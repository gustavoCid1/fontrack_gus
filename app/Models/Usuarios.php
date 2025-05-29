<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Usuarios extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tb_users';

    protected $primaryKey = 'id_usuario';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'nombre',
        'correo',
        'password',
        'tipo_usuario',
        'foto_usuario',
        'id_lugar',
    ];


    public $timestamps = true;
    /**
     * Los atributos que deben estar ocultos para los arrays.
     */
    protected $hidden = ['password', 'remember token'];


    /**
     * Mutador para encriptar la contraseña.
     * Comprueba si la contraseña ya está encriptada para evitar doble hashing.
     */
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

    /**
     * Relación con el modelo Lugar.
     */
    public function lugar()
    {
        return $this->belongsTo(\App\Models\Lugar::class, 'id_lugar', 'id_lugar');
    }
}
