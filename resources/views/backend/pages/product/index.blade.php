@extends('backend.layouts.master')


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Product</li>
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
                        Product List
                        <a class="btn btn-info float-right" href="{{route('product.create')}}"><i
                                class="fa fa-plus"></i></a>
                    </div>

                    <div class="card-body ">
                        <form method="get" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="name" value="{{Request::get('name')}}">
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
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @php $i=1 @endphp
                            @foreach($data as $row)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->price}}</td>
                                    <td>{{$row->qty}}</td>
                                    <td><img class="size-50" src="{{asset('storage/'.$row->image)}}"></td>
                                    <td>
                                        <a href="{{ route('product.edit', $row->id)}} " class="btn btn-info"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="{{ route('product.destroy', $row->id)}} " class="btn btn-danger"
                                           onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
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
