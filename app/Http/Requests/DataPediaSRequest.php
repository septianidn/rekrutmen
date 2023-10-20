<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class DataPediaSRequest extends FormRequest
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
        $method = strtolower($this->method());
    
        $rules = [];
        switch ($method) {
            case 'post':
                $rules = [
                    'value' => 'required',
                    'label' => 'required',
                    'parent_id' => 'nullable',
                   
                ];
                break;
            case 'patch':
                $rules = [
                    'value' => 'required',
                    'label' => 'required',
                    'parent_id' => 'nullable',
                   
                ];
                break;

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'value.*'  =>'Value Data harus berisi.',
            'label.*'  =>'Label Data harus berisi.',
        ];
    }

     /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator){
        $data = [
            'status' => true,
            'message' => $validator->errors()->first(),
            'all_message' =>  $validator->errors()
        ];

        if ($this->ajax()) {
            throw new HttpResponseException(response()->json($data,422));
        } else {
            throw new HttpResponseException(redirect()->back()->withInput()->with('errors', $validator->errors()));
        }
    }


}
