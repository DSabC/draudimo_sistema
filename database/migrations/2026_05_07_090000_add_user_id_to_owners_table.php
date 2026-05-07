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
        Schema::table('owners', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('address')->constrained()->nullOnDelete();
        });

        $defaultOwnerUserId = User::query()
            ->orderByRaw("case when role = ? then 0 else 1 end", [User::ROLE_ADMIN])
            ->value('id');

        if ($defaultOwnerUserId !== null) {
            DB::table('owners')
                ->whereNull('user_id')
                ->update(['user_id' => $defaultOwnerUserId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
