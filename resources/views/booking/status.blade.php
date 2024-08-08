@php
$extraValue = 0;
$sitesetup = App\Models\Setting::where('type','site-setup')->where('key', 'site-setup')->first();
$datetime = $sitesetup ? json_decode($sitesetup->value) : null;
@endphp
<div class="border-bottom pb-3">
    <div class="row pb-1 gy-2">
        <div class="col-6 col-lg-3">
            <div>
                <h4 class="c1 mb-2 pb-1">{{__('messages.book_placed')}}</h4>
                <p class="opacity-75">{{ date("$datetime->date_format / $datetime->time_format", strtotime($bookingdata->created_at))}}</p>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div>
                <h4 class="c1  mb-2 pb-1">{{__('messages.booking_status')}}</h4>
                <p class="opacity-75">{{  App\Models\BookingStatus::bookingStatus($bookingdata->status)}}</p>
                <!-- <p class="opacity-75">{{ $bookingdata->status}}</p> -->
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div>
                <h4 class="c1  mb-2 pb-1">{{__('messages.payment_status')}}</h4>
                <p class="opacity-75">{{ ucwords(str_replace('_', ' ',  optional($bookingdata->payment)->payment_status ?: 'pending'))}}</p>
                <!-- <p class="opacity-75">{{ optional($bookingdata->payment)->payment_status ?: 'pending' }}</p> -->
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div>
                <h4 class="c1  mb-2 pb-1">{{__('messages.booking_amount')}}</h4>
                <p class="opacity-75">{{!empty($bookingdata->total_amount) ? getPriceFormat($bookingdata->total_amount + $extraValue ): 0}}</p>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-between mt-5">
    <div class="col-md-6 col-xl-4 d-flex justify-content-center customer-info-detail">
        <div class="d-flex flex-column gap-30 w-100">
            @if($bookingdata->handymanAdded->count() !== 0 )
            <div class="c1-light-bg radius-10 py-3 px-3">
               
                    @foreach($bookingdata->handymanAdded as $booking)
                    <h4 class="mb-2">{{__('messages.handyman_information')}}</h4>
                    <h5 class="c1 mb-3">{{optional($booking->handyman)->display_name ?? '-'}}</h5>
                    <ul class="list-info">
                        <li>
                            <span class="material-icons customer-info-text">{{__('messages.phone_information')}}</span>
                            <a href="tel:{{optional($booking->handyman)->contact_number}}" class="customer-info-value">
                                <p class="mb-0">{{optional($booking->handyman)->contact_number ?? '-'}}</p>
                            </a>
                        </li>
                        <li>
                            <span class="material-icons customer-info-text">{{__('messages.address')}}</span>
                            <p class="customer-info-value">{{optional($booking->handyman)->address ?? '-'}}</p>
                        </li>
                    </ul>
                    @endforeach
             
            </div>
            @endif
            <div class="c1-light-bg radius-10 py-3 px-3">
                <h4 class="mb-2">{{__('messages.provider_information')}}</h4>
                <h5 class="c1 mb-3">{{optional($bookingdata->provider)->display_name ?? '-'}}</h5>
                <ul class="list-info">
                    <li>
                        <span class="material-icons customer-info-text">{{__('messages.phone_information')}}</span>
                        <a href="tel:{{ optional($bookingdata->provider)->contact_number }}" class="customer-info-value">
                            <p class="mb-0">{{ optional($bookingdata->provider)->contact_number ?? '-' }}</p>
                        </a>
                    </li>
                    <li>
                        <span class="material-icons customer-info-text">{{__('messages.address')}}</span>
                        <p class="customer-info-value">{{ optional($bookingdata->provider)->address ?? '-' }}</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4 mb-5 mb-md-0">
        @if(count($bookingdata->bookingActivity) > 0)
        <div class="col-md-5 col-lg-12">
            <div class="card">
                <div class="card-body activity-height">
                    <ul class="iq-timeline">
                        <?php date_default_timezone_set($admin->time_zone ?? 'UTC'); ?>
                        @foreach($bookingdata->bookingActivity as $activity)
                        <li>
                            <div class="timeline-dots"></div>
                            <div class="d-flex justify-content-between gap-2">
                            <h6 class="mb-1">{{str_replace("_"," ",ucfirst($activity->activity_type))}}</h6>
                            <small class="mb-1">{{ date("$datetime->date_format / $datetime->time_format", strtotime($activity->datetime))}}</small>
                            </div>
                            <div class="d-inline-block w-100">
                                <p>{{$activity->activity_message}}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<br />
<br />
{{-- here we will put the button edit that will show form  --}}
@if (Auth::user()->user_type == 'admin')  
    <div class="d-flex justify-content-end">
        <button type="button" id="showFieldsButton" class="btn btn-primary">edit</button>
    </div>
@endif

<br />
{{-- this form will be for update the request status and payment status will be hidden but when i click in update button it appear and it can seen by admin --}}
<div class="hidden" id="request_status">
    <div class="col-md-12 form-group">
        <form id="updateForm" method="POST" action="{{ route('bookingStatus.update', $bookingdata->id) }}">
            @csrf
            {{-- @method('PUT') --}}
        <input type="text" name="booking_id" value="{{$bookingdata->id}}" id="booking_id" hidden>
        <div class="row">
            <div class=" form-group col-md-4 ">
                {{-- <label class="form-label" for="request_status">Request Status</label> --}}
                <select class="w-100 form-control " name="payment_status" id="request_status" >
                    <option value="" selected disabled>--update request status--</option>
                    <option  value="pending" {{ App\Models\BookingStatus::bookingStatus($bookingdata->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="accept" {{ App\Models\BookingStatus::bookingStatus($bookingdata->status) == 'accept' ? 'selected' : '' }}>Accepted</option>
                    <option value="cancelled" {{ App\Models\BookingStatus::bookingStatus($bookingdata->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="waiting" {{ App\Models\BookingStatus::bookingStatus($bookingdata->status) == 'waiting' ? 'selected' : '' }}>Waiting</option>
                    <option value="rejected" {{ App\Models\BookingStatus::bookingStatus($bookingdata->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="on_going" {{ App\Models\BookingStatus::bookingStatus($bookingdata->status) == 'on_going' ? 'selected' : '' }}>On Going</option>
                    <option value="in_progress" {{ App\Models\BookingStatus::bookingStatus($bookingdata->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="hold" {{ App\Models\BookingStatus::bookingStatus($bookingdata->status) == 'hold' ? 'selected' : '' }}>Hold</option>
                    <option value="completed" {{ App\Models\BookingStatus::bookingStatus($bookingdata->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
        
            <div class=" form-group col-md-4">
                {{-- <label for="payment_status">Payment Status</label> --}}
                <select class="w-100 form-control " name="payment_status" id="payment_status" >
                    <option value="" selected disabled>--update payment status--</option>
                    <option value="pending" {{ optional($bookingdata->payment)->payment_status == 'pending' ? 'selected' : '' }} >Pending</option>
                    <option value="failed" {{ optional($bookingdata->payment)->payment_status == 'failed' ? 'selected' : '' }}>Failed</option> 
                    <option value="paid" {{ optional($bookingdata->payment)->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div class="d-flex justify-content-end col-md-4 align-items-center">
                <button class="btn btn-primary" type="submit" id="submitButton">save</button>
            </div>
        </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('showFieldsButton').addEventListener('click', function() {
        const requestStatus = document.getElementById('request_status');
        requestStatus.classList.toggle('hidden');
    });
</script>

<style>
    .hidden {
        display: none;
    }
</style>
