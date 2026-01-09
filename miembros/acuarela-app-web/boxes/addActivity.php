<div id="lightbox-activities" class="lightbox">
  <div class="lightbox-content">
    <form action="" method="POST" id="createActicity">
      <div class="steps">
        <div class="step step-1 active">
          <h2 id="lightbox-title">Agregar actividad</h2>
          <h3 id="lightbox-subtitle">Elige la actividad que quieres agregar</h3>
          <fieldset>
            <ul class="types">
              <li>
                <input type="radio" name="activityType" id="6088935af169a43504538925" value="6088935af169a43504538925"
                  onchange="updateIconClass('acuarela-Alimentacion', 'Alimentación')">
                <label for="6088935af169a43504538925">
                  <i class="acuarela acuarela-Alimentacion"></i>
                  <span>Alimentación</span>
                </label>
              </li>
              <li>
                <input type="radio" name="activityType" id="60889371f169a43504538926" value="60889371f169a43504538926"
                  onchange="updateIconClass('acuarela-Siesta', 'Siesta')">
                <label for="60889371f169a43504538926">
                  <i class="acuarela acuarela-Siesta"></i>
                  <span>Siesta</span>
                </label>
              </li>
              <li>
                <input type="radio" name="activityType" id="6088937ff169a43504538927" value="6088937ff169a43504538927"
                  onchange="updateIconClass('acuarela-Bano', 'Baño')">
                <label for="6088937ff169a43504538927">
                  <i class="acuarela acuarela-Bano"></i>
                  <span>Baño</span>
                </label>
              </li>
              <!-- <li>
                <input type="radio" name="activityType" id="6088939df169a43504538929"
                  onchange="updateIconClass('acuarela-Salud', 'Health Check')">
                <label for="6088939df169a43504538929">
                  <i class="acuarela acuarela-Salud"></i>
                  <span>Health Check</span>
                </label>
              </li> -->
              <li>
                <input type="radio" name="activityType" id="608893aef169a4350453892a" value="608893aef169a4350453892a"
                  onchange="updateIconClass('acuarela-Actividades', 'Actividades')">
                <label for="608893aef169a4350453892a">
                  <i class="acuarela acuarela-Actividades"></i>
                  <span>Actividades</span>
                </label>
              </li>
            </ul>
            <div class="btnactions">
              <button type="button" onclick="nextStep()" class="btn btn-action-primary enfasis btn-big">Siguiente</button>
            </div>
          </fieldset>
        </div>
        <div class="step step-2">
          <h2 id="lightbox-title">Actividades</h2>
          <div class="typeSelected">
            <i class="acuarela typeSelectedIcon"></i>
            <div class="txt">
              <strong class="typeSelectedName">Juego</strong>
              <strong>¿Quiénes participaron?</strong>
            </div>
          </div>
          <ul class="participaron">
            <?php 
            for ($i=0; $i < count($children); $i++) { 
            $kid = $children[$i];
          ?>
            <li>
              <input type="radio" name="kidSelected" id="<?=$kid->id?>">
              <label for="<?=$kid->id?>">
                <?php
                $photoUrl = isset($kid->photo) ? 'https://acuarelacore.com/api/' . $kid->photo->formats->small->url : null;
                $gender = $kid->gender;

                if ($photoUrl) {
                    echo "<img src='$photoUrl' alt='{$kid->name}'>";
                } else {
                    if ($gender === "Masculino") {
                        echo '<img src="img/mal.png" alt="">';
                    } elseif ($gender === "Femenino") {
                        echo '<img src="img/fem.png" alt="">';
                    } elseif ($gender === "X") {
                        echo '<img src="img/Nonbinary.png" alt="">';
                    }
                }
              ?>
                <span><?=$kid->name?></span>
                <label for="rate-<?=$kid->id?>-0">
                  <input type="radio" class="rate-0" name="rate-<?=$kid->id?>" id="rate-<?=$kid->id?>-0" value="0">
                  <i class="acuarela acuarela-Anadir_reaccion"></i>
                </label>
                <label for="rate-<?=$kid->id?>-1">
                  <input type="radio" class="rate-1" name="rate-<?=$kid->id?>" id="rate-<?=$kid->id?>-1" value="1">
                  <i class="acuarela acuarela-Anadir_reaccion"></i>
                </label>
                <label for="rate-<?=$kid->id?>-2">
                  <input type="radio" class="rate-2" name="rate-<?=$kid->id?>" id="rate-<?=$kid->id?>-2" value="2">
                  <i class="acuarela acuarela-Anadir_reaccion"></i>
                </label>
              </label>
            </li>
            <?php } ?>
          </ul>
          <div class="btnactions">
            <button type="button" onclick="prevStep()" class="btn btn-action-secondary enfasis btn-big">Atras</button>
            <button type="button" onclick="nextStep()" class="btn btn-action-primary enfasis btn-big">Siguiente</button>
          </div>
        </div>
        <div class="step step-3">
          <div class="typeSelected">
            <i class="acuarela typeSelectedIcon"></i>
            <div class="txt">
              <strong class="typeSelectedName">Juego</strong>
              <strong>¿Quiénes participaron?</strong>
            </div>
          </div>
          <span><i class="acuarela acuarela-"></i><label for="">Título de la actividad</label><input type="text"
              name="title" id="title"></span>
          <span><i class="acuarela acuarela-"></i><label for="">Descripción</label><textarea name="description"
              id="description"></textarea></span>
              <div class="btnactions">
                <button type="button" onclick="prevStep()" class="btn btn-action-secondary enfasis btn-big">Atras</button>
                <button type="button" onclick="sendActivity()" id="save" class="btn btn-action-primary enfasis btn-big">Guardar</button>
              </div>
        </div>
      </div>
      <input type="hidden" name="group" id="group" value="<?=$grupo->id?>">
    </form>
    <button id="activities-close-button" class="lightbox-button"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="16" cy="16" r="15.5" stroke="#E1E4E9"/><g clip-path="url(#clip0_1_41059)"><path d="M23.3796 20.3855L18.9948 16.0006L23.3796 11.6157C24.2066 10.7888 24.2066 9.44797 23.3796 8.62104C22.5527 7.79411 21.2119 7.79411 20.385 8.62104L15.9997 13.0059L11.6149 8.62069C10.7876 7.79376 9.44677 7.79376 8.6202 8.62069C7.79327 9.44797 7.79327 10.7888 8.6202 11.6153L13.0054 16.0002L8.6202 20.3851C7.79327 21.2124 7.79327 22.5532 8.6202 23.3798C9.03419 23.7934 9.57559 23.9999 10.1177 23.9999C10.6595 23.9999 11.2016 23.7931 11.6152 23.3798L15.9997 18.9952L20.385 23.3801C20.799 23.7934 21.3404 24.0002 21.8825 24.0002C22.4246 24.0002 22.9663 23.7934 23.38 23.3801C24.2066 22.5532 24.2066 21.2127 23.3796 20.3855Z" fill="#98A2B7"/></g><defs><clipPath id="clip0_1_41059"><rect width="16" height="16" fill="white" transform="translate(8 8)"/></clipPath></defs></svg></button>
  </div>
</div>