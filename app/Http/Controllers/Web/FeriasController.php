<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Ferias; // Alterado para o nome de classe correto: Ferias
use Illuminate\Http\Request;

class FeriasController extends Controller // Alterado para o nome de classe correto: FeriasController
{
    // Listar férias de um usuário
    public function index($usuarioId)
    {
        $usuario = Usuario::findOrFail($usuarioId);
        $ferias = Ferias::where('usuario_id', $usuarioId)->orderBy('data_inicio', 'desc')->get();

        return view('ferias.index', compact('usuario', 'ferias'));
    }

    // Salvar nova férias
    public function store(Request $request, $usuarioId)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim'    => 'required|date|after_or_equal:data_inicio',
            'observacao'  => 'nullable|string|max:500',
        ]);

        Ferias::create([
            'usuario_id'  => $usuarioId,
            'data_inicio' => $request->data_inicio,
            'data_fim'    => $request->data_fim,
            'observacao'  => $request->observacao,
        ]);

        return redirect()->route('usuarios.ferias.index', $usuarioId)
                         ->with('success', 'Férias cadastradas com sucesso.');
    }

    // Excluir férias
    public function destroy($id, $usuarioId)
    {
        $ferias = Ferias::findOrFail($id);
        $ferias->delete();

        return redirect()->route('usuarios.ferias.index', $usuarioId)
                         ->with('success', 'Férias excluídas com sucesso.');
    }
}