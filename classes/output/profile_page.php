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
 * Output renderable for the Smart Profile page.
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

    /**
     * Constructor.
     *
     * @param object $profileuser
     * @param object $viewer
     */
    public function __construct(object $profileuser, object $viewer) {
        $this->profileuser = $profileuser;
        $this->viewer = $viewer;
        $this->usercontext = context_user::instance($profileuser->id);
    }

    /**
     * Exports data for Mustache template.
     *
     * @param renderer_base $output
     * @return array
     */
    public function export_for_template(renderer_base $output): array {
        global $CFG, $DB, $PAGE;
        require_once($CFG->dirroot . '/user/profile/lib.php');
        require_once($CFG->libdir . '/badgeslib.php');
        require_once($CFG->libdir . '/enrollib.php');

        $isown = ($this->viewer->id == $this->profileuser->id);
        $systemcontext = context_system::instance();

        // 1. Avatar & User Picture.
        $userpicture = new user_picture($this->profileuser);
        $userpicture->size = 150;
        $avatarurl = $userpicture->get_url($PAGE)->out(false);

        // 2. Roles Badges.
        $rolebadges = $this->get_user_roles();

        // 3. Edit & Config URLs.
        $canedit = $isown ? has_capability('moodle/user:editownprofile', $this->usercontext)
                          : has_capability('moodle/user:editprofile', $this->usercontext);

        $editurl = '';
        if ($canedit) {
            if ($isown) {
                $editurl = (new moodle_url('/user/edit.php', ['id' => $this->profileuser->id]))->out(false);
            } else {
                $editurl = (new moodle_url('/user/editadvanced.php', ['id' => $this->profileuser->id]))->out(false);
            }
        }

        $preferencesurl = '';
        if ($isown || has_capability('moodle/user:editprofile', $this->usercontext)) {
            $preferencesurl = (new moodle_url('/user/preferences.php', ['userid' => $this->profileuser->id]))->out(false);
        }

        $gradesurl = '';
        if ($isown || has_capability('moodle/grade:viewall', $systemcontext)) {
            $gradesurl = (new moodle_url('/grade/report/overview/index.php', ['userid' => $this->profileuser->id]))->out(false);
        }

        // Messaging URL for viewing another user.
        $messageurl = '';
        $showmessage = false;
        if (!$isown && isloggedin() && !isguestuser() && !empty($CFG->messaging)) {
            $messageurl = (new moodle_url('/message/index.php', ['id' => $this->profileuser->id]))->out(false);
            $showmessage = true;
        }

        // 4. Contact Info with 3-Layer Visibility Filter.
        $contactinfo = [];
        $countries = get_string_manager()->get_list_of_countries();

        if (visibility_manager::is_field_visible('email', $this->profileuser, $this->viewer, $this->usercontext) && !empty($this->profileuser->email)) {
            $contactinfo[] = [
                'icon'  => 'fa-envelope',
                'label' => get_string('email'),
                'value' => $this->profileuser->email,
                'islink' => true,
                'link'  => 'mailto:' . s($this->profileuser->email),
            ];
        }

        if (visibility_manager::is_field_visible('phone1', $this->profileuser, $this->viewer, $this->usercontext) && !empty($this->profileuser->phone1)) {
            $contactinfo[] = [
                'icon'  => 'fa-phone',
                'label' => get_string('phone'),
                'value' => $this->profileuser->phone1,
                'islink' => true,
                'link'  => 'tel:' . s($this->profileuser->phone1),
            ];
        }

        if (visibility_manager::is_field_visible('city', $this->profileuser, $this->viewer, $this->usercontext) && !empty($this->profileuser->city)) {
            $contactinfo[] = [
                'icon'  => 'fa-location-dot',
                'label' => get_string('city'),
                'value' => $this->profileuser->city,
                'islink' => false,
            ];
        }

        if (visibility_manager::is_field_visible('country', $this->profileuser, $this->viewer, $this->usercontext) && !empty($this->profileuser->country)) {
            $countryname = $countries[$this->profileuser->country] ?? $this->profileuser->country;
            $contactinfo[] = [
                'icon'  => 'fa-globe',
                'label' => get_string('country'),
                'value' => $countryname,
                'islink' => false,
            ];
        }

        if (visibility_manager::is_field_visible('timezone', $this->profileuser, $this->viewer, $this->usercontext) && !empty($this->profileuser->timezone)) {
            $contactinfo[] = [
                'icon'  => 'fa-clock',
                'label' => get_string('timezone'),
                'value' => $this->profileuser->timezone,
                'islink' => false,
            ];
        }

        // Custom profile fields.
        $customfields = $this->get_custom_profile_fields();

        // 5. About / Bio & Interests.
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

        $showinterests = visibility_manager::is_field_visible('interests', $this->profileuser, $this->viewer, $this->usercontext);
        $interests = [];
        if ($showinterests && core_tag_tag::is_enabled('core', 'user')) {
            $tags = core_tag_tag::get_item_tags('core', 'user', $this->profileuser->id);
            foreach ($tags as $tag) {
                $interests[] = [
                    'name' => $tag->get_display_name(),
                    'url'  => (new moodle_url('/tag/index.php', ['tag' => $tag->rawname]))->out(false),
                ];
            }
        }

        // 6. Courses.
        $showcoursesconfig = get_config('local_smartprofile', 'showcourses');
        $showcourses = $showcoursesconfig && visibility_manager::is_field_visible('courses', $this->profileuser, $this->viewer, $this->usercontext);
        $courses = $showcourses ? $this->get_courses() : [];

        // 7. Badges.
        $showbadgesconfig = get_config('local_smartprofile', 'showbadges');
        $showbadges = $showbadgesconfig && !empty($CFG->enablebadges) && visibility_manager::is_field_visible('badges', $this->profileuser, $this->viewer, $this->usercontext);
        $badges = $showbadges ? $this->get_badges() : [];
        $badges_preview = array_slice($badges, 0, 5);

        // 8. Gamification (format_quest integration).
        $showgamificationconfig = get_config('local_smartprofile', 'showgamification');
        $showgamification = $showgamificationconfig && visibility_manager::is_field_visible('gamelevel', $this->profileuser, $this->viewer, $this->usercontext);
        $gamification = $showgamification ? $this->get_gamification_data() : null;

        // 9. Activity Info.
        $showactivityconfig = get_config('local_smartprofile', 'showactivity');
        $showactivity = $showactivityconfig && ($isown || has_capability('moodle/user:viewdetails', $this->usercontext));
        $activityinfo = [];
        if ($showactivity) {
            $activityinfo = [
                'firstaccess' => $this->profileuser->firstaccess ? userdate($this->profileuser->firstaccess, get_string('strftimedatetime', 'langconfig')) : '-',
                'lastaccess'  => $this->profileuser->lastaccess ? userdate($this->profileuser->lastaccess, get_string('strftimedatetime', 'langconfig')) : '-',
                'lastip'      => ($isown || is_siteadmin()) ? ($this->profileuser->lastip ?: '') : '',
            ];
        }

        // 10. Privacy Toggles for Profile Owner.
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

        // 11. Appearance Theme Mode.
        $thememode = get_config('local_smartprofile', 'thememode') ?: 'auto';

        return [
            'userid'            => $this->profileuser->id,
            'fullname'          => fullname($this->profileuser),
            'avatarurl'         => $avatarurl,
            'rolebadges'        => $rolebadges,
            'isownprofile'      => $isown,
            'canedit'           => $canedit,
            'editurl'           => $editurl,
            'preferencesurl'    => $preferencesurl,
            'gradesurl'         => $gradesurl,
            'showmessage'       => $showmessage,
            'messageurl'        => $messageurl,
            'lastaccess'        => $this->format_time_ago($this->profileuser->lastaccess),
            'contactinfo'       => $contactinfo,
            'has_contact'       => !empty($contactinfo),
            'customfields'      => $customfields,
            'has_customfields'  => !empty($customfields),
            'description'       => $description,
            'has_description'   => !empty($description),
            'interests'         => $interests,
            'has_interests'     => !empty($interests),
            'has_about'         => (!empty($description) || !empty($interests)),
            'showcourses'       => $showcourses,
            'courses'           => $courses,
            'has_courses'       => !empty($courses),
            'courses_count'     => count($courses),
            'showbadges'        => $showbadges,
            'badges'            => $badges,
            'badges_preview'    => $badges_preview,
            'has_badges'        => !empty($badges),
            'badges_count'      => count($badges),
            'showgamification'  => $showgamification && !empty($gamification),
            'gamification'      => $gamification,
            'showactivity'      => $showactivity,
            'activityinfo'      => $activityinfo,
            'toggles'           => $toggles,
            'thememode'         => $thememode,
            'sesskey'           => sesskey(),
        ];
    }

    /**
     * Gets user roles formatted as badges.
     *
     * @return array
     */
    protected function get_user_roles(): array {
        global $DB;
        $roles = [];

        if (is_siteadmin($this->profileuser)) {
            $roles[] = [
                'name'  => get_string('administrator'),
                'class' => 'badge-admin',
            ];
        }

        $sql = "SELECT DISTINCT r.id, r.name, r.shortname
                  FROM {role_assignments} ra
                  JOIN {role} r ON r.id = ra.roleid
                 WHERE ra.userid = :userid";
        $assignedroles = $DB->get_records_sql($sql, ['userid' => $this->profileuser->id]);

        foreach ($assignedroles as $r) {
            $displayname = role_get_name($r);
            $class = 'badge-role';
            if ($r->shortname === 'editingteacher' || $r->shortname === 'teacher') {
                $class = 'badge-teacher';
            } else if ($r->shortname === 'manager') {
                $class = 'badge-manager';
            } else if ($r->shortname === 'student') {
                $class = 'badge-student';
            }

            $roles[] = [
                'name'  => $displayname,
                'class' => $class,
            ];
        }

        return $roles;
    }

    /**
     * Gets custom profile fields.
     *
     * @return array
     */
    protected function get_custom_profile_fields(): array {
        global $CFG, $DB;
        require_once($CFG->dirroot . '/user/profile/lib.php');

        $categories = profile_get_user_fields_with_data($this->profileuser->id);
        $fields = [];

        foreach ($categories as $cat) {
            if (empty($cat->fields)) {
                continue;
            }
            foreach ($cat->fields as $field) {
                if ($field->is_empty()) {
                    continue;
                }
                if (!$field->is_visible()) {
                    continue;
                }
                $fields[] = [
                    'name'  => format_string($field->field->name),
                    'value' => $field->display_data(),
                ];
            }
        }

        return $fields;
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

            $courseimage = '';
            if (class_exists('\core_course\external\course_summary_exporter')) {
                $courseimage = \core_course\external\course_summary_exporter::get_course_image($course) ?: '';
            }

            $hasprogress = ($progress !== null);
            $progressval = $hasprogress ? round($progress) : 0;

            $courses[] = [
                'id'          => $course->id,
                'fullname'    => format_string($course->fullname),
                'shortname'   => format_string($course->shortname),
                'progress'    => $progressval,
                'hasprogress' => $hasprogress,
                'iscomplete'  => ($progressval >= 100),
                'url'         => (new moodle_url('/course/view.php', ['id' => $course->id]))->out(false),
                'imageurl'    => $courseimage,
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
                'dateissued'  => userdate($b->dateissued, get_string('strftimedate', 'langconfig')),
                'badgeurl'    => (new moodle_url('/badges/badge.php', ['hash' => $b->uniquehash]))->out(false),
            ];
        }

        return $badges;
    }

    /**
     * Gets gamification summary from format_quest if available.
     *
     * @return array|null
     */
    protected function get_gamification_data(): ?array {
        // Loose coupling: check if format_quest API exists.
        if (class_exists('\format_quest\api') && method_exists('\format_quest\api', 'get_user_level_summary')) {
            try {
                $data = \format_quest\api::get_user_level_summary($this->profileuser->id);
                if (!empty($data)) {
                    return $data;
                }
            } catch (\Throwable $e) {
                // Silently ignore if API encounters an issue.
            }
        }

        return null;
    }

    /**
     * Helper to format last access nicely (e.g. "5 mins ago", "Yesterday").
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

        return userdate($timestamp, get_string('strftimedate', 'langconfig'));
    }
}
