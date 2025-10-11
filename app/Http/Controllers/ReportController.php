<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Dompdf\Dompdf;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('generatedBy')->paginate(20);
        return view('reports.index', compact('reports'));
    }

    public function generate(Request $request)
    {
        return back()->with('info','Report generation is not implemented in this scaffold. Implement using maatwebsite/excel or dompdf.');
    }
}
