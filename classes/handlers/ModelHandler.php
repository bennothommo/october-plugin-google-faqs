<?php
namespace BennoThommo\GoogleFaqs\Classes\Handlers;

use BennoThommo\GoogleFaqs\Models\Faqs;

abstract class ModelHandler
{
    /**
     * Extends the `model.afterFetch` event.
     *
     * @param object $model
     * @return void
     */
    abstract public function afterFetch($model);

    /**
     * Retrieves the FAQ record from the database.
     *
     * @param object $model
     * @return void
     */
    protected function fetchRecord($model)
    {
        $class = get_class($model);
        $key = $model->id;

        // Find record for model
        $faqRecord = Faqs::where([
            'model' => $class,
            'key' => $key
        ])->first();

        if (!$faqRecord) {
            return null;
        } else {
            return $faqRecord->faqs;
        }
    }

    /**
     * Extends the `model.afterSave` event.
     *
     * @param object $model
     * @return void
     */
    abstract public function afterSave($model);

    /**
     * Saves the FAQ record in the database.
     *
     * @param object $model
     * @return void
     */
    protected function saveRecord($model)
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
                'faqs' => (!empty($faqs)) ? array_values($faqs) : null
            ]);
        } else {
            $faqRecord->faqs = (!empty($faqs)) ? array_values($faqs) : null;
            $faqRecord->save();
        }
    }
}
