<?php
/* @var $this TemperatureController */
/* @var $model Temperature */

$this->menu=array(
//	array('label'=>'List Temperature', 'url'=>array('index')),
//	array('label'=>'Create Temperature', 'url'=>array('create')),
//	array('label'=>'View Temperature', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Temperature', 'url'=>array('admin')),
);
?>

<h1>Update Temperature <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
