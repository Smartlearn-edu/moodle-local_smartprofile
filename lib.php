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
 * Library functions for Smart Profile.
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Extends navigation and handles fallback server-side redirect if needed.
 *
 * @param global_navigation $navigation The global navigation object.
 */
function local_smartprofile_extend_navigation(global_navigation $navigation) {
    global $PAGE, $USER;

    if (!isloggedin() || isguestuser()) {
        return;
    }

    if (local_smartprofile_should_redirect()) {
        $script = $_SERVER['SCRIPT_NAME'] ?? '';
        $isprofilepage = (strpos($script, '/user/profile.php') !== false) ||
                         (strpos($script, '/user/view.php') !== false) ||
                         ($PAGE->pagetype === 'user-profile');

        if ($isprofilepage && !defined('AJAX_SCRIPT') && !defined('WS_SERVER')) {
            $userid = optional_param('id', $USER->id, PARAM_INT);
            if (empty($userid)) {
                $userid = optional_param('userid', $USER->id, PARAM_INT);
            }
            $courseid = optional_param('course', 0, PARAM_INT);
            if (empty($courseid)) {
                $courseid = optional_param('courseid', 0, PARAM_INT);
            }

            $params = ['id' => $userid];
            if ($courseid > 0) {
                $params['course'] = $courseid;
            }

            $url = new moodle_url('/local/smartprofile/index.php', $params);
            redirect($url);
            exit;
        }
    }
}

/**
 * Checks if the current user qualifies for Smart Profile redirection.
 *
 * @return bool
 */
function local_smartprofile_should_redirect(): bool {
    global $USER, $DB, $CFG;

    if (!isloggedin() || isguestuser()) {
        return false;
    }

    $classic = optional_param('classic', 0, PARAM_INT);
    $noredirect = optional_param('noredirect', 0, PARAM_INT);
    if ($classic == 1 || $noredirect == 1) {
        return false;
    }

    if (!get_config('local_smartprofile', 'enableredirect')) {
        return false;
    }

    if (is_siteadmin()) {
        return (bool) get_config('local_smartprofile', 'redirectadmins');
    }

    $roles = get_config('local_smartprofile', 'redirectroles');
    if (empty($roles)) {
        // If no specific roles are configured, redirect all authenticated users.
        return true;
    }

    $roleids = explode(',', $roles);

    // Moodle's "Authenticated user" virtual role check.
    if (!empty($CFG->defaultuserroleid) && in_array($CFG->defaultuserroleid, $roleids)) {
        return true;
    }

    [$insql, $params] = $DB->get_in_or_equal($roleids);
    $params[] = $USER->id;

    $sql = "SELECT id FROM {role_assignments} WHERE roleid $insql AND userid = ?";
    return $DB->record_exists_sql($sql, $params);
}

/**
 * Add nodes to user profile navigation tree.
 *
 * @param \core_user\output\myprofile\tree $tree
 * @param stdClass $user
 * @param bool $iscurrentuser
 * @param stdClass $course
 * @return bool
 */
function local_smartprofile_myprofile_navigation(\core_user\output\myprofile\tree $tree, $user, $iscurrentuser, $course = null) {
    global $USER;

    if (!isloggedin() || isguestuser()) {
        return false;
    }

    // Create a dedicated Smart Profile category to guarantee it exists in the tree.
    $category = new \core_user\output\myprofile\category(
        'smartprofile',
        get_string('pluginname', 'local_smartprofile'),
        null
    );
    $tree->add_category($category);

    // Add link to modern Smart Profile page from classic profile.
    $profileparams = ['id' => $user->id];
    if (!empty($course) && !empty($course->id) && $course->id != SITEID) {
        $profileparams['course'] = $course->id;
    }
    $smartprofileurl = new moodle_url('/local/smartprofile/index.php', $profileparams);
    $smartprofilenode = new \core_user\output\myprofile\node(
        'smartprofile',
        'smartprofile_view',
        get_string('smartprofile:view', 'local_smartprofile'),
        null,
        $smartprofileurl
    );
    $tree->add_node($smartprofilenode);

    $isowner = $iscurrentuser || (!empty($user->id) && $USER->id == $user->id);
    $usercontext = context_user::instance($user->id);

    if ($isowner || has_capability('moodle/user:editprofile', $usercontext)) {
        $url = new moodle_url('/local/smartprofile/preferences.php', ['id' => $user->id]);
        $prefnode = new \core_user\output\myprofile\node(
            'smartprofile',
            'smartprofile_privacy',
            get_string('profile_visibility_settings', 'local_smartprofile'),
            null,
            $url
        );
        $tree->add_node($prefnode);
    }
    return true;
}

/**
 * Extends the settings navigation to add SmartProfile privacy preferences to user preferences page.
 *
 * @param settings_navigation $settingsnav The settings navigation object.
 * @param context $context The context.
 */
function local_smartprofile_extend_settings_navigation(settings_navigation $settingsnav, context $context) {
    global $USER;

    if (!isloggedin() || isguestuser()) {
        return;
    }

    if ($context->contextlevel != CONTEXT_USER) {
        return;
    }

    $userid = $context->instanceid;
    $iscurrentuser = ($USER->id == $userid);

    if ($iscurrentuser || has_capability('moodle/user:editprofile', $context)) {
        $useraccount = $settingsnav->find('useraccount', navigation_node::TYPE_CONTAINER);
        if (!$useraccount) {
            $useraccount = $settingsnav->find('usercurrentsettings', navigation_node::TYPE_CONTAINER);
        }

        if ($useraccount) {
            $url = new moodle_url('/local/smartprofile/preferences.php', ['id' => $userid]);
            $node = navigation_node::create(
                get_string('profile_visibility_settings', 'local_smartprofile'),
                $url,
                navigation_node::TYPE_SETTING,
                'smartprofile_privacy',
                'smartprofile_privacy',
                new pix_icon('i/settings', '')
            );
            $useraccount->add_node($node);
        }
    }
}
