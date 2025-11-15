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
        // Busca os livros na tabela "livros"
        $response = $this->supabase
            ->from('livros')
            ->get('');

        if ($response->failed()) {
            return abort(500, "Erro ao consultar Supabase: " . $response->body());
        }

        $livros = $response->json();

        return view('catalog.index', compact('livros'));
    }
}
