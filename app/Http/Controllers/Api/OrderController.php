<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\DeliveryOrder;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $orders = (new OrderService())->getOrdersWithSearchAndFilter($request, 'user');
        return OrderResource::collection($orders);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function store(Request $request)
    {
        try {
            $order = (new OrderService())->placeAnOrder($request);
            return response()->json(['status' => 'success', 'message' => "Order placed successfully", 'data' => $order], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return OrderResource
     */
    public function show($id, Request $request)
    {
        $order = Order::findOrFail($id);
        if ($request->type == 'delivered') {
            $order = DeliveryOrder::findOrFail($id);
        }
        return new OrderResource($order->where('user_id', auth()->id())->first());
    }


    /**
     * @param $orderID
     * @param $status
     * @return JsonResponse
     */
    public function updateOrderStatus($orderID, $status): JsonResponse
    {
        $order=Order::find($orderID);
        $order->status = $status;
        $order->save();
        //Store and updated order status history with date
        (new OrderService())->orderStatusUpdate($order, $status);
        return response()->json(['status' => 'success', 'message' => "Order status updated successfully"], 200);
    }

}
