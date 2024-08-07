<x-master-layout>
    <div class="container-fluid">
        @if($notifications->isNotEmpty())
            @foreach($notifications as $notification)
                <div class="alert alert-warning d-flex justify-content-between align-items-center">
                            <a href="/booking/{{ $notification->order_id }}" class="">{{ $notification->message }}</a>
                            <div class="d-flex gap-2">
                                <form method="POST"  action="{{ route('notifications.read', $notification->id) }}">
                                    @csrf
                                    <button class="mark-as-read btn btn-sm btn-primary" data-id="{{ $notification->id }}">Mark as Read</button>
                                </form>
                                <form method="POST" action="{{ route('notifications.delete', $notification->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete-notification btn btn-sm btn-danger" data-id="{{ $notification->id }}">Delete</button>
                                </form>
                            </div>
                </div>
            @endforeach  
        @endif



    </div>
</x-master-layout>