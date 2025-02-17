<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Parameter(name: 'product', description: 'Первичный ключ', in: 'path')]
class ProductController extends Controller
{
    #[OA\Get(
        tags: ['Product'],
        description: 'Возвращает перечень товаров',
        path: '/api/v1/products/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Перечень товаров',
        response: 200,
    )]
    #[OA\Response(  
        content: new OA\JsonContent(),
        description: 'Товар не найден',
        response: 404,
    )]
    public function index(Request $request)
    {
        $query = Product::query();
        $filter = $request->input('filter');
        if (isset($filter['name'])) {
            $query->where('name', 'LIKE', '%' . $filter['name'] . '%');
        }
        if (isset($filter['price'])) {
            if (isset($filter['price']['>']))
            $query->where('price', '>' , $filter['price']['>']);
            if (isset($filter['price']['<']))
            $query->where('price', '<' , $filter['price']['<']);
        }
        $storeSort = explode(',', $request->input('sort'));
        foreach ($storeSort as $value) {
            $pos = strpos($value, '-') === 0;
            $norm = str_replace('-', '', $value);
            $arr=['name','price'];
            if (in_array($norm, $arr, true)) {
                $query->orderBy($norm, $pos ? 'DESC' : 'ASC');
            }
        }
        $query->get();
        $products = $query->paginate(4);
        return new ProductCollection($products);
        // пример https запроса
        // /products?sort=-name,price&filter[name]=%батарейка%&filter[price][>]=1&filter[price][<]=100
    }

    #[OA\Post(
        tags: ['Product'],
        description: 'Создаёт запись о товаре',
        path: '/api/v1/products/',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(ref: '#/components/schemas/Product'),
            ),
            required: true,
        ),
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Запись о товаре создана',
        response: 201,
    )]
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

    #[OA\Get(
        tags: ['Product'],
        description: 'Возвращает товар по идентификатору',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/product'),
        ],
        path: '/api/v1/products/{product}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Товар',
        response: 200,
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Товар не найден',
        response: 404,
    )]
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    #[OA\Patch(
        tags: ['Product'],
        description: 'Корректирует запись о товаре',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/product'),
        ],
        path: '/api/v1/products/{product}/',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(ref: '#/components/schemas/Product'),
            ),
            required: false,
        ),
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Запись о товаре откорректирована',
        response: 204,
    )]
    public function update(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['available'] = isset($data['available']);
        $product->update($data);
        return response()->noContent(204);
    }

    #[OA\Delete(
        tags: ['Product'],
        description: 'Удаляет запись о товаре',
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/product'),
        ],
        path: '/api/v1/products/{product}/',
    )]
    #[OA\Response(
        content: new OA\JsonContent(),
        description: 'Запись о товаре удалена',
        response: 204,
    )]
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent(204);
    }
}
