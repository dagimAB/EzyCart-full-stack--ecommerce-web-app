const list = document.querySelector(".list");
const countSpan = document.querySelector(".count");

const initApp = async () => {
  try {
    const response = await fetch("./api/get_products.php");
    if (!response.ok) {
      // Handle non-successful HTTP responses
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const products = await response.json();


    products.forEach((product) => {
      let newDiv = document.createElement("div");
      newDiv.innerHTML = `
        <div class="card_container">
          <img src="${product.image}">
          <h3>${product.name}</h3>
          <div class="description"><p>${product.description}</p></div>
          <br/>
          <div class="price">Price: <span>$${product.price}</span></div>
        </div>
      `;
      list.appendChild(newDiv);
    });
  } catch (error) {
    console.error("Error fetching products:", error);
    list.innerHTML = "<p>Failed to load products. Please try again later.</p>";
  }
};
initApp();








// button header slider
const btn1 = document.querySelector(".slider_control_left");
const btn2 = document.querySelector(".slider_control_right");

const imgs = document.querySelectorAll(".image_slider ul img");
let n = 0;

function changeSlide() {
  for (let i = 0; i < imgs.length; i++) {
    imgs[i].style.display = "none";
  }
  imgs[n].style.display = "block";
}
changeSlide();

btn1.addEventListener("click", (e) => {
  if (n > 0) {
    n--;
  } else {
    n = imgs.length - 1;
  }
  changeSlide();
});

btn2.addEventListener("click", (e) => {
  if (n < imgs.length - 1) {
    n++;
  } else {
    n = 0;
  }
  changeSlide();
});







//header toggle

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





// //handle the search functionality
function redirectToCategory() {
  const select = document.getElementById("categorySelect");
  const selectedOption = select.options[select.selectedIndex];
  const redirectUrl = selectedOption.getAttribute("data-redirect");

  if (redirectUrl) {
    window.location.href = redirectUrl;
    return false;
  }
  return true;
}

document.getElementById("searchForm").addEventListener("submit", function (e) {
  const select = document.getElementById("categorySelect");
  const selectedOption = select.options[select.selectedIndex];
  if (selectedOption.getAttribute("data-redirect")) {
    e.preventDefault();
  }
});






// // // Books and Movies slider
document.addEventListener("DOMContentLoaded", function () {
  // Function to initialize slider
  function initSlider(sliderWrapper) {
    const slider = sliderWrapper.querySelector(".product_slider");
    const products = slider.querySelector(".products");
    const items = Array.from(products.querySelectorAll("img"));

    // Calculate total width needed
    const itemWidth =
      items[0].offsetWidth +
      parseInt(window.getComputedStyle(items[0]).marginRight);
    const visibleItems = Math.ceil(products.offsetWidth / itemWidth);
    const totalItems = items.length;

    // Clone items to fill the visible space plus buffer
    const clonesNeeded = Math.ceil((visibleItems * 2) / totalItems);
    for (let i = 0; i < clonesNeeded; i++) {
      items.forEach((item) => {
        const clone = item.cloneNode(true);
        products.appendChild(clone);
      });
    }

    let animationId;
    let speed = 1; // Default speed
    let position = 0;
    const scrollSpeed = 1; // Base scroll speed
    const totalWidth = itemWidth * (totalItems * (clonesNeeded + 1));

    function animate() {
      position -= speed;

      // Reset position when we've scrolled one full set of items
      if (position <= -itemWidth * totalItems) {
        position = 0;
      }

      products.style.transform = `translateX(${position}px)`;
      animationId = requestAnimationFrame(animate);
    }

    // Start animation
    animate();

    // Event listeners for hover
    slider.addEventListener("mouseenter", () => {
      speed = scrollSpeed * 0.3; // Slow down on hover
    });

    slider.addEventListener("mouseleave", () => {
      speed = scrollSpeed; // Return to normal speed
    });
  }

  // Initialize all sliders
  const sliders = document.querySelectorAll(".product_slider_wrapper");
  sliders.forEach((sliderWrapper) => {
    initSlider(sliderWrapper);
  });
});