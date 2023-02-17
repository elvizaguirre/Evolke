<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
require dirname(__FILE__) . '/includes/init.php';

$filename = basename($_SERVER['PHP_SELF']);
$baseUrl = getUrl($filename)[2];
$db = new DB();
$isNew = true;
$valNome = '';
$idVolk = '';
$idProcesso = $valPessoa = $valUnidade = $valStatus = 0;

if (
    isset($_POST['inpId']) && isset($_POST['inpStatus'])
) {
    $idProcesso = isset($_POST['inpId']) ? $_POST['inpId'] : null;
    $valNome = isset($_POST['inpNome']) ? $_POST['inpNome'] : '';
    $valPessoa = isset($_POST['inpPessoa']) ? $_POST['inpPessoa'] : null;
    $valUnidade = isset($_POST['inpUnidade']) ? $_POST['inpUnidade'] : null;
    $valStatus = isset($_POST['inpStatus']) ? $_POST['inpStatus'] : null;

    if ($_POST['inpId'] == 'new') {
        $processo = new Processo();
        $processo->setId(0);
        $unidade = new Unidade();
        $unidade->setId($valUnidade);
        $pessoa = new Pessoa();
        $pessoa->setId($valPessoa);
        $processo->setName($valNome);
        $processo->setUnidade($unidade);
        $processo->setPessoa($pessoa);
    } else {
        $processo = $db->find($idProcesso);
    }
    if ($valStatus != $processo->getStatus()
    ) {
        $processo->setStatus($valStatus);
        $processo->setModifiedDate(new DateTime());
        $db->save($processo);
    } 

    header('Location:' . $baseUrl . 'index.php', true, 302);
}


$pessoas = $db->listPessoas();
$unidades = $db->listUnidades();

if (isset($_GET['id']) && $_GET['id'] != 'new') {
    $isNew = false;
    $idProcesso = $_GET['id'];
    $processo = $db->find($idProcesso);
    if ($processo) {
        $valNome = $processo->getName();
        $idProcesso = $processo->getId();
        $valPessoa = $processo->getPessoa()->getId();
        $valUnidade = $processo->getUnidade()->getId();
        $valStatus = $processo->getStatus();
        $idVolk = $processo->getIdVolk();
    } else {
        header('Location:' . $baseUrl . $filename . '?id=new', true, 302);
        exit();
    }
}

require dirname(__FILE__) . '/views/base.php';
?>
<div class="row">
    <div class="col">
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><span>Administraçao</span></li>
                        <li class="breadcrumb-item active"><span>Integrações</span></li>
                        <li class="breadcrumb-item" aria-current="page">Cadastro</li>
                    </ol>
                </nav>
            </div>
        </div>
        <?php
        if (!$isNew) {
            ?>
            <div class="row mt-5">
                <div class="col float-end">
                    <button class="btn btn-success rounded-0 float-end" onclick="integrateVolk(<?= $processo->getId() ?>)">Integrar com VolkLMS</button>
                </div>
            </div>
        <?php } ?>
        <div class="row mt-4">
            <form action="#" method="post" onsubmit="return validate()">
                <input type="hidden" name="inpId" value="<?= $isNew ? "new" : $idProcesso ?>" />
                <div class="row">
                    <div class="col">
                        <div class="col d-flex"
                            style="border-style: dotted; border-width: 0.2em 0 0 0; border-color: #b7b7b7; padding: 0.2em 0;">
                            <div class="col-2  d-flex">
                                <label class="align-self-center" for="inpNome"><span
                                        class="text-danger">*</span>NOME</label>
                            </div>
                            <div class="col-5 align-middle">
                                <input type="text" name="inpNome" id="inpNome" class="form-control"
                                    value="<?= $valNome ?>"  <?= $isNew ? '' : ' disabled ' ?>/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="col d-flex"
                            style="border-style: dotted; border-width: 0.2em 0 0 0; border-color: #b7b7b7; padding: 0.2em 0;">
                            <div class="col-2  d-flex">
                                <label class="align-self-center" for="inpPessoa"><span
                                        class="text-danger">*</span>PESSOAS</label>
                            </div>
                            <div class="col-5 align-middle">
                                <select name="inpPessoa" id="inpPessoa" class="form-select" <?= $isNew ? '' : ' disabled ' ?>>
                                    <?php
                                    if ($isNew) {
                                        echo '<option value="0" selected disabled>Selecione uma pessoa</option>';
                                    }
                                    /** @var Pessoa $pessoa */
                                    foreach ($pessoas as $pessoa) {
                                        $option = '<option value="' . $pessoa->getId() . '" ';
                                        $option .= (!$isNew && $valPessoa == $pessoa->getId() ? ' selected ' : '');
                                        $option .= '>';
                                        echo $option . $pessoa->getName() . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="col d-flex"
                            style="border-style: dotted; border-width: 0.2em 0 0 0; border-color: #b7b7b7; padding: 0.2em 0;">
                            <div class="col-2  d-flex">
                                <label class="align-self-center" for="inpUnidade"><span
                                        class="text-danger">*</span>UNIDADES</label>
                            </div>
                            <div class="col-5 align-middle">
                                <select name="inpUnidade" id="inpUnidade" class="form-select"
                                    value="<?= $valUnidade ?>" <?= $isNew ? '' : ' disabled ' ?>>
                                    <?php
                                    if ($isNew) {
                                        echo '<option value="0" selected disabled>Selecione uma unidade</option>';
                                    }
                                    /** @var Unidade $unidade */
                                    foreach ($unidades as $unidade) {
                                        $option = '<option value="' . $unidade->getId() . '" ';
                                        $option .= (!$isNew && $valUnidade == $unidade->getId() ? ' selected ' : '');
                                        $option .= '>';
                                        echo $option . $unidade->getName() . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="col d-flex"
                            style="border-style: dotted; border-width: 0.2em 0 0.2em 0; border-color: #b7b7b7; padding: 0.2em 0;">
                            <div class="col-2  d-flex">
                                <label class="align-self-center" for="inpStatus"><span
                                        class="text-danger">*</span>STATUS</label>
                            </div>
                            <div class="col-5 align-middle">
                                <select name="inpStatus" id="inpStatus" class="form-select" value="<?= $valStatus ?>">
                                    <?php
                                    if ($isNew) {
                                        echo '<option value="0" selected disabled>Selecione o status</option>';
                                    }
                                    foreach ($status as $key => $value) {
                                        $option = '<option value="' . $key . '" ';
                                        $option .= (!$isNew && $valStatus == $key ? ' selected ' : '');
                                        $option .= '>';
                                        echo $option . $value . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <div class="col-12 border-top border-bottom ps-2 pt-2 pb-2" style="background-color: #b7b7b7;">
                            <div class="col-12">
                                <button class="btn btn-success rounded-0" type="submit">Gravar</button>
                                <a href="edit.php?id=new" class="btn btn-primary rounded-0 ms-2">Novo</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function validate()
    {
        const nome = document.getElementById('inpNome').value;
        const pessoa = document.getElementById('inpPessoa').value;
        const unidade = document.getElementById('inpUnidade').value;
        const status = document.getElementById('inpStatus').value;
        if (!nome || nome === '') {
            alert('Indique um nome válido');
            return false;
        }
        if (!pessoa || pessoa <= 0) {
            alert('Selecione uma pessoa válida');
            return false;
        }
        if (!unidade || unidade <= 0) {
            alert('Selecione uma unidade válida');
            return false;
        }
        if (!status || status <= 0 || status > <?=(count($status) + 1) ?>) {
            alert('Status inválido');
            return false;
        }
        return true;
    }

    <?php 
    if (!$isNew) {
    ?>
    function integrateVolk(id)
    {
        $.ajax({
            url: "<?= $baseUrl ?>integrate.php",
            type: "GET",
            headers: {
                'Authorization': "Bearer " + '',
            },
            data: {
                id_processo: <?= $idProcesso ?>,
                id_volk: <?= $idVolk ? $idVolk : 0 ?>,
            },
            success: function (data) {
                alert('Integrado com sucesso');
            },
            error: function(data){
                alert("Algum erro ocorreu, consulte o log.");
            },
            complete: function(){
                console.log("COMPLETED");
            }
        });
    }
    <?php 
    }
    ?>
</script>