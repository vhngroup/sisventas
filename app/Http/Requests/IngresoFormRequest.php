<?php

namespace sisventas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresoFormRequest extends FormRequest
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
    'idarticulo'=>'required',
    'cantidad'=>'required',
    'precio_compra'=>'required',
    'precio_venta'=>'required',
    'idproveedor'=>'required',
    'tipo_comprobante'=>'required|max:20',
    'serie_comprobante' =>'required|max:12',
    'numero_comprobante' =>'required|max:10',
    'anticipo' =>'required'
        ];
    }
}
