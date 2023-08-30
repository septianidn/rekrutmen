<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class KategoriKontenRequest extends FormRequest
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
                    'nama_kategori' => 'required|string|max:255',
                    'alias_url' => 'required|string|max:255',
                    'deskripsi' => 'nullable|string',
                    'grup_konten_id' => 'required',
                  
             
                ];
                break;
            case 'patch':
                $rules = [
                    'nama_kategori' => 'required|string|max:255',
                    'alias_url' => 'required|string|max:255',
                    'deskripsi' => 'nullable|string',
                    'grup_konten_id' => 'required',
                   
             
                  
                   
                ];
                break;

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nama_kategori.*'  =>'Nama Grup is required.',
            'deskripsi.*'  =>'Deskripsi is required.',
            'alias_url.*'  =>'Alias Url is required.',
            'grup_konten_id.*'  =>'Pilih grup konten.',
           
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
