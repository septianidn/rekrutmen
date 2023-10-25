<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class PertanyaanRequest extends FormRequest
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
          
            'nama_halaman.*' => 'required',          
            'data.*.pertanyaan.*.pertanyaan' => 'required',
         
            'pertanyaan.*.kode_soal' => 'required',
            'pertanyaan.*.tipe_pertanyaan' => 'required',

            'pertanyaan.*.pertanyaan_general_option' => 'required',
            'pertanyaan.*.pertanyaan_general_option.*.kode' => 'required',
            'pertanyaan.*.pertanyaan_general_option.*.label' => 'required',
            'pertanyaan.*.pertanyaan_general_option.*.value' => 'required',
        ];
    }

    public function messages()
    {
        $messages =[];
        
        foreach ($this->get('data') as $key => $dataItem) {
            $pertanyaanArray = $dataItem['pertanyaan'];
            
            foreach ($pertanyaanArray as $key1 => $pertanyaanItem) {
                $messages["data.$key.pertanyaan.$key1.pertanyaan"] = "Kolom Halaman " . ($key + 1) . " , soal " . ($key1 + 1) . " wajib diisi";
            }
        }
    
        return $messages;
    
    
    }
    

     /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator){
    
        $data = [
            'status' => true,
            'message' => $validator->errors()->first(),
            'all_message' =>  $validator->errors()->all()
        ];

        if ($this->ajax()) {
            throw new HttpResponseException(response()->json($data,422));
        } else {
            throw new HttpResponseException(redirect()->back()->withInput()->with('errors', $data['all_message']));

        }
    }


}
