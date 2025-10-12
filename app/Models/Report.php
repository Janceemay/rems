<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Report extends Model
{
    use HasFactory;

    protected $primaryKey = 'report_id';
    protected $fillable = [
        'generated_by',
        'report_type',
        'report_format',
        'file_path',
        'period_start',
        'period_end',
        'date_generated',
        'remarks'
    ];

    protected $dates = ['date_generated', 'period_start', 'period_end'];

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by', 'user_id');
    }

    public function getReportTypeLabelAttribute()
    {
        return match ($this->report_type) {
            'sales_summary' => 'Sales Summary Report',
            'property_inventory' => 'Property Inventory Report',
            'client_payment' => 'Client Payment Report',
            'agent_performance' => 'Agent Performance Report',
            'team_performance' => 'Team Performance Report',
            'commission_summary' => 'Commission Summary Report',
            'financial_overview' => 'Financial Overview',
            default => ucfirst(str_replace('_', ' ', $this->report_type ?? 'General Report')),
        };
    }

    public function getReportFormatLabelAttribute()
    {
        return strtoupper($this->report_format ?? 'PDF');
    }

    public function getDownloadUrlAttribute()
    {
        if (!$this->file_path) return null;
        return asset('storage/' . ltrim($this->file_path, '/'));
    }

    public function getFormattedDateGeneratedAttribute()
    {
        return $this->date_generated
            ? Carbon::parse($this->date_generated)->format('M d, Y h:i A')
            : '—';
    }

    public function getPeriodLabelAttribute()
    {
        if (!$this->period_start || !$this->period_end) return 'N/A';
        $start = Carbon::parse($this->period_start)->format('M d, Y');
        $end = Carbon::parse($this->period_end)->format('M d, Y');
        return "{$start} - {$end}";
    }

    protected static function booted()
    {
        static::creating(function ($report) {
            if (!$report->date_generated) {
                $report->date_generated = now();
            }
        });
    }
}
