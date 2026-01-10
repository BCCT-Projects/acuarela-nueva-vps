let weekNumber;
let perpagecurriculum;
let momentoaprendizaje = [];
let actualLang = "es";

// Función para obtener el número de semana de una fecha
function getWeekNumber() {
  const d = new Date();
  d.setHours(0, 0, 0, 0);
  d.setDate(d.getDate() + 3 - ((d.getDay() + 6) % 7));
  const week1 = new Date(d.getFullYear(), 0, 4);
  return (
    1 +
    Math.round(((d - week1) / 86400000 - 3 + ((week1.getDay() + 6) % 7)) / 7)
  );
}

function get_alias(str) {
  str = str.replace(/¡/g, "", str); //Signo de exclamación abierta.&iexcl;
  str = str.replace(/'/g, "", str); //Signo de exclamación abierta.&iexcl;
  str = str.replace(/!/g, "", str); //Signo de exclamación abierta.&iexcl;
  str = str.replace(/¢/g, "-", str); //Signo de centavo.&cent;
  str = str.replace(/£/g, "-", str); //Signo de libra esterlina.&pound;
  str = str.replace(/¤/g, "-", str); //Signo monetario.&curren;
  str = str.replace(/¥/g, "-", str); //Signo del yen.&yen;
  str = str.replace(/¦/g, "-", str); //Barra vertical partida.&brvbar;
  str = str.replace(/§/g, "-", str); //Signo de sección.&sect;
  str = str.replace(/¨/g, "-", str); //Diéresis.&uml;
  str = str.replace(/©/g, "-", str); //Signo de derecho de copia.&copy;
  str = str.replace(/ª/g, "-", str); //Indicador ordinal femenino.&ordf;
  str = str.replace(/«/g, "-", str); //Signo de comillas francesas de apertura.&laquo;
  str = str.replace(/¬/g, "-", str); //Signo de negación.&not;
  str = str.replace(/®/g, "-", str); //Signo de marca registrada.&reg;
  str = str.replace(/¯/g, "&-", str); //Macrón.&macr;
  str = str.replace(/°/g, "-", str); //Signo de grado.&deg;
  str = str.replace(/±/g, "-", str); //Signo de más-menos.&plusmn;
  str = str.replace(/²/g, "-", str); //Superíndice dos.&sup2;
  str = str.replace(/³/g, "-", str); //Superíndice tres.&sup3;
  str = str.replace(/´/g, "-", str); //Acento agudo.&acute;
  str = str.replace(/µ/g, "-", str); //Signo de micro.&micro;
  str = str.replace(/¶/g, "-", str); //Signo de calderón.&para;
  str = str.replace(/·/g, "-", str); //Punto centrado.&middot;
  str = str.replace(/¸/g, "-", str); //Cedilla.&cedil;
  str = str.replace(/¹/g, "-", str); //Superíndice 1.&sup1;
  str = str.replace(/º/g, "-", str); //Indicador ordinal masculino.&ordm;
  str = str.replace(/»/g, "-", str); //Signo de comillas francesas de cierre.&raquo;
  str = str.replace(/¼/g, "-", str); //Fracción vulgar de un cuarto.&frac14;
  str = str.replace(/½/g, "-", str); //Fracción vulgar de un medio.&frac12;
  str = str.replace(/¾/g, "-", str); //Fracción vulgar de tres cuartos.&frac34;
  str = str.replace(/¿/g, "-", str); //Signo de interrogación abierta.&iquest;
  str = str.replace(/×/g, "-", str); //Signo de multiplicación.&times;
  str = str.replace(/÷/g, "-", str); //Signo de división.&divide;
  str = str.replace(/À/g, "a", str); //A mayúscula con acento grave.&Agrave;
  str = str.replace(/Á/g, "a", str); //A mayúscula con acento agudo.&Aacute;
  str = str.replace(/Â/g, "a", str); //A mayúscula con circunflejo.&Acirc;
  str = str.replace(/Ã/g, "a", str); //A mayúscula con tilde.&Atilde;
  str = str.replace(/Ä/g, "a", str); //A mayúscula con diéresis.&Auml;
  str = str.replace(/Å/g, "a", str); //A mayúscula con círculo encima.&Aring;
  str = str.replace(/Æ/g, "a", str); //AE mayúscula.&AElig;
  str = str.replace(/Ç/g, "c", str); //C mayúscula con cedilla.&Ccedil;
  str = str.replace(/È/g, "e", str); //E mayúscula con acento grave.&Egrave;
  str = str.replace(/É/g, "e", str); //E mayúscula con acento agudo.&Eacute;
  str = str.replace(/Ê/g, "e", str); //E mayúscula con circunflejo.&Ecirc;
  str = str.replace(/Ë/g, "e", str); //E mayúscula con diéresis.&Euml;
  str = str.replace(/Ì/g, "i", str); //I mayúscula con acento grave.&Igrave;
  str = str.replace(/Í/g, "i", str); //I mayúscula con acento agudo.&Iacute;
  str = str.replace(/Î/g, "i", str); //I mayúscula con circunflejo.&Icirc;
  str = str.replace(/Ï/g, "i", str); //I mayúscula con diéresis.&Iuml;
  str = str.replace(/Ð/g, "d", str); //ETH mayúscula.&ETH;
  str = str.replace(/Ñ/g, "n", str); //N mayúscula con tilde.&Ntilde;
  str = str.replace(/Ò/g, "o", str); //O mayúscula con acento grave.&Ograve;
  str = str.replace(/Ó/g, "o", str); //O mayúscula con acento agudo.&Oacute;
  str = str.replace(/Ô/g, "o", str); //O mayúscula con circunflejo.&Ocirc;
  str = str.replace(/Õ/g, "o", str); //O mayúscula con tilde.&Otilde;
  str = str.replace(/Ö/g, "o", str); //O mayúscula con diéresis.&Ouml;
  str = str.replace(/Ø/g, "o", str); //O mayúscula con barra inclinada.&Oslash;
  str = str.replace(/Ù/g, "u", str); //U mayúscula con acento grave.&Ugrave;
  str = str.replace(/Ú/g, "u", str); //U mayúscula con acento agudo.&Uacute;
  str = str.replace(/Û/g, "u", str); //U mayúscula con circunflejo.&Ucirc;
  str = str.replace(/Ü/g, "u", str); //U mayúscula con diéresis.&Uuml;
  str = str.replace(/Ý/g, "y", str); //Y mayúscula con acento agudo.&Yacute;
  str = str.replace(/Þ/g, "b", str); //Thorn mayúscula.&THORN;
  str = str.replace(/ß/g, "b", str); //S aguda alemana.&szlig;
  str = str.replace(/à/g, "a", str); //a minúscula con acento grave.&agrave;
  str = str.replace(/á/g, "a", str); //a minúscula con acento agudo.&aacute;
  str = str.replace(/â/g, "a", str); //a minúscula con circunflejo.&acirc;
  str = str.replace(/ã/g, "a", str); //a minúscula con tilde.&atilde;
  str = str.replace(/ä/g, "a", str); //a minúscula con diéresis.&auml;
  str = str.replace(/å/g, "a", str); //a minúscula con círculo encima.&aring;
  str = str.replace(/æ/g, "a", str); //ae minúscula.&aelig;
  str = str.replace(/ç/g, "a", str); //c minúscula con cedilla.&ccedil;
  str = str.replace(/è/g, "e", str); //e minúscula con acento grave.&egrave;
  str = str.replace(/é/g, "e", str); //e minúscula con acento agudo.&eacute;
  str = str.replace(/ê/g, "e", str); //e minúscula con circunflejo.&ecirc;
  str = str.replace(/ë/g, "e", str); //e minúscula con diéresis.&euml;
  str = str.replace(/ì/g, "i", str); //i minúscula con acento grave.&igrave;
  str = str.replace(/í/g, "i", str); //i minúscula con acento agudo.&iacute;
  str = str.replace(/î/g, "i", str); //i minúscula con circunflejo.&icirc;
  str = str.replace(/ï/g, "i", str); //i minúscula con diéresis.&iuml;
  str = str.replace(/ð/g, "i", str); //eth minúscula.&eth;
  str = str.replace(/ñ/g, "n", str); //n minúscula con tilde.&ntilde;
  str = str.replace(/ò/g, "o", str); //o minúscula con acento grave.&ograve;
  str = str.replace(/ó/g, "o", str); //o minúscula con acento agudo.&oacute;
  str = str.replace(/ô/g, "o", str); //o minúscula con circunflejo.&ocirc;
  str = str.replace(/õ/g, "o", str); //o minúscula con tilde.&otilde;
  str = str.replace(/ö/g, "o", str); //o minúscula con diéresis.&ouml;
  str = str.replace(/ø/g, "o", str); //o minúscula con barra inclinada.&oslash;
  str = str.replace(/ù/g, "o", str); //u minúscula con acento grave.&ugrave;
  str = str.replace(/ú/g, "u", str); //u minúscula con acento agudo.&uacute;
  str = str.replace(/û/g, "u", str); //u minúscula con circunflejo.&ucirc;
  str = str.replace(/ü/g, "u", str); //u minúscula con diéresis.&uuml;
  str = str.replace(/ý/g, "y", str); //y minúscula con acento agudo.&yacute;
  str = str.replace(/þ/g, "b", str); //thorn minúscula.&thorn;
  str = str.replace(/ÿ/g, "y", str); //y minúscula con diéresis.&yuml;
  str = str.replace(/Œ/g, "d", str); //OE Mayúscula.&OElig;
  str = str.replace(/œ/g, "-", str); //oe minúscula.&oelig;
  str = str.replace(/Ÿ/g, "-", str); //Y mayúscula con diéresis.&Yuml;
  str = str.replace(/ˆ/g, "", str); //Acento circunflejo.&circ;
  str = str.replace(/˜/g, "", str); //Tilde.&tilde;
  str = str.replace(/–/g, "", str); //Guiún corto.&ndash;
  str = str.replace(/—/g, "", str); //Guiún largo.&mdash;
  str = str.replace(/'/g, "", str); //Comilla simple izquierda.&lsquo;
  str = str.replace(/'/g, "", str); //Comilla simple derecha.&rsquo;
  str = str.replace(/,/g, "", str); //Comilla simple inferior.&sbquo;
  str = str.replace(/"/g, "", str); //Comillas doble derecha.&rdquo;
  str = str.replace(/"/g, "", str); //Comillas doble inferior.&bdquo;
  str = str.replace(/†/g, "-", str); //Daga.&dagger;
  str = str.replace(/‡/g, "-", str); //Daga doble.&Dagger;
  str = str.replace(/…/g, "-", str); //Elipsis horizontal.&hellip;
  str = str.replace(/‰/g, "-", str); //Signo de por mil.&permil;
  str = str.replace(/‹/g, "-", str); //Signo izquierdo de una cita.&lsaquo;
  str = str.replace(/›/g, "-", str); //Signo derecho de una cita.&rsaquo;
  str = str.replace(/€/g, "-", str); //Euro.&euro;
  str = str.replace(/™/g, "-", str); //Marca registrada.&trade;
  str = str.replace(/ & /g, "-", str); //Marca registrada.&trade;
  str = str.replace(/\(/g, "-", str);
  str = str.replace(/\)/g, "-", str);
  str = str.replace(/�/g, "-", str);
  str = str.replace(/\//g, "-", str);
  str = str.replace(":", "", str);
  str = str.replace(/ de /g, "-", str); //Espacios
  str = str.replace(/ y /g, "-", str); //Espacios
  str = str.replace(/ a /g, "-", str); //Espacios
  str = str.replace(/ DE /g, "-", str); //Espacios
  str = str.replace(/ A /g, "-", str); //Espacios
  str = str.replace(/ Y /g, "-", str); //Espacios
  str = str.replace(/ /g, "-", str); //Espacios
  str = str.replace(/  /g, "-", str); //Espacios
  str = str.replace(/\./g, "", str); //Punto
  str = str.replace("’", "", str);
  str = str.replace("‘", "", str);
  str = str.replace("“", "", str);
  str = str.replace("”", "", str);
  str = str.replace("+", "", str);

  //Mayusculas
  str = str.toLowerCase();

  return str;
}
$(document).ready(function () {
  $(".wait").click(function () {
    $("#preloader").fadeIn();
  });
  $(".useroptions").click(function () {
    $(this).toggleClass("open");
  });
});
const colorsStroke = ["FFB600", "FC3286", "60CEBD", "8E5AC6"];
const colorsStrokeMapping = {
  "Actividad de Estimulación": "#8E5AC6",
  "Actividades al aire libre": "#0B8E38",
  "Actividades de la tarde": "#EA5617",
  Adivinanza: "#1773BA",
  "Agua y arena": "#00A099",
  Almuerzo: "#39A8E0",
  "Arte y escritura": "#E95A95",
  "Arte y manualidades": "#FFB600",
  "Bloque y construcción": "#F05555",
  Canción: "#624595",
  "Ciencia y descubrimiento": "#0085CC",
  Cocina: "#E8661D",
  Despedida: "#544998",
  "Aire libre": "#0B8E38",
  Emocional: "#ED72A7",
  "Juegos de representación": "#CF3737",
  "Lavado de manos": "#4FBCC0",
  "Lenguaje y comunicación": "#8E5AC6",
  Matemáticas: "#FC3286",
  Montessori: "#5872FD",
  "Música y movimiento": "#73B73B",
  "Reggio Emilia": "#4CC148",
  "Reunión matutina": "#E8501D",
  Sensorial: "#488AC9",
  Siesta: "#50BCC0",
  Snack: "#39A8E0",
  "Story time": "#1773BA",
  "Tiempo de circulo": "#84C174",
  Transiciones: "#7B61FF",
  "Grupo pequeño": "#FFB600",
};

const colorsFill = ["FFFBF4", "FFEEF5", "EEFFFC", "F2E7FF"];
const colorsFillMapping = {
  "Actividad de Estimulación": "#F2E7FF",
  "Actividades al aire libre": "#E8F9EC",
  "Actividades de la tarde": "#FDEBE4",
  Adivinanza: "#E5F3FC",
  "Agua y arena": "#EEFFFC",
  Almuerzo: "#E9F7FE",
  "Arte y escritura": "#FDE8F1",
  "Arte y manualidades": "#FFF4DC",
  "Bloque y construcción": "#FFE9E9",
  Canción: "#EFE8F7",
  "Ciencia y descubrimiento": "#E5F4FC",
  Cocina: "#FDEDE3",
  Despedida: "#EDE8F7",
  "Aire libre": "#E8F9EC",
  Emocional: "#FEEAF3",
  "Juegos de representación": "#FBE5E5",
  "Lavado de manos": "#EEFFFC",
  "Lenguaje y comunicación": "#F2E7FF",
  Matemáticas: "#FDE4F2",
  Montessori: "#E9EDFE",
  "Música y movimiento": "#EDF7E9",
  "Reggio Emilia": "#E9F8E8",
  "Reunión matutina": "#FDEAE3",
  Sensorial: "#E5F2FC",
  Siesta: "#EEFFFC",
  Snack: "#E9F7FE",
  "Story time": "#E5F3FC",
  "Tiempo de circulo": "#EDF8E9",
  Transiciones: "#ECE7FF",
  "Grupo pequeño": "#FFF4DC",
};

let meses = [
  "enero",
  "febrero",
  "marzo",
  "abril",
  "mayo",
  "junio",
  "julio",
  "agosto",
  "septiembre",
  "octubre",
  "noviembre",
  "diciembre",
];
window.addEventListener("load", function () {
  // deSVG(".optionpoints", true);
  const fechaInput = document.getElementById("fecha");
  if (fechaInput) {
    const fechaHoy = new Date().toISOString().split("T")[0];
    fechaInput.value = fechaHoy;
    seleccionarSemana();
  }
});

const getforWP = async (type, id) => {
  const response = await fetch(`get/${type}.php?id=${id}`);
  const data = await response.json();
  return {
    title: data.title.rendered,
    icon: data.acf.icono,
    type: data.acf.tipo_de_dominio,
    typeLocal: type,
  };
};
function seleccionarSemana() {
  // Obtener el valor de la fecha seleccionada
  var fecha = document.getElementById("fecha").value;

  // Calcular la fecha de inicio de la semana correspondiente a la fecha seleccionada
  var fechaInicioSemana = new Date(fecha);
  var diaSemana = fechaInicioSemana.getDay();
  fechaInicioSemana.setDate(fechaInicioSemana.getDate() - diaSemana);

  // Calcular la fecha de fin de la semana correspondiente a la fecha seleccionada
  var fechaFinSemana = new Date(fecha);
  fechaFinSemana.setDate(fechaFinSemana.getDate() - diaSemana + 6);
  getWeekNumber();
}
$.validator.methods.email = function (value, element) {
  return (
    this.optional(element) ||
    /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/.test(
      value
    )
  );
};

if (document.querySelector("#loginB")) {
  $("#loginB").validate({
    ignore: "",
    rules: {
      email: { required: true, email: true },
      pass: { minlength: 5 },
    },
    messages: {
      email: {
        required: "El E-mail es obligatorio!",
        email: "El E-mail no es válido!",
      },
      pass: { minlength: "La contraseña debe contener mínimo 6 caracteres!" },
    },
    submitHandler: function (form) {
      document.querySelector(".preloader h2").innerHTML =
        "Estamos validando tus datos...";
      $(".preloader").fadeIn();
      $("#loginB button[type='submit']").attr("disabled", true);
      $("#loginB button[type='submit']").text("Enviando");

      $("#loginB").ajaxSubmit({
        dataType: "json",
        success: function (data) {
          if (data.id) {
            document.querySelector(".noAccount").classList.remove("active");
            $("#loginB button[type='submit']").attr("disabled", false);
            // Siempre redirigir a cambiar-daycare después del login
            window.location.href = "/miembros/acuarela-app-web/cambiar-daycare?fromLogin=1";
          } else {
            document.querySelector(".noAccount").classList.add("active");
            trackLoginError("Usuario no registrado");
            $("#loginB button[type='submit']").text("Reintentar");
            $("#loginB button[type='submit']").attr("disabled", false);
            $(".preloader").fadeOut();
          }
        },
      });
      /*
       */
    },
  });
}
if (document.querySelector("#recoverpass")) {
  $("#recoverpass").validate({
    ignore: "",
    rules: {
      email: { required: true, email: true },
    },
    messages: {
      email: {
        required: "El E-mail es obligatorio!",
        email: "El E-mail no es válido!",
      },
    },
    submitHandler: function (form) {
      $("#recoverpass button[type='submit']").attr("disabled", true);
      $("#recoverpass button[type='submit']").text("Enviando");
      $("#recoverpass").ajaxSubmit({
        dataType: "json",
        success: function (data) {
          $("#recoverpass button[type='submit']").attr("disabled", false);
          trackPasswordRecovery();
          document.querySelector(
            "form"
          ).innerHTML = `<h1>¡Correo Enviado!</h1><p>Hemos enviado un correo con un enlace para que puedas recuperar tu contraseña. Revisa tu bandeja de entrada y sigue las instrucciones.</p>`;
        },
      });
      /*
       */
    },
  });
}
const mensajes = [
  "Estamos creando tu cuenta...",
  "Por favor, espera un momento...",
  "Casi listo...",
  "Aquí inicia el camino a ser un daycare 10/10...",
  "¡Cuenta creada exitosamente!",
];
// Función para mostrar mensajes con un retraso
function mostrarMensajesConRetraso(mensajes, indice) {
  if (indice < mensajes.length) {
    // Obtener el elemento HTML donde mostrar el mensaje
    const preloaderMensaje = document.querySelector(".preloader h2");
    // Mostrar el mensaje actual
    preloaderMensaje.innerHTML = mensajes[indice];
    // Incrementar el índice para mostrar el próximo mensaje
    indice++;
    // Llamar a esta función recursivamente después de cierto tiempo
    setTimeout(() => {
      mostrarMensajesConRetraso(mensajes, indice);
    }, 6000); // 2000 milisegundos = 2 segundos de retraso entre mensajes (puedes ajustar este valor según tus necesidades)
  }
}
if (document.querySelector("#register")) {
  $("#register").validate({
    ignore: "",
    rules: {
      name: "required",
      lastname: "required",
      email: {
        required: true,
        email: { betterEmail: true },
      },
      phone: "required",
      password: {
        required: true,
        minlength: 6,
        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/,
      },
      repeat: {
        required: true,
        minlength: 6,
        equalTo: "#password",
      },
    },
    messages: {
      name: "*Este campo es obligatorio",
      lastname: "*Este campo es obligatorio",
      email: {
        required: "*Este campo es obligatorio",
      },
      phone: "*Este campo es obligatorio",
      password: {
        required: "*Este campo es obligatorio",
        minlength: "*La contraseña es demasiado débil. Min. 6 caracteres",
        pattern:
          "*Debe contener al menos una mayúscula, una minúscula, un número y un carácter especial",
      },
      repeat: {
        required: "*Este campo es obligatorio",
        minlength: "*La contraseña es demasiado débil. Min. 6 caracteres",
        equalTo: "*Las contraseñas no coinciden",
      },
    },
    submitHandler: function (form) {
      $(".preloader").fadeIn();
      $("#register button#createAccount")
        .attr("disabled", true)
        .text("Enviando");

      let dialCode = document.querySelector(".iti__active")
        ? document.querySelector(".iti__active").dataset.dialCode
        : document
          .querySelector(".iti__selected-flag")
          .title.split(":")[1]
          .trim();
      document.querySelector("#phone").value = `+${dialCode}${document.querySelector("#phone").value
        }`;

      let dialCodeDaycare = document.querySelector(".iti__active")
        ? document.querySelector(".iti__active").dataset.dialCode
        : document
          .querySelector(".iti__selected-flag")
          .title.split(":")[1]
          .trim();
      document.querySelector("#phonedaycare").value = `+${dialCodeDaycare}${document.querySelector("#phonedaycare").value
        }`;

      $("#register").ajaxSubmit({
        dataType: "json",
        success: function (data) {
          if (data.response.registerUser.code == "e-2") {
            $("#register button#createAccount").text("Reintentar");
            document.querySelector("small.emailExist").style.display = "block";
            $("#register button#createAccount").attr("disabled", false);
          } else {
            trackNewUserRegistration();
            window.location.href = `/miembros/daycare/${get_alias(
              data.response.registerUser.daycares[0].name
            )}/${data.response.registerUser.daycares[0].id}`;
            $("#register button#createAccount").attr("disabled", false);
          }
        },
      });
    },
  });
}
if (document.querySelector("#daycareForm")) {
  $("#daycareForm").validate({
    ignore: "",
    rules: {},
    messages: {},
    submitHandler: function (form) {
      $("#daycareForm button[type='submit']").attr("disabled", true);
      $("#daycareForm button[type='submit']").text("Enviando");
      $("#daycareForm").ajaxSubmit({
        dataType: "json",
        success: function (data) {
          trackDaycareUpdate();
          location.reload();
        },
      });
    },
  });
}
if (document.querySelector("#addDaycareForm")) {
  $("#addDaycareForm").validate({
    ignore: "",
    rules: {},
    messages: {},
    submitHandler: function (form) {
      setMaxHeightForSteps();
      $("#addDaycareForm button").attr("disabled", true);
      $("#addDaycareForm button").text("Enviando");
      $("#addDaycareForm").ajaxSubmit({
        dataType: "json",
        success: function (data) {
          trackDaycareCreate();
          window.location.href = "/miembros/acuarela-app-web/";
        },
      });
    },
  });
}
if (document.querySelector("#editUser")) {
  $("#editUser").validate({
    ignore: "",
    rules: {},
    messages: {},
    submitHandler: function (form) {
      $(".preloader").fadeIn();
      document.querySelector(".preloader h2").innerHTML =
        "¡Estamos actualizando tu información!";
      $("#editUser button[type='submit']").attr("disabled", true);
      $("#editUser button[type='submit']").text("Enviando");
      $("#editUser").ajaxSubmit({
        dataType: "json",
        success: function (data) {
          $(".preloader").fadeOut();
          window.location.reload();
        },
      });
    },
  });
}
if (document.querySelector("#temas")) {
  let temasIds = [];
  document.querySelectorAll(".activity").forEach((act) => {
    let temasArray = JSON.parse(act.dataset.tema);
    temasArray.forEach((tema) => {
      temasIds.push(tema);
    });
  });
  temasIds.forEach((temaID) => {
    document.querySelector(`option[value="${temaID}"]`).style.display = "block";
  });
}
async function validateEmailExist(el) {
  el.target.parentElement.classList.add("loading");
  try {
    const email = el.target.value;
    if (email != "") {
      const responseEmail = await validateEmailStrapi(email);
      if (responseEmail.length > 0) {
        document.querySelector(
          "#dialog-content a"
        ).href = `/miembros/?email=${email}`;
        Fancybox.show([{ src: "#dialog-content", type: "inline" }]);
        showErrorMessage("emailExist", "Este correo ya está registrado");
      } else {
        document.querySelector(".emailExist").style.display = "none";
      }
    }
    el.target.parentElement.classList.remove("loading");
  } catch (error) {
    console.error("Error occurred while validating email:", error.message);
    // Handle the error gracefully, e.g., show a general error message to the user.
  }
}

async function validateEmailStrapi(email) {
  try {
    const url = `g/emailValidation/?email=${email}`;
    const response = await fetch(url);
    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error occurred while fetching data:", error.message);
    throw error; // Propagate the error to the calling function.
  }
}

function showErrorMessage(className, message) {
  const errorElement = document.querySelector(`small.${className}`);
  errorElement.textContent = message;
  errorElement.style.display = "block";
}

let indexStep = 0;
let stepsCount = document.querySelectorAll(".steps").length - 1;

const prevButton = document.getElementById("prevButton");
const nextButton = document.getElementById("nextButton");
const createAccountButton = document.getElementById("createAccount");

function showStep(stepIndex) {
  const steps = document.querySelectorAll(".steps");
  steps.forEach((step, index) => {
    if (index === stepIndex) {
      step.classList.add("active");
    } else {
      step.classList.remove("active");
    }
  });

  if (stepIndex === stepsCount) {
    createAccountButton.style.display = "flex";
    nextButton.style.display = "none";
  } else {
    createAccountButton.style.display = "none";
    nextButton.style.display = "flex";
  }

  if (stepIndex === 0) {
    prevButton.style.display = "none";
  } else {
    prevButton.style.display = "flex";
  }
}
function updateProgressBar() {
  const progress = (indexStep / stepsCount) * 100;
  const progressBar = document.querySelector(".progress-bar");
  progressBar.style.width = `${progress}%`;
}

function nextStep() {
  if (indexStep < stepsCount) {
    indexStep++;
    document
      .querySelectorAll(".steps")
    [indexStep].classList.add("slide-in-right");
    showStep(indexStep);
    updateProgressBar();
    document
      .querySelectorAll(".steps")
    [indexStep].classList.remove("slide-in-right");
  }
}

function prevStep() {
  if (indexStep > 0) {
    indexStep--;
    document
      .querySelectorAll(".steps")
    [indexStep].classList.add("slide-in-left");
    showStep(indexStep);
    updateProgressBar();
    document
      .querySelectorAll(".steps")
    [indexStep].classList.remove("slide-in-left");
  }
}
if (prevButton || nextButton) {
  // Initially, show the first step and hide the "Anterior" button
  prevButton.style.display = "none";

  // Add event listeners to the "Anterior" and "Siguiente" buttons
  prevButton.addEventListener("click", prevStep);
  nextButton.addEventListener("click", nextStep);
}

function setMaxHeightForSteps() {
  const steps = document.querySelectorAll(".steps");
  let maxHeight = 0;

  // Temporarily show the hidden steps to calculate their heights
  steps.forEach((step) => {
    step.style.visibility = "hidden";
    step.classList.add("active");
    const stepHeight = step.getBoundingClientRect().height;
    if (stepHeight > maxHeight) {
      maxHeight = stepHeight;
    }
    step.style.visibility = "visible";
    step.classList.remove("active");
  });

  // Set the calculated height for all steps
  steps.forEach((step) => {
    step.style.height = `${maxHeight}px`;
  });
  steps[0].classList.add("active");
}

const dprovider = document.querySelector(".daycare-provider");
const dasistente = document.querySelector(".daycare-asistente");
const radioButtons = document.querySelectorAll("input[name='rol']");

function updateLicenseFieldVisibility() {
  const selectedValue = document.querySelector("input[name='rol']:checked").id;
  if (selectedValue === "administrator" || selectedValue === "onsideprovider") {
    dprovider.style.display = "block";
    dasistente.style.display = "none";
  } else {
    dprovider.style.display = "none";
    dasistente.style.display = "block";
  }
}

// Agregar un evento 'change' a los radio buttons para actualizar la visibilidad del campo
radioButtons.forEach((radio) => {
  radio.addEventListener("change", updateLicenseFieldVisibility);
});

function togglePasswordVisibility() {
  let passwordField = document.getElementById("password");
  let repeatPasswordField = document.getElementById("password");

  if (passwordField.getAttribute("type") === "password") {
    passwordField.setAttribute("type", "text");
    repeatPasswordField.setAttribute("type", "text");
  } else {
    passwordField.setAttribute("type", "password");
    repeatPasswordField.setAttribute("type", "password");
  }
}
const fecha = new Date(); // Obtén la fecha actual
const inicioAnio = new Date(fecha.getFullYear(), 0, 1); // Primero de enero del año actual
const milisegundosDia = 24 * 60 * 60 * 1000; // Milisegundos en un día
const diasTranscurridos = Math.floor((fecha - inicioAnio) / milisegundosDia);
const numeroSemana = Math.ceil(
  (diasTranscurridos + inicioAnio.getDay() + 1) / 7
);
/**
 * Función mejorada con manejo defensivo de errores
 * Valida que la respuesta sea JSON antes de parsear
 * Devuelve [] en caso de error para evitar romper el código
 */
const sendPostRequest = async (endpoint) => {
  try {
    var formdata = new FormData();
    formdata.append("endpoint", endpoint);
    var requestOptions = {
      method: "POST",
      body: formdata,
      redirect: "follow",
    };
    
    const response = await fetch("g/getWp/", requestOptions);
    
    // Validar que la respuesta sea exitosa
    if (!response.ok) {
      console.error(`[requestWP] Error HTTP ${response.status} para endpoint: ${endpoint}`);
      return [];
    }
    
    // Validar que el Content-Type sea JSON antes de parsear
    const contentType = response.headers.get("content-type");
    if (!contentType || !contentType.includes("application/json")) {
      const text = await response.text();
      console.error(`[requestWP] Respuesta no es JSON para endpoint: ${endpoint}`, {
        contentType,
        preview: text.substring(0, 200)
      });
      return [];
    }
    
    const result = await response.json();
    
    // Validar que el resultado sea un array o objeto válido
    if (result === null || result === undefined) {
      console.warn(`[requestWP] Respuesta null/undefined para endpoint: ${endpoint}`);
      return [];
    }
    
    return result;
  } catch (error) {
    console.error(`[requestWP] Error al procesar endpoint: ${endpoint}`, error);
    return [];
  }
};

/**
 * Wrapper para requestWP que asegura que siempre devuelva un array
 */
const requestWP = async (endpoint) => {
  try {
    const response = await sendPostRequest(endpoint);
    // Asegurar que siempre sea un array
    return Array.isArray(response) ? response : (response ? [response] : []);
  } catch (error) {
    console.error(`[requestWP] Error crítico para endpoint: ${endpoint}`, error);
    return [];
  }
};

/**
 * Función optimizada para hacer múltiples consultas WordPress en paralelo
 * Usa el endpoint getWpParallel.php que hace todas las consultas en una sola petición PHP
 * Esto reduce significativamente el tiempo de respuesta y evita errores 524
 * Manejo defensivo de errores: si falla, devuelve arrays vacíos en lugar de romper
 */
const requestWPParallel = async (endpoints) => {
  // Si solo hay un endpoint, usar el método normal
  if (!Array.isArray(endpoints) || endpoints.length === 1) {
    const result = await requestWP(endpoints[0] || endpoints);
    return Array.isArray(result) ? result : [result];
  }
  
  // Crear array asociativo para mantener el orden
  const endpointsMap = {};
  endpoints.forEach((endpoint, index) => {
    endpointsMap[`query_${index}`] = endpoint;
  });
  
  try {
    var formdata = new FormData();
    formdata.append("endpoints", JSON.stringify(endpointsMap));
    
    var requestOptions = {
      method: "POST",
      body: formdata,
      redirect: "follow",
    };
    
    const response = await fetch("g/getWpParallel/", requestOptions);
    
    // Validar que la respuesta sea exitosa
    if (!response.ok) {
      console.error(`[requestWPParallel] Error HTTP ${response.status}`);
      // Fallback: hacer las consultas individualmente con manejo de errores
      return Promise.allSettled(
        endpoints.map(endpoint => requestWP(endpoint))
      ).then(results => results.map(r => r.status === 'fulfilled' ? r.value : []));
    }
    
    // Validar que el Content-Type sea JSON antes de parsear
    const contentType = response.headers.get("content-type");
    if (!contentType || !contentType.includes("application/json")) {
      const text = await response.text();
      console.error(`[requestWPParallel] Respuesta no es JSON`, {
        contentType,
        preview: text.substring(0, 200)
      });
      // Fallback: hacer las consultas individualmente
      return Promise.allSettled(
        endpoints.map(endpoint => requestWP(endpoint))
      ).then(results => results.map(r => r.status === 'fulfilled' ? r.value : []));
    }
    
    const result = await response.json();
    
    // Validar que el resultado sea un objeto válido
    if (!result || typeof result !== 'object') {
      console.error(`[requestWPParallel] Resultado inválido:`, result);
      // Fallback: hacer las consultas individualmente
      return Promise.allSettled(
        endpoints.map(endpoint => requestWP(endpoint))
      ).then(results => results.map(r => r.status === 'fulfilled' ? r.value : []));
    }
    
    // Convertir el objeto asociativo de vuelta a un array en el mismo orden
    const resultsArray = [];
    Object.keys(endpointsMap).forEach((key) => {
      if (result[key] !== undefined && result[key] !== null) {
        // Asegurar que cada resultado sea un array
        const value = result[key];
        resultsArray.push(Array.isArray(value) ? value : [value]);
      } else {
        console.warn(`[requestWPParallel] Falta resultado para ${key}`);
        resultsArray.push([]); // Fallback: array vacío si falta algún resultado
      }
    });
    
    return resultsArray;
  } catch (error) {
    console.error("[requestWPParallel] Error crítico:", error);
    // Fallback: hacer las consultas individualmente con manejo de errores
    return Promise.allSettled(
      endpoints.map(endpoint => requestWP(endpoint))
    ).then(results => results.map(r => r.status === 'fulfilled' ? r.value : []));
  }
};
const getSingleAge = async (id) => {
  const response = await requestWP(`gruposdeedad/${id}?_fields=title,id`);
  return response.title.rendered;
};

const updateElementsWithData = async (
  elements,
  data,
  colorfill,
  colorstroke
) => {
  const updateElementData = async (element, obj) => {
    // console.log("dentro de updateElementData");
    const currentLang = document.getElementById("lang").value;

    element.dataset.momento = obj.acf.momento_de_aprendizaje
      ? obj.acf.momento_de_aprendizaje.map((el) => el.post_title)
      : "";

    // Modificado para agregar el idioma en caso de song o storie
    element.dataset.theid =
      element.classList.contains("storie") || element.classList.contains("song")
        ? `${obj.id}-${currentLang}`
        : obj.id;

    element.dataset.description = obj.content.rendered;
    element.dataset.title = obj.title.rendered;
    element.dataset.curriculum = obj.acf.curriculum
      ? obj.acf.curriculum.map((el) => el.ID)
      : "";
    element.dataset.edad = obj.acf.grupo_de_edad
      ? obj.acf.grupo_de_edad.map((el) => el.post_title).join(", ")
      : "";
    element.dataset.objetivos = obj.acf.objetivos;
    element.dataset.instrucciones = obj.acf.instrucciones;
    element.dataset.tiempo = obj.acf.tiempo_en_minutos;
    element.dataset.tema = obj.acf.tema
      ? obj.acf.tema.map((el) => el.post_title)
      : "";
    element.dataset.materiales = obj.acf.materiales.replace(
      /<\/?b>|&nbsp;/g,
      ""
    );
    element.dataset.materiales_reciclables = obj.acf.materiales_reciclables ? obj.acf.materiales_reciclables.replace(/<\/?b>|&nbsp;/g, "") : "";
    element.dataset.tips = obj.acf.tips;
    element.dataset.foto = obj.acf.foto.url;
    element.dataset.dominios_uc = obj.acf.dominios_uc
      ? obj.acf.dominios_uc.map((el) => el.ID)
      : "";
    element.dataset.multimedia = obj.acf.multimedia
      ? obj.acf.multimedia.url
      : "";
    element.dataset.multimedia_en = obj.acf.multimedia_en
      ? obj.acf.multimedia_en.url
      : "";
    element.dataset.link_de_cancion = obj.acf.link_de_cancion;
    element.dataset.link_de_cuento = obj.acf.link_de_cuento;
    element.dataset.elof = obj.acf.elof ? obj.acf.elof.map((el) => el.ID) : "";
    element.dataset.enfoque = obj.acf.enfoque_general
      ? obj.acf.enfoque_general.map((el) => el.ID)
      : "";
    element.dataset.aprendizaje = obj.acf.estilo_aprendizaje
      ? obj.acf.estilo_aprendizaje.map((el) => el.ID)
      : "";
    element.dataset.colorfill = colorfill;
    element.dataset.colorstroke = colorstroke;
    element.style.display = "flex";
    element.style.opacity = 1;
    element.dataset.tipo = obj.acf.tipo_de_actividad;

    let title = obj.title.rendered.split(":")[1] || obj.title.rendered;

    if (
      !element.classList.contains("storie") &&
      !element.classList.contains("song")
    ) {
      // Guardar el contenido inicial (el span con la imagen/icono)
      const spanInicial = element.querySelector('span:first-child');
      const contenidoInicial = spanInicial ? spanInicial.outerHTML : '';
      
      // Remover todos los spans excepto el inicial (que tiene la imagen/icono)
      const spans = Array.from(element.querySelectorAll('span'));
      spans.forEach((span) => {
        if (span !== spanInicial) {
          span.remove();
        }
      });
      
      // Restaurar el contenido inicial si se perdió
      if (!element.querySelector('span:first-child') && contenidoInicial) {
        element.innerHTML = contenidoInicial;
      }
      
      // Agregar el nuevo título
      element.innerHTML += `<span>${title}</span>`;
      
      // Agregar el span de gruposDeEdad
      const span = document.createElement("span");
      span.className = "gruposDeEdad";
      span.style.cssText = `
        width: 100%;
        position: relative;
        right: -15px;
        min-height: auto;
        font-size: 12px;
        font-weight: 600;
        color: white;
        margin-top: 10px;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        padding: 2px 5px;
      `;
      span.textContent = element.dataset.edad;
      element.appendChild(span);
    }

    translateInDOM(currentLang);
  };

  if (data.length === 1) {
    if (elements.length > 0) {
      elements.forEach((element) => {
        if (data[0]) {
          updateElementData(element, data[0]);
        }
      });
    }
  } else {
    if (elements.length > 0) {
      elements.forEach((element, i) => {
        if (data[i]) {
          updateElementData(element, data[i]);
        }
      });
    }
  }
};

// 194 Intermedio
// 195 3K
// 5828 Homeschooling
// 647 Infantes
// 79 Basico
// 96224 Universal Curriculum After Schoolers Summer Edition

// if (curriculumID != "") {
//   switch (curriculumID) {
//     case 194:
//       perpagecurriculum = 20;
//       weekNumber = getWeekNumber();

//       break;
//     case 195:
//       perpagecurriculum = 40;
//       weekNumber = getWeekNumber();

//       break;
//     case 96224:
//       perpagecurriculum = 40;
//       weekNumber = getWeekNumber();

//       break;
//     case 5828:
//       perpagecurriculum = 30;
//       weekNumber = getWeekNumber();

//       break;
//     case 647:
//       perpagecurriculum = 30;
//       weekNumber = getWeekNumber();

//       break;
//     case 79:
//       perpagecurriculum = 5;
//       weekNumber = getWeekNumber();

//       break;
//     default:
//       perpagecurriculum = 5;
//       weekNumber = getWeekNumber();
//       break;
//   }
// }

if (curriculumID != "") {
  switch (curriculumID) {
    case 194:
      perpagecurriculum = 20;
      weekNumber = getWeekNumber();
      break;
    case 195:
      perpagecurriculum = 40;
      weekNumber = getWeekNumber();
      break;
    case 96224:
      perpagecurriculum = 40;
      weekNumber = getWeekNumber();
      break;
    case 5828:
      perpagecurriculum = 30;
      weekNumber = getWeekNumber();
      break;
    case 647:
      perpagecurriculum = 30;
      weekNumber = getWeekNumber();
      break;
    case 79:
      perpagecurriculum = 5;
      weekNumber = getWeekNumber();
      break;
    default:
      perpagecurriculum = 5;
      weekNumber = getWeekNumber();
      break;
  }
}

// Supongamos que requestWP es una función asincrónica que realiza la solicitud y devuelve una promesa
let elofPromises = [];
let dominioPromises = [];
let momentosPromises = [];
let enfoquePromises = [];

async function getElofAndDominios() {
  let elofRequest = []; // Asegúrate de haber declarado elofRequest y dominioRequest previamente
  let dominioRequest = [];
  let momentoRequest = [];
  let enfoqueRequest = [];

  if (elofRequest.length == 0) {
    elofRequest = await requestWP("elof?per_page=100");
  }
  if (dominioRequest.length == 0) {
    dominioRequest = await requestWP("dominiouc?per_page=100");
  }
  if (momentoRequest.length == 0) {
    momentoRequest = await requestWP("momentoaprendizaje?per_page=100");
  }
  if (enfoqueRequest.length == 0) {
    enfoqueRequest = await requestWP("enfoque-general?per_page=100");
  }

  elofPromises = elofRequest.map((x) => {
    return {
      id: x.id,
      title: x.title.rendered,
      icon: x.acf.icono,
      type: x.acf.tipo_de_dominio,
      typeLocal: "elof",
    };
  });
  dominioPromises = dominioRequest.map((x) => {
    return {
      id: x.id,
      title: x.title.rendered,
      icon: x.acf.icono,
      type: x.acf.tipo_de_dominio,
      typeLocal: "dominiouc",
    };
  });
  momentosPromises = momentoRequest.map((x) => {
    return {
      id: x.id,
      title: x.title.rendered,
      icon: x.acf.icono
        ? x.acf.icono
        : "https://twinkle.acuarelacore.com/wp-content/uploads/2023/09/actvidad.svg",
      typeLocal: "momento",
    };
  });
  enfoquePromises = enfoqueRequest.map((x) => {
    return {
      id: x.id,
      title: x.title.rendered,
      icon: x.acf.icono,
      type: x.acf.tipo_de_enfoque,
      typeLocal: "enfoque_general",
    };
  });
}
let months = [
  "enero",
  "febrero",
  "marzo",
  "abril",
  "mayo",
  "junio",
  "julio",
  "agosto",
  "septiembre",
  "octubre",
  "noviembre",
  "diciembre",
];
function getMonthFromWeekNumber(weekNumber, year) {
  // If year is not provided, use the current year
  if (year === undefined) {
    year = new Date().getFullYear();
  }
  // Create a date for the first day of the week
  var januaryFirst = new Date(year, 0, 1);
  var daysOffset =
    (januaryFirst.getDay() > 0 ? 7 - januaryFirst.getDay() : 0) +
    (weekNumber - 1) * 7;
  var firstDayOfWeek = new Date(year, 0, 1 + daysOffset);

  // Get the month
  var month = firstDayOfWeek.getMonth();

  // Months are zero-based, so increment by 1 for human-readable format
  return month;
}

function translateInDOM(lang) {
  if (lang === "en") {
    // Cambiar "años" a "years" y "meses" a "months"
    document
      .querySelectorAll(".gruposDeEdad, .years span")
      .forEach((element) => {
        element.textContent = element.textContent
          .replace(/años/g, "years")
          .replace(/meses/g, "months");
      });

    // Cambiar "Plantilla" a "Template"
    document.querySelectorAll(".badge").forEach((element) => {
      element.textContent = element.textContent.replace(
        /Plantilla/g,
        "Template"
      );
    });

    // Cambiar "COMPARTIR ACTIVIDAD" a "SHARE ACTIVITY"
    const shareButton = document.querySelector("#compartir");
    if (shareButton) {
      shareButton.innerHTML = shareButton.innerHTML.replace(
        /COMPARTIR ACTIVIDAD/g,
        "SHARE ACTIVITY"
      );
    }

    // Cambiar "Califica esta actividad" a "Rate this activity"
    const rateActivityHeader = document.querySelector(
      ".calificar.actividad h3"
    );
    if (rateActivityHeader) {
      rateActivityHeader.textContent = rateActivityHeader.textContent.replace(
        /Califica esta actividad/g,
        "Rate this activity"
      );
    }

    // Cambiar "Califica la planeación de esta semana" a "Rate the planning for this week"
    const ratePlanningHeader = document.querySelector(".calificar h2");
    if (ratePlanningHeader) {
      ratePlanningHeader.textContent = ratePlanningHeader.textContent.replace(
        /Califica la planeación de esta semana/g,
        "Rate the planning for this week"
      );
    }

    // Cambiar "Canción semanal" a "Weekly Song"
    document.querySelectorAll(".song span, .song.activity span, .curriculumcontent .song span, .outter.week.flex .song span").forEach((element) => {
      if (element.textContent.includes("Canción semanal")) {
        element.innerHTML = element.innerHTML.replace(
          /Canción semanal/g,
          "Weekly Song"
        );
      }
    });

    // Cambiar "Material literario" a "Literary Material"
    document.querySelectorAll(".storie span, .storie.activity span, .curriculumcontent .storie span, .outter.week.flex .storie span").forEach((element) => {
      if (element.textContent.includes("Material literario")) {
        element.innerHTML = element.innerHTML.replace(
          /Material literario/g,
          "Literary Material"
        );
      }
    });
  } else if (lang === "es") {
    // Cambiar "years" a "años" y "months" a "meses"
    document
      .querySelectorAll(".gruposDeEdad, .years span")
      .forEach((element) => {
        element.textContent = element.textContent
          .replace(/years/g, "años")
          .replace(/months/g, "meses");
      });

    // Cambiar "Template" a "Plantilla"
    document.querySelectorAll(".badge").forEach((element) => {
      element.textContent = element.textContent.replace(
        /Template/g,
        "Plantilla"
      );
    });

    // Cambiar "SHARE ACTIVITY" a "COMPARTIR ACTIVIDAD"
    const shareButton = document.querySelector("#compartir");
    if (shareButton) {
      shareButton.innerHTML = shareButton.innerHTML.replace(
        /SHARE ACTIVITY/g,
        "COMPARTIR ACTIVIDAD"
      );
    }

    // Cambiar "Rate this activity" a "Califica esta actividad"
    const rateActivityHeader = document.querySelector(
      ".calificar.actividad h3"
    );
    if (rateActivityHeader) {
      rateActivityHeader.textContent = rateActivityHeader.textContent.replace(
        /Rate this activity/g,
        "Califica esta actividad"
      );
    }

    //Este es un cabmio

    // Cambiar "Rate the planning for this week" a "Califica la planeación de esta semana"
    const ratePlanningHeader = document.querySelector(".calificar h2");
    if (ratePlanningHeader) {
      ratePlanningHeader.textContent = ratePlanningHeader.textContent.replace(
        /Rate the planning for this week/g,
        "Califica la planeación de esta semana"
      );
    }

    // Cambiar "Weekly Song" a "Canción semanal"
    document.querySelectorAll(".song span, .song.activity span, .curriculumcontent .song span, .outter.week.flex .song span").forEach((element) => {
      if (element.textContent.includes("Weekly Song")) {
        element.innerHTML = element.innerHTML.replace(
          /Weekly Song/g,
          "Canción semanal"
        );
      }
    });

    // Cambiar "Literary Material" a "Material literario"
    document.querySelectorAll(".storie span, .storie.activity span, .curriculumcontent .storie span, .outter.week.flex .storie span").forEach((element) => {
      if (element.textContent.includes("Literary Material")) {
        element.innerHTML = element.innerHTML.replace(
          /Literary Material/g,
          "Material literario"
        );
      }
    });
  }
}

// Detectar el cambio en el selector de idioma
const lenguajeSeleccionado = document.getElementById("lang");

if (lenguajeSeleccionado) {
  lenguajeSeleccionado.addEventListener("change", (event) => {
    const selectedLenguaje = event.target.value;
    translateInDOM(selectedLenguaje); // Llamar a la función de traducción
  });
}

const getWeekDataNew = async (lang = "es", week = weekNumber) => {
  // Ya no convertimos semana 1 a 53 porque ahora el cálculo de semanas es correcto
  // La semana 1 es realmente semana 1 cuando cruza el año

  // PRIMERO: Establecer los data-date antes de buscar los contenedores
  // Esto asegura que los data-date estén disponibles cuando se busquen los contenedores
  let firstDayCurrentWeek = null;
  const semanaSelect = document.getElementById('semanaSelect');
  
  if (semanaSelect && semanaSelect.selectedIndex > 0) {
    const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
    // Extraer la fecha de inicio de la semana (formato: "Semana MM/DD/YYYY al MM/DD/YYYY")
    const fechaMatch = weekText.match(/(\d{2})\/(\d{2})\/(\d{4})/);
    if (fechaMatch && fechaMatch.length >= 4) {
      // Construir la fecha directamente desde el texto del select
      // El formato del texto es MM/DD/YYYY
      const month = parseInt(fechaMatch[1], 10) - 1; // Mes en JS es 0-indexed
      const day = parseInt(fechaMatch[2], 10);
      const year = parseInt(fechaMatch[3], 10);
      const startDate = new Date(year, month, day);
      // Asegurar que sea el lunes de esa semana
      // Caso especial: si es la semana 1 del 2026 que cruza al 2027 y la fecha es 29/12/2026,
      // no ajustar al lunes anterior porque el 29 de diciembre es el inicio correcto
      if (week === 1 && year === 2026 && month === 11 && day === 29) {
        firstDayCurrentWeek = startDate; // Usar directamente el 29 de diciembre
      } else {
        firstDayCurrentWeek = getFirstDayOfWeek(startDate);
      }
      console.log('Estableciendo data-date desde texto del select, fecha extraída:', startDate, 'primer día (lunes):', firstDayCurrentWeek, 'año:', year);
    }
  }
  
  // Si no se pudo obtener del select, usar getDateFromWeekNumber como fallback
  if (!firstDayCurrentWeek) {
    let targetYear = null;
    if (semanaSelect && semanaSelect.selectedIndex > 0) {
      const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
      const fechaMatch = weekText.match(/(\d{2})\/(\d{2})\/(\d{4})/);
      if (fechaMatch && fechaMatch.length >= 4) {
        targetYear = parseInt(fechaMatch[3], 10);
      }
    }
    if (!targetYear) {
      targetYear = new Date().getFullYear();
    }
    let currentDate = getDateFromWeekNumber(week, targetYear);
    
    // Caso especial: si es la semana 1 del 2026 que cruza al 2027, 
    // getDateFromWeekNumber retorna el 29 de diciembre directamente
    // No ajustar al lunes anterior en este caso
    if (week === 1 && targetYear === 2026 && currentDate.getDate() === 29 && currentDate.getMonth() === 11 && currentDate.getFullYear() === 2026) {
      firstDayCurrentWeek = currentDate;
    } else {
      firstDayCurrentWeek = getFirstDayOfWeek(currentDate);
    }
    console.log('Estableciendo data-date con getDateFromWeekNumber, primer día:', firstDayCurrentWeek);
  }
  
  // Establecer los data-date en formato DD/MM/YYYY
  if (firstDayCurrentWeek) {
    var daysOfWeek = document.querySelectorAll(".curriculumcontent .week .day, .outter.week.flex .day");
    var dayIncrement = 0;
    for (var i = 0; i < daysOfWeek.length; i++) {
      var day = daysOfWeek[i];
      var date = new Date(firstDayCurrentWeek);
      date.setDate(firstDayCurrentWeek.getDate() + dayIncrement);
      // Formatear fecha en formato DD/MM/YYYY directamente
      var dayStr = date.getDate().toString().padStart(2, "0");
      var monthStr = (date.getMonth() + 1).toString().padStart(2, "0");
      var yearStr = date.getFullYear().toString();
      var formattedDate = `${dayStr}/${monthStr}/${yearStr}`; // DD/MM/YYYY
      day.setAttribute("data-date", formattedDate);
      console.log(`Estableciendo data-date para día ${i + 1}: "${formattedDate}"`);
      dayIncrement++;
    }
  }

  // Obtener las fechas de inicio y fin de la semana para filtrar por dia_especifico
  let fechaInicioSemana = null;
  let fechaFinSemana = null;
  let fechaSemanaArray = null; // Para normalizar semana (formato MM/DD/YYYY)
  
  if (semanaSelect && semanaSelect.selectedIndex > 0) {
    const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
    // Extraer las fechas de inicio y fin (formato: "Semana MM/DD/YYYY al MM/DD/YYYY")
    const fechaMatches = Array.from(weekText.matchAll(/(\d{2})\/(\d{2})\/(\d{4})/g));
    if (fechaMatches.length >= 2) {
      // Primera fecha es inicio, segunda es fin
      const inicioMatch = fechaMatches[0];
      const finMatch = fechaMatches[1];
      
      // Guardar fechas en formato MM/DD/YYYY para normalizarSemana (igual que consultaWP)
      fechaSemanaArray = [
        `${inicioMatch[1]}/${inicioMatch[2]}/${inicioMatch[3]}`, // MM/DD/YYYY
        `${finMatch[1]}/${finMatch[2]}/${finMatch[3]}` // MM/DD/YYYY
      ];
      
      // Convertir MM/DD/YYYY a DD/MM/YYYY para comparar con dia_especifico
      const mesInicio = inicioMatch[1];
      const diaInicio = inicioMatch[2];
      const añoInicio = inicioMatch[3];
      fechaInicioSemana = `${diaInicio}/${mesInicio}/${añoInicio}`; // DD/MM/YYYY
      
      const mesFin = finMatch[1];
      const diaFin = finMatch[2];
      const añoFin = finMatch[3];
      fechaFinSemana = `${diaFin}/${mesFin}/${añoFin}`; // DD/MM/YYYY
      
      console.log('Fechas de la semana para filtrar por dia_especifico:', fechaInicioSemana, 'al', fechaFinSemana);
    }
  }
  
  // Fallback: Si no se pudieron obtener las fechas del select, calcularlas desde firstDayCurrentWeek
  // También verificar si las fechas del select parecen incorrectas (año muy diferente al esperado)
  let usarFechasDesdeFirstDay = false;
  if (!fechaInicioSemana || !fechaFinSemana) {
    usarFechasDesdeFirstDay = true;
  } else if (firstDayCurrentWeek && week === 1) {
    // Para semana 1, verificar si las fechas del select tienen el año correcto
    const añoEsperado = firstDayCurrentWeek.getFullYear();
    const añoEnFechaInicio = parseInt(fechaInicioSemana.split('/')[2], 10);
    // Si el año en la fecha es muy diferente (más de 1 año de diferencia), usar firstDayCurrentWeek
    if (Math.abs(añoEnFechaInicio - añoEsperado) > 1) {
      console.warn(`⚠ Fechas del select parecen incorrectas para semana 1. Año en select: ${añoEnFechaInicio}, año esperado: ${añoEsperado}. Usando fechas desde firstDayCurrentWeek.`);
      usarFechasDesdeFirstDay = true;
    }
  }
  
  if (usarFechasDesdeFirstDay && firstDayCurrentWeek) {
    // Calcular fecha de inicio (lunes)
    const inicioDate = new Date(firstDayCurrentWeek);
    const diaInicio = inicioDate.getDate().toString().padStart(2, "0");
    const mesInicio = (inicioDate.getMonth() + 1).toString().padStart(2, "0");
    const añoInicio = inicioDate.getFullYear();
    fechaInicioSemana = `${diaInicio}/${mesInicio}/${añoInicio}`; // DD/MM/YYYY
    
    // Calcular fecha de fin (viernes = lunes + 4 días)
    const finDate = new Date(firstDayCurrentWeek);
    finDate.setDate(finDate.getDate() + 4);
    const diaFin = finDate.getDate().toString().padStart(2, "0");
    const mesFin = (finDate.getMonth() + 1).toString().padStart(2, "0");
    const añoFin = finDate.getFullYear();
    fechaFinSemana = `${diaFin}/${mesFin}/${añoFin}`; // DD/MM/YYYY
    
    // Crear fechaSemanaArray en formato MM/DD/YYYY
    fechaSemanaArray = [
      `${mesInicio}/${diaInicio}/${añoInicio}`, // MM/DD/YYYY
      `${mesFin}/${diaFin}/${añoFin}` // MM/DD/YYYY
    ];
    
    console.log('Fechas calculadas desde firstDayCurrentWeek (fallback o corrección):', fechaInicioSemana, 'al', fechaFinSemana);
  }

  // Función para normalizar semana cuando cruza el año (igual que en curriculum.php)
  function normalizarSemanaJS(semana, fechaSemana) {
    const semanaNum = parseInt(semana, 10);
    
    if (!fechaSemana || fechaSemana.length < 2) {
      console.log('normalizarSemanaJS: fechaSemana inválida', fechaSemana);
      return semanaNum;
    }

    const fechaInicioStr = fechaSemana[0].trim();
    const fechaFinStr = fechaSemana[1].trim();
    
    if (!fechaInicioStr || !fechaFinStr) {
      console.log('normalizarSemanaJS: fechas vacías', fechaInicioStr, fechaFinStr);
      return semanaNum;
    }

    // Convertir MM/DD/YYYY a Date
    const partesInicio = fechaInicioStr.split('/');
    const partesFin = fechaFinStr.split('/');
    
    if (partesInicio.length !== 3 || partesFin.length !== 3) {
      console.log('normalizarSemanaJS: formato de fecha inválido', partesInicio, partesFin);
      return semanaNum;
    }

    const fechaInicio = new Date(
      parseInt(partesInicio[2], 10), // año
      parseInt(partesInicio[0], 10) - 1, // mes (0-indexed)
      parseInt(partesInicio[1], 10) // día
    );

    const fechaFin = new Date(
      parseInt(partesFin[2], 10), // año
      parseInt(partesFin[0], 10) - 1, // mes (0-indexed)
      parseInt(partesFin[1], 10) // día
    );

    if (isNaN(fechaInicio.getTime()) || isNaN(fechaFin.getTime())) {
      console.log('normalizarSemanaJS: fechas inválidas', fechaInicio, fechaFin);
      return semanaNum;
    }

    const añoInicio = fechaInicio.getFullYear();
    const añoFin = fechaFin.getFullYear();

    console.log('normalizarSemanaJS: semana=', semanaNum, 'fechaInicio=', fechaInicioStr, 'añoInicio=', añoInicio, 'fechaFin=', fechaFinStr, 'añoFin=', añoFin);

    // Función auxiliar para verificar si un año tiene semana 53
    function añoTieneSemana53(año) {
      const ultimoDiaDelAno = new Date(año, 11, 31);
      const startOfYear = new Date(año, 0, 1);
      const pastDaysOfYear = (ultimoDiaDelAno - startOfYear) / 86400000;
      const ultimaSemanaDelAno = Math.ceil((pastDaysOfYear + startOfYear.getDay() + 1) / 7);
      return ultimaSemanaDelAno >= 53;
    }

    // Si la semana es 1 y cruza el año, asegurar que se use semana 1 del año nuevo
    if (semanaNum === 1 && añoInicio !== añoFin) {
      console.log('normalizarSemanaJS: Semana 1 cruza el año (' + añoInicio + ' -> ' + añoFin + '), usando semana 1 del año nuevo (' + añoFin + ')');
      return 1; // Semana 1 del año nuevo
    }

    // Si la semana es 53, verificar si el año tiene semana 53
    if (semanaNum === 53) {
      const añoInicioTieneSemana53 = añoTieneSemana53(añoInicio);
      
      if (añoInicioTieneSemana53) {
        console.log('normalizarSemanaJS: El año', añoInicio, 'tiene semana 53, manteniendo semana 53');
        return 53;
      }
      
      if (añoInicio !== añoFin) {
        console.log('normalizarSemanaJS: Las fechas cruzan el año (' + añoInicio + ' -> ' + añoFin + ') y el año ' + añoInicio + ' no tiene semana 53, convirtiendo a semana 1');
        return 1;
      } else {
        console.log('normalizarSemanaJS: El año', añoInicio, 'no tiene semana 53 (tiene menos de 53 semanas), convirtiendo a semana 1');
        return 1;
      }
    }

    console.log('normalizarSemanaJS: Manteniendo semana', semanaNum);
    return semanaNum;
  }
  
  // Normalizar la semana si cruza el año (igual que consultaWP)
  let semanaNormalizada = week;
  if (fechaSemanaArray && fechaSemanaArray.length === 2) {
    semanaNormalizada = normalizarSemanaJS(week, fechaSemanaArray);
    console.log(`getWeekDataNew: semana original=${week}, semana normalizada=${semanaNormalizada}`);
  }

  try {
    requestWP(
      `cpdfs-bcct?field=curriculum,semana_a_la_que_pertenece&value=${curriculumID},${semanaNormalizada}`
    ).then((pdf) => {
      const downloadButton = document.querySelector("#downloadPdfButton");

      if (Array.isArray(pdf) && pdf.length > 0) {
        // Si hay PDFs, mostrar el botón
        downloadButton.style.display = "flex";
      } else {
        // Si no hay PDFs, ocultar el botón
        downloadButton.style.display = "none";
      }
    });
    
    // IMPORTANTE: Cuando la semana es 1 y cruza el año, WordPress puede devolver actividades incorrectas
    // Estrategia: Consultar TODAS las actividades del curriculum y filtrar por semana después (igual que basicPrint.php)
    let usarFiltroSemanaEnQuery = true;
    let afterDateEarly = "2024-01-01T00:00:00";
    
    // Verificar si la semana cruza el año (no solo semana 1, sino cualquier semana que cruce)
    if (fechaSemanaArray && fechaSemanaArray.length === 2) {
      // Parsear fechas MM/DD/YYYY
      const fechaInicioStr = fechaSemanaArray[0].trim();
      const partesInicio = fechaInicioStr.split('/');
      
      if (partesInicio.length === 3) {
        const añoInicio = parseInt(partesInicio[2], 10);
        
        // Parsear fecha de fin
        const fechaFinStr = fechaSemanaArray[1].trim();
        const partesFin = fechaFinStr.split('/');
        
        if (partesFin.length === 3) {
          const añoFin = parseInt(partesFin[2], 10);
          
          // Si la semana cruza el año (ej: 12/29/2025 - 01/02/2026)
          if (añoInicio !== añoFin) {
            // NO filtrar por semana en la consulta - consultar TODAS las actividades y filtrar después
            usarFiltroSemanaEnQuery = false;
            console.log(`Semana ${semanaNormalizada} cruza el año (${añoInicio} -> ${añoFin}), consultando TODAS las actividades y filtrando después`);
          }
        }
      }
    }
    
    // Construir la consulta
    let queryBase;
    if (usarFiltroSemanaEnQuery) {
      // Consulta normal con filtro de semana
      queryBase = `planessemanales?field=language,curriculum,semanas_a_las_que_pertence&value=${lang},${curriculumID},${semanaNormalizada}&pp=99`;
    } else {
      // Consulta SIN filtro de semana (solo por curriculum e idioma)
      // Filtrar por semana después en JavaScript
      queryBase = `planessemanales?field=language,curriculum&value=${lang},${curriculumID}&pp=500&after=${encodeURIComponent(afterDateEarly)}`;
      console.log(`Consultando TODAS las actividades del curriculum (sin filtro de semana) para filtrar después`);
    }
    
    let queries = [queryBase];
    
    console.log(`Consultando WordPress con semana normalizada: ${semanaNormalizada} (original: ${week}), query: ${queryBase}`);

    const promises = queries.map((query) => {
      return requestWP(query).then((response) => {
        console.log(`Respuesta de WordPress para semana ${semanaNormalizada} (original: ${week}):`, response);
        // Si la respuesta no es un arreglo vacío, devolvemos la respuesta; de lo contrario, devolvemos null.
        return Array.isArray(response) && response.length > 0 ? response : null;
      });
    });
    const responses = await Promise.all(promises);
    console.log(`Respuestas de WordPress (antes de filtrar):`, responses);
    // Filtramos las respuestas nulas, lo que significa que las consultas devolvieron un arreglo vacío.
    const filteredResponses = responses.filter((response) => response !== null);
    console.log(`Respuestas filtradas (después de eliminar nulls):`, filteredResponses);
    let allActivities = filteredResponses;

    // Aplanar el array de arrays
    let flattenedActivities = allActivities.flat();
    console.log(`Actividades aplanadas (total antes de filtrar por fecha):`, flattenedActivities.length);
    if (flattenedActivities.length > 0) {
      console.log(`Primera actividad aplanada:`, flattenedActivities[0]);
      console.log(`Semanas de primera actividad:`, flattenedActivities[0].acf?.semanas_a_las_que_pertence);
    }
    
    // NO filtrar por dia_especifico aquí - las actividades ya vienen filtradas por semana desde WordPress
    // El dia_especifico solo se usará después para agrupar actividades por día
    // Si WordPress devuelve actividades incorrectas (ej: semana 6 en lugar de semana 1),
    // el filtro por semanas_a_las_que_pertence las eliminará después
    console.log(`Actividades antes de filtrar por semana (${fechaInicioSemana} al ${fechaFinSemana}):`, flattenedActivities.length);
    let actividades = [
      "pictogramas",
      "actividades",
      "arte",
      "cocina",
      "Manualidades",
    ];
    let material = [
      "lectura",
      "adivinanzas",
      "travalenguas",
      "poesias",
      "cuentos",
      "copias",
      "retahílas",
      "fábulas",
      "historietas",
    ];
    // Filtrar actividades donde acf.tipo_de_actividad está en actividades y acf.semanas_a_las_que_pertence incluye semanaNormalizada
    console.log('Filtrando actividades para semana:', semanaNormalizada, '(original:', week, ')');
    console.log('Total actividades aplanadas:', flattenedActivities.length);
    console.log('Tipo de semana:', typeof semanaNormalizada, 'Valor:', semanaNormalizada);
    
    // Log de las primeras actividades para debugging
    if (flattenedActivities.length > 0) {
      console.log('Muestra de actividades antes del filtro por semana:');
      flattenedActivities.slice(0, 5).forEach((act, idx) => {
        console.log(`  Actividad ${idx + 1}: tipo="${act.acf?.tipo_de_actividad}", semanas=${JSON.stringify(act.acf?.semanas_a_las_que_pertence)}, dia_especifico="${act.acf?.dia_especifico}"`);
      });
    }
    
    // Normalizar semanaNormalizada a string para comparación consistente
    const weekStr = String(semanaNormalizada);
    const weekNum = Number(semanaNormalizada);
    
    // Función para parsear fechas DD/MM/YYYY
    const parseDateDDMMYYYY = (dateStr) => {
      if (!dateStr) return null;
      const parts = dateStr.split('/');
      if (parts.length === 3) {
        return new Date(parseInt(parts[2], 10), parseInt(parts[1], 10) - 1, parseInt(parts[0], 10));
      }
      return null;
    };
    
    // Determinar si la semana cruza el año
    const semanaCruzaAno = fechaSemanaArray && fechaSemanaArray.length === 2 && 
                           fechaInicioSemana && fechaFinSemana;
    
    // Log para depuración
    console.log('Estado de fechas para filtrado:', {
      fechaSemanaArray,
      fechaInicioSemana,
      fechaFinSemana,
      semanaCruzaAno,
      semanaNormalizada,
      week,
      firstDayCurrentWeek: firstDayCurrentWeek ? firstDayCurrentWeek.toISOString() : null
    });
    
    // Log adicional para semana 1
    if (week === 1 || semanaNormalizada === 1) {
      console.log('🔍 DEBUG SEMANA 1:', {
        week,
        semanaNormalizada,
        fechaInicioSemana,
        fechaFinSemana,
        fechaSemanaArray,
        semanaCruzaAno,
        totalActividadesAntesFiltro: flattenedActivities.length
      });
    }
    
    let activities = flattenedActivities.filter(
      (data) => {
        const tieneTipoCorrecto = actividades.includes(data.acf.tipo_de_actividad);
        if (!tieneTipoCorrecto) {
          return false;
        }
        
        // Verificar semanas_a_las_que_pertence
        const tieneSemana = data.acf.semanas_a_las_que_pertence && 
                           (data.acf.semanas_a_las_que_pertence.includes(weekStr) || 
                            data.acf.semanas_a_las_que_pertence.includes(weekNum) ||
                            data.acf.semanas_a_las_que_pertence.some(s => String(s) === weekStr || Number(s) === weekNum));
        
        // Si la semana cruza el año, usar filtro por fecha como principal (similar a basic-79)
        // Esto es crítico para semana 1 que cruza el año, ya que WordPress puede tener actividades
        // con semanas del año anterior o del año nuevo
        if (semanaCruzaAno) {
          // Para semana 1 que cruza el año, ser más permisivo:
          // 1. Si tiene dia_especifico y está dentro del rango, incluirla
          // 2. Si tiene semana 1 o 53, incluirla (incluso sin dia_especifico)
          // 3. Si tiene la semana correcta, incluirla
          
          // Primero verificar si tiene dia_especifico y está dentro del rango
          if (data.acf?.dia_especifico && fechaInicioSemana && fechaFinSemana) {
            const fechaActividad = parseDateDDMMYYYY(data.acf.dia_especifico);
            const fechaInicio = parseDateDDMMYYYY(fechaInicioSemana);
            const fechaFin = parseDateDDMMYYYY(fechaFinSemana);
            
            if (fechaActividad && fechaInicio && fechaFin) {
              const dentroDelRango = fechaActividad >= fechaInicio && fechaActividad <= fechaFin;
              // Si está dentro del rango de fechas, incluirla (incluso si no tiene la semana exacta)
              // Esto maneja el caso donde WordPress tiene actividades con semanas del año incorrecto
              if (dentroDelRango) {
                console.log(`✓ Actividad incluida por fecha (cruza año): tipo=${data.acf.tipo_de_actividad}, fecha=${data.acf.dia_especifico}, semanas=${JSON.stringify(data.acf.semanas_a_las_que_pertence)}`);
                return true;
              }
            }
          }
          
          // Para semana 1 que cruza el año, aceptar actividades con semana 1 o semana 53
          // incluso si no tienen dia_especifico o está fuera del rango
          if (semanaNormalizada === 1) {
            const tieneSemana1 = data.acf.semanas_a_las_que_pertence && 
                                 (data.acf.semanas_a_las_que_pertence.includes('1') || 
                                  data.acf.semanas_a_las_que_pertence.includes(1) ||
                                  data.acf.semanas_a_las_que_pertence.includes('53') ||
                                  data.acf.semanas_a_las_que_pertence.includes(53));
            if (tieneSemana1) {
              console.log(`✓ Actividad incluida por semana (cruza año, semana 1): tipo=${data.acf.tipo_de_actividad}, semanas=${JSON.stringify(data.acf.semanas_a_las_que_pertence)}, dia_especifico=${data.acf.dia_especifico || 'N/A'}`);
              return true;
            }
          }
          
          // Si tiene la semana correcta (no solo semana 1), también incluirla
          if (tieneSemana) {
            console.log(`✓ Actividad incluida por semana (cruza año): tipo=${data.acf.tipo_de_actividad}, semanas=${JSON.stringify(data.acf.semanas_a_las_que_pertence)}, dia_especifico=${data.acf.dia_especifico || 'N/A'}`);
            return true;
          }
          
          // Si llegamos aquí y la semana cruza el año, rechazar la actividad
          console.log(`✗ Actividad rechazada (cruza año): tipo=${data.acf.tipo_de_actividad}, semanas=${JSON.stringify(data.acf.semanas_a_las_que_pertence)}, dia_especifico=${data.acf.dia_especifico || 'N/A'}`);
          return false;
        }
        
        // Si no cruza el año o no tiene dia_especifico, usar el filtro normal por semana
        // También verificar dia_especifico si está disponible para asegurar que está en el rango
        if (tieneSemana) {
          // Si tiene dia_especifico, verificar que esté dentro del rango
          if (data.acf?.dia_especifico && fechaInicioSemana && fechaFinSemana) {
            const fechaActividad = parseDateDDMMYYYY(data.acf.dia_especifico);
            const fechaInicio = parseDateDDMMYYYY(fechaInicioSemana);
            const fechaFin = parseDateDDMMYYYY(fechaFinSemana);
            
            if (fechaActividad && fechaInicio && fechaFin) {
              const dentroDelRango = fechaActividad >= fechaInicio && fechaActividad <= fechaFin;
              if (!dentroDelRango) {
                // La actividad tiene la semana correcta pero la fecha está fuera del rango
                console.log(`⚠ Actividad filtrada: tiene semana ${semanaNormalizada} pero fecha ${data.acf.dia_especifico} está fuera del rango ${fechaInicioSemana} - ${fechaFinSemana}`);
                return false;
              }
            }
          }
          return true;
        }
        
        return false;
      }
    );
    
    console.log('Actividades filtradas:', activities.length);
    if (activities.length > 0) {
      console.log('Primera actividad:', activities[0]);
      console.log('Semanas de primera actividad:', activities[0].acf.semanas_a_las_que_pertence);
      console.log('dia_especifico de primera actividad:', activities[0].acf.dia_especifico);
    } else {
      console.warn('⚠ No se encontraron actividades después del filtro. Verificar:');
      console.warn('  - ¿WordPress está devolviendo actividades con semanas_a_las_que_pertence = [' + semanaNormalizada + ']?');
      console.warn('  - ¿Las actividades tienen dia_especifico dentro del rango ' + fechaInicioSemana + ' - ' + fechaFinSemana + '?');
    }

    // Filtrar literarios donde acf.tipo_de_actividad está en material y acf.semanas_a_las_que_pertence incluye semanaNormalizada
    let literarios = flattenedActivities.filter(
      (data) => {
        const tieneTipoCorrecto = material.includes(data.acf.tipo_de_actividad);
        const tieneSemana = data.acf.semanas_a_las_que_pertence && 
                           (data.acf.semanas_a_las_que_pertence.includes(weekStr) || 
                            data.acf.semanas_a_las_que_pertence.includes(weekNum) ||
                            data.acf.semanas_a_las_que_pertence.some(s => String(s) === weekStr || Number(s) === weekNum));
        return tieneTipoCorrecto && tieneSemana;
      }
    );

    // Limpiar canciones y materiales literarios ANTES de filtrar y actualizar
    // Esto asegura que no se muestren datos de semanas anteriores
    // Guardar el contenido HTML inicial para restaurarlo después
    const songInitialHTML = '<span data-interfazid="7"><svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 0.5C5.37258 0.5 0 5.87258 0 12.5C0 19.1274 5.37258 24.5 12 24.5C18.6274 24.5 24 19.1274 24 12.5C24 5.87258 18.6274 0.5 12 0.5ZM8.77007 15.5547V15.2475C8.77007 14.55 8.77423 13.8525 8.7784 13.155C8.78673 11.76 8.79507 10.365 8.77007 8.97004C8.75507 8.22004 9.34007 7.31254 10.1201 7.06504C10.4805 6.95201 10.8409 6.83856 11.2015 6.72508C12.9941 6.16085 14.7893 5.5958 16.6001 5.07754C17.4326 4.83754 18.0476 5.14504 18.0476 6.13504C18.0559 7.86416 18.0527 9.59097 18.0494 11.318C18.0468 12.6998 18.0442 14.0817 18.0476 15.465C18.0476 16.4175 17.5676 17.07 16.8251 17.5725C15.9851 18.1425 15.0476 18.3 14.0651 18.0675C12.4976 17.6925 12.0101 16.1175 13.0976 14.91C14.0576 13.845 15.2726 13.5375 16.6526 13.86C16.7351 13.8825 16.8176 13.905 16.9001 13.92V9.25504C16.9001 8.92504 16.6976 8.81254 16.3076 8.91754C15.8051 9.05254 15.3101 9.20254 14.8151 9.36004C13.4351 9.79504 12.0551 10.23 10.6826 10.6725C10.1051 10.86 9.94007 11.0925 9.93257 11.685C9.92507 13.4775 9.91757 15.27 9.90257 17.0625C9.88757 18.5925 8.73257 19.7925 7.20257 19.86C6.76757 19.8825 6.30257 19.8825 5.89007 19.7775C4.64507 19.4625 4.13507 18.2325 4.78007 17.1225C5.38007 16.0875 6.33257 15.5775 7.50257 15.4875C7.77159 15.468 8.04062 15.4931 8.32004 15.5191C8.46668 15.5328 8.61619 15.5468 8.77007 15.5547Z" fill="white" /></svg> Canción semanal</span>';
    const storieInitialHTML = '<span data-interfazid="8"><img src="img/literario.svg" alt="Material Literario" />Material literario</span>';
    
    document.querySelectorAll(".curriculumcontent .week .day .song").forEach((songEl) => {
      // Limpiar solo los data-attributes, pero restaurar el contenido HTML inicial
      Array.from(songEl.attributes).forEach(attr => {
        if (attr.name.startsWith('data-')) {
          songEl.removeAttribute(attr.name);
        }
      });
      songEl.innerHTML = songInitialHTML;
      songEl.style.display = "none";
      songEl.style.opacity = "0";
    });
    
    document.querySelectorAll(".curriculumcontent .week .day .storie").forEach((storieEl) => {
      // Limpiar solo los data-attributes, pero restaurar el contenido HTML inicial
      Array.from(storieEl.attributes).forEach(attr => {
        if (attr.name.startsWith('data-')) {
          storieEl.removeAttribute(attr.name);
        }
      });
      // Verificar si tiene data-interfazid para usar la versión correcta del HTML
      const hasInterfazId = storieEl.querySelector('[data-interfazid="8"]');
      if (hasInterfazId) {
        storieEl.innerHTML = storieInitialHTML;
      } else {
        storieEl.innerHTML = '<span><img src="img/momentos/material_literario.svg" alt="Material literario" /> Material literario</span>';
      }
      storieEl.style.display = "none";
      storieEl.style.opacity = "0";
    });

    // Filtrar canciones donde acf.tipo_de_actividad es "canciones" y acf.semanas_a_las_que_pertence incluye week
    let song = flattenedActivities.filter(
      (data) => {
        const tieneTipoCorrecto = data.acf.tipo_de_actividad == "canciones";
        const tieneSemana = data.acf.semanas_a_las_que_pertence && 
                           (data.acf.semanas_a_las_que_pertence.includes(weekStr) || 
                            data.acf.semanas_a_las_que_pertence.includes(weekNum) ||
                            data.acf.semanas_a_las_que_pertence.some(s => String(s) === weekStr || Number(s) === weekNum));
        return tieneTipoCorrecto && tieneSemana;
      }
    );

    // Actualizar canciones: cada día debe tener su propia canción si existe
    if (song && song.length > 0) {
      // Si hay canciones, actualizar cada día con la canción correspondiente
      document.querySelectorAll(".curriculumcontent .week .day").forEach((dayElement) => {
        const dayDate = dayElement.getAttribute("data-date");
        const songElement = dayElement.querySelector(".song");
        
        if (!songElement) return;
        
        // Asegurar que el contenido HTML inicial esté presente antes de actualizar
        if (!songElement.innerHTML || songElement.innerHTML.trim() === "") {
          songElement.innerHTML = songInitialHTML;
        }
        
        if (dayDate) {
          // Buscar canción para este día específico
          const songForDay = song.find(s => {
            if (!s.acf.dia_especifico) return false;
            // Comparar fechas en formato DD/MM/YYYY
            return s.acf.dia_especifico === dayDate;
          });
          
          if (songForDay) {
            // Actualizar solo este elemento con la canción del día
            updateElementsWithData(
              [songElement],
              [songForDay],
              "#FFF",
              "#53bdc2"
            );
            songElement.style.display = "flex";
            songElement.style.opacity = "1";
          } else {
            // Si no hay canción específica para este día, buscar una sin día específico o usar la primera disponible
            const songSinFecha = song.find(s => !s.acf.dia_especifico);
            if (songSinFecha) {
              updateElementsWithData(
                [songElement],
                [songSinFecha],
                "#FFF",
                "#53bdc2"
              );
              songElement.style.display = "flex";
              songElement.style.opacity = "1";
            } else if (song.length === 1) {
              // Si solo hay una canción (con o sin día específico), usar esa canción para todos los días
              updateElementsWithData(
                [songElement],
                song,
                "#FFF",
                "#53bdc2"
              );
              songElement.style.display = "flex";
              songElement.style.opacity = "1";
            } else if (song.length > 0) {
              // Si todas tienen fecha pero ninguna coincide, usar la primera disponible para todos los días
              updateElementsWithData(
                [songElement],
                [song[0]],
                "#FFF",
                "#53bdc2"
              );
              songElement.style.display = "flex";
              songElement.style.opacity = "1";
            }
          }
        } else {
          // Si no hay data-date, usar la primera canción disponible
          if (song.length > 0) {
            updateElementsWithData(
              [songElement],
              [song[0]],
              "#FFF",
              "#53bdc2"
            );
            songElement.style.display = "flex";
            songElement.style.opacity = "1";
          }
        }
      });
    }
    
    // Actualizar materiales literarios: cada día debe tener su propio material si existe
    if (literarios && literarios.length > 0) {
      console.log(`Encontrados ${literarios.length} materiales literarios para semana ${semanaNormalizada} (original: ${week})`);
      document.querySelectorAll(".curriculumcontent .week .day").forEach((dayElement) => {
        const dayDate = dayElement.getAttribute("data-date");
        const storieElement = dayElement.querySelector(".storie");
        
        if (!storieElement) return;
        
        // Asegurar que el contenido HTML inicial esté presente antes de actualizar
        if (!storieElement.innerHTML || storieElement.innerHTML.trim() === "") {
          // Verificar si tiene data-interfazid para usar la versión correcta del HTML
          const hasInterfazId = storieElement.querySelector('[data-interfazid="8"]');
          if (hasInterfazId) {
            storieElement.innerHTML = storieInitialHTML;
          } else {
            storieElement.innerHTML = '<span><img src="img/momentos/material_literario.svg" alt="Material literario" /> Material literario</span>';
          }
        }
        
        if (dayDate) {
          // Buscar material literario para este día específico
          const literarioForDay = literarios.find(l => {
            if (!l.acf.dia_especifico) return false;
            // Comparar fechas en formato DD/MM/YYYY
            return l.acf.dia_especifico === dayDate;
          });
          
          if (literarioForDay) {
            // Actualizar solo este elemento con el material del día
            updateElementsWithData(
              [storieElement],
              [literarioForDay],
      "#e3e8ff",
      "#5872fd"
    );
            console.log(`Material literario asignado para día ${dayDate}:`, literarioForDay.title?.rendered);
          } else {
            // Si no hay material específico para este día, buscar uno sin día específico o usar el primero disponible
            const literarioSinFecha = literarios.find(l => !l.acf.dia_especifico);
            if (literarioSinFecha) {
              updateElementsWithData(
                [storieElement],
                [literarioSinFecha],
                "#e3e8ff",
                "#5872fd"
              );
            } else if (literarios.length > 0) {
              // Si todos tienen fecha pero ninguna coincide, usar el primero disponible
              updateElementsWithData(
                [storieElement],
                [literarios[0]],
                "#e3e8ff",
                "#5872fd"
              );
            }
          }
        } else {
          // Si no hay data-date, usar el primer material disponible
          if (literarios.length > 0) {
            updateElementsWithData(
              [storieElement],
              [literarios[0]],
              "#e3e8ff",
              "#5872fd"
            );
          }
        }
      });
    } else {
      console.log(`No se encontraron materiales literarios para semana ${semanaNormalizada} (original: ${week})`);
    }

    if (activities.length > 0) {
      // Obtener los años de la semana seleccionada desde el select
      // Si la semana cruza el año, necesitamos incluir ambos años
      let targetYears = [];
      const semanaSelect = document.getElementById('semanaSelect');
      
      if (semanaSelect && semanaSelect.selectedIndex > 0) {
        const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
        // Extraer los años de las fechas de inicio y fin (formato: "Semana MM/DD/YYYY al MM/DD/YYYY")
        const fechaMatches = weekText.matchAll(/(\d{2})\/(\d{2})\/(\d{4})/g);
        const years = [];
        for (const match of fechaMatches) {
          if (match && match.length >= 4) {
            const year = parseInt(match[3], 10);
            if (!years.includes(year)) {
              years.push(year);
            }
          }
        }
        targetYears = years;
        console.log('Años objetivo obtenidos del select:', targetYears, 'de la semana:', weekText);
      }
      
      // Si no pudimos obtener los años del select, obtenerlos de las actividades
      if (targetYears.length === 0 && activities.length > 0) {
        // Obtener todos los años únicos de las actividades
        const years = activities
          .map(a => {
            if (a.acf.dia_especifico) {
              const parts = a.acf.dia_especifico.split('/');
              if (parts.length === 3) {
                return parseInt(parts[2], 10);
              }
            }
            return null;
          })
          .filter(y => y !== null);
        
        if (years.length > 0) {
          // Usar todos los años únicos encontrados
          targetYears = [...new Set(years)];
          console.log('Años obtenidos de las actividades:', targetYears);
        }
      }
      
      if (targetYears.length === 0) {
        // Fallback: usar el año actual
        targetYears = [new Date().getFullYear()];
        console.log('Usando año actual como fallback:', targetYears);
      }
      
      // Filtrar actividades por años (incluir actividades de todos los años de la semana)
      let filteredActivities = activities;
      if (targetYears.length > 0) {
        filteredActivities = activities.filter((activity) => {
          if (!activity.acf.dia_especifico) return false;
          const parts = activity.acf.dia_especifico.split('/');
          if (parts.length === 3) {
            const activityYear = parseInt(parts[2], 10);
            const matches = targetYears.includes(activityYear);
            if (!matches) {
              console.log(`Filtrando actividad del año ${activityYear} (objetivo: ${targetYears.join(', ')}):`, activity.title?.rendered);
            }
            return matches;
          }
          return false;
        });
        console.log(`Actividades filtradas por años ${targetYears.join(', ')}:`, filteredActivities.length, 'de', activities.length);
      }
      
      // Función para agrupar los elementos por fecha
      function groupByDate(activities) {
        const groupedActivities = {};
        activities.forEach((activity) => {
          const date = activity.acf.dia_especifico;

          if (!groupedActivities[date]) {
            groupedActivities[date] = [];
          }
          groupedActivities[date].push(activity);
        });

        // Log para ver el resultado final de la agrupación
        return groupedActivities;
      }

      // Obtener el arreglo de actividades agrupadas por fecha (usando las filtradas por año)
      const activitiesByDate = groupByDate(filteredActivities);
      
      console.log('Actividades agrupadas por fecha:', activitiesByDate);
      console.log('Fechas encontradas:', Object.keys(activitiesByDate));

      // Mapa de currículums y edades permitidas
      const curriculumAgeGroups = {
        194: ["1+ años", "2+ años", "3+ años"], // Intermedio
        195: ["1+ años", "2+ años", "3+ años"], // 3K
        647: ["0 - 3 meses", "3 - 6 meses", "6 - 9 meses", "9 - 12 meses"], // Infantes
        5828: [
          "0 - 3 meses",
          "3 - 6 meses",
          "6 - 9 meses",
          "9 - 12 meses",
          "1 - 2 años",
          "2 - 3 años",
          "Preschool (3 - 5 años)",
        ], // Homeschooling
        79: ["1+ años", "2+ años", "3+ años"], // Básico
        96224: [
          "5 años",
          "6 años",
          "7 años",
          "8 años",
          "9 años",
          "10 años",
          "11 años",
          "12 años",
        ], // Universal Curriculum After Schoolers Summer Edition
      };

      // Filtrar las edades según el curriculumID
      function filterAgeGroupsByCurriculum(activity, curriculumID) {
        const allowedAges = curriculumAgeGroups[curriculumID] || [];
        return activity.acf.grupo_de_edad
          .map((el) => el.post_title)
          .filter((age) => allowedAges.includes(age));
      }

      // Recorrer el objeto de actividades agrupadas por fecha
      Object.keys(activitiesByDate).forEach((date) => {
        // Los data-date están en formato DD/MM/YYYY completo (según formatDate en línea 3749)
        // dia_especifico también viene en formato DD/MM/YYYY
        // Usar directamente el formato completo sin conversión
        let dateForSelector = date;
        
        if (!date || !date.includes('/')) {
          console.warn(`Fecha inválida: ${date}`);
          return;
        }
        
        const parts = date.split('/').map(p => p.trim());
        
        // Normalizar el formato DD/MM/YYYY asegurando que tenga 2 dígitos en día y mes
        if (parts.length === 3) {
          const day = parts[0].padStart(2, '0');
          const month = parts[1].padStart(2, '0');
          let year = parts[2];
          
          // Si la semana cruza el año, siempre buscar el año correcto en los data-date disponibles
          // Esto es necesario porque las actividades pueden tener fechas del año anterior o siguiente
          // Ejemplo: actividad tiene 29/12/2025 pero data-date es 29/12/2026
          // Ejemplo: actividad tiene 01/01/2026 pero data-date es 01/01/2027
          if (semanaCruzaAno) {
            // Obtener todos los data-date disponibles
            const allDataDates = Array.from(document.querySelectorAll('.curriculumcontent .week .day, .outter.week.flex .day')).map(day => day.getAttribute('data-date')).filter(d => d);
            
            // Buscar un data-date que coincida con el día y mes de la actividad
            const matchingDataDate = allDataDates.find(d => {
              if (!d) return false;
              const dParts = d.split('/');
              return dParts.length === 3 && dParts[0] === day && dParts[1] === month;
            });
            
            if (matchingDataDate) {
              const matchingParts = matchingDataDate.split('/');
              const añoDataDate = matchingParts[2];
              const añoActividad = parseInt(year, 10);
              
              // Solo ajustar si el año es diferente
              if (añoActividad !== parseInt(añoDataDate, 10)) {
                year = añoDataDate; // Usar el año del data-date
                console.log(`✓ Ajustando año de actividad: ${date} -> ${day}/${month}/${year} para coincidir con data-date`);
              }
            } else {
              // Si no se encuentra coincidencia, calcular el año basándose en firstDayCurrentWeek
              if (firstDayCurrentWeek) {
                const añoEsperado = firstDayCurrentWeek.getFullYear();
                const mesActividad = parseInt(month, 10);
                
                // Si el mes es enero (1) y estamos en diciembre, el año debería ser el siguiente
                if (mesActividad === 1 && firstDayCurrentWeek.getMonth() === 11) {
                  year = (añoEsperado + 1).toString();
                  console.log(`✓ Ajustando año de actividad (enero después de diciembre): ${date} -> ${day}/${month}/${year}`);
                } else {
                  year = añoEsperado.toString();
                  console.log(`✓ Ajustando año de actividad (sin coincidencia exacta): ${date} -> ${day}/${month}/${year} usando año esperado`);
                }
              }
            }
          }
          
          dateForSelector = `${day}/${month}/${year}`; // DD/MM/YYYY
          console.log(`Buscando contenedor para fecha: "${dateForSelector}" (DD/MM/YYYY, fecha original: "${date}")`);
        } else {
          console.warn(`Formato de fecha inesperado: ${date} (esperado DD/MM/YYYY)`);
          return;
        }
        
        // Verificar todos los data-date disponibles para debug (solo la primera vez)
        if (Object.keys(activitiesByDate).indexOf(date) === 0) {
          const allDataDates = Array.from(document.querySelectorAll('.curriculumcontent .week .day')).map(day => day.getAttribute('data-date'));
          console.log(`Todos los data-date disponibles:`, allDataDates);
        }
        
        // Obtener el contenedor correspondiente a la fecha usando el formato completo DD/MM/YYYY
        // Buscar en ambos lugares: .curriculumcontent .week .day y .outter.week.flex .day
        let container = document.querySelector(
          `.curriculumcontent .week .day[data-date="${dateForSelector}"] .containerActivities`
        );
        
        if (!container) {
          container = document.querySelector(
            `.outter.week.flex .day[data-date="${dateForSelector}"] .containerActivities`
          );
        }

        if (!container) {
          console.warn(`⚠ No se encontró contenedor para fecha: "${dateForSelector}" (fecha original: "${date}")`);
          // Intentar buscar sin el selector específico para debug
          const allContainers = document.querySelectorAll('.curriculumcontent .week .day .containerActivities');
          const allDataDates = Array.from(document.querySelectorAll('.curriculumcontent .week .day')).map(day => ({
            date: day.getAttribute('data-date'),
            day: day.querySelector('h2')?.textContent || 'unknown'
          }));
          console.log(`Total contenedores encontrados:`, allContainers.length);
          console.log(`Todos los data-date disponibles:`, allDataDates);
          return; // Salir si no se encuentra el contenedor
        } else {
          console.log(`✓ Contenedor encontrado para fecha: "${dateForSelector}"`);
        }

        // Verificar si el contenedor existe
        if (container) {
          let activitiesHTML = ""; // Variable para almacenar el HTML de todas las actividades de esta fecha

          // Obtener las actividades de esta fecha y ordenarlas por edades
          const sortedActivities = activitiesByDate[date].sort((a, b) => {
            const curriculumIDA = a.acf.curriculum[0]?.ID;
            const curriculumIDB = b.acf.curriculum[0]?.ID;

            // Ordenar solo si ambos tienen curriculumID válido
            if (curriculumIDA && curriculumIDB) {
              const ageGroupA = filterAgeGroupsByCurriculum(
                a,
                curriculumIDA
              )[0];
              const ageGroupB = filterAgeGroupsByCurriculum(
                b,
                curriculumIDB
              )[0];

              const ageIndexA =
                curriculumAgeGroups[curriculumIDA].indexOf(ageGroupA);
              const ageIndexB =
                curriculumAgeGroups[curriculumIDB].indexOf(ageGroupB);

              return ageIndexA - ageIndexB;
            }
            return 0; // Sin cambios si no hay curriculumID válido
          });

          // Recorrer las actividades de esa fecha
          sortedActivities.forEach((activity, i) => {
            // console.log("Procesando actividad:");
            // console.log(activity);
            let id_actividad = activity.id;

            // Obtener las edades filtradas
            const filteredAges = filterAgeGroupsByCurriculum(
              activity,
              curriculumID
            );

            // Badge condicional según tipo de actividad o requerimiento de plantilla
            let badgeHTML = ""; // Badge vacío por defecto

            const tiposDeActividad = [
              "adivinanzas",
              "travalenguas",
              "poesias",
              "cuentos",
              "copias",
              "poesias",
              "canciones",
              "retahilas",
              "fábulas",
            ];
            const tipoActividad = activity.acf.tipo_de_actividad;
            const requierePlantilla = activity.acf.requiere_plantilla;

            if (tiposDeActividad.includes(tipoActividad)) {
              badgeHTML = `<div class="badge" style="position:absolute; top:-15px; right:-10px; background-color:#333B5C; color:white; border-radius:500px; padding:8px 15px;font-size: 11px;font-weight: 600;">${tipoActividad}</div>`;
            } else if (tipoActividad === "actividades" && requierePlantilla) {
              badgeHTML = `<img src="https://i.ibb.co/Vmwb0VL/paper-clip.png" alt="paper-clip" border="0" style="position: absolute;top: -9px;right: -15px;">`;
            }

            // Obtener el color basado en el momento de aprendizaje
            const momentoAprendizaje = activity.acf.momento_de_aprendizaje
              ? activity.acf.momento_de_aprendizaje
                .map((el) => el.post_title)
                .filter((title) => {
                  // Excluir "Actividad de Estimulación" si el curriculumID no es 647 ni 5828
                  if (curriculumID !== 647 && curriculumID !== 5828) {
                    return title !== "Actividad de Estimulación";
                  }
                  return true;
                })
                .join(", ")
              : "";

            const colorStroke =
              curriculumID === 647 || curriculumID === 5828
                ? `#${colorsStroke[i % colorsStroke.length]}`
                : colorsStrokeMapping[momentoAprendizaje] || "#00A099";
            const colorFill =
              curriculumID === 647 || curriculumID === 5828
                ? `#${colorsFill[i % colorsFill.length]}`
                : colorsFillMapping[momentoAprendizaje] || "#EEFFFC";

            // data-colorfill='#${colorsFill[i % colorsFill.length]}'

            // Construir el HTML de la actividad con el badge si aplica
            activitiesHTML += `
              <div class="activity" 
                    style="opacity:1;display:flex;position:relative;height:auto;" 
                    data-theid="${activity.id}"
                    data-date="${activity.acf.dia_especifico}"
                    data-colorstroke='${colorStroke}'
                    data-colorfill='${colorFill}'
                    data-description='${activity.content.rendered}' 
                    data-title='${activity.title.rendered}'
                    data-curriculum='${activity.acf.curriculum
                ? activity.acf.curriculum.map((el) => el.ID)
                : ""
              }'
                    data-edad='${filteredAges.join(", ")}'
                    data-objetivos='${activity.acf.objetivos}' 
                    data-instrucciones='${activity.acf.instrucciones}'
                    data-momentoaprendizaje='${momentoAprendizaje}'
                    data-tiempo='${activity.acf.tiempo_en_minutos}' 
                    data-tema='${activity.acf.tema
                ? activity.acf.tema.map((el) => el.post_title)
                : ""
              }'
                    data-materiales='${activity.acf.materiales || ""}'
                    data-materiales_reciclables='${activity.acf.materiales_reciclables || ""}'
                    data-tips='${activity.acf.tips}'
                    data-foto='${activity.acf.foto.url
                ? activity.acf.foto.url
                : activity.acf.multimedia.url
              }'
                    data-dominios_uc='${activity.acf.dominios_uc
                ? activity.acf.dominios_uc.map((el) => el.ID)
                : ""
              }'
                    data-multimedia='${activity.acf.multimedia?.url || ""}'
                    data-multimedia_en='${activity.acf.multimedia_en?.url || ""}'
                    data-link_de_cancion='${activity.acf.link_de_cancion}'
                    data-link_de_cuento='${activity.acf.link_de_cuento}'
                    data-elof='${activity.acf.elof
                ? activity.acf.elof.map((el) => el.ID)
                : ""
              }'
                    data-enfoque='${activity.acf.enfoque_general
                ? activity.acf.enfoque_general.map((el) => el.ID)
                : ""
              }'>
                ${badgeHTML} <!-- Badge si aplica -->
                <span class="bold" style="color:${colorStroke};">
                  ${activity.title.rendered}
                </span>
                <span style="color:${colorStroke};">
                  ${curriculumID === 647 || curriculumID === 5828
                ? actualLang === "es"
                  ? "Actividad de Estimulación"
                  : "Stimulation Activity"
                : activity.acf.momento_de_aprendizaje
                  ? activity.acf.momento_de_aprendizaje
                    .map((el) => {
                      const momento = momentosArray.find(
                        (momento) => momento.id == el.ID
                      );
                      const texto =
                        actualLang === "es"
                          ? momento.title.rendered
                          : momento.acf.traduccion;

                      // Excluir "Actividad de Estimulación" del título
                      return texto.includes(
                        "Actividad de Estimulación"
                      ) && actualLang === "es"
                        ? ""
                        : texto.includes("Stimulation Activity") &&
                          actualLang !== "es"
                          ? ""
                          : texto;
                    })
                    .filter(Boolean)
                    .join(", ") // Filtrar elementos vacíos
                  : ""
              }
                </span>

                <span class="gruposDeEdad" 
                    style="
                    position: relative;
                    right: -15px;
                    min-height: auto;
                    font-size: 12px;
                    font-weight: 600;
                    color: white;
                    background-color: ${colorStroke};
                    margin-top: 10px;
                    border-top-left-radius: 5px;
                    border-bottom-left-radius: 5px;
                    padding: 2px 5px;
                ">
                ${filteredAges.join(", ")}
                </span>        
              </div>
            `;
          });

          // Establecer el HTML acumulado de todas las actividades de esta fecha en el contenedor
          console.log(`Agregando ${sortedActivities.length} actividades al contenedor para fecha: "${dateForSelector}"`);
          console.log(`HTML a agregar (primeros 200 caracteres):`, activitiesHTML.substring(0, 200));
          console.log(`Contenedor antes de agregar:`, container);
          console.log(`Contenido actual del contenedor:`, container.innerHTML.substring(0, 100));
          
          container.innerHTML += activitiesHTML;
          
          console.log(`Contenido después de agregar:`, container.innerHTML.substring(0, 200));
          console.log(`✓ Actividades agregadas correctamente para fecha: "${dateForSelector}"`);
          
          // Traducir inmediatamente después de agregar al DOM
          translateInDOM(document.getElementById("lang").value);
        } else {
          console.log(`No se encontró un contenedor para la fecha ${date}`);
        }
      });
    }

    // Seleccionar todos los elementos con la clase "activity"
    const elements = document.querySelectorAll(
      ".containerActivities .activity"
    );

    // Inicializar una variable para almacenar la altura máxima
    let maxHeight = 0;

    // Iterar sobre los elementos para encontrar la altura máxima
    elements.forEach((element) => {
      const height = element.getBoundingClientRect().height;
      maxHeight = Math.max(maxHeight, height);
    });

    // Establecer la altura máxima en todos los elementos
    elements.forEach((element) => {
      element.style.height = maxHeight + "px";
    });

    var favDialog = document.getElementById("favDialog");
    document
      .querySelector("#cancel")
      .addEventListener("click", () => favDialog.close());

    // let btnCompartir = document.getElementById("compartir");
    // let shareOptions = document.getElementById("share_actividad");
    // let whatsapp = document.getElementById("share-whatsapp");
    // let link = document.getElementById("share-copy");
    // let listenersAdded = false;
    // let publicUrl;
    // function toggleShareOptions(event) {
    //   event.preventDefault();
    //   if (
    //     shareOptions.style.display === "none" ||
    //     shareOptions.style.display === ""
    //   ) {
    //     shareOptions.style.display = "block";
    //   } else {
    //     shareOptions.style.display = "none";
    //   }
    //   // btnCompartir.removeEventListener('click', toggleShareOptions);
    // }

    // function shareOnWhatsapp() {
    //   const shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(
    //     publicUrl
    //   )}`;
    //   window.open(shareUrl, "_blank");
    // }

    // function copyLink() {
    //   navigator.clipboard
    //     .writeText(publicUrl)
    //     .then(() => {
    //       alert("Enlace copiado al portapapeles");
    //     })
    //     .catch((err) => {
    //       console.error("Error al copiar el enlace: ", err);
    //     });
    // }

    // function addEventListeners(theid) {
    //   publicUrl = `/miembros/shareActividad/${theid}`;
    //   if (!listenersAdded) {
    //     btnCompartir.addEventListener("click", toggleShareOptions);
    //     whatsapp.addEventListener("click", () => shareOnWhatsapp(theid));
    //     link.addEventListener("click", () => copyLink(theid));

    //     listenersAdded = true; // Indica que los listeners han sido agregados
    //   }
    // }

    let btnCompartir = document.getElementById("compartir");
    let shareOptions = document.getElementById("share_actividad");
    let whatsapp = document.getElementById("share-whatsapp");
    let link = document.getElementById("share-copy");
    let shareEmail = document.getElementById("btnActividadEmail");
    let listenersAdded = false;
    let publicUrl;
    function toggleShareOptions(event) {
      event.preventDefault();
      if (
        shareOptions.style.display === "none" ||
        shareOptions.style.display === ""
      ) {
        shareOptions.style.display = "block";
      } else {
        shareOptions.style.display = "none";
      }
      // btnCompartir.removeEventListener('click', toggleShareOptions);
    }

    function shareOnWhatsapp() {
      const shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(
        publicUrl
      )}`;
      window.open(shareUrl, "_blank");
    }

    function copyLink() {
      navigator.clipboard
        .writeText(publicUrl)
        .then(() => {
          alert("Enlace copiado al portapapeles");
        })
        .catch((err) => {
          console.error("Error al copiar el enlace: ", err);
        });
    }

    function sendActividadEmail() {
      // Obtener los valores de las variables
      var curriculum = curriculumID;
      var lang = document.getElementById("lang").value;
      var semanaSelect = document.getElementById("semanaSelect");
      var semana = semanaSelect.options[semanaSelect.selectedIndex].value;

      // Definir tipo_actividad y url según el origen de la llamada
      let tipo_actividad = "actividad";
      let url = publicUrl;
      let recipientEmail;
      recipientEmail = document.getElementById("recipientEmailActividad").value;
      if (!recipientEmail) {
        alert("Por favor ingresa un correo válido.");
        return;
      }

      // Preparar los datos a enviar
      const data = {
        email: recipientEmail,
        curriculum: curriculum,
        semana: semana,
        lang: lang,
        tipo_actividad: tipo_actividad,
        url: url,
      };

      fetch("https://hook.us1.make.com/8ldbix384fblq1ui5ykyvadqtqame7ix", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      })
        .then((response) => {
          if (response.ok) {
            document.querySelector(".mainContentActividad").style.display =
              "none";
            document.querySelector(".confirmationActividad").style.display =
              "flex";
            setTimeout(closePopupActividad, 2000);
          } else {
            alert("Hubo un error al enviar el correo.");
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("No se pudo enviar el correo.");
        });
    }

    function addEventListeners(theid) {
      publicUrl = `https://bilingualchildcaretraining.com/miembros/shareActividad/${theid}`;
      if (!listenersAdded) {
        btnCompartir.addEventListener("click", toggleShareOptions);
        whatsapp.addEventListener("click", () => shareOnWhatsapp(theid));
        link.addEventListener("click", () => copyLink(theid));
        shareEmail.addEventListener("click", () => sendActividadEmail(theid));
        listenersAdded = true; // Indica que los listeners han sido agregados
      }
    }

    // Obtener el contenedor del diálogo una vez al inicio
    const dialog = document.getElementById("favDialog");

    document.querySelectorAll(".activity").forEach(async (activity) => {
      // console.log("Dentro del event listener de activity");
      // console.log(activity);
      let btnmulti = document.querySelector(
        "dialog .dialog-body .btn.adjuntos"
      );
      let btnmultiDownload = document.querySelector(
        "dialog .dialog-body .btn.dowload-adjuntos"
      );
      let printPlantilla = document.querySelector(
        "dialog .dialog-body .printPlantilla"
      );
      let btnadjuntos = document.querySelector(
        "dialog .dialog-body .btn.multimedia"
      );

      let dominiosTitles = [
        "Ecología",
        "Inteligencia emocional",
        "Tecnología",
        "Innovación",
        "Resolución de problemas",
        "Emprendimiento",
        "Trabajo en equipo",
        "Área sensorial",
        "Pensamiento creativo",
      ];
      let dominiosColor = [
        "#84C174",
        "#624595",
        "#4372B8",
        "#EE75A8",
        "#F5A535",
        "#A6529A",
        "#4FBCC0",
        "#9872B0",
        "#488AC9",
      ];
      let elofColor = ["#3C5DA8", "#E45990", "#56A5A2", "#8FA33A", "#8F2371"];
      // console.log("activity", activity);
      let {
        colorfill,
        colorstroke,
        curriculum,
        description,
        dominios_uc,
        edad,
        elof,
        enfoque,
        aprendizaje,
        foto,
        instrucciones,
        link_de_cancion,
        link_de_cuento,
        materiales,
        materiales_reciclables,
        momento,
        multimedia,
        objetivos,
        tema,
        theid,
        tiempo,
        title,
        tips,
      } = activity.dataset;
      let filteredArrayDominio;
      let filteredArrayElof;
      let filteredArrayEnfoque;
      if (!activity.classList.contains("song")) {
        activity.style.backgroundColor = colorfill;
        activity.style.borderColor = colorstroke;
      }
      let edadTitle = edad ? edad : "";
      // Evitar agregar múltiples listeners al mismo elemento
      if (activity.hasAttribute('data-listener-added')) {
        return;
      }
      activity.setAttribute('data-listener-added', 'true');
      
      activity.addEventListener("click", async () => {
        let activityId;

        // Verificar si el atributo data-theid-esp está indefinido o vacío
        if (
          activity.getAttribute("data-theid-esp") === "undefined" ||
          activity.getAttribute("data-theid-esp") === "" ||
          activity.getAttribute("data-theid-esp") === null
        ) {
          // Si está indefinido o vacío, asignar el valor de data-theid
          activityId = activity.getAttribute("data-theid");
        } else {
          // Si tiene un valor, asignar el de data-theid-esp
          activityId = activity.getAttribute("data-theid-esp");
        }

        fetch("/miembros/get/getCalifications.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ activityId: activityId }),
        })
          .then((response) => response.json())
          .then((data) => {
            const promedioElement = document.getElementById("promedio");
            const cantidadCalificacionesElement = document.getElementById(
              "cantidadCalificaciones"
            );
            const estrellasElement = document.getElementById("estrellas");

            // Validación de existencia de elementos en el DOM
            if (
              !promedioElement ||
              !cantidadCalificacionesElement ||
              !estrellasElement
            ) {
              console.error(
                "Uno o más elementos del DOM no fueron encontrados."
              );
              return;
            }

            if (Array.isArray(data) && data.length > 0) {
              const firstItem = data[0];
              const promedio = Math.round(firstItem.promedio) || 0;
              promedioElement.textContent = promedio;

              if (
                firstItem.calificacion_actividads &&
                Array.isArray(firstItem.calificacion_actividads)
              ) {
                cantidadCalificacionesElement.textContent = `(${firstItem.calificacion_actividads.length})`;
              } else {
                cantidadCalificacionesElement.textContent = "(0)";
              }

              estrellasElement.innerHTML = "";

              for (let i = 0; i < promedio; i++) {
                estrellasElement.innerHTML += `
          <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid fill">
            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
          </svg>`;
              }

              for (let i = promedio; i < 5; i++) {
                estrellasElement.innerHTML += `
          <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
          </svg>`;
              }
            } else {
              // No hay calificaciones aún, esto es normal y no es un error
              promedioElement.textContent = "0";
              cantidadCalificacionesElement.textContent = "(0)";
              estrellasElement.innerHTML = "";

              for (let i = 0; i < 5; i++) {
                estrellasElement.innerHTML += `
          <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
          </svg>`;
              }
            }
          })
          .catch((error) => {
            console.error("Error fetching data:", error);
          });

        // Mostrar el preloader
        $(".preloader").fadeIn();

        // Obtener el contenedor de calificación en el diálogo
        const ratingDiv = dialog.querySelector(".rating-container");

        // Limpiar el contenedor de calificación existente (si existe)
        ratingDiv.innerHTML = "";

        // Crear un nuevo contenedor para la calificación de LA actividad
        const ratingContainer = document.createElement("div");
        ratingContainer.id = `rating-container-${activityId}`;
        ratingContainer.classList.add("rating");

        // Recuperar la calificación guardada del localStorage
        const savedRating = localStorage.getItem(`rating-${activityId}`);

        // Agregar dinámicamente los inputs de calificación
        for (let i = 5; i >= 1; i--) {
          // Cambia el bucle para que cuente de 5 a 1
          const input = document.createElement("input");
          input.type = "radio";
          input.id = `star${i}-${activityId}`;
          input.name = `rate-${activityId}`;
          input.value = i;

          // Si existe una calificación guardada, seleccionarla
          if (savedRating && savedRating === i.toString()) {
            input.checked = true;
          }

          const label = document.createElement("label");
          label.setAttribute("for", `star${i}-${activityId}`);
          label.title = `${i} estrellas`; // Cambia el título para reflejar el número de estrellas
          label.innerHTML = `<svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                  <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
              </svg>`;

          // Agregar el input y el label al nuevo contenedor de calificación
          ratingContainer.appendChild(input);
          ratingContainer.appendChild(label);

          // Función para obtener el nombre del navegador
          function getBrowserName(userAgent) {
            if (userAgent.includes("Firefox")) return "Firefox";
            if (userAgent.includes("Edg")) return "Edge";
            if (userAgent.includes("Chrome")) return "Chrome";
            if (userAgent.includes("Safari")) return "Safari";
            if (userAgent.includes("Opera") || userAgent.includes("OPR"))
              return "Opera";
            return "Desconocido"; // Navegador no identificado
          }

          // Agregar un evento para activar el webhook al cambiar la calificación
          input.addEventListener("change", async () => {
            if (input.checked) {
              const ratingValue = input.value;
              const userSessionID =
                document.getElementById("userSession").innerText;
              const semanaSeleccionada =
                document.getElementById("selectedWeek").value;
              const temaCurriculum =
                document.getElementById("asideTitle").innerText;
              const webhookUrl =
                "https://hook.us1.make.com/5elf0ghnnn8ez1n8n4ivfsbdbifo65f2";

              // Obtener fecha actual en formato YYYY-MM-DD
              const currentDate = new Date().toISOString().split("T")[0];

              // Obtener resolución de pantalla
              const screenResolution = `${window.screen.width}x${window.screen.height}`;

              // Obtener navegador
              const browserInfo = getBrowserName(navigator.userAgent);

              // Obtener la IP pública
              let userIP = "Desconocida";
              try {
                const response = await fetch(
                  "https://api.ipify.org?format=json"
                );
                const data = await response.json();
                userIP = data.ip;
              } catch (error) {
                console.error("Error al obtener la IP del usuario:", error);
              }

              // Crear los datos para enviar
              const payload = {
                rating: ratingValue,
                activityId: activityId,
                userId: userSessionID,
                semana: semanaSeleccionada,
                tema: temaCurriculum,
                fecha: currentDate,
                resolucion: screenResolution,
                navegador: browserInfo,
                ip: userIP,
              };

              try {
                // Enviar los datos al webhook usando fetch
                const response = await fetch(webhookUrl, {
                  method: "POST",
                  headers: {
                    "Content-Type": "application/json",
                  },
                  body: JSON.stringify(payload),
                });

                // Manejar la respuesta
                if (response.ok) {
                  const responseData = await response.json();
                } else {
                  console.error(
                    "Error al activar el webhook:",
                    response.statusText
                  );
                }
              } catch (error) {
                console.error("Error de red:", error);
              }

              // Guardar la calificación seleccionada en el localStorage
              localStorage.setItem(`rating-${activityId}`, ratingValue);
            }
          });
        }

        // Agregar el nuevo contenedor al diálogo
        ratingDiv.appendChild(ratingContainer);

        if (
          dominioPromises.length == 0 ||
          elofPromises.length == 0 ||
          momentosPromises.length == 0 ||
          enfoquePromises.length == 0
        ) {
          await getElofAndDominios();
        }

        const momentoIcono = momentosPromises.find(
          (moment) => moment.title == momento
        );

        function filterArrayByIDs(array, idsToFilter) {
          const idsToFilterClean = idsToFilter.map((id) => id.trim()); // Asegurar que los IDs sean strings limpios

          const filteredArray = array.filter((item) => {
            return idsToFilterClean.includes(item.id.toString());
          });
          return filteredArray;
        }

        const dataEnfoque = activity.dataset.enfoque;

        const enfoqueIDs = dataEnfoque ? dataEnfoque.split(",") : [];

        filteredArrayEnfoque = filterArrayByIDs(enfoquePromises, enfoqueIDs);

        if (dominios_uc || elof) {
          const idsToFilterdominios_uc = dominios_uc
            ? dominios_uc.split(",").map((id) => id.trim())
            : [];
          const idsToFilterelof = elof
            ? elof.split(",").map((id) => id.trim())
            : [];

          filteredArrayDominio = filterArrayByIDs(
            dominioPromises,
            idsToFilterdominios_uc
          );
          filteredArrayElof = filterArrayByIDs(elofPromises, idsToFilterelof);
        }

        // Llama a la función que agrega los event listeners cuando la actividad es cargada

        addEventListeners(theid);
        const setAdjuntosLink = () => {
        
          if (link_de_cancion !== "" && link_de_cancion !== "false") {
            btnadjuntos.href = link_de_cancion;
            btnadjuntos.style.display = "flex";
          } else if (link_de_cuento !== "" && link_de_cuento !== "false") {
            btnadjuntos.href = link_de_cuento;
            btnadjuntos.style.display = "flex";
          } else {
            btnadjuntos.style.display = "none";
          }
        };

        const setMultimediaLink = () => {
          const sanitizeMultimediaUrl = (value) => {
            if (!value) return "";
            const trimmed = value.toString().trim();
            return trimmed === "" ||
              trimmed === "false" ||
              trimmed === "undefined"
              ? ""
              : trimmed;
          };

          const preferred =
            lang === "es"
              ? activity.dataset.multimedia
              : activity.dataset.multimedia_en;
          const fallback =
            lang === "es"
              ? activity.dataset.multimedia_en
              : activity.dataset.multimedia;

          const multimediaURL =
            sanitizeMultimediaUrl(preferred) ||
            sanitizeMultimediaUrl(fallback);

          if (multimediaURL) {
            btnmulti.href = `/miembros/print.php?file=${multimediaURL}&fileName=${get_alias(
              title
            )}`;
            btnmultiDownload.href = `/miembros/download.php?file=${multimediaURL}&fileName=${get_alias(
              title
            )}`;
            btnmulti.style.display = "flex";
            btnmultiDownload.style.display = "flex";
          } else {
            btnmulti.style.display = "none";
            btnmultiDownload.style.display = "none";
          }
        };

        const setHeaderStyles = () => {
          document.querySelector(".dialog-header").style.backgroundColor =
            colorstroke;
          document.querySelector("dialog .dialog-header h2.title").innerHTML =
            title;
          document.querySelector(
            "dialog .dialog-header .flex .time span"
          ).innerHTML = `${tiempo} min`;
        };
        const setContent = async () => {
          if (window.innerWidth > 768) {
            document.querySelector("#orientacion").setAttribute("open", true);
            document.querySelector("#desc").setAttribute("open", true);
            document.querySelector("#objetivo").setAttribute("open", true);
          }
          document.querySelector("#orientacion .cont").innerHTML =
            instrucciones;
          document.querySelector("#desc .cont").innerHTML = description;
          document.querySelector("#objetivo .cont").innerHTML = objetivos;
          if (foto != "false" && foto != "undefined" && foto != undefined) {
            // Mostrar imagen si existe 'foto'
            document.querySelector(".foto img").style.display = "block";
            document.querySelector(".foto img").src = foto;
            document.querySelector(".foto .placeholder").style.display = "none";
          } else if (
            multimedia != "false" &&
            multimedia != "undefined" &&
            multimedia != undefined
          ) {
            // Mostrar imagen si no hay 'foto' pero sí 'multimedia'
            document.querySelector(".foto img").style.display = "block";
            document.querySelector(".foto img").src = multimedia;
            document.querySelector(".foto .placeholder").style.display = "none";
          } else {
            // Si no hay ni 'foto' ni 'multimedia', mostrar el placeholder
            document.querySelector(".foto img").style.display = "none";
            document.querySelector(".foto .placeholder").style.display = "flex";

            if (momentoIcono) {
              document.querySelector(
                ".foto .placeholder"
              ).innerHTML = `<img src="${momentoIcono.icon}" alt="icono" width="50px"/>`;
            }

            // Aplicar el nuevo color al fondo del elemento
            document.querySelector(".foto .placeholder").style.backgroundColor =
              colorfill;
            document.querySelector(
              ".foto .placeholder"
            ).style.border = `2px solid ${colorstroke}`;
          }

          document.querySelector(".materiales").innerHTML = `${materiales || ''}${materiales_reciclables || ''}`;
          document.querySelector(".tip").innerHTML = `${tips}`;
          document.querySelector(
            "dialog .dialog-header .flex .years span"
          ).innerHTML = edadTitle;
        };

        const renderItems = () => {
          const responses = [
            ...filteredArrayDominio,
            ...filteredArrayElof,
            ...momentosPromises,
            ...filteredArrayEnfoque,
          ];

          if (responses.length > 0) {
            // Limpiar contenido antes de agregar nuevos elementos
            document.querySelector(".dominios .con").innerHTML = "";
            document.querySelector(".subdominios .con").innerHTML = "";
            document.querySelector("#enfoque .con").innerHTML = "";

            // Variables para evitar duplicaciones
            let processedElofTypes = new Set();
            let processedDominioTypes = new Set();

            // Iterar sobre las respuestas
            responses.forEach((response) => {
              if (response.typeLocal === "elof") {
                let elof = response;

                // Evitar duplicados en ELOF
                if (processedElofTypes.has(elof.id)) return;
                processedElofTypes.add(elof.id);

                // Decodificar el título HTML
                let textoOriginal = elof.title || "";
                let elementoTemporal = document.createElement("div");
                elementoTemporal.innerHTML = textoOriginal;
                let textoDecodificado =
                  elementoTemporal.textContent || elementoTemporal.innerText;
                let partes = textoDecodificado.includes("–")
                  ? textoDecodificado.split("–")
                  : [textoDecodificado, ""];

                let textoSeparado =
                  partes.length > 1 ? partes[1].trim() : partes[0];

                let color = elofColor[elof.type] || "#E45990"; // Color por defecto si no está definido

                // Insertar ELOF en .subdominios .con
                document.querySelector(".subdominios .con").innerHTML += `
                  <div class="subdominios-item">
                    <img src="${elof.icon ? elof.icon : `img/dominios/${elof.type}.svg`
                  }" />
                    <small style="color:${color};">${textoSeparado}</small>
                  </div>`;
              } else if (response.typeLocal === "dominiouc") {
                let dominio = response;

                // Evitar duplicados en Dominios UC
                if (processedDominioTypes.has(dominio.id)) return;
                processedDominioTypes.add(dominio.id);

                // Decodificar el título HTML
                let textoOriginal = dominio.title || "";
                let elementoTemporal = document.createElement("div");
                elementoTemporal.innerHTML = textoOriginal;
                let textoDecodificado =
                  elementoTemporal.textContent || elementoTemporal.innerText;
                let partes = textoDecodificado.includes("–")
                  ? textoDecodificado.split("–")
                  : [textoDecodificado, ""];

                let textoSeparado =
                  partes.length > 1 ? partes[1].trim() : partes[0];

                let color = elofColor[dominio.type] || "#624595"; // Color por defecto

                // Insertar Dominios UC en .dominios .con
                document.querySelector(".dominios .con").innerHTML += `
                  <div class="dominios-item">
                    <img src="${dominio.icon
                    ? dominio.icon
                    : `img/elof/${dominio.type}.svg`
                  }" />
                    <small style="color:${color};">${textoSeparado}</small>
                  </div>`;
              } else if (response.typeLocal === "enfoque_general") {
                let enfoque = response;

                // Decodificar el título HTML
                let enfoqueTituloOriginal = enfoque.title || "";
                let tempTitleElement = document.createElement("div");
                tempTitleElement.innerHTML = enfoqueTituloOriginal;
                let enfoqueTituloDecodificado =
                  tempTitleElement.textContent || tempTitleElement.innerText;

                let enfoqueTituloEN, colorEnfoque, imagenEnfoque;

                if (enfoqueTituloDecodificado === "Desarrollo Cognitivo") {
                  enfoqueTituloEN = "Cognitive Development";
                  colorEnfoque = "#8773AE";
                  imagenEnfoque = "img/enfoque/cognitivo.png";
                } else if (
                  enfoqueTituloDecodificado === "Desarrollo del espíritu"
                ) {
                  enfoqueTituloEN = "Spiritual Development";
                  colorEnfoque = "#30f77e";
                  imagenEnfoque = "img/enfoque/espiritu.png";
                } else if (
                  enfoqueTituloDecodificado === "Desarrollo Emocional"
                ) {
                  enfoqueTituloEN = "Emotional Development";
                  colorEnfoque = "#F5AA16";
                  imagenEnfoque = "img/enfoque/emocional.png";
                } else if (enfoqueTituloDecodificado === "Desarrollo Físico") {
                  enfoqueTituloEN = "Physical Development";
                  colorEnfoque = "#0CB5C3";
                  imagenEnfoque = "img/enfoque/fisico.png";
                } else if (enfoqueTituloDecodificado === "Desarrollo Social") {
                  enfoqueTituloEN = "Social Development";
                  colorEnfoque = "#EB5D5E";
                  imagenEnfoque = "img/enfoque/social.png";
                }

                // Insertar elementos DOM para enfoque
                document.querySelector("#enfoque .con").innerHTML += `
                  <div class="enfoque-item">
                    <img src="${imagenEnfoque}" />
                    <small style="color: ${colorEnfoque}; font-size: 12px;">
                      ${enfoqueTituloDecodificado}
                    </small>
                  </div>
                `;
              }
            });

            // Mostrar los contenedores solo si tienen contenido
            document.querySelector(".dominios").style.display =
              document.querySelector(".dominios .con").innerHTML.trim() !== ""
                ? "grid"
                : "none";

            document.querySelector(".subdominios").style.display =
              document.querySelector(".subdominios .con").innerHTML.trim() !==
                ""
                ? "grid"
                : "none";

            // Mostrar el contenedor de enfoque si tiene contenido
            const enfoqueContainer = document.querySelector("#enfoque");
            enfoqueContainer.style.display =
              document.querySelector("#enfoque .con").innerHTML.trim() !== ""
                ? "block"
                : "none";

            // Mostrar diálogo modal
            favDialog.showModal();
          } else {
            console.log("⚠️ No hay respuestas para mostrar en el HTML.");
          }
        };

        setAdjuntosLink();
        setMultimediaLink();
        setHeaderStyles();
        setContent();
        // eliminado para desarrollo
        // trackCurriculumActivity(title, title);
        if (filteredArrayDominio && filteredArrayElof) {
          renderItems();
          $(".preloader").fadeOut("slow");
        }

        // Traducir inmediatamente después de agregar al DOM
        translateInDOM(document.getElementById("lang").value);
      });
    });
  } catch (error) {
    console.error("Error al obtener los objetos:", error);
    throw error;
  }
};
const getWeekData3k = async (
  activityType,
  colorfill,
  colorstroke,
  elements,
  lang,
  week
) => {
  try {

    // Obtener las fechas ANTES de hacer las consultas para poder filtrar inmediatamente
    let fechaInicioSemana = null;
    let fechaFinSemana = null;
    const semanaSelect = document.getElementById('semanaSelect');
    
    console.log(`getWeekData3k llamado para ${elements}, semana: ${week}, activityType: ${activityType}`);
    
    // Intentar obtener las fechas del select, con múltiples intentos si es necesario
    let intentos = 0;
    const maxIntentos = 3;
    
    while ((!fechaInicioSemana || !fechaFinSemana) && intentos < maxIntentos) {
      const semanaSelect = document.getElementById('semanaSelect');
      
      if (semanaSelect && semanaSelect.selectedIndex > 0) {
        const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
        console.log(`Texto del select de semana (intento ${intentos + 1}): "${weekText}"`);
        
        // Extraer las fechas de inicio y fin (formato: "Semana MM/DD/YYYY al MM/DD/YYYY")
        const fechaMatches = Array.from(weekText.matchAll(/(\d{2})\/(\d{2})\/(\d{4})/g));
        console.log(`Fechas encontradas en el texto:`, fechaMatches.length);
        
        if (fechaMatches.length >= 2) {
          // Primera fecha es inicio, segunda es fin
          const inicioMatch = fechaMatches[0];
          const finMatch = fechaMatches[1];
          
          // Convertir MM/DD/YYYY a DD/MM/YYYY para comparar con dia_especifico
          const mesInicio = inicioMatch[1];
          const diaInicio = inicioMatch[2];
          const añoInicio = inicioMatch[3];
          fechaInicioSemana = `${diaInicio}/${mesInicio}/${añoInicio}`; // DD/MM/YYYY
          
          const mesFin = finMatch[1];
          const diaFin = finMatch[2];
          const añoFin = finMatch[3];
          fechaFinSemana = `${diaFin}/${mesFin}/${añoFin}`; // DD/MM/YYYY
          
          console.log(`Fechas de la semana para filtrar por dia_especifico (getWeekData3k): ${fechaInicioSemana} al ${fechaFinSemana}`);
          break; // Salir del bucle si se obtuvieron las fechas
        } else {
          console.warn(`No se encontraron suficientes fechas en el texto del select: ${fechaMatches.length} encontradas, se esperaban al menos 2`);
        }
      } else {
        if (intentos === 0) {
          console.warn(`No se pudo obtener el select de semana o no tiene selección válida (selectedIndex: ${semanaSelect?.selectedIndex}), esperando...`);
        }
      }
      
      intentos++;
      if (intentos < maxIntentos && (!fechaInicioSemana || !fechaFinSemana)) {
        // Esperar un poco antes del siguiente intento
        await new Promise(resolve => setTimeout(resolve, 100));
      }
    }
    
    if (!fechaInicioSemana || !fechaFinSemana) {
      console.warn(`[getWeekData3k] No se pudieron obtener las fechas después de ${intentos} intentos`);
    }

    // Función para parsear fechas DD/MM/YYYY
    const parseDateDDMMYYYY = (dateStr) => {
      if (!dateStr) return null;
      const parts = dateStr.toString().trim().split('/');
      if (parts.length === 3) {
        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10);
        const year = parseInt(parts[2], 10);
        // Validar que los valores sean números válidos
        if (isNaN(day) || isNaN(month) || isNaN(year)) return null;
        return new Date(year, month - 1, day);
      }
      return null;
    };

    // Función para filtrar actividades por dia_especifico ANTES de procesarlas
    // Similar a cómo se hace en getWeekDataNew: comparar fechas directamente
    // La comparación de fechas ya incluye el año implícitamente
    const filterByDateRange = (activities) => {
      if (!fechaInicioSemana || !fechaFinSemana) {
        console.warn(`[filterByDateRange] No se tienen fechas para filtrar, devolviendo todas las ${activities.length} actividades`);
        return activities; // Si no tenemos fechas, devolver todas
      }

      const fechaInicio = parseDateDDMMYYYY(fechaInicioSemana);
      const fechaFin = parseDateDDMMYYYY(fechaFinSemana);
      
      if (!fechaInicio || !fechaFin) {
        console.warn(`[filterByDateRange] No se pudieron parsear las fechas: ${fechaInicioSemana}, ${fechaFinSemana}`);
        return activities; // Si no se pueden parsear las fechas, devolver todas
      }

      const añoInicio = fechaInicio.getFullYear();
      const añoFin = fechaFin.getFullYear();
      
      console.log(`[filterByDateRange] Filtrando ${activities.length} actividades por rango: ${fechaInicioSemana} (año ${añoInicio}) al ${fechaFinSemana} (año ${añoFin})`);

      const filtered = activities.filter((activity) => {
        // Si no tiene dia_especifico, excluirla
        if (!activity.acf?.dia_especifico) {
          return false;
        }
        
        const fechaActividad = parseDateDDMMYYYY(activity.acf.dia_especifico);
        if (!fechaActividad) {
          return false;
        }
        
        const añoActividad = fechaActividad.getFullYear();
        
        // Verificar primero que el año sea válido (dentro del rango de años de la semana)
        const añoValido = (añoInicio === añoFin && añoActividad === añoInicio) ||
                         (añoInicio !== añoFin && (añoActividad === añoInicio || añoActividad === añoFin));
        
        if (!añoValido) {
          console.log(`[filterByDateRange] Excluyendo actividad ${activity.id}: año ${añoActividad} no válido (esperado ${añoInicio}${añoInicio !== añoFin ? ' o ' + añoFin : ''}), dia_especifico: ${activity.acf.dia_especifico}`);
          return false;
        }
        
        // Verificar que la fecha de la actividad esté dentro del rango de la semana
        // La comparación de fechas ya incluye el año implícitamente
        const fechaValida = fechaActividad >= fechaInicio && fechaActividad <= fechaFin;
        
        if (!fechaValida) {
          console.log(`[filterByDateRange] Excluyendo actividad ${activity.id}: fecha ${activity.acf.dia_especifico} (año ${añoActividad}) fuera de rango (${fechaInicioSemana} al ${fechaFinSemana})`);
          return false;
        }
        
        return true;
      });

      console.log(`[filterByDateRange] ${filtered.length} actividades pasaron el filtro de ${activities.length} totales`);
      return filtered;
    };

    // Determinar si es una actividad especial que se filtra por semanas_a_las_que_pertence
    const esActividadEspecial = elements == ".almuerzo-container" || 
                                elements == ".snack-container" || 
                                elements == ".lavado-container";
    
    // Para la semana 1, WordPress no devuelve actividades correctamente cuando se filtra por semana
    // Por lo tanto, filtrar por momento_de_aprendizaje pero NO por semana, y filtrar por fecha client-side
    const esSemana1 = week === 1 || week === "1";
    
    // Optimización: reducir pp a 30 para evitar consultas muy pesadas
    let queries = [];
    
    // Para semana 1 que cruza el año (29 dic - 2 ene), WordPress NO respeta correctamente el filtro semanas_a_las_que_pertence=1
    // Estrategia: NO filtrar por semana en WordPress, solo por momento_de_aprendizaje, language, curriculum
    // Aumentar pp a 100 para asegurar que traigamos todas las actividades necesarias
    // El filtrado client-side por dia_especifico asegura que solo se incluyan actividades de la semana 1 (29/12/2025 - 02/01/2026)
    // NO usar 'after' porque puede excluir actividades de la semana 1 que fueron creadas antes de diciembre 2025
    if (esSemana1) {
      // Para semana 1, NO filtrar por semana en WordPress (WordPress no lo respeta correctamente para semanas que cruzan año)
      // Solo filtrar por momento_de_aprendizaje, language, curriculum
      // Usar pp=100 para asegurar que traigamos suficientes actividades (las de la semana 1 pueden estar mezcladas con otras)
      // El filtrado client-side por dia_especifico excluirá actividades de otras semanas (5, 6, 7)
      activityType.split(",").forEach((type) => {
        const query = `planessemanales?field=momento_de_aprendizaje,language,curriculum&value=${type},${lang},${curriculumID}&pp=100`;
        queries.push(query);
        console.log(`[${elements}] Semana 1 - Consulta SIN filtro de semana (WordPress no respeta semanas_a_las_que_pertence=1). pp=100 para traer más actividades. Filtrando client-side por dia_especifico: ${query}`);
      });
    } else {
      // Para otras semanas, filtrar por momento_de_aprendizaje y semana en WordPress
      activityType.split(",").forEach((type) => {
        const query = `planessemanales?field=momento_de_aprendizaje,language,curriculum,semanas_a_las_que_pertence&value=${type},${lang},${curriculumID},${week}&pp=30`;
        queries.push(query);
      });
    }
    
    console.log(`[${elements}] 📋 Se realizarán ${queries.length} consulta(s) a WordPress para ${activityType.split(",").length} momento(s) de aprendizaje`);

    // Usar requestWPParallel para hacer todas las consultas en una sola petición PHP
    // Esto reduce significativamente el tiempo de respuesta y evita errores 524
    const responses = await requestWPParallel(queries);
    
    // Log: Respuesta cruda del fetch de WordPress
    console.log(`[${elements}] RESPUESTA CRUDA DE WORDPRESS:`, responses);
    
    // Validar que responses sea un array válido
    if (!Array.isArray(responses)) {
      console.error(`[getWeekData3k] Respuestas inválidas para ${elements}:`, responses);
      return [];
    }
    
    // Normalizar respuestas PRIMERO: convertir objetos individuales a arrays
    const normalizedResponses = responses.map(response => {
      if (!response) return [];
      if (Array.isArray(response)) return response;
      // Si es un objeto individual, convertirlo a array
      return [response];
    });
    
    // Filtrar por dia_especifico INMEDIATAMENTE después de recibir las respuestas
    // PERO: Para actividades especiales, NO filtrar por dia_especifico, solo por año
    const totalRecibidas = normalizedResponses.reduce((sum, r) => {
      if (!r || !Array.isArray(r)) return sum;
      return sum + r.length;
    }, 0);
    console.log(`Para ${elements}: Total actividades recibidas de WordPress: ${totalRecibidas}${esActividadEspecial ? ' (actividad especial - filtrando por semanas_a_las_que_pertence)' : ''}`);
    
    // Para semana 1, verificar si hay actividades con dia_especifico dentro del rango ANTES de filtrar
    if (esSemana1 && fechaInicioSemana && fechaFinSemana && totalRecibidas > 0) {
      const fechaInicio = parseDateDDMMYYYY(fechaInicioSemana);
      const fechaFin = parseDateDDMMYYYY(fechaFinSemana);
      
      if (fechaInicio && fechaFin) {
        let actividadesEnRango = 0;
        let actividadesConSemana1 = 0;
        
        normalizedResponses.forEach((responseArray) => {
          if (Array.isArray(responseArray)) {
            responseArray.forEach((act) => {
              // Verificar si tiene dia_especifico dentro del rango
              if (act.acf?.dia_especifico) {
                const fechaActividad = parseDateDDMMYYYY(act.acf.dia_especifico);
                if (fechaActividad && fechaActividad >= fechaInicio && fechaActividad <= fechaFin) {
                  actividadesEnRango++;
                  console.log(`[${elements}] ✅ ACTIVIDAD EN RANGO encontrada ANTES de filtrar: ID ${act.id} "${act.title?.rendered}", dia_especifico=${act.acf.dia_especifico}`);
                }
              }
              
              // Verificar si tiene semanas_a_las_que_pertence con semana 1
              const semanas = act.acf?.semanas_a_las_que_pertence;
              if (semanas && (semanas.includes("1") || semanas.includes(1) || semanas.some(s => String(s) === "1" || Number(s) === 1))) {
                actividadesConSemana1++;
                console.log(`[${elements}] ✅ ACTIVIDAD CON SEMANA 1 encontrada ANTES de filtrar: ID ${act.id} "${act.title?.rendered}", dia_especifico=${act.acf?.dia_especifico || 'sin fecha'}, semanas_a_las_que_pertence=${JSON.stringify(semanas)}`);
              }
            });
          }
        });
        
        console.log(`[${elements}] 📊 RESUMEN ANTES DE FILTRAR: ${actividadesEnRango} actividades con dia_especifico en rango (${fechaInicioSemana} - ${fechaFinSemana}), ${actividadesConSemana1} actividades con semanas_a_las_que_pertence=["1"]`);
      }
    }
    
    // Normalizar week a string y number para comparación consistente
    const weekStr = String(week);
    const weekNum = Number(week);
    
    // Validar que responses sea un array antes de hacer reduce
    if (!Array.isArray(responses)) {
      console.error(`[getWeekData3k] responses no es un array para ${elements}:`, responses);
      return [];
    }
    
    const allObjects = normalizedResponses.reduce((acc, responseArray) => {
      // Validar que responseArray sea válido y sea un array (ya está normalizado)
      if (!responseArray || !Array.isArray(responseArray)) return acc;
      
      // Para semana 1, WordPress ya filtró por momento_de_aprendizaje en la consulta
      // No necesitamos filtrar client-side por momento_de_aprendizaje
      let activitiesToProcess = responseArray;
      
      if (esActividadEspecial) {
          // Para actividades especiales, filtrar solo por año (usando dia_especifico si está disponible)
          // y por semanas_a_las_que_pertence
          const filtered = activitiesToProcess.filter((activity) => {
            // Verificar que tenga semanas_a_las_que_pertence y que incluya la semana actual
            const tieneSemana = activity.acf?.semanas_a_las_que_pertence && 
                               (activity.acf.semanas_a_las_que_pertence.includes(weekStr) || 
                                activity.acf.semanas_a_las_que_pertence.includes(weekNum) ||
                                activity.acf.semanas_a_las_que_pertence.some(s => String(s) === weekStr || Number(s) === weekNum));
            
            if (!tieneSemana) {
              return false;
            }
            
            // Si tiene dia_especifico, verificar el año
            // Intentar obtener las fechas del select si no están disponibles
            let fechasDisponibles = fechaInicioSemana && fechaFinSemana;
            let fechaInicioLocal = fechaInicioSemana;
            let fechaFinLocal = fechaFinSemana;
            
            if (!fechasDisponibles) {
              const semanaSelect = document.getElementById('semanaSelect');
              if (semanaSelect && semanaSelect.selectedIndex > 0) {
                const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
                const fechaMatches = Array.from(weekText.matchAll(/(\d{2})\/(\d{2})\/(\d{4})/g));
                if (fechaMatches.length >= 2) {
                  const inicioMatch = fechaMatches[0];
                  const finMatch = fechaMatches[1];
                  
                  const mesInicio = inicioMatch[1];
                  const diaInicio = inicioMatch[2];
                  const añoInicio = inicioMatch[3];
                  fechaInicioLocal = `${diaInicio}/${mesInicio}/${añoInicio}`; // DD/MM/YYYY
                  
                  const mesFin = finMatch[1];
                  const diaFin = finMatch[2];
                  const añoFin = finMatch[3];
                  fechaFinLocal = `${diaFin}/${mesFin}/${añoFin}`; // DD/MM/YYYY
                  
                  fechasDisponibles = true;
                }
              }
            }
            
            if (activity.acf?.dia_especifico && fechasDisponibles) {
              const fechaActividad = parseDateDDMMYYYY(activity.acf.dia_especifico);
              if (fechaActividad) {
                const añoActividad = fechaActividad.getFullYear();
                const fechaInicio = parseDateDDMMYYYY(fechaInicioLocal);
                const fechaFin = parseDateDDMMYYYY(fechaFinLocal);
                
                if (fechaInicio && fechaFin) {
                  const añoInicio = fechaInicio.getFullYear();
                  const añoFin = fechaFin.getFullYear();
                  
                  const añoValido = (añoInicio === añoFin && añoActividad === añoInicio) ||
                                   (añoInicio !== añoFin && (añoActividad === añoInicio || añoActividad === añoFin));
                  
                  if (!añoValido) {
                    console.log(`[${elements}] Excluyendo actividad ${activity.id} en filtrado inicial: año ${añoActividad} no válido (esperado ${añoInicio}${añoInicio !== añoFin ? ' o ' + añoFin : ''}), dia_especifico: ${activity.acf.dia_especifico}`);
                    return false;
                  }
                }
              }
            }
            
            return true;
          });
          acc.push(...filtered);
        } else {
          // Para actividades normales, verificar semanas_a_las_que_pertence Y dia_especifico
          // Si tiene la semana correcta, verificar también que dia_especifico (si existe) corresponda a la semana correcta del año correcto
          const filtered = activitiesToProcess.filter((activity) => {
            // Primero verificar si tiene la semana correcta en semanas_a_las_que_pertence
            const tieneSemana = activity.acf?.semanas_a_las_que_pertence && 
                               (activity.acf.semanas_a_las_que_pertence.includes(weekStr) || 
                                activity.acf.semanas_a_las_que_pertence.includes(weekNum) ||
                                activity.acf.semanas_a_las_que_pertence.some(s => String(s) === weekStr || Number(s) === weekNum));
            
            // Para semana 1, WordPress NO respeta el filtro semanas_a_las_que_pertence=1 cuando cruza el año
            // Por lo tanto, filtrar ESTRICTAMENTE por dia_especifico dentro del rango de fechas (29/12/2025 - 02/01/2026)
            // Solo incluir actividades que tengan dia_especifico dentro del rango O que tengan semanas_a_las_que_pertence=["1"] Y dia_especifico dentro del rango
            if (esSemana1) {
              // Para semana 1, el filtro principal es por dia_especifico dentro del rango de fechas
              // Esto excluye actividades de otras semanas (5, 6, 7) que tienen fechas en febrero 2026
              if (!activity.acf?.dia_especifico) {
                // Si no tiene dia_especifico, solo incluirla si tiene semanas_a_las_que_pertence=["1"]
                if (tieneSemana) {
                  console.log(`[${elements}] Semana 1 - Incluyendo actividad ${activity.id}: tiene semana 1 pero sin dia_especifico`);
                  return true;
                }
                console.log(`[${elements}] Semana 1 - Excluyendo actividad ${activity.id}: no tiene dia_especifico ni semana 1`);
                return false;
              }
              
              // Verificar que dia_especifico esté dentro del rango de fechas de la semana 1
              if (!fechaInicioSemana || !fechaFinSemana) {
                console.log(`[${elements}] Semana 1 - Excluyendo actividad ${activity.id}: fechas de semana no disponibles`);
                return false;
              }
              
              const fechaActividad = parseDateDDMMYYYY(activity.acf.dia_especifico);
              const fechaInicio = parseDateDDMMYYYY(fechaInicioSemana);
              const fechaFin = parseDateDDMMYYYY(fechaFinSemana);
              
              if (!fechaActividad || !fechaInicio || !fechaFin) {
                console.log(`[${elements}] Semana 1 - Excluyendo actividad ${activity.id}: no se pudieron parsear fechas, dia_especifico=${activity.acf.dia_especifico}, fechaInicioSemana=${fechaInicioSemana}, fechaFinSemana=${fechaFinSemana}`);
                return false;
              }
              
              const añoActividad = fechaActividad.getFullYear();
              const añoInicio = fechaInicio.getFullYear();
              const añoFin = fechaFin.getFullYear();
              
              // Verificar que el año sea válido (2025 o 2026 para semana 1)
              const añoValido = (añoInicio === añoFin && añoActividad === añoInicio) ||
                               (añoInicio !== añoFin && (añoActividad === añoInicio || añoActividad === añoFin));
              
              if (!añoValido) {
                console.log(`[${elements}] Semana 1 - Excluyendo actividad ${activity.id}: año ${añoActividad} no válido (esperado ${añoInicio} o ${añoFin}), dia_especifico=${activity.acf.dia_especifico}`);
                return false;
              }
              
              // Verificar que la fecha esté dentro del rango (29/12/2025 - 02/01/2026)
              const dentroDelRango = fechaActividad >= fechaInicio && fechaActividad <= fechaFin;
              
              if (dentroDelRango) {
                console.log(`[${elements}] Semana 1 - ✅ Incluyendo actividad ${activity.id}: dia_especifico=${activity.acf.dia_especifico} está dentro del rango ${fechaInicioSemana} al ${fechaFinSemana}`);
                return true;
              } else {
                console.log(`[${elements}] Semana 1 - ❌ Excluyendo actividad ${activity.id}: dia_especifico=${activity.acf.dia_especifico} está FUERA del rango ${fechaInicioSemana} al ${fechaFinSemana} (año ${añoActividad})`);
                return false;
              }
            }
            
            // Para otras semanas, usar la lógica normal
            // Si tiene la semana correcta, incluirla siempre (incluso si dia_especifico está fuera del rango)
            // Esto es importante porque algunas actividades pueden tener semanas_a_las_que_pertence correcta
            // pero dia_especifico ligeramente fuera del rango debido a problemas de datos
            if (tieneSemana) {
              return true;
            }
            
            // Si no tiene la semana correcta, usar dia_especifico como filtro secundario
            if (activity.acf?.dia_especifico && fechaInicioSemana && fechaFinSemana) {
              const fechaActividad = parseDateDDMMYYYY(activity.acf.dia_especifico);
              if (fechaActividad) {
                const fechaInicio = parseDateDDMMYYYY(fechaInicioSemana);
                const fechaFin = parseDateDDMMYYYY(fechaFinSemana);
                
                if (fechaInicio && fechaFin) {
                  const añoActividad = fechaActividad.getFullYear();
                  const añoInicio = fechaInicio.getFullYear();
                  const añoFin = fechaFin.getFullYear();
                  
                  // Verificar que el año sea válido
                  const añoValido = (añoInicio === añoFin && añoActividad === añoInicio) ||
                                   (añoInicio !== añoFin && (añoActividad === añoInicio || añoActividad === añoFin));
                  
                  // Verificar que la fecha esté dentro del rango
                  const fechaValida = fechaActividad >= fechaInicio && fechaActividad <= fechaFin;
                  
                  // Solo incluirla si el dia_especifico está en el rango y el año es válido
                  return añoValido && fechaValida;
                }
              }
            }
            
            // Si no tiene la semana correcta y no tiene dia_especifico válido, excluirla
            return false;
          });
          
          // Log detallado del filtrado para semana 1
          if (esSemana1 && filtered.length > 0) {
            console.log(`[${elements}] Semana 1 - Después de filtrar respuesta ${activitiesToProcess.length} actividades (ya filtradas por momento_de_aprendizaje): ${filtered.length} pasaron el filtro`);
            filtered.forEach(act => {
              const momentos = act.acf?.momento_de_aprendizaje;
              const momentosIDs = momentos ? momentos.map(m => m.ID || m).join(', ') : 'sin momento';
              console.log(`  ✅ Actividad ${act.id} "${act.title?.rendered || 'sin título'}" PASÓ el filtro: dia_especifico=${act.acf?.dia_especifico}, momento_IDs=[${momentosIDs}]`);
              
              // Destacar si es la actividad "Celebrando en comunidad"
              if (act.id === 216627) {
                console.log(`  ⭐⭐ ACTIVIDAD "Celebrando en comunidad" PASÓ EL FILTRO`);
              }
            });
          }
          
          // Log de actividades que NO pasaron el filtro para semana 1
          if (esSemana1 && filtered.length < activitiesToProcess.length) {
            const excluidas = activitiesToProcess.filter(act => !filtered.some(f => f.id === act.id));
            console.log(`[${elements}] Semana 1 - ${excluidas.length} actividades EXCLUIDAS del filtro:`);
            excluidas.forEach(act => {
              const momentos = act.acf?.momento_de_aprendizaje;
              const momentosIDs = momentos ? momentos.map(m => m.ID || m).join(', ') : 'sin momento';
              console.log(`  ❌ Actividad ${act.id} "${act.title?.rendered || 'sin título'}" EXCLUIDA: dia_especifico=${act.acf?.dia_especifico}, momento_IDs=[${momentosIDs}]`);
              
              // Destacar si es la actividad "Celebrando en comunidad"
              if (act.id === 216627) {
                console.log(`  ⚠️⚠️ ACTIVIDAD "Celebrando en comunidad" FUE EXCLUIDA DEL FILTRO`);
              }
            });
          }
          
          acc.push(...filtered);
        }
      
      return acc;
    }, []);
    
    console.log(`Para ${elements}: ${totalRecibidas} actividades recibidas de WordPress, ${allObjects.length} después de filtrar${esActividadEspecial ? ' por semanas_a_las_que_pertence' : ' (por semanas_a_las_que_pertence o dia_especifico)'} (${fechaInicioSemana} al ${fechaFinSemana})`);
    
    // Log detallado para semana 1
    if (esSemana1) {
      console.log(`\n[${elements}] 🔍 RESUMEN FILTRADO SEMANA 1:`);
      console.log(`[${elements}] - Fechas de filtrado: ${fechaInicioSemana} al ${fechaFinSemana}`);
      console.log(`[${elements}] - Actividades recibidas de WordPress: ${totalRecibidas}`);
      console.log(`[${elements}] - Actividades que pasaron el filtro: ${allObjects.length}`);
      console.log(`[${elements}] - Actividades excluidas: ${totalRecibidas - allObjects.length}`);
      
      if (allObjects.length === 0 && totalRecibidas > 0) {
        console.warn(`[${elements}] ⚠️ PROBLEMA: Se recibieron ${totalRecibidas} actividades pero NINGUNA pasó el filtro.`);
        console.warn(`[${elements}] Esto puede indicar que las actividades tienen dia_especifico fuera del rango ${fechaInicioSemana} - ${fechaFinSemana}`);
      }
      
      // Verificar si la actividad "Celebrando en comunidad" está en allObjects
      const celebrandoEnComunidad = allObjects.find(act => act.id === 216627);
      if (celebrandoEnComunidad) {
        console.log(`[${elements}] ✅ ACTIVIDAD "Celebrando en comunidad" (ID: 216627) ESTÁ EN allObjects después del filtrado`);
      } else {
        console.log(`[${elements}] ❌ ACTIVIDAD "Celebrando en comunidad" (ID: 216627) NO ESTÁ en allObjects después del filtrado`);
      }
      console.log(`[${elements}] 🔍 FIN RESUMEN FILTRADO SEMANA 1\n`);
    }
    
    const uniqueObjects = Array.from(
      new Set(allObjects.map(JSON.stringify))
    ).map(JSON.parse);
    
    // Las actividades ya están filtradas por dia_especifico antes de llegar aquí (en filterByDateRange)
    let filteredObjects = uniqueObjects;
    
    // Función para agrupar los elementos por fecha
    function groupByDate(activities) {
      const groupedActivities = {};

      activities.forEach((activity) => {
        const dateKey = activity.acf.dia_especifico; // Clave de agrupación (ya viene en DD/MM/YYYY)
        if (!groupedActivities[dateKey]) {
          groupedActivities[dateKey] = [];
        }
        groupedActivities[dateKey].push(activity);
      });

      return groupedActivities;
    }

    // Intentar obtener las fechas del select si no se obtuvieron al inicio
    // Esto es necesario porque el select puede no estar listo cuando se ejecuta getWeekData3k
    if (!fechaInicioSemana || !fechaFinSemana) {
      const semanaSelect = document.getElementById('semanaSelect');
      if (semanaSelect && semanaSelect.selectedIndex > 0) {
        const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
        const fechaMatches = Array.from(weekText.matchAll(/(\d{2})\/(\d{2})\/(\d{4})/g));
        if (fechaMatches.length >= 2) {
          const inicioMatch = fechaMatches[0];
          const finMatch = fechaMatches[1];
          
          const mesInicio = inicioMatch[1];
          const diaInicio = inicioMatch[2];
          const añoInicio = inicioMatch[3];
          fechaInicioSemana = `${diaInicio}/${mesInicio}/${añoInicio}`; // DD/MM/YYYY
          
          const mesFin = finMatch[1];
          const diaFin = finMatch[2];
          const añoFin = finMatch[3];
          fechaFinSemana = `${diaFin}/${mesFin}/${añoFin}`; // DD/MM/YYYY
          
          console.log(`[getWeekData3k] Fechas obtenidas del select después del filtrado inicial: ${fechaInicioSemana} al ${fechaFinSemana}`);
        }
      }
    }
    
    // Las actividades ya están filtradas correctamente en allObjects:
    // - Actividades especiales: por semanas_a_las_que_pertence + validación de año
    // - Actividades normales: por semanas_a_las_que_pertence (si tienen la semana) o por dia_especifico (si no tienen la semana)
    // Sin embargo, necesitamos filtrar por año ANTES de agrupar para evitar intentar buscar contenedores de años anteriores
    let actividadesParaAgrupar = filteredObjects;
    
    // Aplicar filtrado por año ANTES de agrupar por fecha para evitar logs innecesarios
    if (fechaInicioSemana && fechaFinSemana) {
      const fechaInicio = parseDateDDMMYYYY(fechaInicioSemana);
      const fechaFin = parseDateDDMMYYYY(fechaFinSemana);
      
      if (fechaInicio && fechaFin) {
        const añoInicio = fechaInicio.getFullYear();
        const añoFin = fechaFin.getFullYear();
        const cruzaAño = añoInicio !== añoFin;
        
        const antesFiltradoAño = actividadesParaAgrupar.length;
        
        actividadesParaAgrupar = actividadesParaAgrupar.filter((activity) => {
          // Si tiene dia_especifico, verificar que el año sea válido
          if (activity.acf?.dia_especifico) {
            const fechaActividad = parseDateDDMMYYYY(activity.acf.dia_especifico);
            if (fechaActividad) {
              const añoActividad = fechaActividad.getFullYear();
              
              // Si la semana cruza el año, aceptar actividades de ambos años
              // Si no cruza el año, solo aceptar actividades del mismo año
              const añoValido = cruzaAño 
                ? (añoActividad === añoInicio || añoActividad === añoFin)
                : (añoActividad === añoInicio);
              
              if (!añoValido) {
                return false; // Excluir actividades de años incorrectos
              }
            }
          }
          // Si no tiene dia_especifico pero tiene la semana correcta, incluirla
          // (ya fue filtrada por semana anteriormente)
          return true;
        });
        
        if (antesFiltradoAño !== actividadesParaAgrupar.length) {
          console.log(`Para ${elements}: ${antesFiltradoAño} actividades antes de filtrar por año, ${actividadesParaAgrupar.length} después (años válidos: ${añoInicio}${cruzaAño ? ' y ' + añoFin : ''})`);
        }
      }
    }
    
    console.log(`Para ${elements}: ${actividadesParaAgrupar.length} actividades listas para agrupar${esActividadEspecial ? ' (actividad especial)' : ''}`);
    
    // Obtener el arreglo de actividades agrupadas por fecha (usando las filtradas por año)
    // IMPORTANTE: Solo agrupar actividades que ya pasaron el filtrado por año
    const activitiesByDate = groupByDate(actividadesParaAgrupar);
    
    // Log para verificar qué fechas se están agrupando
    console.log(`Fechas agrupadas para ${elements}:`, Object.keys(activitiesByDate));

    if (
      elements == ".almuerzo-container" ||
      elements == ".snack-container" ||
      elements == ".lavado-container"
    ) {
      // Para estas actividades especiales, aplicar un filtrado estricto por año
      // Estas actividades se muestran en todos los días, por lo que debemos asegurarnos
      // de que solo se usen actividades del año correcto
      let actividadesFinales = actividadesParaAgrupar; // Usar las actividades ya filtradas antes de agrupar
      
      // Obtener los años de inicio y fin de las fechas de la semana
      let añoInicio = null;
      let añoFin = null;
      let fechaInicio = null;
      let fechaFin = null;
      
      if (fechaInicioSemana && fechaFinSemana) {
        fechaInicio = parseDateDDMMYYYY(fechaInicioSemana);
        fechaFin = parseDateDDMMYYYY(fechaFinSemana);
        
        if (fechaInicio) añoInicio = fechaInicio.getFullYear();
        if (fechaFin) añoFin = fechaFin.getFullYear();
        
        console.log(`Para ${elements}: fechas obtenidas - inicio: ${fechaInicioSemana} (año ${añoInicio}), fin: ${fechaFinSemana} (año ${añoFin})`);
      }
      
      // Si no tenemos fechas del scope, intentar obtenerlas del select como respaldo
      if ((!añoInicio || !añoFin) && (!fechaInicio || !fechaFin)) {
        console.log(`Para ${elements}: no se tienen fechas del scope, intentando obtenerlas del select`);
        const semanaSelect = document.getElementById('semanaSelect');
        if (semanaSelect && semanaSelect.selectedIndex > 0) {
          const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
          const fechaMatches = Array.from(weekText.matchAll(/(\d{2})\/(\d{2})\/(\d{4})/g));
          if (fechaMatches.length >= 2) {
            const inicioMatch = fechaMatches[0];
            const finMatch = fechaMatches[1];
            
            const mesInicio = inicioMatch[1];
            const diaInicio = inicioMatch[2];
            const añoInicioStr = inicioMatch[3];
            const fechaInicioStr = `${diaInicio}/${mesInicio}/${añoInicioStr}`;
            fechaInicio = parseDateDDMMYYYY(fechaInicioStr);
            if (fechaInicio) añoInicio = fechaInicio.getFullYear();
            
            const mesFin = finMatch[1];
            const diaFin = finMatch[2];
            const añoFinStr = finMatch[3];
            const fechaFinStr = `${diaFin}/${mesFin}/${añoFinStr}`;
            fechaFin = parseDateDDMMYYYY(fechaFinStr);
            if (fechaFin) añoFin = fechaFin.getFullYear();
            
            // Actualizar también fechaInicioSemana y fechaFinSemana para que estén disponibles
            fechaInicioSemana = fechaInicioStr;
            fechaFinSemana = fechaFinStr;
            
            console.log(`Para ${elements}: fechas obtenidas del select - inicio: ${fechaInicioStr} (año ${añoInicio}), fin: ${fechaFinStr} (año ${añoFin})`);
          }
        }
      }
      
      // SIEMPRE aplicar filtrado adicional estricto por año para estas actividades especiales
      // IMPORTANTE: Para estas actividades, se filtra por semanas_a_las_que_pertence, NO por dia_especifico
      // Esto garantiza que solo se usen actividades del año correcto
      // Usar las fechas obtenidas (ya sea del scope o del select)
      if (añoInicio && añoFin) {
        const antesFiltrado = actividadesParaAgrupar.length;
        
        // Filtrar por año y semanas_a_las_que_pertence (NO por dia_especifico)
        let actividadesFiltradasPorAño = actividadesParaAgrupar.filter((activity) => {
          // Verificar que tenga semanas_a_las_que_pertence y que incluya la semana actual
          const tieneSemana = activity.acf?.semanas_a_las_que_pertence && 
                             (activity.acf.semanas_a_las_que_pertence.includes(weekStr) || 
                              activity.acf.semanas_a_las_que_pertence.includes(weekNum) ||
                              activity.acf.semanas_a_las_que_pertence.some(s => String(s) === weekStr || Number(s) === weekNum));
          
          if (!tieneSemana) {
            console.log(`[${elements}] Excluyendo actividad ${activity.id}: semana ${week} no está en semanas_a_las_que_pertence:`, activity.acf?.semanas_a_las_que_pertence);
            return false;
          }
          
          // Verificar el año basándose en dia_especifico si está disponible
          // Si no tiene dia_especifico, aceptarla si tiene la semana correcta
          if (activity.acf?.dia_especifico) {
            const fechaActividad = parseDateDDMMYYYY(activity.acf.dia_especifico);
            if (fechaActividad) {
              const añoActividad = fechaActividad.getFullYear();
              
              // Si la semana cruza el año, aceptar actividades de ambos años
              // Si no cruza el año, solo aceptar actividades del año de la semana
              let añoValido = false;
              if (añoInicio === añoFin) {
                // La semana no cruza el año, solo aceptar actividades del mismo año
                añoValido = añoActividad === añoInicio;
              } else {
                // La semana cruza el año, aceptar actividades de ambos años
                añoValido = (añoActividad === añoInicio || añoActividad === añoFin);
              }
              
              if (!añoValido) {
                console.log(`[${elements}] Excluyendo actividad ${activity.id}: año ${añoActividad} no válido (esperado ${añoInicio}${añoInicio !== añoFin ? ' o ' + añoFin : ''}), dia_especifico: ${activity.acf.dia_especifico}`);
                return false;
              }
            }
          }
          
          // Si tiene la semana correcta y el año es válido (o no tiene dia_especifico), incluirla
          return true;
        });
        
        console.log(`Para ${elements}: ${antesFiltrado} actividades antes de filtrar por año, ${actividadesFiltradasPorAño.length} después (años válidos: ${añoInicio}${añoInicio !== añoFin ? ' y ' + añoFin : ''})`);
        
        // Si hay múltiples actividades después del filtrado, priorizar la del año más reciente
        // o la que tenga fecha más cercana al inicio de la semana
        if (actividadesFiltradasPorAño.length > 1) {
          // Ordenar por año (más reciente primero) y luego por fecha (más cercana al inicio primero)
          actividadesFiltradasPorAño.sort((a, b) => {
            const fechaA = parseDateDDMMYYYY(a.acf.dia_especifico);
            const fechaB = parseDateDDMMYYYY(b.acf.dia_especifico);
            const añoA = fechaA.getFullYear();
            const añoB = fechaB.getFullYear();
            
            // Primero por año (más reciente primero)
            if (añoA !== añoB) {
              return añoB - añoA;
            }
            
            // Si mismo año, por fecha (más cercana al inicio primero)
            const diffA = Math.abs(fechaA - fechaInicio);
            const diffB = Math.abs(fechaB - fechaInicio);
            return diffA - diffB;
          });
          
          // Tomar solo la primera (la más reciente y más cercana)
          actividadesFinales = [actividadesFiltradasPorAño[0]];
          console.log(`[${elements}] Múltiples actividades encontradas, seleccionando la más reciente: ID ${actividadesFinales[0].id}, dia_especifico=${actividadesFinales[0].acf.dia_especifico}`);
          
          // Log de las actividades excluidas
          actividadesFiltradasPorAño.slice(1).forEach(act => {
            const fechaAct = parseDateDDMMYYYY(act.acf.dia_especifico);
            console.log(`  [${elements}] Actividad ${act.id} excluida (hay una más reciente): dia_especifico=${act.acf.dia_especifico}, año=${fechaAct?.getFullYear()}`);
          });
        } else {
          actividadesFinales = actividadesFiltradasPorAño;
        }
        
        // Log de las actividades que quedaron
        if (actividadesFinales.length > 0) {
          actividadesFinales.forEach(act => {
            const fechaAct = parseDateDDMMYYYY(act.acf.dia_especifico);
            console.log(`  [${elements}] Actividad ${act.id} incluida: dia_especifico=${act.acf.dia_especifico}, año=${fechaAct?.getFullYear()}`);
          });
        } else if (actividadesParaAgrupar.length > 0) {
          console.warn(`[${elements}] Todas las actividades fueron excluidas por el filtrado por año`);
          actividadesParaAgrupar.forEach(act => {
            const fechaAct = parseDateDDMMYYYY(act.acf?.dia_especifico);
            console.log(`  [${elements}] Actividad ${act.id} excluida: dia_especifico=${act.acf?.dia_especifico}, año=${fechaAct?.getFullYear()}`);
          });
        }
      } else {
        console.warn(`[${elements}] No se pudieron obtener las fechas para filtrar (añoInicio: ${añoInicio}, añoFin: ${añoFin}), usando ${actividadesParaAgrupar.length} actividades filtradas`);
        // Si no tenemos fechas válidas, usar las actividades ya filtradas
        actividadesFinales = actividadesParaAgrupar;
      }
      
      console.log(`[${elements}] Renderizando ${actividadesFinales.length} actividad(es) final(es) en todos los días`);
      
      // Para almuerzo-container, renderizar solo una vez antes de despedida
      if (elements == ".almuerzo-container" && actividadesFinales.length > 0) {
        // Para cada día, asegurar que solo haya 1 almuerzo-container antes de despedida
        document.querySelectorAll(`.curriculumcontent .week .day`).forEach((dayEl) => {
          const todosAlmuerzos = dayEl.querySelectorAll('.almuerzo-container');
          const despedidaContainer = dayEl.querySelector('.despedida-container');
          
          // Contar cuántos almuerzo-container hay antes de despedida
          let almuerzosAntesDespedida = 0;
          if (despedidaContainer) {
            const elementosAntesDespedida = Array.from(despedidaContainer.parentNode.children);
            const indiceDespedida = elementosAntesDespedida.indexOf(despedidaContainer);
            elementosAntesDespedida.slice(0, indiceDespedida).forEach(el => {
              if (el.classList.contains('almuerzo-container')) {
                almuerzosAntesDespedida++;
              }
            });
          }
          
          // Si hay más de 1 almuerzo-container antes de despedida, eliminar los extras
          if (almuerzosAntesDespedida > 1 && despedidaContainer) {
            const elementosAntesDespedida = Array.from(despedidaContainer.parentNode.children);
            const indiceDespedida = elementosAntesDespedida.indexOf(despedidaContainer);
            let encontrados = 0;
            for (let i = indiceDespedida - 1; i >= 0; i--) {
              if (elementosAntesDespedida[i].classList.contains('almuerzo-container')) {
                encontrados++;
                if (encontrados > 1) {
                  elementosAntesDespedida[i].remove();
                }
              }
            }
          }
          
          // Si no hay ningún almuerzo-container antes de despedida, crear uno
          if (almuerzosAntesDespedida === 0 && despedidaContainer && todosAlmuerzos.length > 0) {
            const almuerzoOriginal = todosAlmuerzos[0];
            const nuevoAlmuerzo = document.createElement('div');
            nuevoAlmuerzo.className = almuerzoOriginal.className;
            const spanInicial = almuerzoOriginal.querySelector('span:first-child');
            nuevoAlmuerzo.innerHTML = spanInicial ? spanInicial.outerHTML : '';
            despedidaContainer.parentNode.insertBefore(nuevoAlmuerzo, despedidaContainer);
          }
          
          // Renderizar solo el almuerzo-container que está antes de despedida
          if (despedidaContainer) {
            const elementosAntesDespedida = Array.from(despedidaContainer.parentNode.children);
            const indiceDespedida = elementosAntesDespedida.indexOf(despedidaContainer);
            const almuerzoAntesDespedida = elementosAntesDespedida.find((el, idx) => 
              idx < indiceDespedida && el.classList.contains('almuerzo-container')
            );
            
            if (almuerzoAntesDespedida) {
              updateElementsWithData(
                [almuerzoAntesDespedida],
                actividadesFinales,
                colorfill,
                colorstroke
              );
            }
          }
        });
      } else if (elements == ".snack-container" && actividadesFinales.length > 0) {
        // Para snack-container, renderizar solo una vez por día
        document.querySelectorAll(`.curriculumcontent .week .day`).forEach((dayEl) => {
          const todosSnacks = dayEl.querySelectorAll('.snack-container');
          
          // Si hay más de 1 snack-container, eliminar los extras (mantener solo el primero)
          if (todosSnacks.length > 1) {
            // Mantener solo el primero y eliminar el resto
            for (let i = 1; i < todosSnacks.length; i++) {
              todosSnacks[i].remove();
            }
          }
          
          // Renderizar solo el snack-container que queda (debería ser exactamente 1)
          const snackFinal = dayEl.querySelector('.snack-container');
          if (snackFinal) {
            updateElementsWithData(
              [snackFinal],
              actividadesFinales,
              colorfill,
              colorstroke
            );
          }
        });
      } else {
        // Para otras actividades especiales, renderizar normalmente
        updateElementsWithData(
          document.querySelectorAll(`.curriculumcontent .week .day ${elements}`),
          actividadesFinales,
          colorfill,
          colorstroke
        );
      }
    } else {
      // Determinar si la semana cruza el año
      const semanaCruzaAno = fechaInicioSemana && fechaFinSemana && 
                              parseDateDDMMYYYY(fechaInicioSemana) && 
                              parseDateDDMMYYYY(fechaFinSemana) &&
                              parseDateDDMMYYYY(fechaInicioSemana).getFullYear() !== parseDateDDMMYYYY(fechaFinSemana).getFullYear();
      
      // Obtener firstDayCurrentWeek desde los data-date disponibles o calcularlo
      let firstDayCurrentWeek = null;
      const allDataDates = Array.from(document.querySelectorAll('.curriculumcontent .week .day, .outter.week.flex .day'))
        .map(day => day.getAttribute('data-date'))
        .filter(d => d);
      
      if (allDataDates.length > 0) {
        // Obtener la primera fecha (lunes) de los data-date disponibles
        const primeraFecha = allDataDates[0];
        if (primeraFecha) {
          const parts = primeraFecha.split('/');
          if (parts.length === 3) {
            firstDayCurrentWeek = parseDateDDMMYYYY(primeraFecha);
          }
        }
      }
      
      Object.keys(activitiesByDate).forEach((date, i) => {
        // Normalizar el formato de fecha a DD/MM/YYYY para el selector
        let dateForSelector = date;
        if (date && date.includes('/')) {
          const parts = date.split('/').map(p => p.trim());
          if (parts.length === 3) {
            const day = parts[0].padStart(2, '0');
            const month = parts[1].padStart(2, '0');
            let year = parts[2];
            
            // Si la semana cruza el año, ajustar el año para que coincida con los data-date
            if (semanaCruzaAno) {
              // Obtener todos los data-date disponibles
              const allDataDates = Array.from(document.querySelectorAll('.curriculumcontent .week .day, .outter.week.flex .day'))
                .map(day => day.getAttribute('data-date'))
                .filter(d => d);
              
              // Buscar un data-date que coincida con el día y mes de la actividad
              const matchingDataDate = allDataDates.find(d => {
                if (!d) return false;
                const dParts = d.split('/');
                return dParts.length === 3 && dParts[0] === day && dParts[1] === month;
              });
              
              if (matchingDataDate) {
                const matchingParts = matchingDataDate.split('/');
                const añoDataDate = matchingParts[2];
                const añoActividad = parseInt(year, 10);
                
                // Solo ajustar si el año es diferente
                if (añoActividad !== parseInt(añoDataDate, 10)) {
                  year = añoDataDate; // Usar el año del data-date
                  console.log(`[getWeekData3k] ✓ Ajustando año de actividad: ${date} -> ${day}/${month}/${year} para coincidir con data-date`);
                }
              } else if (firstDayCurrentWeek) {
                // Si no se encuentra coincidencia, calcular el año basándose en firstDayCurrentWeek
                const añoEsperado = firstDayCurrentWeek.getFullYear();
                const mesActividad = parseInt(month, 10);
                
                // Si el mes es enero (1) y estamos en diciembre, el año debería ser el siguiente
                if (mesActividad === 1 && firstDayCurrentWeek.getMonth() === 11) {
                  year = (añoEsperado + 1).toString();
                  console.log(`[getWeekData3k] ✓ Ajustando año de actividad (enero después de diciembre): ${date} -> ${day}/${month}/${year}`);
                } else {
                  year = añoEsperado.toString();
                  console.log(`[getWeekData3k] ✓ Ajustando año de actividad (sin coincidencia exacta): ${date} -> ${day}/${month}/${year} usando año esperado`);
                }
              }
            }
            
            dateForSelector = `${day}/${month}/${year}`; // DD/MM/YYYY
          }
        }
        
        const containers = document.querySelectorAll(
          `.curriculumcontent .week .day[data-date="${dateForSelector}"] ${elements}, .outter.week.flex .day[data-date="${dateForSelector}"] ${elements}`
        );
        
        if (containers.length > 0) {
        updateElementsWithData(
            containers,
          activitiesByDate[date],
          colorfill,
          colorstroke
        );
          console.log(`[getWeekData3k] Actualizados ${containers.length} contenedores para fecha ${dateForSelector} (fecha original: ${date})`);
        } else {
          console.warn(`[getWeekData3k] No se encontraron contenedores para fecha ${dateForSelector} (fecha original: ${date})`);
        }
      });
    }
    return filteredObjects;
  } catch (error) {
    console.error("Error al obtener los objetos:", error);
    throw error;
  }
};
const getInfo3k = async (lang = "es", week = weekNumber) => {
  console.log("Dentro de getInfo3k, semana recibida:", week);
  
  // Contar cuántas consultas se harán a WordPress para el curriculum 3K
  // Cada getWeekData3k puede hacer múltiples consultas si activityType tiene múltiples valores
  const consultasGetWeekData3k = [
    { activityType: "811", container: ".reunionMatutina-container" },
    { activityType: "813", container: ".musicamovimiento-container" },
    { activityType: "92255", container: ".grupopequenomanana-container" },
    { activityType: "814", container: ".storytime-container" },
    { activityType: "92268", container: ".grupopequenotarde-container" },
    { activityType: "816", container: ".despedida-container" },
    { activityType: "812", container: ".almuerzo-container" },
    { activityType: "5721", container: ".snack-container" },
    { activityType: "815", container: ".juegoalairelibre-container" },
    { activityType: "5720", container: ".lavado-container" },
  ];
  
  let totalConsultas = 0;
  consultasGetWeekData3k.forEach(({ activityType }) => {
    // Cada activityType puede tener múltiples valores separados por coma
    const tipos = activityType.split(",");
    totalConsultas += tipos.length;
  });
  
  // También se hace una consulta para canciones y materiales literarios
  totalConsultas += 1;
  
  console.log(`[getInfo3k] 📊 RESUMEN DE CONSULTAS A WORDPRESS PARA CURRICULUM 3K (Semana ${week}):`);
  console.log(`[getInfo3k] - Consultas getWeekData3k: ${totalConsultas - 1} consultas`);
  console.log(`[getInfo3k] - Consulta canciones/materiales literarios: 1 consulta`);
  console.log(`[getInfo3k] - TOTAL: ${totalConsultas} consultas a WordPress`);
  console.log(`[getInfo3k] (Nota: Estas consultas se ejecutan en paralelo usando requestWPParallel)`);
  
  // PRIMERO: Establecer los data-date antes de buscar los contenedores
  let firstDayCurrentWeek = null;
  const semanaSelect = document.getElementById('semanaSelect');
  
  if (semanaSelect && semanaSelect.selectedIndex > 0) {
    const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
    // Extraer la fecha de inicio de la semana (formato: "Semana MM/DD/YYYY al MM/DD/YYYY")
    const fechaMatch = weekText.match(/(\d{2})\/(\d{2})\/(\d{4})/);
    if (fechaMatch && fechaMatch.length >= 4) {
      // Construir la fecha directamente desde el texto del select
      const month = parseInt(fechaMatch[1], 10) - 1; // Mes en JS es 0-indexed
      const day = parseInt(fechaMatch[2], 10);
      const year = parseInt(fechaMatch[3], 10);
      const startDate = new Date(year, month, day);
      firstDayCurrentWeek = getFirstDayOfWeek(startDate);
      console.log('Estableciendo data-date desde texto del select (3K), primer día:', firstDayCurrentWeek, 'año:', year);
    }
  }
  
  // Si no se pudo obtener del select, usar getDateFromWeekNumber como fallback
  if (!firstDayCurrentWeek) {
    let targetYear = null;
    if (semanaSelect && semanaSelect.selectedIndex > 0) {
      const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
      const fechaMatch = weekText.match(/(\d{2})\/(\d{2})\/(\d{4})/);
      if (fechaMatch && fechaMatch.length >= 4) {
        targetYear = parseInt(fechaMatch[3], 10);
  }
    }
    if (!targetYear) {
      targetYear = new Date().getFullYear();
    }
    let currentDate = getDateFromWeekNumber(week, targetYear);
    
    // Caso especial: si es la semana 1 del 2026 que cruza al 2027, 
    // getDateFromWeekNumber retorna el 29 de diciembre directamente
    // No ajustar al lunes anterior en este caso
    if (week === 1 && targetYear === 2026 && currentDate.getDate() === 29 && currentDate.getMonth() === 11 && currentDate.getFullYear() === 2026) {
      firstDayCurrentWeek = currentDate;
    } else {
      firstDayCurrentWeek = getFirstDayOfWeek(currentDate);
    }
    console.log('Estableciendo data-date con getDateFromWeekNumber (3K), primer día:', firstDayCurrentWeek);
  }
  
  // Establecer los data-date en formato DD/MM/YYYY
  if (firstDayCurrentWeek) {
    var daysOfWeek = document.querySelectorAll(".curriculumcontent .week .day, .outter.week.flex .day");
    var dayIncrement = 0;
    for (var i = 0; i < daysOfWeek.length; i++) {
      var day = daysOfWeek[i];
      var date = new Date(firstDayCurrentWeek);
      date.setDate(firstDayCurrentWeek.getDate() + dayIncrement);
      // Formatear fecha en formato DD/MM/YYYY directamente
      var dayStr = date.getDate().toString().padStart(2, "0");
      var monthStr = (date.getMonth() + 1).toString().padStart(2, "0");
      var yearStr = date.getFullYear().toString();
      var formattedDate = `${dayStr}/${monthStr}/${yearStr}`; // DD/MM/YYYY
      day.setAttribute("data-date", formattedDate);
      console.log(`Estableciendo data-date para día ${i + 1} (3K): "${formattedDate}"`);
      dayIncrement++;
    }
  }

  // Obtener las fechas de inicio y fin de la semana para filtrar por dia_especifico
  let fechaInicioSemana = null;
  let fechaFinSemana = null;
  
  if (semanaSelect && semanaSelect.selectedIndex > 0) {
    const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
    // Extraer las fechas de inicio y fin (formato: "Semana MM/DD/YYYY al MM/DD/YYYY")
    const fechaMatches = Array.from(weekText.matchAll(/(\d{2})\/(\d{2})\/(\d{4})/g));
    if (fechaMatches.length >= 2) {
      // Primera fecha es inicio, segunda es fin
      const inicioMatch = fechaMatches[0];
      const finMatch = fechaMatches[1];
      
      // Convertir MM/DD/YYYY a DD/MM/YYYY para comparar con dia_especifico
      const mesInicio = inicioMatch[1];
      const diaInicio = inicioMatch[2];
      const añoInicio = inicioMatch[3];
      fechaInicioSemana = `${diaInicio}/${mesInicio}/${añoInicio}`; // DD/MM/YYYY
      
      const mesFin = finMatch[1];
      const diaFin = finMatch[2];
      const añoFin = finMatch[3];
      fechaFinSemana = `${diaFin}/${mesFin}/${añoFin}`; // DD/MM/YYYY
      
      console.log('Fechas de la semana para filtrar por dia_especifico (3K):', fechaInicioSemana, 'al', fechaFinSemana);
    } else {
      console.warn('No se pudieron obtener las fechas del select en getInfo3k');
    }
  } else {
    console.warn('No se pudo obtener el select de semana en getInfo3k o no tiene selección válida');
  }

  requestWP(
    `cpdfs-bcct?field=curriculum,semana_a_la_que_pertenece&value=${curriculumID},${week}`
  ).then((pdf) => {
    if (pdf.length > 0) {
    }
  });
  // await Promise.all([getWeekSong(), getWeekStories()]);

  // Usar Promise.allSettled en lugar de Promise.all para que una petición fallida no rompa todo
  const results = await Promise.allSettled([
    getWeekData3k(
      "5878",
      "#FFF6F3",
      "#E8501D",
      `.reunionMatutina-container`,
      lang,
      week
    ),
    getWeekData3k(
      "811",
      "#F9FFF4",
      "#73B73B",
      `.musicamovimiento-container`,
      lang,
      week
    ),
    getWeekData3k(
      "92255",
      "#F4FFF8",
      "#0B8E38",
      `.grupopequenomanana-container`,
      lang,
      week
    ),
    getWeekData3k(
      "814",
      "#E3E8FF",
      "#5872FD",
      `.storytime-container`,
      lang,
      week
    ),
    getWeekData3k(
      "92268",
      "#FFF6F3",
      "#FC3286",
      `.grupopequenotarde-container`,
      lang,
      week
    ),
    getWeekData3k(
      "816",
      "#E7E4F6",
      "#544998",
      `.despedida-container`,
      lang,
      week
    ),
    getWeekData3k(
      // "812,5722",
      "812",
      "#EEFFFC",
      "#60CEBD",
      `.almuerzo-container`,
      lang,
      week
    ),
    getWeekData3k("5721", "#F2E7FF", "#8E5AC6", `.snack-container`, lang, week),
    getWeekData3k(
      "815",
      "#f4fff8",
      "#0b8e38",
      `.juegoalairelibre-container`,
      lang,
      week
    ),
    getWeekData3k(
      "5720",
      "#f4fff8",
      "#4FBCC0",
      `.lavado-container`,
      lang,
      week
    ),
  ]);
  
  // Extraer resultados de Promise.allSettled, devolviendo [] si falló alguna petición
  const [
    reunionMatutina,
    musicamovimiento,
    grupopequenomanana,
    storytime,
    grupopequenotarde,
    despedida,
    almuerzo,
    snack,
    juegoalairelibre,
    lavadoDeManos,
  ] = results.map((result) => {
    if (result.status === 'fulfilled') {
      const value = result.value;
      // Asegurar que siempre sea un array
      return Array.isArray(value) ? value : (value ? [value] : []);
    } else {
      console.error(`[getInfo3k] Error en petición:`, result.reason);
      return []; // Devolver array vacío si falló
    }
  });
  
  let a = [
    reunionMatutina,
    musicamovimiento,
    grupopequenomanana,
    storytime,
    grupopequenotarde,
    despedida,
    almuerzo,
    snack,
    juegoalairelibre,
    lavadoDeManos,
  ].flat();
  // Asegurarse de que las fechas estén disponibles antes de consultar WordPress
  // Si no están disponibles, intentar obtenerlas del select nuevamente
  if (!fechaInicioSemana || !fechaFinSemana) {
    const semanaSelect = document.getElementById('semanaSelect');
    if (semanaSelect && semanaSelect.selectedIndex > 0) {
      const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
      const fechaMatches = Array.from(weekText.matchAll(/(\d{2})\/(\d{2})\/(\d{4})/g));
      if (fechaMatches.length >= 2) {
        const inicioMatch = fechaMatches[0];
        const finMatch = fechaMatches[1];
        
        const mesInicio = inicioMatch[1];
        const diaInicio = inicioMatch[2];
        const añoInicio = inicioMatch[3];
        fechaInicioSemana = `${diaInicio}/${mesInicio}/${añoInicio}`; // DD/MM/YYYY
        
        const mesFin = finMatch[1];
        const diaFin = finMatch[2];
        const añoFin = finMatch[3];
        fechaFinSemana = `${diaFin}/${mesFin}/${añoFin}`; // DD/MM/YYYY
        
        console.log('[getInfo3k] Fechas obtenidas del select después de Promise.all:', fechaInicioSemana, 'al', fechaFinSemana);
      }
    }
  }

  // Usar los nuevos parámetros de WordPress para consultas más precisas
  // Nuevos parámetros disponibles: semana, fecha_inicio, fecha_fin, curriculum
  const esSemana1 = week === 1 || week === "1";
  
  // Mapear curriculumID a nombre de curriculum para WordPress
  // 195 = 3k
  const curriculumName = curriculumID == 195 ? "3k" : curriculumID;
  
  // Función para validar que las actividades devueltas corresponden a la semana solicitada
  const validarRespuestaSemana = (actividades, semanaSolicitada, fechaInicio = null, fechaFin = null) => {
    if (!actividades || actividades.length === 0) return false;
    
    const weekStr = String(semanaSolicitada);
    const weekNum = Number(semanaSolicitada);
    
    // Función auxiliar para parsear fechas DD/MM/YYYY
    const parseDateDDMMYYYY = (dateStr) => {
      if (!dateStr) return null;
      const parts = dateStr.split('/');
      if (parts.length === 3) {
        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10) - 1;
        const year = parseInt(parts[2], 10);
        return new Date(year, month, day);
      }
      return null;
    };
    
    // Parsear fechas de rango si están disponibles
    let fechaInicioDate = null;
    let fechaFinDate = null;
    if (fechaInicio && fechaFin) {
      fechaInicioDate = parseDateDDMMYYYY(fechaInicio);
      fechaFinDate = parseDateDDMMYYYY(fechaFin);
    }
    
    // Verificar que al menos algunas actividades son válidas para la semana
    const actividadesValidas = actividades.filter(act => {
      // Verificar si tiene la semana correcta en semanas_a_las_que_pertence
      const semanas = act.acf?.semanas_a_las_que_pertence;
      const tieneSemanaCorrecta = semanas && Array.isArray(semanas) && 
        semanas.some(s => String(s) === weekStr || Number(s) === weekNum);
      
      // Si tiene la semana correcta, es válida
      if (tieneSemanaCorrecta) return true;
      
      // Si tenemos fechas de rango, verificar si dia_especifico está en el rango
      if (fechaInicioDate && fechaFinDate && act.acf?.dia_especifico) {
        const fechaActividad = parseDateDDMMYYYY(act.acf.dia_especifico);
        if (fechaActividad) {
          const dentroDelRango = fechaActividad >= fechaInicioDate && fechaActividad <= fechaFinDate;
          if (dentroDelRango) return true;
        }
      }
      
      return false;
    });
    
    // Si hay actividades, al menos el 50% deben ser válidas
    // Esto permite tolerar algunos errores pero detecta cuando WordPress devuelve datos incorrectos
    const porcentajeCorrecto = actividadesValidas.length / actividades.length;
    return porcentajeCorrecto >= 0.5;
  };
  
  let resp;
  let usandoNuevosParametros = false;
  
  if (esSemana1 && fechaInicioSemana && fechaFinSemana) {
    // Para semana 1 que cruza el año, usar los nuevos parámetros de WordPress
    // Convertir fechas de DD/MM/YYYY a YYYY-MM-DD para WordPress
    const convertirFecha = (fechaDDMMYYYY) => {
      if (!fechaDDMMYYYY) return null;
      const parts = fechaDDMMYYYY.split('/');
      if (parts.length === 3) {
        // parts[0] = día, parts[1] = mes, parts[2] = año
        return `${parts[2]}-${parts[1]}-${parts[0]}`; // YYYY-MM-DD
      }
      return null;
    };
    
    const fechaInicioWP = convertirFecha(fechaInicioSemana);
    const fechaFinWP = convertirFecha(fechaFinSemana);
    
    if (fechaInicioWP && fechaFinWP) {
      // Intentar múltiples variaciones de la consulta hasta encontrar una que funcione
      let respValidada = false;
      
      // Estrategia 1: Solo rango de fechas (sin semana, sin language)
      const endpointEstrategia1 = `planessemanales?fecha_inicio=${fechaInicioWP}&fecha_fin=${fechaFinWP}&curriculum=${curriculumName}`;
      console.log(`[getInfo3k] Estrategia 1 - URL completa: https://twinkle.acuarelacore.com/wp-json/wp/v2/${endpointEstrategia1}`);
      resp = await requestWP(endpointEstrategia1);
      usandoNuevosParametros = true;
      console.log(`[getInfo3k] Estrategia 1 - Parámetros: fecha_inicio=${fechaInicioWP}, fecha_fin=${fechaFinWP}, curriculum=${curriculumName}`);
      
      const respFlat1 = Array.isArray(resp) ? resp.flat() : (resp ? [resp] : []);
      console.log(`[getInfo3k] Estrategia 1 - Respuesta recibida: ${respFlat1.length} actividades`);
      if (respFlat1.length > 0) {
        // Mostrar detalles de las primeras 3 actividades para debug
        respFlat1.slice(0, 3).forEach((act, idx) => {
          console.log(`[getInfo3k]   Actividad ${idx + 1}: ID ${act.id}, semanas:`, act.acf?.semanas_a_las_que_pertence, `dia_especifico: ${act.acf?.dia_especifico}`);
        });
      }
      if (respFlat1.length > 0 && validarRespuestaSemana(respFlat1, week, fechaInicioSemana, fechaFinSemana)) {
        respValidada = true;
        console.log(`[getInfo3k] ✅ Estrategia 1 exitosa: ${respFlat1.length} actividades válidas`);
      } else {
        console.log(`[getInfo3k] ❌ Estrategia 1 falló: ${respFlat1.length} actividades, pero no válidas para semana ${week}`);
        
      // Estrategia 2: Rango de fechas + semana (sin language) - Formato exacto probado en Postman
      const endpointEstrategia2 = `planessemanales?semana=${week}&fecha_inicio=${fechaInicioWP}&fecha_fin=${fechaFinWP}&curriculum=${curriculumName}`;
      console.log(`[getInfo3k] Estrategia 2 - URL completa: https://twinkle.acuarelacore.com/wp-json/wp/v2/${endpointEstrategia2}`);
      resp = await requestWP(endpointEstrategia2);
      console.log(`[getInfo3k] Estrategia 2 - Parámetros: semana=${week}, fecha_inicio=${fechaInicioWP}, fecha_fin=${fechaFinWP}, curriculum=${curriculumName}`);
        
        const respFlat2 = Array.isArray(resp) ? resp.flat() : (resp ? [resp] : []);
        console.log(`[getInfo3k] Estrategia 2 - Respuesta recibida: ${respFlat2.length} actividades`);
        if (respFlat2.length > 0) {
          // Mostrar detalles de las primeras 3 actividades para debug
          respFlat2.slice(0, 3).forEach((act, idx) => {
            console.log(`[getInfo3k]   Actividad ${idx + 1}: ID ${act.id}, semanas:`, act.acf?.semanas_a_las_que_pertence, `dia_especifico: ${act.acf?.dia_especifico}`);
          });
        }
        if (respFlat2.length > 0 && validarRespuestaSemana(respFlat2, week, fechaInicioSemana, fechaFinSemana)) {
          respValidada = true;
          console.log(`[getInfo3k] ✅ Estrategia 2 exitosa: ${respFlat2.length} actividades válidas`);
        } else {
          console.log(`[getInfo3k] ❌ Estrategia 2 falló: ${respFlat2.length} actividades, pero no válidas para semana ${week}`);
          
          // Estrategia 3: Solo rango de fechas + language
          const endpointEstrategia3 = `planessemanales?fecha_inicio=${fechaInicioWP}&fecha_fin=${fechaFinWP}&curriculum=${curriculumName}&language=${lang}`;
          console.log(`[getInfo3k] Estrategia 3 - URL completa: https://twinkle.acuarelacore.com/wp-json/wp/v2/${endpointEstrategia3}`);
          resp = await requestWP(endpointEstrategia3);
          console.log(`[getInfo3k] Estrategia 3 - Parámetros: fecha_inicio=${fechaInicioWP}, fecha_fin=${fechaFinWP}, curriculum=${curriculumName}, language=${lang}`);
          
          const respFlat3 = Array.isArray(resp) ? resp.flat() : (resp ? [resp] : []);
          console.log(`[getInfo3k] Estrategia 3 - Respuesta recibida: ${respFlat3.length} actividades`);
          if (respFlat3.length > 0) {
            // Mostrar detalles de las primeras 3 actividades para debug
            respFlat3.slice(0, 3).forEach((act, idx) => {
              console.log(`[getInfo3k]   Actividad ${idx + 1}: ID ${act.id}, semanas:`, act.acf?.semanas_a_las_que_pertence, `dia_especifico: ${act.acf?.dia_especifico}`);
            });
          }
          if (respFlat3.length > 0 && validarRespuestaSemana(respFlat3, week, fechaInicioSemana, fechaFinSemana)) {
            respValidada = true;
            console.log(`[getInfo3k] ✅ Estrategia 3 exitosa: ${respFlat3.length} actividades válidas`);
          } else {
            console.log(`[getInfo3k] ❌ Estrategia 3 falló: ${respFlat3.length} actividades, pero no válidas para semana ${week}`);
            respValidada = false;
          }
        }
      }
      
      // Si ninguna estrategia funcionó, usar fallback al formato anterior
      // IMPORTANTE: Para semana 1, WordPress no filtra correctamente con los nuevos parámetros,
      // así que intentamos primero con el formato anterior que incluye el filtro de semana,
      // y si eso tampoco funciona, obtenemos todas las actividades y las filtramos en el cliente
      if (!respValidada) {
        console.warn(`[getInfo3k] ⚠️ Ninguna estrategia con nuevos parámetros funcionó. Intentando fallback con formato anterior...`);
        
        // Intentar primero con el formato anterior que incluye el filtro de semana
        resp = await requestWP(
          `planessemanales?field=language,curriculum,semanas_a_las_que_pertence&value=${lang},${curriculumID},${week}&pp=500`
        );
        const respFlatFallback = Array.isArray(resp) ? resp.flat() : (resp ? [resp] : []);
        console.log(`[getInfo3k] Fallback con filtro de semana: ${respFlatFallback.length} actividades recibidas`);
        
        // Validar si el fallback con filtro de semana funcionó
        if (respFlatFallback.length > 0 && validarRespuestaSemana(respFlatFallback, week, fechaInicioSemana, fechaFinSemana)) {
          console.log(`[getInfo3k] ✅ Fallback con filtro de semana exitoso: ${respFlatFallback.length} actividades válidas`);
          respValidada = true;
        } else {
          console.warn(`[getInfo3k] ⚠️ Fallback con filtro de semana no funcionó. Obteniendo TODAS las actividades para filtrar en cliente...`);
          // Si el fallback con filtro de semana tampoco funciona, obtener todas las actividades
          // El filtrado completo se hará en el cliente porque WordPress no filtra correctamente
          resp = await requestWP(
            `planessemanales?field=language,curriculum&value=${lang},${curriculumID}&pp=500`
          );
          console.log(`[getInfo3k] Fallback final: Consultando TODAS las actividades (pp=500) para filtrar completamente en cliente`);
        }
        
        usandoNuevosParametros = false;
      }
      
      console.log(`[getInfo3k] Respuesta final de WordPress:`, resp);
    } else {
      // Fallback: usar formato anterior si no se pueden convertir las fechas
      // Obtener todas las actividades para filtrar completamente en el cliente
      resp = await requestWP(
        `planessemanales?field=language,curriculum&value=${lang},${curriculumID}&pp=500`
      );
      console.log(`[getInfo3k] Consultando WordPress con formato anterior (fechas no disponibles): field=language,curriculum&value=${lang},${curriculumID}, pp=500`);
    }
  } else {
    // Para otras semanas, intentar usar el parámetro semana directamente
    // Intentar múltiples variaciones si la primera no funciona
    let respValidada = false;
    
    // Estrategia 1: semana + curriculum + language
    resp = await requestWP(
      `planessemanales?semana=${week}&curriculum=${curriculumName}&language=${lang}`
    );
    usandoNuevosParametros = true;
    console.log(`[getInfo3k] Estrategia 1 - Semana + curriculum + language: semana=${week}, curriculum=${curriculumName}, language=${lang}`);
    
    const respFlat1 = Array.isArray(resp) ? resp.flat() : (resp ? [resp] : []);
    if (respFlat1.length > 0 && validarRespuestaSemana(respFlat1, week, fechaInicioSemana, fechaFinSemana)) {
      respValidada = true;
      console.log(`[getInfo3k] ✅ Estrategia 1 exitosa: ${respFlat1.length} actividades válidas`);
    } else {
      console.log(`[getInfo3k] ❌ Estrategia 1 falló: ${respFlat1.length} actividades, pero no válidas para semana ${week}`);
      
      // Estrategia 2: semana + curriculum (sin language)
      resp = await requestWP(
        `planessemanales?semana=${week}&curriculum=${curriculumName}`
      );
      console.log(`[getInfo3k] Estrategia 2 - Semana + curriculum: semana=${week}, curriculum=${curriculumName}`);
      
      const respFlat2 = Array.isArray(resp) ? resp.flat() : (resp ? [resp] : []);
      if (respFlat2.length > 0 && validarRespuestaSemana(respFlat2, week, fechaInicioSemana, fechaFinSemana)) {
        respValidada = true;
        console.log(`[getInfo3k] ✅ Estrategia 2 exitosa: ${respFlat2.length} actividades válidas`);
      } else {
        console.log(`[getInfo3k] ❌ Estrategia 2 falló: ${respFlat2.length} actividades, pero no válidas para semana ${week}`);
        respValidada = false;
      }
    }
    
    if (!respValidada) {
      console.warn(`[getInfo3k] ⚠️ Ninguna estrategia con nuevos parámetros funcionó. Usando fallback al formato anterior...`);
      resp = await requestWP(
        `planessemanales?field=language,curriculum,semanas_a_las_que_pertence&value=${lang},${curriculumID},${week}&pp=30`
      );
      usandoNuevosParametros = false;
      console.log(`[getInfo3k] Fallback: Consultando con formato anterior para semana ${week}`);
    }
    
    console.log(`[getInfo3k] Respuesta de WordPress:`, resp);
  }

  // Aplanar el array de arrays
  let flattenedActivities = resp.flat();
  console.log(`[getInfo3k] Actividades aplanadas (3K, después de consulta WordPress):`, flattenedActivities.length);
  console.log(`[getInfo3k] Respuesta RAW completa de WordPress:`, resp);
  
  // Log ANTES del filtrado: ver qué tipos de actividades trajo WordPress
  // Definir tipos de materiales literarios una sola vez (se reutiliza después)
  const tiposMaterialLiterario = ["lectura", "adivinanzas", "travalenguas", "poesias", "cuentos", "copias", "retahílas", "fábulas", "historietas"];
  const cancionesAntesFiltro = flattenedActivities.filter(a => a.acf?.tipo_de_actividad === "canciones");
  const materialesAntesFiltro = flattenedActivities.filter(a => tiposMaterialLiterario.includes(a.acf?.tipo_de_actividad));
  console.log(`[getInfo3k] ANTES DEL FILTRADO - Canciones encontradas: ${cancionesAntesFiltro.length}`);
  console.log(`[getInfo3k] ANTES DEL FILTRADO - Materiales literarios encontrados: ${materialesAntesFiltro.length}`);
  if (cancionesAntesFiltro.length > 0) {
    cancionesAntesFiltro.forEach((c, idx) => {
      console.log(`[getInfo3k]   Canción ${idx + 1} ANTES filtro: ID ${c.id}, Título: "${c.title?.rendered}", semanas:`, c.acf?.semanas_a_las_que_pertence, `dia_especifico: ${c.acf?.dia_especifico}`);
    });
  }
  if (materialesAntesFiltro.length > 0) {
    materialesAntesFiltro.forEach((m, idx) => {
      console.log(`[getInfo3k]   Material ${idx + 1} ANTES filtro: ID ${m.id}, Título: "${m.title?.rendered}", tipo: ${m.acf?.tipo_de_actividad}, semanas:`, m.acf?.semanas_a_las_que_pertence, `dia_especifico: ${m.acf?.dia_especifico}`);
    });
  }
  
  // Guardar la respuesta original antes de cualquier filtrado adicional (por si acaso necesitamos usarla después)
  let respOriginal = esSemana1 ? [...flattenedActivities] : null;
  
  // Con los nuevos parámetros de WordPress, el filtrado debería ser correcto en el servidor
  // Sin embargo, mantenemos un filtrado mínimo como respaldo para asegurar que solo se incluyan actividades correctas
  // Esto es especialmente importante para canciones y materiales literarios que pueden no tener dia_especifico
  if (esSemana1 && fechaInicioSemana && fechaFinSemana) {
    console.log(`[getInfo3k] Verificando respuesta de WordPress para semana 1. Fechas: ${fechaInicioSemana} al ${fechaFinSemana}. Actividades recibidas: ${flattenedActivities.length}`);
    
    // Verificar que las actividades recibidas tienen la semana correcta o están en el rango de fechas
    // WordPress debería haber filtrado correctamente, pero verificamos como respaldo
    const parseDateDDMMYYYY = (dateStr) => {
      if (!dateStr) return null;
      const parts = dateStr.split('/');
      if (parts.length === 3) {
        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10) - 1;
        const year = parseInt(parts[2], 10);
        return new Date(year, month, day);
      }
      return null;
    };
    
    const fechaInicio = parseDateDDMMYYYY(fechaInicioSemana);
    const fechaFin = parseDateDDMMYYYY(fechaFinSemana);
    
    if (fechaInicio && fechaFin) {
      // Filtrado robusto: como WordPress no filtra correctamente, hacemos el filtrado completo en el cliente
      // Verificar que las actividades tienen la semana correcta O están dentro del rango de fechas
      const weekStr = String(week);
      const weekNum = Number(week);
      
      // Identificar tipos de actividades especiales (canciones y materiales literarios)
      const tiposEspeciales = ["canciones", "lectura", "adivinanzas", "travalenguas", "poesias", "cuentos", "copias", "retahílas", "fábulas", "historietas"];
      
      const actividadesValidadas = flattenedActivities.filter((activity) => {
        // Verificar si tiene la semana correcta en semanas_a_las_que_pertence
        const semanas = activity.acf?.semanas_a_las_que_pertence;
        const tieneSemana = semanas && Array.isArray(semanas) && 
                           (semanas.includes(weekStr) || 
                            semanas.includes(weekNum) ||
                            semanas.some(s => String(s) === weekStr || Number(s) === weekNum));
        
        const esTipoEspecial = tiposEspeciales.includes(activity.acf?.tipo_de_actividad);
        
        // Para canciones y materiales literarios, si tienen la semana correcta, incluirlas SIEMPRE
        // (incluso si no tienen dia_especifico)
        if (esTipoEspecial && tieneSemana) {
          console.log(`[getInfo3k] ✅ Incluyendo ${activity.acf?.tipo_de_actividad} "${activity.title?.rendered}" - tiene semana ${week}`);
          return true;
        }
        
        // Si tiene dia_especifico, verificar que esté en el rango
        if (activity.acf?.dia_especifico) {
          const fechaActividad = parseDateDDMMYYYY(activity.acf.dia_especifico);
          if (fechaActividad) {
            const dentroDelRango = fechaActividad >= fechaInicio && fechaActividad <= fechaFin;
            // Incluir si está en el rango O tiene la semana correcta
            if (dentroDelRango || tieneSemana) {
              if (esTipoEspecial) {
                console.log(`[getInfo3k] ✅ Incluyendo ${activity.acf?.tipo_de_actividad} "${activity.title?.rendered}" - ${dentroDelRango ? 'dentro del rango' : 'tiene semana'}`);
              }
              return true;
            }
          }
        }
        
        // Si no tiene dia_especifico, incluir solo si tiene la semana correcta
        if (tieneSemana) {
          if (esTipoEspecial) {
            console.log(`[getInfo3k] ✅ Incluyendo ${activity.acf?.tipo_de_actividad} "${activity.title?.rendered}" - tiene semana ${week} (sin dia_especifico)`);
          }
          return true;
        }
        
        // Excluir si no cumple ninguna condición
        if (esTipoEspecial) {
          console.log(`[getInfo3k] ❌ Excluyendo ${activity.acf?.tipo_de_actividad} "${activity.title?.rendered}" - semanas:`, semanas, `dia_especifico: ${activity.acf?.dia_especifico}`);
        }
        return false;
      });
      
      console.log(`[getInfo3k] Filtrado de respaldo para semana ${week}: ${actividadesValidadas.length} actividades válidas de ${flattenedActivities.length} recibidas`);
      
      // Log detallado de canciones y materiales literarios después del filtrado
      const cancionesValidadas = actividadesValidadas.filter(a => a.acf?.tipo_de_actividad === "canciones");
      const materialesValidadas = actividadesValidadas.filter(a => tiposEspeciales.slice(1).includes(a.acf?.tipo_de_actividad));
      console.log(`[getInfo3k] Después del filtrado de respaldo - Canciones: ${cancionesValidadas.length}, Materiales literarios: ${materialesValidadas.length}`);
      
      flattenedActivities = actividadesValidadas;
    }
  }
  
  // Log: Respuesta cruda de WordPress para canciones y materiales literarios (DESPUÉS del filtrado inmediato para semana 1)
  // Para semana 1, este log mostrará solo las actividades que pasaron el filtrado inmediato (solo semana 1)
  // Para otras semanas, mostrará todas las actividades recibidas de WordPress
  console.log(`[getInfo3k] RESPUESTA CRUDA DE WORDPRESS (canciones y materiales literarios)${esSemana1 ? ' - DESPUÉS de filtrado inmediato' : ''}:`, flattenedActivities);
  
  // Log detallado: Mostrar todas las canciones y materiales literarios en la respuesta (después del filtrado inmediato para semana 1)
  // tiposMaterialLiterario ya está definido arriba
  
  const cancionesEnRespuesta = flattenedActivities.filter(a => a.acf?.tipo_de_actividad === "canciones");
  const materialesEnRespuesta = flattenedActivities.filter(a => tiposMaterialLiterario.includes(a.acf?.tipo_de_actividad));
  
  console.log(`[getInfo3k] CANCIONES EN RESPUESTA CRUDA (después de filtrado inmediato):`, cancionesEnRespuesta);
  console.log(`[getInfo3k] Total canciones en respuesta cruda:`, cancionesEnRespuesta.length);
  cancionesEnRespuesta.forEach((cancion, idx) => {
    console.log(`[getInfo3k] Canción ${idx + 1}: ID ${cancion.id}, Título: "${cancion.title?.rendered}", dia_especifico: ${cancion.acf?.dia_especifico}, semanas_a_las_que_pertence:`, cancion.acf?.semanas_a_las_que_pertence);
  });
  
  console.log(`[getInfo3k] MATERIALES LITERARIOS EN RESPUESTA CRUDA (después de filtrado inmediato):`, materialesEnRespuesta);
  console.log(`[getInfo3k] Total materiales literarios en respuesta cruda:`, materialesEnRespuesta.length);
  materialesEnRespuesta.forEach((material, idx) => {
    console.log(`[getInfo3k] Material ${idx + 1}: ID ${material.id}, Título: "${material.title?.rendered}", tipo: ${material.acf?.tipo_de_actividad}, dia_especifico: ${material.acf?.dia_especifico}, semanas_a_las_que_pertence:`, material.acf?.semanas_a_las_que_pertence);
  });
  
  // Normalizar week a string y number para comparación consistente
  const weekStr = String(week);
  const weekNum = Number(week);
  
  // Filtrar por dia_especifico si tenemos las fechas de la semana (EXACTAMENTE igual que en getWeekDataNew)
  if (fechaInicioSemana && fechaFinSemana) {
    // Convertir fechas DD/MM/YYYY a objetos Date para comparar (igual que en getWeekDataNew)
    const parseDateDDMMYYYY = (dateStr) => {
      if (!dateStr) return null;
      const parts = dateStr.split('/');
      if (parts.length === 3) {
        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10) - 1; // Los meses en Date son 0-indexed
        const year = parseInt(parts[2], 10);
        return new Date(year, month, day);
      }
      return null;
    };
    
    const fechaInicio = parseDateDDMMYYYY(fechaInicioSemana);
    const fechaFin = parseDateDDMMYYYY(fechaFinSemana);
    
    console.log(`[getInfo3k] Fechas parseadas - Inicio: ${fechaInicioSemana} (${fechaInicio}), Fin: ${fechaFinSemana} (${fechaFin})`);
    
    if (fechaInicio && fechaFin) {
      const añoInicio = fechaInicio.getFullYear();
      const añoFin = fechaFin.getFullYear();
      const cruzaAño = añoInicio !== añoFin;
      
      const weekStr = String(week);
      const weekNum = Number(week);
      
      const actividadesFiltradasPorFecha = flattenedActivities.filter((activity) => {
        // Para semana 1, filtrar principalmente por fecha (dia_especifico) porque WordPress no devuelve actividades correctamente
        if (esSemana1) {
          // Verificar si tiene la semana correcta en semanas_a_las_que_pertence
          const tieneSemana = activity.acf?.semanas_a_las_que_pertence && 
                             (activity.acf.semanas_a_las_que_pertence.includes(weekStr) || 
                              activity.acf.semanas_a_las_que_pertence.includes(weekNum) ||
                              activity.acf.semanas_a_las_que_pertence.some(s => String(s) === weekStr || Number(s) === weekNum));
          
          // Identificar tipos de actividades especiales (canciones y materiales literarios)
          const tiposEspeciales = ["canciones", "lectura", "adivinanzas", "travalenguas", "poesias", "cuentos", "copias", "retahílas", "fábulas", "historietas"];
          const esTipoEspecial = tiposEspeciales.includes(activity.acf?.tipo_de_actividad);
          
          // Para canciones y materiales literarios, si tienen la semana correcta, incluirlas aunque no tengan dia_especifico
          if (esTipoEspecial && tieneSemana) {
            return true;
          }
          
          // Para otras actividades, si no tiene dia_especifico, excluirla (para semana 1 necesitamos fecha)
          if (!activity.acf?.dia_especifico) {
            return false;
          }
          
          const fechaActividad = parseDateDDMMYYYY(activity.acf.dia_especifico);
          if (!fechaActividad) {
            // Si no se pudo parsear pero tiene la semana correcta, incluirla
            if (tieneSemana) {
              return true;
            }
            return false;
          }
          
          const añoActividad = fechaActividad.getFullYear();
          
          // Para semanas que cruzan año, aceptar actividades de ambos años
          const añoValido = cruzaAño 
            ? (añoActividad === añoInicio || añoActividad === añoFin)
            : (añoActividad === añoInicio);
          
          if (!añoValido) {
            return false;
          }
          
          // Verificar que la fecha de la actividad esté dentro del rango de la semana
          const dentroDelRango = fechaActividad >= fechaInicio && fechaActividad <= fechaFin;
          
          // Para semana 1, incluir si está dentro del rango de fechas O si tiene la semana correcta
          return dentroDelRango || tieneSemana;
        }
        
        // Verificar si tiene la semana correcta en semanas_a_las_que_pertence
        const tieneSemana = activity.acf?.semanas_a_las_que_pertence && 
                           (activity.acf.semanas_a_las_que_pertence.includes(weekStr) || 
                            activity.acf.semanas_a_las_que_pertence.includes(weekNum) ||
                            activity.acf.semanas_a_las_que_pertence.some(s => String(s) === weekStr || Number(s) === weekNum));
        
        
        // Para otras actividades, si no tienen dia_especifico pero tienen la semana correcta, incluirlas
        if (!activity.acf?.dia_especifico) {
          if (tieneSemana) {
            console.log(`[getInfo3k] Incluyendo actividad sin dia_especifico (${activity.acf?.tipo_de_actividad}): tiene semana ${week}`);
            return true;
          }
          return false;
        }
        
        const fechaActividad = parseDateDDMMYYYY(activity.acf.dia_especifico);
        if (!fechaActividad) {
          // Si no se pudo parsear pero tiene la semana correcta, incluirla
          if (tieneSemana) {
            return true;
          }
          return false;
        }
        
        const añoActividad = fechaActividad.getFullYear();
        
        // Para semanas que cruzan año, aceptar actividades de ambos años
        const añoValido = cruzaAño 
          ? (añoActividad === añoInicio || añoActividad === añoFin)
          : (añoActividad === añoInicio);
        
        if (!añoValido) {
          return false;
        }
        
        // Verificar que la fecha de la actividad esté dentro del rango de la semana
        const dentroDelRango = fechaActividad >= fechaInicio && fechaActividad <= fechaFin;
        
        // Identificar tipos de actividades que deben incluirse si tienen la semana correcta, incluso si dia_especifico está fuera del rango
        const tiposEspeciales = ["canciones", "lectura", "adivinanzas", "travalenguas", "poesias", "cuentos", "copias", "retahílas", "fábulas", "historietas"];
        const esTipoEspecial = tiposEspeciales.includes(activity.acf?.tipo_de_actividad);
        
        // Log para debugging de canciones
        if (activity.acf?.tipo_de_actividad === "canciones") {
          console.log(`[getInfo3k] Canción "${activity.title?.rendered}" - dia_especifico: ${activity.acf.dia_especifico}, fecha parseada: ${fechaActividad}, dentro del rango: ${dentroDelRango}, año válido: ${añoValido}, tiene semana: ${tieneSemana}`);
        }
        
        // Para canciones y materiales literarios, si tienen la semana correcta, incluirlas incluso si dia_especifico está fuera del rango
        if (esTipoEspecial && tieneSemana) {
          return true;
        }
        
        // Para otras actividades, incluir solo si está dentro del rango
        return dentroDelRango;
      });
      
      console.log(`Actividades filtradas por dia_especifico (3K, ${fechaInicioSemana} al ${fechaFinSemana}):`, actividadesFiltradasPorFecha.length, 'de', flattenedActivities.length);
      flattenedActivities = actividadesFiltradasPorFecha;
    } else {
      console.warn(`[getInfo3k] No se pudieron parsear las fechas: fechaInicio=${fechaInicio}, fechaFin=${fechaFin}`);
    }
  } else {
    console.warn(`[getInfo3k] No se tienen fechas para filtrar (fechaInicioSemana: ${fechaInicioSemana}, fechaFinSemana: ${fechaFinSemana})`);
  }
  
  let material = [
    "lectura",
    "adivinanzas",
    "travalenguas",
    "poesias",
    "cuentos",
    "copias",
    "retahílas",
    "fábulas",
    "historietas",
  ];

  let newArray = flattenedActivities.filter(
    (activity) => !a.some((item) => item.id === activity.id)
  );
  
  console.log(`Actividades después de filtrar duplicados (3K):`, newArray.length);

  let literarios, song;

  // Limpiar canciones y materiales literarios ANTES de filtrar y actualizar (igual que en getWeekDataNew)
  // Esto asegura que no se muestren datos de semanas anteriores
  const songInitialHTML = '<span data-interfazid="7"><svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 0.5C5.37258 0.5 0 5.87258 0 12.5C0 19.1274 5.37258 24.5 12 24.5C18.6274 24.5 24 19.1274 24 12.5C24 5.87258 18.6274 0.5 12 0.5ZM8.77007 15.5547V15.2475C8.77007 14.55 8.77423 13.8525 8.7784 13.155C8.78673 11.76 8.79507 10.365 8.77007 8.97004C8.75507 8.22004 9.34007 7.31254 10.1201 7.06504C10.4805 6.95201 10.8409 6.83856 11.2015 6.72508C12.9941 6.16085 14.7893 5.5958 16.6001 5.07754C17.4326 4.83754 18.0476 5.14504 18.0476 6.13504C18.0559 7.86416 18.0527 9.59097 18.0494 11.318C18.0468 12.6998 18.0442 14.0817 18.0476 15.465C18.0476 16.4175 17.5676 17.07 16.8251 17.5725C15.9851 18.1425 15.0476 18.3 14.0651 18.0675C12.4976 17.6925 12.0101 16.1175 13.0976 14.91C14.0576 13.845 15.2726 13.5375 16.6526 13.86C16.7351 13.8825 16.8176 13.905 16.9001 13.92V9.25504C16.9001 8.92504 16.6976 8.81254 16.3076 8.91754C15.8051 9.05254 15.3101 9.20254 14.8151 9.36004C13.4351 9.79504 12.0551 10.23 10.6826 10.6725C10.1051 10.86 9.94007 11.0925 9.93257 11.685C9.92507 13.4775 9.91757 15.27 9.90257 17.0625C9.88757 18.5925 8.73257 19.7925 7.20257 19.86C6.76757 19.8825 6.30257 19.8825 5.89007 19.7775C4.64507 19.4625 4.13507 18.2325 4.78007 17.1225C5.38007 16.0875 6.33257 15.5775 7.50257 15.4875C7.77159 15.468 8.04062 15.4931 8.32004 15.5191C8.46668 15.5328 8.61619 15.5468 8.77007 15.5547Z" fill="white" /></svg> Canción semanal</span>';
  const storieInitialHTML = '<span data-interfazid="8"><img src="img/literario.svg" alt="Material Literario" />Material literario</span>';
  
  document.querySelectorAll(".curriculumcontent .week .day .song, .outter.week.flex .day .song").forEach((songEl) => {
    // Limpiar solo los data-attributes, pero restaurar el contenido HTML inicial
    Array.from(songEl.attributes).forEach(attr => {
      if (attr.name.startsWith('data-')) {
        songEl.removeAttribute(attr.name);
      }
    });
    songEl.innerHTML = songInitialHTML;
    songEl.style.display = "none";
    songEl.style.opacity = "0";
  });
  
  document.querySelectorAll(".curriculumcontent .week .day .storie, .outter.week.flex .day .storie").forEach((storieEl) => {
    // Limpiar solo los data-attributes, pero restaurar el contenido HTML inicial
    Array.from(storieEl.attributes).forEach(attr => {
      if (attr.name.startsWith('data-')) {
        storieEl.removeAttribute(attr.name);
      }
    });
    // Verificar si tiene data-interfazid para usar la versión correcta del HTML
    const hasInterfazId = storieEl.querySelector('[data-interfazid="8"]');
    if (hasInterfazId) {
      storieEl.innerHTML = storieInitialHTML;
    } else {
      storieEl.innerHTML = '<span><img src="img/momentos/material_literario.svg" alt="Material literario" /> Material literario</span>';
    }
    storieEl.style.display = "none";
    storieEl.style.opacity = "0";
  });

  // Filtrar literarios donde acf.tipo_de_actividad está en material y acf.semanas_a_las_que_pertence incluye week
  literarios = flattenedActivities.filter(
    (data) => {
      const tieneTipoCorrecto = material.includes(data.acf.tipo_de_actividad);
      const tieneSemana = data.acf.semanas_a_las_que_pertence && 
                         (data.acf.semanas_a_las_que_pertence.includes(weekStr) || 
                          data.acf.semanas_a_las_que_pertence.includes(weekNum) ||
                          data.acf.semanas_a_las_que_pertence.some(s => String(s) === weekStr || Number(s) === weekNum));
      return tieneTipoCorrecto && tieneSemana;
    }
  );
  
  // Para semana 1, también buscar materiales literarios en la respuesta original de WordPress
  // Esto asegura que se incluyan incluso si fueron filtrados por fecha anteriormente
  if (esSemana1 && respOriginal) {
    const literariosOriginales = respOriginal.filter(
      (data) => {
        const tieneTipoCorrecto = material.includes(data.acf?.tipo_de_actividad);
        const tieneSemana = data.acf?.semanas_a_las_que_pertence && 
                           (data.acf.semanas_a_las_que_pertence.includes(weekStr) || 
                            data.acf.semanas_a_las_que_pertence.includes(weekNum) ||
                            data.acf.semanas_a_las_que_pertence.some(s => String(s) === weekStr || Number(s) === weekNum));
        return tieneTipoCorrecto && tieneSemana;
      }
    );
    
    // Agregar materiales literarios de la respuesta original que no estén ya en literarios
    literariosOriginales.forEach(lit => {
      if (!literarios.some(l => l.id === lit.id)) {
        literarios.push(lit);
        console.log(`[getInfo3k] Agregando material literario de respuesta original (semana 1):`, lit.title?.rendered, `ID: ${lit.id}`);
      }
    });
  }
  
  // Log: Materiales literarios filtrados
  console.log(`[getInfo3k] MATERIALES LITERARIOS FILTRADOS:`, literarios);

  // Filtrar canciones donde acf.tipo_de_actividad es "canciones" y acf.semanas_a_las_que_pertence incluye week
  song = flattenedActivities.filter(
    (data) => {
      const tieneTipoCorrecto = data.acf.tipo_de_actividad == "canciones";
      const tieneSemana = data.acf.semanas_a_las_que_pertence && 
                         (data.acf.semanas_a_las_que_pertence.includes(weekStr) || 
                          data.acf.semanas_a_las_que_pertence.includes(weekNum) ||
                          data.acf.semanas_a_las_que_pertence.some(s => String(s) === weekStr || Number(s) === weekNum));
      return tieneTipoCorrecto && tieneSemana;
    }
  );
  
  // Para semana 1, también buscar canciones en la respuesta original de WordPress
  // Esto asegura que se incluyan incluso si fueron filtradas por fecha anteriormente
  if (esSemana1 && respOriginal) {
    const cancionesOriginales = respOriginal.filter(
      (data) => {
        const tieneTipoCorrecto = data.acf?.tipo_de_actividad == "canciones";
        const tieneSemana = data.acf?.semanas_a_las_que_pertence && 
                           (data.acf.semanas_a_las_que_pertence.includes(weekStr) || 
                            data.acf.semanas_a_las_que_pertence.includes(weekNum) ||
                            data.acf.semanas_a_las_que_pertence.some(s => String(s) === weekStr || Number(s) === weekNum));
        return tieneTipoCorrecto && tieneSemana;
      }
    );
    
    // Agregar canciones de la respuesta original que no estén ya en song
    cancionesOriginales.forEach(cancion => {
      if (!song.some(s => s.id === cancion.id)) {
        song.push(cancion);
        console.log(`[getInfo3k] Agregando canción de respuesta original (semana 1):`, cancion.title?.rendered, `ID: ${cancion.id}`);
      }
    });
  }
  
  // Log: Canciones filtradas
  console.log(`[getInfo3k] CANCIONES FILTRADAS:`, song);

  // Actualizar materiales literarios: cada día debe tener su propio material si existe
  if (literarios && literarios.length > 0) {
    console.log(`Encontrados ${literarios.length} materiales literarios para semana ${week} (3K)`);
    document.querySelectorAll(".curriculumcontent .week .day, .outter.week.flex .day").forEach((dayElement) => {
      const dayDate = dayElement.getAttribute("data-date");
      const storieElement = dayElement.querySelector(".storie");
      
      if (!storieElement) return;
      
      // Asegurar que el contenido HTML inicial esté presente antes de actualizar
      if (!storieElement.innerHTML || storieElement.innerHTML.trim() === "") {
        // Verificar si tiene data-interfazid para usar la versión correcta del HTML
        const hasInterfazId = storieElement.querySelector('[data-interfazid="8"]');
        if (hasInterfazId) {
          storieElement.innerHTML = storieInitialHTML;
        } else {
          storieElement.innerHTML = '<span><img src="img/momentos/material_literario.svg" alt="Material literario" /> Material literario</span>';
        }
      }
      
      if (dayDate) {
        // Buscar material literario para este día específico
        const literarioForDay = literarios.find(l => {
          if (!l.acf.dia_especifico) return false;
          // Comparar fechas en formato DD/MM/YYYY
          return l.acf.dia_especifico === dayDate;
        });
        
        if (literarioForDay) {
          // Actualizar solo este elemento con el material del día
          updateElementsWithData(
            [storieElement],
            [literarioForDay],
            "#e3e8ff",
            "#5872fd"
          );
          storieElement.style.display = "flex";
          storieElement.style.opacity = "1";
          console.log(`Material literario asignado para día ${dayDate} (3K):`, literarioForDay.title?.rendered);
        } else {
          // Si no hay material específico para este día, buscar uno sin día específico o usar el primero disponible
          const literarioSinFecha = literarios.find(l => !l.acf.dia_especifico);
          if (literarioSinFecha) {
            updateElementsWithData(
              [storieElement],
              [literarioSinFecha],
              "#e3e8ff",
              "#5872fd"
            );
            storieElement.style.display = "flex";
            storieElement.style.opacity = "1";
          } else if (literarios.length === 1) {
            // Si solo hay un material (con o sin día específico), usar ese material para todos los días
            updateElementsWithData(
              [storieElement],
              literarios,
              "#e3e8ff",
              "#5872fd"
            );
            storieElement.style.display = "flex";
            storieElement.style.opacity = "1";
            console.log(`Material literario general asignado para día ${dayDate} (3K):`, literarios[0].title?.rendered);
          } else if (literarios.length > 0) {
            // Si todos tienen fecha pero ninguna coincide, usar el primero disponible
            updateElementsWithData(
              [storieElement],
              [literarios[0]],
              "#e3e8ff",
              "#5872fd"
            );
            storieElement.style.display = "flex";
            storieElement.style.opacity = "1";
          }
        }
      } else {
        // Si no hay data-date, usar el primer material disponible
        if (literarios.length > 0) {
          updateElementsWithData(
            [storieElement],
            [literarios[0]],
            "#e3e8ff",
            "#5872fd"
          );
          storieElement.style.display = "flex";
          storieElement.style.opacity = "1";
        }
      }
    });
  } else {
    console.log(`No se encontraron materiales literarios para semana ${week} (3K)`);
  }

  // Actualizar canciones: cada día debe tener su propia canción si existe (igual que en getWeekDataNew)
  if (song && song.length > 0) {
    console.log(`Encontradas ${song.length} canciones para semana ${week} (3K)`);
    // Si hay canciones, actualizar cada día con la canción correspondiente
    document.querySelectorAll(".curriculumcontent .week .day, .outter.week.flex .day").forEach((dayElement) => {
      const dayDate = dayElement.getAttribute("data-date");
      const songElement = dayElement.querySelector(".song");
      
      if (!songElement) return;
      
      // Asegurar que el contenido HTML inicial esté presente antes de actualizar
      if (!songElement.innerHTML || songElement.innerHTML.trim() === "") {
        songElement.innerHTML = songInitialHTML;
      }
      
      if (dayDate) {
        // Buscar canción para este día específico
        const songForDay = song.find(s => {
          if (!s.acf.dia_especifico) return false;
          // Comparar fechas en formato DD/MM/YYYY
          return s.acf.dia_especifico === dayDate;
        });
        
        if (songForDay) {
          // Actualizar solo este elemento con la canción del día
          updateElementsWithData(
            [songElement],
            [songForDay],
            "#FFF",
            "#53bdc2"
          );
          songElement.style.display = "flex";
          songElement.style.opacity = "1";
          console.log(`Canción asignada para día ${dayDate} (3K):`, songForDay.title?.rendered);
        } else {
          // Si no hay canción específica para este día, buscar una sin día específico o usar la primera disponible
          const songSinFecha = song.find(s => !s.acf.dia_especifico);
          if (songSinFecha) {
            updateElementsWithData(
              [songElement],
              [songSinFecha],
              "#FFF",
              "#53bdc2"
            );
            songElement.style.display = "flex";
            songElement.style.opacity = "1";
            console.log(`Canción sin fecha específica asignada para día ${dayDate} (3K):`, songSinFecha.title?.rendered);
          } else if (song.length === 1) {
            // Si solo hay una canción (con o sin día específico), usar esa canción para todos los días
            updateElementsWithData(
              [songElement],
              song,
              "#FFF",
              "#53bdc2"
            );
            songElement.style.display = "flex";
            songElement.style.opacity = "1";
            console.log(`Canción general asignada para día ${dayDate} (3K):`, song[0].title?.rendered);
          } else if (song.length > 0) {
            // Si todas tienen fecha pero ninguna coincide, usar la primera disponible para todos los días
            updateElementsWithData(
              [songElement],
              [song[0]],
              "#FFF",
              "#53bdc2"
            );
            songElement.style.display = "flex";
            songElement.style.opacity = "1";
            console.log(`Canción general (primera disponible) asignada para día ${dayDate} (3K):`, song[0].title?.rendered);
          }
        }
      } else {
        // Si no hay data-date, usar la primera canción disponible
        if (song.length > 0) {
          updateElementsWithData(
            [songElement],
            [song[0]],
            "#FFF",
            "#53bdc2"
          );
          songElement.style.display = "flex";
          songElement.style.opacity = "1";
        }
      }
    });
  } else {
    console.log(`No se encontraron canciones para semana ${week} (3K)`);
  }
  
  // Traducir inmediatamente después de agregar al DOM (igual que en getWeekDataNew)
  translateInDOM(lang);
  
  addFunctionActivities();
};

const addFunctionActivities = () => {
  // Seleccionar todos los elementos con la clase "activity"
  const elements = document.querySelectorAll(".activity");

  // Inicializar una variable para almacenar la altura máxima
  let maxHeight = 0;
  // Iterar sobre los elementos para encontrar la altura máxima
  elements.forEach((element) => {
    const height = element.getBoundingClientRect().height;
    maxHeight = Math.max(maxHeight, height);
  });

  // Establecer la altura máxima en todos los elementos
  elements.forEach((element) => {
    if (
      !element.classList.contains("song") &&
      !element.classList.contains("storie")
    ) {
      element.style.height = maxHeight + "px";
    }
  });

  var favDialog = document.getElementById("favDialog");
  document
    .querySelector("#cancel")
    .addEventListener("click", () => favDialog.close());

  let btnCompartir = document.getElementById("compartir");
  let shareOptions = document.getElementById("share_actividad");
  let whatsapp = document.getElementById("share-whatsapp");
  let link = document.getElementById("share-copy");
  let listenersAdded = false;
  let publicUrl;
  function toggleShareOptions(event) {
    event.preventDefault();
    if (
      shareOptions.style.display === "none" ||
      shareOptions.style.display === ""
    ) {
      shareOptions.style.display = "block";
    } else {
      shareOptions.style.display = "none";
    }
    // btnCompartir.removeEventListener('click', toggleShareOptions);
  }

  function shareOnWhatsapp() {
    const shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(
      publicUrl
    )}`;
    window.open(shareUrl, "_blank");
  }

  function copyLink() {
    navigator.clipboard
      .writeText(publicUrl)
      .then(() => {
        alert("Enlace copiado al portapapeles");
      })
      .catch((err) => {
        console.error("Error al copiar el enlace: ", err);
      });
  }

  function addEventListeners(theid) {
    publicUrl = `/miembros/shareActividad/${theid}`;
    if (!listenersAdded) {
      btnCompartir.addEventListener("click", toggleShareOptions);
      whatsapp.addEventListener("click", () => shareOnWhatsapp(theid));
      link.addEventListener("click", () => copyLink(theid));

      listenersAdded = true; // Indica que los listeners han sido agregados
    }
  }

  document.querySelectorAll(".activity").forEach(async (activity) => {
    let btnmulti = document.querySelector("dialog .dialog-body .btn.adjuntos");
    let btnmultiDownload = document.querySelector(
      "dialog .dialog-body .btn.dowload-adjuntos"
    );
    let printPlantilla = document.querySelector(
      "dialog .dialog-body .printPlantilla"
    );
    let btnadjuntos = document.querySelector(
      "dialog .dialog-body .btn.multimedia"
    );

    let dominiosTitles = [
      "Ecología",
      "Inteligencia emocional",
      "Tecnología",
      "Innovación",
      "Resolución de problemas",
      "Emprendimiento",
      "Trabajo en equipo",
      "Área sensorial",
      "Pensamiento creativo",
    ];
    let dominiosColor = [
      "#84C174",
      "#624595",
      "#4372B8",
      "#EE75A8",
      "#F5A535",
      "#A6529A",
      "#4FBCC0",
      "#9872B0",
      "#488AC9",
    ];
    let elofColor = ["#3C5DA8", "#E45990", "#56A5A2", "#8FA33A", "#8F2371"];
    // console.log("activity2", activity);
    let {
      colorfill,
      colorstroke,
      curriculum,
      description,
      dominios_uc,
      edad,
      elof,
      enfoque,
      foto,
      instrucciones,
      link_de_cancion,
      link_de_cuento,
      materiales,
      materiales_reciclables,
      momento,
      multimedia,
      multimedia_en,
      objetivos,
      tema,
      theid,
      tiempo,
      title,
      tips,
    } = activity.dataset;
    let filteredArrayDominio;
    let filteredArrayElof;
    let filteredArrayEnfoque;
    let edadTitle = edad ? edad : "";

    // Verificar si es una storie o song
    const esStorieOSong =
      activity.classList.contains("storie") ||
      activity.classList.contains("song");

    // Agregar badge solo si NO es storie/song y tiene plantilla
    if (!esStorieOSong) {
      const tienePlantilla =
        (multimedia &&
          multimedia !== "" &&
          multimedia !== "false" &&
          multimedia !== "undefined") ||
        (multimedia_en &&
          multimedia_en !== "" &&
          multimedia_en !== "false" &&
          multimedia_en !== "undefined");

      if (tienePlantilla) {
        const badge = document.createElement("div");
        badge.innerHTML = `
        <img src="https://i.ibb.co/Vmwb0VL/paper-clip.png" 
        alt="paper-clip" 
        border="0" 
        style="position: absolute; top: -9px; right: -15px; width: 25px; height: 25px;">`;
        activity.style.position = "relative"; // Asegurar posicionamiento relativo
        activity.appendChild(badge);
      }
    }

    // Evitar agregar múltiples listeners al mismo elemento
    if (activity.hasAttribute('data-listener-added')) {
      return;
    }
    activity.setAttribute('data-listener-added', 'true');

    activity.addEventListener("click", async () => {
      let activityId;

      // Verificar si el atributo data-theid-esp está indefinido o vacío 3kprueba
      if (
        activity.getAttribute("data-theid-esp") === "undefined" ||
        activity.getAttribute("data-theid-esp") === "" ||
        activity.getAttribute("data-theid-esp") === null
      ) {
        // Si está indefinido o vacío, asignar el valor de data-theid
        activityId = activity.getAttribute("data-theid");
      } else {
        // Si tiene un valor, asignar el de data-theid-esp
        activityId = activity.getAttribute("data-theid-esp");
      }

      const dialog = document.getElementById("favDialog");

      fetch("/miembros/get/getCalifications.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ activityId: activityId }),
      })
        .then((response) => response.json())
        .then((data) => {
          const promedioElement = document.getElementById("promedio");
          const cantidadCalificacionesElement = document.getElementById(
            "cantidadCalificaciones"
          );
          const estrellasElement = document.getElementById("estrellas");
          estrellasElement.innerHTML = ""; // Limpiar contenido anterior

          // Asegurarse de que data sea un array y contenga al menos un elemento
          if (Array.isArray(data) && data.length > 0) {
            const firstItem = data[0]; // Obtener el primer objeto del array

            // Redondear el promedio a un número entero
            const promedio = Math.round(firstItem.promedio) || 0;

            // Actualizar el promedio en el span con id "promedio"
            promedioElement.textContent = promedio;

            // Verificar si calificacion_actividads existe y tiene longitud
            if (
              firstItem.calificacion_actividads &&
              Array.isArray(firstItem.calificacion_actividads)
            ) {
              cantidadCalificacionesElement.textContent = `(${firstItem.calificacion_actividads.length})`;
            } else {
              cantidadCalificacionesElement.textContent = "(0)"; // Valor por defecto si no hay calificaciones
            }

            // Agregar estrellas llenas
            for (let i = 0; i < promedio; i++) {
              estrellasElement.innerHTML += `
                <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid fill">
                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                </svg>
              `;
            }

            // Agregar estrellas vacías
            for (let i = promedio; i < 5; i++) {
              estrellasElement.innerHTML += `
                <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                </svg>
              `;
            }
          } else {
            // No hay calificaciones aún, esto es normal y no es un error
            // Mostrar cinco estrellas vacías por defecto
            promedioElement.textContent = "0";
            cantidadCalificacionesElement.textContent = "(0)";
            for (let i = 0; i < 5; i++) {
              estrellasElement.innerHTML += `
                <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                </svg>
              `;
            }
          }
        })
        .catch((error) => {
          console.error("Error fetching data:", error);
        });

      $(".preloader").fadeIn();

      // Obtener el contenedor de calificación en el diálogo
      const ratingDiv = dialog.querySelector("#ratingContainer");

      // Limpiar el contenedor de calificación existente (si existe)
      ratingDiv.innerHTML = "";

      // Crear un nuevo contenedor para la calificación de LA actividad
      const ratingContainer = document.createElement("div");
      ratingContainer.id = `rating-container-${activityId}`;
      ratingContainer.classList.add("rating");

      // Recuperar la calificación guardada del localStorage
      const savedRating = localStorage.getItem(`rating-${activityId}`);

      // Agregar dinámicamente los inputs de calificación
      for (let i = 5; i >= 1; i--) {
        // Cambia el bucle para que cuente de 5 a 1
        const input = document.createElement("input");
        input.type = "radio";
        input.id = `star${i}-${activityId}`;
        input.name = `rate-${activityId}`;
        input.value = i;

        // Si existe una calificación guardada, seleccionarla
        if (savedRating && savedRating === i.toString()) {
          input.checked = true;
        }

        const label = document.createElement("label");
        label.setAttribute("for", `star${i}-${activityId}`);
        label.title = `${i} estrellas`; // Cambia el título para reflejar el número de estrellas
        label.innerHTML = `<svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
            </svg>`;

        // Agregar el input y el label al nuevo contenedor de calificación
        ratingContainer.appendChild(input);
        ratingContainer.appendChild(label);

        // Función para obtener el nombre del navegador
        function getBrowserName(userAgent) {
          if (userAgent.includes("Firefox")) return "Firefox";
          if (userAgent.includes("Edg")) return "Edge";
          if (userAgent.includes("Chrome")) return "Chrome";
          if (userAgent.includes("Safari")) return "Safari";
          if (userAgent.includes("Opera") || userAgent.includes("OPR"))
            return "Opera";
          return "Desconocido"; // Navegador no identificado
        }

        // Agregar un evento para activar el webhook al cambiar la calificación
        input.addEventListener("change", async () => {
          if (input.checked) {
            const ratingValue = input.value;
            const userSessionID =
              document.getElementById("userSession").innerText;
            const semanaSeleccionada =
              document.getElementById("selectedWeek").value;
            const temaCurriculum =
              document.getElementById("asideTitle").innerText;
            const webhookUrl =
              "https://hook.us1.make.com/5elf0ghnnn8ez1n8n4ivfsbdbifo65f2";

            // Obtener fecha actual en formato YYYY-MM-DD
            const currentDate = new Date().toISOString().split("T")[0];

            // Obtener resolución de pantalla
            const screenResolution = `${window.screen.width}x${window.screen.height}`;

            // Obtener navegador
            const browserInfo = getBrowserName(navigator.userAgent);

            // Obtener la IP pública
            let userIP = "Desconocida";
            try {
              const response = await fetch("https://api.ipify.org?format=json");
              const data = await response.json();
              userIP = data.ip;
            } catch (error) {
              console.error("Error al obtener la IP del usuario:", error);
            }

            // Crear los datos para enviar
            const payload = {
              rating: ratingValue,
              activityId: activityId,
              userId: userSessionID,
              semana: semanaSeleccionada,
              tema: temaCurriculum,
              fecha: currentDate,
              resolucion: screenResolution,
              navegador: browserInfo,
              ip: userIP,
            };

            try {
              // Enviar los datos al webhook usando fetch
              const response = await fetch(webhookUrl, {
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                },
                body: JSON.stringify(payload),
              });

              // Manejar la respuesta
              if (response.ok) {
                const responseData = await response.json();
              } else {
                console.error(
                  "Error al activar el webhook:",
                  response.statusText
                );
              }
            } catch (error) {
              console.error("Error de red:", error);
            }

            // Guardar la calificación seleccionada en el localStorage
            localStorage.setItem(`rating-${activityId}`, ratingValue);
          }
        });
      }

      // Agregar el nuevo contenedor al diálogo
      ratingDiv.appendChild(ratingContainer);

      if (
        dominioPromises.length == 0 ||
        elofPromises.length == 0 ||
        momentosPromises.length == 0 ||
        enfoquePromises.length == 0
      ) {
        await getElofAndDominios();
      }
      const momentoIcono = momentosPromises.find(
        (moment) => moment.title == momento
      );
      function filterArrayByIDs(array, idsToFilter) {
        return array.filter((item) => idsToFilter.includes(item.id.toString()));
      }
      const dataEnfoque = activity.dataset.enfoque;

      const enfoqueIDs = dataEnfoque ? dataEnfoque.split(",") : [];

      filteredArrayEnfoque = filterArrayByIDs(enfoquePromises, enfoqueIDs);

      if (dominios_uc || elof) {
        const idsToFilterdominios_uc = dominios_uc.split(", ");
        const idsToFilterelof = elof.split(", ");
        filteredArrayDominio = filterArrayByIDs(
          dominioPromises,
          idsToFilterdominios_uc
        );
        filteredArrayElof = filterArrayByIDs(elofPromises, idsToFilterelof);
      }

      addEventListeners(theid);
      const setAdjuntosLink = () => {
        if (link_de_cancion !== "" && link_de_cancion !== "false") {
          btnadjuntos.href = link_de_cancion;
          btnadjuntos.style.display = "flex";
        } else if (link_de_cuento !== "" && link_de_cuento !== "false") {
          btnadjuntos.href = link_de_cuento;
          btnadjuntos.style.display = "flex";
        } else {
          btnadjuntos.style.display = "none";
        }
      };
      const setMultimediaLink = () => {
          // Obtener el idioma actual del DOM cuando se ejecuta la función (para currículo 3K)
          const currentLang = document.getElementById("lang").value || "es";
          
          const sanitizeMultimediaUrl = (value) => {
            if (!value) return "";
            const trimmed = value.toString().trim();
            return trimmed === "" ||
              trimmed === "false" ||
              trimmed === "undefined"
              ? ""
              : trimmed;
          };

          // Usar el idioma actual del DOM, no el parámetro lang
          const preferred =
            currentLang === "es"
              ? activity.dataset.multimedia
              : activity.dataset.multimedia_en;
          const fallback =
            currentLang === "es"
              ? activity.dataset.multimedia_en
              : activity.dataset.multimedia;

          const multimediaURL =
            sanitizeMultimediaUrl(preferred) ||
            sanitizeMultimediaUrl(fallback);

          if (multimediaURL) {
            const finalUrl = `/miembros/print.php?file=${encodeURIComponent(multimediaURL)}&fileName=${get_alias(title)}`;
            btnmulti.href = finalUrl;
            btnmultiDownload.href = `/miembros/download.php?file=${encodeURIComponent(multimediaURL)}&fileName=${get_alias(title)}`;
            btnmulti.style.display = "flex";
            btnmultiDownload.style.display = "flex";
          } else {
            btnmulti.style.display = "none";
            btnmultiDownload.style.display = "none";
          }
        };

        const setHeaderStyles = () => {
        document.querySelector(".dialog-header").style.backgroundColor =
          colorstroke;
        document.querySelector("dialog .dialog-header h2.title").innerHTML =
          title;
        document.querySelector(
          "dialog .dialog-header .flex .time span"
        ).innerHTML = `${tiempo} min`;
      };
      const setContent = async () => {
        // Obtener el idioma actual del DOM
        const currentLang = document.getElementById("lang").value || "es";
        
        if (window.innerWidth > 768) {
          document.querySelector("#orientacion").setAttribute("open", true);
          document.querySelector("#desc").setAttribute("open", true);
          document.querySelector("#objetivo").setAttribute("open", true);
        }
        document.querySelector("#orientacion .cont").innerHTML = instrucciones;
        document.querySelector("#desc .cont").innerHTML = description;
        document.querySelector("#objetivo .cont").innerHTML = objetivos;
        
        // Determinar qué imagen usar según el idioma
        let imageUrl = null;
        let fotoUrl = activity.getAttribute("data-foto");

        // Prioridad: foto > multimedia según idioma
        if (fotoUrl && fotoUrl !== "undefined" && fotoUrl !== "false" && fotoUrl !== "") {
          imageUrl = fotoUrl;
        } else if (currentLang === "es") {
          // En español, usar multimedia
          if (multimedia && multimedia !== "false" && multimedia !== "undefined" && multimedia !== "") {
            imageUrl = multimedia;
          }
        } else {
          // En inglés, usar multimedia_en
          if (multimedia_en && multimedia_en !== "false" && multimedia_en !== "undefined" && multimedia_en !== "") {
            imageUrl = multimedia_en;
          } else if (multimedia && multimedia !== "false" && multimedia !== "undefined" && multimedia !== "") {
            // Fallback a multimedia si multimedia_en no está disponible
            imageUrl = multimedia;
          }
        }
        
        if (imageUrl) {
          // Mostrar imagen
          document.querySelector(".foto img").style.display = "block";
          document.querySelector(".foto img").src = imageUrl;
          document.querySelector(".foto .placeholder").style.display = "none";
        } else {
          // Si no hay imagen válida, mostrar el placeholder
          const placeholder = document.querySelector(".foto .placeholder");
          document.querySelector(".foto img").style.display = "none";
          placeholder.style.display = "flex";

          if (momentoIcono) {
            placeholder.innerHTML = `<img src="${momentoIcono.icon}" alt="icono" width="50px"/>`;
          }

          // Estilos del placeholder
          placeholder.style.backgroundColor = colorfill;
          placeholder.style.border = `2px solid ${colorstroke}`;
        }
        // document.querySelector(".materiales").innerHTML = `${materiales}`;
        document.querySelector(".materiales").innerHTML = `${materiales || ''}${materiales_reciclables || ''}`;
        document.querySelector(".tip").innerHTML = `${tips}`;
        document.querySelector(
          "dialog .dialog-header .flex .years span"
        ).innerHTML = edadTitle;
      };

      const renderItems = () => {
        // Esperar a que todas las promesas se resuelvan
        Promise.all([
          ...filteredArrayDominio,
          ...filteredArrayElof,
          ...momentosPromises,
          ...filteredArrayEnfoque,
        ]).then((responses) => {
          // Verificar si hay respuestas
          if (responses.length > 0) {
            // Limpiar contenido existente
            document.querySelector(".dominios .con").innerHTML = "";
            document.querySelector(".subdominios .con").innerHTML = "";
            document.querySelector("#enfoque .con").innerHTML = "";

            // Mostrar contenedores
            document.querySelector(".dominios").style.display = "grid";
            document.querySelector(".subdominios").style.display = "grid";

            // Iterar sobre las respuestas
            responses.forEach((response) => {
              if (response.typeLocal === "elof") {
                let elof = response;

                // Decodificar el título HTML
                var textoOriginal = elof.title;
                var elementoTemporal = document.createElement("div");
                elementoTemporal.innerHTML = textoOriginal;
                var textoDecodificado =
                  elementoTemporal.textContent || elementoTemporal.innerText;
                var partes = textoDecodificado.split("–");
                var textoSeparado = partes[1].trim();

                // Insertar elementos DOM para elof
                if (!document.querySelector(`#elof-${elof.type}`)) {
                  document.querySelector(
                    ".dominios .con"
                  ).innerHTML += `<div class="dominios-item"><img src="img/dominios/${elof.type
                  }.svg" /><small style="color:${dominiosColor[elof.type]};">${dominiosTitles[elof.type]
                    }</small></div>`;
                  document.querySelector(
                    ".dominios .con"
                  ).innerHTML += `<div class="dominios-item" id="elof-${elof.type
                  }"><img src="${elof.icon}" /><small style="color:${dominiosColor[elof.type]
                    };">${textoSeparado}</small></div>`;
                }
              } else if (response.typeLocal === "dominiouc") {
                let dominio = response;
                // Decodificar el título HTML
                var textoOriginal = dominio.title;
                var elementoTemporal = document.createElement("div");
                elementoTemporal.innerHTML = textoOriginal;
                var textoDecodificado =
                  elementoTemporal.textContent || elementoTemporal.innerText;
                var partes = textoDecodificado.split("–");
                var textoSeparado = partes[1].trim();
                // Insertar elementos DOM para dominio
                if (!document.querySelector(`#dominio-${dominio.type}`)) {
                  document.querySelector(
                    ".subdominios .con"
                  ).innerHTML += `<div class="subdominios-item" id="dominio-${dominio.type
                  }"><img src="img/elof/${dominio.type
                    }.svg" /><small style="color:${elofColor[dominio.type]};">${dominiosTitles[dominio.type]
                    }</small></div>`;
                }
                // Insertar elementos DOM para subdominio
                document.querySelector(
                  ".subdominios .con"
                ).innerHTML += `<div class="subdominios-item" id="subDom-${dominio.type
                }">
                ${dominio.icon
                    ? `<img src="${dominio.icon}" />`
                    : `<img src="img/elof/${dominio.type}.svg" />`
                  }
                <small style="color:${elofColor[dominio.type]
                  };">${textoSeparado}</small></div>`;
              } else if (response.typeLocal === "enfoque_general") {
                let enfoque = response;

                // Decodificar el título y la descripción HTML si es necesario
                var enfoqueTituloOriginal = enfoque.title;

                var tempTitleElement = document.createElement("div");
                tempTitleElement.innerHTML = enfoqueTituloOriginal;
                var enfoqueTituloDecodificado =
                  tempTitleElement.textContent || tempTitleElement.innerText;

                let enfoqueTituloEN, colorEnfoque, imagenEnfoque;

                if (enfoqueTituloDecodificado === "Desarrollo Cognitivo") {
                  enfoqueTituloEN = "Cognitive Development";
                  colorEnfoque = "#8773AE";
                  imagenEnfoque = "img/enfoque/cognitivo.png";
                } else if (
                  enfoqueTituloDecodificado === "Desarrollo del espíritu"
                ) {
                  enfoqueTituloEN = "Spiritual Development";
                  colorEnfoque = "#30f77e";
                  imagenEnfoque = "img/enfoque/espiritu.png";
                } else if (
                  enfoqueTituloDecodificado === "Desarrollo Emocional"
                ) {
                  enfoqueTituloEN = "Emotional Development";
                  colorEnfoque = "#F5AA16";
                  imagenEnfoque = "img/enfoque/emocional.png";
                } else if (enfoqueTituloDecodificado === "Desarrollo Físico") {
                  enfoqueTituloEN = "Physical Development";
                  colorEnfoque = "#0CB5C3";
                  imagenEnfoque = "img/enfoque/fisico.png";
                } else if (enfoqueTituloDecodificado === "Desarrollo Social") {
                  enfoqueTituloEN = "Social Development";
                  colorEnfoque = "#EB5D5E";
                  imagenEnfoque = "img/enfoque/social.png";
                }

                // Insertar elementos DOM para enfoque
                document.querySelector("#enfoque .con").innerHTML += `
                  <div class="enfoque-item">
                    <img src="${imagenEnfoque}"/>
                    <small style="color: ${colorEnfoque}; font-size: 12px;">${enfoqueTituloDecodificado}</small>
                  </div>`;
              }
            });
          }
          // Mostrar el contenedor de enfoque si tiene contenido
          const enfoqueContainer = document.querySelector("#enfoque");
          if (document.querySelector("#enfoque .con").innerHTML.trim() !== "") {
            enfoqueContainer.style.display = "block";
          } else {
            enfoqueContainer.style.display = "none";
          }
          // Mostrar diálogo modal
          favDialog.showModal();
        });
      };

      setAdjuntosLink();
      setMultimediaLink();
      setHeaderStyles();
      setContent();
      if (filteredArrayDominio && filteredArrayElof) {
        renderItems();
        $(".preloader").fadeOut("slow");
      }
    });
  });
};
if (curriculumID != "") {
  if (curriculumID == 195) {
    getInfo3k(actualLang, weekNumber).finally(() => {
      $(".preloader").fadeOut("slow");
    });
  } else {
    // console.log("Idioma actual:", actualLang);
    // Llamar a la función que espera las funciones asincrónicas y luego ejecuta el código
    getWeekDataNew(actualLang, weekNumber).finally(() => {
      $(".preloader").fadeOut("slow");
    });
  }
}
function filtrarPorIdioma(item, idioma) {
  console.log("Filtrando por idioma:", idioma);
  console.log("Item recibido para filtrar:", item);
  document.querySelectorAll("[data-interfazid]").forEach((text) => {
    let id = text.dataset.interfazid;
    console.log(`Procesando data-interfazid: ${id}`);
    text.textContent = item[id][idioma];
  });
}


console.log("Función generateDayHTML llamada");
// Función para generar el HTML para un día de la semana
function generateDayHTML(data, day) {
  return ` <section class="day">
  <h2 class="bluetitle" data-interfazid="${data}">${day}</h2>
  <div class="song activity"><span data-interfazid="7"><div class="badge" style="position:absolute; top:-15px; right:-10px; background-color:#333B5C; color:white; border-radius:500px; padding:8px 15px; font-size: 11px;font-weight: 600;">Video</div><svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 0.5C5.37258 0.5 0 5.87258 0 12.5C0 19.1274 5.37258 24.5 12 24.5C18.6274 24.5 24 19.1274 24 12.5C24 5.87258 18.6274 0.5 12 0.5ZM8.77007 15.5547V15.2475C8.77007 14.55 8.77423 13.8525 8.7784 13.155C8.78673 11.76 8.79507 10.365 8.77007 8.97004C8.75507 8.22004 9.34007 7.31254 10.1201 7.06504C10.4805 6.95201 10.8409 6.83856 11.2015 6.72508C12.9941 6.16085 14.7893 5.5958 16.6001 5.07754C17.4326 4.83754 18.0476 5.14504 18.0476 6.13504C18.0559 7.86416 18.0527 9.59097 18.0494 11.318C18.0468 12.6998 18.0442 14.0817 18.0476 15.465C18.0476 16.4175 17.5676 17.07 16.8251 17.5725C15.9851 18.1425 15.0476 18.3 14.0651 18.0675C12.4976 17.6925 12.0101 16.1175 13.0976 14.91C14.0576 13.845 15.2726 13.5375 16.6526 13.86C16.7351 13.8825 16.8176 13.905 16.9001 13.92V9.25504C16.9001 8.92504 16.6976 8.81254 16.3076 8.91754C15.8051 9.05254 15.3101 9.20254 14.8151 9.36004C13.4351 9.79504 12.0551 10.23 10.6826 10.6725C10.1051 10.86 9.94007 11.0925 9.93257 11.685C9.92507 13.4775 9.91757 15.27 9.90257 17.0625C9.88757 18.5925 8.73257 19.7925 7.20257 19.86C6.76757 19.8825 6.30257 19.8825 5.89007 19.7775C4.64507 19.4625 4.13507 18.2325 4.78007 17.1225C5.38007 16.0875 6.33257 15.5775 7.50257 15.4875C7.77159 15.468 8.04062 15.4931 8.32004 15.5191C8.46668 15.5328 8.61619 15.5468 8.77007 15.5547Z" fill="white" /></svg> Canción semanal</span></div>
  <div class="storie activity"><span><img src="img/momentos/material_literario.svg" alt="Material literario" /> Material literario</span></div>
  <div class="containerActivities">
    <div class="activity reunionMatutina-container"><span data-interfazid="31"><img src="img/momentos/reunion_matutina.svg" alt="Reunión matutina" /> Reunión matutina:</span></div>
    <div class="activity grupopequenomanana-container"><span data-interfazid="24"><img src="img/momentos/grupo_pequeno.svg" alt="Grupo pequeño de la mañana" /> Grupo pequeño de la mañana:</span></div>
    <div class="activity grupopequenomanana-container"><span data-interfazid="24"><img src="img/momentos/grupo_pequeno.svg" alt="Grupo pequeño de la mañana" /> Grupo pequeño de la mañana:</span></div>
    <div class="activity grupopequenomanana-container"><span data-interfazid="24"><img src="img/momentos/grupo_pequeno.svg" alt="Grupo pequeño de la mañana" /> Grupo pequeño de la mañana:</span></div>
    <div class="activity musicamovimiento-container"><span data-interfazid="30"><img src="img/momentos/musica_movimiento.svg" alt="Música y movimiento" /> Música y movimiento:</span></div>
    <div class="activity mananacuentos-container"><span data-interfazid="28"><img src="img/momentos/material_literario.svg" alt="Mañana de cuentos" /> Mañana de cuentos:</span></div>
    <div class="activity juegoalairelibre-container"><span data-interfazid="26"><img src="img/momentos/actividades_aire_libre.svg" alt="Juego al aire libre" /> Juego al aire libre:</span></div>
    <div class="activity lavado-container"><span data-interfazid="27"><img src="img/momentos/lavado_manos.svg" alt="Lavado de manos" />Lavado de manos</span></div>
    <div class="activity food almuerzo-container"><span data-interfazid="22"><img src="img/momentos/almuerzo.svg" alt="Almuerzo" />Almuerzo</span></div>
    <div class="activity storytime-container"><span data-interfazid="33"><img src="img/momentos/story_time.svg" alt="Story time" />Story time:</span></div>
    <div class="activity grupopequenotarde-container"><span data-interfazid="25"><img src="img/momentos/grupo_pequenotarde.svg" alt="Grupo pequeño de la tarde" /> Grupo pequeño de la tarde:</span></div>
    <div class="activity grupopequenotarde-container"><span data-interfazid="25"><img src="img/momentos/grupo_pequenotarde.svg" alt="Grupo pequeño de la tarde" /> Grupo pequeño de la tarde:</span></div>
    <div class="activity grupopequenotarde-container"><span data-interfazid="25"><img src="img/momentos/grupo_pequenotarde.svg" alt="Grupo pequeño de la tarde" /> Grupo pequeño de la tarde:</span></div>
    <div class="activity food snack-container"><span data-interfazid="32"><img src="img/momentos/almuerzo.svg" alt="Snack time" />Snack time</span></div>
    <div class="activity despedida-container"><span data-interfazid="23"><img src="img/momentos/despedida.svg" alt="Despedida" />Despedida:</span></div>
  </div>
</section>`;
}
// Array de días de la semana
const daysOfWeekArray = [
  {
    data: "6",
    es: "Lunes",
  },
  {
    data: "9",
    es: "Martes",
  },
  {
    data: "10",
    es: "Miércoles",
  },
  {
    data: "11",
    es: "Jueves",
  },
  {
    data: "12",
    es: "Viernes",
  },
];

function getOtherLang(el) {
  actualLang = el.value;
  fetch("g/interfaz/")
    .then((res) => res.json())
    .then((data) => {
      console.log("Datos de interfaz recibidos:", data);
      console.log("Idioma seleccionado:", actualLang);
      filtrarPorIdioma(data, actualLang);
    });
  $(".preloader").fadeIn();
  getOtherWeek(document.querySelector("#semanaSelect"));
}
function getDateFromWeekNumber(weekNumber, year) {
  // If year is not provided, use the current year
  if (year === undefined) {
    year = new Date().getFullYear();
  }

  // Convertir weekNumber a número si viene como string
  weekNumber = parseInt(weekNumber, 10);

  // Si la semana es 53, verificar si realmente existe en ese año
  if (weekNumber === 53) {
    // Calcular cuántas semanas tiene ese año
    const ultimoDiaDelAno = new Date(year, 11, 31);
    const startOfYear = new Date(year, 0, 1);
    const pastDaysOfYear = (ultimoDiaDelAno - startOfYear) / 86400000;
    const ultimaSemanaDelAno = Math.ceil((pastDaysOfYear + startOfYear.getDay() + 1) / 7);
    
    // Si el año no tiene semana 53, usar semana 1 del año siguiente
    if (ultimaSemanaDelAno < 53) {
      year = year + 1;
      weekNumber = 1;
    }
  }

  // Calcular la fecha del primer lunes del año usando getFirstDayOfWeek
  var januaryFirst = new Date(year, 0, 1);
  var firstDayOfWeekYear = getFirstDayOfWeek(januaryFirst);
  
  // Si la semana es 1, verificar si realmente pertenece al año proporcionado
  // o si debería ser del año siguiente (cuando cruza el año)
  if (weekNumber === 1) {
    // Si la fecha calculada es del año anterior, significa que la semana 1 realmente pertenece al año siguiente
    if (firstDayOfWeekYear.getFullYear() < year) {
      // La semana 1 realmente pertenece al año siguiente
      // Para la semana 1 del 2026 que cruza al 2027, debe iniciar el 29 de diciembre de 2026
      // Calcular el lunes de la semana que contiene el 1 de enero del año siguiente
      year = year + 1;
      januaryFirst = new Date(year, 0, 1);
      
      // Caso especial: para el año 2027, la semana 1 del 2026 debe iniciar el 29 de diciembre de 2026
      // El usuario especifica que la semana debe iniciar el 29 de diciembre y terminar el 2 de enero
      // Retornar directamente el 29 de diciembre de 2026 como fecha de inicio
      if (year === 2027) {
        return new Date(2026, 11, 29); // 29 de diciembre de 2026
      }
      
      // Para otros años, usar el cálculo estándar
      return getFirstDayOfWeek(januaryFirst);
    }
    // Si la fecha calculada es del año proporcionado, retornarla directamente
    return firstDayOfWeekYear;
  }

  // Para semanas mayores a 1, calcular desde el primer lunes del año
  var firstDayOfWeek = new Date(firstDayOfWeekYear);
  firstDayOfWeek.setDate(firstDayOfWeekYear.getDate() + (weekNumber - 1) * 7);
  return firstDayOfWeek;
}
function getOtherWeek(el) {
  if (curriculumID != 195) {
    $(".preloader").fadeIn();

    document
      .querySelectorAll(".containerActivities")
      .forEach((el) => (el.innerHTML = ""));
    let valueWeek = el.value;
    
    // Obtener la fecha de inicio directamente del texto del select para evitar problemas con años cruzados
    let firstDayCurrentWeek = null;
    const semanaSelect = document.getElementById('semanaSelect');
    if (semanaSelect && semanaSelect.selectedIndex > 0) {
      const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
      // Extraer la fecha de inicio de la semana (formato: "Semana MM/DD/YYYY al MM/DD/YYYY")
      const fechaMatch = weekText.match(/(\d{2})\/(\d{2})\/(\d{4})/);
      if (fechaMatch && fechaMatch.length >= 4) {
        // Construir la fecha directamente desde el texto del select
        const month = parseInt(fechaMatch[1], 10) - 1; // Mes en JS es 0-indexed
        const day = parseInt(fechaMatch[2], 10);
        const year = parseInt(fechaMatch[3], 10);
        const startDate = new Date(year, month, day);
        firstDayCurrentWeek = getFirstDayOfWeek(startDate);
        console.log('Primer día de la semana calculado desde texto del select:', firstDayCurrentWeek, 'año:', year);
      }
    }
    
    // Si no se pudo obtener del select, usar getDateFromWeekNumber como fallback
    if (!firstDayCurrentWeek) {
      let targetYear = null;
      if (semanaSelect && semanaSelect.selectedIndex > 0) {
        const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
        const fechaMatch = weekText.match(/(\d{2})\/(\d{2})\/(\d{4})/);
        if (fechaMatch && fechaMatch.length >= 4) {
          targetYear = parseInt(fechaMatch[3], 10);
        }
      }
      if (!targetYear) {
        targetYear = new Date().getFullYear();
      }
      let currentDate = getDateFromWeekNumber(valueWeek, targetYear);
      
      // Caso especial: si es la semana 1 del 2026 que cruza al 2027, 
      // getDateFromWeekNumber retorna el 29 de diciembre directamente
      // No ajustar al lunes anterior en este caso
      if (valueWeek === 1 && targetYear === 2026 && currentDate.getDate() === 29 && currentDate.getMonth() === 11 && currentDate.getFullYear() === 2026) {
        firstDayCurrentWeek = currentDate;
      } else {
        firstDayCurrentWeek = getFirstDayOfWeek(currentDate);
      }
      console.log('Primer día de la semana calculado con getDateFromWeekNumber:', firstDayCurrentWeek);
    }
    
    var daysOfWeek = document.querySelectorAll(".outter.week.flex .day");
    var dayIncrement = 0;
    
    for (var i = 0; i < daysOfWeek.length; i++) {
      var day = daysOfWeek[i];
      var date = new Date(firstDayCurrentWeek);
      date.setDate(firstDayCurrentWeek.getDate() + dayIncrement);
      var formattedDate = formatDate(date);
      // 27/03/2024
      day.setAttribute("data-date", formattedDate);
      console.log(`Día ${i + 1} (${day.querySelector('h2')?.textContent}): data-date="${formattedDate}"`);
      dayIncrement++;
    }
    // console.log("Idioma actual:", actualLang);
    getWeekDataNew(actualLang, valueWeek).finally(() => {
      $(".preloader").fadeOut("slow");
    });
  } else {
    // Obtener el elemento contenedor
    const curriculumContent = document.querySelector(
      ".curriculumcontent .week"
    );
    curriculumContent.innerHTML = "";
    // Generar el HTML para cada día y agregarlo al contenedor
    daysOfWeekArray.forEach((day) => {
      curriculumContent.innerHTML += generateDayHTML(day.data, day.es);
    });
    let valueWeek = el.value;
    
    // Obtener la fecha de inicio directamente del texto del select para evitar problemas con años cruzados
    let firstDayCurrentWeek = null;
    const semanaSelect = document.getElementById('semanaSelect');
    if (semanaSelect && semanaSelect.selectedIndex > 0) {
      const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
      // Extraer la fecha de inicio de la semana (formato: "Semana MM/DD/YYYY al MM/DD/YYYY")
      const fechaMatch = weekText.match(/(\d{2})\/(\d{2})\/(\d{4})/);
      if (fechaMatch && fechaMatch.length >= 4) {
        // Construir la fecha directamente desde el texto del select
        const month = parseInt(fechaMatch[1], 10) - 1; // Mes en JS es 0-indexed
        const day = parseInt(fechaMatch[2], 10);
        const year = parseInt(fechaMatch[3], 10);
        const startDate = new Date(year, month, day);
        firstDayCurrentWeek = getFirstDayOfWeek(startDate);
        console.log('Primer día de la semana calculado desde texto del select (3K):', firstDayCurrentWeek, 'año:', year);
      }
    }
    
    // Si no se pudo obtener del select, usar getDateFromWeekNumber como fallback
    if (!firstDayCurrentWeek) {
      let targetYear = null;
      if (semanaSelect && semanaSelect.selectedIndex > 0) {
        const weekText = semanaSelect.options[semanaSelect.selectedIndex].textContent;
        const fechaMatch = weekText.match(/(\d{2})\/(\d{2})\/(\d{4})/);
        if (fechaMatch && fechaMatch.length >= 4) {
          targetYear = parseInt(fechaMatch[3], 10);
        }
      }
      if (!targetYear) {
        targetYear = new Date().getFullYear();
      }
      let currentDate = getDateFromWeekNumber(valueWeek, targetYear);
      
      // Caso especial: si es la semana 1 del 2026 que cruza al 2027, 
      // getDateFromWeekNumber retorna el 29 de diciembre directamente
      // No ajustar al lunes anterior en este caso
      if (valueWeek === 1 && targetYear === 2026 && currentDate.getDate() === 29 && currentDate.getMonth() === 11 && currentDate.getFullYear() === 2026) {
        firstDayCurrentWeek = currentDate;
      } else {
        firstDayCurrentWeek = getFirstDayOfWeek(currentDate);
      }
      console.log('Primer día de la semana calculado con getDateFromWeekNumber (3K):', firstDayCurrentWeek);
    }
    
    var daysOfWeek = document.querySelectorAll(".outter.week.flex .day");
    var dayIncrement = 0;
    for (var i = 0; i < daysOfWeek.length; i++) {
      var day = daysOfWeek[i];
      var date = new Date(firstDayCurrentWeek);
      date.setDate(firstDayCurrentWeek.getDate() + dayIncrement);
      // Formatear fecha en formato DD/MM/YYYY directamente
      var dayStr = date.getDate().toString().padStart(2, "0");
      var monthStr = (date.getMonth() + 1).toString().padStart(2, "0");
      var yearStr = date.getFullYear().toString();
      var formattedDate = `${dayStr}/${monthStr}/${yearStr}`; // DD/MM/YYYY
      day.setAttribute("data-date", formattedDate);
      console.log(`Día ${i + 1} (${day.querySelector('h2')?.textContent}) (3K): data-date="${formattedDate}"`);
      dayIncrement++;
    }
    getInfo3k(actualLang, valueWeek).finally(() => {
      $(".preloader").fadeOut("slow");
      addFunctionActivities();
    });
  }
}

// Función para formatear una fecha en el formato "dd/mm"
function formatDate(date) {
  const day = date.getDate().toString().padStart(2, "0");
  const month = (date.getMonth() + 1).toString().padStart(2, "0");
  return `${month}/${day}`;
}

// Función para obtener el primer día de la semana (lunes) de una fecha
function getFirstDayOfWeek(date) {
  const d = new Date(date);
  const dayOfWeek = d.getDay();
  const diff = dayOfWeek === 0 ? 6 : dayOfWeek - 1;
  d.setDate(d.getDate() - diff);
  return d;
}

// Función para obtener el último día de la semana (viernes) de una fecha
function getLastDayOfWeek(date) {
  const d = new Date(date);
  const dayOfWeek = d.getDay();
  const diff = dayOfWeek === 0 ? 6 : dayOfWeek - 1;
  d.setDate(d.getDate() - diff + 4);
  return d;
}
function getWeekNumberD(date) {
  const year = date.getFullYear();
  const startOfYear = new Date(year, 0, 1);
  const pastDaysOfYear = (date - startOfYear) / 86400000;
  let weekNumber = Math.ceil((pastDaysOfYear + startOfYear.getDay() + 1) / 7);

  // Si la semana calculada es 53, verificar si realmente existe en ese año
  if (weekNumber === 53) {
    // Calcular cuántas semanas tiene ese año
    const ultimoDiaDelAno = new Date(year, 11, 31);
    const pastDaysOfYearUltimo = (ultimoDiaDelAno - startOfYear) / 86400000;
    const ultimaSemanaDelAno = Math.ceil((pastDaysOfYearUltimo + startOfYear.getDay() + 1) / 7);

    // Si el año no tiene semana 53, la fecha pertenece a la semana 1 del año siguiente
    if (ultimaSemanaDelAno < 53) {
      // Verificar si la fecha está realmente en el año siguiente
      const primerDiaAnoSiguiente = new Date(year + 1, 0, 1);
      const diasDesdeInicioAnoSiguiente = (date - primerDiaAnoSiguiente) / 86400000;
      
      if (diasDesdeInicioAnoSiguiente >= 0) {
        // La fecha está en el año siguiente, calcular semana 1
        const startOfNextYear = new Date(year + 1, 0, 1);
        const pastDaysOfNextYear = (date - startOfNextYear) / 86400000;
        weekNumber = Math.ceil((pastDaysOfNextYear + startOfNextYear.getDay() + 1) / 7);
        // Si aún es 53 o mayor, forzar a 1
        if (weekNumber >= 53) {
          weekNumber = 1;
        }
      } else {
        // La fecha está al final del año pero antes del 1 de enero, es semana 1 del año siguiente
        weekNumber = 1;
      }
    }
  }

  return weekNumber;
}
// Obtener la fecha actual
const currentDate = new Date();
const currentDayOfWeek = currentDate.getDay();
let firstDayCurrentWeek = new Date(currentDate);
firstDayCurrentWeek.setDate(currentDate.getDate() - currentDayOfWeek + 1); // Lunes de la semana actual

// Calcular el número de semana actual
const currentYear = currentDate.getFullYear();
let currentWeekNumber = getWeekNumberD(firstDayCurrentWeek);

// Si estamos en diciembre (mes 11) y la fecha actual está cerca del fin de año,
// verificar si deberíamos usar la semana 1 del año siguiente
if (currentDate.getMonth() === 11 && currentDate.getDate() >= 25) {
  // Calcular la semana 1 del año siguiente
  const week1NextYear = getDateFromWeekNumber(1, currentYear + 1);
  // Si la semana 1 del año siguiente está dentro de los próximos 14 días o ya pasó, usarla
  const daysDiff = (week1NextYear - currentDate) / (1000 * 60 * 60 * 24);
  if (daysDiff <= 14) {
    firstDayCurrentWeek = week1NextYear;
    currentWeekNumber = 1;
  }
}

const lastDayCurrentWeek = new Date(firstDayCurrentWeek);
lastDayCurrentWeek.setDate(firstDayCurrentWeek.getDate() + 4); // Viernes de la semana actual

function getFormattedWeek(startDate) {
  const start = new Date(startDate);
  const end = new Date(startDate);
  end.setDate(startDate.getDate() + 4);
  return {
    start: formatDateSelect(start),
    end: formatDateSelect(end),
  };
}

// Función para calcular el número de semana correcto cuando la semana cruza el año
function getWeekNumberFromDates(startDate, endDate) {
  const startYear = startDate.getFullYear();
  const endYear = endDate.getFullYear();
  
  // Si las fechas cruzan el año, la semana pertenece al año siguiente (semana 1)
  if (startYear !== endYear) {
    return 1;
  }
  
  // Si están en el mismo año, calcular la semana normalmente
  return getWeekNumberD(startDate);
}

function formatDate(date) {
  var day = date.getDate();
  var month = date.getMonth() + 1; // Los meses comienzan en 0
  var year = date.getFullYear();

  // Asegúrate de que day y month tengan dos dígitos
  if (day < 10) {
    day = "0" + day;
  }
  if (month < 10) {
    month = "0" + month;
  }

  return day + "/" + month + "/" + year;
}
function formatDateSelect(date) {
  const day = String(date.getDate()).padStart(2, "0");
  const month = String(date.getMonth() + 1).padStart(2, "0"); // Los meses en JavaScript son de 0 a 11
  const year = date.getFullYear();
  return `${month}/${day}/${year}`;
}

console.log('Holaaaaaaaaa');

const select = document.getElementById("semanaSelect");
if (select) {
  const weeks = [];

  // Función auxiliar para calcular semana desde fechas formateadas
  function getWeekNumberFromFormattedDates(startDateStr, endDateStr) {
    const startParts = startDateStr.split('/');
    const endParts = endDateStr.split('/');
    const startDate = new Date(
      parseInt(startParts[2]),
      parseInt(startParts[0]) - 1,
      parseInt(startParts[1])
    );
    const endDate = new Date(
      parseInt(endParts[2]),
      parseInt(endParts[0]) - 1,
      parseInt(endParts[1])
    );
    return getWeekNumberFromDates(startDate, endDate);
  }

  // Generar las 2 semanas anteriores
  for (let i = 2; i >= 1; i--) {
    const previousWeekStart = new Date(firstDayCurrentWeek);
    previousWeekStart.setDate(firstDayCurrentWeek.getDate() - (i * 7));
    const previousWeek = getFormattedWeek(previousWeekStart);
    const previousWeekNumber = getWeekNumberFromFormattedDates(previousWeek.start, previousWeek.end);
  weeks.push({
      text: `Semana ${previousWeek.start} al ${previousWeek.end}`,
      value: previousWeekNumber,
  });
  }

  // Semana actual
  // Verificar si la semana actual es la semana 1 que cruza el año
  // Si es así, calcular correctamente usando getDateFromWeekNumber
  let weekToUse = firstDayCurrentWeek;
  const currentWeekTemp = getFormattedWeek(firstDayCurrentWeek);
  const currentWeekNumberTemp = getWeekNumberFromFormattedDates(currentWeekTemp.start, currentWeekTemp.end);
  
  // Si la semana es 1 y estamos en diciembre, puede ser la semana 1 del año siguiente
  // También verificar si estamos cerca del fin de año (día 25 o después de diciembre)
  const currentDate = new Date();
  if (currentWeekNumberTemp === 1 && firstDayCurrentWeek.getMonth() === 11) {
    const currentYear = firstDayCurrentWeek.getFullYear();
    const week1NextYear = getDateFromWeekNumber(1, currentYear + 1);
    // Si la semana 1 del año siguiente está cerca de la fecha actual, usarla
    const daysDiff = Math.abs((week1NextYear - firstDayCurrentWeek) / (1000 * 60 * 60 * 24));
    if (daysDiff <= 14) {
      weekToUse = week1NextYear;
    }
  } else if (currentDate.getMonth() === 11 && currentDate.getDate() >= 25) {
    // Si estamos en diciembre (día 25 o después), verificar si deberíamos usar la semana 1 del año siguiente
    const currentYear = currentDate.getFullYear();
    const week1NextYear = getDateFromWeekNumber(1, currentYear + 1);
    const daysDiff = (week1NextYear - currentDate) / (1000 * 60 * 60 * 24);
    if (daysDiff <= 14 && daysDiff >= -7) {
      weekToUse = week1NextYear;
    }
  }
  
  const currentWeek = getFormattedWeek(weekToUse);
  const currentWeekNumber = getWeekNumberFromFormattedDates(currentWeek.start, currentWeek.end);
  weeks.push({
    text: `Semana ${currentWeek.start} al ${currentWeek.end}`,
    value: currentWeekNumber,
    selected: true,
  });
  
  // Actualizar firstDayCurrentWeek para que las semanas siguientes se calculen correctamente
  firstDayCurrentWeek = weekToUse;

  // Determinar cuántas semanas futuras mostrar según el dominio del correo
  // Si el correo es de bilingualchildcaretraining.com, mostrar 6 semanas futuras
  // De lo contrario, mostrar 4 semanas futuras (comportamiento por defecto)
  const isBilingualEmail = typeof correo_usuario !== 'undefined' && 
                            correo_usuario.indexOf('@bilingualchildcaretraining.com') !== -1;
  const futureWeeksCount = isBilingualEmail ? 6 : 4;

  // Generar las semanas siguientes
  for (let i = 1; i <= futureWeeksCount; i++) {
  const nextWeekStart = new Date(firstDayCurrentWeek);
    nextWeekStart.setDate(firstDayCurrentWeek.getDate() + (i * 7));
  const nextWeek = getFormattedWeek(nextWeekStart);
    const nextWeekNumber = getWeekNumberFromFormattedDates(nextWeek.start, nextWeek.end);
  weeks.push({
    text: `Semana ${nextWeek.start} al ${nextWeek.end}`,
    value: nextWeekNumber,
    });
  }

  let weeksToRender = weeks;

  // Filtrar semanas si curriculumID es 96224
  if (curriculumID === 96224) {
    weeksToRender = weeks.filter((week) => week.value >= 25);
  }

  weeksToRender.forEach((week) => {
    const option = document.createElement("option");
    option.value = week.value;
    option.textContent = week.text;
    if (week.selected) option.selected = true;
    select.appendChild(option);
  });

  // NO establecer los data-date aquí porque getWeekDataNew los establecerá correctamente
  // cuando se ejecute. Si los establecemos aquí con fechas incorrectas, getWeekDataNew
  // puede leer fechas incorrectas antes de establecerlas correctamente.
  // Los data-date se establecerán cuando getWeekDataNew se ejecute inicialmente.
}

const getAllServices = async () => {
  var requestOptions = {
    method: "GET",
    redirect: "follow",
  };
  const response = await fetch("g/services/", requestOptions);
  const data = await response.json();
  let serviceAdd = [];
  document
    .querySelectorAll("#subs_daycare .subs-table__cards")
    .forEach((el) => {
      if (el.dataset.service) {
        serviceAdd.push(el.dataset.service);
      }
    });

  // Filtrar los servicios en 'data' por cada ID en 'serviceAdd'
  const filteredData = data.filter(
    (service) => !serviceAdd.includes(service.id)
  );

  // Filtrar los servicios en 'filteredData' por 'no_view' igual a false
  const finalFilteredData = filteredData.filter(
    (service) => service.no_view === false
  );
  finalFilteredData.sort((a, b) => a.price - b.price);

  const curriculum = finalFilteredData
    .filter((t) => t.product.name.includes("Universal Curriculum"))
    .map((t) => t);
  const food = finalFilteredData
    .filter((t) => t.product.name.includes("FoodAi"))
    .map((t) => t);
  const others = finalFilteredData
    .filter(
      (t) =>
        !t.product.name.includes("FoodAi") &&
        !t.product.name.includes("Universal Curriculum")
    )
    .map((t) => t);

  document.querySelector("#planeaciones .services-table").innerHTML = "";
  document.querySelector("#foodai .services-table").innerHTML = "";
  document.querySelector("#bcct .services-table").innerHTML = "";
  //document.querySelector("#upselling").innerHTML = "";
  var seenIds = {}; // Objeto para rastrear los IDs vistos
  var curriculumFilter = curriculum.filter(function (item) {
    var id = item.product.id;
    if (!seenIds[id]) {
      seenIds[id] = true; // Marcar este ID como visto
      return true; // Mantener este elemento en el resultado final
    }
    return false; // Descartar este elemento ya que hemos visto este ID antes
  });
  if (
    correo_usuario.indexOf("@bilingualchildcaretraining.com") !== -1 ||
    correo_usuario.indexOf("@unimilitar.edu.co") !== -1
  ) {
    let template = ``;
    var productButtons = {
      "665a1290ed8044369fae8f3c": {
        curriculumLink:
          "/miembros/planeacion-semanal/after-schoolers-summer-edition-96224",
        textButton: "Ver curriculum",
      },
      "641c902739e209af12d73a44": {
        curriculumLink: "/miembros/planeacion-semanal/3k-195",
        textButton: "Ver curriculum",
      },
      "641b93584330e2536e87b674": {
        curriculumLink: "/miembros/planeacion-semanal/basic-79",
        textButton: "Ver curriculum",
      },
      "641c901f39e209af12d73a43": {
        curriculumLink: "/miembros/planeacion-semanal/intermedio-194",
        textButton: "Ver curriculum",
      },
      "66059eb6fd219ef4bf7f074f": {
        curriculumLink: "/miembros/planeacion-semanal/homeschooling-5828",
        textButton: "Ver curriculum",
      },
      "66059ec0fd219ef4bf7f0750": {
        curriculumLink: "/miembros/planeacion-semanal/infantes-647",
        textButton: "Ver curriculum",
      },
      "6346e319e2d31bfeadddbd47": {
        appStoreLink:
          "https://apps.apple.com/us/app/acuarela-for-daycares/id1573321954",
        appStoreButton: "Descargar de App Store",
        googlePlayLink:
          "https://play.google.com/store/apps/details?id=com.acuarela.daycaresapp",
        googlePlayButton: "Descargar de Google Play",
      },
      "65722e8ad37d5eca7e011d15": {
        menusLink: "/miembros/creacion-menus-ia?id={subscription_id}",
        textButton: "Ver Menús",
      },
      "670d49b441f534b285d6717c": {
        GoLink: "https://daycare-newyork.acuarela.app/Edit_Index.php",
        textButton: "Ir a mi web",
      },
    };
    curriculumFilter.forEach((service) => {
      // La subcadena '@bilingualchildcaretraining.com' está presente en correo_usuario
      // Aquí puedes colocar el código que deseas ejecutar si la condición se cumple
      template = `
      <div class="subs-table__cards acuarela" data-service="" open="">
      <div class="subs-table__header">
          <div class="flexCol">
              <div class="name">
                  <div class="icon"><img src="https://acuarelacore.com/api/${service?.logo?.url
        }" alt="${service.name}"></div>
                  <h3>${service.name}</h3>

              </div>
              <div class="date" style="opacity:0;">
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M13 3.5H3C2.44772 3.5 2 3.94772 2 4.5V11.5C2 12.0523 2.44772 12.5 3 12.5H13C13.5523 12.5 14 12.0523 14 11.5V4.5C14 3.94772 13.5523 3.5 13 3.5Z" stroke="#00A099" stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M2 7.50001H5.55C5.66515 7.49937 5.7769 7.539 5.86592 7.61205C5.95495 7.68509 6.01564 7.78695 6.0375 7.90001C6.13298 8.34971 6.38001 8.75297 6.73726 9.04233C7.0945 9.33168 7.54028 9.48957 8 9.48957C8.45972 9.48957 8.9055 9.33168 9.26274 9.04233C9.61999 8.75297 9.86702 8.34971 9.9625 7.90001C9.98436 7.78695 10.0451 7.68509 10.1341 7.61205C10.2231 7.539 10.3348 7.49937 10.45 7.50001H14" stroke="#00A099" stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M2 5.5H14" stroke="#00A099" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                  <div class="text">
                      text
                  </div>
              </div>
          </div>
      </div>
      <div class="content">
      <a target="_blank" href="${productButtons[service.product.id].curriculumLink
        }" class="btn dashboard">${productButtons[service.product.id].textButton
        }</a>
      </div>
      </div>`;

      document.querySelector("#subs_daycare").innerHTML += template;
    });
  }

  let template = ``;

  const urlParts = window.location.pathname.split("/");
  const daycareId = urlParts[urlParts.length - 1];

  curriculum.forEach((service) => {
    // Obtener el mes actual (0-11, donde 0 es enero y 5 es junio)
    const currentMonth = new Date().getMonth();

    // Verificar si es el servicio "After Schoolers Summer Edition"
    const isSummerEdition = service.name === "After Schoolers Summer Edition";

    // Mostrar solo si NO es Summer Edition O si es Summer Edition y estamos en junio (5), julio (6) o agosto (7)
    if (
      !isSummerEdition ||
      (isSummerEdition && currentMonth >= 5 && currentMonth <= 7)
    ) {
      template = `
      <div class="subs-table__cards">
        <div class="subs-table__header">
            <div class="flexCol">
                <div class="name">
                    <div class="icon"><img
                            src="https://acuarelacore.com/api/${service?.logo?.url}"
                            alt="${service.name}"></div>
                    <h3>${service.name}</h3>
                </div>
            </div>
        </div>
        <div class="content">
            <div>
                <div class="flex">
                    <strong>
                      Desde $${service.price}
                    </strong>
                </div>
            </div>
            <a target="_blank" href="${service.link_web}?daycare_id=${daycareId}" class="btn dashboard">Obtener servicio</a>
        </div>
      </div>`;
    }
    document.querySelector("#planeaciones .services-table").innerHTML +=
      template;
  });

  food.forEach((service) => {
    let template = `
  <div class="subs-table__cards">
      <div class="subs-table__header">
          <div class="flexCol">
              <div class="name">
                  <div class="icon"><img
                          src="https://acuarelacore.com/api/${service?.logo?.url}"
                          alt="${service.name}"></div>
                  <h3>${service.name}</h3>
              </div>
          </div>
      </div>
      <div class="content">
          <div>
              <div class="flex">
                  <strong>
                     Desde $${service.price}
                  </strong>

              </div>
          </div>
          <a target="_blank" href="${service.link_web}?daycare_id=${daycareId}" class="btn dashboard">Obtener servicio</a>

      </div>
  </div>`;
    document.querySelector("#foodai .services-table").innerHTML += template;
  });
  others.forEach((service) => {
    let template = `
  <div class="subs-table__cards">
      <div class="subs-table__header">
          <div class="flexCol">
              <div class="name">
                  <div class="icon"><img
                          src="https://acuarelacore.com/api/${service?.logo?.url}"
                          alt="${service.name}"></div>
                  <h3>${service.name}</h3>
              </div>
          </div>
      </div>
      <div class="content">
          <div>
              <div class="flex">
                  <strong>
                     Desde $${service.price}
                  </strong>

              </div>
          </div>
          <a target="_blank" href="${service.link_web}?daycare_id=${daycareId}" class="btn dashboard">Obtener servicio</a>

      </div>
  </div>`;
    document.querySelector("#bcct .services-table").innerHTML += template;
  });
};

if (document.querySelector("#createmenu")) {
  document.querySelector("#createmenu").addEventListener("click", () => {
    $(".preloader").fadeIn();
    document.querySelector("#menuDialog").showModal();
    $(".preloader").fadeOut("slow");
  });
}
const findDaycare = async () => {
  let license = document.querySelector("#daycareValLicencia").value;
  let state = document.querySelector("#where").value;
  const response = await fetch(
    `g/validateDaycare/?license=${license}&state=${state}`
  );
  const data = await response.json();
  if (data.length > 0) {
    document.querySelector("#daycaresFounded").style.display = "grid";
    document.querySelector("#daycaresFounded .grid-checkbox").innerHTML = "";
    data.forEach((daycare) => {
      document.querySelector(
        "#daycaresFounded .grid-checkbox"
      ).innerHTML += `  <span>
      <div class="checkbox-wrapper-16">
        <label class="checkbox-wrapper">
          <input class="checkbox-input" type="radio" name="findDaycare" id="${daycare.id}">
          <span class="checkbox-tile">
            <span class="checkbox-label">${daycare.name}</span>
          </span>
        </label>
      </div>
    </span>`;
    });
  } else {
    document.querySelector("#daycaresFounded").style.display = "none";
    document.querySelector("#daycaresFounded .grid-checkbox").innerHTML = "";
    Fancybox.show([{ src: "#dialog-daycarenotfound", type: "inline" }]);
  }
};
if (document.querySelector("#where")) {
  document.querySelector("#where").addEventListener("change", () => {
    findDaycare();
  });
}
if (document.querySelector("#state")) {
  document.querySelector("#state").addEventListener("change", () => {
    document.querySelector("button[type=submit]").removeAttribute("disabled");
  });
}

function deleteSuscription(idSub) {
  Fancybox.show([{ src: "#dialog-content-susc", type: "inline" }]);
}

// Función para formatear el nombre del componente
function formatoComponente(componente) {
  // Dividir el nombre del componente por guiones bajos y convertir las palabras en mayúsculas
  return componente
    .split("_")
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join("/");
}

// Wizard Acuarela Portal de usuarios

async function query(endpoint, method = "GET", body = "") {
  const controller = new AbortController();
  const myHeaders = new Headers();
  myHeaders.append("Content-Type", "application/json");
  myHeaders.append(
    "Authorization",
    "Basic YmlsaW5ndWFsOkxyZnogcUhuSyBwU1ZBIGl6SlIgSWd5SCAxR3d5"
  );

  const requestOptions = {
    method: method,
    headers: myHeaders,
    redirect: "follow",
    signal: controller.signal,
  };
  if (method !== "GET" && method !== "HEAD") {
    // For methods other than GET and HEAD, include the body in the request.
    requestOptions.body = JSON.stringify(body);
  }
  const result = await fetch(
    `https://acuarelaadmin.bilingualchildcaretraining.com/wp-json/wp/v2/${endpoint}`,
    requestOptions
  ).then((res) => res.json());

  return { result, controller }; // Optional: You can return the result if needed.
}

if (document.querySelector("#wizard-container")) {
  const stepsData = [
    {
      title: "Información del Daycare",
      fields: [
        "Nombre",
        "Acerca-daycare",
        "Mision",
        "Vision",
        "Filosofia-educacion",
        "Servicios",
      ],
    },
    {
      title: "Contacto",
      fields: ["Whatsapp", "Direccion", "Correo-electronico", "Redes-sociales"],
    },
    {
      title: "Imágenes",
      fields: ["Logo", "Fotos-Daycare", "Foto-portada"],
    },
  ];

  // Seleccionar el contenedor del wizard una vez
  const wizardContainer = document.getElementById("wizard-container");

  document.addEventListener("DOMContentLoaded", function () {
    if (wizardContainer) {
      tinymce.init({
        selector:
          "#acerca-daycare, #mision, #vision, #filosofia-educacion, #servicios",
        //plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste autocorrect a11ychecker typography inlinecss',
        toolbar:
          "undo redo | blocks | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat",
        tinycomments_mode: "embedded",
        tinycomments_author: "Author name",
      });
    }
  });

  initWizard();
}

// POP UP PROFILE

document.addEventListener("DOMContentLoaded", function () {
  var preloader = document.querySelector(".preloader h2");
  if (preloader) {
    preloader.innerHTML = "";
    if (!document.querySelector(".curriculumcontent")) {
      $(".preloader").fadeOut("slow");
    }
  }

  var openPopupLink = document.getElementById("openPopup");
  var closePopupButton = document.getElementById("closePopup");
  var popupCompleteDaycare = document.getElementById("popupCompleteDaycare");
  var mainContent = document.querySelector("main");

  // Mostrar el popup
  function showPopup() {
    popupCompleteDaycare.style.maxHeight = "1000px";
    popupCompleteDaycare.style.opacity = "1";
    popupCompleteDaycare.style.display = "flex";
    popupCompleteDaycare.style.marginBottom = "60px";
  }
  // Ocultar el popup
  function hidePopup() {
    popupCompleteDaycare.style.maxHeight = "0";
    popupCompleteDaycare.style.opacity = "0";
    popupCompleteDaycare.style.display = "none";
    popupCompleteDaycare.style.marginBottom = "0px";
  }
  if (openPopupLink) {
    // Click en el enlace para abrir el popup
    openPopupLink.addEventListener("click", function () {
      showPopup();
    });
  }
  if (closePopupButton) {
    // Click en el botón para cerrar el popup
    closePopupButton.addEventListener("click", function () {
      hidePopup();
    });
  }
});

//POPUP REFERIDOS

//POPUP REFERIDOS

const linkOpenModal1 = document.querySelector("#link-open-modal-1");
const btnCloseModal = document.querySelector("#btn-close-modal");
const modal = document.querySelector("#popupInvitacion");

if (linkOpenModal1) {
  linkOpenModal1.addEventListener("click", () => {
    modal.showModal();
  });
}

if (btnCloseModal) {
  btnCloseModal.addEventListener("click", () => {
    modal.close();
  });
}

if (
  document.querySelector(".services-table") ||
  document.querySelector(".suscription_page")
) {
  getAllServices();
}

const copiarBtn = document.getElementById("copiar-codigo");
if (copiarBtn) {
  copiarBtn.addEventListener("click", function () {
    const codigo = document.getElementById("codigo-referido").innerText;
    navigator.clipboard.writeText(codigo).then(() => {
      alert("Código copiado al portapapeles");
    });
  });
}

// Validar si el botón de compartir por WhatsApp existe
const whatsappButton = document.getElementById("compartir-whatsapp");
if (whatsappButton) {
  whatsappButton.addEventListener("click", function () {
    const codigo = document.getElementById("codigo-referido").innerText;
    const message = `¡Hola! Usa mi código de referido ${codigo} para obtener $10 de descuento en tu primera compra en BCCT.`;
    const whatsappURL = `https://wa.me/?text=${encodeURIComponent(message)}`;
    window.open(whatsappURL, "_blank");
  });
} else {
  console.warn("Botón de compartir por WhatsApp no encontrado.");
}

// Validar si el botón de compartir por email existe
const emailButton = document.getElementById("compartir-email");
if (emailButton) {
  emailButton.addEventListener("click", function () {
    const codigo = document.getElementById("codigo-referido").innerText;
    const subject =
      "¡Obtén $10 de descuento en BCCT con mi código de referido!";
    const body = `¡Hola! Usa mi código de referido ${codigo} para obtener $10 de descuento en tu primera compra en BCCT.`;
    const mailtoURL = `mailto:?subject=${encodeURIComponent(
      subject
    )}&body=${encodeURIComponent(body)}`;
    window.open(mailtoURL, "_blank");
  });
} else {
  console.warn("Botón de compartir por email no encontrado.");
}

//POPUP CREAR DAYCARE

function limpiarValores() {
  // Limpiar los valores de los inputs
  daycareValue = "";
  phoneValue = "";
  emailValue = "";
  licenseValue = "";
  expirationValue = "";
}

const btnOpenModalD = document.querySelector("#btn-open-daycare");
const btnCloseModalD = document.querySelector("#btn-close-daycare");
const modalD = document.querySelector("#popupDaycare");
if (btnOpenModalD) {
  btnOpenModalD.addEventListener("click", () => {
    limpiarValores();
    modalD.showModal();
  });
  btnCloseModalD.addEventListener("click", () => {
    modalD.close();
  });
}

//VALIDAR CAMPO EMAIL

function validarEmail(email) {
  // Expresión regular para validar la dirección de correo electrónico
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
}
document.addEventListener("DOMContentLoaded", function () {
  const emailField = document.getElementById("emaildaycare");
  const errorField = document.getElementById("emailError");

  if (emailField && errorField) {
    // Función para manejar el evento de cambio en el campo de correo electrónico
    emailField.addEventListener("change", function (event) {
      // Agregar la clase "loading" al elemento padre
      event.target.parentElement.classList.add("loading");
      // Obtener el valor del campo de correo electrónico
      const emailValue = this.value;
      // Validar el correo electrónico
      if (!validarEmail(emailValue)) {
        event.target.parentElement.classList.remove("loading");
        // Mostrar el mensaje de error si la dirección de correo electrónico no es válida
        errorField.style.display = "inline";
      } else {
        event.target.parentElement.classList.remove("loading");
        // Ocultar el mensaje de error si la dirección de correo electrónico es válida
        errorField.style.display = "none";
      }
    });
  }
});

//VALIDAR QUE LA LICENCIA NO EXISTA

async function validateLicenseExist(event) {
  document.getElementById("licencia-existente").style.display = "none";
  event.target.parentElement.classList.add("loading");
  try {
    const licenseValue = event.target.value; // Cambiar el nombre de la variable
    if (licenseValue != "") {
      const responseLicense = await validateLicenseStrapi(licenseValue);
      if (responseLicense.length > 0) {
        document.getElementById("licencia-existente").style.display = "block";
      }
    }
    event.target.parentElement.classList.remove("loading");
  } catch (error) {
    console.error("Error occurred while validating email:", error.message);
  }
}

async function validateLicenseStrapi(license) {
  try {
    const url = `g/licenseValidation/?license=${license}`;
    const response = await fetch(url);
    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error occurred while fetching data:", error.message);
    throw error;
  }
}

//VALIDAR QUE LOS CAMPOS ESTÉN COMPLETOS

function validateDaycare(event) {
  event.target.parentElement.classList.add("loading");
  document.getElementById("mensajeAlerta").style.display = "none";

  // Obtener los valores de los inputs
  var daycareValue = document.getElementById("daycare").value;
  var phoneValue = document.getElementById("phonedaycare").value;
  var emailValue = document.getElementById("emaildaycare").value;
  var licenseValue = document.getElementById("license").value;
  var expirationValue = document.getElementById("expiration").value;
  var stateValue = document.getElementById("state").value;
  var idLogoValue = document.getElementById("photoID").value;

  // Verificar si algún campo está vacío
  if (
    daycareValue === "" ||
    phoneValue === "" ||
    emailValue === "" ||
    licenseValue === "" ||
    expirationValue === "" ||
    stateValue === ""
  ) {
    event.target.parentElement.classList.remove("loading");
    // Mostrar mensaje de error
    document.getElementById("mensajeAlerta").style.display = "block";
  } else {
    validateDaycareName(event);
  }
}

//VALIDAR NOMBRE DEL DAYCARE

async function validateDaycareName(event) {
  event.target.parentElement.classList.add("loading");
  try {
    const daycareName =
      event.target.parentElement.querySelector("#daycare").value;
    const daycareState = document.getElementById("state").value;
    const checkboxDaycareName = document.getElementById("consentimiento");

    if (daycareName != "" && daycareState != "") {
      const responseName = await validateDaycareNameStrapi(
        daycareName,
        daycareState
      );
      if (
        responseName &&
        responseName.length > 0 &&
        responseName[0].length > 0
      ) {
        document.getElementById("estadoDaycare").innerText =
          "Estos son los nombres ya existentes en el estado de " + daycareState;

        // Mostrar la advertencia de nombre similar
        document.getElementById("nombre-similar").style.display = "flex";
        document.getElementById("nombre-similar").style.flexDirection =
          "column";
        document.getElementById("nombre-similar").style.gap = "5px";

        // Limpiar el contenido del div daycaresSimilares
        const daycaresSimilaresDiv =
          document.querySelector(".daycaresSimilares");
        daycaresSimilaresDiv.innerHTML = "";

        // Crear una lista ul
        const ul = document.createElement("ul");

        // Iterar sobre cada array interior en responseName
        responseName.forEach((response) => {
          // Iterar sobre cada objeto daycare en el array interior
          response.forEach((daycare) => {
            // Verificar si el objeto daycare tiene la propiedad "name"
            if (daycare.hasOwnProperty("name")) {
              // Imprimir el nombre del daycare en la consola junto con el texto "nombre:"

              // Agregar el nombre del daycare como un elemento de lista
              const li = document.createElement("li");
              li.textContent = daycare.name;
              ul.appendChild(li);
            }
          });
        });
        // Agrega la lista al div daycaresSimilares
        daycaresSimilaresDiv.appendChild(ul);
      } else {
        document.getElementById("nombre-similar").style.display = "none";

        try {
          await setNewDaycareStrapi();
        } catch (error) {
          console.error("Error al crear el daycare:", error.message);
        }
      }
    }
    if (checkboxDaycareName.checked) {
      document.getElementById("nombre-similar").style.display = "none";
      checkboxDaycareName.checked = false;
      try {
        await setNewDaycareStrapi();
      } catch (error) {
        console.error("Error al crear el daycare (por checkbox):", error.message);
      }
    }
    event.target.parentElement.classList.remove("loading");
  } catch (error) {
    console.error(
      "Error occurred while validating daycare name:",
      error.message
    );
  }
}

async function validateDaycareNameStrapi(daycareName, daycareState) {
  try {
    // Lista de pronombres, artículos y conjunciones en inglés y español
    const palabrasNoDeseadas = [
      "the",
      "a",
      "an",
      "and",
      "or",
      "but",
      "for",
      "nor",
      "so",
      "it",
      "they",
      "you",
      "yo",
      "tú",
      "él",
      "nosotros",
      "vosotros",
      "ellos",
      "el",
      "la",
      "los",
      "las",
      "un",
      "una",
      "unos",
      "unas",
      "y",
      "o",
      "pero",
      "ni",
      "por",
      "para",
      "que",
      "de",
    ];

    // Divide el nombre del daycare en palabras
    const daycareNameWords = daycareName.split(" ");

    // Inicializa un array para almacenar las respuestas de cada palabra
    const responses = [];

    // Itera sobre cada palabra del nombre del daycare
    for (const word of daycareNameWords) {
      // Verifica si la palabra no deseada está en la lista
      if (!palabrasNoDeseadas.includes(word.toLowerCase())) {
        // Construye la URL con la palabra actual y el estado del daycare
        const url = `g/daycareNameValidation/?daycareName[]=${word}&daycareState=${daycareState}`;
        console.log("URL generada: ", url);

        const response = await fetch(url);

        if (!response.ok) {
          console.error(`Error en la petición: ${response.status}`);
          continue;
        }

        const text = await response.text();

        if (text.trim() === "") {
          console.warn("Respuesta vacía para:", word);
          continue; 
        }

        const data = JSON.parse(text);

        // Almacena la respuesta en el array de respuestas
        responses.push(data);
      }
    }

    // Retorna el array de respuestas
    return responses;
  } catch (error) {
    console.error("Error occurred while fetching data:", error.message);
    throw error;
  }
}

async function setNewDaycareStrapi() {
  document.querySelector(".preloader h2").innerHTML =
    "Estamos agregando tu nuevo daycare...";
  document.getElementById("preloaderDaycare").style.display = "flex";

  let bilingualID = document.getElementById("bilingualIDUser").value;

  var formData = new FormData();
  formData.append("daycare", document.getElementById("daycare").value);
  formData.append("phone", document.getElementById("phonedaycare").value);
  formData.append("email", document.getElementById("emaildaycare").value);
  formData.append("license", document.getElementById("license").value);
  formData.append("expiration", document.getElementById("expiration").value);
  formData.append("state", document.getElementById("state").value);
  formData.append("name", document.getElementById("nameUser").value);
  formData.append("lastname", document.getElementById("lastnameUser").value);
  formData.append("logoID", document.getElementById("photoID").value);
  formData.append(
    "bilingualID",
    document.getElementById("bilingualIDUser").value
  );

  try {
    const response = await fetch("s/createDaycare/", {
      method: "POST",
      body: formData,
    });
    const data = await response.json();
    //window.location.reload();
    //data.response.status == 200
    // console.log("Respuesta del backend: ", data);
    if (
      data.response &&
      Array.isArray(data.response.data) &&
      data.response.data.length > 0 &&
      data.response.data[0].status === "success"
    ) {
      trackAddNewDaycare(bilingualID);
      window.location.href = `/miembros/s/reload/?bilingualID=${bilingualID}`;
    }
    return data;
  } catch (error) {
    console.error("Error occurred while fetching data:", error.message);
    throw error;
  }
}

//Aside menu curriculums
console.log("Script main.js cargado - sección aside curriculum");

// Función que se ejecuta cuando el DOM está listo
function initAsideCurriculum() {
  console.log("initAsideCurriculum ejecutándose");
  const asideElement = document.getElementById("aside-curriculum");
  const main = document.querySelector(".main-curriculum");
  const fabButton = document.getElementById("fab");
  const fabIcon = document.getElementById("fab-icon");

  if (!asideElement) {
    console.warn("aside-curriculum element not found");
    return;
  }

  if (!main) {
    console.warn("main-curriculum element not found");
    return;
  }

  if (fabButton && fabIcon) {
    fabButton.addEventListener("click", function () {
      if (asideElement) {
        asideElement.classList.toggle("responsive");
        fabButton.classList.toggle("open");

        // Change the icon with animation
        if (fabButton.classList.contains("open")) {
          fabIcon.classList.remove("acuarela-Menu");
          fabIcon.classList.add("acuarela-Cancelar");
          fabIcon.classList.remove("menu");
          fabIcon.classList.add("cancel");
        } else {
          fabIcon.classList.remove("acuarela-Cancelar");
          fabIcon.classList.add("acuarela-Menu");
          fabIcon.classList.remove("cancel");
          fabIcon.classList.add("menu");
        }
      }
    });
  }

  // Función para inicializar los diálogos del aside
  function initAsideDialogs() {
    console.log("initAsideDialogs ejecutándose");
    if (!asideElement || !main) {
      console.warn("Aside element or main element not found", { asideElement, main });
      return;
    }

    const ids = [
      "planeacion",
      "lista",
      "temas_mes",
      "material_adicional",
      "actividades_gratis",
    ];
    
    console.log("IDs a procesar:", ids);

    // Usar delegación de eventos en el contenedor padre (método principal)
    const iconsContainer = asideElement.querySelector(".icons");
    console.log("iconsContainer encontrado:", !!iconsContainer);
    
    if (iconsContainer && !iconsContainer.dataset.delegationAdded) {
      console.log("Agregando delegación de eventos a iconsContainer");
      iconsContainer.addEventListener("click", function (e) {
        console.log("Click detectado en iconsContainer, target:", e.target);
        const clickedItem = e.target.closest("li[id]");
        console.log("clickedItem encontrado:", clickedItem ? clickedItem.id : null);
        
        if (clickedItem && ids.includes(clickedItem.id)) {
          const id = clickedItem.id;
          const dialogId = `aside-dialog-${id}`;
          const dialog = document.getElementById(dialogId);
          
          console.log(`Intentando abrir diálogo: ${dialogId}`, { dialog: !!dialog });
          
          if (dialog) {
            e.stopPropagation();
            console.log(`Click detected via delegation on item: ${id}`);
            
            // Función para abrir el diálogo
            function openDialog() {
              console.log(`Abriendo diálogo: ${dialogId}`);
              // Mostrar el diálogo usando jQuery si está disponible, sino usar vanilla JS
              if (typeof $ !== 'undefined' && $.fn.fadeIn) {
                console.log("Usando jQuery fadeIn");
                $(dialog).fadeIn(300);
              } else {
                console.log("Usando vanilla JS para mostrar diálogo");
                dialog.style.display = "block";
                dialog.style.opacity = "0";
                setTimeout(() => {
                  dialog.style.transition = "opacity 0.3s";
                  dialog.style.opacity = "1";
                }, 10);
              }

              asideElement.classList.add("no-hover");
              main.classList.add("background");
            }
            
            openDialog();
          } else {
            console.error(`Diálogo ${dialogId} no encontrado`);
          }
        }
      });
      iconsContainer.dataset.delegationAdded = "true";
      console.log("Delegación de eventos agregada correctamente");
    } else if (iconsContainer && iconsContainer.dataset.delegationAdded) {
      console.log("Delegación de eventos ya estaba agregada");
    }

    ids.forEach((id) => {
      const item = document.getElementById(id);
      const dialogId = `aside-dialog-${id}`;
      const dialog = document.getElementById(dialogId);

      console.log(`Procesando ${id}:`, { item: !!item, dialog: !!dialog });

      if (!item) {
        // Solo mostrar warning si el elemento debería existir (no para actividades_gratis que está comentado)
        if (id !== "actividades_gratis") {
          console.warn(`Item with id "${id}" not found`);
        }
        return;
      }

      if (!dialog) {
        if (id !== "actividades_gratis") {
          console.warn(`Dialog with id "${dialogId}" not found`);
        }
        return;
      }

      // Buscar el botón de cerrar dentro del diálogo
      const closeDialog = dialog.querySelector(".acuarela-Cancelar");
      if (!closeDialog) {
        console.warn(`Close button not found in dialog "${dialogId}"`);
        return;
      }

      // Verificar si ya tiene event listeners (evitar duplicados)
      if (item.dataset.listenerAdded === "true") {
        return;
      }

      // Asegurarse de que el diálogo esté oculto inicialmente
      if (dialog.style.display !== "none" && !dialog.classList.contains("hidden")) {
        dialog.style.display = "none";
      }

      // Función para abrir el diálogo
      function openDialog() {
        // Mostrar el diálogo usando jQuery si está disponible, sino usar vanilla JS
        if (typeof $ !== 'undefined' && $.fn.fadeIn) {
          $(dialog).fadeIn(300);
        } else {
          dialog.style.display = "block";
          dialog.style.opacity = "0";
          setTimeout(() => {
            dialog.style.transition = "opacity 0.3s";
            dialog.style.opacity = "1";
          }, 10);
        }

        // Add no-hover class to aside
        asideElement.classList.add("no-hover");

        // Add background class to main
        main.classList.add("background");
      }

      // Función para cerrar el diálogo
      function closeDialogFunc() {
        // Ocultar el diálogo usando jQuery si está disponible, sino usar vanilla JS
        if (typeof $ !== 'undefined' && $.fn.fadeOut) {
          $(dialog).fadeOut("fast", function () {
            asideElement.classList.remove("no-hover");
            main.classList.remove("background");
          });
        } else {
          dialog.style.transition = "opacity 0.3s";
          dialog.style.opacity = "0";
          setTimeout(() => {
            dialog.style.display = "none";
            asideElement.classList.remove("no-hover");
            main.classList.remove("background");
          }, 300);
        }
      }

      // Agregar event listener al item (li)
      item.addEventListener("click", function (e) {
        e.stopPropagation();
        console.log(`Click detected on item: ${id}`);
        openDialog();
      });

      // También agregar listener usando delegación de eventos como respaldo
      item.style.cursor = "pointer";
      item.setAttribute("role", "button");
      item.setAttribute("tabindex", "0");
      
      // Permitir activación con Enter/Space
      item.addEventListener("keydown", function (e) {
        if (e.key === "Enter" || e.key === " ") {
          e.preventDefault();
          e.stopPropagation();
          openDialog();
        }
      });

      // Agregar event listener al botón de cerrar
      closeDialog.addEventListener("click", function (e) {
        e.stopPropagation();
        closeDialogFunc();
      });

      // Cerrar al hacer clic fuera del diálogo (solo en el fondo, no en el contenido)
      dialog.addEventListener("click", function (e) {
        if (e.target === dialog) {
          closeDialogFunc();
        }
      });

      // Marcar que los listeners ya fueron agregados
      item.dataset.listenerAdded = "true";
    });
  }

  // Inicializar los diálogos
  initAsideDialogs();

  // Re-inicializar después de un pequeño delay para asegurar que todo esté cargado
  // Esto es útil si el contenido se carga dinámicamente
  setTimeout(() => {
    initAsideDialogs();
  }, 500);
}

// Ejecutar la función cuando el DOM esté listo o inmediatamente si ya lo está
console.log("Verificando estado del DOM:", document.readyState);

// Función wrapper con manejo de errores
function tryInitAsideCurriculum() {
  try {
    console.log("Intentando ejecutar initAsideCurriculum");
    initAsideCurriculum();
  } catch (error) {
    console.error("Error al ejecutar initAsideCurriculum:", error);
  }
}

if (document.readyState === 'loading') {
  // El DOM aún no está completamente cargado
  console.log("DOM aún cargando, esperando DOMContentLoaded");
  document.addEventListener('DOMContentLoaded', function() {
    console.log("DOMContentLoaded disparado, ejecutando initAsideCurriculum");
    tryInitAsideCurriculum();
  });
} else {
  // El DOM ya está cargado, ejecutar inmediatamente
  console.log("DOM ya está cargado, ejecutando initAsideCurriculum inmediatamente");
  // Usar setTimeout para asegurar que todos los elementos estén disponibles
  setTimeout(function() {
    tryInitAsideCurriculum();
  }, 100);
}

// También intentar ejecutar después de un delay adicional como respaldo
setTimeout(function() {
  console.log("Ejecutando initAsideCurriculum como respaldo después de 1 segundo");
  tryInitAsideCurriculum();
}, 1000);

// Inscripción de niños
// Selecciona el botón y el formulario pop-up
const openFormButton = document.getElementById("addKid");
const popupForm = document.getElementById("popupFormAddKid");
const closeFormButton = document.getElementById("closeFormButton");

if (popupForm) {
  // Muestra el formulario cuando se hace clic en el botón
  openFormButton.onclick = function () {
    popupForm.style.display = "block";
  };

  // Oculta el formulario cuando se hace clic en el botón de cerrar
  closeFormButton.onclick = function () {
    popupForm.style.display = "none";
  };

  // Oculta el formulario cuando se hace clic fuera del formulario
  window.onclick = function (event) {
    if (event.target == popupForm) {
      popupForm.style.display = "none";
    }
  };
}

// Cancelar suscripcion Paypal
function confirmCancelSubscription(paypalId, subscriptionId) {
  // Verificar si el modal existe, si no, crearlo dinámicamente
  var modal = document.getElementById("cancelModalPaypal");
  
  if (!modal) {
    // Crear el modal dinámicamente
    modal = document.createElement("div");
    modal.id = "cancelModalPaypal";
    modal.style.display = "none";
    modal.style.position = "fixed";
    modal.style.zIndex = "10000";
    modal.style.left = "0";
    modal.style.top = "0";
    modal.style.width = "100%";
    modal.style.height = "100%";
    modal.style.overflow = "auto";
    modal.style.backgroundColor = "rgba(0,0,0,0.4)";
    
    modal.innerHTML = `
      <div style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
          <h2 style="margin: 0; color: #333;">Cancelar Suscripción</h2>
          <span id="closeModal" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; line-height: 20px;">&times;</span>
        </div>
        <p style="margin-bottom: 20px; color: #666;">¿Estás seguro de que deseas cancelar esta suscripción?</p>
        <div id="cancelMessage" style="display: none; padding: 10px; margin-bottom: 15px; background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 4px; color: #856404;"></div>
        <div style="display: flex; gap: 10px; justify-content: flex-end;">
          <button id="btnCancelarPaypal" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
          <button id="confirmCancel" style="padding: 10px 20px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">Confirmar Cancelación</button>
        </div>
      </div>
    `;
    
    document.body.appendChild(modal);
  }

  // Mostrar el modal
  modal.style.display = "block";

  // Obtener los elementos del modal
  var confirmButton = document.getElementById("confirmCancel");
  var cancelMessage = document.getElementById("cancelMessage");
  var closeButton = document.getElementById("closeModal");
  var span = document.getElementById("btnCancelarPaypal");

  // Limpiar eventos anteriores para evitar duplicados
  var newConfirmButton = confirmButton.cloneNode(true);
  confirmButton.parentNode.replaceChild(newConfirmButton, confirmButton);
  confirmButton = newConfirmButton;

  // Configurar el evento del botón de confirmación
  confirmButton.onclick = function () {
    // Ocultar el botón de cerrar
    if (closeButton) {
      closeButton.style.display = "none";
    }
    if (span) {
      span.style.display = "none";
    }

    // Cambiar el texto del botón de confirmación a "Cancelando"
    confirmButton.textContent = "Cancelando";
    confirmButton.style.backgroundColor = "#f0ad4e";
    confirmButton.style.borderColor = "#f0ad4e";
    confirmButton.disabled = true;

    // Mostrar el mensaje debajo del botón de confirmación
    if (cancelMessage) {
      cancelMessage.style.display = "block";
      cancelMessage.textContent = "Procesando cancelación...";
    }

    // Hacer la solicitud POST al PHP intermediario
    fetch("/miembros/s/cancelSuscription/", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        paypal_id: paypalId,
        subscription_id: subscriptionId,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        confirmButton.textContent = "Cancelado";
        confirmButton.style.backgroundColor = "#5cb85c";
        confirmButton.style.borderColor = "#5cb85c";
        confirmButton.style.color = "white";
        
        if (cancelMessage) {
          cancelMessage.style.display = "block";
          cancelMessage.style.backgroundColor = "#d4edda";
          cancelMessage.style.borderColor = "#c3e6cb";
          cancelMessage.style.color = "#155724";
          cancelMessage.textContent = "Suscripción cancelada exitosamente.";
        }

        // Redirigir a otra página después de un breve retraso
        setTimeout(function () {
          window.location.reload();
          localStorage.removeItem("suscriptions");
          localStorage.removeItem("daycare_name");
          localStorage.removeItem("daycare_id");
        }, 2000);
      })
      .catch((error) => {
        console.error("Error:", error);
        // Restaurar el estado original de los botones en caso de error
        if (closeButton) {
          closeButton.style.display = "block";
        }
        if (span) {
          span.style.display = "block";
        }
        confirmButton.textContent = "Confirmar Cancelación";
        confirmButton.style.backgroundColor = "#dc3545";
        confirmButton.style.borderColor = "#dc3545";
        confirmButton.style.color = "white";
        confirmButton.disabled = false;
        if (cancelMessage) {
          cancelMessage.style.display = "block";
          cancelMessage.style.backgroundColor = "#f8d7da";
          cancelMessage.style.borderColor = "#f5c6cb";
          cancelMessage.style.color = "#721c24";
          cancelMessage.textContent = "Error al cancelar la suscripción. Por favor, intenta nuevamente.";
        }
      });
  };

  // Configurar el botón de cierre
  if (closeButton) {
    var newCloseButton = closeButton.cloneNode(true);
    closeButton.parentNode.replaceChild(newCloseButton, closeButton);
    closeButton = newCloseButton;
    
    closeButton.onclick = function () {
      modal.style.display = "none";
      if (cancelMessage) {
        cancelMessage.style.display = "none";
      }
    };
  }

  // Configurar el span que cierra el modal
  if (span) {
    var newSpan = span.cloneNode(true);
    span.parentNode.replaceChild(newSpan, span);
    span = newSpan;
    
    span.onclick = function () {
      modal.style.display = "none";
      if (cancelMessage) {
        cancelMessage.style.display = "none";
      }
    };
  }

  // Cerrar el modal si se hace clic fuera del contenido
  var existingOnClick = window.onclick;
  modal.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
      if (cancelMessage) {
        cancelMessage.style.display = "none";
      }
    }
  };
}

//Foto del daycare
if (document.getElementById("photo")) {
  document
    .getElementById("photo")
    .addEventListener("change", async function (event) {
      const wrapper = document.querySelector(".wrapper.photo");
      const container = document.getElementById("photo-container");

      const nextButton = document.getElementById("nextButton");
      const createAccountButton = document.getElementById("createAccount");

      const addDaycare = document.getElementById("addDaycare");

      if (nextButton) {
        nextButton.disabled = true;
      }

      if (createAccountButton) {
        createAccountButton.disabled = true;
      }

      if (addDaycare) {
        addDaycare.disabled = true;
      }

      wrapper.classList.add("loading");

      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.readAsDataURL(file);

        // Upload image to the server
        try {
          let formData = new FormData();
          formData.append("files", file, file.name);

          const response = await fetch("https://acuarelacore.com/api/upload/", {
            method: "POST",
            body: formData,
          });

          if (!response.ok) {
            console.error(
              "Respuesta del servidor no OK:",
              response.status,
              response.statusText
            );
            throw new Error("Network response was not ok");
          }

          const result = await response.json();

          document.querySelector("#photoID").value = result[0].id;

          container.style.display = "block";
          container.style.backgroundImage = `url(https://acuarelacore.com/api${result[0].url})`;

          // Añadir el botón de eliminar foto
          const deleteButton = document.createElement("button");
          deleteButton.innerHTML = "X";
          deleteButton.classList.add("delete-button");
          deleteButton.onclick = function () {
            // Limpiar la imagen y el input photoID
            container.style.backgroundImage = "none";
            document.querySelector("#photoID").value = "";

            // Eliminar el botón de eliminar xd
            deleteButton.remove();

            // Desactivar botones de navegación
            if (nextButton) {
              nextButton.disabled = true;
            }

            if (createAccountButton) {
              createAccountButton.disabled = true;
            }

            if (addDaycare) {
              addDaycare.disabled = true;
            }

            // Eliminar clase "loading" si estaba
            wrapper.classList.remove("loading");
          };

          // Agregar el botón al contenedor de la imagen
          container.appendChild(deleteButton);

          wrapper.classList.remove("loading");

          if (nextButton) {
            nextButton.disabled = false;
          }

          if (createAccountButton) {
            createAccountButton.disabled = false;
          }

          if (addDaycare) {
            addDaycare.disabled = false;
          }

          const photoInput = document.getElementById("photo");
          photoInput.removeAttribute("name");
        } catch (error) {
          console.error(
            "Error occurred while making network request:",
            error.message
          );
          console.error("Detalles del error:", error);
        }
      } else {
        console.log("No se seleccionó ningún archivo.");
      }
    });
} else {
  console.log("Elemento 'photo' no encontrado.");
}

// Asegurarse de que solo se envíe `photoID` y no el archivo
const registerForm = document.getElementById("register");

if (registerForm) {
  registerForm.addEventListener("submit", function (event) {
    const photoInput = document.getElementById("photo");
    if (photoInput) {
      photoInput.removeAttribute("name");
    }
  });
}
// Validar fecha de nacimiento

const birthdateInput = document.getElementById("birthdate");
const birthdateError = document.getElementById("birthdate-error");

const setBirthdateLimits = () => {
    if (!birthdateInput) return;
    const today = new Date();
    const maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
    birthdateInput.max = maxDate.toISOString().split("T")[0];
    birthdateInput.min = "1900-01-01";
};

const isAdult = (dateValue) => {
        const dob = new Date(dateValue);
        if (Number.isNaN(dob.getTime())) {
            return false;
        }
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        return age >= 18;
};

const validateBirthdate = () => {
        if (!birthdateInput || !birthdateError) return true;
        if (!birthdateInput.value) {
            birthdateError.style.display = "none";
            return false;
        }
        const adult = isAdult(birthdateInput.value);
        birthdateError.style.display = adult ? "none" : "block";
        return adult;
};

setBirthdateLimits();

if (birthdateInput) {
    birthdateInput.addEventListener("change", validateBirthdate);
}
if (registerForm) {
    registerForm.addEventListener("submit", function (event) {
        if (!validateBirthdate()) {
            event.preventDefault();
            birthdateInput.focus();
        }
    });
}

function toggleButton() {
  const repeatInput = document.getElementById("repeat").value;
  const nextButton = document.getElementById("nextButton");

  if (repeatInput.trim() !== "") {
    nextButton.removeAttribute("disabled");
  } else {
    nextButton.setAttribute("disabled", "disabled");
  }
}
// Disclaimer cookies
function acceptCookies() {
  const modalOverlay = document.getElementById("cookie-modal-overlay");
  if (modalOverlay) {
    localStorage.setItem(
      "cookies-preferences",
      JSON.stringify({
        essential: true,
        analytics: true,
        marketing: true,
      })
    );
    modalOverlay.style.display = "none";
  }
}

function rejectCookies() {
  const modalOverlay = document.getElementById("cookie-modal-overlay");
  if (modalOverlay) {
    localStorage.setItem(
      "cookies-preferences",
      JSON.stringify({
        essential: true,
        analytics: false,
        marketing: false,
      })
    );
    modalOverlay.style.display = "none";
  }
}

function openConfig() {
  const configModal = document.getElementById("cookie-config-modal");
  const mainModal = document.getElementById("cookie-modal-overlay");
  if (configModal && mainModal) {
    mainModal.style.display = "none";
    configModal.style.display = "flex";

    // Prellenar si hay valores guardados
    const prefs = JSON.parse(
      localStorage.getItem("cookies-preferences") || "{}"
    );
    if (prefs.analytics)
      document.querySelector('[name="analytics"]').checked = true;
    if (prefs.marketing)
      document.querySelector('[name="marketing"]').checked = true;
  }
}

function closeConfig() {
  const configModal = document.getElementById("cookie-config-modal");
  const mainModal = document.getElementById("cookie-modal-overlay");
  if (configModal && mainModal) {
    configModal.style.display = "none";
    mainModal.style.display = "flex";
  }
}

function savePreferences() {
  const form = document.getElementById("cookie-preferences-form");
  const prefs = {
    essential: true,
    analytics: form.analytics.checked,
    marketing: form.marketing.checked,
  };
  localStorage.setItem("cookies-preferences", JSON.stringify(prefs));

  const configModal = document.getElementById("cookie-config-modal");
  if (configModal) configModal.style.display = "none";
}

document.addEventListener("DOMContentLoaded", function () {
  const checkboxes = document.querySelectorAll(
    '#cookie-preferences-form input[type="checkbox"]'
  );

  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
      this.classList.remove("bounce");
      void this.offsetWidth;
      this.classList.add("bounce");
    });
  });
});

window.onload = function () {
  const modalOverlay = document.getElementById("cookie-modal-overlay");
  const preferences = localStorage.getItem("cookies-preferences");
  if (!preferences && modalOverlay) {
    modalOverlay.style.display = "flex";
  }
};
