@extends('backend.layouts.master')


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Order Details</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Order Details</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content bg-white">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header card-default">
                        Order Details
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item bg-info text-white">Order Details</li>
                                    <li class="list-group-item"><b>Order No: </b> <span
                                            class="float-right"> {{ $order->order_no }}</span></li>
                                    <li class="list-group-item"><b>Subtotal: </b> <span
                                            class="float-right"> {{ $order->sub_total }}</span></li>
                                    <li class="list-group-item"><b>Total Quantity: </b> <span
                                            class="float-right"> {{ $order->total_quantity }}</span></li>
                                    <li class="list-group-item"><b>Grand Total: </b> <span
                                            class="float-right"> {{ $order->grand_total }}</span>
                                    </li>
                                    <li class="list-group-item"><b>Status: </b> <span
                                            class="float-right"> {{ $order->status }}</span></li>
                                    <li class="list-group-item"><b>Date: </b> <span
                                            class="float-right"> {{ date_format(date_create($order->date),"d-m-Y") }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item bg-info text-white">Delivery Details</li>
                                    <li class="list-group-item"><b>Name: </b> <span
                                            class="float-right"> {{ $order->user->name }}</span></li>
                                    <li class="list-group-item"><b>Email: </b> <span
                                            class="float-right"> {{ $order->user->email }}</span></li>
                                    <li class="list-group-item"><b>Delivery Address: </b> <span
                                            class="float-right"> {{ $order->shipping_address }}</span>
                                    <li class="list-group-item"><b>Note: </b> <span
                                            class="float-right"> {{ $order->note }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-12">
                                <div class="card mt-5 mb-0">
                                    <div class="card-header bg-info text-white">
                                        Order Item
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>SI</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>subtotal</th>
                                                <th>Image</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $i=1 @endphp
                                            @foreach($order->orderItems as $item)
                                                <tr>
                                                    <th>{{$i++}}</th>
                                                    <th>{{ $item->product->name }}</th>
                                                    <th>{{ $item->price }}</th>
                                                    <th>{{ $item->quantity }}</th>
                                                    <th>{{ $item->sub_total }}</th>
                                                    <td><img class="size-50"
                                                             src="{{asset('storage/'.$item->product->image)}}"></td>
                                                    </th>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
