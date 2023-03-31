<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;


class Controller extends BaseController
{
    
    protected $company_settings;
    public function  __construct(){
        $companyID=1; //take this from authentication
        $this->company_settings= DB::select("select * from companyprofiletable where companyID=? ", [$companyID]);
        View::share('company_settings', $this->company_settings);
    }

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
