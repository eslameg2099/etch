@include('dashboard.errors')

{{ BsForm::text('code')->required() }}
{{ BsForm::number('percentage_value')->min(0)->max(100)->required() }}
{{ BsForm::number('usage_count')->min(1)->required() }}
{{ BsForm::checkbox('only_once')->value(1)->withDefault()->checked($coupon->only_once ?? true)->label('إستخدام لمرة واحدة') }}
{{ BsForm::checkbox('only_new')->value(1)->withDefault()->checked($coupon->only_new ?? false)->label('للعملاء الجدد') }}
