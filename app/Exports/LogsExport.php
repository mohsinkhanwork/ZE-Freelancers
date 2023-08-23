<?php

namespace App\Exports;

use App\Models\TimeLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LogsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Fetch all logs and then map each log to transform the data format as needed
        return TimeLog::where('user_id', $this->userId)->get()->map(function ($log) {
            return [
                'start_time'       => substr($log->start_time, 11, 8), // Assuming start_time is a datetime string
                'end_time'         => substr($log->end_time, 11, 8),   // Assuming end_time is a datetime string
                'description'      => $log->description,
                'duration'         => $log->duration,                  // Assuming you have a duration column
                'created_at'       => $log->created_at->format('l, j F Y'), // Formatting the date
                'status'           => $log->status
            ];
        });
    }

    /**
     * Define the headers for the exported Excel file
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Start Time (UTC)',
            'End Time (UTC)',
            'Project description',
            'Hours Logged (UTC)',
            'Date Log Created',
            'Status'
        ];
    }
}
