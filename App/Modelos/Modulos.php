<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class Modulos extends Modelo
{
    public $timestamps = true;
    protected $table = 'modulos';
    protected $fillable = array(
        'slug',
        'titulo',
        'descripcion',
        'instalado',
        'class_name',
    );
    

    public static function getInstalled() {
        $installed = array();

        $modulos = Modulos::where('instalado', 1)->get();
        if (!empty($modulos)) {
            foreach ($modulos as $modulo) {
                $installed[$modulo->slug] = $modulo;
            }
        }

        return $installed;
    }
}
