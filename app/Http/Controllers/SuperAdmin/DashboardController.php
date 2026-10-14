<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\BugReport;
use App\Models\FeatureRequest;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('superadmin.dashboard', [
            'userCount' => User::count(),
            'activeUserCount' => User::where('status', 'active')->count(),
            'openBugCount' => BugReport::where('status', 'open')->count(),
            'featureRequestCount' => FeatureRequest::count(),
            'reviewFeatureRequestCount' => FeatureRequest::whereIn('status', ['submitted', 'reviewing', 'planned', 'in_progress'])->count(),
            'recentAuditLogs' => AuditLog::with('user')->latest()->take(6)->get(),
        ]);
    }
}
