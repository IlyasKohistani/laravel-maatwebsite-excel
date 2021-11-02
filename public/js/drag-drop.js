document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
  const dropZoneElement = inputElement.closest(".drop-zone");

  dropZoneElement.addEventListener("click", (e) => {
    inputElement.click();
  });

  inputElement.addEventListener("change", (e) => {
    if (inputElement.files.length) {
      updateThumbnail(dropZoneElement, inputElement.files[0]);
    }
  });

  dropZoneElement.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZoneElement.classList.add("drop-zone--over");
  });

  ["dragleave", "dragend"].forEach((type) => {
    dropZoneElement.addEventListener(type, (e) => {
      dropZoneElement.classList.remove("drop-zone--over");
    });
  });

  dropZoneElement.addEventListener("drop", (e) => {
    e.preventDefault();

    if (e.dataTransfer.files.length) {
      inputElement.files = e.dataTransfer.files;
      var event = new Event('change');
      // Dispatch it.
      inputElement.dispatchEvent(event);
      updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
    }

    dropZoneElement.classList.remove("drop-zone--over");
  });
});

/**
 * Updates the thumbnail on a drop zone element.
 *
 * @param {HTMLElement} dropZoneElement
 * @param {File} file
 */
function updateThumbnail(dropZoneElement, file) {
  let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

  // First time - remove the prompt
  if (dropZoneElement.querySelector(".drop-zone__prompt")) {
    dropZoneElement.querySelector(".drop-zone__prompt").remove();
  }

  // First time - there is no thumbnail element, so lets create it
  if (!thumbnailElement) {
    thumbnailElement = document.createElement("div");
    thumbnailElement.classList.add("drop-zone__thumb");
    dropZoneElement.appendChild(thumbnailElement);
  }

  thumbnailElement.dataset.label = file.name;
  thumbnailElement.innerHTML = ""

  // Show thumbnail for image files
  if (file.type.startsWith("image/")) {
    const reader = new FileReader();

    reader.readAsDataURL(file);
    reader.onload = () => {
      thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
    };
  } else if (file.name.includes('xlsx') || file.name.includes('xls')) {
    thumbnailElement.style.backgroundImage = null
    thumbnailElement.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" height="90%" viewBox="0 0 48 48" style=" fill:#000000;"><path fill="#c1f5ea" d="M29,6H15.744C14.781,6,14,6.781,14,7.744v7.259h15V6z"></path><path fill="#7decd6" d="M14,15.003h15v9.002H14V15.003z"></path><path fill="#3ddab4" d="M14,24.005h15v9.05H14V24.005z"></path><path fill="#c1f5ea" d="M42.256,6H29v9.003h15V7.744C44,6.781,43.219,6,42.256,6z"></path><path fill="#7decd6" d="M29,15.003h15v9.002H29V15.003z"></path><path fill="#3ddab4" d="M29,24.005h15v9.05H29V24.005z"></path><path fill="#7decd6" d="M6.513,15H14v18H6.513C5.678,33,5,32.322,5,31.487V16.513C5,15.678,5.678,15,6.513,15z"></path><path fill="#00b569" d="M14,33v7.256C14,41.219,14.781,42,15.743,42H29h13.257C43.219,42,44,41.219,44,40.257V33H14z"></path><path fill="#00b569" d="M14,24v9h7.487C22.322,33,23,32.322,23,31.487V24H14z"></path><path fill="#3ddab4" d="M14,24v-9h7.487C22.322,15,23,15.678,23,16.513V24H14z"></path><path fill="#fff" d="M9.807,19h2.386l1.936,3.754L16.175,19h2.229l-3.071,5l3.141,5h-2.351l-2.11-3.93L11.912,29H9.526 l3.193-5.018L9.807,19z"></path></svg>';
  } else {
    thumbnailElement.style.backgroundImage = null
  }
}
