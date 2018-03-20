<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;
use Escuchable\App\Session;

class Configuracion extends Modelo
{
    public $timestamps = true;
    protected $table = 'configuracion';
    protected $fillable = array(
        'id',
        'user_id',
        'config',
        'value',
    );

    public function obtain($config) {
        $data = [
            'user_id' => Session::get('user.id'),
            'config' => $config,
        ];
        $configDB = Configuracion::firstOrNew($data);
        $configDB->save();

        return $configDB->valor;
    }

    public function set($config, $valor = false) {
        $data = [
            'user_id' => Session::get('user.id'),
            'config' => $config,
        ];
        $configDB = Configuracion::firstOrNew($data);
        $configDB->valor = $valor;
        $configDB->save();

        return $configDB;
    }
    
    public function remove($config) {
        $data = [
            'user_id' => Session::get('user.id'),
            'config' => $config,
        ];
        $configDB = Configuracion::firstOrNew($data);
        $configDB->delete();
    }
}
