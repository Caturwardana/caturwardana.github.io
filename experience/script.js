$(document).ready(function(){

    $(document).on('click', '#menu', function(){
        $(this).toggleClass('fa-times');
        $('.navbar').toggleClass('nav-toggle');
    });

    $(window).on('scroll load',function(){
        $('#menu').removeClass('fa-times');
        $('.navbar').removeClass('nav-toggle');

        if(window.scrollY>60){
            document.querySelector('#scroll-top').classList.add('active');
        }else{
            document.querySelector('#scroll-top').classList.remove('active');
        }
    });

    loadExperiences();
});

async function loadExperiences() {
    try {
        const response = await fetch('../experience.json');
        const experiences = await response.json();
        renderExperiences(experiences);
    } catch (error) {
        console.error('Error loading experiences:', error);
    }
}

function renderExperiences(experiences) {
    const timeline = document.querySelector('.timeline');
    if (!timeline) return;

    timeline.innerHTML = experiences.map(exp => `
        <div class="container ${exp.side || 'right'}">
            <div class="content">
                <div class="tag">
                    <h2>${escapeHtml(exp.company)}</h2>
                </div>
                <div class="desc">
                    <h3>${escapeHtml(exp.position)}</h3>
                    <p>${escapeHtml(exp.date)}</p>
                    ${exp.details && exp.details.length > 0 ? `
                    <ul class="experience-list">
                        ${exp.details.map(d => `<li>${escapeHtml(d)}</li>`).join('')}
                    </ul>` : ''}
                </div>
            </div>
        </div>
    `).join('');
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/* ===== SCROLL REVEAL ANIMATION ===== */
const srtop = ScrollReveal({
    origin: 'top',
    distance: '80px',
    duration: 1000,
    reset: true
});

/* SCROLL EXPERIENCE */
srtop.reveal('.experience .timeline',{delay: 400});
srtop.reveal('.experience .timeline .container',{interval: 400}); 



// disable developer mode
document.onkeydown = function(e) {
  if(e.keyCode == 123) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
     return false;
  }
}

document.addEventListener('visibilitychange',
function(){
    if(document.visibilityState === "visible"){
        document.title = "Experience | Portfolio Jigar Sable";
        $("#favicon").attr("href","/assets/images/favicon.png");
    }
    else {
        document.title = "Come Back To Portfolio";
        $("#favicon").attr("href","/assets/images/favhand.png");
    }
});