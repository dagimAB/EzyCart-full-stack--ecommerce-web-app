
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