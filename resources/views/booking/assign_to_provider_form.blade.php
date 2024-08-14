<!-- Modal -->
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ $pageTitle }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::open(['route' => 'booking.assign_provider', 'method' => 'post', 'id' => 'assignProviderForm' ,'data-toggle' => "validator" ]) }}
        <div class="modal-body" id="exampleModal">
            {{ Form::hidden('id', $bookingdata->id) }}
            <div class="row">
                <div class="col-md-12 form-group">
                    {{ Form::label('provider_id', __('messages.select_name', [ 'select' => __('messages.provider') ]).' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                    <br />
                    @php
                    $route = route('ajax-list', ['type' => 'provider', 'booking_id' => $bookingdata->id ]);
                
                    $assigned_provider = $bookingdata->providersAdded->mapWithKeys(function ($item) {
                        return [$item->id => $item->name]; // Adjust this according to your User model attributes
                    });
                    
                @endphp
                {{ Form::select('provider_id[]', $assigned_provider, $bookingdata->providersAdded->pluck('id'), [
                    'class' => 'select2js provider',
                    'id' => 'provider_id',
                    'required',
                    'data-placeholder' => __('messages.select_name', [ 'select' => __('messages.provider') ]),
                    'data-ajax--url' => $route,
                ]) }}
                
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">{{ trans('messages.close') }}</button>
            <button type="submit" class="btn btn-md btn-primary" id="btn_submit" data-form="ajax">{{ trans('messages.save') }}</button>
        </div>
        {{ Form::close() }}
    </div>
</div>
<script>
    $('#provider_id').select2({
        width: '100%',
        placeholder: "{{ __('messages.select_name', ['select' => __('messages.provider')]) }}",
    });



    $(document).ready(function() {
        $('#assignProviderForm').on('submit', function(event) {
            event.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.href = response.redirectUrl;
                        $('#exampleModal').style = 'display:none';
                        alert('Provider updated successfully.');
                    } else {
                        alert('Error updating provider.');
                    }
                },
                error: function() {
                    alert('Error occurred.');
                }
            });
        });
    });
</script>
