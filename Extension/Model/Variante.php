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
