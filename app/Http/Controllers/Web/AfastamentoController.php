<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Afastamento;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AfastamentoController extends Controller
{
    public function index()
    {
        $afastamentos = Afastamento::with('usuario')->paginate(10);
        return view('afastamentos.index', compact('afastamentos'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        return view('afastamentos.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id'  => 'required|exists:usuarios,id',
            'tipo'        => 'required|string',
            'data_inicio' => 'required|date',
            'data_fim'    => 'nullable|date|after_or_equal:data_inicio',
        ]);

        Afastamento::create($request->all());

        return redirect()->route('afastamentos.index')
            ->with('success', 'Afastamento registrado com sucesso.');
    }

    public function edit($id)
    {
        $afastamento = Afastamento::findOrFail($id);
        $usuarios = Usuario::all();

        return view('afastamentos.edit', compact('afastamento', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $afastamento = Afastamento::findOrFail($id);

        $request->validate([
            'usuario_id'  => 'required|exists:usuarios,id',
            'tipo'        => 'required|string',
            'data_inicio' => 'required|date',
            'data_fim'    => 'nullable|date|after_or_equal:data_inicio',
            'observacao'  => 'nullable|string',
        ]);

        $afastamento->update($request->only([
            'usuario_id',
            'tipo',
            'data_inicio',
            'data_fim',
            'observacao',
        ]));

        return redirect()->route('afastamentos.index')
            ->with('success', 'Afastamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $afastamento = Afastamento::findOrFail($id);
        $afastamento->delete();

        return redirect()->route('afastamentos.index')
            ->with('success', 'Afastamento excluído com sucesso!');
    }
}
