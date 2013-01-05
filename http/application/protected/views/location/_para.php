<?php
/* @var $this ParameterController */
/* @var $model Parameter */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'parameter-form',
	'enableAjaxValidation'=>false,
        // Check that the action method below is correct
        'action' => array('/parameter/update', 'id' => $model->id), 
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
                <?php //echo $form->textField($model,'value'); ?>
<?php echo $form->dropDownList($model,'value', CHtml::listData(Location::model()->findAll(), 'id', 'location')); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
