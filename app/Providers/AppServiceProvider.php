<?php

namespace App\Providers;

use App\Repositories\Admin\Brands\BrandsRepository;
use App\Repositories\Admin\Brands\BrandsRepositoryInterface;
use App\Repositories\Admin\Campaign\CampaignRepository;
use App\Repositories\Admin\Campaign\CampaignRepositoryInterface;
use App\Repositories\Admin\Cart\CartRepository;
use App\Repositories\Admin\Cart\CartRepositoryInterface;
use App\Repositories\Admin\Comment\CommentRepository;
use App\Repositories\Admin\Comment\CommentRepositoryInterface;
use App\Repositories\Admin\Coupon\CouponRepository;
use App\Repositories\Admin\Coupon\CouponRepositoryInterface;
use App\Repositories\Admin\CouriarApiSetting\CouriarApiSettingRepository;
use App\Repositories\Admin\CouriarApiSetting\CourierApiSettingRepository;
use App\Repositories\Admin\CouriarApiSetting\CourierApiSettingRepositoryInterface;
use App\Repositories\Admin\Manage_site\SiteRepository;
use App\Repositories\Admin\Manage_site\SiteRepositoryInterface;
use App\Repositories\Admin\MarketingTool\MarketingToolRepository;
use App\Repositories\Admin\MarketingTool\MarketingToolRepositoryInterface;
use App\Repositories\Admin\Media\MediaRepository;
use App\Repositories\Admin\Order\OrderRepository;
use App\Repositories\Admin\Order\OrderRepositoryInterface;
use App\Repositories\Admin\Pages\PageRepository;
use App\Repositories\Admin\Pages\PageRepositoryInterface;
use App\Repositories\Admin\Pos\POSRepository;
use App\Repositories\Admin\Pos\POSRepositoryInterface;
use App\Repositories\Admin\Report\ReportRepository;
use App\Repositories\Admin\Report\ReportRepositoryInterface;

use App\Repositories\Admin\SidebarSlider\SidebarSliderRepository;
use App\Repositories\Admin\SidebarSlider\SidebarSliderRepositoryInterface;
use App\Repositories\Admin\Smtp\SmtpSettingRepository;
use App\Repositories\Admin\Smtp\SmtpSettingRepositoryInterface;

use App\Services\Admin\Campaign\CampaignService;
use App\Services\Admin\Campaign\CampaignServiceInterface;
use App\Services\Admin\Cart\CartService;
use App\Services\Admin\Cart\CartServiceInterface;
use App\Services\Admin\Comment\CommentService;
use App\Services\Admin\Coupon\CouponService;
use App\Services\Admin\Coupon\CouponServiceInterface;
use App\Services\Admin\CouriarApiSetting\CouriarApiSettingService;
use App\Services\Admin\CouriarApiSetting\CouriarApiSettingServiceInterface;
use App\Services\Admin\Manage_site\SiteService;
use App\Services\Admin\Manage_site\SiteServiceInterface;
use App\Services\Admin\MarketingTool\MarketingToolService;
use App\Services\Admin\Media\MediaService;
use App\Services\Admin\Order\OrderService;
use App\Services\Admin\Order\OrderServiceInterface;
use App\Services\Admin\OrderStatistics\OrderStatisticsService;
use App\Services\Admin\Pages\PageService;
use App\Services\Admin\Pages\PageServiceInterface;
use App\Services\Admin\Pos\POSService;
use App\Services\Admin\Pos\POSServiceInterface;
use App\Services\Admin\Report\ReportService;
use App\Services\Admin\Report\ReportServiceInterface;
use App\Services\Admin\SidebarSlider\SidebarSliderService;
use App\Services\Admin\SidebarSlider\SidebarSliderServiceInterface;
use App\Services\Admin\Smtp\SmtpSettingService;
use App\Services\Admin\Smtp\SmtpSettingServiceInterface;
use Illuminate\Support\ServiceProvider;

use App\Repositories\Admin\Product\ProductRepository;
use App\Repositories\Admin\Product\ProductRepositoryInterface;
use App\Repositories\Admin\Purchase\PurchaseRepository;
use App\Repositories\Admin\Purchase\PurchaseRepositoryInterface;
use App\Repositories\Admin\Role\RoleRepository;
use App\Repositories\Admin\UserRole\UserRepository;
use App\Services\Admin\CourierConfigService\CourierConfigService;
use App\Services\Admin\Product\ProductService;
use App\Services\Admin\Purchase\PurchaseService;
use App\Services\Admin\Purchase\PurchaseServiceInterface;
use App\Services\Admin\Role\RolePermissionService;
use App\Services\Admin\UserRole\UserService;
use App\Services\AvatarService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //  PageRepositoryInterface to the PageRepository
        $this->app->bind(PageRepositoryInterface::class, PageRepository::class);
        // PageServiceInterface to the PageService
        $this->app->bind(PageServiceInterface::class, PageService::class);


        // SiteRepositoryInterface to the SiteRepository
        $this->app->bind(SiteRepositoryInterface::class, SiteRepository::class);
        // SiteServiceInterface to the SiteService
        $this->app->bind(SiteServiceInterface::class, SiteService::class);


        // SmtpSettingRepositoryInterface to the SmtpSettingRepository
        $this->app->bind(SmtpSettingRepositoryInterface::class, SmtpSettingRepository::class);
        // SmtpSettingServiceInterface to the SmtpSettingService
        $this->app->bind(SmtpSettingServiceInterface::class, SmtpSettingService::class);

        // SidebarSliderRepositoryInterface to the SidebarSliderRepository
        $this->app->bind(SidebarSliderRepositoryInterface::class, SidebarSliderRepository::class);
        // SidebarSliderServiceInterface to the SidebarSliderService
        $this->app->bind(SidebarSliderServiceInterface::class, SidebarSliderService::class);

        // BandsRepositoryInterface to the BandsRepository
        $this->app->bind(BrandsRepositoryInterface::class, BrandsRepository::class);



        // CampaignRepositoryInterface to the CampaignRepository
        $this->app->bind(CampaignRepositoryInterface::class, CampaignRepository::class);
        //     // CampaignServiceInterface to the CampaignService
        $this->app->bind(CampaignServiceInterface::class, CampaignService::class);

        // CouponRepositoryInterface to the CouponRepository
        $this->app->bind(CouponRepositoryInterface::class, CouponRepository::class);
        //     // CouponServiceInterface to the CouponService
        $this->app->bind(CouponServiceInterface::class, CouponService::class);

        // MediaRepository
        $this->app->bind(MediaRepository::class);
        // MediaService
        $this->app->bind(MediaService::class);



        // CouriarApiSettingRepositoryInterface to the CouriarApiSettingRepository
        $this->app->bind(CourierApiSettingRepositoryInterface::class, CouriarApiSettingRepository::class);
        // CouriarApiSettingServiceInterface to the CouriarApiSettingService
        $this->app->bind(CouriarApiSettingServiceInterface::class, CouriarApiSettingService::class);


        // CommentRepositoryInterface to the CommentRepository
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        // CommentServiceInterface to the CommentService
        $this->app->bind(CommentService::class);

        // MarketingToolRepositoryInterface to the MarketingToolRepository
        $this->app->bind(MarketingToolRepositoryInterface::class, MarketingToolRepository::class);

        // MarketingToolService
        $this->app->bind(MarketingToolService::class);

        // POSRepositoryInterface to the POSRepository
        $this->app->bind(POSRepositoryInterface::class, POSRepository::class);
        // POSServiceInterface to the POSService
        $this->app->bind(POSServiceInterface::class, POSService::class);

        // CartServiceInterface to the CartService
        $this->app->bind(CartServiceInterface::class, CartService::class);

        // CartRepositoryInterface to the CartRepository
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);


        // OrderRepositoryInterface to the OrderRepository
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        // OrderServiceInterface to the OrderService
        $this->app->bind(OrderServiceInterface::class, OrderService::class);

        // ReportRepositoryInterface to the ReportRepository
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
        //  // ReportServiceInterface to the ReportService
        $this->app->bind(ReportServiceInterface::class, ReportService::class);

        // OrderStatisticsService

        $this->app->bind(OrderStatisticsService::class);

        //  ProductRepositoryInterface
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductService::class);

          //PurchaseRepository
          $this->app->bind(PurchaseRepositoryInterface::class, PurchaseRepository::class);
          $this->app->bind(PurchaseServiceInterface::class, PurchaseService::class);
          


        // avater
        $this->app->singleton(AvatarService::class, function ($app) {
            return new AvatarService();

            // UserService
            $this->app->bind(UserRepository::class);
            $this->app->bind(UserService::class);

            // RolePermissionService'
            $this->app->bind(RolePermissionService::class);
            $this->app->bind(RoleRepository::class);


        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Register the avatar directive
        Blade::directive('avatar', function ($expression) {
            // Extract the parameters from the expression
            [$image, $name] = explode(',', $expression);

            // Return avatar based on logic from AvatarService
            return "<?php echo app('App\Services\AvatarService')->getAvatar(trim($image), trim($name)); ?>";
        });





        //Roles and permission code

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}
