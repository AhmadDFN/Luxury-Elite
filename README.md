<p align="center">
  <img src="https://lightgoldenrodyellow-spoonbill-684387.hostingersite.com/images/logo-lx.png" alt="Luxury Elite Logo" width="320">
</p>

<h1 align="center">Luxury Elite</h1>
<p align="center"><strong>Internal Esports Team Management Platform</strong></p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Inertia.js-955CB4?style=for-the-badge&logo=inertia&logoColor=white" alt="Inertia.js">
  <img src="https://img.shields.io/badge/Svelte-FF3E00?style=for-the-badge&logo=svelte&logoColor=white" alt="Svelte">
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white" alt="SQLite">
</p>

---

## 🎮 About The Project

An elegant, scalable, and modern internal management platform built specifically for the esports organization **Luxury Elite**. This platform bridges the gap between internal team operations (scrims, rosters, VODs) and public team presentation.

Currently optimized for **Delta Force**, but architected from the ground up to support future multi-game expansions.

---

## ✨ Key Features

### 👤 1. Advanced Player Management
* **Separated Auth & Profile:** Clean architectural separation between login credentials (`users`) and player statistics (`player_profiles`).
* **Role vs Status System:** * *Roles (Access Control):* Owner, Admin, Coach, Captain, Player.
  * *Membership Status:* Active, Trial, Inactive, Bench.
* **Delta Force Specialization:** Supports multiple game roles (Assault, Recon, Engineer, Vehicle) and specific vehicle specializations (Tank, APC, Helicopter, Jet).
* **History Tracking:** Log and track every time a player moves between divisions (*WF Competitive, OPS Competitive, Luxury Elite Ladies, Luxury Elite Casuals*).

### ⚔️ 2. Smart Scrim System
* **Public Scrim Request:** Outside teams can view available dates and submit a scrim request without seeing sensitive internal data.
* **Anti-Clash Rule:** System constraint ensures **only 1 approved scrim per day**.
* **Workflow Integration:** Once approved by an Admin/Manager, further coordination is seamlessly directed to WhatsApp.

### 📺 3. VOD & Strategy Hub
* **Secure Links:** Coaches and captains can link strategy videos via embed URLs (YouTube Unlisted / Google Drive).
* **Division Locked:** VODs are filtered by division to keep strategic assets confidential.

### 🌐 4. Public Website Ready
* Exposes public-facing data dynamically: Filtered roster (respects player privacy toggles), achievements, news, and real-time scrim availability.

---

## 🛠️ Installation & Setup

Ensure you have **PHP >= 8.2**, **Composer**, and **Node.js** installed on your local machine.

### 1. Clone the Repository
```bash
git clone [https://github.com/username/luxury-elite-platform.git](https://github.com/username/luxury-elite-platform.git)
cd luxury-elite-platform
2. Backend Setup
Bash
# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
Note on Database: If you are using SQLite, make sure extension=pdo_sqlite is enabled in your php.ini. Create an empty database file inside database/database.sqlite if needed, then update your .env configuration.

Bash
# Run migrations and seeders
php artisan migrate --seed
3. Frontend Setup
Bash
# Install Node dependencies
npm install

# Run Vite development server
npm run dev
4. Serve the Application
Bash
php artisan serve
Open http://localhost:8000 in your browser.

📐 Database Architecture Highlights
Pivot Table Conversion: Used for handling multiple game roles and vehicle specializations dynamically without hardcoding arrays or strings.

Scalable Divisions: Divisions are linked to a games table, making it effortless to add new games (e.g., Valorant, MLBB) in the future.

Data Integrity: Features strict constraints on scrim_schedules to maintain the one-scrim-per-day operational rule.

👤 Author
iRzell - Lead Developer / Creator - GitHub Profile
