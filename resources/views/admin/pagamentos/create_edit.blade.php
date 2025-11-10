@extends('layouts.admin')

@section('title', 'Registrar Pagamento')
@section('header_title', 'Registrar Novo Pagamento')

@section('header_actions')
    <a href="{{ route('pagamentos.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
        &larr; Voltar para a Lista
    </a>
@endsection

@section('content')
    <h3 class="text-xl font-bold text-gray-800 mb-6">Lançamento Manual de Pagamento</h3>
            
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <form 
            method="POST" 
            action="{{ route('pagamentos.store') }}"
        >
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="idAluno" class="block text-sm font-medium text-gray-700 mb-1">Aluno</label>
                    <select name="idAluno" id="idAluno" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('idAluno') border-red-500 @enderror">
                        <option value="">--- Selecione um Aluno ---</option>
                        @foreach($alunos as $aluno)
                            <option value="{{ $aluno->idAluno }}" {{ old('idAluno') == $aluno->idAluno ? 'selected' : '' }}>
                                {{ $aluno->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('idAluno')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="idPlano" class="block text-sm font-medium text-gray-700 mb-1">Plano Referente</label>
                    <select name="idPlano" id="idPlano" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('idPlano') border-red-500 @enderror">
                        <option value="">--- Selecione um Plano ---</option>
                        @foreach($planos as $plano)
                            <option value="{{ $plano->idPlano }}" {{ old('idPlano') == $plano->idPlano ? 'selected' : '' }}>
                                {{ $plano->nomePlano }} (R$ {{ number_format($plano->valor, 2, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    @error('idPlano')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="data_pagamento" class="block text-sm font-medium text-gray-700 mb-1">Data do Pagamento</label>
                    <input type="date" name="data_pagamento" id="data_pagamento" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('data_pagamento') border-red-500 @enderror" 
                        value="{{ old('data_pagamento', date('Y-m-d')) }}">
                    @error('data_pagamento')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="valor_pago" class="block text-sm font-medium text-gray-700 mb-1">Valor Pago (R$)</label>
                    <input type="number" step="0.01" name="valor_pago" id="valor_pago" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('valor_pago') border-red-500 @enderror" 
                        value="{{ old('valor_pago') }}" placeholder="Ex: 119.90">
                    @error('valor_pago')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                        <option value="Pago" {{ old('status') == 'Pago' ? 'selected' : '' }}>Pago</option>
                        <option value="Pendente" {{ old('status') == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="Vencido" {{ old('status') == 'Vencido' ? 'selected' : '' }}>Vencido</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            
            <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end">
                <button 
                    type="submit" 
                    class="py-2 px-6 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150"
                >
                    Salvar Pagamento
                </button>
            </div>
        </form>

    </div>
@endsection