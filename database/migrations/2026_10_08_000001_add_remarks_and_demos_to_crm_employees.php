<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('crm_employees')) {
            Schema::table('crm_employees', function (Blueprint $table) {
                if (!Schema::hasColumn('crm_employees', 'remarks')) {
                    $table->text('remarks')->nullable()->after('target_amount');
                }
                if (!Schema::hasColumn('crm_employees', 'demos_count')) {
                    $table->integer('demos_count')->default(0)->after('remarks');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('crm_employees')) {
            Schema::table('crm_employees', function (Blueprint $table) {
                if (Schema::hasColumn('crm_employees', 'remarks')) {
                    $table->dropColumn('remarks');
                }
                if (Schema::hasColumn('crm_employees', 'demos_count')) {
                    $table->dropColumn('demos_count');
                }
            });
        }
    }
};
