<?php

//微信端

Route::group(['namespace' => 'WeChat', 'middleware' => 'active.nav'], function () {
    //用户登录
    Route::get('/login', ['as' => 'login', 'middleware' => 'wechat', 'uses' => 'UserController@login']);
    //登录认证后
    Route::group(['middleware' => 'auth'], function () {
        //积分商城
        Route::get('/', ['as' => 'index', 'uses' => 'SiteController@index']);
        //商品列表
        Route::get('/goods-list/{type?}', ['as' => 'goods.list', 'uses' => 'SiteController@goodsList']);
        //店铺商品列表
        Route::get('/shop-goods-list/{type?}', ['as' => 'shop.goods.list', 'uses' => 'SiteController@shopGoodsList']);
        //商品详情
        Route::get('/goods-detail/{id}', ['as' => 'goods.page', 'uses' => 'SiteController@goods']);
        //商品收藏
        Route::get('/goods-collection/{id}', ['as' => 'goods.collection', 'uses' => 'SiteController@GoodsCollection']);
        //取消商品收藏
        //Route::get('/goodsCollection-delete/{id}', ['as' => 'goods.collection.delete', 'uses' => 'SiteController@destroyGoodsCollection']);
        //优惠劵列表
        Route::get('/coupons/{id?}', ['as' => 'coupon.list', 'uses' => 'SiteController@couponList']);
        //优惠劵详情
        Route::get('/coupon/{id}', ['as' => 'coupon.page', 'uses' => 'SiteController@coupon']);
        //优惠券收藏
        Route::get('/coupon-collection/{id}', ['as' => 'coupon.collection', 'uses' => 'SiteController@CouponCollection']);
        //取消优惠券收藏
        //Route::get('/couponCollection-delete/{id}', ['as' => 'coupon.collection.delete', 'uses' => 'SiteController@destroyCouponCollection']);
        //店铺收藏
        Route::get('/shops-collection/{id}', ['as' => 'shops.collection', 'uses' => 'SiteController@ShopsCollection']);
        //取消店铺收藏
        //Route::get('/shopsCollection-delete/{id}', ['as' => 'shops.collection.delete', 'uses' => 'SiteController@destroyShopsCollection']);
        //店铺列表
        Route::get('/shops/{type?}', ['as' => 'shop.list', 'uses' => 'SiteController@shopList']);
        //取消收藏
        Route::get('/Collection-delete/{id}', ['as' => 'collection.delete', 'uses' => 'SiteController@destroyCollection']);
        //店铺详情
        Route::get('/shop/{id}', ['as' => 'shop.page', 'uses' => 'SiteController@shop']);
        //优惠劵购买
        Route::post('/order-coupon/{id}', ['as' => 'coupon.order', 'uses' => 'OrderController@coupon']);
        //商品订单填写页
        Route::get('/order/{id}', ['as' => 'order', 'uses' => 'OrderController@goods']);
        //
        Route::post('/order-shop', ['as' => 'order.shop', 'uses' => 'OrderController@shopGoods']);
        Route::post('/order-direct', ['as' => 'order.direct', 'uses' => 'OrderController@directGoods']);
        //获取历史地址列表
        Route::get('/user-address', ['as' => 'address', 'uses' => 'OrderController@coupon']);
        //地址保存
        Route::post('/user-address', ['as' => 'address', 'uses' => 'OrderController@coupon']);
        //会员扫码
        Route::get('/{serialNumber}/p/{password}', ['middleware' => 'throttle', 'uses' => 'ScanController@member'])->where(['serialNumber' => '[0-9]+']);
        //导购扫码
        Route::get('/{serialNumber}/c/{password}', ['middleware' => 'throttle', 'uses' => 'ScanController@sale'])->where(['serialNumber' => '[0-9]+']);
        //线下兑换优惠劵
        Route::get('/coupon/{orderNumber}/{password}', ['middleware' => 'throttle', 'as' => 'order.exchange.coupon', 'uses' => 'ScanController@getCoupon'])->where(['orderNumber' => '[0-9]+']);
        Route::post('/coupon/{orderNumber}/{password}', ['middleware' => 'throttle', 'as' => 'order.exchange.coupon', 'uses' => 'ScanController@postCoupon'])->where(['orderNumber' => '[0-9]+']);
        //线下兑换商品
        Route::get('/goods/{orderNumber}/{password}', ['middleware' => 'throttle', 'as' => 'order.exchange.goods', 'uses' => 'ScanController@getGoods'])->where(['orderNumber' => '[0-9]+']);
        Route::post('/goods/{orderNumber}/{password}', ['middleware' => 'throttle', 'as' => 'order.exchange.goods', 'uses' => 'ScanController@postGoods'])->where(['orderNumber' => '[0-9]+']);
        //会员中心首页
        Route::get('/user', ['as' => 'user.index', 'uses' => 'UserController@index']);
        //会员中心
        Route::group(['prefix' => 'user', 'middleware' => 'member'], function () {
            //个人资料展示页
            Route::get('/info', ['as' => 'user.info', 'uses' => 'UserController@getInfo']);
            //个人资料表单页
            Route::put('/info', ['as' => 'user.info', 'uses' => 'UserController@putInfo']);
            //修改个人资料
            Route::post('/info', ['as' => 'user.info', 'uses' => 'UserController@postInfo']);
            //积分中心展示页
            Route::get('/integral', ['as' => 'user.integral', 'uses' => 'UserController@integralList']);
            Route::get('/integral/{page}', ['as' => 'user.integral.inline', 'uses' => 'UserController@integralPage']);
            //红包记录展示页
            Route::get('/commission', ['as' => 'user.commission', 'uses' => 'UserController@commissionList']);
            Route::get('/commission/{page}', ['as' => 'user.commission.inline', 'uses' => 'UserController@commissionPage']);
            //消息中心展示页
            Route::get('/messages', ['as' => 'user.messages', 'uses' => 'UserController@messagesList']);
            Route::get('/messages/{page}', ['as' => 'user.messages.inline', 'uses' => 'UserController@messagesPage']);
            //地址列表
            Route::get('/addresses', ['as' => 'user.addresses', 'uses' => 'UserController@addressList']);
            //删除地址
            Route::get('/address-delete/{id}', ['as' => 'user.address.delete', 'uses' => 'UserController@destroyList']);
            //优惠劵列表
            Route::get('/coupons/{type?}', ['as' => 'user.coupon.list', 'uses' => 'UserController@couponList']);
            //
            Route::get('/coupon-exchange/{id}', ['as' => 'user.coupon.exchange', 'uses' => 'UserController@couponExchange']);
            //订单列表
            Route::get('/orders/{type?}/{keyword?}', ['as' => 'user.order.list', 'uses' => 'UserController@orderList']);
            //订单详情
            Route::get('/order/{id}', ['as' => 'user.order.page', 'uses' => 'UserController@orderPage']);
            //订单兑换
            Route::get('/order-exchange/{id}', ['as' => 'user.order.exchange', 'uses' => 'UserController@orderExchange']);
            //评论列表
            Route::get('/comments-wait', ['as' => 'user.comments.wait', 'uses' => 'UserController@commentsWait']);
            Route::get('/comments-has', ['as' => 'user.comments.has', 'uses' => 'UserController@commentsHas']);
            //评论
            Route::get('/comment/{id}', ['as' => 'user.comment', 'uses' => 'UserController@getComment']);
            Route::post('/comment/{id}', ['as' => 'user.comment', 'uses' => 'UserController@postComment']);
            //我的收藏
            Route::get('/favourites/{type?}', ['as' => 'user.favourites', 'uses' => 'UserController@favourites']);
            //意见反馈页
            Route::get('/feedback', ['as' => 'user.feedback', 'uses' => 'UserController@feedback']);
            //意见反馈处理
            Route::post('/feedback', ['as' => 'user.feedback', 'uses' => 'UserController@postFeedback']);
            //员工申请页
            Route::get('/apply-employee', ['as' => 'user.apply.employee', 'uses' => 'UserController@getApplyEmployee']);
            //处理员工申请
            Route::post('/apply-employee', ['as' => 'user.apply.employee', 'uses' => 'UserController@postApplyEmployee']);
            //邀请导购/老板填写页
            Route::get('/apply/{token}', ['as' => 'user.apply.shop-staff', 'uses' => 'UserController@getApply'])->where(['code' => '\w{40}$']);
            //处理邀请导购/老板请求
            Route::post('/apply/{token}', ['as' => 'user.apply.shop-staff', 'uses' => 'UserController@postApply'])->where(['code' => '\w{40}$']);
            Route::post('/address-save', ['as' => 'user.address.save', 'uses' => 'UserController@addressSave']);
        });
        //员工管理中心
        Route::group(['middleware' => 'employee', 'prefix' => 'employee'], function () {
            //首页
            Route::get('/', ['as' => 'employee.center', 'uses' => 'EmployeeController@index']);
            //邀请加入页面
            Route::get('/invite', ['as' => 'employee.invite', 'uses' => 'EmployeeController@invite']);
            //申请列表页面加载
            Route::get('/applies/{type?}', ['as' => 'employee.applies', 'uses' => 'EmployeeController@applies']);
            //补充资料表单页
            Route::get('/apply/{id}', ['as' => 'employee.apply.page', 'uses' => 'EmployeeController@getApply']);
            //补充资料处理页
            Route::post('/apply/{id}', ['as' => 'employee.apply.page', 'uses' => 'EmployeeController@postApply']);
            //修改资料表单页
            Route::get('/apply-refuse/{id}', ['as' => 'employee.apply.refuse.page', 'uses' => 'EmployeeController@getApplyRefuse']);
            //修改资料处理页
            Route::post('/apply-refuse/{id}', ['as' => 'employee.apply.refuse.page', 'uses' => 'EmployeeController@postApplyRefuse']);

            //店铺申请页
            Route::get('/shop/{id?}', ['as' => 'employee.shop.apply', 'uses' => 'EmployeeController@getShopApply']);
            //处理店铺申请
            Route::post('/shop/{id?}', ['as' => 'employee.shop.apply', 'uses' => 'EmployeeController@postShopApply']);
            //店铺列表页面
            Route::get('/shop-list', ['as' => 'employee.shops.list', 'uses' => 'EmployeeController@getShopsList']);

            //老板列表
            Route::get('/boss-list', ['as' => 'employee.boss.list', 'uses' => 'EmployeeController@getBossList']);
            //老板资料编辑
            Route::get('/boss/{id}', ['as' => 'employee.boss.page', 'uses' => 'EmployeeController@getBossPage']);
            //老板资料编辑处理
            Route::post('/boss/{id}', ['as' => 'employee.boss.page', 'uses' => 'EmployeeController@postBossPage']);

            //导购列表
            Route::get('/sale-list', ['as' => 'employee.sale.list', 'uses' => 'EmployeeController@getSaleList']);
            //导购资料编辑
            Route::get('/sale/{id}', ['as' => 'employee.sale.page', 'uses' => 'EmployeeController@getSalePage']);
            //导购资料编辑处理
            Route::post('/sale/{id}', ['as' => 'employee.sale.page', 'uses' => 'EmployeeController@postSalePage']);

            //商品列表页面
            Route::get('/goods-list/{type?}', ['as' => 'employee.goods.list', 'uses' => 'EmployeeController@getGoodsList']);
            //商品申请页面
            Route::get('/goods/{id?}', ['as' => 'employee.goods.apply', 'uses' => 'EmployeeController@getGoodsApply']);
            //处理商品申请
            Route::post('/goods/{id?}', ['as' => 'employee.goods.apply', 'uses' => 'EmployeeController@postGoodsApply']);

            //新建优惠券页面
            Route::get('/coupon/{id?}', ['as' => 'employee.coupon.apply', 'uses' => 'EmployeeController@getCouponApply']);
            //新建优惠券处理页
            Route::post('/coupon/{id?}', ['as' => 'employee.coupon.apply', 'uses' => 'EmployeeController@postCouponApply']);
            //优惠券列表页面
            Route::get('/coupon-list/{type?}', ['as' => 'employee.coupon.list', 'uses' => 'EmployeeController@getCouponList']);
            //销售数据
            Route::get('/selldata-list', ['as' => 'employee.selldata.list', 'uses' => 'EmployeeController@dataTable']);
            //总体销售数据列表
            Route::any('/totaldata-list', ['as' => 'employee.totaldata.list', 'uses' => 'EmployeeController@totalData']);

            //导购销售数据列表
            Route::any('/saledata-list', ['as' => 'employee.saledata.list', 'uses' => 'EmployeeController@saleData']);
            //导购销售数据详情列表
            Route::get('/saledetails-list', ['as' => 'employee.saledetails.list', 'uses' => 'EmployeeController@saleDetails']);

            //店铺销售数据列表
            Route::get('/shopdata-list', ['as' => 'employee.shopdata.list', 'uses' => 'EmployeeController@shopData']);
            //店铺销售数据详情列表
            Route::get('/shopdetails-list', ['as' => 'employee.shopdetails.list', 'uses' => 'EmployeeController@shopDetails']);

        });
        //老板业务中心
        Route::group(['middleware' => 'boss', 'prefix' => 'boss'], function () {
            //积分记录
            Route::get('/integral-record', ['as' => 'boss.record.integral', 'uses' => 'BossController@integralRecord']);
            //积分提现
            Route::get('/integral-withdraw', ['as' => 'boss.withdraw.apply', 'uses' => 'BossController@getWithdraw']);
            Route::post('/integral-withdraw', ['as' => 'boss.withdraw.apply', 'uses' => 'BossController@postWithdraw']);
            //提现记录
            Route::get('/withdraw-record', ['as' => 'boss.record.withdraw', 'uses' => 'BossController@withdrawRecord']);
            //店铺列表
            Route::get('/shop-list', ['as' => 'boss.shop.list', 'uses' => 'BossController@getShopList']);
            //导购列表
            Route::get('/sale-list', ['as' => 'boss.sale.list', 'uses' => 'BossController@getSaleList']);
            //销售记录
            //Route::get('/sale-record', ['as' => 'boss.record.sale', 'uses' => 'BossController@saleRecord']);
            //销售数据
            Route::get('/selldata-list', ['as' => 'boss.selldata.list', 'uses' => 'BossController@dataTable']);
            //总体销售数据列表
            Route::get('/totaldata-list', ['as' => 'boss.totaldata.list', 'uses' => 'BossController@totalData']);

            //导购销售数据列表
            Route::get('/saledata-list', ['as' => 'boss.saledata.list', 'uses' => 'BossController@saleData']);
            //导购销售数据详情列表
            Route::get('/saledetails-list', ['as' => 'boss.saledetails.list', 'uses' => 'BossController@saleDetails']);

            //店铺销售数据列表
            Route::get('/shopdata-list', ['as' => 'boss.shopdata.list', 'uses' => 'BossController@shopData']);
            //店铺销售数据详情列表
            Route::get('/shopdetails-list', ['as' => 'boss.shopdetails.list', 'uses' => 'BossController@shopDetails']);


        });
        //导购业务中心
        Route::group(['middleware' => 'sale', 'prefix' => 'sale'], function () {
            //佣金记录
            Route::get('/commission-record', ['as' => 'sale.record.commission', 'uses' => 'SaleController@commissionRecord']);
            //店铺列表
            Route::get('/shop-list', ['as' => 'sale.shop.list', 'uses' => 'SaleController@shopList']);
            //销售数据
            ///Route::get('/sale-record', ['as' => 'sale.record.sale', 'uses' => 'SaleController@saleRecord']);
            //销售统计
            Route::get('/saledata-list', ['as' => 'sale.saledata.list', 'uses' => 'SaleController@dataTable']);
            //总体销售数据列表
            Route::any('/total-sale-data', ['as' => 'sale.data.total', 'uses' => 'SaleController@totalDataTable']);
        });
        //老板业务中心
        Route::group(['middleware' => 'boss', 'prefix' => 'boss'], function () {
            Route::get('/integral-record', ['as' => 'boss.record.integral', 'uses' => 'BossController@integralRecord']);
        });
    });
});

//后台管理中心
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    //登录
    Route::get('/login', ['as' => 'admin.login', 'uses' => 'DefaultController@getLogin']);
    Route::post('/login', ['as' => 'admin.login', 'uses' => 'DefaultController@postLogin']);
    Route::get('/login/{token}', ['as' => 'admin.login.token', 'uses' => 'DefaultController@verifyToken']);
    //微信认证
    Route::group(['prefix' => 'verify', 'middleware' => 'wechat'], function () {
        Route::get('/{token}', 'DefaultController@getAdminTokenVerify');
        Route::post('/{token}', 'DefaultController@postAdminTokenVerify');
        Route::delete('/{token}', 'DefaultController@cancelAdminTokenVerify');
    });
    //登录后
    Route::group(['middleware' => ['auth:admin', 'auth.admin']], function () {
        Route::get('/set-menu', function () {
            $wechat = app('wechat');
            $buttons = [
                [
                    "name" => "扫一扫",
                    "type" => "scancode_push",
                    "key" => "scan_code",
                ],
                [
                    "type" => "view",
                    "name" => "积分商城",
                    "url" => "http://ec28.cn"
                ],
                [
                    "type" => "view",
                    "name" => "用户中心",
                    "url" => "http://ec28.cn/user"
                ],
            ];
            var_dump($wechat->menu->add($buttons));
        });
        //首页
        Route::get('/', ['as' => 'admin.login.token', 'uses' => 'DefaultController@index']);
        //修改密码
        Route::get('/change-password', ['as' => 'admin.change-password', 'uses' => 'DefaultController@getChangePassword']);
        Route::post('/change-password', ['as' => 'admin.change-password', 'uses' => 'DefaultController@postChangePassword']);
        //退出登录
        Route::get('/logout', ['as' => 'admin.logout', 'uses' => 'DefaultController@logout']);
        //系统设置
        Route::get('/setting', ['as' => 'admin.setting', 'uses' => 'DefaultController@getSetting']);
        Route::post('/setting', ['as' => 'admin.setting', 'uses' => 'DefaultController@postSetting']);
        //广告图管理
        Route::get('/banners', ['as' => 'admin.banner', 'uses' => 'BannerController@getBanner']);
        Route::get('/banner/{id?}', ['as' => 'admin.banner.page', 'uses' => 'BannerController@getBannerPage']);
        Route::post('/banner/{id?}', ['as' => 'admin.banner.page', 'uses' => 'BannerController@postBannerPage']);
        Route::delete('/banner/{id}', ['as' => 'admin.banner.delete', 'uses' => 'BannerController@bannerDelete']);
        //部门管理
        Route::get('departments', ['as' => 'admin.department.list', 'uses' => 'DepartmentController@index']);
        Route::get('department/{id?}', ['as' => 'admin.department.page', 'uses' => 'DepartmentController@getPage']);
        Route::post('department/{id?}', ['as' => 'admin.department.page', 'uses' => 'DepartmentController@postPage']);
        Route::delete('department/{id}', ['as' => 'admin.department.delete', 'uses' => 'DepartmentController@delete']);
        //产品管理
        Route::get('/products', ['as' => 'admin.product.list', 'uses' => 'ProductController@index']);
        Route::get('/product/{id?}', ['as' => 'admin.product.page', 'uses' => 'ProductController@getPage']);
        Route::post('/product/{id?}', ['as' => 'admin.product.page', 'uses' => 'ProductController@postPage']);
        Route::delete('/product/{id}', ['as' => 'admin.product.delete', 'uses' => 'ProductController@delete']);
        //会员积分活动管理
        Route::get('/activities/integral-list', ['as' => 'admin.activity.integral.list', 'uses' => 'ActivityController@integralList']);
        Route::get('/activities/integral/{id?}', ['as' => 'admin.activity.integral.page', 'uses' => 'ActivityController@getIntegral']);
        Route::post('/activities/integral/{id?}', ['as' => 'admin.activity.integral.page', 'uses' => 'ActivityController@postIntegral']);
        Route::delete('/activities/integral/{id}', ['as' => 'admin.activity.integral.delete', 'uses' => 'ActivityController@deleteIntegral']);
        Route::put('/activities/integral/{id}', ['as' => 'admin.activity.integral.up-or-down', 'uses' => 'ActivityController@upOrDownIntegral']);
        //会员红包活动管理
        Route::get('/activities/red-packet-list', ['as' => 'admin.activity.red-packet.list', 'uses' => 'ActivityController@redPacketList']);
        Route::get('/activities/red-packet/{id?}', ['as' => 'admin.activity.red-packet.page', 'uses' => 'ActivityController@getRedPacket']);
        Route::post('/activities/red-packet/{id?}', ['as' => 'admin.activity.red-packet.page', 'uses' => 'ActivityController@postRedPacket']);
        Route::delete('/activities/red-packet/{id}', ['as' => 'admin.activity.red-packet.delete', 'uses' => 'ActivityController@deleteRedPacket']);
        Route::put('/activities/red-packet/{id}', ['as' => 'admin.activity.red-packet.up-or-down', 'uses' => 'ActivityController@upOrDownRedPacket']);
        //导购红包活动管理
        Route::get('/activities/commission-list', ['as' => 'admin.activity.commission.list', 'uses' => 'ActivityController@commissionList']);
        Route::get('/activities/commission/{id?}', ['as' => 'admin.activity.commission.page', 'uses' => 'ActivityController@getCommission']);
        Route::post('/activities/commission/{id?}', ['as' => 'admin.activity.commission.page', 'uses' => 'ActivityController@postCommission']);
        Route::delete('/activities/commission/{id}', ['as' => 'admin.activity.commission.delete', 'uses' => 'ActivityController@deleteCommission']);
        Route::put('/activities/commission/{id}', ['as' => 'admin.activity.commission.up-or-down', 'uses' => 'ActivityController@upOrDownCommission']);
        //获取可参与活动产品
        Route::post('/activities/products', ['as' => 'admin.activity.products', 'uses' => 'ActivityController@searchProduct']);
        //直营商品管理
        Route::get('/goods-list', ['as' => 'admin.direct-goods.list', 'uses' => 'DirectController@index']);
        Route::get('/goods/{id?}', ['as' => 'admin.direct-goods.page', 'uses' => 'DirectController@getGoodsPage']);
        Route::post('/goods/{id?}', ['as' => 'admin.direct-goods.page', 'uses' => 'DirectController@postGoodsPage']);
        Route::delete('/goods/{id}', ['as' => 'admin.direct-goods.delete', 'uses' => 'DirectController@goodsDelete']);
        //直营优惠券管理
        Route::get('/directCoupon', ['as' => 'admin.direct-coupon.list', 'uses' => 'DirectController@getCouponList']);
        Route::get('/direct-coupon/{id?}', ['as' => 'admin.direct-coupon.page', 'uses' => 'DirectController@getCouponPage']);
        Route::post('/direct-coupon/{id?}', ['as' => 'admin.direct-coupon.page', 'uses' => 'DirectController@postCouponPage']);
        Route::delete('/direct-coupon/{id}', ['as' => 'admin.direct-coupon.delete', 'uses' => 'DirectController@CouponDelete']);
        //标签管理
        Route::get('/barcodes', ['as' => 'admin.barcode.list', 'uses' => 'BarCodeController@index']);
        Route::get('/barcodes/cancel', ['as' => 'admin.barcode.cancel', 'uses' => 'BarCodeController@cancel']);
        Route::get('/barcode/search', ['as' => 'admin.barcode.search', 'uses' => 'BarCodeController@search']);
        Route::get('/generate-barcode-cancel', ['as' => 'admin.generate-barcode-cancel.page', 'uses' => 'BarCodeController@getCancel']);
        Route::post('/generate-barcode-cancel', ['as' => 'admin.generate-barcode-cancel.page', 'uses' => 'BarCodeController@postCancel']);
        Route::get('/barcode/export', ['as' => 'admin.barcode.export', 'uses' => 'BarCodeController@exportForm']);
        //标签生成
        Route::get('/generate-barcode-tasks', ['as' => 'admin.generate-barcode-task.list', 'uses' => 'BarCodeController@taskList']);
        Route::get('/generate-barcode-task', ['as' => 'admin.generate-barcode-task.page', 'uses' => 'BarCodeController@getTaskPage']);
        Route::post('/generate-barcode-task', ['as' => 'admin.generate-barcode-task.page', 'uses' => 'BarCodeController@postTaskPage']);
        Route::get('/generate-barcode-download/{id}', ['as' => 'admin.generate-barcode-task.download', 'uses' => 'BarCodeController@downloadExport']);
        Route::post('/generate-barcode-import', ['as' => 'admin.generate-barcode-task.import', 'uses' => 'BarCodeController@importTask']);
        //标签导出
        //Route::get('/export-barcode-tasks', ['as' => 'admin.export-barcode-task.list', 'uses' => 'BarCodeController@exportList']);
        //Route::post('/export-barcode-task/{id}', ['as' => 'admin.export-barcode-task.page', 'uses' => 'BarCodeController@postExportPage']);
        //Route::get('/export-barcode-task/download/{id}', ['as' => 'admin.export-barcode-task.download', 'uses' => 'BarCodeController@downloadExport']);
        //Route::delete('/export-barcode-task/{id}', ['as' => 'admin.export-barcode-task.cancel', 'uses' => 'BarCodeController@cancelExport']);
        //会员管理
        Route::get('/members', ['as' => 'admin.member.list', 'uses' => 'MemberController@index']);
        Route::get('/members/forbidden/{id?}/{parameter?}', ['as' => 'admin.member.forbidden', 'uses' => 'MemberController@forbidden']);
        Route::post('/members/fore', ['as' => 'admin.member.fore', 'uses' => 'MemberController@fore']);

        Route::get('/member/addresses', ['as' => 'admin.member.address.list', 'uses' => 'MemberController@addressList']);
        Route::get('/member/favorites-Goods', ['as' => 'admin.member.favoriteGoods.list', 'uses' => 'MemberController@favoriteGoodsList']);
        Route::get('/member/favorites-Shops', ['as' => 'admin.member.favoriteShops.list', 'uses' => 'MemberController@favoriteShopsList']);
        Route::get('/member/import', ['as' => 'admin.member.import', 'uses' => 'MemberController@importFormWechat']);
        Route::get('/member/export', ['as' => 'admin.member.export', 'uses' => 'MemberController@exportFormWechat']);

        //积分记录
        Route::get('/records/integral', ['as' => 'admin.record.integral', 'uses' => 'RecordController@integral']);
        Route::get('/record/export', ['as' => 'admin.record.export', 'uses' => 'RecordController@exportFormInte']);
        //现金记录
        Route::get('/records/cash', ['as' => 'admin.record.cash', 'uses' => 'RecordController@cash']);
        Route::get('/record/exportcash', ['as' => 'admin.record.exportcash', 'uses' => 'RecordController@exportFormCash']);
        //提现记录
        Route::get('/records/withdraw', ['as' => 'admin.record.withdraw', 'uses' => 'RecordController@withdraw']);
        //标签验证记录
        Route::get('/records/barcode-verify', ['as' => 'admin.record.barcode-verify', 'uses' => 'RecordController@barcodeVerify']);
        Route::get('/record/exportbarcode', ['as' => 'admin.record.exportbarcode', 'uses' => 'RecordController@exportFormBarcode']);
        //员工审核
        Route::get('/audits/employees', ['as' => 'admin.audits.employee.list', 'uses' => 'AuditsController@employeeList']);
        Route::get('/audits/employee/{id}', ['as' => 'admin.audits.employee.page', 'uses' => 'AuditsController@getEmployee']);
        Route::post('/audits/approval/employee/{id}', ['as' => 'admin.audits.employee.approval', 'uses' => 'AuditsController@approvalEmployee']);
        Route::post('/audits/refusal/employee/{id}', ['as' => 'admin.audits.employee.refusal', 'uses' => 'AuditsController@refusalEmployee']);
        //员工列表
        Route::get('/employees', ['as' => 'admin.employee.list', 'uses' => 'EmployeeController@index']);

        Route::get('/employees/{id?}', ['as' => 'admin.employee.page', 'uses' => 'EmployeeController@getEmployeePage']);
        Route::post('/employees/{id?}', ['as' => 'admin.employee.page', 'uses' => 'EmployeeController@EmployeePage']);

        //管理员列表
        Route::get('/administrators', ['as' => 'admin.administrator.list', 'uses' => 'AdministratorController@index']);
        Route::get('/administrators/{id?}', ['as' => 'admin.administrator.page', 'uses' => 'AdministratorController@getAdminPage']);
        Route::post('/administrators/{id?}', ['as' => 'admin.administrator.page', 'uses' => 'AdministratorController@AdminPage']);

        //老板审核
        Route::get('/audits/bosses', ['as' => 'admin.audits.boss.list', 'uses' => 'AuditsController@bossList']);
        Route::get('/audits/boss/{id}', ['as' => 'admin.audits.boss.page', 'uses' => 'AuditsController@getBoss']);
        Route::post('/audits/approval/boss/{id}', ['as' => 'admin.audits.boss.approval', 'uses' => 'AuditsController@approvalBoss']);
        Route::post('/audits/refusal/boss/{id}', ['as' => 'admin.audits.boss.refusal', 'uses' => 'AuditsController@refusalBoss']);
        //老板列表
        Route::get('/bosses', ['as' => 'admin.boss.list', 'uses' => 'BossController@index']);
        Route::delete('/bosses/{id}', ['as' => 'admin.boss.delete', 'uses' => 'BossController@getdel']);

        //导购审核
        Route::get('/audits/sales', ['as' => 'admin.audits.sale.list', 'uses' => 'AuditsController@saleList']);
        Route::get('/audits/sale/{id}', ['as' => 'admin.audits.sale.page', 'uses' => 'AuditsController@getSale']);
        Route::post('/audits/approval/sale/{id}', ['as' => 'admin.audits.sale.approval', 'uses' => 'AuditsController@approvalSale']);
        Route::post('/audits/refusal/sale/{id}', ['as' => 'admin.audits.sale.refusal', 'uses' => 'AuditsController@refusalSale']);
        //导购列表
        Route::get('/sales', ['as' => 'admin.sale.list', 'uses' => 'SaleController@index']);
        Route::delete('/sales/{id}', ['as' => 'admin.sale.delete', 'uses' => 'SaleController@getdel']);

        //消息记录
        Route::get('/messages', ['as' => 'admin.message.list', 'uses' => 'MessageController@index']);
        Route::delete('/message/{id}', ['as' => 'admin.message.delete', 'uses' => 'MessageController@delete']);
        Route::get('/message/send-records', ['as' => 'admin.message.send-record', 'uses' => 'MessageController@sendRecordList']);
        //店铺审核
        Route::get('/audits/shops', ['as' => 'admin.audits.shop.list', 'uses' => 'AuditsController@shopList']);
        Route::get('/audits/shop/{id}', ['as' => 'admin.audits.shop.page', 'uses' => 'AuditsController@getShop']);
        Route::post('/audits/approval/shop/{id}', ['as' => 'admin.audits.shop.approval', 'uses' => 'AuditsController@approvalShop']);
        Route::post('/audits/refusal/shop/{id}', ['as' => 'admin.audits.shop.refusal', 'uses' => 'AuditsController@refusalShop']);
        //店铺列表
        Route::get('/shops', ['as' => 'admin.shop.list', 'uses' => 'ShopController@index']);
        Route::delete('/shops/{id}', ['as' => 'admin.shop.delete', 'uses' => 'ShopController@delete']);

        //店铺商品审核
        Route::get('/audits/commodities', ['as' => 'admin.audits.commodity.list', 'uses' => 'AuditsController@commodityList']);
        Route::get('/audits/commodity/{id}', ['as' => 'admin.audits.commodity.page', 'uses' => 'AuditsController@getCommodity']);
        Route::post('/audits/approval/commodity/{id}', ['as' => 'admin.audits.commodity.approval', 'uses' => 'AuditsController@approvalCommodity']);
        Route::post('/audits/refusal/commodity/{id}', ['as' => 'admin.audits.commodity.refusal', 'uses' => 'AuditsController@refusalCommodity']);
        //店铺商品列表

        Route::get('/shop/commodities/{id?}', ['as' => 'admin.shop.commodity.list', 'uses' => 'ShopController@commodityList']);

        Route::get('/commodity-page/{id?}', ['as' => 'admin.shop.commodity.page', 'uses' => 'ShopController@getgoodsPage']);
        Route::post('/commodity-page/{id?}', ['as' => 'admin.shop.commodity.page', 'uses' => 'ShopController@shopgoodsPage']);

        //店铺优惠劵审核
        Route::get('/audits/coupons', ['as' => 'admin.audits.coupon.list', 'uses' => 'AuditsController@couponList']);
        Route::get('/audits/coupon/{id}', ['as' => 'admin.audits.coupon.page', 'uses' => 'AuditsController@getCoupon']);
        Route::post('/audits/approval/coupon/{id}', ['as' => 'admin.audits.coupon.approval', 'uses' => 'AuditsController@approvalCoupon']);
        Route::post('/audits/refusal/coupon/{id}', ['as' => 'admin.audits.coupon.refusal', 'uses' => 'AuditsController@refusalCoupon']);
        //店铺优惠卷列表
        Route::get('/shop/coupons/{id?}', ['as' => 'admin.shop.coupon.list', 'uses' => 'ShopController@couponList']);

        Route::get('/coupons/{id?}', ['as' => 'admin.shop.page', 'uses' => 'ShopController@getPage']);
        Route::post('/coupons/{id?}', ['as' => 'admin.shop.page', 'uses' => 'ShopController@shopPage']);

        //订单列表
        Route::get('/orders', ['as' => 'admin.order.list', 'uses' => 'OrderController@index']);
        Route::get('/orders/{id?}', ['as' => 'admin.order.page', 'uses' => 'OrderController@getOrderPage']);
        Route::post('/orders/{id?}', ['as' => 'admin.order.page', 'uses' => 'OrderController@orderPage']);
        Route::get('/order/export', ['as' => 'admin.order.export', 'uses' => 'OrderController@exportFormOrder']);

        //订单评论列表
        Route::get('/order/comments', ['as' => 'admin.order.comment.list', 'uses' => 'OrderController@commentList']);
        //后台上传
        Route::post('/upload', ['as' => 'admin.widget.upload', 'uses' => 'WidgetController@upload']);
    });
});

//回调通知
Route::group(['prefix' => 'notify'], function () {
    //微信后台
    Route::match(['get', 'post'], '/wechat', 'NotifyController@wechat');
});

//插件
Route::group(['prefix' => 'widget'], function () {
    Route::post('/address', ['as' => 'widget.address', 'uses' => 'WidgetController@address']);
    Route::post('/location-to-address', ['as' => 'widget.location', 'uses' => 'WidgetController@location']);
    Route::get('/images/{name}', ['as' => 'widget.images', 'uses' => 'WidgetController@images']);
});
