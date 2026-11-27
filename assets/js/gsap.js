// Registrar ScrollTrigger antes de crear animaciones que lo utilizan.
gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', function () {

    // Animar elementos con la clase .animate al entrar en el viewport
    gsap.utils.toArray('.wp-block-cover__inner-container > * > *, main .is-layout-flow > * > *, .wp-block-heading, #colophon, .is-style-timeline > *').forEach(function (element) {
        gsap.from(element, {
            scrollTrigger: {
                trigger: element, // Elemento que activa la animación
                start: 'top 80%', // Inicia cuando el top del elemento está al 80% del viewport
                end: 'bottom 20%', // Termina cuando el bottom del elemento está al 20% del viewport
                toggleActions: 'play none none none', // Reproducir solo una vez
            },
            opacity: 0,
            y: 50,
            duration: 0.3,
        });
    });
});


const triggerSection = document.querySelector('#kpis-section');
const elements = document.querySelectorAll('.animated-number');

    if (triggerSection && elements.length > 0) {
        gsap.from(elements, {
        textContent: 0,
        duration: 2,
        snap: { textContent: 1 },
        scrollTrigger: {
            trigger: triggerSection,
            start: 'top center',
        },
        });
    }


  // Efecto parallax + scale suave para fondo de covers.
  gsap.utils.toArray('.bg-scroll-animated .wp-block-cover').forEach(function (cover) {
    const bgImage = cover.querySelector('.wp-block-cover__image-background');

    if (!bgImage) {
      return;
    }

    gsap.set(bgImage, {
      scale: 1,
      yPercent: -4,
      transformOrigin: '50% 50%',
      willChange: 'transform',
    });

    gsap.to(bgImage, {
      scale: 1.20,
      yPercent: 7,
      ease: 'none',
      scrollTrigger: {
        trigger: cover,
        start: 'top bottom',
        end: 'bottom top',
        scrub: 1.2,
        invalidateOnRefresh: true,
      },
    });
  });

