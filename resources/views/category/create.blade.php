<x-master-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold">انشاء قسم</h5>
                            @if ($auth_user->can('category list'))
                                <a href="{{ route('category.index') }}" class="float-right btn btn-sm btn-primary"><i
                                        class="fa fa-angle-double-left"></i> {{ __('رجوع') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        {{ Form::model($categorydata, ['method' => 'POST', 'route' => 'category.store', 'enctype' => 'multipart/form-data', 'data-toggle' => 'validator', 'id' => 'category']) }}
                        {{ Form::hidden('id') }}
                        <div class="row">
                            <div class="form-group col-md-4">
                                {{ Form::label('name', __('الاسم') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('name', old('name'), ['placeholder' => __('الاسم'), 'class' => 'form-control', 'required', 'title' => 'Please enter alphabetic characters and spaces only']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('color', trans('اللون') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::color('color', null, ['placeholder' => trans('messages.color'), 'class' => 'form-control', 'id' => 'color']) }}
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('status', trans('الحاله') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::select('status', ['1' => __('messages.active'), '0' => __('messages.inactive')], old('status'), ['id' => 'role', 'class' => 'form-control select2js', 'required']) }}
                            </div>

                            <div class="form-group col-md-8">
                                <label class="form-control-label" for="image">{{ __('الصورة') }} <span
                                        class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" onchange="preview()"
                                        accept="image/*">
                                    @if ($categorydata && getMediaFileExit($categorydata, 'image'))
                                        <label
                                            class="custom-file-label upload-label">{{ $categorydata->getFirstMedia('image')->file_name }}</label>
                                    @else
                                        <label
                                            class="custom-file-label upload-label">{{ __('messages.choose_file', ['file' => __('صوره')]) }}</label>
                                    @endif
                                </div>
                            </div>
                            @if (getMediaFileExit($categorydata, 'image'))
                                <div class="col-md-3 mb-2">
                                    @php
                                        $extention = imageExtention(getSingleMedia($categorydata, 'image'));
                                    @endphp
                                    <img id="category_image_preview" src="{{ getSingleMedia($categorydata, 'image') }}"
                                        alt="#" class="attachment-image mt-1"
                                        style="background-color:{{ $extention == 'svg' ? $categorydata->color : '' }}">
                                    <a class="text-danger remove-file"
                                        href="{{ route('remove.file', ['id' => $categorydata->id, 'type' => 'image']) }}"
                                        data--submit="confirm_form" data--confirmation='true' data--ajax="true"
                                        title='{{ __('messages.remove_file_title', ['name' => __('messages.image')]) }}'
                                        data-title='{{ __('messages.remove_file_title', ['name' => __('messages.image')]) }}'
                                        data-message='{{ __('messages.remove_file_msg') }}'>
                                        <i class="ri-close-circle-line"></i>
                                    </a>
                                </div>
                            @endif
                            <img id="category_image_preview" src="" width="150px" />


                            <div class="form-group col-md-8">
                                <label class="form-control-label" for="cover_image">صوره الغلاف</label>
                                <div class="custom-file">
                                    <input type="file" name="cover_image" class="custom-file-input"
                                        onchange="previewCoverImage()" accept="image/*">
                                    @if ($categorydata && getMediaFileExit($categorydata, 'cover_image'))
                                        <label
                                            class="custom-file-label upload-label">{{ $categorydata->getFirstMedia('cover_image')->file_name }}</label>
                                    @else
                                        <label
                                            class="custom-file-label upload-label">{{ __('messages.choose_file', ['file' => __('صوره الغلاف')]) }}</label>
                                    @endif
                                </div>
                            </div>
                            @if (getMediaFileExit($categorydata, 'cover_image'))
                                <div class="col-md-3 mb-2">
                                    @php
                                        $coverExtension = imageExtention(getSingleMedia($categorydata, 'cover_image'));
                                    @endphp
                                    <img id="cover_image_preview"
                                        src="{{ getSingleMedia($categorydata, 'cover_image') }}" alt="#"
                                        class="attachment-image mt-1"
                                        style="background-color:{{ $coverExtension == 'svg' ? $categorydata->color : '' }}">
                                    <a class="text-danger remove-file"
                                        href="{{ route('remove.file', ['id' => $categorydata->id, 'type' => 'cover_image']) }}"
                                        data--submit="confirm_form" data--confirmation='true' data--ajax="true"
                                        title='{{ __('messages.remove_file_title', ['name' => __('messages.cover_image')]) }}'
                                        data-title='{{ __('messages.remove_file_title', ['name' => __('messages.cover_image')]) }}'
                                        data-message='{{ __('messages.remove_file_msg') }}'>
                                        <i class="ri-close-circle-line"></i>
                                    </a>
                                </div>
                            @endif
                            <img id="cover_image_preview" src="" width="150px" />

                            <!-- Zones Field (Multiple Select) -->
                            <div class="row">
                                <div class="form-group col-md-11 ml-3">
                                    {{ Form::label('zones', 'المناطق' . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                    {{-- {{ Form::select('zones[]', $zonesList, old('zones'), ['class' => 'form-control select2js', 'multiple' => 'multiple', 'required']) }} --}}
                                    {{ Form::text('zones', old('zones'), ['class' => 'form-control', 'required' ,'placeholder' => 'ادخل المناطق']) }}
                                    <small class="help-block with-errors text-danger"></small>
                                </div>


                                {{-- add commision field that thake the % of commistion --}}
                                    
                                <div class="form-group col-md-11 ml-3">
                                    {{ Form::label('commission', 'العموله %' . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                    {{ Form::number('commission', old('commission'), ['class' => 'form-control', 'required' ,'placeholder' => 'ادخل العموله %']) }}
                                    <small class="help-block with-errors text-danger"></small>
                                </div>

                                <div class="form-group col-md-11 ml-3">
                                    {{ Form::label('description', "الوصف", ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('description', null, ['class' => 'form-control textarea', 'rows' => 3, 'placeholder' => __('الوصف')]) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 ml-3">
                                    <div class="custom-control custom-switch">
                                        <!-- <input type="checkbox" name="is_featured" value="1" class="custom-control-input" id="is_featured"> -->
                                        {{ Form::checkbox('is_featured', $categorydata->is_featured, null, ['class' => 'custom-control-input', 'id' => 'is_featured']) }}
                                        <label class="custom-control-label"
                                            for="is_featured">{{ __('عنصر مميز') }}
                                        </label>
                                    </div>
                                </div>


                            </div>
                            <div class="row w-100 justify-content-end">
                                {{ Form::submit("حفظ", ['class' => 'btn btn-md btn-primary ']) }}
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- add tree --}}
    
            @include('components.category-tree', ['categories' => $categories])
            {{-- end tree --}}
        </div>


        <script>
            function preview() {
                category_image_preview.src = URL.createObjectURL(event.target.files[0]);
            }
            function previewCoverImage() {
                cover_image_preview.src = URL.createObjectURL(event.target.files[0]);
            }
        </script>
</x-master-layout>
