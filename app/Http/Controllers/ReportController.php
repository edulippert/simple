<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\CustomerGuarantee;
use App\Finish;
use App\Guarantee;
use App\MaintenanceProgram;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function rel_attendances(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $condominium_id = $request->condominium_id;
        $is_finalized = $request->is_finalized; 

        if ($start_date > $end_date) {
            $message_error = ['message' => ['A data inicial tem que ser menor que a data final']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $message_error],422);
        }

        if ($start_date==null || $end_date == null) {
            $message_error = ['message' => ['As datas sao obrigatorias']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $message_error],422);
        }


        if (!$condominium_id) {
            $message_error = ['message' => ['Condominio tem que ser diferente de nulo']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $message_error],422);
        }

        

        $detail = Attendance::buildReportDetail($start_date,$end_date,$condominium_id,$is_finalized);    
        $total = Attendance::buildReportTotal($start_date,$end_date,$condominium_id,$is_finalized);

        return [
            'detail' => $detail,
            'total' => $total
        ];

    }

    public function rel_finishes(Request $request)
    {
        $condominium_id = $request->condominium_id;

        if (!$condominium_id) {
            $message_error = ['message' => ['Condominio tem que ser diferente de nulo']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $message_error],422);
        }

        return Finish::buildFinishesResponse($condominium_id);

    }

    public function rel_maintenances(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $condominium_id = $request->condominium_id;

        if ($start_date > $end_date) {
            $message_error = ['message' => ['A data inicial tem que ser menor que a data final']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $message_error],422);
        }

        if ($start_date==null || $end_date == null) {
            $message_error = ['message' => ['As datas sao obrigatorias']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $message_error],422);
        }


        if (!$condominium_id) {
            $message_error = ['message' => ['Condominio tem que ser diferente de nulo']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $message_error],422);
        }

        return MaintenanceProgram::buildReportDetail($start_date,$end_date,$condominium_id);

    }

    public function rel_garantias(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $condominium_id = $request->condominium_id;

        if ($start_date > $end_date) {
            $message_error = ['message' => ['A data inicial tem que ser menor que a data final']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $message_error],422);
        }

        if ($start_date==null || $end_date == null) {
            $message_error = ['message' => ['As datas sao obrigatorias']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $message_error],422);
        }


        if (!$condominium_id) {
            $message_error = ['message' => ['Condominio tem que ser diferente de nulo']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $message_error],422);
        }

       // return CustomerGuarantee::

    }
}
