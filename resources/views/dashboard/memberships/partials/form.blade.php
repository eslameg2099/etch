@include('dashboard.errors')

{{ BsForm::text('name')->required() }}
{{ BsForm::number('rates_count')->min(0)->required() }}

@isset($membership)
    {{ BsForm::image('image')->files($membership->getMediaResource()) }}
@else
    {{ BsForm::image('image') }}
@endisset