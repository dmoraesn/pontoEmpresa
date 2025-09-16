<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Horario;
use App\Services\PontoService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class UsuarioController extends Controller
{
    protected $pontoService;

    public function __construct(PontoService $pontoService)
    {
        $this->pontoService = $pontoService;
    }

    /**
     * Listagem de usuários
     */
    public function index()
    {
        $usuarios = Usuario::orderBy('nome')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Grava um novo usuário
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome'  => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'cpf'   => 'required|string|max:14|unique:usuarios,cpf',
            'cargo' => 'nullable|string|max:100',
        ]);

        Usuario::create($request->only(['nome','email','cpf','cargo']));

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuário cadastrado com sucesso.');
    }

    /**
     * Exibir detalhes de um usuário (usando Route-Model Binding)
     */
    public function show(Usuario $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Exibir espelho de ponto - Versão HTML (agora refatorado)
     */
    public function espelho(Request $request, Usuario $usuario)
    {
        $mes = $request->input('mes_ano', now()->format('Y-m'));
    
        // Busca o último horário vigente do usuário
        $horario = $usuario->horarios()
            ->orderByDesc('vigente_desde')
            ->first();

        // Se não existir nenhum horário cadastrado para o usuário,
        // podemos pegar um horário padrão (exemplo: o mais antigo da tabela)
        if (!$horario) {
            $horario = Horario::orderBy('vigente_desde', 'asc')->first();
        }

        if (!$horario) {
            abort(500, "Nenhum horário de trabalho encontrado para o usuário ou como padrão.");
        }
        
        // Passa o horário encontrado para o cálculo do espelho
        $dados = $this->pontoService->calcularEspelhoMensal($usuario, $mes, $horario);
    
        return view('usuarios.espelho', compact('dados'));
    }

    /**
     * Gerar e baixar o espelho de ponto em PDF (novo método)
     */
    public function gerarEspelhoPDF(Request $request, Usuario $usuario)
    {
        $mes = $request->input('mes_ano', now()->format('Y-m'));

        // Busca o último horário vigente do usuário
        $horario = $usuario->horarios()
            ->orderByDesc('vigente_desde')
            ->first();
    
        // Se não existir nenhum horário cadastrado para o usuário,
        // podemos pegar um horário padrão (exemplo: o mais antigo da tabela)
        if (!$horario) {
            $horario = Horario::orderBy('vigente_desde', 'asc')->first();
        }
    
        if (!$horario) {
            abort(500, "Nenhum horário de trabalho encontrado para o usuário ou como padrão.");
        }
        
        // Reutilizamos 100% da lógica de cálculo chamando o mesmo serviço
        $dados = $this->pontoService->calcularEspelhoMensal($usuario, $mes, $horario);
        
        // Carrega a view específica do PDF
        $pdf = Pdf::loadView('usuarios.espelho_ponto_pdf', compact('dados'));
        $pdf->setPaper('a4', 'portrait');

        $nomeArquivo = "espelho-ponto-{$usuario->nome}-{$mes}.pdf";
        
        return $pdf->download($nomeArquivo);
    }
}