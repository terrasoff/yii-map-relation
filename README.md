# Description
MANY-MANY relation management for Yii framework

#How to use this behavior

Firstly suppose you have classes Book, Author and BookAuthor.
BookAuthor is map-table (many-many) for relation Book <-> Author.

## Add alias "terrasoff-map-relation"

	Yii::setPathOfAlias('terrasoff-map-relation', Yii::getPathOfAlias('vendor').'/terrasoff/yii/map-relations');

For example, u could add it to your config file.

## Add interface and behaviors to your model

	class Book extends CActiveRecord implements MapRelatedInterface
	{
		...
		public function behaviors() {
			return array(
				...
				'RelationBehavior' => array(
					'class' => 'terrasoff-map-relation.MapRelationBehavior',
				),
				'activerecord-relation-behavior' => array(
					'class' => 'vendor.yiiext.activerecord-relation-behavior.EActiveRecordRelationBehavior'
				),
			);
		}
	}

## Create controller

	Yii::import('terrasoff-map-relation.controllers.MapRelatedController');

	class MyController extends MapRelatedController
	{

		public $ownerClass = 'Book';
		public $relatedClass = 'Author';

	}

## View related models

To view existed relations we could simply use "list" view.
Also you could delete relation using this view.
For example in CDetailView:

	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model, // Book
		'attributes'=>array(
			'name',
			'created',
			array(
				'label' => 'authors',
				'type'=>'raw',
				'value'=>function($model) {
					return $this->renderPartial('terrasoff-map-relation.views.list', array(
						'owner'=>$model,
						'relation'=>'Author',
					),true);
				}
			),
		),
	)); ?>

## Add new relation

To add new relation we simply navigate to MyController/add:

	<a href="<?= Yii::app()->createUrl('MyController/add', array('id'=>$model->primaryKey)) ?>">Add</a>