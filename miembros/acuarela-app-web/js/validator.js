class FormValidator {
  constructor(form, fields, handleResponse) {
    this.form = form;
    this.fields = fields;
    this.handleResponse = handleResponse;
  }

  initialize() {
    this.validateOnEntry();
    this.validateOnSubmit();
  }

  validateOnSubmit() {
    let self = this;

    this.form.addEventListener("submit", (e) => {
      e.preventDefault();
      let isValid = true;
      self.fields.forEach((field) => {
        const input = document.querySelector(`#${field}`);
        if (!self.validateFields(input)) {
          isValid = false;
        }
      });

      if (isValid) {
        // If all fields are valid, submit the form via AJAX
        self.ajaxSubmit();
      }
    });
  }

  ajaxSubmit() {
    fadeIn(preloader);
    // Serialize form data
    const formData = new FormData(this.form);

    // Make AJAX request
    fetch(this.form.action, {
      method: this.form.method,
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        this.handleResponse(data); // Handle response data using the provided function
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }

  validateOnEntry() {
    let self = this;
    this.fields.forEach((field) => {
      const input = document.querySelector(`#${field}`);

      input.addEventListener("input", (event) => {
        self.validateFields(input);
      });
    });
  }

  validateFields(field) {
    // Check presence of values
    if (field.value.trim() === "") {
      this.setStatus(
        field,
        `${
          field.previousElementSibling
            ? field.previousElementSibling.innerText
            : field.placeholder
        } es obligatorio`,
        "error"
      );
      return false;
    } else {
      this.setStatus(field, null, "success");
    }

    // check for a valid email address
    if (field.type === "email") {
      const re = /\S+@\S+\.\S+/;
      if (re.test(field.value)) {
        this.setStatus(field, null, "success");
      } else {
        this.setStatus(
          field,
          "Por favor ingresa un correo electrónico válido",
          "error"
        );
        return false;
      }
    }

    // Password confirmation edge case
    if (field.id === "password_confirmation") {
      const passwordField = this.form.querySelector("#password");

      if (field.value.trim() == "") {
        this.setStatus(
          field,
          "Se requiere confirmación de contraseña",
          "error"
        );
        return false;
      } else if (field.value != passwordField.value) {
        this.setStatus(field, "La contraseña no coincide", "error");
        return false;
      } else {
        this.setStatus(field, null, "success");
      }
    }

    return true;
  }

  setStatus(field, message, status) {
    const errorMessage = field.parentElement.querySelector(".error-message");

    if (status === "success") {
      if (errorMessage) {
        errorMessage.innerText = "";
      }
      field.classList.remove("input-error");
    }

    if (status === "error") {
      field.parentElement.querySelector(".error-message").innerText = message;
      field.classList.add("input-error");
    }
  }
}
const createAsistenteForm = document.querySelector("#createAsistente");
if (createAsistenteForm) {
  const createAsistenteFormFields = [
    "nombres",
    "apellidos",
    "email",
    "fecha-de-nacimiento",
    "telefono",
    "calle",
    "codigo-postal",
    "estado",
    "ciudad",
  ];
  // Función de manejo de respuesta al crear asistente
  async function handleResponse(data) {
    fadeOut(preloader);
    
    if (data.entity && (data.entity.id || data.entity._id)) {
      const { name, lastname, mail } = data.entity;
      
      // Mostrar modal de éxito
      showSuccessModal(
        "¡Asistente creado exitosamente!",
        `<p><strong>${name} ${lastname}</strong> ha sido agregado como asistente.</p>
         <p style="margin-top: 10px;">Se ha enviado un correo de activación a <strong>${mail}</strong> para que pueda crear su contraseña y acceder a la aplicación.</p>`,
        () => {
          window.location.href = "/miembros/acuarela-app-web/asistentes";
        }
      );
    } else {
      // Error al crear
      alert("Hubo un error al crear el asistente. Por favor intenta de nuevo.");
    }
  }
  const validator = new FormValidator(
    createAsistenteForm,
    createAsistenteFormFields,
    handleResponse
  );

  validator.initialize();
}

// Función para mostrar modal de éxito
function showSuccessModal(title, message, onClose) {
  // Crear el modal si no existe
  let modal = document.getElementById('successModal');
  if (!modal) {
    modal = document.createElement('div');
    modal.id = 'successModal';
    modal.innerHTML = `
      <div class="modal-overlay"></div>
      <div class="modal-content">
        <div class="modal-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#0cb5c3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
        </div>
        <h2 class="modal-title"></h2>
        <div class="modal-message"></div>
        <button class="modal-button">Aceptar</button>
      </div>
    `;
    document.body.appendChild(modal);
    
    // Agregar estilos del modal
    const style = document.createElement('style');
    style.textContent = `
      #successModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10000;
      }
      #successModal.active {
        display: flex;
        justify-content: center;
        align-items: center;
      }
      #successModal .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
      }
      #successModal .modal-content {
        position: relative;
        background: white;
        border-radius: 16px;
        padding: 40px;
        max-width: 420px;
        width: 90%;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        animation: modalSlideIn 0.3s ease;
      }
      @keyframes modalSlideIn {
        from {
          opacity: 0;
          transform: translateY(-20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      #successModal .modal-icon {
        margin-bottom: 20px;
      }
      #successModal .modal-title {
        color: #333;
        font-size: 1.4rem;
        margin-bottom: 15px;
      }
      #successModal .modal-message {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 25px;
      }
      #successModal .modal-message strong {
        color: #0cb5c3;
      }
      #successModal .modal-button {
        background: #0cb5c3;
        color: white;
        border: none;
        padding: 12px 40px;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
      }
      #successModal .modal-button:hover {
        background: #0a9aa6;
      }
    `;
    document.head.appendChild(style);
  }
  
  // Actualizar contenido
  modal.querySelector('.modal-title').textContent = title;
  modal.querySelector('.modal-message').innerHTML = message;
  
  // Mostrar modal
  modal.classList.add('active');
  
  // Manejar cierre
  const closeModal = () => {
    modal.classList.remove('active');
    if (onClose) onClose();
  };
  
  modal.querySelector('.modal-button').onclick = closeModal;
  modal.querySelector('.modal-overlay').onclick = closeModal;
}
const editAsistenteForm = document.querySelector("#editAsistente");
if (editAsistenteForm) {
  const editAsistenteFormFields = [
    "nombres",
    "apellidos",
    "fecha-de-nacimiento",
    "telefono",
    "calle",
    "codigo-postal",
    "estado",
    "ciudad",
  ];
  // Función de manejo de respuesta dinámica Login
  async function handleResponse(data) {
    fadeOut(preloader);
    window.location.reload();
  }
  const validator = new FormValidator(
    editAsistenteForm,
    editAsistenteFormFields,
    handleResponse
  );

  validator.initialize();
}

const createGroup = document.querySelector("#createGroup");
if (createGroup) {
  const createGroupFields = ["acuarelauser", "edades", "shift", "name"];
  // Función de manejo de respuesta dinámica Login
  function handleResponse(data) {
    fadeOut(preloader);
    window.location.href = "/miembros/acuarela-app-web/grupos";
  }
  const validator = new FormValidator(
    createGroup,
    createGroupFields,
    handleResponse
  );

  validator.initialize();
}

const editGroup = document.querySelector("#editGroup");
if (editGroup) {
  const editGroupFields = ["acuarelauser", "edades", "shift"];
  // Función de manejo de respuesta dinámica Login
  function handleResponse(data) {
    console.log(data);
    fadeOut(preloader);
    window.location.href = `/miembros/acuarela-app-web/grupo/${
      document.querySelector("main").dataset.groupid
    }`;
  }
  const validator = new FormValidator(
    editGroup,
    editGroupFields,
    handleResponse
  );

  validator.initialize();
}

const Comment = document.querySelector("#add-comment");
if (Comment) {
  const CommentFields = ["acuarelauser"];

  // Función de manejo de respuesta dinámica Login
  function handleResponse(data) {
    fadeOut(preloader);
    window.location.href = "/miembros/acuarela-app-web/grupos";
  }
  const validator = new FormValidator(Comment, CommentFields, handleResponse);

  validator.initialize();
}
