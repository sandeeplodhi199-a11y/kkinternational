<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrmNotification extends Model
{
    protected $table = 'crm_notifications';
    protected $guarded = [];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Safe helper to create a notification.
     */
    public static function notify($title, $message, $type = 'info', $link = null, $userId = null)
    {
        try {
            return self::create([
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'link' => $link,
                'is_read' => false,
            ]);
        } catch (\Throwable $e) {
            \Log::warning("Could not create notification: " . $e->getMessage());
            return null;
        }
    }

    /**
     * UI helper: Category display label.
     */
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'lead' => 'Lead Alert',
            'followup' => 'Follow-up',
            'task' => 'Task Due',
            'demo' => 'Demo Scheduled',
            'payment' => 'Payment Received',
            'deal' => 'Deals',
            'customer' => 'Customer Alert',
            'quotation' => 'Quotation',
            'system' => 'System Update',
            'warning' => 'Important Alert',
            'success' => 'Success Alert',
            default => 'Notification',
        };
    }

    /**
     * UI helper: FontAwesome icon class.
     */
    public function getIconAttribute()
    {
        return match($this->type) {
            'lead' => 'fa-solid fa-user-plus',
            'followup' => 'fa-solid fa-calendar-check',
            'task' => 'fa-solid fa-list-check',
            'demo' => 'fa-solid fa-laptop-code',
            'payment' => 'fa-solid fa-indian-rupee-sign',
            'deal' => 'fa-solid fa-trophy',
            'customer' => 'fa-solid fa-building-user',
            'quotation' => 'fa-solid fa-file-invoice-dollar',
            'system' => 'fa-solid fa-shield-halved',
            'warning' => 'fa-solid fa-triangle-exclamation',
            'success' => 'fa-solid fa-circle-check',
            default => 'fa-solid fa-bell',
        };
    }

    /**
     * UI helper: Icon colors and background.
     */
    public function getIconStyleAttribute()
    {
        return match($this->type) {
            'lead' => 'bg-emerald-50 text-emerald-600 border border-emerald-200/60',
            'followup' => 'bg-amber-50 text-amber-600 border border-amber-200/60',
            'task' => 'bg-violet-50 text-violet-600 border border-violet-200/60',
            'demo' => 'bg-cyan-50 text-cyan-600 border border-cyan-200/60',
            'payment' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/60',
            'deal' => 'bg-orange-50 text-orange-600 border border-orange-200/60',
            'customer' => 'bg-blue-50 text-blue-600 border border-blue-200/60',
            'quotation' => 'bg-indigo-50 text-indigo-600 border border-indigo-200/60',
            'system' => 'bg-slate-100 text-slate-700 border border-slate-200',
            'warning' => 'bg-rose-50 text-rose-600 border border-rose-200/60',
            'success' => 'bg-teal-50 text-teal-700 border border-teal-200/60',
            default => 'bg-blue-50 text-blue-600 border border-blue-200/60',
        };
    }

    /**
     * Populate notifications from existing CRM records if none or new exist.
     */
    public static function syncSystemNotifications()
    {
        // 1. Sync Demos
        if (Schema::hasTable('crm_demos')) {
            $demos = DB::table('crm_demos')->latest('id')->limit(10)->get();
            foreach ($demos as $demo) {
                $title = "Demo Scheduled: " . ($demo->title ?: 'Product Walkthrough');
                if (!self::where('title', $title)->exists()) {
                    self::create([
                        'user_id' => $demo->assigned_to ?? null,
                        'title' => $title,
                        'message' => "Client demonstration scheduled for " . ($demo->date ?? 'today') . " at " . ($demo->time ?? '11:00 AM') . ". Status: " . ($demo->status ?? 'Scheduled'),
                        'type' => 'demo',
                        'link' => url('/crm/admin/demos'),
                        'is_read' => false,
                        'created_at' => $demo->created_at ?? now(),
                        'updated_at' => $demo->updated_at ?? now(),
                    ]);
                }
            }
        }

        // 2. Sync Tasks
        if (Schema::hasTable('crm_tasks')) {
            $tasks = DB::table('crm_tasks')->latest('id')->limit(10)->get();
            foreach ($tasks as $task) {
                $title = "Task: " . $task->title;
                if (!self::where('title', $title)->exists()) {
                    self::create([
                        'user_id' => $task->assigned_to ?? null,
                        'title' => $title,
                        'message' => ($task->description ? $task->description . " — " : "") . "Due Date: " . ($task->due_date ?? 'Immediate') . " | Priority: " . ($task->priority ?? 'Medium'),
                        'type' => 'task',
                        'link' => url('/crm/admin/tasks'),
                        'is_read' => false,
                        'created_at' => $task->created_at ?? now(),
                        'updated_at' => $task->updated_at ?? now(),
                    ]);
                }
            }
        }

        // 3. Sync Follow-ups
        if (Schema::hasTable('crm_followups')) {
            $followups = DB::table('crm_followups')->latest('id')->limit(10)->get();
            foreach ($followups as $f) {
                $title = "Follow-up Scheduled (" . ($f->type ?: 'Call') . ")";
                if (!self::where('title', $title)->whereDate('created_at', Carbon::parse($f->created_at)->toDateString())->exists()) {
                    self::create([
                        'user_id' => $f->assigned_to ?? null,
                        'title' => $title,
                        'message' => "Follow-up scheduled for " . ($f->date ?? 'today') . ($f->time ? " at " . $f->time : "") . ". Notes: " . ($f->notes ?: 'Pending follow-up discussion.'),
                        'type' => 'followup',
                        'link' => url('/crm/admin/followups'),
                        'is_read' => false,
                        'created_at' => $f->created_at ?? now(),
                        'updated_at' => $f->updated_at ?? now(),
                    ]);
                }
            }
        }

        // 4. Sync Leads
        if (Schema::hasTable('crm_leads')) {
            $leads = DB::table('crm_leads')->latest('id')->limit(10)->get();
            foreach ($leads as $lead) {
                $title = "Lead Assigned: {$lead->name} (" . ($lead->lead_code ?: 'LEAD') . ")";
                if (!self::where('title', $title)->exists()) {
                    self::create([
                        'user_id' => $lead->assigned_to ?? null,
                        'title' => $title,
                        'message' => "Company: " . ($lead->company ?: 'Individual') . " | Status: " . ($lead->status ?: 'New') . " | Expected Value: ₹" . number_format($lead->expected_value ?? 0),
                        'type' => 'lead',
                        'link' => url('/crm/admin/leads/' . $lead->id),
                        'is_read' => false,
                        'created_at' => $lead->created_at ?? now(),
                        'updated_at' => $lead->updated_at ?? now(),
                    ]);
                }
            }
        }

        // 5. Sync Customers
        if (Schema::hasTable('crm_customers')) {
            $customers = DB::table('crm_customers')->latest('id')->limit(10)->get();
            foreach ($customers as $c) {
                $title = "New Customer: {$c->name}";
                if (!self::where('title', $title)->exists()) {
                    self::create([
                        'user_id' => $c->assigned_to ?? null,
                        'title' => $title,
                        'message' => "Customer {$c->customer_code} ({$c->company}) registered. Contact: {$c->phone}",
                        'type' => 'customer',
                        'link' => url('/crm/admin/customers'),
                        'is_read' => false,
                        'created_at' => $c->created_at ?? now(),
                        'updated_at' => $c->updated_at ?? now(),
                    ]);
                }
            }
        }

        // 6. Sync Payments
        if (Schema::hasTable('crm_payments')) {
            $payments = DB::table('crm_payments')->latest('id')->limit(10)->get();
            foreach ($payments as $p) {
                $title = "Payment Received: " . ($p->payment_no ?: 'PAYMENT');
                if (!self::where('title', $title)->exists()) {
                    self::create([
                        'title' => $title,
                        'message' => "Payment of ₹" . number_format($p->amount ?? 0) . " recorded via " . ($p->payment_method ?? 'Bank Transfer') . ". Status: " . ($p->status ?? 'Paid'),
                        'type' => 'payment',
                        'link' => url('/crm/admin/payments'),
                        'is_read' => false,
                        'created_at' => $p->created_at ?? now(),
                        'updated_at' => $p->updated_at ?? now(),
                    ]);
                }
            }
        }

        // 7. Sync Deals
        if (Schema::hasTable('crm_deals')) {
            $deals = DB::table('crm_deals')->latest('id')->limit(10)->get();
            foreach ($deals as $deal) {
                $title = "Deal: " . $deal->title;
                if (!self::where('title', $title)->exists()) {
                    self::create([
                        'user_id' => $deal->assigned_to ?? null,
                        'title' => $title,
                        'message' => "Stage: {$deal->stage} | Deal Value: ₹" . number_format($deal->value ?? 0) . " (Probability: {$deal->probability}%)",
                        'type' => 'deal',
                        'link' => url('/crm/admin/deals'),
                        'is_read' => false,
                        'created_at' => $deal->created_at ?? now(),
                        'updated_at' => $deal->updated_at ?? now(),
                    ]);
                }
            }
        }

        // 8. Sync Quotations
        if (Schema::hasTable('crm_quotations')) {
            $quotes = DB::table('crm_quotations')->latest('id')->limit(10)->get();
            foreach ($quotes as $q) {
                $title = "Quotation: " . ($q->quotation_no ?: 'QUOTATION');
                if (!self::where('title', $title)->exists()) {
                    self::create([
                        'title' => $title,
                        'message' => "Generated for {$q->customer_name} — Total: ₹" . number_format($q->grand_total ?? 0) . " (Status: {$q->status})",
                        'type' => 'quotation',
                        'link' => url('/crm/admin/quotations'),
                        'is_read' => false,
                        'created_at' => $q->created_at ?? now(),
                        'updated_at' => $q->updated_at ?? now(),
                    ]);
                }
            }
        }

        // 9. Sync Website Enquiries if exists
        if (Schema::hasTable('tbl_enquiry')) {
            $enquiries = DB::table('tbl_enquiry')->latest('id')->limit(5)->get();
            foreach ($enquiries as $eq) {
                $title = "Website Inquiry: " . $eq->name;
                if (!self::where('title', $title)->exists()) {
                    self::create([
                        'title' => $title,
                        'message' => "Online contact enquiry received. Email: {$eq->email} | Phone: {$eq->phone}. Message: " . \Illuminate\Support\Str::limit($eq->message, 80),
                        'type' => 'lead',
                        'link' => url('/crm/admin/leads'),
                        'is_read' => false,
                        'created_at' => $eq->created_at ?? now(),
                        'updated_at' => $eq->updated_at ?? now(),
                    ]);
                }
            }
        }

        // 10. System Health / Audit safety notification
        if (!self::where('type', 'system')->exists()) {
            self::create([
                'title' => 'CRM Real-Time Notification System Active',
                'message' => 'Real-time alert engine connected. Tracking all lead assignments, upcoming follow-ups, payment confirmations, and team tasks.',
                'type' => 'system',
                'link' => url('/crm/admin/activity-logs'),
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
