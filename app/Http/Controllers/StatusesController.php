<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);

        Auth::user()->statuses()->create([
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', '发布成功');
    }

    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);

        $status->delete();

        return redirect()->back()->with('success', '删除成功');
    }
}
