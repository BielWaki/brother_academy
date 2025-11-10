<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil | Academia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; }
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
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Meu Perfil Completo</h1>

        <div class="bg-white p-6 rounded-xl shadow-lg border border-slate-200">
            <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Meus Dados</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                <p><strong>Nome:</strong> {{ $aluno->nome }}</p>
                <p><strong>E-mail:</strong> {{ $aluno->email }}</p>
                <p><strong>Nascimento:</strong> {{ \Carbon\Carbon::parse($aluno->data_nascimento)->format('d/m/Y') }}</p>
                <p><strong>Telefone:</strong> {{ $aluno->telefone ?? 'Não cadastrado' }}</p>
                <p><strong>Plano Atual:</strong> {{ $aluno->plano ? $aluno->plano->nomePlano : 'Nenhum' }}</p>
                <p><strong>Professor:</strong> {{ $aluno->professor ? $aluno->professor->nome : 'Aguardando atribuição' }}</p>
            </div>
            
            <hr class="my-6">
            
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Segurança</h2>
            <a href="{{ route('aluno.senha.form') }}" 
               class="inline-block py-2 px-5 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition duration-150">
                Alterar Minha Senha
            </a>
            
            <a href="{{ route('aluno.dashboard') }}" 
               class="inline-block py-2 px-5 text-gray-600 hover:text-black transition duration-150">
                &larr; Voltar ao Painel
            </a>
        </div>
    </div>
</body>
</html>