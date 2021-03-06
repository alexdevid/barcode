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
		<ul class="nav nav-tabs" role="tablist">
			<?php $images = $model->getImages(); ?>
			<?php for ($i = 0; $i < count($images); $i++): ?>
				<li class="<?= $i == 0 ? 'active' : ''; ?>">
					<a href="#page_<?= $i; ?>" role="tab" data-toggle="tab" data-id="<?= $i; ?>"><?= $i+1; ?></a>
				</li>
			<?php endfor; ?>
		</ul>
		<div class="tab-content">
			<?php for ($a = 0; $a < count($images); $a++): ?>
				<div class="text-center tab-pane <?= ($a == 0) ? 'active' : ''; ?>" id="page_<?= $a; ?>">
					<i class="glyphicon glyphicon-refresh rotate preloader"
					   style="top: <?= (($model->getDocumentHeight() / $model->getResizeRatio()) / 2) - 10; ?>; left: <?= (($model->getDocumentWidth() / $model->getResizeRatio()) / 2) - 10; ?>"></i>
					<canvas id="canvas_<?= $a; ?>"
							width='<?= $model->getDocumentWidth() / $model->getResizeRatio(); ?>'
							height='<?= $model->getDocumentHeight() / $model->getResizeRatio(); ?>'
							>Установите нормальный браузер</canvas>
				</div>
			<?php endfor; ?>
		</div>
	</div>
	<div class="col-md-3">
		<div class="">
			<div class="btn-group-vertical">
				<button class="btn btn-info" id="rotate" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Повернуть штрих-код">
					<i class="glyphicon glyphicon-repeat"></i>
				</button>
				<a href="#" class="btn btn-info" id="save" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Скачать страницу" download="<?= $model->generateCode(); ?>">
					<i class="glyphicon glyphicon-save"></i>
				</a>
				<a href="#" class="btn btn-info" id="print" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Печатать страницу">
					<i class="glyphicon glyphicon-print"></i>
				</a>

				<a href="#" class="btn btn-info" id="saveBulk" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Скачать все архивом" download="<?= $model->generateCode(); ?>">
					<i class="glyphicon glyphicon-compressed"></i>
				</a>

				<a href="<?= Yii::app()->createUrl('system/index'); ?>" class="btn btn-success" id="print" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Сделать еще">
					<i class="glyphicon glyphicon-plus"></i>
				</a>
				<iframe id="downloadArchive" style="display:none"></iframe>
			</div>
		</div>
	</div>
</div>
<script>
	var Images = [
<?php foreach ($model->getImages() as $image): ?>
			"<?= $image; ?>",
<?php endforeach; ?>
	];
	var resizeRatio = <?= $model->getResizeRatio(); ?>;
	var uid = <?= $model->id; ?>;
	var runCanvas = true;
</script>