<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    use HasFactory;

    protected $table = 'tb_lugares'; // Asegura que Laravel use la tabla correcta
    protected $primaryKey = 'id_lugar'; // Define la clave primaria correctamente
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'estado'
    ];  

    // Relaciones
    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'id_lugar'); // Ajuste en relación
    }

    public function materiales()
    {
        return $this->hasMany(Material::class, 'id_lugar'); // Ajuste en relación
    }
}
