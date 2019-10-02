<?php
return [
    'plugin' => [
        'name' => 'Google FAQs',
        'description' => 'Insert Google FAQ JSON-LD content into your website.',
    ],
    'tabs' => [
        'googleFaqs' => 'Google FAQs',
    ],
    'fields' => [
        'faqs' => [
            'prompt' => 'Add a new FAQ entry',
            'fields' => [
                'question' => [
                    'label' => 'Question'
                ],
                'answer' => [
                    'label' => 'Answer'
                ]
            ]
        ],
    ],
];
