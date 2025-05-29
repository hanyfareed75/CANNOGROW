const BASE_API_PATH = "/managment/api/index.php?";
orderDelivary_resource = "resource=orderDelivaryController&action=";
agent_resource = "resource=agentController&action=";
selectOrderIDs = [];
let agentFees = 0;
// Initialize event listeners when the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function () {
  initializeEventListeners();
  // initializeModal();
  getOrderSummaryReadyForDelivery();
  fetchagents(); // Fetch agents when page loads
});
function initializeEventListeners() {
  // Handle customer list item clicks
  document.querySelectorAll(".list-group-item").forEach((item) => {
    item.addEventListener("click", function (e) {
      e.preventDefault();
      const customerId = this.getAttribute("data-customer-id");
      fetchCustomerOrders(customerId);
    });
  });

  // Add event listener for assign agent button
  document
    .getElementById("assignAgent")
    .addEventListener("click", setDelivaryTrans);
}
// function initializeModal() {}

//function to get ordersummary ready for delivery
function getOrderSummaryReadyForDelivery() {
  const url = BASE_API_PATH + orderDelivary_resource + "getAllOrdersBycustomer";
  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateCustomerList(data.data);
      } else {
        console.error("Error fetching order summary:", data.message);
      }
    })
    .catch((error) => console.error("Fetch error:", error));
}

function updateCustomerList(customers) {
  const listGroup = document.querySelector(".list-group");
  if (!listGroup) return;

  let html = "";
  customers.forEach((customer) => {
    html += `
            <a href="#" class="list-group-item list-group-item-action" 
               data-customer-id="${customer.cust_id}">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">${customer.cust_name}</h5>
                    <small>عدد الاوردرات: ${customer.total_orders}</small>
                </div>
                <p class="mb-1">موبايل: ${customer.mobile_1}</p>
                <p class="mb-1">العنوان: ${customer.address}</p>
                <small>المنطقة: ${customer.area_name} | 
                       اجمالى المبلغ: ${customer.total_spent} جنية  </small>
                       <small class="text-danger"> مصاريف الشحن ${customer.delivaryFees}</small>
            </a>
        `;
  });

  listGroup.innerHTML = html;
  initializeEventListeners(); // Reinitialize event listeners for new items
}

function fetchCustomerOrders(customerId) {
  fetch(
    BASE_API_PATH +
      orderDelivary_resource +
      "getOrdersByCustomerId&cust_id=" +
      customerId,
    {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    }
  )
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        displayOrderDetails(data.data);
      } else {
        alert(data.error || "Failed to fetch order details");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Failed to fetch order details");
    });
}

function displayOrderDetails(orders) {
  let tempOrderIDs = [];

  // Clear previous order details
  const modalContent = document.getElementById("orderDetailsContent");

  // Remove any existing style element
  const existingStyle = document.getElementById("orderStyles");
  if (existingStyle) {
    existingStyle.remove();
  }

  let html = '<div class="table-responsive"><table class="table">';
  html += `
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Date</th>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
  `;

  let totals = 0;

  if (!orders || orders.length === 0) {
    html += `
      <tr>
        <td colspan="6" class="text-center">No orders found for this customer.</td>
      </tr>
    `;
  } else {
    orders.forEach((order) => {
      // Only push to tempOrderIDs here, remove the other push
      tempOrderIDs.push(order.order_id);

      const orderDate = new Date(order.created_at);
      const today = new Date();
      const diffTime = today - orderDate;
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      const rowClass = diffDays > 1.5 ? "old-order" : "";
      const subtotal = order.qty * order.unit_price;
      totals += subtotal;

      html += `
        <tr class="${rowClass}">
          <td>${order.order_id}</td>
          <td>${order.created_at}</td>
          <td>${order.name_ar}</td>
          <td>${order.unit_price}</td>
          <td>${order.qty}</td>
          <td>${subtotal}</td>
        </tr>
      `;
    });
  }

  // Remove duplicates after the loop
  selectOrderIDs = Array.from(new Set(tempOrderIDs));

  html += `
    <tr>
      <td colspan="5" class="text-end"><strong>Grand Total:</strong></td>
      <td><strong class="text-danger">${totals}</strong></td>
    </tr>
  `;

  html += "</tbody></table></div>";
  modalContent.innerHTML = html;

  const modal = new bootstrap.Modal(
    document.getElementById("orderDetailsModal")
  );

  // Add event listener for when modal is shown
  document
    .getElementById("orderDetailsModal")
    .addEventListener("shown.bs.modal", function () {
      // Add the styles after modal is shown
      const style = document.createElement("style");
      style.id = "orderStyles";
      style.textContent = `
      #orderDetailsModal tr.old-order {
        background-color: #ffebee !important;
        color: #d32f2f !important;
      }
      #orderDetailsModal tr.old-order td {
        background-color: #ffebee !important;
        color: #d32f2f !important;
      }
    `;
      document.head.appendChild(style);
    });

  modal.show();
  console.log(selectOrderIDs);
}

function fetchagents() {
  fetch(BASE_API_PATH + agent_resource + "getAPI", {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateAgentList(data.data);
      } else {
        alert(data.error || "Failed to fetch agents");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Failed to fetch agents");
    });
}

function updateAgentList(agents) {
  const agentSelect = document.getElementById("agentSelect");
  if (!agentSelect) return;

  // Keep the default option
  let html = '<option value="">Select Agent...</option>';

  agents.forEach((agent) => {
    html += `
            <option value="${agent.agent_id}">
                ${agent.agent_name} - 0${agent.mobile_1}
            </option>
        `;
  });

  agentSelect.innerHTML = html;
}

// Create empty function for handling delivery transaction
function setDelivaryTrans() {
  // This function will be implemented later
  console.log("Assign agent button clicked");
  //save the selected agent ,s
  // You'll have access to these elements:
  const selectedAgent = document.getElementById("agentSelect").value;
  agentFees = document.getElementById("agentfees").value;
  const notes = document.getElementById("notes").value;

  console.log("Selected Agent:", selectedAgent);
  console.log("Order Value:", selectOrderIDs);
  console.log("Notes:", notes);
  console.log("Agent Fees:", agentFees);
  if (selectedAgent === "") {
    alert("Please select an agent.");
    return;
  }
  if (agentFees === "") {
    alert("Please enter agent fees.");
    return;
  }
  // Call the function to save the delivery transaction
  saveDeliveryTransaction(selectedAgent, selectOrderIDs, notes, agentFees);
}
function saveDeliveryTransaction(
  selectedAgent,
  selectOrderIDs,
  notes,
  agentFees
) {
  const data = {
    agent_id: selectedAgent,
    order_ids: selectOrderIDs,
    notes: notes,
    agent_fees: agentFees,
  };

  fetch(BASE_API_PATH + orderDelivary_resource + "createDeliveryTransaction", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Delivery transaction created successfully");
        // Close modal and refresh the page
        const modal = bootstrap.Modal.getInstance(
          document.getElementById("orderDetailsModal")
        );
        modal.hide();
        // location.reload();
      } else {
        alert("Failed to create delivery transaction: " + data.error);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Failed to create delivery transaction");
    });
}
