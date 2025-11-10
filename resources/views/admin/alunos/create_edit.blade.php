@extends('layouts.admin')

@section('title', $isEdit ? 'Editar Aluno' : 'Novo Aluno')
@section('header_title', $isEdit ? 'Editar Aluno' : 'Matricular Novo Aluno')

@section('header_actions')
    <a href="{{ route('alunos.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
        &larr; Voltar para a Lista
    </a>
@endsection

@section('content')
    <h3 class="text-xl font-bold text-gray-800 mb-6">{{ $isEdit ? 'Dados Pessoais e Contrato' : 'Preencha a Ficha de Matrícula' }}</h3>
            
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <form 
            method="POST" 
            action="{{ $isEdit ? route('alunos.update', $aluno->idAluno) : route('alunos.store') }}"
        >
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                    <input type="text" name="nome" id="nome" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('nome') border-red-500 @enderror" 
                        value="{{ old('nome', $aluno->nome ?? '') }}">
                    @error('nome')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror" 
                        value="{{ old('email', $aluno->email ?? '') }}">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="data_nascimento" class="block text-sm font-medium text-gray-700 mb-1">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" id="data_nascimento" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('data_nascimento') border-red-500 @enderror" 
                        value="{{ old('data_nascimento', $aluno->data_nascimento ?? '') }}">
                    @error('data_nascimento')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                    <input type="text" name="telefone" id="telefone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('telefone') border-red-500 @enderror" 
                        value="{{ old('telefone', $aluno->telefone ?? '') }}" placeholder="(XX) XXXXX-XXXX">
                    @error('telefone')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            
            <h4 class="text-xl font-bold text-gray-800 mt-10 mb-6">Informações de Acesso e Contrato</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label for="idPlano" class="block text-sm font-medium text-gray-700 mb-1">Plano Contratado</label>
                    <select name="idPlano" id="idPlano" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('idPlano') border-red-500 @enderror">
                        <option value="">--- Selecione um Plano ---</option>
                        @foreach($planos as $plano)
                            <option value="{{ $plano->idPlano }}" 
                                {{ old('idPlano', $aluno->idPlano ?? '') == $plano->idPlano ? 'selected' : '' }}>
                                {{ $plano->nomePlano }} (R$ {{ number_format($plano->valor, 2, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    @error('idPlano')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="idProfessor" class="block text-sm font-medium text-gray-700 mb-1">Professor Responsável (Instrutor)</label>
                    <select name="idProfessor" id="idProfessor"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('idProfessor') border-red-500 @enderror">
                        <option value="">--- Selecione um Professor ---</option>
                        @foreach($professores as $professor)
                            <option value="{{ $professor->idProfessor }}" 
                                {{ old('idProfessor', $aluno->idProfessor ?? '') == $professor->idProfessor ? 'selected' : '' }}>
                                {{ $professor->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('idProfessor')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if($isEdit)
                    <div>
                        <label for="status_bloqueio" class="block text-sm font-medium text-gray-700 mb-1">Status de Acesso</label>
                        <select name="status_bloqueio" id="status_bloqueio"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('status_bloqueio') border-red-500 @enderror">
                            <option value="0" {{ old('status_bloqueio', $aluno->status_bloqueio ?? 0) == 0 ? 'selected' : '' }}>0 - Ativo</option>
                            <option value="1" {{ old('status_bloqueio', $aluno->status_bloqueio ?? 0) == 1 ? 'selected' : '' }}>1 - Bloqueado</option>
                        </select>
                        @error('status_bloqueio')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
                
                <div class="md:col-span-2 border-t pt-4">
                    <h5 class="text-md font-semibold text-gray-800 mb-3">
                        {{ $isEdit ? 'Alterar Senha (Opcional)' : 'Definir Senha de Acesso' }}
                    </h5>
                </div>

                <div>
                    <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Senha {{ $isEdit ? '(Preencha para alterar)' : '' }}</label>
                    <input type="password" name="senha" id="senha" {{ $isEdit ? '' : 'required' }}
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('senha') border-red-500 @enderror" 
                        placeholder="Mínimo 8 caracteres">
                    @error('senha')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="senha_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Senha</label>
                    <input type="password" name="senha_confirmation" id="senha_confirmation" {{ $isEdit ? '' : 'required' }}
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                        placeholder="Repita a senha">
                </div>

            </div>
            
            <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end">
                <button 
                    type="submit" 
                    class="py-2 px-6 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150"
                >
                    {{ $isEdit ? 'Salvar Alterações' : 'Matricular Aluno' }}
                </button>
            </div>
        </form>

    </div>
@endsection