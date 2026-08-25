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
 * User Profile Privacy and Visibility Preferences Page.
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . "/../../config.php");
require_once($CFG->dirroot . "/user/lib.php");
require_once($CFG->dirroot . "/local/smartprofile/lib.php");

use local_smartprofile\visibility_manager;

require_login();

$userid = optional_param("id", $USER->id, PARAM_INT);
if (empty($userid)) {
    $userid = optional_param("userid", $USER->id, PARAM_INT);
}

$user = $DB->get_record("user", ["id" => $userid, "deleted" => 0], "*", MUST_EXIST);
$usercontext = context_user::instance($user->id);

$isown = ($USER->id == $user->id);
if (!$isown && !has_capability("moodle/user:editprofile", $usercontext)) {
    throw new \moodle_exception("nopermissions", "error", "", get_string("editprofile", "local_smartprofile"));
}

$PAGE->set_context($usercontext);
$PAGE->set_url(new moodle_url("/local/smartprofile/preferences.php", ["id" => $user->id]));
$PAGE->set_pagelayout("standard");
$PAGE->set_title(get_string("profile_visibility_settings", "local_smartprofile"));
$PAGE->set_heading(get_string("profile_visibility_settings", "local_smartprofile"));

// Setup navigation breadcrumbs.
if ($isown) {
    $PAGE->navbar->add(get_string("preferences"), new moodle_url("/user/preferences.php"));
} else {
    $PAGE->navbar->add(fullname($user), new moodle_url("/local/smartprofile/index.php", ["id" => $user->id]));
    $PAGE->navbar->add(get_string("preferences"), new moodle_url("/user/preferences.php", ["userid" => $user->id]));
}
$PAGE->navbar->add(get_string("profile_visibility_settings", "local_smartprofile"));

// Get field registry and user preferences.
$registry = visibility_manager::get_field_registry();
$userprefs = visibility_manager::get_user_preferences($user->id);

$categorynames = [
    "contact"      => get_string("privacy_category_contact", "local_smartprofile"),
    "about"        => get_string("privacy_category_about", "local_smartprofile"),
    "academic"     => get_string("privacy_category_academic", "local_smartprofile"),
    "gamification" => get_string("privacy_category_gamification", "local_smartprofile"),
    "activity"     => get_string("privacy_category_activity", "local_smartprofile"),
];

$categoryicons = [
    "contact"      => "fa-address-card",
    "about"        => "fa-user-pen",
    "academic"     => "fa-graduation-cap",
    "gamification" => "fa-trophy",
    "activity"     => "fa-chart-line",
];

$groupedfields = [];
foreach ($registry as $fieldname => $fieldmeta) {
    $cat = $fieldmeta["category"] ?? "contact";
    if (!isset($groupedfields[$cat])) {
        $groupedfields[$cat] = [
            "category_key"   => $cat,
            "category_name"  => $categorynames[$cat] ?? ucfirst($cat),
            "category_icon"  => $categoryicons[$cat] ?? "fa-folder",
            "fields"         => [],
        ];
    }

    $currentval = $userprefs[$fieldname] ?? $fieldmeta["default"];
    $ispublic = ($currentval === visibility_manager::VISIBILITY_PUBLIC);

    $groupedfields[$cat]["fields"][] = [
        "field"          => $fieldname,
        "title"          => get_string($fieldmeta["title"], "local_smartprofile"),
        "icon"           => $fieldmeta["icon"] ?? "fa-eye",
        "is_public"      => $ispublic,
        "is_private"     => !$ispublic,
        "status"         => $currentval,
        "status_label"   => $ispublic ? get_string("status_public", "local_smartprofile") : get_string("status_private", "local_smartprofile"),
    ];
}

$templatecontext = [
    "user_fullname"     => fullname($user),
    "user_avatar"       => $OUTPUT->user_picture($user, ["size" => 60, "link" => false]),
    "profile_url"       => (new moodle_url("/local/smartprofile/index.php", ["id" => $user->id]))->out(false),
    "categories"        => array_values($groupedfields),
    "sesskey"           => sesskey(),
    "isown"             => $isown,
];

$PAGE->requires->js_call_amd("local_smartprofile/profile", "init", [["isown" => true]]);

echo $OUTPUT->header();
echo $OUTPUT->render_from_template("local_smartprofile/preferences_page", $templatecontext);
echo $OUTPUT->footer();
