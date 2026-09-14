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
 * SmartProfile Pro feature showcase and promotion page.
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');

admin_externalpage_setup('local_smartprofile_pro');

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/smartprofile/pro.php'));
$PAGE->set_title(get_string('pro_page_title', 'local_smartprofile'));
$PAGE->set_heading(get_string('pro_page_title', 'local_smartprofile'));

$propage = new \local_smartprofile\output\pro_page();

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_smartprofile/pro_page', $propage->export_for_template($OUTPUT));
echo $OUTPUT->footer();
