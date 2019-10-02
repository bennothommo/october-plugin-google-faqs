<?php
namespace BennoThommo\GoogleFaqs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateGoogleFaqsTable extends Migration
{
    public function up()
    {
        Schema::create('bennothommo_googlefaqs', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('model');
            $table->string('key');
            $table->text('faqs')->nullable()->default(null);
            $table->timestamps();

            $table->index('model');
            $table->index('key');
        });
    }

    public function down()
    {
        Schema::drop('october_blog_posts');
    }
}
