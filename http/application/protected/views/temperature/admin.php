<?php
/* @var $this TemperatureController */
/* @var $model Temperature */

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
or <b>=</b>) at the beginning of each value to filter results.
</p>

<h2>Chart test</h2>
<?php 
$this->Widget('ext.ActiveHighcharts.HighchartsWidget', array(
        'dataProvider'=>$dataProvider,
        'template'=>'{items}',
        'options'=> array(
            'title'=>array(
                'text'=>'Temperatures'
            ),
		'exporting' => array('enabled' => false),
            'xAxis'=>array(
                // It cant be 1.a self-defined xAxis array as you want; 
                // 2.a series from datebase such as time series
                "categories"=>'createDate'            
            ),
            'series'=>array(
                array(
//                    'type'=>'areaspline',
                    'name'=>'Values',             //title of data
                    'dataResource'=>'value',     //data resource according to datebase column
                )
            )
        )
    ));
?>

