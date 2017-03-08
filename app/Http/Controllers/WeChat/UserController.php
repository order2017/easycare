<?php

namespace App\Http\Controllers\WeChat;

use App\Comment;
use App\CommissionBlotter;
use App\Employee;
use App\EmployeeApply;
use App\Favorite;
use App\FeedBack;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyEmployeeRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\UserAddressRequest;
use App\Http\Requests\UserInfoRequest;
use App\IntegralBlotter;
use App\Message;
use App\Order;
use App\Region;
use App\ShopStaffApply;
use App\User;
use App\UserAddress;
use App\UserCoupon;
use App\UserOAuthInfo;
use Auth;
use DB;
use Illuminate\Http\Exception\HttpResponseException;
use QrCode;
use Redirect;
use \Illuminate\Http\Request;
use Session;

class UserController extends Controller
{

    public function index()
    {
        if (Auth::user()->is_member) {
            return view('frontend.user.index');
        } elseif (Auth::user()->is_boss) {
            return view('frontend.boss.index');
        } elseif (Auth::user()->is_employee) {
            return view('frontend.employee.index');
        } elseif (Auth::user()->is_sale) {
            return view('frontend.sale.index');
        }
        abort(401);
    }

    public function login()
    {
        if (Auth::guest()) {
            $userInfo = session('wechat.oauth_user');
            if (!$user = User::findByOpenid($userInfo['id'])) {
                $user = User::registerByOpenid($userInfo['id']);
            }
            $user && Auth::login($user);
        }
        return redirect()->intended();
    }

    public function getInfo()
    {
        return view('frontend.user.info', ['info' => Auth::user()]);
    }

    public function putInfo()
    {
        return view('frontend.user.info-form', ['user' => Auth::user()]);
    }

    public function postInfo(UserInfoRequest $request)
    {
        if ($request->ajax()) return null;
        Auth::user()->fill($request->only(['name',
            'sex',
            'mobile',
            'birthday',
            'childName',
            'childSex',
            'childBirthday']))->saveOrFail();
        return view('frontend.user.info-success');
    }

    public function getApplyEmployee()
    {
        $apply = $this->hasApplyEmployee();
        return view('frontend.user.apply-employee', ['apply' => $apply]);
    }

    public function postApplyEmployee(ApplyEmployeeRequest $request)
    {
        $apply = $this->hasApplyEmployee();
        if ($request->ajax()) {
            return null;
        }
        $apply = empty($apply) ? new EmployeeApply(['user_id' => Auth::user()->id]) : $apply;
        $apply->fill($request->only(['name', 'mobile', 'email', 'province_id', 'city_id', 'county_id', 'address', 'departments_id']))->setAttribute('status',EmployeeApply::STATUS_WAIT)->saveOrFail();
        return view('frontend.user.apply-success');
    }

    protected function hasApplyEmployee()
    {
        $apply = EmployeeApply::whereUserId(Auth::user()->id)->first();
        if ($apply && in_array($apply->status, [EmployeeApply::STATUS_WAIT, EmployeeApply::STATUS_APPROVE])) {
            throw new HttpResponseException(response(view('frontend.user.apply-success')));
        }
        return $apply;
    }

    public function getApply($token)
    {
        $employee = $this->getEmployeeByToken($token);
        return view('frontend.user.apply', ['employee' => $employee]);
    }

    public function postApply(Request $request, $token)   //店铺员工/老板申请
    {
        $employee = $this->getEmployeeByToken($token);
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required|mobile',
        ]);
        if ($request->ajax()) {
            return null;
        }
        $apply = new ShopStaffApply();
        $apply->user_id = Auth::user()->id;
        $apply->employees_id = $employee->id;
        $apply->fill($request->only(['name', 'mobile']))->saveOrFail();
        return view('frontend.user.apply-success');
    }

    protected function getEmployeeByToken($token)
    {
        if (Auth::user()->is_has_apply_shop_staff) {
            throw new HttpResponseException(response(view('frontend.user.apply-repeat-submit')));
        }
        return Employee::whereToken($token)->firstOrFail();
    }

    public function couponList($type = null)
    {
        $type = $type === null ? 'wait' : $type;
        $query = UserCoupon::whereUserId(Auth::user()->id);
        if ($type == 'wait') {
            $query->normal();
        } elseif ($type == 'finish') {
            $query->whereStatus(UserCoupon::STATUS_FINISH);
        } elseif ($type == 'expired') {
            $query->expired();
        }
        return view('frontend.user.coupon-list', ['list' => $query->get(), 'type' => $type]);
    }

    public function orderList($type = null, $keyword = null)
    {
        $type = $type === null ? 'all' : $type;
        $query = Order::whereUserId(Auth::user()->id);
        switch ($type) {
            case 'all':
                break;
            case 'wait':
                $query->whereStatus(Order::STATUS_WAIT);
                break;
            case 'finish':
                $query->whereStatus(Order::STATUS_FINISH);
                break;
        }
        $list = $query->get();
        return view('frontend.user.order-list', ['list' => $list, 'type' => $type]);
    }

    public function orderWaitList()
    {
        $type = Order::whereUserId(Auth::user()->id)->whereStatus(Order::STATUS_WAIT)->value('status');
        $list = Order::whereUserId(Auth::user()->id)->whereStatus(Order::STATUS_WAIT)->get();
        return view('frontend.user.order-list', ['list' => $list, 'type' => $type]);
    }

    public function orderPage($id)
    {
        $order = Order::findOrFail($id);
        return view('frontend.user.order-page', ['order' => $order]);
    }

    public function orderExchange($id)
    {
        $order = Order::findOrFail($id);
        return view('frontend.user.order-exchange', ['code' => 'data:image/png;base64,'
            . base64_encode(QrCode::format('png')->size(200)->margin(0)
                ->generate(route('order.exchange.goods', ['orderNumber' => $order['order_number'], 'password' => $order['password']])))]);
    }

    public function couponExchange($id)
    {
        $order = UserCoupon::findOrFail($id);
        return view('frontend.user.order-exchange', ['code' => 'data:image/png;base64,'
            . base64_encode(QrCode::format('png')->size(200)->margin(0)
                ->generate(route('order.exchange.coupon', ['couponNumber' => $order['coupon_number'], 'password' => $order['password']])))]);
    }

    public function integralList()
    {
        return view('frontend.user.integral-record', ['list' => IntegralBlotter::whereUserId(Auth::user()->id)->orderBy('created_at', 'desc')->get()]);
    }

    public function integralPage()
    {
        return view('frontend.user.integral-record');
    }

    public function feedback()
    {
        return view('frontend.user.feedback');
    }

    public function postFeedback(FeedbackRequest $request)
    {
        if ($request->ajax()) {
            return null;
        }
        $apply = new FeedBack(['user_id' => Auth::user()->id]);
        $apply->fill($request->only(['type', 'mobile', 'content']))->saveOrFail();
        return view('frontend.user.feedbackApply-success');
    }

    public function commissionList()
    {
        return view('frontend.user.commission-record', ['list' => CommissionBlotter::whereUserId(Auth::user()->id)->orderBy('created_at', 'desc')->get()]);
    }

    //我的收藏列表
    public function favourites($type = null)
    {
        $type = $type === null ? 'goods' : $type;
        $query = Favorite::whereUserId(Auth::user()->id);
        switch ($type) {
            case 'goods':
                $query->whereType(Favorite::TYPE_GOODS);
                break;
            case 'shop':
                $query->whereType(Favorite::TYPE_SHOP);
                break;
            case 'coupon':
                $query->whereType(Favorite::TYPE_COUPON);
                break;
        }
        $count = $query->first();
        $favouriteList = $query->get();
        return view('frontend.user.favourite-list', ['list' => $favouriteList, 'type' => $type, 'count' => $count]);
    }

    public function commentsWait()
    {
        return view('frontend.user.comment-wait-list',
            ['list' => Order::whereUserId(Auth::user()->id)->whereStatus(Order::STATUS_FINISH)->whereCommentStatus(Order::COMMENTS_WAIT)->get()]);
    }

    public function commentsHas()
    {
        $model = Order::join('comments', 'orders.id', '=', 'comments.order_id')
            ->select('orders.*', 'comments.created_at', 'comments.content', 'comments.point')
            ->get();
        $type = Order::join('comments', 'orders.id', '=', 'comments.order_id')
            ->select('orders.*', 'comments.created_at', 'comments.content', 'comments.point')->exists();
        return view('frontend.user.comment-has-list', ['list' => $model, 'type' => $type]);
    }

    public function getComment($id)
    {
        return view('frontend.user.comment', ['model' => Order::findOrFail($id)]);
    }

    public function postComment(CommentRequest $request, $id)
    {
        if ($request->ajax()) {
            return null;
        }
        $apply = new Comment(['order_id' => $id]);
        $apply->fill($request->only(['content', 'point', 'images']))->saveOrFail();
        return view('frontend.user.comment-success');
    }

    public function addressList()
    {
        return view('frontend.user.address-list',
            ['list' => UserAddress::whereUserId(Auth::user()->id)->get(),
                'type' => UserAddress::whereUserId(Auth::user()->id)->exists()
            ]);
    }

    public function messagesList()
    {
        return view('frontend.user.message-list',
            ['list' => Message::whereToUserId(Auth::user()->id)->get(),
                'type' => Message::whereToUserId(Auth::user()->id)->exists()
            ]);
    }

    public function destroyList($id)
    {
        $post = UserAddress::find($id);
        $post->delete();
        if ($post->trashed()) {

            return view('frontend.user.addressDelete-success');
        }
    }

    public function addressSave(UserAddressRequest $request)
    {
        $model = new UserAddress();
        $model->fill($request->only(['contact', 'phone', 'province_id', 'city_id', 'county_id', 'address']))->setAttribute('user_id', Auth::user()->id)->saveOrFail();
        return response()->json(['code' => 1, 'message' => '保存成功', 'data' => $model]);
    }

}