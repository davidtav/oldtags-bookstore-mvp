<?php

namespace App\Http\Controllers;

use App\Services\SupabaseService;

class CatalogController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

   public function index()
{
    // Chama o serviço e já recebe a resposta
    $response = $this->supabase->from('livros');

    if ($response->failed()) {
        return abort(500, "Erro ao consultar Supabase: " . $response->body());
    }

    $livros = $response->json();

    return view('catalog.index', compact('livros'));
}
}
