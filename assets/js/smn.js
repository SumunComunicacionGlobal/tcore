// Añade clase a body cuando se hace scroll
window.addEventListener("scroll", function() {
    if (window.scrollY > 180) {
        document.body.classList.add("scrolled");
    } else {
        document.body.classList.remove("scrolled");
    }
});
// Añade botones de scroll a la izquierda y derecha
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".is-style-group-horizontal-scroll-btns").forEach((content) => {
        if (content.children.length > 1) {
            const rightBtn = document.createElement("button");
            rightBtn.classList.add("scrolling-button", "scrolling-button--right");
            rightBtn.innerHTML = "→";
            rightBtn.disabled = false;

            const leftBtn = document.createElement("button");
            leftBtn.classList.add("scrolling-button", "scrolling-button--left");
            leftBtn.innerHTML = "←";
            leftBtn.disabled = true;

            const buttonContainer = document.createElement("div");
            buttonContainer.classList.add("scrolling-button-container");
            buttonContainer.appendChild(leftBtn);
            buttonContainer.appendChild(rightBtn);
            //content.parentNode.insertBefore(buttonContainer, content.nextSibling);
            // Agregar el contenedor de botones antes del contenido
            content.parentNode.insertBefore(buttonContainer, content);

            // Desplazamiento fijo para móvil y desktop
            function getScrollStep() {
                return window.innerWidth < 768 ? 400 : 288;
            }

            rightBtn.addEventListener("click", () => {
                const scrollContent = content;
                const scrollStep = getScrollStep();
                scrollContent.scrollLeft += scrollStep;
                leftBtn.disabled = false;

                if (scrollContent.scrollWidth - scrollContent.scrollLeft - scrollContent.clientWidth <= 0) {
                    rightBtn.disabled = true;
                }
            });

            leftBtn.addEventListener("click", () => {
                const scrollContent = content;
                const scrollStep = getScrollStep();
                scrollContent.scrollLeft -= scrollStep;
                rightBtn.disabled = false;

                if (scrollContent.scrollLeft <= 0) {
                    leftBtn.disabled = true;
                }
            });
        }
    });
});

// Añade drag para los elementos con scroll horizontal
document.addEventListener('DOMContentLoaded', (event) => {
    const sliders = document.querySelectorAll('.is-style-group-horizontal-scroll');
    let isDown = false;
    let startX;
    let scrollLeft;
  
    // Añade el evento a cada slider
    sliders.forEach(slider => {
        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mousemove', (e) => {
            if(!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 3; //scroll-fast
            slider.scrollLeft = scrollLeft - walk;
            console.log(walk);
        });
    });
  
  });

//Rank Math FAQ Dropdown
document.addEventListener('DOMContentLoaded', (event) => {
    const faqs = document.querySelectorAll('.rank-math-list-item');
    faqs.forEach(faq => {
        const question = faq.querySelector('.rank-math-question');
        question.addEventListener('click', () => {
            faq.classList.toggle('active');
        });
    });
});

// Navegación suave para enlaces a anclas
// Navegación suave para enlaces a anclas con offset para barra fija
document.addEventListener('DOMContentLoaded', (event) => {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    const offset = 120; // px
    anchorLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            // Ignora enlaces vacíos o solo "#"
            if (!href || href === '#' || href === '#demo') return;
            e.preventDefault();
            const targetId = href.substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = elementPosition - offset;
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('smn-demo-modal');
    if (!modal) return;

    let opener;

    document.addEventListener('click', function(event) {
        const link = event.target.closest('a[href]');
        if (!link || link.hash !== '#demo' || link.host !== window.location.host) return;

        event.preventDefault();
        if (modal.open) return;

        opener = link;
        modal.showModal();
        document.body.classList.add('demo-modal-open');
    });

    modal.querySelector('.smn-demo-modal__close').addEventListener('click', function() {
        modal.close();
    });

    modal.addEventListener('keydown', function(event) {
        if (event.key !== 'Tab') return;

        const controls = Array.from(modal.querySelectorAll('a[href], button, input, select, textarea, [tabindex]')).filter(function(control) {
            return !control.matches(':disabled') && control.tabIndex >= 0 && control.getClientRects().length > 0;
        });
        const firstControl = controls[0];
        const lastControl = controls[controls.length - 1];

        if (event.shiftKey && document.activeElement === firstControl) {
            event.preventDefault();
            lastControl.focus();
        } else if (!event.shiftKey && document.activeElement === lastControl) {
            event.preventDefault();
            firstControl.focus();
        }
    });

    modal.addEventListener('click', function(event) {
        if (event.target !== modal) return;

        const bounds = modal.getBoundingClientRect();
        if (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom) {
            modal.close();
        }
    });

    modal.addEventListener('close', function() {
        document.body.classList.remove('demo-modal-open');
        if (opener && opener.isConnected) {
            opener.focus({ preventScroll: true });
        }
    });
});

// Reproducir automáticamente los vídeos con etiqueta <video> al hacer scroll
document.addEventListener('DOMContentLoaded', (event) => {
    const videos = document.querySelectorAll('video');
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.play();
            } else {
                entry.target.pause();
            }
        });
    }, observerOptions);

    videos.forEach(video => {
        observer.observe(video);
    });
});

// Abre todos los links externos en pestaña nueva
document.addEventListener('DOMContentLoaded', (event) => {
    const links = document.querySelectorAll('a[href^="http"]');
    links.forEach(link => {
        if (link.hostname !== window.location.hostname) {
            link.setAttribute('target', '_blank');
            link.setAttribute('rel', 'noopener noreferrer');
        }
    });
});
// Mostrar .contenido-pagina-wrapper al marcar el checkbox de aceptación de Contact Form 7
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.wpcf7-acceptance input').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                const wpcf7Parent = checkbox.closest('.wpcf7');
                if (wpcf7Parent) {
                    const contenidoWrapper = wpcf7Parent.querySelector('.contenido-pagina-wrapper');
                    if (contenidoWrapper) {
                        contenidoWrapper.style.display = 'block';
                    }
                }
            }
            // No hacer nada al desactivar el checkbox
        });
    });
});

// Cada enlace de #slider-oee-conectado-control lleva a la slide con el mismo índice que su li
document.addEventListener('click', function(event) {
    const link = event.target.closest('#slider-oee-conectado-control > li a');
    if (!link || !window.jQuery) return;

    const slider = document.getElementById('slider-oee-conectado');
    const carousel = slider && (slider.classList.contains('slick-initialized') ? slider : slider.querySelector('.slick-initialized'));
    if (!carousel) return;

    event.preventDefault();
    const item = link.closest('#slider-oee-conectado-control > li');
    const index = Array.prototype.indexOf.call(item.parentElement.children, item);
    jQuery(carousel).slick('slickGoTo', index);
});

// jQuery(document).ready(function($) {
//     $('.wp-block-group.is-style-carousel').addClass('wp-block-cb-carousel').removeClass('is-layout-grid').slick({
//         dots: true,
//         arrows: false,
//         infinite: false,
//         slidesToShow: 4,
//         slidesToScroll: 1,
//         adaptiveHeight: true,
//         responsive: [
//             {
//                 breakpoint: 1240,
//                 settings: {
//                     slidesToShow: 3,
//                 }
//             },
//             {
//                 breakpoint: 768,
//                 settings: {
//                     slidesToShow: 2,
//                 }
//             },
//             {
//                 breakpoint: 480,
//                 settings: {
//                     slidesToShow: 1,
//                 }
//             }
//         ]
//     });
// });

// Filtra Query Loops por el término elegido en una lista marcada como terms-filter
document.addEventListener('click', function(event) {

    const link = event.target.closest('.wp-block-categories-list.terms-filter a');
    if (!link) return;


    const termUrl = new URL(link.href, window.location.href);
    if (termUrl.origin !== window.location.origin) return;

    const pathParts = termUrl.pathname.split('/').filter(Boolean);
    const termSlug = pathParts[pathParts.length - 1];
    if (!termSlug) return;

    const queries = document.querySelectorAll('.wp-block-query.terms-fitler-posts, .wp-block-query.terms-filter-posts');
    if (!queries.length) return;

    event.preventDefault();
    const termClassSuffix = `-${termSlug}`;
    const selectedItem = link.closest('li');
    const isActive = selectedItem?.classList.contains('is-term-filter-active');

    queries.forEach((query) => {
        const posts = query.querySelectorAll('.wp-block-post');

        posts.forEach((post) => {
            const matchesTerm = Array.from(post.classList).some((className) => className.endsWith(termClassSuffix));
            post.hidden = !isActive && !matchesTerm;
        });

        query.querySelectorAll('.wp-block-query-pagination').forEach((pagination) => {
            pagination.hidden = !isActive;
        });

    });

    document.querySelectorAll('.wp-block-categories-list.terms-filter li').forEach((item) => {
        item.classList.remove('is-term-filter-active');
        item.querySelector('a')?.removeAttribute('aria-current');
    });

    if (!isActive && selectedItem) {
        selectedItem.classList.add('is-term-filter-active');
        link.setAttribute('aria-current', 'true');
    }
});

