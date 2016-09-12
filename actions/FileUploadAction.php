<?php

namespace mranger\ckeditor\actions;

use mranger\ckeditor\helpers\CKEditorHelper;
use mranger\ckeditor\models\FileUploadForm;
use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

/**
 * @author MrAnger
 */
class FileUploadAction extends Action {
	protected $uploadPath;
	protected $uploadedUrl;

	/**
	 * @return string
	 *
	 * @throws BadRequestHttpException
	 */
	public function run() {
		$request = Yii::$app->request;
		$this->uploadPath = Yii::getAlias(CKEditorHelper::getParam(CKEditorHelper::KEY_FILE_UPLOAD_PATH, '@webroot/upload'));
		$this->uploadedUrl = CKEditorHelper::getParam(CKEditorHelper::KEY_FILE_UPLOADED_URL, '/upload');

		$CKEditorFuncNum = $request->get('CKEditorFuncNum');

		if ($CKEditorFuncNum === null)
			throw new BadRequestHttpException("Not passed a required parameter 'CKEditorFuncNum'.");

		$uploadForm = new FileUploadForm();

		$uploadForm->load($request->post());

		// Uploaded File
		$uploadForm->upload = UploadedFile::getInstance($uploadForm, 'upload');

		if ($uploadForm->validate()) {
			$fileName = time() . "_" . $uploadForm->upload->name;

			$url = "$this->uploadedUrl/$fileName";
			$uploadPath = "$this->uploadPath/$fileName";

			if (!is_dir($this->uploadPath))
				FileHelper::createDirectory($this->uploadPath);

			$message = '';
			if (!$uploadForm->upload->saveAs($uploadPath)) {
				$message = 'Failed to save the downloaded file. Contact your site administrator.';
				$url = '';
			}

			return $this->out($CKEditorFuncNum, $url, $message);
		} else {
			return $this->out($CKEditorFuncNum, '', implode("\n", $uploadForm->getErrors('upload')));
		}
	}

	protected function out($funcNum, $fileUrl = '', $message = '') {
		return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$fileUrl', '$message');</script>";
	}
}
