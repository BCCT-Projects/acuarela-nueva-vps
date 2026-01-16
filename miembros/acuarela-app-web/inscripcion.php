<?php
$classBody = "inscripcion";
include "includes/header.php";
$inscripcion = isset($_GET['id']) ? $a->getInscripciones($_GET['id']) : "";
?>
<main>
  <?php
  $mainHeaderTitle = "Agregar Niñx";
  $action = '<button class="btn btn-action-primary enfasis btn-big" onclick="handleInscripcion()">Guardar Borrador</button>';
  include "templates/sectionHeader.php";
  ?>
  <div class="navtabs">
    <div class="navtab active" data-index="0" data-target="basica">Información básica</div>
    <div class="navtab" data-index="1" data-target="familia">Familia</div>
    <div class="navtab" data-index="2" data-target="pagos">Horarios y pagos</div>
    <div class="navtab" data-index="3" data-target="adjuntos">Adjuntos</div>

    <div class="navtab" data-index="4" data-target="resumen">Resumen</div>
    <div class="underline"></div>
  </div>
  <div class="content">
    <form action="s/createInscription/" method="POST" id="inscription" autocomplete="off">
      <div class="formHeader">
        <strong>
          Has completado el <span class="percentage">
            <?= $inscripcion != "" ? $inscripcion->percentaje : "0" ?>%
          </span> de la inscripción
          mínima de <span class="name"></span>
        </strong>
        <button type="button" id="next" class="btn btn-action-secondary btn-big enfasis">
          Siguiente
        </button>
      </div>
      <div id="basica" class="tab-content active">
        <span>
          <i class="acuarela acuarela-Usuario"></i>
          <label for="name">Nombre</label>
          <input type="text" name="name" id="name" / value="<?= $inscripcion != "" ? $inscripcion->name : "" ?>"
            required
            oninput="changeValuesForMultipleContainers(event, {'span.name': ' {value}', '#resname strong': '{value}'})">
        </span>
        <span>
          <i class="acuarela acuarela-Usuario"></i>
          <label for="lastname">Apellidos</label>
          <input type="text" name="lastname" id="lastname" /
            value="<?= $inscripcion != "" ? $inscripcion->lastname : "" ?>" required>
        </span>
        <div class="row">
          <span class="calendar">
            <i class="acuarela acuarela-Calendario"></i>
            <label for="birthdate">Fecha de nacimiento</label>
            <input type="date" name="birthdate" id="birthdate"
              value="<?= $inscripcion ? date('Y-m-d', strtotime($inscripcion->birthdate)) : '' ?>" required
              data-selectors='{"#resbirthday strong": "{value}"}' />
          </span>
          <span>
            <i class="acuarela acuarela-Nino"></i>
            <label for="genero">Género</label>
            <select name="genero" id="genero" <?= $inscripcion != "" ? $inscripcion->gender : "" ?>
              onchange="changeValuesForMultipleContainers(event, {'#resgender strong': '{value}'})">
              <option <?= $inscripcion != "" && $inscripcion->gender == "Masculino" ? "selected" : "" ?> value="Masculino">
                Masculino</option>
              <option <?= $inscripcion != "" && $inscripcion->gender == "Femenino" ? "selected" : "" ?> value="Femenino">
                Femenino</option>
              <option <?= $inscripcion != "" && $inscripcion->gender == "X" ? "selected" : "" ?> value="X">X</option>
            </select>
          </span>
        </div>
      </div>
      <div id="familia" class="tab-content">
        <section class="splide" id="family" aria-label="Splide Basic HTML Example">
          <h2>Información de padres</h2>
          <div class="splide__track">
            <ul class="splide__list">
              <li class="splide__slide">
                <fieldset>
                  <h4>Padre 1</h4>
                  <span>
                    <i class="acuarela acuarela-Familia"></i>
                    <label for="parent_type1">Parentesco</label>
                    <select name="parent_type1" id="parent_type1"
                      onchange="changeValuesForMultipleContainers(event, {'#resparenttype strong': '{value}'})">
                      <option value="Mamá">Mamá</option>
                      <option value="Papá">Papá</option>
                    </select>
                  </span>
                  <span>
                    <i class="acuarela acuarela-Mensajes"></i>
                    <label for="parent_email1">Correo Electrónico</label>
                    <input type="email" autocomplete="off" name="parent_email1" id="parent_email1"
                      onchange="handleEmailChange(event, 1); this.value = this.value.toLowerCase(); changeValuesForMultipleContainers(event, { '#resparentmail strong': '{value}'})"
                      onblur="this.value = this.value.toLowerCase()"
                      oninput="changeValuesForMultipleContainers(event, { '#resparentmail strong': '{value}'})"
                      value="<?= $inscripcion != "" ? $inscripcion->parents[0]->email : "" ?>" required />
                  </span>
                  <span>
                    <i class="acuarela acuarela-Usuario"></i>
                    <label for="parent_name1">Nombres</label>
                    <input type="text" autocomplete="off" name="parent_name1" id="parent_name1"
                      value="<?= $inscripcion != "" ? $inscripcion->parents[0]->name : "" ?>" required
                      oninput="changeValuesForMultipleContainers(event, { '#resparentname strong': '{value}'})" />
                  </span>
                  <span>
                    <i class="acuarela acuarela-Usuario"></i>
                    <label for="parent_lastname1">Apellidos</label>
                    <input type="text" autocomplete="off" name="parent_lastname1" id="parent_lastname1"
                      value="<?= $inscripcion != "" ? $inscripcion->parents[0]->lastname : "" ?>" required />
                  </span>
                  <span>
                    <i class="acuarela acuarela-Telefono"></i>
                    <label for="parent_phone1">Celular</label>
                    <input type="text" autocomplete="off" name="parent_phone1" id="parent_phone1"
                      value="<?= $inscripcion != "" ? $inscripcion->parents[0]->phone : "" ?>" required
                      oninput="changeValuesForMultipleContainers(event, { '#resparenttel strong': '{value}'})" />
                  </span>
                </fieldset>
              </li>
              <li class="splide__slide">
                <fieldset>
                  <h4>Padre 2</h4>
                  <span>
                    <i class="acuarela acuarela-Familia"></i>
                    <label for="parent_type2">Parentesco</label>
                    <select name="parent_type2" id="parent_type2">
                      <option value="Mamá">Mamá</option>
                      <option value="Papá">Papá</option>
                    </select>
                  </span>
                  <span>
                    <i class="acuarela acuarela-Mensajes"></i>
                    <label for="parent_email2">Correo Electrónico</label>
                    <input type="email" autocomplete="off" name="parent_email2" id="parent_email2"
                      onchange="handleEmailChange(event, 2); this.value = this.value.toLowerCase()"
                      onblur="this.value = this.value.toLowerCase()"
                      value="<?= $inscripcion != "" ? $inscripcion->parents[1]->email : "" ?>" />
                  </span>
                  <span>
                    <i class="acuarela acuarela-Usuario"></i>
                    <label for="parent_name2">Nombres</label>
                    <input type="text" autocomplete="off" name="parent_name2" id="parent_name2"
                      value="<?= $inscripcion != "" ? $inscripcion->parents[1]->name : "" ?>" />
                  </span>
                  <span>
                    <i class="acuarela acuarela-Usuario"></i>
                    <label for="parent_lastname2">Apellidos</label>
                    <input type="text" autocomplete="off" name="parent_lastname2" id="parent_lastname2"
                      value="<?= $inscripcion != "" ? $inscripcion->parents[1]->lastname : "" ?>" />
                  </span>
                  <span>
                    <i class="acuarela acuarela-Telefono"></i>
                    <label for="parent_phone2">Celular</label>
                    <input type="text" autocomplete="off" name="parent_phone2" id="parent_phone2"
                      value="<?= $inscripcion != "" ? $inscripcion->parents[1]->phone : "" ?>" />
                  </span>
                </fieldset>
              </li>
            </ul>
          </div>
          <div class="splide__arrows splide__arrows--ltr">
            <button class="splide__arrow splide__arrow--prev" type="button" aria-label="Previous slide"
              aria-controls="splide01-track">
              <i class="acuarela acuarela-Flecha_izquierda"></i>
            </button>
            <button class="splide__arrow splide__arrow--next" type="button" aria-label="Next slide"
              aria-controls="splide01-track">
              <i class="acuarela acuarela-Flecha_derecha"></i>
            </button>
          </div>
        </section>
        <section id="responsables-list">
          <h2>Agrega 2 contactos responsables distintos a los padres </h2>
          <div class="responsables">
            <fieldset class="responsables-card">
              <span>
                <i class="acuarela acuarela-"></i>
                <label for="">Parentesco</label>
                <select name="guardian1_relationship" id="parent_type1" onchange="checkOtherOption(this)">
                  <option value="Hermana/o">Hermana/o</option>
                  <option value="Prima/o">Prima/o</option>
                  <option value="Abuela/o">Abuela/o</option>
                  <option value="Tia/o">Tia/o</option>
                  <option value="Otra/o">Otra/o</option>
                </select>
              </span>
              <span class="other_relationship_span" style="display:none;">
                <i class="acuarela acuarela-"></i>
                <label for="other_relationship2">Especifique el parentesco</label>
                <input type="text" name="other_relationship2" />
              </span>
              <span>
                <i class="acuarela acuarela-"></i>
                <label for="">Nombres </label>
                <input type="text" name="guardian1_name" id="guardian1_name"
                  value="<?= $inscripcion != "" ? $inscripcion->guardians[0]->guardian_name : "" ?>" required />
              </span>
              <span>
                <i class="acuarela acuarela-"></i>
                <label for="">Apellidos </label>
                <input type="text" name="guardian1_lastname" id="guardian1_lastname"
                  value="<?= $inscripcion != "" ? $inscripcion->guardians[0]->guardian_lastname : "" ?>" required />
              </span>
              <span>
                <i class="acuarela acuarela-"></i>
                <label for="">Celular</label>
                <input type="text" name="guardian1_phone" id="guardian1_phone"
                  value="<?= $inscripcion != "" ? $inscripcion->guardians[0]->guardian_phone : "" ?>" required />
              </span>
              <span>
                <i class="acuarela acuarela-"></i>
                <label for="">Correo electrónico</label>
                <input type="email" name="guardian1_email" id="guardian1_email"
                  onblur="this.value = this.value.toLowerCase()"
                  value="<?= $inscripcion != "" ? $inscripcion->guardians[0]->guardian_email : "" ?>" required />
              </span>
              <span>
                <div class="cntr-check">
                  <input checked type="checkbox" id="guardian1_emergency" name="guardian1_emergency"
                    class="hidden-xs-up" />
                  <label for="guardian1_emergency" class="cbx"></label>
                  <span> Marcar como contacto de emergencia</span>
                </div>
              </span>
              <span>
                <div class="cntr-check">
                  <input checked type="checkbox" id="guardian1_pickup" name="guardian1_pickup" class="hidden-xs-up" />
                  <label for="guardian1_pickup" class="cbx"></label>
                  <span> Puede entregar o recibir al niño</span>
                </div>
              </span>
            </fieldset>
            <fieldset class="responsables-card">
              <span>
                <i class="acuarela acuarela-"></i>
                <label for="">Parentesco</label>
                <select name="guardian2_relationship" id="parent_type1" onchange="checkOtherOption(this)">
                  <option value="Hermana/o">Hermana/o</option>
                  <option value="Prima/o">Prima/o</option>
                  <option value="Abuela/o">Abuela/o</option>
                  <option value="Tia/o">Tia/o</option>
                  <option value="Otra/o">Otra/o</option>
                </select>
              </span>
              <span class="other_relationship_span" style="display:none;">
                <i class="acuarela acuarela-"></i>
                <label for="other_relationship2">Especifique el parentesco</label>
                <input type="text" name="other_relationship2" />
              </span>
              <span>
                <i class="acuarela acuarela-"></i>
                <label for="">Nombres</label>
                <input type="text" name="guardian2_name" id="guardian2_name"
                  value="<?= $inscripcion != "" ? $inscripcion->guardians[1]->guardian_name : "" ?>" />
              </span>
              <span>
                <i class="acuarela acuarela-"></i>
                <label for="">Apellidos</label>
                <input type="text" name="guardian2_lastname" id="guardian2_lastname"
                  value="<?= $inscripcion != "" ? $inscripcion->guardians[1]->guardian_lastname : "" ?>" />
              </span>
              <span>
                <i class="acuarela acuarela-"></i>
                <label for="">Celular</label>
                <input type="text" name="guardian2_phone" id="guardian2_phone"
                  value="<?= $inscripcion != "" ? $inscripcion->guardians[1]->guardian_phone : "" ?>" />
              </span>
              <span>
                <i class="acuarela acuarela-"></i>
                <label for="">Correo electrónico</label>
                <input type="email" name="guardian2_email" id="guardian2_email"
                  onblur="this.value = this.value.toLowerCase()"
                  value="<?= $inscripcion != "" ? $inscripcion->guardians[1]->guardian_email : "" ?>" />
              </span>
              <span>
                <div class="cntr-check">
                  <input type="checkbox" id="guardian2_emergency" name="guardian2_emergency" class="hidden-xs-up" />
                  <label for="guardian2_emergency" class="cbx"></label>
                  <span> Marcar como contacto de emergencia</span>
                </div>
              </span>
              <span>
                <div class="cntr-check">
                  <input type="checkbox" id="guardian2_pickup" name="guardian2_pickup" class="hidden-xs-up" />
                  <label for="guardian2_pickup" class="cbx"></label>
                  <span> Puede entregar o recibir al niño</span>
                </div>
              </span>
            </fieldset>
          </div>
        </section>
      </div>
      <div id="pagos" class="tab-content">
        <span>
          <i class="acuarela acuarela-Nino"></i>
          <label for="paymentTime">Cada cuánto se cobra:</label>
          <select name="paymentTime" id="paymentTime">
            <option <?= $inscripcion != "" && $inscripcion->payment->time == "Hora" ? "selected" : "" ?> value="Hora">Hora
            </option>
            <option <?= $inscripcion != "" && $inscripcion->payment->time == "Diario" ? "selected" : "" ?> value="Diario">
              Diario</option>
            <option <?= $inscripcion != "" && $inscripcion->payment->time == "Semanal" ? "selected" : "" ?> value="Semanal">
              Semanal</option>
            <option <?= $inscripcion != "" && $inscripcion->payment->time == "Mensual" ? "selected" : "" ?> value="Mensual">
              Mensual</option>
            <option <?= $inscripcion != "" && $inscripcion->payment->time == "Semestral" ? "selected" : "" ?>
              value="Semestral">Semestral</option>
            <option <?= $inscripcion != "" && $inscripcion->payment->time == "Anual" ? "selected" : "" ?> value="Anual">
              Anual</option>
          </select>
        </span>
        <span class="calendar">
          <i class="acuarela acuarela-Calendario"></i>
          <label for="proximo_pago">Inicio del cobro</label>
          <input type="date" name="proximo_pago" id="proximo_pago"
            value="<?= $inscripcion ? date('Y-m-d', strtotime($inscripcion->payment->proximo_pago)) : '' ?>" required
            data-selectors='{"#resproximopago strong": "{value}"}' />
        </span>
        <span>
          <i class="acuarela acuarela-Usuario"></i>
          <label for="paymentPrice">Cuánto se va a cobrar:</label>
          <input type="text" name="paymentPrice" id="paymentPrice"
            value="<?= $inscripcion != "" ? $inscripcion->payment->price : "" ?>" required />
        </span>
        <div class="info">
          <i class="acuarela acuarela-Informacion"></i>
          <p>
            Recuerda asociar una cuenta PayPal en tu perfil para beneficiarte de
            los pagos automáticos.
          </p>
        </div>
      </div>
      <div id="adjuntos" class="tab-content">
        <?php
        // Plantillas adicionales
        $additionalFiles = [
          'acuerdo-de-registro' => 'Acuerdo de registro',
          'formulario-de-examen-de-salud' => 'Formulario de examen de salud',
          'formato-de-alergias' => 'Formato de alergias',
          'id-de-los-padres' => 'ID de los padres',
          'plan-de-transporte' => 'Plan de transporte',
          'acuerdo-de-siestas' => 'Acuerdo de siestas',
          'archivos-adicionales' => 'Archivos adicionales',
        ];

        foreach ($additionalFiles as $fileId => $labelText) {
          // Verificar si el archivo ya existe en $inscripcion->files
          $exists = false;
          if (is_object($inscripcion) && !empty($inscripcion->files) && is_iterable($inscripcion->files)) {
            foreach ($inscripcion->files as $file) {
              if ($file->name === $fileId) {
                $exists = true;
                break;
              }
            }
          }

          echo '<div class="wrapper">';

          if ($exists) {
            // Estructura para archivos ya existentes
            echo '
              <input type="hidden" id="' . $fileId . '-id" name="' . $fileId . '-id" value="' . $fileId . '">
              <input type="file" id="' . $fileId . '" name="' . $fileId . '" class="selected">
              <label for="' . $fileId . '" class="btn-1 special"><i class="acuarela acuarela-Aceptar"></i>Subir ' . $labelText . '</label>';
          } else {
            // Estructura para nuevos archivos
            echo '
              <input type="hidden" id="' . $fileId . '-id" name="' . $fileId . '-id">
              <input type="file" id="' . $fileId . '" name="' . $fileId . '" />
              <label for="' . $fileId . '" class="btn-1"><i class="acuarela acuarela-Agregar"></i>Subir ' . $labelText . '</label>';
          }

          echo '</div>';
        }
        ?>


      </div>



      <div id="resumen" class="tab-content">
        <h4>Información básica del niño</h4>
        <p id="resname">
          <i class="acuarela acuarela-Usuario"></i>Nombre<strong>Nombre</strong>
        </p>
        <div class="row">
          <p id="resbirthday">
            <i class="acuarela acuarela-Evento"></i>Nacido el<strong>Nacido el</strong>
          </p>
          <p id="resgender">
            <i class="acuarela acuarela-Nino"></i>Género<strong>Masculino</strong>
          </p>
        </div>
        <h4>Familia</h4>
        <h5>Padre principal</h5>
        <div class="row">
          <p id="resparentname">
            <i class="acuarela acuarela-Usuario"></i>Nombre <strong></strong>
          </p>
          <p id="resparenttype">
            <i class="acuarela acuarela-Familia"></i>Parentesco <strong>Mamá</strong>
          </p>
        </div>
        <div class="row">
          <p id="resparenttel">
            <i class="acuarela acuarela-Telefono"></i>Celular <strong></strong>
          </p>
          <p id="resparentmail">
            <i class="acuarela acuarela-Mensajes"></i>Correo electrónico <strong></strong>
          </p>
        </div>
        <!-- <h5>Otros responsables</h5> -->
      </div>

      <input type="hidden" name="daycare" id="daycare" value="<?= $a->daycareID ?>">
      <input type="hidden" name="inscripcion" id="inscripcion" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>">
    </form>
  </div>
</main>



<?php include "includes/footer.php" ?>