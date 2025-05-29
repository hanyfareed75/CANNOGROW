let api = "https://www.cannigrow.free.nf/managment/api/products.php";

window.addEventListener("load", () => {
  fetchData();
});

async function fetchData() {
  
  fetch(api) 
    .then((response) => response.json())
    .then(async (data) => {
     
      const tbody = document.querySelector("#storeTable tbody");

      for (const item of data) {
        
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${item.product_id}</td>
            <td>${item.name_eng}</td>
            <td>${item.name_ar}</td>
            <td>${item.unit_price}</td>
            <td>${item.description_eng}</td>
            <td>${item.description_ar}</td>
            <td>${item.start_date}</td>
            <td>${item.end_date}</td>
            <td>${item.modify_date}</td>
          `;
        tbody.appendChild(row);
      }
    })
    .catch((err) => {
      console.error("Error loading data from API", err);
    });

  
}

async function searchItem(id) {
  // Made searchItem async
  try {
    const response = await fetch(
      // Await the fetch call
      `https://www.cannigrow.free.nf/managment/api/product.php?id=${id}`
    );
    const data = await response.json(); // Await the JSON parsing
    return data[0].item_name; // Return the item name]; // Return the item name
  } catch (error) {
    console.error("Error searching item:", error);
    return "Error"; // Return an error indicator or handle as needed
  }
}

function addtostore() {
  document
    .getElementById("storeForm")
    .addEventListener("submit", async function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      const data = Object.fromEntries(formData.entries());

      const response = await fetch(
        "https://www.cannigrow.free.nf/managment/api/product.php",
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        }
      )
        .then((response) => {
          // Check if the response is actually JSON
          const contentType = response.headers.get("content-type");

          if (contentType && contentType.includes("application/json")) {
            return response.json(); // Parse as JSON
          } else {
            return response.text(); // Parse as plain text if not JSON
          }
        })
        .then((data) => {
         document.getElementById("message").innerHTML = `
          <div class="alert alert-success">تم الإضافة  بنجاح</div>`;
        })
        .catch((err) => {
          console.error("Error loading data from API" + err);
        });
      setTimeout(() => {
        this.reset();
        refreshData();
      }, 3000); // 3 second
      
    });
}

function refreshData() {
  location.reload();
}

//_____________________________________________________________________________________________

function deleteItem() {
  const item = {
    item_id: document.getElementById("item_id").value,
  };
  fetch(api, {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(item),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
    })
    .catch((err) => {
      console.error("Error loading data from API", err);
    });
}

function updateItem() {
  const item = {
    item_id: document.getElementById("item_id").value,
    item_name: document.getElementById("item_name").value,
    measure: document.getElementById("measure").value,
    unit_price: document.getElementById("unit_price").value,
  };
  fetch(api, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(item),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
    })
    .catch((err) => {
      console.error("Error loading data from API", err);
    });
}
