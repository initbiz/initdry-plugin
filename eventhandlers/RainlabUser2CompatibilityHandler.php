<?php

declare(strict_types=1);

namespace Initbiz\InitDry\EventHandlers;

use RainLab\User\Models\User;
use System\Classes\PluginManager;
use System\Classes\VersionManager;

/**
 * RainLab.User v3 is the version that renamed the
 * name/surname columns to first_name/last_name (see migrate_v3_0_0.php).
 */
class RainlabUser2CompatibilityHandler
{
    public function subscribe($event)
    {
        if (!PluginManager::instance()->hasPlugin('RainLab.User')) {
            return;
        }

        $version = VersionManager::instance()->getLatestVersion('RainLab.User');

        if ($version && version_compare($version, '3.0.0', '>=')) {
            $this->addNameAndSurnameAccessor($event);
        } else {
            $this->addFirstNameAndLastNameAccessor($event);
            $this->addActivatedAtAccessor($event);
        }
    }

    public function addNameAndSurnameAccessor($event)
    {
        User::extend(function ($model) {
            $model->append(['name', 'surname']);

            $model->addDynamicMethod('getNameAttribute', function () use ($model) {
                return $model->first_name;
            });

            $model->addDynamicMethod('getSurnameAttribute', function () use ($model) {
                return $model->last_name;
            });

            $model->addDynamicMethod('setNameAttribute', function ($value) use ($model) {
                $model->first_name = $value;
            });

            $model->addDynamicMethod('setSurnameAttribute', function ($value) use ($model) {
                $model->last_name = $value;
            });
        });
    }

    // RainLab.User v2 compatibility
    public function addFirstNameAndLastNameAccessor($event)
    {
        User::extend(function ($model) {
            $model->append(['first_name', 'last_name']);

            $model->addDynamicMethod('getFirstNameAttribute', function () use ($model) {
                return $model->name;
            });

            $model->addDynamicMethod('getLastNameAttribute', function () use ($model) {
                return $model->surname;
            });

            $model->addDynamicMethod('setFirstNameAttribute', function ($value) use ($model) {
                $model->name = $value;
            });

            $model->addDynamicMethod('setLastNameAttribute', function ($value) use ($model) {
                $model->surname = $value;
            });
        });
    }

    public function addActivatedAtAccessor($event)
    {
        User::extend(function ($model) {
            $model->addDynamicMethod('setActivatedAtAttribute', function ($value) use ($model) {
                if (!is_null($value)) {
                    $model->activated_at = $value;
                    $model->is_activated = true;
                }
            });
        });
    }
}
