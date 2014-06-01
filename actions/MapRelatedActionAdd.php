<?php
/**
 *
 * Action for adding MANY-MANY relations
 * Author: terrasoff
 * Email: terrasoff@terrasoff.ru
 * Skype: tarasov.konstantin
 */

Yii::import('terrasoff-map-relation.actions.MapRelatedAction');

class MapRelatedActionAdd extends MapRelatedAction
{
    /**
     * Path to view related records
     * @var string
     */
    public $view = 'terrasoff-map-relation.views.add';

    public function run($id)
    {
        $class = $this->ownerClass;
        $relatedClass = $this->relatedClass;

        /** @var CActiveRecord $model */
        $model = $class::model()->findByPk($id);

        if ($model)
        {
            $relationName = $model->getMapRelationNameByClass($relatedClass);
            $relationClass = $model->getMapRelationClass($relatedClass);

            $list = Yii::app()->request->getPost('related');

            if ($list !== null && count($list))
            {
                /**
                 * save relation (activerecord-relation-behavior is using)
                 * @link https://github.com/yiiext/activerecord-relation-behavior.git
                 */
                $model->{$relationName} = array_merge($model->{$relationName}, $list);
                if ($model->save())
                    Yii::app()->user->setFlash('success', $this->messages['add:success']);

                $this->controller->redirect(Yii::app()->createUrl($this->modelViewUrl, array('id'=>$id)));
            }

            $this->controller->render($this->view, array(
                'relations' => $this->controller->mode === MapRelatedController::MODE_UNIQUE_ABSOLUTE
                    ? $relatedClass::model()->availableRelations($relationClass)->findAll()
                    : $relatedClass::model()->availableRelations($relationClass, $model)->findAll(),
                'owner'=>$model,
                'modelViewUrl'=>$this->modelViewUrl,
            ));
        }
        // model not found
        else
            $this->controller->redirect($this->returnUrl);
    }

}