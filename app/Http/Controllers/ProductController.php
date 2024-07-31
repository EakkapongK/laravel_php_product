<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    //
    public function index()
    {
        $response = Http::post('http://localhost:8000/Auth/Login', [
            'userCode' => 'take',
            'passWord' => '123',
        ]);
        $products = [];
        // Handle the response
        if ($response->successful()) {
            $responseData = $response->json();
            $data = response()->json($responseData, 200)->getData();
            // session(['token_api' => $data->data->token]);
            Session::put('token_api', $data->data->token);
            $products = $this -> getProduct();
            // dd($products);
            // return $products;
        } else {
            return response()->json(['error' => 'Failed to make API request'], $response->status());
        }

        return view('admin.product.index', compact('products'));
    }

    public function getProduct(){
        $token = Session::get('token_api');
        $url = "http://localhost:8000/Product/Products?Page=1&Limit=10&Code=&Name=รองเท้า";
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get($url);

        if ($response->successful()) {
            $responseData = $response->json();
            $data = response()->json($responseData, 200)->getData();
            // dd($data-> data);
            return $data-> data;
        } else {
            return response()->json(['error' => 'Unexpected error: ' . $response->body()], $response->status());
        }

         
    }

    public function add(Request $request){        
        $token = Session::get('token_api');
        //ตรวจสอบข้อมูล
        $request->validate([
            'product_code' => 'required|max:50',
            'product_name' => 'required|max:100'
        ], [
            'product_code.required' => 'กรุณาระบุรหัสสินค้าด้วยครับ',
            'product_code.max' => 'ระบุได้ไม่เกิน 50 ตัวอักษร',
            'product_name.required' => 'กรุณาระบุชื่อสินค้าด้วยครับ',
            'product_name.max' => 'ระบุได้ไม่เกิน 100 ตัวอักษร'
        ]);

        $url = 'http://localhost:8000/Product/Add';
        $data = [
            'code' => $request -> product_code,
            'name' => $request -> product_name,
            'price' => $request -> product_price,
            'quantity' => $request -> product_quantity,
            'remark' => $request -> product_remark,
            'itemNo' => $request -> product_itemNo
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' .$token
        ])->post($url, $data);

        // Handle the response
        if ($response->successful()) {
            $responseData = $response->json();
            $data = response()->json($responseData, 200);
        } else {
            return response()->json(['error' => 'Failed to make API request'], $response->status());
        }

        return redirect()->route('product')->with('success','บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id){
        $token = Session::get('token_api');
        $url = "http://localhost:8000/Product/".$id;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get($url);

        if ($response->successful()) {
            $responseData = $response->json();
            $data = response()->json($responseData, 200)->getData();;
            // dd($data-> data);
            $product = $data-> data;
            return view('admin.product.edit', compact('product'));
        } else {
            return response()->json(['error' => 'Unexpected error: ' . $response->body()], $response->status());
        }


    }

    public function update(Request $request, $id){
        // dd($id, $request );
        $token = Session::get('token_api');
        //ตรวจสอบข้อมูล
        $request->validate([
            'product_code' => 'required|max:50',
            'product_name' => 'required|max:100'
        ], [
            'product_code.required' => 'กรุณาระบุรหัสสินค้าด้วยครับ',
            'product_code.max' => 'ระบุได้ไม่เกิน 50 ตัวอักษร',
            'product_name.required' => 'กรุณาระบุชื่อสินค้าด้วยครับ',
            'product_name.max' => 'ระบุได้ไม่เกิน 100 ตัวอักษร'
        ]);

        $url = 'http://localhost:8000/Product/Update';
        $data = [
            'id' => $id,
            'code' => $request -> product_code,
            'name' => $request -> product_name,
            'price' => $request -> product_price,
            'quantity' => $request -> product_quantity,
            'remark' => $request -> product_remark,
            'itemNo' => $request -> product_itemNo
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' .$token
        ])->put($url, $data);

        // Handle the response
        if ($response->successful()) {
            $responseData = $response->json();
            $data = response()->json($responseData, 200);
        } else {
            return response()->json(['error' => 'Failed to make API request'], $response->status());
        }

        return redirect()->route('product')->with('success','แก้ไขข้อมูลเรียบร้อย');
    }
    
    public function delete($id){
        // dd($id );
        $token = Session::get('token_api');
        $url = "http://localhost:8000/Product/delete/".$id;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' .$token
        ])->delete($url);

        // Handle the response
        if ($response->successful()) {
            $responseData = $response->json();
            $data = response()->json($responseData, 200);
        } else {
            return response()->json(['error' => 'Failed to make API request'], $response->status());
        }

        return redirect()->route('product')->with('success','ลบข้อมูลเรียบร้อย');
    }
    
}
