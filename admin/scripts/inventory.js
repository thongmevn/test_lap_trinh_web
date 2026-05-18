const itemForm = document.getElementById("item-form");
const chargeForm = document.getElementById("charge-form");
const bookingSearch = document.getElementById("booking-search");
const chargeSearch = document.getElementById("charge-search");
const itemSelect = document.getElementById("item-select");

function postForm(data, callback) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/inventory.php", true);
  xhr.onload = function () {
    callback(this.responseText);
  };
  xhr.send(data);
}

function postUrlEncoded(payload, callback) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/inventory.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    callback(this.responseText);
  };
  xhr.send(payload);
}

function get_items() {
  postUrlEncoded("get_items=1", function (html) {
    document.getElementById("items-data").innerHTML = html;
  });
}

function get_item_options() {
  postUrlEncoded("get_item_options=1", function (html) {
    itemSelect.innerHTML = html;
  });
}

function get_booking_options(search = "") {
  postUrlEncoded("get_booking_options=1&search=" + encodeURIComponent(search), function (html) {
    document.getElementById("booking-select").innerHTML = html;
  });
}

function get_charges(search = "") {
  postUrlEncoded("get_charges=1&search=" + encodeURIComponent(search), function (html) {
    document.getElementById("charges-data").innerHTML = html;
  });
}

function reset_item_form() {
  itemForm.reset();
  itemForm.elements["item_id"].value = "";
}

itemForm.addEventListener("submit", function (event) {
  event.preventDefault();

  const data = new FormData(itemForm);
  data.append(itemForm.elements["item_id"].value ? "update_item" : "add_item", "");

  postForm(data, function (result) {
    if (result == 1) {
      alert("success", "Đã lưu đồ dùng!");
      reset_item_form();
      get_items();
      get_item_options();
    } else {
      alert("error", "Không thể lưu đồ dùng!");
    }
  });
});

function edit_item(id) {
  postUrlEncoded("get_item=1&item_id=" + id, function (response) {
    const data = JSON.parse(response);
    itemForm.elements["item_id"].value = data.id;
    itemForm.elements["name"].value = data.name;
    itemForm.elements["category"].value = data.category || "";
    itemForm.elements["default_charge"].value = data.default_charge;
    itemForm.scrollIntoView({ behavior: "smooth", block: "start" });
  });
}

function toggle_item_status(id, value) {
  postUrlEncoded("toggle_item_status=" + id + "&value=" + value, function (result) {
    if (result == 1) {
      get_items();
      get_item_options();
    } else {
      alert("error", "Không thể đổi trạng thái!");
    }
  });
}

function delete_item(id) {
  if (!confirm("Xóa đồ dùng này?")) return;
  postUrlEncoded("delete_item=1&item_id=" + id, function (result) {
    if (result == 1) {
      alert("success", "Đã xóa đồ dùng!");
      get_items();
      get_item_options();
    } else if (result === "charge_exists") {
      alert("error", "Đồ dùng đã phát sinh bồi thường, không thể xóa!");
    } else {
      alert("error", "Không thể xóa đồ dùng!");
    }
  });
}

itemSelect.addEventListener("change", function () {
  const option = itemSelect.options[itemSelect.selectedIndex];
  const charge = option ? option.getAttribute("data-charge") : "";
  chargeForm.elements["unit_charge"].value = charge || "";
});

bookingSearch.addEventListener("input", function () {
  get_booking_options(this.value);
});

chargeSearch.addEventListener("input", function () {
  get_charges(this.value);
});

chargeForm.addEventListener("submit", function (event) {
  event.preventDefault();

  const data = new FormData(chargeForm);
  data.append("add_charge", "");

  postForm(data, function (result) {
    if (result == 1) {
      alert("success", "Đã thêm khoản bồi thường!");
      chargeForm.reset();
      get_booking_options(bookingSearch.value);
      get_charges(chargeSearch.value);
    } else {
      alert("error", "Không thể thêm bồi thường. Kiểm tra booking và đồ dùng!");
    }
  });
});

function set_charge_status(id, status) {
  postUrlEncoded("set_charge_status=1&charge_id=" + id + "&status=" + status, function (result) {
    if (result == 1) {
      alert("success", "Đã cập nhật trạng thái!");
      get_charges(chargeSearch.value);
    } else {
      alert("error", "Không thể cập nhật trạng thái!");
    }
  });
}

function delete_charge(id) {
  if (!confirm("Xóa khoản bồi thường này?")) return;
  postUrlEncoded("delete_charge=1&charge_id=" + id, function (result) {
    if (result == 1) {
      alert("success", "Đã xóa khoản bồi thường!");
      get_charges(chargeSearch.value);
    } else {
      alert("error", "Không thể xóa khoản bồi thường!");
    }
  });
}

window.onload = function () {
  get_items();
  get_item_options();
  get_booking_options();
  get_charges();
};
