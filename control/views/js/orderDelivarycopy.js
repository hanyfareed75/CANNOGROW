// Constants
const BASE_API_PATH = "/managment/api";
const STATE = {
  orderedProducts: [],
  orderCustomer: [],
  orderAgent: [],
  totals: 0,
  agentName: "",
  agent_id: 0,
  order_id: 0,
  areaname: "",
};

// Initialize application
document.addEventListener("DOMContentLoaded", function () {
  initializeEventListeners();
  initializeModal();
});

function initializeModal() {
  const delivaryModal = document.getElementById("delivaryDetails");
  if (delivaryModal) {
    delivaryModal.addEventListener("show.bs.modal", function () {
      const deliveryData = JSON.parse(localStorage.getItem("delivary") || "{}");
      updateModalContent(deliveryData);
    });
  }
}

// Event Listeners

function initializeEventListeners() {
  document
    .getElementById("orderselect")
    .addEventListener("change", handleOrderSelect);
  document
    .getElementById("agentselect")
    .addEventListener("change", handleAgentSelect);
  document
    .getElementById("creatdelivary")
    .addEventListener("click", handleCreateDelivery);
 
  document
    .getElementById("confirmButton")
    .addEventListener("click", (ev) => {
          ev.preventDefault();
      handleFormSubmit(ev);
    })
} // Add this closing brace

// API Calls fetch order details by customer ID to fill the order table
async function fetchOrderDetailsByID(id) {
  try {
    showLoading(true);
    const response = await fetch(
      `${BASE_API_PATH}/index.php?resource=orderDelivary&action=getOrdersByCustomerID&cust_id=${id}`
    );

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();

    if (!data.success) {
      throw new Error(data.error || "Failed to fetch order details");
    }

    STATE.orderedProducts = [];
    STATE.orderCustomer = [];
console.log("Fetched order details:", data.data);
    if (data.data && data.data.length > 0) {
      updateOrderDetails(data.data[0]);
      updateOrderTable(data.data.data || []);
    }
  } catch (error) {
    console.error("Error loading order details:", error);
    showError(error.message);
  } finally {
    showLoading(false);
  }
}
async function handleResponse(response) {
  try {
      // First level of parsing
      const firstLevel = await response.json();
      
      // Check first level success
      if (!firstLevel.success) {
          throw new Error('First level request failed');
      }

      // Get nested data array
      const orders = firstLevel.data.data;
      
      // Group orders by order_id
      const groupedOrders = orders.reduce((acc, order) => {
          if (!acc[order.order_id]) {
              // Create new order group
              acc[order.order_id] = {
                  orderInfo: {
                      order_id: order.order_id,
                      created_at: order.created_at,
                      cust_name: order.cust_name,
                      mobile_1: order.mobile_1,
                      order_value: order.order_value,
                      sp_discounts: order.sp_discounts,
                      order_status: order.order_status,
                      notes: order.notes
                  },
                  products: []
              };
          }
          
          // Add product to order
          acc[order.order_id].products.push({
              name_ar: order.name_ar,
              unit_price: order.unit_price,
              qty: order.qty,
              total: order.total
          });
          
          return acc;
      }, {});

      return groupedOrders;
  } catch (error) {
      console.error('Error parsing response:', error);
      throw error;
  }
}
// Example fetch call
async function fetchOrders() {
  try {
      const response = await fetch('your-api-endpoint');
      const groupedOrders = await handleResponse(response);
      
      // Now you can access the data in a more structured way
      Object.values(groupedOrders).forEach(order => {
          console.log('Order ID:', order.orderInfo.order_id);
          console.log('Customer:', order.orderInfo.cust_name);
          console.log('Products:', order.products);
          
          // Calculate order total
          const orderTotal = order.products.reduce((sum, product) => 
              sum + parseFloat(product.total), 0);
          console.log('Total:', orderTotal);
      });
      
      return groupedOrders;
  } catch (error) {
      console.error('Failed to fetch orders:', error);
      throw error;
  }
}

// To display in a table:
function displayOrders(groupedOrders) {
  const tbody = document.querySelector('#ordersTable tbody');
  tbody.innerHTML = '';
  
  Object.values(groupedOrders).forEach(order => {
      const row = document.createElement('tr');
      row.innerHTML = `
          <td>${order.orderInfo.order_id}</td>
          <td>${order.orderInfo.created_at}</td>
          <td>${order.orderInfo.cust_name}</td>
          <td>${order.orderInfo.mobile_1}</td>
          <td>
              <ul>
                  ${order.products.map(product => `
                      <li>${product.name_ar} (${product.qty} × ${product.unit_price})</li>
                  `).join('')}
              </ul>
          </td>
          <td>${order.orderInfo.order_value}</td>
          <td>${order.orderInfo.order_status}</td>
      `;
      tbody.appendChild(row);
  });
}
// Example usage:
async function updateDeliveryStatus(orderId) {
  try {
    const response = await fetch(`${BASE_API_PATH}/orderAPI.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        _method: "PUT", // Use PUT method for updating
      },
      body: JSON.stringify({
        order_id: orderId,
        status: "delivered",
      }),
    });

    const data = await response.json();
    if (!data.success) {
      throw new Error(data.error || "Failed to update delivery status");
    }

    return data;
  } catch (error) {
    console.error("Error updating delivery status:", error);
    showError(error.message);
    return false;
  }
}

// Event Handlers
function handleOrderSelect(event) {
  const cust_id = event.target.value;
  if (cust_id) {
    const selectedOption = event.target.options[event.target.selectedIndex];
    const [name] = selectedOption.text.split(" - ");
    STATE.custName = name;
    STATE.cust_id = cust_id;
    fetchOrderDetailsByID(cust_id);
  }
}

function handleAgentSelect(event) {
  const selectedOption = event.target.options[event.target.selectedIndex];
  const [name] = selectedOption.text.split(" - ");
  STATE.agent_id = selectedOption.value;
  STATE.agentName = name;
  console.log("Selected agent:", STATE.agent_id, STATE.agentName);
  if (STATE.agent_id && STATE.agentName) {
    document.getElementById("agentName").textContent = STATE.agentName;
  } else {
    document.getElementById("agentName").textContent = "غير محدد";
  }
}

async function handleCreateDelivery(event) {
  event.preventDefault();

  if (!validateDelivery()) {
    return;
  }

  const deliveryData = createDeliveryObject();
  if (deliveryData) {
    saveToLocalStorage(deliveryData);
    updateDeliveryTable(deliveryData);
  }
}
// Helper Functions
// ...existing code...
function updateDeliveryTable(deliveryData) {
  if (!deliveryData || !deliveryData.products) {
    showError("بيانات التوصيل غير صحيحة");
    return;
  }

  // Update customer information

  // Update delivery information

  // Update products table
  const tbody = document.getElementById("agentTbody");
  if (!tbody) return;

  tbody.innerHTML = "";
  let totalAmount = 0;
  console.log(deliveryData);

  const row = document.createElement("tr");
  row.innerHTML = `
      
        <td>${deliveryData["agent_name"] || ""}</td>
        <td class="text-center">${deliveryData["order_id"] || 0}</td>
        <td class="text-center">${(
          deliveryData["areaname"] || 0
        ).toLocaleString("ar-EG")}</td>
        
    `;
  tbody.appendChild(row);

  // Add delivery fees to total
  totalAmount += Number(deliveryData.delivery_fees) || 0;

  // Add total row
  const totalRow = document.createElement("tr");
  totalRow.classList.add("table-info", "fw-bold");
  totalRow.innerHTML = `
      <td colspan="4" class="text-center">الإجمالي شامل رسوم التوصيل</td>
      <td class="text-center">${totalAmount.toLocaleString("ar-EG")}</td>
  `;
  tbody.appendChild(totalRow);
}
function validateDelivery() {
  try {
    // Check agent selection
    if (!STATE.agent_id || !STATE.agentName) {
      throw new Error("الرجاء اختيار المندوب");
    }

    // Check order selection
    if (!STATE.order_id) {
      throw new Error("الرجاء اختيار الأوردر");
    }

    // Get and validate delivery fees
    const deliveryFees = document.getElementById("delivaryfees").value;
    if (!deliveryFees || isNaN(deliveryFees) || parseFloat(deliveryFees) < 0) {
      throw new Error("الرجاء إدخال رسوم توصيل صحيحة");
    }

    // Get and validate delivery date
    const deliveryDate = document.getElementById("delivaryDate").value;
    if (!deliveryDate) {
      throw new Error("الرجاء اختيار تاريخ التوصيل");
    }

    // Validate date is not in the past
    const selectedDate = new Date(deliveryDate);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (selectedDate < today) {
      throw new Error("لا يمكن اختيار تاريخ في الماضي");
    }

    // Validate products exist
    if (!STATE.orderedProducts || STATE.orderedProducts.length === 0) {
      throw new Error("لا توجد منتجات في الأوردر");
    }

    return true;
  } catch (error) {
    showError(error.message);
    return false;
  }
}
async function handleFormSubmit(event) {
  event.preventDefault();


  const success = await updateDeliveryStatus(STATE.order_id);
  if (success) {
   alert("Delivery status updated successfully");
  }
}

// Helper Functions
function createDeliveryObject() {
  try {
    if (!STATE.agent_id || !STATE.agentName || !STATE.order_id) {
      throw new Error("الرجاء اختيار المندوب والطلب");
    }

    const deliveryFees = document.getElementById("delivaryfees").value;
    const deliveryDate = document.getElementById("delivaryDate").value;

    const deliveryObject = {
      agent_id: STATE.agent_id,
      agent_name: STATE.agentName,
      order_id: STATE.order_id,
      areaname: STATE.areaname,
      delivery_fees: deliveryFees,
      delivery_date: deliveryDate,
      products: STATE.orderedProducts,
      customers: STATE.orderCustomer,
      created_at: new Date().toISOString(),
    };

    return deliveryObject;
  } catch (error) {
    showError(error.message);
    return null;
  }
}

function validateDelivery() {
  try {
    // Check agent selection
    if (!STATE.agent_id || !STATE.agentName) {
      throw new Error("الرجاء اختيار المندوب");
    }

    // Check order selection
    if (!STATE.order_id) {
      throw new Error("الرجاء اختيار الأوردر");
    }

    // Get and validate delivery fees
    const deliveryFees = document.getElementById("delivaryfees").value;
    if (!deliveryFees || isNaN(deliveryFees) || parseFloat(deliveryFees) < 0) {
      throw new Error("الرجاء إدخال رسوم توصيل صحيحة");
    }

    // Get and validate delivery date
    const deliveryDate = document.getElementById("delivaryDate").value;
    if (!deliveryDate) {
      throw new Error("الرجاء اختيار تاريخ التوصيل");
    }

    // Validate date is not in the past
    const selectedDate = new Date(deliveryDate);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (selectedDate < today) {
      throw new Error("لا يمكن اختيار تاريخ في الماضي");
    }

    // Validate products exist
    if (!STATE.orderedProducts || STATE.orderedProducts.length === 0) {
      throw new Error("لا توجد منتجات في الأوردر");
    }

    return true;
  } catch (error) {
    showError(error.message);
    return false;
  }
}

function showError(message) {
  const errorAlert = document.getElementById("errorAlert");
  if (errorAlert) {
    errorAlert.textContent = message;
    errorAlert.classList.remove("d-none");
    setTimeout(() => errorAlert.classList.add("d-none"), 5000);
  }
}

function showLoading(show) {
  const spinner = document.getElementById("loadingSpinner");
  if (spinner) {
    spinner.classList.toggle("d-none", !show);
  }
}

function saveToLocalStorage(data) {
  localStorage.setItem("delivary", JSON.stringify(data));
}

function updateOrderTable(orderData) {
  const tbody = document.querySelector("table tbody");
  if (!tbody) {
    console.error("Table body not found");
    return;
  }

  tbody.innerHTML = "";

  if (!Array.isArray(orderData) || orderData.length === 0) {
    tbody.innerHTML = `
          <tr>
              <td colspan="4" class="text-center">لا توجد منتجات</td>
          </tr>`;
    return;
  }

  let totalAmount = 0;
console.log("Updating order table with data:", orderData);
  // Clear existing rows
  orderData.forEach((item, index) => {
    const row = document.createElement("tr");
    row.innerHTML = `
          <td class="text-center">${index + 1}</td>
            <td>${item.order_id || ""}</td>
          <td>${item.name_ar || ""}</td>
          <td class="text-center">${item.qty || 0}</td>
          <td class="text-center">${
            item.unit_price?.toLocaleString("ar-EG") || 0
          }</td>
          <td class="text-center">${
            item.total?.toLocaleString("ar-EG") || 0
          }</td>
      `;
    tbody.appendChild(row);

    totalAmount += Number(item.total) + item.delivery_fees || 0;
    document.getElementById("totalPrice").innerHTML =
      totalAmount.toLocaleString("ar-EG");
  });

  // Add total row
  const totalRow = document.createElement("tr");
  totalRow.classList.add("table-info", "fw-bold");
  totalRow.innerHTML = `
      <td colspan="4" class="text-center">الإجمالي</td>
      <td class="text-center">${totalAmount.toLocaleString("ar-EG")}</td>
  `;
  tbody.appendChild(totalRow);

  // Update state
  STATE.totals = totalAmount;
}

function updateOrderDetails(orderData) {
  if (!orderData) return;

  // Update customer info in state
  STATE.orderCustomer = [
    {
      cust_name: orderData.cust_name || "",
      mobile_1: orderData.mobile_1 || "",
      address: orderData.address || "",
      area_name: orderData.area_name || "",
    },
  ];
  console.log("Updating order details in state:", orderData);
  STATE.areaname = orderData.area_name || "";

  // Add ordered product to state
  STATE.orderedProducts.push({
    product_name: orderData.name_ar,
    qty: orderData.qty,
    unit_price: orderData.unit_price,
    total: orderData.total,
  });
}
function updateModalContent(deliveryData) {
  if (!deliveryData) {
    showError("لا توجد بيانات للعرض");
    return;
  }

  console.log("Updating modal content with delivery data:", deliveryData);

  try {
    // Update agent info
    document.getElementById("agentNameValue").textContent =
      deliveryData.agent_name || "--";

    // Update customer details
    if (deliveryData.customers && deliveryData.customers.length > 0) {
      const customer = deliveryData.customers[0];
      document.getElementById("cust_name").textContent =
        customer.cust_name || "--";
      document.getElementById("mobile_1").textContent =
        customer.mobile_1 || "--";
      document.getElementById("mobile_2").textContent =
        customer.mobile_2 || "--";
      document.getElementById("address").textContent = customer.address || "--";
      document.getElementById("areaname").textContent =
        customer.area_name || "--";
    }

    // Validate products array and update order count
    const products = Array.isArray(deliveryData.products)
      ? deliveryData.products
      : [];
    document.getElementById("orderCount").textContent = products.length;
STATE.order_id = deliveryData.order_id || 0;
    // Render orders in container
    const container = document.getElementById("ordersContainer");
    if (container) {
      renderOrdersFromProducts(
        products,
        "ordersContainer",
        deliveryData.order_id
      );
    }
  } catch (error) {
    console.error("Error updating modal content:", error);
    showError("حدث خطأ أثناء عرض البيانات");
  }
}

function renderOrdersFromProducts(products, containerId, orderId) {
  const container = document.getElementById(containerId);
  if (!container) {
    console.error("Container not found:", containerId);
    return;
  }

  container.innerHTML = "";

  // Validate products array
  if (!Array.isArray(products) || products.length === 0) {
    container.innerHTML = `<p class="text-center">لا توجد منتجات لعرضها</p>`;
    return;
  }

  // Create order div
  const orderDiv = document.createElement("div");
  orderDiv.className = "mb-4 border-bottom pb-3";

  // Calculate total order value
  const orderTotal = products.reduce((sum, product) => {
    return sum + (product.qty * product.unit_price + STATE.totals);
  }, 0);

  orderDiv.innerHTML = `
        <h6>أوردر رقم <span>${orderId}</span></h6>
        <table class="table table-bordered table-sm text-center">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>اسم المنتج</th>
                    <th>الكمية</th>
                    <th>سعر الوحدة</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                ${products
                  .map((product, index) => {
                    const productName =
                      product.product_name || product.name_ar || "غير معروف";
                    const quantity = product.qty || 1;
                    const unitPrice = product.unit_price || 0;
                    const total = quantity * unitPrice;
                    return `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${productName}</td>
                            <td>${quantity}</td>
                            <td>${unitPrice.toLocaleString("ar-EG")}</td>
                            <td>${total.toLocaleString("ar-EG")}</td>
                        </tr>
                    `;
                  })
                  .join("")}
            </tbody>
            <tfoot>
                <tr class="table-info fw-bold">
                    <td colspan="4" class="text-center">الإجمالي</td>
                    <td class="text-center">${orderTotal.toLocaleString(
                      "ar-EG"
                    )}</td>
                </tr>
            </tfoot>
        </table>
    `;

  container.appendChild(orderDiv);
} // Add this closing brace
