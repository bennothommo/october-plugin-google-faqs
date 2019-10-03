<?php
namespace BennoThommo\GoogleFaqs\Classes;

class Renderer
{
    public static function render(array $faqs)
    {
        $structure = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => self::renderItems($faqs)
        ];

        return json_encode($structure, JSON_PRETTY_PRINT);
    }

    protected static function renderItems(array $faqs)
    {
        $items = [];

        foreach ($faqs as $faq) {
            $items[] = [
                '@type' => 'question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'answer',
                    'text' => $faq['answer']
                ]
            ];
        }

        return $items;
    }
}
