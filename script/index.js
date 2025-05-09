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

const list = document.querySelector(".list");
const countSpan = document.querySelector(".count");

const products = [
  {
    id: 15,
    image: "./Resources/images/WomenWatches.jpg",
    name: "Women's watch",
    description:
      "Watches Women with Date Silver Stainless Steel Luxury Ladies Watches with Small Wrists Diamond",
    price: 20,
  },
  {
    id: 25,
    image: "./Resources/images/Watches.jpg",
    name: "Men's Watches",
    description: "Amazon Essentials Men's Faux Leather Strap Watch",
    price: 60,
  },
  {
    id: 35,
    image: "./Resources/images/Desktops.jpg",
    name: "Desktops",
    description:
      'All-in-One Desktop, 24" FHD Display, Intel Core i5-8500T up to 3.5GHz, 16G DDR4 Memory, 512G SSD.',
    price: 60,
  },
  {
    id: 45,
    image: "./Resources/images/PlayStation.jpg",
    name: "PlayStation",
    description:
      "BGGUANG PS5 Slim Cooling Station, Charging Controller, Featuring Three Adjustable Cooling Fan.",
    price: 29,
  },
  {
    id: 55,
    image: "./Resources/images/jacket.jpg",
    name: "Hooded Shirt Jacket",
    description: "Legendary Whitetails Men's Maplewood Hooded Shirt Jacket.",
    price: 55,
  },
  {
    id: 65,
    image: "./Resources/images/mensblouse.avif",
    name: "Men's Blouse",
    description:
      "Men's Cotton Henley Shirt Long Sleeve Hippie Casual Beach T Shirts.",
    price: 29,
  },
  {
    id: 75,
    image: "./Resources/images/mensJeans.avif",
    name: "Men's Jeans",
    description:
      "Men's Slim Fit Jeans Stretch Destroyed Ripped Skinny Jeans Side Striped Denim Pants.",
    price: 35,
  },
  {
    id: 85,
    image: "./Resources/images/mensSweater.avif",
    name: "Men's Sweater",
    description:
      "EzyCart Essentials Men's Crewneck Sweater (Available in Big & Tall).",
    price: 22,
  },
  {
    id: 95,
    image: "./Resources/images/mensDailyCloth.avif",
    name: "Men's Daily Clothes",
    description:
      "EzyCart Essentials Men's Daily Clothes (Available in Big & Tall).",
    price: 20,
  },
  {
    id: 105,
    image: "./Resources/images/short-sweater.jpg",
    name: "Short Sweaters",
    description:
      "Women's See Through Hole Ripped Crop Tops Knit Pullover Short Sweaters.",
    price: 34,
  },
  {
    id: 115,
    image: "./Resources/images/womensDailyClothes.avif",
    name: "Women's Daily Clothes",
    description:
      "EzyCart Essentials Women's Daily Clothes (Available in Big & Tall).",
    price: 30,
  },
  {
    id: 125,
    image: "./Resources/images/Dresses2.avif",
    name: "Dresses",
    description:
      "Womens Square Neck Long Sleeve Fall Dresses Casual Babydoll Sweater Dress.",
    price: 25,
  },
  {
    id: 135,
    image: "./Resources/images/womenSweater.avif",
    name: "Women's Sweater",
    description:
      "Womens Square Neck Long Sleeve Fall Dresses Casual Babydoll Sweaters.",
    price: 29,
  },
  {
    id: 145,
    image: "./Resources/images/womensBlouse.avif",
    name: "Women's Blouse",
    description:
      "Womens Square Neck Long Sleeve Fall Dresses Casual Babydoll Blouse T-shirt.",
    price: 27,
  },
  {
    id: 155,
    image: "./Resources/images/luxury-gold-diamond-jewelry.avif",
    name: "Luxury Diamond Jewelry",
    description:
      "Certified NATURAL Diamond Solid Gold Bezel Set Diamond Necklace, Diamond Necklace for Women.",
    price: 290,
  },
  {
    id: 165,
    image: "./Resources/images/beautiful-golden-bracelets.avif",
    name: "Beautiful Golden Bracelets",
    description:
      "Diamond Solid Gold Bezel Set Diamond Necklace, Diamond Ring for Men's.",
    price: 270,
  },
  {
    id: 175,
    image: "./Resources/images/gold-necklaces.avif",
    name: "Gold Necklaces",
    description:
      "NATURAL Diamond Solid Gold Bezel Set Diamond Necklace, Diamond Necklace for Women.",
    price: 310,
  },
  {
    id: 185,
    image: "./Resources/images/diamond-rings-necklaces.avif",
    name: "Diamond Rings And Necklaces",
    description:
      "Certified NATURAL Diamond Solid Gold Bezel Set Diamond Rings Women.",
    price: 340,
  },
  {
    id: 195,
    image: "./Resources/images/earrings.jpg",
    name: "Crystal Earrings",
    description:
      "Attract Trilogy Crystal Necklace and Earrings Jewelry Collection.",
    price: 339,
  },
  {
    id: 205,
    image: "./Resources/images/toyota.webp",
    name: "Toyota",
    description: "Toyota - Known for reliability and efficiency worldwide",
    price: 1050,
  },
  {
    id: 215,
    image: "./Resources/images/Ford car without background.png",
    name: "Ford",
    description:
      "Ford is known for its trucks, SUVs, and cars, including the F-150, Mustang, and Explorer.",
    price: 1040,
  },
  {
    id: 225,
    image: "./Resources/images/Honda car without background.png",
    name: "Honda",
    description:
      "Honda known for its high-quality vehicles and motorcycles. Popular models include the Civic, Accord, and CR-V.",
    price: 1100,
  },
  {
    id: 235,
    image: "./Resources/images/BMW car without background.png",
    name: "BMW",
    description:
      "BMW is known for its performance and luxury vehicles, including the 3 Series, 5 Series, and X5.",
    price: 1190,
  },
  {
    id: 245,
    image: "./Resources/images/Chevrolet without background.png",
    name: "Chevrolet",
    description:
      "Chevy, is an American automobile division of General Motors. Popular models include the Silverado, Malibu, and Equinox.",
    price: 1170,
  },
  {
    id: 255,
    image: "./Resources/images/ninja.jpg",
    name: "Ninja Cook",
    description:
      "Ninja DZ201 Foodi 8 Quart 6-in-1 DualZone 2-Basket Air Fryer with 2 Independent Frying Baskets, Match Cook.",
    price: 50,
  },
  {
    id: 265,
    image: "./Resources/images/mixing -bowls.jpg",
    name: "Mixing Bowls",
    description:
      "Mixing Bowls with Airtight Lids Set, 26PCS Stainless Steel Khaki Bowls with Grater Attachments, Non-Slip.",
    price: 50,
  },
  {
    id: 275,
    image: "./Resources/images/cookware.jpg",
    name: "Cookware Set",
    description:
      "Cuisinart 11-Piece Cookware Set, Chef's Classic Stainless Steel Collection 77-11G.",
    price: 20,
  },
  {
    id: 285,
    image: "./Resources/images/kitchenaid.jpg",
    name: "KitchenAid",
    description:
      "KitchenAid Large Capacity Full Size Rust Resistant Dish Rack with Angled Drain Board and Removable Flatware Caddy.",
    price: 25,
  },
  {
    id: 295,
    image: "./Resources/images/hairstraightener.jpg",
    name: "Hair Straightener Brush",
    description:
      "Hair Straightener Brush, TYMO Ring Hair Straightener Comb Straightening Brush.",
    price: 39,
  },
  {
    id: 305,
    image: "./Resources/images/hairoil.jpg",
    name: "Hair Oil",
    description:
      "Elizavecca CER-100 Hair Essence Oil - Leave-In Treatment for Dry Hair.",
    price: 19,
  },
  {
    id: 315,
    image: "./Resources/images/facemask.jpg",
    name: "Face Mask Paper",
    description:
      "Project E Beauty 100pcs Disposable DIY Non-Woven Face Mask Paper Pre-Cut.",
    price: 29,
  },
  {
    id: 315,
    image: "./Resources/images/shampo.jpg",
    name: "Shampoo",
    description:
      "COLOR WOW Color Security Shampoo – Sulfate Free & Residue-Free Formula.",
    price: 19,
  },
  {
    id: 325,
    image: "./Resources/images/toy1.jpg",
    name: "NATIONAL GEOGRAPHIC",
    description:
      "NATIONAL GEOGRAPHIC Glowing Marble Run – Construction Set with 15 Glow in The Dark Glass Marbles.",
    price: 10,
  },
  {
    id: 335,
    image: "./Resources/images/toy2.jpg",
    name: "Lego Gear Bots",
    description:
      "Klutz Lego Gear Bots Science/STEM Activity Kit for 8-12 years.",
    price: 10,
  },
  {
    id: 345,
    image: "./Resources/images/dart.jpg",
    name: "Magnetic Dart Board",
    description:
      "Magnetic Dart Board - 12pcs Magnetic Darts - Excellent Indoor Game and Party Games.",
    price: 10,
  },
  {
    id: 355,
    image: "./Resources/images/rocket_launcher.jpg",
    name: "Rocket Launcher",
    description:
      "Toys Rocket Launcher for Kids - Launch up to 100 Ft, 8 Multi-Color Foam Rockets & Adjustable Launch Stand.",
    price: 12,
  },
];



const initApp = () => {
  products.forEach((product, index) => {
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
};
initApp();



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