<?php

namespace sisventas\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;
use Articulo;


class ArticuloFormRequest extends FormRequest
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
       
            return [
            'idcategoria' =>'required',
            'impuesto' =>'required',
             'codigo' =>'required|max:28|unique:articulo,codigo,'.$this->segment('3').',idarticulo',
             'nombre'=>'required |max:85',
             'stock'=>'required |numeric',
             'descripcion'=>'required | max:410',
             'imagen'=>'mimes:jpeg,jpg,bmp,png'
            ];
        }
       
    }
