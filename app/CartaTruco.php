<?php

/**
 * Description of CartaTruco
 *
 * @author thiago
 */

namespace app;

use MRCartas\Carta;

class CartaTruco extends Carta {
    
    private $invido;
    
    public function __construct($naipe = null, $valor = null, $invido = null) {
        parent::__construct($naipe, $valor);
        $this->invido = $invido;
    }
    
    public function getInvido() {
        return $this->invido;
    }
    
    public function setInvido($invido) {
        $this->invido = $invido;
    }
}