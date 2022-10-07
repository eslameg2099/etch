@include('dashboard.errors')
@bsMultilangualFormTabs
{{ BsForm::text('name') }}
@endBsMultilangualFormTabs
{{ BsForm::checkbox('is_active')->value(1)->default(0)->checked($category->is_active ?? old('is_active')) }}

@isset($category)
    {{ BsForm::image('image')->files($category->getMediaResource()) }}
@else
    {{ BsForm::image('image') }}
@endisset
