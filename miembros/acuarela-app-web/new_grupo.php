<?php $classBody ="newgroup"; include "includes/header.php"; ?>
<main >
    <form action="s/createGroup/" method="POST" id="createGroup">
        <?php
            $mainHeaderTitle = '<span><input type="text" class="big" name="name" id="name" placeholder="Nombre del grupo"><span class="error-message"></span></span>' ;
            $action = '<button type="submit" class="btn btn-action-primary enfasis btn-big">Guardar cambios</button>';
            include "templates/sectionHeader.php";
        ?>

        <div class="content">
            <fieldset>
                <h2>Información</h2>
                <span>
                    <label for="acuarelauser">Líder de grupo</label>
                    <select name="acuarelauser" id="acuarelauser"><option value="">Selecciona un Asistente</option></select>
                    <span class="error-message"></span>
                </span>
                <span>
                    <label for="edades">Edades</label>
                    <select name="edades" id="edades"><option value="">Selecciona un grupo de edad</option></select>
                    <span class="error-message"></span>
                </span>
                <span>
                    <label for="shift">Horario</label>
                    <input type="text" name="shift" id="shift" />
                    <span class="error-message"></span>
                </span>
            </fieldset>
            <fieldset>
                <h2>Integrantes</h2>
                <ul class="children">
                </ul>
            </fieldset>
        </div>
    </form>
</main>
<?php include "includes/footer.php" ?>