// Status filter functionality
document
  .getElementById("status-filter")
  .addEventListener("change", function () {
    const status = this.value;
    const rows = document.querySelectorAll(".order-table tbody tr");

    rows.forEach((row) => {
      const rowStatus = row.getAttribute("data-status");
      if (status === "all" || rowStatus === status) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });

// Date filter functionality
document.getElementById("date-filter").addEventListener("change", function () {
  const date = this.value;
  const rows = document.querySelectorAll(".order-table tbody tr");

  rows.forEach((row) => {
    const rowDate = row.getAttribute("data-date");
    if (!date || rowDate === date) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
});
