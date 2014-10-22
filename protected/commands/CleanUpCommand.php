<?php

class CleanUpCommand extends CConsoleCommand
{

	protected $week;

	public function actionIndex()
	{
		$this->week = 7 * 24 * 60 * 60;

		$it = new DirectoryIterator(__DIR__ . '/../../userfiles/');
		foreach ($it as $fileinfo) {

			if ($fileinfo->isDot()) {
				continue;
			}

			$id = $fileinfo->getFilename();
			$model = Document::model()->findByPk($id);

			if (!$model) {
				continue;
			}

			if ($this->documentIsFresh($model->created_at)) {
				continue;
			}

			echo 'Removing ' . $fileinfo->getFilename() . "\n";
			if ($fileinfo->isDir()) {
				$this->removeDirectory($fileinfo->getPathname());
			} elseif ($fileinfo->isFile() || $fileinfo->isLink()) {
				unlink($fileinfo->getPathname());
			}
		}
	}

	protected function removeDirectory($dirname)
	{
		$it = new DirectoryIterator($dirname);

		foreach ($it as $file) {
			if ($file->isDot()) {
				continue;
			}
			if ($file->isFile() || $file->isLink()) {
				unlink($file->getPathname());
			}
		}

		rmdir($dirname);
	}

	protected function documentIsFresh($created_at)
	{
		return (time() - $created_at) < $this->week;
	}

}
