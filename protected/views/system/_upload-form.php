<div class="col-sm-6 col-sm-offset-3">
	<?php
	$form = $this->beginWidget('CActiveForm', [
		'id' => 'upload-form',
		'enableAjaxValidation' => false,
		'htmlOptions' => ['enctype' => 'multipart/form-data'],
	]);
	?>

	<div class="form-group">
		<?php echo $form->label($model, 'doc_id'); ?>
		<?php echo $form->textField($model, 'doc_id', ['class' => 'form-control']) ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model, 'org_id'); ?>
		<?php echo $form->textField($model, 'org_id', ['class' => 'form-control']) ?>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="form-group">
				<?php echo $form->label($model, 'document'); ?>
				<?php echo $form->fileField($model, 'document', ['class' => 'form-control']) ?>
			</div>
		</div>
		<div class="col-md-4 text-right">
			<?php echo CHtml::submitButton('Отправить', ['class' => 'btn btn-primary form-submit', 'id' => 'uploadBtn']); ?>
		</div>
	</div>
	<?php $this->endWidget();
	?>
</div>
<div class="col-sm-3">
	<?php if ($model->hasErrors()): ?>
		<?php echo $form->errorSummary($model, '', '', array('class' => 'alert alert-danger')); ?>
	<?php endif; ?>
</div>