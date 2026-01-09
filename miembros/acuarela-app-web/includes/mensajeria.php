<div id="mesajeria-menu" class="mesajeria-menu" style="display: none;">
    <!-- <button id="mainButton" class="main-button">
        <i class="acuarela acuarela-Mensajes"></i>
    </button> -->

    <div class="icons">
        <ul id="opciones-mensajeria">
            <li id="buscar-mensajeria" title="Buscar chats activos">
                <i class="acuarela acuarela-Buscar"></i>
            </li>
            <li id="agregar-mensajeria" title="Crear nuevo chat">
                <i class="acuarela acuarela-Agregar"></i>
            </li>
            <!-- <li class="chat-icon" title="Ver chat">
                <img src="https://bilingualchildcaretraining.com/miembros/acuarela-app-web/img/placeholder.png" alt="">
            </li> -->
            <li id="agregar-grupo-mensajeria" title="Crear Grupo">
                <i class="acuarela acuarela-Ambos"></i>
            </li>
            <hr style="border: 1px solid #ccc; width: 100%;">
            <!--
            <li class="chat-icon">
                <img src="https://bilingualchildcaretraining.com/miembros/acuarela-app-web/img/placeholder.png" alt="">
            </li>
            <li class="chat-icon">
                <img src="https://bilingualchildcaretraining.com/miembros/acuarela-app-web/img/placeholder.png" alt="">
            </li> -->
            <!-- <li id="opcines-mensajeria">
                <i class="acuarela acuarela-Opciones"></i>
            </li> -->

        </ul>
    </div>
    <div id="chats-buscados" class="chats-buscados" style="display: none;">
        <div class="buscador-mensajeria">
            <i id="btn-buscador-chat" class="acuarela acuarela-Buscar"></i>
            <input id="buscador-chat" type="text">
            <i id="closeBuscador" class="acuarela acuarela-Cancelar"></i>
        </div>
        <div id="chats-padres" class="chats-padres">

        </div>

    </div>

    <div id="chats-agregados" class="chats-buscados" style="display: none;">
        <div class="buscador-mensajeria">
            <i id="btn-invitar" class="acuarela acuarela-Agregar"></i>
            <input id="agregar-chat" type="text">
            <i id="closeAgregar" class="acuarela acuarela-Cancelar"></i>
        </div>
        <div id="padres-inactivos" class="chats-padres">

        </div>

    </div>

    <div id="chat-grupal" class="chats-buscados" style="display: none;">
        <div class="buscador-mensajeria">
            <i id="btn-crear-grupo" class="acuarela acuarela-Agregar"></i>
            <i id="btn-buscador-chat-grupal" class="acuarela acuarela-Buscar"></i>
            <input id="buscador-chat-grupal" type="text">
            <i id="closeBuscador-grupal" class="acuarela acuarela-Cancelar"></i>
        </div>
        <div id="div-lista-chats-grupales" class="chats-padres">


        </div>

    </div>

    <div id="chat-individual" class="chat-individual" style="display: none;">
        <div class="info-chat">
            <img id="imgUser" src="https://bilingualchildcaretraining.com/miembros/acuarela-app-web/img/placeholder.png" alt="">
            <p id="userChat"></p>
            <!-- <i class="acuarela acuarela-Usuario"></i> -->
            <i id="closeChat" class="acuarela acuarela-Cancelar"></i>
        </div>
        <div id="messages" class="chat-mensajes">
            <div class="mensaje-enviado">
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minima asperiores repudiandae nisi magnam minus et, adipisci numquam id aspernatur totam blanditiis, animi, dolorem fugit dolores! Commodi voluptates sint dolorem magnam.

                </p>
                <p class="chat-hora">00:00AM</p>
            </div>
            <div class="mensaje-recibido">
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minima asperiores repudiandae nisi magnam minus et, adipisci numquam id aspernatur totam blanditiis, animi, dolorem fugit dolores! Commodi voluptates sint dolorem magnam.

                </p>
                <p class="chat-hora">00:00AM</p>
            </div>
            <div class="mensaje-enviado">
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minima asperiores repudiandae nisi magnam minus et, adipisci numquam id aspernatur totam blanditiis, animi, dolorem fugit dolores! Commodi voluptates sint dolorem magnam.

                </p>
                <p class="chat-hora">00:00AM</p>
            </div>
        </div>
        <div class="chat-barra-mensajes">
            <input id="messageInput" type="text" placeholder="Mensaje">
            <i id="sendBtn" class="acuarela acuarela-Enviar"></i>
            <!-- <i class="acuarela acuarela-Adjuntar"></i> -->
        </div>
    </div>



    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>

</div>