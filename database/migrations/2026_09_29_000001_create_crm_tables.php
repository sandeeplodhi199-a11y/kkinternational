<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Roles & Permissions
        if (!Schema::hasTable('crm_roles')) {
            Schema::create('crm_roles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('crm_permissions')) {
            Schema::create('crm_permissions', function (Blueprint $table) {
                $table->id();
                $table->string('module');
                $table->string('slug')->unique();
                $table->string('name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('crm_role_permissions')) {
            Schema::create('crm_role_permissions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('role_id');
                $table->unsignedBigInteger('permission_id');
                $table->timestamps();
            });
        }

        // 2. Departments & Employees
        if (!Schema::hasTable('crm_departments')) {
            Schema::create('crm_departments', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('crm_employees')) {
            Schema::create('crm_employees', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('department_id')->nullable();
                $table->string('employee_code')->unique();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('phone')->nullable();
                $table->string('designation')->nullable();
                $table->string('role')->default('Employee'); // Super Admin, Admin, Manager, Employee
                $table->date('joining_date')->nullable();
                $table->decimal('target_amount', 12, 2)->default(0);
                $table->string('status')->default('Active'); // Active, Inactive
                $table->string('avatar')->nullable();
                $table->timestamps();
            });
        }

        // 3. Lead Sources & Statuses
        if (!Schema::hasTable('crm_lead_sources')) {
            Schema::create('crm_lead_sources', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('icon')->nullable();
                $table->string('color')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('crm_lead_statuses')) {
            Schema::create('crm_lead_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('color')->default('#6b7280');
                $table->integer('order_num')->default(0);
                $table->timestamps();
            });
        }

        // 4. Leads & Activities
        if (!Schema::hasTable('crm_leads')) {
            Schema::create('crm_leads', function (Blueprint $table) {
                $table->id();
                $table->string('lead_code')->unique();
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('company')->nullable();
                $table->unsignedBigInteger('source_id')->nullable();
                $table->unsignedBigInteger('status_id')->nullable();
                $table->string('status')->default('New'); // New, Contacted, Qualified, Follow-up, Proposal, Negotiation, Converted, Lost
                $table->string('priority')->default('Medium'); // Low, Medium, High, Urgent
                $table->unsignedBigInteger('assigned_to')->nullable(); // user_id or employee_id
                $table->decimal('expected_value', 12, 2)->default(0);
                $table->date('follow_up_date')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('crm_lead_activities')) {
            Schema::create('crm_lead_activities', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('lead_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('type')->default('note'); // note, call, email, status_change, follow_up, task
                $table->text('description');
                $table->timestamps();
            });
        }

        // 5. Companies & Contacts
        if (!Schema::hasTable('crm_companies')) {
            Schema::create('crm_companies', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('industry')->nullable();
                $table->string('website')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->unsignedBigInteger('assigned_to')->nullable();
                $table->decimal('total_revenue', 12, 2)->default(0);
                $table->integer('total_deals')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('crm_contacts')) {
            Schema::create('crm_contacts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('company_id')->nullable();
                $table->unsignedBigInteger('customer_id')->nullable();
                $table->string('name');
                $table->string('designation')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 6. Customers
        if (!Schema::hasTable('crm_customers')) {
            Schema::create('crm_customers', function (Blueprint $table) {
                $table->id();
                $table->string('customer_code')->unique();
                $table->string('name');
                $table->string('company')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->unsignedBigInteger('assigned_to')->nullable();
                $table->unsignedBigInteger('lead_id')->nullable();
                $table->string('status')->default('Active'); // Active, Inactive
                $table->decimal('total_spent', 12, 2)->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 7. Deals / Sales Pipeline
        if (!Schema::hasTable('crm_deal_stages')) {
            Schema::create('crm_deal_stages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->integer('order_num')->default(0);
                $table->string('color')->default('#3b82f6');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('crm_deals')) {
            Schema::create('crm_deals', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->unsignedBigInteger('customer_id')->nullable();
                $table->unsignedBigInteger('lead_id')->nullable();
                $table->decimal('value', 12, 2)->default(0);
                $table->string('stage')->default('New'); // New, Qualified, Proposal, Negotiation, Won, Lost
                $table->integer('probability')->default(20); // 0-100%
                $table->date('expected_closing_date')->nullable();
                $table->unsignedBigInteger('assigned_to')->nullable();
                $table->string('priority')->default('Medium');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 8. Tasks
        if (!Schema::hasTable('crm_tasks')) {
            Schema::create('crm_tasks', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->unsignedBigInteger('assigned_to')->nullable();
                $table->unsignedBigInteger('related_lead_id')->nullable();
                $table->unsignedBigInteger('related_customer_id')->nullable();
                $table->string('priority')->default('Medium'); // Low, Medium, High, Urgent
                $table->date('due_date')->nullable();
                $table->string('status')->default('Pending'); // Pending, In Progress, Completed, Cancelled
                $table->timestamps();
            });
        }

        // 9. Follow-ups
        if (!Schema::hasTable('crm_followups')) {
            Schema::create('crm_followups', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('lead_id')->nullable();
                $table->unsignedBigInteger('customer_id')->nullable();
                $table->unsignedBigInteger('assigned_to')->nullable();
                $table->date('date');
                $table->time('time')->nullable();
                $table->string('type')->default('Call'); // Call, Email, Meeting, WhatsApp, Demo
                $table->text('notes')->nullable();
                $table->string('status')->default('Pending'); // Pending, Completed, Overdue, Cancelled
                $table->boolean('reminder_sent')->default(false);
                $table->timestamps();
            });
        }

        // 10. Calendar Events
        if (!Schema::hasTable('crm_calendar_events')) {
            Schema::create('crm_calendar_events', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('title');
                $table->string('event_type')->default('Meeting'); // Meeting, Demo, Followup, Task, Reservation
                $table->dateTime('start_time');
                $table->dateTime('end_time')->nullable();
                $table->text('description')->nullable();
                $table->string('location')->nullable();
                $table->timestamps();
            });
        }

        // 11. Demos
        if (!Schema::hasTable('crm_demos')) {
            Schema::create('crm_demos', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->unsignedBigInteger('customer_id')->nullable();
                $table->unsignedBigInteger('lead_id')->nullable();
                $table->unsignedBigInteger('assigned_to')->nullable();
                $table->date('date');
                $table->time('time')->nullable();
                $table->string('status')->default('Scheduled'); // Scheduled, Completed, Rescheduled, Cancelled
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 12. Reservations / Bookings
        if (!Schema::hasTable('crm_reservations')) {
            Schema::create('crm_reservations', function (Blueprint $table) {
                $table->id();
                $table->string('reservation_code')->unique();
                $table->unsignedBigInteger('customer_id')->nullable();
                $table->string('customer_name')->nullable();
                $table->string('service_name');
                $table->date('date');
                $table->time('time')->nullable();
                $table->unsignedBigInteger('assigned_to')->nullable();
                $table->string('status')->default('Confirmed'); // Confirmed, Pending, Completed, Cancelled
                $table->decimal('amount', 12, 2)->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 13. Products & Services
        if (!Schema::hasTable('crm_products')) {
            Schema::create('crm_products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->nullable();
                $table->string('category')->default('Product'); // Product, Service, Software, Subscription
                $table->text('description')->nullable();
                $table->decimal('price', 12, 2)->default(0);
                $table->decimal('tax_rate', 5, 2)->default(18.00); // 18% GST default
                $table->string('status')->default('Active'); // Active, Inactive
                $table->timestamps();
            });
        }

        // 14. Quotations & Items
        if (!Schema::hasTable('crm_quotations')) {
            Schema::create('crm_quotations', function (Blueprint $table) {
                $table->id();
                $table->string('quotation_no')->unique();
                $table->unsignedBigInteger('customer_id')->nullable();
                $table->string('customer_name')->nullable();
                $table->string('customer_email')->nullable();
                $table->string('customer_phone')->nullable();
                $table->date('quotation_date');
                $table->date('valid_until')->nullable();
                $table->decimal('subtotal', 12, 2)->default(0);
                $table->string('discount_type')->default('percentage'); // percentage, fixed
                $table->decimal('discount_rate', 5, 2)->default(0);
                $table->decimal('discount_amount', 12, 2)->default(0);
                $table->decimal('tax_amount', 12, 2)->default(0);
                $table->decimal('grand_total', 12, 2)->default(0);
                $table->text('notes')->nullable();
                $table->text('terms')->nullable();
                $table->string('status')->default('Draft'); // Draft, Sent, Accepted, Declined, Invoiced
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('crm_quotation_items')) {
            Schema::create('crm_quotation_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('quotation_id');
                $table->unsignedBigInteger('product_id')->nullable();
                $table->string('item_name');
                $table->text('description')->nullable();
                $table->integer('quantity')->default(1);
                $table->decimal('unit_price', 12, 2)->default(0);
                $table->decimal('tax_rate', 5, 2)->default(18.00);
                $table->decimal('total', 12, 2)->default(0);
                $table->timestamps();
            });
        }

        // 15. Payments
        if (!Schema::hasTable('crm_payments')) {
            Schema::create('crm_payments', function (Blueprint $table) {
                $table->id();
                $table->string('payment_no')->unique();
                $table->unsignedBigInteger('quotation_id')->nullable();
                $table->unsignedBigInteger('customer_id')->nullable();
                $table->decimal('amount', 12, 2);
                $table->date('payment_date');
                $table->string('payment_method')->default('Bank Transfer'); // Bank Transfer, UPI, Credit Card, Cash, Cheque
                $table->string('transaction_ref')->nullable();
                $table->string('status')->default('Paid'); // Paid, Partially Paid, Pending, Overdue
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 16. Sales Targets
        if (!Schema::hasTable('crm_sales_targets')) {
            Schema::create('crm_sales_targets', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id'); // employee/user
                $table->string('period_type')->default('Monthly'); // Monthly, Quarterly, Yearly
                $table->string('period_name'); // e.g. "October 2026", "Q3 2026", "2026"
                $table->decimal('target_amount', 12, 2);
                $table->decimal('achieved_amount', 12, 2)->default(0);
                $table->date('start_date');
                $table->date('end_date');
                $table->timestamps();
            });
        }

        // 17. Notifications
        if (!Schema::hasTable('crm_notifications')) {
            Schema::create('crm_notifications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable(); // null for all admins
                $table->string('title');
                $table->text('message');
                $table->string('link')->nullable();
                $table->string('type')->default('info'); // info, success, warning, danger
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }

        // 18. Activity Logs
        if (!Schema::hasTable('crm_activity_logs')) {
            Schema::create('crm_activity_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('user_name')->nullable();
                $table->string('module'); // Leads, Deals, Customers, Tasks, Quotations, Payments, Employees
                $table->string('action'); // Created, Updated, Deleted, Status Changed, Assigned
                $table->text('description');
                $table->string('ip_address')->nullable();
                $table->timestamps();
            });
        }

        // 19. Settings
        if (!Schema::hasTable('crm_settings')) {
            Schema::create('crm_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key_name')->unique();
                $table->text('value_data')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_settings');
        Schema::dropIfExists('crm_activity_logs');
        Schema::dropIfExists('crm_notifications');
        Schema::dropIfExists('crm_sales_targets');
        Schema::dropIfExists('crm_payments');
        Schema::dropIfExists('crm_quotation_items');
        Schema::dropIfExists('crm_quotations');
        Schema::dropIfExists('crm_products');
        Schema::dropIfExists('crm_reservations');
        Schema::dropIfExists('crm_demos');
        Schema::dropIfExists('crm_calendar_events');
        Schema::dropIfExists('crm_followups');
        Schema::dropIfExists('crm_tasks');
        Schema::dropIfExists('crm_deals');
        Schema::dropIfExists('crm_deal_stages');
        Schema::dropIfExists('crm_customers');
        Schema::dropIfExists('crm_contacts');
        Schema::dropIfExists('crm_companies');
        Schema::dropIfExists('crm_lead_activities');
        Schema::dropIfExists('crm_leads');
        Schema::dropIfExists('crm_lead_statuses');
        Schema::dropIfExists('crm_lead_sources');
        Schema::dropIfExists('crm_employees');
        Schema::dropIfExists('crm_departments');
        Schema::dropIfExists('crm_role_permissions');
        Schema::dropIfExists('crm_permissions');
        Schema::dropIfExists('crm_roles');
    }
};
