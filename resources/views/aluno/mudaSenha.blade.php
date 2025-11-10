<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mudar Senha | Academia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen">

    <div class="mb-6">
        <a href="{{ route('homepage') }}" class="text-3xl font-extrabold text-indigo-600 tracking-wider">
            Academia
        </a>
    </div>

    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-2xl border border-gray-200">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800">Alterar Senha</h1>
            <p class="text-gray-500 mt-2">Digite sua senha antiga e uma nova senha.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('aluno.senha.update') }}">
            @csrf <div class="mb-5">
                <label for="senha_antiga" class="block text-sm font-medium text-gray-700 mb-1">Senha Antiga</label>
                <input 
                    type="password" 
                    id="senha_antiga" 
                    name="senha_antiga" 
                    required 
                    placeholder="Sua senha atual"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>
            
            <div class="mb-5">
                <label for="senha_nova" class="block text-sm font-medium text-gray-700 mb-1">Nova Senha</label>
                <input 
                    type="password" 
                    id="senha_nova" 
                    name="senha_nova" 
                    required 
                    placeholder="Mínimo 8 caracteres"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <div class="mb-6">
                <label for="senha_nova_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirme a Nova Senha</label>
                <input 
                    type="password" 
                    id="senha_nova_confirmation" 
                    name="senha_nova_confirmation" 
                    required 
                    placeholder="Repita a nova senha"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>
            
            <button 
                type="submit" 
                class="w-full py-3 px-4 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-700 transition duration-200"
            >
                Salvar Nova Senha
            </button>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    <a href="{{ route('aluno.dashboard') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Voltar para o painel
                    </a>
                </p>
            </div>
        </form>
    </div>

</body>
</html>