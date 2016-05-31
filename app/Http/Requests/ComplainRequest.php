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
                $validation_rules = array('complain_category_id' => 'required',
                                          'complain_description' => 'required');
                //exclude Zakat2U and Portal from required validation
                $aduan_category_exception_value = array('5','6');

                //set required fields
                $others_field_validation = array(
                                                'branch_id'=>'required',
                                                'lokasi_id'=>'required',
                                                'ict_no'=>'required'
                                                );
                //check complain_category_id Not in $aduan_category_exception_value
                //in_array(field_name, array)
                if(!in_array($this->complain_category_id,$aduan_category_exception_value))
                {
                    $validation_rules = $others_field_validation + $validation_rules;
                }

                return $validation_rules;
                }
            case 'PUT':  {
                return['complain_description' => 'required',];
                 }
            default:break;
        }
        /*return [
            'complain_description' => 'required',
        ];*/
    }
}
