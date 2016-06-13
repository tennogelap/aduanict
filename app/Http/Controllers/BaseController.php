<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\ComplainStatus;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\AssetsLocation;
use App\Branch;
use App\ComplainCategory;
use App\ComplainSource;
use App\Complain;
use App\Asset;
use Illuminate\Support\Facades\DB;
class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->user_id = 0;
        $this->unit_id = 0;
        $this->exclude_array = [5,6];
        if (Auth::check()){
            $this->user_id = Auth::user()->emp_id;
            $this->unit_id = Auth::user()->unit_id;
        }
    }

    public function get_complain_statuses()
    {
        $complain_statuses = ComplainStatus::lists('description','status_id');
        $complain_statuses = [''=>'Pilih Status']+ $complain_statuses->all();
        return $complain_statuses;
    }

    public function format_date($date)
    {
        $exp_date = explode('-',$date);
        $get_year = $exp_date[2];
        $get_month = $exp_date[1];
        $get_day = $exp_date[0];
        $formatted_date = Carbon::createFromDate($get_year,$get_month,$get_day)->format('Y-m-d');
        return $formatted_date;
    }
    public function get_branches (){
        $branches= Branch::lists('branch_description','id');
        $branches = array(''=>'Pilih cawangan') + $branches->all();
        return $branches;
    }
    public function get_complain_categories (){

        $complain_categories = ComplainCategory::select('description',
            DB::raw('category_id||\'-\'|| kod_unit AS category_value'))
            ->lists('description','category_value');
        $complain_categories = array(''=>'Pilih Kategori')+$complain_categories ->all();

        return $complain_categories;
    }
    public function get_complain_sources (){

        $complain_sources = ComplainSource::lists('description','source_id');
        $complain_sources = array(''=>'Pilih Kaedah')+$complain_sources ->all();
        return $complain_sources;
    }
    public function get_users (){

        $users = User::where('id','!=',Auth::user()->id)->lists('name','emp_id');
        $users = array(''=>'Sila buat pilihan') + $users->all();
        return $users;
    }
    public function get_locations ($filter=array()){
        //check for edit filter by branch_id in array
        //dd(1);
        if (isset($filter['branch_id'])&& !empty($filter['branch_id']))
        {
            $branch_id = $filter['branch_id'];
        }
        //check for AJAX request filter by branch_id
        if ($this->request->has('branch_id'))
        {
            $branch_id = $this->request->input('branch_id');
        }
        if(empty($branch_id))
        {
            $validation_branch_id = $this->request->old('branch_id');
            $branch_id = $validation_branch_id;
        }
        if (!empty($branch_id))
        {
            $locations= AssetsLocation::where('branch_id',$branch_id)
                ->lists('location_description','location_id');
        }
        else
        {
            $locations= AssetsLocation::lists('location_description','location_id');
        }
        $locations = array(''=>'Pilih lokasi') + $locations->all();
        return $locations;
    }

    public function get_assets ($filter=array()){
        //filter by ajax request
        $lokasi_id= $this->request->lokasi_id;

        //or filter by array from other function
        if (isset($filter['lokasi_id'])&& !empty($filter['lokasi_id']))
        {
            $lokasi_id = $filter['lokasi_id'];
        }

        if(empty($lokasi_id))
        {
            $validation_lokasi_id = $this->request->old('lokasi_id');
            $lokasi_id = $validation_lokasi_id;
        }

        if (!empty($lokasi_id))
        {
            $assets =Asset::select('ict_no', DB::raw('ict_no||\'-\'|| butiran AS butiran_aset'))
                ->where('lokasi_id',$lokasi_id)
                ->lists('butiran_aset', 'ict_no');
            $assets = array(''=>'Pilih Aset') + $assets->all();
        }
        else
        {//by default
            $assets = array(''=>'Pilih Aset');
        }

        return $assets;
    }
    public function get_complain_actions($id){

        $complain_actions=Complain::find($id)->complain_action_fk()->orderBy('id','desc')->get();
        return $complain_actions;
    }
    function prepare_branch_location_asset($complain, $method='edit')
    {
        //if zakat2u & portal, exclude branch, location, asssetid

        if(!in_array($complain->complain_category_id, $this->exclude_array)) {
            //complain location list/dropdown
            $location_filter = array('branch_id' => $complain->branch_id);
            $locations = $this->get_locations($location_filter);
            //complain branch list/dropdown
            $branches = $this->get_branches();
            //complain assets list/dropdown
            $complain_lokasi_id = $complain->lokasi_id;
            $assets_filter = ['lokasi_id' => $complain_lokasi_id];
            $assets = $this->get_assets($assets_filter);
            $hide_branches_locations_assets ='N';
        }
        else
        {
            if($method=='action')
            {
                $branches = $this->get_branches();
                $locations = $this->get_locations();
                $assets = $this->get_assets();
                $hide_branches_locations_assets = 'N';
            }
            else
            {
                $branches = [];
                $locations = [];
                $assets = [];
                $hide_branches_locations_assets = 'Y';
            }
        }
        return ['branches'=>$branches,
            'locations'=>$locations,
            'assets'=>$assets,
            'hide_branches_locations_assets'=>$hide_branches_locations_assets];
    }
}
