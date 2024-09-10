<x-master-layout>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-block card-stretch">
                <div class="card-body p-0">
                    <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                        <h5 class="font-weight-bold">انشاء اضافة</h5>
                        <a href="{{ route('serviceaddon.index') }}" class="float-right btn btn-sm btn-primary"><i class="fa fa-angle-double-left"></i> {{ __('رجوع') }}</a>
                        @if($auth_user->can('service list'))
                       
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                {{ Form::model($serviceaddon,['method' => 'POST','route'=>'serviceaddon.store', 'enctype'=>'multipart/form-data','data-toggle'=>"validator" ,'id'=>'serviceaddon'] ) }}
                        {{ Form::hidden('id') }}
                        <div class="row">
                            <div class="form-group col-md-4">
                                {{ Form::label('name', __('الاسم').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('name', old('name'), ['placeholder' => __('الاسم'), 'class' => 'form-control', 'title' => 'Please enter alphabetic characters and spaces only']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('name', __("الخدمة").' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                <br />
                                @php
                                    if($auth_user->user_type == 'admin')
                                    {
                                        $route = route('ajax-list', ['type' => 'service-list']);
                                    } else {
                                        $route = route('ajax-list', ['type' => 'service-list', 'provider_id' => $auth_user->id]);
                                    }
                                
                                @endphp
                                {{ Form::select('service_id', [ optional($serviceaddon->service)->id => optional($serviceaddon->service)->name ], optional($serviceaddon->service)->id, [
                                        'class' => 'select2js form-group service',
                                        'id' => 'service_id',
                                        'required',
                                        'data-placeholder' => __("اختر الخدمة"),
                                        'data-ajax--url' => $route,
                                ]) }} 
                                
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('price', __('السعر').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('price', null, [ 'placeholder' => __('السعر'), 'class' =>'form-control', 'required', 'pattern' => '^\\d+(\\.\\d{1,2})?$']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="form-control-label" for="serviceaddon_image">{{ __('صورة') }}</label>
                                <div class="custom-file">
                                    <input type="file" name="serviceaddon_image" class="custom-file-input" accept="image/*">
                                    <label class="custom-file-label upload-label">{{  __('اختر صورة') }}</label>
                                </div>
                            </div>

                                @if(getMediaFileExit($serviceaddon, 'serviceaddon_image'))
                                    <div class="col-md-2 mb-2">
                                        @php
                                            $extention = imageExtention(getSingleMedia($serviceaddon,'serviceaddon_image'));
                                        @endphp
                                        <img id="serviceaddon_image_preview" src="{{getSingleMedia($serviceaddon,'serviceaddon_image')}}" alt="#" class="attachment-image mt-1">
                                            <a class="text-danger remove-file" href="{{ route('remove.file', ['id' => $serviceaddon->id, 'type' => 'serviceaddon_image']) }}"
                                                data--submit="confirm_form"
                                                data--confirmation='true'
                                                data--ajax="true"
                                                title='{{ __("messages.remove_file_title" , ["name" =>  __("messages.image") ]) }}'
                                                data-title='{{ __("messages.remove_file_title" , ["name" =>  __("messages.image") ]) }}'
                                                data-message='{{ __("messages.remove_file_msg") }}'>
                                                <i class="ri-close-circle-line"></i>
                                            </a>
                                    </div>
                                @endif
                            <!-- <div class="form-group col-md-4">
                                {{ Form::label('quantity', __('messages.quantity').' ', ['class' => 'form-control-label'], false) }}
                                {{ Form::number('quantity',null, [ 'min' => 1, 'step' => 'any' , 'placeholder' => __('messages.quantity'),'class' =>'form-control']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>  -->
                            <div class="form-group col-md-4">
                                {{ Form::label('status',__('الحالة').' ',['class'=>'form-control-label'],false) }}
                                {{ Form::select('status',['1' => __('نشط') , '0' => __('غير نشط') ],old('status'),[ 'id' => 'role' ,'class' =>'form-control select2js','required']) }}
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