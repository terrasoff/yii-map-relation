<?php
/**
 *
 * Action for add relations
 * Author: terrasoff
 * Email: terrasoff@terrasoff.ru
 * Skype: tarasov.konstantin
 */

Yii::import('terrasoff-map-relation.actions.MapRelatedAction');

class MapRelatedActionDelete extends MapRelatedAction
{
    public function run()
    {
        $ownerClass = $this->ownerClass;
        $relatedClass = $this->relatedClass;

        $idOwner = Yii::app()->request->getPost('idOwner');
        $idRelated = Yii::app()->request->getPost('idRelated');

        $owner = $ownerClass::model()->findByPk($idOwner);
        $related = $relatedClass::model()->findByPk($idRelated);

        if ($owner)
        {
            // add relations (if they are)
            if ($related)
            {
                $keyOwner = $owner->getTableSchema()->primaryKey;
                $keyRelated = $related->getTableSchema()->primaryKey;
                $key = array_combine(array($keyOwner, $keyRelated), array($owner->primaryKey, $related->primaryKey));

                $mapClass = $owner->getMapRelationClass($relatedClass);
                $model = $mapClass::model()->findByPk($key);

                if ($model && !$model->delete())
                    Yii::app()->user->setFlash('errors', $model->getErrors());
                else
                    Yii::app()->user->setFlash('success', "\"{$related->getLabel()}\"".' '.$this->messages['delete:success']);

                $this->controller->redirect(Yii::app()->createUrl($this->modelViewUrl, array('id'=>$idOwner)));
            }
            // relation not found
            $this->controller->redirect(Yii::app()->createUrl($this->modelViewUrl, array('id'=>$idOwner)));
        }
        // model not found
        else
            $this->controller->redirect(Yii::app()->createUrl($this->returnUrl));
    }

}