<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return response()->json([
            'Mensagem' => 'Tags listadas com sucesso',
            'dados' => $tags
        ], 200);
    }

    public function store(Request $request)
    {
        $validacao = Validator::make($request->all(), [
            'nome' => 'required|string|max:190',
        ]);

        if ($validacao->fails()) {
            return response()->json([
                'mensagem' => 'Erro de validação',
                'erros' => $validacao->errors()
            ], 422);
        }

        $tag = Tag::create($request->all());
        return response()->json([
            'Mensagem' => 'Tag cadastrada com sucesso',
            'dados' => $tag
        ], 201);
    }

    public function show(string $id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return response()->json([
                'Mensagem' => 'Tag não encontrada'
            ], 404);
        }

        return response()->json([
            'Mensagem' => 'Tag retornada com sucesso',
            'dados' => $tag
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json([
                'Mensagem' => 'Tag não encontrada'
            ], 404);
        }

        $validacao = Validator::make($request->all(), [
            'nome' => 'required|string|max:190',
        ]);

        if ($validacao->fails()) {
            return response()->json([
                'mensagem' => 'Erro de validação',
                'erros' => $validacao->errors()
            ], 422);
        }

        $tag->update([
            'nome' => $request->nome
        ]);
        return response()->json([
            'Mensagem' => 'Tag atualizada com sucesso',
            'dados' => $tag
        ], 200);
    }

    public function destroy(string $id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return response()->json([
                'Mensagem' => 'Tag não encontrada'
            ], 404);
        }
        $tag->delete();
        return response()->json([
            'Mensagem' => 'Tag removida com sucesso'
        ], 200);
    }
}
