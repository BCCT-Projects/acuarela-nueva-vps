<div id="cookie-modal-overlay" class="cookie-overlay">
  <div id="cookie-modal" class="cookie-modal">
    <h2>AVISO DE COOKIES</h2>
    <p>Tu privacidad es importante para nosotros</p>
    <p>
      Utilizamos cookies propias y de terceros para ofrecerte una mejor experiencia en nuestra 
      plataforma, habilitar funcionalidades esenciales, analizar el uso de nuestros servicios y 
      mostrarte contenidos personalizados según tus preferencias y hábitos de navegación.  
      Puedes obtener más información en nuestra 
      <a href="/politicas-privacidad/" target="_blank" class="cookie-link">Política de privacidad</a>.
    </p>
    
    <div class="cookie-buttons">
      <button onclick="acceptCookies()" class="btn btn-menta">Aceptar todas las cookies</button>
      <button onclick="rejectCookies()" class="btn btn-menta btn-menta-2">Rechazar cookies</button>
      <button onclick="openConfig()" class="btn btn-menta btn-menta-2">Configurar</button>
    </div>
  </div>
</div>
<!-- Modal de configuración -->
<div id="cookie-config-modal" class="cookie-overlay">
  <div class="cookie-modal">
    <h2>Configuración de cookies</h2>
    <form id="cookie-preferences-form">
      <label>
        <input type="checkbox" name="essential" checked disabled>
        Cookies esenciales (siempre activas)
      </label>
      <label>
        <input type="checkbox" name="analytics">
        Cookies de análisis
      </label>
      <label>
        <input type="checkbox" name="marketing">
        Cookies de marketing
      </label>
      <div class="cookie-buttons">
        <button type="button" class="btn btn-menta" onclick="savePreferences()">Guardar preferencias</button>
        <button type="button" class="btn btn-menta btn-menta-2" onclick="closeConfig()">Cancelar</button>
      </div>
    </form>
  </div>
</div>
