<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadInteractionController extends Controller
{
    public function toggleLike(Thread $thread)
    {
        $userId = Auth::id() ?? 1;

        if ($thread->likes()->where('user_id', $userId)->exists()) {
            $thread->likes()->detach($userId);
        } else {
            $thread->likes()->attach($userId);
        }

        return back();
    }

    public function toggleSave(Thread $thread)
    {
        $userId = Auth::id() ?? 1;

        if ($thread->saves()->where('user_id', $userId)->exists()) {
            $thread->saves()->detach($userId);
        } else {
            $thread->saves()->attach($userId);
        }

        return back();
    }

    public function storeReply(Request $request, Thread $thread)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:thread_replies,id',
        ]);

        ThreadReply::create([
            'user_id' => Auth::id() ?? 1,
            'thread_id' => $thread->id,
            'parent_id' => $request->parent_id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Balasan berhasil dikirim!');
    }
}
