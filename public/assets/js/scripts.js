// Menu toggle functionality
const menuBtn = document.getElementById("menu-btn");
const navLinks = document.getElementById("nav-links");
const menuBtnIcon = menuBtn.querySelector("i");

menuBtn.addEventListener("click", (e) => {
  navLinks.classList.toggle("open");

  const isOpen = navLinks.classList.contains("open");
  menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line");
});

navLinks.addEventListener("click", (e) => {
  navLinks.classList.remove("open");
  menuBtnIcon.setAttribute("class", "ri-menu-line");
});

// See More functionality
function truncateDescription(id, maxLength) {
  const description = document.getElementById(`job-description-${id}`);
  const fullText = description.textContent.trim();

  // Only truncate if text length exceeds maxLength
  if (fullText.length > maxLength) {
    const truncatedText = fullText.substring(0, maxLength) + '...'; // Truncate with ellipsis
    description.textContent = truncatedText;  // Set the truncated text

    // Add "See more" link
    const seeMore = document.createElement('span');
    seeMore.className = 'see-more';
    seeMore.textContent = ' See more';
    seeMore.onclick = function () {
      toggleDescription(id);
    };
    description.appendChild(seeMore);
    description.setAttribute('data-full-text', fullText);  // Store full text for later
  }
}

function toggleDescription(id) {
  const description = document.getElementById(`job-description-${id}`);
  const seeMore = description.querySelector('.see-more');

  // Toggle the full description when clicking "See more"
  description.classList.toggle('expanded');

  if (description.classList.contains('expanded')) {
    description.textContent = description.getAttribute('data-full-text');  // Show full description
    const seeLess = document.createElement('span');
    seeLess.className = 'see-more';
    seeLess.textContent = ' See less';
    seeLess.onclick = function () {
      toggleDescription(id);
    };
    description.appendChild(seeLess);
  } else {
    truncateDescription(id, 200);  // Revert back to truncated description
  }
}