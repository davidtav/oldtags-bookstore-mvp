<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// Exemplo de rota da API (checkout)
Route::post('/checkout', function (Request $request) {
    $items = $request->input('items', []);
    $total = $request->input('total', 0);

    Log::info('--- NOVO PEDIDO RECEBIDO ---');
    Log::info('Total do Pedido: R$' . number_format($total, 2, ',', '.'));
    Log::info('Itens: ' . count($items) . ' livros.');

    foreach ($items as $item) {
        Log::info("  - Livro: {$item['titulo']} (ID: {$item['id']}) - R$ {$item['preco']}");
    }

    return response()->json([
        'message' => 'Pedido processado com sucesso!',
        'order_id' => time()
    ]);
});
