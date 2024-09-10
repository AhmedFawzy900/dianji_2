<x-master-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold">انشاء قسم فرعي جديد</h5>
                            @if ($auth_user->can('category list'))
                                <a href="{{ route('subcategorylevel4.index') }}"
                                    class="float-right btn btn-sm btn-primary"><i class="fa fa-angle-double-left"></i>
                                    {{ __('الرجوع') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row justify-content-center align-items-start">
                    <div class="card col-md-8">
                        <div class="card-body">
                            {{ Form::model($subcategorylevel4, ['method' => 'POST', 'route' => 'subcategorylevel4.store', 'enctype' => 'multipart/form-data', 'data-toggle' => 'validator', 'id' => 'subcategorylevel4']) }}
                            {{ Form::hidden('id') }}
                            <div class="row">
                                <div class="form-group col-md-4">
                                    {{ Form::label('name', trans('الاسم') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                    {{ Form::text('name', old('name'), ['placeholder' => trans('الاسم'), 'class' => 'form-control', 'required']) }}
                                    <small class="help-block with-errors text-danger"></small>
                                </div>
    
                                <div class="form-group col-md-4">
                                    {{ Form::label('name', __('القسم الرئيسي', ['select' => __('Subcategory Level3')]) . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                    <br />
                                    {{ Form::select(
                                        'subcategory_level3_id',
                                        [optional($subcategorylevel4->subcategorylevel3)->id => optional($subcategorylevel4->subcategorylevel3)->name],
                                        optional($subcategorylevel4->subcategorylevel3)->id,
                                        [
                                            'class' => 'select2js form-group subcategory',
                                            'required',
                                            'data-placeholder' => __('القسم الرئيسي', ['select' => __('subcategorylevel3')]),
                                            'data-ajax--url' => route('ajax-list', ['type' => 'subcategory_level_3']),
                                        ],
                                    ) }}
    
    
                                </div>
    
                                <div class="form-group col-md-4">
                                    {{ Form::label('status', trans('الحالة') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                    {{ Form::select('status', ['1' => __('نسط'), '0' => __('غير نشط')], old('status'), ['id' => 'role', 'class' => 'form-control select2js', 'required']) }}
                                    <small class="help-block with-errors text-danger"></small>
                                </div>
    
                                <div class="form-group col-md-4">
                                    <label class="form-control-label" for="image">{{ __('صورة') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input" accept="image/*">
                                        @if ($subcategorylevel4 && getMediaFileExit($subcategorylevel4, 'image'))
                                            <label
                                                class="custom-file-label upload-label">{{ $subcategorylevel4->getFirstMedia('image')->file_name }}</label>
                                        @else
                                            <label
                                                class="custom-file-label upload-label">{{ __('اختر صورة', ['file' => __('messages.image')]) }}</label>
                                        @endif
                                    </div>
                                </div>
    
                                @if (getMediaFileExit($subcategorylevel4, 'image'))
                                    <div class="col-md-2 mb-2">
                                        @php
                                            $extention = imageExtention(getSingleMedia($subcategorylevel4, 'image'));
                                        @endphp
                                        <img id="subcategory_image_preview"
                                            src="{{ getSingleMedia($subcategorylevel4, 'image') }}" alt="#"
                                            class="attachment-image mt-1">
                                        <a class="text-danger remove-file"
                                            href="{{ route('remove.file', ['id' => $subcategorylevel4->id, 'type' => 'image']) }}"
                                            data--submit="confirm_form" data--confirmation='true' data--ajax="true"
                                            title='{{ __('messages.remove_file_title', ['name' => __('messages.image')]) }}'
                                            data-title='{{ __('messages.remove_file_title', ['name' => __('messages.image')]) }}'
                                            data-message='{{ __('messages.remove_file_msg') }}'>
                                            <i class="ri-close-circle-line"></i>
                                        </a>
                                    </div>
                                @endif
                                <div class="form-group col-md-4">
                                    <label class="form-control-label" for="cover_image">{{ __('صورة الغلاف') }} <span
                                            class="text-danger"></span></label>
                                    <div class="custom-file">
                                        <input type="file" name="cover_image" class="custom-file-input" accept="image/*">
                                        @if ($subcategorylevel4 && getMediaFileExit($subcategorylevel4, 'cover_image'))
                                            <label
                                                class="custom-file-label upload-label">{{ $subcategorylevel4->getFirstMedia('cover_image')->file_name }}</label>
                                        @else
                                            <label
                                                class="custom-file-label upload-label">{{ __('اختر صوره', ['file' => __('cover image')]) }}</label>
                                        @endif
                                    </div>
                                </div>
    
                                @if (getMediaFileExit($subcategorylevel4, 'cover_image'))
                                    <div class="col-md-2 mb-2">
                                        @php
                                            $extention = imageExtention(getSingleMedia($subcategorylevel4, 'cover_image'));
                                        @endphp
                                        <img id="subcategory_image_preview"
                                            src="{{ getSingleMedia($subcategorylevel4, 'cover_image') }}" alt="#"
                                            class="attachment-image mt-1">
                                        <a class="text-danger remove-file"
                                            href="{{ route('remove.file', ['id' => $subcategorylevel4->id, 'type' => 'cover_image']) }}"
                                            data--submit="confirm_form" data--confirmation='true' data--ajax="true"
                                            title='{{ __('messages.remove_file_title', ['name' => __('messages.image')]) }}'
                                            data-title='{{ __('messages.remove_file_title', ['name' => __('messages.image')]) }}'
                                            data-message='{{ __('messages.remove_file_msg') }}'>
                                            <i class="ri-close-circle-line"></i>
                                        </a>
                                    </div>
                                @endif
    
    
                                <div class="form-group col-md-12">
                                    {{ Form::label('description', trans('الوصف'), ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('description', null, ['class' => 'form-control textarea', 'rows' => 3, 'placeholder' => __('الوصف')]) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="custom-control custom-switch custom-control-inline">
                                        <!-- <input type="checkbox" name="is_featured" value="1" class="custom-control-input" id="is_featured"> -->
                                        {{ Form::checkbox('is_featured', $subcategorylevel4->is_featured, null, ['class' => 'custom-control-input', 'id' => 'is_featured']) }}
                                        <label class="custom-control-label"
                                            for="is_featured">{{ __('مميز') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{ Form::submit(trans('حفظ'), ['class' => 'btn btn-md btn-primary float-right']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                    <div class="col-md-4" >
                        @include('components.category-tree', ['categories' => $categories])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>
