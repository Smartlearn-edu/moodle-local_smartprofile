# Smart Profile (`local_smartprofile`) — Free Community Edition

<p align="center">
  <img src=".github/screenshots/0-main%20banner.png" alt="SmartProfile Main Banner & Identity Hub" width="100%">
</p>

**SmartProfile** is an open-source Moodle local plugin that reimagines the default profile page (`/user/profile.php` and `/user/view.php`) into a **Modern Digital Learner Identity & Academic Portfolio Hub**.

It empowers learners, researchers, and educators to showcase their academic progress, earned certificates, badges, completed courses, and skills in a responsive, LinkedIn-inspired portfolio format — backed by a **strict 3-layer privacy model**.

---

## 🎬 Visual Showcase & Highlights

### 1. 🎓 Academic Identity & Learning Performance
Personalized identity hero banner with online presence indicators, academic credit hour ribbons, and real-time learning analytics.

<table>
  <tr>
    <td width="50%" align="center" valign="top">
      <img src=".github/screenshots/0-main%20banner.png" alt="Identity-First Hero Card" width="100%"><br>
      <strong>Identity-First Hero Card & Stats Strip</strong><br>
      <em>Modern gradient cover, verified status chips, role hierarchy, and 6-metric academic ribbon.</em>
    </td>
    <td width="50%" align="center" valign="top">
      <img src=".github/screenshots/1-%20performance.png" alt="Learning Performance Card" width="100%"><br>
      <strong>Learning Performance & Analytics</strong><br>
      <em>Progress ring gauge, average grade metrics, and completed activities counter.</em>
    </td>
  </tr>
</table>

### 2. 📜 Completed Courses & Verified Certificates
Display verifiable academic accomplishments and courses completed across the institution with direct links.

<table>
  <tr>
    <td width="50%" align="center" valign="top">
      <img src=".github/screenshots/2-%20completed%20courses.png" alt="Completed Courses Showcase" width="100%"><br>
      <strong>Completed Courses Showcase</strong><br>
      <em>Gold-seal completion certificates with institution name, course title, and completion date.</em>
    </td>
    <td width="50%" align="center" valign="top">
      <img src=".github/screenshots/8-%20certificate.png" alt="Multi-Plugin Certificates" width="100%"><br>
      <strong>Multi-Plugin Verified Certificates</strong><br>
      <em>Auto-aggregates certificates from <code>mod_customcert</code> and <code>tool_certificate</code> with verification codes.</em>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top">
      <img src=".github/screenshots/3-%20lerning%20progress.png" alt="Learning Journey & Progress" width="90%"><br>
      <strong>Learning Journey & Enrolled Courses</strong><br>
      <em>Real-time course progress bars, completion tags, and quick-jump links.</em>
    </td>
  </tr>
</table>

### 3. 🛡️ 3-Layer Privacy & Granular Visibility Control
Give learners complete autonomy over their public presence while maintaining core Moodle capability rules and staff overrides.

<table>
  <tr>
    <td width="50%" align="center" valign="top">
      <img src=".github/screenshots/7-%20Privacy.png" alt="Privacy Settings Overview" width="100%"><br>
      <strong>Privacy & Visibility Dashboard</strong><br>
      <em>Categorized controls for contact info, course visibility, and academic stats.</em>
    </td>
    <td width="50%" align="center" valign="top">
      <img src=".github/screenshots/7-%20Privacy-2.png" alt="Granular Field Visibility Toggles" width="100%"><br>
      <strong>Granular Field Visibility Toggles</strong><br>
      <em>Individual public/private switches for email, phone, city, badges, and recent activity.</em>
    </td>
  </tr>
</table>

---

## ✨ Key Features (Community Edition)

### 🎓 Academic Identity & Student Showcase
* **Identity-First Hero Card**:
  * Modern cover banner with stylish gradient overlay.
  * High-resolution avatar with online presence indicator.
  * Role Hierarchy display (`Admin > Manager > Teacher > Student > Parent`).
  * Status chips (*Active*, *Member since [date]*, *Location*).
  * Academic bio quote and customizable overview.

### 🛡️ 3-Layer Privacy & Visibility Control
* **Student Privacy Autonomy**: Granular user privacy settings (Public vs. Private) for email, phone, city, timezone, courses, badges, and recent activity.
* **Core Capability Gate**: Fully respects core Moodle visibility rules and capability gates.
* **Staff Override**: Allows managers and editing teachers to inspect complete student details when authorized.

### 📊 Academic Progress & Multi-Plugin Certificates
* **Course Progress Cards**: Enrolled courses showcase with completion progress bar and direct course links.
* **Badges & Achievements Gallery**: Visual display of earned Open Badges with direct verification links.
* **Multi-Plugin Certificate Engine**: Automatically detects and displays certificates from `mod_customcert`, `tool_certificate`, and `mod_certificate`.
* **Profile Facts Strip (6-Metric Ribbon)**: Enrolled courses, Completed courses, Progress %, Certificates earned, Badges earned, Credit hours earned.
* **Learning Performance Card**: Real metrics for computed average grade and completed activities with automatic empty state handling.

### 🌐 Interoperability & Clean URLs
* **Custom Clean URL Harmony**: Integrates with `local_customcleanurl` for clean profile vanity URLs (`/user/profile/username`).
* **SmartDashboard Companion**: One-click cockpit launcher linking directly to `local_smartdashboard`.
* **Classic Profile System Bridge**: Instant dropdown menu providing deep links to native Moodle reports, today's logs, forum posts, notes, and the default profile.

---

## 💎 SmartProfile Pro / Enterprise Features

Looking for institutional verifiable credentials, Apple Wallet passes, and faculty endorsements? Explore **SmartProfile Pro**:

<table>
  <tr>
    <td width="33%" align="center" valign="top">
      <img src=".github/screenshots/5-%20generated%20pf.png" alt="Dynamic PDF CV Builder" width="100%"><br>
      <strong>Dynamic PDF CV Builder</strong><br>
      <em>Instant 1-page academic resume with vector QR verification code.</em>
    </td>
    <td width="33%" align="center" valign="top">
      <img src=".github/screenshots/4-%20academic%20endorsment.png" alt="Faculty Endorsements" width="100%"><br>
      <strong>Verified Faculty Endorsements</strong><br>
      <em>Instructor-written recommendations with 5-star competency ratings.</em>
    </td>
    <td width="33%" align="center" valign="top">
      <img src=".github/screenshots/6-%20linkedin%20share.png" alt="LinkedIn Add to Profile" width="100%"><br>
      <strong>1-Click LinkedIn Sharing</strong><br>
      <em>Pre-filled certification IDs and direct credential verification links.</em>
    </td>
  </tr>
</table>

* 📱 **Apple Wallet Passes (`.pkpass`)**: Instant mobile wallet credentials with scannable QR verification.
* 📜 **One-Click Dynamic PDF CV Builder**: Professional 1-page academic resumes generated via TCPDF with verification QR codes.
* 👨‍🏫 **Role-Adaptive Faculty & Educator Showcase**: Automatically detects teachers and professors to display *Courses Instructed*, *Total Students Taught*, and academic research links.
* 🌟 **Verified Faculty Endorsements**: Instructors can author verified recommendations with 5-star skill ratings.
* 🛡️ **W3C / 1EdTech Open Badges 3.0 (OBv3)**: Cryptographic JSON-LD credential assertions endpoint.
* 🎨 **Enterprise White-Labeling**: Multi-tenant custom brand logo, primary colors, footer taglines, and custom CSS injection.

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
| **Redirect Admins** | Whether administrators are redirected | `Disabled` |
| **Theme Mode** | Default color scheme (Auto, Dark, Light) | `Auto` |
| **Show Courses** | Master toggle for courses section | `Enabled` |
| **Show Badges** | Master toggle for badges section | `Enabled` |
| **Show Activity** | Master toggle for recent activity section | `Enabled` |
| **Show Gamification** | Master toggle for gamification badge stats | `Enabled` |

---

## 🔒 Capabilities & Permissions

* `local/smartprofile:view`: Allows a user to access SmartProfile (default: Authenticated users).
* `local/smartprofile:viewallfields`: Allows managers and editing teachers to view all profile fields, bypassing individual privacy toggles.

---

## 🛠️ Technical Details

* **Moodle Version Support**: Moodle 4.5 / 5.0+ (Tested up to Moodle 5.2).
* **PHP Support**: PHP 8.1 / 8.2 / 8.3 / 8.4+.
* **Redirection Hook**: Implements Moodle's `\core\hook\output\before_http_headers` for instant, zero-flicker server-side interception with `classic=1` bypass.
* **Privacy & GDPR Compliance**: Full implementation of Moodle Privacy API (`\core_privacy\local\metadata\provider`, `user_preference_provider`).

---

## 📄 License

This program is free software: you can redistribute it and/or modify it under the terms of the **GNU General Public License (GPL-3.0-or-later)**.

Developed with ❤️ by [SmartLearn Education](https://smartlearn.education).
