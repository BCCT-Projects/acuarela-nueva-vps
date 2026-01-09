<div id="tour-container" class="hidden">
        <div class="tour-step">
            <button type="button" id="endTour" onclick="endTour()">
                <!-- SVG del botón de cierre -->
            </button>
            <h2 id="tour-title">¡Bienvenido a Acuarela!</h2>
            <hr />
            <div id="tour-video">
                <video loop muted autoplay>
                    <source id="tour-video-source" src="" type="video/mp4">
                </video>
            </div>
            <div id="tour-description"></div>
            <div class="tour-actions">
                <ul id="steps-dots" class="steps-dots"></ul>
                <div class="btns">
                    <button id="tour-prev" class="btn btn-action-secondary enfasis btn-big" onclick="prevStepTour()">Anterior</button>
                    <button id="tour-next" class="btn btn-action-secondary enfasis btn-big" onclick="nextStepTour()">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
<script>
   const tourSteps = [
    {
        title: "¡Bienvenido a Acuarela!",
        image: "videos/ilus1.mp4",
        description: "<p>¡Felicidades por este nuevo paso que das en camino a ser un Daycare 10/10! Te acompañaremos durante tu primer recorrido por nuestra aplicación para que puedas completar la información básica y así aprovechar al máximo todas las ventajas que Acuarela ofrece para ti.</p><p>¡Comencemos!</p>"
    },
    {
        title: "¡Bienvenido a Acuarela!",
        image: "videos/ilus2.mp4",
        description: "<p>Como verás en el menú lateral, las funciones de Acuarela están desactivadas en este momento. Para activarlas basta con seguir los pasos que te iremos indicando en esta primera configuración. Toca el botón siguiente para continuar.</p>"
    },
    {
        title: "¡Bienvenido a Acuarela!",
        image: "videos/ilus3.mp4",
        description: "<p>Comienza por cargar la imagen de perfil de tu Daycare, puede ser el logo o una foto de tus instalaciones. Luego completa los datos básicos de tu programa, horarios y licencia. ¡Buena suerte!</p>"
    }
];

let currentStep = 0;

function startTour() {
    document.getElementById('tour-container').classList.remove('hidden');
    createDots();
    showStepTour();
}

function createDots() {
    const stepsDotsContainer = document.getElementById('steps-dots');
    stepsDotsContainer.innerHTML = ''; // Limpiar los dots previos
    tourSteps.forEach((step, index) => {
        const dot = document.createElement('li');
        if (index === 0) {
            dot.classList.add('active');
        }
        stepsDotsContainer.appendChild(dot);
    });
}

function updateDots() {
    const dots = document.querySelectorAll('#steps-dots li');
    dots.forEach((dot, index) => {
        if (index === currentStep) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });
}

function showStepTour() {
    document.getElementById('tour-title').innerText = tourSteps[currentStep].title;
    document.querySelector('#tour-video video').src = tourSteps[currentStep].image;
    document.getElementById('tour-description').innerHTML = tourSteps[currentStep].description;
    document.getElementById('tour-prev').style.display = currentStep === 0 ? 'none' : 'inline-block';
    document.getElementById('tour-next').innerText = currentStep === tourSteps.length - 1 ? 'Finalizar' : 'Siguiente';
    updateDots();
}

function nextStepTour() {
    if (currentStep < tourSteps.length - 1) {
        currentStep++;
        showStepTour();
    } else {
        endTour();
    }
}

function prevStepTour() {
    if (currentStep > 0) {
        currentStep--;
        showStepTour();
    }
}

function endTour() {
    document.getElementById('tour-container').classList.add('hidden');
    currentStep = 0;
}

document.getElementById('tour-next').addEventListener('click', nextStepTour);
document.getElementById('tour-prev').addEventListener('click', prevStepTour);

</script>