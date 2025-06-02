<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    
    protected $table = 'tb_materiales';
    protected $primaryKey = 'id_material'; 
    
    protected $fillable = [
        'clave_material',
        'descripcion',
        'generico',
        'clasificacion',
        'existencia',
        'costo_promedio',
        'id_lugar' 
    ];

    // Relación con la tabla Lugar (corrección de la clave foránea)
    public function lugar()
    {
        return $this->belongsTo(Lugar::class, 'id_lugar', 'id'); // Asegurando que la PK referenciada sea 'id'
    }
}
