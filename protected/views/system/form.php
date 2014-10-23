<?php if ($model->isNewRecord): ?>
	<?php $this->renderPartial('_upload-form', ['model' => $model]); ?>
<?php else: ?>
	<?php $this->renderPartial('_barcode-select', ['model' => $model]); ?>
<?php endif; ?>