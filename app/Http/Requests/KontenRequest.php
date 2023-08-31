<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class KontenRequest extends FormRequest
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
        $user_id = $this->route()->user;

        $rules = [];
        switch ($method) {
            case 'post':
                $rules = [   
                    'judul' => 'required|max:255',
                    'kategori_konten_id' => 'required',
                    'isi_konten' => 'required',
                    'alias_url' => 'required',     
                    'waktu_terbit'  => 'nullable',              
                    'waktu_tutup' => 'nullable',              
                    'gambar_headline' => 'nullable',        
                    'meta_key'  => 'nullable',        
                    'meta_desc' => 'nullable',      
                    'tags' => 'nullable',        
                    'status_terbit_id'  => 'required',
                ];
                break;
            case 'patch':
                $rules = [
                    'judul' => 'required|max:255',
                    'kategori_konten_id' => 'required',
                    'isi_konten' => 'required',
                    'alias_url' => 'required',     
                    'waktu_terbit'  => 'nullable',              
                    'waktu_tutup' => 'nullable',              
                    'gambar_headline' => 'nullable',        
                    'meta_key'  => 'nullable',        
                    'meta_desc' => 'nullable',      
                    'tags' => 'nullable',        
                    'status_terbit_id'  => 'required',
                ];
                break;

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'judul.*'  => 'Judul harus berisi.',
            'isi_konten.*'  => 'Isi konten harus berisi.',
            'alias_url.*'  =>'Alias Url harus berisi.',
            'status_terbit_id.*'  => 'Pilih Status Terbit',
           
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
