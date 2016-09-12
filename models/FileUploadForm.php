<?php

namespace mranger\ckeditor\models;

use mranger\ckeditor\helpers\CKEditorHelper;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @author MrAnger
 */
class FileUploadForm extends Model {
	public $upload;

	protected $allowedExtensions = 'png, jpg, jpeg, bmp, gif, ico, swf';

	public function rules() {
		$customAllowedExtensions = CKEditorHelper::getParam(CKEditorHelper::KEY_FILE_UPLOAD_ALLOWED_EXTENSIONS);

		return [
			[['upload'], 'required'],
			[['upload'], 'file', 'skipOnEmpty' => false, 'extensions' => (($customAllowedExtensions !== null) ? $customAllowedExtensions : $this->allowedExtensions)],
		];
	}

	public function attributeLabels() {
		return [
			'upload' => 'File',
		];
	}

	public function formName() {
		return '';
	}
}