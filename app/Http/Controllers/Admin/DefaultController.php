<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminChangePasswordRequest;
use App\LoginVerify;
use App\Setting;
use App\User;
use Auth;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Request;
use QrCode;

class DefaultController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function getLogin()
    {
        if (Auth::guard('admin')->guest()) {
            return view('admin.login');
        }
        return redirect('/admin/');
    }

    public function getChangePassword()
    {
        return view('admin.change-password');
    }

    public function postChangePassword(AdminChangePasswordRequest $request)
    {
        if (\Hash::check($request->input('old_password'), $request->user('admin')->password)) {
            $request->user('admin')->changePassword($request->input('new_password'));
            return response()->json(['code' => 1, 'message' => '修改成功', 'url' => route('admin.logout')]);
        } else {
            return response()->json(['code' => 0, 'message' => '原密码错误']);
        }
    }

    public function logout()
    {
        if (!Auth::guard('admin')->guest()) {
            Auth::guard('admin')->logout();
        }
        return redirect('/admin/login');
    }

    /**
     * 验证登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function postLogin(Request $request)
    {
        if ($user = User::findByUsername($request->input('username'))) {
            if ($user->validatePassword($request->input('password'))) {
                $loginVerify = LoginVerify::generateByUserId($user['id']);
                return response()->json(['code' => 1, 'data' => [
                    'image' => 'data:image/png;base64,'
                        . base64_encode(QrCode::format('png')
                            ->size(200)
                            ->margin(0)
                            ->generate(url('/admin/verify', ['token' => $loginVerify->token]))),
                    'token' => $loginVerify->token
                ]]);
            }
        }
        return response()->json(['code' => 0, 'message' => '用户名不存在或密码错误']);
    }

    /**
     * 检查token状态
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */

    public function verifyToken($token)
    {
        $loginVerify = LoginVerify::whereToken($token)->first();
        if ($loginVerify->is_success) {
            Auth::guard('admin')->login($loginVerify->user);
            return response()->json(['code' => 1, 'data' => url('/admin')]);
        }
        return response()->json(['code' => 0]);
    }

    /**
     * 显示确认界面
     * @param $token
     * @return mixed
     */

    public function getAdminTokenVerify($token)
    {
        $this->verifyTokenExist($token);
        return view('admin.token.verify');
    }

    /**
     * 确认登录
     * @param Request $request
     * @param $token
     * @return null
     */

    public function postAdminTokenVerify(Request $request, $token)
    {
        $loginVerify = $this->verifyTokenExist($token);
        if ($request->ajax()) {
            return null;
        }
        $loginVerify->confirm();
        return view('admin.token.success');
    }

    protected function verifyTokenExist($token)
    {
        if (!$loginVerify = LoginVerify::whereToken($token)->first()) {
            throw new HttpResponseException(response(view('admin.token.not-found')));
        }
        if ($loginVerify->is_expired) {
            throw new HttpResponseException(response(view('admin.token.expired')));
        }
        $userInfo = session('wechat.oauth_user');
        if ($loginVerify->verifyUser($userInfo['id'])) {
            return $loginVerify;
        }
        throw new HttpResponseException(response(view('admin.token.user-fail')));
    }

    /**
     * @return mixed
     */

    public function cancelAdminTokenVerify()
    {
        return view('admin.token.cancel');
    }

    public function getSetting()
    {
        return view('admin.setting');
    }

    public function postSetting(Request $request)
    {
        foreach ($request->only(Setting::keyList()) as $key => $value) {
            Setting::setValue($key, $value);
        }
        return response()->json(['code' => 1, 'url' => route('admin.setting'), 'message' => '保存成功']);
    }


}