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
				$model->saveDocument();
				$model->generateBarcode();
			}
		}

		$this->render('form', ['model' => $model]);
	}

	public function actionSave()
	{
		$data = $_POST;
		$images = $data['images'];
		$webDir = Document::FILE_DIR . $data['id'] . DIRECTORY_SEPARATOR;
		$dir = Yii::getPathOfAlias('webroot') . Document::FILE_DIR . $data['id'] . DIRECTORY_SEPARATOR;


		$zip = new ZipArchive();
		$filename = $dir . "archive.zip";

		if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
			throw new CHttpException('500', 'Can not open ZIP Archive');
		}

		for ($i = 0; $i < count($images); $i++) {
			$images[$i] = str_replace('data:image/jpeg;base64,', '', $images[$i]);
			$images[$i] = str_replace(' ', '+', $images[$i]);
			$data = base64_decode($images[$i]);

			$zip->addFromString('b' . $i . '.jpg', $data);
		}

		$zip->close();

		echo $webDir . "archive.zip";
		Yii::app()->end();
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
