@if($city)
    @if($city->trashed())
        <a href="{{ route('dashboard.cities.trashed.show', $city) }}">
            {{ $city->name }}
        </a>
    @else
        <a href="{{ route('dashboard.cities.show', $city) }}">
            {{ $city->name }}
        </a>
    @endif
@endif