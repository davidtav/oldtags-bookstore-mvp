@extends('layouts.app')

@section('content')
<div x-data="cartData" x-init="init" class="min-h-screen bg-gray-100">

    
    <header class="bg-blue-700 text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <h2 class="text-xl font-bold">OldTags Bookstore</h2>
            <a href="/" class="text-white hover:text-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Seu Carrinho de Compras</h1>

    
        <div x-show="cart.length === 0" class="text-center py-20 bg-white rounded-lg shadow">
            <p class="text-xl text-gray-500">Seu carrinho está vazio.</p>
            <a href="/" class="mt-4 inline-block px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800">Voltar para o Catálogo</a>
        </div>

        <div x-show="cart.length > 0" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
           
            <div class="lg:col-span-2 space-y-4">
                <template x-for="item in cart" :key="item.id">
                    <div class="flex items-center bg-white p-4 rounded-lg shadow-sm">
                        <img :src="item.capa_url || 'https://via.placeholder.com/80x120'" :alt="item.titulo" class="w-20 h-24 object-cover rounded mr-4">
                        <div class="flex-grow">
                            <h3 class="text-lg font-semibold" x-text="item.titulo"></h3>
                            <p class="text-gray-600 text-sm" x-text="'Autor: ' + item.autor"></p>
                            <p class="text-sm font-bold text-orange-600" x-text="'R$ ' + item.preco"></p>
                        </div>
                        <button @click="removeFromCart(item.id)" class="text-red-500 hover:text-red-700 p-2 ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.86 10.32a2 2 0 01-1.99 1.68H7.85a2 2 0 01-1.99-1.68L5 7m14 0h-4m-6 0H5m14 0l-1.33-4m-10 4l-1.33-4m1.33 4h10.34"></path></svg>
                        </button>
                    </div>
                </template>
            </div>

        
            <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow-lg h-fit">
                <h2 class="text-xl font-bold mb-4">Resumo do Pedido</h2>
                <div class="flex justify-between mb-2">
                    <p>Itens:</p>
                    <p x-text="'R$ ' + totalPrice.toFixed(2)"></p>
                </div>
                <div class="flex justify-between font-bold text-lg border-t pt-4 mt-4">
                    <p>Total:</p>
                    <p x-text="'R$ ' + totalPrice.toFixed(2)"></p>
                </div>
                
             
                <button @click="checkout" :disabled="isCheckingOut" class="mt-6 w-full py-3 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 transition disabled:bg-gray-400">
                    <span x-text="isCheckingOut ? 'Processando...' : 'Finalizar Compra'">Finalizar Compra</span>
                </button>
            </div>
        </div>
    </main>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('cartData', () => ({
        cart: [],
        isCheckingOut: false,

        init() {
           
            const savedCart = localStorage.getItem('oldtags_cart');
            if (savedCart) {
                try {
                    this.cart = JSON.parse(savedCart);
                } catch (e) {
                    this.cart = [];
                }
            }
        },

        
        get totalPrice() {
            
            return this.cart.reduce((total, item) => total + parseFloat(item.preco || 0), 0);
        },

        removeFromCart(id) {
            this.cart = this.cart.filter(item => item.id !== id);
            localStorage.setItem('oldtags_cart', JSON.stringify(this.cart));
        },

       
        async checkout() {
            if (this.cart.length === 0) {
                alert('O carrinho está vazio.');
                return;
            }

            this.isCheckingOut = true;
            
      
            const response = await fetch('/api/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    items: this.cart,
                    total: this.totalPrice
                })
            });

            this.isCheckingOut = false;

            if (response.ok) {
              const data = await response.json();
                    console.group('🛒 Pedido Finalizado');
                    console.log('✅ Pedido processado com sucesso!');
                    console.log('Itens enviados:', this.cart.length);
                    console.log('Total:', `R$ ${this.totalPrice.toFixed(2).replace('.', ',')}`);
                    console.log('ID do Pedido:', data.order_id);
                    console.groupEnd();
                    alert('Pedido finalizado com sucesso! (Verifique o console do navegador)');
                    localStorage.removeItem('oldtags_cart');
                    this.cart = [];
                    window.location.href = '/';
            } else {
                alert('Erro ao finalizar o pedido. Verifique o console.');
            }
        }
    }));
});
</script>
@endsection