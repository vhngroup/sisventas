<?php

namespace sisventas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoFormRequest extends FormRequest
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
    'idproveedor'=>'required',
    'num_comprobante' =>'required|max:15',
    'idarticulo'=>'required',
    'cantidad'=>'required',
    'precio_venta'=>'required',
    'descuento'=>'required',
    'total_venta'=>'required',  
    
            //
        ];
    }
}
