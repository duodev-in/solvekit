<?php

namespace App\Services\SuperAdmin;

use App\Mail\ReportBugSubmitted;
use App\Models\BugReport;
use Illuminate\Support\Facades\Mail;

class ReportBugService
{
    public function create(array $data): BugReport
    {
        $report = BugReport::create($data);

        Mail::to(config('superadmin.mail_recipient'))->send(new ReportBugSubmitted($report));

        return $report;
    }

    public function updateStatus(BugReport $report, array $data): BugReport
    {
        $report->update($data);

        return $report->refresh();
    }
}
