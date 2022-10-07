@if($category->trashed())
    <a href="{{ route('dashboard.categories.trashed.show', $category) }}"
       title="@lang('categories.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@else
    <a href="{{ route('dashboard.categories.show', $category) }}"
       title="@lang('categories.actions.show')"
       class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-eye"></i>
    </a>
@endif