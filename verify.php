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
 * Public Academic Credential Verification Page.
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Public verification page for third-party verification (no login required).
// phpcs:disable moodle.Files.RequireLogin.Missing
require_once(__DIR__ . '/../../config.php');

$userid = required_param('id', PARAM_INT);
$categoryid = optional_param('cat', 0, PARAM_INT);
$hash = required_param('h', PARAM_ALPHANUM);

$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);
$PAGE->set_url(new moodle_url('/local/smartprofile/verify.php', ['id' => $userid, 'cat' => $categoryid, 'h' => $hash]));
$PAGE->set_pagelayout('base');
$PAGE->set_title(get_string('verify_title', 'local_smartprofile'));
$PAGE->set_heading(get_string('verify_title', 'local_smartprofile'));

// Verify security hash to ensure valid authentic link.
$expectedhash = substr(sha1($userid . '_' . $categoryid . '_' . get_site_identifier()), 0, 16);
$isvalid = ($hash === $expectedhash);

$user = null;
if ($isvalid) {
    $user = $DB->get_record('user', ['id' => $userid, 'deleted' => 0]);
    if (!$user) {
        $isvalid = false;
    }
}

if (!$isvalid) {
    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('invalid_verification', 'local_smartprofile'), 'error');
    echo $OUTPUT->footer();
    exit;
}

// Gather verified achievement details.
$issuername = get_config('local_smartprofile', 'issuer_name') ?: $SITE->fullname;
$siteurl = $CFG->wwwroot;

$useravatar = new user_picture($user);
$useravatar->size = 120;
$avatarurl = $useravatar->get_url($PAGE)->out(false);

$subjectname = get_string('general', 'core');
$totalhours = 0.0;
$subcategories = [];
$totaltrophies = 0;

if ($categoryid > 0) {
    $cat = \core_course_category::get($categoryid, IGNORE_MISSING);
    $subjectname = $cat ? format_string($cat->name) : (get_string('category', 'core') . ' ' . $categoryid);

    // Find all subcategories under this root category.
    $catids = [$categoryid];
    if ($cat) {
        $children = $cat->get_children();
        foreach ($children as $child) {
            $catids[] = $child->id;
        }
    }

    if ($DB->get_manager()->table_exists('enrol_trophy_rewards')) {
        [$insql, $inparams] = $DB->get_in_or_equal($catids, SQL_PARAMS_NAMED);
        $inparams['uid'] = $userid;
        $rewards = $DB->get_records_sql(
            "SELECT categoryid, SUM(credits) AS catcredits
               FROM {enrol_trophy_rewards}
              WHERE userid = :uid AND rewardtype = 'credithours' AND categoryid $insql
           GROUP BY categoryid",
            $inparams
        );
        foreach ($rewards as $r) {
            $cid = (int)$r->categoryid;
            $amt = (float)$r->catcredits;
            $totalhours += $amt;
            $subcatobj = \core_course_category::get($cid, IGNORE_MISSING);
            $hoursunit = get_string('credithours', 'local_smartprofile');
            $subcategories[] = [
                'name'  => $subcatobj ? format_string($subcatobj->name) : (get_string('category', 'core') . ' ' . $cid),
                'hours' => rtrim(rtrim(number_format($amt, 2, '.', ''), '0'), '.') . ' ' . $hoursunit,
            ];
        }
    }
} else {
    // Total across all categories.
    $subjectname = get_string('overallprogress', 'local_smartprofile');
    if ($DB->get_manager()->table_exists('enrol_trophy_rewards')) {
        $totalhours = (float)$DB->get_field_sql(
            "SELECT SUM(credits) FROM {enrol_trophy_rewards} WHERE userid = :uid AND rewardtype = 'credithours'",
            ['uid' => $userid]
        );
        $totaltrophies = (int)$DB->count_records('enrol_trophy_rewards', [
            'userid'     => $userid,
            'rewardtype' => 'medal',
        ]);
    }
}

$formattedhours = rtrim(rtrim(number_format($totalhours, 2, '.', ''), '0'), '.');
$hoursdisplay = get_string('credithours_display', 'local_smartprofile', $formattedhours);
$credentialid = 'SL-VERIFY-' . $userid . '-' . $categoryid . '-' . strtoupper(substr($hash, 0, 8));
$verifieddate = userdate(time(), '%B %d, %Y');

$templatecontext = [
    'fullname'          => fullname($user),
    'avatarurl'         => $avatarurl,
    'issuername'        => $issuername,
    'siteurl'           => $siteurl,
    'subjectname'       => $subjectname,
    'hours_display'     => $hoursdisplay,
    'has_hours'         => ($totalhours > 0),
    'totaltrophies'     => $totaltrophies,
    'has_trophies'      => ($totaltrophies > 0),
    'credentialid'      => $credentialid,
    'verifieddate'      => $verifieddate,
    'has_subcategories' => !empty($subcategories),
    'subcategories'     => $subcategories,
    'profileurl'        => (new moodle_url('/local/smartprofile/index.php', ['id' => $userid]))->out(false),
];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_smartprofile/verify_page', $templatecontext);
echo $OUTPUT->footer();
