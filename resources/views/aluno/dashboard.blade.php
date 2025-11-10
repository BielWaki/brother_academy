<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard do Aluno | Academia</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f1f5f9;
            }
        </style>
    </head>
    <body>

    <nav class="bg-indigo-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('aluno.dashboard') }}" class="flex-shrink-0 text-white text-xl font-bold tracking-wider">
                    Academia | Aluno
                </a>
                <div class="flex items-center space-x-4">
                    <span class="text-white text-sm hidden sm:block">Olá, {{ $aluno->nome }}</span>
                    <form method="POST" action="{{ route('aluno.logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-indigo-200 hover:text-white transition duration-150 ease-in-out">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Bem-vindo(a) ao seu Painel, {{ $aluno->nome }}</h1>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                <p class="font-bold">Sucesso!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif


        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-lg border border-slate-200">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Minha Conta
                </h2>
                <div class="space-y-3 text-gray-700">
                    <p><strong>E-mail:</strong> {{ $aluno->email }}</p>
                    <p><strong>Nascimento:</strong> {{ \Carbon\Carbon::parse($aluno->data_nascimento)->format('d/m/Y') }}</p>
                    <p><strong>Plano Atual:</strong>
                        @if($aluno->plano)
                            <span class="font-medium text-indigo-600">{{ $aluno->plano->nomePlano }}</span>
                        @else
                            Nenhum plano ativo.
                        @endif
                    </p>
                    <p><strong>Professor:</strong>
                        @if($aluno->professor)
                            <span class="font-medium">{{ $aluno->professor->nome }}</span>
                        @else
                            Aguardando atribuição.
                        @endif
                    </p>
                    
                    <a href="{{ route('aluno.perfil') }}" class="w-full block text-center mt-4 py-2 px-4 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition duration-150">
                        Ver Perfil Completo
                    </a>
                    </div>
            </div>

            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg border border-slate-200">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Modalidades do seu Plano
                </h2>
                
                @if($aluno->plano && $aluno->plano->modalidades->count() > 0)
                    
                    <div class="space-y-5"> 
                        
                        <p class="text-gray-700 text-base">Seu plano <strong>{{ $aluno->plano->nomePlano }}</strong> dá acesso a:</p>

                        @foreach($aluno->plano->modalidades as $modalidade)
                            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                                <strong class="block text-indigo-700 text-lg">{{ $modalidade->nome }}</strong>
                                <p class="text-gray-600 text-sm mt-1">{{ $modalidade->descricao }}</p>
                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="text-center py-6">
                        <p class="text-gray-500">
                            @if($aluno->plano)
                                Nenhuma modalidade específica encontrada para o seu plano.
                            @else
                                Você não possui um plano ativo para listarmos as modalidades.
                            @endif
                        </p>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-lg border border-slate-200">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Status Financeiro
                </h2>
                
                <div class="space-y-3 text-gray-700">
                    <p><strong>Status:</strong>
                        <span class="font-bold p-1 rounded-md text-sm
                            @if($statusPagamento == 'Em dia')
                                bg-green-100 text-green-700
                            @else
                                bg-red-100 text-red-700
                            @endif">
                            {{ $statusPagamento }}
                        </span>
                    </p>
                    <p><strong>Último Pagamento:</strong>
                        @if($ultimoPagamento)
                            {{ \Carbon\Carbon::parse($ultimoPagamento->dataPagamento)->format('d/m/Y') }} (R$ {{ number_format($ultimoPagamento->valor, 2, ',', '.') }})
                        @else
                            Nenhum registro.
                        @endif
                    </p>
                    <p><strong>Próximo Vencimento:</strong>
                        @if($proximoVencimento)
                            <span class="font-medium text-lg">{{ \Carbon\Carbon::parse($proximoVencimento)->format('d/m/Y') }}</span>
                        @else
                            Não aplicável.
                        @endif
                    </p>
                    
                    <a href="{{ route('aluno.pagamentos') }}" class="w-full block text-center mt-4 py-2 px-4 border border-transparent rounded-lg shadow-md text-white bg-green-500 hover:bg-green-600 transition duration-150">
                        Ver Histórico de Pagamentos
                    </a>
                    </div>
            </div>
            
        </div>
    </div>

    </body>
</html>