let add_room_form = document.getElementById("add_room_form");

let selectedImages = [];

add_room_form.addEventListener("submit", function (e) {
  e.preventDefault();
  add_room();
});

// Image input preview handling for Add Room
let addRoomImagesInput = document.getElementById("add-room-images-input");
let addRoomPreviews = document.getElementById("add-room-previews");
if (addRoomImagesInput) {
  addRoomImagesInput.addEventListener("change", function (e) {
    selectedImages = Array.from(this.files);
    renderAddRoomPreviews();
    // clear file input so user can re-select same files if needed
    this.value = "";
  });
}

function renderAddRoomPreviews() {
  if (!addRoomPreviews) return;
  addRoomPreviews.innerHTML = "";
  selectedImages.forEach((file, idx) => {
    if (!file.type.startsWith("image/")) return;
    let reader = new FileReader();
    let wrapper = document.createElement("div");
    wrapper.className = "preview-item";
    wrapper.style =
      "position:relative;width:90px;height:70px;border:1px solid #e3e3e3;border-radius:6px;overflow:hidden;display:inline-block;margin-right:8px;";

    let delBtn = document.createElement("button");
    delBtn.type = "button";
    delBtn.className = "btn btn-sm btn-danger";
    delBtn.style =
      "position:absolute;top:4px;right:4px;padding:2px 6px;font-size:12px;line-height:1";
    delBtn.innerText = "×";
    delBtn.addEventListener("click", function () {
      selectedImages.splice(idx, 1);
      renderAddRoomPreviews();
    });

    reader.onload = function (ev) {
      let img = document.createElement("img");
      img.src = ev.target.result;
      img.style = "width:100%;height:100%;object-fit:cover;display:block";
      wrapper.appendChild(img);
      wrapper.appendChild(delBtn);
    };

    reader.readAsDataURL(file);
    addRoomPreviews.appendChild(wrapper);
  });
}

function add_room() {
  let data = new FormData();
  data.append("add_room", "");
  data.append("name", add_room_form.elements["name"].value);
  data.append("area", add_room_form.elements["area"].value);
  data.append("price", add_room_form.elements["price"].value);
  data.append("quantity", add_room_form.elements["quantity"].value);
  data.append("adult", add_room_form.elements["adult"].value);
  data.append("children", add_room_form.elements["children"].value);
  data.append("desc", add_room_form.elements["desc"].value);

  let features = [];
  add_room_form.elements["features"].forEach((el) => {
    if (el.checked) {
      features.push(el.value);
    }
  });

  let facilities = [];
  add_room_form.elements["facilities"].forEach((el) => {
    if (el.checked) {
      facilities.push(el.value);
    }
  });

  data.append("features", JSON.stringify(features));
  data.append("facilities", JSON.stringify(facilities));

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function () {
    var myModalEl = document.getElementById("add-room");
    var modal = bootstrap.Modal.getInstance(myModalEl);

    let resp = this.responseText.trim();
    let roomId = parseInt(resp);

    if (!isNaN(roomId) && roomId > 0) {
      // If images were selected, upload them to the add_image endpoint
      try {
        if (selectedImages && selectedImages.length > 0) {
          for (let i = 0; i < selectedImages.length; i++) {
            let fdata = new FormData();
            fdata.append("add_image", "");
            fdata.append("room_id", roomId);
            fdata.append("image", selectedImages[i]);

            let xi = new XMLHttpRequest();
            xi.open("POST", "ajax/rooms.php", true);
            xi.onload = function () {
              // optional: handle per-image feedback
            };
            xi.send(fdata);
          }
        }
      } catch (e) {
        console.error(e);
      }

      if (modal) modal.hide();
      alert("success", "New room added!");
      add_room_form.reset();
      selectedImages = [];
      if (addRoomPreviews) addRoomPreviews.innerHTML = "";
      get_all_rooms();
    } else {
      if (modal) modal.hide();
      alert("error", "Server Down!");
    }
  };

  xhr.send(data);
}

function get_all_rooms() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    document.getElementById("room-data").innerHTML = this.responseText;
  };

  xhr.send("get_all_rooms");
}

let edit_room_form = document.getElementById("edit_room_form");

function edit_details(id) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    let data = JSON.parse(this.responseText);

    edit_room_form.elements["name"].value = data.roomdata.name;
    edit_room_form.elements["area"].value = data.roomdata.area;
    edit_room_form.elements["price"].value = data.roomdata.price;
    edit_room_form.elements["quantity"].value = data.roomdata.quantity;
    edit_room_form.elements["adult"].value = data.roomdata.adult;
    edit_room_form.elements["children"].value = data.roomdata.children;
    edit_room_form.elements["desc"].value = data.roomdata.description;
    edit_room_form.elements["room_id"].value = data.roomdata.id;

    edit_room_form.elements["features"].forEach((el) => {
      if (data.features.includes(Number(el.value))) {
        el.checked = true;
      }
    });

    edit_room_form.elements["facilities"].forEach((el) => {
      if (data.facilities.includes(Number(el.value))) {
        el.checked = true;
      }
    });
  };

  xhr.send("get_room=" + id);
}

edit_room_form.addEventListener("submit", function (e) {
  e.preventDefault();
  submit_edit_room();
});

function submit_edit_room() {
  let data = new FormData();
  data.append("edit_room", "");
  data.append("room_id", edit_room_form.elements["room_id"].value);
  data.append("name", edit_room_form.elements["name"].value);
  data.append("area", edit_room_form.elements["area"].value);
  data.append("price", edit_room_form.elements["price"].value);
  data.append("quantity", edit_room_form.elements["quantity"].value);
  data.append("adult", edit_room_form.elements["adult"].value);
  data.append("children", edit_room_form.elements["children"].value);
  data.append("desc", edit_room_form.elements["desc"].value);

  let features = [];
  edit_room_form.elements["features"].forEach((el) => {
    if (el.checked) {
      features.push(el.value);
    }
  });

  let facilities = [];
  edit_room_form.elements["facilities"].forEach((el) => {
    if (el.checked) {
      facilities.push(el.value);
    }
  });

  data.append("features", JSON.stringify(features));
  data.append("facilities", JSON.stringify(facilities));

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function () {
    // Cách tắt Modal chuẩn Bootstrap 5
    var myModalEl = document.getElementById("edit-room");
    var modal = bootstrap.Modal.getInstance(myModalEl);
    if (modal) modal.hide();

    if (this.responseText == 1) {
      alert("success", "Dữ liệu phòng đã được cập nhật!");
      get_all_rooms();
    } else {
      alert("error", "Lỗi hệ thống hoặc không có thay đổi!");
    }
  };

  xhr.send(data);
}

function toggle_status(id, val) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert("success", "Status toggled!");
      get_all_rooms();
    } else {
      alert("success", "Server Down!");
    }
  };

  xhr.send("toggle_status=" + id + "&value=" + val);
}

let add_image_form = document.getElementById("add_image_form");

add_image_form.addEventListener("submit", function (e) {
  e.preventDefault();
  add_image();
});

function add_image() {
  let data = new FormData();
  data.append("image", add_image_form.elements["image"].files[0]);
  data.append("room_id", add_image_form.elements["room_id"].value);
  data.append("add_image", "");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function () {
    let response = this.responseText.trim();

    if (response == "inv_img") {
      alert(
        "error",
        "Only JPG, WEBP or PNG images are allowed!",
        "image-alert",
      );
    } else if (response == "inv_size") {
      alert("error", "Image should be less than 2MB!", "image-alert");
    } else if (response == "upd_failed") {
      alert("error", "Image upload failed. Server Down!", "image-alert");
    } else if (response == "1" || response.includes("1")) {
      alert("success", "New image added!", "image-alert");
      room_images(
        add_image_form.elements["room_id"].value,
        document.querySelector("#room-images .modal-title").innerText,
      );
      add_image_form.reset();
    } else {
      alert("error", "Lỗi hệ thống: " + response, "image-alert");
    }
  };
  xhr.send(data);
}

function room_images(id, rname) {
  document.querySelector("#room-images .modal-title").innerText = rname;
  add_image_form.elements["room_id"].value = id;
  add_image_form.elements["image"].value = "";

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    document.getElementById("room-image-data").innerHTML = this.responseText;
  };

  xhr.send("get_room_images=" + id);
}

function rem_image(img_id, room_id) {
  let data = new FormData();
  data.append("image_id", img_id);
  data.append("room_id", room_id);
  data.append("rem_image", "");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert("success", "Image Removed!", "image-alert");
      room_images(
        room_id,
        document.querySelector("#room-images .modal-title").innerText,
      );
    } else {
      alert("error", "Image removal failed!", "image-alert");
    }
  };
  xhr.send(data);
}

function thumb_image(img_id, room_id) {
  let data = new FormData();
  data.append("image_id", img_id);
  data.append("room_id", room_id);
  data.append("thumb_image", "");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert("success", "Image Thumbnail Changed!", "image-alert");
      room_images(
        room_id,
        document.querySelector("#room-images .modal-title").innerText,
      );
    } else {
      alert("error", "Thumbnail update failed!", "image-alert");
    }
  };
  xhr.send(data);
}

// Replace an existing room image (admin) - called from the hidden file input in images table
function replace_image(inputEl, image_id, room_id) {
  if (!inputEl || !inputEl.files || !inputEl.files[0]) return;

  let data = new FormData();
  data.append("replace_image", "");
  data.append("image_id", image_id);
  data.append("room_id", room_id);
  data.append("image", inputEl.files[0]);

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms.php", true);

  xhr.onload = function () {
    let resp = this.responseText.trim();

    if (resp == "inv_img") {
      alert(
        "error",
        "Only JPG, WEBP or PNG images are allowed!",
        "image-alert",
      );
    } else if (resp == "inv_size") {
      alert("error", "Image should be less than 2MB!", "image-alert");
    } else if (resp == "upd_failed") {
      alert("error", "Image upload failed. Server Down!", "image-alert");
    } else if (resp == "1" || resp.includes("1")) {
      alert("success", "Image replaced!", "image-alert");
      room_images(
        room_id,
        document.querySelector("#room-images .modal-title").innerText,
      );
    } else {
      alert("error", "Replace failed! Lỗi thực tế: " + resp, "image-alert");
      console.log(resp);
    }
  };

  xhr.send(data);
}

function remove_room(room_id) {
  if (confirm("Are you sure, you want to delete this room?")) {
    let data = new FormData();
    data.append("room_id", room_id);
    data.append("remove_room", "");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function () {
      if (this.responseText == 1) {
        alert("success", "Room Removed!");
        get_all_rooms();
      } else {
        alert("error", "Room removal failed!");
      }
    };
    xhr.send(data);
  }
}

window.onload = function () {
  get_all_rooms();
};
