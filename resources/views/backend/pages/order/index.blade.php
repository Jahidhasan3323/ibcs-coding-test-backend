@extends('backend.layouts.master')


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Order</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Order</li>
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
                        Order List
                    </div>
                    <div class="card-body ">
                        <form method="get" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="order_no" value="{{Request::get('order_no')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-info">Search</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="card-body bg-white">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <th>SI</th>
                            <th>Order</th>
                            <th>Subtotal</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                            <th>User</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @php $i=1 @endphp
                            @foreach($data as $row)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$row->order_no}}</td>
                                    <td>{{$row->sub_total}}</td>
                                    <td>{{$row->grand_total}}</td>
                                    <td>

                                        @if ($row->status !='Delivered')
                                            <input type="hidden" value="{{$row->id}}" id="orderId">
                                            <select
                                                class="form-control orderStatus"
                                                id="orderStatus{{$row->id}}">
                                                <option value="Pending">Pending</option>
                                                <option value="Approved">Approved</option>
                                                <option value="Processing">Processing</option>
                                                <option value="Shipped">Shipped</option>
                                                <option value="Delivered">Delivered</option>
                                                <option value="Rejected">Rejected</option>
                                            </select>
                                        @else
                                            {{$row->status}}
                                        @endif
                                    </td>
                                    <td>
                                        <b>Name: </b> <span>{{$row->user->name}}</span><br>
                                        <b>Email: </b> <span>{{$row->user->email}}</span>
                                    </td>
                                    <td>
                                        <a href="{{ $type == "all" ? route('order.show', $row->id) : ($type == "delivered" ? route('delivered.order.show', $row->id)  : "") }} " class="btn btn-info"><i
                                                class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                <script>
                                    document.getElementById('orderStatus{{$row->id}}').value = "{{$row->status}}"
                                </script>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="float-right mt-3">
                            {{$data->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection
@section('script')
    <script>
        $(".orderStatus").change(function () {
            let status =$(this).val()
            let orderId = $(this).parent().find('#orderId').val()
            $.ajax({
                type:'get',
                url:`order/update-status/${orderId}/${status}`,
                // data:{ "status":status, "orderId":orderId},
                success:function(data){
                    window.location.reload()
                },
                error:function(){
                }
            });
        });
    </script>
@endsection
