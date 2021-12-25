<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use Illuminate\Http\Request;

class DeliveredOrderController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $data = DeliveryOrder::with('user')->orderBy('id', 'desc');
        if ($request->order_no){
            $data = $data->where('order_no', 'like', '%'.$request->order_no.'%');
        }
        $data= $data->paginate(2);
        return view('backend.pages.order.index', ['data' => $data, 'type'=>'delivered']);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $id)
    {
        $order = DeliveryOrder::with('orderItems', 'orderStatus', 'user')->find($id);
        return view('backend.pages.order.show', ['order' => $order]);
    }
}
