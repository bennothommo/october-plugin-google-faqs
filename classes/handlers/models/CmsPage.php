<?php
namespace BennoThommo\GoogleFaqs\Classes\Handlers\Models;

use BennoThommo\GoogleFaqs\Classes\Handlers\ModelHandler;

class CmsPage extends ModelHandler
{
    /**
     * @inheritDoc
     */
    public function afterFetch($model)
    {
        $faqs = $this->fetchRecord($model);
        $model->viewBag['bennothommo_googlefaqs_faqs'] = $faqs;
    }

    /**
     * @inheritDoc
     */
    public function afterSave($model)
    {
        $this->saveRecord($model);
    }
}
