<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * DBConstant enum.
 */
class DBConstant extends BaseEnum
{
    const IS_SKILLS_SUB = 1;
    const COURSE_SCHEDULE_NOT_BOOKED = 0;
    const BANK_TYPE = 0;
    const BRANCH_TYPE = 1;
    const IDENTITY_VERIFICATION_DISPLAY_FIRST = 0;
    const IDENTITY_VERIFICATION_DISPLAY_LAST = 1;
    const USER_NEW_SERVICE = 1;
    const FIXED_NUM_DRAB = 1;
    const LIST_COURSE_STATUS = [0, 2, 3];
    const ALL_CATEGORY = [1, 2, 3];
    const TYPE_CATEGORY_LIVESTREAM = 1;
    const STATUS_ORDER_LIST = 2;
    const STATUS_ORDER_END_LIST = 3;
    const STATUS_COURSE_SCHEDULE_OPEN = 0;
    // [users] user_type
    const USER_TYPE_STUDENT = 1;
    public const USER_TYPE_TEACHER = 2;
    const COURSE_TYPE = 1;
    const STATUS_ORDER_CANCEL = 0;

    // [users] teacher_type
    const TEACHER_TYPE_INDIVIDUAL = 1;
    const TEACHER_TYPE_FREELANCE = 2;
    const TEACHER_TYPE_CORPORATION = 3;

    // [users] teacher_category
    const TEACHER_CATEGORY_SKILLS = 1;
    const TEACHER_CATEGORY_CONSULTATION = 1;
    const TEACHER_CATEGORY_FORTUNETELLING = 1;

    // [users] text teacher_category
    const TEXT_TEACHER_CATEGORY_SKILLS = "teacher_category_skills";
    const TEXT_TEACHER_CATEGORY_CONSULTATION = "teacher_category_consultation";
    const TEXT_TEACHER_CATEGORY_FORTUNETELLING = "teacher_category_fortunetelling";

    // [users] login_type
    const LOGIN_TYPE_EMAIL = 'EMAIL';
    const LOGIN_TYPE_LINE = 'LINE';
    const LOGIN_TYPE_FACEBOOK = 'FACEBOOK';
    const LOGIN_TYPE_GOOGLE = 'GOOGLE';

    const ITEM_PER_PAGE = [
        '10' => '10',
        '25' => '25',
        '100' => '100',
    ];

    // [users] sex
    const SEX_MALE = 1;
    const SEX_FEMALE = 2;
    const SEX_OTHER = 0;
    const SEX_NOT_APPLICABLE = 9;

    // [users] identity_verification_status
    const IDENTITY_VERIFICATION_STATUS_NOT_YET_APPLIED = 0;
    const IDENTITY_VERIFICATION_STATUS_APPLIED = 1;
    const IDENTITY_VERIFICATION_STATUS_REJECTED = 2;
    const IDENTITY_VERIFICATION_STATUS_APPROVED = 3;

    // [users] business_card_verification_status
    const BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED = 0;
    const BUSINESS_CARD_VERIFICATION_STATUS_APPLIED = 1;
    const BUSINESS_CARD_VERIFICATION_STATUS_REJECTED = 2;
    const BUSINESS_CARD_VERIFICATION_STATUS_APPROVED = 3;

    // [users] user_status
    const USER_STATUS_ACTIVE = 0;
    const USER_STATUS_DEACTIVE = 1;

    // [users] connect_verification_session
    public const CONNECT_VERIFICATION_SESSION_PENDING = 0;
    public const CONNECT_VERIFICATION_SESSION_FAIL = 1;
    public const CONNECT_VERIFICATION_SESSION_SUCCESS = 2;

    // [users] connect_verification_read
    public const CONNECT_VERIFICATION_READ = 1;
    public const CONNECT_VERIFICATION_NOT_READ = 0;

    // [image_paths] type
    const IMAGE_TYPE_IDENTITY_VERIFICATION = 1;
    const IMAGE_TYPE_BUSINESS_CARD = 2;
    const IMAGE_TYPE_COURSE = 3;
    const IMAGE_COURSE_DISPLAY = 1;
    public const BUSINESS_DISPLAY = 0;

    // [categories] type
    const CATEGORY_TYPE_SKILLS = 1;
    const CATEGORY_TYPE_CONSULTATION = 2;
    const CATEGORY_TYPE_FORTUNETELLING = 3;

    // [courses] type
    const COURSE_TYPE_MAIN = 1;
    const COURSE_TYPE_SUB = 2;
    const COURSE_TYPE_EXTENSION = 3;

    // [courses] dist_method
    const DIST_METHOD_LIVE_STREAMING = 1;
    const DIST_METHOD_LIVE_VIDEO_CALL = 2;

    // course facemask
    const FACEMASK_OK = 0;
    const FACEMASK_NG = 1;

    //course
    const FIXED_NUM_MIN = 1;
    const FIXED_NUM_MAX = 9999999999;

    // courses status
    const COURSE_STATUS_OPEN = 0;
    const COURSE_STATUS_CLOSE = 1;
    const COURSE_STATUS_PREVIEW = 8;
    const COURSE_STATUS_DRAFT = 9;
    public const COURSE_STATUS_DRAFT_TEXT = '下書き保存';
    const COURSE_STATUS_WAIT_APPROVAL = 10;

    // approval status course
    const COURSE_NOT_REVIEW = 0;
    const COURSE_REJECT = 1;
    const COURSE_APPROVED = 2;
    const COURSE_APPROVED_STATUS_PENDING = 0;

    // [course schedules] type
    const COURSE_SCHEDULES_TYPE_RESERVATION = 1;
    const COURSE_SCHEDULES_TYPE_EXTENSION = 2;

    // [course schedules] status
    const COURSE_SCHEDULES_STATUS_OPEN = 0;
    const COURSE_SCHEDULES_STATUS_CANCELED = 1;
    const COURSE_SCHEDULES_STATUS_CLOSED = 2;
    const COURSE_SCHEDULES_STATUS_RECORDED = 3;
    const COURSE_SCHEDULES_STATUS_PENDING = 4;
    const COURSE_SCHEDULES_STATUS_PREVIEW = 8;
    const COURSE_SCHEDULES_STATUS_DRAFT = 9;
    public const COURSE_SCHEDULES_STATUS_CLONE = 10;

    const COURSE_SCHEDULE_REGISTER_STEP_1 = 1;
    const COURSE_SCHEDULE_REGISTER_STEP_2 = 2;
    const COURSE_SCHEDULE_REGISTER_STEP_3 = 3;

    // [caches] deposit_reason
    const DEPOSIT_REASON_SERVICES = 1;

    // [caches] withdrawal_reason
    const WITHDRAWAL_REASON_WITHDRAWAL_REQUEST = 1;

    // [user_points] deposit_reason
    const DEPOSIT_REASON_FROM_CONSOLE_USER = 1;

    // [user_points] withdrawal_reason
    const WITHDRAWAL_REASON_EXCHANGE_FOR_CASH = 1;
    const WITHDRAWAL_REASON_POINTS_EXPIRED = 2;

    // [purchases] status
    const PURCHASES_STATUS_NOT_CAPTURED = 0;
    const PURCHASES_STATUS_NOT_CANCELED_BEFORE_CAPTURE = 1;
    const PURCHASES_STATUS_CAPTURED = 2;
    const PURCHASES_STATUS_CANCELED_AFTER_CAPTURE = 3;

    // [settlements] payment_method
    const PAYMENT_METHOD_CREDIT_CARD = 1;
    const PAYMENT_METHOD_APPLE_PAY = 2;
    const PAYMENT_METHOD_GOOGLE_PAY = 3;

    // [settlements] status
    const PAYMENT_STATUS_APPROVAL_ERROR = 1;
    const PAYMENT_STATUS_APPROVED = 2;
    const PAYMENT_STATUS_CAPTURE_ERROR = 3;
    const PAYMENT_STATUS_CAPTURED = 4;
    const PAYMENT_STATUS_VOID_ERROR = 5;
    const PAYMENT_STATUS_VOIDED = 6;

    // [settlements] currency
    const CURRENCY_DEFAULT = 'JPY';

    // [bank accounts] account_type
    const BANK_ACCOUNT_TYPE_SAVINGS = 1;
    const BANK_ACCOUNT_TYPE_CHECKING = 2;
    const BANK_ACCOUNT_TYPE_TIME_DEPOSIT = 3;

    // [box notification master contents] timing_type
    const BOX_NOTIFICATION_TIMING_TYPE_ANY_TIMING = 99;

    // [email notifications] status
    const EMAIL_SENDING_STATUS_NOT_SENT = 0;
    const EMAIL_SENDING_STATUS_SENT = 1;
    const EMAIL_SENDING_STATUS_ERROR = 2;

    // [email authentications password_reset] user_type
    const AUTHENTICATIONS_USER_TYPE_GENERAL = 1;
    const AUTHENTICATIONS_USER_TYPE_CONSOLE = 2;

    // List category type
    const LIST_CATEGORY_TYPE = [
        'all' => 0, // 全社計
        'live_stream' => 1, // 教えて！ライブ配信
        'trouble_consultation' => 2, // オンライン悩み相談
        'fortune_telling' => 3, // オンライン占い
    ];

    const LIST_CATEGORY = [
        0 => '全社計',
        1 => '教えて！ライブ配信',
        2 => 'オンライン悩み相談計',
        3 => 'オンライン占い計'
    ];
    const CATEGORY_LIST = [
        1 => '教えて！ライブ配信',
        2 => 'オンライン悩み相談',
        3 => 'オンライン占い'
    ];
    const LIST_TARGET_MONTH = [
        1 => '上半期業績',
        2 => '下半期業績'
    ];

    // [users] registration_status
    const REGISTRATION_STATUS_NOT_AUTHENTICATED = 0;
    const REGISTRATION_STATUS_AUTHENTICATED = 1;
    const REGISTRATION_STATUS_STEP1_COMPLETED = 2;
    const REGISTRATION_STATUS_STEP2_COMPLETED = 3;

    // [users] is_archived
    const NOT_ARCHIVED_FLAG = 0;
    const ARCHIVED_FLAG = 1;

    // [image_paths] status
    const IMAGE_PATH_STATUS = [
        'applying' => 0,
        'reject' => 1,
        'approved' => 2,
        'temp' => 9
    ];

    const BOX_NOTIFICATION_TRANS_CONTENT_TO_TYPE = [
        '1' => "購入者",
        '2' => "講師",
    ];
    const BOX_NOTIFICATION_TRANS_CONTENT_TO_TYPE_PORTAL = [
        '1' => "購入者",
        '2' => "出品者",
    ];
    // [image_paths] type
    const IMAGE_PATH_TYPE = [
        'identity_verification' => 1,
        'business_verification' => 2,
        'course' => 3,
        'background' => 4
    ];

    // [transfer_histories] status
    const TRANSFER_HISTORY_STATUS = [
        'applied' => 0,
        'approved' => 1,
    ];

    // [box_notification_trans_contents] type
    const BOX_NOTIFICATION_TRANS_CONTENT_TYPE = [
        'to_all' => 1,
        'to_teacher' => 2
    ];

    // [box_notification_trans_contents] is_delivered
    const BOX_NOTIFICATION_TRANS_CONTENT_IS_DELIVERED = [
        'not_delivered' => 0,
        'delivered' => 1
    ];

    // [box_notifications] is_read
    const BOX_NOTIFICATION_IS_READ = [
        'not_read' => 0,
        'read' => 1
    ];

    // [user-points] is_consumed
    const USER_POINT_IS_CONSUMED = [
        'not_consumed' => 0,
        'consumed' => 1
    ];

    // [user-points] is_processed
    const USER_POINT_IS_PROCESSED = [
        'not_processed' => 0,
        'processed' => 1
    ];

    // [user-points] withdrawal_reason
    const USER_POINT_WITHDRAWAL_REASON = [
        'exchange_for_cash' => 1,
        'points_expired' => 2
    ];

    // [categories] category_id
    const CATEGORY_ID = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33];

    // [sales] is_imported
    const SALE_CANCELLATION_FEE = 0;
    const SALE_NOT_IMPORTED = 0;
    const SALE_IMPORTED = 1;

    // [sales] is_imported
    public const SALE_NOT_PAYOUT = 0;
    public const SALE_PAYOUT = 1;

    const WITHDRAWAL_STATUS = [
        "0" => "申請中",
        "1" => "承認済み"
    ];
    public const WITHDRAWAL_STATUS_PORTAL = [
        '0' => '承認待ち',
        '1' => '承認済み'
    ];
    public const TRANSFER_STATUS_PORTAL = [
        '0' => '入金待ち',
        '3' => '入金済み',
        '4' => '振込エラー',
        '7' => '残高エラー',
    ];
    // [user] user_type
    const USER_TYPE = [
        "1" => "購入者",
        "2" => "出品者"
    ];

    // [user] sex
    const SEX = [
        "1" => "男性",
        "2" => "女性",
        "9" => "その他",
        "0" => '無回答'
    ];

    // [user] identity_verification_status
    const IDENTITY_VERIFICATION_STATUS = [
        "0" => "未申請",
        "1" => "申請中",
        "2" => "却下",
        "3" => "承認済み"
    ];

    // [user_point]
    const DEFAULT_LIMIT_PURCHASE_POINT = 10;

    // [user] business_card_verification_status
    const BUSINESS_CARD_VERIFICATION_STATUS = [
        "0" => "未申請",
        "1" => "申請中",
        "2" => "却下",
        "3" => "承認済み"
    ];
    const IMAGE_PATHS_STATUS = [
        "0" => "承認待ち",
        "1" => "否認",
        "2" => "承認",
    ];

    const APPROVAL_STATUS = [
        "0" => "承認待ち",
        "1" => "否認",
        "2" => "承認"
    ];
    const BOX_NOTIFICATION_TO_TYPE_OPTION = [
        "1" => "購入者",
        "2" => "出品者",
    ];
    const APPROVAL_STATUS_COURSE = 0;
    // [users] user_type
    const USER_TYPE_GENERAL_USER = 1;
    const USER_TYPE_SALES_SUPPORT_USER = 2;
    const USER_TYPE_HOST_USER = 2;

    // [settlements] status
    const SETTLEMENT_STATUS_APPROVAL_ERROR = 1;
    const SETTLEMENT_STATUS_APPROVED = 2;
    const SETTLEMENT_STATUS_CAPTURE_ERROR = 3;
    const SETTLEMENT_STATUS_CAPTURED = 4;
    const SETTLEMENT_STATUS_VOID_ERROR = 5;
    const SETTLEMENT_STATUS_VOIDED_CANCELED = 6;
    public const SETTLEMENT_STATUS_PENDING = 7;

    const IS_LAPPI_NEW = 1;
    const IS_NOT_LAPPI_NEW = 0;

    const IS_LAPPI_REPEATER = 1;
    const IS_NOT_LAPPI_REPEATER = 0;

    const IS_TEACHER_NEW = 1;
    const IS_NOT_TEACHER_NEW = 0;

    const IS_TEACHER_REPEATER = 1;
    const IS_NOT_TEACHER_REPEATER = 0;

    const IS_CONSUMED = 1;
    const NOT_CONSUMED = 0;

    const PAGE_VIEW_COUNT_DEFAULT = 1;

    const IS_TOP_PAGE_NOT_VIEWED = 0;
    const IS_TOP_PAGE_VIEWED = 1;

    const IS_SKILL_NOT_VIEWED = 0;
    const IS_SKILL_VIEWED = 1;

    const IS_CONSULTATION_NOT_VIEWED = 0;
    const IS_CONSULTATION_VIEWED = 1;

    const IS_FORTUNETELLING_NOT_VIEWED = 0;
    const IS_FORTUNETELLING_VIEWED = 1;

    // [applicants] is_reviewed
    const NOT_REVIEWED = 0;
    const REVIEWED = 1;

    // [purchase]
    const DISCOUNT_AMOUNT_DEFAULT = 0;

    const PURCHASE_ITEM_COURSE = [
        'course' => 1,
        'extension' => 2,
        'option' => 3,
        'question' => 4,
        'gift' => 5
    ];

    const PURCHASE_ITEM_COURSE_TYPE = 'course';
    const PURCHASE_ITEM_OPTION = 'option';
    const PURCHASE_ITEM_EXTENSION = 'extension';
    const PURCHASE_ITEM_GIFT = 'gift';
    const PURCHASE_ITEM_QUESTION = 'question';

    // [follows] teacher_repeat_count
    const TEACHER_REPEAT_COUNT_DEFAULT = 0;

    // course type
    const SUB_COURSE_TYPE = 2;

    //sales
    const NOT_SKILL = 0;
    const SKILL = 1;
    const NOT_SKILL_SUB = 0;
    const SKILL_SUB = 1;
    const NOT_CONSULTATION = 0;
    const CONSULTATION = 1;
    const NOT_FORTUNETELLING = 0;
    const FORTUNETELLING = 1;

    // [question_tickets]
    const UNUSED_STATUS = 0;
    const USED_STATUS = 1;

    // [message is read]
    const MESSAGE_NOT_READ = 0;
    const MESSAGE_READ = 1;

    // [transfer_histories status]
    public const TRANSFER_HISTORIES_STATUS_PENDING = 0;
    public const TRANSFER_HISTORIES_STATUS_APPROVED = 1;
    public const TRANSFER_HISTORIES_STATUS_SENDING = 2;
    public const TRANSFER_HISTORIES_STATUS_PAID = 3;
    public const TRANSFER_HISTORIES_STATUS_FAIL = 4;
    public const TRANSFER_HISTORIES_STATUS_REPORT_TEACHER = 5;
    public const TRANSFER_HISTORIES_STATUS_TEACHER_UPDATE = 6;
    public const TRANSFER_HISTORIES_STATUS_FAIL_BALANCE = 7;
    public const TRANSFER_HISTORIES_REASON_FAIL_LAPPI = 1;
    public const TRANSFER_HISTORIES_REASON_FAIL_TEACHER = 2;
    public const BALANCE_INSUFFICIENT = 'balance_insufficient';

    // failure_code
    public const TRANSFER_HISTORIES_FAILURE_CODE = [
        'balance_insufficient' => 'balance_insufficient'
    ];

    // [users] name_use
    const NAME_USE_NICKNAME = 1;
    const NAME_USE_REALNAME = 2;

    // [users] cash_balance, points_balance
    const CASH_BALANCE_DEFAULT = 0;
    const POINTS_BALANCE_DEFAULT = 0;

    // [users] qualifications
    const DONT_HAVE_QUALIFICATION = 0;
    const IS_HAVE_QUALIFICATION = 1;
    const HAVE_QUALIFICATION = 0;

    const NO_CONTRACT_SINGED = 0;
    const CONTRACT_SINGED = 1;

    // [users] nda_status
    const NDA_STATUS_NO_CONTRACT = 0;
    const NDA_STATUS_CONTRACT = 1;

    // [course]
    const RATING_DEFAULT = 0;
    const NUM_OF_RATING_DEFAULT = 0;
    const NUM_OF_APPLICANT = 0;
    const COURSE_IS_HIDDEN_OPEN = 0;
    const COURSE_IS_HIDDEN_CLOSE = 1;

    const DISPLAY_ORDER_IMAGE_PATH = 1;

    // [users] name_use
    const USER_NICKNAME = 1;
    const USER_REALNAME = 2;
    const USER_TEACHER = 2;

    // [notification_settings] noti setting
    const NOTIFICATION_SETTING_DISABLED = 0;
    const NOTIFICATION_SETTING_ENABLED = 1;

    // courses
    public const MAX_COURSE_SCHEDULE = 10;
    public const MAX_SUB_COURSE = 10;
    public const MAX_OPTION = 5;
    public const MAX_EXTENSION = 3;

    // ranks teach
    const BRONZE = 2;
    const SILVER = 3;
    const GOLD = 4;
    const PLATINUM = 5;

    // ranks teacher id
    const RANK_ID_NONE = 1;

    // reviews
    const PUBLIC_INFO = 1;
    const HIDDEN_INFO = 0;

    // Course schedule
    const COURSE_SCHEDULE = [
        'purchased' => 1,
        'not_purchased' => 2,
    ];

    // Firebase room
    const ROOM_PURCHASED = 1;
    const ROOM_NOT_PURCHASED = 2;
    const ROOM_CANCEL = 4;
    const ROOM_PRIVATE = 6;
    const ROOM_COURSE = 2;

    // IS RESTING STOP SERVICE
    const STOP_SERVICE = 1;
    const NOT_STOP_SERVICE = 0;

    // [restocks]
    const STATUS_NOT_RESTOCK = 0;
    const STATUS_HAD_RESTOCK = 1;

    // Firebase new constant
    // type
    const ROOM_TYPE_OPEN = 1;
    const ROOM_TYPE_CLOSE = 2;
    const ROOM_TYPE_PRIVATE = 3;
    const ROOM_TYPE_PROMOTION = 4;

    // status
    const ROOM_STATUS_PURCHASED = 1;
    const ROOM_STATUS_NOT_PURCHASED = 2;
    const ROOM_STATUS_STUDENT_CANCEL = 3;
    const ROOM_STATUS_TEACHER_CANCEL = 4;
    const ROOM_STATUS_NONE = 5;

    //stripe logs
    //type
    public const STRIPE_LOG_TYPE_IN = 1;
    public const STRIPE_LOG_TYPE_OUT = 2;
}
