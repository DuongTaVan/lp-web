const mix = require('laravel-mix');
mix.version();

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix vue js
mix.js('resources/js/agora/livestream/teacher.js', 'public/js/agora/livestream/teacher.js')
    .vue();
mix.js('resources/js/agora/livestream/student.js', 'public/js/agora/livestream/student.js')
    .vue();
mix.js('resources/js/clients/commons/message.js', 'public/js/clients/message.js')
    .vue();
// mix style livestream
mix.sass('resources/sass/agora/index.scss', 'public/css/agora/style.css');

mix.scripts([
    'resources/plugins/toastr.min.js',
    'resources/js/portals/commons/toast.js',
], 'public/js/toast.min.js');

mix.scripts([
    'resources/plugins/loadingoverlay.min.js',
    'resources/js/portals/commons/loading.js',
], 'public/js/loading-overlay.min.js');

mix.scripts([
    'node_modules/jquery-validation/dist/jquery.validate.min.js',
    'node_modules/jquery-validation/dist/localization/messages_ja.js'
], 'public/js/jquery.validate.min.js');

mix.scripts([
    'resources/plugins/sharethis.js'
], 'public/js/sharethis.js');

mix.scripts([
    'node_modules/select2/dist/js/select2.min.js',
    'node_modules/select2/dist/js/i18n/ja.js',
], 'public/js/live-search.js');
mix.js('resources/js/portals/commons/custom-validator.js', 'public/js');
mix.js('resources/js/portals/portal.js', 'public/js/portals/portal.js');
mix.js('resources/js/portals/modules/realtime.js', 'public/js/portals/realtime.js');
mix.js('resources/js/portals/modules/discount.js', 'public/js/portals/modules/discount.js');
// merge js to client.js
mix.js('resources/js/clients/modules/course-detail/livestream.js', 'public/js/clients/modules/livestream.js');
mix.js('resources/js/clients/client.js', 'public/js/clients/client.js');
mix.js('resources/js/clients/orders/suborder-detail.js', 'public/js/clients/orders/suborder-detail.js');
mix.js('resources/js/clients/modules/register.js', 'public/js/clients/modules/register.js');
mix.js('resources/js/clients/teachers/create-course-one.js', 'public/js/clients/teachers/create-course-one.js');
mix.js('resources/js/clients/student-livestream/purchase-gift.js', 'public/js/clients/student-livestream/purchase-gift.js');
mix.js('resources/js/clients/orders/cancel-order.js', 'public/js/clients/orders/cancel-order.js');
mix.js('resources/js/clients/teachers/register/identification.js', 'public/js/clients/teachers/register/identification.js');
mix.js('resources/js/clients/teachers/message/buyer.js', 'public/js/clients/teachers/message/buyer.js');
mix.js('resources/js/clients/modules/header.js', 'public/js/clients/modules/header.js');
mix.js('resources/js/clients/modules/search.js', 'public/js/clients/modules/search.js');
mix.js('resources/js/clients/modules/sidebar-left.js', 'public/js/clients/modules/sidebar-left.js');
mix.js('resources/js/portals/commons/box-notification.js', 'public/js/portals/box-notification.js');
mix.copy('node_modules/chart.js/dist/chart.js', 'public/js');
mix.js('resources/js/clients/teachers/preview-course.js', 'public/js/clients/teachers/preview-course.js');
mix.js('resources/js/clients/teachers/preview-clone-course.js', 'public/js/clients/teachers/preview-clone-course.js');
mix.js('resources/js/clients/teachers/preview-course-schedule.js', 'public/js/clients/teachers/preview-course-schedule.js');

mix.js('resources/js/clients/commons/noti.js', 'public/js/clients/commons/noti.js');
mix.js('resources/js/clients/modules/teacher-page.js', 'public/js/clients/teachers/teacher-page.js');
mix.js('resources/js/clients/teachers/teacher-transfer-apply.js', 'public/js/clients/teachers/teacher-transfer-apply.js');
mix.js('resources/js/clients/student/courses-purchasing.js', 'public/js/clients/student/courses-purchasing.js');
mix.js('resources/js/clients/commons/client-ckeditor.js', 'public/js/clients/commons/client-ckeditor.js');
mix.js('resources/js/clients/orders/list-service.js', 'public/js/clients/orders/list-service.js');
mix.js('resources/js/clients/commons/firebase-messaging.js', 'public/js/clients/commons/firebase-messaging.js');
//**************** CSS ********************
mix.sass('resources/sass/portals/portal.scss', 'public/css/portals/style.css');
mix.sass('resources/sass/clients/client.scss', 'public/css/clients/style.css');

// //images
// mix.copy('resources/assets/img', 'public/assets/img');
// // fonts
// mix.copy('resources/assets/fonts', 'public/assets/fonts');
// //sound
// mix.copy('resources/assets/sounds', 'public/assets/sounds');

mix.postCss('resources/plugins/toastr.min.css', 'public/css/toastr.min.css');

//top-logged
mix.sass('resources/sass/clients/home.scss', 'public/css/clients/home.css');
//teacher-page
mix.sass('resources/sass/clients/teacher_page.scss', 'public/css/clients/teacher_page.css');
//home-private
mix.sass('resources/sass/clients/home_private.scss', 'public/css/clients/home-private.css');
mix.sass('resources/sass/clients/modules/livestream.scss', 'public/css/clients/modules/livestream.css');
mix.sass('resources/sass/clients/modules/footer/user-guide.scss', 'public/css/clients/modules/footer/user-guide.css');
mix.sass('resources/sass/clients/modules/footer/live-streaming.scss', 'public/css/clients/modules/footer/live-streaming.css');
mix.sass('resources/sass/clients/modules/footer/video-call.scss', 'public/css/clients/modules/footer/video-call.css');
mix.sass('resources/sass/clients/modules/footer/delivery-method.scss', 'public/css/clients/modules/footer/delivery-method.css');
mix.sass('resources/sass/clients/modules/footer/management-company.scss', 'public/css/clients/modules/footer/management-company.css');
mix.sass('resources/sass/clients/commons/option-search.scss', 'public/css/clients/commons/option-search.css');
mix.sass('resources/sass/clients/modules/teacher/create_course.scss', 'public/css/clients/modules/teacher/create_course.css');
mix.sass('resources/sass/clients/modules/teacher/course/preview.scss', 'public/css/clients/modules/teacher/course/preview.css');
mix.sass('resources/sass/clients/modules/teacher/service-list.scss', 'public/css/clients/modules/teacher/service-list.css');
mix.sass('resources/sass/clients/modules/teacher/seller.scss', 'public/css/clients/modules/teacher/seller.css');
mix.sass('resources/sass/clients/modules/teacher/seller-rank.scss', 'public/css/clients/modules/teacher/seller-rank.css');
mix.sass('resources/sass/clients/modules/teacher/inquiry.scss', 'public/css/clients/modules/teacher/inquiry.css');
mix.sass('resources/sass/clients/modules/teacher/guide.scss', 'public/css/clients/modules/teacher/guide.css');
mix.sass('resources/sass/clients/modules/teacher/become.scss', 'public/css/clients/modules/teacher/become.css');

// custom datetimepicker
mix.scripts([
    'resources/plugins/flatpickr.min.js',
    'resources/plugins/custom-datetimepicker.js',
    'resources/plugins/flatpickr.l10n.ja.js'
], 'public/js/flatpickr.min.js');
mix.scripts('resources/plugins/ckeditor.js', 'public/js/ckeditor.js');
mix.scripts('resources/plugins/lappi-slider.js', 'public/js/lappi-slider.js');
mix.scripts('resources/plugins/auto-bank.js', 'public/js/auto-bank.js');
mix.postCss('resources/plugins/flatpickr.min.css', 'public/css');
//Error Page css
mix.sass('resources/sass/error_page.scss', 'public/css/error_page.css');
// Maintain Page css
mix.sass('resources/sass/maintain_page.scss', 'public/css/maintain_page.css');
//End Error Page css
//Letter Detail
mix.js('resources/js/clients/teachers/letter-detail.js', 'public/js/clients/teachers/letter-detail.js');
//End Letter Detail
//Notification Detail
mix.js('resources/js/clients/teachers/notification-detail.js', 'public/js/clients/teachers/notification-detail.js');
//End Notification Detail
//About payment method
mix.sass('resources/sass/clients/about_payment_method.scss', 'public/css/clients/about_payment_method.css');
//About lappi
mix.sass('resources/sass/clients/about-lappi.scss', 'public/css/clients/about-lappi.css');
//Terms of service
mix.sass('resources/sass/clients/modules/footer/terms-of-service.scss', 'public/css/footer/terms-of-service.css');
//End Terms of service
//Privacy policy
mix.sass('resources/sass/clients/modules/footer/privacy-policy.scss', 'public/css/footer/privacy-policy.css');
//End privacy policy
mix.sass('resources/sass/clients/modules/footer/faq.scss', 'public/css/footer/faq.css');
mix.sass('resources/sass/clients/safety_security.scss', 'public/css/clients/safety_security.css');
//usage fee
mix.sass('resources/sass/clients/usage_fee.scss', 'public/css/clients/usage_fee.css');
//End usage fee
mix.sass('resources/sass/clients/modules/footer/specified-commercial-transaction-law.scss', 'public/css/footer/specified-commercial-transaction-law.css');

mix.sass('resources/sass/clients/modules/footer/guide-new-member.scss', 'public/css/footer/guide-new-member.css');
//
//
mix.sass('resources/sass/clients/seller_guidelines.scss', 'public/css/clients/seller_guidelines.css');
mix.sass('resources/sass/clients/delivery-screen.scss', 'public/css/clients/delivery-screen.css');
