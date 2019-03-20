<?php

namespace sisventas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoFormRequest extends FormRequest
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
            'idpersona'=>'required',
            'fecha'=>'required',
            'descripcion'=>'required|max:80',
            'estado'=>'required'
            //
        ];
    }
}
