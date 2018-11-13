<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Channel;
use App\Rules\Recaptcha;
use Illuminate\Auth\Access\Gate;

class StoreThreadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'channel_id' => [
                    'required',
                    'exists:channels,id',
                    //Checks if channel contains the specific category passed by request
                    function ($attribute, $value, $fail) {
                        $result = Channel::where('category_id', request('category_id'))->first();
                        if (empty($result)) {
                            $fail('Category id is invalid.');
                        }
                    },
                ],
            'category_id' => 'required|exists:categories,id',
            'g-recaptcha-response' => ['required', new Recaptcha],
        ];
    }
}
