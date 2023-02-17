<?php
$page = '';
if (isset($_GET["page"])) {
  $page = $_GET["page"];
} else {
  $page = 1;
}

$start_from = ($page - 1) * RECORD_PER_PAGE;

// $query = "SELECT * FROM alumnos order by alumno_id DESC LIMIT $start_from, $record_per_page";
$result = [];

?>

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
    /** @var Processo $processo */
    foreach ($result as $key => $processo) {
      ?>
      
      <?php
    }
    ?>
  
</table>
<div align="center">
  <br />
  <?php
  $total_pages = ceil($total_records / RECORD_PER_PAGE);
  $start_loop = $page;
  $diferencia = $total_pages - $page;
  if ($diferencia <= 5) {
    $start_loop = $total_pages - 5;
  }
  $end_loop = ($start_loop + 4) > $total_pages ? ($start_loop + 4) : $total_pages;
  if ($page > 1) {
    echo "<a class='pagina' href='pagina.php?pagina=1'>Primera</a>";
    echo "<a class='pagina' href='pagina.php?pagina=" . ($page - 1) . "'><<</a>";
  }
  for ($i = $start_loop; $i <= $end_loop; $i++) {
    echo "<a class='pagina' href='pagina.php?pagina=" . $i . "'>" . $i . "</a>";
  }
  if ($page <= $end_loop) {
    echo "<a class='pagina' href='pagina.php?pagina=" . ($page + 1) . "'>>></a>";
    echo "<a class='pagina' href='pagina.php?pagina=" . $total_pages . "'>Última</a>";
  }


  ?>