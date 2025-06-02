<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ Esto permite que funcione con Auth
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Usuarios extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tb_users'; // Asegúrate de que esto coincida con tu tabla

    protected $primaryKey = 'id_usuario'; // Ajusta según tu clave primaria

    public $timestamps = false; // O true, si usas created_at / updated_at

    protected $fillable = [
        'nombre',
        'correo',
        'password',
        'tipo_usuario',
        'foto_usuario',
        'id_lugar',
    ];

    protected $hidden = [
        'password', // 🔐 Oculta la contraseña en respuestas JSON
        'remember_token',
    ];

    public function lugar()
    {
        return $this->belongsTo(Lugar::class, 'id_lugar', 'id_lugar');
    }
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            // Si ya empieza con '$2y$', asumimos que está encriptada
            if (Str::startsWith($value, '$2y$')) {
                $this->attributes['password'] = $value;
            } else {
                $this->attributes['password'] = bcrypt($value);
            }
        }
    }

    /**
     * Accesor para obtener la URL de la foto del usuario.
     * Si el usuario tiene foto guardada en public/img, devuelve su URL, de lo contrario la foto default.
     */
    public function getFotoUsuarioUrlAttribute()
    {
        if ($this->foto_usuario && file_exists(public_path('img/' . $this->foto_usuario))) {
            return asset('img/' . $this->foto_usuario);
        }
        return asset('img/usuario_default.png');
    }

}
