<div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="update" class="space-y-4">
        <div>
            <label>Data e Hora</label>
            <input type="datetime-local" wire:model="data_hora" class="form-control">
            @error('data_hora') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Tipo</label>
            <select wire:model="tipo" class="form-control">
                <option value="entrada">Entrada</option>
                <option value="saida">Saída</option>
            </select>
            @error('tipo') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Origem</label>
            <input type="text" wire:model="origem" class="form-control">
            @error('origem') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>
