<?php 
    $classBody ="newgroup"; 
    include "includes/header.php";
    $grupo = $a->getGrupos($_GET['id']);
    $post_json = json_encode($grupo->children, true);
    $post_json_escaped = htmlspecialchars($post_json, ENT_QUOTES, 'UTF-8');
?>
<main data-children="<?=$post_json_escaped?>" data-groupid="<?=$grupo->id?>" data-acuarelauser="<?=$grupo->acuarelauser->id?>" data-edades="<?=$grupo->age_range?>">
    <form action="s/editGroup/" method="POST" id="editGroup">
        <?php
            $mainHeaderTitle = '<input type="text" class="big" name="name" id="name" placeholder="Nombre del grupo" value="'. $grupo->name.'">' ;
            $action = '<button type="submit" class="btn btn-action-primary enfasis btn-big">Guardar cambios</button>';
            include "templates/sectionHeader.php";
        ?>

        <div class="content">
            <fieldset>
                <h2>Información</h2>
                <span>
                    <label for="acuarelauser">Líder de grupo</label>
                    <select name="acuarelauser" id="acuarelauser"><option value="">Selecciona un Asistente</option></select>
                </span>
                <span>
                    <label for="edades">Edades</label>
                    <select name="edades" id="edades"><option value="">Selecciona un grupo de edad</option></select>
                </span>
                <span>
                    <label for="shift">Horario</label>
                    <input type="text" name="shift" id="shift" value="<?=$grupo->shift?>" />
                </span>
            </fieldset>
            <fieldset>
                <h2>Integrantes</h2>
                <ul class="children">
                </ul>
            </fieldset>
        </div>
        <input type="hidden" name="id" id="id" value="<?=$grupo->id?>" />
    </form>
</main>
<?php include "includes/footer.php" ?>