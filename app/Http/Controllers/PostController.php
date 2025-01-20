<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'Mensagem' => 'Posts listados com sucesso',
            'dados' => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        $validacao = Validator::make($request->all(), [
            'titulo' => 'required|string|max:190',
            'conteudo' => 'required|string',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        if ($validacao->fails()) {
            return response()->json([
                'mensagem' => 'Erro de validação',
                'erros' => $validacao->errors()
            ], 422);
        }

        $post = Post::create($request->all());
        return response()->json([
            'Mensagem' => 'Post cadastrado com sucesso',
            'dados' => $post
        ], 201);
    }

    public function show(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'Mensagem' => 'Post não encontrado'
            ], 404);
        }

        return response()->json([
            'Mensagem' => 'Post retornado com sucesso',
            'dados' => $post
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'Mensagem' => 'Post não encontrado'
            ], 404);
        }

        $validacao = Validator::make($request->all(), [
            'titulo' => 'required|string|max:190',
            'conteudo' => 'required|string',
        ]);

        if ($validacao->fails()) {
            return response()->json([
                'mensagem' => 'Erro de validação',
                'erros' => $validacao->errors()
            ], 422);
        }

        $post->update([
            'titulo' => $request->titulo,
            'conteudo' => $request->conteudo
        ]);
        return response()->json([
            'Mensagem' => 'Post atualizado com sucesso',
            'dados' => $post
        ], 200);
    }

    public function destroy(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'Mensagem' => 'Post não encontrado'
            ], 404);
        }
        $post->delete();
        return response()->json([
            'Mensagem' => 'Post removido com sucesso'
        ], 200);
    }
}
