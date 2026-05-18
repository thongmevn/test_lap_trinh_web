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

  document.addEventListener("click", function (event) {
    const modalBtn = event.target.closest('[data-ui-toggle="modal"], [data-bs-toggle="modal"]');
    if (modalBtn) {
      event.preventDefault();
      const target = resolveTarget(modalBtn) || document.querySelector(modalBtn.getAttribute("data-bs-target"));
      showModal(target);
      return;
    }

    const dismissBtn = event.target.closest('[data-ui-dismiss="modal"], [data-bs-dismiss="modal"]');
    if (dismissBtn) {
      event.preventDefault();
      if (dismissBtn.type === "reset" && dismissBtn.form) {
        dismissBtn.form.reset();
      }
      hideModal(dismissBtn.closest(".modal"));
      return;
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

  window.bootstrap = window.bootstrap || {};
  window.bootstrap.Modal = {
    getInstance: function (target) {
      return window.AppModal.getInstance(target);
    },
    getOrCreateInstance: function (target) {
      return window.AppModal.getInstance(target);
    }
  };

})();
