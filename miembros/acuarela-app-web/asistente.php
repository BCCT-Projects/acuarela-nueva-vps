<?php $classBody ="asistente"; include "includes/header.php"; $asistente = $a->getAsistentes($_GET['id']); ?>
<main>
    <?php
    $mainHeaderTitle = '<a href="/miembros/acuarela-app-web/asistentes" ><i class="acuarela acuarela-Flecha_izquierda"></i></a>'."{$asistente->name} {$asistente->lastname}" ;
    $action = '<button type="button" onclick="openEditAsistente()" class="btn btn-action-primary enfasis btn-big">Editar Perfil</button>';
    include "templates/sectionHeader.php";
    // Crea un objeto DateTime desde la cadena ISO 8601
    $birthdate = new DateTime($asistente->birthdate);
    // Formatea la fecha al formato MM-DD-YYYY
    $birthdate_formateada = $birthdate->format('m-d-Y');
    // Crea un objeto DateTime desde la cadena ISO 8601
    $published_at = new DateTime($asistente->published_at);
    // Formatea la fecha al formato MM-DD-YYYY
    $published_at_formateada = $published_at->format('m-d-Y');
?>
    <div class="content">
        <div class="basicinfo">
            <div class="txt">
                <p><i class="acuarela acuarela-Evento"></i> <span>Fecha de nacimiento</span> <strong>
                        <?=$birthdate_formateada?>
                    </strong></p>
                <p><i class="acuarela acuarela-Calendario"></i> <span>Inscrito desde</span> <strong>
                        <?=$published_at_formateada?>
                    </strong></p>
                <p><i class="acuarela acuarela-Localizacion"></i> <span>Dirección</span>
                    <strong><?=$asistente->address->complement?> <?=$asistente->address->number?>
                        <?=$asistente->address->street?></strong>
                </p>
                <p><i class="acuarela acuarela-Localizacion"></i> <span>Ciudad</span>
                    <strong><?=$asistente->city?></strong>
                </p>
                <p><i class="acuarela acuarela-Nivel_educativo"></i> <span>Nivel educativo</span>
                    <strong><?=$asistente->study?></strong>
                </p>
                <p><i class="acuarela acuarela-Telefono"></i> <span>Teléfono</span>
                    <strong><?=$asistente->phone?></strong>
                </p>
                <p><i class="acuarela acuarela-Mensajes"></i> <span>E-mail</span> <strong><?=$asistente->mail?></strong>
                </p>
            </div>
            <div class="photo">
                <img loading="lazy" class="lazyload" src="img/placeholder.png"
                    data-src="<?=isset($asistente->photo) ? $a->getSmallestImageUrl($asistente->photo) : "img/placeholder.png"?>"
                    alt="<?=$asistente->photo->url?>">
            </div>
        </div>

    </div>
</main>
<div id="editasistente-lightbox" class="lightbox">
    <div class="lightbox-content">
        <h3 id="editasistente-lightbox-subtitle">Editar asistente</h3>
        <form action="s/editAsistente/" id="editAsistente" method="POSt">
            <fieldset>
            <div class="wrapper photo">
                <input type="file" id="photo" accept="image/png, image/jpeg" />
                <label for="photo" style="background-image: url(<?=$a->getSmallestImageUrl($asistente->photo)?>);"><i class="acuarela acuarela-Camara"></i></label>
                <input type="hidden" name="photoID" id="photoID" value="<?=$asistente->photo->id?>">
            </div>
                <span>
                    <i class="acuarela acuarela-Usuario"></i>
                    <label for="name">Nombres</label>
                    <input type="text" name="nombres" id="nombres" value="<?=$asistente->name ?>" >
                    <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Usuario"></i>
                    <label for="name">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" value="<?=$asistente->lastname?>" >
                    <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Evento"></i>
                    <span class="calendar">
                        <label for="name">Fecha de nacimiento</label>
                        <input type="date" name="fecha-de-nacimiento" id="fecha-de-nacimiento"  value="<?=$asistente->birthdate?>" />
                        <span class="error-message"></span>
                    </span>
                    <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Nivel_educativo"></i>
                    <label for="name">Nivel educativo</label>
                    <select name="nivel-educativo" id="nivel-educativo" >
                        <option <?=$asistente->study == 'Primaria'?'selected':''?> value="Primaria">Primaria</option>
                        <option <?=$asistente->study == 'high school'?'selected':''?> value="high school">high school</option>
                        <option <?=$asistente->study == 'CDA'?'selected':''?> value="CDA">CDA</option>
                        <option <?=$asistente->study == 'Some College'?'selected':''?> value="Some College">Some College</option>
                        <option <?=$asistente->study == 'associate degree'?'selected':''?> value="associate degree">associate degree</option>
                        <option <?=$asistente->study == 'Bachelor degree'?'selected':''?> value="Bachelor degree">Bachelor degree</option>
                        <option <?=$asistente->study == 'Master degree'?'selected':''?> value="Master degree">Master degree</option>
                        <option <?=$asistente->study == 'Other'?'selected':''?> value="Other">Other</option>
                    </select>
                    <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Telefono"></i>
                    <label for="name">Teléfono</label>
                    <input type="text" name="telefono" id="telefono"  value="<?=$asistente->phone?>">
                    <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Casa"></i>
                    <label for="name">Calle</label>
                    <input type="text" name="calle" id="calle" value="<?=$asistente->address->street?>">
                    <span class="error-message"></span>
                </span>
                <span>
                    <i class="acuarela acuarela-Localizacion"></i>
                    <label for="name">Depto/Unidad</label>
                    <input type="text" name="depto-unidad" id="depto-unidad" value="<?=$asistente->address->number?>">
                    <span class="error-message"></span>
                </span>

                <span>
                    <i class="acuarela acuarela-Localizacion"></i>
                    <label for="name">Ciudad</label>
                    <input type="text" name="ciudad" id="ciudad" value="<?=$asistente->city?>" >
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
                    <input type="text" name="codigo-postal" id="codigo-postal" value="<?=$asistente->zipcode?>">
                    <span class="error-message"></span>
                </span>

            </fieldset>
            <input type="hidden" name="id" id="id" value="<?=$asistente->id?>">
            <div class="actions">
                <button type="submit" id="confirm-button"
                    class="lightbox-button btn btn-action-primary enfasis btn-big">Actualizar</button>
            </div>
        </form>
        <button id="editasistente-close-button" class="lightbox-button close-button"><svg width="32" height="32" viewBox="0 0 32 32"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="16" cy="16" r="15.5" stroke="#E1E4E9" />
                <g clip-path="url(#clip0_1_41059)">
                    <path
                        d="M23.3796 20.3855L18.9948 16.0006L23.3796 11.6157C24.2066 10.7888 24.2066 9.44797 23.3796 8.62104C22.5527 7.79411 21.2119 7.79411 20.385 8.62104L15.9997 13.0059L11.6149 8.62069C10.7876 7.79376 9.44677 7.79376 8.6202 8.62069C7.79327 9.44797 7.79327 10.7888 8.6202 11.6153L13.0054 16.0002L8.6202 20.3851C7.79327 21.2124 7.79327 22.5532 8.6202 23.3798C9.03419 23.7934 9.57559 23.9999 10.1177 23.9999C10.6595 23.9999 11.2016 23.7931 11.6152 23.3798L15.9997 18.9952L20.385 23.3801C20.799 23.7934 21.3404 24.0002 21.8825 24.0002C22.4246 24.0002 22.9663 23.7934 23.38 23.3801C24.2066 22.5532 24.2066 21.2127 23.3796 20.3855Z"
                        fill="#98A2B7" />
                </g>
                <defs>
                    <clipPath id="clip0_1_41059">
                        <rect width="16" height="16" fill="white" transform="translate(8 8)" />
                    </clipPath>
                </defs>
            </svg></button>
    </div>
</div>
<?php include "includes/footer.php" ?>