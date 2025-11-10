@extends('layouts.admin')

@section('title', 'Painel Administrativo')
@section('header_title', 'Visão Geral')

@section('content')
    <h3 class="text-xl font-bold mb-6 text-gray-800">Resumo da Academia</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-indigo-500">
            <p class="text-sm font-medium text-gray-500">Total de Alunos</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">1,240</p>
            <p class="text-xs text-green-500 mt-2">+5% este mês</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
            <p class="text-sm font-medium text-gray-500">Planos Ativos</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">3</p>
            <p class="text-xs text-gray-500 mt-2">Plano Black é o mais popular</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-yellow-500">
            <p class="text-sm font-medium text-gray-500">Pagamentos Pendentes</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">R$ 5.400,00</p>
            <p class="text-xs text-yellow-600 mt-2">Atenção aos inadimplentes</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-pink-500">
            <p class="text-sm font-medium text-gray-500">Professores</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">12</p>
            <p class="text-xs text-indigo-500 mt-2">Ver equipe completa</p>
        </div>
    </div>
    
    <div class="mt-10 bg-white p-6 rounded-xl shadow-lg">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Últimas Atividades e Logs</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ação</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tabela</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registro ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">INSERT</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Alunos</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">258</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">08/11/2025 10:30</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">UPDATE</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Treinos</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">105</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">08/11/2025 09:45</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">DELETE</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Planos</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">5</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">07/11/2025 18:15</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection