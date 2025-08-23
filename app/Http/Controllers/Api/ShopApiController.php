<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ShopApiController extends Controller
{
    /**
     * Get all products
     */
    public function getProducts(Request $request): JsonResponse
    {
        // Return mock data for now since there's no product model yet
        $products = [
            [
                'id' => 1,
                'name' => 'Azam FC Home Jersey 2024',
                'type' => 'home',
                'season' => '2024',
                'image' => 'https://via.placeholder.com/300x300?text=Home+Jersey',
                'customization_options' => ['name', 'number'],
                'price' => 45000,
                'is_active' => true,
                'in_stock' => true,
                'description' => 'Official Azam FC home jersey for 2024 season',
                'external_shop_url' => 'https://shop.azamfc.co.tz',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Azam FC Away Jersey 2024',
                'type' => 'away',
                'season' => '2024',
                'image' => 'https://via.placeholder.com/300x300?text=Away+Jersey',
                'customization_options' => ['name', 'number'],
                'price' => 45000,
                'is_active' => true,
                'in_stock' => true,
                'description' => 'Official Azam FC away jersey for 2024 season',
                'external_shop_url' => 'https://shop.azamfc.co.tz',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Azam FC Training Kit',
                'type' => 'training',
                'season' => '2024',
                'image' => 'https://via.placeholder.com/300x300?text=Training+Kit',
                'customization_options' => [],
                'price' => 35000,
                'is_active' => true,
                'in_stock' => true,
                'description' => 'Official Azam FC training kit',
                'external_shop_url' => 'https://shop.azamfc.co.tz',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Azam FC Scarf',
                'type' => 'merchandise',
                'season' => '2024',
                'image' => 'https://via.placeholder.com/300x300?text=Scarf',
                'customization_options' => [],
                'price' => 15000,
                'is_active' => true,
                'in_stock' => true,
                'description' => 'Official Azam FC supporter scarf',
                'external_shop_url' => 'https://shop.azamfc.co.tz',
                'sizes' => [],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Products retrieved successfully'
        ]);
    }

    /**
     * Get featured products
     */
    public function getFeaturedProducts(Request $request): JsonResponse
    {
        // Return first 2 products as featured
        $allProducts = $this->getProducts($request)->getData()->data;
        $featuredProducts = array_slice($allProducts, 0, 2);

        return response()->json([
            'success' => true,
            'data' => $featuredProducts,
            'message' => 'Featured products retrieved successfully'
        ]);
    }

    /**
     * Get products by category
     */
    public function getProductsByCategory(Request $request, string $category): JsonResponse
    {
        $allProducts = $this->getProducts($request)->getData()->data;
        $categoryProducts = array_filter($allProducts, function($product) use ($category) {
            return $product->type === $category;
        });

        return response()->json([
            'success' => true,
            'data' => array_values($categoryProducts),
            'message' => "Products in category '{$category}' retrieved successfully"
        ]);
    }

    /**
     * Get single product
     */
    public function getProduct(Request $request, int $id): JsonResponse
    {
        $allProducts = $this->getProducts($request)->getData()->data;
        $product = collect($allProducts)->firstWhere('id', $id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product retrieved successfully'
        ]);
    }
}