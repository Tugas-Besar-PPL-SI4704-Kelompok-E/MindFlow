<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index()
    {
        // Add withCount for likes, saves, replies
        $threads = Thread::query()->with('user')->withCount(['likes', 'saves', 'replies'])->latest()->get();
        return view('forum.index', compact('threads'));
    }

    public function show(Thread $forum)
    {
        $forum->load(['user', 'replies.user'])->loadCount(['likes', 'saves', 'replies']);
        // Only load top-level replies (parent_id is null) for the initial render
        $topReplies = $forum->replies()->whereNull('parent_id')->with('children.user')->withCount('children')->latest()->get();

        return view('forum.show', [
            'thread' => $forum,
            'replies' => $topReplies
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        if ($user && $user->status === 'muted' && $user->muted_until && now()->lessThan($user->muted_until)) {
            return back()->with([
                'mute_error' => true,
                'mute_until' => $user->muted_until->toIso8601String()
            ]);
        }

        Thread::query()->create([
            'user_id' => Auth::id() ?? 1, // Fallback to 1 for dummy auth
            'content' => $request->content,
            'is_anonymous' => $request->has('is_anonymous'),
        ]);

        return redirect()->route('forum.index')->with('success', 'Thread berhasil dibuat!');
    }

    public function edit(Thread $forum)
    {
        if ($forum->user_id !== (Auth::id() ?? 1)) {
            abort(403, 'Unauthorized action.');
        }

        if ($forum->created_at->diffInMinutes(now()) > 15) {
            abort(403, 'Batas waktu edit telah habis (15 menit).');
        }

        return view('forum.edit', ['thread' => $forum]);
    }

    public function update(Request $request, Thread $forum)
    {
        if ($forum->user_id !== (Auth::id() ?? 1)) {
            abort(403, 'Unauthorized action.');
        }

        if ($forum->created_at->diffInMinutes(now()) > 15) {
            abort(403, 'Batas waktu edit telah habis (15 menit).');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $forum->update([
            'content' => $request->content,
            'is_anonymous' => $request->has('is_anonymous'),
        ]);

        return redirect()->route('forum.index')->with('success', 'Thread berhasil diperbarui!');
    }

    public function destroy(Thread $forum)
    {
        $user = Auth::user();
        $isAdmin = $user && $user->role === 'admin';
        
        if (!$isAdmin && $forum->user_id !== (Auth::id() ?? 1)) {
            abort(403, 'Unauthorized action.');
        }

        $forum->delete();

        return redirect()->route('forum.index')->with('success', 'Thread berhasil dihapus!');
    }
}
