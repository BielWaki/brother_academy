<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia BROTHER | Alcance Seus Limites</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            color: #1e293b;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-blue': '#007BFF',   // Azul Royal
                        'primary-black': '#0D0D0D',  // Preto
                        'primary-gray': '#B0B0B0',   // Cinza Metálico
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">

<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <a href="{{ route('homepage') }}" class="text-3xl font-extrabold text-primary-blue tracking-wider">
                Academia Brother 💪🏻
            </a>
            
            <nav class="hidden md:flex space-x-6">
                <a href="#modalidades" class="text-gray-600 hover:text-primary-blue font-medium transition duration-150">Modalidades</a>
                <a href="#planos" class="text-gray-600 hover:text-primary-blue font-medium transition duration-150">Planos</a>
                <a href="{{ route('aluno.register.form') }}" class="text-gray-600 hover:text-primary-blue font-medium transition duration-150">Matricule-se</a>
            </nav>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('aluno.login.form') }}" class="py-2 px-4 border border-primary-blue text-sm font-medium text-primary-blue rounded-lg hover:bg-blue-50 transition duration-150">
                    Login Aluno
                </a>
            </div>
        </div>
    </div>
</header>

<main>
<section class="relative h-[60vh] flex items-center justify-center overflow-hidden" style="background-image: url('/imagens/imagem1.jpg'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-primary-black bg-opacity-70 backdrop-blur-sm"></div>
        
        <div class="relative z-10 text-center max-w-4xl px-4">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white leading-tight mb-4">
                Alcance Seus Limites. Transforme Seu Corpo.
            </h1>
            <p class="text-xl text-blue-100 mb-8">
                Equipamentos de ponta e infraestrutura de qualidade com mensalidades acessíveis.
            </p>
            <a href="#planos" class="py-3 px-8 text-lg font-bold text-primary-blue bg-white rounded-full shadow-xl hover:bg-gray-100 transition duration-300 transform hover:scale-105 inline-flex items-center">
                Ver Planos e Preços
            </a>
        </div>
    </section>
    
    <section id="planos" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-2">
                Venha treinar na <span class="text-primary-blue">melhor</span> academia da sua região
            </h2>
            <p class="text-lg text-gray-600 mb-12 max-w-3xl mx-auto">
                Escolha o plano ideal para você e comece a sua transformação hoje.
            </p>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                @php
                    $planosMock = [
                        (object)['nomePlano' => 'Plano Basic', 'valor' => 119.90, 'duracaoMeses' => 1, 'is_vantajoso' => false, 'beneficios' => ['Acesso à unidade principal', 'Área de musculação', 'Acompanhamento do instrutor']],
                        (object)['nomePlano' => 'Plano Black', 'valor' => 149.90, 'duracaoMeses' => 12, 'is_vantajoso' => true, 'beneficios' => ['Todas as academias da rede', 'Leve 5 amigos para treinar', 'Cadeira de massagem', 'Área de musculação e aeróbicos']],
                        (object)['nomePlano' => 'Plano Fit', 'valor' => 99.90, 'duracaoMeses' => 1, 'is_vantajoso' => false, 'beneficios' => ['Acesso à unidade principal', 'Área de musculação']],
                    ];
                @endphp

                @foreach ($planosMock as $plano)
                    <div class="relative flex flex-col h-full rounded-xl shadow-2xl transition duration-300 transform hover:scale-[1.02]
                        @if($plano->is_vantajoso)
                            bg-primary-black text-white border border-primary-black 
                        @else
                            bg-white text-gray-900 border border-gray-200
                        @endif
                    ">
                        
                        @if($plano->is_vantajoso)
                            <div class="absolute top-0 -translate-y-1/2 left-1/2 -translate-x-1/2 bg-primary-blue text-white font-extrabold text-sm px-4 py-1 rounded-full shadow-lg">
                                O mais vantajoso
                            </div>
                        @endif

                        <div class="p-8 pb-4 flex-grow">
                            <h3 class="text-3xl font-extrabold mb-2
                                @if($plano->is_vantajoso) text-white @else text-gray-900 @endif">
                                {{ $plano->nomePlano }}
                            </h3>
                            <p class="text-sm
                                @if($plano->is_vantajoso) text-gray-300 @else text-gray-500 @endif
                            ">
                                @if($plano->duracaoMeses > 1)
                                    {{ $plano->duracaoMeses }} meses de fidelidade
                                @else
                                    Sem fidelidade
                                @endif
                            </p>

                            <div class="mt-4 mb-6">
                                <p class="text-sm line-through
                                    @if($plano->is_vantajoso) text-gray-400 @else text-gray-500 @endif
                                ">
                                    DE R$ {{ number_format($plano->valor, 2, ',', '.') }}/mês
                                </p>
                                <p class="text-lg font-bold text-primary-blue">
                                    A PARTIR DE
                                </p>
                                <p class="text-5xl font-extrabold mt-1">
                                    <span class="text-2xl">R$</span> 9,90*
                                </p>
                                <p class="text-sm mt-1
                                    @if($plano->is_vantajoso) text-gray-300 @else text-gray-600 @endif
                                ">
                                    no 1º mês, depois R$ {{ number_format($plano->valor, 2, ',', '.') }}/mês
                                </p>
                            </div>
                        </div>

                        <div class="px-8 mb-8">
                            <a href="{{ route('aluno.register.form') }}?plano={{ $plano->nomePlano }}"
                                class="w-full inline-flex justify-center py-3 px-6 rounded-lg shadow-md text-base font-bold transition duration-150 ease-in-out 
                                @if($plano->is_vantajoso)
                                    bg-primary-blue hover:bg-blue-600 text-white
                                @else
                                    bg-primary-blue hover:bg-blue-600 text-white
                                @endif
                                "
                            >
                                Contratar Agora
                            </a>
                        </div>
                        
                        <div class="p-8 border-t
                            @if($plano->is_vantajoso) border-gray-700 @else border-gray-200 @endif
                        ">
                            <ul class="text-left space-y-3">
                                @foreach($plano->beneficios as $beneficio)
                                    <li class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-2 h-6 w-6
                                            @if($plano->is_vantajoso) text-green-400 @else text-green-500 @endif"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-sm
                                            @if($plano->is_vantajoso) text-gray-200 @else text-gray-700 @endif
                                        ">
                                            {{ $beneficio }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach

            </div>
            
            <p class="text-sm text-gray-500 mt-8">* Condição de preço promocional válida apenas para o primeiro mês de adesão.</p>
        </div>
    </section>

    <section id="modalidades" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Aulas e Treinos Exclusivos!</h2>
            <p class="text-lg text-gray-600 mb-12 max-w-3xl mx-auto">
                Treinos de alta intensidade, funcionais e aulas coletivas para manter a motivação.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse ($modalidades as $modalidade)
                    <div class="bg-white rounded-xl shadow-2xl overflow-hidden border border-gray-100 transition duration-300 transform hover:shadow-blue-300/50">
                        <img class="w-full h-48 object-cover"
                        src="{{ $modalidade->imagemUrl }}"
                        alt="{{ $modalidade->nome }}">
                        
                        <div class="bg-primary-blue text-white font-extrabold text-xl py-3 px-4">
                            {{ strtoupper($modalidade->nome) }}
                        </div>

                        <div class="p-6">
                            <div class="flex justify-around items-center mb-6 border-b pb-4 border-gray-100">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary-blue mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-xs font-medium text-gray-500">Duração</span>
                                    <span class="text-sm font-bold text-gray-800">45 / 60 min</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary-blue mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    <span class="text-xs font-medium text-gray-500">Intensidade</span>
                                    <span class="text-sm font-bold text-gray-800">Alta</span>
                                </div>
                            </div>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-4">{{ $modalidade->descricao }}</p>
                            
                            <a href="#modalidade-detalhe-{{ $modalidade->idModalidade }}" class="inline-block text-sm font-bold text-primary-blue hover:text-blue-700 transition duration-150">
                                    Saiba Mais
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-3 text-center py-10">
                        <p class="text-gray-500">Nenhuma modalidade cadastrada ainda. Em breve teremos novidades!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <div class="bg-white">

@foreach ($modalidades as $modalidade)
    
    <!--
        Esta é a seção de detalhe para CADA modalidade.
    -->
    <section id="modalidade-detalhe-{{ $modalidade->idModalidade }}"
            class="py-20
                    @if($loop->iteration % 2 == 0)
                        bg-gray-50
                    @else
                        bg-white
                    @endif
                ">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                
                <!-- Coluna da Imagem -->
                <div>
                    <img class="w-full h-96 object-cover rounded-2xl shadow-2xl"
                        src="{{ $modalidade->imagemUrl }}"
                        alt="Imagem de {{ $modalidade->nome }}">
                </div>

                <!-- Coluna do Conteúdo -->
                <div class="
                    @if($loop->iteration % 2 == 0)
                        md:order-first 
                    @endif
                ">
                    <h2 class="text-4xl font-extrabold text-primary-blue mb-4">
                        {{ $modalidade->nome }}
                    </h2>
                    <p class="text-lg text-gray-600 mb-6">
                        {{ $modalidade->descricao }}
                    </p>

                    <!-- Curiosidades Específicas -->
                    @if($modalidade->nome == 'Aeróbico')
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Sabia que...?</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            <li>O termo "aeróbico" foi criado em 1968 pelo Dr. Kenneth H. Cooper, provando que exercícios que aumentam o consumo de oxigênio previnem doenças cardíacas.</li>
                            <li>Exercícios aeróbicos são famosos por liberarem endorfina, o "hormônio da felicidade", reduzindo o estresse e melhorando o humor.</li>
                            <li>Não é só corrida! Dança, pular corda e natação também são excelentes exercícios aeróbicos.</li>
                        </ul>

                    @elseif($modalidade->nome == 'Muay Thai')
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">A Arte dos Oito Membros</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            <li>É conhecido como a "arte dos oito membros" porque usa punhos, cotovelos, joelhos e canelas.</li>
                            <li>Originário da Tailândia, era a técnica de combate desarmado usada pelos guerreiros siameses.</li>
                            <li>Um treino intenso de Muay Thai pode queimar mais de 800 calorias por hora, sendo um dos mais eficientes para perda de peso.</li>
                        </ul>

                    @elseif($modalidade->nome == 'CrossFit')
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">O que é o "WOD"?</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            <li>"WOD" significa "Workout of the Day" (Treino do Dia). Cada dia o treino é diferente, o que impede o corpo de se acostumar e torna o exercício menos monótono.</li>
                            <li>O CrossFit não foca em uma só coisa; ele mistura levantamento de peso olímpico, ginástica e cardio para criar atletas completos.</li>
                            <li>O senso de comunidade é um dos pilares. Os alunos frequentemente treinam juntos e incentivam uns aos outros a superar seus limites.</li>
                        </ul>

                    @elseif($modalidade->nome == 'Spinning')
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Mais que Pedalar</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            <li>Foi criado em 1987 pelo ciclista Johnny G, que queria treinar em casa simulando as montanhas da Califórnia, incluindo a parte mental do esporte.</li>
                            <li>É um exercício de altíssima intensidade, mas de baixo impacto, o que significa que queima muitas calorias sem sobrecarregar joelhos e tornozelos.</li>
                            <li>A música não é só um detalhe, ela dita o ritmo, a intensidade e a cadência da pedalada, tornando a aula uma experiência imersiva.</li>
                        </ul>

                    @elseif($modalidade->nome == 'Treino Funcional')
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Movimentos do Dia a Dia</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            <li>O foco é treinar movimentos que você usa na vida real: agachar (como para pegar algo), levantar, empurrar e puxar.</li>
                            <li>Quase todos os exercícios funcionais ativam o "core" (músculos do abdômen, lombar e quadril), melhorando a postura e prevenindo dores nas costas.</li>
                            <li>Em vez de máquinas que isolam um músculo, o funcional usa pesos livres, faixas elásticas e o peso do próprio corpo para trabalhar vários músculos ao mesmo tempo.</li>
                        </ul>
                    @endif
                    
                    <a href="#modalidades" class="inline-block mt-8 text-sm font-bold text-primary-blue hover:text-blue-700 transition duration-150">
                        &larr; Voltar para todas as modalidades
                    </a>
                </div>

            </div>
        </div>
    </section>
    
@endforeach


</div>
</main>

<!-- Rodapé ATUALIZADO com 'primary-black' -->
<footer class="bg-primary-black text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-lg font-bold mb-4 text-primary-blue">Academia</p>
        <div class="text-sm text-gray-400 space-x-4">
            <a href="#" class="hover:text-primary-blue">Termos de Uso</a>
            <span>|</span>
            <a href="#" class="hover:text-primary-blue">Política de Privacidade</a>
        </div>
        <p class="mt-6 text-xs text-gray-500">
            &copy; {{ date('Y') }} Academia. Todos os direitos reservados.
        </p>
    </div>
</footer>

</body>
</html>