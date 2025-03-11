<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
class ClientReportsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Fetch data
            $reports = DB::table('reports')
                ->select('id', 'name', 'email', 'subject', 'message', 'created_at')
                ->get();

            // Convert data to proper format
            $data = [];
            foreach ($reports as $report) {
                $data[] = [
                    'action' => '<button class="btn btn-danger delete-review" data-id="' . Crypt::encryptString($report->id) . '">Delete</button>',
                    'name' => $report->name,
                    'email' => $report->email,
                    'subject' => $report->subject,
                    'message' => $report->message,
                    'date' => $report->created_at,
                ];
            }

            // Return JSON response
            return response()->json([
                "draw" => intval($request->draw),
                "recordsTotal" => count($data),
                "recordsFiltered" => count($data),
                "data" => $data,
            ]);
        }

        return view('admin.clientrep.index');
    }


}