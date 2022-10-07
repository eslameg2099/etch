<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ReportRequest;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::filter()->paginate();

        return view('dashboard.reports.index', compact('reports'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        return view('dashboard.reports.show', compact('report'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Report $report
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Report $report)
    {
        $report->delete();

        flash()->success(trans('reports.messages.deleted'));

        return redirect()->route('dashboard.reports.index');
    }

    /**
     * Update the specified resource from storage.
     *
     * @param \App\Models\Report $report
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Report $report, Request $request)
    {
        $report->forceFill($request->only('status'))->save();

        flash()->success(trans('reports.messages.updated'));

        return redirect()->route('dashboard.reports.index');
    }
}
