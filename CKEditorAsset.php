<?php

namespace mranger\ckeditor;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author MrAnger
 */
class CKEditorAsset extends AssetBundle {
	public $sourcePath = "@bower/ckeditor#full";

	public $js = [
		'ckeditor.js',
		'adapters/jquery.js',
	];

	public $depends = [
		'\yii\web\JqueryAsset',
	];
}
