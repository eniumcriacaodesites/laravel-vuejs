<?php

namespace CodeBills\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillReceiveRequest extends FormRequest
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
        return [
            'date_due' => 'required|date_format:Y-m-d',
            'name' => 'required|max:255',
            'value' => 'required|numeric',
            'done' => 'boolean',
        ];
    }
}
