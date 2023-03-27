<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\CaptchaTrait;
use Setting;

class ContactRequest extends FormRequest
{
    protected $availableAttributes = 'contact.attributes';

    use CaptchaTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        $all = parent::validationData();
        $contactPage = Setting::get('recaptcha_contact', 0);
        $all['captcha'] = $this->captchaCheck($contactPage);

        return $all;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'captcha' => 'required|accepted',
        ];
    }
}
