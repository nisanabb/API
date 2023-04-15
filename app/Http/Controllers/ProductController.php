<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function index()
    {
        $product = Product::orderBy('time', 'DESC')->get();

        return response()->json([
            'message' => 'your request has been processed successfully', 
            'data' => $product], 201);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        return response()->json([
        'message' => 'Detail or Data Resource', 
        'data' => $product], 201);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_seller'     => ['numeric'],
            'product_name'  => [],
            'product_total' => ['numeric'],
            'product_price' => ['numeric'],
            'availability'  => ['in:ready,sold'],
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $seller = Product::create($request->all());
            $response = [
                'code' => "200",
                'message' => 'Product Created',
                'data' => $seller
            ];

            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'code' => "400",
                'message' => "Failed" 
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if(!$product) {
            return response()->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'id_seller'     => ['numeric'],
            'product_name'  => [],
            'product_total' => ['numeric'],
            'product_price' => ['numeric'],
            'availability'  => ['in:ready,sold'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $product->update($request->all());
            $response = [
                'message' => 'Product Updated',
                'data' => $product
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }   

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'message' => 'succesfully deleted', 
            'data' => $product], 201);
            
    } 
    public function count()
    {
        $count = Product::count();
    
        return response()->json(['count' => $count]);
    }

    public function filterByPrice(Request $request)
    {
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
    
        if (!$minPrice || !$maxPrice) {
            return response()->json(['error' => 'Please provide both min_price and max_price parameters.'], 400);
        }
    
        $product = Product::whereBetween('product_price', [(float) $minPrice, (float) $maxPrice])->get();
    
        if ($product->isEmpty()) {
            return response()->json(['message' => 'No products found.'], 404);
        }
    
        return response()->json($product);
    }
    

    

}

