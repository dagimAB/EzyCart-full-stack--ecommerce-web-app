document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("togglePassword")
    .addEventListener("click", function () {
      const passwordInput = document.getElementById("password");
      const type =
        passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);

      // Toggle eye icon (optional)
      this.textContent = type === "password" ? "👁️" : "👁️‍🗨️";
    });

  document
    .getElementById("signInForm")
    .addEventListener("submit", function (e) {
      // Prevent the form from submitting
      e.preventDefault();

      // Get input values
      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value.trim();

      // Email validation regex
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      // Password validation regex
      const passwordRegex =
        /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

      // Validation flags and error message
      let isValid = true;
      let errorMessage = "";

      // Check if all fields are filled
      if (!email || !password) {
        isValid = false;
        errorMessage += "All fields are required.\n";
      }

      // Validate email format
      if (email && !emailRegex.test(email)) {
        isValid = false;
        errorMessage += "Please enter a valid email address.\n";
      }

      // Validate password complexity
      if (password && !passwordRegex.test(password)) {
        isValid = false;
        errorMessage +=
          "Password must be at least 8 characters long, contain one uppercase letter, one number, and one special character.\n";
      }

      // Show error messages or submit the form
      if (!isValid) {
        alert(errorMessage);
      } else {
        // Submit the form if validation passes
        this.submit();
      }
    });

  // Dropdown functionality
  const dropdownButton = document.querySelector(".header_drop_down");
  const hiddenContent = document.querySelector(".hidden-content");


  // Toggle visibility when dropdown button is clicked
  dropdownButton.addEventListener("click", () => {
    hiddenContent.classList.toggle("active");
  });

  // Close the dropdown if clicked outside
  document.addEventListener("click", (e) => {
    if (
      !dropdownButton.contains(e.target) &&
      !hiddenContent.contains(e.target)
    ) {
      hiddenContent.classList.remove("active");
    }
  });
});


