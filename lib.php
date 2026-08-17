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
                         ($PAGE->pagetype === 'user-profile');

        if ($isprofilepage && !defined('AJAX_SCRIPT') && !defined('WS_SERVER')) {
            $userid = optional_param('id', $USER->id, PARAM_INT);
            $url = new moodle_url('/local/smartprofile/index.php', ['id' => $userid]);
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
