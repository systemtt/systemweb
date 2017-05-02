<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
  protected $table='obra';

  protected $primaryKey='idobra';

  public $timestamps=false;


  protected $fillable =[
    'nombre',
    'tipo_de_remate',
    'fecha',
    'horario',
    'direccion',
    'descripcion',
    'imagenes_cuadros',
    'imagenp',
    'estado'
  ];

  protected $guarded =[

  ];
}
