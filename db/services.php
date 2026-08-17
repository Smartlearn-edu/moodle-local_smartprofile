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
 * External services definition for Smart Profile.
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = [
    'local_smartprofile_save_visibility_prefs' => [
        'classname'   => 'local_smartprofile\external\profile_data',
        'methodname'  => 'save_visibility_prefs',
        'description' => 'Save user visibility preferences for Smart Profile',
        'type'        => 'write',
        'ajax'        => true,
        'loginrequired' => true,
    ],
    'local_smartprofile_get_courses_with_progress' => [
        'classname'   => 'local_smartprofile\external\profile_data',
        'methodname'  => 'get_courses_with_progress',
        'description' => 'Get enrolled courses with progress for a user',
        'type'        => 'read',
        'ajax'        => true,
        'loginrequired' => true,
    ],
    'local_smartprofile_get_user_badges' => [
        'classname'   => 'local_smartprofile\external\profile_data',
        'methodname'  => 'get_user_badges',
        'description' => 'Get user badges',
        'type'        => 'read',
        'ajax'        => true,
        'loginrequired' => true,
    ],
];
