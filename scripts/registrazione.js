function jsonCheckUsername(json) {
  if ((formStatus.username = !json.exists)) {
    document.querySelector(".username").classList.remove("errorj");
  } else {
    document.querySelector(".erroreusername").textContent =
      "ATTENZIONE USERNAME GIA REGISTRATO";
    document.querySelector(".username").classList.add("errorj");
  }
}
function jsonCheckEmail(json) {
  if ((formStatus.email = !json.exists)) {
    document.querySelector(".email").classList.remove("errorj");
  } else {
    document.querySelector(".erroreemail").textContent =
      "ATTENZIONE EMAIL GIA REGISTRATA";
    document.querySelector(".email").classList.add("errorj");
  }
}

function fetchResponse(response) {
  if (!response.ok) return null;
  return response.json();
}

function checkName(event) {
  const name = document.querySelector(".name input");
  if (!/^[a-zA-Z_]{1,20}$/.test(name.value)) {
    document.querySelector(".errorename").textContent =
      "ATTENZIONE NOME non valido";
    name.parentNode.classList.add("errorj");
    formStatus.name = false;
    checkForm();
  } else {
    name.parentNode.classList.remove("errorj");
    document.querySelector(".errorename").textContent = "";
  }
}
function checkSurname(event) {
  const sur = document.querySelector(".surname input");
  if (!/^[a-zA-Z_]{1,20}$/.test(sur.value)) {
    document.querySelector(".erroresurname").textContent =
      "ATTENZIONE COGNOME non valido";
    sur.parentNode.classList.add("errorj");
    formStatus.sur = false;
    checkForm();
  } else {
    sur.parentNode.classList.remove("errorj");
    document.querySelector(".erroresurname").textContent = "";
  }
}

function checkUsername(event) {
  const input = document.querySelector(".username input");
  if (!/^[a-zA-Z0-9_]{1,15}$/.test(input.value)) {
    document.querySelector(".erroreusername").textContent =
      "ATTENZIONE USERNAME non valido";
    input.parentNode.classList.add("errorj");
    formStatus.username = false;
    checkForm();
  } else {
    document.querySelector(".erroreusername").textContent = "";
    fetch("check_username.php?q=" + encodeURIComponent(input.value))
      .then(fetchResponse)
      .then(jsonCheckUsername);
  }
}

function checkEmail(event) {
  const emailInput = document.querySelector(".email input");

  if (
    !/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\a@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
      String(emailInput.value).toLowerCase()
    )
  ) {
    document.querySelector(".erroreemail").textContent =
      "ATTENZIONE EMAIL non valida";
    emailInput.parentNode.classList.add("errorj");
    formStatus.email = false;
    checkForm();
  } else {
    document.querySelector(".erroreemail").textContent = "";
    fetch("check_email.php?q=" + encodeURIComponent(emailInput.value))
      .then(fetchResponse)
      .then(jsonCheckEmail);
  }
}

function checkPassword(event) {
  const passwordInput = document.querySelector(".password input");
  if ((formStatus.password = passwordInput.value.length < 6)) {
    document.querySelector(".errorepassword").textContent =
      "ATTENZIONE PASSWORD troppo corta";
    document.querySelector(".password").classList.add("errorj");
    checkForm();
  } else {
    if(/^[A-Za-z0-9]/.test(passwordInput.value)&&/[0-9]/.test(passwordInput.value)&&/[A-Z]/.test(passwordInput.value)&&/[A-Za-z0-9]$/.test(passwordInput.value)){
    document.querySelector(".errorepassword").textContent = "";
    document.querySelector(".password").classList.remove("errorj");
    }
    else{
      document.querySelector(".errorepassword").textContent =
      "ATTENZIONE PASSWORD deve contenere almeno una maiscola ed un numero ";
    document.querySelector(".password").classList.add("errorj");
    checkForm();
    }
  }
}

function confirm_password(event) {
  const confirmPasswordInput = document.querySelector(
    ".confirm_password input"
  );
  if (
    (formStatus.confirmPassword =
      confirmPasswordInput.value ===
      document.querySelector(".password input").value)
  ) {
    document.querySelector(".erroreconfirm").textContent = "";
    document.querySelector(".confirm_password").classList.remove("errorj");
  } else {
    document.querySelector(".erroreconfirm").textContent =
      "ATTENZIONE CONFERMA PASSWORD: non coincide con la password";
    document.querySelector(".confirm_password").classList.add("errorj");
    checkForm();
  }
}

function checkForm() {
  Object.keys(formStatus).length != 6 ||
    Object.values(formStatus).includes(false);
}

const formStatus = { upload: true };
document.querySelector(".email input").addEventListener("blur", checkEmail);
document.querySelector(".name input").addEventListener("blur", checkName);
document.querySelector(".surname input").addEventListener("blur", checkSurname);
document
  .querySelector(".username input")
  .addEventListener("blur", checkUsername);
document
  .querySelector(".password input")
  .addEventListener("blur", checkPassword);
document
  .querySelector(".confirm_password input")
  .addEventListener("blur", confirm_password);
