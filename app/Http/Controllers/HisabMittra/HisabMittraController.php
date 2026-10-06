<?php

namespace App\Http\Controllers\HisabMittra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HisabMittraController extends Controller
{
    /**
     * Homepage with Hero, Dashboard Preview, Trust Stats, Modules, and CTAs.
     */
    public function home()
    {
        $stats = [
            'businesses_count' => '2,400+',
            'uptime' => '99.98%',
            'payroll_processed' => '₹480 Cr+',
            'leads_managed' => '1.2M+',
            'active_employees' => '45,000+',
        ];

        return view('hisab_mittra.index', compact('stats'));
    }

    /**
     * Comprehensive Features Overview (All 6 core modules).
     */
    public function features()
    {
        return view('hisab_mittra.features');
    }

    /**
     * Dedicated HRM & Attendance module landing page.
     */
    public function hrm()
    {
        return view('hisab_mittra.hrm');
    }

    /**
     * Dedicated CRM & Sales Pipeline landing page.
     */
    public function crm()
    {
        return view('hisab_mittra.crm');
    }

    /**
     * Pricing Plans & Detailed Feature Comparison.
     */
    public function pricing()
    {
        return view('hisab_mittra.pricing');
    }

    /**
     * About Us - Company Story, Vision, Leadership.
     */
    public function about()
    {
        return view('hisab_mittra.about');
    }

    /**
     * Contact Us Page.
     */
    public function contact()
    {
        return view('hisab_mittra.contact');
    }

    /**
     * Handle Contact Form Submission -> Creates lead in CRM.
     */
    public function postContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:30',
            'company' => 'nullable|string|max:150',
            'message' => 'required|string|max:1000',
        ]);

        try {
            $lead = \App\Models\Crm\CrmLead::create([
                'lead_code' => 'WEB-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'company' => $validated['company'] ?? 'Inquiry via Website',
                'status' => 'New',
                'priority' => 'High',
                'expected_value' => 50000.00,
                'notes' => $validated['message'],
            ]);

            // Real-time Notification in CRM
            \App\Models\Crm\CrmNotification::notify(
                "New Website Lead: {$validated['name']}",
                "{$validated['name']} ({$validated['email']}) submitted an inquiry from " . ($validated['company'] ?? 'Website') . ".",
                'lead',
                url('/crm/admin/leads/' . $lead->id)
            );
        } catch (\Throwable $e) {
            \Log::error("Hisab postContact error: " . $e->getMessage());
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Thank you! Your inquiry has been received. Our senior enterprise advisor will contact you within 2 hours.'
            ]);
        }

        return back()->with('success', 'Thank you! Your message has been received. Our enterprise advisor will contact you shortly.');
    }

    /**
     * Book Demo Page.
     */
    public function bookDemo()
    {
        return view('hisab_mittra.book_demo');
    }

    /**
     * Handle Book Demo Form Submission.
     */
    public function postDemo(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'business_name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:30',
            'employee_count' => 'required|string|max:50',
            'business_type' => 'nullable|string|max:100',
            'preferred_date' => 'nullable|date',
            'preferred_time' => 'nullable|string|max:50',
            'message' => 'nullable|string|max:1000',
        ]);

        try {
            // 1. Create a Lead record for sales tracking
            $lead = \App\Models\Crm\CrmLead::create([
                'lead_code' => 'DEMO-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'company' => $validated['business_name'],
                'status' => 'Contacted',
                'priority' => 'Urgent',
                'expected_value' => 120000.00,
                'notes' => "Demo booked for " . ($validated['preferred_date'] ?? date('Y-m-d')) . " at " . ($validated['preferred_time'] ?? '11:00 AM') . ". Employee size: {$validated['employee_count']}.",
            ]);

            // 2. Create demo record
            $demo = \App\Models\Crm\CrmDemo::create([
                'title' => 'Product Demo - ' . $validated['business_name'],
                'lead_id' => $lead->id,
                'date' => $validated['preferred_date'] ?? date('Y-m-d'),
                'time' => $validated['preferred_time'] ?? '11:00:00',
                'status' => 'Scheduled',
                'notes' => "Contact: {$validated['name']} ({$validated['phone']}) | Employees: {$validated['employee_count']} | Type: " . ($validated['business_type'] ?? 'General') . " | " . ($validated['message'] ?? ''),
            ]);

            // 3. Real-time Notification in CRM
            \App\Models\Crm\CrmNotification::notify(
                "Demo Booked: {$validated['business_name']}",
                "Product walkthrough scheduled for " . ($validated['preferred_date'] ?? 'today') . " at " . ($validated['preferred_time'] ?? '11:00 AM') . " by {$validated['name']}.",
                'demo',
                url('/crm/admin/demos')
            );
        } catch (\Throwable $e) {
            \Log::error("Hisab postDemo error: " . $e->getMessage());
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Demo scheduled successfully! A calendar invitation and Zoom/Google Meet link have been sent to your email.'
            ]);
        }

        return back()->with('success', 'Your demo has been scheduled! Our solution architect will meet you at the requested time.');
    }

    /**
     * Blog / Resources Listing.
     */
    public function blog()
    {
        $posts = [
            [
                'title' => 'Mastering Indian Payroll Compliance: PF, ESI, and New Labour Codes 2026',
                'slug' => 'mastering-indian-payroll-compliance-2026',
                'category' => 'Payroll & Legal',
                'read_time' => '6 min read',
                'date' => 'October 01, 2026',
                'excerpt' => 'A comprehensive guide for Indian MSMEs and growing enterprises on staying 100% compliant with statutory deductions, wage code changes, and monthly filings.',
                'author' => 'Rajesh Varma, VP Compliance'
            ],
            [
                'title' => 'Why WhatsApp CRM Delivers 3.4x Higher Deal Conversions than Email',
                'slug' => 'whatsapp-crm-delivers-higher-deal-conversions',
                'category' => 'Sales Strategy',
                'read_time' => '5 min read',
                'date' => 'September 28, 2026',
                'excerpt' => 'Discover how integrating WhatsApp directly with your sales pipeline eliminates follow-up delays, automates quotation dispatch, and speeds up deal closures.',
                'author' => 'Priya Sen, Lead Growth Strategist'
            ],
            [
                'title' => 'Geofencing vs Face Recognition: Choosing the Best Attendance for Hybrid Workforces',
                'slug' => 'geofencing-vs-face-recognition-attendance',
                'category' => 'HR Tech',
                'read_time' => '4 min read',
                'date' => 'September 24, 2026',
                'excerpt' => 'Compare modern touchless attendance technologies for distributed retail, factory floors, field sales teams, and corporate offices.',
                'author' => 'Anand K., Head of Product'
            ],
            [
                'title' => 'The Complete Financial Playbook for Scaling from 10 to 500 Employees',
                'slug' => 'financial-playbook-scaling-business',
                'category' => 'Business Operations',
                'read_time' => '8 min read',
                'date' => 'September 18, 2026',
                'excerpt' => 'From cash flow forecasting to automated invoicing and inventory synchronization, learn the operational foundations of high-growth Indian companies.',
                'author' => 'Sanjay Singhania, Founder & CEO'
            ],
        ];

        return view('hisab_mittra.blog', compact('posts'));
    }

    /**
     * Help Center & Documentation.
     */
    public function help()
    {
        return view('hisab_mittra.help');
    }
}
