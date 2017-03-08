<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/28
 * Time: 9:08
 */

namespace App\Http\Controllers\Admin;


use App\Favorite;
use App\Http\Controllers\Controller;
use App\User;
use App\UserAddress;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;


class MemberController extends Controller
{
    public function index(Request $request)
    {
        $searchKey = ['name', 'childName','mobile','birthday','childBirthday'];
        $query = User::query();
        $search = [];
        foreach ($searchKey as $key) {
            $search[$key] = $request->input($key);
            $query->where($key, 'like', '%' . $request->input($key) . '%');
        }
        return view('admin.member.list', ['list' => $query->whereRole(User::ROLE_MEMBER)->orderBy('id','desc')->paginate(15),'search' => $search]);
    }

    public function forbidden($id,$parameter)
    {
       if($parameter==1){
           $user = User::where('id', '=', $id)->update(['status' => User::STATUS_LOCK]);
           if($user){
               return response()->json(['code' => 1, 'message' => '禁用成功', 'url' => '']);
           }else{
               return response()->json(['code' => 0, 'message' => '禁用失败', 'url' => '']);
           }
       }elseif($parameter==2){
           $user = User::where('id', '=', $id)->update(['status' => User::STATUS_NORMAL]);
           if($user){
               return response()->json(['code' => 1, 'message' => '解除成功', 'url' => '']);
           }else{
               return response()->json(['code' => 0, 'message' => '解除失败', 'url' => '']);
           }
       }
    }

    public function fore()
    {
        $id = Input::get(['idd']);
        $user = User::whereIn('id',array($id))->update(['status' => User::STATUS_LOCK]);
        if($user){
            return response()->json(['code' => 1, 'message' => '禁用成功', 'url' => '']);
        }else{
            return response()->json(['code' => 0, 'message' => '禁用失败', 'url' => '']);
        }
    }



    public function addressList()
    {
        return view('admin.member.address-list', ['list' => UserAddress::paginate(15)]);
    }

    public function favoriteGoodsList()
    {
        return view('admin.member.favoriteGoods-list', ['list' => Favorite::whereType(Favorite::TYPE_GOODS)->paginate(15)]);
    }

    public function favoriteShopsList()
    {
        return view('admin.member.favoriteShops-list', ['list' => Favorite::whereType(Favorite::TYPE_SHOP)->paginate(15)]);
    }

    public function importFormWechat()
    {
        set_time_limit(0);
        $app = app('wechat');
        $userList = [];
        do {
            $users = $app->user->lists();
            $userList = array_merge($userList, $users['data']['openid']);
        } while (collect($userList)->last() != $users['next_openid']);
        foreach ($userList as $openid) {
            if (!$user = User::findByOpenid($openid)) {
                $user = User::registerByOpenid($openid);
            }
            if (!$user->is_subscribe) {
                $user->subscribe();
            }
        }
        return redirect(route('admin.member.list'));
    }

    public function exportFormWechat()
    {
        $list = User::whereRole(User::ROLE_MEMBER)->orderBy('id','asc')->get();

        foreach ($list as $key => $value) {
            $export[] = array(
                'ID' => $value['id'],
                '姓名' => $value['name'],
                '性别' => $value['sex_text'],
                '生日' => $value['birthday'],
                '手机号' => $value['mobile'],
                '孩子姓名' => $value['childName'],
                '孩子性别' => $value['childSex_text'],
                '孩子生日' => $value['childBirthday'],
                '创建时间' => $value['created_at'],
                '修改时间' => $value['updated_at'],
            );
        }

        $tab_name = '会员列表';
        Excel::create($tab_name, function($excel) use ($export) {
            $excel->sheet('export', function($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');
        iconv('UTF-8', 'GBK',$tab_name);

        return redirect(route('admin.member.list'));
    }
}