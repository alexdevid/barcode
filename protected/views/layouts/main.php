<html>
    <head>
        <title>Barcode Generator</title>
		<?php Yii::app()->clientScript->registerPackage('bootstrap'); ?>
		<?php Yii::app()->clientScript->registerCssFile('/web/css/core.css'); ?>

		<?php Yii::app()->clientScript->registerScriptFile('/web/js/fabric.min.js', CClientScript::POS_END); ?>
		<?php Yii::app()->clientScript->registerScriptFile('/web/js/canvas.js', CClientScript::POS_END); ?>
    </head>
    <body>
        <div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<img src="/web/images/logo.jpg" alt="" />
					<div class="text-muted title">Barcode Generator</div>
				</div>
			</div>
			<hr />
			<?= $content; ?>
			<hr />
			<footer class="text-center text-muted">
				<small>&copy; <?= date('Y', time()); ?> <a href="http://finservice.pro" target="_blank">finservice.pro</a></small>
			</footer>
        </div>
    </body>
</html>
