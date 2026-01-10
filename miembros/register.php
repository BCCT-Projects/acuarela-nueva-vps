<?php $classBody = "login";
include 'includes/header.php'; ?>
<div class="progress">
    <div class="progress-bar" style="width: 0;"></div>
</div>
<main>
    <form action="s/createUser/" method="POST" id="register" autocomplete="off" enctype="multipart/form-data">
        <h1>
            Crea una cuenta en Bilingual Childcare Training
        </h1>
        <div class="steps step-1 active">
            <div class="flex">
                <span>
                    <input type="text" id="threadId" name="threadId">
                    <input type="text" id="estadoValue" name="estadoValue">
                    <input type="text" id="daycareValue" name="daycareValue">

                    <label for="name">¿Cúal es tu nombre?</label>
                    <input type="text" placeholder="Nombre" name="name" id="name" />
                </span>
                <span>
                    <label for="lastname"></label>
                    <input type="text" placeholder="Apellido" name="lastname" id="lastname" />
                </span>
            </div>
            <div class="flex">
                <span>
                    <label for="">¿Cúal es tu correo?</label>
                    <input type="email" placeholder="example@example.com" name="email" id="email"
                        onblur="validateEmailExist(event)" autocomplete="off" />
                    <small class="emailExist">Este correo ya está registrado</small>
                    <div class="noAccount">No se encontró un usuario registrado!</div>
                </span>
                <span>
                    <label for="">Teléfono</label>
                    <input type="tel" placeholder="000 00 00" name="phone" id="phone" />
                </span>
            </div>
            <div class="flex">
                <span>
                    <label for="birthdate">Fecha de nacimiento</label>
                    <input type="date" name="birthdate" id="birthdate" required />
                    <small id="birthdate-error" style="display:none; color: red;">Debes tener al menos 18 años.</small>
                </span>
            </div>
            <div class="flex">
                <span>
                    <label for="">Contraseña</label>
                    <input type="password" placeholder="*******" name="password" id="password" />
                    <button id="viewPassword" type="button" onclick="togglePasswordVisibility()"><svg width="32"
                            height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_318_107687)">
                                <path
                                    d="M16 11.6362C13.5927 11.6362 11.6364 13.5926 11.6364 15.9999C11.6364 18.4072 13.5927 20.3635 16 20.3635C18.4073 20.3635 20.3636 18.4072 20.3636 15.9999C20.3636 13.5926 18.4072 11.6362 16 11.6362Z"
                                    fill="currentColor" />
                                <path
                                    d="M16 5.09082C8.72728 5.09082 2.51639 9.61441 0 15.9999C2.51639 22.3854 8.72728 26.909 16 26.909C23.28 26.909 29.4837 22.3854 32.0001 15.9999C29.4837 9.61441 23.28 5.09082 16 5.09082ZM16 23.2726C11.9855 23.2726 8.72728 20.0144 8.72728 15.9999C8.72728 11.9853 11.9855 8.72716 16 8.72716C20.0146 8.72716 23.2728 11.9854 23.2728 15.9999C23.2728 20.0145 20.0146 23.2726 16 23.2726Z"
                                    fill="currentColor" />
                            </g>
                            <defs>
                                <clipPath id="clip0_318_107687">
                                    <rect width="32" height="32" fill="white" />
                                </clipPath>
                            </defs>
                        </svg></button>
                </span>
                <span>
                    <label for="">Confirmar Contraseña</label>
                    <input type="password" placeholder="*******" name="repeat" id="repeat" oninput="toggleButton()" />
                </span>
            </div>
           
            <div id="dialog-content" style="display:none;max-width:500px;">
                <h2>¡Ya estas registrado en Bilingual Childcare Training!</h2>
                <p>El correo electrónico ya está registrado en Bilingual Childcare Training. Por favor,<a
                        href="/miembros/" class="link register">inicia sesión</a> para acceder a tu cuenta.</p>
            </div>
        </div>
        <div class="steps step-2">
            <h2>¿Qué rol desempeñas en tu daycare?</h2>
            <div class="grid-checkbox">
                <span>
                    <div class="checkbox-wrapper-16">
                        <label class="checkbox-wrapper">
                            <input class="checkbox-input" type="radio" name="rol" id="administrator">
                            <span class="checkbox-tile">
                                <span class="checkbox-label">Administrator / On-site Provider</span>
                            </span>
                        </label>
                    </div>
                </span>
                <span>
                    <div class="checkbox-wrapper-16">
                        <label class="checkbox-wrapper">
                            <input class="checkbox-input" type="radio" name="rol" id="asistente" />
                            <span class="checkbox-tile">
                                <span class="checkbox-label">Asistente</span>
                            </span>
                        </label>
                    </div>
                </span>
            </div>
            <div class="daycare-provider" style="display: none;">
                <div class="flex">
                    <span>
                        <label for="">¿Cómo se llama tu daycare?</label>
                        <input type="text" placeholder="Nombre de tu daycare" name="daycare" id="daycare" />
                    </span>
                    <span>
                        <label for="">¿Dónde está ubicado tu Daycare?</label>
                        <div class="c-select">
                            <select name="state" id="state">
                                <option value="">Selecciona un estado</option>
                                <?php
                                foreach ($states as $state) {
                                    $selected = $daycare->state == $state ? "selected" : "";
                                    echo "<option $selected value=\"$state\">$state</option>";
                                }
                                ?>
                            </select>
                            <div class="c-arrow"></div>
                        </div>
                    </span>

                </div>
                <div class="flex">
                    <span>
                        <label for="">Teléfono de contacto para tu daycare</label>
                        <input type="tel" placeholder="000 00 00" name="phonedaycare" id="phonedaycare" />
                    </span>
                    <span>
                        <label for="">Correo de contacto para tu daycare</label>
                        <input type="email" placeholder="daycare@example.com" name="emaildaycare" id="emaildaycare" />
                    </span>

                </div>
                <div class="flex">
                    <span>
                        <label for="">Número de licencia:</label>
                        <input type="text" placeholder="A0000A0000A0000" name="license" id="license" maxlength="9" />
                    </span>
                    <span>
                        <label for="">Fecha de expiración de licencia:</label>
                        <input type="date" name="expiration" id="expiration" />
                    </span>
                </div>
                <p id="mensajeAlerta" style="display:none;">Por favor, complete todos los campos.</p>
                <div class="flex wrapper photo">
                    <div id="photo-container"></div>
                    <span>
                        <label for="photo">Logo del daycare:</label>
                        <input type="file" id="photo" accept="image/png, image/jpeg" />
                        <input type="hidden" name="photoID" id="photoID">
                    </span>
                </div>
                <div class="terms">
            <div class="checkbox">
              <input type="checkbox" name="termsfooter" id="termsfooter" checked />
              <div class="checkmark"><i class="gg-check"></i></div>
              <label for="termsfooter">Acepto <a href="/politica-privacidad" target="_blank">política de privacidad,</a> <a href="/terminos-condiciones" target="_blank"> términos y condiciones</a></label>
            </div>
          </div>
            </div>
            <div class="daycare-asistente" style="display: none;">
                <span>
                    <label for="">¿Cúal es el numero de licencia de tu daycare?</label>
                    <input type="tel" placeholder="licencia" name="daycareValLicencia" id="daycareValLicencia" />
                </span>
                <span>
                    <label for="">¿Dónde está ubicado tu Daycare?</label>
                    <div class="c-select">
                        <select name="where" id="where">
                            <option value="">Selecciona un estado</option>
                            <?php
                            foreach ($states as $state) {
                                $selected = $daycare->state == $state ? "selected" : "";
                                echo "<option $selected value=\"$state\">$state</option>";
                            }
                            ?>
                        </select>
                        <div class="c-arrow"></div>
                    </div>
                </span>
                <div id="daycaresFounded" style="display:none;">
                    <h2>¿Cúal es tu daycare?</h2>
                    <div class="grid-checkbox">
                        <span>
                            <div class="checkbox-wrapper-16">
                                <label class="checkbox-wrapper">
                                    <input class="checkbox-input" type="radio" name="findDaycare" id="administrator">
                                    <span class="checkbox-tile">
                                        <span class="checkbox-label">Administrator</span>
                                    </span>
                                </label>
                            </div>
                        </span>
                    </div>
                </div>
                <div id="dialog-daycarenotfound" style="display:none;max-width:500px;">
                    <h2>¡TU DAYCARE NO ESTA REGISTRADO!</h2>
                    <p>pídele a tu proveedora que cree una cuenta primero</p>
                </div>
            </div>
        </div>
        <div class="actions">
            <button type="button" id="prevButton">Anterior</button>
            <button type="button" id="nextButton" disabled>Siguiente</button>
            <button type="submit" id="createAccount" disabled>CREAR CUENTA</button>
        </div>

        <a href="/miembros/" class="link register">Ya tengo una cuenta, quiero iniciar sesión</a>
    </form>
</main>

<script>
    // Recupera el valor del parámetro "threadId" de la URL
    let urlParams = new URLSearchParams(window.location.search);
    let threadId = urlParams.get('threadId');

    // Recupera el valor del parámetro "estadoValue" de la URL
    let estadoValue = urlParams.get('estadoValue');

    // Recupera el valor del parámetro "daycareValue" de la URL
    let daycareValue = urlParams.get('daycareValue');

    document.getElementById("threadId").value = threadId;
    document.getElementById("estadoValue").value = estadoValue;
    document.getElementById("daycareValue").value = daycareValue;
</script>

<?php include 'includes/footer.php'; ?>