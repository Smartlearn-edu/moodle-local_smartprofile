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
 * Main entry point for Smart Profile.
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once($CFG->dirroot . '/user/profile/lib.php');

$userid = optional_param('id', 0, PARAM_INT);

// Force login check if configured.
if (!empty($CFG->forceloginforprofiles)) {
    require_login();
    if (isguestuser()) {
        $PAGE->set_context(context_system::instance());
        $PAGE->set_title(get_string('loginrequired'));
        echo $OUTPUT->header();
        echo $OUTPUT->confirm(
            get_string('guestcantaccessprofiles', 'error'),
            get_login_url(),
            $CFG->wwwroot
        );
        echo $OUTPUT->footer();
        exit;
    }
} else if (!empty($CFG->forcelogin)) {
    require_login();
}

$userid = $userid ?: ($USER->id ?? 0);
if (empty($userid)) {
    require_login();
    $userid = $USER->id;
}

$profileuser = $DB->get_record('user', ['id' => $userid, 'deleted' => 0]);
if (!$profileuser) {
    $PAGE->set_context(context_system::instance());
    $PAGE->set_title(get_string('user'));
    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('invaliduser', 'error'), 'notifyproblem');
    echo $OUTPUT->footer();
    exit;
}

$usercontext = context_user::instance($profileuser->id, MUST_EXIST);

// Core profile access check (respects all Moodle access rules).
if (!user_can_view_profile($profileuser, null, $usercontext)) {
    $struser = get_string('user');
    $PAGE->set_context(context_system::instance());
    $PAGE->set_title($struser);
    $PAGE->set_heading($struser);
    $PAGE->set_pagelayout('mypublic');
    $PAGE->set_url('/local/smartprofile/index.php', ['id' => $userid]);
    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('usernotavailable', 'error'), 'notifyproblem');
    echo $OUTPUT->footer();
    exit;
}

// Page setup.
$PAGE->set_context($usercontext);
$PAGE->set_url(new moodle_url('/local/smartprofile/index.php', ['id' => $profileuser->id]));
$PAGE->set_pagelayout('report');
$PAGE->set_pagetype('local-smartprofile-index');
$PAGE->add_body_class('path-local-smartprofile');
$PAGE->add_body_class('smartprofile-active');
$PAGE->set_title(fullname($profileuser) . ' - ' . get_string('pluginname', 'local_smartprofile'));
$PAGE->set_heading('');

// Init AMD JS module.
$isown = ($USER->id == $profileuser->id);
$PAGE->requires->strings_for_js(['status_public', 'status_private', 'pref_saved', 'pref_error'], 'local_smartprofile');
$PAGE->requires->js_call_amd('local_smartprofile/profile', 'init', [
    [
        'userid'  => $profileuser->id,
        'isown'   => $isown,
        'sesskey' => sesskey(),
    ],
]);

echo $OUTPUT->header();

$profilepage = new \local_smartprofile\output\profile_page($profileuser, $USER);
echo $OUTPUT->render_from_template('local_smartprofile/profile_page', $profilepage->export_for_template($OUTPUT));

echo $OUTPUT->footer();
