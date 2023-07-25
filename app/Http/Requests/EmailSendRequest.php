<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class EmailSendRequest extends FormRequest
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
                    'tujuan' => 'required|max:30',
                    'subjek' => 'required',
                    'isi' => 'required',
                    'tanggal_kirim' => 'required',
                    'tipe' => 'required',
                    'status' => 'required',

                ];
                break;
            case 'patch':
                $rules = [
                    'tujuan' => 'required|max:30',
                    'subjek' => 'required',
                    'isi' => 'required',
                    'tanggal_kirim' => 'required',
                    'tipe' => 'required',
                    'status' => 'required',
                ];
                break;

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nama_jenjang.*'  =>'Nama jenjang harus berisi.',
            'tujuan' => 'Tujuan email harus berisi',
            'subjek' => 'Subjek email harus berisi',
            'isi' => 'Isi email harus berisi',
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
