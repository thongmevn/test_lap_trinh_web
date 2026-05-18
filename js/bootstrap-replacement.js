/**
 * Bootstrap-like Functionality Replacement
 * Provides modal and collapse functionality without Bootstrap JS
 */

class BootstrapReplacement {
  constructor() {
    this.modals = new Map();
    this.init();
  }

  init() {
    // Initialize all modal triggers
    document.addEventListener("click", (e) => {
      const trigger = e.target.closest('[data-bs-toggle="modal"]');
      if (trigger) {
        const targetId = trigger.getAttribute("data-bs-target");
        if (targetId) {
          this.showModal(targetId);
        }
      }

      // Close modal when close button is clicked
      const closeBtn = e.target.closest('[data-bs-dismiss="modal"]');
      if (closeBtn) {
        const modal = closeBtn.closest(".modal");
        if (modal) {
          this.hideModal(modal.id);
        }
      }

      // Close modal when backdrop is clicked
      if (e.target.classList.contains("modal")) {
        const modal = e.target;
        if (modal.getAttribute("data-bs-backdrop") === "static") {
          // Don't close if backdrop is static
        } else {
          this.hideModal(modal.id);
        }
      }

      // Toggle collapse
      const collapseBtn = e.target.closest('[data-bs-toggle="collapse"]');
      if (collapseBtn) {
        const targetId = collapseBtn.getAttribute("data-bs-target");
        if (targetId) {
          this.toggleCollapse(targetId);
        }
      }
    });

    // Close modal on Escape key
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        document.querySelectorAll(".modal.show").forEach((modal) => {
          if (modal.getAttribute("data-bs-keyboard") !== "false") {
            this.hideModal(modal.id);
          }
        });
      }
    });
  }

  showModal(selector) {
    const modal = document.querySelector(selector);
    if (modal) {
      modal.classList.add("show");
      modal.style.display = "block";
      document.body.style.overflow = "hidden";

      // Add backdrop
      let backdrop = document.querySelector(".modal-backdrop");
      if (!backdrop) {
        backdrop = document.createElement("div");
        backdrop.className = "modal-backdrop fade show";
        document.body.appendChild(backdrop);
      } else {
        backdrop.classList.add("show");
      }

      this.modals.set(selector, true);
    }
  }

  hideModal(selector) {
    const modal = document.getElementById(selector);
    if (modal) {
      modal.classList.remove("show");
      modal.style.display = "none";
      document.body.style.overflow = "";

      // Remove backdrop if no modals are open
      const openModals = document.querySelectorAll(".modal.show");
      if (openModals.length === 0) {
        const backdrop = document.querySelector(".modal-backdrop");
        if (backdrop) {
          backdrop.classList.remove("show");
          backdrop.style.display = "none";
        }
      }

      this.modals.delete(selector);
    }
  }

  toggleCollapse(selector) {
    const element = document.querySelector(selector);
    if (element) {
      element.classList.toggle("show");
    }
  }
}

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", () => {
  new BootstrapReplacement();
});

// Make functions globally available for inline handlers
function showModal(selector) {
  const modal = document.querySelector(selector);
  if (modal) {
    modal.classList.add("show");
    modal.style.display = "block";
    document.body.style.overflow = "hidden";
  }
}

function hideModal(selector) {
  const modal = document.querySelector(selector);
  if (modal) {
    modal.classList.remove("show");
    modal.style.display = "none";
    document.body.style.overflow = "";
  }
}

function toggleCollapse(selector) {
  const element = document.querySelector(selector);
  if (element) {
    element.classList.toggle("show");
  }
}

window.bootstrap = window.bootstrap || {};
window.bootstrap.Modal = {
  getInstance(modal) {
    if (!modal) {
      return null;
    }

    return {
      show() {
        showModal("#" + modal.id);
      },
      hide() {
        hideModal("#" + modal.id);
      }
    };
  },
  getOrCreateInstance(modal) {
    return this.getInstance(modal);
  }
};
