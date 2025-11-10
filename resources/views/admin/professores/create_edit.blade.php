@extends('layouts.admin')

@section('title', $isEdit ? 'Editar Professor' : 'Novo Professor')
@section('header_title', $isEdit ? 'Editar Professor' : 'Novo Professor')

@section('header_actions')
    <a href="{{ route('professores.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
        &larr; Voltar para a Lista
    </a>
@endsection

@section('content')
    <h3 class="text-xl font-bold text-gray-800 mb-6">{{ $isEdit ? 'Editar dados do Professor' : 'Cadastrar Novo Professor' }}</h3>
            
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <form 
            method="POST" 
            action="{{ $isEdit ? route('professores.update', $professor->idProfessor) : route('professores.store') }}"
        >
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome do Professor</label>
                    <input type="text" name="nome" id="nome" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('nome') border-red-500 @enderror" 
                        value="{{ old('nome', $professor->nome ?? '') }}">
                    @error('nome')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone (Opcional)</label>
                    <input type="text" name="telefone" id="telefone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('telefone') border-red-500 @enderror" 
                        value="{{ old('telefone', $professor->telefone ?? '') }}" placeholder="(XX) XXXXX-XXXX">
                    @error('telefone')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Modalidades que este professor ensina</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 border rounded-lg max-h-60 overflow-y-auto">
                        @if(isset($modalidades))
                            @forelse($modalidades as $modalidade)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="modalidades_ids[]" value="{{ $modalidade->idModalidade }}"
                                        class="rounded text-indigo-600 focus:ring-indigo-500"
                                        @if(in_array($modalidade->idModalidade, old('modalidades_ids', $modalidadesAssociadasIds ?? []))) checked @endif
                                    >
                                    <span class="text-sm text-gray-700">{{ $modalidade->nome }}</span>
                                </label>
                            @empty
                                <p class="text-sm text-gray-500 col-span-full">Nenhuma modalidade cadastrada. Cadastre modalidades primeiro.</p>
                            @endforelse
                        @else
                             <p class="text-sm text-gray-500 col-span-full">(Variável $modalidades não carregada)</p>
                        @endif
                    </div>
                    @error('modalidades_ids')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end">
                <button 
                    type="submit" 
                    class="py-2 px-6 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150"
                >
                    {{ $isEdit ? 'Salvar Alterações' : 'Cadastrar Professor' }}
                </button>
            </div>
        </form>

    </div>
@endsection