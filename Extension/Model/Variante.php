<?php

namespace FacturaScripts\Plugins\POS\Extension\Model;

use Closure;

/**
 * Personalización infometica: si la variante tiene descripción propia,
 * se usa en lugar de "descripción del producto + atributos" en documentos
 * (facturas, albaranes, tickets...).
 */
class Variante
{
    /**
     * Al guardar una variante: si el producto ya tiene más de una variante y nunca se decidió
     * (ocultar_base NULL), se activa "ocultar producto base". Después el usuario puede desmarcarla.
     */
    public function save(): Closure
    {
        return function () {
            $db = new \FacturaScripts\Core\Base\DataBase();
            $id = (int)$this->idproducto;
            $db->exec('UPDATE productos SET ocultar_base = 1 WHERE idproducto = ' . $id
                . ' AND ocultar_base IS NULL'
                . ' AND (SELECT COUNT(*) FROM variantes WHERE idproducto = ' . $id . ') > 1');
            return true;
        };
    }

    public function description(): Closure
    {
        return function (bool $onlyAttributes = false) {
            $descripcion = trim((string)($this->descripcion ?? ''));
            if ($onlyAttributes || $descripcion === '') {
                return null;
            }

            return $descripcion;
        };
    }
}
