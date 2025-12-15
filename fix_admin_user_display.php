<?php
/**
 * Script untuk memperbaiki tampilan user di admin
 * Menampilkan semua user termasuk yang belum memiliki role
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔧 MEMPERBAIKI ADMIN USER DISPLAY\n";
echo "=================================\n\n";

// Backup controller lama
echo "1️⃣ Membuat backup UserController.php...\n";
copy('app/Http/Controllers/UserController.php', 'app/Http/Controllers/UserController.php.backup');
echo "✅ Backup berhasil dibuat\n\n";

// Backup controller lama
echo "2️⃣ Membuat backup AdminController.php...\n";
copy('app/Http/Controllers/Admin/AdminController.php', 'app/Http/Controllers/Admin/AdminController.php.backup');
echo "✅ Backup berhasil dibuat\n\n";

// Modifikasi UserController untuk menampilkan semua user
echo "3️⃣ Memodifikasi UserController.php...\n";

$userControllerContent = file_get_contents('app/Http/Controllers/UserController.php');

// Ganti query untuk menampilkan semua user
$oldQuery = "public function data()
    {
        \$users = User::with('usersDetail')
                ->role('user')
                ->orderBy('created_at', 'desc');";

$newQuery = "public function data()
    {
        \$users = User::with('usersDetail')
                ->orderBy('created_at', 'desc');";

$userControllerContent = str_replace($oldQuery, $newQuery, $userControllerContent);

// Tambahkan kolom role
$oldColumn = "            ->addColumn('no_hp', function (\$user) {
                return \$user->usersDetail ? \$user->usersDetail->no_hp : '-';
            })";

$newColumn = "            ->addColumn('no_hp', function (\$user) {
                return \$user->usersDetail ? \$user->usersDetail->no_hp : '-';
            })
            ->addColumn('role', function (\$user) {
                if (\$user->hasRole('admin')) {
                    return '<span class=\"badge badge-danger\">Admin</span>';
                } elseif (\$user->hasRole('tutor')) {
                    return '<span class=\"badge badge-info\">Tutor</span>';
                } elseif (\$user->hasRole('user')) {
                    return '<span class=\"badge badge-success\">User</span>';
                } else {
                    return '<span class=\"badge badge-warning\">Tanpa Role</span>';
                }
            })";

$userControllerContent = str_replace($oldColumn, $newColumn, $userControllerContent);

// Update columns array
$oldColumns = "                }
                    , {
                    data: 'aksi'";

$newColumns = "                }
                    , {
                    data: 'role',
                    searchable: false,
                    sortable: false
                }
                    , {
                    data: 'aksi'";

$userControllerContent = str_replace($oldColumns, $newColumns, $userControllerContent);

file_put_contents('app/Http/Controllers/UserController.php', $userControllerContent);
echo "✅ UserController.php berhasil dimodifikasi\n\n";

// Modifikasi view untuk menambahkan kolom role
echo "4️⃣ Memodifikasi view admin/user/index.blade.php...\n";

$userViewContent = file_get_contents('resources/views/admin/user/index.blade.php');

// Tambah kolom role di header
$oldHeader = "                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No HP</th>
                                        <th style=\"width: 15%\"><i class=\"fa fa-cog\"></i></th>";

$newHeader = "                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No HP</th>
                                        <th>Role</th>
                                        <th style=\"width: 15%\"><i class=\"fa fa-cog\"></i></th>";

$userViewContent = str_replace($oldHeader, $newHeader, $userViewContent);

// Tambah kolom role di JavaScript columns
$oldJsColumn = "                    , {
                    data: 'no_hp'
                }
                    , {
                    data: 'aksi'";

$newJsColumn = "                    , {
                    data: 'no_hp'
                }
                    , {
                    data: 'role'
                }
                    , {
                    data: 'aksi'";

$userViewContent = str_replace($oldJsColumn, $newJsColumn, $userViewContent);

// Update columnDefs
$oldDefs = "                , columnDefs: [
                    { className: 'text-center', targets: [0, 3, 4] },
                ]";

$newDefs = "                , columnDefs: [
                    { className: 'text-center', targets: [0, 3, 4, 5] },
                ]";

$userViewContent = str_replace($oldDefs, $newDefs, $userViewContent);

file_put_contents('resources/views/admin/user/index.blade.php', $userViewContent);
echo "✅ View admin/user/index.blade.php berhasil dimodifikasi\n\n";

// Modifikasi AdminController untuk menampilkan semua user
echo "5️⃣ Memodifikasi AdminController.php...\n";

$adminControllerContent = file_get_contents('app/Http/Controllers/Admin/AdminController.php');

// Ganti query untuk menampilkan semua user
$oldAdminQuery = "    public function data() {
        \$users = User::with('roles')
                ->role('admin')
                ->orderBy('name', 'asc');";

$newAdminQuery = "    public function data() {
        \$users = User::with('roles')
                ->orderBy('name', 'asc');";

$adminControllerContent = str_replace($oldAdminQuery, $newAdminQuery, $adminControllerContent);

// Update role display logic
$oldRoleLogic = "            ->addColumn('roles', function (\$user) {
                return '<span class=\"badge badge-success\">'. \$user->roles->pluck('name')[0] .'</span>';
            })";

$newRoleLogic = "            ->addColumn('roles', function (\$user) {
                if (\$user->roles->count() > 0) {
                    return '<span class=\"badge badge-success\">'. \$user->roles->pluck('name')[0] .'</span>';
                } else {
                    return '<span class=\"badge badge-warning\">Tanpa Role</span>';
                }
            })";

$adminControllerContent = str_replace($oldRoleLogic, $newRoleLogic, $adminControllerContent);

file_put_contents('app/Http/Controllers/Admin/AdminController.php', $adminControllerContent);
echo "✅ AdminController.php berhasil dimodifikasi\n\n";

// Buat script untuk assign role ke user yang belum punya role
echo "6️⃣ Membuat script untuk assign role default...\n";

$assignRoleScript = '<?php
/**
 * Script untuk memberikan role default ke user yang belum punya role
 */

require_once "vendor/autoload.php";

$app = require_once "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔄 ASSIGNING DEFAULT ROLES TO USERS\n";
echo "===================================\n\n";

try {
    // Get all users without roles
    $usersWithoutRoles = App\Models\User::whereDoesntHave("roles")->get();
    
    echo "📊 Users tanpa role: " . $usersWithoutRoles->count() . "\n\n";
    
    foreach ($usersWithoutRoles as $user) {
        echo "🎯 Assigning role \"user\" ke: {$user->name} ({$user->email})\n";
        
        try {
            $user->assignRole("user");
            echo "✅ Berhasil!\n";
        } catch (Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n✅ Proses selesai!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>';

file_put_contents('assign_default_roles.php', $assignRoleScript);
echo "✅ Script assign_default_roles.php berhasil dibuat\n\n";

echo "🎉 PERBAIKAN SELESAI!\n";
echo "====================\n\n";

echo "📋 YANG SUDAH DILAKUKAN:\n";
echo "1. ✅ Backup controller lama\n";
echo "2. ✅ Modifikasi UserController untuk tampilkan semua user\n";
echo "3. ✅ Modifikasi view untuk tambah kolom Role\n";
echo "4. ✅ Modifikasi AdminController untuk tampilkan semua user\n";
echo "5. ✅ Buat script untuk assign role default\n\n";

echo "📝 LANGKAH SELANJUTNYA:\n";
echo "1. Jalankan: php assign_default_roles.php\n";
echo "2. Clear cache: php artisan config:clear\n";
echo "3. Restart server jika perlu\n";
echo "4. Check admin/user dan admin/admin untuk lihat semua user\n\n";

echo "🔍 HASIL YANG DIHARAPKAN:\n";
echo "- Di admin/user: Semua user akan muncul dengan kolom Role\n";
echo "- Di admin/admin: Semua user akan muncul (tidak hanya admin)\n";
echo "- User tanpa role akan mendapat badge 'Tanpa Role'\n";
echo "- User akan otomatis mendapat role 'user' setelah script dijalankan\n";
?>