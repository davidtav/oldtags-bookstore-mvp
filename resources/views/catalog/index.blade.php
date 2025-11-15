@extends('layouts.app')

@section('content')

<div 
    x-data="catalogoData({ livrosIniciais: {{ json_encode($livros) }} })"
    class="min-h-screen bg-background"
>

    {{-- HEADER --}}
    <header class="bg-blue-700 text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <h2 class="text-xl font-bold">OldTags bookstore</h2>

            <a href="/cart" class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>

                {{-- BADGE DO CARRINHO --}}
                <span 
                    x-text="cart.length"
                    class="absolute top-[-5px] right-[-5px] bg-red-600 text-white text-xs rounded-full 
                           h-5 w-5 flex items-center justify-center font-bold">
                </span>
            </a>
        </div>
    </header>

    {{-- CONTEÚDO PRINCIPAL --}}
    <main class="container mx-auto px-4 py-8">

        {{-- TÍTULO + SUBTÍTULO --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-foreground mb-2">
                Livros Usados de Tecnologia
            </h1>
            <p class="text-muted-foreground">
                Encontre os melhores livros técnicos com preços especiais
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            {{-- FILTROS --}}
            <aside class="lg:col-span-1">
                <div class="p-4 border rounded shadow bg-white">
                    <h3 class="font-bold text-lg mb-4">Filtros</h3>

                    <label class="block mb-2 text-sm font-medium">Buscar Livros:</label>
                    <input 
                        type="text" 
                        x-model.debounce.300ms="searchTerm" 
                        class="w-full p-2 border rounded mb-4"
                        placeholder="Título, Autor..."
                    >

                    <label class="block mb-2 text-sm font-medium">Condição:</label>
                    <select 
                        x-model="filtroCondicao" 
                        class="w-full p-2 border rounded"
                    >
                        <option value="Todas">Todas as condições</option>
                        <option value="novo">Novo</option>
                        <option value="usado">Usado</option>
                    </select>
                </div>
            </aside>

            {{-- LISTAGEM DE LIVROS --}}
            <div class="lg:col-span-3">

                {{-- NENHUM LIVRO --}}
                <div 
                    x-show="livrosFiltrados.length === 0" 
                    class="text-center py-12"
                >
                    <p class="text-xl text-muted-foreground">
                        Nenhum livro encontrado com os filtros selecionados.
                    </p>
                </div>

                {{-- GRID DE LIVROS --}}
                <div 
                    x-show="livrosFiltrados.length > 0"
                    class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6"
                >
                    <template x-for="book in livrosFiltrados" :key="book.id">
                        <div
                            class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow"
                        >
                            <div class="w-full h-64 flex items-center justify-center bg-gray-100 p-4">
                                <img 
                                    :src="book.capa_url" 
                                    :alt="book.titulo"
                                    class="max-h-full max-w-full object-contain"
                                >
                            </div>

                            <div class="p-4">
                                <h3 
                                    class="text-lg font-semibold mb-1 line-clamp-2" 
                                    x-text="book.titulo"
                                ></h3>

                                <p class="text-sm text-gray-500 mb-2">
                                    Autor: <span x-text="book.autor"></span>
                                </p>

                                <p class="text-xl font-bold text-orange-600 mb-1">
                                    R$ <span x-text="book.preco"></span>
                                </p>

                                <p class="text-xs text-gray-600 mb-3">
                                    Condição: <span x-text="book.condicao"></span>
                                </p>

                                {{-- BOTÃO DE CARRINHO --}}
                                <button 
                                    @click="addToCart(book)"
                                    class="mt-2 w-full bg-blue-700 text-white p-2 rounded 
                                           hover:bg-blue-800 transition font-medium"
                                >
                                    Adicionar ao Carrinho
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

    </main>
</div>

<script>
document.addEventListener("alpine:init", () => {
    
    Alpine.data("catalogoData", (props) => ({

        // Dados do Laravel
        livros: props.livrosIniciais,

        // Filtros
        searchTerm: "",
        filtroCondicao: "Todas",

        // Carrinho
        cart: [],

        // Inicialização
        init() {
            const saved = localStorage.getItem("oldtags_cart");
            if (saved) {
                this.cart = JSON.parse(saved);
            }
        },

        // Adicionar ao carrinho
        addToCart(livro) {
            if (!this.cart.find(item => item.id === livro.id)) {
                this.cart.push(livro);
                localStorage.setItem("oldtags_cart", JSON.stringify(this.cart));
                alert("Livro adicionado ao carrinho!");
            } else {
                alert("Este livro já está no carrinho!");
            }
        },

        // Filtro computado
        get livrosFiltrados() {
            return this.livros.filter(livro => {

                const texto = (livro.titulo + " " + livro.autor).toLowerCase();
                const busca = this.searchTerm.toLowerCase();

                const condicaoOK =
                    this.filtroCondicao === "Todas" ||
                    livro.condicao === this.filtroCondicao;

                return texto.includes(busca) && condicaoOK;
            });
        },

    }));

});
</script>

@endsection
