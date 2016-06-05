<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TwilioRequest extends Request
{
    /**
     * Validate that the incoming request is from twilio.
     *
     * @return bool
     */
    public function authorize(\Services_Twilio_RequestValidator $validator)
    {
        return $validator->validate(
            $this->headers->get('X-Twilio-Signature'),
            $this->fullUrl(),
            $this->input()
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}