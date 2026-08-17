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
 * Arabic language strings for local_smartprofile.
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'الملف الشخصي الذكي (Smart Profile)';
$string['smartprofile:view'] = 'عرض الملف الشخصي الذكي';
$string['smartprofile:viewallfields'] = 'عرض جميع حقول الملف الشخصي متجاوزاً إعدادات الخصوصية (تجاوز الكادر التعليمي)';

// --- Settings ---
$string['redirect_heading'] = 'إعادة توجيه الملف الشخصي';
$string['redirect_desc'] = 'التحكم في كيفية إعادة توجيه المستخدمين إلى صفحة الملف الشخصي الذكي.';
$string['enableredirect'] = 'تفعيل إعادة التوجيه للملف الشخصي';
$string['enableredirect_desc'] = 'عند التفعيل، سيتم تحويل زيارات الملف الشخصي الافتراضي (/user/profile.php) تلقائياً إلى الملف الشخصي الذكي.';
$string['redirectroles'] = 'الأدوار المعاد توجيهها';
$string['redirectroles_desc'] = 'حدد الأدوار التي سيتم إعادة توجيهها. في حال عدم تحديد أي دور، سيتم تحويل جميع المستخدمين المسجلين.';
$string['redirectadmins'] = 'إعادة توجيه مدراء النظام';
$string['redirectadmins_desc'] = 'هل يتم تحويل مدراء النظام أيضاً إلى الملف الشخصي الذكي.';

$string['appearance_heading'] = 'المظهر والسمة';
$string['appearance_desc'] = 'تخصيص المظهر العام لصفحة الملف الشخصي الذكي.';
$string['thememode'] = 'وضع السمة';
$string['thememode_desc'] = 'اختر الوضع اللوني الافتراضي للصفحة.';
$string['thememode_auto'] = 'تلقائي (مطابق للنظام / القالب)';
$string['thememode_dark'] = 'الوضع الليلي (Dark Mode)';
$string['thememode_light'] = 'الوضع الفاتح (Light Mode)';

$string['sections_heading'] = 'أقسام الملف الشخصي';
$string['sections_desc'] = 'تفعيل أو تعطيل أقسام محددة في صفحة الملف الشخصي.';
$string['showcourses'] = 'عرض قسم المقررات الدراسية';
$string['showcourses_desc'] = 'عرض المقررات المسجل بها مع نسبة الإنجاز والتقدم.';
$string['showbadges'] = 'عرض قسم الأوسمة والشهادات';
$string['showbadges_desc'] = 'عرض الأوسمة المكتسبة في شبكة بصرية جذابة.';
$string['showactivity'] = 'عرض قسم النشاط وتاريخ الدخول';
$string['showactivity_desc'] = 'عرض آخر تسجيل دخول وإحصائيات النشاط.';
$string['showgamification'] = 'عرض قسم التحفيز والمهام (Gamification)';
$string['showgamification_desc'] = 'عرض المستوى ونقاط الخبرة في حال كان ملحق format_quest مثبتاً.';

// --- Profile Page UI ---
$string['editprofile'] = 'تعديل الملف الشخصي';
$string['preferences'] = 'التفضيلات';
$string['viewgrades'] = 'عرض الدرجات';
$string['lastseen'] = 'آخر ظهور';
$string['justnow'] = 'الآن';
$string['minutesago'] = 'منذ {$a} د';
$string['hoursago'] = 'منذ {$a} س';
$string['daysago'] = 'منذ {$a} ي';

$string['section_about'] = 'نبذة عني';
$string['section_contact'] = 'معلومات التواصل';
$string['section_courses'] = 'المقررات المسجلة';
$string['section_badges'] = 'الأوسمة المكتسبة';
$string['section_gamification'] = 'المغامرة والإنجازات';
$string['section_activity'] = 'نشاط الحساب';
$string['section_privacy'] = 'إعدادات الخصوصية الشخصية';
$string['privacy_info'] = 'اضغط على الشارات أدناه للتبديل بين إظهار أو إخفاء معلوماتك عن زملائك الطلاب.';

$string['interests'] = 'الاهتمامات';
$string['nocourses'] = 'لا توجد مقررات دراسية لعرضها حالياً.';
$string['nobadges'] = 'لم يتم الحصول على أوسمة بعد.';
$string['completed'] = 'مكتمل';
$string['progress'] = 'نسبة الإنجاز';
$string['dateissued'] = 'تاريخ الحصول: {$a}';
$string['firstaccess'] = 'أول دخول للنظام';
$string['lastaccess'] = 'آخر نشاط';
$string['ipaddress'] = 'عنوان IP';

$string['status_public'] = 'عام';
$string['status_private'] = 'خاص';
$string['make_public'] = 'جعله عاماً';
$string['make_private'] = 'جعله خاصاً';
$string['visibility_toggle_help'] = 'التبديل بين عام (مرئي لزملائك الطلاب) وخاص (مخفي عن زملائك). المعلمون وإدارة النظام يمكنهم دائماً رؤية البيانات كاملة.';

// --- Fields ---
$string['field_email'] = 'البريد الإلكتروني';
$string['field_phone'] = 'رقم الهاتف';
$string['field_city'] = 'المدينة';
$string['field_country'] = 'الدولة';
$string['field_timezone'] = 'المنطقة الزمنية';
$string['field_description'] = 'النبذة الشخصية';
$string['field_interests'] = 'الاهتمامات';
$string['field_courses'] = 'المقررات';
$string['field_badges'] = 'الأوسمة';
$string['field_gamelevel'] = 'المستوى ونقاط الخبرة';
$string['field_activity'] = 'إحصائيات النشاط';

// --- AJAX & Feedback ---
$string['pref_saved'] = 'تم تحديث خيار الخصوصية بنجاح.';
$string['pref_error'] = 'تعذر حفظ إعدادات الخصوصية.';
$string['error_access_denied'] = 'تم رفض الوصول.';

// --- Privacy API ---
$string['privacy:metadata:preference:visibility'] = 'تخزين تفضيلات المستخدم الخاصة بظهور الحقول (عام / خاص).';
