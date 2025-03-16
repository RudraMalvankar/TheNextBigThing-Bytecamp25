# TheNextBigThing - ByteCamp 2025 Hackathon Submission

Welcome to our project submission for **ByteCamp 2025 Hackathon**! 🚀

## About This Project
This project consists of four main modules, each serving a unique purpose and developed by different team members.

### 1. RethinkLabs (Brainify) - PHP & MySQL
Developed by **Rudra Malvankar**, this module is a VARK-based online learning environment designed to optimize learning strategies based on user preferences.

#### How to Run:
1. Install **XAMPP** or **WAMP** to set up a local PHP and MySQL environment.
2. Clone the repository and place the `rethinklabs` folder inside the `htdocs` (for XAMPP) or `www` (for WAMP) directory.
3. Import the `database.sql` file into **phpMyAdmin** to set up the database.
4. Start **Apache** and **MySQL** from your server control panel.
5. Open your browser and go to `http://localhost/rethinklabs` to run the application.

---

### 2. Business Model - PHP with Payment Gateway & Admin Dashboard
Developed by **Aditi Godse**, this module is similar to the RethinkLabs model but includes an integrated payment gateway and an admin dashboard for business operations.

#### How to Run:
1. Follow the same steps as RethinkLabs to set up PHP and MySQL.
2. Configure the payment gateway API keys in the `config.php` file.
3. Admin Dashboard can be accessed via `http://localhost/Business-model/admin/index.php`.
4. User interface is available at `http://localhost/Business-model/index.php`.

---

### 3. Shiksha - AI-Powered Real-Time Chat & AI-Driven Personalization
Developed by **Esha Gond**, Shiksha leverages AI to enhance learning through real-time chat and personalized content delivery. This module consists of two subfolders: **frontend** and **backend**.

#### Tech Stack:
- Frontend: **React (Vite)**
- Backend: **Node.js & MongoDB**

#### How to Set Up:
1. Install **Node.js** and **MongoDB**.
2. Clone the repository and navigate to the `shiksha/backend` folder.
   ```bash
   cd shiksha/backend
   npm install
   npx nodemon
   ```
3. Open another terminal and navigate to the `shiksha/frontend` folder.
   ```bash
   cd shiksha/frontend
   npm install
   npm run dev
   ```
4. Access the frontend at `http://localhost:5173` and the backend API at `http://localhost:5000`.

---

### 4. Custom Search Models - Next.js
Developed by **Kaivalya Narvekar**, this module consists of five different custom search models, each in a separate Next.js folder.

#### How to Set Up:
1. Ensure you have **Node.js** installed.
2. Navigate to each folder and run the following commands:
   ```bash
   npm install
   npm run dev
   ```
3. Access each project at `http://localhost:3175` (or as specified in `.env.local`).

---

## Team Members
- **Rudra Malvankar** - Full-Stack Developer & Team Leader
- **Aditi Godse** - Frontend Developer & Business Strategy
- **Esha Gond** - Frontend, AI Developer
- **Kaivalya Narvekar** - AI & Next.js Developer

We hope you enjoy exploring our project as much as we enjoyed building it! 🚀

**Team TheNextBigThing**

