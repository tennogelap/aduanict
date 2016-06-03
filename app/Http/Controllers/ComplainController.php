<?php

namespace App\Http\Controllers;

use App\AssetsLocation;
use App\Branch;
use App\ComplainAction;
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
use Flash;
class ComplainController extends Controller
{
    /*MAIN function*/
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->user_id = 0;
        $this->unit_id = 0;

        if (Auth::check()){
            $this->user_id = Auth::user()->emp_id;
            $this->unit_id = Auth::user()->unit_id;
        }
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
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
        elseif (Entrust::hasRole('unit_manager'))
        {
            $complains = Complain::where('user_emp_id',$this->user_id)
                ->orWhere('action_emp_id', $this->user_id)
                ->orWhere('register_user_id', $this->user_id)
                ->orWhere('unit_id', $this->unit_id)
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
        $category_explode = explode('-',$request->complain_category_id);

        $input['complain_category_id'] = $category_explode[0];
        $input['unit_id'] = $category_explode[1];


        $input['user_emp_id'] = $pengadu;

        //create new record

        $aduan_category_exception_value = array('5','6');

        if(in_array($request->complain_category_id,$aduan_category_exception_value))
        {
            $input['lokasi_id'] = null;
            $input['ict_no'] = null;
        }

//       save
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
//       $complain_actions=Complain::find($id)->complain_action_fk()->orderBy('id','desc')->get();
        $complain_actions=$this->get_complain_actions($id);

        //complain sources list/dropdown
        $complain_sources = $this->get_complain_sources();
        //complain location list/dropdown
        $location_filter = array('branch_id'=>$complain->branch_id);
        $locations = $this->get_locations($location_filter);
        //complain branch list/dropdown
        $branchs = $this->get_branch();
        //complain assets list/dropdown
        $assets = $this->get_assets();

        return view('complaints/edit',compact(  'complain',
                                                'complain_categories',
                                                'statuses',
                                                'units',
                                                'sources',
                                                'complain_actions',
                                                'branchs',
                                                'locations',
                                                'complain_sources',
                                                'assets'
                                             )
                    );
    }
    public function action($id)
    {
        //complain category list/dropdown
        $complain_categories = $this->get_complain_categories();
        $complain = Complain::find($id);
        $statuses = ComplainStatus::lists('description', 'status_id');
        $units = Unit::lists('butiran', 'kod');
        $complain_actions=$this->get_complain_actions($id);
        //complain sources list/dropdown
        $complain_sources = $this->get_complain_sources();
        //complain location list/dropdown
        $location_filter = array('branch_id'=>$complain->branch_id);
        $locations = $this->get_locations($location_filter);
        //complain branch list/dropdown
        $branchs = $this->get_branch();
        //complain assets list/dropdown
        $assets = $this->get_assets();
//        $sources=ComplainSource::lists('source_description', 'source_id');
        return view('complaints/action',compact('complain',
                                                'complain_categories',
                                                'statuses',
                                                'units',
                                                'sources',
                                                'complain_actions',
                                                'complain_actions',
                                                'branchs',
                                                'locations',
                                                'complain_sources',
                                                'assets'
                                            ));
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
        //udate record
        $complain = complain::find($id);
        $category_explode = explode('-',$request->complain_category_id);

        $input['complain_category_id'] = $category_explode[0];
        $input['unit_id'] = $category_explode[1];

        $complain->fill($input);
        //save
        $complain->save();

        //after success, message and route to index
        Flash::success('Berjaya dikemaskinikan');

        return back();
    }
    public function verify(Request $request, $id)
    {
        $complain = Complain::find($id);
        if($request->submit_type=='finish')
        {
            $complain->complain_status_id=5;
        }
        elseif($request->submit_type=='reject') {
            $complain->complain_status_id=2;
        }
        /*
         * start save complain
         * */
        //udate record
        $request['verify_emp_id'] = $this->user_id;
        $request['verify_date'] = date("Y-m-d H:i:s");
//        //save
        $complain->update($request->all());
        /*
         * End save complain
         * */

        //insert into complain_action as log
        $complain_action = new ComplainAction;

        $complain_action ->complain_id=$id;
        $complain_action ->user_emp_id=$this->user_id;
        $complain_action ->user_comment=$request->user_comment;
        $complain_action ->verify_date=date("Y-m-d H:i:s");

        $complain_action->save();
        //after success, route to index
        return back();
    }
    /*
     * Helpdesk update action
     * */
    public function update_action(ComplainRequest $request, $id)
    {
        //udate record
        $complain = Complain::find($id);

        $request['action_date'] = date("Y-m-d H:i:s");
        
        if ($request->submit_type=='finish')
        {
            $request['complain_status_id'] =5;
        }
        else
        {
            $request['complain_status_id'] = $request->complain_status_id;
        }

        if($request['complain_status_id']==7)
        {
            $request['assign_date']= date("Y-m-d H:i:s");
        }
//       save
        $complain->fill($request->all());
//        $complain->update($input);
        $complain->update($request->all());

        //insert into complain_action as log
        $complain_action = new ComplainAction;

        $complain_action ->complain_id=$id;
        $complain_action ->action_by=$this->user_id;
        $complain_action ->action_comment=$request->action_comment;
        $complain_action ->delay_reason=$request->helpdesk_delay_reason;
        $complain_action ->complain_status_id=$request['complain_status_id'];

        $complain_action->save();

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
        //delete record
        $complain = Complain::find($id);
        $complain->delete();

        //after success, route to index
        return back();
    }
    public function assign()
    {
        $complains = Complain::where('unit_id', $this->unit_id)
            ->Where('complain_status_id', 7)
            ->orderBy('complain_id','desc')
            ->paginate(15);

        return view('complaints/assign_index', compact('complains'));
    }

    public function assign_staff($id)
    {
        //paparkan maklumat complain
        $complain = Complain::find($id);
        //paparkan juga log tindakan
        $complain_actions=$this->get_complain_actions($id);
        //dapat senarai staff unit yg sama
        $unit_staff_list = User::where('unit_id',$this->unit_id)
            ->where('emp_id','!=',$this->user_id)
            ->lists('name','emp_id');

        $unit_staff_list = array(''=>'Pilih Staff')+$unit_staff_list->all();

        //Senarai tugasan staff unit
        $unit_staff_tasks = Complain::where('unit_id',$this->unit_id)
                                    ->where('complain_status_id','=',2)
                                    ->orderBy('action_emp_id','asc');

        //load the view and pass the variable using compact
        return view('complaints/assign_staff',compact('complain',
            'complain_actions',
            'unit_staff_list',
            'unit_staff_tasks'));
    }
    public function update_assign_staff(Request $request, $id)
    {
        //paparkan maklumat complain
        $complain = Complain::find($id);
        //paparkan juga log tindakan
        $input['action_emp_id'] = $request->action_emp_id;
        $input['complain_status_id'] = 2;
        $input['assign_date'] = date("Y-m-d H:i:s");

        $complain->fill($input);
        //save
        $complain->save();

        //insert into complain_action as log
        $complain_action = new ComplainAction;

        $complain_action ->complain_id=$id;
        $complain_action ->action_by=$this->user_id;
        $complain_action ->complain_status_id='7';

        $complain_action->save();

        Flash::success('Aduan telah diagihkan kepada kakitangan.');
        
        return back();
    }

    //get data
    public function get_complain_categories (){

        $complain_categories = ComplainCategory::select('description',
                                DB::raw('category_id||\'-\'|| kod_unit AS category_value'))
                                ->lists('description','category_value');
        $complain_categories = array(''=>'Pilih Kategori')+$complain_categories ->all();

        return $complain_categories;
    }
    function get_complain_sources (){

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
        if (isset($filter['branch_id'])&& !empty($filter['branch_id']))
        {
            $branch_id = $filter['branch_id'];
        }
        //check for AJAX request filter by branch_id
        if ($this->request->has('branch_id'))
        {
            $branch_id = $this->request->input('branch_id');
        }
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

    public function get_assets_dummy()
    {
        $assets = array(''=>'Sila pilih aset ICT','1'=>'PC','2'=>'Laptop','3'=>'Projector' );

        return $assets;
    }

//    public function get_assets_dummy (){
    public function get_assets (){
        $lokasi_id= $this->request->lokasi_id;
        if (!empty($lokasi_id))
        {
        $assets =Asset::lists('butiran', 'ict_no')
                ->where('lokasi_id',$lokasi_id)
                ->lists('AssetIctno', 'ict_no');       }
        else
        {
//        $assets =Asset::lists('butiran', 'ict_no');
            $assets = Asset::select('ict_no', DB::raw('ict_no||\'-\'|| butiran AS aset_value'))
                    ->lists('aset_value','ict_no');
        }

        $assets = array(''=>'Pilih Aset') + $assets->all();
        return $assets;
    }
    public function get_branch (){
        $branchs= Branch::lists('branch_description','id');
        $branchs = array(''=>'Pilih cawangan') + $branchs->all();
        return $branchs;
    }

    public function get_complain_actions($id){

        $complain_actions=Complain::find($id)->complain_action_fk()->orderBy('id','desc')->get();
        return $complain_actions;
    }

}
