<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuadro extends Model
{
  protected $table='cuadro';

  protected $primaryKey='idcuadro';

  public $timestamps=false;

  protected $guarded =[

  ];
}
