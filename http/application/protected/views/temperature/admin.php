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
/*
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
$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=>array(
      'title' => array('text' => 'Fruit Consumption'),
      'xAxis' => array(
         'categories' => array('Apples', 'Bananas', 'Oranges')
      ),
      'yAxis' => array(
         'title' => array('text' => 'Fruit eaten')
      ),
      'series' => array(
         array('name' => 'Jane', 'data' => array(1, 0, 4)),
         array('name' => 'John', 'data' => array(5, 7, 3))
      )
   )
));
$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=>'{
      "title": { "text": "Fruit Consumption" },
"theme" => "gray",
      "xAxis": {
         "categories": ["Apples", "Bananas", "Oranges"]
      },
      "yAxis": {
         "title": { "text": "Fruit eaten" }
      },
      "series": [
         { "name": "Jane", "color": "black", "data": [1, 0, 4] },
         { "name": "John", "color": "red", "data": [5, 7,3] }
      ]
   }'
));
*/

$arr = Yii::app()->db->createCommand('SELECT id, value FROM temperature where createDate > datetime(\'now\', \'-1 hour\', \'localtime\')')->queryAll(); 
$dataProvider=new CArrayDataProvider($arr, array(
                                'keyField' => 'id'
                ));


//$arr = Yii::app()->db->createCommand('SELECT id, value FROM temperature')->queryAll(); 

//$arr = array();
//foreach($temps as $t)
//{
//    $arr[$t->id] = $t->id;
//    $arr[$t->id] = '1';
//}

//$dP=new CActiveDataProvider('Temperature');

/*
$this->widget('application.extensions.EFlot.EFlotGraphWidget', 
    array(
        'data'=>array(
            array(
                'label'=> 'line', 
               'data'=>array(
                    array(1,1),
                    array(2,7),
                    array(3,12),
                    array(4,32),
                    array(5,62),
                    array(6,9),
                ),
//		'data'=>$arr,
		'data'=>$model->listforgraph(),
                'lines'=>array('show'=>true),
                'points'=>array('show'=>true),
            ),
        ),
        'options'=>array(
                'legend'=>array(
                    'position'=>'nw',
                    'show'=>false,
                    'margin'=>10,
                    'backgroundOpacity'=> 0.5
                    ),
        ),
        'htmlOptions'=>array(
               'style'=>'width:800px;height:400px;'
        )
    )
);
*/
    $this->widget('application.extensions.amcharts.EAmChartWidget', 
                    array(
                        'width' => 700, // width of the Chart
                        'height' => 400, // height of the chart
                        'chart'=>array(// collections of grpah to display into the chart
                                    'dataProvider'=>$dataProvider, // DataProvider
                                    'categoryField' => 'createDate' // Field of the DataProvider to set on the X Axis
                                    ),
                        'graphs'=>array(
                                array(
                                    'valueField' => 'value',
                                    'title'=>'Value',
                                    'type' => 'line',
                                    'fillColors'=>'Transparent',
                                    'fillAlphas'=>'0',
                                    'lineColor'=>'#EE2299',
                                    'bullet'=>'round'
                                )),
                        'categoryAxis'=>array(
                                    'title'=>'Species Name'
                                    ),
                        'valueAxis'=>array(
                                    'title'=>'Identifier')
    )); 

?>


