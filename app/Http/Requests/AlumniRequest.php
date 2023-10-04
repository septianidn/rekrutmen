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
        $nim =  $this->route()->nim;
        $rules = [];
        switch ($method) {
            case 'post':
                $rules = [
                    'nim' => 'required|unique:alumni',
                    'email' => 'required',
                    'nama' => 'required',
                    'kode_prodi_id' => 'required',
                    'thn_masuk' => 'required',
                    'thn_lulus' => 'required',
                    'tempat_lahir'=> 'nullable',
                    'tanggal_lahir'=> 'nullable',
                    'pin' => 'required|max:8',
                    'nomor_handphone' => 'nullable|max:13',
                    'periode_wisuda'=> 'nullable',
                    'status_tc'=> 'nullable',
                    'tipe_masuk'=> 'nullable',
                    'nik'=> 'nullable',
                    'npwp'=> 'nullable',
                    'judul_tesis'=> 'nullable',
                    
                ];
                break;
            case 'patch':
                $rules = [
                    // 'nim' => 'required|unique:alumni,nim,'.$nim,
                    'email' => 'required',
                    'nama' => 'required',
                    'kode_prodi_id' => 'required',
                    'thn_masuk' => 'required',
                    'thn_lulus' => 'required',
                    'tempat_lahir'=> 'nullable',
                    'tanggal_lahir'=> 'nullable',
                    // 'pin' => 'required|max:8|unique:alumni,nim,'.$nim,
                    // 'nomor_handphone' => 'nullable|max:13|unique:alumni,nim,'.$nim,
                    'periode_wisuda'=> 'nullable',
                    'status_tc'=> 'nullable',
                    'tipe_masuk'=> 'nullable',
                    // 'nik'=> 'nullable|unique:alumni,nim,'.$nim,
                    // 'npwp'=> 'nullable|unique:alumni,nim,'.$nim,
                    'judul_tesis'=> 'nullable',
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
