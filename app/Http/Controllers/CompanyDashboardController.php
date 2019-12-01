<?php

namespace App\Http\Controllers;

use App\Attendance;
use Carbon\Carbon;
use App\MaintenanceProgram;
use Illuminate\Http\Request;

class CompanyDashboardController extends Controller
{
    public function buildDashboard(Request $request)
    {

        $month = null;
        $year = null;

        $now = Carbon::now();

        if ($request->month) {
            $month = $request->month;
        }else{
            $month = $now->month;
        }

        if ($request->year) {
            $year= $request->year;
        }else{
            $year= $now->year;
        }

        return [
            'condominiums_percents' => $this->buildCondominiumsMaintenancesPercent($request->company_id,$month,$year),
            'attendance_graph' => $this->buildAttendanceGraph($request->company_id,$month,$year)
        ];

    }

    private function buildCondominiumsMaintenancesPercent($company_id,$month,$year)
    {
        return MaintenanceProgram::buildCompanyCondominiumsGroupedByMaintenancesPercent($company_id,$month,$year);
    }

    private function buildAttendanceGraph($company_id,$month,$year)
    {
        return Attendance::buildAttendanceGraphResponse($company_id,$month,$year);
    }
}
