<?php
/* @var $this LocationController */
/* @var $model Location */

$this->menu=array(
//	array('label'=>'List Location', 'url'=>array('index')),
	array('label'=>'Manage Location', 'url'=>array('admin')),
);
?>

<h1>Create Location</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
