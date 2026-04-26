<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['nom', 'email', 'password', 'role'];
    const UPDATED_AT = null;
    protected $hidden   = ['password'];
    protected $casts    = ['password' => 'hashed'];

    public function isMedecin(): bool { return $this->role === 'medecin'; }
    public function isPatient(): bool { return $this->role === 'patient'; }
}