<?php

namespace App\Inspections;
use Exception;

class Invalidkeywords
{
    protected $keywords = [
        'foo'
    ];

    public function detect($body)
    {

        foreach ($this->keywords as $keyword) {
            if(stripos(request($body), $keyword) !== false ){
                throw new Exception('Your reply contains spam');
            }
        }
    }
}
