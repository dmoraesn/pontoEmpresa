<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use App\Models\Usuario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::orderBy('nome')->get();
        $horarios = Horario::with('usuario')->orderByDesc('vigente_desde')->get();

        return view('horarios.index', compact('usuarios','horarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'carga_horas' => 'required|integer|min:1',
            'hora_entrada_prevista' => 'required|date_format:H:i',
            'hora_saida_prevista' => 'required|date_format:H:i',
            'intervalo_minimo_minutos' => 'required|integer|min:0',
            'vigente_desde' => 'required|date',
        ]);

        Horario::create($request->only([
            'usuario_id',
            'carga_horas',
            'hora_entrada_prevista',
            'hora_saida_prevista',
            'intervalo_minimo_minutos',
            'vigente_desde'
        ]));

        return back()->with('success','Horário cadastrado com sucesso.');
    }

    public function edit(Horario $horario)
    {
        $usuarios = Usuario::orderBy('nome')->get();
        return view('horarios.edit', compact('horario','usuarios'));
    }

    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'carga_horas' => 'required|integer|min:1',
            'hora_entrada_prevista' => 'required|date_format:H:i',
            'hora_saida_prevista' => 'required|date_format:H:i',
            'intervalo_minimo_minutos' => 'required|integer|min:0',
            'vigente_desde' => 'required|date',
        ]);

        $horario->update($request->only([
            'usuario_id',
            'carga_horas',
            'hora_entrada_prevista',
            'hora_saida_prevista',
            'intervalo_minimo_minutos',
            'vigente_desde'
        ]));

        return redirect()->route('horarios.index')->with('success','Horário atualizado com sucesso.');
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();
        return back()->with('success','Horário excluído com sucesso.');
    }
}
