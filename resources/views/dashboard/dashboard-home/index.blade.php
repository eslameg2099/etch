@extends('dashboard.layout.main')

@section('content')
    <section id="dashboard-analytics">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12 st-cards">
                <div class="card">
                    <a href="{{ route('dashboard.wallets.system') }}" class="card-link-color">
                        <div class="card-header d-flex align-items-start pb-0">
                            <div>
                                <h2 class="text-bold-700 mb-1">
                                    {{ \App\Support\Payment\Models\Transaction::whereNull('user_id')->parentsOnly()->sum('amount') }}
                                    {{ Settings::locale()->get('currency') }}
                                </h2>
                                <p>@lang('محفظة النظام')</p>
                            </div>
                            <div class="avatar bg-rgba-warning  p-50 m-0">
                                <div class="avatar-content">
                                    <i class="fas fa-money-check-alt text-warning  font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
                
            </div>
            <div class="col-lg-3 col-sm-6 col-12 st-cards">
                <div class="card">
                    <a href="{{ route('dashboard.wallets.delegates') }}" class="card-link-color">
                        <div class="card-header d-flex align-items-start pb-0">
                            <div>
                                <h2 class="text-bold-700 mb-1">
                                    {{ \App\Support\Payment\Models\Transaction::whereHas('user', function ($query) {
                                        $query->where('type', \App\Models\Users\User::Delegate);
                                    })->parentsOnly()->sum('amount') }}

                                    {{ Settings::locale()->get('currency') }}
                                </h2>
                                <p>@lang('اجمالي محافظ المناديب')</p>
                            </div>
                            <div class="avatar bg-rgba-warning  p-50 m-0">
                                <div class="avatar-content">
                                    <i class="fas fa-file-invoice-dollar text-warning  font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 st-cards">
                <div class="card">
                    <a href="{{ route('dashboard.wallets.users') }}" class="card-link-color">
                        <div class="card-header d-flex align-items-start pb-0">
                            <div>
                                <h2 class="text-bold-700 mb-1">
                                    {{ \App\Support\Payment\Models\Transaction::whereHas('user', function ($query) {
                                        $query->where('type', \App\Models\Users\User::User);
                                    })->parentsOnly()->sum('amount') }}

                                    {{ Settings::locale()->get('currency') }}
                                </h2>
                                <p>@lang('اجمالي محافظ المستخدمين')</p>
                            </div>
                            <div class="avatar bg-rgba-warning  p-50 m-0">
                                <div class="avatar-content">
                                    <i class="fas fa-file-invoice-dollar text-warning  font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 st-cards">
                <div class="card">
                    <a href="{{ route('dashboard.orders.index') }}" class="card-link-color">
                        <div class="card-header d-flex align-items-start pb-0">
                            <div>
                                <h2 class="text-bold-700 mb-1">
                                    {{-- TODO: need refactor --}}
                                    {{ \App\Models\Orders\Order::notRejected()->has('payment')->with('payment')->get()->sum('payment.amount') }}

                                    {{ Settings::locale()->get('currency') }}
                                </h2>
                                <p>@lang('اجمالي الطلبات')</p>
                            </div>
                            <div class="avatar bg-rgba-warning  p-50 m-0">
                                <div class="avatar-content">
                                    <i class="fas fa-sack-dollar text-warning  font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-4 col-sm-6 st-cards">
                <div class="card text-center">
                    <a href="{{ route('dashboard.users.index') }}" class="card-link-color">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                                    <div class="avatar-content">
                                        <i class="fas fa-users text-black-50 font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="text-bold-700">
                                    {{ \App\Models\Users\User::where('type', \App\Models\Users\User::User)->count() }}
                                </h2>
                                <p class="mb-0 line-ellipsis">
                                    @lang('عدد المستخدمين')
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-sm-6 st-cards">
                <div class="card text-center">
                    <a href="{{ route('dashboard.delegates.index') }}" class="card-link-color">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                                    <div class="avatar-content">
                                        <i class="fas fa-user-shield text-black-50 font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="text-bold-700">
                                    {{ \App\Models\Users\User::where('type', \App\Models\Users\User::Delegate)->count() }}
                                </h2>
                                <p class="mb-0 line-ellipsis">
                                    @lang('عدد المناديب')
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-sm-6 st-cards">
                <div class="card text-center">
                    <a href="{{ route('dashboard.shops.index') }}" class="card-link-color">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                                    <div class="avatar-content">
                                        <i class="fas fa-store text-black-50 font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="text-bold-700">
                                    {{ \App\Models\Shop::whereNotNull('city_id')->count() }}
                                </h2>
                                <p class="mb-0 line-ellipsis">
                                    @lang('عدد المتاجر')
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-sm-6 st-cards">
                <div class="card text-center">
                    <a href="{{ route('dashboard.categories.index') }}" class="card-link-color">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                                    <div class="avatar-content">
                                        <i class="fas fa-th text-black-50 font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="text-bold-700">
                                    {{ \App\Models\MasterData\Category::count() }}
                                </h2>
                                <p class="mb-0 line-ellipsis">
                                    @lang('عدد الاقسام')
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </section>
@endsection
@push('scripts')
    <script>
      $(function () {
        $('.st-cards .card').mouseenter(function (e) {
          animateCSS(this, 'pulse')
        })
      })
    </script>
@endpush
