let getAgeGroups; // Declara la variable fuera del bloque para que sea accesible después del bloque if
let menusInSub;

// Mapeo de identificadores a nombres
let ageGroupMapping = {
  "61eecb9e0cde4b171de1db57": "Infants",
  "61eecb950cde4b171de1db56": "Toddlers",
  "61eecb7d0cde4b171de1db55": "+2 años",
};
/*$(".useroptions").click(function () {
  $(this).toggleClass("open");
});*/
function getTipoMenuContent(data) {
  // Verificar si hay datos para el tipo de comida actual
  if (data.length > 0) {
    // Procesar la información solo si hay datos
    data.forEach((menu) => {
      // Obtén el contenido HTML de la propiedad 'content'
      let contentHTML = menu.content;

      // Crea un elemento div temporal para manipular el contenido HTML
      let tempDiv = document.createElement("div");
      tempDiv.innerHTML = contentHTML;

      // Crea un objeto para almacenar la información deseada
      let result = {};

      // Definir el orden de los días de la semana
      const orderOfDays = ["lunes", "martes", "miércoles", "jueves", "viernes"];

      // Itera sobre los elementos <li>
      tempDiv.querySelectorAll("li").forEach((li) => {
        // Obtiene el nombre del día de la semana
        let dayElement = li.querySelector("p");
        let dayOfWeek = dayElement ? dayElement.innerText.trim() : "Sin día";

        // Obtiene el contenido del <ul> dentro de <li>, si existe
        let ulElement = li.querySelector("ul");
        if (ulElement) {
          let ulContent = ulElement.innerHTML;
          // Almacena la información en el objeto result
          result[dayOfWeek] = `<ul>${ulContent}</ul>`;
        } else {
          // Si no hay elemento <ul>, asume que el contenido es directamente de un <li>
          let liContent = li.innerHTML;
          result[dayOfWeek] = `<ul>${liContent}</ul>`;
        }
      });

      // Agregar "Sin día" al resultado y ordenar según el orden definido
      orderOfDays.forEach((day) => {
        if (!result[day] && result["Sin día"]) {
          result[day] = result["Sin día"];
        }
      });
    });
  }
}
// Función para separar por días
function separarPorDias(comidas) {
  const dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];

  // Objeto resultante con días y contenido correspondiente
  const resultado = {};

  // Iterar sobre los días
  dias.forEach((dia) => {
    resultado[dia] = {
      desayuno: comidas.desayuno.replace(
        /<p>([^<]+)<\/p>/g,
        `<p>${dia}: $1</p>`
      ),
      snackAM: comidas.snackAM.replace(/<p>([^<]+)<\/p>/g, `<p>${dia}: $1</p>`),
      almuerzo: comidas.almuerzo.replace(
        /<p>([^<]+)<\/p>/g,
        `<p>${dia}: $1</p>`
      ),
      cena: comidas.cena.replace(/<p>([^<]+)<\/p>/g, `<p>${dia}: $1</p>`),
    };
  });

  return resultado;
}
function getFecha(menucreado) {
  // Fecha proporcionada
  const fechaAccion = menucreado.creation_date;

  // Crear un objeto Date con la fecha proporcionada
  const fechaAccionObj = new Date(fechaAccion);

  // Obtener la fecha actual
  const fechaActualObj = new Date();

  // Calcular la diferencia entre las fechas en milisegundos
  const diferenciaMilisegundos = fechaActualObj - fechaAccionObj;

  // Calcular la diferencia en días
  const diferenciaDias = diferenciaMilisegundos / (1000 * 60 * 60 * 24);

  // Obtener el número de semanas y meses con decimales
  const semanas = diferenciaDias / 7;
  const meses = diferenciaDias / 30;

  // Construir el texto según la diferencia
  let texto;
  if (meses >= 1) {
    texto = meses < 2 ? "hace un mes" : `hace ${Math.round(meses)} meses`;
  } else if (semanas >= 1) {
    texto =
      semanas < 2 ? "hace una semana" : `hace ${Math.round(semanas)} semanas`;
  } else {
    const dias = Math.round(diferenciaDias);

    if (dias === 0) {
      texto = "Hoy";
    } else {
      texto = dias === 1 ? "Ayer" : `Hace ${dias} días`;
    }
  }

  // Imprimir el resultado
  return texto;
}

const fetchAgeGroups = async () => {
  const res = await fetch(`/miembros/g/getAgeGroups/`);
  return await res.json();
};

const fetchSubMenu = async () => {
  const idSub = document.querySelector("main").dataset.idsub;
  const res = await fetch(`/miembros/g/getSub/?id=${idSub}`);
  $(".preloader").fadeOut("slow");
  return await res.json();
};

const foundGroupById = (groupId, ageGroups) => {
  const foundGroup = ageGroups.find((group) => group.id === groupId);
  return foundGroup ? foundGroup.name : null;
};

const findMenusById = async (id) => {
  try {
    let menusFinded = menusInSub.find((element) => element.id == id);
    let listaPlanesDeComida = document.getElementById("planesDeComida");
    let ageGroupTitle = document.getElementById("age_group_title");
    listaPlanesDeComida.innerHTML = "";
    const menu = menusFinded.menu;

    // Función para extraer solo los elementos <ul> por días
    const dias = ["lunes", "martes", "miércoles", "jueves", "viernes"];

    // Obtener los nombres de los componentes del primer día para crear la estructura de comidasFijo
    const primerDia = Object.keys(menu.json_content.desayuno)[0];
    const componentesDesayuno = Object.keys(
      menu.json_content.desayuno[primerDia]
    );
    const componentesAlmuerzo = Object.keys(
      menu.json_content.almuerzo[primerDia]
    );
    const componentesCena = Object.keys(menu.json_content.cena[primerDia]);
    const componentesSnackAM = Object.keys(
      menu.json_content.snack_am[primerDia]
    );
    const componentesSnackPM = Object.keys(
      menu.json_content.snack_pm[primerDia]
    );
    let ageGroupId = menu.age_group;
    let ageGroupName = ageGroupMapping[ageGroupId] || ageGroupId;

    // Función para filtrar los componentes vacíos
    function filtrarComponentes(componentes, comida) {
      return componentes.filter((componente) => {
        let valorComponente;
        switch (comida) {
          case "Desayuno":
            valorComponente = menu.json_content.desayuno[primerDia][componente];
            break;
          case "Almuerzo":
            valorComponente = menu.json_content.almuerzo[primerDia][componente];
            break;
          case "Cena":
            valorComponente = menu.json_content.cena[primerDia][componente];
            break;
          case "Snack AM":
            valorComponente = menu.json_content.snack_am[primerDia][componente];
            break;
          case "Snack PM":
            valorComponente = menu.json_content.snack_pm[primerDia][componente];
            break;
          default:
            valorComponente = "";
            break;
        }
        // Verificar si el valor del componente no está vacío
        return valorComponente && valorComponente.trim() !== "";
      });
    }

    // Crear la estructura de comidasFijo basada en los componentes específicos de cada comida
    var comidasFijo = [
      {
        titulo: "Desayuno",
        componentes: filtrarComponentes(componentesDesayuno, "Desayuno"),
      },
      {
        titulo: "Snack AM",
        componentes: filtrarComponentes(componentesSnackAM, "Snack AM"),
      },
      {
        titulo: "Almuerzo",
        componentes: filtrarComponentes(componentesAlmuerzo, "Almuerzo"),
      },
      {
        titulo: "Snack PM",
        componentes: filtrarComponentes(componentesSnackPM, "Snack PM"),
      },
      {
        titulo: "Cena",
        componentes: filtrarComponentes(componentesCena, "Cena"),
      },
    ];

    ageGroupTitle.textContent = "Edad: " + ageGroupName;

    // Elemento <li> fijo para mostrar los componentes
    var elementoFijo = document.createElement("li");
    var h3Fijo = document.createElement("h3");
    h3Fijo.textContent = "Componentes";
    elementoFijo.appendChild(h3Fijo);

    comidasFijo.forEach(function (comida) {
      // Crear un div para cada comida con la clase "componentes"
      var divComida = document.createElement("div");
      divComida.classList.add("componentes");

      // Agregar el título de la comida (h4)
      var h4Titulo = document.createElement("h4");
      h4Titulo.textContent = comida.titulo;
      divComida.appendChild(h4Titulo);

      // Crear un div para los componentes
      var divComponentes = document.createElement("div");
      divComponentes.classList.add("componentes-list");

      // Agregar los componentes de la comida (p) con etiquetas strong
      comida.componentes.forEach(function (componente) {
        var pComponente = document.createElement("p");
        var strongComponente = document.createElement("strong");
        strongComponente.textContent = formatoComponente(componente);
        pComponente.appendChild(strongComponente);
        divComponentes.appendChild(pComponente);
      });

      // Agregar el div de los componentes al div de la comida
      divComida.appendChild(divComponentes);

      // Agregar el div de la comida al elemento fijo
      elementoFijo.appendChild(divComida);
    });

    // Agregar el elemento fijo a la lista de planes de comida
    listaPlanesDeComida.appendChild(elementoFijo);

    // Generar contenido por cada día
    function generarContenidoDia(dia) {
      var diaSentenceCase =
        dia.charAt(0).toUpperCase() + dia.slice(1).toLowerCase();
      var contenido = document.createElement("li");
      contenido.classList.add("dia", dia);

      var h3 = document.createElement("h3");
      h3.textContent = diaSentenceCase;
      contenido.appendChild(h3);

      ["desayuno", "snack_am", "almuerzo", "snack_pm", "cena"].forEach(
        function (meal) {
          var propiedades = document.createElement("div");
          propiedades.classList.add(meal);
          var objeto = menu.json_content[meal][dia];
          if (objeto) {
            Object.keys(objeto).forEach((propiedad) => {
              if (objeto[propiedad]) {
                // Verificar si la propiedad no está vacía
                var div = document.createElement("div");
                div.classList.add("propiedad", propiedad);
                div.textContent = objeto[propiedad];
                propiedades.appendChild(div);
              }
            });
          }
          contenido.appendChild(propiedades);
        }
      );

      return contenido;
    }

    var fragmento = document.createDocumentFragment();
    dias.forEach((dia) => {
      fragmento.appendChild(generarContenidoDia(dia));
    });
    listaPlanesDeComida.appendChild(fragmento);

    document.querySelector("#menuDialog").style.display = "block";
    $(".preloader").fadeOut("slow");
  } catch (error) {
    console.error("Error fetching menus:", error);
  }
};

// Función para formatear el nombre del componente
function formatoComponente(componente) {
  // Dividir el nombre del componente por guiones bajos y convertir las palabras en mayúsculas
  return componente
    .split("_")
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join("/");
}

const renderMenu = (menu, index, ageGroups) => {
  const group = foundGroupById(menu.menu.age_group, ageGroups);
  const template = `
    <li>
      <img src="img/tabla/Menu_Comidas_Infantes.svg" alt="Menu_Comidas_Infantes">
      <strong>Menú ${index + 1}</strong>
      <p>${group == "School Age" ? "2+ años" : group}</p>
      <p>${getFecha(menu)}</p>
      <button class="button-ver" onclick="findMenusById('${menu.id}')">
        Ver menú
        <span>
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"
            fill="none">
            <path d="M6.5 3.5L11.5 8.5L6.5 13.5" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
      </button>
    </li>`;
  document.querySelector(".tabla-elementos").innerHTML += template;
};

const updateCounter = (numberMenus) => {
  const counterElement = document.querySelector(".contador-menu");
  const botonGenerar = document.querySelector(".boton-generar");
  if (counterElement && botonGenerar) {
    if (numberMenus > 0) {
      counterElement.innerHTML = `<i id="icono-soporte" class="acuarela acuarela-16 acuarela-Soporte"></i>
        <span class="texto-contador">Menús restantes: </span><span id="contador">${numberMenus}</span>
        <div class="bocadillo" id="bocadillo">Este es el número de menús que puedes crear</div>`;
      if (botonGenerar) {
        botonGenerar.style.display = "flex";
      }
    } else {
      if (botonGenerar) {
        botonGenerar.style.display = "none";
      }
      counterElement.innerHTML = `<a href="https://bilingualchildcaretraining.com/checkout/?service=65723104b5cb46bac4e81e98"
        class="btn btn-big btn-action-primary">Mejorar mi plan</a>`;
    }
  }
};

const getMenuHistory = async (menuHistories = "", actualSub = "") => {
  if (!getAgeGroups) {
    getAgeGroups = await fetchAgeGroups();
  }

  let daycareName = document.getElementById("daycare_name");
  if (document.querySelector("main").dataset.idsub) {
    const subMenu = menuHistories ? actualSub : await fetchSubMenu();

    var daycareNameLink = subMenu.daycare.name.toLowerCase();

    var daycareIdLink = subMenu.daycare._id;

    // Actualizar el enlace de redirección
    var volverLink = document.getElementById("volverFoodai");
    volverLink.href = `/miembros/suscripciones/${daycareIdLink}`;

    const { number_menus, menuhistory } = subMenu;

    daycareName.textContent = "Daycare: " + subMenu.daycare.name;

    let semanaMenu = document.getElementById("semanaSelect");

    updateCounter(number_menus);

    // Verificar si el elemento .tabla-elementos está presente en el DOM
    const tablaElementos = document.querySelector(".tabla-elementos");
    if (tablaElementos) {
      // Si el elemento existe, modificar su contenido
      tablaElementos.innerHTML = `<li class="header-tabla"><strong></strong><strong></strong>
        <strong>Edad</strong><strong>Generado</strong><strong></strong></li>`;
      const mainElement = document.querySelector("main");
      if (menuhistory) {
        menusInSub = menuhistory.menuscreados;

        menuhistory.menuscreados.forEach((menu, index) => {
          renderMenu(menu, index, getAgeGroups);
        });
        mainElement.dataset.menuhistoryid = menuhistory.id;
        mainElement.dataset.menuscreados = JSON.stringify(
          extraerIDs(menuhistory)
        );
      }

      mainElement.dataset.number_menus = number_menus;
      removeSkeleton();
    }
  } else {
    if (document.querySelector(".curriculumcontent")) {
      daycareName.textContent = "Daycare: " + nombre_daycare;
    }
  }
};
// Función para extraer IDs de la propiedad "menus"
function extraerIDs(objetoCompleto) {
  const resultado = {
    menuscreados: objetoCompleto.menuscreados.map((menuCreado) => {
      return {
        menu: menuCreado.menu,
        creation_date: menuCreado.creation_date,
      };
    }),
  };

  return resultado;
}
function removeSkeleton() {
  document
    .querySelectorAll(".home main .tabla-elementos li.skeleton")
    .forEach((el) => el.remove());
}
const updateUserMenusHistory = async (
  subid,
  menuhistoriesid,
  numberMenus,
  data
) => {
  var formdata = new FormData();
  formdata.append("subid", subid);
  formdata.append("menuhistoriesid", menuhistoriesid);
  formdata.append("numberMenus", numberMenus);
  formdata.append("data", JSON.stringify(data));

  var requestOptions = {
    method: "POST",
    body: formdata,
    redirect: "follow",
  };
  await fetch("/miembros/s/updateMenusHistory/", requestOptions)
    .then((response) => response.json())
    .then((result) => {
      console.log("Result: ", result);
      let template = `<li class="header-tabla"><strong></strong><strong></strong><strong>Edad</strong><strong>Generado</strong><strong></strong></li><li class="skeleton"></li><li class="skeleton"></li><li class="skeleton"></li><li class="skeleton"></li><li class="skeleton"></li>`;
      document.querySelector(".tabla-elementos").innerHTML = template;
    })
    .catch((error) => console.log("error", error))
    .finally(() => getMenuHistory());
};
async function opendialogUpgradeSub() {
  const sub = await fetchSubMenu();
  const response = await fetch("/g/serviceMenus/");
  const data = await response.json();
  const newService = [];
  data.forEach((service) => {
    if (sub.service.id != service.id) {
      newService.push(service);
    }
  });
}

let btnCompartir = document.getElementById("compartirMenu");
let shareOptions = document.getElementById("share_menu");
let whatsapp = document.getElementById("whatsapp_menu");
let link = document.getElementById("copy_menu");
let listenersAdded = false;
let publicUrl;

function toggleShareOptions(id) {
  if (
    shareOptions.style.display === "none" ||
    shareOptions.style.display === ""
  ) {
    shareOptions.style.display = "block";
  } else {
    shareOptions.style.display = "none";
  }
  // btnShareMenu.removeEventListener('click', toggleShareOptions);
}

function shareOnWhatsapp() {
  console.log("hola whatsapp");
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

function addEventListeners(id) {
  publicUrl = `/miembros/shareMenu/${id}`;
  // publicUrl = `https://dev.bilingualchildcaretraining.com/miembros/shareMenu/${id}`;
  // console.log(listenersAdded);
  if (!listenersAdded) {
    btnCompartir.addEventListener("click", toggleShareOptions);
    whatsapp.addEventListener("click", () => shareOnWhatsapp(id));
    link.addEventListener("click", () => copyLink(id));
    listenersAdded = true; // Indica que los listeners han sido agregados
  }
}
// Función principal para generar un menú aleatorio
async function getMenuRandomMenu(age) {
  // Mostrar mensaje de carga
  document.querySelector(".preloader h2").innerHTML =
    "Estamos generando tu nuevo menú...";
  $(".preloader").fadeIn();

  // Obtener el título del grupo de edad
  let ageGroupTitle = document.getElementById("age_group_title");
  let ageGroupName = ageGroupMapping[age] || age;
  ageGroupTitle.textContent = "Edad: " + ageGroupName;

  // Función para obtener el menú desde el servidor
  const fetchMenu = async () => {
    const response = await fetch(`/miembros/g/getMenus/?age=${age}`);
    let resp = await response.json();
    return resp.response;
  };

  try {
    // Obtener el elemento de la lista donde se insertará el contenido
    let listaPlanesDeComida = document.getElementById("planesDeComida");
    listaPlanesDeComida.innerHTML = "";

    const menu = await fetchMenu();

    addEventListeners(menu.id);

    console.log(menu);
    // Días de la semana
    const dias = ["lunes", "martes", "miércoles", "jueves", "viernes"];

    // Obtener los componentes del primer día
    const primerDia = Object.keys(menu.json_content.desayuno)[0];
    const componentesDesayuno = Object.keys(
      menu.json_content.desayuno[primerDia]
    );
    const componentesAlmuerzo = Object.keys(
      menu.json_content.almuerzo[primerDia]
    );
    const componentesCena = Object.keys(menu.json_content.cena[primerDia]);
    const componentesSnackAM = Object.keys(
      menu.json_content.snack_am[primerDia]
    );
    const componentesSnackPM = Object.keys(
      menu.json_content.snack_pm[primerDia]
    );

    // Función para filtrar componentes vacíos
    function filtrarComponentes(componentes, comida) {
      return componentes.filter((componente) => {
        let valorComponente;
        switch (comida) {
          case "Desayuno":
            valorComponente = menu.json_content.desayuno[primerDia][componente];
            break;
          case "Almuerzo":
            valorComponente = menu.json_content.almuerzo[primerDia][componente];
            break;
          case "Cena":
            valorComponente = menu.json_content.cena[primerDia][componente];
            break;
          case "Snack AM":
            valorComponente = menu.json_content.snack_am[primerDia][componente];
            break;
          case "Snack PM":
            valorComponente = menu.json_content.snack_pm[primerDia][componente];
            break;
          default:
            valorComponente = "";
            break;
        }
        return valorComponente && valorComponente.trim() !== "";
      });
    }

    // Crear la estructura de comidasFijo
    var comidasFijo = [
      {
        titulo: "Desayuno",
        componentes: filtrarComponentes(componentesDesayuno, "Desayuno"),
      },
      {
        titulo: "Snack AM",
        componentes: filtrarComponentes(componentesSnackAM, "Snack AM"),
      },
      {
        titulo: "Almuerzo",
        componentes: filtrarComponentes(componentesAlmuerzo, "Almuerzo"),
      },
      {
        titulo: "Snack PM",
        componentes: filtrarComponentes(componentesSnackPM, "Snack PM"),
      },
      {
        titulo: "Cena",
        componentes: filtrarComponentes(componentesCena, "Cena"),
      },
    ];

    // Crear elemento fijo
    var elementoFijo = document.createElement("li");
    var h3Fijo = document.createElement("h3");
    h3Fijo.textContent = "Componentes";
    elementoFijo.appendChild(h3Fijo);

    // Iterar sobre las comidas
    comidasFijo.forEach(function (comida) {
      var divComida = document.createElement("div");
      divComida.classList.add("componentes");

      var h4Titulo = document.createElement("h4");
      h4Titulo.textContent = comida.titulo;
      divComida.appendChild(h4Titulo);

      var divComponentes = document.createElement("div");
      divComponentes.classList.add("componentes-list");

      comida.componentes.forEach(function (componente) {
        var pComponente = document.createElement("p");
        var strongComponente = document.createElement("strong");
        strongComponente.textContent = formatoComponente(componente);
        pComponente.appendChild(strongComponente);
        divComponentes.appendChild(pComponente);
      });

      divComida.appendChild(divComponentes);
      elementoFijo.appendChild(divComida);
    });

    listaPlanesDeComida.appendChild(elementoFijo);

    // Generar contenido por cada día
    function generarContenidoDia(dia) {
      var diaSentenceCase =
        dia.charAt(0).toUpperCase() + dia.slice(1).toLowerCase();
      var contenido = document.createElement("li");
      contenido.classList.add("dia", dia);

      var h3 = document.createElement("h3");
      h3.textContent = diaSentenceCase;
      contenido.appendChild(h3);

      ["desayuno", "snack_am", "almuerzo", "snack_pm", "cena"].forEach(
        function (meal) {
          var propiedades = document.createElement("div");
          propiedades.classList.add(meal);
          var objeto = menu.json_content[meal][dia];
          if (objeto) {
            Object.keys(objeto).forEach((propiedad) => {
              if (objeto[propiedad]) {
                var div = document.createElement("div");
                div.classList.add("propiedad", propiedad);
                div.textContent = objeto[propiedad];
                propiedades.appendChild(div);
              }
            });
          }
          contenido.appendChild(propiedades);
        }
      );

      return contenido;
    }

    var fragmento = document.createDocumentFragment();
    dias.forEach((dia) => {
      fragmento.appendChild(generarContenidoDia(dia));
    });
    listaPlanesDeComida.appendChild(fragmento);

    // Obtener la fecha actual
    const currentDate = new Date();
    const year = currentDate.getFullYear();
    const month = String(currentDate.getMonth() + 1).padStart(2, "0");
    const day = String(currentDate.getDate()).padStart(2, "0");
    const formattedDate = `${year}-${month}-${day}`;
    if (document.querySelector("main").dataset.menuscreados) {
      let allActualData = JSON.parse(
        document.querySelector("main").dataset.menuscreados
      );
      allActualData.menuscreados.push({
        menu: menu.id,
        creation_date: formattedDate,
      });

      await updateUserMenusHistory(
        document.querySelector("main").dataset.idsub,
        document.querySelector("main").dataset.menuhistoryid,
        document.querySelector("main").dataset.number_menus,
        allActualData
      );
    }
    trackCreatedMenus(ageGroupName, menu.version_promp);
    document.querySelector("#menuDialog").style.display = "block";
    $(".preloader").fadeOut("slow");
  } catch (error) {
    console.error("Error fetching menus:", error);
    $(".preloader").fadeOut("slow");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const botonGenerar = document.querySelector(".boton-generar");
  const popup = document.getElementById("popupFood");
  const botonGenerarPopup = document.getElementById("generarPopup");
  const cerrarPopup = document.getElementById("cerrar-popup");
  const tarjetas = document.querySelectorAll(".tarjeta");
  const popupContent = document.getElementById("popupContent");
  const iconoSoporte = document.getElementById("icono-soporte");
  const bocadillo = document.getElementById("bocadillo");
  if (iconoSoporte) {
    iconoSoporte.addEventListener("click", () => {
      bocadillo.style.display = "block";
      setTimeout(() => {
        bocadillo.style.display = "none";
      }, 5000);
    });
  }
  if (botonGenerar) {
    botonGenerar.addEventListener("click", function () {
      popup.style.display = "block";
      popupContent.style.display = "flex";
    });
  }
  if (tarjetas) {
    tarjetas.forEach((tarjeta) => {
      tarjeta.addEventListener("click", function () {
        tarjetas.forEach((t) => t.classList.remove("selected"));
        tarjeta.classList.add("selected");
      });
    });
  }
  if (botonGenerarPopup) {
    // Asignar el evento al botón
    botonGenerarPopup.addEventListener("click", function () {
      const selectedTarjeta = document.querySelector(".tarjeta.selected");
      if (selectedTarjeta) {
        const opcionSeleccionada = selectedTarjeta.dataset.id;
        popup.style.display = "none";
        getMenuRandomMenu(opcionSeleccionada);
      }
    });
  }

  document.addEventListener("click", function (event) {
    if (
      popup &&
      popupContent &&
      event.target !== popup &&
      !popup.contains(event.target) &&
      event.target !== botonGenerar
    ) {
      popup.style.display = "none";
      tarjetas.forEach((tarjeta) => {
        tarjeta.classList.remove("selected");
      });
    }
  });

  document.addEventListener("click", function (event) {
    if (
      popupContent &&
      event.target !== popupContent &&
      !popupContent.contains(event.target) &&
      event.target !== botonGenerar
    ) {
      popup.style.display = "none";
      popupContent.style.display = "none";
      tarjetas.forEach((tarjeta) => {
        tarjeta.classList.remove("selected");
      });
    }
  });

  if (cerrarPopup) {
    cerrarPopup.addEventListener("click", function () {
      popup.style.display = "none";
      if ((popup.style.display = "none")) {
        tarjetas.forEach((tarjeta) => {
          tarjeta.classList.remove("selected");
        });
      }
    });
  }
  getMenuHistory();
});
