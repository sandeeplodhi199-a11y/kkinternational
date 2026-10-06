<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Crm\CrmRole;
use App\Models\Crm\CrmDepartment;
use App\Models\Crm\CrmEmployee;
use App\Models\Crm\CrmLeadSource;
use App\Models\Crm\CrmLeadStatus;
use App\Models\Crm\CrmLead;
use App\Models\Crm\CrmLeadActivity;
use App\Models\Crm\CrmCompany;
use App\Models\Crm\CrmContact;
use App\Models\Crm\CrmCustomer;
use App\Models\Crm\CrmDeal;
use App\Models\Crm\CrmTask;
use App\Models\Crm\CrmFollowup;
use App\Models\Crm\CrmCalendarEvent;
use App\Models\Crm\CrmDemo;
use App\Models\Crm\CrmReservation;
use App\Models\Crm\CrmProduct;
use App\Models\Crm\CrmQuotation;
use App\Models\Crm\CrmQuotationItem;
use App\Models\Crm\CrmPayment;
use App\Models\Crm\CrmSalesTarget;
use App\Models\Crm\CrmNotification;
use App\Models\Crm\CrmActivityLog;
use App\Models\Crm\CrmSetting;

class CrmDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Roles
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super_admin', 'description' => 'Full access to all system modules and configuration'],
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Full management access to CRM, team, and reports'],
            ['name' => 'Manager', 'slug' => 'manager', 'description' => 'Team-level management and pipeline oversight'],
            ['name' => 'Employee', 'slug' => 'employee', 'description' => 'Standard sales rep access to assigned records'],
        ];
        foreach ($roles as $r) {
            DB::table('crm_roles')->updateOrInsert(['slug' => $r['slug']], array_merge($r, ['created_at' => $now, 'updated_at' => $now]));
        }

        // 2. Departments
        $depts = [
            ['name' => 'Enterprise Sales', 'description' => 'High-ticket B2B client acquisition'],
            ['name' => 'Inside Sales', 'description' => 'Inbound lead qualification and quick closures'],
            ['name' => 'Customer Success', 'description' => 'Client onboarding, retention and account management'],
            ['name' => 'Technical Support', 'description' => 'Product demos, integration and SLA management'],
        ];
        foreach ($depts as $d) {
            DB::table('crm_departments')->updateOrInsert(['name' => $d['name']], array_merge($d, ['created_at' => $now, 'updated_at' => $now]));
        }
        $deptSalesId = DB::table('crm_departments')->where('name', 'Enterprise Sales')->value('id') ?? 1;

        // 3. User Accounts (Admin and Employee)
        // Admin
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@crm.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('KkAdmin@2026!'),
                'mobile' => '+91 9876543210',
                'type' => 'crm_admin',
                'is_deleted' => 0,
            ]
        );

        $adminEmp = DB::table('crm_employees')->updateOrInsert(
            ['email' => 'admin@crm.com'],
            [
                'user_id' => $adminUser->id,
                'department_id' => $deptSalesId,
                'employee_code' => 'EMP-001',
                'name' => 'Admin',
                'email' => 'admin@crm.com',
                'phone' => '+91 9876543210',
                'designation' => 'Managing Director & Head of Sales',
                'role' => 'Admin',
                'joining_date' => '2024-01-15',
                'target_amount' => 1500000.00,
                'status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
        $adminEmpId = DB::table('crm_employees')->where('email', 'admin@crm.com')->value('id');

        // Employee (Maruf Hossen, inspired by the reference screenshot profile!)
        $employeeUser = User::updateOrCreate(
            ['email' => 'employee@crm.com'],
            [
                'name' => 'Maruf Hossen',
                'password' => Hash::make('employee123'),
                'mobile' => '+91 9812345678',
                'type' => 'crm_employee',
                'is_deleted' => 0,
            ]
        );

        DB::table('crm_employees')->updateOrInsert(
            ['email' => 'employee@crm.com'],
            [
                'user_id' => $employeeUser->id,
                'department_id' => $deptSalesId,
                'employee_code' => 'EMP-002',
                'name' => 'Maruf Hossen',
                'email' => 'employee@crm.com',
                'phone' => '+91 9812345678',
                'designation' => 'Senior Account Executive',
                'role' => 'Employee',
                'joining_date' => '2024-06-01',
                'target_amount' => 500000.00,
                'status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
        $empId = DB::table('crm_employees')->where('email', 'employee@crm.com')->value('id');

        // Additional Team Members
        $teamMembers = [
            ['code' => 'EMP-003', 'name' => 'Priya Verma', 'email' => 'priya@crm.com', 'phone' => '+91 9823456789', 'desig' => 'Inside Sales Specialist', 'target' => 400000],
            ['code' => 'EMP-004', 'name' => 'Rahul Roy', 'email' => 'rahul@crm.com', 'phone' => '+91 9834567890', 'desig' => 'Customer Success Manager', 'target' => 350000],
            ['code' => 'EMP-005', 'name' => 'Neha Singh', 'email' => 'neha@crm.com', 'phone' => '+91 9845678901', 'desig' => 'Solutions Consultant', 'target' => 450000],
        ];
        foreach ($teamMembers as $tm) {
            $u = User::updateOrCreate(
                ['email' => $tm['email']],
                [
                    'name' => $tm['name'],
                    'password' => Hash::make('password123'),
                    'mobile' => $tm['phone'],
                    'type' => 'crm_employee',
                    'is_deleted' => 0,
                ]
            );
            DB::table('crm_employees')->updateOrInsert(
                ['email' => $tm['email']],
                [
                    'user_id' => $u->id,
                    'department_id' => $deptSalesId,
                    'employee_code' => $tm['code'],
                    'name' => $tm['name'],
                    'email' => $tm['email'],
                    'phone' => $tm['phone'],
                    'designation' => $tm['desig'],
                    'role' => 'Employee',
                    'joining_date' => '2024-07-10',
                    'target_amount' => $tm['target'],
                    'status' => 'Active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        // 4. Lead Sources
        $sources = [
            ['name' => 'Website', 'slug' => 'website', 'icon' => 'globe', 'color' => '#2563eb'],
            ['name' => 'WhatsApp', 'slug' => 'whatsapp', 'icon' => 'message-circle', 'color' => '#16a34a'],
            ['name' => 'Referral', 'slug' => 'referral', 'icon' => 'users', 'color' => '#9333ea'],
            ['name' => 'Facebook', 'slug' => 'facebook', 'icon' => 'facebook', 'color' => '#1d4ed8'],
            ['name' => 'Instagram', 'slug' => 'instagram', 'icon' => 'instagram', 'color' => '#e11d48'],
            ['name' => 'Google Search', 'slug' => 'google', 'icon' => 'search', 'color' => '#ea580c'],
            ['name' => 'Direct Calling', 'slug' => 'direct', 'icon' => 'phone', 'color' => '#0d9488'],
        ];
        foreach ($sources as $s) {
            DB::table('crm_lead_sources')->updateOrInsert(['slug' => $s['slug']], array_merge($s, ['created_at' => $now, 'updated_at' => $now]));
        }

        // 5. Lead Statuses
        $statuses = [
            ['name' => 'New', 'slug' => 'new', 'color' => '#3b82f6', 'order_num' => 1],
            ['name' => 'Contacted', 'slug' => 'contacted', 'color' => '#6366f1', 'order_num' => 2],
            ['name' => 'Qualified', 'slug' => 'qualified', 'color' => '#06b6d4', 'order_num' => 3],
            ['name' => 'Follow-up', 'slug' => 'follow-up', 'color' => '#f59e0b', 'order_num' => 4],
            ['name' => 'Proposal', 'slug' => 'proposal', 'color' => '#8b5cf6', 'order_num' => 5],
            ['name' => 'Negotiation', 'slug' => 'negotiation', 'color' => '#ec4899', 'order_num' => 6],
            ['name' => 'Converted', 'slug' => 'converted', 'color' => '#10b981', 'order_num' => 7],
            ['name' => 'Lost', 'slug' => 'lost', 'color' => '#ef4444', 'order_num' => 8],
        ];
        foreach ($statuses as $st) {
            DB::table('crm_lead_statuses')->updateOrInsert(['slug' => $st['slug']], array_merge($st, ['created_at' => $now, 'updated_at' => $now]));
        }

        // 6. Companies
        $companies = [
            ['name' => 'Apex Logistics Corp', 'industry' => 'Supply Chain', 'website' => 'https://apexlogistics.in', 'phone' => '+91 22 4567 8901', 'email' => 'info@apexlogistics.in', 'address' => 'Andheri East, Mumbai, MH', 'assigned_to' => $empId, 'total_revenue' => 450000, 'total_deals' => 2],
            ['name' => 'Zenith Health Systems', 'industry' => 'Healthcare', 'website' => 'https://zenithhealth.org', 'phone' => '+91 11 2345 6789', 'email' => 'contact@zenithhealth.org', 'address' => 'Connaught Place, New Delhi, DL', 'assigned_to' => $empId, 'total_revenue' => 320000, 'total_deals' => 1],
            ['name' => 'Horizon Retailers Ltd', 'industry' => 'E-Commerce', 'website' => 'https://horizonretail.com', 'phone' => '+91 80 9876 5432', 'email' => 'support@horizonretail.com', 'address' => 'Indiranagar, Bengaluru, KA', 'assigned_to' => $adminEmpId, 'total_revenue' => 780000, 'total_deals' => 3],
            ['name' => 'BlueWave Cloud Solutions', 'industry' => 'IT Services', 'website' => 'https://bluewavesoft.com', 'phone' => '+91 40 8765 4321', 'email' => 'biz@bluewavesoft.com', 'address' => 'HITEC City, Hyderabad, TS', 'assigned_to' => $empId, 'total_revenue' => 250000, 'total_deals' => 1],
            ['name' => 'Sunrise Hospitality & Resorts', 'industry' => 'Hospitality', 'website' => 'https://sunriseresorts.in', 'phone' => '+91 832 234 5678', 'email' => 'sales@sunriseresorts.in', 'address' => 'Panaji, Goa', 'assigned_to' => $empId, 'total_revenue' => 180000, 'total_deals' => 1],
        ];
        foreach ($companies as $comp) {
            DB::table('crm_companies')->updateOrInsert(['name' => $comp['name']], array_merge($comp, ['created_at' => $now, 'updated_at' => $now]));
        }

        // 7. Customers
        $customers = [
            ['customer_code' => 'CUST-1001', 'name' => 'Vikram Singhania', 'company' => 'Apex Logistics Corp', 'email' => 'vikram@apexlogistics.in', 'phone' => '+91 9820011223', 'address' => 'Andheri East, Mumbai', 'assigned_to' => $empId, 'status' => 'Active', 'total_spent' => 450000.00],
            ['customer_code' => 'CUST-1002', 'name' => 'Dr. Shalini Gupta', 'company' => 'Zenith Health Systems', 'email' => 'shalini@zenithhealth.org', 'phone' => '+91 9811099887', 'address' => 'CP, New Delhi', 'assigned_to' => $empId, 'status' => 'Active', 'total_spent' => 320000.00],
            ['customer_code' => 'CUST-1003', 'name' => 'Kunal Bansal', 'company' => 'Horizon Retailers Ltd', 'email' => 'kunal@horizonretail.com', 'phone' => '+91 9880055443', 'address' => 'Indiranagar, Bangalore', 'assigned_to' => $adminEmpId, 'status' => 'Active', 'total_spent' => 780000.00],
            ['customer_code' => 'CUST-1004', 'name' => 'Sneha Reddy', 'company' => 'BlueWave Cloud Solutions', 'email' => 'sneha@bluewavesoft.com', 'phone' => '+91 9849033221', 'address' => 'HITEC City, Hyderabad', 'assigned_to' => $empId, 'status' => 'Active', 'total_spent' => 250000.00],
        ];
        foreach ($customers as $c) {
            DB::table('crm_customers')->updateOrInsert(['customer_code' => $c['customer_code']], array_merge($c, ['created_at' => $now, 'updated_at' => $now]));
        }

        // 8. Products & Services
        $products = [
            ['name' => 'Enterprise Cloud CRM (Annual)', 'code' => 'PRD-CRM-ENT', 'category' => 'Software', 'price' => 120000.00, 'tax_rate' => 18.00, 'status' => 'Active', 'description' => 'Unlimited users, pipeline analytics, custom workflow automation.'],
            ['name' => 'WhatsApp & SMS Marketing Engine', 'code' => 'PRD-MKT-API', 'category' => 'Software', 'price' => 35000.00, 'tax_rate' => 18.00, 'status' => 'Active', 'description' => 'Official Meta API connector with pre-approved templates.'],
            ['name' => 'Dedicated Implementation & Onboarding', 'code' => 'SRV-ONB-PRO', 'category' => 'Service', 'price' => 50000.00, 'tax_rate' => 18.00, 'status' => 'Active', 'description' => '30 days hands-on team onboarding and workflow migration.'],
            ['name' => 'Custom ERP & Payment Gateway Integration', 'code' => 'SRV-INT-CUST', 'category' => 'Service', 'price' => 75000.00, 'tax_rate' => 18.00, 'status' => 'Active', 'description' => 'Seamless sync with Razorpay, Tally, and Zoho Books.'],
            ['name' => '24/7 Priority SLA & Support Contract', 'code' => 'SRV-SLA-247', 'category' => 'Subscription', 'price' => 45000.00, 'tax_rate' => 18.00, 'status' => 'Active', 'description' => '15 minute SLA response time with dedicated account manager.'],
        ];
        foreach ($products as $p) {
            DB::table('crm_products')->updateOrInsert(['code' => $p['code']], array_merge($p, ['created_at' => $now, 'updated_at' => $now]));
        }

        // 9. Leads
        $leads = [
            ['code' => 'LEAD-101', 'name' => 'Rohit Kapoor', 'email' => 'rohit@kapoorsteels.com', 'phone' => '+91 9871122334', 'company' => 'Kapoor Steels Pvt Ltd', 'status' => 'New', 'priority' => 'High', 'assigned_to' => $empId, 'val' => 185000, 'fdate' => $now->copy()->addDays(1)->format('Y-m-d')],
            ['code' => 'LEAD-102', 'name' => 'Ananya Chatterjee', 'email' => 'ananya@finpro.in', 'phone' => '+91 9831144556', 'company' => 'FinPro Advisers', 'status' => 'Contacted', 'priority' => 'Medium', 'assigned_to' => $empId, 'val' => 120000, 'fdate' => $now->copy()->addDays(2)->format('Y-m-d')],
            ['code' => 'LEAD-103', 'name' => 'Devendra Patel', 'email' => 'dpatel@pateltextiles.com', 'phone' => '+91 9825566778', 'company' => 'Patel Textiles Group', 'status' => 'Qualified', 'priority' => 'Urgent', 'assigned_to' => $empId, 'val' => 290000, 'fdate' => $now->copy()->format('Y-m-d')],
            ['code' => 'LEAD-104', 'name' => 'Meera Nair', 'email' => 'meera@keralaspices.co', 'phone' => '+91 9847788990', 'company' => 'Kerala Spice Exports', 'status' => 'Proposal', 'priority' => 'High', 'assigned_to' => $empId, 'val' => 210000, 'fdate' => $now->copy()->addDays(3)->format('Y-m-d')],
            ['code' => 'LEAD-105', 'name' => 'Siddharth Saxena', 'email' => 'sid@novasoft.tech', 'phone' => '+91 9810022334', 'company' => 'NovaSoft Technologies', 'status' => 'Negotiation', 'priority' => 'Urgent', 'assigned_to' => $adminEmpId, 'val' => 450000, 'fdate' => $now->copy()->format('Y-m-d')],
            ['code' => 'LEAD-106', 'name' => 'Pooja Agarwal', 'email' => 'pooja@heritagejewels.com', 'phone' => '+91 9829911223', 'company' => 'Heritage Jewels Jaipur', 'status' => 'Converted', 'priority' => 'Medium', 'assigned_to' => $empId, 'val' => 320000, 'fdate' => null],
            ['code' => 'LEAD-107', 'name' => 'Aditya Malhotra', 'email' => 'aditya@malhotracars.in', 'phone' => '+91 9811199887', 'company' => 'Malhotra Motors', 'status' => 'Follow-up', 'priority' => 'High', 'assigned_to' => $empId, 'val' => 175000, 'fdate' => $now->copy()->format('Y-m-d')],
            ['code' => 'LEAD-108', 'name' => 'Gaurav Joshi', 'email' => 'gaurav@joshipackaging.com', 'phone' => '+91 9822233445', 'company' => 'Joshi Packaging Solutions', 'status' => 'Lost', 'priority' => 'Low', 'assigned_to' => $empId, 'val' => 95000, 'fdate' => null],
            ['code' => 'LEAD-109', 'name' => 'Kavita Menon', 'email' => 'kavita@greengarden.org', 'phone' => '+91 9844455667', 'company' => 'Green Garden Organic', 'status' => 'New', 'priority' => 'Low', 'assigned_to' => $adminEmpId, 'val' => 80000, 'fdate' => $now->copy()->addDays(4)->format('Y-m-d')],
            ['code' => 'LEAD-110', 'name' => 'Harsh Vardhan', 'email' => 'harsh@solarpower.in', 'phone' => '+91 9899988776', 'company' => 'Surya Solar Systems', 'status' => 'Proposal', 'priority' => 'Urgent', 'assigned_to' => $empId, 'val' => 380000, 'fdate' => $now->copy()->addDays(1)->format('Y-m-d')],
        ];
        foreach ($leads as $l) {
            DB::table('crm_leads')->updateOrInsert(
                ['lead_code' => $l['code']],
                [
                    'lead_code' => $l['code'],
                    'name' => $l['name'],
                    'email' => $l['email'],
                    'phone' => $l['phone'],
                    'company' => $l['company'],
                    'status' => $l['status'],
                    'priority' => $l['priority'],
                    'assigned_to' => $l['assigned_to'],
                    'expected_value' => $l['val'],
                    'follow_up_date' => $l['fdate'],
                    'notes' => 'Client expressed interest in CRM automation and WhatsApp API.',
                    'created_at' => $now->copy()->subDays(rand(1, 20)),
                    'updated_at' => $now,
                ]
            );
        }

        // 10. Deals
        $deals = [
            ['title' => 'Apex Logistics CRM Multi-Branch License', 'val' => 240000, 'stage' => 'Proposal', 'prob' => 60, 'assigned' => $empId, 'date' => $now->copy()->addDays(10)->format('Y-m-d')],
            ['title' => 'Zenith Health Patient Workflow Module', 'val' => 320000, 'stage' => 'Negotiation', 'prob' => 85, 'assigned' => $empId, 'date' => $now->copy()->addDays(5)->format('Y-m-d')],
            ['title' => 'Horizon Retail Omnichannel Sync', 'val' => 450000, 'stage' => 'Won', 'prob' => 100, 'assigned' => $adminEmpId, 'date' => $now->copy()->subDays(3)->format('Y-m-d')],
            ['title' => 'BlueWave Cloud API Integration', 'val' => 125000, 'stage' => 'Qualified', 'prob' => 40, 'assigned' => $empId, 'date' => $now->copy()->addDays(20)->format('Y-m-d')],
            ['title' => 'Heritage Jewels VIP Loyalty Program', 'val' => 180000, 'stage' => 'Won', 'prob' => 100, 'assigned' => $empId, 'date' => $now->copy()->subDays(7)->format('Y-m-d')],
            ['title' => 'Surya Solar B2B Lead Engine', 'val' => 380000, 'stage' => 'New', 'prob' => 20, 'assigned' => $empId, 'date' => $now->copy()->addDays(30)->format('Y-m-d')],
        ];
        foreach ($deals as $dl) {
            DB::table('crm_deals')->updateOrInsert(
                ['title' => $dl['title']],
                [
                    'title' => $dl['title'],
                    'value' => $dl['val'],
                    'stage' => $dl['stage'],
                    'probability' => $dl['prob'],
                    'assigned_to' => $dl['assigned'],
                    'expected_closing_date' => $dl['date'],
                    'priority' => 'High',
                    'notes' => 'Contract review pending with legal team.',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        // 11. Tasks
        $tasks = [
            ['title' => 'Send customized quotation to Devendra Patel', 'priority' => 'Urgent', 'status' => 'Pending', 'due' => $now->copy()->format('Y-m-d'), 'assigned' => $empId],
            ['title' => 'Conduct Zoom product demo for Surya Solar', 'priority' => 'High', 'status' => 'Pending', 'due' => $now->copy()->addDays(1)->format('Y-m-d'), 'assigned' => $empId],
            ['title' => 'Follow up on payment with Horizon Retail', 'priority' => 'Medium', 'status' => 'Completed', 'due' => $now->copy()->subDays(1)->format('Y-m-d'), 'assigned' => $adminEmpId],
            ['title' => 'Review legal agreement with NovaSoft', 'priority' => 'Urgent', 'status' => 'In Progress', 'due' => $now->copy()->addDays(2)->format('Y-m-d'), 'assigned' => $adminEmpId],
            ['title' => 'Schedule kickoff call with Heritage Jewels', 'priority' => 'Medium', 'status' => 'Completed', 'due' => $now->copy()->subDays(2)->format('Y-m-d'), 'assigned' => $empId],
        ];
        foreach ($tasks as $t) {
            DB::table('crm_tasks')->updateOrInsert(
                ['title' => $t['title']],
                [
                    'title' => $t['title'],
                    'priority' => $t['priority'],
                    'status' => $t['status'],
                    'assigned_to' => $t['assigned'],
                    'due_date' => $t['due'],
                    'description' => 'Important deliverable for quarterly target achievement.',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        // 12. Follow-ups
        $followups = [
            ['date' => $now->copy()->format('Y-m-d'), 'time' => '11:00:00', 'type' => 'Call', 'status' => 'Pending', 'notes' => 'Discuss discounted annual SLA pricing with Devendra.', 'assigned' => $empId],
            ['date' => $now->copy()->format('Y-m-d'), 'time' => '15:30:00', 'type' => 'Meeting', 'status' => 'Pending', 'notes' => 'Showcase dashboard analytics to Aditya Malhotra.', 'assigned' => $empId],
            ['date' => $now->copy()->addDays(2)->format('Y-m-d'), 'time' => '14:00:00', 'type' => 'Email', 'status' => 'Pending', 'notes' => 'Send case study on retail inventory automation.', 'assigned' => $empId],
            ['date' => $now->copy()->subDays(1)->format('Y-m-d'), 'time' => '10:00:00', 'type' => 'Call', 'status' => 'Overdue', 'notes' => 'Urgent check on contract signing.', 'assigned' => $empId],
            ['date' => $now->copy()->subDays(3)->format('Y-m-d'), 'time' => '16:00:00', 'type' => 'Call', 'status' => 'Completed', 'notes' => 'Finalized quotation details.', 'assigned' => $empId],
        ];
        foreach ($followups as $fu) {
            DB::table('crm_followups')->insert([
                'date' => $fu['date'],
                'time' => $fu['time'],
                'type' => $fu['type'],
                'status' => $fu['status'],
                'notes' => $fu['notes'],
                'assigned_to' => $fu['assigned'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // 13. Demos & Reservations
        DB::table('crm_demos')->updateOrInsert(
            ['title' => 'Enterprise Pipeline Automation Demo'],
            [
                'title' => 'Enterprise Pipeline Automation Demo',
                'assigned_to' => $empId,
                'date' => $now->copy()->addDays(1)->format('Y-m-d'),
                'time' => '11:30:00',
                'status' => 'Scheduled',
                'notes' => 'Screen share with CTO and Head of Sales.',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('crm_reservations')->updateOrInsert(
            ['reservation_code' => 'RES-2026-01'],
            [
                'reservation_code' => 'RES-2026-01',
                'customer_name' => 'Sunrise Hospitality & Resorts',
                'service_name' => 'VIP Onsite CRM Training Workshop',
                'date' => $now->copy()->addDays(4)->format('Y-m-d'),
                'time' => '10:00:00',
                'assigned_to' => $empId,
                'status' => 'Confirmed',
                'amount' => 50000.00,
                'notes' => 'Conference hall reserved for 25 staff members.',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        // 14. Quotations & Items
        $qId = DB::table('crm_quotations')->updateOrInsert(
            ['quotation_no' => 'QT-2026-0084'],
            [
                'quotation_no' => 'QT-2026-0084',
                'customer_name' => 'Devendra Patel',
                'customer_email' => 'dpatel@pateltextiles.com',
                'customer_phone' => '+91 9825566778',
                'quotation_date' => $now->copy()->format('Y-m-d'),
                'valid_until' => $now->copy()->addDays(15)->format('Y-m-d'),
                'subtotal' => 205000.00,
                'discount_type' => 'percentage',
                'discount_rate' => 10.00,
                'discount_amount' => 20500.00,
                'tax_amount' => 33210.00,
                'grand_total' => 217710.00,
                'status' => 'Sent',
                'notes' => 'Thank you for your business. License valid for 12 months from activation.',
                'terms' => "1. 50% advance upon contract signing.\n2. Balance within 15 days of onboarding.\n3. Annual renewal fee 15% lower.",
                'created_by' => $empId,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
        $quoteId = DB::table('crm_quotations')->where('quotation_no', 'QT-2026-0084')->value('id');

        DB::table('crm_quotation_items')->updateOrInsert(
            ['quotation_id' => $quoteId, 'item_name' => 'Enterprise Cloud CRM (Annual)'],
            [
                'quotation_id' => $quoteId,
                'item_name' => 'Enterprise Cloud CRM (Annual)',
                'quantity' => 1,
                'unit_price' => 120000.00,
                'tax_rate' => 18.00,
                'total' => 120000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
        DB::table('crm_quotation_items')->updateOrInsert(
            ['quotation_id' => $quoteId, 'item_name' => 'Custom ERP & Payment Gateway Integration'],
            [
                'quotation_id' => $quoteId,
                'item_name' => 'Custom ERP & Payment Gateway Integration',
                'quantity' => 1,
                'unit_price' => 75000.00,
                'tax_rate' => 18.00,
                'total' => 75000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        // 15. Payments
        $payments = [
            ['no' => 'PAY-8801', 'amount' => 140000.00, 'date' => $now->copy()->subDays(2)->format('Y-m-d'), 'method' => 'Bank Transfer', 'ref' => 'HDFC88902341', 'status' => 'Paid', 'notes' => 'Advance invoice cleared.'],
            ['no' => 'PAY-8802', 'amount' => 95000.00, 'date' => $now->copy()->subDays(5)->format('Y-m-d'), 'method' => 'UPI', 'ref' => 'UPI9988776655', 'status' => 'Paid', 'notes' => 'Add-on module fee.'],
            ['no' => 'PAY-8803', 'amount' => 49500.00, 'date' => $now->copy()->subDays(10)->format('Y-m-d'), 'method' => 'Credit Card', 'ref' => 'CC77665544', 'status' => 'Paid', 'notes' => 'Quarterly support contract.'],
            ['no' => 'PAY-8804', 'amount' => 85000.00, 'date' => $now->copy()->addDays(7)->format('Y-m-d'), 'method' => 'Cheque', 'ref' => 'CHQ-554433', 'status' => 'Pending', 'notes' => 'Milestone 2 pending completion.'],
        ];
        foreach ($payments as $pay) {
            DB::table('crm_payments')->updateOrInsert(
                ['payment_no' => $pay['no']],
                [
                    'payment_no' => $pay['no'],
                    'amount' => $pay['amount'],
                    'payment_date' => $pay['date'],
                    'payment_method' => $pay['method'],
                    'transaction_ref' => $pay['ref'],
                    'status' => $pay['status'],
                    'notes' => $pay['notes'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        // 16. Sales Target
        DB::table('crm_sales_targets')->updateOrInsert(
            ['user_id' => $empId, 'period_name' => 'September 2026'],
            [
                'user_id' => $empId,
                'period_type' => 'Monthly',
                'period_name' => 'September 2026',
                'target_amount' => 500000.00,
                'achieved_amount' => 420000.00,
                'start_date' => $now->copy()->startOfMonth()->format('Y-m-d'),
                'end_date' => $now->copy()->endOfMonth()->format('Y-m-d'),
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        // 17. Activity Logs
        $logs = [
            ['user_name' => 'Admin', 'module' => 'Leads', 'action' => 'Created', 'desc' => 'Added new enterprise lead Rohit Kapoor (Kapoor Steels).'],
            ['user_name' => 'Maruf Hossen', 'module' => 'Quotations', 'action' => 'Generated', 'desc' => 'Generated quotation #QT-2026-0084 for ₹2,17,710.'],
            ['user_name' => 'Maruf Hossen', 'module' => 'Deals', 'action' => 'Stage Updated', 'desc' => 'Moved Zenith Health deal to Negotiation stage.'],
            ['user_name' => 'Admin', 'module' => 'Payments', 'action' => 'Payment Recorded', 'desc' => 'Received ₹1,40,000 via NEFT from Horizon Retail.'],
        ];
        foreach ($logs as $l) {
            DB::table('crm_activity_logs')->insert([
                'user_name' => $l['user_name'],
                'module' => $l['module'],
                'action' => $l['action'],
                'description' => $l['desc'],
                'ip_address' => '127.0.0.1',
                'created_at' => $now->copy()->subMinutes(rand(10, 300)),
                'updated_at' => $now,
            ]);
        }

        // 18. Notifications
        $notifications = [
            ['title' => 'High-Priority Lead Assigned', 'message' => 'Devendra Patel (Patel Textiles) was assigned to you.', 'type' => 'success', 'link' => '/crm/employee/leads'],
            ['title' => 'Payment Received', 'message' => '₹1,40,000 payment received from Apex Logistics.', 'type' => 'info', 'link' => '/crm/admin/payments'],
            ['title' => 'Upcoming Follow-up Due', 'message' => 'Call scheduled with Rohit Kapoor in 30 minutes.', 'type' => 'warning', 'link' => '/crm/employee/followups'],
            ['title' => 'Monthly Target Milestone', 'message' => 'Congratulations! You achieved 84% of your September target.', 'type' => 'success', 'link' => '/crm/employee/performance'],
        ];
        foreach ($notifications as $n) {
            DB::table('crm_notifications')->insert([
                'title' => $n['title'],
                'message' => $n['message'],
                'type' => $n['type'],
                'link' => $n['link'],
                'is_read' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // 19. CRM Settings
        $settings = [
            'company_name' => 'Emedley Cloud CRM',
            'company_tagline' => 'Enterprise Sales & Customer Growth Platform',
            'currency_symbol' => '₹',
            'support_email' => 'support@emedleycrm.com',
            'support_phone' => '+91 98765 43210',
            'fiscal_year_start' => 'April',
        ];
        foreach ($settings as $k => $v) {
            DB::table('crm_settings')->updateOrInsert(['key_name' => $k], ['value_data' => $v, 'created_at' => $now, 'updated_at' => $now]);
        }
    }
}
