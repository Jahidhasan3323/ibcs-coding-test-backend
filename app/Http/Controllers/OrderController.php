<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;


class OrderController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $data = Order::with('user')->orderBy('id', 'desc');
        if ($request->order_no){
            $data = $data->where('order_no', 'like', '%'.$request->order_no.'%');
        }
        $data= $data->paginate(10);
        return view('backend.pages.order.index', ['data' => $data, 'type'=>'all']);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $id)
    {
        $order = Order::with('orderItems', 'orderStatus', 'user')->find($id);
        return view('backend.pages.order.show', ['order' => $order]);
    }





}
