<html>
    <head>
        <title>Barcode Generator</title>
		<?php Yii::app()->clientScript->registerPackage('bootstrap'); ?>
		<?php Yii::app()->clientScript->registerCssFile('/web/css/core.css'); ?>
		<?php Yii::app()->clientScript->registerScriptFile('/web/js/html2canvas.js', CClientScript::POS_END); ?>
		<?php Yii::app()->clientScript->registerScriptFile('/web/js/canvas.js', CClientScript::POS_END); ?>
    </head>
    <body>
        <div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="text-center">Barcode Generator</h1>
				</div>
			</div>
			<hr />
			<?= $content; ?>
        </div>
    </body>
</html>
