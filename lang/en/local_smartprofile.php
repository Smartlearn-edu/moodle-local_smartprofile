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
$string['certificate'] = 'Certificate';
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

// --- Dynamic Academic CV & PDF Exporter ---
$string['cv_heading'] = 'Academic CV & Resume Exporter';
$string['cv_desc'] = 'Allow learners and staff to export a 1-click dynamic academic CV (PDF) with embedded tamper-evident QR verification.';
$string['enable_cv_export'] = 'Enable Academic CV Export';
$string['enable_cv_export_desc'] = 'When enabled, a "Download CV (PDF)" button will be visible on the profile page.';
$string['export_cv'] = 'Download CV (PDF)';
$string['cv_title'] = 'Academic CV & Learner Profile';
$string['scan_to_verify'] = 'Scan the QR code to verify this official academic record online.';
$string['featuredisabled'] = 'This feature is currently disabled by the site administrator.';

// --- Role-Adaptive Faculty & Educator Showcase ---
$string['faculty_heading'] = 'Faculty & Educator Showcase';
$string['faculty_desc'] = 'Control role-adaptive profiles for teachers, instructors, and professors.';
$string['enable_faculty_mode'] = 'Enable Role-Adaptive Faculty Profiles';
$string['enable_faculty_mode_desc'] = 'When enabled, profiles of teachers, instructors, and managers automatically adapt to display their taught courses, students instructed, research links, and office hours.';
$string['taught_courses'] = 'Courses Instructed';
$string['taught_courses_desc'] = 'Courses actively taught and managed by this faculty member.';
$string['students_instructed'] = 'Students Instructed';
$string['academic_disciplines'] = 'Academic Disciplines';
$string['faculty_tenure'] = 'Academic Tenure';
$string['tenure_year_single'] = '1st Year Faculty';
$string['tenure_years_plural'] = '{$a} Years Active';
$string['office_hours'] = 'Office Hours & Consultations';
$string['office_location'] = 'Office Location';
$string['book_consultation'] = 'Book Consultation';
$string['academic_research'] = 'Academic Research & Publications';
$string['research_interests'] = 'Research Interests & Specializations';
$string['google_scholar'] = 'Google Scholar';
$string['researchgate'] = 'ResearchGate';
$string['faculty_badge'] = 'Verified Faculty / Educator';
$string['no_taught_courses'] = 'No active taught courses to display.';

// --- Open Badges 3.0 (OBv3) & Mobile Wallet Credentials ---
$string['wallet_heading'] = 'Open Badges 3.0 & Mobile Wallet Passes';
$string['wallet_desc'] = 'Enable learners to export their verified credentials as Apple Wallet passes (.pkpass) and W3C Open Badges 3.0 JSON-LD assertions.';
$string['enable_wallet_passes'] = 'Enable Apple Wallet Passes (.pkpass)';
$string['enable_wallet_passes_desc'] = 'When enabled, learners and third parties can download a native mobile pass (.pkpass) for Apple Wallet with scannable QR verification.';
$string['enable_obv3'] = 'Enable Open Badges 3.0 (JSON-LD) Endpoint';
$string['enable_obv3_desc'] = 'When enabled, the verification page supports 1EdTech / W3C Open Badges 3.0 cryptographic JSON-LD output via API & web.';
$string['add_to_apple_wallet'] = 'Save to Apple Wallet';
$string['export_obv3'] = 'Open Badges 3.0 (JSON-LD)';
$string['wallet_pass_title'] = 'Verified Academic Pass';

// --- Academic Endorsements & Faculty Recommendations ---
$string['endorsements_heading'] = 'Academic Endorsements & Faculty Recommendations';
$string['endorsements_desc'] = 'Allow teachers and professors to write verified skill endorsements and recommendations on learner profiles.';
$string['enable_endorsements'] = 'Enable Academic Endorsements';
$string['enable_endorsements_desc'] = 'When enabled, verified faculty members can endorse skills and write academic recommendations for their students.';
$string['write_endorsement'] = 'Write Recommendation';
$string['no_endorsements_yet'] = 'No faculty recommendations have been added yet.';
$string['be_first_to_endorse'] = 'Be the first educator to endorse this learner';
$string['endorsed_skill'] = 'Endorsed Skill / Academic Competency';
$string['endorsed_skill_placeholder'] = 'e.g. Machine Learning, Statistical Analysis, Team Leadership...';
$string['general_endorsement'] = 'General Academic Recommendation';
$string['rating'] = 'Faculty Praise & Assessment Rating';
$string['rating_exceptional'] = 'Exceptional Performance';
$string['rating_very_good'] = 'Very Good';
$string['rating_good'] = 'Good';
$string['recommendation_text'] = 'Recommendation & Testimonial Statement';
$string['recommendation_placeholder'] = 'Write a detailed recommendation highlighting the student\'s academic strengths, coursework projects, and dedication...';
$string['submit_endorsement'] = 'Publish Verified Recommendation';
$string['endorsement_added_success'] = 'Faculty recommendation has been successfully published to the learner\'s profile.';
$string['endorsement_deleted_success'] = 'Endorsement has been removed.';
$string['endorsement_empty_skill'] = 'Please provide a skill or competency to endorse.';
$string['delete_confirm'] = 'Are you sure you want to delete this recommendation?';
$string['verified_faculty'] = 'Verified Faculty / Instructor';

// --- SmartDashboard Interop & Enterprise White-Labeling ---
$string['interop_heading'] = 'SmartDashboard Interoperability & Enterprise White-Labeling';
$string['interop_desc'] = 'Connect SmartProfile with SmartDashboard and customize institutional branding.';
$string['enable_smartdashboard_interop'] = 'Enable SmartDashboard Companion Interoperability';
$string['enable_smartdashboard_interop_desc'] = 'When enabled and local_smartdashboard is installed, direct navigation links and student 360° analytics launchers will appear on the profile.';
$string['open_smartdashboard'] = 'Open in SmartDashboard';
$string['custom_primary_color'] = 'Primary Brand Accent Color (HEX)';
$string['custom_primary_color_desc'] = 'Override the primary accent color across all profile components (e.g., #10b981, #2563eb, #8b5cf6). Leave empty to use theme defaults.';
$string['custom_logo_url'] = 'Custom Institution Logo URL';
$string['custom_logo_url_desc'] = 'Custom logo image URL for institution branding across profiles, verification portals, and PDF CVs.';
$string['custom_footer_tagline'] = 'Custom Footer Tagline';
$string['custom_footer_tagline_desc'] = 'Custom statement or copyright notice rendered at the bottom of learner and faculty profiles.';
$string['custom_css'] = 'Custom Enterprise CSS Overrides';
$string['custom_css_desc'] = 'Additional CSS rules to inject directly into SmartProfile pages for bespoke institutional styling.';

// --- Classic Profile & Report Links ---
$string['classic_profile'] = 'Classic Profile';
$string['moodle_system_profile'] = 'Classic Profile & Reports';
$string['view_classic_profile'] = 'Open Default Classic Profile';
$string['course_profile'] = 'Course Profile View';
$string['reports_and_logs'] = 'Reports & Activity Logs';
$string['todays_logs'] = 'Today\'s Activity Logs';
$string['all_logs'] = 'All Activity Logs';
$string['outline_report'] = 'Activity Outline Report';
$string['complete_report'] = 'Complete Activity Report';
$string['user_contributions'] = 'Posts, Notes & Tools';
$string['forum_posts'] = 'Forum Posts';
$string['forum_discussions'] = 'Forum Discussions';
$string['teacher_notes'] = 'Teacher Notes';
$string['learning_plans'] = 'Learning Plans & Competencies';
$string['browser_sessions'] = 'Active Browser Sessions';
$string['send_message'] = 'Send Message';

// --- Privacy Metadata ---
$string['privacy:metadata:endorse'] = 'Stores academic endorsements and recommendations written by instructors for learners.';
$string['privacy:metadata:endorse:userid'] = 'The ID of the learner receiving the recommendation.';
$string['privacy:metadata:endorse:endorserid'] = 'The ID of the instructor who authored the endorsement.';
$string['privacy:metadata:endorse:skill'] = 'The skill or competency being endorsed.';
$string['privacy:metadata:endorse:recommendation'] = 'The recommendation text.';
$string['privacy:metadata:endorse:rating'] = 'The rating given.';
$string['privacy:metadata:endorse:timecreated'] = 'The time the endorsement was created.';

// --- Preferences Page Strings ---
$string['profile_visibility_settings'] = 'SmartProfile Privacy & Visibility';
$string['profile_visibility_desc'] = 'Choose what other students, instructors, and visitors can see on your academic profile.';
$string['privacy_category_contact'] = 'Contact & Location';
$string['privacy_category_about'] = 'Biography & Skills';
$string['privacy_category_academic'] = 'Academic Progress & Courses';
$string['privacy_category_gamification'] = 'Gamification, Badges & Levels';
$string['privacy_category_activity'] = 'Recent Learning Activity';
$string['back_to_profile'] = 'Back to Profile';
$string['click_to_toggle'] = 'Click to toggle Public / Private';
$string['saved'] = 'Preferences saved successfully';

// --- Privacy Data Export Strings ---
$string['privacy:data:endorsementsreceived'] = 'Endorsements received';
$string['privacy:data:endorsementsauthored'] = 'Endorsements authored';

// --- Endorsement Errors ---
$string['endorsement_notfound'] = 'The endorsement could not be found. It may have already been removed.';

// --- Real Activity & Facts Strings ---
$string['website'] = 'Website';
$string['credithours_earned'] = 'Credit Hours Earned';
$string['activity_badge_earned'] = 'Earned the badge "{$a}"';
$string['activity_course_completed'] = 'Completed the course "{$a}"';

// --- Pro Upgrade Promo Strings ---
$string['upgrade_to_pro'] = 'SmartProfile Pro';
$string['upgrade_to_pro_title'] = 'Explore SmartProfile Pro Enterprise Features';
$string['pro_promo_heading'] = '⭐ SmartProfile Pro / Enterprise Edition';
$string['pro_promo_desc'] = 'Looking for Apple Wallet passes (.pkpass), 1EdTech/W3C Open Badges 3.0, dynamic PDF CV resumes, and verified faculty recommendations? <a href="https://services.smartlearn.education/services/plugins/local_smartprofile" target="_blank" class="btn btn-sm btn-primary ms-2">Explore SmartProfile Pro ↗</a>';
$string['pro_menu_item'] = 'SmartProfile Pro';
$string['pro_page_title'] = 'SmartProfile Pro & Enterprise Edition';
$string['pro_badge'] = 'PRO / ENTERPRISE EDITION';
$string['pro_hero_title'] = 'Supercharge Your Moodle with Enterprise Digital Identity';
$string['pro_hero_desc'] = 'Unlock Apple Wallet passes, W3C Open Badges 3.0, dynamic 1-page PDF academic CVs, verified faculty recommendations, and full enterprise white-labeling.';
$string['pro_get_btn'] = 'Get SmartProfile Pro ↗';
$string['pro_feat_wallet_title'] = 'Native Apple Wallet Passes (.pkpass)';
$string['pro_feat_wallet_desc'] = 'Allow learners to download native iOS/Android Apple Wallet passes with scannable QR verification for academic credits and credentials.';
$string['pro_feat_cv_title'] = 'One-Click Dynamic PDF CV Builder';
$string['pro_feat_cv_desc'] = 'Generate professional 1-page academic resumes on the fly via TCPDF with high-contrast vector QR codes linking directly to public verification.';
$string['pro_feat_endorse_title'] = 'Verified Faculty Endorsements Engine';
$string['pro_feat_endorse_desc'] = 'Instructors can author verified recommendations with 5-star skill ratings, showcasing learner competencies on their public portfolio and CV.';
$string['pro_feat_obv3_title'] = 'W3C / 1EdTech Open Badges 3.0';
$string['pro_feat_obv3_desc'] = 'Cryptographic JSON-LD credential assertion endpoint conforming to global Open Badges v3 standards.';
$string['pro_compare_title'] = 'Feature Comparison';
$string['pro_compare_subtitle'] = 'Compare features between SmartProfile Free Community and Pro Enterprise editions.';
$string['edition_free'] = 'Community (Free)';
$string['edition_pro'] = 'Enterprise (Pro)';
$string['comp_modern_profile'] = 'Modern Learner Identity & Portfolio UI';
$string['comp_privacy_toggles'] = '3-Layer Privacy & Field Visibility Toggles';
$string['comp_course_progress'] = 'Course Progress & Badges Showcase Cards';
$string['comp_wallet_passes'] = 'Apple Wallet (.pkpass) Digital Mobile Credentials';
$string['comp_cv_builder'] = 'Dynamic PDF Academic CV & Resume Builder';
$string['comp_faculty_endorsements'] = 'Verified Faculty Endorsements & Recommendation Engine';
$string['comp_obv3'] = 'W3C Open Badges 3.0 (JSON-LD) Verifiable Credential API';
$string['pro_cta_footer_title'] = 'Ready to Upgrade Your Institution?';
$string['pro_cta_footer_desc'] = 'SmartProfile Pro is available as an instant in-place upgrade. Simply install the Pro ZIP over the Free edition with zero data loss.';

$string['feature'] = 'Feature';
$string['pro_feat_faculty_title'] = 'Role-Adaptive Faculty & Educator Showcase';
$string['pro_feat_faculty_desc'] = 'Smart adaptive profile detection for professors and teachers, displaying courses instructed, students taught, academic discipline metrics, and research links.';
$string['comp_faculty_mode'] = 'Role-Adaptive Faculty & Educator Portfolio Mode';
$string['pro_feat_trophy_title'] = 'Royal Trophy Shield & Lifetime Points Showcase';
$string['pro_feat_trophy_desc'] = 'Showcase learner levels, trophies, XP points, and credit hour milestones with direct Apple Wallet pass syncing.';
$string['comp_trophy_shield'] = 'Royal Trophy Shield & Gamification Widget';
$string['pro_bundle_badge'] = 'SPECIAL INSTITUTIONAL BUNDLE OFFER • SAVE MORE';
$string['pro_bundle_title'] = 'SmartProfile Pro + Trophy & Credits Engine Bundle';
$string['pro_bundle_desc'] = 'Equip your Moodle site with the ultimate gamified academic portfolio suite. Combine SmartProfile Pro with the automated Trophy & Medals rewards engine at an exclusive bundled price.';
$string['pro_bundle_item_sp'] = 'SmartProfile Pro: Apple Wallet passes, W3C Open Badges 3.0, Dynamic PDF CVs & Faculty Endorsements.';
$string['pro_bundle_item_trophy'] = 'Trophy & Credits Engine: Automated course completion awards, lifetime XP & wallet balances.';
$string['pro_bundle_item_sync'] = 'Seamless zero-configuration plug-and-play auto-sync between both plugins.';
$string['pro_bundle_btn'] = 'Get the SmartLearn Bundle (Special Discount) ↗';
