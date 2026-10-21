<?php

declare(strict_types=1);

namespace Initbiz\InitDry\Traits;

/**
 * NestedTree for models with SoftDelete: trashed nodes keep their place in the tree,
 * so that the bounds stay right when they're force deleted or restored
 */
trait TrashableNestedTree
{
    use \October\Rain\Database\Traits\NestedTree;

    public function initializeTrashableNestedTree(): void
    {
        // After the node, so that the children are never trashed before it
        $this->bindEvent('model.afterDelete', function () {
            if (!$this->isSoftDelete()) {
                return;
            }

            foreach ($this->children()->get() as $child) {
                $child->delete();
            }
        });
    }

    /**
     * Force deleting removes the children one by one, also the ones in the trash, with their own events
     * and relations; trashing them, after the node, doesn't shift the tree
     */
    public function deleteDescendants()
    {
        if ($this->getRight() === null || $this->getLeft() === null) {
            return;
        }

        if ($this->isSoftDelete()) {
            return;
        }

        foreach ($this->children()->withTrashed()->get() as $child) {
            $child->forceDelete();
        }

        $this->getConnection()->transaction(function () {
            // The removed children shifted the tree
            $node = $this->newNestedTreeQuery()->find($this->getKey());
            if ($node === null) {
                return;
            }

            $leftColumn = $this->getLeftColumnName();
            $rightColumn = $this->getRightColumnName();
            $right = $node->getRight();
            $width = $right - $node->getLeft() + 1;

            $this->newNestedTreeQuery()->where($leftColumn, '>', $right)->decrement($leftColumn, $width);
            $this->newNestedTreeQuery()->where($rightColumn, '>', $right)->decrement($rightColumn, $width);
        });
    }

    /**
     * Only the children trashed together with the node come back, with their own events and relations
     */
    public function restoreDescendants()
    {
        $deletedAt = $this->getPrevious()[$this->getDeletedAtColumn()] ?? null;
        if ($deletedAt === null) {
            return;
        }

        $children = $this->children()->onlyTrashed()
            ->where($this->getQualifiedDeletedAtColumn(), '>=', $deletedAt)
            ->get();

        foreach ($children as $child) {
            $child->restore();
        }
    }

    public function shiftSiblingsForRestore()
    {
        // The trashed node kept its place in the tree
    }

    protected function newNestedTreeQuery()
    {
        return $this->newQuery()->withTrashed();
    }
}
