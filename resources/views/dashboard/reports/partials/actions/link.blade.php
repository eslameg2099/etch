@if($report)
    @if($report->trashed())
        <a href="{{ route('dashboard.reports.trashed.show', $report) }}">
            {{ $report->name }}
        </a>
    @else
        <a href="{{ route('dashboard.reports.show', $report) }}">
            {{ $report->name }}
        </a>
    @endif
@else
    ---
@endif