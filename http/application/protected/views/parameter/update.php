<?php
/* @var $this ParameterController */
/* @var $model Parameter */

$this->breadcrumbs=array(
	'Parameters'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Parameter', 'url'=>array('index')),
	array('label'=>'Create Parameter', 'url'=>array('create')),
	array('label'=>'View Parameter', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Parameter', 'url'=>array('admin')),
);
?>

<h1>Update Parameter <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>