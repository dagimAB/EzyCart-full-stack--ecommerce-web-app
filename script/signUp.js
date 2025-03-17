
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
    .getElementById("togglePassword2")
    .addEventListener("click", function () {
      const passwordInput = document.getElementById("confirmPassword");
      const type =
        passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);

      // Toggle eye icon (optional)
      this.textContent = type === "password" ? "👁️" : "👁️‍🗨️";
    });



document
  .getElementById("registrationForm")
  .addEventListener("submit", function (e) {
    // Prevent form submission
    e.preventDefault();

    // Get input values
    const fname = document.getElementById("fname").value.trim();
    const lname = document.getElementById("lname").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const confirmPassword = document
      .getElementById("confirmPassword")
      .value.trim();
    const city = document.getElementById("city").value.trim();
    const dob = document.getElementById("dob").value;

    // Validation flags and error message
    let isValid = true;
    let errorMessage = "";

    // Check if all fields are filled
    if (
      !fname ||
      !lname ||
      !phone ||
      !email ||
      !password ||
      !confirmPassword ||
      !city ||
      !dob
    ) {
      isValid = false;
      errorMessage += "All fields are required.\n";
    }

    // Validate phone number length
    if (phone.length !== 10 && phone.length !== 13) {
      isValid = false;
      errorMessage += "Phone number must be exactly 10 or 13 characters long.\n";
    }

    // Validate password complexity
    const passwordRegex =
      /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (password && !passwordRegex.test(password)) {
      isValid = false;
      errorMessage +=
        "Password must be at least 8 characters long, contain one uppercase letter, one number, and one special character.\n";
    }

    // Validate confirm password
    if (password !== confirmPassword) {
      isValid = false;
      errorMessage += "Passwords do not match.\n";
    }

    // Validate date of birth
    if (dob) {
      const today = new Date();
      const birthDate = new Date(dob);
      if (birthDate >= today) {
        isValid = false;
        errorMessage += "Date of birth must be in the past.\n";
      }
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
document.addEventListener("DOMContentLoaded", function () {
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