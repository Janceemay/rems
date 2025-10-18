<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\{Report, Transaction, Property, User, AuditLog};
use Dompdf\Dompdf;
use Dompdf\Options;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class ReportController extends Controller {
    public function index() {
        $this->authorizeRoles(['Admin', 'Sales Manager']);
        $reports = Report::with('generatedBy')->latest()->paginate(20);

        return view('reports.index', compact('reports'));
    }

    public function generate(Request $request) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        $data = $request->validate([
            'type' => 'required|string|in:sales,agents,properties,commissions',
            'format' => 'required|string|in:pdf,csv',
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date|after_or_equal:period_start',
        ]);

        $type = $data['type'];
        $format = $data['format'];
        $periodStart = $data['period_start'] ?? now()->subMonth();
        $periodEnd = $data['period_end'] ?? now();

        switch ($type) {
            case 'sales':
                $records = Transaction::with('property', 'client.user', 'agent')
                    ->whereBetween('created_at', [$periodStart, $periodEnd])
                    ->get();
                $title = 'Sales Report';
                break;

            case 'agents':
                $records = User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))
                    ->withCount('transactions')
                    ->get();
                $title = 'Agent Performance Report';
                break;

            case 'properties':
                $records = Property::with('developer')->get();
                $title = 'Property Listings Report';
                break;

            case 'commissions':
                $records = \App\Models\Commission::with('agent', 'transaction.property')->get();
                $title = 'Commission Report';
                break;

            default:
                return back()->withErrors(['type' => 'Invalid report type selected.']);
        }

        $fileName = strtolower($type) . '_report_' . now()->format('Ymd_His');

        if ($format === 'pdf') {
            $filePath = $this->generatePDF($records, $title, $fileName);
        } else {
            $filePath = $this->generateCSV($records, $fileName);
        }

        $report = Report::create([
            'generated_by' => Auth::id(),
            'report_type' => $type,
            'report_format' => strtoupper($format),
            'file_path' => $filePath,
            'date_generated' => now(),
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'generate',
            'target_table' => 'reports',
            'target_id' => $report->report_id,
            'remarks' => "Generated {$type} report ({$format})",
        ]);

        return redirect()->route('reports.index')->with('success', ucfirst($type) . " report generated successfully!");
    }

    private function generatePDF($records, $title, $fileName) {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        if (view()->exists('reports.templates.pdf')) {
            $html = view('reports.templates.pdf', compact('records', 'title'))->render();
        } else {
            $html = '<!doctype html><html><head><meta charset="utf-8"><style>body{font-family:Arial,Helvetica,sans-serif}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ddd;padding:8px;text-align:left}th{background:#f4f4f4}</style></head><body>';
            $html .= '<h1>' . htmlspecialchars($title) . '</h1>';

            if ($records instanceof \Illuminate\Support\Collection && $records->isNotEmpty()) {
                $first = $records->first()->toArray();
                $headers = array_keys($first);

                $html .= '<table><thead><tr>';
                foreach ($headers as $h) {
                    $html .= '<th>' . htmlspecialchars($h) . '</th>';
                }
                $html .= '</tr></thead><tbody>';

                foreach ($records as $record) {
                    $row = $record->toArray();
                    $html .= '<tr>';
                    foreach ($headers as $h) {
                        $val = data_get($row, $h);
                        if (is_array($val) || is_object($val)) {
                            $cell = json_encode($val);
                        } else {
                            $cell = (string) $val;
                        }
                        $html .= '<td>' . htmlspecialchars($cell) . '</td>';
                    }
                    $html .= '</tr>';
                }

                $html .= '</tbody></table>';
            } else {
                $html .= '<p>No records found for the selected period.</p>';
            }

            $html .= '</body></html>';
        }

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfPath = "reports/{$fileName}.pdf";
        Storage::put("public/{$pdfPath}", $dompdf->output());

        return "/storage/{$pdfPath}";
    }

    private function generateCSV($records, $fileName) {
        $csvData = '';
        if ($records->isNotEmpty()) {
            $csvData .= implode(',', array_keys($records->first()->toArray())) . "\n";
            foreach ($records as $record) {
                $csvData .= implode(',', array_map(fn($v) => '"' . $v . '"', $record->toArray())) . "\n";
            }
        }

        $csvPath = "reports/{$fileName}.csv";
        Storage::put("public/{$csvPath}", $csvData);

        return "/storage/{$csvPath}";
    }

    public function download(Report $report) {
        $this->authorizeRoles(['Admin', 'Sales Manager']);

        if (!Storage::exists('public/' . ltrim($report->file_path, '/storage/'))) {
            return back()->withErrors(['file' => 'Report file not found.']);
        }

        return response()->download(storage_path('app/public/' . ltrim($report->file_path, '/storage/')));
    }

    private function authorizeRoles(array $roles) {
        $roleName = optional(Auth::user()->role)->role_name;
        if (!in_array($roleName, $roles)) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function exportTransactions(Request $request)
    {
        $format = $request->input('format', 'xlsx');
        $fileName = 'transactions_report_' . now()->format('Y_m_d_His') . '.' . $format;

        Report::create([
            'type' => 'Transactions',
            'period' => now()->format('Y-m-d'),
            'file_path' => 'exports/' . $fileName,
            'generated_by' => Auth::id(),
        ]);

        return Excel::download(new TransactionsExport, $fileName);
    }
}
