<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class BookingNotificationController extends Controller
{
    //  show notification page 
    public function notifications()
    {
        $notifications = Notification::where('is_read', false)->get(); // Fetch unread notifications
        
        return view('booking.notifications')->with('notifications', $notifications);
    }

    //  mark notification as read
    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        $notification->is_read = true;
        $notification->save();
        return redirect()->back()->with('success', 'Notification marked as read');
    }

    // delete notification
    public function destroy($id)
    {
        $notification = Notification::find($id);
        $notification->delete();
        return redirect()->back()->with('success', 'Notification deleted successfully');
    }
}
