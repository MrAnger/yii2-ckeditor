<?php

namespace mranger\ckeditor;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class CKEditor extends InputWidget {
	use CKEditorTrait;

	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init();
		$this->initOptions();
	}

	/**
	 * @inheritdoc
	 */
	public function run() {
		if ($this->hasModel()) {
			echo Html::activeTextarea($this->model, $this->attribute, $this->options);
		} else {
			echo Html::textarea($this->name, $this->value, $this->options);
		}
		$this->registerPlugin();
	}

	/**
	 * Registers CKEditor plugin
	 *
	 * @codeCoverageIgnore
	 */
	protected function registerPlugin() {
		$js = [];

		$view = $this->getView();

		CKEditorWidgetAsset::register($view);

		$id = $this->options['id'];

		$options = $this->clientOptions !== false && !empty($this->clientOptions)
			? Json::encode($this->clientOptions)
			: '{}';

		$js[] = "CKEDITOR.replace('$id', $options);";
		$js[] = "mranger.ckeditorWidget.registerOnChangeHandler('$id');";

		if (isset($this->clientOptions['filebrowserUploadUrl'])) {
			$js[] = "mranger.ckeditorWidget.registerCsrfImageUploadHandler();";
		}

		if (!empty($this->externalPlugins)) {
			$baseUrl = Yii::$app->urlManager->baseUrl;

			foreach ($this->externalPlugins as $item) {
				$pluginName = $item['name'];
				$pluginUrl = $item['url'];
				$pluginFileName = $item['fileName'];

				$js[] = "CKEDITOR.plugins.addExternal('$pluginName', '$baseUrl$pluginUrl', '$pluginFileName');";
			}
		}

		$view->registerJs(implode("\n", $js));
	}
}