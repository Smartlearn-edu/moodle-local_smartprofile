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
$string['completedcourses'] = 'Completed Courses';
$string['nocompletedcourses'] = 'No completed courses to display.';
$string['nocertificates'] = 'No certificates earned yet.';
$string['completedon'] = 'Completed';
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
$string['field_completedcourses'] = 'Completed Courses';
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

// --- Rewards & Trophies ---
$string['points_label'] = 'Points';
$string['trophies'] = 'Trophies';
$string['trophy_singular'] = '1 Trophy';
$string['trophies_plural'] = '{$a} Trophies';
$string['credithours'] = 'Credit Hours';
$string['credithours_display'] = '{$a} Credit Hours';
$string['credithours_breakdown'] = 'Academic Credit Hours Breakdown';
$string['credithours_breakdown_desc'] = 'Earned credit hours organized by academic department & subject';
$string['totalcredithours'] = 'Total Credit Hours';
$string['wallet'] = 'View Wallet';

// --- Privacy API ---
$string['privacy:metadata:preference:visibility'] = 'Stores the user\'s public/private visibility preferences for profile fields.';

// --- Social & LinkedIn Sharing ---
$string['sharing_heading'] = 'Social Media & LinkedIn Credential Sharing';
$string['sharing_desc'] = 'Allow learners to share their achievements and credit hours on LinkedIn and social networks.';
$string['show_shareonlinkedin'] = 'Show share on LinkedIn';
$string['show_shareonlinkedin_desc'] = 'Choose the target destination when learners or visitors click to verify the shared credential.';
$string['share_disabled'] = 'Do not show';
$string['share_link_verification'] = 'Show link to public verification page';
$string['share_link_profile'] = 'Show link to profile page';
$string['linkedin_org_id'] = 'LinkedIn Organization ID';
$string['linkedin_org_id_desc'] = 'The numeric ID of your LinkedIn organization page (e.g. 1234567). If left empty, it will auto-detect from the tool_certificate plugin if available.';
$string['issuer_name'] = 'Issuing Organization Name';
$string['issuer_name_desc'] = 'The organization name displayed on shared credentials (defaults to site name).';

$string['share_achievements'] = 'Share Achievements';
$string['add_to_linkedin'] = 'Add to LinkedIn';
$string['share_on_linkedin'] = 'Add to LinkedIn Profile';
$string['share_to_linkedin_feed'] = 'Share to LinkedIn Feed';
$string['share_to_x'] = 'Share on X (Twitter)';
$string['share_to_whatsapp'] = 'Share via WhatsApp';
$string['share_to_facebook'] = 'Share on Facebook';
$string['copy_verify_link'] = 'Copy Verification Link';
$string['link_copied'] = 'Link copied to clipboard!';
$string['share_modal_title'] = 'Share Academic Achievement';
$string['share_modal_subtitle'] = 'Showcase your verified accomplishment on LinkedIn and social media.';
$string['share_total_msg'] = '🎓 Proud to announce that I have earned {$a->credits} and {$a->trophies} at {$a->site}! View my verified learning portfolio: {$a->url}';
$string['share_cat_msg'] = '🎓 I have completed {$a->credits} in {$a->category} at {$a->site}! View my verified academic credential: {$a->url}';

// --- Public Verification Page ---
$string['verify_title'] = 'Academic Credential Verification';
$string['verified_credential'] = 'Verified Academic Credential';
$string['verified_seal'] = 'Officially Verified Credential';
$string['verified_by'] = 'Verified by {$a}';
$string['verified_recipient'] = 'Awarded to';
$string['verified_subject'] = 'Academic Discipline / Subject';
$string['verified_hours'] = 'Total Earned Hours';
$string['verified_code'] = 'Credential ID';
$string['verified_date'] = 'Date Verified';
$string['verified_subcats'] = 'Earned In Courses & Disciplines';
$string['invalid_verification'] = 'Invalid verification link or credential not found.';
