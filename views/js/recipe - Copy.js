document.getElementById("load-recipes").addEventListener("click", getRecipes);

document.getElementById("recipe-form").addEventListener("submit", function (e) {
  e.preventDefault();
  
  const formData = new FormData(this);

  fetch("api/add-recipe.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.text())
    .then((msg) => {
      document.getElementById("response-msg").textContent =
        "تمت الإضافة بنجاح!";
        msg;
      //getRecipes(); // إعادة تحميل الجدول
      this.reset(); // تفريغ النموذج
    })
    .catch((err) => {
      document.getElementById("response-msg").textContent =
        "حدث خطأ، تأكد من البيانات.";
      console.error(err);
    });
});

function getRecipes() {
    console.log("Fetching recipes...");
  fetch("api/recipe.php")
    .then((response) => response.json())
    .then((data) => {
      const tableBody = document.getElementById("recipe-table-body");
      tableBody.innerHTML = "";

      data.forEach((item) => {
        const row = `
            <tr>
              
              <td>${item.rec_name || "-"}</td>
              <td>${item.product_id}</td>
              <td>${item.item_id}</td>
              <td>${item.rec_value}</td>
              <td>${item.notes || "-"}</td>
            </tr>
          `;
        tableBody.innerHTML += row;
      });
    })
    .catch((error) => {
      document.getElementById(
        "recipe-table-body"
      ).innerHTML = `<tr><td colspan="6">فشل تحميل البيانات.</td></tr>`;
    });
}
