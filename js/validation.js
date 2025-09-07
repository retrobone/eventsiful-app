document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.querySelector('form[action="login.php"]');

  if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
      const emailInput = document.getElementById("email");
      const passwordInput = document.getElementById("password");
      const emailError = document.getElementById("email-error");
      const passwordError = document.getElementById("password-error");

      let isValid = true;
      emailError.textContent = "";
      passwordError.textContent = "";

      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(emailInput.value)) {
        emailError.textContent = "Please enter a valid email address.";
        isValid = false;
      }

      if (passwordInput.value.trim() === "") {
        passwordError.textContent = "Password cannot be empty.";
        isValid = false;
      }

      if (!isValid) {
        event.preventDefault();
      }
    });
  }
  const registerForm = document.querySelector('form[action="register.php"]');

  if (registerForm) {
    registerForm.addEventListener("submit", function (event) {
      const nameInput = document.getElementById("name");
      const emailInput = document.getElementById("email");
      const passwordInput = document.getElementById("password");

      const nameError = document.getElementById("name-error");
      const emailError = document.getElementById("email-error");
      const passwordError = document.getElementById("password-error");

      let isValid = true;
      nameError.textContent = "";
      emailError.textContent = "";
      passwordError.textContent = "";

      if (nameInput.value.trim() === "") {
        nameError.textContent = "Name cannot be empty.";
        isValid = false;
      }

      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(emailInput.value)) {
        emailError.textContent = "Please enter a valid email address.";
        isValid = false;
      }

      if (passwordInput.value.length < 8) {
        passwordError.textContent =
          "Password must be at least 8 characters long.";
        isValid = false;
      }

      if (!isValid) {
        event.preventDefault();
      }
    });
  }
});
