@extends('layouts.admin')

@section('title', 'Gestão de Alunos')
@section('header_title', 'Gestão de Alunos')

@section('header_actions')
    <a href="{{ route('alunos.create') }}" class="py-2 px-4 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition duration-150">
        Matricular Novo Aluno
    </a>
@endsection

@section('content')
    <h3 class="text-xl font-bold text-gray-800 mb-6">Lista de Alunos Matriculados</h3>
            
    <div class="bg-white p-6 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contato</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plano</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                    @forelse ($alunos as $aluno)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $aluno->nome }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $aluno->email }}</div>
                                <div class="text-sm text-gray-500">{{ $aluno->telefone ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $aluno->plano->nomePlano ?? 'Sem Plano' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($aluno->status_bloqueio)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Bloqueado
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Ativo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('alunos.edit', $aluno->idAluno) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                
                                <form method="POST" action="{{ route('alunos.toggleBlock', $aluno->idAluno) }}" class="inline-block" onsubmit="return confirm('Tem certeza que deseja {{ $aluno->status_bloqueio ? 'desbloquear' : 'bloquear' }} este aluno?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="{{ $aluno->status_bloqueio ? 'text-green-600 hover:text-green-900' : 'text-red-600 hover:text-red-900' }}">
                                        {{ $aluno->status_bloqueio ? 'Desbloquear' : 'Bloquear' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                Nenhum aluno matriculado ainda.
                            </td>
                        </tr>
                    @endforelse
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection