<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission; // Use the correct model

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = array(

            array(
                "id" => 1,
                "name" => "Dashboard",
                "guard_name" => "web",
                "group" => "Dashboard",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 2,
                "name" => "OrderManagement",
                "guard_name" => "web",
                "group" => "Order",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 3,
                "name" => "RoleUser",
                "guard_name" => "web",
                "group" => "AccessManage",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 4,
                "name" => "RolePermission",
                "guard_name" => "web",
                "group" => "AccessManage",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 5,
                "name" => "UserInformation",
                "guard_name" => "web",
                "group" => "User",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 6,
                "name" => "PosManagement",
                "guard_name" => "web",
                "group" => "POS",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),




            array(
                "id" => 7,
                "name" => "AllProduct",
                "guard_name" => "web",
                "group" => "Product",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),
            array(
                "id" => 8,
                "name" => "AddProduct",
                "guard_name" => "web",
                "group" => "Product",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 9,
                "name" => "ListAttribute",
                "guard_name" => "web",
                "group" => "Attribute",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 10,
                "name" => "AddAttribute",
                "guard_name" => "web",
                "group" => "Attribute",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),


            array(
                "id" => 11,
                "name" => "AddCoupon",
                "guard_name" => "web",
                "group" => "Coupon",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 12,
                "name" => "CouponList",
                "guard_name" => "web",
                "group" => "Coupon",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 13,
                "name" => "Brands",
                "guard_name" => "web",
                "group" => "Brand",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),


            array(
                "id" => 14,
                "name" => "AddCategory",
                "guard_name" => "web",
                "group" => "Category",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 15,
                "name" => "SubCategory",
                "guard_name" => "web",
                "group" => "Category",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),


            array(
                "id" => 16,
                "name" => "AddSupplier",
                "guard_name" => "web",
                "group" => "Suppliers",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),


            array(
                "id" => 17,
                "name" => "SupplierList",
                "guard_name" => "web",
                "group" => "Suppliers",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),


            array(
                "id" => 18,
                "name" => "Slider",
                "guard_name" => "web",
                "group" => "Sliders",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),



            array(
                "id" => 19,
                "name" => "AddCampaign",
                "guard_name" => "web",
                "group" => "Promotion",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),


            array(
                "id" => 20,
                "name" => "ListCampaign",
                "guard_name" => "web",
                "group" => "Promotion",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 21,
                "name" => "BlogCategory",
                "guard_name" => "web",
                "group" => "Blog",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 22,
                "name" => "Blogs",
                "guard_name" => "web",
                "group" => "Blog",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 23,
                "name" => "StockManagement",
                "guard_name" => "web",
                "group" => "Inventory",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 24,
                "name" => "StockOut",
                "guard_name" => "web",
                "group" => "Inventory",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 25,
                "name" => "UpcomingStock",
                "guard_name" => "web",
                "group" => "Inventory",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 26,
                "name" => "AddPurchase",
                "guard_name" => "web",
                "group" => "Purchase",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 27,
                "name" => "PurchaseList",
                "guard_name" => "web",
                "group" => "Purchase",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 28,
                "name" => "CouriarApi",
                "guard_name" => "web",
                "group" => "ApiSetting",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 29,
                "name" => "PaymentApi",
                "guard_name" => "web",
                "group" => "ApiSetting",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 30,
                "name" => "OrderReport",
                "guard_name" => "web",
                "group" => "Report",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 31,
                "name" => "OfficeReport",
                "guard_name" => "web",
                "group" => "Report",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 32,
                "name" => "PurchaseReport",
                "guard_name" => "web",
                "group" => "Report",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 33,
                "name" => "StockReport",
                "guard_name" => "web",
                "group" => "Report",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 34,
                "name" => "MediaManage",
                "guard_name" => "web",
                "group" => "Media",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 35,
                "name" => "Policy",
                "guard_name" => "web",
                "group" => "Page",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 36,
                "name" => "TermCondition",
                "guard_name" => "web",
                "group" => "Page",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 37,
                "name" => "RefundPolicy",
                "guard_name" => "web",
                "group" => "Page",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 38,
                "name" => "SaleSupport",
                "guard_name" => "web",
                "group" => "Page",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 39,
                "name" => "ShippingDelivery",
                "guard_name" => "web",
                "group" => "Page",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 40,
                "name" => "BasicInformation",
                "guard_name" => "web",
                "group" => "BasicInformation",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 41,
                "name" => "Contact",
                "guard_name" => "web",
                "group" => "Contact",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 42,
                "name" => "SocialMedia",
                "guard_name" => "web",
                "group" => "SocialMedia",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 43,
                "name" => "SMTP",
                "guard_name" => "web",
                "group" => "SMTP",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),

            array(
                "id" => 44,
                "name" => "Comment",
                "guard_name" => "web",
                "group" => "Comment",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),


            array(
                "id" => 45,
                "name" => "MarketingTool",
                "guard_name" => "web",
                "group" => "MarketingTool",
                "created_at" => "2019-10-05 23:58:06",
                "updated_at" => "2019-10-05 23:58:06",
            ),


            [
                'id' => 46,
                'name' => 'AccountManagement',
                'guard_name' => 'web',
                'group' => 'Account Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 47,
                'name' => 'AccountList',
                'guard_name' => 'web',
                'group' => 'Account Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 48,
                'name' => 'AccountType',
                'guard_name' => 'web',
                'group' => 'Account Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 49,
                'name' => 'ReportBalance',
                'guard_name' => 'web',
                'group' => 'Account Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 50,
                'name' => 'Balance',
                'guard_name' => 'web',
                'group' => 'Account Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 51,
                'name' => 'FundTransfer',
                'guard_name' => 'web',
                'group' => 'Account Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 52,
                'name' => 'AccountPurpose',
                'guard_name' => 'web',
                'group' => 'Account Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 53,
                'name' => 'AnalyticsDashboard',
                'guard_name' => 'web',
                'group' => 'Dashboard',
                'created_at' => now(),
                'updated_at' => now(),

            ]







        );
        Permission::insert($permissions);


    }
}
