<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewOrderNotify;
use App\Notifications\OrderStatusNotify;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderService
{
    /**
     * product search and filter
     *
     * @param Request $request
     * @return string
     */
    public function placeAnOrder(Request $request)
    {
        $auth  = auth()->user();
        $order = new Order();
        $order->fill($request->all());
        $order->user_id        = $auth->id;
        $order->date           = Carbon::now()->toDateString();
        $order->customer_email = $auth->email;
        $order->save();
        $sub_total          = $this->storeOrderItems($order, $request->carts);
        $order->order_no    = $this->generateOrderNo($order->id);
        $order->sub_total   = $sub_total;
        $order->grand_total = $sub_total;
        $order->save();
        $this->customerOrderNotify($order);
        $this->adminOrderNotify($order);
        return $order;
    }

    /**
     * Store order items
     *
     * @param $order
     * @param $carts
     * @return float|int
     */
    private function storeOrderItems($order, $carts)
    {
        $items = [];
        $total = 0;
        foreach ($carts as $cart) {
            $product   = Product::findOrFail($cart['product_id']);
            $sub_total = $product->price * $cart['quantity'];
            $total     += $sub_total;
            $item      = [
                'product_id' => $product->id,
                'price'      => $product->price,
                'quantity'   => $cart['quantity'],
                'sub_total'  => $sub_total,
            ];
            array_push($items, $item);
        }
        $order->orderItems()->createMany($items);
        return $total;
    }

    /**
     * Order notify
     *
     * @param $order
     */
    private function customerOrderNotify($order)
    {
        $notify_details = [
            'greeting'   => "Hi {$order->user->name}",
            'body'       => "Your Order No: {$order->order_no}, Grand Total: Tk. {$order->grand_total}",
            'thanks'     => 'Thank you very much for doing business with us.',
            'actionText' => 'Order Details',
            'actionURL'  => config('app.frontend_url') . '/order/' . $order->id,
            'order_id'   => $order->order_no
        ];
         Notification::send($order->user, new NewOrderNotify($notify_details));
    }

    /**
     * Order notify
     *
     * @param $order
     */
    private function adminOrderNotify($order)
    {
        $admin   = User::first();
        $details = [
            'greeting'   => "Hi {$admin->name}, New Order notify",
            'body'       => "New Order: Customer name: {$order->user->name}, Order No: {$order->order_no}, Grand Total: Tk."
                            . number_format($order->grand_total, 2),
            'thanks'     => 'Thank you very much for doing business with us.',
            'actionText' => 'Order Details',
            'actionURL'  => config('app.url') . '/order/show/' . $order->id,
            'order_id'   => $order->order_no
        ];
        Notification::send($admin, new NewOrderNotify($details));
    }

    /**
     * order status update notify
     *
     * @param Order $order
     */
    private function orderStatusNotify(Order $order)
    {
        $notify_details = [
            'greeting'   => "Hi {$order->user->name}",
            'body'       => "Your Order Status: {$order->status}",
            'thanks'     => 'Thank you very much for doing business with us.',
            'actionText' => 'Order Details',
            'actionURL'  => config('app.frontend_url') . '/order/' . $order->id,
            'order_id'   => $order->order_no
        ];
        Notification::send($order->user, new OrderStatusNotify($notify_details));
    }

    /**
     * order status status update
     *
     * @param Order $order
     */
    public function orderStatusUpdate(Order $order, $status)
    {

        if ($status != 'Pending') {
            $history                        = $order->orderStatus
                ?: new OrderStatus();
            $history->{strtolower($status)} = Carbon::now()->toDateString();
            $order->orderStatus()->save($history);

            //when order status delivered product quantity update
            if ($status == 'Delivered')
                $this->orderProductQtyUpdate($order);
        }
        //Customer Order status update notify
        $this->orderStatusNotify($order);
    }

    /**
     * when order status delivered product quantity update
     *
     * @param Order $order
     */
    private function orderProductQtyUpdate(Order $order)
    {
        foreach ($order->orderItems as $orderItem) {
            $orderItem->product()->decrement('qty', $orderItem->quantity);
        }
    }

    /**
     * return orders with searching and filtering
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getOrdersWithSearchAndFilter(Request $request, $type = null)
    {
        $query = Order::query();
        if ($type == 'user') {
            $query->where('user_id', auth()->id());
        }
        if ($request->filled('search')) {
            $query->where('order_no','like', '%'. $request->search.'%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        return $query->latest()->paginate($request->get('per_page', config('constant.mrhPagination')));
    }
    /**
     * generate order no
     *
     * @param $patient_id
     * @return string
     */
    public function generateOrderNo($order_id)
    {
        return '0-' . Carbon::now()->format('ymd') . '-' . sprintf("%03d", $order_id);
    }
}
