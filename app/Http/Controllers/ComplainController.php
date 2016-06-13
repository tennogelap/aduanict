<?php

namespace App\Http\Controllers;


use App\ComplainAction;

use App\ComplainStatus;
use App\ComplainAttachment;
use App\Events\ComplainCreatedEvent;
use App\Events\ComplainHelpdeskActionEvent;
use App\Events\ComplainUserVerifyEvent;
use Event;
use App\Unit;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Complain;
use Validator;
use App\Http\Requests\ComplainRequest;
use Auth;
use App\User;
use Entrust;
use Flash;
use App\Helpers\CustomHelper;
class ComplainController extends BaseController
{
    /*MAIN function*/
    public function __construct(Request $request)
    {
        parent::__construct();      //panggil _construct kat BaseController

        $this->middleware('ComplainPermission');
        //guna utk function yg tiada request
        $this->request = $request;  //
    }
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Entrust::hasRole('members')||Entrust::hasRole('unit_manager'))
        {
            /*
             * show by
             * 1. REGISTER_USER_ID
             * 2. USER_EMP_ID
             * 3. ACTION_EMP_ID*/

            $complains = Complain::with('user_fk','employeeR_fk','employeeU_fk',
                'branch_fk','complain_action_fk','assets_location_fk','asset_fk',
                'verify_user_fk','action_user_fk','complain_unit_fk','complain_status_fk',
                'complain_category_fk','complain_source_fk','onBehalf_fk','regUser_fk')
                ->where(function($query)
                    { $query ->orWhere('action_emp_id', $this->user_id)
                        ->orWhere('register_user_id', $this->user_id)
                        ->orWhere('unit_id',$this->unit_id);
                    });
        }
        else
        {
            $complains = Complain::with('user_fk','employeeR_fk','employeeU_fk',
            'branch_fk','complain_action_fk','assets_location_fk','asset_fk',
            'verify_user_fk','action_user_fk','complain_unit_fk','complain_status_fk',
            'complain_category_fk','complain_source_fk','onBehalf_fk','regUser_fk');
        }
        if (!empty($this->request->complain_status_id))
        { //input dari search field
            $complains = $complains->where('complain_status_id',$this->request->complain_status_id);
        }
        if (!empty($this->request->search_anything))
        { //input dari search field
            $complains = Complain::where(function($query)
                { $query->orWhere('complain_description','like','%'.$this->request->search_anything.'%') ;
                });
        }
        if (!empty($this->request->aduan_id))
        { //input dari search field
            $complains = Complain::where(function($query)
                { $query->orWhere('complain_id', $this->request->aduan_id) ;
                });
        }
        if (!empty($this->request->start_date))
        { //input dari search field
            $start_date = $this->format_date($this->request->start_date);
            $complains = $complains->whereDate('created_at','>=',$start_date);
        }
        if (!empty($this->request->end_date))
        { //input dari search field
            $end_date = $this->format_date($this->request->end_date);
            $complains = $complains->whereDate('created_at','<=',$end_date);
        }

        $complains = $complains->orderBy('complain_id','desc')->paginate(15);
        $get_statuses = $this->get_complain_statuses();
        return view('complaints/index', compact('complains','get_statuses'));
    }

        /**Show the form for creating a new resource. @return \Illuminate\Http\Response*/
    public function create()
    {   //user list/dropdown
        $users = $this->get_users();
        //complain category list/dropdown
        $complain_categories = $this->get_complain_categories();
        //complain sources list/dropdown
        $complain_sources = $this->get_complain_sources();
        //complain branch list/dropdown
        $branches = $this->get_branches();
        //complain location list/dropdown
        $locations = $this->get_locations();
        //complain assets list/dropdown
        $assets = $this->get_assets();

        return view('complaints/create',compact('users','complain_categories','complain_sources','locations','branches','assets'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComplainRequest $request)
    {
//      Start check if Bagi Pihak is null, assign user login as bagi pihak
        $pengadu   = $request->input('user_emp_id');
        if (empty($pengadu))
        {
            $pengadu = Auth::user()->emp_id;
        }
//        End

        $input = $request->all();
        $category_explode = explode('-',$request->complain_category_id);

        $input['complain_category_id'] = $category_explode[0];
        $input['unit_id'] = $category_explode[1];


        $input['user_emp_id'] = $pengadu;

        //create new record
        if(in_array($input['complain_category_id'],$this->exclude_array))
        {
            $input['lokasi_id'] = null;
            $input['ict_no'] = null;
        }

//       save
        $complain = Complain::create($input); // alternative save

        //chk if has file attachment
        if($request->hasFile('complain_attachment') && $request->file('complain_attachment')->isValid())
        {   //rename file to make it unique
            $fileName = $complain->complain_id.'-'.$request->file('complain_attachment')->getClientOriginalName();
            //set destination path
            $destinationPath = base_path().'/public/uploads/';
            //move/upload file
            $request->file('complain_attachment')->move($destinationPath, $fileName);

            $complain_attachment = new ComplainAttachment();
            $complain_attachment->attachable_id=$complain->complain_id;
            $complain_attachment->attachable_type='App\Complain';
            $complain_attachment->attachment_filename=$fileName;
            $complain_attachment->created_at=date("Y-m-d H:i:s");

            $complain_attachment->save();
        }

        //hantar email guna event
        Event::fire(new ComplainCreatedEvent($complain));

        //after success, route to index
        if($request->ajax())
        {
            return response()->json(array('flag'=>'Tahniah',
                                          'message'=>'Aduan berjaya dihantar',
                                          'result'=>'success',
                                          'redirect'=>url('complain')
            ));
        }
        else
        {
            Flash::success('Aduan berjaya dihantar');
            return redirect(route('complain.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //complain category list/dropdown
        $complain = Complain::find($id);
        $complain_actions=$this->get_complain_actions($id);

        return view('complaints/show',compact(  'complain','complain_actions'));
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
        $complain_actions=$this->get_complain_actions($id);

        //complain sources list/dropdown
        $complain_sources = $this->get_complain_sources();

        $get_branches_locations_assets = $this->prepare_branch_location_asset($complain);

        $branches = $get_branches_locations_assets['branches'];
        $locations = $get_branches_locations_assets['locations'];
        $assets = $get_branches_locations_assets['assets'];
        $hide_branches_locations_assets = $get_branches_locations_assets['hide_branches_locations_assets'];
        return view('complaints/edit',compact(  'complain',
                                                'complain_categories',
                                                'statuses',
                                                'units',
                                                'sources',
                                                'complain_actions',
                                                'branches',
                                                'locations',
                                                'complain_sources',
                                                'assets',
                                                'hide_branches_locations_assets'
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
        $branches = $this->get_branches();
        //complain assets list/dropdown
//        $get_branches_locations_assets = $this->prepare_branch_location_asset($complain);
        $complain_lokasi_id = $complain->lokasi_id;
        $assets_filter = ['lokasi_id'=>$complain_lokasi_id];
        $assets = $this->get_assets($assets_filter);
        $hide_branches_locations_assets = 'N';

        return view('complaints/action',compact('complain',
                                                'complain_categories',
                                                'statuses',
                                                'units',
                                                'sources',
                                                'complain_actions',
                                                'complain_actions',
                                                'branches',
                                                'locations',
                                                'complain_sources',
                                                'assets',
                                                'hide_branches_locations_assets'
                                            ));
    }

    public function technical_action($id)
    {
        //complain category list/dropdown
        $complain_categories = $this->get_complain_categories();
        $complain = Complain::find($id);
        //status 'Tindakan' @ 'Sahkan (P)' sahaja
        $statuses = ComplainStatus::where('status_id','2')
                                    ->orWhere('status_id','3')
                                    ->lists('description', 'status_id');

        $units = Unit::lists('butiran', 'kod');
        $complain_actions=$this->get_complain_actions($id);
        //complain sources list/dropdown
        $complain_sources = $this->get_complain_sources();
        //complain location list/dropdown
        $location_filter = array('branch_id'=>$complain->branch_id);
        $locations = $this->get_locations($location_filter);
        //complain branch list/dropdown
        $branches = $this->get_branches();
        //complain assets list/dropdown
        $complain_lokasi_id = $complain->lokasi_id;
        $assets_filter = ['lokasi_id'=>$complain_lokasi_id];
        $assets = $this->get_assets($assets_filter);
//        $hide_branches_locations_assets = $get_branches_locations_assets['hide_branches_locations_assets'];

        return view('complaints/technical_action',compact('complain',
            'complain_categories',
            'statuses',
            'units',
            'sources',
            'complain_actions',
            'complain_actions',
            'branches',
            'locations',
            'complain_sources',
            'assets'
//            ,'hide_branches_locations_assets'
        ));
    }

    /*
  * Technical action update
  * */
    public function update_technical_action(Request $request, $id)
    {
        //update record
        $complain = Complain::find($id);

        $request['action_date'] = date("Y-m-d H:i:s");

        $request['complain_status_id'] = $request->complain_status_id;
        $request['delay_reason'] = $request->delay_reason;
        $request['action_comment'] = $request->action_comment;

//       save
        $complain->fill($request->all());

        $complain->update($request->all());

        //insert into complain_action as log
        if($request['complain_status_id']==3) {
            $complain_action = new ComplainAction;

            $complain_action->complain_id = $id;
            $complain_action->action_by = $this->user_id;
            $complain_action->action_comment = $request->action_comment;
            $complain_action->delay_reason = $request->delay_reason;
            $complain_action->complain_status_id = $request->complain_status_id;

            $complain_action->save();
        }

        if($request['complain_status_id']==2)
        {
            Flash::success('Aduan berjaya dikemaskini');
        }
        elseif($request['complain_status_id']==3)
        {
            Flash::success('Aduan berjaya dihantar untuk pengesahan pengadu');
        }
        //after success, route to index
        //return back();
        return redirect(route('complain.show',$id));
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
        $complain = complain::find($id);
        if ($request->has('complain_category_id')) {
            //udate record
            $category_explode = explode('-', $request->complain_category_id);

            $input['complain_category_id'] = $category_explode[0];
            $input['unit_id'] = $category_explode[1];
        }

        if (!in_array($complain->complain_category_id, $this->exclude_array))
        {
            $input['branch_id'] = $request->branch_id;
            $input['lokasi_id'] = $request->lokasi_id;
            $input['ict_no'] = $request->ict_no;
        }
        $complain->fill($input);
        //save
        $complain->save();

        //after success, message and route to index
        Flash::success('Berjaya dikemaskinikan');

        return back();
    }
    public function verify(ComplainRequest $request, $id)
    {
        $complain = Complain::find($id);
        $complain_action = new ComplainAction;
        $complain_action ->complain_status_id = $complain->complain_status_id;

        if($request->submit_type=='finish')
        {
            $complain->complain_status_id=4;
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


        $complain_action ->complain_id=$id;
        $complain_action ->user_emp_id=$this->user_id;
        $complain_action ->user_comment=$request->user_comment;
        $complain_action ->verify_date=date("Y-m-d H:i:s");

        $complain_action->save();
        //after success, route to index

        //kalau helpdesk update action assign, event send email kepada Unit manager
        Event::fire(new ComplainUserVerifyEvent($complain));
        return redirect(route('complain.show',$id));
    }
    /*
     * Helpdesk update action
     * */
    public function update_action(ComplainRequest $request, $id)
    {
        //udate record
        $complain = Complain::find($id);
        $complain_action = new ComplainAction;
        $complain_action->complain_status_id = $complain->complain_status_id;

        $request['action_date'] = date("Y-m-d H:i:s");

        if ($request->submit_type=='finish')
        {
            $request['complain_status_id'] =5;
        }
        else
        {
            $request['complain_status_id'] = $request->complain_status_id;
            if($request->complain_status_id==3)
            {
                $request['action_emp_id'] =$this->user_id;
            }
        }

        if($request['complain_status_id']==7)
        {
            $request['assign_date']= date("Y-m-d H:i:s");
        }
//       save
        $complain->fill($request->all());
        $complain->update($request->all());

        //insert into complain_action as log
        if($complain->complain_status_id>1)
        {

            $complain_action->complain_id = $id;
            $complain_action->action_by = $this->user_id;
            $complain_action->action_comment = $request->action_comment;
            $complain_action->delay_reason = $request->helpdesk_delay_reason;

            $complain_action->save();
        }

        //kalau helpdesk update action assign, event send email kepada Unit manager
        Event::fire(new ComplainHelpdeskActionEvent($complain));

        //after success, route to index
        return redirect(route('complain.show',$id));
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
}
