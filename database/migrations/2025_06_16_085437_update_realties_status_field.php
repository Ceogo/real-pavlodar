<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('realties')
            ->where('status', 'active')
            ->update(['status' => 'active']);

        DB::table('realties')
            ->whereIn('status', ['archive', 'blocked'])
            ->update(['status' => 'inactive']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert changes if needed
        DB::table('realties')
            ->where('status', 'inactive')
            ->update(['status' => 'archive']);

        DB::table('realties')
            ->where('status', 'sold')
            ->update(['status' => 'archive']);
    }
};
