<?php

namespace App\Inspections;
use Exception;
use Illuminate\Validation\ValidationException;

class KeyHeldDown
{

    public function detect($body)
    {
        if(preg_match('/(.)\1{4,}/u', $body)){
            throw new ValidationException('Your reply contains spam');
        }
    }
}
