@extends('backend.layouts.master')


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">product</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content ">
            <div class="container-fluid ">
                <div class="card">
                    <div class="card-header card-default">
                        Add Product
                    </div>
                    <div class="card-body bg-white">
                        <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">
                                    <strong>{{$errors->first('name')}}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" step="0.0001" class="form-control" id="price" name="price" value="{{old('price')}}">
                                @if ($errors->has('price'))
                                    <span class="text-danger">
                                    <strong>{{$errors->first('price')}}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="qty" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="qty" name="qty" value="{{old('qty')}}">
                                @if ($errors->has('qty'))
                                    <span class="text-danger">
                                    <strong>{{$errors->first('qty')}}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control"  id="image" name="image" value="{{old('image')}}">
                                @if ($errors->has('image'))
                                    <span class="text-danger">
                                    <strong>{{$errors->first('image')}}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="descriptin" class="form-label">Description</label>
                                <textarea class="form-control" name="description">{{old('description')}}</textarea>
                                @if ($errors->has('description'))
                                    <span class="text-danger">
                                    <strong>{{$errors->first('description')}}</strong>
                                </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
