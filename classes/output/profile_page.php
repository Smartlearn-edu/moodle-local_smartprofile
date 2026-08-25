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

namespace local_smartprofile\output;

use renderable;
use templatable;
use renderer_base;
use moodle_url;
use user_picture;
use context_user;
use context_system;
use core_tag_tag;
use local_smartprofile\visibility_manager;

/**
 * Output renderable for the Smart Profile (Digital Learner Identity & Portfolio).
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class profile_page implements renderable, templatable {
    /** @var object The user whose profile is being viewed */
    protected $profileuser;

    /** @var object The current viewer */
    protected $viewer;

    /** @var context_user */
    protected $usercontext;

    /** @var int Optional course context ID */
    protected $courseid;

    /**
     * Constructor.
     *
     * @param object $profileuser
     * @param object $viewer
     * @param int $courseid
     */
    public function __construct(object $profileuser, object $viewer, int $courseid = 0) {
        $this->profileuser = $profileuser;
        $this->viewer = $viewer;
        $this->courseid = $courseid;
        $this->usercontext = context_user::instance($profileuser->id);
    }

    /**
     * Exports data for Mustache template.
     *
     * @param renderer_base $output
     * @return array
     */
    public function export_for_template(renderer_base $output): array {
        global $CFG, $DB, $PAGE, $USER, $SITE;
        require_once($CFG->dirroot . '/user/profile/lib.php');
        require_once($CFG->libdir . '/badgeslib.php');
        require_once($CFG->libdir . '/enrollib.php');

        $isown = ($this->viewer->id == $this->profileuser->id);
        $systemcontext = context_system::instance();
        $isadmin = is_siteadmin($this->viewer);
        $canviewall = $isadmin || has_capability('local/smartprofile:viewallfields', $this->usercontext, $this->viewer);

        // 1. Avatar & User Picture.
        $userpicture = new user_picture($this->profileuser);
        $userpicture->size = 180;
        $avatarurl = $userpicture->get_url($PAGE)->out(false);

        // 2. Roles & Headlines.
        $rolebadges = $this->get_user_roles();
        $primaryrole = !empty($rolebadges) ? $rolebadges[0]['name'] : get_string('student', 'core');
        $institution = $this->profileuser->institution ?: ($SITE->shortname ?? get_string('pluginname', 'local_smartprofile'));
        $department = $this->profileuser->department ?: '';
        $headline = $this->profileuser->department ? ($this->profileuser->department . ' • ' . $institution) : ($primaryrole . ' at ' . $institution);

        // 3. Status & Location.
        $countries = get_string_manager()->get_list_of_countries();
        $countryname = !empty($this->profileuser->country) ? ($countries[$this->profileuser->country] ?? $this->profileuser->country) : '';
        $locationparts = array_filter([$this->profileuser->city, $countryname]);
        $locationstring = !empty($locationparts) ? implode(', ', $locationparts) : '';
        $membersince = $this->profileuser->timecreated ? userdate($this->profileuser->timecreated, '%B %Y') : '';

        // 4. Action URLs.
        $canedit = $isown ? has_capability('moodle/user:editownprofile', $this->usercontext)
                          : has_capability('moodle/user:editprofile', $this->usercontext);

        $editurl = $canedit ? ($isown ? (new moodle_url('/user/edit.php', ['id' => $this->profileuser->id]))->out(false)
                                     : (new moodle_url('/user/editadvanced.php', ['id' => $this->profileuser->id]))->out(false)) : '';

        $preferencesurl = ($isown || has_capability('moodle/user:editprofile', $this->usercontext))
            ? (new moodle_url('/local/smartprofile/preferences.php', ['id' => $this->profileuser->id]))->out(false) : '';

        $gradesurl = ($isown || has_capability('moodle/grade:viewall', $systemcontext))
            ? (new moodle_url('/grade/report/overview/index.php', ['userid' => $this->profileuser->id]))->out(false) : '';

        $messageurl = '';
        $showmessage = false;
        if (!$isown && isloggedin() && !isguestuser() && !empty($CFG->messaging)) {
            $messageurl = (new moodle_url('/message/index.php', ['id' => $this->profileuser->id]))->out(false);
            $showmessage = true;
        }

        $showcvexport = false;
        $cvurl = '';

        // 5. Courses & Learning Journey.
        $allcourses = $this->get_courses();
        $coursescount = count($allcourses);
        $completedcoursescount = 0;
        $totalprogresssum = 0;
        foreach ($allcourses as $c) {
            if ($c['iscomplete']) {
                $completedcoursescount++;
            }
            $totalprogresssum += $c['progress'];
        }
        $overallprogress = ($coursescount > 0) ? round($totalprogresssum / $coursescount) : 0;

        // 6. Badges & Achievements.
        $allbadges = $this->get_badges();
        $badgescount = count($allbadges);
        $badgesdisplay = array_slice($allbadges, 0, 5);
        $badgesmorecount = max(0, $badgescount - 5);

        // 7. Completed Courses & Certificates.
        $completedcourses = $this->get_completed_courses($allcourses);
        $certificates = $this->get_certificates($allcourses);
        $certificatescount = count($certificates);

        // 8. Gamification Level, XP, Streak & Credit Hours Breakdown.
        $gamification = $this->get_gamification_stats($coursescount, $completedcoursescount, $badgescount);
        $credithoursbreakdown = $this->get_credithours_category_breakdown();

        // 9. Learning Performance Stats.
        $showperformance = visibility_manager::is_field_visible('performance', $this->profileuser, $this->viewer, $this->usercontext);
        $performancedata = $showperformance ? $this->get_learning_performance($overallprogress, $coursescount, $completedcoursescount) : null;

        // 10. Skills / Interests.
        $showskills = visibility_manager::is_field_visible('skills', $this->profileuser, $this->viewer, $this->usercontext);
        $skills = $showskills ? $this->get_user_skills() : [];

        // 11. Recent Activity (STRICT PRIVACY: Only visible to Owner and Staff with capability).
        // Global admin switch: showactivity.
        $showactivityenabled = (bool)(get_config('local_smartprofile', 'showactivity') ?? 1);
        $showrecentactivity = ($isown || $canviewall) && $showactivityenabled && visibility_manager::is_field_visible('activity', $this->profileuser, $this->viewer, $this->usercontext);
        $recentactivity = $showrecentactivity ? $this->get_recent_activity() : [];

        // 12. About Info (Bio & Key Metadata).
        $showabout = visibility_manager::is_field_visible('description', $this->profileuser, $this->viewer, $this->usercontext);
        $description = '';
        if ($showabout && !empty($this->profileuser->description)) {
            $description = file_rewrite_pluginfile_urls(
                $this->profileuser->description,
                'pluginfile.php',
                $this->usercontext->id,
                'user',
                'profile',
                null
            );
            $description = format_text($description, $this->profileuser->descriptionformat);
        }

        // Bio Quote (short excerpt for hero).
        $bioquote = '';
        if ($showabout && !empty($this->profileuser->description)) {
            $cleanbio = strip_tags($this->profileuser->description);
            if (strlen($cleanbio) > 160) {
                $bioquote = substr($cleanbio, 0, 157) . '...';
            } else {
                $bioquote = $cleanbio;
            }
        }

        // Contact info with privacy checks.
        $showemail = visibility_manager::is_field_visible('email', $this->profileuser, $this->viewer, $this->usercontext) && !empty($this->profileuser->email);
        $showphone = visibility_manager::is_field_visible('phone1', $this->profileuser, $this->viewer, $this->usercontext) && !empty($this->profileuser->phone1);
        $showlocation = visibility_manager::is_field_visible('city', $this->profileuser, $this->viewer, $this->usercontext);

        // Social Links.
        $sociallinks = $this->get_social_links();

        // 13. Privacy Toggles for Profile Owner.
        $toggles = [];
        if ($isown) {
            $registry = visibility_manager::get_field_registry();
            $userprefs = visibility_manager::get_user_preferences($this->profileuser->id);
            foreach ($registry as $field => $meta) {
                $currentval = $userprefs[$field] ?? $meta['default'];
                $ispublic = ($currentval === visibility_manager::VISIBILITY_PUBLIC);
                $toggles[] = [
                    'field'    => $field,
                    'ispublic' => $ispublic,
                    'icon'     => $meta['icon'],
                    'title'    => get_string($meta['title'], 'local_smartprofile'),
                    'status'   => $ispublic ? get_string('status_public', 'local_smartprofile') : get_string('status_private', 'local_smartprofile'),
                ];
            }
        }
        // 14. Faculty / Educator Profile Detection & Data.
        $facultymodeenabled = (bool)(get_config('local_smartprofile', 'enable_faculty_mode') ?? 1);
        $isassignedfacultyrole = false;
        foreach ($rolebadges as $rb) {
            if (in_array($rb['class'], ['badge-teacher', 'badge-manager', 'badge-admin'])) {
                $isassignedfacultyrole = true;
                break;
            }
        }

        $taughtcourses = $this->get_taught_courses();
        $isfaculty = $facultymodeenabled && (!empty($taughtcourses) || $isassignedfacultyrole);
        $facultydata = $isfaculty ? $this->get_faculty_profile_data($taughtcourses, $skills) : null;

        // 15. Academic Endorsements & Faculty Recommendations.
        $endorsementsenabled = (bool)(get_config('local_smartprofile', 'enable_endorsements') ?? 1);
        $endorsements = [];
        $canendorse = false;
        $sharedcourses = [];
        if ($endorsementsenabled) {
            $endorsements = \local_smartprofile\endorsement_manager::get_endorsements($this->profileuser->id, true);
            $viewerid = (int)($this->viewer->id ?? ($USER->id ?? 0));
            if ($viewerid > 0) {
                $canendorse = \local_smartprofile\endorsement_manager::can_endorse($viewerid, $this->profileuser->id);
                if ($canendorse) {
                    $sharedcourses = \local_smartprofile\endorsement_manager::get_shared_courses($viewerid, $this->profileuser->id);
                }
            }
        }

        // 16. SmartDashboard Ecosystem Interoperability.
        $dashboardenabled = (bool)(get_config('local_smartprofile', 'enable_smartdashboard_interop') ?? 1);
        $dashboardurl = '';
        if ($dashboardenabled) {
            $hasdashboard = file_exists($CFG->dirroot . '/local/smartdashboard') || \core_plugin_manager::instance()->get_plugin_info('local_smartdashboard');
            if ($hasdashboard) {
                if ($isown || $isadmin || $isfaculty) {
                    $dashboardurl = (new moodle_url('/local/smartdashboard/index.php'))->out(false);
                } else if ($canviewall) {
                    $dashboardurl = (new moodle_url('/local/smartdashboard/index.php', ['userid' => $this->profileuser->id]))->out(false);
                }
            }
        }

        // 17. Enterprise White-Labeling & Custom Styling.
        $customprimarycolor = get_config('local_smartprofile', 'custom_primary_color') ?: '';
        $customlogourl = get_config('local_smartprofile', 'custom_logo_url') ?: '';
        $customfootertagline = get_config('local_smartprofile', 'custom_footer_tagline') ?: '';
        $customcss = get_config('local_smartprofile', 'custom_css') ?: '';

        $customstylestring = '';
        if (!empty($customprimarycolor) && preg_match('/^#[0-9a-fA-F]{3,8}$/', $customprimarycolor)) {
            $customstylestring = "--sp-primary: {$customprimarycolor}; --sp-primary-hover: {$customprimarycolor};";
        }

        // 18. Theme Mode.
        $thememode = get_config('local_smartprofile', 'thememode') ?: 'auto';

        // 19. Moodle System Profile & Native Tool Links.
        $systemlinks = $this->get_moodle_system_links();

        return [
            'userid'                  => $this->profileuser->id,
            'fullname'                => fullname($this->profileuser),
            'isfaculty'               => $isfaculty,
            'faculty'                 => $facultydata,
            'showclassiclinks'        => true,
            'classic_profile_url'     => $systemlinks['classic_profile_url'],
            'course_profile_url'      => $systemlinks['course_profile_url'],
            'has_course_profile'      => $systemlinks['has_course_profile'],
            'course_name'             => $systemlinks['course_name'],
            'system_reports'          => $systemlinks['reports'],
            'has_system_reports'      => $systemlinks['has_reports'],
            'system_contributions'    => $systemlinks['contributions'],
            'has_system_contributions' => $systemlinks['has_contributions'],
            'dashboardurl'            => $dashboardurl,
            'has_dashboard'           => !empty($dashboardurl),
            'custom_logo_url'         => $customlogourl,
            'has_custom_logo'         => !empty($customlogourl),
            'custom_footer_tagline'   => $customfootertagline,
            'has_custom_footer'       => !empty($customfootertagline),
            'custom_css'              => $customcss,
            'custom_style_string'     => $customstylestring,
            'showendorsements'        => $endorsementsenabled,
            'has_endorsements'        => !empty($endorsements),
            'endorsements'            => $endorsements,
            'endorsements_count'      => count($endorsements),
            'can_write_endorsement'   => $canendorse,
            'shared_courses'          => $sharedcourses,
            'has_shared_courses'      => !empty($sharedcourses),
            'endorse_action_url'      => '',
            'sesskey'                 => sesskey(),
            'avatarurl'               => $avatarurl,
            'headline'                => $headline,
            'institution'             => $institution,
            'department'              => $department,
            'bio_quote'               => $bioquote,
            'description'             => $description,
            'has_description'         => !empty($description),
            'rolebadges'              => $rolebadges,
            'membersince'             => $membersince,
            'locationstring'          => $showlocation ? $locationstring : '',
            'has_location'            => $showlocation && !empty($locationstring),
            'email'                   => $showemail ? $this->profileuser->email : '',
            'showemail'               => $showemail,
            'phone'                   => $showphone ? $this->profileuser->phone1 : '',
            'showphone'               => $showphone,
            'website'                 => !empty($this->profileuser->url) ? $this->profileuser->url : '',
            'has_website'             => !empty($this->profileuser->url),
            'isownprofile'            => $isown,
            'canedit'                 => $canedit,
            'editurl'                 => $editurl,
            'preferencesurl'          => $preferencesurl,
            'gradesurl'               => $gradesurl,
            'showmessage'             => $showmessage,
            'messageurl'              => $messageurl,
            'cvurl'                   => $cvurl,
            'showcvexport'            => $showcvexport,
            'lastaccess'              => $this->format_time_ago($this->profileuser->lastaccess),

            // Profile Facts Ribbon (6 stats)
            'courses_count'           => $coursescount,
            'courses_completed_count' => $completedcoursescount,
            'overall_progress'        => $overallprogress,
            'certificates_count'      => $certificatescount,
            'badges_count'            => $badgescount,

            // Gamification Shield (global admin switch: showgamification).
            'showgamification'        => (bool)(get_config('local_smartprofile', 'showgamification') ?? 1),
            'gamification'            => $gamification,

            // Performance Card
            'showperformance'         => $showperformance && !empty($performancedata),
            'performance'             => $performancedata,

            // Badges & Achievements (global admin switch: showbadges).
            'showbadges'              => (bool)(get_config('local_smartprofile', 'showbadges') ?? 1)
                && !empty($CFG->enablebadges) && visibility_manager::is_field_visible('badges', $this->profileuser, $this->viewer, $this->usercontext),
            'badges'                  => $badgesdisplay,
            'has_badges'              => !empty($badgesdisplay),
            'has_more_badges'         => ($badgesmorecount > 0),
            'badges_more_count'       => $badgesmorecount,

            // Completed Courses
            'showcompletedcourses'    => visibility_manager::is_field_visible('completedcourses', $this->profileuser, $this->viewer, $this->usercontext),
            'completedcourses'        => $completedcourses,
            'has_completedcourses'    => !empty($completedcourses),

            // Certificates (Empty box ready for certificate integration)
            'showcertificates'        => visibility_manager::is_field_visible('certificates', $this->profileuser, $this->viewer, $this->usercontext),
            'certificates'            => $certificates,
            'has_certificates'        => !empty($certificates),

            // Academic Credit Hours Category Breakdown
            'credithours_breakdown'     => $credithoursbreakdown,
            'has_credithours_breakdown' => !empty($credithoursbreakdown),

            // Learning Journey (global admin switch: showcourses).
            'showcourses'             => (bool)(get_config('local_smartprofile', 'showcourses') ?? 1)
                && visibility_manager::is_field_visible('courses', $this->profileuser, $this->viewer, $this->usercontext),
            'courses'                 => $allcourses,
            'has_courses'             => !empty($allcourses),

            // Sidebar: Skills & Connect
            'showskills'              => $showskills && !empty($skills),
            'skills'                  => $skills,
            'has_skills'              => !empty($skills),
            'sociallinks'             => $sociallinks,
            'has_social'              => !empty($sociallinks),

            // Sidebar: Recent Activity (Private by default)
            'showrecentactivity'      => $showrecentactivity && !empty($recentactivity),
            'recentactivity'          => $recentactivity,

            // Privacy Controls
            'toggles'                 => $toggles,
            'thememode'               => $thememode,
            'showproupgrade'          => is_siteadmin($this->viewer),
        ];
    }

    /**
     * Gets user roles formatted as badges and sorted by priority:
     * admin (100) > manager (90) > teacher (80) > student (50) > parent (30)
     *
     * @return array
     */
    protected function get_user_roles(): array {
        global $DB;
        $roles = [];

        if (is_siteadmin($this->profileuser)) {
            $roles[] = [
                'name'     => get_string('administrator'),
                'class'    => 'badge-admin',
                'priority' => 100,
            ];
        }

        $sql = "SELECT DISTINCT r.id, r.name, r.shortname, r.archetype
                  FROM {role_assignments} ra
                  JOIN {role} r ON r.id = ra.roleid
                 WHERE ra.userid = :userid";
        $assignedroles = $DB->get_records_sql($sql, ['userid' => $this->profileuser->id]);

        foreach ($assignedroles as $r) {
            $displayname = role_get_name($r);
            $class = 'badge-role';
            $priority = 10;

            if ($r->shortname === 'manager' || $r->archetype === 'manager') {
                $class = 'badge-manager';
                $priority = 90;
            } else if ($r->shortname === 'editingteacher' || $r->shortname === 'teacher' || $r->archetype === 'editingteacher' || $r->archetype === 'teacher') {
                $class = 'badge-teacher';
                $priority = 80;
            } else if ($r->shortname === 'coursecreator') {
                $class = 'badge-teacher';
                $priority = 75;
            } else if ($r->shortname === 'student' || $r->archetype === 'student') {
                $class = 'badge-student';
                $priority = 50;
            } else if (in_array($r->shortname, ['parent', 'mentor', 'guardian', 'supervisor'])) {
                $class = 'badge-role';
                $priority = 30;
            }

            $roles[] = [
                'name'     => $displayname,
                'class'    => $class,
                'priority' => $priority,
            ];
        }

        // Sort roles descending by priority (highest first).
        usort($roles, function ($a, $b) {
            return $b['priority'] <=> $a['priority'];
        });

        return $roles;
    }

    /**
     * Gets enrolled courses with progress.
     *
     * @return array
     */
    protected function get_courses(): array {
        global $CFG;
        require_once($CFG->libdir . '/enrollib.php');

        $isown = ($this->viewer->id == $this->profileuser->id);
        $allcourses = enrol_get_all_users_courses($this->profileuser->id, true, 'id, fullname, shortname, summary, visible');

        $courses = [];
        foreach ($allcourses as $course) {
            if ($course->id == SITEID) {
                continue;
            }

            if (!$isown && !$course->visible) {
                $coursecontext = \context_course::instance($course->id);
                if (!has_capability('moodle/course:viewhiddencourses', $coursecontext)) {
                    continue;
                }
            }

            $progress = null;
            if ($isown || has_capability('moodle/grade:viewall', \context_course::instance($course->id))) {
                if (class_exists('\core_completion\progress')) {
                    $progress = \core_completion\progress::get_course_progress_percentage($course, $this->profileuser->id);
                }
            }

            $hasprogress = ($progress !== null);
            $progressval = $hasprogress ? round($progress) : 0;
            $iscomplete = ($progressval >= 100);

            $courseimage = '';
            if (class_exists('\core_course\external\course_summary_exporter')) {
                $courseimage = \core_course\external\course_summary_exporter::get_course_image($course) ?: '';
            }

            $courses[] = [
                'id'           => $course->id,
                'fullname'     => format_string($course->fullname),
                'shortname'    => format_string($course->shortname),
                'progress'     => $progressval,
                'hasprogress'  => $hasprogress,
                'iscomplete'   => $iscomplete,
                'status_text'  => $iscomplete ? get_string('completed', 'local_smartprofile') : get_string('inprogress', 'moodle', 'In Progress'),
                'status_class' => $iscomplete ? 'status-completed' : 'status-inprogress',
                'url'          => (new moodle_url('/course/view.php', ['id' => $course->id]))->out(false),
                'imageurl'     => $courseimage,
            ];
        }

        return $courses;
    }

    /**
     * Gets earned badges.
     *
     * @return array
     */
    protected function get_badges(): array {
        global $CFG;
        require_once($CFG->libdir . '/badgeslib.php');

        if (empty($CFG->enablebadges)) {
            return [];
        }

        $userbadges = badges_get_user_badges($this->profileuser->id);
        $badges = [];
        $colors = ['badge-color-gold', 'badge-color-purple', 'badge-color-blue', 'badge-color-bronze', 'badge-color-amber'];
        $i = 0;

        foreach ($userbadges as $b) {
            $badgeurl = moodle_url::make_pluginfile_url(
                \context_system::instance()->id,
                'badges',
                'badgeimage',
                $b->id,
                '/',
                'f1',
                false
            )->out(false);

            $badges[] = [
                'id'          => $b->id,
                'name'        => format_string($b->name),
                'description' => format_text($b->description, FORMAT_HTML),
                'imageurl'    => $badgeurl,
                'dateissued'  => userdate($b->dateissued, '%b %d, %Y'),
                'badgeurl'    => (new moodle_url('/badges/badge.php', ['hash' => $b->uniquehash]))->out(false),
                'colorclass'  => $colors[$i % count($colors)],
            ];
            $i++;
        }

        return $badges;
    }

    /**
     * Gets completed courses list for showcase.
     *
     * @param array $courses
     * @return array
     */
    protected function get_completed_courses(array $courses): array {
        global $DB, $SITE;
        $completedcourses = [];

        // Pre-fetch course completion dates if available.
        $completiontimes = [];
        $courseids = [];
        foreach ($courses as $c) {
            if ($c['iscomplete']) {
                $courseids[] = $c['id'];
            }
        }

        if (!empty($courseids)) {
            [$insql, $params] = $DB->get_in_or_equal($courseids, SQL_PARAMS_NAMED);
            $params['userid'] = $this->profileuser->id;
            $records = $DB->get_records_select(
                'course_completions',
                "userid = :userid AND course $insql AND timecompleted IS NOT NULL",
                $params,
                '',
                'course, timecompleted'
            );
            foreach ($records as $rec) {
                $completiontimes[$rec->course] = $rec->timecompleted;
            }
        }

        foreach ($courses as $c) {
            if ($c['iscomplete']) {
                $timecompleted = $completiontimes[$c['id']] ?? time();
                $completedcourses[] = [
                    'id'           => $c['id'],
                    'title'        => $c['fullname'],
                    'shortname'    => $c['shortname'],
                    'issued_date'  => userdate($timecompleted, '%b %d, %Y'),
                    'url'          => $c['url'],
                    'institution'  => $this->profileuser->institution ?: ($this->profileuser->department ?: $SITE->fullname),
                    'colorclass'   => 'cert-color-gold',
                ];
            }
        }

        return $completedcourses;
    }

    /**
     * Gets certificates / credentials list.
     *
     * @param array $courses
     * @return array
     */
    protected function get_certificates(array $courses): array {
        // Prepared for certificate integration (empty by default until configured).
        $certificates = [];

        return $certificates;
    }

    /**
     * Gets gamification & rewards metrics (Trophies, Points, Shield data).
     *
     * @param int $coursescount
     * @param int $completedcourses
     * @param int $badgescount
     * @return array
     */
    protected function get_gamification_stats(int $coursescount, int $completedcourses, int $badgescount): array {
        global $CFG, $DB;

        $totaltrophiesearned = 0;
        $totalpointsearned = 0;
        $totalcredithoursearned = 0.0;

        // 1. Fetch lifetime rewards earned from enrol_trophy_rewards or enrol_credit_rewards table.
        if ($DB->get_manager()->table_exists('enrol_trophy_rewards')) {
            $totaltrophiesearned = (int)$DB->count_records('enrol_trophy_rewards', [
                'userid'     => $this->profileuser->id,
                'rewardtype' => 'medal',
            ]);

            $totalpointsearned = (int)$DB->get_field_sql(
                "SELECT SUM(credits) FROM {enrol_trophy_rewards} WHERE userid = :uid AND rewardtype = 'points'",
                ['uid' => $this->profileuser->id]
            );

            $totalcredithoursearned = (float)$DB->get_field_sql(
                "SELECT SUM(credits) FROM {enrol_trophy_rewards} WHERE userid = :uid AND rewardtype = 'credithours'",
                ['uid' => $this->profileuser->id]
            );
        } else if ($DB->get_manager()->table_exists('enrol_credit_rewards')) {
            $totaltrophiesearned = (int)$DB->count_records('enrol_credit_rewards', [
                'userid'     => $this->profileuser->id,
                'rewardtype' => 'medal',
            ]);

            $totalpointsearned = (int)$DB->get_field_sql(
                "SELECT SUM(credits) FROM {enrol_credit_rewards} WHERE userid = :uid AND rewardtype = 'points'",
                ['uid' => $this->profileuser->id]
            );
        }

        // 2. Query current wallet balances to ensure at least current balance is honored.
        $currpoints = 0;
        $currtrophies = 0;
        $currcredithours = 0.0;
        if ($DB->get_manager()->table_exists('enrol_trophy_balances')) {
            $currpoints = (int)$DB->get_field_sql(
                "SELECT SUM(balance) FROM {enrol_trophy_balances} WHERE userid = :uid AND currencytype = 'points'",
                ['uid' => $this->profileuser->id]
            );
            $currcredithours = (float)$DB->get_field_sql(
                "SELECT SUM(balance) FROM {enrol_trophy_balances} WHERE userid = :uid AND currencytype = 'credithours'",
                ['uid' => $this->profileuser->id]
            );
            $currtrophies = (int)$DB->get_field_sql(
                "SELECT SUM(balance) FROM {enrol_trophy_balances} WHERE userid = :uid AND currencytype NOT IN ('points', 'credithours')",
                ['uid' => $this->profileuser->id]
            );
        } else if ($DB->get_manager()->table_exists('enrol_credit_balances')) {
            $currpoints = (int)$DB->get_field_sql(
                "SELECT SUM(balance) FROM {enrol_credit_balances} WHERE userid = :uid AND currencytype = 'points'",
                ['uid' => $this->profileuser->id]
            );
            $currtrophies = (int)$DB->get_field_sql(
                "SELECT SUM(balance) FROM {enrol_credit_balances} WHERE userid = :uid AND currencytype != 'points'",
                ['uid' => $this->profileuser->id]
            );
        }

        // Check fallback user profile field for credits / trophies.
        if ($currpoints === 0 && $totalpointsearned === 0) {
            $field = $DB->get_record('user_info_field', ['shortname' => 'my_trophy']);
            if (!$field) {
                $field = $DB->get_record('user_info_field', ['shortname' => 'my_credit']);
            }
            if ($field) {
                $raw = $DB->get_field('user_info_data', 'data', [
                    'userid' => $this->profileuser->id,
                    'fieldid' => $field->id,
                ]);
                if (is_numeric($raw)) {
                    $currpoints = (int)$raw;
                }
            }
        }

        // Showcase reflects total lifetime trophies, points and credit hours obtained.
        $totaltrophies = max($totaltrophiesearned, $currtrophies);
        $totalpoints = max($totalpointsearned, $currpoints);
        $totalcredithours = max($totalcredithoursearned, $currcredithours);

        $walleturl = '';
        if (file_exists($CFG->dirroot . '/enrol/trophy/wallet.php')) {
            $walleturl = (new moodle_url('/enrol/trophy/wallet.php', ['userid' => $this->profileuser->id]))->out(false);
        } else if (file_exists($CFG->dirroot . '/enrol/credit/wallet.php')) {
            $walleturl = (new moodle_url('/enrol/credit/wallet.php', ['userid' => $this->profileuser->id]))->out(false);
        }

        $trophies_label = ($totaltrophies === 1)
            ? get_string('trophy_singular', 'local_smartprofile')
            : get_string('trophies_plural', 'local_smartprofile', $totaltrophies);

        $points_display = number_format($totalpoints) . ' ' . get_string('points_label', 'local_smartprofile');

        $credithours_formatted = rtrim(rtrim(number_format($totalcredithours, 2, '.', ''), '0'), '.');
        $credithours_display = get_string('credithours_display', 'local_smartprofile', $credithours_formatted);

        $sharedata = $this->generate_share_links('total', 0, $credithours_formatted, '', $totaltrophies);

        return [
            'totaltrophies'        => $totaltrophies,
            'totalpoints'          => $totalpoints,
            'totalcredithours'     => $totalcredithours,
            'hascredithours'       => ($totalcredithours > 0),
            'trophies_label'       => $trophies_label,
            'points_display'       => $points_display,
            'credithours_display'  => $credithours_display,
            'walleturl'            => $walleturl,
            'share'                => $sharedata,
            'has_share'            => !empty($sharedata),
        ];
    }

    /**
     * Retrieves the hierarchical category breakdown of academic credit hours for the profile user.
     *
     * @return array List of top-level category objects with aggregated hours and subcategory items.
     */
    protected function get_credithours_category_breakdown(): array {
        global $DB;

        // Check if trophy tables exist.
        if (
            !$DB->get_manager()->table_exists('enrol_trophy_rewards') &&
            !$DB->get_manager()->table_exists('enrol_trophy_balances')
        ) {
            return [];
        }

        // 1. Gather hours per exact categoryid.
        $catcredits = [];

        if ($DB->get_manager()->table_exists('enrol_trophy_rewards')) {
            $rewards = $DB->get_records_sql(
                "SELECT categoryid, SUM(credits) AS totalcredits
                   FROM {enrol_trophy_rewards}
                  WHERE userid = :uid AND rewardtype = 'credithours'
               GROUP BY categoryid",
                ['uid' => $this->profileuser->id]
            );
            foreach ($rewards as $rec) {
                $cid = (int)$rec->categoryid;
                $catcredits[$cid] = (float)$rec->totalcredits;
            }
        }

        // Top-up or fallback with direct category balances.
        if ($DB->get_manager()->table_exists('enrol_trophy_balances')) {
            $balances = $DB->get_records_sql(
                "SELECT categoryid, balance
                   FROM {enrol_trophy_balances}
                  WHERE userid = :uid AND currencytype = 'credithours'",
                ['uid' => $this->profileuser->id]
            );
            foreach ($balances as $rec) {
                $cid = (int)$rec->categoryid;
                $bal = (float)$rec->balance;
                if (!isset($catcredits[$cid])) {
                    $catcredits[$cid] = $bal;
                } else {
                    $catcredits[$cid] = max($catcredits[$cid], $bal);
                }
            }
        }

        // Filter out zero or negative hours.
        $catcredits = array_filter($catcredits, function ($amount) {
            return $amount > 0;
        });

        if (empty($catcredits)) {
            return [];
        }

        // 2. Map each category to its root (top-level) category in Moodle.
        $parents = [];

        foreach ($catcredits as $cid => $hours) {
            if ($cid <= 0) {
                // Universal / Global category.
                $rootid = 0;
                $rootname = get_string('general', 'core');
                if (!isset($parents[$rootid])) {
                    $parents[$rootid] = [
                        'parent_id'   => $rootid,
                        'parent_name' => $rootname,
                        'total'       => 0.0,
                        'subcats'     => [],
                    ];
                }
                $parents[$rootid]['total'] += $hours;
                $parents[$rootid]['subcats'][$cid] = [
                    'name'  => $rootname,
                    'hours' => $hours,
                ];
                continue;
            }

            $cat = \core_course_category::get($cid, IGNORE_MISSING);
            if (!$cat) {
                $rootid = $cid;
                $rootname = get_string('category', 'core') . ' ' . $cid;
                if (!isset($parents[$rootid])) {
                    $parents[$rootid] = [
                        'parent_id'   => $rootid,
                        'parent_name' => $rootname,
                        'total'       => 0.0,
                        'subcats'     => [],
                    ];
                }
                $parents[$rootid]['total'] += $hours;
                $parents[$rootid]['subcats'][$cid] = [
                    'name'  => $rootname,
                    'hours' => $hours,
                ];
                continue;
            }

            // If category has parents, find the top-level root ancestor.
            $ancestors = $cat->get_parents();
            if (empty($ancestors)) {
                // This category is already a root parent (parent == 0).
                $rootid = $cat->id;
                $rootname = format_string($cat->name);
                if (!isset($parents[$rootid])) {
                    $parents[$rootid] = [
                        'parent_id'   => $rootid,
                        'parent_name' => $rootname,
                        'total'       => 0.0,
                        'subcats'     => [],
                    ];
                }
                $parents[$rootid]['total'] += $hours;
                if (!isset($parents[$rootid]['subcats'][$cid])) {
                    $parents[$rootid]['subcats'][$cid] = [
                        'name'  => format_string($cat->name),
                        'hours' => $hours,
                    ];
                } else {
                    $parents[$rootid]['subcats'][$cid]['hours'] += $hours;
                }
            } else {
                // First ancestor in $ancestors array is the top-most root category.
                $rootancestorid = (int)reset($ancestors);
                $rootcat = \core_course_category::get($rootancestorid, IGNORE_MISSING);
                $rootname = $rootcat ? format_string($rootcat->name) : format_string($cat->name);
                $rootid = $rootcat ? $rootcat->id : $cat->id;

                if (!isset($parents[$rootid])) {
                    $parents[$rootid] = [
                        'parent_id'   => $rootid,
                        'parent_name' => $rootname,
                        'total'       => 0.0,
                        'subcats'     => [],
                    ];
                }
                $parents[$rootid]['total'] += $hours;
                $parents[$rootid]['subcats'][$cid] = [
                    'name'  => format_string($cat->name),
                    'hours' => $hours,
                ];
            }
        }

        // 3. Format into template-friendly array.
        $breakdown = [];
        foreach ($parents as $pdata) {
            $totalformatted = rtrim(rtrim(number_format($pdata['total'], 2, '.', ''), '0'), '.');
            $subcatlist = [];
            $showsubcats = false;

            // If there are multiple subcategories, or the single subcategory is not identical to the root parent name.
            if (count($pdata['subcats']) > 1 || (count($pdata['subcats']) === 1 && reset($pdata['subcats'])['name'] !== $pdata['parent_name'])) {
                $showsubcats = true;
                foreach ($pdata['subcats'] as $sub) {
                    $subhoursformatted = rtrim(rtrim(number_format($sub['hours'], 2, '.', ''), '0'), '.');
                    $pct = ($pdata['total'] > 0) ? round(($sub['hours'] / $pdata['total']) * 100) : 100;
                    $subcatlist[] = [
                        'name'       => $sub['name'],
                        'hours'      => get_string('credithours_display', 'local_smartprofile', $subhoursformatted),
                        'raw_hours'  => $subhoursformatted,
                        'percentage' => $pct,
                    ];
                }
            }

            $sharedata = $this->generate_share_links('category', (int)$pdata['parent_id'], $totalformatted, $pdata['parent_name']);

            $breakdown[] = [
                'parent_id'         => $pdata['parent_id'],
                'parent_name'       => $pdata['parent_name'],
                'total_hours'       => get_string('credithours_display', 'local_smartprofile', $totalformatted),
                'raw_total'         => $totalformatted,
                'has_subcategories' => $showsubcats,
                'subcategories'     => $subcatlist,
                'share'             => $sharedata,
                'has_share'         => !empty($sharedata),
            ];
        }

        return $breakdown;
    }

    /**
     * Generates social and LinkedIn sharing payloads for academic achievements.
     *
     * @param string $scope 'total' or 'category'
     * @param int $categoryid Course category ID (0 for total)
     * @param string $hours Formatted credit hours string
     * @param string $categoryname Name of category
     * @param int $trophies Number of trophies earned
     * @return array|null Sharing URLs and modal payload or null if sharing disabled.
     */
    protected function generate_share_links(string $scope, int $categoryid, string $hours, string $categoryname = '', int $trophies = 0): ?array {
        global $SITE;

        $showshare = (int)(get_config('local_smartprofile', 'show_shareonlinkedin') ?? 1);
        if ($showshare === 0) {
            return null;
        }

        $issuername = get_config('local_smartprofile', 'issuer_name') ?: $SITE->fullname;
        $hash = substr(sha1($this->profileuser->id . '_' . $categoryid . '_' . get_site_identifier()), 0, 16);

        if ($showshare === 2) {
            $verifyurl = (new moodle_url('/local/smartprofile/index.php', ['id' => $this->profileuser->id]))->out(false);
        } else {
            $verifyurl = (new moodle_url('/local/smartprofile/verify.php', [
                'id'  => $this->profileuser->id,
                'cat' => $categoryid,
                'h'   => $hash,
            ]))->out(false);
        }

        $credentialid = 'SL-CH-' . $this->profileuser->id . '-' . $categoryid . '-' . strtoupper(substr($hash, 0, 8));

        if ($scope === 'total') {
            $certname = $issuername . ' - ' . get_string('overallprogress', 'local_smartprofile') . ' (' . $hours . ' ' . get_string('credithours', 'local_smartprofile') . ')';
            $posta = (object)[
                'credits'  => $hours . ' ' . get_string('credithours', 'local_smartprofile'),
                'trophies' => $trophies . ' ' . get_string('trophies', 'local_smartprofile'),
                'site'     => $issuername,
                'url'      => $verifyurl,
            ];
            $posttext = get_string('share_total_msg', 'local_smartprofile', $posta);
        } else {
            $certname = $issuername . ' - ' . $categoryname . ' (' . $hours . ' ' . get_string('credithours', 'local_smartprofile') . ')';
            $posta = (object)[
                'credits'  => $hours . ' ' . get_string('credithours', 'local_smartprofile'),
                'category' => $categoryname,
                'site'     => $issuername,
                'url'      => $verifyurl,
            ];
            $posttext = get_string('share_cat_msg', 'local_smartprofile', $posta);
        }

        // LinkedIn Add to Profile URL params.
        $linkedinparams = [
            'startTask'  => 'CERTIFICATION_NAME',
            'name'       => $certname,
            'issueYear'  => date('Y'),
            'issueMonth' => date('n'),
            'certId'     => $credentialid,
            'certUrl'    => $verifyurl,
        ];

        $orgid = get_config('local_smartprofile', 'linkedin_org_id');
        if (empty($orgid)) {
            $orgid = get_config('tool_certificate', 'linkedinorganizationid');
        }
        if (!empty($orgid)) {
            $linkedinparams['organizationId'] = $orgid;
        } else {
            $linkedinparams['organizationName'] = $issuername;
        }

        $linkedinaddurl = (new moodle_url('https://www.linkedin.com/profile/add', $linkedinparams))->out(false);
        $linkedinposturl = 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($verifyurl);
        $xurl = 'https://twitter.com/intent/tweet?text=' . urlencode($posttext);
        $whatsappurl = 'https://api.whatsapp.com/send?text=' . urlencode($posttext);
        $facebookurl = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($verifyurl);

        $walletpassurl = '';
        $obv3url = '';

        return [
            'can_share'         => true,
            'verify_url'        => $verifyurl,
            'credential_id'     => $credentialid,
            'wallet_pass_url'   => $walletpassurl,
            'obv3_url'          => $obv3url,
            'linkedin_add_url'  => $linkedinaddurl,
            'linkedin_post_url' => $linkedinposturl,
            'x_url'             => $xurl,
            'whatsapp_url'      => $whatsappurl,
            'facebook_url'      => $facebookurl,
            'post_text'         => $posttext,
            'share_title'       => $certname,
        ];
    }

    /**
     * Gets learning performance metrics from real user data only.
     *
     * Returns null when there is no real data to display so the
     * section can be hidden entirely.
     *
     * @param int $overallprogress
     * @param int $coursescount
     * @param int $completedcourses
     * @return array|null
     */
    protected function get_learning_performance(int $overallprogress, int $coursescount, int $completedcourses): ?array {
        global $DB;

        // Average Grade (real grades only).
        $sql = "SELECT AVG(gg.finalgrade / gi.grademax * 100) as avggrade
                  FROM {grade_grades} gg
                  JOIN {grade_items} gi ON gi.id = gg.itemid
                 WHERE gg.userid = :userid
                   AND gi.itemtype = 'course'
                   AND gg.finalgrade IS NOT NULL
                   AND gi.grademax > 0";
        $graderec = $DB->get_record_sql($sql, ['userid' => $this->profileuser->id]);
        $hasavggrade = ($graderec && $graderec->avggrade !== null);
        $avggrade = $hasavggrade ? round($graderec->avggrade) . '%' : '';

        // Activities completed count (real completions only).
        $activitiescount = $DB->count_records_select(
            'course_modules_completion',
            'userid = :userid AND completionstate > 0',
            ['userid' => $this->profileuser->id]
        );

        // Nothing real to show.
        if (!$hasavggrade && $activitiescount == 0 && $overallprogress == 0) {
            return null;
        }

        return [
            'overall_progress'      => $overallprogress,
            'average_grade'         => $avggrade,
            'has_average_grade'     => $hasavggrade,
            'activities_completed'  => $activitiescount,
            'has_activities'        => ($activitiescount > 0),
        ];
    }

    /**
     * Gets user skills / tags.
     *
     * @return array
     */
    protected function get_user_skills(): array {
        $skills = [];
        if (core_tag_tag::is_enabled('core', 'user')) {
            $tags = core_tag_tag::get_item_tags('core', 'user', $this->profileuser->id);
            foreach ($tags as $tag) {
                $skills[] = [
                    'name' => $tag->get_display_name(),
                    'url'  => (new moodle_url('/tag/index.php', ['tag' => $tag->rawname]))->out(false),
                ];
            }
        }

        return $skills;
    }

    /**
     * Gets recent activity timeline from real user data.
     *
     * Combines recently earned badges and completed courses, sorted by date.
     * Returns an empty array when there is no real activity to show.
     *
     * @return array
     */
    protected function get_recent_activity(): array {
        global $CFG, $DB;

        $items = [];

        // Recently earned badges.
        if (!empty($CFG->enablebadges)) {
            $badgeissues = $DB->get_records_sql(
                "SELECT bi.dateissued, b.name
                   FROM {badge_issued} bi
                   JOIN {badge} b ON b.id = bi.badgeid
                  WHERE bi.userid = :uid
               ORDER BY bi.dateissued DESC",
                ['uid' => $this->profileuser->id],
                0,
                5
            );
            foreach ($badgeissues as $issue) {
                $items[] = [
                    'icon'    => 'fa-award',
                    'color'   => 'activity-gold',
                    'title'   => get_string('activity_badge_earned', 'local_smartprofile', format_string($issue->name)),
                    'timeago' => '',
                    '_time'   => (int)$issue->dateissued,
                ];
            }
        }

        // Recently completed courses.
        $completions = $DB->get_records_sql(
            "SELECT cc.timecompleted, c.fullname
               FROM {course_completions} cc
               JOIN {course} c ON c.id = cc.course
              WHERE cc.userid = :uid AND cc.timecompleted IS NOT NULL
           ORDER BY cc.timecompleted DESC",
            ['uid' => $this->profileuser->id],
            0,
            5
        );

        foreach ($completions as $comp) {
            $items[] = [
                'icon'    => 'fa-graduation-cap',
                'color'   => 'activity-purple',
                'title'   => get_string('activity_course_completed', 'local_smartprofile', format_string($comp->fullname)),
                'timeago' => '',
                '_time'   => (int)$comp->timecompleted,
            ];
        }

        // Sort by real timestamp descending and keep the most recent entries.
        usort($items, function ($a, $b) {
            return $b['_time'] <=> $a['_time'];
        });
        $items = array_slice($items, 0, 6);

        // Format human-readable relative time.
        foreach ($items as &$item) {
            $item['timeago'] = $this->format_time_ago($item['_time']);
            unset($item['_time']);
        }

        return $items;
    }

    /**
     * Gets social & web links.
     *
     * @return array
     */
    protected function get_social_links(): array {
        $links = [];
        if (!empty($this->profileuser->url)) {
            $links[] = ['icon' => 'fa-globe', 'url' => $this->profileuser->url, 'name' => get_string('website', 'local_smartprofile')];
        }

        return $links;
    }

    /**
     * Helper to format last access nicely.
     *
     * @param int $timestamp
     * @return string
     */
    protected function format_time_ago(int $timestamp): string {
        if (empty($timestamp)) {
            return get_string('never');
        }

        $diff = time() - $timestamp;

        if ($diff < 60) {
            return get_string('justnow', 'local_smartprofile');
        } else if ($diff < 3600) {
            $mins = max(1, round($diff / 60));
            return get_string('minutesago', 'local_smartprofile', $mins);
        } else if ($diff < 86400) {
            $hours = max(1, round($diff / 3600));
            return get_string('hoursago', 'local_smartprofile', $hours);
        } else if ($diff < 604800) {
            $days = max(1, round($diff / 86400));
            return get_string('daysago', 'local_smartprofile', $days);
        }

        return userdate($timestamp, '%b %d, %Y');
    }

    /**
     * Helper to read a user preference or custom user profile field seamlessly.
     *
     * @param string $shortname
     * @param string $default
     * @return string
     */
    protected function get_user_field_or_pref(string $shortname, string $default = ''): string {
        global $DB;
        // 1. Check User Preference.
        $pref = get_user_preferences('local_smartprofile_' . $shortname, null, $this->profileuser->id);
        if ($pref !== null && $pref !== '') {
            return (string)$pref;
        }
        // 2. Check Custom User Profile Field.
        $field = $DB->get_record('user_info_field', ['shortname' => $shortname]);
        if ($field) {
            $val = $DB->get_field('user_info_data', 'data', ['userid' => $this->profileuser->id, 'fieldid' => $field->id]);
            if ($val !== false && $val !== null && $val !== '') {
                return (string)$val;
            }
        }
        return $default;
    }

    /**
     * Retrieves all active courses taught or managed by the profile user.
     *
     * @return array
     */
    protected function get_taught_courses(): array {
        global $DB, $CFG;
        require_once($CFG->libdir . '/enrollib.php');

        $sql = "SELECT DISTINCT c.id, c.fullname, c.shortname, c.summary, c.summaryformat, c.visible, c.category, c.timecreated
                  FROM {course} c
                  JOIN {context} ctx ON ctx.instanceid = c.id AND ctx.contextlevel = " . CONTEXT_COURSE . "
                  JOIN {role_assignments} ra ON ra.contextid = ctx.id
                  JOIN {role} r ON r.id = ra.roleid
                 WHERE ra.userid = :userid
                   AND (r.archetype IN ('editingteacher', 'teacher', 'coursecreator', 'manager')
                        OR r.shortname IN ('editingteacher', 'teacher', 'coursecreator', 'manager', 'professor', 'instructor', 'tutor'))
                   AND c.id != :siteid
              ORDER BY c.visible DESC, c.fullname ASC";

        $records = $DB->get_records_sql($sql, [
            'userid' => $this->profileuser->id,
            'siteid' => SITEID,
        ]);

        if (empty($records)) {
            return [];
        }

        $taught = [];
        $isown = ($this->viewer->id == $this->profileuser->id);

        foreach ($records as $course) {
            if (!$isown && !$course->visible) {
                $coursecontext = \context_course::instance($course->id);
                if (!has_capability('moodle/course:viewhiddencourses', $coursecontext, $this->viewer)) {
                    continue;
                }
            }

            // Student count in this course.
            $studentcount = (int)$DB->get_field_sql(
                "SELECT COUNT(DISTINCT ra.userid)
                   FROM {role_assignments} ra
                   JOIN {role} r ON r.id = ra.roleid
                   JOIN {context} ctx ON ctx.id = ra.contextid AND ctx.contextlevel = " . CONTEXT_COURSE . "
                  WHERE ctx.instanceid = :courseid
                    AND (r.archetype = 'student' OR r.shortname = 'student')",
                ['courseid' => $course->id]
            );

            // Course image.
            $courseimage = '';
            if (class_exists('\core_course\external\course_summary_exporter')) {
                $courseimage = \core_course\external\course_summary_exporter::get_course_image($course) ?: '';
            }

            // Category name.
            $catname = '';
            if (!empty($course->category)) {
                $cat = \core_course_category::get($course->category, IGNORE_MISSING);
                if ($cat) {
                    $catname = format_string($cat->name);
                }
            }

            $taught[] = [
                'id'           => $course->id,
                'fullname'     => format_string($course->fullname),
                'shortname'    => format_string($course->shortname),
                'category'     => $catname,
                'summary'      => format_text($course->summary, $course->summaryformat),
                'studentcount' => $studentcount,
                'url'          => (new moodle_url('/course/view.php', ['id' => $course->id]))->out(false),
                'imageurl'     => $courseimage,
                'visible'      => (bool)$course->visible,
            ];
        }

        return $taught;
    }

    /**
     * Compiles academic research, office hours, and faculty metrics.
     *
     * @param array $taughtcourses
     * @param array $skills
     * @return array
     */
    protected function get_faculty_profile_data(array $taughtcourses, array $skills): array {
        global $DB;

        $taughtcount = count($taughtcourses);
        $courseids = array_map(function ($c) {
            return $c['id'];
        }, $taughtcourses);
        $totalstudents = 0;
        $disciplines = [];

        if (!empty($courseids)) {
            [$insql, $params] = $DB->get_in_or_equal($courseids, SQL_PARAMS_NAMED);
            $totalstudents = (int)$DB->get_field_sql(
                "SELECT COUNT(DISTINCT ra.userid)
                   FROM {role_assignments} ra
                   JOIN {role} r ON r.id = ra.roleid
                   JOIN {context} ctx ON ctx.id = ra.contextid AND ctx.contextlevel = " . CONTEXT_COURSE . "
                  WHERE ctx.instanceid $insql
                    AND (r.archetype = 'student' OR r.shortname = 'student')",
                $params
            );

            foreach ($taughtcourses as $tc) {
                if (!empty($tc['category'])) {
                    $disciplines[$tc['category']] = true;
                }
            }
        }

        $disciplinescount = count($disciplines);

        // Academic tenure / years active.
        $created = $this->profileuser->timecreated ?: (time() - 31536000);
        $yearsactive = max(1, (int)round((time() - $created) / (365.25 * 86400)));
        $tenurestring = ($yearsactive === 1)
            ? get_string('tenure_year_single', 'local_smartprofile')
            : get_string('tenure_years_plural', 'local_smartprofile', $yearsactive);

        // Office hours & consultation booking.
        $officehours = $this->get_user_field_or_pref('officehours', '');
        $bookingurl = $this->get_user_field_or_pref('bookingurl', '');
        $officelocation = $this->get_user_field_or_pref('officelocation', '');

        // Academic Research profiles.
        $orcid = $this->get_user_field_or_pref('orcid', '');
        $googlescholar = $this->get_user_field_or_pref('googlescholar', '');
        $researchgate = $this->get_user_field_or_pref('researchgate', '');

        $hasresearchlinks = !empty($orcid) || !empty($googlescholar) || !empty($researchgate) || !empty($this->profileuser->url);
        $hasofficehours = !empty($officehours) || !empty($bookingurl) || !empty($officelocation);

        return [
            'taughtcourses'             => $taughtcourses,
            'has_taughtcourses'         => ($taughtcount > 0),
            'taughtcourses_count'       => $taughtcount,
            'total_students_instructed' => number_format($totalstudents),
            'disciplines_count'         => max(1, $disciplinescount),
            'tenure_string'             => $tenurestring,
            'officehours'               => $officehours,
            'bookingurl'                => $bookingurl,
            'officelocation'            => $officelocation,
            'has_officehours'           => $hasofficehours,
            'has_bookingurl'            => !empty($bookingurl),
            'orcid'                     => $orcid,
            'orcid_url'                 => !empty($orcid) ? (strpos($orcid, 'http') === 0 ? $orcid : ('https://orcid.org/' . $orcid)) : '',
            'googlescholar'             => $googlescholar,
            'researchgate'              => $researchgate,
            'has_research_links'        => $hasresearchlinks,
            'research_interests'        => $skills,
            'has_research_interests'    => !empty($skills),
        ];
    }

    /**
     * Retrieves native Moodle system profile and report links.
     *
     * @return array
     */
    protected function get_moodle_system_links(): array {
        global $CFG, $DB;

        $userid = (int)$this->profileuser->id;
        $courseid = (int)$this->courseid;
        $isown = ($this->viewer->id == $this->profileuser->id);
        $isadmin = is_siteadmin($this->viewer);
        $canviewreports = $isadmin || $isown || has_capability('moodle/user:viewuseractivitiesreport', $this->usercontext, $this->viewer);

        $classicprofileurl = (new \moodle_url('/user/profile.php', ['id' => $userid, 'classic' => 1]))->out(false);

        $courseprofileurl = '';
        $coursename = '';
        if ($courseid > 1) {
            $course = $DB->get_record('course', ['id' => $courseid], 'id, fullname, shortname');
            if ($course) {
                $courseprofileurl = (new \moodle_url('/user/view.php', ['id' => $userid, 'course' => $courseid, 'classic' => 1]))->out(false);
                $coursename = format_string($course->fullname);
            }
        }

        // Reports list.
        $reports = [];
        if ($canviewreports) {
            $logparams = ['id' => $userid];
            if ($courseid > 1) {
                $logparams['course'] = $courseid;
            } else {
                $logparams['course'] = SITEID;
            }

            $reports[] = [
                'title' => get_string('todays_logs', 'local_smartprofile'),
                'url'   => (new \moodle_url('/report/log/user.php', array_merge($logparams, ['mode' => 'today'])))->out(false),
                'icon'  => 'fa-clock',
            ];
            $reports[] = [
                'title' => get_string('all_logs', 'local_smartprofile'),
                'url'   => (new \moodle_url('/report/log/user.php', array_merge($logparams, ['mode' => 'all'])))->out(false),
                'icon'  => 'fa-list-check',
            ];
            $reports[] = [
                'title' => get_string('outline_report', 'local_smartprofile'),
                'url'   => (new \moodle_url('/report/outline/user.php', array_merge($logparams, ['mode' => 'outline'])))->out(false),
                'icon'  => 'fa-chart-line',
            ];
            $reports[] = [
                'title' => get_string('complete_report', 'local_smartprofile'),
                'url'   => (new \moodle_url('/report/outline/user.php', array_merge($logparams, ['mode' => 'complete'])))->out(false),
                'icon'  => 'fa-file-lines',
            ];
            $reports[] = [
                'title' => get_string('grades', 'core'),
                'url'   => (new \moodle_url('/grade/report/overview/index.php', ['userid' => $userid]))->out(false),
                'icon'  => 'fa-award',
            ];
        }

        // Contributions & Tools list.
        $contributions = [];
        $contributions[] = [
            'title' => get_string('forum_posts', 'local_smartprofile'),
            'url'   => (new \moodle_url('/mod/forum/user.php', ['id' => $userid]))->out(false),
            'icon'  => 'fa-comments',
        ];
        $contributions[] = [
            'title' => get_string('forum_discussions', 'local_smartprofile'),
            'url'   => (new \moodle_url('/mod/forum/user.php', ['id' => $userid, 'group' => 0, 'mode' => 'discussions']))->out(false),
            'icon'  => 'fa-message',
        ];

        // Notes (if enabled)
        if (!empty($CFG->enablenotes)) {
            $contributions[] = [
                'title' => get_string('teacher_notes', 'local_smartprofile'),
                'url'   => (new \moodle_url('/notes/index.php', ['user' => $userid]))->out(false),
                'icon'  => 'fa-sticky-note',
            ];
        }

        // Learning Plans (if enabled)
        if (!empty($CFG->enablecompetencies)) {
            $contributions[] = [
                'title' => get_string('learning_plans', 'local_smartprofile'),
                'url'   => (new \moodle_url('/admin/tool/lp/plans.php', ['userid' => $userid]))->out(false),
                'icon'  => 'fa-diagram-project',
            ];
        }

        // Browser Sessions (for admin or self)
        if ($isown || $isadmin) {
            $contributions[] = [
                'title' => get_string('browser_sessions', 'local_smartprofile'),
                'url'   => (new \moodle_url('/report/usersessions/user.php', ['id' => $userid]))->out(false),
                'icon'  => 'fa-shield-halved',
            ];
        }

        return [
            'classic_profile_url' => $classicprofileurl,
            'course_profile_url'  => $courseprofileurl,
            'has_course_profile'  => !empty($courseprofileurl),
            'course_name'         => $coursename,
            'reports'             => $reports,
            'has_reports'         => !empty($reports),
            'contributions'       => $contributions,
            'has_contributions'   => !empty($contributions),
        ];
    }
}
