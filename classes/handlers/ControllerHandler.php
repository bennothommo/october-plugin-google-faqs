<?php
namespace BennoThommo\GoogleFaqs\Classes\Handlers;

use Lang;

abstract class ControllerHandler
{
    /**
     * Extends the fields in a form widget.
     *
     * @param \Backend\Widgets\Form $widget
     * @return void
     */
    abstract public function extendFields(\Backend\Widgets\Form $widget);

    /**
     * Injects the FAQs field into the form widget.
     *
     * @param \Backend\Widgets\Form $widget
     * @return void
     */
    protected function injectFields(\Backend\Widgets\Form $widget)
    {
        $widget->addTabFields([
            'bennothommo_googlefaqs_faqs' => [
                'type' => 'repeater',
                'tab' => Lang::get('bennothommo.googlefaqs::lang.tabs.googleFaqs'),
                'titleFrom' => 'question',
                'prompt' => Lang::get('bennothommo.googlefaqs::lang.fields.faqs.prompt'),
                'commentAbove' => Lang::get('bennothommo.googlefaqs::lang.hints.faqs'),
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
}
