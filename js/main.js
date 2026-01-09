
// $( document ).ready() {
//     console.log("READY")
// };



// General toggle
function toggleTarget(target) {
  $("[data-toggle='" + target + "']").toggleClass("active");
}

// Accordion
function toggleAccordion(target) {
  $("[data-toggle='" + target + "']")
    .siblings()
    .removeClass("active");
  $("[data-toggle='" + target + "']")
    .siblings()
    .find(".content")
    .slideUp();

  $("[data-toggle='" + target + "']").toggleClass("active");
  $("[data-toggle='" + target + "']")
    .find(".content")
    .slideToggle();
}

$("#contact__form").validate({
  ignore: "",
  rules: {
    name: "required",
    phone: {
      digits: true,
    },
    email: { required: true, email: true },
    daycare_name: { required: true },
    country: { required: true },
    city: { required: true },
  },
  messages: {
    name: "Nombre obligatorio.",
    phone: "Número telefónico obligatorio.",
    email: { required: "Correo obligatorio.", email: "Correo no valido." },
    daycare_name: { required: "Daycare obligatorio." },
    country: { required: "País obligatorio." },
    city: { required: "Ciudad obligatoria." },
  },
  highlight: function (element) {
    $(element).addClass("error");
    $(element).parent("div").addClass("error");
  },
  unhighlight: function (element) {
    $(element).removeClass("error").addClass("success");
    $(element).parent("div").removeClass("error").addClass("success");
  },
  submitHandler: function (form) {
    $("#contact__form button").attr("disabled", true);
    $("#contact__form button").text("Enviando");
    $("#contact__form").ajaxSubmit({
      dataType: "json",
      success: function (data) {
        console.log(data);
        console.log("Encviado");
        TrackDemo(data.info);
      },
    });
    setTimeout(() => {
      $("#contact__form").fadeOut();
      $(".contact__texts").hide();
      $(".contact__success").fadeIn();
    }, 500);
  },
});

function trackDownload(OS) {
  fbq("track", "StartTrial", {
    test_event_code: "TEST8078",
  });
}

function InitiateCheckout(period, price) {
  fbq("track", "InitiateCheckout", {
    value: price,
    currency: "USD",
    period,
  });
}

function TrackDemo({ name, email, daycare, phone, city }) {
  fbq("track", "Lead", {
    name,
    email,
    daycare,
    phone,
    city,
  });
}

// document.querySelector("#western-new-york").addEventListener("click", () => {
//   setCondado("Western New York");
// });
// document.querySelector("#finger-lakes").addEventListener("click", () => {
//   setCondado("Finger Lakes");
// });
// document.querySelector("#southern-tier").addEventListener("click", () => {
//   setCondado("Southern Tier");
// });
// document.querySelector("#central-new-york").addEventListener("click", () => {
//   setCondado("Central New York");
// });
// document.querySelector("#north-country").addEventListener("click", () => {
//   setCondado("North Country");
// });
// document.querySelector("#capital-region").addEventListener("click", () => {
//   setCondado("Capital Region");
// });
// document.querySelector("#mohawk-valley").addEventListener("click", () => {
//   setCondado("Mohawk Valley");
// });
// document.querySelector("#hudson-valley").addEventListener("click", () => {
//   setCondado("Hudson Valley");
// });
// document.querySelector("#new-york-city").addEventListener("click", () => {
//   setCondado("New York City");
// });
// document.querySelector("#long-island").addEventListener("click", () => {
//   setCondado("Long Island");
// });

function setCondado(name) {
  Fancybox.show([{ src: "#dialog-content", type: "inline" }], {
    on: {
      done: (fancybox, slide) => {
        document.querySelector("#condado").value = name;
        doneBox();
      },
    },
  });
}

function openInvitationForm() {
  Fancybox.show([{ src: "#dialog-content", type: "inline" }], {
    on: {
      done: (fancybox, slide) => {
        doneBox();
      },
    },
  });
}

function doneBox() {
  $("#invitationForm").validate({
    ignore: "",
    rules: {
      name: { required: true },
      daycare: { required: true },
      licencia: { required: true },
      condado: { required: true },
      email: { required: true, email: true },
      phone: {
        required: true,
      },
    },
    messages: {
      name: { required: "Nombre obligatorio." },
      daycare: { required: "Daycare obligatorio." },
      licencia: { required: "Licencia obligatoria." },
      condado: { required: "Estado obligatorio." },
      email: {
        required: "Correo obligatorio.",
        email: "Correo no valido.",
      },
      phone: {
        required: "No es un número telefónico.",
      },
    },
    submitHandler: function (form) {
      $("#invitationForm button").attr("disabled", true);
      $("#invitationForm button").text("Enviando");
      $("#invitationForm").ajaxSubmit({
        dataType: "json",
        success: function (data) {
          console.log(data);
        },
      });
      setTimeout(() => {
        $(".formLanding .form").fadeOut();
        $(".formLanding .success").fadeIn();
      }, 500);
    },
  });
}

function unMutedVideo() {
  const video = document.querySelector(".video-container #video1");
  if (video.muted === true) {
    document.querySelector("#unmutedBtn img").src = "img/volOn.svg";
    video.muted = false;
  } else if (video.muted === false) {
    document.querySelector("#unmutedBtn img").src = "img/volOff.svg";
    video.muted = true;
  }
}


//PARA EL MODAL DEL DEMO
// setTimeout(() => {
//   const openModalBtn = document.getElementById('openModalBtn');
//   const closeModalBtn = document.getElementById('closeModalBtn');
//   const modalOverlay = document.getElementById('modalOverlay');

//   if (openModalBtn) {
//     openModalBtn.addEventListener('click', () => {
//       modalOverlay.classList.remove('hidden');
//     });
//   }

//   if (closeModalBtn) {
//     closeModalBtn.addEventListener('click', () => {
//       modalOverlay.classList.add('hidden');
//     });
//   }

//   if (modalOverlay) {
//     modalOverlay.addEventListener('click', (e) => {
//       if (e.target === modalOverlay) {
//         modalOverlay.classList.add('hidden');
//       }
//     });
//   }
// }, 100);
setTimeout(() => {
  const openModalBtns = document.querySelectorAll('.openModalBtn');
  const closeModalBtn = document.getElementById('closeModalBtn');
  const modalOverlay = document.getElementById('modalOverlay');

  openModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      modalOverlay.classList.remove('hidden');
    });
  });

  if (closeModalBtn) {
    closeModalBtn.addEventListener('click', () => {
      modalOverlay.classList.add('hidden');
    });
  }

  if (modalOverlay) {
    modalOverlay.addEventListener('click', (e) => {
      if (e.target === modalOverlay) {
        modalOverlay.classList.add('hidden');
      }
    });
  }
}, 100);


const alertMessage = {
  emailTitle: {
    es: "Correo requerido",
    en: "Email Required",
  },
  emailText: {
    es: "Por favor, ingresa tu correo electrónico para continuar.",
    en: "Please enter your email address to continue.",
  },
  checkboxTitle: {
    es: "Términos y condiciones requeridos",
    en: "Terms and Conditions Required",
  },
  checkboxText: {
    es: "Por favor, acepta los términos y condiciones para continuar.",
    en: "Please accept the terms and conditions to proceed.",
  },
  successTitle: {
    es: "¡Gracias por completar el formulario!",
    en: "Thank you for filling out the form!",
  },
  successText: {
    es: "Hemos recibido su información y uno de nuestros asesores se pondrá en contacto con usted en breve para brindarle más detalles. ¡Esté atento a su correo!",
    en: "We have received your information, and one of our advisors will contact you shortly to provide more details. Please check your email!",
  },
  errorTitle: {
    es: "¡No se pudo completar el formulario!",
    en: "The form could not be completed!",
  },
  errorText: {
    es: "Por favor, inténtelo de nuevo más tarde o contáctenos directamente para recibir asistencia.",
    en: "Please try again later or contact us directly for assistance.",
  },
  buttonText: {
    es: "Entendido",
    en: "Understood",
  },
};


const form = document.getElementById("demoForm");
if (form) {
  const nameInput = document.getElementById("nameInput");
  const lastnameInput = document.getElementById("lastnameInput");
  const emailInput = document.getElementById("emailInput");
  const daycareInput = document.getElementById("daycareInput");
  // const numNinosInput = document.getElementById("numNinosInput");

  form.addEventListener("submit", function (event) {
    event.preventDefault(); // Evita el submit clásico

    const formData = {
      name: nameInput.value,
      lastName: lastnameInput.value,
      email: emailInput.value,
      fuenteComunicacion: "web form",
      servicioInteres: "demo acuarela",
      daycareName: daycareInput.value,
      // numNinos: parseInt(numNinosInput.value, 10),
    };

    fetch("/s/validatedemo/", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(formData),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // Limpiar campos
          nameInput.value = "";
          lastnameInput.value = "";
          emailInput.value = "";
          daycareInput.value = "";
          // numNinosInput.value = "";

          alert("¡Formulario enviado con éxito!");
        } else {
          alert("Error al enviar el formulario. Intenta nuevamente.");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Hubo un problema con el servidor. Inténtalo más tarde.");
      });
  });
}




// //Carrusel de testimonios
function attachSliderListeners() {
  let currentIndex = 0;

  const sliderTrack = document.querySelector('.testimonial__slider-track');
  const slides = document.querySelectorAll('.testimonial__slide');
  const totalSlides = slides.length;
  const slidesPerView = 2;

  if (!sliderTrack || totalSlides === 0) {
    console.warn("Slider elements not found in the DOM.");
    return;
  }

  function updateSlider() {
    const slideWidth = slides[0].offsetWidth + 20; // 20 es el gap
    const moveX = currentIndex * slideWidth;
    sliderTrack.style.transform = `translateX(-${moveX}px)`;
  }

  const leftArrow = document.querySelector('img[alt="Desplazar testimonios a la izquierda"]');
  const rightArrow = document.querySelector('img[alt="Desplazar testimonios a la derecha"]');

  if (leftArrow) {
    leftArrow.addEventListener('click', () => {
      currentIndex = Math.max(0, currentIndex - 1);
      updateSlider();
    });
  }

  if (rightArrow) {
    rightArrow.addEventListener('click', () => {
      if (currentIndex < totalSlides - slidesPerView) {
        currentIndex++;
        updateSlider();
      }
    });
  }

  window.addEventListener('resize', updateSlider);

  updateSlider(); // Para asegurarte que el slider se ajuste en inicio
}
setTimeout(() => {
  attachSliderListeners();
}, 100);




//Parte para manejar la tabla de acuarela lite y pro
let monthlyAcuarela = true;
let acuarelaService = false;

function toggleFrequencyAcuarela() {
  monthlyAcuarela = !monthlyAcuarela;
  document.getElementById("frequencyLabelAcuarela").textContent = monthlyAcuarela
    ? "Mensual"
    : "Anual";
  updateAcuarelaServices();
  // updatePricesIndiUni();
}
getAllAcuarela();


//Parte para manejar la tabla de acuarela lite y pro, (No con el switch)
function setFrequencyAcuarela(option) {
  monthlyAcuarela = option === "mensual";
  // Primero quitar "active" de ambos
  document.getElementById("optionAnual").classList.remove("active");
  document.getElementById("optionMensual").classList.remove("active");
  // Luego agregar "active" solo al seleccionado
  if (monthlyAcuarela) {
    document.getElementById("optionMensual").classList.add("active");
  } else {
    document.getElementById("optionAnual").classList.add("active");
  }

  updateAcuarelaServices();
}


const toggleBtn = document.querySelector('.toggle-btn');
const listDeployment = document.querySelector('.list-deployment');

if (toggleBtn) {
  toggleBtn.addEventListener('click', () => {
    listDeployment.classList.toggle('active');
    toggleBtn.classList.toggle('rotated');
  });
}


function getAllAcuarela() {
  if (!acuarelaService) {
    return fetch("/g/getAcuarelaServices/")
      .then((res) => res.json())
      .then((data) => {
        acuarelaService = data;
        return data;
      });
  } else {
    return Promise.resolve(acuarelaService);
  }
}

var preloader = document.querySelector(".preloader");
// Función para desvanecer gradualmente el elemento
function fadeOut(element) {
  var opacity = 1;
  var interval = 50; // intervalo de tiempo en milisegundos
  var duration = 300; // duración total del desvanecimiento en milisegundos

  // Función recursiva para ajustar la opacidad en cada paso del intervalo
  function decreaseOpacity() {
    opacity -= interval / duration;
    element.style.opacity = opacity;

    // Si la opacidad es mayor que 0, seguir desvaneciendo
    if (opacity > 0) {
      setTimeout(decreaseOpacity, interval);
    } else {
      // Si la opacidad llega a 0, ocultar el elemento
      element.style.display = "none";
    }
  }

  // Iniciar el desvanecimiento
  decreaseOpacity();
}

function updateAcuarelaServices() {
  fadeOut(preloader);
  getAllAcuarela() // Obtener los datos de los currículos
    .then((data) => {
      const tableContainer = document.querySelector(".acuarela-bussines-slide#services");
      tableContainer.innerHTML = ""; // Limpiar la tabla anterior
      let tableHTML = `
      <table>
        <thead>
          <tr>
            <th>
              <div class="boxtitle__table">
                <img src="img/Favicon.svg" alt="Acuarela App" />
                <div class="boxtitle__table-title">
                  <h2> Acuarela App</h2>
                    <p>
                      <span id="optionAnual" class="frequency-option ${monthlyAcuarela ? '' : 'active'}" onclick="setFrequencyAcuarela('anual')">Anual</span> / 
                      <span id="optionMensual" class="frequency-option ${monthlyAcuarela ? 'active' : ''}" onclick="setFrequencyAcuarela('mensual')">Mensual</span>
                    </p>
                </div>
              </div>

              <h3> Características </h3>
            </th>
      `;

      data.forEach((acuarela) => {
        const price = monthlyAcuarela
          ? acuarela.acf.precio_mensual
          : acuarela.acf.presio_anual;

        const isPro = acuarela.title.rendered.trim().toLowerCase() === "acuarela pro";

        const redirectLink = monthlyAcuarela
          ? acuarela.acf.link_de_pago_mensual
          : acuarela.acf.link_de_pago_anual;

        const isProButton = acuarela.acf.texto_boton === "Quiero ser Pro";
        const buttonText = acuarela.acf.texto_boton; 
        const disabledAttr = "";
        const buttonClassExtra = ""; 
        const onclickAttr = `onclick="window.open('${redirectLink || "#"}', '_blank')"`;

        const asesorButtonClass = isPro ? "buttonth-white" : "buttonth-white btn-invisible";

        tableHTML += `
          <th class="th-acuarela">
            <p> 
              <span class="title-price">
                ${acuarela.title.rendered} 
                ${isPro ? '<img src="img/crown_simple.svg" alt="Pro"/>' : ''}
              </span>
              <span class="price">${price}</span>
            </p>
            <button class="buttonth ${buttonClassExtra}" ${disabledAttr} ${onclickAttr} target="_blank">
              ${buttonText}
            </button>
            <button class="${asesorButtonClass}" target="_blank">
              Hablar con asesor
            </button>
          </th>
        `;
      });

      tableHTML += `
          </tr>
        </thead>
        <tbody>
      `;

      const allFeatures = {};

      data.forEach((acuarela) => {
        const featuresData = parseFeatures(acuarela.content.rendered);
        Object.keys(featuresData).forEach((feature) => {
          allFeatures[feature] = true; // Guardar la característica como clave única
        });
      });

      let index = 0;
      Object.keys(allFeatures).forEach((feature) => {
        const rowClass = index % 2 === 0 ? 'white-bgtd' : 'menta-bgtd'; // Alternar clase con base en index par o impar
        tableHTML += `
          <tr>
            <td class="${rowClass}">${feature}</td>
        `;

        data.forEach((acuarela) => {
          const featuresData = parseFeatures(acuarela.content.rendered);
          tableHTML += `
            <td style="text-align: center;">
              ${featuresData[feature] === true ? "✔" : featuresData[feature] === false ? "✖" : featuresData[feature]}
            </td>
          `;
        });

        tableHTML += `</tr>`;
        index++;
      });

      tableHTML += `
      <tr>
        <td style="text-align: center; font-weight: bold;"></td>
      `;

      tableHTML += `
      </tr>
    </tbody>
  </table>
  `;

      tableContainer.innerHTML = tableHTML;
    })
    .catch((error) => {
      console.error("Error al obtener los datos de los currículos:", error);
    });
}

function updateAcuarelaServices2() {
  fadeOut(preloader);
  getAllAcuarela()
    .then((data) => {
      const filteredData = data.filter((acuarela) => {
        return acuarela.title.rendered.trim().toLowerCase() !== "acuarela pro";
      });

      const container = document.querySelector("#services2");
      container.innerHTML = "";

      // Reunir todas las características únicas
      const allFeatures = {};
      filteredData.forEach((acuarela) => {
        const featuresData = parseFeatures(acuarela.content.rendered);
        Object.keys(featuresData).forEach((feature) => {
          allFeatures[feature] = true;
        });
      });

      // Crear encabezado (tarjetas de cada plan)
      let headerHTML = `<div class="acuarela-plans-header">`;

      filteredData.forEach((acuarela) => {
        const price = monthlyAcuarela
          ? acuarela.acf.precio_mensual
          : acuarela.acf.presio_anual;

        headerHTML += `
          <div class="plan-card">
            <img src="img/Favicon.svg" alt="${acuarela.title.rendered}" />
            <h2>${acuarela.title.rendered}</h2>
          </div>
          <div class="plan-price">
            <p class="price" data-monthly="${acuarela.acf.precio_mensual}" data-yearly="${acuarela.acf.presio_anual}">${price}</p>
          </div>
          <div class="plan-change">
            <p class="page-month ${monthlyAcuarela ? 'active' : ''}" onclick="setFrequencyAcuarela2('mensual')">Pago mensual</p>
            <p class="page-year ${!monthlyAcuarela ? 'active' : ''}" onclick="setFrequencyAcuarela2('anual')">
              Pago Anual
              <span>Ahorras 30%</span>
            </p>
          </div>
        `;
      });

      headerHTML += `
        <div class="feature-title-header">
          <h3>Características</h3>
        </div>
      </div>`;
      container.innerHTML += headerHTML;

      // Crear filas de características
      let featuresHTML = `<div class="acuarela-features">`;
      let index = 0;

      Object.keys(allFeatures).forEach((feature) => {
        const rowClass = index % 2 === 0 ? 'white-bgtd' : 'menta-bgtd';

        // Nuevo contenedor grid por cada fila de característica
        featuresHTML += `<div class="feature-container" >`;

        // Título
        featuresHTML += `
          <div class="feature-row ${rowClass}">
            <div class="feature-title">${feature}</div>
          </div>
        `;

        // Valores
        featuresHTML += `<div class="feature-values" style="display: flex; gap: 20px;">`;
        filteredData.forEach((acuarela) => {
          const featuresData = parseFeatures(acuarela.content.rendered);
          featuresHTML += `
            <div class="feature-value">
              ${featuresData[feature] === true ? "✔" : featuresData[feature] === false ? "✖" : featuresData[feature]}
            </div>
          `;
        });
        featuresHTML += `</div>`; // cerrar feature-values

        featuresHTML += `</div>`; // cerrar feature-container
        index++;
      });

      featuresHTML += `</div>`; // cerrar acuarela-features
      container.innerHTML += featuresHTML;


      // Crear botones finales (uno por cada plan)
      let buttonsHTML = `<div class="acuarela-buttons">`;
      filteredData.forEach((acuarela) => {
        const redirectLink = monthlyAcuarela
          ? acuarela.acf.link_de_pago_mensual
          : acuarela.acf.link_de_pago_anual;

        const buttonText = acuarela.acf.texto_boton; 
        const disabledAttr = ""; 
        const buttonClassExtra = ""; 
        const onclickAttr = `onclick="window.open('${redirectLink || "#"}', '_blank')"`;

        buttonsHTML += `
          <div class="plan-buttons">
            <button class="buttonth ${buttonClassExtra}" ${disabledAttr} ${onclickAttr}>
              ${buttonText}
            </button>
            <button class="buttonth-white btn-invisible">
              Hablar con asesor
            </button>
          </div>
        `;
      });
      buttonsHTML += `</div>`; // cerrar .acuarela-buttons
      container.innerHTML += buttonsHTML;
    })
    .catch((error) => {
      console.error("Error al obtener los datos de los currículos (services2):", error);
    });
}

// Esta es la nueva función para tu vista de mobile (updateAcuarelaServices2)
function setFrequencyAcuarela2(option) {
  monthlyAcuarela = option === "mensual";
  updateAcuarelaServices2();  // Volver a pintar la sección con el precio correcto
  updateAcuarelaServicesPro();  // Volver a pintar la sección con el precio correcto

  // Después de pintar, activar clases
  setTimeout(() => {
    // Quitar "active" de todos
    document.querySelectorAll(".page-month").forEach(el => el.classList.remove("active"));
    document.querySelectorAll(".page-year").forEach(el => el.classList.remove("active"));

    // Agregar "active" solo al seleccionado
    if (monthlyAcuarela) {
      document.querySelectorAll(".page-month").forEach(el => el.classList.add("active"));
    } else {
      document.querySelectorAll(".page-year").forEach(el => el.classList.add("active"));
    }
  }, 0); // Ejecuta justo después de repintar
}



function updateAcuarelaServicesPro() {
  fadeOut(preloader);
  getAllAcuarela()
    .then((data) => {
      // Filtra SOLO el plan Pro
      const filteredData = data.filter((acuarela) => {
        return acuarela.title.rendered.trim().toLowerCase() === "acuarela pro";
      });

      const container = document.querySelector("#servicesPro");
      container.innerHTML = "";

      // Reunir todas las características únicas
      const allFeatures = {};
      filteredData.forEach((acuarela) => {
        const featuresData = parseFeatures(acuarela.content.rendered);
        Object.keys(featuresData).forEach((feature) => {
          allFeatures[feature] = true;
        });
      });

      // Crear encabezado
      let headerHTML = `<div class="acuarela-plans-header">`;

      filteredData.forEach((acuarela) => {
        const price = monthlyAcuarela
          ? acuarela.acf.precio_mensual
          : acuarela.acf.presio_anual;

        headerHTML += `
          <div class="plan-card">
            <img src="img/Favicon.svg" alt="${acuarela.title.rendered}" />
            <h2>${acuarela.title.rendered}</h2>
            <img class="crown" src="img/crown_simple.svg" alt="Pro"/>
          </div>
          <div class="plan-price">
            <p class="price">${price}</p>
          </div>
          <div class="plan-change">
            <p class="page-month ${monthlyAcuarela ? 'active' : ''}" onclick="setFrequencyAcuarela2('mensual')">Pago mensual</p>
            <p class="page-year ${!monthlyAcuarela ? 'active' : ''}" onclick="setFrequencyAcuarela2('anual')">
              Pago Anual
              <span>Ahorras 30%</span>
            </p>
          </div>
        `;
      });

      headerHTML += `
        <div class="feature-title-header">
          <h3>Características</h3>
        </div>
      </div>`;
      container.innerHTML += headerHTML;

      // Crear filas de características
      let featuresHTML = `<div class="acuarela-features">`;
      let index = 0;

      Object.keys(allFeatures).forEach((feature) => {
        const rowClass = index % 2 === 0 ? 'white-bgtd' : 'menta-bgtd';

        featuresHTML += `<div class="feature-container">`;

        featuresHTML += `
          <div class="feature-row ${rowClass}">
            <div class="feature-title">${feature}</div>
          </div>
        `;

        featuresHTML += `<div class="feature-values" style="display: flex; gap: 20px;">`;
        filteredData.forEach((acuarela) => {
          const featuresData = parseFeatures(acuarela.content.rendered);
          featuresHTML += `
            <div class="feature-value">
              ${featuresData[feature] === true ? "✔" : featuresData[feature] === false ? "✖" : featuresData[feature]}
            </div>
          `;
        });
        featuresHTML += `</div>`; // cerrar feature-values

        featuresHTML += `</div>`; // cerrar feature-container
        index++;
      });

      featuresHTML += `</div>`; // cerrar acuarela-features
      container.innerHTML += featuresHTML;

      // Crear botones
      let buttonsHTML = `<div class="acuarela-buttons">`;
      filteredData.forEach((acuarela) => {
        const redirectLink = monthlyAcuarela
          ? acuarela.acf.link_de_pago_mensual
          : acuarela.acf.link_de_pago_anual;

        const buttonText = acuarela.acf.texto_boton; 
        const disabledAttr = "";
        const buttonClassExtra = ""; 
        const onclickAttr = `onclick="window.open('${redirectLink || "#"}', '_blank')"`;

        buttonsHTML += `
          <div class="plan-buttons">
            <button class="buttonth ${buttonClassExtra}" ${disabledAttr} ${onclickAttr}>
              ${buttonText}
            </button>
            <button class="buttonth-white btn-invisible">
              Hablar con asesor
            </button>
          </div>
        `;
      });
      buttonsHTML += `</div>`;
      container.innerHTML += buttonsHTML;
    })
    .catch((error) => {
      console.error("Error al obtener los datos de los currículos (servicesPro):", error);
    });
}







function parseFeatures(featuresString) {
  // Limpiar el contenido de etiquetas HTML y comillas especiales
  const cleanedData = featuresString
    .replace(/<p>|<\/p>/g, '') // Eliminar etiquetas <p>
    .replace(/<br\s*\/?>/g, '') // Eliminar saltos de línea
    .replace(/«|»/g, '"'); // Reemplazar comillas angulares por comillas estándar

  try {
    // Intentar parsear el contenido como JSON
    const features = JSON.parse(cleanedData);
    return features.features;
  } catch (error) {
    console.error("Error al parsear el JSON de características:", error);
    return null; // Retorna null si hay error en el parseo
  }
}


if (document.querySelector(".acuarela-services")) {
  getAllAcuarela().then(() => {
    updateAcuarelaServices();
  });
}
if (document.querySelector(".acuarela-services2")) {
  getAllAcuarela().then(() => {
    updateAcuarelaServices2();
    updateAcuarelaServicesPro();
  });
}
