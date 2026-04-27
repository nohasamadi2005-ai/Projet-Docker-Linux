<?php
namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\User;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    // GET /api/slots
    public function index()
    {
        $slots = Slot::with('medecin')
                     ->where('disponible', 1)
                     ->where('date_creneau', '>=', today())
                     ->orderBy('date_creneau')
                     ->orderBy('heure_debut')
                     ->get();

        return response()->json($slots);
    }

    // POST /api/slots
    public function store(Request $request)
    {
        $request->validate([
            'date_creneau' => 'required|date|after_or_equal:today',
            'heure_debut'  => 'required|date_format:H:i',
            'heure_fin'    => 'required|date_format:H:i|after:heure_debut',
        ]);

        $slot = Slot::create([
            'medecin_id'   => $request->user()->id,
            'date_creneau' => $request->date_creneau,
            'heure_debut'  => $request->heure_debut,
            'heure_fin'    => $request->heure_fin,
            'disponible'   => true,
        ]);

        return response()->json($slot, 201);
    }

    // DELETE /api/slots/{id}
    public function destroy($id)
    {
        $slot = Slot::findOrFail($id);
        $slot->delete();
        return response()->json(['message' => 'Créneau supprimé']);
    }
}