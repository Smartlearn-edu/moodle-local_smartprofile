<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Language strings for local_smartprofile.
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Smart Profile';
$string['smartprofile:view'] = 'View Smart Profile';
$string['smartprofile:viewallfields'] = 'View all profile fields bypassing user privacy toggles (Staff override)';

// --- Settings ---
$string['redirect_heading'] = 'Profile Redirection';
$string['redirect_desc'] = 'Control how users are redirected to the Smart Profile page.';
$string['enableredirect'] = 'Enable Profile Redirection';
$string['enableredirect_desc'] = 'When enabled, visits to the standard Moodle profile (/user/profile.php) will be seamlessly redirected to Smart Profile.';
$string['redirectroles'] = 'Redirect Roles';
$string['redirectroles_desc'] = 'Select which roles should be redirected. If none are selected, all authenticated users will be redirected.';
$string['redirectadmins'] = 'Redirect Administrators';
$string['redirectadmins_desc'] = 'Whether site administrators should also be redirected to Smart Profile.';

$string['appearance_heading'] = 'Appearance & Theme';
$string['appearance_desc'] = 'Configure the visual look and feel of the Smart Profile page.';
$string['thememode'] = 'Theme Mode';
$string['thememode_desc'] = 'Choose the default theme mode for the profile page.';
$string['thememode_auto'] = 'Auto (Match system / theme)';
$string['thememode_dark'] = 'Dark Mode';
$string['thememode_light'] = 'Light Mode';

$string['sections_heading'] = 'Profile Sections';
$string['sections_desc'] = 'Enable or disable specific sections on the profile page.';
$string['showcourses'] = 'Show Courses Section';
$string['showcourses_desc'] = 'Display enrolled courses with completion progress.';
$string['showbadges'] = 'Show Badges Section';
$string['showbadges_desc'] = 'Display earned badges in a visual grid.';
$string['showactivity'] = 'Show Activity Section';
$string['showactivity_desc'] = 'Display login recency and activity stats.';
$string['showgamification'] = 'Show Gamification Section';
$string['showgamification_desc'] = 'Display Quest level and gamification stats if format_quest is installed.';

// --- Profile Page UI ---
$string['editprofile'] = 'Edit Profile';
$string['preferences'] = 'Preferences';
$string['viewgrades'] = 'View Grades';
$string['lastseen'] = 'Last active';
$string['justnow'] = 'Just now';
$string['minutesago'] = '{$a}m ago';
$string['hoursago'] = '{$a}h ago';
$string['daysago'] = '{$a}d ago';
$string['membersince'] = 'Member since';
$string['joined'] = 'Joined';

// --- Metrics & Facts Ribbon ---
$string['coursesenrolled'] = 'Courses Enrolled';
$string['coursescompleted'] = 'Courses Completed';
$string['overallprogress'] = 'Overall Progress';
$string['certificates'] = 'Certificates';
$string['badgesearned'] = 'Badges Earned';
$string['currentstreak'] = 'Current Streak';

// --- Performance & Cards ---
$string['learningperformance'] = 'Learning Performance';
$string['viewfullanalytics'] = 'View full analytics';
$string['averagegrade'] = 'Average Grade';
$string['activitiescompleted'] = 'Activities Completed';
$string['assessmentscompleted'] = 'Assessments Completed';
$string['timespentlearning'] = 'Time Spent Learning';

$string['achievements'] = 'Achievements';
$string['learningjourney'] = 'Learning Journey';
$string['section_about'] = 'About Me';
$string['section_contact'] = 'Contact Information';
$string['profilevisibility'] = 'Profile Visibility';
$string['privacy_info'] = 'Click the badges below to toggle what other students can see on your profile.';
$string['recentactivity'] = 'Recent Activity';
$string['skills'] = 'Skills & Expertise';
$string['connect'] = 'Connect';
$string['issued'] = 'Issued';
$string['footertagline'] = 'Empowering learners, showcasing achievements.';

$string['interests'] = 'Interests';
$string['nocourses'] = 'No enrolled courses to display.';
$string['nobadges'] = 'No badges earned yet.';
$string['completed'] = 'Completed';
$string['progress'] = 'Progress';
$string['dateissued'] = 'Earned';
$string['firstaccess'] = 'First access';
$string['lastaccess'] = 'Last access';
$string['ipaddress'] = 'IP Address';

$string['status_public'] = 'Public';
$string['status_private'] = 'Private';
$string['make_public'] = 'Make Public';
$string['make_private'] = 'Make Private';
$string['visibility_toggle_help'] = 'Toggle between Public (visible to classmates) and Private (hidden from classmates). Staff can always see full info.';

// --- Fields ---
$string['field_email'] = 'Email';
$string['field_phone'] = 'Phone';
$string['field_city'] = 'City';
$string['field_country'] = 'Country';
$string['field_timezone'] = 'Timezone';
$string['field_description'] = 'Biography';
$string['field_interests'] = 'Interests';
$string['field_courses'] = 'Courses';
$string['field_performance'] = 'Learning Performance';
$string['field_certificates'] = 'Certificates';
$string['field_badges'] = 'Badges';
$string['field_gamelevel'] = 'Game Level & XP';
$string['field_skills'] = 'Skills & Expertise';
$string['field_social'] = 'Social Links';
$string['field_activity'] = 'Activity Stats';

// --- AJAX & Feedback ---
$string['pref_saved'] = 'Privacy preference updated successfully.';
$string['pref_error'] = 'Could not save privacy preference.';
$string['error_access_denied'] = 'Access denied.';

// --- Privacy API ---
$string['privacy:metadata:preference:visibility'] = 'Stores the user\'s public/private visibility preferences for profile fields.';
