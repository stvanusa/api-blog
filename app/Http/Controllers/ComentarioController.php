<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use Illuminate\Support\Facades\Validator;

class ComentarioController extends Controller
{
    public function index()
    {
        $comentarios = Comentario::all();
        return response()->json([
            'Mensagem' => 'Comentários listados com sucesso',
            'dados' => $comentarios
        ], 200);
    }

    public function store(Request $request)
    {
        $validacao = Validator::make($request->all(), [
            'conteudo' => 'required|string|max:1000',
            'usuario_id' => 'required|exists:usuarios,id',
            'post_id' => 'required|exists:posts,id',
        ]);

        if ($validacao->fails()) {
            return response()->json([
                'mensagem' => 'Erro de validação',
                'erros' => $validacao->errors()
            ], 422);
        }

        $comentario = Comentario::create($request->all());
        return response()->json([
            'Mensagem' => 'Comentário cadastrado com sucesso',
            'dados' => $comentario
        ], 201);
    }

    public function show(string $id)
    {
        $comentario = Comentario::find($id);
        if (!$comentario) {
            return response()->json([
                'Mensagem' => 'Comentário não encontrado'
            ], 404);
        }

        return response()->json([
            'Mensagem' => 'Comentário retornado com sucesso',
            'dados' => $comentario
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $comentario = Comentario::find($id);

        if (!$comentario) {
            return response()->json([
                'Mensagem' => 'Comentário não encontrado'
            ], 404);
        }

        $validacao = Validator::make($request->all(), [
            'conteudo' => 'required|string|max:1000',
        ]);

        if ($validacao->fails()) {
            return response()->json([
                'mensagem' => 'Erro de validação',
                'erros' => $validacao->errors()
            ], 422);
        }

        $comentario->update([
            'conteudo' => $request->conteudo
        ]);
        return response()->json([
            'Mensagem' => 'Comentário atualizado com sucesso',
            'dados' => $comentario
        ], 200);
    }

    public function destroy(string $id)
    {
        $comentario = Comentario::find($id);
        if (!$comentario) {
            return response()->json([
                'Mensagem' => 'Comentário não encontrado'
            ], 404);
        }
        $comentario->delete();
        return response()->json([
            'Mensagem' => 'Comentário removido com sucesso'
        ], 200);
    }
}
