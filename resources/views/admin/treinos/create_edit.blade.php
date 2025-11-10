@extends('layouts.admin')

@section('title', $isEdit ? 'Editar Treino' : 'Novo Treino')
@section('header_title', $isEdit ? 'Editar Treino' : 'Novo Treino')

@section('header_actions')
    <a href="{{ route('treinos.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
        &larr; Voltar para a Lista
    </a>
@endsection

@section('content')
    <h3 class="text-xl font-bold text-gray-800 mb-6">{{ $isEdit ? 'Editar dados do Treino' : 'Montar Novo Treino' }}</h3>
            
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <form 
            method="POST" 
            action="{{ $isEdit ? route('treinos.update', $treino->idTreino) : route('treinos.store') }}"
        >
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="idAluno" class="block text-sm font-medium text-gray-700 mb-1">Aluno</label>
                    <select name="idAluno" id="idAluno" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('idAluno') border-red-500 @enderror">
                        <option value="">--- Selecione um Aluno ---</option>
                        @if(isset($alunos))
                            @foreach($alunos as $aluno)
                                <option value="{{ $aluno->idAluno }}" 
                                    {{ old('idAluno', $idAlunoPreselecionado ?? $treino->idAluno ?? '') == $aluno->idAluno ? 'selected' : '' }}>
                                    {{ $aluno->nome }}
                                </option>
                            @endforeach
                        @else
                            <option value="" disabled>(Variável $alunos não carregada)</option>
                        @endif
                    </select>
                    @error('idAluno')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                     <label for="descricao" class="block text-sm font-medium text-gray-700 mb-1">Descrição do Treino (Exercícios, Séries, Repetições)</label>
                    <textarea name="descricao" id="descricao" rows="10" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('descricao') border-red-500 @enderror" 
                        placeholder="Ex:&#10;Treino A - Peito e Tríceps&#10;- Supino Reto: 4x10&#10;- Crucifixo Inclinado: 3x12&#10;- Tríceps Pulley: 4x15"
                    >{{ old('descricao', $treino->descricao ?? '') }}</textarea>
                    @error('descricao')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="data_inicio" class="block text-sm font-medium text-gray-700 mb-1">Data de Início (Vigência)</label>
                    <input type="date" name="data_inicio" id="data_inicio" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('data_inicio') border-red-500 @enderror" 
                        value="{{ old('data_inicio', $treino->data_inicio ?? date('Y-m-d')) }}">
                    @error('data_inicio')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="data_fim" class="block text-sm font-medium text-gray-700 mb-1">Data de Fim (Opcional)</label>
                    <input type="date" name="data_fim" id="data_fim"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('data_fim') border-red-500 @enderror" 
                        value="{{ old('data_fim', $treino->data_fim ?? '') }}">
                    @error('data_fim')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            
            <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end">
                <button 
                    type="submit" 
                    class="py-2 px-6 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150"
                >
                    {{ $isEdit ? 'Salvar Alterações' : 'Cadastrar Treino' }}
                </button>
            </div>
        </form>

    </div>
@endsection