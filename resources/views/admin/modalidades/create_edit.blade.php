@extends('layouts.admin')

@section('title', $isEdit ? 'Editar Modalidade' : 'Nova Modalidade')
@section('header_title', $isEdit ? 'Editar Modalidade' : 'Nova Modalidade')

@section('header_actions')
    <a href="{{ route('modalidades.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
        &larr; Voltar para a Lista
    </a>
@endsection

@section('content')
    <h3 class="text-xl font-bold text-gray-800 mb-6">{{ $isEdit ? 'Editar dados da Modalidade' : 'Cadastrar Nova Modalidade' }}</h3>
            
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <form 
            method="POST" 
            action="{{ $isEdit ? route('modalidades.update', $modalidade->idModalidade) : route('modalidades.store') }}"
        >
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome da Modalidade</label>
                    <input type="text" name="nome" id="nome" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('nome') border-red-500 @enderror" 
                        value="{{ old('nome', $modalidade->nome ?? '') }}">
                    @error('nome')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="descricao" class="block text-sm font-medium text-gray-700 mb-1">Descrição (Opcional)</label>
                    <textarea name="descricao" id="descricao" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('descricao') border-red-500 @enderror"
                    >{{ old('descricao', $modalidade->descricao ?? '') }}</textarea>
                    @error('descricao')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end">
                <button 
                    type="submit" 
                    class="py-2 px-6 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150"
                >
                    {{ $isEdit ? 'Salvar Alterações' : 'Cadastrar Modalidade' }}
                </button>
            </div>
        </form>

    </div>
@endsection