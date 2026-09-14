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

namespace local_smartprofile\output;

use renderable;
use templatable;
use renderer_base;
use moodle_url;

/**
 * Output renderable for the SmartProfile Pro showcase and promotion page.
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class pro_page implements renderable, templatable {
    /**
     * Exports data for Mustache template.
     *
     * @param renderer_base $output
     * @return array
     */
    public function export_for_template(renderer_base $output): array {
        $settingsurl = (new moodle_url('/admin/settings.php', ['section' => 'local_smartprofile']))->out(false);
        $prourl = 'https://services.smartlearn.education/services/plugins/local_smartprofile';

        $features = [
            [
                'icon'      => 'fa-wallet',
                'iconclass' => 'sp-pro-icon-purple',
                'title'     => get_string('pro_feat_wallet_title', 'local_smartprofile'),
                'desc'      => get_string('pro_feat_wallet_desc', 'local_smartprofile'),
            ],
            [
                'icon'      => 'fa-file-pdf',
                'iconclass' => 'sp-pro-icon-red',
                'title'     => get_string('pro_feat_cv_title', 'local_smartprofile'),
                'desc'      => get_string('pro_feat_cv_desc', 'local_smartprofile'),
            ],
            [
                'icon'      => 'fa-chalkboard-user',
                'iconclass' => 'sp-pro-icon-green',
                'title'     => get_string('pro_feat_faculty_title', 'local_smartprofile'),
                'desc'      => get_string('pro_feat_faculty_desc', 'local_smartprofile'),
            ],
            [
                'icon'      => 'fa-award',
                'iconclass' => 'sp-pro-icon-amber',
                'title'     => get_string('pro_feat_endorse_title', 'local_smartprofile'),
                'desc'      => get_string('pro_feat_endorse_desc', 'local_smartprofile'),
            ],
            [
                'icon'      => 'fa-shield-halved',
                'iconclass' => 'sp-pro-icon-blue',
                'title'     => get_string('pro_feat_obv3_title', 'local_smartprofile'),
                'desc'      => get_string('pro_feat_obv3_desc', 'local_smartprofile'),
            ],
            [
                'icon'      => 'fa-trophy',
                'iconclass' => 'sp-pro-icon-yellow',
                'title'     => get_string('pro_feat_trophy_title', 'local_smartprofile'),
                'desc'      => get_string('pro_feat_trophy_desc', 'local_smartprofile'),
            ],
        ];

        $bundleitems = [
            ['text' => get_string('pro_bundle_item_sp', 'local_smartprofile')],
            ['text' => get_string('pro_bundle_item_trophy', 'local_smartprofile')],
            ['text' => get_string('pro_bundle_item_sync', 'local_smartprofile')],
        ];

        $comparisonrows = [
            [
                'feature' => get_string('comp_modern_profile', 'local_smartprofile'),
                'free'    => true,
                'pro'     => true,
            ],
            [
                'feature' => get_string('comp_privacy_toggles', 'local_smartprofile'),
                'free'    => true,
                'pro'     => true,
            ],
            [
                'feature' => get_string('comp_course_progress', 'local_smartprofile'),
                'free'    => true,
                'pro'     => true,
            ],
            [
                'feature' => get_string('comp_trophy_shield', 'local_smartprofile'),
                'free'    => false,
                'pro'     => true,
            ],
            [
                'feature' => get_string('comp_faculty_mode', 'local_smartprofile'),
                'free'    => false,
                'pro'     => true,
            ],
            [
                'feature' => get_string('comp_wallet_passes', 'local_smartprofile'),
                'free'    => false,
                'pro'     => true,
            ],
            [
                'feature' => get_string('comp_cv_builder', 'local_smartprofile'),
                'free'    => false,
                'pro'     => true,
            ],
            [
                'feature' => get_string('comp_faculty_endorsements', 'local_smartprofile'),
                'free'    => false,
                'pro'     => true,
            ],
            [
                'feature' => get_string('comp_obv3', 'local_smartprofile'),
                'free'    => false,
                'pro'     => true,
            ],
        ];

        return [
            'pro_url'         => $prourl,
            'settings_url'    => $settingsurl,
            'features'        => $features,
            'bundle_items'    => $bundleitems,
            'comparison_rows' => $comparisonrows,
        ];
    }
}
