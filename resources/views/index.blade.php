<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineCRUD - Catálogo de Filmes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col">

    <nav class="bg-slate-900/80 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <a href="#" class="flex items-center gap-2 text-xl font-black tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-violet-500">
                <i class="fa-solid fa-popcorn text-indigo-500"></i> CINECRUD
            </a>
            
            <div class="relative w-full sm:w-72">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-500">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </span>
                <input type="text" placeholder="Buscar filme..." class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-9 pr-4 py-2 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition-colors">
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 py-8">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
                    Meus Filmes
                    <span class="text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 px-2.5 py-1 rounded-full">
                        {{ count($filmes ?? []) }} {{ count($filmes ?? []) == 1 ? 'Filme' : 'Filmes' }}
                    </span>
                </h1>
                <p class="text-sm text-slate-400 mt-1">Gerencie seu catálogo pessoal de filmes favoritos.</p>
            </div>

            <a href="#" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-semibold text-sm px-5 py-3 rounded-xl shadow-lg shadow-indigo-600/20 active:scale-[0.98] transition-all duration-200 cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i> Adicionar Filme
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-sm">
                <i class="fa-solid fa-circle-check text-base"></i>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @forelse($filmes ?? [] as $filme)
                <div class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-800/60 shadow-md group transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-indigo-500/5 hover:border-slate-700/80">
                    
                    <div class="relative aspect-[3/4] bg-slate-800 overflow-hidden">
                        @if(!empty($filme->capa))
                            <img src="{{ asset('storage/' . $filme->capa) }}" alt="{{ $filme->titulo }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-600 p-4 bg-gradient-to-b from-slate-900 to-slate-800">
                                <i class="fa-solid fa-film text-4xl mb-3 text-slate-700"></i>
                                <span class="text-xs text-center font-bold uppercase tracking-widest text-slate-500">Sem Imagem</span>
                            </div>
                        @endif

                        <span class="absolute top-3 right-3 bg-slate-950/80 backdrop-blur-sm text-indigo-400 text-xs font-bold px-2.5 py-1 rounded-lg border border-slate-800">
                            {{ $filme->ano }}
                        </span>
                    </div>
                    
                    <div class="p-5">
                        <span class="text-[10px] font-black uppercase tracking-wider text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/10">
                            {{ $filme->genero }}
                        </span>
                        
                        <h3 class="text-base font-bold text-white mt-3 line-clamp-1 group-hover:text-indigo-400 transition-colors" title="{{ $filme->titulo }}">
                            {{ $filme->titulo }}
                        </h3>
                        
                        <p class="text-xs text-slate-400 mt-2 line-clamp-2 min-h-[32px]" title="{{ $filme->sinopse }}">
                            {{ $filme->sinopse ?? 'Nenhuma sinopse disponível para este título.' }}
                        </p>
                        
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-800/80">
                            <a href="#" class="text-xs font-semibold text-slate-400 hover:text-indigo-400 flex items-center gap-1.5 transition-colors">
                                <i class="fa-solid fa-pen-to-square"></i> Editar
                            </a>
                            
                            <form action="#" method="POST" onsubmit="return confirm('Deseja mesmo excluir este filme do catálogo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-slate-400 hover:text-rose-400 flex items-center gap-1.5 transition-colors cursor-pointer">
                                    <i class="fa-solid fa-trash-can"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-slate-900/40 border border-dashed border-slate-800 rounded-3xl p-12 text-center max-w-md mx-auto w-full mt-8">
                    <div class="w-14 h-14 bg-indigo-600/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-indigo-500/10">
                        <i class="fa-solid fa-clapperboard text-xl text-indigo-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Nenhum filme cadastrado</h3>
                    <p class="text-slate-500 mt-1.5 text-xs leading-relaxed">
                        Sua lista está limpa no momento. Adicione os seus filmes favoritos para começar a organizar seu catálogo!
                    </p>
                    <a href="#" class="inline-flex items-center gap-2 mt-5 bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white font-medium text-xs px-4 py-2.5 rounded-xl border border-slate-700/60 transition-all cursor-pointer">
                        <i class="fa-solid fa-plus"></i> Cadastrar o Primeiro
                    </a>
                </div>
            @endforelse
        </div>

    </main>

    <footer class="bg-slate-950 border-t border-slate-900 py-6 text-center text-xs text-slate-600">
        <p>&copy; {{ date('Y') }} CineCRUD. Desenvolvido com Laravel & Tailwind CSS.</p>
    </footer>

</body>
</html>