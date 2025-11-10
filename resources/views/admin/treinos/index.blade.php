@extends('layouts.admin')

@section('title', 'Gestão de Treinos')
@section('header_title', 'Gestão de Treinos')

@section('header_actions')
    <a href="{{ route('treinos.create') }}" class="py-2 px-4 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition duration-150">
        Montar Novo Treino
    </a>
@endsection

@section('content')
    <h3 class="text-xl font-bold text-gray-800 mb-6">Lista de Treinos</h3>

    <div class="bg-white p-6 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aluno</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição (Início)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Início</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Fim</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                    @forelse ($treinos as $treino)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $treino->aluno->nome ?? 'Aluno não encontrado' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 max-w-md truncate">{{ $treino->descricao ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($treino->data_inicio)->format('d/m/Y') }}</div>
                            </td>
                             <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $treino->data_fim ? \Carbon\Carbon::parse($treino->data_fim)->format('d/m/Y') : 'Indefinido' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('treinos.edit', $treino->idTreino) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                
                                <form method="POST" action="{{ route('treinos.destroy', $treino->idTreino) }}" class="inline-block" onsubmit="return confirm('Tem certeza que deseja EXCLUIR este treino?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                Nenhum treino cadastrado ainda.
                            </td>
                        </tr>
                    @endforelse
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection