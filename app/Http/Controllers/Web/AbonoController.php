<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Abono;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AbonoController extends Controller
{
    public function index($id)
    {
        $usuario = Usuario::findOrFail($id);
        $abonos  = Abono::where('usuario_id', $id)->orderByDesc('data')->get();
        return view('abonos.index', compact('usuario','abonos'));
    }

    public function store(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $data = $request->validate([
            'data'    => ['required','date'],
            'duracao' => ['required','regex:/^\d{1,2}:\d{2}$/'], // HH:MM
            'motivo'  => ['nullable','string','max:255'],
            'tipo'    => ['required','in:abonado,desconto'],
        ]);

        [$h,$m] = array_map('intval', explode(':', $data['duracao']));
        $minutos = ($h * 60) + $m;

        Abono::create([
            'usuario_id' => $usuario->id,
            'data'       => $data['data'],
            'minutos'    => $minutos,
            'motivo'     => $data['motivo'] ?? null,
            'tipo'       => $data['tipo'],
        ]);

        return back()->with('success', 'Abono criado.');
    }

    public function update(Request $request, Abono $abono)
    {
        $data = $request->validate([
            'data'    => ['required','date'],
            'duracao' => ['required','regex:/^\d{1,2}:\d{2}$/'],
            'motivo'  => ['nullable','string','max:255'],
            'tipo'    => ['required','in:abonado,desconto'],
        ]);

        [$h,$m] = array_map('intval', explode(':', $data['duracao']));
        $abono->update([
            'data'    => $data['data'],
            'minutos' => ($h*60)+$m,
            'motivo'  => $data['motivo'] ?? null,
            'tipo'    => $data['tipo'],
        ]);

        return back()->with('success', 'Abono atualizado.');
    }

    public function destroy(Abono $abono)
    {
        $abono->delete();
        return back()->with('success', 'Abono excluído.');
    }
}
