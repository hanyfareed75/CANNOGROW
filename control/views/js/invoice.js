window.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("uploadForm");
  if (!form) {
    console.error("uploadForm not found!");
    return;
  }

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const fileInput = document.getElementById("invoice_photo");
    if (!fileInput || !fileInput.files.length) {
      console.error("No file selected");
      return;
    }

    const formData = new FormData();
    formData.append("file", fileInput.files[0]);

    fetch("https://cannigrow.free.nf/managment/api/uploadFile.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then(
        (data) =>
          (document.getElementById("responseMessage").innerHTML = data.message)
      )
      .catch((error) => console.error(error));
  });
});
