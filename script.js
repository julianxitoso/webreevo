// Variable global para el reproductor de YouTube
let player;

// LÓGICA PARA OCULTAR/MOSTRAR BARRA DE NAVEGACIÓN
let lastScrollTop = 0;
let scrollTimeout;
const navbar = document.querySelector('.navbar');

window.addEventListener('scroll', function() {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop && scrollTop > 150){
        navbar.classList.add('navbar-hidden');
    } else {
        navbar.classList.remove('navbar-hidden');
    }

    clearTimeout(scrollTimeout);

    // CORREGIDO: El tiempo de espera es ahora de 400ms
    scrollTimeout = setTimeout(() => {
        if (scrollTop > 150) {
             navbar.classList.remove('navbar-hidden');
        }
    }, 500000); 

    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
});

// Esta función es llamada automáticamente por la API de YouTube cuando está lista
function onYouTubeIframeAPIReady() {
    player = new YT.Player('youtube-player', {
      height: '100%',
      width: '100%',
      videoId: 'dE3-cK-HYyY',
      playerVars: {
        'playsinline': 1, 'autoplay': 0, 'controls': 1,
        'rel': 0, 'modestbranding': 1, 'loop': 1,
        'playlist': 'dE3-cK-HYyY'
      }
    });
    // ELIMINADO: El popupPlayer no se usaba.
}

document.addEventListener('DOMContentLoaded', function() {

    // LÓGICA PARA CONTROLAR EL VIDEO DE YOUTUBE AL HACER SCROLL
    const videoContainer = document.querySelector('.video-container');
    if (videoContainer) {
        const videoObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (player && typeof player.playVideo === 'function') {
                    if (entry.isIntersecting) {
                        player.playVideo();
                    } else {
                        player.pauseVideo();
                    }
                }
            });
        }, { threshold: 0.5 });
        videoObserver.observe(videoContainer);
    }

    // LÓGICA PARA EL MODAL DE VIDEO LOCAL
    const videoModalEl = document.getElementById('videoModal');
    if (videoModalEl) {
        const myModal = new bootstrap.Modal(videoModalEl);
        const video = document.getElementById('popup-video');

        setTimeout(() => {
            myModal.show();
        }, 2000);

        videoModalEl.addEventListener('shown.bs.modal', function () {
            video.play();
        });

        videoModalEl.addEventListener('hide.bs.modal', function () {
            video.pause();
            video.currentTime = 0;
        });
    }

    // En script.js, reemplaza la lógica de GSAP de los objetivos con esto:

// LÓGICA PARA EL EFECTO DE CARRUSEL (VERSIÓN OPTIMIZADA)
gsap.registerPlugin(ScrollTrigger);

const objetivoCards = gsap.utils.toArray('.objetivos-sticky-container .objetivo-card');
const numCards = objetivoCards.length;

gsap.set(objetivoCards, {
    y: (i) => i * 80,
    scale: (i) => 1 - i * 0.05,
    opacity: (i) => 1 - i * 0.25,
    zIndex: (i) => numCards - i,
});
gsap.set(objetivoCards[0], { y: 0, scale: 1, opacity: 1 });

const masterTimeline = gsap.timeline({
    repeat: -1,
    scrollTrigger: {
        trigger: ".objetivos-sticky-container",
        start: "top top",
        end: "bottom bottom",
        toggleActions: "play none none none"
    }
});

objetivoCards.forEach((card, index) => {
    masterTimeline.to({}, { duration: 4 });
    
    const transitionTimeline = gsap.timeline();
    objetivoCards.forEach((c, i) => {
        const newPos = (i - (index + 1) + numCards) % numCards;

        // Animamos SOLO las propiedades visuales y rápidas
        transitionTimeline.to(c, {
            y: newPos * 80,
            scale: 1 - newPos * 0.05,
            opacity: newPos === 0 ? 1 : (1 - newPos * 0.25),
            duration: 1.2,
            ease: 'power2.inOut'
        }, 0);

        // CAMBIO CLAVE: Cambiamos el zIndex instantáneamente al INICIO de la transición
        transitionTimeline.set(c, {
            zIndex: numCards - newPos
        }, 0);
    });
    masterTimeline.add(transitionTimeline);
});

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

        // CORREGIDO: El radio ahora se calcula dinámicamente para ser responsivo.
        const radius = orbitContainer.clientWidth / 2.2; 

        factors.forEach((factor, i) => {
            const angle = i * 45 + orbitAngle - 90;
            const rad = angle * Math.PI / 180;
            const x = Math.cos(rad) * radius;
            const y = Math.sin(rad) * radius;

            // CORREGIDO: Se eliminó la línea de transform duplicada.
            factor.style.transform = `translate(-50%, -50%) translate(${x}px, ${y}px)`;
            
            const inner = factor.querySelector('.factor-inner');
            if (inner) inner.style.transform = `rotate(0deg)`;
        });

        requestAnimationFrame(animateOrbit);
    }

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
        revealElements.forEach(element => revealObserver.observe(element));
    }

        // --- SOLUCIÓN DEFINITIVA PARA EL SCROLL DEL MENÚ ---
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link[href^="#"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Previene el salto brusco del enlace

            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

});