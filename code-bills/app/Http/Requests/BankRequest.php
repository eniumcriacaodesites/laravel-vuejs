<?php

namespace CodeBills\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
{
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
        if ($this->getMethod() === 'PUT') {
            return [
                'name' => 'required|max:255|unique:banks,name,' . (int) $this->route('bank'),
                'logo' => 'max:255|image',
            ];
        }

        return [
            'name' => 'required|max:255|unique:banks,name',
            'logo' => 'required|max:255|image',
        ];
    }
}
