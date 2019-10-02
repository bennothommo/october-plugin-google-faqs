<?php
namespace BennoThommo\GoogleFaqs\Models;

use Model;

class Faqs extends Model
{
    /**
     * Table associated with the model.
     *
     * @var string
     */
    protected $table = 'bennothommo_googlefaqs';

    /**
     * Enables timestamping
     *
     * @var boolean
     */
    public $timestamps = true;

    /**
     * Defines fillable attributes
     *
     * @var array
     */
    public $fillable = [
        'model',
        'key',
        'faqs'
    ];
}
