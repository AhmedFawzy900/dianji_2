<x-master-layout>
    {{-- {{ Form::open(['route' => ['provider.destroy', $providerdata->id], 'method' => 'delete','data--submit'=>'provider'.$providerdata->id]) }} --}}
    <main class="main-area">
        <div class="main-content">
            <div class="container-fluid">
                @include('partials._provider')
                <div class="card mb-30">
                    <div class="card-body p-30">
                        <div class="col-lg-12">
                            <div class="card overview-detail mb-0">
                                <div class="card-body">
                                    <div class="">
                                        <form class="row" method="POST" action="{{ route('comission.save', $providerdata->id) }}">
                                            @csrf
                    
                                            {{-- <div class="form-group col-md-4">
                                                {{ Form::label('type', trans('messages.type').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                                <input type="text" class="form-control" name="type" value="{{ optional(optional($providerdata)->providertype)['type'] }}" readonly>
                                            </div> --}}
                                            
                                            <div class="form-group col-md-4">
                                                {{ Form::label('commission', trans('messages.commission').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                                <input type="number" class="form-control" name="commission" value="{{ $providerdata->comission ?? ''}}" required>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                {{ Form::label('commission_type', trans('Type').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                                {{ Form::select('commission_type', ['fixed' => 'Fixed', 'percentage' => 'Percentage'], $providerdata->comission_type ?? null, ['class' => 'form-control', 'required' => 'required']) }}
                                            </div>
                                            
                                            <div class="form-group d-flex justify-content-center align-items-center col-md-4 mt-3">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Save') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    {{-- {{ Form::close() }} --}}
   
</x-master-layout>