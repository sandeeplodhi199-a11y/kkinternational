<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Crm\CrmFollowup;
use App\Models\Crm\CrmTask;
use App\Models\Crm\CrmDemo;
use App\Models\Crm\CrmReservation;

class CrmCalendarController extends Controller
{
    public function index(Request $request)
    {
        $events = [];

        // Follow-ups
        foreach (CrmFollowup::with(['lead', 'customer'])->get() as $fu) {
            $title = ($fu->type ?: 'Followup') . ': ' . ($fu->lead ? $fu->lead->name : ($fu->customer ? $fu->customer->name : 'Client'));
            $events[] = [
                'id' => 'fu_' . $fu->id,
                'title' => $title,
                'date' => $fu->date,
                'time' => $fu->time ? substr($fu->time, 0, 5) : '10:00',
                'type' => 'Followup',
                'color' => '#f59e0b',
            ];
        }

        // Tasks
        foreach (CrmTask::all() as $t) {
            $events[] = [
                'id' => 't_' . $t->id,
                'title' => 'Task: ' . $t->title,
                'date' => $t->due_date,
                'time' => '17:00',
                'type' => 'Task',
                'color' => '#3b82f6',
            ];
        }

        // Demos
        foreach (CrmDemo::all() as $d) {
            $events[] = [
                'id' => 'dm_' . $d->id,
                'title' => 'Demo: ' . $d->title,
                'date' => $d->date,
                'time' => $d->time ? substr($d->time, 0, 5) : '11:00',
                'type' => 'Demo',
                'color' => '#10b981',
            ];
        }

        // Reservations
        foreach (CrmReservation::all() as $r) {
            $events[] = [
                'id' => 'res_' . $r->id,
                'title' => 'Booking: ' . $r->service_name,
                'date' => $r->date,
                'time' => $r->time ? substr($r->time, 0, 5) : '14:00',
                'type' => 'Reservation',
                'color' => '#8b5cf6',
            ];
        }

        return view('crm.admin.calendar.index', compact('events'));
    }
}
