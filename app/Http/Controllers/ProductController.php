<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();
        $filter = $request->input('filter');
        if (isset($filter['name'])) {
            $query->where('name', 'LIKE', '%' . $filter['name'] . '%');
        }
        if (isset($filter['price'])) {
            if (isset($filter['price']['>']))
            $query->where('price', '>' , $filter['price']);
        }
        if (isset($filter['price'])) {
            if (isset($filter['price']['<']))
            $query->where('price', '<' , $filter['price']);
        }
        $storeSort = explode(',', $request->input('sort'));
        foreach ($storeSort as $value) {
            $pos = strpos($value, '-') === 0;
            $norm = str_replace('-', '', $value);
            $arr=['name','price'];
            if (in_array($norm, $arr)) {
                $query->orderBy($arr, $pos ? 'DESC' : 'ASC');
            }
        }
        $query->get();
        $products = $query->paginate(2);
        return new ProductCollection($products);
        // пример https запроса
        // /products?sort=-name,price&filter[name]=%батарейка%&filter[price][>]=1&filter[price][<]=100
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['available'] = isset($data['available']);
        $product = Product::create($data);
        return response()->noContent(201)->withHeaders([
            'Location' => route('products.show', [
                'product' => $product->id,
            ]),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['available'] = isset($data['available']);
        $product->update($data);
        return response()->noContent(204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent(204);
    }
}
