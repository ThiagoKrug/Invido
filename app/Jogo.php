<?php

/**
 * Description of Jogo
 *
 * @author thiago
 */

namespace app;

use MRCartas\Baralho,
    app\CartaTruco,
    app\Jogador,
    app\Placar;

class Jogo {
    /* @var $baralho \MRCartas\Baralho */

    private $baralho;

    /* @var $jogador \app\Jogador */
    private $jogador;

    /* @var $placar \app\Placar */
    private $placar;
    
    private $ultimoInvido;
    
    private $ultimasTresCartas;

    public function __construct() {
        $this->baralho = new Baralho();
        $naipes = array('paus', 'ouro', 'espada', 'copas');
        $valores = array('A' => 1, 'Q' => 0, 'J' => 0, '10' => 0, '7' => 7, '6' => 6, '5' => 5, '4' => 4, '3' => 3, '2' => 2);
        foreach ($naipes as $naipe) {
            foreach ($valores as $key => $value) {
                $carta = new CartaTruco();
                $carta->setNaipe($naipe);
                $carta->setValor($key);
                $carta->setInvido($value);
                $this->baralho->addCarta($carta);
            }
        }
        $this->baralho->embaralhaCartas();

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
    
    public function getBaralho() {
        return $this->baralho;
    }
    
    public function setBaralho($baralho) {
        $this->baralho = $baralho;
    }
    
    public function getUltimoInvido() {
        return $this->ultimoInvido;
    }

    public function setUltimoInvido($ultimoInvido) {
        $this->ultimoInvido = $ultimoInvido;
    }
    
    public function getUltimasTresCartas() {
        return $this->ultimasTresCartas;
    }

    public function setUltimasTresCartas($ultimasTresCartas) {
        $this->ultimasTresCartas = $ultimasTresCartas;
    }

    public function acertou() {
        $chute = $this->jogador->getChute();
        $this->setUltimoInvido($this->calcularInvido());
        if ($chute == $this->getUltimoInvido()) {
            $this->placar->addAcertos();
            return true;
        } else {
            $this->placar->addErros();
            return false;
        }
    }

    private function getTresCartas() {
        $cartas = array();
        $cartas[] = $this->baralho->retiraCartaInicio();
        $cartas[] = $this->baralho->retiraCartaInicio();
        $cartas[] = $this->baralho->retiraCartaInicio();
        $this->setUltimasTresCartas($cartas);
        return $cartas;
    }

    private function calcularInvido() {
        $cartas = $this->getTresCartas();

        // todas iguais (flor)
        if (($cartas[0]->getNaipe() == $cartas[1]->getNaipe()) &&
                ($cartas[0]->getNaipe() == $cartas[2]->getNaipe())) {
            
            return $cartas[0]->getInvido() + $cartas[1]->getInvido() + $cartas[2]->getInvido() + 20;

            // carta 0 eh do mesmo naipe da carta 1
        } else if (($cartas[0]->getNaipe() == $cartas[1]->getNaipe()) &&
                ($cartas[0]->getNaipe() != $cartas[2]->getNaipe())) {

            return $cartas[0]->getInvido() + $cartas[1]->getInvido() + 20;

            // carta 0 eh do mesmo naipe da carta 2
        } else if (($cartas[0]->getNaipe() != $cartas[1]->getNaipe()) &&
                ($cartas[0]->getNaipe() == $cartas[2]->getNaipe())) {

            return $cartas[0]->getInvido() + $cartas[2]->getInvido() + 20;

            // carta 1 eh do mesmo naipe da carta 2
        } else if (($cartas[0]->getNaipe() != $cartas[1]->getNaipe()) &&
                ($cartas[1]->getNaipe() == $cartas[2]->getNaipe())) {

            return $cartas[1]->getInvido() + $cartas[2]->getInvido() + 20;

            // nenhuma carta eh do mesmo naipe
        } else if (($cartas[0]->getNaipe() != $cartas[1]->getNaipe()) &&
                ($cartas[0]->getNaipe() != $cartas[2]->getNaipe()) &&
                ($cartas[1]->getNaipe() != $cartas[2]->getNaipe())) {

            return $this->verificaMaiorInvido($cartas);
        }
    }

    private function verificaMaiorInvido(array $cartas) {
        $maior = -12341234;
        foreach ($cartas as $carta) {
            $invido = $carta->getInvido();
            if ($invido > $maior) {
                $maior = $invido;
            }
        }
        return $maior;
    }

}