<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Área do Aluno</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9; /* slate-100 */
        }
    </style>
    <!-- Configuração das Novas Cores -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-blue': '#007BFF',
                        'primary-black': '#0D0D0D',
                        'primary-gray': '#B0B0B0',
                    }
                }
            }
        }
    </script>
</head>
<body class="flex flex-col items-center justify-center min-h-screen">

    <div class="mb-6">
        <a href="{{ route('homepage') }}" class="text-3xl font-extrabold text-primary-blue tracking-wider">
            Academia
        </a>
    </div>

    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-2xl border border-gray-200">
        
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800">Área do Aluno</h1>
            <p class="text-gray-500 mt-2">Acesse seu painel e sua ficha de treino.</p>
        </div>

        <!-- Exibe erros de validação (Ex: senha errada) -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('aluno.login') }}">
            @csrf
            
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    placeholder="seu.email@exemplo.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-blue focus:border-primary-blue transition duration-150"
                    value="{{ old('email') }}"
                >
            </div>
            
            <div class="mb-6">
                <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                <input
                    type="password"
                    id="senha"
                    name="senha"
                    required
                    placeholder="••••••••"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-blue focus:border-primary-blue transition duration-150"
                >
            </div>
            
            <button
                type="submit"
                class="w-full py-3 px-4 bg-primary-blue text-white font-bold rounded-lg shadow-lg hover:bg-blue-600 transition duration-200"
            >
                Entrar
            </button>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Não tem uma conta?
                    <a href="{{ route('aluno.register.form') }}" class="font-medium text-primary-blue hover:text-blue-700">
                        Matricule-se aqui
                    </a>
                </p>
            </div>
        </form>

    </div>

</body>
</html>