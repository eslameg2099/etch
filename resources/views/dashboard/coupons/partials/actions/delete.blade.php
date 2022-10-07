@if($coupon->isNot(auth()->user()))
    @if(! $coupon->trashed())
        <a href="#coupon-{{ $coupon->id }}-delete-model"
           title="@lang('coupons.actions.delete')"
           class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"
           data-toggle="modal">
            <i class="feather icon-trash"></i>
        </a>


        <!-- Modal -->
        <div class="modal fade" id="coupon-{{ $coupon->id }}-delete-model" tabindex="-1" role="dialog"
             aria-labelledby="modal-title-{{ $coupon->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modal-title-{{ $coupon->id }}">@lang('coupons.dialogs.delete.title')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('coupons.dialogs.delete.info')
                    </div>
                    <div class="modal-footer">
                        {{ BsForm::delete(route('dashboard.coupons.destroy', $coupon)) }}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            @lang('coupons.dialogs.delete.cancel')
                        </button>
                        <button type="submit" class="btn btn-danger">
                            @lang('coupons.dialogs.delete.confirm')
                        </button>
                        {{ BsForm::close() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <a href="{{ route('dashboard.coupons.restore', $coupon) }}"
           title="@lang('coupons.actions.restore')"
           class="btn btn-icon btn-primary mr-1 mb-1 waves-effect waves-light">
            <i class="fas fa-trash-restore"></i>
        </a>
    @endif
@endif
