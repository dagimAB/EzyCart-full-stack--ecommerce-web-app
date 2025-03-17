

// form validation


  document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".form form");
    const firstName = form.querySelector("input[type='text']:nth-of-type(1)");
    const lastName = form.querySelector("input[type='text']:nth-of-type(2)");
    const phoneNumber = form.querySelector("input[type='tel']");
    const email = form.querySelector("input[type='email']");
    const city = form.querySelector("input[type='text']:nth-of-type(3)");
    const paymentMethods = form.querySelectorAll("input[name='pm']");
    const submitButton = form.querySelector(".submit");

    // Validation function
    function validateForm(event) {
      let isValid = true;
      let errorMessage = "";

      // Validate first name
      if (firstName.value.trim() === "") {
        isValid = false;
        errorMessage += "First Name is required.\n";
      }

      // Validate last name
      if (lastName.value.trim() === "") {
        isValid = false;
        errorMessage += "Last Name is required.\n";
      }

      // Validate phone number
      const phoneRegex = /^[0-9]{10}$/; // Adjust for your locale
      if (!phoneRegex.test(phoneNumber.value.trim())) {
        isValid = false;
        errorMessage += "Phone Number must be 10 digits.\n";
      }

      // Validate email
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email.value.trim())) {
        isValid = false;
        errorMessage += "Invalid Email address.\n";
      }

      // Validate city
      if (city.value.trim() === "") {
        isValid = false;
        errorMessage += "City is required.\n";
      }

      // Validate payment method
      const paymentSelected = Array.from(paymentMethods).some(
        (method) => method.checked
      );
      if (!paymentSelected) {
        isValid = false;
        errorMessage += "Please select a Payment Method.\n";
      }

      // Display error messages or allow submission
      if (!isValid) {
        event.preventDefault();
        alert(errorMessage);
      }
    }

    // Attach validation to the submit button
    submitButton.addEventListener("click", validateForm);
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