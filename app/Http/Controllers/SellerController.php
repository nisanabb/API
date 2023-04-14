<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;


class SellerController extends Controller
{
    public function index()
    {
        $seller = Seller::orderBy('time', 'DESC')->get();

        return response()->json([
            'message' => 'your request has been processed successfully', 
            'data' => $seller], 201);
    }

    public function show($id)
    {
        $seller = Seller::findOrFail($id);
        
        return response()->json([
        'message' => 'Detail or Data Resource', 
        'data' => $seller], 201);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'seller_name'   => [],
            'address'       => [],
            'phone'         => ['numeric'],
            'city'          => [],
            'postalcode'    => [],
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $seller = Seller::create($request->all());
            $response = [
                'code' => "200",
                'message' => 'Seller Created',
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
        $seller = Seller::find($id);

        if(!$seller) {
            return response()->json(['error' => 'Seller not found'], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'seller_name'   => [],
            'address'       => [],
            'phone'         => ['numeric'],
            'city'          => [''],
            'postalcode'    => [''],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $seller->update($request->all());
            $response = [
                'code' => "200",
                'message' => 'Seller Updated',
                'data' => $seller
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'code' => "400",
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }   

    public function destroy($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->delete();
        return response()->json([
            'message' => 'succesfully deleted', 
            'data' => $seller], 201);
            
    } 
    
}
