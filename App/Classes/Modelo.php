<?php
namespace Escuchable\App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Expression as raw;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model as Model;

use Escuchable\App\observerModel;

class Modelo extends Model
{
    public static $cache;

    public static function boot()
    {
        parent::boot();

        static::observe(new modeloObserver);
    }


}
