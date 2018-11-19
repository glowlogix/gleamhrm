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
        $doc=App\Document::Create([
            'name'      => 'Termination and Resignation Policy 2.docx.pdf', 
            'url'       => URL::to('storage/documents/Termination and Resignation Policy 2.docx.pdf'),
            'status'    => 1, 
        ]);

        $doc=App\Document::Create([
            'name'      => 'Code_of_Conduct.pdf',
            'url'       => URL::to('storage/documents/Code_of_Conduct.pdf'),
            'status'    => 1
        ]);
    }
}
