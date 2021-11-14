<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\apiNotificationResource;
use App\Order;
use App\Product;
use App\User;

class apiNotificationController extends Controller
{
    //
    public function index($id)
    {
        $user = User::find($id);
        return [
            'read' => apiNotificationResource::collection($user->readNotifications),
            'unread' => apiNotificationResource::collection($user->unReadNotifications),
        ];
    }

    public function markAsRead($id)
    {
        $user = User::find($id);

        $notifications = $user->notifications->where('notifiable_id', $id);
        foreach ($notifications as $item) {
            $user->notifications->where('id', $item->id)->markAsRead();
        }
    }

    public function getDashboardData()
    {
        $userCount = User::all()->count();
        $productCount = Product::all()->count();
        $orderCount = Order::all()->count();
        return [
            'userCount' => $userCount,
            'productCount' => $productCount,
            'orderCount' => $orderCount,
        ];
    }

}
