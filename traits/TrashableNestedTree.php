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

    /**
     * Trashing the children doesn't shift the tree; force deleting removes them one by one,
     * also the ones in the trash, with their own events and relations
     */
    public function deleteDescendants()
    {
        if ($this->getRight() === null || $this->getLeft() === null) {
            return;
        }

        if ($this->isSoftDelete()) {
            foreach ($this->children()->get() as $child) {
                $child->delete();
            }

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

    public function shiftSiblingsForRestore()
    {
        // The trashed node kept its place in the tree
    }

    protected function newNestedTreeQuery()
    {
        return $this->newQuery()->withTrashed();
    }
}
