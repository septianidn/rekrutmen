<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class KonselorRequest extends FormRequest
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
        $user_id = $this->route()->konselor;
      
        $rules = [];
        switch ($method) {
            case 'post':
                $rules = [

                    'password' => 'required|confirmed|min:8',
                    'email' => 'required|max:191|email|unique:users',
                    'phone_number'=>'max:13',
                    'nip' => 'nullable|max:16|number|unique:konselor',
                    'deskripsi' => 'nullable'

                ];
                break;
            case 'patch':
                $rules = [
                    'email' => 'required|max:191|email|unique:users,email,'.$user_id,
                    'phone_number'=>'max:13',
                    'password' => 'confirmed|min:8|nullable',
                    'nip' => 'nullable|max:16|number|unique:konselor,nip,'.$user_id,
                    'deskripsi' => 'nullable'


                ];
                break;

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'password.*'  =>'Password harus diisi.',
            'email.required'  =>'Email harus berisi.',
            'email.unique'  =>'Email telah digunakan.',
            'nip.unique'  =>'NIP telah digunakan.',

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
