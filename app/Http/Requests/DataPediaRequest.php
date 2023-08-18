<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class DataPediaRequest extends FormRequest
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
                    'nama_data' => 'required',
                    'deskripsi_data' => 'nullable',
                    'publish' => 'required',
                   
                ];
                break;
            case 'patch':
                $rules = [
                    'nama_data' => 'required',
                    'deskripsi_data' => 'nullable',
                    'publish' => 'required',
                ];
                break;

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nama_data.*'  =>'Nama Data harus berisi.',
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
