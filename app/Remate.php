<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remate extends Model
{
  protected $table='remate';

  protected $primaryKey='idremate';

  public $timestamps=false;

  protected $guarded =[

  ];
}
