<?php

namespace App\Inspections;
use Exception;
use Illuminate\Validation\ValidationException;

class Invalidkeywords
{
    protected $keywords = [
        'foo'
    ];

    public function detect($body)
    {

        foreach ($this->keywords as $keyword) {
            if(stripos(request($body), $keyword) !== false ){
                throw new ValidationException('Your reply contains spam');
            }
        }
    }
}
