<!-- FAQ -->
<section class="faq" id="faq">
    <h2>Preguntas frecuentes</h2>
    <div id="faq-container"></div> <!-- contenedor dinámico -->
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
                    <b class="faq-item__title">${pregunta.title.rendered}</b>
                    <div class="faq-item__content content">${pregunta.content.rendered}</div>
                </div>
                `).join('');
            }
        });
    });
</script>