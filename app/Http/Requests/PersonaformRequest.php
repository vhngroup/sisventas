<?php

namespace sisventas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

class PersonaformRequest extends FormRequest
{
    private $route;
    public function __construct(Route $route)
    {
        $this->route=$route;
    }
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
    return 
    [
    'nombre'=>'required|max:100',
    'tipo_documento'=>'required|max:20',
    'num_documento'=>'required|max:20|unique:persona,num_documento,'.$this->segment('3').',idpersona',
    'direccion'=>'max:200',
    'telefono'=>'required|max:30',
    'email'=>'max:50'
    ];
    }
}
