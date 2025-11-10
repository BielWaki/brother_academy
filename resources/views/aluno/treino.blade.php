<!DOCTYPE html>
    <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Treino Completo | Academia</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
                body {
                    font-family: 'Inter', sans-serif;
                    background-color: #f1f5f9; 
                }
                .pre-wrap {
                    white-space: pre-wrap;
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
            
            <div class="flex items-center justify-between mb-8 border-b pb-4">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Sua Ficha de Treino
                </h1>
                <a href="{{ route('aluno.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center">
                    &larr; Voltar para o Dashboard
                </a>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-slate-200 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-700">
                    <div>
                        <p class="font-semibold text-sm text-indigo-600">Treino ID</p>
                        <p class="text-xl font-bold">{{ $treino->idTreino }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-sm text-indigo-600">Início da Vigência</p>
                        <p class="text-xl font-bold">{{ \Carbon\Carbon::parse($treino->data_inicio)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-sm text-indigo-600">Previsão de Fim</p>
                        <p class="text-xl font-bold">
                            @if($treino->data_fim)
                                {{ \Carbon\Carbon::parse($treino->data_fim)->format('d/m/Y') }}
                            @else
                                Em Aberto
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-2xl border border-slate-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Detalhes e Execução</h2>
                
                @if($treino->descricao)
                    <div class="pre-wrap text-lg text-gray-700 leading-relaxed">
                        {{ $treino->descricao }}
                    </div>
                @else
                    <div class="text-center py-10 bg-gray-50 rounded-lg">
                        <p class="text-gray-500">A descrição detalhada do seu treino não foi preenchida.</p>
                        <p class="text-gray-500 mt-2">Entre em contato com seu professor ({{ $aluno->professor->nome ?? 'N/A' }}).</p>
                    </div>
                @endif
                
            </div>

        </div>

        <footer class="p-4 text-center text-sm text-gray-500 border-t bg-white mt-10">
            &copy; {{ date('Y') }} Academia. Área do Aluno.
        </footer>

        </body>
    </html>