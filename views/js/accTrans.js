window.onload = function () {
   passinfo();
}

function passinfo(){
  
    var x = document.getElementById("gotoInvoice");
    var invoice_id=document.getElementById("invoice_id").addEventListener("change", function(){
        invoice_id=document.getElementById("invoice_id").value;
        console.log(invoice_id);
    });
    console.log(invoice_id);
    var trans_id=document.getElementById("gl_id").innerHTML;
    x.addEventListener("click", function(){
        url =
          "views/invoice.php?$gl_id=" +
          encodeURIComponent(trans_id) +
          "&$inv_id=" +
          encodeURIComponent(invoice_id)
          
        window.open(url, "_blank");
    });
    
}