<?php

use Illuminate\Support\Facades\Auth;

$errors = $errors ?? new \Illuminate\Support\MessageBag;

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Gestão Academia</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f3f4f6;
            }
        </style>
    </head>
    <body class="flex items-center justify-center min-h-screen">

        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-2xl border border-gray-200">
            
            <div class="text-center mb-8">
                <h1 class="text-4xl font-extrabold text-indigo-700">Gestão Academia</h1>
                <p class="text-gray-500 mt-2">Login para Administradores e Professores</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- CORRIGIDO: Aponta para a rota real de login do admin e inclui @csrf -->
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        placeholder="seu.email@academia.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 @error('password') border-red-500 @enderror"
                    >
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- CORRIGIDO: Removido o onclick. O botão agora envia o formulário de verdade -->
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-700 transition duration-200 transform hover:scale-[1.01]"
                >
                    Entrar
                </button>
                
                <div class="mt-4 text-center">
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Esqueceu sua senha?</a>
                </div>
            </form>

        </div>

    </body>
</html>