@extends('layouts.app')

@section('content')
<script>
    // 1. Defina as constantes globalmente
    const SUPABASE_URL = 'https://meylzxetnzkpuusmnsom.supabase.co';
    const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im1leWx6eGV0bnprcHV1c21uc29tIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjI3ODc3OTgsImV4cCI6MjA3ODM2Mzc5OH0.nT1iHe3V0BdkcblMHx05HDdTHy4skHC0mRgb-HCa2p4';

    // 2. Variável para o cliente Supabase
    let supabaseClient = null;

    // INICIALIZA O SUPABASE ASSIM QUE DISPONÍVEL
    (function waitForSupabase() {
        if (typeof supabase !== 'undefined') {
            supabaseClient = supabase.createClient(SUPABASE_URL, SUPABASE_KEY);
            console.log('✅ Supabase inicializado com sucesso!');
        } else {
            console.log('⏳ Aguardando Supabase carregar...');
            setTimeout(waitForSupabase, 50);
        }
    })();

    // OUVINTE DE EVENTO PARA GARANTIR QUE ALPINE ESTEJA PRONTO
    document.addEventListener('alpine:init', () => {
        console.log('🎨 Inicializando Alpine.js component...');

        Alpine.data('catalogoData', () => ({
            // Variáveis de Estado
            livros: [],
            searchTerm: '',
            filtroCondicao: 'Todas',
            cart: [],
            isLoading: false,

            // Inicialização
            init() {
                // Carrega o carrinho do localStorage
                const savedCart = localStorage.getItem('oldtags_cart');
                if (savedCart) {
                    try {
                        this.cart = JSON.parse(savedCart);
                    } catch (e) {
                        console.error('Erro ao carregar carrinho:', e);
                        this.cart = [];
                    }
                }
                // Busca os livros
                this.fetchLivros();
            },

            // FUNÇÃO DE BUSCA
            async fetchLivros() {
                // Aguarda o Supabase estar pronto
                const maxWait = 50; // 5 segundos
                let waited = 0;
                while (!supabaseClient && waited < maxWait) {
                    console.log('⏳ Aguardando Supabase inicializar...');
                    await new Promise(resolve => setTimeout(resolve, 100));
                    waited++;
                }

                if (!supabaseClient) {
                    console.error('❌ Supabase não inicializou a tempo!');
                    alert('Erro ao inicializar sistema. Por favor, recarregue a página.');
                    this.isLoading = false;
                    return;
                }

                this.isLoading = true;

                try {
                    console.log('🔍 Buscando livros no Supabase...');
                    
                    const { data, error } = await supabaseClient
                        .from('livros')
                        .select('id, titulo, autor, preco, condicao, capa_url');

                    if (error) {
                        console.error('❌ Erro de Supabase:', error);
                        alert(`Erro ao carregar dados!\n\nDetalhe: ${error.message}\n\nVerifique:\n1. A tabela 'livros' existe?\n2. As políticas RLS permitem leitura pública?`);
                        this.livros = [];
                    } else {
                        this.livros = data || [];
                        console.log(`✅ Sucesso! ${this.livros.length} livros carregados.`, data);
                    }
                } catch (e) {
                    console.error("❌ Erro fatal na execução:", e);
                    alert(`Erro inesperado: ${e.message}`);
                    this.livros = [];
                } finally {
                    this.isLoading = false;
                }
            },
            
            // Lógica do Carrinho
            addToCart(livro) {
                // Verifica se o livro já está no carrinho
                const exists = this.cart.find(item => item.id === livro.id);
                if (!exists) {
                    this.cart.push(livro);
                    localStorage.setItem('oldtags_cart', JSON.stringify(this.cart));
                    alert('Livro adicionado ao carrinho!');
                } else {
                    alert('Este livro já está no carrinho!');
                }
            },
            
            // Propriedade Computada (Filtros)
            get livrosFiltrados() { 
                return this.livros.filter(livro => {
                    const matchSearch = livro.titulo.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                                         livro.autor.toLowerCase().includes(this.searchTerm.toLowerCase());
                    const matchCondicao = this.filtroCondicao === 'Todas' || livro.condicao === this.filtroCondicao;
                    return matchSearch && matchCondicao;
                });
            },
        }));
    });
</script>

<div x-data="catalogoData" class="min-h-screen bg-background">

    <header class="bg-blue-700 text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <h2 class="text-xl font-bold">OldTags bookstore</h2>

            <a href="/cart" class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span x-text="cart.length" class="absolute top-[-5px] right-[-5px] bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">0</span>
            </a>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-foreground mb-2">
                Livros Usados de Tecnologia
            </h1>
            <p class="text-muted-foreground">
                Encontre os melhores livros técnicos com preços especiais
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <aside class="lg:col-span-1">
                <div class="p-4 border rounded shadow bg-white">
                    <h3 class="font-bold text-lg mb-4">Filtros</h3>

                    <label class="block mb-2 text-sm font-medium">Buscar Livros:</label>
                    <input type="text" 
                           x-model.debounce.300ms="searchTerm" 
                           class="w-full p-2 border rounded mb-4" 
                           placeholder="Título, Autor...">

                    <label class="block mb-2 text-sm font-medium">Condição:</label>
                    <select x-model="filtroCondicao" class="w-full p-2 border rounded">
                        <option value="Todas">Todas as condições</option>
                        <option value="Novo">Novo</option>
                        <option value="Usado">Usado</option>                       
                    </select>
                </div>
            </aside>

            <div class="lg:col-span-3">
                <div x-show="isLoading" class="text-center py-12">
                    <p class="text-xl text-muted-foreground">Carregando catálogo...</p>
                </div>

                <div x-show="!isLoading && livrosFiltrados.length === 0" class="text-center py-12">
                    <p class="text-xl text-muted-foreground">
                        Nenhum livro encontrado com os filtros selecionados.
                    </p>
                </div>

                <div x-show="!isLoading && livrosFiltrados.length > 0" 
                     class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <template x-for="book in livrosFiltrados" :key="book.id">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow">
                            <img :src="book.capa_url" 
                                 :alt="book.titulo" 
                                 class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-1 line-clamp-2" x-text="book.titulo"></h3>
                                <p class="text-sm text-gray-500 mb-2" x-text="'Autor: ' + book.autor"></p>
                                <p class="text-xl font-bold text-orange-600 mb-1" x-text="'R$ ' + book.preco"></p>
                                <p class="text-xs text-gray-600 mb-3" x-text="'Condição: ' + book.condicao"></p>

                                <button @click="addToCart(book)" 
                                        class="mt-2 w-full bg-blue-700 text-white p-2 rounded hover:bg-blue-800 transition font-medium">
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
@endsection