<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Slot;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Stats Cards
        $totalPatients = User::where('role', 'patient')->count();
        $totalAppointments = Appointment::count();
        $appointmentsToday = Appointment::whereHas('creneau', function($q) {
            $q->where('date_creneau', Carbon::today()->toDateString());
        })->count();
        $availableSlots = Slot::where('disponible', true)
            ->where('date_creneau', '>=', Carbon::today()->toDateString())
            ->count();

        // 2. Summary of appointments by status
        $statsStatus = [
            'confirmé' => Appointment::where('statut', 'confirmé')->count(),
            'annulé' => Appointment::where('statut', 'annulé')->count(),
            'en attente' => Appointment::where('statut', 'en attente')->count(),
        ];

        // 3. Bar Chart Data (Last 7 days)
        $chartData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $count = Appointment::whereHas('creneau', function($q) use ($date) {
                $q->where('date_creneau', $date);
            })->count();
            
            $chartLabels[] = Carbon::today()->subDays($i)->format('d M');
            $chartData[] = $count;
        }

        // 4. Recent Activity
        $recentAppointments = Appointment::with(['patient', 'creneau'])
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPatients',
            'totalAppointments',
            'appointmentsToday',
            'availableSlots',
            'statsStatus',
            'chartData',
            'chartLabels',
            'recentAppointments'
        ));
    }
}
