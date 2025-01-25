<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <a href="{{ url('admin/dashboard') }}" class="d-block">
            <div class="m-auto">
                <img src="{{ asset(getMedia('logo')) }}" class="logo-icon" alt="logo icon">
            </div>
        </a>


        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">

        @if(canAccess(['Dashboard']))
        <li>
            <a href="{{ route('dashboard' ) }}">
                <div class="parent-icon">
                    <img src="{{asset('uploads/Dashboard.png')}}" width="35" height="35" />
                </div>
                <div class="menu-title">Dashboard</div>
            </a>

        </li>
        @endif


        @if(canAccess(['OrderManagement']))

        <li>
            <a href="{{ route('admin.orders.index') }}">
                <div class="parent-icon">
                    <img src="{{asset('uploads/checklist.png')}}" width="35" height="35" />
                </div>
                <div class="menu-title">Order Management</div>
            </a>

        </li>
        @endif




        <li>
            <a href="{{ route('admin.incompelete.index') }}">
                <div class="parent-icon">
                    <img src="{{asset('uploads/Order Management.png')}}" width="35" height="35" />
                </div>
                <div class="menu-title">Incomplete orders</div>
            </a>

        </li>

        @if(canAccess(['PosManagement']))
        <li>
            <a href="{{ route('admin.pos.manage') }}">
                <div class="parent-icon">
                    <img src="{{asset('uploads/POS Management.png')}}" width="35" height="35" />
                </div>
                <div class="menu-title">POS Management</div>
            </a>

        </li>
        @endif


        @if(canAccess(['AddProduct']) || canAccess(['AllProduct']))

        <li class="{{ setSidebarActive(['products.*']) }}">
            <a href="#" class="has-arrow">
                <div class="parent-icon">
                    <img src="{{asset('uploads/product management.png')}}" width="35" height="35" />
                </div>
                <div class="menu-title">Products</div>
            </a>
            <ul>
                @if(canAccess(['AddProduct']))
                <li> <a href="{{ route('products.create') }}"><i class='bx bx-radio-circle'></i>Add Products</a>
                </li>
                @endif

                @if(canAccess(['AllProduct']))
                <li> <a href="{{ route('products.index') }}"><i class='bx bx-radio-circle'></i>All Product</a>
                </li>
                @endif

            </ul>
        </li>

        @endif





        @if(canAccess(['ListAttribute']) || canAccess(['AddAttribute']))
        <li>
            <a href="#" class="has-arrow">
                <div class="parent-icon">
                    <img src="{{asset('uploads/Manage Attribute.png')}}" width="35" height="35" />
                </div>
                <div class="menu-title">
                    Attributes
                </div>
            </a>
            <ul class="ml-4">
                @if(canAccess(['ListAttribute']))
                <li>
                    <a href="{{ route('admin.attributes.index') }}">
                        <i class='bx bx-radio-circle'></i>
                        List Attributes
                    </a>

                </li>
                @endif

                @if(canAccess(['AddAttribute']))
                <li>
                    <a href="{{ route('admin.attributes.create') }}">
                        <i class='bx bx-radio-circle'></i>
                        Add Attribute
                    </a>
                </li>
                @endif



            </ul>
        </li>
        @endif



        @if(canAccess(['AddCoupon']) || canAccess(['CouponList']))
        <li>
            <a class="has-arrow" href="#">
                <div class="parent-icon">
                    <img src="{{asset('uploads/coupon.png')}}" width="35" height="35" />

                </div>
                <div class="menu-title">Coupon</div>


            </a>
            <ul>
                @if(canAccess(['AddCoupon']))
                <li> <a href="{{ route('admin.coupons.create') }}"><i class='bx bx-radio-circle'></i>
                        Add Coupon
                    </a>
                </li>
                @endif


                @if(canAccess(['CouponList']))
                <li> <a href="{{ route('admin.coupons.index') }}"><i class='bx bx-radio-circle'></i>
                        Coupon List
                    </a>
                </li>
                @endif

            </ul>
        </li>
        @endif



        @if(canAccess(['UserInformation']))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><img src="{{ asset('uploads/list.png') }}" style="width: 30px; height: 30px" />
                </div>
                <div class="menu-title">Customer Info</div>
            </a>
            <ul>

                <li> <a href="{{route('users')}}">
                        <i class='bx bx-radio-circle'></i>
                        All Customer
                    </a>
                </li>


            </ul>
        </li>
        @endif




         @if(canAccess(['AddSupplier']) || canAccess(['SupplierList']))


        <div id="supplier">
            <!-- Content for suppliers goes here -->

            <li>
                <a class="has-arrow" href="#">
                    <div class="parent-icon">
                        <img src="{{asset('uploads/Manage supplier.png')}}" width="35" height="35" />
</div>
<div class="menu-title">Suppliers</div>
</a>
<ul>
    @if(canAccess(['AddSupplier']))
    <li> <a href="{{ route('admin.suppliers.create') }}#supplier"><i class='bx bx-radio-circle'></i>
            Add-Supplier
        </a>
    </li>
    @endif

    @if(canAccess(['SupplierList']))
    <li> <a href="{{ route('admin.suppliers.index') }}#supplier"><i class='bx bx-radio-circle'></i>
            Supplier List
        </a>
    </li>
    @endif

</ul>
</li>


</div>

@endif


@if(canAccess(['AddPurchase']) || canAccess(['PurchaseList']))


<li id="purchase">
    <a href="#" class="has-arrow">
        <div class="parent-icon">
            <img src="{{asset('uploads/Manage Purchase.png')}}" width="35" height="35" />
        </div>
        <div class="menu-title">
            Purchase
        </div>
    </a>
    <ul class="ml-4">
        @if(canAccess(['AddPurchase']))
        <li>
            <a href="{{ route('admin.purchase.create') }}#purchase">
                <i class='bx bx-radio-circle'></i>
                Add Purchase Product
            </a>

        </li>
        @endif

        @if(canAccess(['PurchaseList']))
        <li>
            <a href="{{ route('admin.purchase.index') }}#purchase">
                <i class='bx bx-radio-circle'></i>
                Product Purchase List
            </a>
        </li>
        @endif

    </ul>
</li>

@endif 





@if(canAccess(['AddCategory']) || canAccess(['SubCategory']))

<li>
    <a class="has-arrow" href="#">
        <div class="parent-icon">
            <img src="{{asset('uploads/manage category.png')}}" width="35" height="35" />
        </div>
        <div class="menu-title">Categories</div>


    </a>
    <ul>
        @if(canAccess(['AddCategory']))
        <li> <a href="{{ route('admin.categories.index') }}"><i class='bx bx-radio-circle'></i>
                Add Category
            </a>
        </li>
        @endif

        @if(canAccess(['SubCategory']))

        <li> <a href="{{ route('admin.subcategories.index') }}"><i class='bx bx-radio-circle'></i>
                Add-Sub-Category
            </a>
        </li>
        @endif

    </ul>
</li>

@endif



@if(canAccess(['AddCampaign']) || canAccess(['ListCampaign']))

<li id="promotion">
    <a href="#" class="has-arrow">
        <div class="parent-icon">
            <img src="{{asset('uploads/manage promotion.png')}}" width="35" height="35" />
        </div>
        <div class="menu-title">
            Promations
        </div>
    </a>
    <ul class="ml-4">
        @if(canAccess(['AddCampaign']))
        <li>
            <a href="{{ route('admin.promotions.add.product.campain') }}#promotion">
                <i class='bx bx-radio-circle'></i>
                Add To Campaign
            </a>

        </li>
        @endif

        @if(canAccess(['ListCampaign']))
        <li>
            <a href="{{ route('admin.promotions.index') }}#promotion">
                <i class='bx bx-radio-circle'></i>
                List Campaign
            </a>
        </li>
        @endif


    </ul>
</li>

@endif






















@if(canAccess(['RoleUser']) || canAccess(['RolePermission']))

<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><img src="{{ asset('uploads/key.png') }}" style="width: 30px; height: 30px" />
        </div>
        <div class="menu-title">Access Manage</div>
    </a>
    <ul>
        @if(canAccess(['RoleUser']))
        <li> <a href="{{ route('role-user.index') }}">
                <i class='bx bx-radio-circle'></i>
                Role User
            </a>
        </li>
        @endif

        @if(canAccess(['RolePermission']))
        <li> <a href="{{ route('role-permission.index') }}">
                <i class='bx bx-radio-circle'></i>
                Role Permission
            </a>
        </li>
        @endif


    </ul>
</li>


@endif


@if(canAccess(['Brands']))

<li>
    <a href="{{ route('admin.brands.index') }}">
        <div class="parent-icon">
            <img src="{{asset('uploads/manage brand.png')}}" width="35" height="35" />
        </div>
        <div class="menu-title">Brands</div>

    </a>
</li>
@endif



@if(canAccess(['BlogCategory']) || canAccess(['Blogs']))

<li id="blog">

    <a href="#" class="has-arrow">
        <div class="parent-icon">
            <img src="{{asset('uploads/manage promotion.png')}}" width="35" height="35" />
        </div>
        <div class="menu-title">
            Blogs
        </div>
    </a>

    <ul class="ml-4">

        @if(canAccess(['BlogCategory']))
        <li>
            <a href="{{route('blog-category.index')}}#blog">
                <i class='bx bx-radio-circle'></i>
                Blog-Categories
            </a>

        </li>
        @endif

        @if(canAccess(['Blogs']))
        <li>
            <a href="{{ route('blogs.index') }}#blog">
                <i class='bx bx-radio-circle'></i>
                Blogs
            </a>
        </li>
        @endif





    </ul>




</li>

@endif


@if(canAccess(['StockManagement']) || canAccess(['StockOut']) || canAccess(['UpcomingStock']))


<li id="inventory">
    <a href="#" class="has-arrow">
        <div class="parent-icon">
            <img src="{{asset('uploads/inventory (1).png')}}" height="35" width="35" />
        </div>
        <div class="menu-title">
            Inventory
        </div>
    </a>
    <ul class="ml-4">
        @if(canAccess(['StockManagement']))
        <li>
            <a href="{{ route('admin.inventory.index') }}#inventory">
                <i class='bx bx-radio-circle'></i>
                Stock Management
            </a>

        </li>
        @endif

        @if(canAccess(['StockOut']))
        <li>
            <a href="{{ route('admin.inventory.stock.out.products') }}#inventory">
                <i class='bx bx-radio-circle'></i>
                Stock Out Products
            </a>
        </li>
        @endif

        @if(canAccess(['UpcomingStock']))
        <li>
            <a href="{{ route('admin.inventory.upcomming.stock.out.products') }}#inventory">
                <i class='bx bx-radio-circle'></i>
                Upcoming Stock Out Products
            </a>
        </li>
        @endif


    </ul>
</li>

@endif


@if(canAccess(['CouriarApi']) || canAccess(['PaymentApi']))
<li id="api">
    <a href="#" class="has-arrow">
        <div class="parent-icon">
            <img src="{{asset('uploads/api (2).png')}}" width="35" height="35" />
        </div>
        <div class="menu-title">API Settings</div>
    </a>
    <ul>
        @if(canAccess(['CouriarApi']))
        <li> <a href="{{ route('couriarApi') }}#api"><i class='bx bx-radio-circle'></i>Couriar Api</a>
        </li>
        @endif

        @if(canAccess(['PaymentApi']))

        <li> <a href="{{ route('paymentApi') }}#api"><i class='bx bx-radio-circle'></i>Payment Api</a>
        </li>
        @endif







    </ul>




</li>
@endif


@if(canAccess(['OrderReport']) || canAccess(['OfficeReport']) || canAccess(['PurchaseReport']) ||
canAccess(['StockReport']) )

<li id="report">
    <a href="#" class="has-arrow">
        <div class="parent-icon">
            <img src="{{asset('uploads/report.png')}}" width="35" height="35" />
        </div>
        <div class="menu-title ">Report</div>
    </a>

    <ul class="ml-4">

        @if(canAccess(['OrderReport']))
        <li>
            <a href="{{ route('admin.report.index') }}#report">
                <i class='bx bx-radio-circle'></i>
                Orders Report
            </a>
        </li>
        @endif

        @if(canAccess(['OfficeReport']))
        <li>
            <a href="{{ route('admin.report.official.sale.report') }}#report">
                <i class='bx bx-radio-circle'></i>
                Office Sale Report
            </a>
        </li>
        @endif
        {{--
                @if(canAccess(['PurchaseReport']))
                <li>
                    <a href="{{ route('admin.report.purchase.report') }}#report">
        <i class='bx bx-radio-circle'></i>
        Purchase Report
        </a>
</li>
@endif --}}

<!-- @if(canAccess(['StockReport']))
<li>
    <a href="{{ route('admin.report.stock.report') }}#report">
        <i class='bx bx-radio-circle'></i>
        Stock Report
    </a>
</li>
@endif -->
</ul>


</li>

@endif









@if(canAccess(['Policy']) || canAccess(['TermCondition']) || canAccess(['RefundPolicy']) ||
canAccess(['SaleSupport']) || canAccess(['ShippingDelivery']) )

<li id="page">
    <a href="#" class="has-arrow">
        <div class="parent-icon">
            <img src="{{asset('uploads/page.png')}}" width="35" height="35" />
        </div>
        <div class="menu-title">Pages</div>
    </a>
    <ul>

        @if(canAccess(['Policy']))

        <li> <a href="{{ route('admin.pages.privacy.policy') }}#page"><i
                    class='bx bx-radio-circle'></i>Policies</a>
        </li>
        @endif

        @if(canAccess(['TermCondition']))
        <li> <a href="{{ route('admin.pages.terms.conditions') }}#page"><i class='bx bx-radio-circle'></i>Terms
                &
                Conditions
            </a>
        </li>
        @endif




        @if(canAccess(['RefundPolicy']))

</li> <a href="{{ route('admin.pages.refund.policy') }}#page"><i class='bx bx-radio-circle'></i>Refund
    Policy</a>
</li>
@endif



@if(canAccess(['SaleSupport']))

<li> <a href="{{ route('admin.pages.sales.support') }}#page"><i class='bx bx-radio-circle'></i>Sales Support</a>
</li>
@endif


@if(canAccess(['ShippingDelivery']))
<li> <a href="{{ route('admin.pages.shipping.delivery') }}#page"><i class='bx bx-radio-circle'></i>Shipping &
        Delivery</a>
</li>
@endif

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>



</ul>

</li>

@endif



<li id="promotion">
            <a href="#" class="has-arrow">
                <div class="parent-icon">
                    <img src="{{asset('uploads/settings.png')}}" width="35" height="35" />
                </div>
                <div class="menu-title"> General Settings </div>
            </a>
            <ul class="ml-4">

                @if(canAccess(['MediaManage']))

                <li>
                    <a href="{{ route('admin.media.index') }}">
                        <i class='bx bx-radio-circle'></i>

                        Media Management
                    </a>
                </li>
                @endif


                @if(canAccess(['BasicInformation']))
                <li id="site">
                    <a href="{{ route('admin.manage.index') }}#site">
                        <i class='bx bx-radio-circle'></i>
                        Basic Information
                    </a>
                </li>
                @endif

                @if(canAccess(['Slider']))

                <li>
                    <a href="{{ route('admin.sliders.banner') }}#slider">
                        <i class='bx bx-radio-circle'></i>
                        Add Banner Slider
                    </a>
                </li>
                @endif



                @if(canAccess(['Contact']))

                <li>
                    <a href="{{ route('admin.manage.contact.page') }}#site">
                        <i class='bx bx-radio-circle'></i>

                        Contact Page
                    </a>
                </li>
                @endif

                @if(canAccess(['SocialMedia']))

                <li id="social-media">
                    {{-- social.media.links --}}
                    <a href="{{ route('admin.manage.social.media.links') }}#site">
                        <i class='bx bx-radio-circle'></i>

                        Social Media Links

                    </a>
                </li>
                @endif


                {{-- smtpSetting --}}

                @if(canAccess(['SMTP']))

                <li id="smtp">
                    <a href="{{ route('admin.manage.smtpSetting') }}#site">
                        <i class='bx bx-radio-circle'></i>
                        SMTP Setting
                    </a>
                </li>

                @endif




                @if(canAccess(['Comment']))

                <li id="comment">
                    <a href="{{ route('admin.comments.index') }}#comment">
                        <i class='bx bx-radio-circle'></i>
                      Comment
                    </a>
                </li>

                @endif


                @if(canAccess(['MarketingTool']))

                <li id="marketing">
                    <a href="{{ route('admin.marketing-tools.index') }}#marketing">
                        <i class='bx bx-radio-circle'></i>
                   Marketing Tools
                    </a>
                </li>

                @endif



            </ul>
        </li>








</ul>












<!--end navigation-->
</div>
