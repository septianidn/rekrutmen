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
            'data.*.pertanyaan.*.kode_soal' => 'required',
         
            'data.*.pertanyaan.*.pertanyaan_general_option.*.kode' => 'required',
            'data.*.pertanyaan.*.pertanyaan_general_option.*.label' => 'required',
            'data.*.pertanyaan.*.pertanyaan_general_option.*.value' => 'required'

        ];
    }

    public function messages()
    {
        $messages =[];
        
        $data = $this->get('data');
      
        if ($data !== null) {
            foreach ($data as $indexPage => $halamanData) {
                if (isset($halamanData['pertanyaan'])) {
                    foreach ($halamanData['pertanyaan'] as $indexCard => $pertanyaanData) {
                        $halaman = "Halaman " . ($indexPage + 1);
                        $soal = "Soal " . ($indexCard + 1);
        
                        // Menambahkan pesan pertanyaan
                        $messages["data.$indexPage.pertanyaan.$indexCard.pertanyaan"] = "Silahkan Isi Pertanyaan $halaman, $soal";
                        $messages["data.$indexPage.pertanyaan.$indexCard.kode_soal"] = "Silahkan Isi Kode Soal $halaman, $soal";
                      
                        if ($pertanyaanData['tipe_pertanyaan'] === 'single' || $pertanyaanData['tipe_pertanyaan'] === 'mutiple') {
                            if (isset($pertanyaanData['pertanyaan_general_option']) && is_array($pertanyaanData['pertanyaan_general_option'])) {
                                foreach ($pertanyaanData['pertanyaan_general_option'] as $indexOption => $pertanyaanGeneralOptionData) {
                                    $indexOptionLabel = $indexOption+1;
                                    $messages["data.$indexPage.pertanyaan.$indexCard.pertanyaan_general_option.$indexOption.kode"] = "Silahkan Isi Kode Single Option ke $indexOptionLabel, $halaman, $soal";
                                    $messages["data.$indexPage.pertanyaan.$indexCard.pertanyaan_general_option.$indexOption.label"] = "Silahkan Isi Label Single Option ke $indexOptionLabel, $halaman, $soal";
                                    $messages["data.$indexPage.pertanyaan.$indexCard.pertanyaan_general_option.$indexOption.value"] = "Silahkan Isi Value Single Option ke $indexOptionLabel, $halaman, $soal";
                                }
                            }
                        }
                    }
                }
            }
        }
    
        dd($messages);
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
