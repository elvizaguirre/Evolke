<?php

require dirname(__FILE__) . '/includes/init.php';
require dirname(__FILE__) . '/views/base.php';

$filename = basename($_SERVER['PHP_SELF']);

$urlArray = getUrl($filename);
$query = $urlArray[0];
$filters = $urlArray[1];
$baseUrl = $urlArray[2];

$db = new DB();
if (isset($_GET["delete"])) {
   $db->delete($_GET["delete"]);
}

$filter = null;
if (isset($_GET["inpFiltro"])) {
    $filter = $_GET["inpFiltro"];
}

$total_records = $db->count($filter);
$page = '';
$total_pages = ceil($total_records / RECORD_PER_PAGE);

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$page = ($page > $total_pages) ? $total_pages : $page;

if (isset($_GET["delete"])) {
    // Delete el ke sea
    header('Location:' . $baseUrl . 'index.php?' . $filters . '&page=' . $page, true, 302);
    exit(0);
}

$list = $db->list($page, $filter);


?>

<div class="row">
    <div class="col">
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><span>Administraçao</span></li>
                        <li class="breadcrumb-item" aria-current="page">Fila de processos</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="#" method="get">
                    <div class="row">
                        <label class="col-1 col-form-label" for="inpFiltro">Filtro:</label>
                        <div class="col-9">
                            <input type="text" name="inpFiltro" id="inpFiltro" class="form-control"
                                value="<?= $filter ?>"
                                placeholder="Informe o nome ou código de processo" />
                        </div>
                        <div class="col-2">
                            <button class="btn btn-success rounded-0 ps-5 pe-5 float-end">Ok</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col float-end">
                <a class="btn btn-success rounded-0 float-end" href="edit.php?id=new">Novo processo</a>
            </div>
        </div>
        <?php
        if (count($list)) {
            ?>
            <div class="row mt-5">
                <div class="col-12">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nome</th>
                                <th>Pessoa</th>
                                <th>Unidade</th>
                                <th>Status</th>
                                <th>Data Criaçao</th>
                                <th>Data Modificaçao</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($list as $processo) {
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $processo->getId(); ?>
                                    </td>
                                    <td>
                                        <?php echo $processo->getName(); ?>
                                    </td>
                                    <td>
                                        <?php echo $processo->getPessoa()->getName(); ?>
                                    </td>
                                    <td>
                                        <?php echo $processo->getUnidade()->getName(); ?>
                                    </td>
                                    <td>
                                        <?= $status[$processo->getStatus()] ?>
                                    </td>
                                    <td>
                                        <?= $processo->getCreatedDate()->format('Y-m-d H:i:s') ?>
                                    </td>
                                    <td>
                                        <?= $processo->getModifiedDate()->format('Y-m-d H:i:s') ?>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-magnifying-glass"
                                            onclick="editProcess(<?= $processo->getId() ?>)"></i>
                                        <i class="ms-2 fa-sharp fa-solid fa-xmark"
                                            onclick="deleteProcess(<?= $processo->getId() ?>)"></i>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Codigo</th>
                                <th>Nome</th>
                                <th>Pessoa</th>
                                <th>Unidade</th>
                                <th>Status</th>
                                <th>Data Criaçao</th>
                                <th>Data Modificaçao</th>
                                <th>Opções</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row mt-5 align-rigth">
                <div class="col float-end">
                    <div class="float-end">
                        <div id="pagination" class="pagination float-end"></div>
                    </div>
                </div>
            </div>
        <?php
        } else {
            ?>
            <div>
                No hay registros para mostrar
            </div>
        <?php
        }
        ?>
    </div>
</div>
</div>

<script type='text/javascript'>

    function editProcess(id)
    {
        window.location = '<?= $baseUrl . 'edit.php?id=' ?>' + id;
    }

    function deleteProcess(id)
    {
        if (confirm('Tem certeza de que deseja excluir este processo?')) {
            window.location = '<?= $baseUrl . 'index.php?' . $filters . '&page=' . $page . '&delete=' ?>' + id;
        }
    }
    // init bootpag
    var options = {
        alignment: 'right',
        totalPages: <?php echo $total_pages ?>,
        bootstrapMajorVersion: 1,
        currentPage: <?= $page ?>,
        itemContainerClass: function (type, page, current) {
            if ((type == 'first' || type == 'prev') && current === 1) {
                return 'page-link disabled';
            }
            if ((type == 'last' || type == 'next') && current === <?php echo $total_pages ?>) {
                return 'page-link disabled';
            }
            if (type === 'first' || type === 'prev' || type === 'next' || type === 'last') {
                return 'page-link ';
            }
            return 'page-link ' + ((page === current) ? "active" : "");
        },
        itemTexts: function (type, page, current) {
            switch (type) {
                case "first":
                    return "Primeira";
                case "prev":
                    return "Anterior";
                case "next":
                    return "Próxima";
                case "last":
                    return "Último";
                case "page":
                    return page;
            }
        },
        shouldShowPage: function (type, page, current) {
            switch (type) {
                case "first":
                case "last":
                    return true;
                default:
                    return true;
            }
        },
        onPageClicked: function (e, originalEvent, type, page) {
            window.location = '<?= $baseUrl . 'index.php?' . $filters . '&page=' ?>' + page;
        }
    }
    $('#pagination').bootstrapPaginator(options);
</script>
</body>

</html>