@php
    $sitesetup = App\Models\Setting::where('type','site-setup')->where('key', 'site-setup')->first();
    $datetime = $sitesetup ? json_decode($sitesetup->value) : null;
@endphp
{{ Form::hidden('id',$bookingdata->id) }}

<div class="card-body p-0">
    <div class="border-bottom pb-3 d-flex justify-content-between align-items-center gap-3 flex-wrap">
        <div>
            <h3 class="c1 mb-2">{{__('messages.book_id')}} {{ '#' . $bookingdata->id ?? '-'}}</h3>
            <p class="opacity-75 fz-12">
                {{__('')}} {{ date("$datetime->date_format / $datetime->time_format", strtotime($bookingdata->created_at)) ?? '-'}}
            </p>
        </div>
        <div class="d-flex flex-wrap flex-xxl-nowrap gap-3" data-select2-id="select2-data-8-5c7s">
            <div class="w3-third">
                @if($bookingdata->handymanAdded->count() == 0)
                    <!-- @hasanyrole('admin|demo_admin|provider')
                        <a href="{{ route('booking.assign_form',['id'=> $bookingdata->id ]) }}"
                        class="float-right btn btn-sm btn-primary loadRemoteModel"><i class="lab la-telegram-plane"></i>
                        {{ __('assign to handyman') }}</a>
                    @endhasanyrole -->
                    @hasanyrole('admin|demo_admin|provider')
                        <a href="{{ route('booking.assign_provider_form',['id'=> $bookingdata->id ]) }}"
                            class="float-right btn mr-2 btn-sm btn-primary loadRemoteModel"><i class="lab la-telegram-plane"></i>
                            {{ __('اسناد لمزود اخر') }}</a>
                    @endhasanyrole
                @endif
            </div>
            @if($bookingdata->payment_id !== null)
            <a href="{{route('invoice_pdf',$bookingdata->id)}}" class="btn btn-primary" target="_blank">
                <i class="ri-file-text-line"></i>

                {{__('messages.invoice')}}
            </a>
            @endif
        </div>
    </div>
    <div class="pay-box">
        <div class="pay-method-details">
            <h4 class="mb-2">{{__('طريقة الدفع')}}</h4>
            <h5 class="c1 mb-2">{{__('الدفع عند الانتهاء من الخدمه')}}</h5>
            <p><span>{{__('المبلغ')}} :
                </span><strong>{{!empty($bookingdata->total_amount) ? getPriceFormat($bookingdata->total_amount): 0}}</strong>
            </p>
        </div>
        <div class="pay-booking-details">
            <div class="row mb-2">
                <div class="col-sm-6"><span>{{__('حالة الحجز')}} :</span></div>
                <div class="col-sm-6 align-text">
                    <span class="c1" id="booking_status__span">{{  App\Models\BookingStatus::bookingStatus($bookingdata->status)}}</span>      
                </div>
                @if($bookingdata->status === "cancelled")
                    <div class="col-sm-6"><span>{{__('السبب')}} :</span></div>
                     <div class="col-sm-6 align-text">
                        <span class="c1" id="booking_status__span">{{ $bookingdata->reason }}</span>
                    </div>
                @endif
            </div>
            <div class="row mb-2">
                <div class="col-sm-6"> <span>{{__('حالة الدفع')}} : </span></div>
                <div class="col-sm-6 align-text">
                    <span id="payment_status__span"
                        class="{{ optional($bookingdata->payment)->payment_status == 'paid' ? 'text-success' : 'text-danger' }}">
                        {{ ucwords(str_replace('_', ' ',  optional($bookingdata->payment)->payment_status ?: 'pending'))}}
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h5>
                        {{__('بيانات الحجز')}} :
                    </h5>
                </div>
                <div class="col-sm-6 align-text">
                    <span id="service_schedule__span">{{ date("$datetime->date_format / $datetime->time_format", strtotime($bookingdata->date)) ?? '-'}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="py-3 d-flex gap-3 flex-wrap customer-info-detail mb-2">
        <div class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
            <h4 class="mb-2">{{__('بيانات العميل')}}</h4>
            <h5 class="c1 mb-3">{{optional($bookingdata->customer)->display_name ?? '-'}}</h5>
            <ul class="list-info">
                <li>
                    <span class="material-icons customer-info-text">{{__('رقم الهاتف')}}</span>
                    <a href="tel:{{optional($bookingdata->customer)->contact_number}}" class="customer-info-value">
                        <p class="mb-0">{{ optional($bookingdata->customer)->contact_number ?? '-' }}</p>
                    </a>
                </li>
                <li>
                    <span class="material-icons  customer-info-text">{{__('العنوان')}}</span>
                    <p class="customer-info-text">{{ optional($bookingdata->customer)->address ?? '-' }}</p>
                </li>
            </ul>
        </div>

        <div class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
            <h4 class="mb-2">{{__('بيانات المزود')}}</h4>
            <h5 class="c1 mb-3">{{optional($bookingdata->provider)->display_name ?? '-'}}</h5>
            <ul class="list-info">
                <li>
                    <span class="material-icons customer-info-text">{{__('رقم الهاتف')}}</span>
                    <a href="tel:{{optional($bookingdata->provider)->contact_number}}" class="customer-info-value">
                        <p class="mb-0">{{ optional($bookingdata->provider)->contact_number ?? '-' }}</p>
                    </a>
                </li>
                <li>
                    <span class="material-icons customer-info-text">{{__('العنوان')}}</span>
                    <p class="customer-info-text">{{ optional($bookingdata->provider)->address ?? '-' }}</p>
                </li>
            </ul>
        </div>

        @if(count($bookingdata->handymanAdded) > 0)
        <div class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
            @foreach($bookingdata->handymanAdded as $booking)
            <h4 class="mb-2">{{__('بيانات العامل')}}</h4>
            <h5 class="c1 mb-3">{{optional($booking->handyman)->display_name ?? '-'}}</h5>
            <ul class="list-info">
                <li>
                    <span class="material-icons  customer-info-text">{{__('رقم الهاتف')}}</span>
                    <a href="" class=" customer-info-value">
                        <p class="mb-0">{{optional($booking->handyman)->contact_number ?? '-'}}</p>
                    </a>
                </li>
                <li>
                    <span class="material-icons  customer-info-text">{{__('العنوان')}}</span>
                    <p class=" customer-info-value">{{optional($booking->handyman)->address ?? '-'}}</p>
                </li>
            </ul>
            @endforeach
        </div>
        @endif
    </div>
    @if($bookingdata->bookingExtraCharge->count() > 0 )
        <h3 class="mb-3 mt-3">{{__('messages.extra_charge')}}</h3>
        <div class="table-responsive border-bottom">
            <table class="table text-nowrap align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-lg-3">{{__('الخدمة')}}</th>
                        <th>{{__('السعر')}}</th>
                        <th>{{__('الكمية')}}</th>
                        <th class="text-end">{{__('المبلغ')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookingdata->bookingExtraCharge as $chrage)
                    <tr>
                        <td class="text-wrap ps-lg-3">
                            <div class="d-flex flex-column">
                                <a href="" class="booking-service-link fw-bold">{{$chrage->title}}</a>
                            </div>
                        </td>
                        <td>{{getPriceFormat($chrage->price)}}</td>
                        <td>{{$chrage->qty}}</td>
                        <td class="text-end">{{getPriceFormat($chrage->price * $chrage->qty)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @php
        $addonTotalPrice = 0;
    @endphp

    @if($bookingdata->bookingAddonService->count() > 0 )
        <h3 class="mb-3 mt-3">{{__('messages.service_addon')}}</h3>
        <div class="table-responsive border-bottom">
            <table class="table text-nowrap align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-lg-3">{{__('الخدمة')}}</th>
                        <th>{{__('السعر')}}</th>
                        <th class="text-end">{{__('المبلغ')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookingdata->bookingAddonService as $addonservice)
                        @php
                            $addonTotalPrice += $addonservice->price;
                        @endphp
                    <tr>
                        <td class="text-wrap ps-lg-3">
                            <div class="d-flex flex-column">
                                <a href="" class="booking-service-link fw-bold">{{$addonservice->name}}</a>
                            </div>
                        </td>
                        <td>{{getPriceFormat($addonservice->price)}}</td>
                        <td class="text-end">{{getPriceFormat($addonservice->price)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <h3 class="mb-3 mt-3">{{__('messages.booking_summery')}}</h3>
    <div class="table-responsive border-bottom">
        <table class="table text-nowrap align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-lg-3">{{__('الخدمة')}}</th>
                    <th>{{__('السعر')}}</th>
                    <th>{{__('الكمية')}}</th>
                    <th class="text-end">{{__('المبلغ')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-wrap ps-lg-3">
                        <div class="d-flex flex-column">
                            <a href=""
                                class="booking-service-link fw-bold">{{optional($bookingdata->service)->name ?? '-'}}</a>
                        </div>
                    </td>
                    <td>{{ isset($bookingdata->amount) ? getPriceFormat($bookingdata->amount) : 0 }}</td>
                    <td>{{!empty($bookingdata->quantity) ? $bookingdata->quantity : 0}}</td>
                    <td class="text-end">{{getPriceFormat($bookingdata->final_total_service_price)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row justify-content-end mt-3">
        <div class="col-sm-10 col-md-6 col-xl-5">
            <div class="table-responsive bk-summary-table">
                <table class="table-sm title-color align-right w-100">
                    <tbody>
                        <tr>
                            <td>{{__('السعر')}}</td>
                            <td class="bk-value">{{getPriceFormat($bookingdata->service->price)}} * {{$bookingdata->quantity}} = {{getPriceFormat($bookingdata->final_total_service_price)}}</td>
                        </tr>
                        @if($bookingdata->bookingPackage == null)
                        <tr>
                            <td>{{__('تخفيض')}} ({{$bookingdata->discount}}% off)</td>
                            <td class="bk-value text-success">-{{getPriceFormat($bookingdata->final_discount_amount)}}</td>
                        </tr>
                        @endif
                        @if($bookingdata->couponAdded != null)
                        <tr>
                            <td>{{__('كوبون')}} ({{($bookingdata->couponAdded->code)}})</td>
                            <td class="bk-value text-success">-{{ getPriceFormat($bookingdata->final_coupon_discount_amount) }}</td>
                        </tr>
                        @endif
                        <tr class="grand-sub-total">
                            <td>{{__('المجموع')}}</td>
                            <td class="bk-value">{{getPriceFormat($bookingdata->final_sub_total)}}</td>
                        </tr>
                         
                        @if($bookingdata->bookingExtraCharge->count() > 0 )
                        <tr>
                            <td>{{__('التوصيات')}} </td>
                            <td class="text-right text-success">+{{getPriceFormat($bookingdata->getExtraChargeValue())}}</td>
                        </tr>
                        @endif

                        @if($bookingdata->bookingAddonService->count() > 0 )
                        <tr>
                            <td>{{__('الاضافات')}} </td>
                            <td class="text-right text-success">+{{getPriceFormat($addonTotalPrice)}}</td>
                        </tr>
                        @endif
                      
                        <tr>
                            <td>{{__('الضريبه')}}</td>
                            <td class="text-right text-danger">{{getPriceFormat($bookingdata->final_total_tax)}}</td>
                        </tr>
                     
                      
                        <tr class="grand-total">
                            <td><strong>{{__('المبلغ النهائي')}}</strong></td>
                            <td class="bk-value">
                                <h3>{{isset($bookingdata->bookingAddonService) ? getPriceFormat($bookingdata->total_amount+$addonTotalPrice) : getPriceFormat($bookingdata->total_amount)}}</h3>
                            </td>
                        </tr>
                        @if($bookingdata->service->is_enable_advance_payment == 1 )
                        <tr>
                            <td>{{__('طرق الدفع المتقدمة')}} ({{$bookingdata->service->advance_payment_amount}}%)</td>
                            <td class="text-right">{{getPriceFormat($bookingdata->advance_paid_amount)}}</td>
                        </tr>
                        <tr>
                            <td>{{__('المبلغ المتبقي')}}</td>
                            <td class="text-right">{{getPriceFormat($bookingdata->total_amount - $bookingdata->advance_paid_amount )}}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script>
$(document).on('change', '.bookingstatus', function() {

    var status = $(this).val();

    var id = $(this).attr('data-id');
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "{{ route('bookingStatus.update', ':id') }}".replace(':id', id),
        data: {
            'status': status,
            'bookingId': id
        },
        success: function(data) {}
    });
})

$(document).on('change', '.paymentStatus', function() {

    var status = $(this).val();

    var id = $(this).attr('data-id');
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "{{ route('bookingStatus.update', ':id') }}".replace(':id', id),
        data: {
            'status': status,
            'bookingId': id
        },
        success: function(data) {}
    });
})
</script>