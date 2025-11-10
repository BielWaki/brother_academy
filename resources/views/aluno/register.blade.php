<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrícula | Academia</title>
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
<body class="flex flex-col items-center justify-center min-h-screen py-10">

    <div class="mb-6">
        <a href="{{ route('homepage') }}" class="text-3xl font-extrabold text-primary-blue tracking-wider">
            Academia
        </a>
    </div>

    <div class="w-full max-w-2xl bg-white p-8 rounded-xl shadow-2xl border border-gray-200">
        
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800">Matrícula Online</h1>
            <p class="text-gray-500 mt-2">Comece sua transformação hoje!</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
                <strong class="font-bold">Erro de Validação:</strong>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('aluno.register') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                    <input type="text" name="nome" id="nome" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-blue focus:border-primary-blue" 
                        value="{{ old('nome') }}">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-blue focus:border-primary-blue" 
                        value="{{ old('email') }}">
                </div>
                
                <div>
                    <label for="data_nascimento" class="block text-sm font-medium text-gray-700 mb-1">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" id="data_nascimento" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-blue focus:border-primary-blue" 
                        value="{{ old('data_nascimento') }}">
                </div>
                
                <div>
                    <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone (Opcional)</label>
                    <input type="text" name="telefone" id="telefone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-blue focus:border-primary-blue" 
                        value="{{ old('telefone') }}" placeholder="(XX) XXXXX-XXXX">
                </div>

                <div class="md:col-span-2">
                    <label for="idPlano" class="block text-sm font-medium text-gray-700 mb-1">Escolha seu Plano</label>
                    <select name="idPlano" id="idPlano" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-blue focus:border-primary-blue">
                        <option value="">--- Selecione um Plano ---</option>
                        @if(isset($planos))
                            @foreach($planos as $plano)
                                <option value="{{ $plano->idPlano }}" 
                                    {{ old('idPlano') == $plano->idPlano ? 'selected' : '' }}>
                                    {{ $plano->nomePlano }} (R$ {{ number_format($plano->valor, 2, ',', '.') }})
                                </option>
                            @endforeach
                        @else
                            <option disabled>Erro ao carregar planos.</option>
                        @endif
                    </select>
                </div>

                <div>
                    <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Crie sua Senha</label>
                    <input type="password" name="senha" id="senha" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-blue focus:border-primary-blue" 
                        placeholder="Mínimo 8 caracteres">
                </div>

                <div>
                    <label for="senha_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirme sua Senha</label>
                    <input type="password" name="senha_confirmation" id="senha_confirmation" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-blue focus:border-primary-blue" 
                        placeholder="Repita a senha">
                </div>
            </div>
            
            <button 
                type="submit" 
                class="w-full py-3 px-4 mt-8 bg-primary-blue text-white font-bold rounded-lg shadow-lg hover:bg-blue-600 transition duration-200"
            >
                Finalizar Matrícula
            </button>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Já tem uma conta? 
                    <a href="{{ route('aluno.login.form') }}" class="font-medium text-primary-blue hover:text-blue-700">
                        Faça login aqui
                    </a>
                </p>
            </div>
        </form>

    </div>

</body>
</html>