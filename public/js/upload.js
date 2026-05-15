// public/js/upload.js
function previewImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    const imageField = document.getElementById("imagePreview");
    const dropzoneContent = document.getElementById("dropzoneContent");
    const dropzoneContainer = document.getElementById("dropzoneContainer");
    const fileDetailsPanel = document.getElementById("fileDetailsPanel");

    const fileNameDisplay = document.getElementById("fileName");
    const fileSizeDisplay = document.getElementById("fileSize");

    if (file) {
        reader.onload = function () {
            if (reader.readyState == 2) {
                imageField.src = reader.result;
                imageField.classList.remove("opacity-0");
                imageField.classList.add("opacity-100");
                dropzoneContent.classList.add("opacity-0");
                dropzoneContainer.classList.remove("border-dashed", "border-2");
                dropzoneContainer.classList.add("border-0");

                let fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                fileNameDisplay.innerText = file.name;
                fileSizeDisplay.innerText = fileSizeMB + " MB";

                fileDetailsPanel.classList.remove("hidden");
                fileDetailsPanel.classList.add("flex");
            }
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById("photo").value = "";
    const imageField = document.getElementById("imagePreview");
    imageField.src = "#";
    imageField.classList.remove("opacity-100");
    imageField.classList.add("opacity-0");
    document.getElementById("dropzoneContent").classList.remove("opacity-0");
    const dropzoneContainer = document.getElementById("dropzoneContainer");
    dropzoneContainer.classList.remove("border-0");
    dropzoneContainer.classList.add("border-dashed", "border-2");
    const fileDetailsPanel = document.getElementById("fileDetailsPanel");
    fileDetailsPanel.classList.add("hidden");
    fileDetailsPanel.classList.remove("flex");
}
