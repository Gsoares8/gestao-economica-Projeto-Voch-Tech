<?php

namespace Tests\Feature;

use App\Models\User; // Importa o User
use Illuminate\Foundation\Testing\RefreshDatabase; // Reseta o banco a cada teste
use Tests\TestCase;

class GrupoEconomicoTest extends TestCase
{
    // Esta 'trait' garante que o banco de dados seja limpo
    // e nossas migrations sejam rodadas antes de cada teste.
    use RefreshDatabase;

    /**
     * Teste 1: Usuário não logado não pode ver a página.
     */
    public function test_nao_logado_nao_pode_ver_grupos(): void
    {
        // Tenta acessar a página
        $response = $this->get('/grupos-economicos');

        // Confirma que foi redirecionado para a tela de login
        $response->assertStatus(302); // 302 é um redirecionamento
        $response->assertRedirect('/login');
    }

    /**
     * Teste 2: Usuário logado pode ver a página.
     */
    public function test_logado_pode_ver_grupos(): void
    {
        // 1. Cria um usuário falso no banco de dados
        $user = User::factory()->create();

        // 2. "Loga" como esse usuário e acessa a página
        $response = $this->actingAs($user)->get('/grupos-economicos');

        // 3. Confirma que a página carregou (status 200)
        $response->assertStatus(200);

        // 4. Confirma que o texto "Adicionar Novo Grupo" está na tela
        $response->assertSee('Adicionar Novo Grupo');
    }
}