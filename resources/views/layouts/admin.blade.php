<?php

use Illuminate\Support\Facades\Request;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão | @yield('title', 'Painel')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .sidebar {
            width: 256px; 
            transition: all 0.3s ease;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 50;
                height: 100%;
            }
            .sidebar.active {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="flex min-h-screen">

    <aside id="sidebar" class="sidebar bg-gray-800 text-white shadow-xl flex-shrink-0 md:translate-x-0">
        <div class="p-6">
            <h1 class="text-2xl font-extrabold text-indigo-400">PAINEL DE GESTÃO</h1>
        </div>
        
        <nav class="mt-8 space-y-2 px-4">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-150 {{ Request::is('gestao') ? 'bg-gray-700' : '' }}">Dashboard</a>
            <div class="pt-4 text-xs font-semibold uppercase text-gray-400 px-3">Cadastros e Gestão</div>
            
            <a href="{{ route('planos.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-150 {{ Request::is('gestao/planos*') ? 'bg-gray-700' : '' }}">Planos</a>
            <a href="{{ route('modalidades.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-150 {{ Request::is('gestao/modalidades*') ? 'bg-gray-700' : '' }}">Modalidades</a>
            <a href="{{ route('professores.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-150 {{ Request::is('gestao/professores*') ? 'bg-gray-700' : '' }}">Professores</a>
            
             <a href="{{ route('alunos.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-150 {{ Request::is('gestao/alunos*') ? 'bg-gray-700' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20h-2m2 0h2m-7.468-6.417A2.99 2.99 0 0110 14h-2m0 0a2.99 2.99 0 00-1.542 1.583m1.542-1.583a3.003 3.003 0 010-4.116m0 0L9 11m0 0l-1-1" />
                </svg>
                Alunos
            </a>
            
            <a href="{{ route('treinos.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-150 {{ Request::is('gestao/treinos*') ? 'bg-gray-700' : '' }}">Treinos</a>

            <!-- CORREÇÃO: trocamos 'admin.pagamentos' por 'pagamentos.index' -->
            <a href="{{ route('pagamentos.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-150 {{ Request::is('gestao/pagamentos*') ? 'bg-gray-700' : '' }}">Pagamentos</a>
        </nav>
        
        <div class="mt-auto p-4 border-t border-gray-700">
             <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center p-3 rounded-lg hover:bg-red-600 text-red-300 hover:text-white transition duration-150">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Sair
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-grow flex flex-col">
        <header class="bg-white shadow-sm p-4 flex items-center justify-between sticky top-0 z-40">
            <button id="menu-toggle" class="md:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            
            <h2 class="text-2xl font-semibold text-gray-800 hidden md:block">
                @yield('header_title', 'Painel')
            </h2>
            
            <div class="flex items-center space-x-4">
                @yield('header_actions')
            </div>
        </header>

        <main class="p-6 md:p-10 flex-grow">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
                    <strong class="font-bold">Erro de Validação:</strong>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
            
        </main>
        
        <footer class="p-4 text-center text-sm text-gray-500 border-t bg-white">
            &copy; {{ date('Y') }} Academia. Painel de Gestão.
        </footer>
    </div>
    
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('menu-toggle');
            
            if (sidebar && !sidebar.contains(event.target) && toggle && !toggle.contains(event.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>