<?php
/* @var $this ParameterController */
/* @var $model Parameter */

$this->breadcrumbs=array(
	'Parameters'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Parameter', 'url'=>array('index')),
	array('label'=>'Manage Parameter', 'url'=>array('admin')),
);
?>

<h1>Create Parameter</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>