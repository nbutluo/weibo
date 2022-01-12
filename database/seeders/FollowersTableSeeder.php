<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        // 获取去除掉 ID 为 1 的所有用户 ID 数组
        $followers = $users->slice(1);
        $follower_ids =  $followers->pluck('id')->toArray();

        // 关注除了 1号以外的所有用户
        $user->follow($follower_ids);

        // 除了 1号以外的所有用户都来关注 1号用户
        foreach ($followers as $follow) {
            $follow->follow($user_id);
        }
    }
}
