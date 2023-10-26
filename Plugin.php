<?php namespace NielsVanDenDries\Unsplash;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'unsplash',
            'description' => 'Retrieves an image from Unsplash using API',
            'author' => 'nielsvandendries',
            'icon' => 'icon-leaf'
        ];
    }

    public function register()
    {
    }

    public function boot()
    {
    }

    public function registerComponents()
    {
        return [
            'Nielsvandendries\Unsplash\Components\Wallpaper' => 'Wallpaper',
        ];
    }

    public function registerPermissions()
    {
    }

    public function registerNavigation()
    {
    }
}
