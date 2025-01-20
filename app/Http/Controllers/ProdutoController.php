<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\Validator;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return response()->json([
            'Mensagem' => 'Produtos listados com sucesso',
            'dados' => $produtos
        ], 200);
    }

    public function store(Request $request)
    {
        $validacao = Validator::make($request->all(), [
            'nome' => 'required|string|max:190',
            'descricao' => 'nullable|string|max:190',
            'preco' => 'required|numeric',
        ]);

        if ($validacao->fails()) {
            return response()->json([
                'mensagem' => 'Erro de validação',
                'erros' => $validacao->errors()
            ], 422);
        }

        $produto = Produto::create($request->all());
        return response()->json([
            'Mensagem' => 'Produto cadastrado com sucesso',
            'dados' => $produto
        ], 201);
    }

    public function show(string $id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json([
                'Mensagem' => 'Produto não encontrado'
            ], 404);
        }

        return response()->json([
            'Mensagem' => 'Produto retornado com sucesso',
            'dados' => $produto
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json([
                'Mensagem' => 'Produto não encontrado'
            ], 404);
        }

        $validacao = Validator::make($request->all(), [
            'nome' => 'required|string|max:190',
            'descricao' => 'nullable|string|max:190',
            'preco' => 'required|numeric',
        ]);

        if ($validacao->fails()) {
            return response()->json([
                'mensagem' => 'Erro de validação',
                'erros' => $validacao->errors()
            ], 422);
        }

        $produto->update($request->all());
        return response()->json([
            'Mensagem' => 'Produto atualizado com sucesso',
            'dados' => $produto
        ], 200);
    }

    public function destroy(string $id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json([
                'Mensagem' => 'Produto não encontrado'
            ], 404);
        }
        $produto->delete();
        return response()->json([
            'Mensagem' => 'Produto removido com sucesso'
        ], 200);
    }
}
