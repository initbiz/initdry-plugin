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

            $isFirstNameAttribute = \Schema::hasColumn($model->getTable(), 'first_name');

            $model->addDynamicMethod('getNameAttribute', function () use ($isFirstNameAttribute, $model) {
                return $isFirstNameAttribute ? $model->first_name : $model->name;
            });

            $model->addDynamicMethod('getSurnameAttribute', function () use ($isFirstNameAttribute, $model) {
                return $isFirstNameAttribute ? $model->last_name : $model->surname;
            });

            $model->addDynamicMethod('setNameAttribute', function ($value) use ($isFirstNameAttribute, $model) {
                if ($isFirstNameAttribute) {
                    $model->first_name = $value;
                } else {
                    $model->name = $value;
                }
            });

            $model->addDynamicMethod('setSurnameAttribute', function ($value) use ($isFirstNameAttribute, $model) {
                if ($isFirstNameAttribute) {
                    $model->last_name = $value;
                } else {
                    $model->surname = $value;
                }
            });
        });
    }
}
