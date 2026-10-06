<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Soft Deletes for Recycle Bin
        foreach (['crm_leads', 'crm_customers', 'crm_deals', 'crm_quotations'] as $tbl) {
            if (Schema::hasTable($tbl) && !Schema::hasColumn($tbl, 'deleted_at')) {
                Schema::table($tbl, function (Blueprint $table) {
                    $table->softDeletes();
                });
            }
        }

        // 2. Branches Table
        if (!Schema::hasTable('crm_branches')) {
            Schema::create('crm_branches', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->unique();
                $table->string('city')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->string('status')->default('Active'); // Active, Inactive
                $table->timestamps();
            });
        }

        // Add branch_id to crm_employees and crm_leads
        if (Schema::hasTable('crm_employees') && !Schema::hasColumn('crm_employees', 'branch_id')) {
            Schema::table('crm_employees', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('department_id');
            });
        }
        if (Schema::hasTable('crm_leads') && !Schema::hasColumn('crm_leads', 'branch_id')) {
            Schema::table('crm_leads', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('assigned_to');
            });
        }

        // 3. Quotation Approval Workflow
        if (Schema::hasTable('crm_quotations')) {
            if (!Schema::hasColumn('crm_quotations', 'approval_status')) {
                Schema::table('crm_quotations', function (Blueprint $table) {
                    $table->string('approval_status')->default('Approved')->after('status'); // Approved, Pending, Rejected
                    $table->decimal('discount_percent', 5, 2)->default(0)->after('approval_status');
                    $table->unsignedBigInteger('approved_by')->nullable()->after('discount_percent');
                    $table->text('rejection_reason')->nullable()->after('approved_by');
                });
            }
        }

        // 4. Active Sessions Tracking Table
        if (!Schema::hasTable('crm_user_sessions')) {
            Schema::create('crm_user_sessions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('user_name');
                $table->string('ip_address')->nullable();
                $table->string('user_agent')->nullable();
                $table->string('device')->default('Desktop');
                $table->string('location')->default('India');
                $table->timestamp('last_activity')->useCurrent();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 5. Seed Initial Branches if empty
        if (DB::table('crm_branches')->count() == 0) {
            DB::table('crm_branches')->insert([
                ['name' => 'Head Office Jaipur', 'code' => 'BR-JPR', 'city' => 'Jaipur, Rajasthan', 'phone' => '+91 141 2890000', 'email' => 'jaipur@kkinternational.com', 'address' => 'MI Road, Jaipur', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Delhi Corporate Branch', 'code' => 'BR-DEL', 'city' => 'New Delhi', 'phone' => '+91 11 45678900', 'email' => 'delhi@kkinternational.com', 'address' => 'Connaught Place, New Delhi', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Mumbai Commercial Hub', 'code' => 'BR-MUM', 'city' => 'Mumbai, Maharashtra', 'phone' => '+91 22 26789000', 'email' => 'mumbai@kkinternational.com', 'address' => 'BKC Complex, Bandra East, Mumbai', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Bengaluru Tech Branch', 'code' => 'BR-BLR', 'city' => 'Bengaluru, Karnataka', 'phone' => '+91 80 41234567', 'email' => 'blr@kkinternational.com', 'address' => 'Indiranagar 100ft Road, Bengaluru', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }

    public function down(): void
    {
        // Reversible if needed
    }
};
