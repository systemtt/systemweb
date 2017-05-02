<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
  protected $table='slider';

  protected $primaryKey='idslider';

  public $timestamps=false;


  protected $fillable =[
    'nombre',
    'descripcion',
    'imagen'
  ];

  protected $guarded =[

  ];
}
