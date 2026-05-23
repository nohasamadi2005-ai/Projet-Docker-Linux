<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SlotController;

Route::get('/',         fn() => redirect('/login'));
Route::get('/login',    fn() => view('auth.login'));
Route::get('/register', fn() => view('auth.register'));
Route::post('/login',   [AuthController::class, 'login']);
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->middleware('auth');
Route::get('/home',     fn() => view('home'))->middleware('auth');

Route::middleware('auth')->group(function () {

    // Routes Patient
    Route::get('/patient/accueil',   [AppointmentController::class, 'index'])
         ->name('appointments.index');
    Route::post('/reserver',         [AppointmentController::class, 'reserver'])
         ->name('appointments.reserver');
    Route::get('/patient/mes-rdv',   [AppointmentController::class, 'mesRdv'])
         ->name('appointments.mes-rdv');
    Route::post('/annuler/{id}',     [AppointmentController::class, 'annuler'])
         ->name('appointments.annuler');

    // Routes Médecin
    Route::get('/medecin/dashboard', [AppointmentController::class, 'dashboard'])
         ->name('appointments.dashboard');
    Route::post('/confirmer/{id}',   [AppointmentController::class, 'confirmer'])
         ->name('appointments.confirmer');

    // Gestion créneaux (médecin)
    Route::get('/medecin/creneaux', function() {
        $slots = \App\Models\Slot::orderBy('date_creneau')
                                 ->orderBy('heure_debut')
                                 ->get();
        return view('slots.index', compact('slots'));
    })->name('slots.index');

    Route::post('/medecin/creneaux', function(\Illuminate\Http\Request $request) {
        $request->validate([
            'date_creneau' => 'required|date|after_or_equal:today',
            'heure_debut'  => 'required|date_format:H:i',
            'heure_fin'    => 'required|date_format:H:i|after:heure_debut',
        ]);
        \App\Models\Slot::create([
            'medecin_id'   => auth()->id(),
            'date_creneau' => $request->date_creneau,
            'heure_debut'  => $request->heure_debut,
            'heure_fin'    => $request->heure_fin,
            'disponible'   => true,
        ]);
        return back()->with('success', 'Créneau ajouté !');
    })->name('slots.store');

    // ← Nouvelles routes modification
    Route::get('/medecin/creneaux/{id}/edit', function($id) {
        $slot = \App\Models\Slot::findOrFail($id);
        if (!$slot->disponible) {
            return redirect('/medecin/creneaux')
                   ->with('error', 'Impossible de modifier un créneau déjà réservé.');
        }
        return view('slots.edit', compact('slot'));
    })->name('slots.edit');

    Route::put('/medecin/creneaux/{id}', function(\Illuminate\Http\Request $request, $id) {

    $request->validate([
        'date_creneau' => 'required|date|after_or_equal:today',
        'heure_debut'  => 'required',
        'heure_fin'    => 'required|after:heure_debut',
    ]);

    $slot = \App\Models\Slot::findOrFail($id);

    // empêcher modification si réservé
    if (!$slot->disponible) {
        return redirect('/medecin/creneaux')
               ->with('error', 'Impossible de modifier un créneau réservé.');
    }

    // mise à jour manuelle
    $slot->date_creneau = $request->date_creneau;
    $slot->heure_debut  = $request->heure_debut;
    $slot->heure_fin    = $request->heure_fin;

    $slot->save();

    return redirect('/medecin/creneaux')
           ->with('success', 'Créneau modifié avec succès !');

     })->name('slots.update');

    Route::delete('/medecin/creneaux/{id}', function($id) {
        \App\Models\Slot::findOrFail($id)->delete();
        return back()->with('success', 'Créneau supprimé.');
    })->name('slots.destroy');

});