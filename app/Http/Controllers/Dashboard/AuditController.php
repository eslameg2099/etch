<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audit;

class AuditController extends Controller
{
    public function index()
    {
        $audits = Audit::filter()->paginate();
        return view('dashboard.audits.index',compact('audits'));
    }
}
