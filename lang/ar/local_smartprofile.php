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

// --- Dynamic Academic CV & PDF Exporter ---
$string['cv_heading'] = 'تصدير السيرة الذاتية والسجل الأكاديمي (PDF)';
$string['cv_desc'] = 'السماح للمتعلمين والكادر بتصدير سيرة ذاتية أكاديمية رسمية بصيغة PDF بنقرة واحدة مع رمز QR موثق.';
$string['enable_cv_export'] = 'تفعيل تصدير السيرة الذاتية الأكاديمية';
$string['enable_cv_export_desc'] = 'عند التفعيل، سيظهر زر "تحميل السيرة الذاتية (PDF)" في أعلى صفحة الملف الشخصي.';
$string['export_cv'] = 'تحميل السيرة الذاتية (PDF)';
$string['cv_title'] = 'السيرة الذاتية الأكاديمية وسجل الإنجازات';
$string['scan_to_verify'] = 'امسح رمز QR للتحقق الفوري من صحة هذه الوثيقة الأكاديمية الرسمية عبر الإنترنت.';
$string['featuredisabled'] = 'هذه الميزة معطلة حالياً من قِبل إدارة الموقع.';

// --- Role-Adaptive Faculty & Educator Showcase ---
$string['faculty_heading'] = 'ملف الكادر التعليمي والأكاديمي (Faculty Showcase)';
$string['faculty_desc'] = 'التحكم في التكيف التلقائي لملفات المعلمين والمحاضرين والأساتذة.';
$string['enable_faculty_mode'] = 'تفعيل العرض المتكيف للكادر الأكاديمي';
$string['enable_faculty_mode_desc'] = 'عند التفعيل، سيتحول مظهر الملف الشخصي للمعلمين والأساتذة تلقائياً لعرض المقررات التي يُدرّسونها، والطلاب، والروابط البحثية، والساعات المكتبية.';
$string['taught_courses'] = 'المقررات التي أُدرّسها';
$string['taught_courses_desc'] = 'المقررات الدراسية النشطة التي يُشرف عليها ويُدرّسها هذا العضو الأكاديمي.';
$string['students_instructed'] = 'إجمالي الطلاب';
$string['academic_disciplines'] = 'التخصصات والأقسام';
$string['faculty_tenure'] = 'الخبرة الأكاديمية';
$string['tenure_year_single'] = 'عضو هيئة تدريس مستجد';
$string['tenure_years_plural'] = '{$a} سنوات من العطاء الأكاديمي';
$string['office_hours'] = 'الساعات المكتبية والاستشارات';
$string['office_location'] = 'المكتب / القاعة';
$string['book_consultation'] = 'حجز موعد استشارة';
$string['academic_research'] = 'الإنتاج والأبحاث الأكاديمية';
$string['research_interests'] = 'الاهتمامات والتخصصات البحثية';
$string['google_scholar'] = 'الباحث العلمي (Google Scholar)';
$string['researchgate'] = 'منصة ResearchGate';
$string['faculty_badge'] = 'عضو هيئة تدريس معتمد';
$string['no_taught_courses'] = 'لا توجد مقررات دراسية نشطة حالياً للعرض.';

// --- Open Badges 3.0 (OBv3) & Mobile Wallet Credentials ---
$string['wallet_heading'] = 'معايير Open Badges 3.0 والمحفظة الرقمية للجوال';
$string['wallet_desc'] = 'السماح للطلاب بتصدير وثائقهم الأكاديمية كبطاقات Apple Wallet (.pkpass) وسجلات Open Badges 3.0 (JSON-LD) المعتمدة دولياً.';
$string['enable_wallet_passes'] = 'تفعيل بطاقات Apple Wallet الرقمية (.pkpass)';
$string['enable_wallet_passes_desc'] = 'عند التفعيل، سيتمكن المتعلمون والجهات المعتمدة من تحميل بطاقة هوية أكاديمية ذكية لمحفظة أبل مزودة برمز استجابة سريعة QR.';
$string['enable_obv3'] = 'تفعيل واجهة Open Badges 3.0 (JSON-LD)';
$string['enable_obv3_desc'] = 'عند التفعيل، ستدعم صفحة التحقق تصدير الإثباتات المشفرة المتوافقة مع معايير 1EdTech و W3C.';
$string['add_to_apple_wallet'] = 'حفظ في Apple Wallet';
$string['export_obv3'] = 'Open Badges 3.0 (JSON-LD)';
$string['wallet_pass_title'] = 'بطاقة الإنجاز الأكاديمي الرقمية';

// --- Academic Endorsements & Faculty Recommendations ---
$string['endorsements_heading'] = 'التوصيات والإشادات الأكاديمية (Faculty Endorsements)';
$string['endorsements_desc'] = 'السماح للأساتذة والمحاضرين بكتابة توصيات أكاديمية وتزكية مهارات الطلاب رسمياً.';
$string['enable_endorsements'] = 'تفعيل التوصيات الأكاديمية للكادر التعليمي';
$string['enable_endorsements_desc'] = 'عند التفعيل، سيتمكن المعلمون من تزكية مهارات طلابهم وكتابة شهادات تقديرية معتمدة على ملفاتهم الشخصية.';
$string['write_endorsement'] = 'كتابة توصية أكاديمية';
$string['no_endorsements_yet'] = 'لم تتم إضافة توصيات أكاديمية لهذا الطالب حتى الآن.';
$string['be_first_to_endorse'] = 'كن أول معلم يُزكّي هذا الطالب ويكتب له توصية';
$string['endorsed_skill'] = 'المهارة أو الكفاءة الأكاديمية المُزكاة';
$string['endorsed_skill_placeholder'] = 'مثال: تعلم الآلة، التحليل الإحصائي، مهارات القيادة والعمل الجماعي...';
$string['general_endorsement'] = 'توصية أكاديمية عامة';
$string['rating'] = 'تقييم الإشادة والأداء الأكاديمي';
$string['rating_exceptional'] = 'أداء استثنائي ومتميز';
$string['rating_very_good'] = 'جيد جداً';
$string['rating_good'] = 'جيد';
$string['recommendation_text'] = 'نص التوصية والشهادة التقديرية';
$string['recommendation_placeholder'] = 'اكتب شهادة تفصيلية توضح تميز الطالب ونقاط قوته وإنجازاته في المقرر أو المشاريع المشتركة...';
$string['submit_endorsement'] = 'نشر التوصية الأكاديمية المعتمدة';
$string['endorsement_added_success'] = 'تم نشر التوصية الأكاديمية بنجاح على الملف الشخصي للطالب.';
$string['endorsement_deleted_success'] = 'تم حذف التوصية بنجاح.';
$string['endorsement_empty_skill'] = 'يرجى كتابة المهارة أو الكفاءة الأكاديمية لتزكيتها.';
$string['delete_confirm'] = 'هل أنت متأكد من رغبتك في حذف هذه التوصية؟';
$string['verified_faculty'] = 'عضو هيئة تدريس معتمد';

// --- SmartDashboard Interop & Enterprise White-Labeling ---
$string['interop_heading'] = 'التكامل مع SmartDashboard والتخصيص المؤسسي (White-Labeling)';
$string['interop_desc'] = 'ربط SmartProfile مع SmartDashboard وتخصيص هوية وألوان المؤسسة التعليمية.';
$string['enable_smartdashboard_interop'] = 'تفعيل الربط التكاملي مع SmartDashboard';
$string['enable_smartdashboard_interop_desc'] = 'عند التفعيل ووجود إضافة local_smartdashboard، ستظهر أزرار الانتقال المباشر والتحليلات الأكاديمية الشاملة 360° في الملف الشخصي.';
$string['open_smartdashboard'] = 'فتح لوحة التحكم SmartDashboard';
$string['custom_primary_color'] = 'لون الهوية الرئيسي (HEX)';
$string['custom_primary_color_desc'] = 'تخصيص اللون الأساسي لكافة مكونات الملف الشخصي (مثل: #10b981 أو #2563eb). اتركه فارغاً لاستخدام النمط الافتراضي.';
$string['custom_logo_url'] = 'رابط شعار المؤسسة المخصص (Logo URL)';
$string['custom_logo_url_desc'] = 'رابط صورة الشعار المؤسسي لعرضه في السير الذاتية وبطاقات المحفظة الرقمية وصفحة التحقق.';
$string['custom_footer_tagline'] = 'شعار التذييل المؤسسي (Footer Tagline)';
$string['custom_footer_tagline_desc'] = 'نص حقوق الملكية أو الشعار التقديري الذي يظهر في أسفل صفحة الملف الشخصي.';
$string['custom_css'] = 'تنسيقات CSS مخصصة (Custom CSS)';
$string['custom_css_desc'] = 'أكواد CSS إضافية تُحقن مباشرة في صفحات SmartProfile لتطبيق الهوية البصرية الخاصة بمؤسستك بدقة.';

// --- Classic Moodle System Profile & Report Links ---
$string['classic_profile'] = 'ملف مودل الأصلي';
$string['moodle_system_profile'] = 'ملف مودل والتقارير الأكاديمية';
$string['view_classic_profile'] = 'فتح ملف مودل الافتراضي للنظام';
$string['course_profile'] = 'عرض ملف المقرر الافتراضي';
$string['reports_and_logs'] = 'التقارير وسجلات النشاط';
$string['todays_logs'] = 'سجلات نشاط اليوم';
$string['all_logs'] = 'كافة سجلات النشاط';
$string['outline_report'] = 'تقرير الأنشطة والمشاركات';
$string['complete_report'] = 'تقرير النشاط الشامل';
$string['user_contributions'] = 'المشاركات والأدوات';
$string['forum_posts'] = 'مشاركات المنتديات';
$string['forum_discussions'] = 'نقاشات المنتديات';
$string['teacher_notes'] = 'ملاحظات المعلم';
$string['learning_plans'] = 'خطط التعلم والجدارات';
$string['browser_sessions'] = 'جلسات المتصفح النشطة';
$string['send_message'] = 'إرسال رسالة';

// --- Privacy Metadata ---
$string['privacy:metadata:endorse'] = 'يخزن التوصيات الأكاديمية وشهادات التزكية التي يكتبها المعلمون لطلابهم.';
$string['privacy:metadata:endorse:userid'] = 'معرف الطالب الذي يتلقى التوصية.';
$string['privacy:metadata:endorse:endorserid'] = 'معرف المعلم الذي كتب التوصية.';
$string['privacy:metadata:endorse:skill'] = 'المهارة أو الكفاءة الأكاديمية المزكاة.';
$string['privacy:metadata:endorse:recommendation'] = 'نص التوصية والشهادة التقديرية.';
$string['privacy:metadata:endorse:rating'] = 'التقييم الممنوح.';
$string['privacy:metadata:endorse:timecreated'] = 'وقت إنشاء التوصية.';

// --- Preferences Page Strings ---
$string['profile_visibility_settings'] = 'إعدادات الخصوصية وظهور الملف الأكاديمي';
$string['profile_visibility_desc'] = 'حدد العناصر التي يمكن للطلاب والمعلمين والزوار الآخرين رؤيتها في ملفك الأكاديمي.';
$string['privacy_category_contact'] = 'بيانات الاتصال والموقع';
$string['privacy_category_about'] = 'السيرة الذاتية والمهارات';
$string['privacy_category_academic'] = 'التقدم الأكاديمي والمقررات';
$string['privacy_category_gamification'] = 'الأوسمة والتحفيز والمستويات';
$string['privacy_category_activity'] = 'سجل النشاط التعليمي الأخير';
$string['back_to_profile'] = 'العودة إلى الملف الأكاديمي';
$string['click_to_toggle'] = 'انقر للتبديل بين عام / خاص';
$string['saved'] = 'تم حفظ التفضيلات بنجاح';

// --- Privacy Data Export Strings ---
$string['privacy:data:endorsementsreceived'] = 'التوصيات المستلمة';
$string['privacy:data:endorsementsauthored'] = 'التوصيات المكتوبة';

// --- Endorsement Errors ---
$string['endorsement_notfound'] = 'لا يمكن العثور على التوصية. ربما تم حذفها مسبقاً.';

// --- Real Activity & Facts Strings ---
$string['website'] = 'الموقع الإلكتروني';
$string['credithours_earned'] = 'الساعات المعتمدة المكتسبة';
$string['activity_badge_earned'] = 'حصل على شارة "{$a}"';
$string['activity_course_completed'] = 'أكمل مقرر "{$a}"';

// --- Pro Upgrade Promo Strings ---
$string['upgrade_to_pro'] = 'النسخة الاحترافية Pro';
$string['upgrade_to_pro_title'] = 'استكشف المزايا الاحترافية لـ SmartProfile Pro';
$string['pro_promo_heading'] = '⭐ النسخة الاحترافية والمؤسسية SmartProfile Pro';
$string['pro_promo_desc'] = 'هل تبحث عن بطاقات Apple Wallet الرقمية، وشهادات Open Badges 3.0، وبناء السير الذاتية PDF، وتوصيات أعضاء هيئة التدريس؟ <a href="https://smartlearn.education" target="_blank" class="btn btn-sm btn-primary ms-2">استكشف مزايا Pro ↗</a>';
