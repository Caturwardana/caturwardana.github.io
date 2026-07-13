document.addEventListener('DOMContentLoaded', function () {
    const footerPlaceholder = document.getElementById('footer-placeholder');
    if (!footerPlaceholder) return;

    const basePath = footerPlaceholder.getAttribute('data-base') || '.';

    footerPlaceholder.innerHTML = `
<section class="footer">
  <div class="box-container">
      <div class="box">
          <h3>Catur's Portfolio</h3>
          <p>Thank you for visiting my personal portfolio website. Connect with me over socials. <br/> <br/> Keep Rising 🚀. Connect with me over live chat!</p>
      </div>

      <div class="box">
          <h3>quick links</h3>
          <a href="${basePath === '.' ? '' : basePath + '/'}#home"><i class="fas fa-chevron-circle-right"></i> home</a>
          <a href="${basePath === '.' ? '' : basePath + '/'}#about"><i class="fas fa-chevron-circle-right"></i> about</a>
          <a href="${basePath === '.' ? '' : basePath + '/'}#skills"><i class="fas fa-chevron-circle-right"></i> skills</a>
          <a href="${basePath === '.' ? '' : basePath + '/'}#education"><i class="fas fa-chevron-circle-right"></i> education</a>
          <a href="${basePath === '.' ? '' : basePath + '/'}#work"><i class="fas fa-chevron-circle-right"></i> work</a>
          <a href="${basePath === '.' ? '' : basePath + '/'}#experience"><i class="fas fa-chevron-circle-right"></i> experience</a>
      </div>

      <div class="box">
          <h3>contact info</h3>
          <p> <i class="fas fa-envelope"></i><a href="mailto:caturwardana2@gmail.com" style="color: inherit;">caturwardana2@gmail.com</a></p>
          <p> <i class="fas fa-map-marked-alt"></i>Jogja, Indonesia-44751</p>
          <div class="share">
              <a href="https://www.linkedin.com/in/caturwardana" class="fab fa-linkedin" aria-label="LinkedIn" target="_blank"></a>
              <a href="https://github.com/caturwardana" class="fab fa-github" aria-label="GitHub" target="_blank"></a>
              <a href="mailto:caturwardana2@gmail.com" class="fas fa-envelope" aria-label="Mail" target="_blank"></a>
          </div>
      </div>
  </div>

  <h1 class="credit"><a href="https://www.linkedin.com/in/caturwardana"> catur wardana</a></h1>
</section>
`;
});
