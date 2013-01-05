<?php
/* @var $this ParameterController */
/* @var $model Parameter */

$this->breadcrumbs=array(
	'Parameters'=>array('admin'),
	'Manage',
);

//$this->menu=array(
//	array('label'=>'List Parameter', 'url'=>array('index')),
//	array('label'=>'Create Parameter', 'url'=>array('create')),
//);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#parameter-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1>Manage Parameters</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'parameter-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'id',
		'name',
		'value',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
