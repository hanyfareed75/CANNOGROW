const api = "https://cannigrow.free.nf/managment/api/orderAPI.php";
document.addEventListener("DOMContentLoaded", function () {
  const order = JSON.parse(sessionStorage.getItem("pendingOrder"));
  if (!order) {
    alert("No pending order found!");
    return;
  }
  document.getElementById("order_id").innerText =
    "رقم القاتورة  :  " + order.items[0].order_id;
  document.getElementById("customer_name").innerText =
    "اسم العميل  :    " + order.customer_name;
  document.getElementById("created_at").innerText =
    "تاريخ الأوردر  :    " + order.created_at;

  const tableBody = document.getElementById("cartTableBody");
  order.items.forEach((item, index) => {
    const row = `
                        <div class="row">
                             <div class="col-xl-1">
                            <p>${index + 1}</p>
                        </div>
                        <div class="col-xl-4">
                            <p>${item.product_name}</p>
                        </div>
                        <div class="col-xl-3">
                            <p class="float-end">${item.unit_price}
                            </p>
                        </div>
                        <div class="col-xl-2">
                            <p class="float-end">${item.qty}
                            </p>
                        </div>
                        <div class="col-xl-2">
                            <p class="float-end">${item.total}
                            </p>
                        </div>
                        <hr>
                    </div>  
      
     
      `;
    tableBody.innerHTML += row;
  });

  // // Display order details (example)
  document.getElementById("order_value").innerText =
    "اجمالي الفاتورة :   " + order.order_value + "   جنية مصري";

  // Handle confirm button
  document
    .getElementById("confirmBtn")
    .addEventListener("click", async function () {
      try {
        const response = await fetch(api, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(order),
        });

        if (response.ok) {
          alert("Order confirmed and posted!");
          sessionStorage.removeItem("pendingOrder");
          window.location.href = "https://cannigrow.free.nf/managment/?orders"; // or redirect to success page
        } else {
          alert("Error posting order");
        }
      } catch (err) {
        console.error("Post error:", err);
        alert("Error connecting to server");
      }
    });
});
