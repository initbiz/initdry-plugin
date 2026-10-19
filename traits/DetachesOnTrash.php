<?php

declare(strict_types=1);

namespace Initbiz\InitDry\Traits;

/**
 * Moving a record to the trash detaches its many-to-many relations, as deleting it for good does,
 * so that no links point to records in the trash; use it with SoftDelete
 */
trait DetachesOnTrash
{
    public function initializeDetachesOnTrash(): void
    {
        $this->bindEvent('model.afterTrash', function () {
            foreach ($this->getRelationDefinitions() as $type => $relations) {
                if (!in_array($type, ['belongsToMany', 'morphToMany', 'morphedByMany'], true)) {
                    continue;
                }

                foreach ($relations as $relationName => $options) {
                    // Like October's detaching on delete, unless the relation opts out
                    if (($options['detach'] ?? true) === false) {
                        continue;
                    }

                    $this->{$relationName}()->detach();
                }
            }
        });
    }
}
