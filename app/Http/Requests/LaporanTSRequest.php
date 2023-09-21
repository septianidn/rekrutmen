<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class LaporanTSRequest extends FormRequest
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
        $laporants_id =  $this->route()->laporan_tracer_study;
        

        $rules = [];
        switch ($method) {
            case 'post':
                $rules = [
                    'paket_soal_id' => 'required|unique:laporan_ts',
                    'lokasi_laporan' => 'required',
                    
                    'deskripsi' => 'nullable',
           
                    'published' => 'nullable'
                ];
                break;
            case 'patch':
                $rules = [
                    'paket_soal_id' => 'required|unique:laporan_ts,paket_soal_id,'.$laporants_id,
                    'lokasi_laporan' => 'required',
                    
                    'deskripsi' => 'nullable',
           
                    'published' => 'nullable'
                ];
                break;

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'alias_url.*'  =>'Alias URL harus berisi.',
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
