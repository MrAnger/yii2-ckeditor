yii2-ckeditor widget
===========================

## Установка

```
php composer.phar require --prefer-dist mranger/yii2-ckeditor "*"
```

или

```json
"mranger/yii2-ckeditor": "*"
```

Так как у меня не получилось нормально реализовать зависимость от пакета CKEditor, бог его знает почему. Вам придется самим добавить зависимость от данного пакета в вашем composer.json
 Я обычно прописываю зависимость от полного пакета последней версии.
 
 ```
 "ckeditor/ckeditor": "dev-full/stable"
 ```
 
 Более подробно можно прочитать по ссылке: [http://docs.ckeditor.com/#!/guide/dev_package_managers](http://docs.ckeditor.com/#!/guide/dev_package_managers).

## Использование

```php
use mranger\ckeditor\CKEditor;

echo $form->field($model, 'content')->widget(CKEditor::className());
```

Можно создавать свои пресеты, которые будут хранить настройки вашего редактора, для этого нужно будет сначала определить папку где будут лежать файлы с пресетами (стандартный путь "@app/ckeditor-presets").

Пример кода пресета и вызова виджета:

пресет: default.php
```php
return [
    'height' => '300px',
    'toolbarGroups'        => [
        ['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors', 'cleanup']],
    	['name' => 'styles'],
    	['name' => 'blocks'],
    	['name' => 'colors'],
    	['name' => 'document', 'groups' => ['mode', 'document', 'doctools']],
    	['name' => 'tools'],
        ['name' => 'others'],
    	'/',
    	['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi']],
    	['name' => 'links'],
    	['name' => 'insert'],
    	['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
    	['name' => 'editing', 'groups' => ['find', 'selection', 'spellchecker']],
    ],
    'filebrowserUploadUrl' => Url::to(['wysiwyg/image-upload'], true),
];
```

Вызов виджета:
```php
echo $form->field($model, 'content')->widget(CKEditor::className(), [
    'preset' => 'default',
    'presetDirPath' => '@app/presets', //стандартный путь "@app/ckeditor-presets" можно не указывать
]);
```

Что бы дать возможность загрузки файлов через редактор, необходимо сначала подключить необходимый экшен для загрузки файлов. Контролер может быть абсолютно любой.
```php
public function actions() {
		return [
			'ckeditor-file-upload' => [
				'class' => 'mranger\ckeditor\actions\FileUploadAction',
			],
		];
	}
```
После этого в настройках(пресете) указать url по которому должны производиться запросы для загрузки файлов.
```php
[
 'filebrowserUploadUrl' => Url::to(['your-controller/ckeditor-file-upload'], true),
]
```

По умолчанию разрешена загрузка только файлов с расширениями: "png, jpg, jpeg, bmp, gif, ico, swf", файлы загружаются по пути: '@webroot/upload'.
Если же необходимо изменить данные параметры, то в массиве params приложения можно определить свои параметры, а именно:
```php
[
 'CKEditorFileUploadAllowedExtensions' => 'gif, png, jpg', // разрешенные расширения файлов
 'CKEditorFileUploadPath' => '@webroot/ckeditor',          // путь для сохранения файлов
 'CKEditorFileUploadedUrl' => 'http://mysite.ru/ckeditor', // ссылка, по которой будут доступны сохраненые файлы
]
```

В настройках виджета можно подключить сторонние плагины для CKEditor, для этого необходимо в пресете добавить массив 'externalPlugins' c содержимым следующего формата:
```php
return [
    'externalPlugins'        => [
        [
            'name' => '', // название плагина
            'url' => '',  // url до папки плагином
            'fileName' => '' , // файл плагина
        ],
    ],
];
```