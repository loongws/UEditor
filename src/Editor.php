<?php

namespace Overtrue\UEditor;

use Encore\Admin\Form\Field;
use Illuminate\Support\Str;
class Editor extends Field
{
    protected $view = 'laravel-admin-ueditor::editor';

    protected static $js = [
        'vendor/ueditor/ueditor.config.js',
        'vendor/ueditor/ueditor.all.js',
    ];

    public function render()
    {
        $name = $this->formatName($this->column);
        
        $jsId = Str::studly(Str::slug($this->id));

        $config = UEditor::config('config', []);

        $config = json_encode(array_merge($config, $this->options));

        $laravel_ueditor_route = config('ueditor.route.name');
        $token = csrf_token();

        $this->script = <<<EOT

window.UEDITOR_CONFIG.serverUrl = '{$laravel_ueditor_route}';
UE.delEditor("{$this->id}");
var ue_{$jsId} = UE.getEditor('{$this->id}', {$config});
ue_{$jsId}.ready(function() {
    ue_{$jsId}.execCommand('serverparam', '_token', '$token');
});

EOT;
        return parent::render();
    }
}
