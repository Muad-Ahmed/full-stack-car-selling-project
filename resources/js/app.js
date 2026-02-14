import axios from "axios";
import "./bootstrap";

/* ==========================
   Toast Helper (GLOBAL)
========================== */
function showToast(type, message) {
    const wrapper = document.createElement("div");
    wrapper.className = "toast-wrapper";

    const toast = document.createElement("div");
    toast.className = `toast ${type}-message`;

    toast.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            ${
                type === "success"
                    ? `<path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12
                        a9 9 0 1 1-18 0
                        9 9 0 0 1 18 0Z" />`
                    : `<path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m0 4.125h.008v.008H12v-.008Z
                        m9-3.375
                        a9 9 0 1 1-18 0
                        9 9 0 0 1 18 0Z" />`
            }
        </svg>
        <span>${message}</span>
    `;

    wrapper.appendChild(toast);
    document.body.appendChild(wrapper);

    setTimeout(() => {
        toast.style.opacity = "0";
        toast.style.transform = "translateY(-10px)";
        setTimeout(() => wrapper.remove(), 400);
    }, 4000);
}

document.addEventListener("DOMContentLoaded", function () {
    /* ==========================
       Floating Search Button
    ========================== */
    const btn = document.getElementById("floatingSearchBtn");
    const SHOW_AFTER = 1180;
    const HIDE_BEFORE_BOTTOM = 350;

    if (btn) {
        window.addEventListener("scroll", () => {
            if (window.innerWidth > 768) {
                btn.style.opacity = "0";
                btn.style.pointerEvents = "none";
                return;
            }

            const scrollTop = window.scrollY;
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;

            const reachedShowPoint = scrollTop >= SHOW_AFTER;
            const nearBottom =
                scrollTop + windowHeight >= documentHeight - HIDE_BEFORE_BOTTOM;

            if (reachedShowPoint && !nearBottom) {
                btn.style.opacity = "0.8";
                btn.style.pointerEvents = "auto";
            } else {
                btn.style.opacity = "0";
                btn.style.pointerEvents = "none";
            }
        });
    }

    /* ==========================
       Hero Slider
    ========================== */
    const initSlider = () => {
        const slides = document.querySelectorAll(".hero-slide");
        if (!slides.length) return;

        let currentIndex = 0;
        const totalSlides = slides.length;

        const moveToSlide = (n) => {
            const normalized = ((n % totalSlides) + totalSlides) % totalSlides;
            slides.forEach((slide, index) => {
                slide.style.transform = `translateX(${-100 * normalized}%)`;
                slide.classList.toggle("active", normalized === index);
            });
            currentIndex = normalized;
        };

        const nextSlide = () =>
            moveToSlide(
                currentIndex === totalSlides - 1 ? 0 : currentIndex + 1,
            );
        const prevSlide = () =>
            moveToSlide(
                currentIndex === 0 ? totalSlides - 1 : currentIndex - 1,
            );

        // --- Auto-play setup ---
        const SLIDE_INTERVAL = 5000; // 5 seconds
        let autoplayTimer = null;
        let interactionPaused = false; // true while user is hovering or interacting

        const startAutoplay = (immediate = false) => {
            if (autoplayTimer || totalSlides <= 1 || interactionPaused) return;
            // If immediate is true, advance first then schedule next moves
            if (immediate) nextSlide();
            autoplayTimer = setInterval(() => nextSlide(), SLIDE_INTERVAL);
        };

        const stopAutoplay = () => {
            if (!autoplayTimer) return;
            clearInterval(autoplayTimer);
            autoplayTimer = null;
        };

        const nextBtn = document.querySelector(".hero-slide-next");
        const prevBtn = document.querySelector(".hero-slide-prev");

        nextBtn?.addEventListener("click", (e) => {
            e.preventDefault();
            nextSlide();
        });
        prevBtn?.addEventListener("click", (e) => {
            e.preventDefault();
            prevSlide();
        });

        // Pause while pointer/keyboard/focus interaction is active on the slider
        const sliderWrapper = document.querySelector(".hero-slides");
        if (sliderWrapper) {
            sliderWrapper.addEventListener("mouseenter", () => {
                interactionPaused = true;
                stopAutoplay();
            });
            sliderWrapper.addEventListener("mouseleave", () => {
                interactionPaused = false;
                startAutoplay();
            });
            sliderWrapper.addEventListener("focusin", () => {
                interactionPaused = true;
                stopAutoplay();
            });
            sliderWrapper.addEventListener("focusout", () => {
                interactionPaused = false;
                startAutoplay();
            });
        }

        // Pause while user is actively using nav buttons (pointer/touch); resume shortly afterwards
        const resumeAfterInteraction = () =>
            setTimeout(() => {
                if (!interactionPaused) startAutoplay();
            }, 800);

        [nextBtn, prevBtn].forEach((btn) => {
            if (!btn) return;
            btn.addEventListener("pointerdown", () => {
                interactionPaused = true;
                stopAutoplay();
            });
            btn.addEventListener("pointerup", () => {
                interactionPaused = false;
                resumeAfterInteraction();
            });
            // For keyboard users
            btn.addEventListener("focus", () => {
                interactionPaused = true;
                stopAutoplay();
            });
            btn.addEventListener("blur", () => {
                interactionPaused = false;
                resumeAfterInteraction();
            });
        });

        // Pause when page not visible to conserve resources
        document.addEventListener("visibilitychange", () => {
            if (document.hidden) stopAutoplay();
            else if (!interactionPaused) startAutoplay();
        });

        // Initialize and start autoplay
        moveToSlide(0);
        startAutoplay();
    };

    /* ==========================
       Image Picker
    ========================== */
    /* ==========================
       Car Images Carousel
    ========================== */
    const initCarCarousel = () => {
        const carousel = document.querySelector(".car-images-carousel");
        if (!carousel) return;

        const activeImage =
            carousel.querySelector("#activeImage") ||
            carousel.querySelector(".car-active-image");
        const thumbnails = carousel.querySelectorAll(
            ".car-image-thumbnails img",
        );
        if (!activeImage || !thumbnails.length) return;

        const normalize = (url) => {
            try {
                return new URL(url, location.origin).href;
            } catch (e) {
                return url;
            }
        };

        const thumbList = Array.from(thumbnails);
        const thumbSrcs = thumbList.map((img) => normalize(img.src));

        // set current index based on activeImage src if possible
        const activeSrc = normalize(activeImage.src || "");
        let currentIndex = thumbSrcs.indexOf(activeSrc);
        if (currentIndex === -1) currentIndex = 0;

        const updateActive = (index) => {
            const len = thumbList.length;
            currentIndex = ((index % len) + len) % len;
            const src = thumbList[currentIndex].src;
            if (src) activeImage.src = src;
            thumbList.forEach((img, i) =>
                img.classList.toggle("active-thumb", i === currentIndex),
            );
        };

        thumbList.forEach((img, i) =>
            img.addEventListener("click", () => updateActive(i)),
        );

        const prevBtn = carousel.querySelector("#prevButton");
        const nextBtn = carousel.querySelector("#nextButton");

        if (prevBtn)
            prevBtn.addEventListener("click", (ev) => {
                ev.preventDefault();
                updateActive(currentIndex - 1);
            });
        if (nextBtn)
            nextBtn.addEventListener("click", (ev) => {
                ev.preventDefault();
                updateActive(currentIndex + 1);
            });

        // initialize active state
        updateActive(currentIndex);
    };

    const initImagePicker = () => {
        const fileInput = document.querySelector("#carFormImageUpload");
        const imagePreview = document.querySelector("#imagePreviews");
        if (!fileInput || !imagePreview) return;

        fileInput.onchange = (ev) => {
            imagePreview.innerHTML = "";
            [...ev.target.files].forEach((file) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const a = document.createElement("a");
                    a.classList.add("car-form-image-preview");
                    a.innerHTML = `<img src="${e.target.result}" />`;
                    imagePreview.append(a);
                };
                reader.readAsDataURL(file);
            });
        };
    };

    /* ==========================
       Mobile Navbar
    ========================== */
    const initMobileNavbar = () => {
        const btnToggle = document.querySelector(".btn-navbar-toggle");
        const navbarMenu = document.querySelector(".navbar-menu");
        if (!btnToggle) return;

        btnToggle.onclick = () =>
            document.body.classList.toggle("navbar-opened");

        document.addEventListener("click", (event) => {
            const isInside =
                btnToggle.contains(event.target) ||
                navbarMenu?.contains(event.target);

            if (
                !isInside &&
                document.body.classList.contains("navbar-opened")
            ) {
                document.body.classList.remove("navbar-opened");
            }
        });
    };

    /* ==========================
       Add to Watchlist (NO alert)
    ========================== */
    const initAddToWatchlist = () => {
        // helper: try to extract numeric car id from URL (last number), otherwise return the full url
        const extractCarKey = (url) => {
            if (!url) return null;
            const m = String(url).match(/(\d+)(?=[^\/]*$)/); // last numeric segment
            return m ? m[1] : url;
        };

        document.addEventListener("click", (ev) => {
            const btn = ev.target?.closest?.(".btn-heart");
            if (!btn) return;
            ev.preventDefault();

            const url = btn.dataset.url;
            if (!url) return;
            if (btn.dataset.loading === "1") return; // prevent double

            // derive stable key: prefer explicit data-car-id if present, otherwise try URL extraction, otherwise fallback to url string
            const clickedCarKey =
                btn.dataset.carId ?? extractCarKey(url) ?? url;

            // find all buttons that represent the same car (use their data-car-id if present, else try to extract from their data-url)
            const allButtons = Array.from(
                document.querySelectorAll(".btn-heart"),
            ).filter((b) => {
                const bUrl = b.dataset.url || "";
                const bKey = b.dataset.carId ?? extractCarKey(bUrl) ?? bUrl;
                return String(bKey) === String(clickedCarKey);
            });

            // determine current state by inspecting the clicked button's SVGs
            const svgs = btn.querySelectorAll("svg");
            const hasFilled =
                svgs.length >= 2
                    ? !svgs[1].classList.contains("hidden")
                    : !svgs[0].classList.contains("hidden");
            const currentlyAdded = Boolean(hasFilled);

            // optimistic new state
            const optimisticAdded = !currentlyAdded;

            // apply state helper
            const applyStateTo = (buttons, added) => {
                buttons.forEach((b) => {
                    const s = Array.from(b.querySelectorAll("svg"));
                    if (s.length >= 2) {
                        // s[0] outline, s[1] filled
                        s[0].classList.toggle("hidden", added);
                        s[1].classList.toggle("hidden", !added);
                    } else if (s.length === 1) {
                        s[0].classList.toggle("hidden");
                    }
                });
            };

            // optimistic update
            applyStateTo(allButtons, optimisticAdded);

            // if removing and on /watchlist, remove element immediately but keep a clone to restore on failure
            let removedClone = null;
            let removedParent = null;
            let removedNext = null;
            if (
                !optimisticAdded &&
                window.location.pathname.includes("/watchlist")
            ) {
                const carItem =
                    btn.closest(".car-item") ||
                    btn.closest(".card") ||
                    btn.closest(".car-list-item");
                if (carItem) {
                    removedParent = carItem.parentNode;
                    removedNext = carItem.nextSibling;
                    removedClone = carItem.cloneNode(true);
                    carItem.remove();
                }
            }

            // mark loading
            allButtons.forEach((b) => (b.dataset.loading = "1"));

            axios
                .post(url)
                .then((response) => {
                    // If backend returns explicit added flag, prefer it. Otherwise trust optimistic.
                    const serverAdded =
                        response?.data &&
                        typeof response.data.added !== "undefined"
                            ? response.data.added
                            : optimisticAdded;

                    // apply authoritative state to the same group
                    applyStateTo(allButtons, Boolean(serverAdded));

                    // if server says removed and we're on watchlist ensure item removed (already removed optimistically)
                    if (
                        serverAdded === false &&
                        window.location.pathname.includes("/watchlist")
                    ) {
                        // already removed optimistically; nothing else needed
                    }

                    showToast(
                        "success",
                        (response && response.data && response.data.message) ||
                            "Updated",
                    );
                })
                .catch((error) => {
                    // revert UI
                    applyStateTo(allButtons, currentlyAdded);

                    // restore removed element if we removed it optimistically
                    if (removedClone && removedParent) {
                        // insert before saved next sibling (or append)
                        removedParent.insertBefore(
                            removedClone,
                            removedNext || null,
                        );
                    }

                    if (error?.response?.status === 401) {
                        showToast(
                            "warning",
                            "Please authenticate first to add cars into watchlist.",
                        );
                    } else {
                        showToast(
                            "warning",
                            "Internal Server Error. Please try again later.",
                        );
                    }
                })
                .finally(() => {
                    allButtons.forEach((b) => delete b.dataset.loading);
                });
        });
    };

    /* ==========================
       Show Phone Number
    ========================== */
    const initShowPhoneNumber = () => {
        const span = document.querySelector(".car-details-phone-view");
        if (!span) return;

        span.addEventListener("click", (ev) => {
            ev.preventDefault();
            axios.post(span.dataset.url).then((response) => {
                const phone = response.data.phone;
                const a = span.parentElement;
                if (a) a.href = "tel:" + phone;
                a?.querySelector(".text-phone")?.replaceWith(phone);
            });
        });
    };

    /* ==========================
       Delete Modal (custom)
    ========================== */
    const deleteModal = document.getElementById("deleteModal");
    const deleteForm = document.getElementById("deleteForm");

    window.openDeleteModal = (action) => {
        if (!deleteModal || !deleteForm) return;
        deleteForm.action = action;
        deleteModal.classList.remove("hidden");
    };

    window.closeDeleteModal = () => {
        if (!deleteModal) return;
        deleteModal.classList.add("hidden");
    };

    // close when clicking outside box
    deleteModal?.addEventListener("click", (e) => {
        if (e.target === deleteModal) closeDeleteModal();
    });

    // close on Escape
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeDeleteModal();
    });

    /* ==========================
       Init Calls
    ========================== */
    initSlider();
    initCarCarousel();
    initImagePicker();
    initMobileNavbar();
    initAddToWatchlist();
    initShowPhoneNumber();
    const initSortDropdown = () => {
        const select = document.querySelector(".sort-dropdown");
        if (!select) return;

        // Initialize select from current URL
        const params = new URLSearchParams(window.location.search);
        const current = params.get("sort") || "";
        if (current) select.value = current;

        select.addEventListener("change", () => {
            const params = new URLSearchParams(window.location.search);
            const val = select.value;
            if (val) params.set("sort", val);
            else params.delete("sort");
            // Reset pagination when sorting changes
            params.delete("page");

            const newUrl =
                window.location.pathname +
                (params.toString() ? "?" + params.toString() : "");
            window.location.href = newUrl;
        });
    };

    initSortDropdown();
});
