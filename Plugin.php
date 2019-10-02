<?php
namespace BennoThommo\GoogleFaqs;

use BennoThommo\GoogleFaqs\Classes\PluginHandler;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    /**
     * Defines required plugins.
     *
     * @var array
     */
    public $require = [
        'BennoThommo.Meta'
    ];

    /**
     * Defines plugin details.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'bennothommo.googlefaqs::lang.plugin.name',
            'description' => 'bennothommo.googlefaqs::lang.plugin.description',
            'author' => 'Ben Thomson',
            'iconSvg' => '~/bennothommo/googlefaqs/assets/img/icon.svg'
        ];
    }

    /**
     * Boot callback.
     *
     * @return void
     */
    public function boot()
    {
        $pluginHandler = PluginHandler::instance();

        // Register controller handlers

        // CMS module
        $pluginHandler->registerController(
            'Cms\Controllers\Index',
            'BennoThommo\GoogleFaqs\Classes\Handlers\Controllers\CmsPages'
        );
        $pluginHandler->registerModel(
            'Cms\Classes\Page',
            'BennoThommo\GoogleFaqs\Classes\Handlers\Models\CmsPage'
        );

        // RainLab.Pages
        $pluginHandler->registerController(
            'RainLab\Pages\Controllers\Index',
            'BennoThommo\GoogleFaqs\Classes\Handlers\Controllers\RainLabPages'
        );
        $pluginHandler->registerModel(
            'RainLab\Pages\Classes\Page',
            'BennoThommo\GoogleFaqs\Classes\Handlers\Models\RainLabPage'
        );

        $pluginHandler->attachEvents();
    }
}
