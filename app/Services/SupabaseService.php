<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SupabaseService
{
    protected $url;
    protected $key;

    public function __construct()
    {
        $this->url = rtrim(env('SUPABASE_URL'), '/');
        $this->key = env('SUPABASE_KEY');
    }

    public function from(string $table)
    {
        return Http::withHeaders([
            'apikey'        => $this->key,
            'Authorization' => "Bearer {$this->key}",
            'Content-Type'  => 'application/json',
        ])->baseUrl("{$this->url}/rest/v1/{$table}");
    }
}
