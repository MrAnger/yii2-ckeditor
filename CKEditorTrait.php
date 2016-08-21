<?php

namespace mranger\ckeditor;

use Yii;
use yii\helpers\ArrayHelper;

trait CKEditorTrait {
	public $preset;

	public $presetDirPath = '@app/ckeditor-presets';

	public $clientOptions = [];

	protected function initOptions() {
		$options = [];

		if ($this->preset !== null && $this->presetDirPath !== null) {
			$preset = Yii::getAlias($this->presetDirPath) . "/$this->preset.php";

			if (file_exists($preset)) {
				$options = require($preset);
			} else {
				throw new \Exception("Preset file not found: $preset");
			}
		}

		$this->clientOptions = ArrayHelper::merge($options, $this->clientOptions);
	}
}