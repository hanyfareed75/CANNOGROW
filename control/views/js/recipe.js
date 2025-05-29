// Load existing recipes on button click
document.getElementById("load-recipes").addEventListener("click", getRecipes);

// Update measure when item changes
document.getElementById("item_id").addEventListener("change", (ev) => {
  fetch("api/recipe-measure.php", {
    method: "POST",
    body: JSON.stringify(ev.target.value),
  })
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("measure").innerHTML = data[0].measure || "";
    })
    .catch((err) => console.error("Error fetching measure:", err));
});

// Handle form submission to add a recipe
document.getElementById("recipe-form").addEventListener("submit", function (e) {
  e.preventDefault();

  const data = {
    product_id: document.getElementById("product_id").value,
    item_id: document.getElementById("item_id").value,
    qty: document.getElementById("qty").value,
    notes: document.getElementById("notes").value,
  };

  fetch("api/add-recipe.php", {
    method: "POST",
    body: JSON.stringify(data),
  })
    .then((res) => res.text())
    .then((msg) => {
      document.getElementById("response-msg").textContent =
        "تمت الإضافة بنجاح!";
      getRecipes(); // Reload recipes
      this.reset(); // Reset form
      document.getElementById("measure").innerHTML = "";
    })
    .catch((err) => {
      document.getElementById("response-msg").textContent =
        "حدث خطأ، تأكد من البيانات.";
      console.error("Add recipe error:", err);
    });
});

// Load all recipes from server and display them
function getRecipes() {
  fetch("api/recipe.php")
    .then((response) => response.json())
    .then((data) => {
      const tableBody = document.getElementById("recipe-table-body");
      tableBody.innerHTML = "";

      data.forEach((item) => {
        tableBody.innerHTML += `
          <tr id="row-${item.rec_id}">
            <td>${item.rec_id || "-"}</td>
            <td>${item.name_eng}</td>
            <td>${item.item_name}</td>
            <td>${item.qty}</td>
            <td>${item.notes || "-"}</td>
            <td>
              <button class="btn btn-sm btn-danger" onclick="deleteRecord(${
                item.rec_id
              })">Delete</button>
            </td>
          </tr>
        `;
      });
    })
    .catch((error) => {
      document.getElementById("recipe-table-body").innerHTML = `
        <tr><td colspan="6">فشل تحميل البيانات. ${error}</td></tr>`;
      console.error("Get recipes error:", error);
    });
}

// Delete a recipe by ID
function deleteRecord(id) {
  fetch("api/delete-recipe.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id }),
  })
    .then((response) => response.text())
    .then((result) => {
      if (result === "success") {
        document.getElementById("row-" + id)?.remove();
        getRecipes(); // Refresh list
      } else {
        alert("Error: " + result);
      }
    })
    .catch((error) => {
      console.error("Delete error:", error);
    });
}
