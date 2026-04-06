# Full-Stack Car Marketplace Application

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![Pest](https://img.shields.io/badge/Pest-v4.x-02D497?style=flat-square&logo=pest)](https://pestphp.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat-square)](https://opensource.org/licenses/MIT)

A high-performance, feature-rich car marketplace platform built with **Laravel 12** and **Blade**. This application facilitates seamless buyer-seller interactions, advanced search capabilities, and integrates modern AI for an enhanced user experience.

🔗 **Live Demo:** [https://cars.muad.pro](https://cars.muad.pro)

---

## ✨ Key Features

- ** Secure Authorization:** Robust access control using Laravel **Gates & Policies** to manage seller and buyer workflows.
- ** Advanced Search & Filtering:** Highly optimized car search with dynamic filters for price, model, mileage, and more.
- ** AI Automotive Concierge:** Integrated chatbot powered by **Google Gemini 2.5 Flash** to assist users with site navigation and inquiries.
- ** Multi-Image Optimization:** Seamless multi-image uploads with background processing and storage optimization.
- ** Personalized Dashboards:** Dedicated dashboards for Sellers (to manage listings) and Users (to track activity).
- ** Watchlist System:** Users can save their favorite vehicles to a personalized watchlist.
- ** Social Authentication:** Quick login via **Google & Facebook** using Laravel Socialite.
- ** CI/CD Ready:** Configured for automated deployment to **VPS** with continuous integration.

---

## 🛠️ Tech Stack

- **Backend:** PHP 8.2+ | Laravel 12
- **Frontend:** Blade Templating | Tailwind CSS 4.0 | Vite
- **AI Integration:** Google Gemini API (2.5 Flash)
- **Testing:** Pest PHP (Feature & E2E Testing)
- **Auth:** Laravel Socialite (OAuth)
- **Deployment:** VPS | GitHub Actions CI/CD

---

## 🚀 Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Muad-Ahmed/full-stack-car-selling-project.git
   cd full-stack-car-selling-project
   ```

2. **Run the setup script:** (Automated installation)
   ```bash
   composer run setup
   ```
   *This command handles composer/npm installs, `.env` creation, key generation, and migrations.*

3. **Configure Environment:**
   Update your `.env` file with these essential keys:
   ```env
   GOOGLE_CLIENT_ID=your_id
   GOOGLE_CLIENT_SECRET=your_secret
   FACEBOOK_CLIENT_ID=your_id
   FACEBOOK_CLIENT_SECRET=your_secret
   GEMINI_API_KEY=your_key
   ```

4. **Start Development Server:**
   ```bash
   composer run dev
   ```

---

## 🧪 Testing

We prioritize reliability using **Pest PHP** for both Feature and End-to-End testing.

```bash
# Run all tests
composer run test
```

---

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---

<p align="center">
    Made by <a href="https://github.com/Muad-Ahmed">Muad Ahmed</a>
</p>
