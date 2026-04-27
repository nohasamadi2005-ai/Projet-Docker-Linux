<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $table    = 'creneaux';
    protected $fillable = ['medecin_id', 'date_creneau', 'heure_debut', 'heure_fin', 'disponible'];

    public function medecin()
    {
        return $this->belongsTo(User::class, 'medecin_id');
    }

    public function rendezVous()
    {
        return $this->hasOne(Appointment::class, 'creneau_id');
    }
}