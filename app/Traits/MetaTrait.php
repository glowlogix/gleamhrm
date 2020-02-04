<?php

namespace App\Traits;

trait MetaTrait
{
    protected $meta = [
        'title' => '',
    ];

    public function metaResponse()
    {
        return $this->meta;
    }
}
