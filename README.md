# Smart Profile (`local_smartprofile`)

**SmartProfile** is an enterprise-grade Moodle local plugin that reimagines the default profile page (`/user/profile.php` and `/user/view.php`) into a **Modern Digital Learner Identity & Academic Portfolio Hub**.

It empowers students, researchers, and educators to showcase their academic progress, verified micro-credentials, Apple Wallet passes, endorsements, certificates, gamification achievements, and skills in a responsive, LinkedIn-inspired portfolio format — backed by a **strict 3-layer privacy model**.

---

## ✨ Key Features

### 🎓 Academic Identity & Faculty Showcase
* **Identity-First Hero Card**:
  * Customizable cover banner with modern gradient overlay.
  * High-resolution avatar with online presence indicator.
  * Role Hierarchy display (`Admin > Manager > Teacher > Student > Parent`).
  * Custom status chips (*Active*, *Member since [date]*, *Location*).
  * **Role-Adaptive Faculty Mode**: Automatically detects teachers and professors to display *Courses Instructed*, *Total Students Taught*, *Office Hours Booking*, and academic research links (ORCID, Google Scholar, ResearchGate).

### 📄 One-Click Dynamic PDF CV Builder
* **Instant Academic Resume Generator**:
  * Generates professional 1-page PDF resumes directly in the browser via TCPDF.
  * Embeds high-contrast vector QR code linking directly to the instant public verification portal.
  * Lists academic background, courses completed, competencies, and verified instructor endorsements.

### 🌟 Verified Faculty Endorsements & Recommendations
* **Peer & Instructor Endorsements Engine**:
  * Instructors can write verified endorsements and rate learner competencies (1–5 stars).
  * Students can highlight recommendations on their profile and include them in their downloadable CV.

### 📱 Digital Credentials, Apple Wallet & Open Badges 3.0
* **Apple Wallet Pass Generation (`.pkpass`)**:
  * 1-click export of academic credit credentials into native Apple Wallet.
* **W3C Open Badges 3.0 (OBv3)**:
  * Interoperable JSON-LD credential endpoint conforming to global Open Badges v3 standards.
* **1-Click LinkedIn Add-to-Profile**:
  * Instant certificate sharing with prefilled certification IDs and direct verification URLs.

### 🛡️ Public Verification Portal
* Public verification endpoint (`/local/smartprofile/verify.php`) with tamper-proof security hash tokens for third-party institutional validation of credits, subjects, and badges.

### 🎮 Gamification & Achievement Center
* **Gamification Shield Widget**: Royal emblem displaying Level, Total XP, and progress bar to next level (integrates with `format_quest` with native fallback).
* **Profile Facts Strip (6-Metric Ribbon)**: Enrolled courses, Completed courses, Progress %, Certificates earned, Badges earned, Credit hours earned.
* **Learning Performance Card**: Real metrics for computed average grade and completed activities with automatic clean empty state handling.

### 🌐 Interoperability & Clean URLs
* **Custom Clean URL Harmony**: Integrates with `local_customcleanurl` for clean profile vanity URLs (`/user/profile/username`).
* **SmartDashboard Companion**: One-click cockpit launcher linking directly to `local_smartdashboard`.
* **Classic Moodle System Bridge**: Instant dropdown menu providing deep links to native Moodle reports, today's logs, forum posts, notes, and the default profile.

### 🎨 Enterprise White-Labeling & Custom Styling
* Customizable primary accent color (`custom_primary_color`).
* Custom brand logo URL.
* Custom footer tagline & custom CSS injection via site admin.
* Adaptive theme modes (Auto, Light, Dark) with high-contrast readability.

---

## 📦 Installation

1. Copy or clone the plugin directory into your Moodle installation:
   ```bash
   git clone https://github.com/Smartlearn-edu/moodle-local_smartprofile.git local/smartprofile
   ```
2. Navigate to **Site Administration > Notifications** to complete the database installation.
3. Configure the plugin settings under:
   **Site Administration > Plugins > Local plugins > Smart Profile**.

---

## ⚙️ Plugin Settings

| Setting | Description | Default |
| :--- | :--- | :--- |
| **Enable Redirection** | Seamlessly redirect `/user/profile.php` and `/user/view.php` to SmartProfile | `Enabled` |
| **Redirect Roles** | Filter which user roles are redirected | `All roles` |
| **Redirect Admins** | Whether administrators are redirected | `Enabled` |
| **Theme Mode** | Default color scheme (Auto, Dark, Light) | `Auto` |
| **Enable CV Export** | Enable downloadable dynamic PDF CV builder | `Enabled` |
| **Enable Endorsements** | Allow teachers to write verified student recommendations | `Enabled` |
| **Enable Wallet Passes** | Enable Apple Wallet .pkpass credential downloads | `Enabled` |
| **Enable Open Badges 3.0** | Enable W3C / 1EdTech JSON-LD verification endpoint | `Enabled` |
| **Custom Primary Color** | Hex code for enterprise brand accent color | *(Empty/Theme default)* |
| **Custom Logo URL** | URL to custom brand logo | *(Empty)* |
| **Custom Footer Tagline** | Custom footer copyright or accreditation tagline | *(Empty)* |
| **Custom CSS** | Inject custom SCSS/CSS rules directly | *(Empty)* |

---

## 🔒 Capabilities & Permissions

* `local/smartprofile:view`: Allows a user to access SmartProfile (default: Authenticated users).
* `local/smartprofile:viewallfields`: Allows managers and editing teachers to view all profile fields, bypassing individual privacy toggles.
* `local/smartprofile:endorse`: Allows teachers and managers to write verified endorsements for students.

---

## 🛠️ Technical Details

* **Moodle Version Support**: Moodle 4.5 / 5.0+ (Tested up to Moodle 5.2).
* **PHP Support**: PHP 8.1 / 8.2 / 8.3 / 8.4+.
* **Redirection Hook**: Implements Moodle's `\core\hook\output\before_http_headers` for instant, zero-flicker server-side interception with `classic=1` bypass.
* **Privacy & GDPR Compliance**: Full implementation of Moodle Privacy API (`\core_privacy\local\metadata\provider`, `\core_privacy\local\request\data_provider`, `\core_privacy\local\request\userlist_provider`, `user_preference_provider`).

---

## 📄 License

This program is free software: you can redistribute it and/or modify it under the terms of the **GNU General Public License (GPL-3.0-or-later)**.

Developed with ❤️ by [SmartLearn Education](https://smartlearn.education).
