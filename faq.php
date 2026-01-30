<?php
// Detect if the file is being accessed directly or included
$isStandalone = (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__));

if ($isStandalone) {
    include 'includes/header.php';
    echo '<main class="container" style="padding-top: 100px; padding-bottom: 100px;">';
}
?>

<!-- FAQ -->
<section class="faq" id="faq">
    <div class="faq__header">
        <h2 class="faq__title">Preguntas Frecuentes</h2>
        <p class="faq__subtitle">Todo lo que necesitas saber para empezar con Acuarela</p>
    </div>
    
    <div id="faq-container" class="faq__container">
        <!-- Preloader or skeleton could go here -->
        <div class="loading-spinner">Cargando preguntas...</div>
    </div> 
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const urls = {
            preguntas: '/g/getFaqs/',
        };

        function fetchData(url) {
            return fetch(url)
                .then(response => response.ok ? response.json() : Promise.reject(`Error: ${response.status}`))
                .catch(error => {
                    console.error(`Error loading ${url}:`, error);
                    return [];
                });
        }

        fetchData(urls.preguntas).then(preguntas => {
            const container = document.getElementById("faq-container");

            if (container && Array.isArray(preguntas)) {
                container.innerHTML = preguntas.map((pregunta, index) => `
                <div class="faq-item" onclick="toggleAccordion('accordion-${index}')" data-toggle="accordion-${index}">
                    <div class="faq-item__header">
                        <b class="faq-item__title">${pregunta.title.rendered}</b>
                        <!-- <span class="faq-item__icon"><i class="icon-arrow-down"></i></span> -->
                    </div>
                    <div class="faq-item__content content">${pregunta.content.rendered}</div>
                </div>
                `).join('');
            } else if (container) {
                container.innerHTML = '<p>No se encontraron preguntas frecuentes disponibles en este momento.</p>';
            }
        });
    });
</script>

<?php
if ($isStandalone) {
    echo '</main>';
    include 'includes/footer.php';
}
?>