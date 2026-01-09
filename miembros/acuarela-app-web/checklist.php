<?php $classBody ="checklist"; include "includes/header.php";  ?>

<main>
    <?php
    $mainHeaderTitle = 'Administrador de Tareas' ;
    $action = '<button onclick="showDialogForm()" data-fancybox data-src="#createTask" class="btn btn-action-primary enfasis btn-big">Crear nueva tarea</button>';
    include "templates/sectionHeader.php";
    ?>


<div class="navtabs">
        <div class="navtab active" data-target="hoy">Vencen hoy</div>
        <div class="navtab" data-target="atrasadas">Atrasadas</div>
        <div class="navtab" data-target="todas">Todas</div>
        <div class="underline"></div>
    </div>
    <div class="content">
    <div id="hoy" class="tab-content active">


        <ul class="taskList">

        </ul>
    </div>
    <div id="atrasadas" class="tab-content ">
        <ul class="taskList">

        </ul>
    </div>
    <div id="todas" class="tab-content ">
        <ul class="taskList">

        </ul>
    </div>
    </div>
</main>
<div id="createTask" style="    max-width: 500px;
    width: 100%;
    padding: 20px;
    height: 100%;">
  <div class="lightbox-content">
    <h2 id="info-lightbox-title">Nueva Tarea</h2>
    <form id="taskForm">
      <span>
        <label for="name">Nombre de la tarea</label>
        <input type="text" name="name" id="name" required />
      </span>
      <span>
        <span class="calendar">
          <label for="date">Fecha de la tarea</label>
          <input type="date" name="date" id="date" required />
          <span class="error-message"></span>
        </span>
      </span>
      <span>
        <label for="acuarelauser">Asignado a</label>
        <select name="acuarelauser" id="acuarelauser" required>
          <option value="">Seleccionar asistente</option>
          <option value="67a51a64fe53cc27d3c5f54e">Asistente</option>
        </select>
      </span>
      <span>
        <label for="commentarios">Comentarios</label>
        <textarea name="commentarios" id="commentarios"></textarea>
      </span>
      <input type="hidden" id="daycare" name="daycare" value="<?= $a->daycareID ?>">
      <button type="submit" class="btn btn-action-primary enfasis btn-big">Crear Tarea</button>
    </form>
  </div>
</div>

<?php include "includes/footer.php" ?>