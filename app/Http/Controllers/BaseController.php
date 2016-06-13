<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\ComplainStatus;

class BaseController extends Controller
{
    public function __construct(Request $request)
    {

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
}
