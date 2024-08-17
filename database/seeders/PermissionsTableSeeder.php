<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        DB::table('permissions')->insert([
            /** ACL  1 to 11 */
            [
                'name' => 'Acessar ACL',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Listar Permissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Criar Permissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Editar Permissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Excluir Permissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Listar Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Criar Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Editar Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Excluir Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Sincronizar Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Atribuir Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],

            /** Users 12 to 17 */
            [
                'name' => 'Acessar Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Listar Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Criar Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Editar Usuário',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Editar Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Excluir Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            /** Certificates 18 to 22 */
            [
                'name' => 'Acessar Certificados',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Listar Certificados',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Criar Certificados',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Editar Certificados',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Excluir Certificados',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            /** Blog 23 to 31 */
            [
                'name' => 'Acessar Blog',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Listar Categorias do Blog',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Criar Categorias do Blog',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Editar Categorias do Blog',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Excluir Categorias do Blog',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Listar Blog',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Criar Blog',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Editar Blog',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Excluir Blog',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            /** Portfolio 32 to 40 */
            [
                'name' => 'Acessar Portfolio',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Listar Categorias do Portfolio',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Criar Categorias do Portfolio',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Editar Categorias do Portfolio',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Excluir Categorias do Portfolio',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Listar Portfolio',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Criar Portfolio',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Editar Portfolio',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
            [
                'name' => 'Excluir Portfolio',
                'guard_name' => 'web',
                'created_at' => new DateTime('now'),
            ],
        ]);
    }
}
