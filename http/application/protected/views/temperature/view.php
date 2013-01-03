<?php
/* @var $this TemperatureController */
/* @var $model Temperature */

$this->breadcrumbs=array(
	'Temperatures'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Temperature', 'url'=>array('index')),
	array('label'=>'Create Temperature', 'url'=>array('create')),
	array('label'=>'Update Temperature', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Temperature', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Temperature', 'url'=>array('admin')),
);
?>

<h1>View Temperature #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'locationId',
		'value',
		'createDate',
	),
)); ?>
