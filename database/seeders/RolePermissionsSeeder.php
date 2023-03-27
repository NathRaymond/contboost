<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->roles();
        $this->permissions();
    }

    protected function permissions()
    {
        $permissions = collect([
            ['name' => 'manage users', 'group' => 'users', 'description' => 'Manage Users.'],
            ['name' => 'create users', 'group' => 'users', 'description' => 'Create Users.'],
            ['name' => 'edit users', 'group' => 'users', 'description' => 'Edit Users.'],
            ['name' => 'delete users', 'group' => 'users', 'description' => 'Delete Users.'],
            ['name' => 'manage roles', 'group' => 'roles', 'description' => 'Manage System User Roles.'],
            ['name' => 'create roles', 'group' => 'roles', 'description' => 'Create Roles.'],
            ['name' => 'edit roles', 'group' => 'roles', 'description' => 'Edit Roles.'],
            ['name' => 'delete roles', 'group' => 'roles', 'description' => 'Delete Roles.'],
            ['name' => 'manage permissions', 'group' => 'roles', 'description' => 'Manage System User Permissions.'],
            ['name' => 'manage dashboard', 'group' => 'page', 'description' => 'Manage dashboard.'],
            ['name' => 'application operations', 'group' => 'system', 'description' => 'Manage application operations.'],
            ['name' => 'manage transactions', 'group' => 'system', 'description' => 'Manage System transactions.'],
            ['name' => 'manage updates', 'group' => 'system', 'description' => 'Manage System updates.'],
            ['name' => 'manage page', 'group' => 'page', 'description' => 'Manage Page.'],
            ['name' => 'create page', 'group' => 'page', 'description' => 'Create Page.'],
            ['name' => 'edit page', 'group' => 'page', 'description' => 'Edit Page.'],
            ['name' => 'delete page', 'group' => 'page', 'description' => 'Delete Page.'],
            ['name' => 'manage post', 'group' => 'page', 'description' => 'Manage Post.'],
            ['name' => 'create post', 'group' => 'page', 'description' => 'Create Post.'],
            ['name' => 'edit post', 'group' => 'page', 'description' => 'Edit Post.'],
            ['name' => 'delete post', 'group' => 'page', 'description' => 'Delete Post.'],
            ['name' => 'view category', 'group' => 'page', 'description' => 'View Category.'],
            ['name' => 'create category', 'group' => 'page', 'description' => 'Create Category.'],
            ['name' => 'edit category', 'group' => 'page', 'description' => 'Edit Category.'],
            ['name' => 'delete category', 'group' => 'page', 'description' => 'Delete Category.'],
            ['name' => 'manage tag', 'group' => 'page', 'description' => 'Manage tags.'],
            ['name' => 'create tag', 'group' => 'page', 'description' => 'Create tags.'],
            ['name' => 'edit tag', 'group' => 'page', 'description' => 'Edit tags.'],
            ['name' => 'delete tag', 'group' => 'page', 'description' => 'Delete tags.'],
            ['name' => 'manage menus', 'group' => 'menus', 'description' => 'Manage Menus.'],
            ['name' => 'create menus', 'group' => 'menus', 'description' => 'Create Menus.'],
            ['name' => 'edit menus', 'group' => 'menus', 'description' => 'Edit Menus.'],
            ['name' => 'delete menus', 'group' => 'menus', 'description' => 'Delete Menus.'],
            ['name' => 'manage settings', 'group' => 'system', 'description' => 'Delete Settings.'],
            ['name' => 'manage usecases', 'group' => 'tool', 'description' => 'Manage usecase.'],
            ['name' => 'create usecases', 'group' => 'tool', 'description' => 'Create usecase.'],
            ['name' => 'edit usecases', 'group' => 'tool', 'description' => 'Edit usecase.'],
            ['name' => 'manage plans', 'group' => 'plan', 'description' => 'Manage plans.'],
            ['name' => 'create plans', 'group' => 'plan', 'description' => 'Create plans.'],
            ['name' => 'edit plans', 'group' => 'plan', 'description' => 'Edit plans.'],
            ['name' => 'delete plans', 'group' => 'plan', 'description' => 'Delete plans.'],
            ['name' => 'manage transactions', 'group' => 'plan', 'description' => 'Manage transactions.'],
        ]);

        $permissions->each(function ($item) {
            $item['title'] = ucfirst($item['name']);

            $permission = Permission::firstOrCreate(['name' => $item['name']]);
            $permission->update($item);
        });
    }

    protected function roles()
    {
        if (DB::table('roles')->count() == 0) {
            $roles = [
                ['name' => 'Super Admin'],
                ['name' => 'User'],
            ];

            foreach ($roles as $role) {
                Role::create($role);
            }
        }
    }
}
