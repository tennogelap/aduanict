<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ComplainCategory;
use App\Branch;
use Carbon\Carbon;
use App\Complain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportController extends BaseController
{
    /*MAIN function*/
    public function __construct(Request $request)
    {
        parent::__construct();      //panggil _construct kat BaseController
        $this->middleware('ReportPermission');

        $this->request = $request;
    }

    //paparan bilangan aduan mingikut tarikh
    public function monthly_statistic_aduan_ict()
    {
        $get_startdate_enddate = $this->get_startdate_enddate();
        $start_date = $get_startdate_enddate['start_date'];
        $end_date = $get_startdate_enddate['end_date'];

        $complain_category_id= $this->request->complain_category_id;
        $branch = $this->request->branch;

        $complains=Complain::whereBetween('created_at',array($start_date,$end_date));

        if(!empty($complain_category_id))
        {
            $exp_complain_category_id = explode('-',$complain_category_id);
            $complain_category_id = $exp_complain_category_id[0];
            $complains = $complains->where('complain_category_id',$complain_category_id);
        }
        if(!empty($branch))
        {
//                    $complains = $complains->where('complain_category_id',$complain_category_id);
        }

        $complains = $complains->orderBy('created_at')
                ->get()
                ->groupBy(function($date) {
                      return Carbon::parse($date->created_at)->format('M'); // grouping by months
                  });

        $monthly_total = [];
        $month_name = [];

        foreach ($complains as $key => $complain)
        {
            $month_name[] = $key;
            $monthly_total[] = $complain->count();
        }
//        dd($complains);
        $monthly_total = json_encode($monthly_total);
        $month_name = json_encode($month_name);
        $complain_categories = $this->get_complain_categories();
        $branchs = $this->get_branch();

      return view('reports.monthly_statistic_aduan_ict',
          compact('complains','monthly_total','month_name','start_date','end_date','complain_categories','branchs'));
    }

    public function monthly_statistic_table_aduanict()
    {
        $get_startdate_enddate = $this->get_startdate_enddate();
//        $start_date = $get_startdate_enddate['start_date'];
//        $end_date = $get_startdate_enddate['end_date'];

        $start_date=Carbon::createFromDate(null, 1, 1);
        $end_date=Carbon::createFromDate(null, 12, 31);

        $sql_query ="SELECT * FROM
                        (    SELECT     a.complain_category_id, C.description, TO_NUMBER(TO_CHAR(a.created_at,'MM')) GROUPMM, count(*) bil
                                   FROM v2_complains A ,   v2_complain_categories c
                                  WHERE a.created_at BETWEEN '2016-01-01' AND '2016-12-31'
                                    AND a.complain_category_id  =c.category_id
                               GROUP BY c.category_id                  ,c.description                         , A.complain_category_id,
                                    to_char(A.created_at,'YYYYMM'),to_number(to_char(A.created_at,'MM')) 
                               ORDER BY 1, 2
                        )
                        pivot (SUM(NVL(bil,0)) FOR groupmm IN (1 AS jan, 2 AS feb, 3 AS mac, 4 AS apr, 5 AS mei, 6 AS jun, 7 AS jul, 8 AS ogo, 9 AS sep, 10 AS okt, 11 AS nov, 12 AS dis))
                   ORDER BY LENGTH(complain_category_id),complain_category_id";


        $complains=DB::select(DB::raw($sql_query));

        if($this->request->submit_type!='downloadpdf')
        {
            return view('reports.monthly_statistic_table_aduanict', compact('complains'));
        }
        else
        {   //point to reports.pdf
            //return view('reports.pdf.monthly_statistic_table_aduanict_print', compact('complains'));
            $data = ['complains'=>$complains];
            $pdf = PDF::loadView('reports.pdf.monthly_statistic_table_aduanict_print', $data)->setPaper('a4', 'landscape');
            return $pdf->download('monthly_statistic_table_aduanict_print.pdf');
        }
    }
    
    public function get_startdate_enddate()
    {
        $start_date = $this->request->start_date;
        $end_date = $this->request->end_date;

        if(empty($start_date))
        {
            $current_year_start_date=Carbon::createFromDate(null, 1, 1);
            $start_date = $current_year_start_date;
        }
        else
        {
            $start_date=Carbon::parse($start_date)->format('Y-m-d');
        }
        if(empty($end_date))
        {
            $current_year_end_date=Carbon::createFromDate(null, 12, 31);
            $end_date = $current_year_end_date;
        }
        else
        {
            $end_date =Carbon::parse($end_date)->format('Y-m-d');
        }
        return ['start_date'=>$start_date,'end_date'=>$end_date];
    }
    public function get_complain_categories (){

        $complain_categories = ComplainCategory::select('description',
            DB::raw('category_id||\'-\'|| kod_unit AS category_value'))
            ->lists('description','category_value');
        $complain_categories = array(''=>'Pilih Kategori')+$complain_categories ->all();

        return $complain_categories;
    }
    public function get_branch (){
        $branchs= Branch::lists('branch_description','id');
        $branchs = array(''=>'Pilih cawangan') + $branchs->all();
        return $branchs;
    }
}
