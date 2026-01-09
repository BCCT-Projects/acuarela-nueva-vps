let actualLang = localStorage.getItem("lang") || "es";
let words = [
  {
    id: 1,
    es: "*Recuerda que solo verás a los niños que no pertenecen a otro grupo.",
    en: "*Remember, you can only see the children that are still without a group.",
  },
  { id: 2, es: "Actualizar", en: "Update" },
  { id: 3, es: "Admin", en: "Manager" },
  { id: 4, es: "Agregar", en: "Add" },
  { id: 5, es: "Agregar gastos", en: "Add expenses" },
  { id: 6, es: "Agregar ingresos", en: "Add income" },
  { id: 7, es: "Agregar niñxs", en: "Add children" },
  { id: 8, es: "Asistencia", en: "Assistance" },
  { id: 9, es: "Asistentes", en: "Assistants" },
  {
    id: 10,
    es: "Aún no has ingresado ningún niño a tu Daycare, realiza el primer registro del día.",
    en: "You haven't added any children to your Daycare, add the first one of the day.",
  },
  {
    id: 11,
    es: "Aún no has vinculado tu cuenta de Paypal. ",
    en: "You haven't linked your PayPal account yet. ",
  },
  { id: 12, es: "Balance ", en: "Balance " },
  { id: 13, es: "Cada hora", en: "By hour" },
  { id: 14, es: "Cada media hora", en: "By half hour" },
  { id: 15, es: "Cada minuto", en: "By minute" },
  { id: 16, es: "Cambiar idioma de la agenda", en: "Change the language" },
  {
    id: 17,
    es: "Capacidad de licencia: niñxs",
    en: "License capacity: children",
  },
  { id: 18, es: "Categorías", en: "Categories" },
  { id: 19, es: "Cerrar sesión", en: "Sing out" },
  { id: 20, es: "Certificados", en: "Certificates" },
  { id: 21, es: "Ciudad", en: "City" },
  { id: 22, es: "Comida", en: "Food" },
  {
    id: 23,
    es: "Comienza por cargar la imagen de perfil de tu Daycare, puede ser el logo o una foto de tus instalaciones. Luego completa los datos básicos de tu programa, horarios y licencia. ¡Buena suerte! Como verás en el menú lateral, las funciones de Acuarela están desactivadas en este momento. Para activarlas basta con seguir los pasos que te iremos indicando en esta primera configuración. Toca el botón siguiente para continuar.",
    en: "Start by uploading your Daycare's profile picture. I can be your logo or a photo of your facilities. Then, fill out the basic data for your program, schedule and license. Good luck! As you can see on the side menu, our functions are currently deactivated. To activate them, you just have to follow the steps to define your initial settings.",
  },
  { id: 24, es: "Concepto de gasto", en: "Concept of expense" },
  { id: 25, es: "Concepto de pago", en: "Concept of payment" },
  { id: 26, es: "Configuración", en: "Settings" },
  { id: 27, es: "Contenido del informe", en: "Report content" },
  { id: 28, es: "Contraseña", en: "Password" },
  { id: 29, es: "Crea tu primer grupo", en: "Create your first group" },
  { id: 30, es: "Cuenta", en: "Account" },
  { id: 31, es: "Describe tus servicios", en: "Describe your services" },
  {
    id: 32,
    es: "Escribe aquí una descripción de tus servicios ",
    en: "Write here a short description of the services you offer",
  },
  { id: 33, es: "Desde", en: "From" },
  { id: 39, es: "Dirección", en: "Address" },
  { id: 40, es: "Dueño de la licencia", en: "License holder" },
  { id: 41, es: "E-mail", en: "Email" },
  { id: 42, es: "Edades", en: "Ages" },
  { id: 43, es: "Editar categorías", en: "Edit categories" },
  { id: 44, es: "Editar perfil", en: "Edit profile" },
  { id: 45, es: "El E-mail no es válido", en: "The email is not recognized" },
  { id: 46, es: "Estado", en: "State" },
  { id: 47, es: "Fecha", en: "Date" },
  { id: 48, es: "Fecha de expiración ", en: "Expiration date" },
  { id: 49, es: "Fecha de información ", en: "Information date" },
  { id: 50, es: "Fichas de asistentes", en: "Assistant sheets" },
  { id: 51, es: "Filosofía de tu Daycare", en: "Your Daycare's philosophy" },
  {
    id: 52,
    es: "Escribe aquí la filosofía de tu Daycare",
    en: "Write here your Daycare's philosophy",
  },
  { id: 53, es: "Finanzas", en: "Finances" },
  { id: 54, es: "Firma ", en: "Signature" },
  { id: 55, es: "Firma del visitante", en: "Visitor's signature" },
  { id: 56, es: "Foto de identificación", en: "ID photo" },
  { id: 57, es: "Gastos", en: "Expenses" },
  { id: 58, es: "Generar factura", en: "Generate invoice" },
  { id: 59, es: "Generar informe ", en: "Create report" },
  { id: 60, es: "Grupos", en: "Groups" },
  { id: 61, es: "Guardar", en: "Save" },
  { id: 62, es: "Guardar Daycare", en: "Save Daycare" },
  { id: 63, es: "Guardar este grupo", en: "Save group" },
  {
    id: 64,
    es: "Ha llegado el momento de configurar el primer grupo. Con esto, podrás acceder a herramientas para asistentes que te ayudarán a dirigir tus niños y llevar registro de todas las actividades que realices. Creamos el primer grupo por ti, toca el botón de opciones y ve a editarlo, luego selecciona el niño que inscribiste para hacerlo parte de este grupo.",
    en: "It's time to create your first group. Here you will access to tools for your assistants to help them lead the children and keep a record of every activity you conduct. We have created the first group for you, click the options button to edit it, then select the child that you registered and add them to this group.",
  },
  {
    id: 65,
    es: "Habilitar pagos automáticos para padres ",
    en: "Enable automatic payments for parents",
  },
  { id: 66, es: "Hasta", en: "To" },
  { id: 67, es: "Horario extendido", en: "Extended hours" },
  { id: 68, es: "Horarios", en: "Schedule" },
  { id: 69, es: "Horarios y precios", en: "Schedules and prices" },
  {
    id: 70,
    es: "Hoy no se ha registrado ninguna visita",
    en: "There aren't any logged visitors today",
  },
  { id: 71, es: "Identificación", en: "ID number" },
  { id: 72, es: "Identificación del visitante", en: "ID of the visitor" },
  { id: 73, es: "Infante semanal", en: "Infant by week" },
  { id: 74, es: "Información ", en: "Info" },
  { id: 75, es: "Ingresar", en: "Sign in" },
  { id: 76, es: "Ingresar con E-mail", en: "Sign in with email" },
  { id: 77, es: "Ingresar con numero", en: "Sign in with phone number" },
  { id: 78, es: "Ingreso", en: "Entry" },
  { id: 79, es: "Ingreso de visitante", en: "Visitor card" },
  { id: 80, es: "Ingreso manual ", en: "Manual entry" },
  { id: 81, es: "Ingresos", en: "Revenue" },
  {
    id: 82,
    es: "Inicia sesión con tu cuenta de BCCT",
    en: "Log in with your BCCT account",
  },
  { id: 83, es: "Inscripciones", en: "Registrations" },
  { id: 84, es: "Inscrito desde ", en: "Registered on" },
  { id: 85, es: "Inspección", en: "Inspection" },
  { id: 86, es: "Integrantes ", en: "Members" },
  {
    id: 87,
    es: "La contraseña debe contener mínimo 6 caracteres.",
    en: "Your password must contain at least 6 characters.",
  },
  { id: 88, es: "Licencia", en: "License" },
  { id: 89, es: "Mis daycares", en: "My Daycares" },
  { id: 90, es: "Modo inspección", en: "Inspection mode" },
  { id: 91, es: "Motivo", en: "Purpose of visit" },
  { id: 92, es: "Motivo del ingreso", en: "Purpose of visit" },
  { id: 93, es: "Social", en: "Social" },
  { id: 94, es: "Método de pago", en: "Payment method" },
  { id: 95, es: "Niñxs agregados", en: "Added children" },
  {
    id: 96,
    es: "No hay Inscripciones creadas",
    en: "There aren't any created registrations",
  },
  {
    id: 97,
    es: "Para agregar una inscripción, haz clic en el botón 'Nueva inscripción'",
    en: "To add a registration, click on New registration",
  },
  {
    id: 98,
    es: "No hay grupos creados",
    en: "There aren't any groups created",
  },
  { id: 99, es: "No hay post disponibles", en: "There aren't any posts" },
  {
    id: 100,
    es: "Para agregar un post, haz clic en el botón publicar",
    en: "To post something, click on Post",
  },
  {
    id: 101,
    es: "No se han creado gastos",
    en: "There aren't any expenses created",
  },
  {
    id: 102,
    es: "No sé encontraron registros en estas fechas",
    en: "There aren't any records for this date range",
  },
  { id: 103, es: "Nombre", en: "Name" },
  { id: 104, es: "Nombre del visitante", en: "ID number" },
  { id: 105, es: "Nombre líder de grupo", en: "Group leader" },
  { id: 106, es: "Nombre y apellido", en: "Full name" },
  { id: 107, es: "Nueva categoría", en: "New category" },
  { id: 108, es: "Nuevo Visitante", en: "New visitor" },
  { id: 109, es: "Nuevo grupo", en: "New group" },
  { id: 110, es: "Número de licencia", en: "License number" },
  { id: 111, es: "Otro", en: "Other" },
  { id: 112, es: "Otros", en: "Others" },
  { id: 113, es: "Pago 100% seguro", en: "100% safe payment" },
  { id: 114, es: "Pago mensual", en: "Monthly payment" },
  { id: 115, es: "Pago quincenal", en: "Bi-weekly payment" },
  { id: 116, es: "Pagos automáticos", en: "Automatic Payments" },
  {
    id: 117,
    es: "Para agregar categorías, separa cada una con una ,",
    en: "To add new categories, separate each using a comma",
  },
  {
    id: 118,
    es: "Para crear un nuevo grupo, haz clic en el botón 'Nuevo Grupo'",
    en: "To create a new group, click on New group",
  },
  { id: 119, es: "Periodo de gracia", en: "Grace period" },
  { id: 120, es: "Pon nombre a este gasto", en: "Name this expense" },
  { id: 121, es: "Pon nombre a este ingreso", en: "Name this income" },
  { id: 122, es: "Precios", en: "Fees" },
  { id: 123, es: "Programa", en: "Program" },
  { id: 124, es: "Publicar", en: "Post" },
  { id: 125, es: "Recuperar contraseña", en: "Recover password" },
  { id: 126, es: "Redes sociales", en: "Social media" },
  { id: 127, es: "Registro de actividades", en: "Activity log" },
  { id: 128, es: "Registro de asistencia", en: "Attendance record" },
  { id: 129, es: "Registro de visitas", en: "Visitor's record" },
  { id: 130, es: "Renta", en: "Rent" },
  { id: 131, es: "Reporte contable", en: "Accounting report" },
  { id: 132, es: "Salida", en: "Departure" },
  {
    id: 133,
    es: "Selecciona lo que quieres que incluya el reporte",
    en: "Select the items you want to include in the report",
  },
  {
    id: 134,
    es: "Selecciona los niños que hacen parte de este grupo",
    en: "Select the children to add them to the group",
  },
  { id: 135, es: "Seleccionar a un niño", en: "Select a child" },
  { id: 136, es: "Seleccionar método de pago", en: "Select method" },
  { id: 137, es: "Seleccionar una categoría", en: "Select a category" },
  { id: 138, es: "Selecciona un asistente", en: "Select an assistant" },
  { id: 139, es: "Selecciona un rango de edad ", en: "Select an age range" },
  { id: 140, es: "Servicio", en: "Service" },
  { id: 141, es: "Servicios", en: "Services" },
  {
    id: 142,
    es: "Si no tienes sitio web, crearemos uno para ti cuando termines de diligenciar toda la ficha de tu daycare",
    en: "If you don't have a website yet, we'll create one for you when you're done filling this form",
  },
  { id: 143, es: "Sitio web", en: "Website" },
  { id: 144, es: "Social ", en: "Social" },
  { id: 145, es: "Tarjeta de crédito ", en: "Credit Card" },
  { id: 146, es: "Teléfono", en: "Phone number" },
  { id: 147, es: "Tipo de gasto", en: "Type of expense" },
  { id: 148, es: "Tipo de pago", en: "Payment type" },
  { id: 149, es: "Toddler semanal", en: "Toddler by week" },
  {
    id: 150,
    es: "Todos los niños se encuentran contigo en el Daycare. No olvides registrar la salida y entregarlo al responsable correspondiente.",
    en: "All the children are at the Daycare with you. Don't forget to log the check out and deliver them to the corresponding person in charge",
  },
  { id: 151, es: "Tomar", en: "Capture" },
  { id: 152, es: "Traducir fechas", en: "Translate dates" },
  { id: 153, es: "Tu pago es seguro aquí", en: "You can pay safely here" },
  { id: 154, es: "Ubicación", en: "Location" },
  { id: 155, es: "Usa un valor numérico", en: "Use a numerical value" },
  { id: 156, es: "Utilidades", en: "Utilities" },
  {
    id: 157,
    es: "Utiliza el filtro de fecha para generar el informe desde y hasta la fecha que necesites ",
    en: "Use the date filter to create the report to set the date range that you require",
  },
  { id: 158, es: "Valor pagado", en: "Amount" },
  { id: 159, es: "Visitas", en: "Visits" },
  { id: 160, es: "Ya un valor numérico", en: "Use a numerical value" },
  { id: 161, es: "Zip code", en: "Zip code" },
  { id: 162, es: "fichas de niños", en: "Children sheets" },
  { id: 163, es: "minutos", en: "Minutes" },
  { id: 164, es: "sin vincular", en: "unlinked" },
  { id: 165, es: "¡Bienvenido a Acuarela!", en: "Welcome to Acuarela!" },
  {
    id: 166,
    es: "¡Excelente! Tu Daycare ya tiene su primer grupo y está listo para usar todas las funciones de Acuarela en tu Daycare. ",
    en: "Excellent! Your Daycare now has its first group and it's ready to use all the functions that Acuarela has for you. ",
  },
  {
    id: 167,
    es: "¡Felicidades por este nuevo paso que das en camino a ser un Daycare 10/10! Te acompañaremos durante tu primer recorrido por nuestra aplicación para que puedas completar la información básica y así aprovechar al máximo todas las ventajas que Acuarela ofrece para ti. ",
    en: "Congratulations on this new step on your way to become a 10/10 Daycare! We'll be by your side during your first tour of our app to help you complete your basic info and take advantage of everything Acuarela can offer. Let's get started! ",
  },
  { id: 168, es: "¡Grupo listo!", en: "Group ready!" },
  {
    id: 169,
    es: "¡No has subido ningún certificado! Sube tu primer certificado para llegar a ser un daycare 10/10",
    en: "You haven't added any certificates yet! Upload your first certificate to get closer to becoming a 10/10 Daycare",
  },
  {
    id: 170,
    es: "¿Por qué ingresa este visitante?",
    en: "Why is the visitor entering?",
  },
  { id: 171, es: "¿Quién realiza el pago?", en: "Who makes this payment?" },
  { id: 172, es: "¿Quiénes están en casa?", en: "Who is at home?" },
  {
    id: 173,
    es: "¿Quiénes están en el daycare?",
    en: "Who is at the Daycare?",
  },
  { id: 174, es: "¿Qué nos hace únicos?", en: "What makes us unique?" },
  {
    id: 175,
    es: "Escribe aquí una descripción que te diferencie de los demás daycares",
    en: "Write here a short description of what makes you different from other ",
  },
  {
    id: 176,
    es: "Espera unos segundos...",
    en: "wait a few seconds...",
  },
  {
    id: 177,
    es: "¡Comencemos!",
    en: "Let's get started!",
  },
  {
    id: 178,
    es: "Siguiente",
    en: "Next",
  },
  {
    id: 179,
    es: "* Para aprovechar al máximo las funciones de Acuarela, ",
    en: "*To enjoy Acuarela to the fullest, ",
  },
  {
    id: 180,
    es: "activa los pagos electrónicos.",
    en: "please activate your electronic payments.",
  },
  { id: 181, es: "Mi Perfil", en: "Profile" },
  {
    id: 182,
    es: "Recuerda que encontrarás siempre un ícono de ayuda que te mostrará cómo usar cada lugar de la app úsalo si estás confundida.",
    en: "Remember that you can always find our Help icon that will assist you in using everything on the app, use it if you need it!",
  },
  {
    id: 183,
    es: "Al activar tu cuenta Paypal con Acuarela, podrás empezar a recibir pagos de manera electrónica de parte de los padres de familia. Cada transacción que recibas por medio de acuarela, tendrá un cobro de USD 0.50 por cada transacción exitosa que realicen padres de familia con tarjeta de crédito o cuentas paypal.",
    en: "By activating your PayPal account with Acuarela, you will be able to start receiving electronic payments from parents. Each transaction you receive through Acuarela will incur a fee of USD 0.50 for every successful transaction made by parents using a credit card or PayPal accounts.",
  },
  {
    id: 184,
    es: "Activar pagos electrónicos",
    en: "Activate electronic payments",
  },
  {
    id: 185,
    es: "Aceptar y continuar",
    en: "Accept and Continue",
  },
  {
    id: 186,
    es: "Cargando...",
    en: "Loading...",
  },
  {
    id: 187,
    es: "reacciones",
    en: "reactions",
  },
  {
    id: 188,
    es: "reacción",
    en: "reaction",
  },
  {
    id: 189,
    es: "Fecha del informe",
    en: "Report date",
  },
  {
    id: 190,
    es: "Anterior",
    en: "Back",
  },
  { id: 191, es: "Agregar Asistente", en: "Add Assistant" },
  {
    id: 192,
    es: "Selecciona el daycare que quieres administrar",
    en: "Select the nursery you want to manage",
  },
  {
    id: 193,
    es: "Administrador de tareas",
    en: "Task Manager",
  },
  {
    id: 194,
    es: "Crear publicación",
    en: "Create post",
  },
  {
    id: 195,
    es: "Vincular publicación a:",
    en: "Link post to:",
  },
  {
    id: 196,
    es: "Cambiar de daycare",
    en: "Change Daycare",
  },
];

function getTranslateAndReplace() {
  document.querySelectorAll("[data-translate]").forEach((element) => {
    let translateId = element.getAttribute("data-translate");
    let wordObj = words.find((word) => word.id == translateId);
    if (wordObj && wordObj[actualLang]) {
      element.textContent = wordObj[actualLang];
    }
  });
  if (actualLang === "es") {
    document.querySelector(
      "header .right ul li button"
    ).innerHTML = `<svg width="513" height="343" viewBox="0 0 513 343" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_301_1272)"><path d="M0 1H512V343H0V1Z" fill="white"/><path d="M0 1H512V92.2H0V1ZM0 251.8H512V343H0V251.8Z" fill="#D03433"/><path d="M0 92H512V252H0V92Z" fill="#FBCA46"/><path d="M177.493 160.6H200.249V172H177.493V160.6Z" fill="white"/><path d="M163.84 194.8C163.84 201.64 170.667 206.2 177.493 206.2C184.32 206.2 191.147 201.64 191.147 194.8L193.422 160.6H161.564L163.84 194.8ZM150.187 160.6C150.187 153.76 154.738 149.2 159.289 149.2H193.422C200.249 149.2 204.8 153.76 204.8 158.32V160.6L202.524 194.8C200.249 208.48 191.147 217.6 177.493 217.6C163.84 217.6 154.738 208.48 152.462 194.8L150.187 160.6Z" fill="#A41517"/><path d="M154.738 172H200.249V183.4H188.871L177.493 206.2L166.116 183.4H154.738V172ZM120.604 137.8H143.36V217.6H120.604V137.8ZM211.627 137.8H234.382V217.6H211.627V137.8ZM154.738 126.4C154.738 119.56 159.289 115 166.116 115H188.871C195.698 115 200.249 119.56 200.249 126.4V130.96C200.249 135.52 197.973 137.8 193.422 137.8H159.289C157.013 137.8 154.738 135.52 154.738 133.24V126.4Z" fill="#A41517"/></g><defs><clipPath id="clip0_301_1272"><rect width="513" height="342" fill="white" transform="translate(0 0.759766)"/></clipPath></defs></svg>ES</div>`;
  } else {
    document.querySelector(
      "header .right ul li button"
    ).innerHTML = `<svg width="513" height="343" viewBox="0 0 513 343" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_301_131)"><path d="M0 0.957031H513V342.957H0V0.957031Z" fill="white"/><path d="M0 0.957031H513V27.257H0V0.957031ZM0 53.557H513V79.857H0V53.557ZM0 106.157H513V132.457H0V106.157ZM0 158.757H513V185.057H0V158.757ZM0 211.457H513V237.757H0V211.457ZM0 264.057H513V290.357H0V264.057ZM0 316.657H513V342.957H0V316.657Z" fill="#D80027"/><path d="M0 0.957031H256.5V185.057H0V0.957031Z" fill="#2E52B2"/><path d="M47.8002 139.857L43.8002 127.057L39.4002 139.857H26.2002L36.9002 147.557L32.9002 160.357L43.8002 152.457L54.4002 160.357L50.3002 147.557L61.2002 139.857H47.8002ZM104.1 139.857L100 127.057L95.8002 139.857H82.6002L93.3002 147.557L89.3002 160.357L100 152.457L110.8 160.357L106.8 147.557L117.5 139.857H104.1ZM160.6 139.857L156.3 127.057L152.3 139.857H138.8L149.8 147.557L145.6 160.357L156.3 152.457L167.3 160.357L163.1 147.557L173.8 139.857H160.6ZM216.8 139.857L212.8 127.057L208.6 139.857H195.3L206.1 147.557L202.1 160.357L212.8 152.457L223.6 160.357L219.3 147.557L230.3 139.857H216.8ZM100 76.2572L95.8002 89.0572H82.6002L93.3002 96.9572L89.3002 109.557L100 101.757L110.8 109.557L106.8 96.9572L117.5 89.0572H104.1L100 76.2572ZM43.8002 76.2572L39.4002 89.0572H26.2002L36.9002 96.9572L32.9002 109.557L43.8002 101.757L54.4002 109.557L50.3002 96.9572L61.2002 89.0572H47.8002L43.8002 76.2572ZM156.3 76.2572L152.3 89.0572H138.8L149.8 96.9572L145.6 109.557L156.3 101.757L167.3 109.557L163.1 96.9572L173.8 89.0572H160.6L156.3 76.2572ZM212.8 76.2572L208.6 89.0572H195.3L206.1 96.9572L202.1 109.557L212.8 101.757L223.6 109.557L219.3 96.9572L230.3 89.0572H216.8L212.8 76.2572ZM43.8002 25.6572L39.4002 38.2572H26.2002L36.9002 46.1572L32.9002 58.8572L43.8002 50.9572L54.4002 58.8572L50.3002 46.1572L61.2002 38.2572H47.8002L43.8002 25.6572ZM100 25.6572L95.8002 38.2572H82.6002L93.3002 46.1572L89.3002 58.8572L100 50.9572L110.8 58.8572L106.8 46.1572L117.5 38.2572H104.1L100 25.6572ZM156.3 25.6572L152.3 38.2572H138.8L149.8 46.1572L145.6 58.8572L156.3 50.9572L167.3 58.8572L163.1 46.1572L173.8 38.2572H160.6L156.3 25.6572ZM212.8 25.6572L208.6 38.2572H195.3L206.1 46.1572L202.1 58.8572L212.8 50.9572L223.6 58.8572L219.3 46.1572L230.3 38.2572H216.8L212.8 25.6572Z" fill="white"/></g><defs><clipPath id="clip0_301_131"><rect width="513" height="342" fill="white" transform="translate(0 0.957031)"/></clipPath></defs></svg>EN</div>`;
  }
}

function showModalLang() {
  Fancybox.show([{ src: "#translate-content", type: "inline" }]);
}

function changeLang(lang) {
  actualLang = lang;
  localStorage.setItem("lang", lang);
  if (lang === "es") {
    document.querySelector(
      "header .right ul li button"
    ).innerHTML = `<svg width="513" height="343" viewBox="0 0 513 343" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_301_1272)"><path d="M0 1H512V343H0V1Z" fill="white"/><path d="M0 1H512V92.2H0V1ZM0 251.8H512V343H0V251.8Z" fill="#D03433"/><path d="M0 92H512V252H0V92Z" fill="#FBCA46"/><path d="M177.493 160.6H200.249V172H177.493V160.6Z" fill="white"/><path d="M163.84 194.8C163.84 201.64 170.667 206.2 177.493 206.2C184.32 206.2 191.147 201.64 191.147 194.8L193.422 160.6H161.564L163.84 194.8ZM150.187 160.6C150.187 153.76 154.738 149.2 159.289 149.2H193.422C200.249 149.2 204.8 153.76 204.8 158.32V160.6L202.524 194.8C200.249 208.48 191.147 217.6 177.493 217.6C163.84 217.6 154.738 208.48 152.462 194.8L150.187 160.6Z" fill="#A41517"/><path d="M154.738 172H200.249V183.4H188.871L177.493 206.2L166.116 183.4H154.738V172ZM120.604 137.8H143.36V217.6H120.604V137.8ZM211.627 137.8H234.382V217.6H211.627V137.8ZM154.738 126.4C154.738 119.56 159.289 115 166.116 115H188.871C195.698 115 200.249 119.56 200.249 126.4V130.96C200.249 135.52 197.973 137.8 193.422 137.8H159.289C157.013 137.8 154.738 135.52 154.738 133.24V126.4Z" fill="#A41517"/></g><defs><clipPath id="clip0_301_1272"><rect width="513" height="342" fill="white" transform="translate(0 0.759766)"/></clipPath></defs></svg>ES</div>`;
  } else {
    document.querySelector(
      "header .right ul li button"
    ).innerHTML = `<svg width="513" height="343" viewBox="0 0 513 343" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_301_131)"><path d="M0 0.957031H513V342.957H0V0.957031Z" fill="white"/><path d="M0 0.957031H513V27.257H0V0.957031ZM0 53.557H513V79.857H0V53.557ZM0 106.157H513V132.457H0V106.157ZM0 158.757H513V185.057H0V158.757ZM0 211.457H513V237.757H0V211.457ZM0 264.057H513V290.357H0V264.057ZM0 316.657H513V342.957H0V316.657Z" fill="#D80027"/><path d="M0 0.957031H256.5V185.057H0V0.957031Z" fill="#2E52B2"/><path d="M47.8002 139.857L43.8002 127.057L39.4002 139.857H26.2002L36.9002 147.557L32.9002 160.357L43.8002 152.457L54.4002 160.357L50.3002 147.557L61.2002 139.857H47.8002ZM104.1 139.857L100 127.057L95.8002 139.857H82.6002L93.3002 147.557L89.3002 160.357L100 152.457L110.8 160.357L106.8 147.557L117.5 139.857H104.1ZM160.6 139.857L156.3 127.057L152.3 139.857H138.8L149.8 147.557L145.6 160.357L156.3 152.457L167.3 160.357L163.1 147.557L173.8 139.857H160.6ZM216.8 139.857L212.8 127.057L208.6 139.857H195.3L206.1 147.557L202.1 160.357L212.8 152.457L223.6 160.357L219.3 147.557L230.3 139.857H216.8ZM100 76.2572L95.8002 89.0572H82.6002L93.3002 96.9572L89.3002 109.557L100 101.757L110.8 109.557L106.8 96.9572L117.5 89.0572H104.1L100 76.2572ZM43.8002 76.2572L39.4002 89.0572H26.2002L36.9002 96.9572L32.9002 109.557L43.8002 101.757L54.4002 109.557L50.3002 96.9572L61.2002 89.0572H47.8002L43.8002 76.2572ZM156.3 76.2572L152.3 89.0572H138.8L149.8 96.9572L145.6 109.557L156.3 101.757L167.3 109.557L163.1 96.9572L173.8 89.0572H160.6L156.3 76.2572ZM212.8 76.2572L208.6 89.0572H195.3L206.1 96.9572L202.1 109.557L212.8 101.757L223.6 109.557L219.3 96.9572L230.3 89.0572H216.8L212.8 76.2572ZM43.8002 25.6572L39.4002 38.2572H26.2002L36.9002 46.1572L32.9002 58.8572L43.8002 50.9572L54.4002 58.8572L50.3002 46.1572L61.2002 38.2572H47.8002L43.8002 25.6572ZM100 25.6572L95.8002 38.2572H82.6002L93.3002 46.1572L89.3002 58.8572L100 50.9572L110.8 58.8572L106.8 46.1572L117.5 38.2572H104.1L100 25.6572ZM156.3 25.6572L152.3 38.2572H138.8L149.8 46.1572L145.6 58.8572L156.3 50.9572L167.3 58.8572L163.1 46.1572L173.8 38.2572H160.6L156.3 25.6572ZM212.8 25.6572L208.6 38.2572H195.3L206.1 46.1572L202.1 58.8572L212.8 50.9572L223.6 58.8572L219.3 46.1572L230.3 38.2572H216.8L212.8 25.6572Z" fill="white"/></g><defs><clipPath id="clip0_301_131"><rect width="513" height="342" fill="white" transform="translate(0 0.957031)"/></clipPath></defs></svg>EN</div>`;
  }

  getTranslateAndReplace();
  Fancybox.close();
}

document.addEventListener("DOMContentLoaded", getTranslateAndReplace);
