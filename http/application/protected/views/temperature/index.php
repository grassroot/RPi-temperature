<?php
/* @var $this TemperatureController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'Create Temperature', 'url'=>array('create')),
	array('label'=>'Manage Temperature', 'url'=>array('admin')),
);
?>

<h1>Temperatures</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
