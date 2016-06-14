<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use Entrust;
use App\Complain;
use Auth;

class ComplainPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //disable middleware if unit testing
        /*if (env('APP_ENV') === 'testing') {
            return $next($request);
        }*/

        $route_name = Route::currentRouteName();
        $route_parameters = $request->route()->parameters();
        //check permission untuk tambah aduan
        if($route_name=='complain.create' || $route_name=='complain.store')
        {
            $this->check_entrust_permission('create_complain',$request);
        }
        //check permission untuk edit aduan
        if($route_name=='complain.edit' || $route_name=='complain.update')
        {
            $this->check_entrust_permission('edit_complain',$request);
            $complain_id = $route_parameters['complain'];
            $complain = Complain::find($complain_id);
            //edit only by pengadu or bagi pihak
            if ($complain->complain_status_id==1)
            {
                if (Auth::user()->emp_id!=$complain->register_user_id
                    && Auth::user()->emp_id!=$complain->user_emp_id )
                {
                    $this->access_denied($request);
                }
            }
            elseif ($complain->complain_status_id==2)
            {
                if (Auth::user()->emp_id!=$complain->action_emp_id )
                {
                    $this->access_denied($request);
                }
            }

        }
        //check permission untuk delete aduan
        if($route_name=='complain.destroy')
        {
            $this->check_entrust_permission('delete_complain',$request);
        }
        //check permission untuk edit aduan oleh helpdesk
        if($route_name=='complain.action' || $route_name=='complain.update_action')
        {
            $this->check_entrust_permission('create_complain',$request);
        }
        //check permission untuk teknikal update aduan
        if($route_name=='complain.technical_action' || $route_name=='complain.update_technical_action')
        {
            $this->check_entrust_permission('technical_action_complain',$request);
            $complain_id = $route_parameters['complain'];
            $complain = Complain::find($complain_id);
            //edit only by pengadu or bagi pihak

            if (($complain->register_user_id==Auth::user()->emp_id || $complain->user_emp_id==Auth::user()->emp_id)
            && ($complain->action_emp_id!=Auth::user()->emp_id))
            {
                $this->access_denied($request);
            }

        }
        //check permission untuk agih aduan
        if($route_name=='complain.assign_staff' || $route_name=='complain.update_assign_staff')
        {
            $this->check_entrust_permission('assign_technical_staff',$request);
        }
        //check permission untuk pengesahan pengadu bhw aduan selesai
        if($route_name=='complain.verify')
        {
            $this->check_entrust_permission('verify_complain_action',$request);
            $complain_id = $route_parameters['complain'];
            $complain = Complain::find($complain_id);
            //edit only by pengadu or bagi pihak

            if (Auth::user()->emp_id!=$complain->register_user_id
                && Auth::user()->emp_id!=$complain->user_emp_id )
            {
                $this->access_denied($request);
            }

        }

        return $next($request);
    }

    //check guna Entrust (role)
    function check_entrust_permission($permission_name,$request)
    {
        if (!Entrust::can($permission_name))
        {
            if ($request->ajax()||$request->wantsJson())
            {
                return response('Unauthorised.',401);
            }
            else
            {
                abort(403,'Accessed Denied');
            }
        }
    }

    //check untuk guna normal permission
    function access_denied ($request)
    {
        if ($request->ajax()||$request->wantsJson())
        {
            return response('Unauthorised.',401);
        }
        else
        {
            abort(403,'Accessed Denied');
        }
    }
}
