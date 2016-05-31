<?php

namespace App\Http\Controllers;

use App\AssetsLocation;
use App\Branch;
use App\ComplainCategory;
use App\ComplainSource;
use App\ComplainStatus;
use App\Unit;
use App\Asset;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Complain;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Requests\ComplainRequest;
use Auth;
use App\User;
use Entrust;
class ComplainController extends Controller
{
    /*MAIN function*/
    public function __construct()
    {
        $this->middleware('auth');
        $this->user_id = 0;

        if (Auth::check()){
            $this->user_id = Auth::user()->emp_id;
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Entrust::hasRole('members'))
        {
            /*
             * show by
             * 1. REGISTER_USER_ID
             * 2. USER_EMP_ID
             * 3. ACTION_EMP_ID*/
            $complains = Complain::where('user_emp_id',$this->user_id)
                ->orWhere('action_emp_id', $this->user_id)
                ->orWhere('register_user_id', $this->user_id)
                ->paginate(15);
        }
        else
        {
            $complains = Complain::orderBy('complain_id','desc')->paginate(15);
        }
        return view('complaints/index', compact('complains'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   //user list/dropdown
        $users = $this->get_users();
        //complain category list/dropdown
        $complain_categories = $this->get_complain_categories();
        //complain sources list/dropdown
        $complain_sources = $this->get_complain_sources();
        //complain location list/dropdown
        $locations = $this->get_locations();
        //complain branch list/dropdown
        $branchs = $this->get_branch();
        //complain assets list/dropdown
        $assets = $this->get_assets();

        return view('complaints/create',compact('users','complain_categories','complain_sources','locations','branchs','assets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComplainRequest $request)
    {
//      Start check if Bagi Pihak is null, assign user login as bagi pihak
//      dd($request);
        $pengadu   = $request->input('user_emp_id');
        if (empty($pengadu))
        {
            $pengadu = Auth::user()->emp_id;
//            dd($pengadu);
        }
//        End

        $input = $request->all();

        $input['user_emp_id'] = $pengadu;

        //create new record

        $aduan_category_exception_value = array('5','6');

        if(in_array($request->complain_category_id,$aduan_category_exception_value))
        {
            $input['lokasi_id'] = null;
            $input['ict_no'] = null;
        }

//        //save
//        $complain->save();
        $user = Complain::create($input); // alternative save

        //after success, route to index
        return redirect(route('complain.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('complaints/show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //complain category list/dropdown
        $complain_categories = $this->get_complain_categories();
        $complain = Complain::find($id);
        $statuses = ComplainStatus::lists('description', 'status_id');
        $units = Unit::lists('butiran', 'kod');
//        $sources=ComplainSource::lists('source_description', 'source_id');
        return view('complaints/edit',compact('complain','complain_categories', 'statuses','units','sources'));
    }
    public function action($id)
    {
        //complain category list/dropdown
        $complain_categories = $this->get_complain_categories();
        $complain = Complain::find($id);
        $statuses = ComplainStatus::lists('description', 'status_id');
        $units = Unit::lists('butiran', 'kod');
//        $sources=ComplainSource::lists('source_description', 'source_id');
        return view('complaints/action',compact('complain','complain_categories', 'statuses','units','sources'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComplainRequest $request, $id)
    {
        $butiran_aduan = $request->COMPLAIN_DESCRIPTION;
        $butiran_tindakan = $request->ACTION_COMMENT;
        //udate record
        $complain = Complain::find($id);
        $complain->COMPLAIN_DESCRIPTION = $butiran_aduan;
        $complain->ACTION_COMMENT = $butiran_tindakan;

        //save
        $complain->save();

        //after success, route to index
        return back();
    }
    /*
     * Helpdesk update action
     * */
    public function update_action(Request $request, $id)
    {
//        $butiran_aduan = $request->complain_description;
//        $butiran_tindakan = $request->action_comment;
//        $butiran_status =$request->complain_status_id;
//        dd($request->all());
        //udate record
        $complain = Complain::find($id);
//        $complain->helpdesk_delay_reason = $request->helpdesk_delay_reason;
//        $complain->action_comment = $request->action_comment;
//        $complain->complain_status_id = $request->complain_status_id;
//
//        //save
//        $complain->save();

        $complain->update($request->all());

//        return $complain;

        //after success, route to index
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        dd($request->all());

        //delete record
        $complain = Complain::find($id);
        $complain->delete();

        //after success, route to index
        return back();
    }
    //get data
    function get_complain_categories (){

        $complain_categories = ComplainCategory::lists('description','category_id');
        $complain_categories = array(''=>'Pilih Kategori')+$complain_categories ->all();
        return $complain_categories;
    }
    function get_complain_sources (){

        $complain_sources = ComplainSource::lists('description','source_id');
        $complain_sources = array(''=>'Pilih Kaedah')+$complain_sources ->all();
        return $complain_sources;
    }
    function get_users (){

        $users = User::where('id','!=',Auth::user()->id)->lists('name','id');
        $users = array(''=>'Sila buat pilihan') + $users->all();
        return $users;
    }
    function get_locations (){
        $branch_id = \Request::input('branch_id');

        if (!empty($branch_id))
        {
            $locations= AssetsLocation::where('branch_id',$branch_id)->lists('location_description','location_id');
        }
        else
        {
            $locations= AssetsLocation::lists('location_description','location_id');
        }
//        $locations= AssetsLocation::lists('location_description','location_id');
        $locations = array(''=>'Pilih lokasi') + $locations->all();
        return $locations;
    }

    function get_assets_dummy()
    {
        $assets = array(''=>'Sila pilih aset ICT','1'=>'PC','2'=>'Laptop','3'=>'Projector' );

        return $assets;
    }

    function get_assets (){
        $lokasi_id = \Request::input('lokasi_id');

        if (!empty($lokasi_id))
        {
            $assets= Asset::where('lokasi_id',$lokasi_id)->lists('ict_no'.'butiran','ict_no');
        }
        else
        {
            $assets= Asset::lists('ict_no'.'butiran','ict_no');
        }
//        $locations= AssetsLocation::lists('location_description','location_id');
        $assets = array(''=>'Pilih Aset') + $assets->all();
        return $assets;
    }
    function get_branch (){
        $branchs= Branch::lists('branch_description','id');
        $branchs = array(''=>'Pilih cawangan') + $branchs->all();
        return $branchs;
    }
}
