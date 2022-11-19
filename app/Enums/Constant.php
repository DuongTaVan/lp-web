<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Constant enum.
 */
class Constant extends BaseEnum
{
    const TIME_TEACHER_JOIN_LATE = 15;
    const TEACHER_PROMOTION_DAY = 59;
    const COURSE_TEXT = 'course';
    const BATCH_07_HOUR = 3;
    const DAY_REMIND_COURSE_SCHEDULE = 1;
    const SELLER_PROFIT = 0.1;
    const COURSE_SCHEDULE_STATUS_OPEN = 0;
    // USER STATUS = 0 ? ACTIVE : DEACTIVATE
    const USER_STATUS_REST = 0;
    const STATUS_OPEN_COURSE_SCHEDULE = 0;
    const STATUS_COURSE_SCHEDULE_HISTORY = 3;
    const COURSE_DESC = 'DESC';
    const COURSE_ASC = 'ASC';
    const IMAGE_OPTION_SCREEN = [
        'thumbnail' => '300,212'
    ];
    const COURSE_SCHEDULE_TYPE = 1;
    const SALE_HISTORY_STATUS_BLADE = 2;
    const SALE_HISTORY_TYPE_BLADE = 1;
    const SALE_HISTORY_COURSE_IS_ARCHIVED = 0;
    const SALE_HISTORY_COURSE_TYPE = 1;
    const SALE_HISTORY_TYPE = 1;
    const SALE_HISTORY_STATUS = 2;
    const COURSE_SCHEDULE_STATUS = 1;
    const TYPE_COURSE_ID = 'course';
    const TYPE_COURSE_SCHEDULE_ID = 'course-schedule';
    const TAB_NOT_REVIEW = 'not-review';
    const TAB_REIVEWED = 'reviewed';
    const NUMBER_RANKING_IMAGE = 12;
    const RESERVATION_COURSE_SCHEDULE = 1;
    const STATUS_CARD_CANCEL = 6;
    const EXPIRATION_DATE = 7;
    const CARD_AMEX = 'amex';
    const IMAGE_DISPLAY_ORDER = 1;
    const IMAGE_TYPE = 3;
    const IMAGE_STATUS = 2;
    const DAY_OF_WEEK_JP = ['日', '月', '火', '水', '木', '金', '土'];

    const REGISTER_SUCCESS = '登録しました。';

    const APPROVE_IDENTITY_IMAGE_SUCCESS = '承認しました。';

    const REJECT_IDENTITY_IMAGE_SUCCESS = '却下しました。';

    const CREATE_BOX_NOTIFICATION_SUCCESS = '配信しました。';

    const IMAGE_PATHS_STATUS = 0;

    const ITEM_PER_PAGE = [
        '5' => '5',
        '10' => '10',
        '20' => '20',
        '100' => '100',
    ];

    const DAY_JAPANESE = [
        'Monday' => '月',
        'Tuesday' => '火',
        'Wednesday' => '水',
        'Thursday' => '木',
        'Friday' => '金',
        'Saturday' => '土',
        'Sunday' => '日',
    ];

    const TRANSFER_HISTORY_SORT_BY_DEFAULT = 'created_at';

    const STATISTIC_SORT_BY_DEFAULT = 'target_date';

    const USER_POINT_SORT_BY_DEFAULT = 'expiration_date';

    const FOLLOW_SORT_BY_DEFAULT = 'follows.created_at';

    const SALE_SORT_BY_DEFAULT = 'id';

    const DEFAULT_LIMIT = 5;

    const ORDER_BY_DESC = 'desc';

    const ORDER_BY_ASC = 'asc';

    const EKYC_STATUS = [
        0 => '未申請',
        1 => '確認済み',
        2 => '非承認',
    ];

    const IMAGE_OBJECT_PRODUCT_MODEL = 'products';

    const IMAGE_LIMIT_DEFAULT = 5;

    const TRANSFER_MONTH = [
        1 => '翌月',
        2 => '翌々月',
    ];

    const DAY = '日';

    const MONTH = '月';

    const YEAR = '年';

    const YEN = '円';

    const IMAGE_TYPE_PRODUCT = 'products';

    const PLAN = [
        1 => '1日プラン',
        3 => '3日間プラン',
        7 => '1週間プラン',
        29 => '1ヶ月プラン',
    ];

    const PLAN_ONE_DAY = 1;

    const PLAN_THREE_DAY = 3;

    const PLAN_FOUR_DAY = 4;

    const PLAN_ONE_WEEK = 7;

    const PLAN_EIGHT_DAY = 8;

    const PLAN_TEN_DAY = 10;

    const PLAN_ELEVEN_DAY = 11;

    const PLAN_ONE_MONTH = 29;

    const PERCENT_SIGN = '%';

    const ACCOUNT_TYPE = [
        0 => '普通',
        1 => '当座',
    ];

    const IS_TRANSFERRED = [
        0 => '未済',
        1 => '振込済み',
    ];

    const STATUS = [
        0 => '未確定',
        1 => '確定済み',
    ];

    const CONTRACT_PERIOD_DEFAULT = 1;

    const LIMIT_PRODUCT_IN_TOP_SCREEN = 8;

    const LIMIT_RANKING_SUMMARY_IN_TOP_SCREEN = 5;

    const TYPE_FILE_ALLOW = 'jpg,png';

    const PREFECTURE = [
        0 => '北海道',
        1 => '青森県',
        2 => '岩手県',
        3 => '宮城県',
        4 => '秋田県',
        5 => '山形県',
        6 => '福島県',
        7 => '茨城県',
        8 => '栃木県',
        9 => '群馬県',
        10 => '埼玉県',
        11 => '千葉県',
        12 => '東京都',
        13 => '神奈川県',
        14 => '新潟県',
        15 => '富山県',
        16 => '石川県',
        17 => '福井県',
        18 => '山梨県',
        19 => '長野県',
        20 => '岐阜県',
        21 => '静岡県',
        22 => '愛知県',
        23 => '三重県',
        24 => '滋賀県',
        25 => '京都府',
        26 => '大阪府',
        27 => '兵庫県',
        28 => '奈良県',
        29 => '和歌山県',
        30 => '鳥取県',
        31 => '島根県',
        32 => '岡山県',
        33 => '広島県',
        34 => '山口県',
        35 => '徳島県',
        36 => '香川県',
        37 => '愛媛県',
        38 => '高知県',
        39 => '福岡県',
        40 => '佐賀県',
        41 => '長崎県',
        42 => '熊本県',
        43 => '大分県',
        44 => '宮崎県',
        45 => '鹿児島県',
        46 => '沖縄県',
    ];

    const DEFAULT_SELECT = '-----';

    const PAGINATE_LIST_HISTORY = 10;

    const TIME_ORDER_CANCEL = '21:59:59';

    const PAGINATE_LIST_FOLLOWER = 10;

    const PAGINATE_LIST_REVIEW = 4;

    const PAGINATE_LIST_NOTI = 6;

    // Active field
    const IS_ACTIVE = 1;

    const IS_NOT_ACTIVE = 0;

    // Pair Category
    const PAIR_CATEGORY_0 = 0;

    const PAIR_CATEGORY_1 = 1;

    const PAIR_CATEGORY_2 = 2;

    const PAIR_CATEGORY_3 = 3;

    const TEACHER_CATEGORY_SKILL = 1;
    const CHECK_USER_TYPE = 1;
    const CHECK_TEACHER_TYPE = 2;
    const TYPE_COURSE_PARENT = 1;

    // [user_type] Text
    const USER_TYPE_TEXT = [
        1 => '購入者',
        2 => '出品者',
    ];

    // [teacher_category] Text
    const TEACHER_CATEGORY_TEXT = [
        1 => '教えて！ライブ配信',
        2 => 'オンライン悩み相談',
        3 => 'オンライン占い',
    ];

    // [teacher_category] Text
    const SEX_TEXT = [
        1 => '男性',
        2 => '女性',
        9 => 'その他',
        0 => '無回答'
    ];

    // [student/my-page] Text
    const GENDER_TEXT = [
        0 => '無回答',
        1 => '男性',
        2 => '女性',
        9 => 'その他',
    ];

    // [login_type] Text
    const LOGIN_TYPE_TEXT = [
        'EMAIL' => 'Eメール',
        'LINE' => 'LINE',
        'FACEBOOK' => 'Facebook',
        'GOOGLE' => 'Google',
    ];

    // [identity_verification_status] Text
    const INDENTITY_VERIFICATION_STATUS_TEXT = [
        0 => '未申請',
        1 => '申請中',
        2 => '却下',
        3 => '承認済み',
    ];

    // [business_card_verification_status] Text
    const BUSINESS_CARD_VERIFICATION_STATUS_TEXT = [
        0 => '未申請',
        1 => '申請中',
        2 => '却下',
        3 => '承認済み',
    ];

    // [nda_status] Text
    const NDA_STATUS_TEXT = [
        0 => '未締結',
        1 => '締結済み',
    ];

    // [account_type] Text
    const ACCOUNT_TYPE_TEXT = [
        1 => '普通',
        2 => '当座',
        3 => '貯蓄',
    ];

    // Target period
    const PERIOD_1 = 1;

    const PERIOD_2 = 2;

    const ARRAY_PERIOD_1 = [4, 5, 6, 7, 8, 9];

    const ARRAY_PERIOD_2 = [10, 11, 12, 1, 2, 3];

    const BEGINNING_OF_SEMESTER_1 = 4;

    const END_OF_SEMESTER_1 = 9;

    const BEGINNING_OF_SEMESTER_2 = 10;

    const END_OF_SEMESTER_2 = 3;

    // Batch
    const BATCH_RECORD_LIMIT = 1000;

    const QUESTION_TICKET_PRICE = 200;

    const GIFT_PRICE = 10;

    const QUESTION_TICKET_POINTS_EQUIVALENT = 20;

    const AGE_YEAR_20 = 20;

    const AGE_YEAR_30 = 30;

    const AGE_YEAR_40 = 40;

    const AGE_YEAR_50 = 50;

    const AGE_YEAR_60 = 60;

    const DAYS_AGO_366 = 366;

    // Box notification
    const BOX_NOTIFICATION_SORT_BY_DEFAULT = 'box_notification_trans_content_id';

    // [box_notification_trans_contents.to_type] Text
    const BOX_NOTIFICATION_TRANS_CONTENTS_TYPE_TEXT = [
        1 => '購入者',
        2 => '出品者',
    ];

    // [box_notification_trans_contents.is_delivered] Text
    const BOX_NOTIFICATION_TRANS_CONTENTS_IS_DELIVERED_TEXT = [
        0 => '未配信',
        1 => '配信済み',
    ];

    // [password_reset.token]
    const TOKEN_PASSWORD_RESET = 255;

    const MONTH_TRANSFER_APPLY = 3;
    public const MIN_DAY_FOR_TRANSFER = 7;
    const TRANSFER_APPLICATION_AMOUNT = 20000;
    const NUMBER_RECORDS_DISPLAY = [
        'DISPLAY_1' => 1,
        'DISPLAY_2' => 2,
        'DISPLAY_3' => 3,
        'DISPLAY_4' => 4,
        'DISPLAY_5' => 5,
        'DISPLAY_6' => 6,
        'DISPLAY_7' => 7,
        'DISPLAY_8' => 8,
        'DISPLAY_9' => 9,
        'DISPLAY_10' => 10,
        'DISPLAY_12' => 12
    ];

    const DAY_AGO_2 = 2;

    const DAY_AGO_8 = 8;

    const POINT_EXPIRATION = 6; //month

    const PER_PAGE_DEFAULT = 10;

    const PAGE_DEFAULT = 1;

    const REVIEW_REWARD_POINTS = 0; //2391
    const REVIEW_REWARD_LIMIT_DATE = 30;
    const REVIEW_REWARD_POINTS_OUT_DATE = 0;

    const USER_TYPE = [
        1 => '購入者',
        2 => '出品者',
    ];

    const TRANSFER_HISTORY_STATUS = [
        0 => '申請中',
        1 => '承認済み',
    ];

    const BANK_ACCOUNTS_TYPE = [
        1 => '普通',
        2 => '当座',
        3 => '貯蓄',
    ];

    const ALL_MONTH = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

    public const TRANSFER_FEE = 300;

    // [course type search]
    const COURSES_SORT_ORDER_DATE = 1;

    const COURSES_SORT_ORDER_SEARCH = 2;

    const COURSES_SORT_ORDER_RECOMMEND = 3;

    // Search time frame
    const COURSES_TIME_FRAME_MORNING = 1;

    const COURSES_TIME_FRAME_AFFTERNOON = 2;

    const COURSES_TIME_FRAME_NIGHT = 3;

    // social type
    const SOCIAL_TYPE_LOGIN = 'LOGIN';
    const SOCIAL_TYPE_REGISTER = 'REGISTER';

    // social_login
    const SOCIAL_LOGIN_LINE = 'line';
    const SOCIAL_LOGIN_FACEBOOK = 'facebook';
    const SOCIAL_LOGIN_GOOGLE = 'google';

    const REVIEW_LIMIT = 10;

    const COURSE_DETAIL_DIST_METHOD = [
        '1' => 'ライブ配信',
        '2' => 'ビデオ通話'
    ];

    const REGISTER_TOKEN_EXPIRED_TIME = 5184000;

    const RANDOM_TOKEN = 255;

    const TIME_POINT = 1921;
    const MONTH_POINT = 12;
    const DAY_POINT = 31;

    //check change image update profile student
    const IS_UPDATE_IMAGE = "0";

    // Get schedules in morning 08:00:00 -> 11:59:59
    const MORNING = [
        'type' => 1,
        'startTime' => '08:00:00',
        'endTime' => '11:59:59'
    ];

    // Get schedules in morning 13:00:00 -> 18:59:59
    const AFTERNOON = [
        'type' => 2,
        'startTime' => '12:00:00',
        'endTime' => '18:59:59'
    ];
    // Get schedules in morning 19:00:00 -> 07:59:59
    const NIGHT = [
        'type' => 3,
        'startTime' => '19:00:00',
        'endTime' => '07:59:59'
    ];
    const MIDNIGHT_BEFORE = '23:59:59';
    const MIDNIGHT = '00:00:00';

    const ORDER_LIST_DESC = 1;
    const ORDER_LIST_ASC = 2;

    const ROUTE_MY_PAGE_SETTING_ACTIVE = [
        'student/my-page/account-setting',
        'student/my-page/credit-card-info'
    ];


    // View count page view
    const PAGE_VIEW_COUNT = 0;

    const COURSE_SCHEDULE_SEEN_RECORD = 4;

    const START_YEAR_FORMAT = '/01/01 00:00:00';
    const END_YEAR_FORMAT = '/12/31 23:59:59';

    const IS_CONSUMED = '利用済み';
    const IS_PROCESSED = '失効';
    const IS_CONSUMED_AND_PROCESSED = '有効';

    const IDENTITY_VERIFICATION_IMG_APP_TYPES = [
        '運転免許証（表面・裏面）',
        'パスポート（顔写真ページ・住所記載ページ）',
        'マイナンバーカード（表面のみ）',
        '在留カード（表面・裏面）'
    ];

    const SORT_DATETIME_DESC = 1;
    const SORT_DATETIME_ASC = 2;

    const OPTION_TAB_ONE = 1;
    const OPTION_TAB_FOR = 4;

    const TIME_FRAME_DEFAULT = 0;

    // Promotional message sort option
    const PROMOTIONAL_MESSAGE_LIST_DESC = 1;
    const PROMOTIONAL_MESSAGE_LIST_ASC = 2;
    const PROMOTIONAL_MESSAGE_BY_DESC = 'desc';
    const PROMOTIONAL_MESSAGE_BY_ASC = 'asc';

    //Message sort option
    const  MESSAGE_LIST_DESC = 1;
    const MESSAGE_LIST_ASC = 2;
    const MESSAGE_BY_DESC = 'desc';
    const MESSAGE_BY_ASC = 'asc';
    const PURCHASE = 1;
    const NOT_PURCHASE = 0;

    // message type firebase
    const MESSAGE_TYPE_TEXT = 1;
    const MESSAGE_TYPE_IMAGE = 2;
    const MESSAGE_TYPE_FILE = 3;
    const MESSAGE_TYPE_STICKER = 4;

    const REQUIRED_ERROR = 'required';

    const COMMENT_TIME_LIMIT = 20;

    const ROUTE_TEACHER_MESSAGE = [
        'client.teacher.my-page.message.message-course',
        'client.teacher.my-page.message.buyer',
        'client.teacher.my-page.message.not-buyer',
        'client.teacher.my-page.message.notice',
        'client.teacher.my-page.message.notification',
        'client.teacher.my-page.message.message-detail',
        'client.teacher.my-page.message.inquiry-list'
    ];

    const LIST_SCREEN_BACKGROUND_GRAY = [
        'client.home',
        'client.home.search',
        'client.course-schedules.detail',
        'client.teacher.course-preview.livestream',
        'client.teacher.course-preview.consultation',
        'client.teacher.course-preview.fortune'
    ];

    const LIST_SCREEN_SP_SEARCH_FORM = [
        'client.home',
        'client.home.search',
        'client.course-schedules.detail',
        'client.teacher.detail',
    ];

    const LIST_SCREEN_NOT_SEARCH_FORM = [
        'client.home',
        'client.home.search'
    ];

    const LIST_SCREEN_BACKGROUND_OTHER = [
        'client.teacher.guidelines',
        'client.user-guide',
        'client.live-streaming',
        'client.video-call',
        'client.delivery-method'
    ];

    const LIST_SCREEN_NO_PADDING = [
        'client.user-guide',
        'client.about-lappi-fe',
        'client.home'
    ];

    const MAX_DAY_SCHEDULE_DATE = 30;

    const SUBMIT = [
        'draft' => 9,
        'preview' => 8,
    ];

    const DIRECTORY_PATH = [
        'user' => 'profiles',
        'id-verification' => 'id-verifications',
        'bc-verification' => 'bc-verifications',
        'background' => 'backgrounds'
    ];

    const FAKE_SCHEDULE_DATE = '2000-12-12 00:00:00';

    const HANDLE_SUB_PRICE = '金額は、必ず入力してください。';

    const COURSE_EDIT_PAGE_TYPE = [
        'LIVESTREAM_SUB_SCHEDULE_DRAFT_STEP2' => 1,
        'LIVESTREAM_SUB_SCHEDULE' => 2,
        'LIVESTREAM_MAIN_SCHEDULE_DRAFT_STEP2' => 3,
        'LIVESTREAM_MAIN_SCHEDULE' => 4,
        'VIDEO_CALL_CONSULTATION_SCHEDULE_DRAFT' => 5,
        'VIDEO_CALL_CONSULTATION_SCHEDULE' => 6,
        'VIDEO_CALL_FORTUNETELLING_SCHEDULE_DRAFT' => 7,
        'VIDEO_CALL_FORTUNETELLING_SCHEDULE' => 8,
    ];

    // fee
    public const SALES_COMMISSION_RATE_PROMOTION = 10;

    public const SALES_COMMISSION_RATE = 22;

    public const SYSTEM_COMMISSION_RATE_PROMOTION = 0;

    public const SYSTEM_COMMISSION_RATE = 50;

    public const COMMISSION_RATE = 0.1;

    public const COMMISSION_RATE_DEFAULT = 0.35;

    public const TAX_RATE = 1 / 1.1;

    public const TAX = 10;

    // course
    public const LIST_MINUTE_REQUIRED = [
//        20 => "20 分",
        30 => "30 分",
        40 => "40 分",
        50 => "50 分",
        60 => "60 分"
    ];
    public const LIST_MINUTE_REQUIRED_VIDEO_CALL = [
        20 => "20 分",
        30 => "30 分",
        40 => "40 分",
        50 => "50 分",
        60 => "60 分"
    ];

    public const LIST_SUB_MINUTE_REQUIRED = [
        30 => "30 分",
        40 => "40 分",
        50 => "50 分",
        60 => "60 分"
    ];
}
