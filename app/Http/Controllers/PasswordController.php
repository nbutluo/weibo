<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use DB;

class PasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // 1.验证邮箱
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        $email = $request->email;

        // 2. 获取对应用户
        $user = User::where('email', $email)->first();

        // 3. 如果不存在
        if (is_null($user)) {
            session()->flash('danger', '邮箱未注册');
            return redirect()->back()->withInput();
        }

        // 4. 生成 Token，会在视图 emails.reset_link 里拼接链接
        $token = hash_hmac('sha256', Str::random(40), config('app.key'));

        // 5. 入库，使用 updateOrInsert 来保持 Email 唯一
        DB::table('password_resets')->updateOrInsert(['email' => $email], [
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => new Carbon,
        ]);

        // 6. 将 Token 链接发送给用户
        Mail::send('emails.reset_link', compact('token'), function ($message) use ($email) {
            $message->to($email)->subject("忘记密码");
        });

        return redirect()->back()->with('success', '重置邮件发送成功，请查收');
    }

    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');
        return view('auth.passwords.reset', compact('token'));
    }

    public function reset(Request $request)
    {
        // 1. 验证数据是否合规
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $email = $request->email;
        $token = $request->token;
        // 找回密码链接的有效时间
        $expires = 60 * 10;

        // 2.获取对应的用户
        $user = User::where('email', $email)->first();

        // 3.如果不存在
        if (is_null($user)) {
            session()->flash('danger', '邮箱未注册');
            return redirect()->back()->withInput();
        }

        // 4. 读取重置记录
        $record = (array) DB::table('password_resets')->where('email', $email)->first();

        // 5.记录存在
        if ($record) {
            // 5.1 检查是否过期
            if (Carbon::parse($record['created_at'])->addSeconds($expires)->isPast()) {
                return redirect()->back()->with('danger', '链接已过期，请重置');
            }

            // 5.2检查是否正确
            if (!Hash::check($token, $record['token'])) {
                return back()->with('danger', '令牌错误');
            }

            // 5.3 一切正常，更新用户密码
            $user->update([
                'password' => bcrypt($request->password),
            ]);

            // 提示更新成功
            session()->flash('success', '密码重置成功，请重新登录');

            return redirect()->route('login');
        }

        // 6. 记录不存在
        return redirect()->back()->with('warning', '未找到重置记录');
    }
}
