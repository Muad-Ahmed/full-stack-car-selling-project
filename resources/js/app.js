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
            slides.forEach((slide, index) => {
                slide.style.transform = `translateX(${-100 * n}%)`;
                slide.classList.toggle("active", n === index);
            });
            currentIndex = n;
        };

        const nextSlide = () =>
            moveToSlide(
                currentIndex === totalSlides - 1 ? 0 : currentIndex + 1,
            );
        const prevSlide = () =>
            moveToSlide(
                currentIndex === 0 ? totalSlides - 1 : currentIndex - 1,
            );

        document
            .querySelector(".hero-slide-next")
            ?.addEventListener("click", nextSlide);
        document
            .querySelector(".hero-slide-prev")
            ?.addEventListener("click", prevSlide);

        moveToSlide(0);
    };

    /* ==========================
       Image Picker
    ========================== */
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
        document.querySelectorAll(".btn-heart").forEach((button) => {
            button.addEventListener("click", (ev) => {
                const btn = ev.currentTarget;
                const url = btn.dataset.url;

                axios
                    .post(url)
                    .then((response) => {
                        btn.querySelector("svg.hidden")?.classList.remove(
                            "hidden",
                        );
                        btn.querySelector("svg:not(.hidden)")?.classList.add(
                            "hidden",
                        );

                        showToast("success", response.data.message);
                    })
                    .catch((error) => {
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
                    });
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
    initImagePicker();
    initMobileNavbar();
    initAddToWatchlist();
    initShowPhoneNumber();
});
