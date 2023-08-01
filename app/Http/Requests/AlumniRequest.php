<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class AlumniRequest extends FormRequest
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
                    'nim' => 'required',
                    'email' => 'required',
                    'nama' => 'required',
                    'kode_prodi_id' => 'required',
                    'thn_masuk' => 'required',
                    'thn_lulus' => 'required',
                    
                ];
                break;
            case 'patch':
                $rules = [
                    'nim' => 'required',
                    'email' => 'required',
                    'nama' => 'required',
                    'kode_prodi_id' => 'required',
                    'thn_masuk' => 'required',
                    'thn_lulus' => 'required',
                ];
                break;

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nim.*'  =>'Nim harus berisi.',
            'email.*'  =>'Email harus berisi.',
            'nama.*'  =>'Nama harus berisi.',
            'thn_masuk.*'  =>'Tahun Masuk harus berisi.',
            'kode_prodi_id.*'  =>'Prodi harus berisi.',
            'thn_lulus.*'  =>'Tahun Lulus harus berisi.',
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
