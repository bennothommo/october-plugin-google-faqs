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
    'hints' => [
        'faqs' => 'You may use this section to add frequently-asked questions to your Google (or other JSON-LD
            compatible) search results. These generally appear underneath the current page\'s listing in the results.'
    ]
];
