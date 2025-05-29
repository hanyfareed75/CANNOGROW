/**
 * Configuration object for API endpoints
 * @const {Object}
 */
const BASE_API_PATH =
  "/managment/api/index.php?resource=itemsController&action=";
//items_resource = "resource=itemsController&action=";
/**
 * Displays a message to the user in an alert box
 * @param {string} message - The message to display
 * @param {string} [type="success"] - The type of alert (success, danger, warning)
 * @depends HTML element with id="message"
 */
const showMessage = (message, type = "success") => {
  const messageElement = document.getElementById("message");
  if (messageElement) {
    messageElement.innerHTML = `
      <div class="alert alert-${type} alert-dismissible fade show" role="alert">
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>`;
  } else {
    console.warn("Message element not found");
  }
};

/**
 * Handles API errors and displays them to the user
 * @param {Error} error - The error object
 * @param {string} operation - The operation that failed
 * @depends showMessage function
 */
const handleApiError = (error, operation) => {
  console.error(`Error ${operation}:`, error);
  showMessage(`خطأ في العملية: ${error.message}`, "danger");
};

/**
 * Searches for items based on search term
 * @param {string} term - Search term
 * @returns {Promise<void>}
 * @depends config object, handleApiError function, updateTable function
 */
async function searchItems(term) {
  try {
    const response = await fetch(
      `${config.baseApi}${config.endpoints.items}?search=${term}`
    );
    const data = await response.json();
    updateTable(data);
  } catch (error) {
    handleApiError(error, "البحث");
  }
}

/**
 * Refreshes the data table with current items
 * @returns {Promise<void>}
 * @depends config object, handleApiError function, initializeEventListeners function
 * @depends HTML element with id="itemTableBody"
 */
async function refreshData() {
  try {
    const response = await fetch(`${config.baseApi}${config.endpoints.items}`);
    const data = await response.json();

    const tableBody = document.getElementById("itemTableBody");
    if (!tableBody) return;

    tableBody.innerHTML = "";

    data.forEach((item) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${item.item_id}</td>
        <td>${item.item_name}</td>
        <td>${item.measure}</td>
        <td>${item.description || ""}</td>
        <td>
          <button class="btn btn-sm btn-primary edit-item" data-id="${
            item.item_id
          }">
            تعديل
          </button>
          <button class="btn btn-sm btn-danger delete-item" data-id="${
            item.item_id
          }">
            حذف
          </button>
        </td>
      `;
      tableBody.appendChild(row);
    });

    // Reinitialize event listeners for new buttons
    initializeEventListeners();
  } catch (error) {
    handleApiError(error, "تحديث البيانات");
  }
}

/**
 * Deletes an item from the database
 * @returns {Promise<void>}
 * @depends config object, showMessage function, handleApiError function
 * @depends HTML element with id="item_id"
 */
async function deleteItem() {
  const itemId = document.getElementById("item_id").value;
  if (!itemId) {
    showMessage("الرجاء إدخال رقم الصنف", "warning");
    return;
  }

  if (!confirm("هل أنت متأكد من حذف هذا الصنف؟")) {
    return;
  }

  try {
    const response = await fetch(
      `${config.baseApi}${config.endpoints.items}/${itemId}`,
      {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
      }
    );
    const data = await response.json();
    showMessage("تم حذف الصنف بنجاح");
    refreshData();
  } catch (error) {
    handleApiError(error, "حذف الصنف");
  }
}

/**
 * Updates an existing item in the database
 * @returns {Promise<void>}
 * @depends HTML elements with ids: item_id, item_name, measure, unit_price
 * @depends refreshData function
 */
function updateItem() {
  const itemId = document.getElementById("item_id").value;
  if (!itemId) {
    alert("Please enter an item ID to update.");
    return;
  }
  const item = {
    item_id: itemId,
    item_name: document.getElementById("item_name").value,
    measure: document.getElementById("measure").value,
    unit_price: document.getElementById("unit_price").value,
  };
  fetch(`${api}/${itemId}`, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(item),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      refreshData(); // Refresh the data after update
    })
    .catch((err) => {
      console.error("Error updating item", err);
    });
}

/**
 * Searches for a specific item by ID
 * @returns {Promise<void>}
 * @depends HTML elements with ids: item_id, item_name, measure, unit_price
 */
function searchItem() {
  const itemId = document.getElementById("item_id").value;
  if (!itemId) {
    alert("Please enter an item ID to search.");
    return;
  }
  fetch(`${api}/${itemId}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.length > 0) {
        const item = data[0];
        document.getElementById("item_name").value = item.item_name;
        document.getElementById("measure").value = item.measure;
        document.getElementById("unit_price").value = item.unit_price;
      } else {
        alert("Item not found.");
      }
    })
    .catch((err) => {
      console.error("Error searching item", err);
    });
}

/**
 * Initializes the form submission handler
 * @returns {void}
 * @depends HTML form with id="itemForm"
 * @depends validateItemForm function, showMessage function
 * @depends config object
 */
function additem() {
  document
    .getElementById("itemForm")
    .addEventListener("submit", async function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      const data = Object.fromEntries(formData.entries());

      // Validate form data
      const errors = validateItemForm(data);
      if (errors.length > 0) {
        showMessage(errors.join("<br>"), "danger");
        return;
      }

      try {
        const response = await fetch(
          "https://cannigrow.free.nf/managment/index.php?action=api-additem",
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data),
          }
        );

        const result = await response.json();
        document.getElementById("message").innerHTML = `
          <div class="alert alert-success">${result.message}</div>`;
      } catch (error) {
        document.getElementById("message").innerHTML = `
          <div class="alert alert-danger">Error submitting form ${error}</div>`;
      }
      setTimeout(() => {
        this.reset();
        // refreshData();
      }, 3000); // 3 second
    });
}

/**
 * Validates the item form data
 * @param {Object} data - Form data object
 * @param {string} data.item_name - Name of the item
 * @param {string} data.measure - Measurement unit
 * @param {string} [data.unit_price] - Price per unit
 * @returns {string[]} Array of error messages
 */
function validateItemForm(data) {
  const errors = [];

  if (!data.item_name?.trim()) {
    errors.push("اسم الصنف مطلوب");
  }

  if (!data.measure?.trim()) {
    errors.push("وحدة القياس مطلوبة");
  }

  if (data.unit_price && isNaN(data.unit_price)) {
    errors.push("السعر يجب أن يكون رقماً");
  }

  return errors;
}

/**
 * Initializes all event listeners for the page
 * @returns {void}
 * @depends Multiple HTML elements with classes: edit-item, delete-item
 * @depends HTML element with id="searchInput"
 */
const initializeEventListeners = () => {
  // Add event listeners to table action buttons
  document.querySelectorAll(".edit-item").forEach((button) => {
    button.addEventListener("click", (e) => {
      const itemId = e.target.dataset.id;
      handleEditItem(itemId);
    });
  });

  document.querySelectorAll(".delete-item").forEach((button) => {
    button.addEventListener("click", (e) => {
      const itemId = e.target.dataset.id;
      handleDeleteItem(itemId);
    });
  });

  // Search input handler
  const searchInput = document.getElementById("searchInput");
  if (searchInput) {
    searchInput.addEventListener("input", (e) => {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
        const searchTerm = e.target.value.trim();
        if (searchTerm.length >= 2) {
          searchItems(searchTerm);
        }
      }, 300);
    });
  }
};

// Document ready handler
/**
 * Initializes the page when DOM is fully loaded
 * @depends initializeEventListeners function
 * @depends additem function
 * @depends showMessage function
 */
document.addEventListener("DOMContentLoaded", function () {
  // Remove duplicate event listener
  let searchTimeout;

  try {
    initializeEventListeners();
    // Initialize the form submission handler
    additem();
  } catch (error) {
    console.error("Error initializing event listeners:", error);
    showMessage("حدث خطأ أثناء تهيئة الصفحة", "danger");
  }
});

// Add debouncing for search
let searchTimeout;
document.getElementById("searchInput").addEventListener("input", (e) => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    const searchTerm = e.target.value.trim();
    if (searchTerm.length >= 2) {
      searchItems(searchTerm);
    }
  }, 300);
});
