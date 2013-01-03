<?php
/* @var $this ParameterController */
/* @var $model Parameter */

$this->breadcrumbs=array(
	'Parameters'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Parameter', 'url'=>array('index')),
	array('label'=>'Create Parameter', 'url'=>array('create')),
	array('label'=>'Update Parameter', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Parameter', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Parameter', 'url'=>array('admin')),
);
?>

<h1>View Parameter #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'value',
	),
)); ?>
