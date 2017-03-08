<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/7/21
 * Time: 14:56
 */

namespace App;


class AdminMenu
{
    public static function menuList()
    {
        return [
            [
                'name' => '产品管理',
                'children' => [
                    [
                        'name' => '产品列表',
                        'url' => 'admin.product.list',
                        'active' => [
                            'admin.product.list',
                        ],
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '会员积分活动管理',
                        'url' => 'admin.activity.integral.list',
                        'icon' => 'am-icon-male',
                        'active' => [
                            'admin.activity.integral.page',
                        ]
                    ],
                    [
                        'name' => '会员红包活动管理',
                        'url' => 'admin.activity.red-packet.list',
                        'icon' => 'am-icon-male',
                        'active' => [
                            'admin.activity.red-packet.page',
                        ]
                    ],
                    [
                        'name' => '导购红包活动管理',
                        'url' => 'admin.activity.commission.list',
                        'icon' => 'am-icon-male',
                        'active' => [
                            'admin.activity.commission.page',
                        ]
                    ],
                ]
            ],
            [
                'name' => '直营管理',
                'children' => [
                    [
                        'name' => '直营商品列表',
                        'url' => 'admin.direct-goods.list',
                        'active' => [
                            'admin.direct-goods.list',
                        ],
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '直营优惠券列表',
                        'url' => 'admin.direct-coupon.list',
                        'icon' => 'am-icon-male',
                    ],
                ]
            ],
            [
                'name' => '标签管理',
                'children' => [
                    [
                        'name' => '标签列表',
                        'url' => 'admin.barcode.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '标签生成',
                        'url' => 'admin.generate-barcode-task.list',
                        'icon' => 'am-icon-male',
                    ],
//                    [
//                        'name' => '标签导出',
//                        'url' => 'admin.export-barcode-task.list',
//                        'icon' => 'am-icon-male',
//                    ],
                ]
            ],
            [
                'name' => '基础资料管理',
                'children' => [
                    [
                        'name' => '系统参数',
                        'url' => 'admin.setting',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '部门资料管理',
                        'url' => 'admin.department.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '广告图管理',
                        'url' => 'admin.banner',
                        'icon' => 'am-icon-male',
                    ]
                ]
            ],
            [
                'name' => '会员管理',
                'children' => [
                    [
                        'name' => '会员列表',
                        'url' => 'admin.member.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '收货地址列表',
                        'url' => 'admin.member.address.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '会员商品收藏',
                        'url' => 'admin.member.favoriteGoods.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '会员店铺收藏',
                        'url' => 'admin.member.favoriteShops.list',
                        'icon' => 'am-icon-male',
                    ],
                ]
            ],
            [
                'name' => '审核管理',
                'children' => [
                    [
                        'name' => '员工审核',
                        'url' => 'admin.audits.employee.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '老板审核',
                        'url' => 'admin.audits.boss.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '导购审核',
                        'url' => 'admin.audits.sale.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '店铺审核',
                        'url' => 'admin.audits.shop.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '店铺商品审核',
                        'url' => 'admin.audits.commodity.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '店铺优惠劵审核',
                        'url' => 'admin.audits.coupon.list',
                        'icon' => 'am-icon-male',
                    ],
                ]
            ],
            [
                'name' => '内部人员管理',
                'children' => [
                    [
                        'name' => '员工管理',
                        'url' => 'admin.employee.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '管理员列表',
                        'url' => 'admin.administrator.list',
                        'icon' => 'am-icon-male',
                    ],
                ]
            ],
            [
                'name' => '店铺人员管理',
                'children' => [
                    [
                        'name' => '老板管理',
                        'url' => 'admin.boss.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '导购管理',
                        'url' => 'admin.sale.list',
                        'icon' => 'am-icon-male',
                    ],
                ]
            ],
            [
                'name' => '交易记录',
                'children' => [
                    [
                        'name' => '积分发放记录',
                        'url' => 'admin.record.integral',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '现金奖励记录',
                        'url' => 'admin.record.cash',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '提现记录',
                        'url' => 'admin.record.withdraw',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '标签扫描记录',
                        'url' => 'admin.record.barcode-verify',
                        'icon' => 'am-icon-male',
                    ],
                ]
            ],
            [
                'name' => '店铺管理',
                'children' => [
                    [
                        'name' => '店铺列表',
                        'url' => 'admin.shop.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '店铺商品列表',
                        'url' => 'admin.shop.commodity.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '店铺优惠劵列表',
                        'url' => 'admin.shop.coupon.list',
                        'icon' => 'am-icon-male',
                    ],
                ]
            ],
            [
                'name' => '消息管理',
                'children' => [
                    [
                        'name' => '消息列表',
                        'url' => 'admin.message.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '消息推送记录',
                        'url' => 'admin.message.send-record',
                        'icon' => 'am-icon-male',
                    ],
                ]
            ],
            [
                'name' => '订单管理',
                'children' => [
                    [
                        'name' => '订单列表',
                        'url' => 'admin.order.list',
                        'icon' => 'am-icon-male',
                    ],
                    [
                        'name' => '订单评论列表',
                        'url' => 'admin.order.comment.list',
                        'icon' => 'am-icon-male',
                    ],
                ]
            ],
        ];
    }

    public static function sidebar()
    {
        $return = [];
        foreach (self::menuList() as $menu) {
            $returnMenu = [
                'name' => $menu['name'],
                'is_active' => false,
            ];
            if (isset($menu['children']) && is_array($menu['children'])) {
                foreach ($menu['children'] as $subMenu) {
                    if (self::checkCurrent($subMenu)) {
                        $subMenu['is_active'] = true;
                        $returnMenu['is_active'] = true;
                    } else {
                        $subMenu['is_active'] = false;
                    }
                    $returnMenu['children'][] = $subMenu;
                }
            }
            $return[] = $returnMenu;
        }
        return $return;
    }

    public static function checkCurrent($subMenu)
    {
        $currentUrl = url()->current();
        $urls[] = route($subMenu['url']);
        if (isset($subMenu['active'])) {
            foreach ($subMenu['active'] as $url) {
                $urls[] = route($url);
            }
        }
        return in_array($currentUrl, $urls);
    }
}