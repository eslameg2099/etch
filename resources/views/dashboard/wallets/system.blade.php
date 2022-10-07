<? /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Support\Payment\Models\Transaction[] $transactions */ ?>
@extends('dashboard.layout.main')
@section('content')
    @include('dashboard.wallets.list', ['title' => trans('wallets.system')])
@endsection