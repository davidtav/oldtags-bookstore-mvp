@extends('layouts.app')

@section('content')
<div x-data="loginData" class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-2xl">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Entrar na OldTags</h1>
        
        <p class="text-center text-sm text-gray-600 mb-8">
            Faça login com sua conta Google para acessar o sistema.
        </p>

        <button @click="signInWithGoogle" :disabled="isSigningIn"
            class="w-full flex items-center justify-center space-x-3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 disabled:opacity-70">
            
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.96 3.65 9.12 8.41 9.87l.03-.02c.08.01.16.02.24.02.19 0 .37-.03.55-.08.09-.03.17-.07.26-.1.17-.05.34-.12.5-.2.08-.04.16-.08.24-.13.15-.09.29-.19.43-.29.14-.1.27-.22.4-.33.13-.12.25-.24.36-.37.1-.13.19-.27.28-.41.08-.14.15-.29.21-.44.06-.15.11-.3.16-.45.04-.15.07-.3.09-.45.02-.15.03-.3.03-.45V12h-2c0 4.42-3.58 8-8 8s-8-3.58-8-8 3.58-8 8-8c2.47 0 4.7 1.15 6.27 3.01l1.42-1.42C17.47 4.29 14.88 2 12 2 6.48 2 2 6.48 2 12s4.48 10 10 10c5.52 0 10-4.48 10-10zM12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm-1.5 5h3v2h-3v-2zm-2 0h-3v2h3v-2zm-2 4h7v2h-7v-2zm9.5-6h-2v-2h2v2zm-2 4h-2v-2h2v2z" fill="white"/></svg>
            <span x-text="isSigningIn ? 'Redirecionando...' : 'Entrar com Google'"></span>
        </button>
        <p class="mt-4 text-center text-xs text-gray-500">
            Ao continuar, você concorda com nossos termos.
        </p>
    </div>
</div>

<script>
    const SUPABASE_URL = '{{ env('SUPABASE_URL') }}';
    const SUPABASE_KEY = '{{ env('SUPABASE_KEY') }}';
    const supabaseClient = Supabase.createClient(SUPABASE_URL, SUPABASE_KEY);

    document.addEventListener('alpine:init', () => {
        Alpine.data('loginData', () => ({
            isSigningIn: false,
            
            async signInWithGoogle() {
                this.isSigningIn = true;
                
                
                const { error } = await supabaseClient.auth.signInWithOAuth({
                    provider: 'google',
                    options: {
                        
                        redirectTo: '{{ url('/admin/dashboard') }}' 
                    }
                });

                if (error) {
                    this.isSigningIn = false;
                    console.error('Erro ao iniciar o login com Google:', error);
                    alert('Erro ao tentar conectar. Verifique o console.');
                }
                // Se bem-sucedido, o Supabase cuida do redirecionamento, então não precisamos de 'else' aqui.
            }
        }));
    });
</script>
@endsection
