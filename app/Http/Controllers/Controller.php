<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Audit;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function __construct(Request $request)
    {
        View::share('request', $request);
    }
    
    public function auditAdd(Request $request, $params)
    {
            Audit::create(
                [
                    'type' => $params['type'],
                    'user_id' => $params['user_id'],
                    'company_id' => $params['company_id'],
                    'details' => $params['details'],
                ]
            );
    }
}
