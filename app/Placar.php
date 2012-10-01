<?php

/**
 * Description of Placar
 *
 * @author thiago
 */

namespace app;

class Placar {

    private $acertos;
    private $erros;

    public function __construct() {
        $this->acertos = 0;
        $this->erros = 0;
    }
    
    public function getAcertos() {
        return $this->acertos;
    }
    
    public function setAcertos($acertos) {
        $this->acertos = $acertos;
    }
    
    public function addAcertos() {
        $this->acertos++;
    }
    
    public function getErros() {
        return $this->erros;
    }
    
    public function setErros($erros) {
        $this->erros = $erros;
    }
    
    public function addErros() {
        $this->erros++;
    }

}