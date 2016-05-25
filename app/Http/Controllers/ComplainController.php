<?php

namespace App\Http\Controllers;

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
    {
        $users = User::where('id','!=',Auth::user()->id)->lists('name','id');
        $users = array(''=>'Sila buat pilihan') + $users->all();
        return view('complaints/create',compact('users'));
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

        $aduan   = $request->ADUAN;
        $login_daftar   = $request->LOGIN_DAFTAR;
        if (empty($login_daftar))
        {
            $login_daftar = Auth::user()->id;
        }
        //create new record
        $complain = new Complain();
        $complain->EMP_ID_ADUAN = Auth::user()->id;
        $complain->ADUAN        = $aduan;
        $complain->LOGIN_DAFTAR = $login_daftar;

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
        $complain = Complain::find($id);
        return view('complaints/edit',compact('complain'));
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
        $butiran_aduan = $request->ADUAN;
        $butiran_tindakan = $request->TINDAKAN;
        //udate record
        $complain = Complain::find($id);
        $complain->ADUAN = $butiran_aduan;
        $complain->TINDAKAN = $butiran_tindakan;

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
}
