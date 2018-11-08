<?php

namespace App\Inspections;
use Exception;
use Illuminate\Validation\ValidationException;

class Invalidkeywords
{

    /**
     * All registered invalid keywords.
     *
     * @var array
     */
    protected $keywords = [
        'foo'
    ];

    /**
     * Detect spam.
     *
     * @param  string $body
     * @throws \Exception
     */
    public function detect($body)
    {

        foreach ($this->keywords as $keyword) {
            if(stripos(request($body), $keyword) !== false ){
                throw new ValidationException('Your reply contains spam');
            }
        }
    }
}
