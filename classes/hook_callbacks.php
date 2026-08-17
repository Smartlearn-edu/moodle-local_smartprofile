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

namespace local_smartprofile;

/**
 * Hook callbacks class for Smart Profile.
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class hook_callbacks {
    /**
     * Executes before HTTP headers are sent, allowing a clean server-side redirect
     * away from the default user profile page before any HTML is rendered.
     *
     * @param \core\hook\output\before_http_headers $hook
     */
    public static function before_http_headers(\core\hook\output\before_http_headers $hook): void {
        global $CFG, $USER;

        // Skip during install/upgrade to prevent breaking the system.
        if (during_initial_install() || !empty($CFG->upgraderunning)) {
            return;
        }

        // We intercept direct requests to the default profile.
        $script = $_SERVER['SCRIPT_NAME'] ?? '';
        if (strpos($script, '/user/profile.php') !== false) {
            require_once($CFG->dirroot . '/local/smartprofile/lib.php');

            if (local_smartprofile_should_redirect()) {
                $userid = optional_param('id', 0, PARAM_INT);
                $username = optional_param('username', '', PARAM_RAW);
                if (empty($username)) {
                    $username = optional_param('u', '', PARAM_RAW);
                }

                $params = [];
                if ($userid > 0) {
                    $params['id'] = $userid;
                } else if (!empty($username)) {
                    $params['username'] = $username;
                }

                $url = new \moodle_url('/local/smartprofile/index.php', $params);
                \redirect($url);
            }
        }
    }
}
