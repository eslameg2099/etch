@if(! $category->trashed())
    <a href="{{ route('dashboard.categories.edit', $category) }}"
       title="@lang('categories.actions.edit')"
       class="btn btn-icon btn-warning mr-1 mb-1 waves-effect waves-light">
        <i class="feather icon-edit"></i>
    </a>
@endif