<?php

$url_request = $_SERVER['REQUEST_URI'];
//define('APPLICATION_PATH', $_SERVER['APPLICATION_PATH']);
define('APPLICATION_PATH', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('APPLICATION_URL', 'http://' . $_SERVER['HTTP_HOST']);

$url = '/' . substr_replace($url_request, '', 0, strlen(APPLICATION_PATH));


set_include_path(get_include_path() . PATH_SEPARATOR . realpath(__DIR__ . '/../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(__DIR__ . '/../library'));
//require_once 'MRCartas/Autoloader.php';
include('package.phar');
require_once 'app/JogoApp.php';
require_once 'app/Jogo.php';
require_once 'app/CartaTruco.php';
require_once 'app/Jogador.php';
require_once 'app/Placar.php';

/* @var $jogoApp app\JogoApp */
$jogoApp = new \app\JogoApp();

require_once 'Zend/Session/Namespace.php';
require_once 'Zend/Json/Encoder.php';
$session = new Zend_Session_Namespace();
if (isset($session->jogo) === false) {
    $session->jogo = new \app\Jogo();
}

$jogoApp->get('/', function () use($session) {
            require '../app/view/index.phtml';
        });

$jogoApp->get('/oi', function () {
            echo 'helloooo mano!';
        });

$jogoApp->get('/chute/{chute}', function ($chute) use ($session) {
            $jogo = $session->jogo;
            /* @var $jogo app\Jogo */
            $jogo->getJogador()->chutar($chute);
            $acertou = $jogo->acertou();
            //echo $jogo->getPlacar()->getAcertos() . ' ' . $jogo->getPlacar()->getErros();
            echo $acertou;
        });
$jogoApp->get('/cartas-restantes/', function () use ($session) {
            $jogo = $session->jogo;
            /* @var $jogo app\Jogo */
            $cartasRestantes = $jogo->getBaralho()->count();
            echo $cartasRestantes;
        });

$jogoApp->get('/ultimo-invido/', function () use ($session) {
            $jogo = $session->jogo;
            /* @var $jogo app\Jogo */
            $ultimoInvido = $jogo->getUltimoInvido();
            echo $ultimoInvido;
        });

$jogoApp->get('/ultimas-tres-cartas/', function () use ($session) {
            $jogo = $session->jogo;
            /* @var $jogo app\Jogo */
            $cartas = $jogo->getUltimasTresCartas();
            $tres = array(array('valor' => $cartas[0]->getValor(), 'naipe' => $cartas[0]->getNaipe()),
                array('valor' => $cartas[1]->getValor(), 'naipe' => $cartas[1]->getNaipe()),
                array('valor' => $cartas[2]->getValor(), 'naipe' => $cartas[2]->getNaipe()));
            echo Zend_Json_Encoder::encode($tres);
        });

$jogoApp->get('/acertos/', function () use ($session) {
            $jogo = $session->jogo;
            /* @var $jogo app\Jogo */
            $acertos = $jogo->getPlacar()->getAcertos();
            echo $acertos;
        });

$jogoApp->get('/erros/', function () use ($session) {
            $jogo = $session->jogo;
            /* @var $jogo app\Jogo */
            $erros = $jogo->getPlacar()->getErros();
            echo $erros;
        });

$jogoApp->get('/novo-jogo/', function () use ($session) {
            $session->jogo = null;
            $session->jogo = new \app\Jogo();
        });

$jogoApp->run($url);
