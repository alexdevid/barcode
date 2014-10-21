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
			<div class="btn-group-vertical">
				<button class="btn btn-info" id="rotate" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Повернуть штрих-код">
					<i class="glyphicon glyphicon-repeat"></i>
				</button>
				<a href="#" class="btn btn-info" id="save" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Скачать" download="<?= $model->generateCode(); ?>">
					<i class="glyphicon glyphicon-save"></i>
				</a>
				<a href="#" class="btn btn-info" id="print" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Печатать">
					<i class="glyphicon glyphicon-print"></i>
				</a>
				<a href="<?= Yii::app()->createUrl('system/index'); ?>" class="btn btn-success" id="print" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Сделать еще">
					<i class="glyphicon glyphicon-plus"></i>
				</a>
			</div>
		</div>
	</div>
</div>
<script>
	var backgroundSrc = "<?= $model->getDocumentImage(); ?>";
	var barcodeSrc = "<?= $model->getBarcodeImage(); ?>";

	var documentWidth = <?= $model->getDocumentWidth(); ?>;
	var documentHeight = <?= $model->getDocumentHeight(); ?>;

	var resizeRatio = <?= $model->getResizeRatio(); ?>


</script>