<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use Entrust;
class ReportPermission
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

        //check permission untuk report graph statistik
        if($route_name=='reports.monthly_statistic_aduan_ict')
        {
            $this->check_entrust_permission('statistic_report_chart',$request);
        }
        //check permission untuk report table statistik
        if($route_name=='reports.monthly_statistic_table_aduanict')
        {
            $this->check_entrust_permission('statistic_report_table',$request);
        }

        return $next($request);
    }
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

}
