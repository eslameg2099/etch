@if($order->isNot(auth()->user()))
    @if(! $order->trashed())
        <a href="#order-{{ $order->id }}-delete-model"
           title="@lang('orders.actions.delete')"
           class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"
           data-toggle="modal">
            <i class="feather icon-trash"></i>
        </a>


        <!-- Modal -->
        <div class="modal fade" id="order-{{ $order->id }}-delete-model" tabindex="-1" role="dialog"
             aria-labelledby="modal-title-{{ $order->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modal-title-{{ $order->id }}">@lang('orders.dialogs.delete.title')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('orders.dialogs.delete.info')
                    </div>
                    <div class="modal-footer">
                        {{ BsForm::delete(route('dashboard.orders.destroy', $order)) }}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            @lang('orders.dialogs.delete.cancel')
                        </button>
                        <button type="submit" class="btn btn-danger">
                            @lang('orders.dialogs.delete.confirm')
                        </button>
                        {{ BsForm::close() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <a href="{{ route('dashboard.orders.restore', $order) }}"
           title="@lang('orders.actions.restore')"
           class="btn btn-icon btn-primary mr-1 mb-1 waves-effect waves-light">
            <i class="fas fa-trash-restore"></i>
        </a>
    @endif
@endif
