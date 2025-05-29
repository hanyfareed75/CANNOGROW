// const API_URL = "./api/customerAPI.php";
const API_URL = "./api/index.php?resource=customer&action=";
let existingCustomers = [];

// Initialize when DOM is fully loaded
document.addEventListener("DOMContentLoaded", function () {
  loadCustomers();
  initializeEventListeners();
});

function initializeEventListeners() {
  // Get form elements
  const form = document.getElementById("customerForm");
  const saveEditBtn = document.getElementById("saveEditCustomer");
  const customerNameInput = document.getElementById("customer_name");

  // Add form submit handler
  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      postCustomer();
    });
  }

  // Add edit save handler
  if (saveEditBtn) {
    saveEditBtn.addEventListener("click", handleEditCustomer);
  }

  // Add name validation
  if (customerNameInput) {
    customerNameInput.addEventListener("blur", validateCustomerName);
  }
}

function validateCustomerName() {
  const customerName = this.value.trim();
  if (customerName && isCustomerNameDuplicate(customerName)) {
    this.setCustomValidity("هذا الاسم موجود بالفعل");
    this.reportValidity();
  } else {
    this.setCustomValidity("");
  }
}

async function loadCustomers() {
  try {
    const response = await fetch(API_URL+'getAPI');
    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

    const data = await response.json();
    console.log("Raw API response:", data); // Debug log

    existingCustomers = data.data || []; // Ensure data is an array

    const tableBody = document.getElementById("customersTbody");
    if (!tableBody) {
      console.error("Table body element not found!");
      return;
    }

    // Map data to table rows with null checks
    tableBody.innerHTML = data.data
      .map((customer) => {
        // Validate customer object
        if (!customer || typeof customer !== "object") {
          console.error("Invalid customer data:", customer);
          return "";
        }

        // Add null checks for each field
        const id = customer?.cust_id || "";
        const name = customer?.cust_name || "";
        const mobile1 = customer?.mobile_1 || "";
        const mobile2 = customer?.mobile_2 || "";
        const address = customer?.address || "";
        const email = customer?.email || "";
        const notes = customer?.notes || "";
        const area = customer?.area_name || "";
        // Log customer data for debugging
        console.log("Customer data:", {
          id,
          name,
          mobile1,
          mobile2,
          address,
          email,
          notes,
          area,
        });
        // Return table row HTML

        return `
          <tr>
            <td>${id}</td>
            <td>${name}</td>
            <td>${mobile1}</td>
            <td>${mobile2}</td>
            <td>${address}</td>
            <td>${area}</td>
            <td>
              <div class="action-buttons">
                <button class="btn btn-primary btn-sm" onclick="editCustomer(${id})">
                  <i class="fas fa-edit"></i> تعديل
                </button>
                <button class="btn btn-danger btn-sm ms-1" onclick="deleteCustomer(${id})">
                  <i class="fas fa-trash-alt"></i> حذف
                </button>
              </div>
            </td>
          </tr>
        `;
      })
      .join("");

    console.log(`Loaded ${data.length} customers successfully`);
  } catch (error) {
    console.error("Error loading customers:", error);
    const tableBody = document.getElementById("customersTbody");
    if (tableBody) {
      tableBody.innerHTML = `
        <tr>
          <td colspan="7" class="text-center text-danger">
            حدث خطأ في تحميل البيانات: ${error.message}
          </td>
        </tr>
      `;
    }
  }
}

function isCustomerNameDuplicate(customerName, excludeId = null) {
  return existingCustomers.some(
    (customer) =>
      customer.cust_name.toLowerCase().trim() ===
        customerName.toLowerCase().trim() && customer.cust_id !== excludeId
  );
}

async function postCustomer() {
  const customerName = document.getElementById("customer_name").value.trim();
  const address = document.getElementById("address").value.trim();
  const mobile1 = document.getElementById("mobile_1").value.trim();
  const mobile2 = document.getElementById("mobile_2").value.trim();
  const email = document.getElementById("email").value.trim();

  // Validate required fields
  if (!customerName || !address || !mobile1) {
    alert("الرجاء ملء جميع الحقول المطلوبة");
    return;
  }

  try {
    const formData = {
      cust_name: customerName,
      address: address,
      mobile_1: mobile1,
      mobile_2: mobile2,
      email: email,
      notes: document.getElementById("notes")?.value?.trim() || "",
      area: document.getElementById("area_id")?.value.trim()||"",// Make notes optional
   
    };

    const response = await fetch(API_URL+'store', {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify(formData),
    });

    // Add this debug block
    if (!response.ok) {
      const errorText = await response.text(); // Get raw response text
      console.error("API Error Response:", errorText);
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Try parsing JSON
    let result;
    try {
      result = await response.json();
    } catch (e) {
      console.error("JSON Parse Error:", e);
      throw new Error("Invalid JSON response from server");
    }

    if (result.success) {
      // Reset form
      document.getElementById("customerForm").reset();

      // Refresh customers list
      await loadCustomers();

      alert("تم إضافة العميل بنجاح");
    } else {
      throw new Error(result.message || "فشل إضافة العميل");
    }
  } catch (error) {
    console.error("Error adding customer:", error);
    alert("حدث خطأ في إضافة العميل: " + error.message);
  }
}

async function handleEditCustomer() {
  const formElements = {
    id: document.getElementById("edit_customer_id"),
    name: document.getElementById("edit_customer_name"),
    mobile1: document.getElementById("edit_mobile_1"),
    mobile2: document.getElementById("edit_mobile_2"),
    address: document.getElementById("edit_address"),
    email: document.getElementById("edit_email"),
    notes: document.getElementById("edit_notes"), // Add notes to validation
    area: document.getElementById("edit_area_id"), // Add area to validation
  };

  // Validate all required elements exist
  if (
    !formElements.id ||
    !formElements.name ||
    !formElements.mobile1 ||
    !formElements.address ||
    !formElements.notes // Add notes to check
    || !formElements.area // Add area to check
  ) {
    console.error("Required form elements not found");
    alert("حدث خطأ: بعض حقول النموذج غير موجودة");
    return;
  }

  const customerId = parseInt(formElements.id.value, 10);
  const customerName = formElements.name.value.trim();

  // Validate input
  if (!customerName) {
    alert("الرجاء إدخال اسم العميل");
    formElements.name.focus();
    return;
  }

  if (isCustomerNameDuplicate(customerName, customerId)) {
    alert("هذا الاسم موجود بالفعل، الرجاء اختيار اسم آخر");
    document.getElementById("edit_customer_name").focus();
    return;
  }

  try {
    // Prepare update data
    const updateData = {
  
      cust_id: customerId,
      cust_name: customerName,
      address: document.getElementById("edit_address").value.trim(),
      mobile_1: document.getElementById("edit_mobile_1").value.trim(),
      mobile_2: document.getElementById("edit_mobile_2").value.trim(),
      notes: document.getElementById("edit_notes")?.value?.trim() || "",
      area: document.getElementById("edit_area_id")?.value.trim()||"",// Make notes optional
    };
    console.log("Sending update data:", updateData); // Debug log
    // Send update request
    const response = await fetch(API_URL+'update', {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify(updateData),
    });

    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

    const result = await response.json();

    if (result.success) {
      // Hide modal
      const editModal = bootstrap.Modal.getInstance(
        document.getElementById("editCustomerModal")
      );
      editModal.hide();

      // Refresh customers list
      await loadCustomers();

      alert("تم تحديث بيانات العميل بنجاح");
    } else {
      throw new Error(result.message || "فشل تحديث البيانات");
    }
  } catch (error) {
    console.error("Error updating customer:", error);
    alert("حدث خطأ في تحديث البيانات: " + error.message);
  }
}

async function editCustomer(id) {
  try {
    const response = await fetch(`${API_URL}findByid&id=${id}`);
    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

    const customerdata = await response.json();
    customer = customerdata.data; // Assuming the API returns an object with a 'data' property
    if (!customer) throw new Error("Customer data not found");

    // Show modal first to ensure elements exist
    const editModal = new bootstrap.Modal(
      document.getElementById("editCustomerModal")
    );
    editModal.show();

    // Wait for modal to finish showing
    setTimeout(() => {
      // Get all form elements
      const formElements = {
        id: document.getElementById("edit_customer_id"),
        name: document.getElementById("edit_customer_name"),
        mobile1: document.getElementById("edit_mobile_1"),
        mobile2: document.getElementById("edit_mobile_2"),
        address: document.getElementById("edit_address"),
        email: document.getElementById("edit_email"),
        notes: document.getElementById("edit_notes"), // Add notes field
        area: document.getElementById("edit_area_id"), // Add area field
      };

      // Check if all elements exist
      for (const [key, element] of Object.entries(formElements)) {
        if (!element) {
          console.error(`Edit form element not found: ${key}`);
          return;
        }
      }

      // Populate form fields
      formElements.id.value = customer.cust_id;
      formElements.name.value = customer.cust_name;
      formElements.mobile1.value = customer.mobile_1;
      formElements.mobile2.value = customer.mobile_2 || "";
      formElements.address.value = customer.address;
      formElements.email.value = customer.email || "";
    }, 200); // Give modal time to render
  } catch (error) {
    console.error("Error fetching customer details:", error);
    alert("حدث خطأ في تحميل بيانات العميل: " + error.message);
  }
}

async function deleteCustomer(id) {
  if (!confirm("هل أنت متأكد من حذف هذا العميل؟")) {
    return;
  }

  try {
    const response = await fetch(API_URL+'delete', {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify({
        _method: "DELETE",
        cust_id: id,
      }),
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const result = await response.json();

    if (result.success) {
      // Refresh customers list
      await loadCustomers();
      alert("تم حذف العميل بنجاح");
    } else {
      throw new Error(result.message || "فشل حذف العميل");
    }
  } catch (error) {
    console.error("Error deleting customer:", error);
    alert("حدث خطأ في حذف العميل: " + error.message);
  }
}
