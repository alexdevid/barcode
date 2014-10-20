<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SystemController
 *
 * @author dev
 */
class SystemController extends BaseController
{

	public function actionIndex()
	{
		$model = new Document;

		if (isset($_POST['Document'])) {

			$model->attributes = $_POST['Document'];

			$model->document = CUploadedFile::getInstance($model, 'document');

			if ($model->save()) {
				$path = Yii::getPathOfAlias('webroot') . Document::FILE_DIR . $model->id;
				mkdir($path);
				$model->document->saveAs($path . DIRECTORY_SEPARATOR . $model->document);

				if ($model->isPdf()) {
					$model->document = $model->generateFromPDF();
				}
				$model->generateBarcode();
			}
		}

		$this->render('form', ['model' => $model]);
	}

	public function actionTest()
	{
		$barcode = new Barcode('M0GL900412AA1', 150, Yii::getPathOfAlias('webroot.web.fonts') . '/OpenSans-Regular.ttf', 18);
		$barcode->saveBarcode(Yii::getPathOfAlias('webroot.userfiles') . '/1.png');
		$this->render('index');
	}

	/**
	 * Default errors handler
	 */
	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			$this->render('error', $error);
		}
	}

}
