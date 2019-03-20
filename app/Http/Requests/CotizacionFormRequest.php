<?php

namespace sisventas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotizacionFormRequest extends FormRequest
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
    'idcliente'=>'required',
    'serie_comprobante' =>'max:12',
    'num_comprobante' =>'required|max:10',
    'idarticulo'=>'required',
    'cantidad'=>'required',
    'acm_Totalgeneral'=>'required',
    'acm_Descuento'=>'required',
    'acm_Subtotal'=>'required',
    'acm_Iva'=>'required',
    'acm_Total'=>'required',
    'totalgeneral'=>'required',
    'totaldescuento'=>'required',
    'subtotal'=>'required',
    'valoriva'=>'required',
    'totalventa'=>'required',
    'idproyecto'=>'required'
        ];
    }
}
