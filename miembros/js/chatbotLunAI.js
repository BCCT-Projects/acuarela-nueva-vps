var primeraLlamada = true;

let hasElementCreated = false;

document.addEventListener("DOMContentLoaded", borrarElementos);

// Variables para almacenar el estado seleccionado y el tipo de daycare en el modal inicial
const selectEstado = document.getElementById("estadosSelect");
let estadoSeleccionadoP = document.querySelector(".estadoSeleccionado");
let estadoSeleccionadoValue = "";
let estadoSeleccionado = "";

// Estado seleccionado
function actualizarEstadoSeleccionado(selectValue) {
  const palabras = selectValue.split("_");
  estadoSeleccionado = palabras
    .map((palabra) => {
      return palabra.toLowerCase() === "del"
        ? "del"
        : palabra.charAt(0).toUpperCase() + palabra.slice(1);
    })
    .join(" ");

  estadoSeleccionadoP.innerHTML = "<b> Estado: </b>" + estadoSeleccionado;
  estadoSeleccionadoValue = selectValue;
}

// Event listener para el cambio en el select
selectEstado.addEventListener("change", function () {
  console.log("Estado seleccionado: ", selectEstado.value);
  actualizarEstadoSeleccionado(selectEstado.value);
});


// Array para almacenar los IDs de los documentos 
let openaiIdsFiles = [];

// Botón modal para guardar el estado y el tipo de daycare seleccionado
document.getElementById("guardarDatos").addEventListener("click", async function() {
  const nuevoIdThread = await cargarThreadId();
  console.log("Nuevo ID Thread: ", nuevoIdThread);
  threadValue = nuevoIdThread;
  handleChat();
  hasElementCreated = false;
});

const selectDaycare = document.getElementById("tipoDaycare");
let daycareSeleccionadoP = document.querySelector(".daycareSeleccionado");
let daycareSeleccionadoValue = "";
let daycareSeleccionado = "";

function actualizarDaycareSeleccionado(selectValue) {
  const palabras = selectValue.split("_");
  daycareSeleccionado = palabras
    .map((palabra) => palabra.charAt(0).toUpperCase() + palabra.slice(1))
    .join(" ");

  daycareSeleccionadoP.innerHTML =
    "<b> Tipo Daycare: </b> " + daycareSeleccionado;
  daycareSeleccionadoValue = selectValue;
}

// Event listener para el cambio en el select
selectDaycare.addEventListener("change", function () {
  console.log("Daycare seleccionado: ", selectDaycare.value);
  actualizarDaycareSeleccionado(selectDaycare.value);
});


const chatInput = document.querySelector(".chat-input textarea");
const sendChatBtn = document.querySelector(".chat-input button");
const chatbox = document.querySelector(".chatbox");
const btnNuevo = document.querySelector("#btnNuevo");
const btnEditar = document.querySelector("#btnEditar");
const btnSi = document.querySelector("#btnSi");
const btnNo = document.querySelector("#btnNo");
var popupChatbot = document.getElementById("chatbotLunAI");
var botonCerrar = document.getElementById("cerrarDialog");
var popupCambiosChatbot = document.getElementById("cambiarChatbotLunAI");
const textarea = document.getElementById("textareaMsg");
const boton = document.getElementById("send-btn");

let threadIdChat = document.getElementById("threadValue");
let estadoChat = document.getElementById("estadoSeleccionadoValue");
let daycareChat = document.getElementById("daycareSeleccionadoValue");

let threadId;
// Obtener el ID de el hilo creado y el asistente
function cargarThreadId() {
  // Realizar una solicitud a getAssistant.php para crear un nuevo hilo
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "get/getAssistant.php", true);
  return new Promise(function (resolve, reject) {
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          // Manejar la respuesta
          var responseHtml = xhr.responseText;
          var threadIdElement = document.createElement("div");
          threadIdElement.innerHTML = responseHtml;

          // Obtener el valor de data-thread-id
          var threadId = threadIdElement
            .querySelector("#threadId")
            .getAttribute("data-thread-id");

          // Obtener el elemento con el ID #threadId
          var existingThreadIdElement = document.getElementById("threadId");

          // Verificar si el elemento existe
          if (existingThreadIdElement) {
            // Establecer el nuevo valor de data-thread-id
            existingThreadIdElement.setAttribute("data-thread-id", threadId);
          } else {
            console.error("Elemento con ID #threadId no encontrado");
          }

          // Resolver la promesa con el valor de threadId
          resolve(threadId);
        } else {
          // Rechazar la promesa en caso de error
          reject(xhr.status);
        }
      }
    };

    xhr.send();
  });
  xhr.send();
}

// Mostrar modal para seleccionar estado y tipo daycare  
document.addEventListener("DOMContentLoaded", function () {
  var formChatbot = document.getElementById("formInfoChatbot");

  popupChatbot.showModal();

  popupChatbot.addEventListener("cancel", function (event) {
    if (!formChatbot.checkValidity()) {
      event.preventDefault();
    }
  });

  formChatbot.addEventListener("submit", function (event) {
    event.preventDefault();
    popupChatbot.close();
  });
});

// Mostar modal para editar el estado y tipo de daycare
btnEditar.addEventListener("click", () => {
  botonCerrar.style.display = "flex";
  botonCerrar.style.justifyContent = "flex-end";
  popupCambiosChatbot.showModal();
});

// Cerrar modal
botonCerrar.addEventListener("click", function () {
  popupChatbot.close();
});

// Botón si en modal para aceptar los cambios 
btnSi.addEventListener("click", () => {
  popupChatbot.showModal();
  popupCambiosChatbot.close();

  var chatItems = chatbox.children;
  for (var i = chatItems.length - 1; i > 0; i--) {
    chatbox.removeChild(chatItems[i]);
  }

  chatInput.value = "";
});

// Botón no en modal para cancelar la edición del estado y tipo de daycare
btnNo.addEventListener("click", () => {
  popupCambiosChatbot.close();
});

// Botón para nuevo chat/hilo de conversación se carga un nuevo hilo
btnNuevo.addEventListener("click", async() => {
  var chatItems = chatbox.children;
  for (var i = chatItems.length - 1; i > 0; i--) {
    chatbox.removeChild(chatItems[i]);
  }

  chatInput.value = "";
  const idThreadNueva = await cargarThreadId();
  console.log("ID Thread Nuevo chat: ", idThreadNueva);
  threadValue = idThreadNueva;
  // Conectar el MutationObserver solo cuando se hace clic en el botón
  observer.observe(threadIdElement, observerConfig);
  hasElementCreated = false;
  handleChat();
});

//COOKIES

const checkCookie = (cookieName) => {
  var cookies = document.cookie.split(";");

  //Iterar por todas las cookies
  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i].trim();
    // Separar valor y nombre de la cookie
    var cookieParts = cookie.split("=");
    //Cookie coincide con el que se envia desde la web
    if (cookieParts[0] === cookieName) {
      return true;
    }
  }
  // Si no se encuentra return false
  return false;
};

// Verificar si hay una cookie llamada "conversation_state" presente
const conversationStateCookie = checkCookie("conversation_state");
// Verificar si hay una cookie llamada "conversation_state_counter" presente
const conversationStateCounterCookie = checkCookie(
  "conversation_state_counter"
);

// Si hay cookie y sesión, habilitar botones
if (conversationStateCookie && userSessionID !== "") {
  console.log("La cookie está presente y válida");

  btnEditar.disabled = false;
  btnNuevo.disabled = false;
}
// Si no hay cookie pero hay sesión, habilitar botones
else if (!conversationStateCookie && userSessionID !== "") {
  console.log("No hay cookie pero hay sesión iniciada");
  btnNuevo.disabled = false;
  btnEditar.disabled = false;
}
// Si hay cookie pero no hay sesión, inhabilitar botones
else if (conversationStateCookie && userSessionID === "") {
  console.log("La cookie está presente pero no hay sesión iniciada");
  btnNuevo.disabled = true;
  btnEditar.disabled = true;
}
// Si no hay cookie ni sesión, habilitar botones
else {
  console.log("No hay cookie ni sesión iniciada");
  btnNuevo.disabled = false;
  btnEditar.disabled = false;
}

// FIN COOKIES

// // Seleccionar el primer <li> dentro de la lista <ul> con id "chatbox"
// const firstChatListItem = document.querySelector("#chatbox li:first-child");

// // Verificar si se encontró el primer <li>
// if (firstChatListItem) {
//   // Establecer el estilo display en "none" para ocultarlo
//   firstChatListItem.style.display = "none";
// }

const createWritingList = () => {
  // Crear el elemento <li> con el mensaje de escritura del asistente
  const chatList = document.createElement("li");
  chatList.classList.add("chat", "incoming");

  // Contenido del mensaje de escritura
  const chatContent = `
    <img src="https://i.ibb.co/YtbMzR7/LunAI.jpg" alt="LunAI">
    <div class="typing-indicator">
      <div class="typing-circle"></div>
      <div class="typing-circle"></div>
      <div class="typing-circle"></div>
      <div class="typing-shadow"></div>
      <div class="typing-shadow"></div>
      <div class="typing-shadow"></div>
    </div>
  `;

  chatList.innerHTML = chatContent;

  return chatList;
};

const createChatList = (message, role) => {
  // Crear el elemento <li> con el mensaje y el rol (incoming o outgoing)
  const chatList = document.createElement("li");
  chatList.classList.add("chat", role);

  // Contenido del mensaje
  let chatContent = "";

  if (conversationStateCookie && userSessionID === "") {
    if (role === "outgoing") {
      chatContent = `
      <p>${message}</p>
      <div class="photo">
        <a>
          <div class="photo-invitado">
            <svg class="user-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,12.5c-3.04,0-5.5,1.73-5.5,3.5s2.46,3.5,5.5,3.5,5.5-1.73,5.5-3.5-2.46-3.5-5.5-3.5Zm0-.5c1.66,0,3-1.34,3-3s-1.34-3-3-3-3,1.34-3,3,1.34,3,3,3Z"></path></svg>
          </div>
        </a>
      </div>
    `;
    } else {
      chatContent = `
        <img src="https://i.ibb.co/YtbMzR7/LunAI.jpg" alt="LunAI">
        <div class="animateRta">
          <p class="rta-text">${message}</p>
        </div>
      `;
    }
  } else {
    if (role === "outgoing" && window.photoUrl) {
      chatContent = `
      <p>${message}</p>
      <div class="photo">
        <a href="/miembros/acuarela-app-web/">
          <img src="${window.photoUrl}" alt="user-photo">
        </a>
      </div>
    `;
    } else if (role === "outgoing") {
      chatContent = `
      <p>${message}</p>
      <div class="photo">
        <a href="/miembros/acuarela-app-web/">
          <div class="photo-placeholder">${window.placeholderInitial}</div>
        </a>
      </div>
    `;
    } else {
      chatContent = `
      <img src="https://i.ibb.co/YtbMzR7/LunAI.jpg" alt="LunAI">
      <div class="animateRta">
        <p class="rta-text">${message}</p>
      </div>
    `;
    }
  }

  chatList.innerHTML = chatContent;

  return chatList;
};

// Función para manejar la conversación
const handleConversation = (data) => {
  // Iterar sobre los mensajes recibidos
  data.data.forEach((message) => {
    // Verificar el rol del mensaje (incoming o outgoing)
    const role = message.role === "assistant" ? "incoming" : "outgoing";

    // Crear el elemento de la lista de chat correspondiente
    const chatList =
      role === "incoming"
        ? createWritingList()
        : createChatList(message.content[0].text.value, role);

    // Agregar el elemento de la lista de chat al chatbox
    chatbox.appendChild(chatList);

    // Si es el primer mensaje saliente, ocultar el primer li
    if (role === "outgoing" && index === 0) {
      const primerLi = chatbox.querySelector("li");
      if (primerLi) {
        primerLi.style.display = "none";
      }
    }
  });

  // Hacer scroll hasta el final del chatbox
  chatbox.scrollTo(0, chatbox.scrollHeight);
};

/*BCCT*/
const assistantId = "asst_RoLjBrQTVk5vwe8X9MrJq7cq";

let userMessage = "";

let currentRunId = null;

const threadIdElement = document.getElementById("threadId");
let threadValue = threadIdElement.getAttribute("data-thread-id");
let threadValuePrueba = threadIdElement.getAttribute("data-thread-id");
let link = "/miembros/crear-cuenta?conversationId=" + threadValue;

// Crear un MutationObserver
const observer = new MutationObserver((mutations) => {
  mutations.forEach((mutation) => {
    if(mutation.type === "attributes"){
      if (mutation.attributeName === "data-thread-id") {
        // Actualizar threadValue cuando se detecte un cambio en data-thread-id
        threadValue = threadIdElement.getAttribute("data-thread-id");
        console.log("Nuevo valor de threadValue:", threadValue);
        hasElementCreated = false; // Restablecer hasElementCreated
      }
    }
  });
});

// Configurar el observador pero no iniciarlo aún
const observerConfig = { attributes: true };

// Generar mensaje para el asistente con el mensaje de el usuario
const generateMessage = (message) => {
  const requestOptions = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      endpoint: `threads/${threadValue}/messages`,  // Endpoint de OpenAI
      data: {
        role: "user",
        content: message,
      },
    }),
  };

  fetch('/miembros/s/postOpenAI/', requestOptions)  // El PHP que actúa como intermediario
    .then((response) => response.json())
    .then((data) => {
      console.log("Generate Message: ", data);
      runCompletion(); 
    })
    .catch((error) => {
      console.error("Error:", error);
    });
};

// Correr la solicitud o mensaje de el usuario
const runCompletion = () => {
  const requestOptions = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      endpoint: `threads/${threadValue}/runs`,  // Endpoint para completar
      data: {
        assistant_id: assistantId,
      },
    }),
  };

  fetch('/miembros/s/postOpenAI/', requestOptions)  // El PHP que actúa como intermediario
    .then((response) => response.json())
    .then((data) => {
      console.log("Run Completion:", data);
      currentRunId = data.id;
      checkStatusAndGenerateResponse(currentRunId);  // Verificar y mostrar respuesta
    })
    .catch((error) => {
      console.error("Error:", error);
    });
};


// Revisar el estatus de la solicitud y generar respuesta si ya se proceso
const checkStatusAndGenerateResponse = (runID) => {
  const requestOptions = {
    method: "POST", // Enviar el endpoint al PHP como POST
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      endpoint: `threads/${threadValue}/runs/${runID}`, // Endpoint de OpenAI
    }),
  };

  fetch('/miembros/g/getOpenAI/', requestOptions)  // El PHP que actúa como intermediario
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "completed") {
        console.log("Response Completed:", data);
        generateResponse();
      } else if (data.status === "in_progress") {
        console.log(
          "La solicitud está aún en progreso. Esperando más tiempo..."
        );
        setTimeout(() => checkStatusAndGenerateResponse(runID), 2000);
      } else {
        console.log(
          "La solicitud ha entrado en un estado no esperado:",
          data.status
        );
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
};

// Insertar hilo de conversación en Strapi 
const insertThread = () => {
  console.log("ID Thread: ", threadValue);
  console.log("Estado seleccionado: ", estadoSeleccionadoValue);
  console.log("Tipo daycare seleccionado:", daycareSeleccionadoValue);

  threadIdChat;

  const myHeaders = new Headers();
  myHeaders.append("Content-Type", "application/json");
  const requestOptions = {
    method: "POST",
    headers: myHeaders,
  };
  fetch(
    `/miembros/s/insertThread/?id_thread=${threadValue}&estado=${estadoSeleccionadoValue}&tipo=${daycareSeleccionadoValue}`,
    requestOptions
  )
    .then((response) => response.json())
    .then((result) => console.log(result))
    .catch((error) => console.error(error));
  console.log("Estado seleccionado: ", estadoSeleccionadoValue);
  console.log("Tipo daycare seleccionado:", daycareSeleccionadoValue);
};

const findElementsWithText = (selector, searchText) => {
  const elements = document.querySelectorAll(selector);
  return Array.from(elements).filter((element) =>
    element.textContent.includes(searchText)
  );
};

// Obtener la respuesta del assistant y mostrar en interfaz
const generateResponse = () => {
  const resultadoDiv = document.getElementById("resultadoConsultas");
  let responseData;

  const requestOptions = {
    method: "POST",  // Aunque sea un GET para OpenAI, se usa POST para el intermediario
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      endpoint: `threads/${threadValue}/messages`,  // Endpoint que se quiere recuperar
    }),
  };

  if (conversationStateCookie && userSessionID === "") {
    fetch('/miembros/g/getOpenAI/', requestOptions)
      .then((response) => response.json())
      .then((data) => {
        responseData = data;
        console.log("Final response: ", data);

        let formattedDate;
        let contentText = "";

        // Verifica si hay mensajes en la respuesta y si es un mensaje del asistente
        if (
          data.data &&
          data.data.length > 0 &&
          data.data[0].role === "assistant"
        ) {
          contentText = data.data[0].content[0].text.value;

          // Verificar el número de elementos <li> dentro del <ul> con la clase "chatbox"
          const chatListItems = document.querySelectorAll(".chatbox li");
          if (chatListItems.length === 5) {
            contentText = `<a href='/miembros/crear-cuenta?threadId=${threadValue}&estadoValue=${estadoSeleccionadoValue}&daycareValue=${daycareSeleccionadoValue}' target='_blank' style='text-decoration: underline; color: #140a4c;'>Regístrate gratis en Bilingual Child Care Training</a> para seguir chateando conmigo. No te preocupes, seguiré siendo gratis.`;
          }
          // Buscar todos los elementos de la clase ".typing-indicator" en la interfaz
          const typingIndicatorElements =
            document.querySelectorAll(".chat.incoming");

          // Reemplazar el último elemento con la clase "typing-indicator" con la respuesta del asistente
          if (typingIndicatorElements.length > 0) {
            const lastTypingIndicatorElement =
              typingIndicatorElements[typingIndicatorElements.length - 1];
            const newResponseLI = createChatList(contentText, "incoming");

            // Reemplazar el nodo ".typing-indicator" con la nueva respuesta
            lastTypingIndicatorElement.parentNode.replaceChild(
              newResponseLI,
              lastTypingIndicatorElement
            );
          } else {
            console.error(
              'No se encontraron elementos "Escribiendo..." para reemplazar.'
            );
          }
        } else {
          console.error(
            "No se encontró un mensaje válido del asistente en la respuesta."
          );
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      })
      .finally(() => chatbox.scrollTo(0, chatbox.scrollHeight));
    const chatListItems = document.querySelectorAll(".chatbox li");
    if (chatListItems.length === 5) {
      // Deshabilitar el botón
      boton.disabled = true;
      // Deshabilitar la textarea
      textarea.disabled = true;
    } else {
      // Habilitar el botón
      boton.disabled = false;
      // Habilitar la textarea
      textarea.disabled = false;
    }
  } else {
    fetch('/miembros/g/getOpenAI/', requestOptions)
      .then((response) => response.json())
      .then((data) => {
        responseData = data;
        console.log("Final response: ", data);

        let formattedDate;

        data.data.forEach((message) => {
          let createdTimestamp = message.created_at;
          let createdDate = new Date(createdTimestamp * 1000);
          formattedDate = createdDate.toLocaleDateString();
          console.log(
            `Mensaje ID: ${message.id}, Fecha de creación: ${formattedDate}`
          );
        });

        if (!hasElementCreated) {
          const btnElement = document.createElement("button");
          btnElement.classList.add("thread-button");
          btnElement.setAttribute("btn-thread-id", threadValue);
          btnElement.textContent = `Conversación creada: ${formattedDate} - Estado: ${estadoSeleccionado}  - Tipo: ${daycareSeleccionado}`;

          // Crear una etiqueta i y añadir las clases "acuarela" y "acuarela-Eliminar"
          const iElement = document.createElement("i");
          iElement.classList.add("acuarela", "acuarela-Eliminar");
          
          // Añadir el event listener al botón recién creado
          btnElement.addEventListener("click", () => {
            // Obtener el valor del atributo btn-thread-id
            const threadId = btnElement.getAttribute("btn-thread-id");
            // Llamar a la función retrieveThread con el threadId como argumento
            threadValue = threadId;
            retrieveThread(threadId);
          
            // Extraer la información de estado y tipo
            const estadoMatch = btnElement.textContent.match(/Estado: ([\w\s]+) -/);
            const tipoMatch = btnElement.textContent.match(/Tipo: (.+)$/);
          
            if (estadoMatch && estadoMatch[1]) {
              const estado = estadoMatch[1].trim();
              console.log("Estado:", estado);
              actualizarEstadoSeleccionado(estado);
            } else {
              console.error("No se encontró el estado en el texto del botón.");
            }
          
            if (tipoMatch && tipoMatch[1]) {
              const tipo = tipoMatch[1].trim();
              console.log("Tipo:", tipo);
              actualizarDaycareSeleccionado(tipo);
            } else {
              console.error("No se encontró el tipo en el texto del botón.");
            }
          });  

          // Agregar el elemento i al elemento p
          btnElement.appendChild(iElement);
          
          // Agregar el elemento de párrafo al div resultado
          resultadoDiv.appendChild(btnElement);
          
          borrarElementos();
          //Insertar hilo en strapi
          insertThread();
          hasElementCreated = true; // Actualizar la variable para indicar que se ha creado el elemento
        }

        // Verifica si hay mensajes en la respuesta y si es un mensaje del asistente
        if (
          data.data &&
          data.data.length > 0 &&
          data.data[0].role === "assistant"
        ) {
          const contentText = data.data[0].content[0].text.value;

          // Buscar todos los elementos de la clase ".typing-indicator" en la interfaz
          const typingIndicatorElements =
            document.querySelectorAll(".chat.incoming");

          // Reemplazar el último elemento con la clase "typing-indicator" con la respuesta del asistente
          if (typingIndicatorElements.length > 0) {
            const lastTypingIndicatorElement =
              typingIndicatorElements[typingIndicatorElements.length - 1];
            const newResponseLI = createChatList(contentText, "incoming");

            // Reemplaza el nodo ".typing-indicator" con la nueva respuesta
            lastTypingIndicatorElement.parentNode.replaceChild(
              newResponseLI,
              lastTypingIndicatorElement
            );
          } else {
            console.error(
              'No se encontraron elementos "Escribiendo..." para reemplazar.'
            );
          }
        } else {
          console.error(
            "No se encontró un mensaje válido del asistente en la respuesta."
          );
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      })
      .finally(() => chatbox.scrollTo(0, chatbox.scrollHeight));
    // Habilitar el botón
    boton.disabled = false;
    // Habilitar la textarea
    textarea.disabled = false;
  }
};

// Borrar los botones
function borrarElementos() {
  const elementosI = document.querySelectorAll("#resultadoConsultas button i");
  console.log(elementosI.length); // Muestra la cantidad de elementos seleccionados
  // Iterar sobre cada elemento <i> y añadir un event listener
  elementosI.forEach((i) => {
    i.addEventListener("click", function (event) {
      console.log("Si detecta el click");
      event.stopPropagation();
      const iCliqueado = event.target;
      // Obtener el botón padre del <i> actual
      const botonPadre = iCliqueado.parentNode;
      // Obtener el valor del atributo del botón padre
      const valorThreadIdBtn = botonPadre.getAttribute("btn-thread-id");
      console.log(`Valor thread id: ${valorThreadIdBtn}`);

      //Enviar la solicitud DELETE al intermediario PHP
      const requestOptions = {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          endpoint: `threads/${valorThreadIdBtn}`,  // Endpoint de OpenAI
          data: {}, 
        }),
      };

      fetch('/miembros/s/deleteThread/', requestOptions)  // El PHP que actúa como intermediario
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la solicitud DELETE");
          }
          console.log("Solicitud DELETE exitosa");
          botonPadre.remove();
        })
        .catch((error) => {
          console.error("Error en la solicitud DELETE:", error);
        });
        getIdThread(valorThreadIdBtn, botonPadre);
    });
  });
}

// Obteber el ID de otras conversaciones 
const getIdThread = (valorThreadIdBtn, botonPadre) => {
  console.log("ID Thread: ", valorThreadIdBtn);

  const myHeaders = new Headers();
  myHeaders.append("Content-Type", "application/json");
  const requestOptions = {
    method: "GET",
    headers: myHeaders,
  };

  return fetch(
    `/miembros/s/IdThread/?id_thread=${valorThreadIdBtn}`,
    requestOptions
  )
    .then((response) => response.json())
    .then((result) => {
      // Verificar si result es un objeto y si tiene el campo "_id"
      if (result && result.response && result.response.length > 0 && result.response[0]._id) {
        const idThread = result.response[0]._id;
        // Llamar a deleteThread con el _id obtenido
        deleteThread(idThread, botonPadre);
      } else {
        console.error("No se pudo obtener el _id del resultado.");
      }
    })
    .catch((error) => console.error(error));
};

// Eliminar conversación en interfaz y de Strapi
const deleteThread = (idThread, botonPadre) => {
  console.log("El _id obtenido es:", idThread);

  const requestOptions = {
    method: "DELETE",
  };

  fetch(`/miembros/s/deleteThread/?id_thread_strapi=${idThread}`, requestOptions)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud DELETE de Strapi");
      }
      // Borrar el  botón
      botonPadre.remove();
      return response.json();
    })
    .then((result) => console.log(result))
    .catch((error) => console.error(error));
};

// Obtener todos los elementos con la clase "thread-button"
const buttons = document.querySelectorAll(".thread-button");

// Iterar sobre cada botón y agregar un event listener para el clic
buttons.forEach((button) => {
  button.addEventListener("click", () => {
    // Obtener el valor del atributo btn-thread-id
    const threadId = button.getAttribute("btn-thread-id");
    // Llamar a la función retrieveThread con el threadId como argumento
    threadValue = threadId;
    retrieveThread(threadId);

    // Extraer la información de estado y tipo
    const estadoMatch = button.textContent.match(/Estado: ([\w\s]+) -/);
    const tipoMatch = button.textContent.match(/Tipo: (.+)$/);

    if (estadoMatch && estadoMatch[1]) {
      const estado = estadoMatch[1].trim();
      console.log("Estado:", estado);
      actualizarEstadoSeleccionado(estado);
    } else {
      console.error("No se encontró el estado en el texto del botón.");
    }

    if (tipoMatch && tipoMatch[1]) {
      const tipo = tipoMatch[1].trim();
      console.log("Tipo:", tipo);
      actualizarDaycareSeleccionado(tipo);
    } else {
      console.error("No se encontró el tipo en el texto del botón.");
    }
  });
});

// La función retrieveThread ahora toma el threadId como argumento
const retrieveThread = (threadId) => {
  // Hacer la solicitud al intermediario PHP
  const requestOptions = {
    method: "POST",  // Aunque sea un GET para OpenAI, se usa POST para el intermediario
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      endpoint: `threads/${threadId}/messages`,  // Endpoint que se quiere recuperar
    }),
  };

  // Solicitud al intermediario PHP que hace la solicitud GET a OpenAI
  fetch('/miembros/g/getOpenAI/', requestOptions)
    .then((response) => response.json())
    .then((data) => {
      console.log("Retrieve thread: ", data);

      const initialAssistantMessage = chatbox.querySelector(".chat.incoming");

      // Eliminar todos los mensajes del chatbox excepto el inicial
      chatbox.innerHTML = initialAssistantMessage.outerHTML;

      // Agregar los mensajes recuperados
      for (let i = data.data.length - 1; i >= 0; i--) {
        const message = data.data[i];
        if (message.role === "user") {
          chatbox.appendChild(
            createChatList(message.content[0].text.value, "outgoing")
          );
        } else if (message.role === "assistant") {
          chatbox.appendChild(
            createChatList(message.content[0].text.value, "incoming")
          );
        }
      }

      // Hacer scroll hacia abajo para mostrar los mensajes más recientes
      chatbox.scrollTo(0, chatbox.scrollHeight);

      hasElementCreated = true;
    })
    .catch((error) => {
      console.error("Error al recuperar el hilo: ", error);
    });
};

const handleChat = () => {
  let userMessage = chatInput.value.trim();

  // Si el mensaje del usuario está vacío, establecer un mensaje predeterminado
  if (!userMessage) {
    userMessage = `Hola, estoy ubicado en el estado de ${estadoSeleccionado} y tengo un tipo de daycare ${daycareSeleccionado}.`;
  }
  console.log("User Message: ", userMessage);

  if (!userMessage) return;

  // Agregar el mensaje del usuario al chatbox primero (outgoing)
  chatbox.appendChild(createChatList(userMessage, "outgoing"));
  chatbox.scrollTo(0, chatbox.scrollHeight);
  currentRunId = null;

  // Limpiar el textarea
  chatInput.value = "";

  // Deshabilitar el botón
  boton.disabled = true;

  // Deshabilitar la textarea
  textarea.disabled = true;

  // Mostrar mensaje de escribiendo mientras responde
  const incomingChatLI = createWritingList("incoming");
  chatbox.appendChild(incomingChatLI);
  chatbox.scrollTo(0, chatbox.scrollHeight);

  // Simular respuesta después de un tiempo (aquí deberías llamar a tu función que maneja la respuesta de la IA)
  setTimeout(() => {
    generateMessage(userMessage);
  }, 600);
};

sendChatBtn.addEventListener("click", handleChat);

document
  .getElementById("textareaMsg")
  .addEventListener("keydown", function (event) {
    // Verificar si la tecla presionada es "Enter" (código de tecla 13)
    if (event.key === "Enter") {
      // Evitar el comportamiento predeterminado de "Enter" en un textarea (salto de línea)
      event.preventDefault();
      handleChat();
    }
  });
