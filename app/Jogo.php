<?php

/**
 * Description of Jogo
 *
 * @author thiago
 */

namespace app;

use MRCartas\Baralho,
    app\Jogador,
    app\Placar;

class Jogo {
    /* @var $baralho \MRCartas\Baralho */

    private $baralho;

    /* @var $jogador \app\Jogador */
    private $jogador;

    /* @var $placar \app\Placar */
    private $placar;

    public function __construct() {
        $this->baralho = new Baralho();
        $naipes = array('paus', 'ouro', 'espada', 'copas');
        $valores = array('A', 'K', 'Q', 'J', '10', '9', '8', '7', '6', '5', '4', '3', '2');
        foreach ($naipes as $naipe) {
            foreach ($valores as $value) {
                $carta = new \MRCartas\Carta();
                $carta->setNaipe($naipe);
                $carta->setValor($value);
                $this->baralho->addCarta($carta);
            }
        }

        $this->jogador = new Jogador();
        
        $this->placar = new Placar();
    }

    public function getPlacar() {
        return $this->placar;
    }

    public function setPlacar($placar) {
        $this->placar = $placar;
    }
    
    public function getJogador() {
        return $this->jogador;
    }

}