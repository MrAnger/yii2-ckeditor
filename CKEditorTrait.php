<?php

namespace mranger\ckeditor;

use Yii;
use yii\helpers\ArrayHelper;

trait CKEditorTrait {
	public $preset;

	public $presetDirPath = '@app/ckeditor-presets';

	public $clientOptions = [];

	public $externalPlugins = [];

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

		$this->externalPlugins = ArrayHelper::getValue($options, 'externalPlugins', []);

		unset($options['externalPlugins']);

		$this->clientOptions = ArrayHelper::merge($options, $this->clientOptions);
	}
}