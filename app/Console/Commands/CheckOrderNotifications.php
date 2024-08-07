<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Console\Command;

class CheckOrderNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:check-notifications';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for orders and send notifications if needed';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = now();

        // Orders not approved after 24 hours
        $pendingOrders = Booking::where('status', 'pending')
            ->where('created_at', '<=', $now->subHours(24))
            ->get();

            foreach ($pendingOrders as $order) {
                Notification::create([
                    'order_id' => $order->id,
                    'message' => 'Order ID ' . $order->id . ' not approved after 24 hours',
                ]);
            }
        // Orders exceeding the scheduled start time and not started
        $overdueOrders = Booking::where('date', '<=', $now)
            ->whereNull('start_at')
            ->get();

        foreach ($overdueOrders as $order) {
            Notification::create([
                'order_id' => $order->id,
                'message' => 'Order ID ' . $order->id . ' exceeded the scheduled start time and not started',
            ]);
        }
        $this->info('Order notifications checked.');
    }
}
