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
 php composer.phar require --prefer-dist ckeditor/ckeditor "dev-full/stable"
 ```
 
 или
 
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