<?php
/* @var $this ParameterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Parameters',
);

$this->menu=array(
	array('label'=>'Create Parameter', 'url'=>array('create')),
	array('label'=>'Manage Parameter', 'url'=>array('admin')),
);
?>

<h1>Parameters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
