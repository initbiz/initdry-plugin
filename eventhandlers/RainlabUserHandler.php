<?php

declare(strict_types=1);

namespace Initbiz\InitDry\EventHandlers;

use RainLab\User\Models\User;

class RainlabUserHandler
{
    public function subscribe($event)
    {
        $this->addNameAndSurnameAccessor($event);
    }

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
}
