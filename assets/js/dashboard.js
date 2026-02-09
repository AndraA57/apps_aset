// Init Lucide Icons
lucide.createIcons();

// Mobile Sidebar Logic
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("sidebarOverlay");
const toggleBtn = document.getElementById("mobileToggle");

function toggleSidebar() {
  sidebar.classList.toggle("show");
  overlay.classList.toggle("show");
}

toggleBtn.addEventListener("click", toggleSidebar);
overlay.addEventListener("click", toggleSidebar);
