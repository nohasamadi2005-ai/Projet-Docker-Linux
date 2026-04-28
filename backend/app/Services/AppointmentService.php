<?php
namespace App\Services;

use App\Models\Slot;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Exception;

class AppointmentService
{
    public function reserver(int $creneauId, int $patientId): Appointment
    {
        return DB::transaction(function () use ($creneauId, $patientId) {

            $creneau = Slot::lockForUpdate()->find($creneauId);
            if (!$creneau) {
                throw new Exception('Créneau introuvable.');
            }

            if (!$creneau->disponible) {
                throw new Exception('Ce créneau est déjà réservé.');
            }

            $dejaDispo = Appointment::where('patient_id', $patientId)
                ->whereIn('statut', ['en_attente', 'confirme'])
                ->whereHas('creneau', function ($q) use ($creneau) {
                    $q->where('date_creneau', $creneau->date_creneau);
                })->exists();

            if ($dejaDispo) {
                throw new Exception('Vous avez déjà un rendez-vous ce jour.');
            }

            $appointment = Appointment::create([
                'patient_id' => $patientId,
                'creneau_id' => $creneauId,
                'statut'     => 'en_attente'
            ]);

            $creneau->update(['disponible' => false]);

            return $appointment->load('creneau');
        });
    }

    public function annuler(int $appointmentId, int $userId, string $role): void
    {
        $appointment = Appointment::with('creneau')->findOrFail($appointmentId);

        if ($role === 'patient' && $appointment->patient_id !== $userId) {
            throw new Exception('Non autorisé.');
        }

        if ($appointment->statut === 'annule') {
            throw new Exception('Ce RDV est déjà annulé.');
        }

        DB::transaction(function () use ($appointment) {
            $appointment->update(['statut' => 'annule']);
            $appointment->creneau->update(['disponible' => true]);
        });
    }
}