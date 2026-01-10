// Función general para enviar eventos a Google Analytics
/*function sendAnalyticsEvent(
    category,
    action,
    label,
    additionalData = {},
    eventName
  ) {
    // Utiliza el nombre del evento proporcionado o un valor predeterminado ('custom_event')
    console.log('Evento enviado a Google Analytics');
    const eventToTrack = eventName || "custom_event";
    console.log("Data adicional: ", additionalData);
    // Envía el evento a Google Analytics
    gtag("event", eventToTrack, {
      event_category: category,
      event_action: action,
      event_label: label,
      ...additionalData,
    });
  }

  function trackLoginSuccess(userId) {
    // Llama a sendAnalyticsEvent con el ID del usuario
    console.log("Tracking Login Success");
    sendAnalyticsEvent(
      "success",
      "login",
      "Inicio de sesión exitoso",
      { id_user: userId },
      "login"
    );
  }
  
  function trackLoginError(errorType) {
    console.log("Tracking Login Error");
    sendAnalyticsEvent(
      "error",
      "login",
      "Error de inicio de sesión",
      { error_type: errorType },
      "login"
    );
  }
  
  function trackNewUserRegistration() {
    sendAnalyticsEvent(
      "success",
      "registration",
      "Nuevo usuario registrado",
      {},
      "registration_new_user"
    );
  }
  
  function trackPasswordRecovery() {
    sendAnalyticsEvent(
      "success",
      "password_recovery",
      "Recuperación de contraseña exitosa",
      {},
      "password_recovery"
    );
  }
  
  function trackDaycareCreate() {
    sendAnalyticsEvent(
      "create", 
      "daycare", 
      "Daycare creado", 
      {}, 
      "create_daycare"
    );
  }
  
  function trackDaycareUpdate() {
    sendAnalyticsEvent(
      'update', 
      'daycare', 
      'Daycare actualizado', 
      {}, 
      'update_daycare'
    );
  }

  function trackCurriculumActivity(activity){
    sendAnalyticsEvent(
      'activity',
      'pop_up',
      'Abrir actividad',
      { activity_category: activity},
      'open_activity'
    );
  }

  function trackCreatedMenus(result){
    sendAnalyticsEvent(
      'create', 
      'menus', 
      'Creación de menú', 
      { 'Resultado del menú': result }, 
      'created_menuIA'
    );
  }*/