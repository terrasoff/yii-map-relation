<?php
/**
 * Workout with MANY-MANY relations
 * Author: terrasoff
 * Email: terrasoff@terrasoff.ru
 * Skype: tarasov.konstantin
 */

class MapRelationBehavior extends CActiveRecordBehavior
{
    public function getMapRelationNameByClass($class)
    {
        $relations = $this->getOwner()->relations();
        foreach ($relations as $i=>$c) {
            if ($c[1] === $class)
                return $i;
        }
        return null;
    }

    public function getMapRelationClass($class)
    {
        $relation = null;
        $relations = $this->getOwner()->relations();

        foreach ($relations as $c) {
            if ($c[1] === $class)
                $relation = $c;
        }

        if (!isset($relation[2]))
            return '';

        $class = explode('(', $relation[2]);
        return isset($class[0])
            ? $class[0]
            : '';
    }

    /**
     * Gets avaliable relations for specified model
     * @param string $class relation name
     * @param CActiveRecord $model if relation is unique around model
     * @return CComponent
     */
    public function availableRelations($class, $model = null)
    {
        $obj = $this->getOwner();
        $ownerKey = $obj->getTableSchema()->primaryKey;

        // search available relations for specified model
        if ($model) {
            $criteria = new CDbCriteria();
            $criteria->addCondition("{$model->getTableSchema()->primaryKey} = {$model->primaryKey}");
            $activeDataProvider= new CActiveDataProvider($class, array('criteria'=>$criteria));
        }
        // search available relations for all models
        else
            $activeDataProvider= new CActiveDataProvider($class);

        $criteria = new CDbCriteria();
        $iterator = new CDataProviderIterator($activeDataProvider, 100);
        $list = array();
        foreach ($iterator as $model)
            $list[] = $model->primaryKey[$ownerKey];

        $criteria->addNotInCondition($obj->getTableSchema()->primaryKey, $list);
        $obj->getDbCriteria()->mergeWith($criteria);

        return $obj;
    }
}