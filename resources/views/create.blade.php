<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineCRUD - Cadastrar Filme</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col">

    <nav class="bg-slate-900/80 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50 px-6 py-4">
        <div class="max-w-3xl mx-auto flex items-center justify-between">
            <a href="/filmes" class="flex items-center gap-2 text-xl font-black tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-violet-500">
                <i class="fa-solid fa-popcorn text-indigo-500"></i> CINECRUD
            </a>
            
            <a href="/filmes" class="text-sm font-medium text-slate-400 hover:text-white transition-colors flex items-center gap-2">
                <i class="fa-solid fa-arrow-left text-xs"></i> Voltar para a listagem
            </a>
        </div>
    </nav>

    <main class="flex-1 max-w-3xl w-full mx-auto px-4 py-10 flex flex-col justify-center">
        
        <div class="bg-slate-900 rounded-2xl border border-slate-800/60 shadow-2xl p-6 sm:p-10 relative overflow-hidden">
            
            <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 via-purple-500 to-violet-500"></div>

            <div class="mb-8">
                <h1 class="text-2xl font-extrabold text-white flex items-center gap-3">
                    <i class="fa-solid fa-clapperboard text-indigo-400"></i> Cadastrar Novo Filme
                </h1>
                <p class="text-sm text-slate-400 mt-1">Preencha as informações abaixo para adicionar o título ao seu catálogo.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl text-sm">
                    <div class="flex items-center gap-2 font-bold mb-1">
                        <i class="fa-solid fa-triangle-exclamation"></i> Ops! Verifique os campos:
                    </div>
                    <ul class="list-disc pl-5 space-y-0.5 text-xs text-slate-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/filmes/store" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="flex flex-col gap-2">
                    <label for="titulo" class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2">
                        Título do Filme <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                            <i class="fa-solid fa-heading text-sm"></i>
                        </span>
                        <input type="text" name="titulo" id="titulo" required placeholder="Ex: Interstellar" value="{{ old('titulo') }}"
                            class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="descricao" class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2">
                        Descrição / Sinopse
                    </label>
                    <div class="relative">
                        <textarea name="descricao" id="descricao" rows="5" placeholder="Digite uma breve sinopse ou resumo do filme..."
                            class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all resize-none leading-relaxed">{{ old('descricao') }}</textarea>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2">
                        Capa do Filme (Imagem)
                    </label>
                    
                    <div class="group relative border-2 border-dashed border-slate-800 hover:border-indigo-500/50 rounded-xl p-6 text-center bg-slate-950/50 transition-colors cursor-pointer">
                        <input type="file" name="imagem" id="imagem" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="updateFileName(this)">
                        
                        <div id="upload-placeholder" class="space-y-2">
                            <div class="w-10 h-10 bg-slate-900 rounded-lg flex items-center justify-center mx-auto text-slate-400 group-hover:text-indigo-400 transition-colors border border-slate-800">
                                <i class="fa-solid fa-cloud-arrow-up text-base"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-300">Clique para fazer upload ou arraste a imagem</p>
                            <p class="text-xs text-slate-500">Formatos aceitos: PNG, JPG, JPEG ou WEBP</p>
                        </div>

                        <div id="file-selected" class="hidden space-y-2">
                            <div class="w-10 h-10 bg-indigo-500/10 rounded-lg flex items-center justify-center mx-auto text-indigo-400 border border-indigo-500/20">
                                <i class="fa-solid fa-file-image text-base"></i>
                            </div>
                            <p id="file-name-text" class="text-sm font-semibold text-indigo-400 truncate max-w-xs mx-auto"></p>
                            <p class="text-xs text-slate-500">Clique ou arraste se desejar substituir</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-4 border-t border-slate-800/60">
                    <a href="/filmes" class="w-full sm:w-auto inline-flex items-center justify-center bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white font-semibold text-sm px-5 py-3 rounded-xl transition-colors cursor-pointer">
                        Cancelar
                    </a>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-semibold text-sm px-6 py-3 rounded-xl shadow-lg shadow-indigo-600/20 active:scale-[0.98] transition-all duration-200 cursor-pointer">
                        <i class="fa-solid fa-check text-xs"></i> Salvar Filme
                    </button>
                </div>

            </form>
        </div>

    </main>

    <footer class="bg-slate-950 border-t border-slate-900 py-6 text-center text-xs text-slate-600">
        <p>&copy; {{ date('Y') }} CineCRUD. Todos os direitos reservados.</p>
    </footer>

    <script>
        function updateFileName(input) {
            const placeholder = document.getElementById('upload-placeholder');
            const fileSelectedDiv = document.getElementById('file-selected');
            const fileNameText = document.getElementById('file-name-text');

            if (input.files && input.files[0]) {
                fileNameText.textContent = input.files[0].name;
                placeholder.classList.add('hidden');
                fileSelectedDiv.classList.remove('hidden');
            } else {
                placeholder.classList.remove('hidden');
                fileSelectedDiv.classList.add('hidden');
            }
        }
    </script>

</body>
</html>