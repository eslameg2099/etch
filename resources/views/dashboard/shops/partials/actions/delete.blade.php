@if($shop->isNot(auth()->user()))
    @if(! $shop->trashed())
        <a href="#shop-{{ $shop->id }}-delete-model"
           title="@lang('shops.actions.delete')"
           class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"
           data-toggle="modal">
            <i class="feather icon-trash"></i>
        </a>


        <!-- Modal -->
        <div class="modal fade" id="shop-{{ $shop->id }}-delete-model" tabindex="-1" role="dialog"
             aria-labelledby="modal-title-{{ $shop->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modal-title-{{ $shop->id }}">@lang('shops.dialogs.delete.title')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('shops.dialogs.delete.info')
                    </div>
                    <div class="modal-footer">
                        {{ BsForm::delete(route('dashboard.shops.destroy', $shop)) }}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            @lang('shops.dialogs.delete.cancel')
                        </button>
                        <button type="submit" class="btn btn-danger">
                            @lang('shops.dialogs.delete.confirm')
                        </button>
                        {{ BsForm::close() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <a href="{{ route('dashboard.shops.restore', $shop) }}"
           title="@lang('shops.actions.restore')"
           class="btn btn-icon btn-primary mr-1 mb-1 waves-effect waves-light">
            <i class="fas fa-trash-restore"></i>
        </a>
    @endif
@endif
