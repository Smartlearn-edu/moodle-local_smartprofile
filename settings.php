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
 * Settings for Smart Profile.
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_smartprofile', get_string('pluginname', 'local_smartprofile'));
    $ADMIN->add('localplugins', $settings);

    // --- Redirection Settings ---
    $settings->add(new admin_setting_heading(
        'local_smartprofile/redirect_heading',
        get_string('redirect_heading', 'local_smartprofile'),
        get_string('redirect_desc', 'local_smartprofile')
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_smartprofile/enableredirect',
        get_string('enableredirect', 'local_smartprofile'),
        get_string('enableredirect_desc', 'local_smartprofile'),
        1
    ));

    $roleoptions = [];
    $allroles = role_get_names();
    if ($allroles) {
        foreach ($allroles as $role) {
            $roleoptions[$role->id] = $role->localname;
        }
    }

    $settings->add(new admin_setting_configmultiselect(
        'local_smartprofile/redirectroles',
        get_string('redirectroles', 'local_smartprofile'),
        get_string('redirectroles_desc', 'local_smartprofile'),
        [],
        $roleoptions
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_smartprofile/redirectadmins',
        get_string('redirectadmins', 'local_smartprofile'),
        get_string('redirectadmins_desc', 'local_smartprofile'),
        0
    ));

    // --- Appearance Settings ---
    $settings->add(new admin_setting_heading(
        'local_smartprofile/appearance_heading',
        get_string('appearance_heading', 'local_smartprofile'),
        get_string('appearance_desc', 'local_smartprofile')
    ));

    $settings->add(new admin_setting_configselect(
        'local_smartprofile/thememode',
        get_string('thememode', 'local_smartprofile'),
        get_string('thememode_desc', 'local_smartprofile'),
        'auto',
        [
            'auto'  => get_string('thememode_auto', 'local_smartprofile'),
            'dark'  => get_string('thememode_dark', 'local_smartprofile'),
            'light' => get_string('thememode_light', 'local_smartprofile'),
        ]
    ));

    // --- Sections Settings ---
    $settings->add(new admin_setting_heading(
        'local_smartprofile/sections_heading',
        get_string('sections_heading', 'local_smartprofile'),
        get_string('sections_desc', 'local_smartprofile')
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_smartprofile/showcourses',
        get_string('showcourses', 'local_smartprofile'),
        get_string('showcourses_desc', 'local_smartprofile'),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_smartprofile/showbadges',
        get_string('showbadges', 'local_smartprofile'),
        get_string('showbadges_desc', 'local_smartprofile'),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_smartprofile/showactivity',
        get_string('showactivity', 'local_smartprofile'),
        get_string('showactivity_desc', 'local_smartprofile'),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_smartprofile/showgamification',
        get_string('showgamification', 'local_smartprofile'),
        get_string('showgamification_desc', 'local_smartprofile'),
        1
    ));

    // --- Role-Adaptive Faculty & Educator Settings ---
    $settings->add(new admin_setting_heading(
        'local_smartprofile/faculty_heading',
        get_string('faculty_heading', 'local_smartprofile'),
        get_string('faculty_desc', 'local_smartprofile')
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_smartprofile/enable_faculty_mode',
        get_string('enable_faculty_mode', 'local_smartprofile'),
        get_string('enable_faculty_mode_desc', 'local_smartprofile'),
        1
    ));

    // --- SmartDashboard Ecosystem Interop ---
    $settings->add(new admin_setting_heading(
        'local_smartprofile/interop_heading',
        get_string('interop_heading', 'local_smartprofile'),
        get_string('interop_desc', 'local_smartprofile')
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_smartprofile/enable_smartdashboard_interop',
        get_string('enable_smartdashboard_interop', 'local_smartprofile'),
        get_string('enable_smartdashboard_interop_desc', 'local_smartprofile'),
        1
    ));
}
