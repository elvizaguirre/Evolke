<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
require dirname(__FILE__) . '/includes/init.php';

if (!isset($_GET['id_processo'])) {
    header('HTTP/1.0 400 Bad Request', true, 400);
    exit();
}

$idProcesso = $_GET['id_processo'];
$idVolk = 0;
$update = false;
if (isset($_GET['id_volk']) && $_GET['id_volk'] != 0) {
    $idVolk = $_GET['id_volk'];
    $update = true;
}
$TOKEN = '';
$curl = curl_init();
$headers = array('Authorization: Bearer ' . $TOKEN);
$URL = "http://54.232.19.198/gabriel/admin/api/v2/router.php";
$URLAuth = $URL . "?action=authToken&email=volklms%40evolke.com.br&senha=volklmsdesafio";
curl_setopt($curl, CURLOPT_URL, $URLAuth);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($curl);
curl_close($curl);

if ($response) {

    $db = new DB();
    $processo = $db->find($idProcesso);
    $idPessoa = $processo->getPessoa()->getId();
    $idUnidade = $processo->getUnidade()->getId();
    $idStatus = $processo->getStatus();

    $response = json_decode($response, true);
    $TOKEN = $response['result']['access_token'];
    $curlNew = curl_init();
    $headers = array('Authorization: Bearer ' . $TOKEN);
    curl_setopt($curlNew, CURLOPT_HTTPHEADER, $headers);

    if (!$update) {
        curl_setopt(
            $curlNew,
            CURLOPT_URL, $URL . '?action=newQueue&acao_fila=7&id_pessoa=' . $idPessoa . '&' .
            'id_unidade=' . $idUnidade . '&status=' . $idStatus
        );
    } else {
        curl_setopt(
            $curlNew,
            CURLOPT_URL, $URL . '?action=updateQueue&id_fila=' . $idVolk . '&status=' . $idStatus
        );
    }

    curl_setopt($curlNew, CURLOPT_RETURNTRANSFER, 1);
    $newResult = curl_exec($curlNew);
    if ($newResult) {
        $newResult = json_decode($newResult, true);
        if($update && $newResult['error'] == ''){
            echo json_encode($newResult);
            exit(0);
        }
        $idFila = $newResult['result']['id_fila'];

        /**
         * saber se o registro foi gerado com sucesso
         */
        curl_setopt($curlNew, CURLOPT_URL, $URL . '?action=getQueue&id_fila=' . $idFila);
        $queue = curl_exec($curlNew);
        if ($queue) {
            $queue = json_decode($queue, true);
            if (isset($queue['result']['data'][0]['id']) && isset($queue['result']['data'][0]['id']) == $idFila) {
                $processo->setIdVolk($idFila);
                $db->save($processo);
                echo json_encode(array('id_fila' => $idFila, $queue));
                exit(0);
            }
        }
    }
}
header('HTTP/1.0 400 Bad Request', true, 400);