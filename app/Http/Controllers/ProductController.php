<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product', [
            'except' => ['index', 'show'],
        ]);
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $products = Product::query()
            ->with('user')
            ->when(
                $request->filled('category'),
                fn ($query) => $query->where('category', $request->string('category')),
            )
            ->latest()
            ->paginate(12);

        return ProductResource::collection($products);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product->load('user'));
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $data = $request->safe()->except('photo');
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('products', 'public');
        }

        $product = Product::create($data);

        return (new ProductResource($product->load('user')))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $data = $request->safe()->except('photo');

        if ($request->hasFile('photo')) {
            $product->deletePhoto();
            $data['photo_path'] = $request->file('photo')->store('products', 'public');
        }

        $product->update($data);

        return new ProductResource($product->fresh()->load('user'));
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->deletePhoto();
        $product->delete();

        return response()->json(null, 204);
    }
}
