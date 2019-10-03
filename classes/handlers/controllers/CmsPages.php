<?php
namespace BennoThommo\GoogleFaqs\Classes\Handlers\Controllers;

use Event;
use BennoThommo\GoogleFaqs\Classes\Handlers\ControllerHandler;
use BennoThommo\GoogleFaqs\Classes\Renderer;
use BennoThommo\Meta\JsonLd;

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

    public function attachEvents()
    {
        Event::listen('cms.page.beforeRenderPage', function (
            \Cms\Classes\Controller $controller,
            \Cms\Classes\Page $page
        ) {
            $faqs = [];

            if (isset($page->apiBag['staticPage'])) {
                $staticPage = $page->apiBag['staticPage'];

                if (isset($staticPage->viewBag['bennothommo_googlefaqs_faqs'])) {
                    $faqs = $staticPage->viewBag['bennothommo_googlefaqs_faqs'];
                }
            } elseif (isset($page->viewBag['bennothommo_googlefaqs_faqs'])) {
                $faqs = $page->viewBag['bennothommo_googlefaqs_faqs'];
            }

            if (count($faqs)) {
                JsonLd::set('googlefaqs', Renderer::render($faqs));
            }
        });
    }
}
