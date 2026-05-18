(function () {
  function resolveTarget(trigger) {
    const target = trigger.getAttribute("data-ui-target");
    return target ? document.querySelector(target) : null;
  }

  function showModal(target) {
    const modal = typeof target === "string" ? document.querySelector(target) : target;
    if (!modal) return;
    modal.classList.add("show");
    modal.setAttribute("aria-hidden", "false");
    document.body.style.overflow = "hidden";
  }

  function hideModal(target) {
    const modal = typeof target === "string" ? document.querySelector(target) : target;
    if (!modal) return;
    modal.classList.remove("show");
    modal.setAttribute("aria-hidden", "true");
    if (!document.querySelector(".modal.show")) {
      document.body.style.overflow = "";
    }
  }

  function toggleCollapse(target) {
    const el = typeof target === "string" ? document.querySelector(target) : target;
    if (el) el.classList.toggle("show");
  }

  function toggleDropdown(button) {
    const menu = button.parentElement.querySelector(".dropdown-menu");
    if (!menu) return;
    document.querySelectorAll(".dropdown-menu.show").forEach((item) => {
      if (item !== menu) item.classList.remove("show");
    });
    menu.classList.toggle("show");
  }

  function showCarouselItem(carousel, nextIndex) {
    const items = Array.from(carousel.querySelectorAll(".carousel-item"));
    if (!items.length) return;
    const current = Math.max(0, items.findIndex((item) => item.classList.contains("active")));
    items[current].classList.remove("active");
    items[(nextIndex + items.length) % items.length].classList.add("active");
  }

  function initCarousel(carousel) {
    const items = carousel.querySelectorAll(".carousel-item");
    if (items.length && !carousel.querySelector(".carousel-item.active")) {
      items[0].classList.add("active");
    }
  }

  document.addEventListener("click", function (event) {
    const modalBtn = event.target.closest('[data-ui-toggle="modal"]');
    if (modalBtn) {
      event.preventDefault();
      if (modalBtn.hasAttribute("data-ui-dismiss")) {
        hideModal(modalBtn.closest(".modal"));
      }
      showModal(resolveTarget(modalBtn));
      return;
    }

    const dismissBtn = event.target.closest('[data-ui-dismiss="modal"]');
    if (dismissBtn) {
      event.preventDefault();
      if (dismissBtn.type === "reset" && dismissBtn.form) {
        dismissBtn.form.reset();
      }
      hideModal(dismissBtn.closest(".modal"));
      return;
    }

    const dropdownBtn = event.target.closest('[data-ui-toggle="dropdown"]');
    if (dropdownBtn) {
      event.preventDefault();
      toggleDropdown(dropdownBtn);
      return;
    }

    const collapseBtn = event.target.closest('[data-ui-toggle="collapse"]');
    if (collapseBtn) {
      event.preventDefault();
      toggleCollapse(resolveTarget(collapseBtn));
      return;
    }

    const prev = event.target.closest(".carousel-control-prev");
    const next = event.target.closest(".carousel-control-next");
    if (prev || next) {
      event.preventDefault();
      const target = (prev || next).getAttribute("data-ui-target");
      const carousel = target ? document.querySelector(target) : (prev || next).closest(".carousel");
      const items = Array.from(carousel.querySelectorAll(".carousel-item"));
      const current = Math.max(0, items.findIndex((item) => item.classList.contains("active")));
      showCarouselItem(carousel, current + (next ? 1 : -1));
      return;
    }

    if (!event.target.closest(".dropdown-menu,.dropdown-toggle")) {
      document.querySelectorAll(".dropdown-menu.show").forEach((menu) => menu.classList.remove("show"));
    }
  });

  document.addEventListener("click", function (event) {
    if (event.target.classList.contains("modal") && event.target.classList.contains("show")) {
      const staticBackdrop = event.target.getAttribute("data-ui-backdrop") === "static";
      if (!staticBackdrop) hideModal(event.target);
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      const modal = document.querySelector(".modal.show");
      if (modal && modal.getAttribute("data-ui-keyboard") !== "false") hideModal(modal);
    }
  });

  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".carousel").forEach(initCarousel);
  });

  window.showUiModal = showModal;
  window.hideUiModal = hideModal;
  window.AppModal = {
    show: showModal,
    hide: hideModal,
    getInstance(target) {
      return {
        show: function () { showModal(target); },
        hide: function () { hideModal(target); }
      };
    }
  };

})();
