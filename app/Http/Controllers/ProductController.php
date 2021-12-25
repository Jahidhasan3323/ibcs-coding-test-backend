<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Product::query();
        if ($request->name) {
            $data = $data->where('name', 'like', "%" . $request->name . "%");
        }
        $data = $data->paginate(10);
        return view('backend.pages.product.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'name'  => 'required',
            'qty'   => 'required | numeric',
            'price' => 'required | numeric',
            'image' => 'required | mimes:jpg,png,jpeg,svg',
        ]);
        if ($request->image) {
            $image = $_FILES["image"]["name"];
            $file_tmp = $_FILES["image"]["tmp_name"];
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            $data['image'] = $request->file('image')->storeAs('product/', 'image' . rand(10, 100000) . '.' . $ext);
        }
        Product::create($data);
        return redirect('product')->with('success', 'Data stored successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Product::where('id', $id)->first();
        return view('backend.pages.product.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method');
        $this->validate($request, [
            'name'  => 'required',
            'qty'   => 'required | numeric',
            'price' => 'required | numeric',
            'image' => 'mimes:jpg,png,jpeg,svg',
        ]);
        if ($request->image) {
            $image = $_FILES["image"]["name"];
            $file_tmp = $_FILES["image"]["tmp_name"];
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            $brand['image'] = $request->file('image')->storeAs('product/', 'image' . rand(10, 100000) . '.' . $ext);
        }
        Product::where('id', $id)->update($data);
        return redirect('product')->with('success', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Product::where('id', $id)->delete();
        return redirect('product')->with('success', 'Data deleted successfully');
    }
}
