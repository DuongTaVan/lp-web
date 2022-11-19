<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\CategoryRepositoryEloquent;
use App\Repositories\EmailNotificationRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(\App\Repositories\BankAccountRepository::class, \App\Repositories\BankAccountRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SaleRepository::class, \App\Repositories\SaleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PageViewRepository::class, \App\Repositories\PageViewRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ApplicantRepository::class, \App\Repositories\ApplicantRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CourseScheduleRepository::class, \App\Repositories\CourseScheduleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ImagePathRepository::class, \App\Repositories\ImagePathRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BoxNotificationTransContentRepository::class, \App\Repositories\BoxNotificationTransContentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BoxNotificationRepository::class, \App\Repositories\BoxNotificationRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SaleRepository::class, \App\Repositories\SaleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TermStatisticRepository::class, \App\Repositories\TermStatisticRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StatisticRepository::class, \App\Repositories\StatisticRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TransferHistoryRepository::class, \App\Repositories\TransferHistoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ImagePathRepository::class, \App\Repositories\ImagePathRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserPointRepository::class, \App\Repositories\UserPointRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EmailNotificationRepository::class, \App\Repositories\EmailNotificationRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RankingRepository::class, \App\Repositories\RankingRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CourseRepository::class, \App\Repositories\CourseRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\QuestionTicketRepository::class, \App\Repositories\QuestionTicketRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GiftTippingHistoryRepository::class, \App\Repositories\GiftTippingHistoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OptionalExtraMappingRepository::class, \App\Repositories\OptionalExtraMappingRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CashRepository::class, \App\Repositories\CashRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EmailNotificationRepository::class, EmailNotificationRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CategoryRepository::class, CategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PurchaseRepository::class, \App\Repositories\PurchaseRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SettlementRepository::class, \App\Repositories\SettlementRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PasswordResetRepository::class, \App\Repositories\PasswordResetRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ReviewRepository::class, \App\Repositories\ReviewRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FollowRepository::class, \App\Repositories\FollowRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OptionalExtraRepository::class, \App\Repositories\OptionalExtraRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PurchaseDetailRepository::class, \App\Repositories\PurchaseDetailRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SubscriberRepository::class, \App\Repositories\SubscriberRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ConsoleUserRepository::class, \App\Repositories\ConsoleUserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GiftRepository::class, \App\Repositories\GiftRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PromotionalMessageRepository::class, \App\Repositories\PromotionalMessageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MessageRepository::class, \App\Repositories\MessageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RankRepository::class, \App\Repositories\RankRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EmailAuthnRepository::class, \App\Repositories\EmailAuthnRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NotificationSettingRepository::class, \App\Repositories\NotificationSettingRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FavoriteRepository::class, \App\Repositories\FavoriteRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RestockRepository::class, \App\Repositories\RestockRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BankAccountHistoryRepository::class, \App\Repositories\BankAccountHistoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BankMasterRepository::class, \App\Repositories\BankMasterRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PromotionRepository::class, \App\Repositories\PromotionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StripeLogRepository::class, \App\Repositories\StripeLogRepositoryEloquent::class);
        //:end-bindings:
    }
}
