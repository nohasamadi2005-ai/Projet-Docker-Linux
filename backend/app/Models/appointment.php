<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table    = 'rendez_vous';
    protected $fillable = ['patient_id', 'creneau_id', 'statut'];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function creneau()
    {
        return $this->belongsTo(Slot::class, 'creneau_id');
    }
}