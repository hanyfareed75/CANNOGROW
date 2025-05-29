const API_URL = "./api/agentAPI.php";
let existingAgents = []; // Store loaded agents
let areas = []; // Add this at the top with other global variables

// Initialize everything when page loads
window.onload = function () {
  loadAgents();
  initializeEventListeners();
};

function initializeEventListeners() {
  document.getElementById("addarea").addEventListener("click", addtoArea);
  document.getElementById("submit").addEventListener("click", postOrders);
  document
    .getElementById("saveEditAgent")
    .addEventListener("click", handleEditAgent);
  document
    .getElementById("agent_name")
    .addEventListener("blur", validateAgentName);
}

function validateAgentName() {
  const agentName = this.value.trim();
  if (agentName && isAgentNameDuplicate(agentName)) {
    this.setCustomValidity("هذا الاسم موجود بالفعل");
    this.reportValidity();
  } else {
    this.setCustomValidity("");
  }
}

async function loadAgents() {
  try {
    const response = await fetch(API_URL);
    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

    const data = await response.json();
    existingAgents = data;

    const tableBody = document.getElementById("agentsTbody");
    if (!tableBody) {
      console.error("Table body element not found!");
      return;
    }

    tableBody.innerHTML = data
      .map(
        (agent) => `
            <tr>
                <td>${agent.agent_id}</td>
                <td>${agent.agent_name}</td>
                <td>${agent.address}</td>
                <td>${agent.mobile_1}</td>
                <td>${agent.mobile_2 || ""}</td>
                <td>${agent.notes || ""}</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm" onclick="editAgent(${
                          agent.agent_id
                        })">
                            <i class="fas fa-edit"></i> تعديل
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteAgent(${
                          agent.agent_id
                        })">
                            <i class="fas fa-trash-alt"></i> حذف
                        </button>
                    </div>
                </td>
            </tr>
        `
      )
      .join("");

    console.log(`Loaded ${data.length} agents successfully`);
  } catch (error) {
    console.error("Error loading agents:", error);
    const tableBody = document.getElementById("agentsTbody");
    if (tableBody) {
      tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-danger">
                        حدث خطأ في تحميل البيانات: ${error.message}
                    </td>
                </tr>`;
    }
  }
}

function isAgentNameDuplicate(agentName, excludeId = null) {
  return existingAgents.some(
    (agent) =>
      agent.agent_name.toLowerCase().trim() ===
        agentName.toLowerCase().trim() && agent.agent_id !== excludeId
  );
}

async function postOrders(event) {
  event.preventDefault();

  const agentName = document.getElementById("agent_name").value.trim();
  const address = document.getElementById("address").value.trim();
  const mobile1 = document.getElementById("mobile_1").value.trim();

  // Validate required fields
  if (!agentName || !address || !mobile1) {
    alert("الرجاء ملء جميع الحقول المطلوبة");
    return;
  }

  // Validate areas
  if (areas.length === 0) {
    alert("الرجاء إضافة منطقة واحدة على الأقل");
    return;
  }

  try {
    const formData = {
      agent_name: agentName,
      address: address,
      mobile_1: mobile1,
      mobile_2: document.getElementById("mobile_2").value.trim(),
      notes: document.getElementById("notes").value.trim(),
      areas: areas,
    };

    const response = await fetch(API_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify(formData),
    });

    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

    const result = await response.json();

    if (result.success) {
      // Reset form and areas
      document.getElementById("itemForm").reset();
      areas = [];
      updateAreaTable();

      // Refresh agents list
      await loadAgents();

      alert("تم إضافة المندوب بنجاح");
    } else {
      throw new Error(result.message || "فشل إضافة المندوب");
    }
  } catch (error) {
    console.error("Error adding agent:", error);
    alert("حدث خطأ في إضافة المندوب: " + error.message);
  }
}

async function handleEditAgent() {
  const agentId = parseInt(document.getElementById("edit_agent_id").value, 10);
  const agentName = document.getElementById("edit_agent_name").value.trim();

  // Validate input
  if (!agentName) {
    alert("الرجاء إدخال اسم المندوب");
    document.getElementById("edit_agent_name").focus();
    return;
  }

  if (isAgentNameDuplicate(agentName, agentId)) {
    alert("هذا الاسم موجود بالفعل، الرجاء اختيار اسم آخر");
    document.getElementById("edit_agent_name").focus();
    return;
  }

  try {
    // Prepare update data
    const updateData = {
      _method: "PUT",
      agent_id: agentId,
      agent_name: agentName,
      address: document.getElementById("edit_address").value.trim(),
      mobile_1: document.getElementById("edit_mobile_1").value.trim(),
      mobile_2: document.getElementById("edit_mobile_2").value.trim(),
      notes: document.getElementById("edit_notes").value.trim(),
    };

    // Send update request
    const response = await fetch(API_URL, {
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
        document.getElementById("editAgentModal")
      );
      editModal.hide();

      // Refresh agents list
      await loadAgents();

      alert("تم تحديث بيانات المندوب بنجاح");
    } else {
      throw new Error(result.message || "فشل تحديث البيانات");
    }
  } catch (error) {
    console.error("Error updating agent:", error);
    alert("حدث خطأ في تحديث البيانات: " + error.message);
  }
}

async function editAgent(id) {
  try {
    const response = await fetch(`${API_URL}?id=${id}`);
    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

    const agent = await response.json();

    // Populate the edit form
    document.getElementById("edit_agent_id").value = agent.agent_id;
    document.getElementById("edit_agent_name").value = agent.agent_name;
    document.getElementById("edit_address").value = agent.address;
    document.getElementById("edit_mobile_1").value = agent.mobile_1;
    document.getElementById("edit_mobile_2").value = agent.mobile_2 || "";
    document.getElementById("edit_notes").value = agent.notes || "";

    // Show the modal
    const editModal = new bootstrap.Modal(
      document.getElementById("editAgentModal")
    );
    editModal.show();
  } catch (error) {
    console.error("Error fetching agent details:", error);
    alert("حدث خطأ في تحميل بيانات المندوب: " + error.message);
  }
}

function addtoArea() {
  const areaSelect = document.getElementById("area_id");
  const selectedOption = areaSelect.options[areaSelect.selectedIndex];

  if (!selectedOption || selectedOption.disabled) {
    alert("الرجاء اختيار منطقة");
    return;
  }

  const newArea = {
    area_id: parseInt(areaSelect.value, 10),
    area_name: selectedOption.text,
    area_index: areas.length + 1,
    agent_name: document.getElementById("agent_name").value.trim(),
  };

  // Check if area already exists
  if (areas.some((area) => area.area_id === newArea.area_id)) {
    alert("هذه المنطقة مضافة بالفعل");
    return;
  }

  areas.push(newArea);
  updateAreaTable();
}

function updateAreaTable() {
  const tableBody = document.getElementById("areaTbody");
  if (!tableBody) {
    console.error("Area table body not found!");
    return;
  }

  tableBody.innerHTML = areas
    .map(
      (area) => `
        <tr>
            <td>${area.area_index}</td>
            <td>${area.area_name}</td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="deleteArea(${area.area_index})">
                    <i class="fas fa-trash-alt"></i> حذف
                </button>
            </td>
        </tr>
    `
    )
    .join("");
}

function deleteArea(index) {
  areas = areas.filter((area) => area.area_index !== index);
  updateAreaTable();
}

async function deleteAgent(id) {
  if (!confirm("هل أنت متأكد من حذف هذا المندوب؟")) {
    return;
  }

  try {
    const response = await fetch(API_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify({
        _method: "DELETE",
        agent_id: id,
      }),
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const result = await response.json();

    if (result.success) {
      // Refresh agents list
      await loadAgents();
      alert("تم حذف المندوب بنجاح");
    } else {
      throw new Error(result.message || "فشل حذف المندوب");
    }
  } catch (error) {
    console.error("Error deleting agent:", error);
    alert("حدث خطأ في حذف المندوب: " + error.message);
  }
}
