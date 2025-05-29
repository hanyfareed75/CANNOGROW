const items = [];
const products = [];
let product = null;

const api = "https://cannigrow.free.nf/managment/api/orderAPI.php";
const product_api = "https://cannigrow.free.nf/managment/api/s_product.php";

let selectedProduct, totalInput, qtyInput, messageBox;

window.onload = function () {
  // Initialize elements
  selectedProduct = document.getElementById("product_id");
  totalInput = document.getElementById("total");
  qtyInput = document.getElementById("qty");
  messageBox = document.getElementById("message");

  // Set date
  document.getElementById("created_at").value = setDate();

  // Load data
  fetchProduct();
  fetchData();

  // Event listeners
  document.getElementById("addtocart").addEventListener("click", addToCart);
  document.getElementById("addorder").addEventListener("click", postOrders);

  qtyInput.addEventListener("change", () => {
    getProductPrice(selectedProduct.value);
  });

  selectedProduct.addEventListener("change", function () {
    qtyInput.value = 1;
    getProductPrice(this.value);
  });
};

// Fetch last order ID
function fetchData() {
  fetch(api)
    .then((res) => res.json())
    .then((data) => {
      document.getElementById("order_id").value = data[0].order_id + 1;
    })
    .catch((err) => {
      messageBox.innerHTML = "Error loading Order ID from API";
      console.error("Order ID API Error:", err);
    });
}

// Get today's date in Egypt time
function setDate() {
  const now = new Date();
  const egyptOffset = 2 * 60; // minutes
  const egyptTime = new Date(
    now.getTime() + (egyptOffset - now.getTimezoneOffset()) * 60000
  );
  return egyptTime.toISOString().split("T")[0];
}

// Add product to cart
function addToCart() {
  const item = {
    order_id: document.getElementById("order_id").value,
    product_index: items.length + 1,
    product_name: selectedProduct.options[selectedProduct.selectedIndex].text,
    product_id: selectedProduct.value,
    unit_price: product.unit_price,
    qty: qtyInput.value,
    total: totalInput.value,
    notes: document.getElementById("notes").value,
  };

  items.push(item);
  renderCartTable();
  calculateTotal();
}

// Render cart table
function renderCartTable() {
  const tableBody = document.getElementById("cartTableBody");
  tableBody.innerHTML = "";

  items.forEach((item, index) => {
    item.product_index = index + 1;
    tableBody.innerHTML += `
      <tr>
        <td>${item.product_index}</td>
        <td>${item.product_name}</td>
        <td>${item.qty}</td>
        <td>${item.total}</td>
        <td>${item.notes}</td>
        <td><button onclick="deleteRecord(${item.product_index})">Delete</button></td>
      </tr>`;
  });
}

// Delete item from cart
function deleteRecord(index) {
  const idx = items.findIndex((item) => item.product_index === index);
  if (idx !== -1) {
    items.splice(idx, 1);
    renderCartTable();
    calculateTotal();
  }
}

// Calculate total value of order
function calculateTotal() {
  const total = items.reduce(
    (acc, item) => acc + parseFloat(item.total || 0),
    0
  );
  document.getElementById("order_value").value = total.toFixed(2);
}

// Submit order
function postOrders() {
  const customer = document.getElementById("cust_id");

  const order = {
    created_at: document.getElementById("created_at").value,
    customer_id: customer.value,
    customer_name: customer.options[customer.selectedIndex].text,
    order_value: document.getElementById("order_value").value,
    sp_discounts: document.getElementById("sp_discounts").value,
    notes: document.getElementById("notes").value,
    items,
  };

  createOrderAndRedirect(order);
}

// Fetch available products
function fetchProduct() {
  fetch(product_api)
    .then((res) => res.json())
    .then((data) => {
      products.push(...data);
    })
    .catch((err) => {
      console.error("Products API Error:", err);
    });
}

// Get selected product price
function getProductPrice(productId) {
  product = products.find((p) => p.product_id == productId);
  if (product) {
    totalInput.value = (product.unit_price * qtyInput.value).toFixed(2);
  }
}

// Redirect after storing order
function createOrderAndRedirect(order) {
  sessionStorage.setItem("pendingOrder", JSON.stringify(order));
  window.location.href = "views/recipte.php"; // Update if needed
}
