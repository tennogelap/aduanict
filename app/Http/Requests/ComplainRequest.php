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
    {
        $route_name = $this->route()->getName();
        /*  Method POST - validation bagi CREATE
            Method PUT - validation bagi UPDATE
        */
        switch ($this->method()){
            case 'GET':
            case 'POST':
                {
                    $validation_rules = array('complain_category_id' => 'required',
                                              'complain_description' => 'required',
                                              'complain_attachment' => 'mimes:jpeg,jpg,bmp,png,pdf,doc,docx,txt,zip,rar');
                    //exclude Zakat2U and Portal from required validation
                    $aduan_category_exception_value = array('5','6');

                    //set required fields
                    $others_field_validation = array(
                                                    'branch_id'=>'required',
                                                    'lokasi_id'=>'required',
                                                    'ict_no'=>'required'
                                                    );

                    $complain_category_id_exp = explode('-',$this->complain_category_id);
                    $complain_category_id = $complain_category_id_exp[0];

                    //check complain_category_id Not in $aduan_category_exception_value
                    //in_array(field_name, array)
                    if(!in_array($complain_category_id,$aduan_category_exception_value))
                    {
                        $validation_rules = $others_field_validation + $validation_rules;
                    }

                    return $validation_rules;
                }
            case 'PUT':
                {
                    if($route_name=='complain.update') {
                        //kemaskini validation rules
                        $validation_rules = array(
                            'complain_category_id'=>'required',
                            'lokasi_id' => 'required',
                            'ict_no' => 'required');

                        if($this->exclude_category=='Y')
                        {
                            array_pull($validation_rules,'complain_category_id');
                        }
                        /* remove item from array
                         * array_pull(array_name, value_name) .. e.g:
                         * array_pull($validation_rules,'complain_category_id');
                         * */
                    }
                    elseif ($route_name=='complain.update_action')
                    {
                        if (!$this->has('submit_type'))
                        {
                            $validation_rules = array(
                                'complain_status_id' => 'required',
                                'action_comment' => 'required'
                            );
                        }
                        else
                        {
                            $validation_rules=array();
                        }
                    }
                    return $validation_rules;
                 }
            default:break;
        }
    }
    public function messages()
    {
        return [
            'branch_id.required' => 'Cawangan adalah mandatori',
            'lokasi_id.required' => 'Lokasi adalah mandatori',
            'ict_no.required' => 'Aset adalah mandatori',
            'complain_category_id.required' => 'Kategori adalah mandatori',
            'complain_source_id.required' => 'Kaedah adalah mandatori',
            'complain_description.required' => 'Aduan adalah mandatori',
            'action_comment.required' => 'Tindakan adalah mandatori',
            'complain_attachment.mimes' => 'Apih terer ngat ekpong.... ni jah buleh upload->jpeg,bmp,png,pdf,doc,docx,txt,zip,rar'
        ];
    }
}
