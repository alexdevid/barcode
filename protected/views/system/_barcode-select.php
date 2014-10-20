<div class="row">
	<div class="col-md-3">
		<div class="alert alert-info">
			Перетащите штрих-код на документе в нужное место
		</div>
		<div class="well well-sm">
			<dl>
				<dt>Номер кредитного договора</dt>
				<dd><?= $model->doc_id; ?></dd>
				<dt>Код организации</dt>
				<dd><?= $model->org_id; ?></dd>
			</dl>
		</div>
		<div class="thumbnail">
			<img src="<?= $model->getBarcodeImage(); ?>" alt="" id="barcode"/>
		</div>
	</div>
	<div class="col-md-6 text-center">
		<img src="<?= $model->getDocumentImage(); ?>"
			 width='<?= $model->getDocumentWidth(); ?>'
			 height='<?= $model->getDocumentHeight(); ?>'
			 id="document" class="hidden">
		<canvas id="hidden" class="hidden" width="<?= $model->getDocumentWidth(); ?>" height="<?= $model->getDocumentHeight(); ?>"></canvas>
		<canvas id="canvas"
				width='<?= $model->getDocumentWidth() / $model->getResizeRatio(); ?>'
				height='<?= $model->getDocumentHeight() / $model->getResizeRatio(); ?>'
				>Установите нормальный браузер</canvas>
	</div>
	<div class="col-md-3">
		<div class="">
			<a href="#" class="btn btn-success" id="save" download>Скачать <i class="glyphicon glyphicon-download-alt"></i></a>
			<br><br>
			<a href="#" class="btn btn-info" id="print">Печатать <i class="glyphicon glyphicon-print"></i></a>
			<br><br>
			<a href="<?= Yii::app()->createUrl('system/index'); ?>" class="btn btn-primary" id="print">Сделать еще <i class="glyphicon glyphicon-repeat"></i></a>
		</div>
	</div>
</div>
<script>
	var documentSrc = "<?= $model->getDocumentImage(); ?>";
	var barcodeSrc = "<?= $model->getBarcodeImage(); ?>";

	var documentWidth = <?= $model->getDocumentWidth(); ?>;
	var documentHeight = <?= $model->getDocumentHeight(); ?>;

	var resizeRatio = <?= $model->getResizeRatio(); ?>
</script>