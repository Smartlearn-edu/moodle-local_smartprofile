# Smart Profile (`local_smartprofile`)

**SmartProfile** is a modern Moodle local plugin that replaces the outdated default profile page (`/user/profile.php`) with a **Digital Learner Identity & Academic Portfolio**.

It empowers students and educators to showcase their academic progress, verified achievements, certificates, gamification levels, and skills in a responsive, LinkedIn-inspired portfolio format — backed by a **strict 3-layer privacy model**.

---

## ✨ Key Features

* **Identity-First Hero Card**:
  * Customizable cover banner with modern gradient overlay.
  * Overlapping high-resolution avatar with online presence indicator.
  * Name with verified learner badge.
  * Intelligent Role Hierarchy display (`Admin > Manager > Teacher > Student > Parent`).
  * Status chips (*Active*, *Member since [date]*, *Location*).
  * **Gamification Shield Widget**: Royal purple emblem displaying current Level, Total XP, and progress bar to the next level (integrates with `format_quest` with native fallback).

* **Profile Facts Strip (6-Metric Ribbon)**:
  * 📖 Courses Enrolled
  * 🎓 Courses Completed
  * 📊 Overall Progress %
  * 📜 Certificates Earned
  * 🏅 Badges Earned
  * 🔥 Current Streak (Days)

* **Learning Performance Card**:
  * Conic circular progress gauge with glowing gradient accent.
  * 4 performance metrics: *Average Grade*, *Activities Completed*, *Assessments Completed*, and *Time Spent Learning*.

* **Achievements & Certificates**:
  * Shiny token medal cards for earned badges with issue dates and `+N More` counter.
  * Framed credential cards for course completion certificates.

* **Learning Journey**:
  * Compact course progress rows with course icons, percentage bars, and *Completed* / *In Progress* tags.

* **SmartLearn Theme Adaptive**:
  * Fully integrated with `theme_smartlearn` CSS custom properties (`--smartlearn-primary`, `--smartlearn-bg`, `--smartlearn-card-bg`, etc.).
  * Automatically coordinates with all SmartLearn style presets (*Emerald Forest*, *Nordic Minimalist*, *Oceanic Teal*, *Crimson University*, *Dark Glassmorphism*, etc.).

* **Strict 3-Layer Privacy Engine**:
  * **Core Moodle Gate**: Respects Moodle's native capability checks (`user_can_view_profile()`).
  * **Staff Override**: Teachers/Admins with `local/smartprofile:viewallfields` can view full profiles.
  * **Personal Privacy Toggles**: Students can toggle specific sections (*Public* vs *Private*) with instant AJAX controls saved directly to Moodle's native User Preferences API (GDPR compliant).
  * **Recent Activity Privacy**: Strictly hidden from classmates/public visitors by default.

---

## 🔗 Clean Vanity URLs (`/profile/username`)

SmartProfile supports ultra-clean vanity URLs such as:
> `https://smartlearn.education/profile/sara`  
> `https://yourdomain.com/profile/john.doe`

### 1. Nginx Configuration

Add the following rewrite rule inside your Nginx `server { ... }` block:

```nginx
# SmartProfile Clean Vanity URLs
rewrite ^/profile/([^/]+)/?$ /local/smartprofile/index.php?username=$1 last;
```

If your Moodle instance is in a subdirectory (e.g. `/dev` or `/moodle`):
```nginx
rewrite ^/dev/profile/([^/]+)/?$ /dev/local/smartprofile/index.php?username=$1 last;
```

Reload Nginx:
```bash
sudo nginx -t && sudo systemctl reload nginx
```

---

### 2. Apache Configuration (`.htaccess`)

Add this rule to the `.htaccess` file in your Moodle web root:

```apache
RewriteEngine On
RewriteRule ^profile/([^/]+)/?$ local/smartprofile/index.php?username=$1 [L,QSA]
```

---

### 3. Built-in Slash Arguments (Zero Configuration)

If web server rewrite rules cannot be modified, SmartProfile works out of the box with Moodle's native slash arguments:
* `https://yourdomain.com/local/smartprofile/index.php/sara`
* `https://yourdomain.com/local/smartprofile/index.php/7`

---

## 📦 Installation

1. Copy or clone the plugin directory into your Moodle installation:
   ```bash
   git clone https://github.com/Smartlearn-edu/moodle-local_smartprofile.git local/smartprofile
   ```
2. Navigate to **Site Administration > Notifications** to complete the database installation.
3. Configure the plugin under **Site Administration > Plugins > Local plugins > Smart Profile**.

---

## ⚙️ Plugin Settings

| Setting | Description | Default |
| :--- | :--- | :--- |
| **Enable Redirection** | Seamlessly redirect `/user/profile.php` visits to SmartProfile | `Enabled` |
| **Redirect Roles** | Filter which user roles are redirected | `All roles` |
| **Redirect Admins** | Whether administrators are redirected | `Enabled` |
| **Theme Mode** | Default color scheme (Auto, Dark, Light) | `Auto` |
| **Profile Sections** | Toggle visibility of Courses, Badges, Activity, and Gamification sections | `All enabled` |

---

## 🔒 Capabilities & Permissions

* `local/smartprofile:view`: Allows a user to access the SmartProfile page (default: Authenticated users).
* `local/smartprofile:viewallfields`: Allows staff/managers to view all profile fields, bypassing individual privacy toggles.

---

## 🛠️ Technical Details

* **Moodle Version Support**: Moodle 4.x / 5.0+ (Tested up to Moodle 5.2).
* **PHP Support**: PHP 8.1 / 8.2 / 8.3+.
* **Redirection Hook**: Implements Moodle 5.x `\core\hook\output\before_http_headers` for fast, zero-flicker server-side interception.
* **No Redundant Tables**: Uses Moodle's native `$DB` queries and User Preferences API for clean uninstalls and automatic GDPR compliance.

---

## 📄 License

This program is free software: you can redistribute it and/or modify it under the terms of the **GNU General Public License (GPL-3.0-or-later)**.

Developed with ❤️ by [SmartLearn Education](https://smartlearn.education).
