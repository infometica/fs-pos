<?php
/**
 * This file is part of POS plugin for FacturaScripts
 * Copyright (C) 2022-2026 Juan José Prieto Dzul <juanjoseprieto88@gmail.com>
 */

namespace FacturaScripts\Plugins\POS\Controller;

use FacturaScripts\Core\Base\Controller;
use FacturaScripts\Core\Tools;

/**
 * Muestra el POS embebido dentro del panel estándar de FacturaScripts
 * (con cabecera y menú), en lugar de a pantalla completa.
 *
 * El POS en sí (Controller\POS) sigue siendo la app real: usa su propio
 * framework de CSS (Tailwind), incompatible con el Bootstrap del núcleo,
 * así que se sirve dentro de un iframe en vez de fusionar los layouts.
 */
class POSPanel extends Controller
{
    /** @var string */
    public $posUrl = '';

    public function getPageData(): array
    {
        $pagedata = parent::getPageData();
        $pagedata['title'] = 'POS';
        $pagedata['menu'] = 'point-of-sale';
        $pagedata['icon'] = 'fas fa-shopping-cart';
        $pagedata['showonmenu'] = true;

        return $pagedata;
    }

    public function privateCore(&$response, $user, $permissions): void
    {
        parent::privateCore($response, $user, $permissions);

        $this->posUrl = Tools::config('route') . '/POS';
    }
}
