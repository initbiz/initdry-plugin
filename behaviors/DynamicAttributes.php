<?php namespace Initbiz\InitDry\Behaviors;

use System\Classes\ModelBehavior;

/**
 * Behavior that adds dynamic accessors and mutators to model 
 * and stores the values in one jsonable column
 */

class DynamicAttributes extends ModelBehavior
{
    protected $requiredProperties = ['dynamicAttributes'];

    protected $model;

    protected $dynamicAttributesColumn = 'additional_data';

    public function __construct($model)
    {
        $this->model = $model;

        if (isset($model->dynamicAttibutesColumn)) {
            $this->dynamicAttributesColumn = $model->dynamicAttibutesColumn;
        }

        $this->makeDynamicAttributes();
    }

    public function makeDynamicAttributes()
    {
        foreach ($this->model->dynamicAttributes as $name) {
            $this->makeMutator($name);
            $this->makeAccessor($name);
        }

        // After mutators and accessors are created we have to unset moneyFields so that Laravel will not try to save it to DB
        unset($this->model->dynamicAttributes);
    }

    public function makeMutator($name)
    {
        $methodName = 'set'.studly_case($name).'Attribute';
        
        $model = $this->model;
        $dynamicAttributesColumn = $this->dynamicAttributesColumn;

        $model->addDynamicMethod($methodName, function ($value) use ($model, $name, $dynamicAttributesColumn) {
            $additionalData = $model->$dynamicAttributesColumn;

            $additionalData[$name] = $value;

            $model->$dynamicAttributesColumn = $additionalData;
        });
    }

    public function makeAccessor($name)
    {
        $methodName = 'get'.studly_case($name).'Attribute';
        
        $model = $this->model;
        $dynamicAttributesColumn = $this->dynamicAttributesColumn;

        $model->addDynamicMethod($methodName, function () use ($model, $name, $dynamicAttributesColumn) {
            if (!isset($model->$dynamicAttributesColumn[$name])) {
                return null;
            }

            return $model->$dynamicAttributesColumn[$name];
        });
    }
}
