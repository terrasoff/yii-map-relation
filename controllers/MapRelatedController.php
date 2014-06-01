<?php

class MapRelatedController extends Controller
{

    // unique relations around specified model
    const MODE_UNIQUE_MODEL = 1;
    // unique relations around all models
    const MODE_UNIQUE_ABSOLUTE = 2;

    public $ownerClass = null;
    public $relatedClass = null;
    public $returnUrl = null;
    public $modelViewUrl = null;
    public $messages = array(
        'add:success'=>'added',
        'delete:success'=>'deleted',
    );

    public $filterModels = null;

    public $mode = self::MODE_UNIQUE_MODEL;

	public function filters()
	{
		return array(
			'accessControl',
			'postOnly + delete',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('add','delete'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

    public function actions()
    {
        $class = strtolower($this->ownerClass);

        if (!$this->returnUrl) {
            if (Yii::app()->user->returnUrl)
                $this->returnUrl = Yii::app()->user->returnUrl;
            else {
                $this->returnUrl = Yii::app()->createUrl("{$class}/admin");
            }
        }

        if (!$this->modelViewUrl)
            $this->modelViewUrl = "{$class}/view";

        return array(
            'add'=>array(
                'class'=>'terrasoff-map-relation.actions.MapRelatedActionAdd',
                'ownerClass' => $this->ownerClass,
                'relatedClass' => $this->relatedClass,
                'returnUrl' => $this->returnUrl,
                'modelViewUrl' => $this->modelViewUrl,
                'messages' => $this->messages,
            ),
            'delete'=>array(
                'class'=>'terrasoff-map-relation.actions.MapRelatedActionDelete',
                'ownerClass' => $this->ownerClass,
                'relatedClass' => $this->relatedClass,
                'returnUrl' => $this->returnUrl,
                'modelViewUrl' => $this->modelViewUrl,
                'messages' => $this->messages,
            ),
        );
    }

}