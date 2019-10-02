<?php
namespace BennoThommo\GoogleFaqs;

use BennoThommo\GoogleFaqs\Models\Faqs;
use System\Classes\PluginBase;
use System\Classes\PluginManager;
use Event;
use Lang;

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
        // Attach to forms
        Event::listen('backend.form.extendFields', function ($widget) {
            $validControllers = [
                'Cms\Controllers\Index',
                'RainLab\Pages\Controllers\Index'
            ];
            $widgetController = get_class($widget->getController());

            if (!in_array($widgetController, $validControllers)) {
                return;
            }

            $this->extendFields($widgetController, $widget);
        });

        $this->extendModels();
    }

    protected function extendFields(string $controller, \Backend\Widgets\Form $widget)
    {
        if ($controller === 'Cms\Controllers\Index') {
            $this->extendCmsPagesAndLayoutsFields($widget);
        } elseif ($controller === 'RainLab\Pages\Controllers\Index') {
            $this->extendRainLabPagesFields($widget);
        }
    }

    protected function extendCmsPagesAndLayoutsFields(\Backend\Widgets\Form $widget)
    {
        $validModels = [
            'Cms\Classes\Page',
            'Cms\Classes\Layout'
        ];
        $model = get_class($widget->model);

        if (!in_array($model, $validModels)) {
            return;
        }

        if ($widget->isNested) {
            return;
        }

        $this->injectFields($widget);
    }

    protected function extendRainLabPagesFields(\Backend\Widgets\Form $widget)
    {
        $validModels = [
            'RainLab\Pages\Classes\Page',
        ];
        $model = get_class($widget->model);

        if (!in_array($model, $validModels)) {
            return;
        }

        if ($widget->isNested) {
            return;
        }

        $this->injectFields($widget);
    }

    protected function injectFields(\Backend\Widgets\Form $widget)
    {
        $widget->addTabFields([
            'bennothommo_googlefaqs_faqs' => [
                'type' => 'repeater',
                'tab' => Lang::get('bennothommo.googlefaqs::lang.tabs.googleFaqs'),
                'titleFrom' => 'question',
                'prompt' => Lang::get('bennothommo.googlefaqs::lang.fields.faqs.prompt'),
                'form' => [
                    'fields' => [
                        'question' => [
                            'type' => 'textarea',
                            'label' => Lang::get('bennothommo.googlefaqs::lang.fields.faqs.fields.question.label'),
                            'size' => 'small',
                            'span' => 'left',
                        ],
                        'answer' => [
                            'type' => 'textarea',
                            'label' => Lang::get('bennothommo.googlefaqs::lang.fields.faqs.fields.answer.label'),
                            'size' => 'small',
                            'span' => 'right',
                        ]
                    ]
                ]
            ]
        ]);
    }

    protected function extendModels()
    {
        if (PluginManager::instance()->exists('RainLab.Pages')) {
            \RainLab\Pages\Classes\Page::extend(function ($model) {
                $model->bindEvent('model.afterSave', function () use ($model) {
                    $this->afterSave($model);
                });
            });
        }
    }

    protected function afterSave($model)
    {
        $class = get_class($model);
        $key = $model->id;
        $faqs = post('bennothommo_googlefaqs_faqs');

        // Find record for model
        $faqRecord = Faqs::where([
            'model' => $class,
            'key' => $key
        ])->first();

        if (!$faqRecord) {
            $faqRecord = Faqs::create([
                'model' => $class,
                'key' => $key,
                'faqs' => json_encode(array_values($faqs))
            ]);
        } else {
            $faqRecord->faqs = json_encode(array_values($faqs));
            $faqRecord->save();
        }
    }
}
