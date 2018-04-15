<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function getDashboard(){
        $total_employee = \App\Employee::where('unit_id', Auth::user()->unit_id())->count();
        $total_demand = \App\Demand::count();
        $total_demand_approval = \App\DemandApproval::count();
        $total_demand_distribution = \App\DistributionMain::count();
        return view('dashboard', compact('total_employee','total_demand', 'total_demand_approval', 'total_demand_distribution'));
    }
}
