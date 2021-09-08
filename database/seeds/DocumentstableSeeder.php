<?php

use Illuminate\Database\Seeder;

class DocumentstableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doc = App\Document::Create([
            'name'      => 'Termination and Resignation Policy.pdf',
            'url'       => 'storage/documents/Termination and Resignation Policy.pdf',
            'status'    => 1,
        ]);
        $doc = App\Document::Create([
            'name'      => 'Code of Conduct.pdf',
            'url'       => 'storage/documents/Code of Conduct.pdf',
            'status'    => 1,
        ]);
    }
}
