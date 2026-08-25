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

namespace local_smartprofile\external;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_multiple_structure;
use core_external\external_single_structure;
use core_external\external_value;
use context_user;
use context_system;
use local_smartprofile\visibility_manager;
use moodle_url;

/**
 * External API service for Smart Profile.
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class profile_data extends external_api {
    /**
     * Parameters for save_visibility_prefs.
     *
     * @return external_function_parameters
     */
    public static function save_visibility_prefs_parameters(): external_function_parameters {
        return new external_function_parameters([
            'preferences' => new external_multiple_structure(
                new external_single_structure([
                    'field'      => new external_value(PARAM_ALPHANUMEXT, 'Field identifier'),
                    'visibility' => new external_value(PARAM_ALPHA, 'Visibility: public or private'),
                ]),
                'List of field preferences'
            ),
        ]);
    }

    /**
     * Saves user's visibility preferences for their own profile.
     *
     * @param array $preferences
     * @return array
     */
    public static function save_visibility_prefs(array $preferences): array {
        global $USER;

        $params = self::validate_parameters(self::save_visibility_prefs_parameters(), [
            'preferences' => $preferences,
        ]);

        $context = context_system::instance();
        self::validate_context($context);

        if (!isloggedin() || isguestuser()) {
            return [
                'status'  => false,
                'message' => get_string('error_access_denied', 'local_smartprofile'),
            ];
        }

        $prefsmap = [];
        foreach ($params['preferences'] as $item) {
            $prefsmap[$item['field']] = $item['visibility'];
        }

        $success = visibility_manager::set_user_preferences($USER->id, $prefsmap);

        return [
            'status'  => $success,
            'message' => $success ? get_string('pref_saved', 'local_smartprofile') : get_string('pref_error', 'local_smartprofile'),
        ];
    }

    /**
     * Return structure for save_visibility_prefs.
     *
     * @return external_single_structure
     */
    public static function save_visibility_prefs_returns(): external_single_structure {
        return new external_single_structure([
            'status'  => new external_value(PARAM_BOOL, 'Operation success status'),
            'message' => new external_value(PARAM_TEXT, 'Feedback message'),
        ]);
    }

    /**
     * Parameters for get_courses_with_progress.
     *
     * @return external_function_parameters
     */
    public static function get_courses_with_progress_parameters(): external_function_parameters {
        return new external_function_parameters([
            'userid' => new external_value(PARAM_INT, 'User ID to get courses for'),
        ]);
    }

    /**
     * Gets courses and completion progress for a user.
     *
     * @param int $userid
     * @return array
     */
    public static function get_courses_with_progress(int $userid): array {
        global $DB, $USER, $CFG;
        require_once($CFG->libdir . '/enrollib.php');
        require_once($CFG->dirroot . '/course/lib.php');

        $params = self::validate_parameters(self::get_courses_with_progress_parameters(), [
            'userid' => $userid,
        ]);

        $targetuser = $DB->get_record('user', ['id' => $params['userid']], '*', MUST_EXIST);
        $usercontext = context_user::instance($targetuser->id);
        self::validate_context($usercontext);

        // Security check.
        if (!user_can_view_profile($targetuser, null, $usercontext)) {
            return ['courses' => []];
        }

        if (!visibility_manager::is_field_visible('courses', $targetuser, $USER, $usercontext)) {
            return ['courses' => []];
        }

        $isown = ($USER->id == $targetuser->id);
        $allcourses = enrol_get_all_users_courses($targetuser->id, true, 'id, fullname, shortname, summary, summaryformat, category, visible');

        $courses = [];
        foreach ($allcourses as $course) {
            if ($course->id == SITEID) {
                continue;
            }

            // If viewing someone else's profile, only show if course is visible or viewer has access.
            if (!$isown && !$course->visible) {
                $coursecontext = \context_course::instance($course->id);
                if (!has_capability('moodle/course:viewhiddencourses', $coursecontext)) {
                    continue;
                }
            }

            // Calculate progress.
            $progress = null;
            if ($isown || has_capability('moodle/grade:viewall', \context_course::instance($course->id))) {
                if (class_exists('\core_completion\progress')) {
                    $progress = \core_completion\progress::get_course_progress_percentage($course, $targetuser->id);
                }
            }

            // Course image.
            $courseimage = null;
            if (class_exists('\core_course\external\course_summary_exporter')) {
                // Get course image via course helper.
                $courseimage = \core_course\external\course_summary_exporter::get_course_image($course);
            }

            $courses[] = [
                'id'          => $course->id,
                'fullname'    => format_string($course->fullname),
                'shortname'   => format_string($course->shortname),
                'progress'    => ($progress !== null) ? round($progress) : -1,
                'hasprogress' => ($progress !== null),
                'url'         => (new moodle_url('/course/view.php', ['id' => $course->id]))->out(false),
                'imageurl'    => $courseimage ?: '',
            ];
        }

        return ['courses' => $courses];
    }

    /**
     * Return structure for get_courses_with_progress.
     *
     * @return external_single_structure
     */
    public static function get_courses_with_progress_returns(): external_single_structure {
        return new external_single_structure([
            'courses' => new external_multiple_structure(
                new external_single_structure([
                    'id'          => new external_value(PARAM_INT, 'Course ID'),
                    'fullname'    => new external_value(PARAM_TEXT, 'Course full name'),
                    'shortname'   => new external_value(PARAM_TEXT, 'Course short name'),
                    'progress'    => new external_value(PARAM_INT, 'Completion progress percentage'),
                    'hasprogress' => new external_value(PARAM_BOOL, 'Whether progress is calculated'),
                    'url'         => new external_value(PARAM_URL, 'Course URL'),
                    'imageurl'    => new external_value(PARAM_RAW, 'Course image URL', VALUE_OPTIONAL),
                ])
            ),
        ]);
    }

    /**
     * Parameters for get_user_badges.
     *
     * @return external_function_parameters
     */
    public static function get_user_badges_parameters(): external_function_parameters {
        return new external_function_parameters([
            'userid' => new external_value(PARAM_INT, 'User ID to get badges for'),
        ]);
    }

    /**
     * Gets earned badges for a user.
     *
     * @param int $userid
     * @return array
     */
    public static function get_user_badges(int $userid): array {
        global $DB, $USER, $CFG;
        require_once($CFG->libdir . '/badgeslib.php');

        $params = self::validate_parameters(self::get_user_badges_parameters(), [
            'userid' => $userid,
        ]);

        if (empty($CFG->enablebadges)) {
            return ['badges' => []];
        }

        $targetuser = $DB->get_record('user', ['id' => $params['userid']], '*', MUST_EXIST);
        $usercontext = context_user::instance($targetuser->id);
        self::validate_context($usercontext);

        if (!user_can_view_profile($targetuser, null, $usercontext)) {
            return ['badges' => []];
        }

        if (!visibility_manager::is_field_visible('badges', $targetuser, $USER, $usercontext)) {
            return ['badges' => []];
        }

        $userbadges = badges_get_user_badges($targetuser->id);
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

        return ['badges' => $badges];
    }

    /**
     * Return structure for get_user_badges.
     *
     * @return external_single_structure
     */
    public static function get_user_badges_returns(): external_single_structure {
        return new external_single_structure([
            'badges' => new external_multiple_structure(
                new external_single_structure([
                    'id'          => new external_value(PARAM_INT, 'Badge ID'),
                    'name'        => new external_value(PARAM_TEXT, 'Badge name'),
                    'description' => new external_value(PARAM_RAW, 'Badge description'),
                    'imageurl'    => new external_value(PARAM_URL, 'Badge icon URL'),
                    'dateissued'  => new external_value(PARAM_TEXT, 'Date badge was issued'),
                    'badgeurl'    => new external_value(PARAM_URL, 'Badge details URL'),
                ])
            ),
        ]);
    }
}
