<?php

namespace mranger\ckeditor;

use yii\web\AssetBundle;

class CKEditorWidgetAsset extends AssetBundle {
	public $sourcePath = __DIR__ . '/assets';

	public $depends = [
		'mranger\ckeditor\CKEditorAsset',
	];

	public $js = [
		'mranger-ckeditor.widget.js',
	];
}
