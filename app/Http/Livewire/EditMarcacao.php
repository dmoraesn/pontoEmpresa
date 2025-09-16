<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Marcacao;
use Carbon\Carbon;

class EditMarcacao extends Component
{
    public $marcacaoId;
    public $data_hora;
    public $tipo;
    public $origem;

    // Inicializa os dados quando o componente é montado
    public function mount(Marcacao $marcacao)
    {
        $this->marcacaoId = $marcacao->id;
        $this->data_hora  = $marcacao->data_hora->timezone('America/Sao_Paulo')->format('Y-m-d\TH:i');
        $this->tipo       = $marcacao->tipo;
        $this->origem     = $marcacao->origem;
    }

    // Regras de validação
    protected function rules()
    {
        return [
            'data_hora' => 'required|date',
            'tipo'      => 'required|in:entrada,saida',
            'origem'    => 'nullable|string|max:50',
        ];
    }

    // Método chamado pelo wire:submit.prevent="update"
    public function update()
    {
        $this->validate();

        $marcacao = Marcacao::findOrFail($this->marcacaoId);

        $marcacao->update([
            'data_hora' => Carbon::parse($this->data_hora, 'America/Sao_Paulo'),
            'tipo'      => $this->tipo,
            'origem'    => $this->origem,
        ]);

        session()->flash('success', 'Marcação atualizada com sucesso!');

        // Atualiza a tela sem recarregar
        $this->emit('marcacaoAtualizada');
    }

    public function render()
    {
        return view('livewire.edit-marcacao');
    }
}
