@if($category)
    @if($category->trashed())
        <a href="{{ route('dashboard.categories.trashed.show', $category) }}">
            {{ $category->name }}
        </a>
    @else
        <a href="{{ route('dashboard.categories.show', $category) }}">
            {{ $category->name }}
        </a>
    @endif
@endif