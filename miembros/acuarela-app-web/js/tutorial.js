document.addEventListener('DOMContentLoaded', () => {
    const btnTutorial = document.getElementById('btn-tutorial-social');
    if (!btnTutorial) return;

    btnTutorial.addEventListener('click', () => {
        // Inicializa driver.js
        const driverObj = window.driver.js.driver({
            showProgress: true,
            doneBtnText: 'Entendido',
            closeBtnText: 'Cerrar',
            nextBtnText: 'Siguiente',
            prevBtnText: 'Anterior',
            steps: [
                {
                    popover: {
                        title: 'Bienvenido a Acuarela',
                        description: 'Acuarela es una plataforma integral diseñada para facilitar la administración de tu Daycare. Aquí podrás gestionar a los niños, tu equipo, las tareas diarias y comunicarte con los padres de familia.',
                        side: "top",
                        align: 'start'
                    }
                },
                {
                    popover: {
                        title: 'Menú Principal',
                        description: 'A tu izquierda se encuentra el panel de navegación principal desde donde puedes acceder a todas las herramientas. Vamos a explorar qué hace cada uno.',
                        side: "top",
                        align: 'start'
                    }
                },
                {
                    element: 'nav a[href="/miembros/acuarela-app-web/"]',
                    popover: {
                        title: 'Página Social',
                        description: 'Actualmente te encuentras en el muro Social de tu Daycare. Aquí podrás ver y realizar publicaciones para toda la comunidad. Además sirve como inicio rápido.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'nav a[href="/miembros/acuarela-app-web/inscripciones"]',
                    popover: {
                        title: 'Agregar niñxs',
                        description: 'Sección para ver la lista de menores, sus detalles, e inscribir nuevos niños al Daycare.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'nav a[href="/miembros/acuarela-app-web/asistencia"]',
                    popover: {
                        title: 'Asistencia',
                        description: 'Módulo para controlar las horas de entrada, salida, tiempos de comida y descansos de cada niño.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'nav a[href="/miembros/acuarela-app-web/asistentes"]',
                    popover: {
                        title: 'Asistentes',
                        description: 'Administra tus asistentes, revisa sus incidencias, asistencia y gestiona sus perfiles y permisos.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'nav a[href="/miembros/acuarela-app-web/grupos"]',
                    popover: {
                        title: 'Grupos',
                        description: 'Crea y administra los diferentes salones/grupos de los niños para mantener todo bien organizado.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'nav a[href="/miembros/acuarela-app-web/administrador-tareas"]',
                    popover: {
                        title: 'Administrador de tareas',
                        description: 'Lleva el control riguroso de las rutinas y de todo el checklist de limpieza y tareas diarias.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'nav a[href="/miembros/acuarela-app-web/finanzas"], nav a#lightbox-finanzas',
                    popover: {
                        title: 'Finanzas',
                        description: 'Genera tus facturas y lleva el seguimiento de los pagos y de todos los egresos (Función PRO).',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'nav a[href="/miembros/acuarela-app-web/inspeccion"]',
                    popover: {
                        title: 'Inspección',
                        description: 'Realiza recorridos de inspección dentro de la plataforma para verificar tu nivel de cumplimiento.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'nav a[href="/miembros/acuarela-app-web/privacy_requests"]',
                    popover: {
                        title: 'Privacidad',
                        description: 'Buzón para resolver consultas y conocer las leyes de privacidad actualizadas.',
                        side: "right",
                        align: 'start'
                    }
                },
                {
                    element: 'nav a[href="/miembros/acuarela-app-web/configuracion"]',
                    popover: {
                        title: 'Configuración',
                        description: 'Actualiza los ajustes de tu perfil personal, la cuenta del Daycare e información general y de subscripción.',
                        side: "right",
                        align: 'start'
                    }
                }
            ]
        });

        // Inicia el tour
        driverObj.drive();
    });
});
