<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Crm\CrmAuthController;
use App\Http\Controllers\Crm\Admin\CrmAdminDashboardController;
use App\Http\Controllers\Crm\Admin\CrmLeadController;
use App\Http\Controllers\Crm\Admin\CrmCustomerController;
use App\Http\Controllers\Crm\Admin\CrmDealController;
use App\Http\Controllers\Crm\Admin\CrmTaskController;
use App\Http\Controllers\Crm\Admin\CrmFollowupController;
use App\Http\Controllers\Crm\Admin\CrmCalendarController;
use App\Http\Controllers\Crm\Admin\CrmDemoReservationController;
use App\Http\Controllers\Crm\Admin\CrmQuotationController;
use App\Http\Controllers\Crm\Admin\CrmPaymentController;
use App\Http\Controllers\Crm\Admin\CrmProductController;
use App\Http\Controllers\Crm\Admin\CrmTeamController;
use App\Http\Controllers\Crm\Admin\CrmReportController;
use App\Http\Controllers\Crm\Admin\CrmSystemController;
use App\Http\Controllers\Crm\Admin\CrmSuperAdminController;
use App\Http\Controllers\Crm\Employee\CrmEmployeeDashboardController;

// Public CRM Routes
Route::prefix('crm')->group(function () {
    Route::get('/', function () {
        return redirect()->route('crm.login');
    });

    Route::get('login', [CrmAuthController::class, 'loginForm'])->name('crm.login');
    Route::get('employee/login', function () {
        return redirect()->route('crm.login', ['role' => 'employee']);
    })->name('crm.employee.login');
    Route::post('login', [CrmAuthController::class, 'login'])->name('crm.login.post');
    Route::post('check-user-role', [CrmAuthController::class, 'checkUserRole'])->name('crm.check-user-role');
    Route::get('forgot-password', [CrmAuthController::class, 'forgotPasswordForm'])->name('crm.forgot-password');
    Route::post('forgot-password', [CrmAuthController::class, 'resetPassword'])->name('crm.forgot-password.post');
    Route::post('logout', [CrmAuthController::class, 'logout'])->name('crm.logout');
    Route::get('global-search', [CrmAdminDashboardController::class, 'globalSearch'])->name('crm.global-search');
    Route::get('leave-impersonate', [CrmSuperAdminController::class, 'leaveImpersonate'])->name('crm.leave-impersonate');
    Route::post('api/leads/webhook', [CrmSuperAdminController::class, 'handleLeadWebhook'])->name('crm.api.leads.webhook');
});

// Admin Panel Routes
Route::prefix('crm/admin')->middleware(['crm_auth:admin'])->name('crm.admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('crm.admin.dashboard');
    });
    Route::get('dashboard', [CrmAdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('search', [CrmAdminDashboardController::class, 'globalSearch'])->name('search');

    // Leads
    Route::get('leads', [CrmLeadController::class, 'index'])->name('leads.index');
    Route::get('leads/create', [CrmLeadController::class, 'create'])->name('leads.create');
    Route::get('leads/kanban', [CrmLeadController::class, 'kanban'])->name('leads.kanban');
    Route::get('leads/bulk-assign', [CrmLeadController::class, 'bulkAssign'])->name('leads.bulk-assign');
    Route::post('leads/bulk-assign', [CrmLeadController::class, 'processBulkAssign'])->name('leads.bulk-assign.post');
    Route::get('leads/upload', [CrmLeadController::class, 'upload'])->name('leads.upload');
    Route::post('leads/upload', [CrmLeadController::class, 'processUpload'])->name('leads.upload.post');
    Route::get('leads/sample-csv', [CrmLeadController::class, 'sampleCsv'])->name('leads.sample-csv');
    Route::post('leads', [CrmLeadController::class, 'store'])->name('leads.store');
    Route::get('leads/{id}', [CrmLeadController::class, 'show'])->name('leads.show');
    Route::match(['put', 'post'], 'leads/{id}', [CrmLeadController::class, 'update'])->name('leads.update');
    Route::delete('leads/{id}', [CrmLeadController::class, 'destroy'])->name('leads.destroy');
    Route::post('leads/{id}/status', [CrmLeadController::class, 'updateStatus'])->name('leads.update-status');
    Route::post('leads/{id}/assign', [CrmLeadController::class, 'assign'])->name('leads.assign');
    Route::get('leads-export', [CrmLeadController::class, 'export'])->name('leads.export');

    // Customers
    Route::get('customers', [CrmCustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/create', [CrmCustomerController::class, 'create'])->name('customers.create');
    Route::post('customers', [CrmCustomerController::class, 'store'])->name('customers.store');
    Route::get('customers/{id}', [CrmCustomerController::class, 'show'])->name('customers.show');
    Route::match(['put', 'post'], 'customers/{id}', [CrmCustomerController::class, 'update'])->name('customers.update');
    Route::delete('customers/{id}', [CrmCustomerController::class, 'destroy'])->name('customers.destroy');

    // Deals / Sales Pipeline
    Route::get('deals', [CrmDealController::class, 'index'])->name('deals.index');
    Route::get('deals/create', [CrmDealController::class, 'create'])->name('deals.create');
    Route::post('deals', [CrmDealController::class, 'store'])->name('deals.store');
    Route::post('deals/{id}/stage', [CrmDealController::class, 'updateStage'])->name('deals.update-stage');
    Route::delete('deals/{id}', [CrmDealController::class, 'destroy'])->name('deals.destroy');

    // Tasks
    Route::get('tasks', [CrmTaskController::class, 'index'])->name('tasks.index');
    Route::get('tasks/create', [CrmTaskController::class, 'create'])->name('tasks.create');
    Route::post('tasks', [CrmTaskController::class, 'store'])->name('tasks.store');
    Route::post('tasks/{id}/status', [CrmTaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::delete('tasks/{id}', [CrmTaskController::class, 'destroy'])->name('tasks.destroy');

    // Follow-ups
    Route::get('followups', [CrmFollowupController::class, 'index'])->name('followups.index');
    Route::get('followups/create', [CrmFollowupController::class, 'create'])->name('followups.create');
    Route::post('followups', [CrmFollowupController::class, 'store'])->name('followups.store');
    Route::post('followups/{id}/status', [CrmFollowupController::class, 'updateStatus'])->name('followups.update-status');
    Route::delete('followups/{id}', [CrmFollowupController::class, 'destroy'])->name('followups.destroy');

    // Calendar
    Route::get('calendar', [CrmCalendarController::class, 'index'])->name('calendar.index');

    // Demos & Reservations
    Route::get('demos', [CrmDemoReservationController::class, 'demos'])->name('demos.index');
    Route::get('demos/create', [CrmDemoReservationController::class, 'createDemo'])->name('demos.create');
    Route::get('demos/assignments', [CrmDemoReservationController::class, 'demoAssignments'])->name('demos.assignments');
    Route::post('demos', [CrmDemoReservationController::class, 'storeDemo'])->name('demos.store');
    Route::post('demos/{id}/status', [CrmDemoReservationController::class, 'updateStatus'])->name('demos.status');
    Route::delete('demos/{id}', [CrmDemoReservationController::class, 'destroyDemo'])->name('demos.destroy');
    Route::get('reservations', [CrmDemoReservationController::class, 'reservations'])->name('reservations.index');
    Route::get('reservations/create', [CrmDemoReservationController::class, 'createReservation'])->name('reservations.create');
    Route::post('reservations', [CrmDemoReservationController::class, 'storeReservation'])->name('reservations.store');

    // Quotations & Tools
    Route::get('quotations', [CrmQuotationController::class, 'index'])->name('quotations.index');
    Route::get('quotations/create', [CrmQuotationController::class, 'create'])->name('quotations.create');
    Route::post('quotations', [CrmQuotationController::class, 'store'])->name('quotations.store');
    Route::get('quotations/{id}', [CrmQuotationController::class, 'show'])->name('quotations.show');
    Route::get('quotations/{id}/print', [CrmQuotationController::class, 'printView'])->name('quotations.print');
    Route::get('quotations/{id}/pdf', [CrmQuotationController::class, 'downloadPdf'])->name('quotations.pdf');
    Route::delete('quotations/{id}', [CrmQuotationController::class, 'destroy'])->name('quotations.destroy');
    Route::get('tools/billing-calculator', [CrmQuotationController::class, 'billingCalculator'])->name('tools.billing-calculator');

    // Payments
    Route::get('payments', [CrmPaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/create', [CrmPaymentController::class, 'create'])->name('payments.create');
    Route::post('payments', [CrmPaymentController::class, 'store'])->name('payments.store');
    Route::delete('payments/{id}', [CrmPaymentController::class, 'destroy'])->name('payments.destroy');

    // Products & Services
    Route::get('products', [CrmProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [CrmProductController::class, 'create'])->name('products.create');
    Route::post('products', [CrmProductController::class, 'store'])->name('products.store');
    Route::match(['put', 'post'], 'products/{id}', [CrmProductController::class, 'update'])->name('products.update');
    Route::delete('products/{id}', [CrmProductController::class, 'destroy'])->name('products.destroy');

    // Team & Performance
    Route::get('team', [CrmTeamController::class, 'index'])->name('team.index');
    Route::get('team/create', [CrmTeamController::class, 'create'])->name('team.create');
    Route::post('team', [CrmTeamController::class, 'store'])->name('team.store');
    Route::get('team/{id}/edit', [CrmTeamController::class, 'edit'])->name('team.edit');
    Route::match(['put', 'post'], 'team/{id}', [CrmTeamController::class, 'update'])->name('team.update');
    Route::delete('team/{id}', [CrmTeamController::class, 'destroy'])->name('team.destroy');
    Route::get('team/{id}/toggle-status', [CrmTeamController::class, 'toggleStatus'])->name('team.toggle-status');
    Route::get('performance', [CrmTeamController::class, 'performance'])->name('team.performance');
    Route::get('targets', [CrmTeamController::class, 'targets'])->name('team.targets');
    Route::post('targets', [CrmTeamController::class, 'storeTarget'])->name('team.targets.store');

    // Reports
    Route::get('reports', [CrmReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export', [CrmReportController::class, 'export'])->name('reports.export');

    // System & Live Tracking
    Route::get('live-tracking', [CrmSystemController::class, 'liveTracking'])->name('system.live-tracking');
    Route::get('activity-logs', [CrmSystemController::class, 'activityLogs'])->name('system.activity-logs');
    Route::get('notifications', [CrmSystemController::class, 'notifications'])->name('system.notifications');
    Route::post('notifications/mark-read', [CrmSystemController::class, 'markAllNotificationsRead'])->name('system.notifications.mark-read');
    Route::delete('notifications/{id}', [CrmSystemController::class, 'deleteNotification'])->name('system.notifications.destroy');
    Route::post('notifications/clear-all', [CrmSystemController::class, 'clearAllNotifications'])->name('system.notifications.clear-all');
    Route::post('notifications/sync', [CrmSystemController::class, 'syncNotifications'])->name('system.notifications.sync');
    Route::get('roles', [CrmSystemController::class, 'roles'])->name('system.roles');
    Route::get('settings', [CrmSystemController::class, 'settings'])->name('system.settings');
    Route::post('settings', [CrmSystemController::class, 'saveSettings'])->name('system.settings.save');

    // Super Admin Hub
    Route::prefix('super')->name('super.')->group(function () {
        // 1. RBAC Matrix
        Route::get('rbac', [CrmSuperAdminController::class, 'rbac'])->name('rbac');
        Route::get('rbac/create', [CrmSuperAdminController::class, 'createRole'])->name('rbac.create');
        Route::post('rbac/role', [CrmSuperAdminController::class, 'storeRole'])->name('rbac.role.store');
        Route::post('rbac/{id}', [CrmSuperAdminController::class, 'updateRolePermissions'])->name('rbac.update');

        // 2. Impersonation
        Route::get('impersonate/{id}', [CrmSuperAdminController::class, 'impersonate'])->name('impersonate');
        Route::get('leave-impersonate', [CrmSuperAdminController::class, 'leaveImpersonate'])->name('leave-impersonate');

        // 3. Multi-Branch
        Route::get('branches', [CrmSuperAdminController::class, 'branches'])->name('branches');
        Route::get('branches/create', [CrmSuperAdminController::class, 'createBranch'])->name('branches.create');
        Route::post('branches', [CrmSuperAdminController::class, 'storeBranch'])->name('branches.store');
        Route::delete('branches/{id}', [CrmSuperAdminController::class, 'destroyBranch'])->name('branches.destroy');

        // 4. Automation & Routing
        Route::get('automation', [CrmSuperAdminController::class, 'automation'])->name('automation');
        Route::post('automation', [CrmSuperAdminController::class, 'saveAutomation'])->name('automation.save');
        Route::post('automation/merge', [CrmSuperAdminController::class, 'mergeDuplicateLeads'])->name('automation.merge');

        // 5. Integrations & API Hub
        Route::get('integrations', [CrmSuperAdminController::class, 'integrations'])->name('integrations');
        Route::post('integrations', [CrmSuperAdminController::class, 'saveIntegrations'])->name('integrations.save');

        // 6. Security & Session Control
        Route::get('security', [CrmSuperAdminController::class, 'security'])->name('security');
        Route::post('security', [CrmSuperAdminController::class, 'saveSecurity'])->name('security.save');
        Route::post('security/session/{id}/revoke', [CrmSuperAdminController::class, 'revokeSession'])->name('security.session.revoke');

        // 7. Recycle Bin
        Route::get('recycle-bin', [CrmSuperAdminController::class, 'recycleBin'])->name('recycle_bin');
        Route::post('recycle-bin/restore-all', [CrmSuperAdminController::class, 'restoreAll'])->name('recycle_bin.restore_all');
        Route::post('recycle-bin/empty', [CrmSuperAdminController::class, 'emptyRecycleBin'])->name('recycle_bin.empty');
        Route::post('recycle-bin/{type}/{id}/restore', [CrmSuperAdminController::class, 'restoreItem'])->name('recycle_bin.restore');
        Route::delete('recycle-bin/{type}/{id}/force', [CrmSuperAdminController::class, 'forceDeleteItem'])->name('recycle_bin.force');

        // 8. Financial Approvals
        Route::get('approvals', [CrmSuperAdminController::class, 'approvals'])->name('approvals');
        Route::post('approvals/{id}/approve', [CrmSuperAdminController::class, 'approveQuotation'])->name('approvals.approve');
        Route::post('approvals/{id}/reject', [CrmSuperAdminController::class, 'rejectQuotation'])->name('approvals.reject');

        // 9. Database Backup & System Logs
        Route::get('backup', [CrmSuperAdminController::class, 'backup'])->name('backup');
        Route::get('backup/download', [CrmSuperAdminController::class, 'downloadBackup'])->name('backup.download');
    });
});

// Employee Panel Routes
Route::prefix('crm/employee')->middleware(['crm_auth:employee'])->name('crm.employee.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('crm.employee.dashboard');
    });
    Route::get('dashboard', [CrmEmployeeDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('leads', [CrmEmployeeDashboardController::class, 'myLeads'])->name('leads');
    Route::get('customers', [CrmEmployeeDashboardController::class, 'myCustomers'])->name('customers');
    Route::get('deals', [CrmEmployeeDashboardController::class, 'myDeals'])->name('deals');
    Route::get('tasks', [CrmEmployeeDashboardController::class, 'myTasks'])->name('tasks');
    Route::get('followups', [CrmEmployeeDashboardController::class, 'myFollowups'])->name('followups');
    Route::get('calendar', [CrmEmployeeDashboardController::class, 'myCalendar'])->name('calendar');
    Route::get('performance', [CrmEmployeeDashboardController::class, 'myPerformance'])->name('performance');
    Route::get('profile', [CrmEmployeeDashboardController::class, 'myProfile'])->name('profile');
    Route::get('notifications', [CrmEmployeeDashboardController::class, 'notifications'])->name('notifications');
});

// Direct Aliases for specification compliance
Route::get('/admin/dashboard.php', function () {
    return redirect()->route('crm.admin.dashboard');
});
Route::get('/employee/dashboard.php', function () {
    return redirect()->route('crm.employee.dashboard');
});
