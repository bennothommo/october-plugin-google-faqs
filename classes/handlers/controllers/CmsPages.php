<?php
namespace BennoThommo\GoogleFaqs\Classes\Handlers\Controllers;

use BennoThommo\GoogleFaqs\Classes\Handlers\ControllerHandler;

class CmsPages extends ControllerHandler
{
    /**
     * @inheritDoc
     */
    public function extendFields(\Backend\Widgets\Form $widget)
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
}
