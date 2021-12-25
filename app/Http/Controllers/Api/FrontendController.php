<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FrontendController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $products = (new ProductService())->productSearchWithFilter($request);
        return ProductResource::collection($products);
    }

    /**
     * @param Product $product
     * @return mixed
     */
    public function checkProductStock(Product $product)
    {
        return $product->qty;
    }
}
