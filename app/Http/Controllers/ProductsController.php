<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use File;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:App\Models\User,id',
            'category_id' => 'required|exists:App\Models\Category,id',
            'description' => 'required',
            'price' => 'required',
            'photo' => 'image'

        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        
        $product = new Product();
        $product -> name = $request['name'];
        $product -> user_id = $request['user_id'];
        $product -> category_id = $request['category_id'];
        $product -> description = $request['description'];
        $product -> price = $request['price'];

        if($request->hasFile('photo')){
            $product -> photo=$request->photo->store('photo');
        }else{
            $product -> photo='';
        }

        $product -> save();

        return response()
            ->json(['success' => 1,'message' => 'Created succesfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product =  Product::find($id);
        $product -> user = $product->user;
        $product -> category = $product->category;
        return response()
            ->json(['success' => 1,'data' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:App\Models\User,id',
            'category_id' => 'required|exists:App\Models\Category,id',
            'description' => 'required',
            'price' => 'required',
            'photo' => 'image'

        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        
        $product =  Product::find($id);
        $product -> name = $request['name'];
        $product -> user_id = $request['user_id'];
        $product -> category_id = $request['category_id'];
        $product -> description = $request['description'];
        $product -> price = $request['price'];

        if($request->hasFile('photo')){
            if(File::exists(public_path("storage/").$product -> photo)){
                File::delete(public_path("storage/").$product -> photo);
            }
            $product -> photo=$request->photo->store('photo');
        }

        $product -> save();

        return response()
            ->json(['success' => 1,'message' => 'Updated succesfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product =  Product::find($id);
        $product -> delete();

        return response()
            ->json(['success' => 1,'message' => 'Deleted succesfully!']);
    }

    public function all_products(){
        $products =  Product::all();

        return response()
            ->json(['success' => 1,'data' => $products]);
    }

    public function search(Request $request){
        $product =  Product::where('name', 'LIKE', '%'.$request['key'].'%')->get();

        return response()
            ->json(['success' => 1,'data' => $product]);
    }
}
