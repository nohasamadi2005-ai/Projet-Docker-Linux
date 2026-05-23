<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Slot;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Exception;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    // Afficher les créneaux disponibles
    public function index()
    {
        $creneaux = Slot::where('disponible', true)
            ->where('date_creneau', '>=', now()->toDateString())
            ->orderBy('date_creneau')
            ->orderBy('heure_debut')
            ->get();

        return view('appointments.index', compact('creneaux'));
    }

    // Réserver un créneau
    public function reserver(Request $request)
    {
        $request->validate([
            'creneau_id' => 'required|integer|exists:creneaux,id'
        ]);

        try {
            $this->appointmentService->reserver(
                $request->creneau_id,
                auth()->id()
            );

            return redirect()->route('appointments.mes-rdv')
                ->with('success', 'Rendez-vous réservé avec succès !');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Mes rendez-vous
    public function mesRdv()
    {
        $appointments = Appointment::where('patient_id', auth()->id())
            ->with('creneau')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('appointments.mes-rdv', compact('appointments'));
    }

    // Annuler un RDV
    public function annuler(int $id)
    {
        try {
            $this->appointmentService->annuler(
                $id,
                auth()->id(),
                auth()->user()->role
            );

            return back()->with('success', 'Rendez-vous annulé.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Dashboard médecin
    public function dashboard()
    {
        $appointments = Appointment::with(['creneau', 'patient'])
            ->orderBy('created_at', 'desc')
            ->get();

        $confirmes = $appointments->where('statut', 'confirme')->count();
        $enAttente = $appointments->where('statut', 'en_attente')->count();
        $annules   = $appointments->where('statut', 'annule')->count();

        return view('appointments.dashboard', compact(
            'appointments', 'confirmes', 'enAttente', 'annules'
        ));
    }

    // Confirmer un RDV (médecin)
    public function confirmer(int $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['statut' => 'confirme']);

        return back()->with('success', 'RDV confirmé.');
    }
}