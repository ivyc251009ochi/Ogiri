<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Answer;
use App\Models\Report;

class AdminController extends Controller
{
    /**
     * 管理画面トップ
     */
    public function index()
    {
        $userCount = User::count();
        $topicCount = Topic::count();
        $answerCount = Answer::count();
        $reportCount = Report::count();

        return view('admin.index', compact(
            'userCount',
            'topicCount',
            'answerCount',
            'reportCount'
        ));
    }

    /**
     * 通報一覧
     */
    public function reports()
    {
        $reports = Report::latest()->get();

        return view('admin.reports', compact('reports'));
    }

    /**
     * ユーザー一覧
     */
    public function users()
    {
        $users = User::all();

        return view('admin.users', compact('users'));
    }

    /**
     * 利用停止
     */
    public function suspend(User $user)
    {
        $user->status = 'suspended';
        $user->save();

        return back()->with('success', '利用停止にしました。');
    }

    /**
     * 利用停止解除
     */
    public function activate(User $user)
    {
        $user->status = 'active';
        $user->save();

        return back()->with('success', '利用停止を解除しました。');
    }
}