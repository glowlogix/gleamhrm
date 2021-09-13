<?php

use App\FaqCategory;
use Illuminate\Database\Seeder;

class FaqCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faq_category = FaqCategory::create([
            'name'   => 'General',
        ]);

        $faq_category = FaqCategory::create([
            'name'   => 'Others',
        ]);
    }
}
