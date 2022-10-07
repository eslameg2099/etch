@extends('dashboard.layout.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            @include('dashboard.contact_us.partials.filter')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('contact_us.plural')</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">@lang('contact_us.attributes.name')</th>
                                <th scope="col">@lang('contact_us.attributes.email')</th>
                                <th scope="col">@lang('contact_us.attributes.mobile')</th>
                                <th scope="col">@lang('contact_us.attributes.message')</th>
                                <th scope="col">@lang('contact_us.attributes.created_at')</th>
                                <th scope="col" style="width: 200px;">...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($contactUs as $message)
                                <tr>
                                    <th scope="row">{{ $message->id }}</th>
                                    <td>{{ $message->name }}</td>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ $message->mobile }}</td>
                                    <td>{{ Str::limit($message->message) }}</td>
                                    <td>{{ $message->created_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @include('dashboard.contact_us.partials.actions.show')
                                            @include('dashboard.contact_us.partials.actions.delete')
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th class="text-center" colspan="100">@lang('contact_us.empty')</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($contactUs->hasPages())
                    <div class="card-footer">
                        {{ $contactUs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection