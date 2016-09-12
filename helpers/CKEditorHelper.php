<?php

namespace mranger\ckeditor\helpers;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * @author MrAnger
 */
class CKEditorHelper {
	const KEY_FILE_UPLOAD_ALLOWED_EXTENSIONS = 'CKEditorFileUploadAllowedExtensions';
	const KEY_FILE_UPLOAD_PATH = 'CKEditorFileUploadPath';
	const KEY_FILE_UPLOADED_URL = 'CKEditorFileUploadedUrl';

	/**
	 * @param string $key
	 * @param mixed $defaultValue
	 *
	 * @return mixed
	 */
	public static function getParam($key, $defaultValue = null) {
		return ArrayHelper::getValue(Yii::$app->params, $key, $defaultValue);
	}
}