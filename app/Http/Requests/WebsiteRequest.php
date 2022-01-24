<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\RuleTrait;

class WebsiteRequest extends FormRequest
{
    use RuleTrait;

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rule();
    }

    public function store()
    {
        return [
            'url' => [
                'required',
                'url',
            ]
        ];
    }

    public function index()
    {
        return [
            'begin' => [
                'required_with:end',
                'date_format:Y-m-d',
                'nullable',
            ],
            'end' => [
                'required_with:begin',
                'date_format:Y-m-d',
                'nullable',
            ],
        ];
    }
}
