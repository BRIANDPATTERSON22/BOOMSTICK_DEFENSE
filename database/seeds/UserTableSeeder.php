<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        // Creating default permissions
        Permission::create(['name' => 'add settings']);
        Permission::create(['name' => 'edit settings']);
        Permission::create(['name' => 'view settings']);
        Permission::create(['name' => 'delete settings']);

        Permission::create(['name' => 'add users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'add roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'add permissions']);
        Permission::create(['name' => 'edit permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'add pages']);
        Permission::create(['name' => 'edit pages']);
        Permission::create(['name' => 'view pages']);
        Permission::create(['name' => 'delete pages']);

        Permission::create(['name' => 'add menus']);
        Permission::create(['name' => 'edit menus']);
        Permission::create(['name' => 'view menus']);
        Permission::create(['name' => 'delete menus']);

        Permission::create(['name' => 'add blocks']);
        Permission::create(['name' => 'edit blocks']);
        Permission::create(['name' => 'view blocks']);
        Permission::create(['name' => 'delete blocks']);

        Permission::create(['name' => 'add sliders']);
        Permission::create(['name' => 'edit sliders']);
        Permission::create(['name' => 'view sliders']);
        Permission::create(['name' => 'delete sliders']);

        Permission::create(['name' => 'add contacts']);
        Permission::create(['name' => 'edit contacts']);
        Permission::create(['name' => 'view contacts']);
        Permission::create(['name' => 'delete contacts']);

        Permission::create(['name' => 'add advertisements']);
        Permission::create(['name' => 'edit advertisements']);
        Permission::create(['name' => 'view advertisements']);
        Permission::create(['name' => 'delete advertisements']);

        Permission::create(['name' => 'add events']);
        Permission::create(['name' => 'edit events']);
        Permission::create(['name' => 'view events']);
        Permission::create(['name' => 'delete events']);

        Permission::create(['name' => 'add blogs']);
        Permission::create(['name' => 'edit blogs']);
        Permission::create(['name' => 'view blogs']);
        Permission::create(['name' => 'delete blogs']);

        Permission::create(['name' => 'add photos']);
        Permission::create(['name' => 'edit photos']);
        Permission::create(['name' => 'view photos']);
        Permission::create(['name' => 'delete photos']);

        Permission::create(['name' => 'add videos']);
        Permission::create(['name' => 'edit videos']);
        Permission::create(['name' => 'view videos']);
        Permission::create(['name' => 'delete videos']);

        Permission::create(['name' => 'add audios']);
        Permission::create(['name' => 'edit audios']);
        Permission::create(['name' => 'view audios']);
        Permission::create(['name' => 'delete audios']);

        // site 
        Permission::create(['name' => 'add testimonials']);
        Permission::create(['name' => 'edit testimonials']);
        Permission::create(['name' => 'view testimonials']);
        Permission::create(['name' => 'delete testimonials']);

        Permission::create(['name' => 'add services']);
        Permission::create(['name' => 'edit services']);
        Permission::create(['name' => 'view services']);
        Permission::create(['name' => 'delete services']);

        // ecommerce
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'add products']);
        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'delete products']);

        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'add categories']);
        Permission::create(['name' => 'edit categories']);
        Permission::create(['name' => 'delete categories']);

        Permission::create(['name' => 'view sub categories']);
        Permission::create(['name' => 'add sub categories']);
        Permission::create(['name' => 'edit sub categories']);
        Permission::create(['name' => 'delete sub categories']);

        Permission::create(['name' => 'view sub category types']);
        Permission::create(['name' => 'add sub category types']);
        Permission::create(['name' => 'edit sub category types']);
        Permission::create(['name' => 'delete sub category types']);

        Permission::create(['name' => 'view brands']);
        Permission::create(['name' => 'add brands']);
        Permission::create(['name' => 'edit brands']);
        Permission::create(['name' => 'delete brands']);

        Permission::create(['name' => 'view modedl']);
        Permission::create(['name' => 'add modedl']);
        Permission::create(['name' => 'edit modedl']);
        Permission::create(['name' => 'delete modedl']);

        Permission::create(['name' => 'view orders']);
        Permission::create(['name' => 'add orders']);
        Permission::create(['name' => 'edit orders']);
        Permission::create(['name' => 'delete orders']);

        Permission::create(['name' => 'view customers']);
        Permission::create(['name' => 'add customers']);
        Permission::create(['name' => 'edit customers']);
        Permission::create(['name' => 'delete customers']);

        Permission::create(['name' => 'view shipping methods']);
        Permission::create(['name' => 'add shipping methods']);
        Permission::create(['name' => 'edit shipping methods']);
        Permission::create(['name' => 'delete shipping methods']);

        Permission::create(['name' => 'view payment methods']);
        Permission::create(['name' => 'add payment methods']);
        Permission::create(['name' => 'edit payment methods']);
        Permission::create(['name' => 'delete payment methods']);

        Permission::create(['name' => 'view attributes']);
        Permission::create(['name' => 'add attributes']);
        Permission::create(['name' => 'edit attributes']);
        Permission::create(['name' => 'delete attributes']);

        Permission::create(['name' => 'view rsr products']);
        Permission::create(['name' => 'add rsr products']);
        Permission::create(['name' => 'edit rsr products']);
        Permission::create(['name' => 'delete rsr products']);

        // Role - Super Admin [Have All Permissions]
        $superAdminRole = Role::create(['name' => 'super-admin']);
        // $superAdminRole->givePermissionTo(Permission::all());

        // Role - Admin
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Role - Customer
        $editorRole = Role::create(['name' => 'customer']);
        // $editorRole->givePermissionTo(['edit users', 'view users']);

        // Role - Manager
        $managerRole = Role::create(['name' => 'manager']);
        // $managerRole->givePermissionTo(['edit users', 'view users']);
        $managerRole->givePermissionTo(Permission::all());

        //Creating User - SuperAdmin
        $userSuperAdmin = User::create([
            'name'      => 'Super Admin',
            'email'      => 'web57admin@web57hosting.com',
            'password' => bcrypt('57inn0vay$8989'),
            'is_verified' => 1,
            // 'remember_token' => md5(microtime().Config::get('app.key')),
            'ip' => request()->getClientIp(),
            'status' => 1,
        ]);
        $userSuperAdmin->assignRole('super-admin');
        // $userSuperAdmin->givePermissionTo(Permission::all());

        //Creating User - Admin
        $userAdmin = User::create([
            'name'      => 'Admin',
            'email'      => 'web57admin2@web57hosting.com',
            'password' => bcrypt('@dmin@!b3'),
            'is_verified' => 1,
            // 'remember_token' => md5(microtime().Config::get('app.key')),
            'ip' => request()->getClientIp(),
            'status' => 1,
        ]);
        $userAdmin->assignRole('admin');

        //Creating User - Manager
        $userManager = User::create([
            'name'      => 'Manager',
            'email'      => 'web57manager@web57hosting.com',
            'password' => bcrypt('m@n@g3r@!b3'),
            'is_verified' => 1,
            // 'remember_token' => md5(microtime().Config::get('app.key')),
            'ip' => request()->getClientIp(),
            'status' => 1,
        ]);
        $userManager->assignRole('manager');
    }
}