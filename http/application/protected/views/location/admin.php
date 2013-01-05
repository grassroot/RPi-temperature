<?php
/* @var $this LocationController */
/* @var $model Location */

$this->breadcrumbs=array(
	'Locations'=>array('admin'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Location', 'url'=>array('index')),
	array('label'=>'Create Location', 'url'=>array('create')),
);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#location-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h2>Change current location</h2>
<?php //echo $this->renderPartial('_change', array(getParameter('CURRENT_LOCATION'))); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'location-grid',
	'dataProvider'=>$model->search(),
//	'filter'=>$model,
	'columns'=>array(
//		'id',
		'location',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
?>
