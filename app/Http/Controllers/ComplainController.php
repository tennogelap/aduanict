<?php

namespace App\Http\Controllers;

use App\AssetsLocation;
use App\Branch;
use App\ComplainCategory;
use App\ComplainSource;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Complain;
use Validator;
use App\Http\Requests\ComplainRequest;
use Auth;
use App\User;
class ComplainController extends Controller
{
    /*MAIN function*/
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complains = Complain::paginate(15);
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

        return view('complaints/create',compact('users','complain_categories','complain_sources','locations','branchs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComplainRequest $request)
    {
//      dd($request->all());

        $aduan   = $request->COMPLAIN_DESCRIPTION;
        $login_daftar   = $request->REGISTER_EMP_ID;
        if (empty($login_daftar))
        {
            $login_daftar = Auth::user()->id;
        }
        //create new record
        $complain = new Complain();
        $complain->REGISTER_EMP_ID = Auth::user()->id;
        $complain->COMPLAIN_DESCRIPTION        = $aduan;
        $complain->REGISTER_EMP_ID = $login_daftar;

        //save
        $complain->save();

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
        return view('complaints/edit',compact('complain','complain_categories'));
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
//       dd($request->all());
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
    function get_assets (){
        $lokasi_id = \Request::input('lokasi_id');

        if (!empty($lokasi_id))
        {
            $assets= Assets::where('lokasi_id',$lokasi_id)->lists('ict_description','ict_no');
        }
        else
        {
            $assets= Assets::lists('ict_description','ict_no');
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
