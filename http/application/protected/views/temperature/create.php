<?php
/* @var $this TemperatureController */
/* @var $model Temperature */

$this->menu=array(
//	array('label'=>'List Temperature', 'url'=>array('index')),
	array('label'=>'Manage Temperature', 'url'=>array('admin')),
);
?>

<h1>Create Temperature</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
