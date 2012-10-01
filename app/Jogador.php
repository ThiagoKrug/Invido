<?php

/**
 * Description of Jogador
 *
 * @author thiago
 */

namespace app;

class Jogador {
    
    private $chute;
    
    public function __construct() {
        $this->chute = -1;
    }
    
    public function chutar($chute) {
        $this->chute = $chute;
    }
    
    public function getChute() {
        return $this->chute;
    }
    
}