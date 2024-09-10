<x-master-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold">الحجز</h5>
                            <a href="{{ route('booking.index') }}" class="float-right btn btn-sm btn-primary"><i
                                    class="fa fa-angle-double-left"></i> {{ __('الرجوع') }}</a>
                            @if ($auth_user->can('booking list'))
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::model($bookingdata, ['method' => 'patch', 'route' => ['booking.update', $bookingdata->id], 'data-toggle' => 'validator', 'id' => 'booking']) }}
                        {{ Form::hidden('id') }}
                        <div class="row">
                            <div class="form-group col-md-4">

                                {{ Form::label('status', __("حالة الحجز"), ['class' => 'form-control-label']) }}
                                <br />
                                {{ Form::select('status', $status, old('status'), ['id' => 'status', 'class' => 'form-control select2js booking_status']) }}
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('date', __('التاريخ') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('date', old('date'), ['placeholder' => __('التاريخ'), 'class' => 'form-control datetimepicker', 'required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('start_at', __('موعد البدء'), ['class' => 'form-control-label']) }}
                                {{ Form::text('start_at', old('start_at'), ['placeholder' => __('موعد البدء'), 'class' => 'form-control datetimepicker']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('end_at', __('موعد الانتهاء'), ['class' => 'form-control-label']) }}
                                {{ Form::text('end_at', old('end_at'), ['placeholder' => __('موعد الانتهاء'), 'class' => 'form-control datetimepicker']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('payment_status', __('حالة الدفع') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::select('payment_status', ['pending' => __('messages.pending'), 'paid' => __('messages.paid'), 'failed' => __('messages.failed')], optional($bookingdata->payment)->payment_status, ['id' => 'payment_status', 'class' => 'form-control select2js', 'required']) }}
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                {{ Form::label('description', __('الوصف'), ['class' => 'form-control-label']) }}
                                {{ Form::textarea('description', null, ['class' => 'form-control textarea', 'rows' => 3, 'placeholder' => __('الوصف')]) }}
                            </div>
                            <div class="form-group col-md-6 reason">
                                {{ Form::label('reason', __('السبب'), ['class' => 'form-control-label']) }}
                                {{ Form::textarea('reason', null, ['class' => 'form-control textarea', 'rows' => 3, 'placeholder' => __('السبب')]) }}
                            </div>
                        </div>
                        {{ Form::submit(__('حفظ'), ['class' => 'btn btn-md btn-primary float-right']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('bottom_script')
        <script>
            (function($) {
                "use strict";
                $(document).ready(function() {
                    // $('#status').attr("disabled", "true");

                    /*  changeReason(status);

                     $("#status").change(function() {
                         changeReason(this.value)
                     });

                     function changeReason(status)
                     {
                         if (jQuery.inArray(status, ['hold', 'in_progress','failed']) !== -1) {
                             $('.reason').removeClass('d-none');
                         }else{
                             $('.reason').addClass('d-none');
                         }
                     } */
                });
            })(jQuery);
        </script>
    @endsection
</x-master-layout>
