<x-master-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mt-4">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold">اضافة خدمة</h5>
                            <a href="{{ route('service.index') }}" class="float-right btn btn-sm btn-primary"><i
                                    class="fa fa-angle-double-left"></i> {{ __('رجوع') }}</a>
                            @if($auth_user->can('service list'))
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::model($servicedata,['method' => 'POST','route'=>'service.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'service'] ) }}
                        {{ Form::hidden('id') }}
                        <div class="row">
                            <div class="form-group col-md-4">
                                {{ Form::label('name', __('الاسم').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('name', old('name'), ['placeholder' => __('الاسم'), 'class' => 'form-control', 'title' => 'Please enter alphabetic characters and spaces only']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('name', __("القسم الرئيسي").' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('category_id', [optional($servicedata->category)->id => optional($servicedata->category)->name], optional($servicedata->category)->id, [
                                            'class' => 'select2js form-group category',
                                            'required',
                                            'id' => 'category_id',
                                            'data-placeholder' => __("القسم الرئيسي"),
                                            'data-ajax--url' => route('ajax-list', ['type' => 'category']),
                                        ]) }}

                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('subcategory_id', __("القسم الفرعي"),['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('subcategory_id', [], [
                                        'class' => 'select2js form-group subcategory_id',
                                        'data-placeholder' => __("القسم الفرعي"),
                                    ]) }}
                            </div>

                            @if(auth()->user()->hasAnyRole(['admin','demo_admin']))
                            <div class="form-group col-md-4">
                                {{ Form::label('name', __("اختر المزود").' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('provider_id', [ optional($servicedata->providers)->id => optional($servicedata->providers)->display_name ], optional($servicedata->providers)->id, [
                                            'class' => 'select2js form-group',
                                            'id' => 'provider_id',
                                            'onchange' => 'selectprovider(this)',
                                            'required',
                                            'data-placeholder' => __("اختر المزود"),
                                            'data-ajax--url' => route('ajax-list', ['type' => 'provider']),
                                        ]) }}
                            </div>
                            @endif
                            <div class="form-group col-md-4">
                                {{ Form::label('name', __("العنوان"),['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('provider_address_id[]', [], old('provider_address_id'), [
                                        'class' => 'select2js form-group provider_address_id',
                                        'id' =>'provider_address_id',
                                        'multiple' => 'multiple',
                                        'data-placeholder' => __("العنوان"),
                                    ]) }}
                                   
                               
                                 @if(auth()->user()->hasAnyRole(['provider']))
                                    <a href="{{ route('provideraddress.create', ['provideraddress' => auth()->id()]) }}" id="add_provider_address_link" class=""><i class="fa fa-plus-circle mt-2"></i>
                                 {{ trans("عنوان المزود") }}</a>
                                 @else
                                    <a href="#" id="add_provider_address_link" class=""><i class="fa fa-plus-circle mt-2"></i>
                                 {{ trans("عنوان المزود") }}</a>
                                 @endif
                            </div> 

                            <div class="form-group col-md-4">
                                {{ Form::label('type',__('نوع السعر').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                {{ Form::select('type',['fixed' => __('ثابت') , 'hourly' => __('الساعه'), 'free' => __('مجاني') ],old('status'),[ 'class' =>'form-control select2js','required' ,'id'=>'price_type']) }}
                            </div>
                            <div class="form-group col-md-4" id="price_div">
                                {{ Form::label('price',__('السعر').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                {{ Form::text('price',null, [ 'min' => 1, 'step' => 'any' , 'placeholder' => __('السعر'),'class' =>'form-control', 'required','id' => 'price',  'pattern' => '^\\d+(\\.\\d{1,2})?$' ]) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4" id="discount_div">
                                {{ Form::label('discount',__('تخفيض').' %', ['class' => 'form-control-label']) }}
                                {{ Form::number('discount',null, [ 'min' => 0,'max' => 99, 'step' => 'any' , 'id' =>'discount','placeholder' => __('تخفيض'),'class' =>'form-control']) }}

                                <span id="discount-error" class="text-danger"></span>
                            </div>


                            <div class="form-group col-md-4">
                                {{ Form::label('duration', __('المده').' (ساعه) ', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('duration', old('duration'), ['placeholder' => __('المده'), 'class' => 'form-control min-datetimepicker-time']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('status',__('الحاله').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                {{ Form::select('status',['1' => __('نشط') , '0' => __('غير نشط') ],old('status'),[ 'class' =>'form-control select2js','required']) }}
                            </div>
                            
                            <div class="form-group col-md-4">
                                    {{ Form::label('visit_type', __('نوع الزياره').' ',['class'=>'form-control-label'],false) }}
                                    <br />
                                    {{ Form::select('visit_type',$visittype,old('visit_type'),[ 'id' => 'visit_type' ,'class' =>'form-control select2js','required']) }}
                                </div>

                            <div class="form-group col-md-4">
                                <label class="form-control-label" for="service_attachment">{{ __('صورة') }}
                                </label>
                                <div class="custom-file">
                                    <input type="file" name="service_attachment[]" class="custom-file-input"
                                        data-file-error="{{ __('غير مسموح بتحميل هذا النوع من الملفات') }}" multiple>
                                    <label
                                        class="custom-file-label upload-label">{{ __("صورة") }}</label>
                                </div>
                            </div>
                        </div>


                        <div class="row service_attachment_div">
                            <div class="col-md-12">


                                @if(getMediaFileExit($servicedata, 'service_attachment'))
                                @php

                                $attchments = $servicedata->getMedia('service_attachment');

                                $file_extention = config('constant.IMAGE_EXTENTIONS');
                                @endphp
                                <div class="border-left-2">
                                    <p class="ml-2"><b>{{ __('messages.attached_files') }}</b></p>
                                    <div class="ml-2 my-3">
                                        <div class="row">
                                            @foreach($attchments as $attchment )
                                            <?php
                                            $extention = in_array(strtolower(imageExtention($attchment->getFullUrl())), $file_extention);
                                            ?>

                                            <div class="col-md-2 pr-10 text-center galary file-gallary-{{$servicedata->id}}"
                                                data-gallery=".file-gallary-{{$servicedata->id}}"
                                                id="service_attachment_preview_{{$attchment->id}}">
                                                @if($extention)
                                                <a id="attachment_files" href="{{ $attchment->getFullUrl() }}"
                                                    class="list-group-item-action attachment-list" target="_blank">
                                                    <img src="{{ $attchment->getFullUrl() }}" class="attachment-image"
                                                        alt="">
                                                </a>
                                                @else
                                                <a id="attachment_files"
                                                    class="video list-group-item-action attachment-list"
                                                    href="{{ $attchment->getFullUrl() }}">
                                                    <img src="{{ asset('images/file.png') }}" class="attachment-file">
                                                </a>
                                                @endif
                                                <a class="text-danger remove-file"
                                                    href="{{ route('remove.file', ['id' => $attchment->id, 'type' => 'service_attachment']) }}"
                                                    data--submit="confirm_form" data--confirmation='true'
                                                    data--ajax="true" data-toggle="tooltip"
                                                    title='{{ __("messages.remove_file_title" , ["name" =>  __("messages.attachments") ] ) }}'
                                                    data-title='{{ __("messages.remove_file_title" , ["name" =>  __("messages.attachments") ] ) }}'
                                                    data-message='{{ __("messages.remove_file_msg") }}'>
                                                    <i class="ri-close-circle-line"></i>
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                {{ Form::label('description',__('الوصف'), ['class' => 'form-control-label']) }}
                                {{ Form::textarea('description', null, ['class'=>"form-control textarea" , 'rows'=>3  , 'placeholder'=> __('الوصف') ]) }}
                            </div>
                            @if(!empty( $slotservice) && $slotservice == 1)
                            <div class="form-group col-md-3">
                                <div class="custom-control custom-switch">
                                    {{ Form::checkbox('is_slot', $servicedata->is_slot, null, ['class' => 'custom-control-input', 'id' => 'is_slot' ]) }}
                                    <label class="custom-control-label"
                                        for="is_slot">{{ __('وقت التشغيل') }}</label>
                                </div>
                            </div>
                            @endif
                            <div class="form-group col-md-3">
                                <div class="custom-control custom-switch">
                                    {{ Form::checkbox('is_featured', $servicedata->is_featured, null, ['class' => 'custom-control-input', 'id' => 'is_featured' ]) }}
                                    <label class="custom-control-label"
                                        for="is_featured">{{ __('عنصر مميز') }}</label>
                                </div>
                            </div>
                            
                            <!-- @if(!empty( $digitalservicedata) && $digitalservicedata->value == 1)
                            <div class="form-group col-md-3">
                                <div class="custom-control custom-switch">
                                    {{ Form::checkbox('digital_service', $servicedata->digital_service, null, ['class' => 'custom-control-input', 'id' => 'digital_service' ]) }}
                                    <label class="custom-control-label"
                                        for="digital_service">{{ __('messages.digital_service') }}</label>
                                </div>
                            </div>
                            @endif -->
                            <div class="form-group col-md-3">
                                <div class="custom-control custom-switch">
                                    {{ Form::checkbox('is_delivery', 1, $servicedata->is_delivery, ['class' => 'custom-control-input', 'id' => 'is_delivery']) }}
                                    <label class="custom-control-label" for="is_delivery">{{ __('متاح توصيل') }}</label>
                                </div>
                            </div>
                            @if(!empty( $advancedPaymentSetting) && $advancedPaymentSetting == 1)
                            <div class="form-group col-md-3" id="is_enable_advance">
                                <div class="custom-control custom-switch">
                                    {{ Form::checkbox('is_enable_advance_payment', $servicedata->is_enable_advance_payment , null, ['class' => 'custom-control-input' , 'id' => 'is_enable_advance_payment' ]) }}
                                    <label class="custom-control-label"
                                        for="is_enable_advance_payment">{{ __('تفعيل خدمة الدفع المتقدم')  }}
                                    </label>
                                </div>
                            </div>
                            @endif
                            <div class="form-group col-md-4" id="amount">
                            {{ Form::label('advance_payment_amount', __('messages.advance_payment_amount').' <span class="text-danger"></span> (%)', ['class' => 'form-control-label'], false) }}
                                {{ Form::number('advance_payment_amount',old('advance_payment_amount'),['placeholder' => __('messages.amount'),'class' =>'form-control','id' => 'advance_payment_amount' ,'min' => '1', 'max' => '99']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                        </div>
                        

                        {{ Form::submit( __('حفظ'), ['class'=>'btn btn-md btn-primary float-right']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
    $data = $servicedata->providerServiceAddress->pluck('provider_address_id')->implode(',');
    @endphp
    @section('bottom_script')
    <script type="text/javascript">
    var discountInput = document.getElementById('discount');
    var discountError = document.getElementById('discount-error');

   
      document.addEventListener('DOMContentLoaded', function () {
        var initialProviderId = document.getElementById('provider_id').value;
        selectprovider({ value: initialProviderId }); 
        document.getElementById('add_provider_address_link').addEventListener('click', function (event) {
            event.preventDefault();
            var providerId = document.getElementById('provider_id').value;
            var providerAddressCreateUrl = "{{ route('provideraddress.create', ['provideraddress' => '']) }}";
            providerAddressCreateUrl = providerAddressCreateUrl.replace('provideraddress=', 'provideraddress=' + providerId);
            window.location.href = providerAddressCreateUrl;
        });


      
   

    });

    function selectprovider(selectElement){

        var providerId = selectElement.value;
        var addProviderAddressLink =  document.getElementById('add_provider_address_link');

        if(providerId){
            addProviderAddressLink.classList.remove('d-none');
        } else {
            addProviderAddressLink.classList.add('d-none');
        }
    }

     
    discountInput.addEventListener('input', function() {
        var discountValue = parseFloat(discountInput.value);
        if (isNaN(discountValue) || discountValue < 0 || discountValue > 99) {
            discountError.textContent = "{{ __('Discount value should be between 0 to 99') }}";
        } else {
            discountError.textContent = "";
        }
    });

    var isEnableAdvancePayment = $("input[name='is_enable_advance_payment']").prop('checked');

    var priceType = $("#price_type").val();

    enableAdvancePayment(priceType);
    checkEnablePayment(isEnableAdvancePayment);

    $("#is_enable_advance_payment").change(function() {
        isEnableAdvancePayment = $(this).prop('checked');
        checkEnablePayment(isEnableAdvancePayment);
        updateAmountVisibility(priceType, isEnableAdvancePayment);
    });

    $("#price_type").change(function() {
        priceType = $(this).val();
        enableAdvancePayment(priceType);
        updateAmountVisibility(priceType, isEnableAdvancePayment);
    });

    function checkEnablePayment(value) {
        $("#amount").toggleClass('d-none', !value);
        $('#advance_payment_amount').prop('required', value);
    }

    function enableAdvancePayment(type) {
        $("#is_enable_advance").toggleClass('d-none', type !== 'fixed');
    }

    function updateAmountVisibility(type, isEnableAdvancePayment) {
        if (type === 'fixed' && !$("#is_enable_advance").hasClass('d-none') && isEnableAdvancePayment) {
            $("#amount").removeClass('d-none');
        } else {
            $("#amount").addClass('d-none');
        }
    }

    (function($) {
        "use strict";
        $(document).ready(function() {
            var provider_id = "{{ isset($servicedata->provider_id) ? $servicedata->provider_id : '' }}";
            var provider_address_id = "{{ isset($data) ? $data : [] }}";

            var category_id = "{{ isset($servicedata->category_id) ? $servicedata->category_id : '' }}";
            var subcategory_id =
                "{{ isset($servicedata->subcategory_id) ? $servicedata->subcategory_id : '' }}";

            var price_type = "{{ isset($servicedata->type) ? $servicedata->type : '' }}";

            providerAddress(provider_id, provider_address_id)
            getSubCategory(category_id, subcategory_id)
            priceformat(price_type)

            $(document).on('change', '#provider_id', function() {
                var provider_id = $(this).val();
                $('#provider_address_id').empty();
                providerAddress(provider_id, provider_address_id);
            })
            $(document).on('change', '#category_id', function() {
                var category_id = $(this).val();
                $('#subcategory_id').empty();
                getSubCategory(category_id, subcategory_id);
            })
            $(document).on('change', '#price_type', function() {
                var price_type = $(this).val();
                priceformat(price_type);
            })


            $('.galary').each(function(index, value) {
                let galleryClass = $(value).attr('data-gallery');
                $(galleryClass).magnificPopup({
                    delegate: 'a#attachment_files',
                    type: 'image',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0,
                            1
                        ] // Will preload 0 - before current, and 1 after the current image
                    },
                    callbacks: {
                        elementParse: function(item) {
                            if (item.el[0].className.includes('video')) {
                                item.type = 'iframe',
                                    item.iframe = {
                                        markup: '<div class="mfp-iframe-scaler">' +
                                            '<div class="mfp-close"></div>' +
                                            '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
                                            '<div class="mfp-title">Some caption</div>' +
                                            '</div>'
                                    }
                            } else {
                                item.type = 'image',
                                    item.tLoading = 'Loading image #%curr%...',
                                    item.mainClass = 'mfp-img-mobile',
                                    item.image = {
                                        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
                                    }
                            }
                        }
                    }
                })
            })
        })

        function providerAddress(provider_id, provider_address_id = "") {
            var provider_address_route =
                "{{ route('ajax-list', [ 'type' => 'provider_address','provider_id' =>'']) }}" + provider_id;
            provider_address_route = provider_address_route.replace('amp;', '');

            $.ajax({
                url: provider_address_route,
                success: function(result) {
                    $('#provider_address_id').select2({
                        width: '100%',
                        placeholder: "{{ trans('messages.select_name',['select' => trans('messages.provider_address')]) }}",
                        data: result.results
                    });
                    if (provider_address_id != "") {
                        $('#provider_address_id').val(provider_address_id.split(',')).trigger('change');
                    }
                }
            });
        }

        function getSubCategory(category_id, subcategory_id = "") {
            var get_subcategory_list =
                "{{ route('ajax-list', [ 'type' => 'subcategory_list','category_id' =>'']) }}" + category_id;
            get_subcategory_list = get_subcategory_list.replace('amp;', '');

            $.ajax({
                url: get_subcategory_list,
                success: function(result) {
                    $('#subcategory_id').select2({
                        width: '100%',
                        placeholder: "{{ trans('messages.select_name',['select' => trans('messages.subcategory')]) }}",
                        data: result.results
                    });
                    if (subcategory_id != "") {
                        $('#subcategory_id').val(subcategory_id).trigger('change');
                    }
                }
            });
        }
        var price = "{{ isset($servicedata->price) ? $servicedata->price : '' }}";
        var discount = "{{ isset($servicedata->discount) ? $servicedata->discount : '' }}";
        function priceformat(value) {
            if (value == 'free') {
                $('#price').val(0);
                $('#price').attr("readonly", true)

                $('#discount').val(0);
                $('#discount').attr("readonly", true)

            }
            else{
                $('#price').val(price);
                $('#price').attr("readonly", false)
                $('#discount').val(discount);
                $('#discount').attr("readonly", false)
            }
        }
    })(jQuery);
    </script>
    @endsection
</x-master-layout>