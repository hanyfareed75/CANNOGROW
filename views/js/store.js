let api = "../controls/getData.php?db=m_store";

let api2 = "../controls/getData.php?db=m_items";
let table = document.getElementById("data");
var table1 = document.getElementById("table1");
const refresh = document.getElementById("refresh");
const items = [];

window.addEventListener("load", () => {
  fetchData();
});
function openAddItem() {
  window.open("items.html");
  console.log("clicked");
}
async function fetchData() {
  // Made fetchData async
  fetch(api) // adjust path if needed
    .then((response) => response.json())
    .then(async (data) => {
      // Made this callback async
      const tbody = document.querySelector("#storeTable tbody");

      for (const item of data) {
        // Using for...of loop to use await
        const itemName = await searchItem(item.item_id); // Await the result of searchItem
        console.log(itemName);
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${item.tran_id}</td>
            <td>${item.tran_date}</td>
            <td>${itemName}</td>  
            <td>${item.qty}</td>
            <td>${item.trans}</td>
            <td>${item.notes}</td>
          `;
        tbody.appendChild(row);
      }
    })
    .catch((err) => {
      console.error("Error loading data from API", err);
    });

  fetch(api2)
    .then((response) => response.json()) // Parse the JSON response
    .then((data) => {
      const select = document.getElementById("item_id");
      // Loop through the categories and add them to the select dropdown
      data.forEach((category) => {
        const option = document.createElement("option");
        option.value = category.item_id; // Set value to the category ID
        option.textContent = category.item_name; // Set the visible name of the category
        select.appendChild(option);
      });
    })
    .catch((error) => {
      console.error("Error fetching categories:", error);
    });
}

async function searchItem(id) {
  // Made searchItem async
  try {
    const response = await fetch(
      // Await the fetch call
      `../api/items.php?id=${id}`
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
        "../api/store.php",
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
          <div class="alert alert-success">تم إضافة  بنجاح</div>`;
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

//   const item = {
//     item_name: document.getElementById("item_name").value,
//     measure: document.getElementById("measure").value,
//     unit_price: document.getElementById("unit_price").value,
//   };
//   fetch(api, {
//     method: "POST",
//     headers: {
//       "Content-Type": "application/json",
//     },
//     body: JSON.stringify(item),
//   })
//     .then((response) => response.json())
//     .then((data) => {
//       console.log(data);
//     })
//     .catch((err) => {
//       console.error("Error loading data from API", err);
//     });
// }

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
