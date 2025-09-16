<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Feriado;
use Illuminate\Http\Request;

class FeriadoController extends Controller
{
    // Listagem de feriados
    public function index()
    {
        $feriados = Feriado::orderBy('data')->get();
        return view('feriados.index', compact('feriados'));
    }

    // Formulário de criação (se quiser usar view separada)
    public function create()
    {
        return view('feriados.create');
    }

    // Gravar um novo feriado
    public function store(Request $request)
    {
        $request->validate([
            'data'      => 'required|date|unique:feriados,data',
            'descricao' => 'required|string|max:120',
            'tipo'      => 'required|in:nacional,estadual,municipal,empresa',
        ]);

        Feriado::create($request->all());

        return redirect()->route('feriados.index')
                         ->with('success', 'Feriado cadastrado com sucesso.');
    }

    // Formulário de edição
    public function edit(Feriado $feriado)
    {
        return view('feriados.edit', compact('feriado'));
    }

    // Atualizar um feriado
    public function update(Request $request, Feriado $feriado)
    {
        $request->validate([
            'data'      => 'required|date|unique:feriados,data,' . $feriado->id,
            'descricao' => 'required|string|max:120',
            'tipo'      => 'required|in:nacional,estadual,municipal,empresa',
        ]);

        $feriado->update($request->all());

        return redirect()->route('feriados.index')
                         ->with('success', 'Feriado atualizado com sucesso.');
    }

    // Excluir um feriado
    public function destroy(Feriado $feriado)
    {
        $feriado->delete();
        return back()->with('success', 'Feriado excluído com sucesso.');
    }
}
