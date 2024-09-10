<x-master-layout>
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold">انشاء حجز جديد</h5>
                                <a href="{{ route('booking.index') }}" class="float-right btn btn-sm btn-primary"><i class="fa fa-angle-double-left"></i> {{ __('رجوع') }}</a>
                            @if($auth_user->can('booking list'))
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::model($bookingdata,['method' => 'POST','route'=>'booking.store', 'data-toggle'=>"validator" ,'id'=>'booking'] ) }}
                            {{ Form::hidden('id') }}
                            <div class="row">
                                                                
                                <div class="form-group col-md-4">
                                    {{ Form::label('name', __("اختر الخدمة").' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                    <br />
                                    {{ Form::select('service_id', [optional($bookingdata->service)->id => optional($bookingdata->service)->name], optional($bookingdata->service)->id, [
                                            'class' => 'select2js form-group service',
                                            'required',
                                            'data-placeholder' => __("اختر الخدمة"),
                                            'data-ajax--url' => route('ajax-list', ['type' => 'service']),
                                        ])
                                    }}
                                </div>
                                @if (auth()->user()->hasRole(['admin']))
                                    <div class="form-group col-md-4">
                                        {{ Form::label('name', __("اختر العميل").' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                        <br />
                                        {{ Form::select('customer_id', [optional($bookingdata->customer)->id => optional($bookingdata->customer)->display_name], optional($bookingdata->customer)->id, [
                                                'class' => 'select2js form-group customer',
                                                'required',
                                                'data-placeholder' => __("اختر العميل"),
                                                'data-ajax--url' => route('ajax-list', ['type' => 'user']),
                                            ])
                                        }}
                                    </div>
                                @else
                                    <input type="hidden" name="customer_id" value="{{$bookingdata->customer_id}}">
                                @endif
                                <div class="form-group col-md-4">
                                    {{ Form::label('name', __("اختر الكوبون"),['class'=>'form-control-label']) }}
                                    <br />
                                    {{ Form::select('coupon_id', [optional($bookingdata->coupon)->id => optional($bookingdata->coupon)->name], optional($bookingdata->coupon)->id, [
                                            'class' => 'select2js form-group coupon',
                                            'data-placeholder' => __("اختر الكوبون"),
                                            'data-ajax--url' => route('ajax-list', ['type' => 'coupon']),
                                        ])
                                    }}
                                </div>
                                
                                <div class="form-group col-md-4">
                                    {{ Form::label('date',__('التاريخ').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                    {{ Form::text('date',old('date'),['placeholder' => __('التاريخ'),'class' =>'form-control min-datetimepicker','required']) }}
                                    <small class="help-block with-errors text-danger"></small>
                                </div>
                                
                                <div class="form-group col-md-4">
                                    {{ Form::label('address',__('العنوان').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                    {{ Form::textarea('address', null, ['class'=>"form-control textarea" , 'rows'=>3  , 'placeholder'=> __('العنوان') ]) }}
                                    <small class="help-block with-errors text-danger"></small>
                                </div>

                                <div class="form-group col-md-12">
                                    {{ Form::label('description',__('الوصف'), ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('description', null, ['class'=>"form-control textarea" , 'rows'=>3  , 'placeholder'=> __('الوصف') ]) }}
                                </div>
                            </div>
                            
                            {{ Form::submit( __('حفظ'), ['class'=>'btn btn-md btn-primary float-right']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>