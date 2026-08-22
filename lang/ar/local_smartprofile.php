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
$string['membersince'] = 'عضو منذ';
$string['joined'] = 'تاريخ الانضمام';

// --- Metrics & Facts Ribbon ---
$string['coursesenrolled'] = 'المقررات المسجلة';
$string['coursescompleted'] = 'المقررات المكتملة';
$string['overallprogress'] = 'نسبة الإنجاز الكلية';
$string['certificates'] = 'الشهادات المكتسبة';
$string['badgesearned'] = 'الأوسمة المكتسبة';
$string['currentstreak'] = 'سلسلة النشاط المستمر';

// --- Performance & Cards ---
$string['learningperformance'] = 'الأداء والإنجاز التعليمي';
$string['viewfullanalytics'] = 'عرض التحليلات الكاملة';
$string['averagegrade'] = 'معدل الدرجات العام';
$string['activitiescompleted'] = 'الأنشطة المكتملة';
$string['assessmentscompleted'] = 'التقييمات المنجزة';
$string['timespentlearning'] = 'الوقت المستغرق في التعلم';

$string['achievements'] = 'الأوسمة والإنجازات';
$string['learningjourney'] = 'مسيرة التعلم';
$string['section_about'] = 'نبذة عني';
$string['section_contact'] = 'معلومات التواصل';
$string['profilevisibility'] = 'إعدادات الخصوصية والظهور';
$string['privacy_info'] = 'اضغط على الشارات أدناه للتبديل بين إظهار أو إخفاء معلوماتك عن زملائك الطلاب.';
$string['recentactivity'] = 'النشاط الأخير';
$string['skills'] = 'المهارات والخبرات';
$string['connect'] = 'التواصل والشبكات';
$string['issued'] = 'تاريخ الإصدار';
$string['footertagline'] = 'تمكين المتعلمين وإبراز الإنجازات الأكاديمية.';

$string['interests'] = 'الاهتمامات';
$string['nocourses'] = 'لا توجد مقررات دراسية لعرضها حالياً.';
$string['nobadges'] = 'لم يتم الحصول على أوسمة بعد.';
$string['completedcourses'] = 'المقررات المكتملة';
$string['nocompletedcourses'] = 'لا توجد مقررات مكتملة لعرضها حالياً.';
$string['nocertificates'] = 'لم يتم الحصول على شهادات بعد.';
$string['completedon'] = 'تاريخ الإتمام';
$string['completed'] = 'مكتمل';
$string['progress'] = 'نسبة الإنجاز';
$string['dateissued'] = 'تاريخ الإنجاز';
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
$string['field_completedcourses'] = 'المقررات المكتملة';
$string['field_performance'] = 'الأداء الأكاديمي';
$string['field_certificates'] = 'الشهادات';
$string['field_badges'] = 'الأوسمة';
$string['field_gamelevel'] = 'المستوى ونقاط الخبرة';
$string['field_skills'] = 'المهارات والخبرات';
$string['field_social'] = 'روابط التواصل';
$string['field_activity'] = 'إحصائيات النشاط';

// --- AJAX & Feedback ---
$string['pref_saved'] = 'تم تحديث خيار الخصوصية بنجاح.';
$string['pref_error'] = 'تعذر حفظ إعدادات الخصوصية.';
$string['error_access_denied'] = 'تم رفض الوصول.';

// --- Rewards & Trophies ---
$string['points_label'] = 'نقطة';
$string['trophies'] = 'الجوائز والكؤوس';
$string['trophy_singular'] = 'كأس واحد 🏆';
$string['trophies_plural'] = '{$a} كؤوس وجوائز 🏆';
$string['credithours'] = 'ساعات معتمدة';
$string['credithours_display'] = '{$a} ساعة معتمدة';
$string['credithours_breakdown'] = 'تفصيل الساعات المعتمدة الأكاديمية';
$string['credithours_breakdown_desc'] = 'الساعات المعتمدة المكتسبة موزعة حسب الأقسام والتخصصات الأكاديمية';
$string['totalcredithours'] = 'إجمالي الساعات المعتمدة';
$string['wallet'] = 'عرض المحفظة';

// --- Privacy API ---
$string['privacy:metadata:preference:visibility'] = 'تخزين تفضيلات المستخدم الخاصة بظهور الحقول (عام / خاص).';

// --- Social & LinkedIn Sharing ---
$string['sharing_heading'] = 'مشاركة الإنجازات والشهادات عبر LinkedIn ووسائل التواصل';
$string['sharing_desc'] = 'السماح للطلاب بمشاركة إنجازاتهم وساعاتهم المعتمدة عبر LinkedIn وشبكات التواصل الاجتماعي.';
$string['show_shareonlinkedin'] = 'إظهار خيار المشاركة على LinkedIn';
$string['show_shareonlinkedin_desc'] = 'حدد الوجهة المستهدفة عند النقر على رابط التحقق من الشهادة المعتمدة.';
$string['share_disabled'] = 'عدم الإظهار';
$string['share_link_verification'] = 'إظهار رابط لصفحة التحقق العامة المعتمدة';
$string['share_link_profile'] = 'إظهار رابط لملف الطالب الشخصي';
$string['linkedin_org_id'] = 'معرّف المنظمة على LinkedIn (Organization ID)';
$string['linkedin_org_id_desc'] = 'المعرّف الرقمي لصفحة المنظمة على LinkedIn (مثل 1234567). في حال تركه فارغاً سيتم التعرف عليه تلقائياً من إضافة tool_certificate إن وُجدت.';
$string['issuer_name'] = 'اسم الجهة / الأكاديمية المصدرة';
$string['issuer_name_desc'] = 'اسم المؤسسة الذي يظهر على الشهادات المعتمدة (الافتراضي: اسم الموقع).';

$string['share_achievements'] = 'مشاركة الإنجازات';
$string['add_to_linkedin'] = 'إضافة إلى LinkedIn';
$string['share_on_linkedin'] = 'إضافة إلى ملف LinkedIn الشخصي';
$string['share_to_linkedin_feed'] = 'مشاركة كمنشور على LinkedIn';
$string['share_to_x'] = 'مشاركة عبر منصة X (تويتر)';
$string['share_to_whatsapp'] = 'مشاركة عبر واتساب';
$string['share_to_facebook'] = 'مشاركة عبر فيسبوك';
$string['copy_verify_link'] = 'نسخ رابط التحقق المعتمد';
$string['link_copied'] = 'تم نسخ الرابط إلى الحافظة بنجاح!';
$string['share_modal_title'] = 'مشاركة الإنجاز الأكاديمي';
$string['share_modal_subtitle'] = 'استعرض إنجازك المعتمد على LinkedIn وشبكات التواصل الاجتماعي.';
$string['share_total_msg'] = '🎓 فخور بإتمام {$a->credits} و {$a->trophies} في {$a->site}! شاهد ملفي الأكاديمي المعتمد: {$a->url}';
$string['share_cat_msg'] = '🎓 لقد أتممت بنجاح {$a->credits} في تخصص {$a->category} في {$a->site}! شاهد سجلي الأكاديمي المعتمد: {$a->url}';

// --- Public Verification Page ---
$string['verify_title'] = 'التحقق من الشهادة الأكاديمية المعتمدة';
$string['verified_credential'] = 'سجل أكاديمي معتمد';
$string['verified_seal'] = 'وثيقة أكاديمية موثقة ومعتمدة رسمياً';
$string['verified_by'] = 'تم التوثيق والاعتماد بواسطة {$a}';
$string['verified_recipient'] = 'ممنوحة إلى';
$string['verified_subject'] = 'التخصص / القسم الأكاديمي';
$string['verified_hours'] = 'إجمالي الساعات المعتمدة المكتسبة';
$string['verified_code'] = 'رقم الوثيقة المعتمدة';
$string['verified_date'] = 'تاريخ التحقق';
$string['verified_subcats'] = 'المقررات والتخصصات الفرعية المكتملة';
$string['invalid_verification'] = 'رابط التحقق غير صالح أو لم يتم العثور على السجل الأكاديمي.';
