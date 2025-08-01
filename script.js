// Variable global para el reproductor de YouTube
let player;


// LÓGICA PARA OCULTAR/MOSTRAR BARRA DE NAVEGACIÓN
let lastScrollTop = 0;
let scrollTimeout;
const navbar = document.querySelector('.navbar');

window.addEventListener('scroll', function() {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    // Oculta la barra al bajar, pero solo después de pasar un poco del inicio
    if (scrollTop > lastScrollTop && scrollTop > 150){
        navbar.classList.add('navbar-hidden');
    } else {
        // Muestra la barra al subir
        navbar.classList.remove('navbar-hidden');
    }

    // Limpia el temporizador cada vez que se mueve el scroll
    clearTimeout(scrollTimeout);

    // Inicia un temporizador: si no hay más scroll en 500ms, se considera "detenido"
    scrollTimeout = setTimeout(() => {
        // Muestra la barra cuando el scroll se detiene
        if (scrollTop > 150) { // No la muestres si estamos casi al tope de la página
             navbar.classList.remove('navbar-hidden');
        }
    }, 12500); // 500 milisegundos = medio segundo

    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
});

// Esta función es llamada automáticamente por la API de YouTube cuando está lista

function onYouTubeIframeAPIReady() {
    // Reproductor para la sección "Planeación Estratégica"
    player = new YT.Player('youtube-player', {
      height: '100%',
      width: '100%',
      videoId: 'dE3-cK-HYyY',
      playerVars: {
        'playsinline': 1, 'autoplay': 0, 'controls': 1,
        'rel': 0, 'modestbranding': 1, 'loop': 1,
        'playlist': 'dE3-cK-HYyY'
      },
      events: { 'onReady': onPlayerReady }
    });
  
    // Reproductor para el video del Popup
    popupPlayer = new YT.Player('youtube-popup-player', {
      height: '100%',
      width: '100%',
      videoId: 'dE3-cK-HYyY', // Puedes usar el mismo video u otro
      playerVars: {
        'playsinline': 1, 'autoplay': 1, 'controls': 1,
        'rel': 0
      }
    });
  }


document.addEventListener('DOMContentLoaded', function() {

    // LÓGICA PARA CONTROLAR EL VIDEO DE YOUTUBE AL HACER SCROLL
    const videoContainer = document.querySelector('.video-container');
    if (videoContainer) {
        const videoObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                // Asegurarnos que el 'player' de YouTube ya se haya cargado
                if (typeof player !== 'undefined' && player.playVideo) {
                    if (entry.isIntersecting) {
                        player.playVideo();
                    } else {
                        player.pauseVideo();
                    }
                }
            });
        }, { threshold: 0.5 }); // Se activa cuando el 50% del video es visible
        videoObserver.observe(videoContainer);
    }

    // LÓGICA PARA EL MODAL DE VIDEO LOCAL
    const videoModalEl = document.getElementById('videoModal');
    if (videoModalEl) {
        const myModal = new bootstrap.Modal(videoModalEl);
        const video = document.getElementById('popup-video');

        // Muestra el modal 2 segundos después de que la página cargue
        setTimeout(() => {
            myModal.show();
        }, 2000);

        // Cuando el modal se HAYA MOSTRADO, reproduce el video
        videoModalEl.addEventListener('shown.bs.modal', function () {
            video.play();
        });

        // Cuando el modal se CIERRA, pausa y reinicia el video
        videoModalEl.addEventListener('hide.bs.modal', function () {
            video.pause();
            video.currentTime = 0; // Vuelve al inicio
        });
    }
    // ANIMACIÓN DE ÓRBITA CON TEXTO ESTÁTICO
    const orbitContainer = document.querySelector('.orbit-container');
    const factors = document.querySelectorAll('.factor');
    let orbitAngle = 0;
    let orbitActive = false;
    let lastTimestamp = null;

    function animateOrbit(timestamp) {
    if (!orbitActive) return;
    if (!lastTimestamp) lastTimestamp = timestamp;
    const delta = timestamp - lastTimestamp;
    lastTimestamp = timestamp;

    orbitAngle += (360 / 30000) * delta;
    if (orbitAngle >= 360) orbitAngle -= 360;

    factors.forEach((factor, i) => {
        // Ajuste: -90 para que el primer factor esté arriba
        const angle = i * 45 + orbitAngle - 90;
        const rad = angle * Math.PI / 180;
        const radius = window.innerWidth <= 768 ? 160 : 190;
        const x = Math.cos(rad) * radius;
        const y = Math.sin(rad) * radius;
        factor.style.transform = `translate(${x}px, ${y}px)`;

        // Mantener el texto derecho
        factor.style.transform = `translate(-50%, -50%) translate(${x}px, ${y}px)`;
        const inner = factor.querySelector('.factor-inner');
        if (inner) inner.style.transform = `rotate(0deg)`;
    });

    requestAnimationFrame(animateOrbit);
}

    // Activar/desactivar animación según scroll
    if (orbitContainer) {
        const orbitObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    orbitActive = true;
                    lastTimestamp = null;
                    requestAnimationFrame(animateOrbit);
                } else {
                    orbitActive = false;
                }
            });
        }, { threshold: 0.2 });
        orbitObserver.observe(orbitContainer);
    }

    // LÓGICA PARA ANIMACIONES DE APARICIÓN AL HACER SCROLL
    const revealElements = document.querySelectorAll('.anim-reveal');
    if(revealElements.length > 0) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        revealElements.forEach(element => {
            revealObserver.observe(element);
        });
    }

});