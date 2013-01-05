<?php
/* @var $this TemperatureController */
/* @var $model Temperature */

$this->breadcrumbs=array(
	'Temperatures'=>array('admin'),
	'Manage',
);

//$this->menu=array(
//	array('label'=>'List Temperature', 'url'=>array('index')),
//	array('label'=>'Create Temperature', 'url'=>array('create')),
//);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#temperature-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2>Manage Temperatures</h2>

<?php //echo Yii::app()->AppParams->CURRENT_LOCATION; ?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'temperature-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'id',
		'tempLocation',
		'value',
		'createDate',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
<p>
You may also use comparison operators (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
 57 or <b>=</b>) at the beginning of each value to filter results.
</p>

