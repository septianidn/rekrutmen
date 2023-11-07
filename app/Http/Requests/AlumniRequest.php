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
        //TODO CHECKIN
       
        // dd($nim);
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
                    'pin' => 'nullable|unique:alumni|max:8',
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
                $nim = $this->route()->databasealumnus;
                $rules = [
                    'nim' => 'required|unique:alumni,nim,' .$nim.',nim',
                    'email' => 'required|email|unique:alumni,email,' .$nim.',nim',
                    'nama' => 'required',
                    'kode_prodi_id' => 'required',
                    'thn_masuk' => 'required',
                    'thn_lulus' => 'required',
                    'tempat_lahir'=> 'nullable',
                    'tanggal_lahir'=> 'nullable',
                    'pin' => 'nullable|max:8|unique:alumni,pin,' .$nim.',nim',
                    'nomor_handphone' => 'nullable|max:13|unique:alumni,nomor_handphone,' .$nim.',nim',
                    'periode_wisuda'=> 'nullable',
                    'status_tc'=> 'nullable',
                    'tipe_masuk'=> 'nullable',
                    //TODO: FIX THIS REQUEST FOR RDIT QUERY BLANK
                    'nik'=> 'nullable|unique:alumni,nik,' .$nim.',nim',
                    'npwp'=> 'nullable|unique:alumni,npwp,' .$nim.',nim',
                    'judul_tesis'=> 'nullable',
                ];
                break;

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nim.required' => 'Nim harus diisi.',
            'email.required' => 'Email harus diisi.',
            'nama.required' => 'Nama harus diisi.',
            'kode_prodi_id.required' => 'Kode Prodi harus diisi.',
            'thn_masuk.required' => 'Tahun Masuk harus diisi.',
            'thn_lulus.required' => 'Tahun Lulus harus diisi.',
            'pin.max' => 'Panjang PIN tidak boleh lebih dari :max karakter.',
            'nomor_handphone.max' => 'Panjang Nomor Handphone tidak boleh lebih dari :max karakter.',
            'pin.unique' => 'PIN sudah digunakan',
            'email.unique' => 'Email sudah digunakan.',
            'nim.unique' => 'Nim sudah digunakan.',
            'nik.unique' => 'NIK sudah digunakan.',
            'npwp.unique' => 'NPWP sudah digunakan.',
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
            throw new HttpResponseException(redirect()->back()->withInput()->with('errors', $data['all_message']));

        }
        
    }


}
