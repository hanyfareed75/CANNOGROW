document.addEventListener("DOMContentLoaded", function () {
  const delivaryDetails = JSON.parse(localStorage.getItem("delivary"));
  if (!delivaryDetails) {
    alert("No delivary details found!");
    return;
  }
  console.log(delivaryDetails);
  const distinctOrderIds = new Set(
    delivaryDetails.products.map((p) => p.order_id)
  );
  console.log(distinctOrderIds.size); // Output: 1
  document.getElementById("agentNameValue").textContent =
    delivaryDetails.agent_name;
  //customer details
  document.getElementById("cust_name").textContent =
    delivaryDetails.customers[0].cust_name;
  document.getElementById("mobile_2").textContent =
    delivaryDetails.customers[0].mobile_2;
  document.getElementById("mobile_1").textContent =
    delivaryDetails.customers[0].mobile_1;
  document.getElementById("address").textContent =
    delivaryDetails.customers[0].address;
  document.getElementById("areaname").textContent =
    delivaryDetails.customers[0].area_name;

  document.getElementById("orderCount").textContent = distinctOrderIds.size;

  renderOrdersFromProducts(delivaryDetails.products, "ordersContainer");
  document.getElementById("confirmButton").addEventListener("click", function () {
    postDelivaryDetails(delivaryDetails);
    window.location.href =
      "https://cannigrow.free.nf/managment/views/delivaryDetails.php";
  })

});

function renderOrdersFromProducts(products, containerId) {
  const container = document.getElementById(containerId);
  container.innerHTML = ""; // Clear existing content

  // Group products by order_id
  const grouped = {};
  products.forEach((p) => {
    if (!grouped[p.order_id]) {
      grouped[p.order_id] = {
        order_value: p.order_value,
        products: [],
      };
    }
    grouped[p.order_id].products.push(p);
  });

  // For each order
  Object.entries(grouped).forEach(([orderId, orderData]) => {
    const orderDiv = document.createElement("div");
    orderDiv.className = "mb-4 border-bottom pb-3";

    // Order number header
    const orderHeader = document.createElement("h6");
    orderHeader.innerHTML = `أوردر رقم <span>${orderId}</span>`;
    orderDiv.appendChild(orderHeader);

    // Create table
    const table = document.createElement("table");
    table.className = "table table-bordered table-sm text-center";

    // Table header
    table.innerHTML = `
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>اسم المنتج</th>
          <th>الكمية</th>
          <th>سعر الوحدة</th>
          <th>الإجمالي</th>
        </tr>
      </thead>
    `;

    const tbody = document.createElement("tbody");

    orderData.products.forEach((product, index) => {
      const row = document.createElement("tr");
      const quantity = product.quantity || 1; // fallback if not available
      const unitPrice =
        product.unit_price || product.order_value / orderData.products.length;
      const total = quantity * unitPrice;

      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${product.name_ar}</td>
        <td>${quantity}</td>
        <td>${unitPrice}</td>
        <td>${total}</td>
      `;
      tbody.appendChild(row);
    });

    table.appendChild(tbody);
    orderDiv.appendChild(table);

    // Total price
    const totalText = document.createElement("h6");
    totalText.className = "text-end text-danger";
    totalText.innerHTML = `إجمالي الفاتورة: <span>${orderData.order_value}</span> جنيه`;
    orderDiv.appendChild(totalText);

    // Append to container
    container.appendChild(orderDiv);
  });
}

//create function to post delivaryDetails to api
function postDelivaryDetails(delivaryDetails) {
  fetch("https://cannigrow.free.nf/managment/api/delivary", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(delivaryDetails),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
    })
    .catch((error) => {
      console.error("Error:", error);
    });
  //remove local storage after post
  localStorage.removeItem("delivary");
}
//create function to render orders from products  

