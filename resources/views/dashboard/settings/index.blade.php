@extends('dashboard.layout.main')
@section('content')
    {{ BsForm::resource('settings')->patch(route('dashboard.settings.update')) }}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('settings.plural')</h3>
        </div>
        <div class="card-body">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link active"
                       id="static-pages-tab"
                       data-toggle="tab"
                       href="#static-pages"
                       role="tab"
                       aria-controls="static-pages"
                       aria-selected="true">
                        @lang('الصفحات الثابتة')
                    </a>
                    <a class="nav-link"
                       id="contacts-tab"
                       data-toggle="tab"
                       href="#contacts"
                       role="tab"
                       aria-controls="contacts"
                       aria-selected="false">
                        @lang('بيانات التواصل الاجتماعي')
                    </a>
                    <a class="nav-link"
                       id="percents-tab"
                       data-toggle="tab"
                       href="#percents"
                       role="tab"
                       aria-controls="percents"
                       aria-selected="false">
                        @lang('بالنسب بالتطبيق')
                    </a>
                    <a class="nav-link"
                       id="pyment-tab"
                       data-toggle="tab"
                       href="#payment"
                       role="tab"
                       aria-controls="payment"
                       aria-selected="false">
                        @lang('طرق الدفع المتاحة')
                    </a>
                    <a class="nav-link"
                       id="images-tab"
                       data-toggle="tab"
                       href="#images"
                       role="tab"
                       aria-controls="images"
                       aria-selected="false">
                        @lang('صور الصفحة الرئيسية')
                    </a>
                    <a class="nav-link"
                       id="orders-tab"
                       data-toggle="tab"
                       href="#orders"
                       role="tab"
                       aria-controls="orders"
                       aria-selected="false">
                        @lang('الطلبات')
                    </a>
                    <a class="nav-link"
                       id="android-tab"
                       data-toggle="tab"
                       href="#android"
                       role="tab"
                       aria-controls="android"
                       aria-selected="false">
                        @lang('نسخة الأندرويد')
                    </a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">

                <div class="tab-pane fade show active in"
                     id="static-pages"
                     role="tabpanel"
                     aria-labelledby="static-pages-tab">
                    {{ BsForm::text('copyRights')->value(Settings::get('copyRights')) }}
                    {{ BsForm::textarea('aboutUs')->value(Settings::get('aboutUs'))->attribute('class', 'form-control textarea') }}
                    {{ BsForm::textarea('usagePolicy')->value(Settings::get('usagePolicy'))->attribute('class', 'form-control textarea') }}
                    {{ BsForm::textarea('termsAndConditions')->value(Settings::get('termsAndConditions'))->attribute('class', 'form-control textarea') }}
                    {{ BsForm::textarea('privacyPolicy')->value(Settings::get('privacyPolicy'))->attribute('class', 'form-control textarea') }}
                </div>

                <div class="tab-pane fade"
                     id="contacts"
                     role="tabpanel"
                     aria-labelledby="contacts-tab">
                    {{ BsForm::text('mobile')->value(Settings::get('mobile')) }}
                    {{ BsForm::text('whatsapp')->value(Settings::get('whatsapp')) }}
                    {{ BsForm::text('email')->value(Settings::get('email')) }}
                    {{ BsForm::text('telegram')->value(Settings::get('telegram')) }}
                    {{ BsForm::text('instagram')->value(Settings::get('instagram')) }}
                    {{ BsForm::text('twitter')->value(Settings::get('twitter')) }}
                    {{ BsForm::text('googleApp')->value(Settings::get('googleApp')) }}
                    {{ BsForm::text('iosApp')->value(Settings::get('iosApp')) }}
                </div>
                <div class="tab-pane fade"
                     id="percents"
                     role="tabpanel"
                     aria-labelledby="percents-tab">
                    {{ BsForm::text('currency')->value(Settings::locale()->get('currency')) }}
                    {{ BsForm::number('user_cancellation_grace_period')->value(Settings::get('user_cancellation_grace_period')) }}
                    {{ BsForm::number('user_cancellation_attempts')->value(Settings::get('user_cancellation_attempts')) }}
                    {{ BsForm::number('orders_per_day')->value(Settings::get('orders_per_day')) }}
                    {{ BsForm::number('delegate_cancellation_grace_period')->value(Settings::get('delegate_cancellation_grace_period')) }}
                    {{ BsForm::number('delegate_cancellation_attempts')->value(Settings::get('delegate_cancellation_attempts')) }}
                    {{ BsForm::number('app_profits_percent')->value(Settings::get('app_profits_percent')) }}
                    {{ BsForm::number('delegate_hold_amount')->value(Settings::get('delegate_hold_amount')) }}
                    {{ BsForm::number('tax')->value(Settings::get('tax')) }}
                    {{ BsForm::number('delivery_cost_per_km')->value(Settings::get('delivery_cost_per_km')) }}
                    {{ BsForm::number('buy_cost_per_km')->value(Settings::get('buy_cost_per_km')) }}

                    {{ BsForm::number('min_delivery_cost')->value(Settings::get('min_delivery_cost')) }}
                    {{ BsForm::number('min_buy_cost')->value(Settings::get('min_buy_cost')) }}
                </div>
                <div class="tab-pane fade"
                     id="payment"
                     role="tabpanel"
                     aria-labelledby="payment-tab">
                    {{ BsForm::checkbox('cash_payment')->value(1)->withDefault()->checked(Settings::get('cash_payment')) }}
                    {{ BsForm::checkbox('wallet_payment')->value(1)->withDefault()->checked(Settings::get('wallet_payment')) }}
                    {{ BsForm::checkbox('visa_payment')->value(1)->withDefault()->checked(Settings::get('visa_payment')) }}
                </div>
                <div class="tab-pane fade"
                     id="images"
                     role="tabpanel"
                     aria-labelledby="images-tab">
                    @if(Settings::instance('category_slider'))
                        {{ BsForm::image('category_slider')
                            ->collection('category_slider')
                            ->label(__('سلايدر الاقسام'))
                            ->unlimited()
                            ->files(Settings::instance('category_slider')
                            ->getMediaResource('category_slider')) }}
                    @else
                        {{ BsForm::image('category_slider')
                            ->collection('categories')
                            ->label(__('سلايدر الاقسام'))
                            ->unlimited() }}
                    @endif
                    @if(Settings::instance('slider'))
                        {{ BsForm::image('slider')
                            ->collection('slider')
                            ->label(__('صور السلايدر'))
                            ->unlimited()
                            ->files(Settings::instance('slider')
                            ->getMediaResource('slider')) }}
                    @else
                        {{ BsForm::image('slider')
                            ->collection('slider')
                            ->label(__('صور السلايدر'))
                            ->unlimited()
                            ->getMediaResource('slider') }}
                    @endif
                    @if(Settings::instance('offers'))
                        {{ BsForm::image('offers')
                            ->collection('offers')
                            ->label(__('صور العروض'))
                            ->unlimited()
                            ->files(Settings::instance('offers')
                            ->getMediaResource('offers')) }}
                    @else
                        {{ BsForm::image('offers')
                            ->collection('offers')
                            ->label(__('صور العروض'))
                            ->unlimited() }}
                    @endif
                </div>
                <div class="tab-pane fade"
                     id="orders"
                     role="tabpanel"
                     aria-labelledby="orders-tab">
                        {{ BsForm::number('auto_cancel_duration')->value(Settings::get('auto_cancel_duration', 30)) }}
                </div>
                <div class="tab-pane fade"
                     id="android"
                     role="tabpanel"
                     aria-labelledby="orders-tab">
                    {{ BsForm::text('android_app_version')->value(Settings::get('android_app_version', 9)) }}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-danger mr-1 mb-1 waves-effect waves-light">
                @lang('settings.actions.save')
            </button>
        </div>
    </div>
    {{ BsForm::close() }}
@endsection