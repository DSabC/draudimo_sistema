<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default(User::ROLE_REGULAR);
            });
        }

        if (Schema::hasColumn('users', 'is_admin')) {
            DB::table('users')
                ->where('is_admin', true)
                ->update(['role' => User::ROLE_ADMIN]);

            DB::table('users')
                ->where('is_admin', false)
                ->update(['role' => User::ROLE_REGULAR]);

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_admin');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_admin')->default(false);
            });
        }

        if (Schema::hasColumn('users', 'role')) {
            DB::table('users')
                ->where('role', User::ROLE_ADMIN)
                ->update(['is_admin' => true]);

            DB::table('users')
                ->where('role', '!=', User::ROLE_ADMIN)
                ->update(['is_admin' => false]);

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
