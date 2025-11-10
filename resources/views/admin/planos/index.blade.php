@extends('layouts.admin')

@section('title', 'Gestão de Planos')
@section('header_title', 'Gestão de Planos')

@section('header_actions')
    <a href="{{ route('planos.create') }}" class="py-2 px-4 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition duration-150">
        Cadastrar Novo Plano
    </a>
@endsection

@section('content')
    <h3 class="text-xl font-bold text-gray-800 mb-6">Lista de Planos</h3>
            
    <div class="bg-white p-6 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duração</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                    @forelse ($planos as $plano)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $plano->nomePlano }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">R$ {{ number_format($plano->valor, 2, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $plano->duracaoMeses }} {{ $plano->duracaoMeses > 1 ? 'meses' : 'mês' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($plano->deletado)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Desativado
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Ativo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('planos.edit', $plano->idPlano) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                
                                @if($plano->deletado)
                                    <form method="POST" action="{{ route('planos.restore', $plano->idPlano) }}" class="inline-block" onsubmit="return confirm('Tem certeza que deseja REATIVAR este plano?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-900">
                                            Restaurar
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('planos.destroy', $plano->idPlano) }}" class="inline-block" onsubmit="return confirm('Tem certeza que deseja DESATIVAR este plano?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Desativar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                Nenhum plano cadastrado ainda.
                            </td>
                        </tr>
                    @endforelse
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection 