$(document).ready(function () {
    $('#menu').click(function () {
        $(this).toggleClass('fa-times');
        $('.navbar').toggleClass('nav-toggle');
    });

    $(window).on('scroll load', function () {
        $('#menu').removeClass('fa-times');
        $('.navbar').removeClass('nav-toggle');
    });

    // Get project ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    const projectId = urlParams.get('id');

    if (projectId) {
        loadProject(projectId);
    } else {
        showNotFound();
    }
});

async function loadProject(projectId) {
    try {
        const response = await fetch('projects.json');
        const projects = await response.json();
        const project = projects.find(p => p.id === projectId);

        if (project) {
            renderProject(project);
            updateTitle(project.name);
        } else {
            showNotFound();
        }
    } catch (error) {
        console.error('Error loading project:', error);
        showNotFound();
    }
}

function renderProject(project) {
    const container = document.getElementById('project-container');

    const skillsHTML = project.skills ? project.skills.map(skill =>
        `<span class="skill-tag">${skill}</span>`
    ).join('') : '';

    const specsHTML = project.specs ? project.specs.map(spec =>
        `<li>${spec}</li>`
    ).join('') : '';

    const imagesHTML = project.images ? project.images.map((img, index) =>
        `<div class="gallery-item" onclick="openLightbox(${index})">
            <img src="../assets/images/projects/${img}" alt="${project.name} - Image ${index + 1}" onerror="this.src='../assets/images/placeholder.png'">
            <div class="overlay">
                <span>View Image ${index + 1}</span>
            </div>
        </div>`
    ).join('') : '';

    const posterHTML = project.poster ? `
        <div class="project-poster">
            <h2>Project Poster</h2>
            <div class="poster-wrapper">
                <img src="../assets/images/projects/${project.poster}" alt="${project.name} Poster" class="poster-image" onerror="this.parentElement.style.display='none'">
            </div>
        </div>
    ` : '';

    const videosHTML = project.videos && project.videos.length > 0 ? `
        <div class="project-videos">
            <h2><i class="fas fa-play-circle"></i> Videos</h2>
            <div class="video-grid">
                ${project.videos.map(video => {
                    const videoId = extractYouTubeId(video.url);
                    return videoId ? `
                    <div class="video-item">
                        <div class="video-wrapper">
                            <iframe src="https://www.youtube.com/embed/${videoId}" title="${video.title}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <p class="video-title">${video.title}</p>
                    </div>
                    ` : `
                    <div class="video-item">
                        <a href="${video.url}" target="_blank" class="video-link">
                            <i class="fas fa-external-link-alt"></i> ${video.title}
                        </a>
                    </div>
                    `;
                }).join('')}
            </div>
        </div>
    ` : '';

    const resourcesHTML = project.resources && project.resources.length > 0 ? `
        <div class="project-resources">
            <h2><i class="fas fa-external-link-alt"></i> Resources & Links</h2>
            <div class="resources-grid">
                ${project.resources.map(item => {
                    const iconMap = {
                        'journal': 'fas fa-book',
                        'patent': 'fas fa-certificate',
                        'documentation': 'fas fa-file-alt',
                        'report': 'fas fa-chart-bar',
                        'github': 'fab fa-github',
                        'website': 'fas fa-globe',
                        'other': 'fas fa-link'
                    };
                    const icon = iconMap[item.type] || iconMap['other'];
                    return `
                    <a href="${item.url}" target="_blank" class="resource-item">
                        <div class="resource-icon"><i class="${icon}"></i></div>
                        <div class="resource-info">
                            <span class="resource-type">${item.type.charAt(0).toUpperCase() + item.type.slice(1)}</span>
                            <span class="resource-title">${item.title}</span>
                        </div>
                        <i class="fas fa-arrow-right resource-arrow"></i>
                    </a>
                    `;
                }).join('')}
            </div>
        </div>
    ` : '';

    const newsHTML = project.news && project.news.length > 0 ? `
        <div class="project-news">
            <h2><i class="fas fa-newspaper"></i> News & Media Coverage</h2>
            <div class="news-list">
                ${project.news.map(item => `
                    <a href="${item.url}" target="_blank" class="news-item">
                        <i class="fas fa-link"></i>
                        <span>${item.title}</span>
                        <i class="fas fa-external-link-alt external-icon"></i>
                    </a>
                `).join('')}
            </div>
        </div>
    ` : '';

    const achievementsHTML = project.achievements ?
        `<div class="project-achievements">
            <h2><i class="fas fa-trophy"></i> Achievements</h2>
            <p class="achievement-badge">${project.achievements}</p>
        </div>` : '';

    container.innerHTML = `
        <a href="./index.html" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Projects
        </a>

        <div class="project-header">
            <h1>${project.name}</h1>
            <div class="project-meta">
                <span><i class="fas fa-calendar"></i> ${project.date}</span>
                <span><i class="fas fa-building"></i> ${project.client}</span>
                <span><i class="fas fa-tag"></i> ${project.category.charAt(0).toUpperCase() + project.category.slice(1)}</span>
            </div>
            <div class="project-skills">
                ${skillsHTML}
            </div>
        </div>

        <div class="project-description">
            <h2>Overview</h2>
            <p>${project.fullDesc}</p>
        </div>

        ${posterHTML}

        ${project.specs && project.specs.length > 0 ? `
        <div class="project-specs">
            <h2>Key Features & Specifications</h2>
            <ul>
                ${specsHTML}
            </ul>
        </div>
        ` : ''}

        ${achievementsHTML}

        ${videosHTML}

        ${resourcesHTML}

        ${newsHTML}

        ${project.images && project.images.length > 0 ? `
        <div class="project-gallery">
            <h2><i class="fas fa-images"></i> Project Gallery</h2>
            <div class="gallery-grid">
                ${imagesHTML}
            </div>
        </div>
        ` : ''}
    `;

    // Create lightbox
    if (project.images && project.images.length > 0) {
        createLightbox(project.images);
    }

    // Reinitialize tilt effect
    VanillaTilt.init(document.querySelectorAll(".tilt"), {
        max: 15,
    });
}

function extractYouTubeId(url) {
    const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([^&?#]+)/);
    return match ? match[1] : null;
}

function createLightbox(images) {
    const lightbox = document.createElement('div');
    lightbox.className = 'lightbox';
    lightbox.id = 'lightbox';
    lightbox.innerHTML = `
        <span class="close" onclick="closeLightbox()">&times;</span>
        <span class="nav prev" onclick="navigateLightbox(-1)">&#10094;</span>
        <span class="nav next" onclick="navigateLightbox(1)">&#10095;</span>
        <img id="lightbox-img" src="" alt="Project Image">
    `;
    document.body.appendChild(lightbox);

    // Store images for navigation
    window.lightboxImages = images;
    window.currentLightboxIndex = 0;

    // Close on background click
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (!lightbox.classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') navigateLightbox(-1);
        if (e.key === 'ArrowRight') navigateLightbox(1);
    });
}

function openLightbox(index) {
    const lightbox = document.getElementById('lightbox');
    const img = document.getElementById('lightbox-img');
    window.currentLightboxIndex = index;
    img.src = `../assets/images/projects/${window.lightboxImages[index]}`;
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.remove('active');
    document.body.style.overflow = '';
}

function navigateLightbox(direction) {
    let newIndex = window.currentLightboxIndex + direction;
    if (newIndex < 0) newIndex = window.lightboxImages.length - 1;
    if (newIndex >= window.lightboxImages.length) newIndex = 0;
    openLightbox(newIndex);
}

function updateTitle(projectName) {
    document.title = `${projectName} | Portfolio Catur Wardana`;
}

function showNotFound() {
    const container = document.getElementById('project-container');
    container.innerHTML = `
        <div class="not-found">
            <h2>Project Not Found</h2>
            <p>The project you're looking for doesn't exist or has been moved.</p>
            <a href="./index.html" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
        </div>
    `;
}

// Scroll to top
$(window).on('scroll', function () {
    if (window.scrollY > 60) {
        document.querySelector('#scroll-top').classList.add('active');
    } else {
        document.querySelector('#scroll-top').classList.remove('active');
    }
});

// Disable developer mode
document.onkeydown = function (e) {
    if (e.keyCode == 123) return false;
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) return false;
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) return false;
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) return false;
    if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) return false;
};
