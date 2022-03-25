<?php

namespace Overtrue\UEditor;

use Encore\Admin\Form;
use Encore\Admin\Admin;
use Illuminate\Support\ServiceProvider;

class UEditorServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(UEditor $extension)
    {
        if (!UEditor::boot()) {
            return;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'laravel-admin-ueditor');
        }

        Admin::booting(function () {
            Form::extend(UEditor::config('field_type', 'UEditor'), Editor::class);
        });
    }
}
