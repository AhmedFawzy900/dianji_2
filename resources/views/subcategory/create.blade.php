<x-master-layout>
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold">انشاء قسم فرعي جديد</h5>
                            @if($auth_user->can('category list'))
                                <a href="{{ route('subcategory.index') }}" class="float-right btn btn-sm btn-primary"><i class="fa fa-angle-double-left"></i> {{ __('رجوع') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row justify-content-center align-items-start">
                    <div class="card col-md-8">
                        <div class="card-body">
                            {{ Form::model($subcategory,['method' => 'POST','route'=>'subcategory.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'subcategory'] ) }}
                                {{ Form::hidden('id') }}
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        {{ Form::label('name',"الاسم".' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                        {{ Form::text('name',old('name'),['placeholder' => trans('الاسم'),'class' =>'form-control','required']) }}
                                        <small class="help-block with-errors text-danger"></small>
                                    </div>
    
                                    <div class="form-group col-md-4">
                                        {{ Form::label('name', __("اسم القسم الرئيسي").' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                        <br />
                                        {{ Form::select('category_id', [optional($subcategory->category)->id => optional($subcategory->category)->name], optional($subcategory->category)->id, [
                                                'class' => 'select2js form-group category',
                                                'required',
                                                'data-placeholder' => __("اختر القسم الرئيسي"),
                                                'data-ajax--url' => route('ajax-list', ['type' => 'category']),
                                            ]) }}
                                        
                                    </div>
                                    {{-- add related sub category
                                    <div class="form-group col-md-4">
                                        {{ Form::label('related_subcategory_id', __('messages.select_name', ['select' => __('related subcategory')])) }}
                                        <br />
                                        {{ Form::select('related_subcategory_id', 
                                            $allSubcategories->pluck('name', 'id'), 
                                            old('related_subcategory_id'), 
                                            ['class' => 'form-control', 'placeholder' => __('messages.select_name', ['select' => __('related subcategory')])]
                                        ) }}
                                    </div> --}}
                                    {{-- end related sub category --}}
                                    
                                    <div class="form-group col-md-4">
                                        {{ Form::label('status',trans('الحالة').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                        {{ Form::select('status',['1' => __('نشط') , '0' => __('غير نشط') ],old('status'),[ 'id' => 'role' ,'class' =>'form-control select2js','required']) }}
                                        <small class="help-block with-errors text-danger"></small>
                                    </div>
    
                                    <div class="form-group col-md-4">
                                        <label class="form-control-label" for="image">{{ __('الصوره') }} <span class="text-danger">*</span></label>
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" accept="image/*">
                                            @if($subcategory && getMediaFileExit($subcategory, 'image'))
                                            <label class="custom-file-label upload-label">{{ $subcategory->getFirstMedia('image')->file_name }}</label>
                                            @else
                                            <label class="custom-file-label upload-label">{{  __("اختر صورة") }}</label>
                                            @endif
                                        </div>
                                    </div>
    
                                    @if(getMediaFileExit($subcategory, 'image'))
                                        <div class="col-md-2 mb-2">
                                            @php
                                                $extention = imageExtention(getSingleMedia($subcategory,'image'));
                                            @endphp
                                            <img id="subcategory_image_preview" src="{{getSingleMedia($subcategory,'image')}}" alt="#" class="attachment-image mt-1">
                                                <a class="text-danger remove-file" href="{{ route('remove.file', ['id' => $subcategory->id, 'type' => 'image']) }}"
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
                                    <div class="form-group col-md-4">
                                        <label class="form-control-label" for="cover_image">{{ __('صورة غلاف') }} <span class="text-danger"></span></label>
                                        <div class="custom-file">
                                            <input type="file" name="cover_image" class="custom-file-input" accept="image/*">
                                            @if($subcategory && getMediaFileExit($subcategory, 'cover_image'))
                                            <label class="custom-file-label upload-label">{{ $subcategory->getFirstMedia('cover_image')->file_name }}</label>
                                            @else
                                            <label class="custom-file-label upload-label">{{  __("اختر صورة غلاف") }}</label>
                                            @endif
                                        </div>
                                    </div>
    
                                    @if(getMediaFileExit($subcategory, 'cover_image'))
                                        <div class="col-md-2 mb-2">
                                            @php
                                                $extention = imageExtention(getSingleMedia($subcategory,'cover_image'));
                                            @endphp
                                            <img id="subcategory_image_preview" src="{{getSingleMedia($subcategory,'cover_image')}}" alt="#" class="attachment-image mt-1">
                                                <a class="text-danger remove-file" href="{{ route('remove.file', ['id' => $subcategory->id, 'type' => 'cover_image']) }}"
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
    
                                    
                                    <div class="form-group col-md-12">
                                        {{ Form::label('description',trans('الوصف'), ['class' => 'form-control-label']) }}
                                        {{ Form::textarea('description', null, ['class'=>"form-control textarea" , 'rows'=>3  , 'placeholder'=> __('الوصف') ]) }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <!-- <input type="checkbox" name="is_featured" value="1" class="custom-control-input" id="is_featured"> -->
                                            <label class="custom-control-label" for="is_featured">{{ __('مميز')  }}
                                            </label>
                                            {{ Form::checkbox('is_featured', $subcategory->is_featured, null, ['class' => 'custom-control-input' , 'id' => 'is_featured' ]) }}
                                        </div>
                                    </div>
                                </div>
                                {{ Form::submit( trans('حفظ'), ['class'=>'btn btn-md btn-primary float-right']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        @include('components.category-tree', ['categories' => $categories])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>