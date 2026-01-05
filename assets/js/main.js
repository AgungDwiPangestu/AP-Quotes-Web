/**
 * Ap Quotes - Main JavaScript
 */

// Mobile Menu Toggle
function toggleMobileMenu() {
  const sidebar = document.getElementById("mobileSidebar");
  const overlay = document.getElementById("overlay");

  if (sidebar && overlay) {
    sidebar.classList.toggle("active");
    overlay.classList.toggle("active");
  }
}

// Close Flash Message
function closeFlash() {
  const flash = document.getElementById("flashMessage");
  if (flash) {
    flash.style.opacity = "0";
    setTimeout(() => flash.remove(), 300);
  }
}

// Auto close flash message after 5 seconds
document.addEventListener("DOMContentLoaded", function () {
  const flash = document.getElementById("flashMessage");
  if (flash) {
    setTimeout(() => {
      closeFlash();
    }, 5000);
  }
});

// Smooth scroll to top
function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

// Confirm logout
function confirmLogout() {
  return confirm("Apakah Anda yakin ingin logout?");
}

// Confirm delete
function confirmDelete(message = "Apakah Anda yakin ingin menghapus ini?") {
  return confirm(message);
}

// Like/Unlike Post with AJAX
function toggleLike(postId, element) {
  const isLiked = element.classList.contains("liked");
  const action = isLiked ? "unlike" : "like";

  fetch(`actions/${action}_post.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `post_id=${postId}`,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        element.classList.toggle("liked");
        const countSpan = element.querySelector(".like-count");
        if (countSpan) {
          countSpan.textContent = data.like_count;
        }
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

// Load Comments with AJAX
function loadComments(postId) {
  fetch(`actions/get_comments.php?post_id=${postId}`)
    .then((response) => response.json())
    .then((data) => {
      const container = document.getElementById(`comments-${postId}`);
      if (container && data.comments) {
        container.innerHTML = renderComments(data.comments);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

// Render Comments HTML
function renderComments(comments) {
  if (comments.length === 0) {
    return '<p class="text-center text-secondary">Belum ada komentar</p>';
  }

  return comments
    .map(
      (comment) => `
        <div class="comment-item">
            <div class="comment-avatar">
                ${comment.username.charAt(0).toUpperCase()}
            </div>
            <div class="comment-content">
                <div class="comment-author">${escapeHtml(
                  comment.username
                )}</div>
                <div class="comment-text">${escapeHtml(comment.comment)}</div>
                <div class="comment-date">${comment.created_at}</div>
            </div>
        </div>
    `
    )
    .join("");
}

// Submit Comment with AJAX
function submitComment(postId, formElement) {
  const formData = new FormData(formElement);

  fetch("actions/comment_action.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        formElement.reset();
        loadComments(postId);

        // Update comment count
        const countElement = document.querySelector(
          `#post-${postId} .comment-count`
        );
        if (countElement) {
          const currentCount = parseInt(countElement.textContent) || 0;
          countElement.textContent = currentCount + 1;
        }
      } else {
        alert(data.message || "Gagal menambahkan komentar");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Terjadi kesalahan saat menambahkan komentar");
    });

  return false; // Prevent form submission
}

// Toggle Comments Section
function toggleComments(postId) {
  const section = document.getElementById(`comments-section-${postId}`);
  if (section) {
    const isHidden = section.style.display === "none";
    section.style.display = isHidden ? "block" : "none";

    if (isHidden) {
      loadComments(postId);
    }
  }
}

// Form Validation
function validateForm(formId) {
  const form = document.getElementById(formId);
  if (!form) return false;

  const inputs = form.querySelectorAll("[required]");
  let isValid = true;

  inputs.forEach((input) => {
    if (!input.value.trim()) {
      input.classList.add("error");
      isValid = false;
    } else {
      input.classList.remove("error");
    }
  });

  return isValid;
}

// Email Validation
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

// Password Strength Checker
function checkPasswordStrength(password) {
  let strength = 0;

  if (password.length >= 8) strength++;
  if (password.match(/[a-z]/)) strength++;
  if (password.match(/[A-Z]/)) strength++;
  if (password.match(/[0-9]/)) strength++;
  if (password.match(/[^a-zA-Z0-9]/)) strength++;

  return strength;
}

// Display Password Strength
function displayPasswordStrength(inputId, displayId) {
  const input = document.getElementById(inputId);
  const display = document.getElementById(displayId);

  if (!input || !display) return;

  input.addEventListener("input", function () {
    const strength = checkPasswordStrength(this.value);
    const strengthText = [
      "Sangat Lemah",
      "Lemah",
      "Sedang",
      "Kuat",
      "Sangat Kuat",
    ];
    const strengthColors = [
      "#e53935",
      "#fb8c00",
      "#fdd835",
      "#43a047",
      "#2e7d32",
    ];

    display.textContent = strengthText[strength - 1] || "";
    display.style.color = strengthColors[strength - 1] || "#757575";
  });
}

// Character Counter
function setupCharCounter(textareaId, counterId, maxLength) {
  const textarea = document.getElementById(textareaId);
  const counter = document.getElementById(counterId);

  if (!textarea || !counter) return;

  textarea.addEventListener("input", function () {
    const remaining = maxLength - this.value.length;
    counter.textContent = `${remaining} karakter tersisa`;

    if (remaining < 0) {
      counter.style.color = "#e53935";
      this.value = this.value.substring(0, maxLength);
    } else {
      counter.style.color = "#757575";
    }
  });
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
  const map = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    "'": "&#039;",
  };
  return text.replace(/[&<>"']/g, (m) => map[m]);
}

// Modal Functions
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.add("active");
  }
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.remove("active");
  }
}

// Close modal on outside click
document.addEventListener("click", function (e) {
  if (e.target.classList.contains("modal")) {
    e.target.classList.remove("active");
  }
});

// Image Preview
function previewImage(input, previewId) {
  const preview = document.getElementById(previewId);

  if (input.files && input.files[0] && preview) {
    const reader = new FileReader();

    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.style.display = "block";
    };

    reader.readAsDataURL(input.files[0]);
  }
}

// Debounce Function
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Search with debounce
function setupSearch(inputId, resultsId, searchFunction) {
  const input = document.getElementById(inputId);

  if (!input) return;

  const debouncedSearch = debounce(function (query) {
    searchFunction(query);
  }, 300);

  input.addEventListener("input", function () {
    debouncedSearch(this.value);
  });
}

// Copy to Clipboard
function copyToClipboard(text) {
  if (navigator.clipboard) {
    navigator.clipboard.writeText(text).then(() => {
      alert("Teks berhasil disalin!");
    });
  } else {
    // Fallback for older browsers
    const textarea = document.createElement("textarea");
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand("copy");
    document.body.removeChild(textarea);
    alert("Teks berhasil disalin!");
  }
}

// Initialize tooltips
document.addEventListener("DOMContentLoaded", function () {
  // Add any initialization code here
  console.log("Ap Quotes loaded successfully!");
});
