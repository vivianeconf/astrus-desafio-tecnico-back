<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'price'=>'required|numeric',
            'quantidad'=>'required|numeric',
            'description'=>'string',
            'category'=>'required|string|in:Mercearia,Hortifrúti,Açougue,Bebidas,Lacticínios'
        ]);

        try {
            Product::create([
                'name'=> $request->name,
                'price'=> $request->price,
                'quantidad'=> $request->quantidad,
                'description'=> $request->description,
                'category'=> $request->category
            ]);

            return response()->json(['message'=>'Produto criado com sucesso.'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message'=>'Não foi possível inserir o produto.', 'error'=>$e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function read($id)
    {
        $product = Product::find($id);
        return response()->json(['product'=>$product], Response::HTTP_ACCEPTED);
    }

    public function all()
    {
        $products = Product::all();

        return response()->json(['products'=>$products], Response::HTTP_ACCEPTED);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $request->validate([
            'name' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'quantidad' => 'sometimes|required|numeric',
            'description' => 'sometimes|string',
            'category' => 'sometimes|required|string|in:Mercearia,Hortifrúti,Açougue,Bebidas,Lacticínios',
        ]);

        try {
            $product->name          = $request->name;
            $product->price         = $request->price;
            $product->quantidad     = $request->quantidad;
            $product->description   = $request->description;
            $product->category      = $request->category;
            $product->save();

            return response()->json(['message'=>'Produto atualizado com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message'=>'Não foi possível editar o produto.', 'error'=>$e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if (!$product)
        {
            return response()->json(['message'=>'Não foi possível excluir o produto.'], Response::HTTP_BAD_REQUEST);
        }
        
        $product->delete();
        
        return response()->json(['message'=>'Produto excluido com sucesso.'], Response::HTTP_OK);
    }
}
