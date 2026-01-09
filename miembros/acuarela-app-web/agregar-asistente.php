<?php $classBody ="newasistente"; include "includes/header.php"; ?>
<main>
    <form action="s/addAsistente/" id="createAsistente" method="POST">
        <?php
            $mainHeaderTitle = 'Agregar Asistente' ;
            $action = '<button type="submit" class="btn btn-action-primary enfasis btn-big">Guardar cambios</button>';
            include "templates/sectionHeader.php";
            
        ?>
        <div class="content">
            <fieldset>

                <span>
                    <i class="acuarela acuarela-Usuario"></i>
                    <label for="name">Nombres</label>
                    <input type="text" name="nombres" id="nombres">
                     <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Usuario"></i>
                    <label for="name">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos">
                     <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Mensajes"></i>
                    <label for="name">E-mail</label>
                    <input type="text" name="email" id="email">
                     <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Evento"></i>
                    <span class="calendar">
                        <label for="name">Fecha de nacimiento</label>
                        <input type="date" name="fecha-de-nacimiento" id="fecha-de-nacimiento" />
                         <span class="error-message"></span>
                    </span>
                     <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Nivel_educativo"></i>
                    <label for="name">Nivel educativo</label>
                    <select name="nivel-educativo" id="nivel-educativo">
                        <option value="Primaria">Primaria</option>
                        <option value="high school">high school</option>
                        <option value="CDA">CDA</option>
                        <option value="Some College">Some College</option>
                        <option value="associate degree">associate degree</option>
                        <option value="Bachelor degree">Bachelor degree</option>
                        <option value="Master degree">Master degree</option>
                        <option value="Other">Other</option>
                    </select>
                     <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Telefono"></i>
                    <label for="name">Teléfono</label>
                    <input type="text" name="telefono" id="telefono">
                     <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Casa"></i>
                    <label for="name">Calle</label>
                    <input type="text" name="calle" id="calle">
                     <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Localizacion"></i>
                    <label for="name">Depto/Unidad</label>
                    <input type="text" name="depto-unidad" id="depto-unidad">
                     <span class="error-message"></span>
                </span>
            
                <span>
                    <i class="acuarela acuarela-Localizacion"></i>
                    <label for="name">Ciudad</label>
                    <input type="text" name="ciudad" id="ciudad">
                     <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Localizacion"></i>
                    <label for="name">Estado</label>
                    <select name="estado" id="estado"></select>
                     <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Localizacion"></i>
                    <label for="name">Código postal</label>
                    <input type="text" name="codigo-postal" id="codigo-postal">
                     <span class="error-message"></span>
                </span>
               
            </fieldset>
            <div class="wrapper photo">
                <input type="file" id="photo" accept="image/png, image/jpeg" />
                <label for="photo"><i class="acuarela acuarela-Camara"></i></label>
                <input type="hidden" name="photoID" id="photoID">
            </div>
        </div>
    </form>
</main>
<?php include "includes/footer.php" ?>