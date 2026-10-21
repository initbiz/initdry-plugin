<?php

declare(strict_types=1);

namespace Initbiz\InitDry\Traits;

/**
 * October's SoftDelete, but the record goes to the trash before its dependents, and restoring it brings back
 * only the dependents trashed together with it, the ones trashed before stay in the trash
 */
trait SoftDelete
{
    use \October\Rain\Database\Traits\SoftDelete {
        performDeleteOnModel as octoberPerformDeleteOnModel;
    }

    protected function performDeleteOnModel()
    {
        // Deleting for good keeps October's order, the dependents first
        if ($this->forceDeleting || !$this->isSoftDeleteEnabled()) {
            $this->octoberPerformDeleteOnModel();

            return;
        }

        // The dependents are trashed after the record, so never before it, however long it takes
        $this->getConnection()->transaction(function () {
            $this->runSoftDelete();
            $this->performSoftDeleteOnRelations();
        });
    }

    protected function performRestoreOnRelations()
    {
        $deletedAt = $this->getRawOriginal($this->getDeletedAtColumn());

        foreach ($this->getRelationDefinitions() as $relations) {
            foreach ($relations as $relationName => $options) {
                if (empty($options['softDelete'])) {
                    continue;
                }

                $relation = $this->{$relationName}();
                $related = $relation->onlyTrashed()
                    ->where($relation->getRelated()->getQualifiedDeletedAtColumn(), '>=', $deletedAt)
                    ->get();

                foreach ($related as $record) {
                    // Restored already with its parent in a tree
                    if (!$record::onlyTrashed()->whereKey($record->getKey())->exists()) {
                        continue;
                    }

                    $record->restore();
                }
            }
        }
    }
}
