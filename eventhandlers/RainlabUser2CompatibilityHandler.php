<?php

declare(strict_types=1);

namespace Initbiz\InitDry\EventHandlers;

use RainLab\User\Models\User;

class RainlabUser2CompatibilityHandler
{
    public function subscribe($event)
    {
        if (\Schema::hasColumn('users', 'first_name')) {
            $this->addNameAndSurnameAccessor($event);
        } else {
            $this->addFirstNameAndLastNameAccessor($event);
            $this->addActivatedAtAccessor($event);
        }
    }

    // RainLab.User v3 compatibility
    public function addNameAndSurnameAccessor($event)
    {
        User::extend(function ($model) {

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
