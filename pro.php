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

echo $OUTPUT->header();
?>

<div class="sp-pro-showcase-wrap" style="max-width: 1000px; margin: 0 auto; padding: 20px 0;">

    <!-- 1. Hero Promo Header -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); color: #ffffff; border-radius: 16px; overflow: hidden;">
        <div class="card-body p-4 p-md-5">
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(253, 224, 71, 0.2); border: 1px solid rgba(253, 224, 71, 0.4); color: #fef08a; font-size: 0.85rem; font-weight: 700;">
                <i class="fa fa-star" aria-hidden="true"></i> <?php echo get_string('pro_badge', 'local_smartprofile'); ?>
            </div>
            <h1 class="display-6 fw-bold mb-3 text-white"><?php echo get_string('pro_hero_title', 'local_smartprofile'); ?></h1>
            <p class="lead mb-4" style="color: #e2e8f0; max-width: 780px;">
                <?php echo get_string('pro_hero_desc', 'local_smartprofile'); ?>
            </p>
            <div class="d-flex flex-wrap gap-3">
                <a href="https://services.smartlearn.education/services/plugins/local_smartprofile" target="_blank" rel="noopener" class="btn btn-warning btn-lg fw-bold px-4 shadow-sm" style="color: #0f172a; border-radius: 10px;">
                    <i class="fa fa-arrow-up-right-from-square me-2" aria-hidden="true"></i> <?php echo get_string('pro_get_btn', 'local_smartprofile'); ?>
                </a>
                <a href="<?php echo (new moodle_url('/admin/settings.php', ['section' => 'local_smartprofile']))->out(false); ?>" class="btn btn-outline-light btn-lg px-4" style="border-radius: 10px;">
                    <i class="fa fa-cog me-2" aria-hidden="true"></i> <?php echo get_string('settings'); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. Feature Highlights Grid -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px; background: #ffffff;">
                <div class="card-body p-4">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-3" style="width: 48px; height: 48px; background: #ede9fe; color: #7c3aed; font-size: 1.3rem;">
                        <i class="fa fa-wallet" aria-hidden="true"></i>
                    </div>
                    <h5 class="fw-bold mb-2"><?php echo get_string('pro_feat_wallet_title', 'local_smartprofile'); ?></h5>
                    <p class="text-muted mb-0"><?php echo get_string('pro_feat_wallet_desc', 'local_smartprofile'); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px; background: #ffffff;">
                <div class="card-body p-4">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-3" style="width: 48px; height: 48px; background: #fee2e2; color: #ef4444; font-size: 1.3rem;">
                        <i class="fa fa-file-pdf" aria-hidden="true"></i>
                    </div>
                    <h5 class="fw-bold mb-2"><?php echo get_string('pro_feat_cv_title', 'local_smartprofile'); ?></h5>
                    <p class="text-muted mb-0"><?php echo get_string('pro_feat_cv_desc', 'local_smartprofile'); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px; background: #ffffff;">
                <div class="card-body p-4">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-3" style="width: 48px; height: 48px; background: #fef3c7; color: #d97706; font-size: 1.3rem;">
                        <i class="fa fa-award" aria-hidden="true"></i>
                    </div>
                    <h5 class="fw-bold mb-2"><?php echo get_string('pro_feat_endorse_title', 'local_smartprofile'); ?></h5>
                    <p class="text-muted mb-0"><?php echo get_string('pro_feat_endorse_desc', 'local_smartprofile'); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px; background: #ffffff;">
                <div class="card-body p-4">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-3" style="width: 48px; height: 48px; background: #dbeafe; color: #2563eb; font-size: 1.3rem;">
                        <i class="fa fa-shield-halved" aria-hidden="true"></i>
                    </div>
                    <h5 class="fw-bold mb-2"><?php echo get_string('pro_feat_obv3_title', 'local_smartprofile'); ?></h5>
                    <p class="text-muted mb-0"><?php echo get_string('pro_feat_obv3_desc', 'local_smartprofile'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Free vs Pro Comparison Table -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header bg-white p-4 border-bottom">
            <h4 class="fw-bold mb-1"><?php echo get_string('pro_compare_title', 'local_smartprofile'); ?></h4>
            <p class="text-muted mb-0"><?php echo get_string('pro_compare_subtitle', 'local_smartprofile'); ?></p>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 px-4"><?php echo get_string('feature', 'core'); ?></th>
                        <th class="py-3 text-center" style="width: 22%;"><?php echo get_string('edition_free', 'local_smartprofile'); ?></th>
                        <th class="py-3 text-center text-primary fw-bold" style="width: 26%; background: #f8fafc;"><?php echo get_string('edition_pro', 'local_smartprofile'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-3 fw-semibold"><?php echo get_string('comp_modern_profile', 'local_smartprofile'); ?></td>
                        <td class="text-center text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                        <td class="text-center text-success bg-light"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 fw-semibold"><?php echo get_string('comp_privacy_toggles', 'local_smartprofile'); ?></td>
                        <td class="text-center text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                        <td class="text-center text-success bg-light"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 fw-semibold"><?php echo get_string('comp_course_progress', 'local_smartprofile'); ?></td>
                        <td class="text-center text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                        <td class="text-center text-success bg-light"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 fw-semibold"><?php echo get_string('comp_wallet_passes', 'local_smartprofile'); ?></td>
                        <td class="text-center text-muted"><i class="fa fa-minus" aria-hidden="true"></i></td>
                        <td class="text-center text-success fw-bold bg-light"><i class="fa fa-check-circle text-primary" aria-hidden="true"></i></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 fw-semibold"><?php echo get_string('comp_cv_builder', 'local_smartprofile'); ?></td>
                        <td class="text-center text-muted"><i class="fa fa-minus" aria-hidden="true"></i></td>
                        <td class="text-center text-success fw-bold bg-light"><i class="fa fa-check-circle text-primary" aria-hidden="true"></i></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 fw-semibold"><?php echo get_string('comp_faculty_endorsements', 'local_smartprofile'); ?></td>
                        <td class="text-center text-muted"><i class="fa fa-minus" aria-hidden="true"></i></td>
                        <td class="text-center text-success fw-bold bg-light"><i class="fa fa-check-circle text-primary" aria-hidden="true"></i></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 fw-semibold"><?php echo get_string('comp_obv3', 'local_smartprofile'); ?></td>
                        <td class="text-center text-muted"><i class="fa fa-minus" aria-hidden="true"></i></td>
                        <td class="text-center text-success fw-bold bg-light"><i class="fa fa-check-circle text-primary" aria-hidden="true"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. Footer CTA -->
    <div class="text-center p-4 bg-white rounded-3 shadow-sm border-0">
        <h5 class="fw-bold mb-2"><?php echo get_string('pro_cta_footer_title', 'local_smartprofile'); ?></h5>
        <p class="text-muted mb-3"><?php echo get_string('pro_cta_footer_desc', 'local_smartprofile'); ?></p>
        <a href="https://services.smartlearn.education/services/plugins/local_smartprofile" target="_blank" rel="noopener" class="btn btn-primary btn-lg fw-bold px-5" style="border-radius: 10px;">
            <i class="fa fa-arrow-up-right-from-square me-2" aria-hidden="true"></i> <?php echo get_string('pro_get_btn', 'local_smartprofile'); ?>
        </a>
    </div>

</div>

<?php
echo $OUTPUT->footer();
