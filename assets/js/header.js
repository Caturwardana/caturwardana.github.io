document.addEventListener('DOMContentLoaded', function () {
    const headerPlaceholder = document.getElementById('header-placeholder');
    if (!headerPlaceholder) return;

    const basePath = headerPlaceholder.getAttribute('data-base') || '.';
    const activePage = headerPlaceholder.getAttribute('data-active') || '';

    const prefix = basePath === '.' ? '' : basePath + '/';

    headerPlaceholder.innerHTML = `
<header>
    <a href="${prefix}" class="logo"><i class="fa fa-cog"></i> Catur</a>

    <div id="menu" class="fas fa-bars"></div>
    <nav class="navbar">
        <ul>
        <li><a href="${prefix}#home" class="${activePage === 'home' ? 'active' : ''}">Home</a></li>
        <li><a href="${prefix}#about" class="${activePage === 'about' ? 'active' : ''}">About</a></li>
        <li><a href="${prefix}#skills" class="${activePage === 'skills' ? 'active' : ''}">Skills</a></li>
        <li><a href="${prefix}#education" class="${activePage === 'education' ? 'active' : ''}">Education</a></li>
        <li><a href="${prefix}#work" class="${activePage === 'work' ? 'active' : ''}">Work</a></li>
        <li><a href="${prefix}#experience" class="${activePage === 'experience' ? 'active' : ''}">Experience</a></li>
        <li><a href="${prefix}#contact" class="${activePage === 'contact' ? 'active' : ''}">Contact</a></li>
        </ul>
    </nav>
</header>
`;
});
