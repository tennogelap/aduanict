<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ComplainRequest extends Request
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
    {   /*  Method POST - validation bagi CREATE
            Method PUT - validation bagi UPDATE
        */
        switch ($this->method()){
            case 'GET':
            case 'POST': {
                return['ADUAN' => 'required',];
                }
            case 'PUT':  {
                return['ADUAN' => 'required',];
                 }
            default:break;
        }
        /*return [
            'ADUAN' => 'required',
        ];*/
    }
}
