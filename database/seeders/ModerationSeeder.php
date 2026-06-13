<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\ArtikelReport;
use App\Models\Forum;
use App\Models\LaporanForum;
use App\Models\ReplyReport;
use App\Models\Thread;
use App\Models\ThreadReply;
use App\Models\ThreadReport;
use App\Models\User;
use Illuminate\Database\Seeder;

class ModerationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have some users
        if (User::count() < 10) {
            User::factory(10)->create();
        }

        $users = User::all();
        $threads = Thread::all();
        $replies = ThreadReply::all();
        $artikels = Artikel::all();
        $forums = Forum::all();

        // If no threads/artikels, create some
        if ($threads->isEmpty()) {
            Thread::factory(5)->create();
            $threads = Thread::all();
        }
        if ($replies->isEmpty()) {
            foreach ($threads as $thread) {
                ThreadReply::factory(2)->create(['thread_id' => $thread->id]);
            }
            $replies = ThreadReply::all();
        }
        if ($artikels->isEmpty()) {
            Artikel::factory(5)->create();
            $artikels = Artikel::all();
        }
        if ($forums->isEmpty()) {
            Forum::factory(5)->create();
            $forums = Forum::all();
        }

        // Create Thread Reports
        foreach ($threads->random(min(3, $threads->count())) as $thread) {
            ThreadReport::factory(rand(1, 2))->create([
                'thread_id' => $thread->id,
                'user_id' => $users->random()->id
            ]);
        }

        // Create Reply Reports
        foreach ($replies->random(min(3, $replies->count())) as $reply) {
            ReplyReport::factory(rand(1, 2))->create([
                'thread_reply_id' => $reply->id,
                'user_id' => $users->random()->id
            ]);
        }

        // Create Artikel Reports
        foreach ($artikels->random(min(3, $artikels->count())) as $artikel) {
            ArtikelReport::factory(rand(1, 2))->create([
                'artikel_id' => $artikel->artikel_id,
                'user_id' => $users->random()->id
            ]);
        }

        // Create Forum Reports (LaporanForum)
        foreach ($forums->random(min(3, $forums->count())) as $forum) {
            LaporanForum::factory(rand(1, 2))->create([
                'forum_id' => $forum->forum_id,
                'pelapor_id' => $users->random()->id
            ]);
        }

        // Mute some users for "moderenisasi" testing
        $usersToMute = $users->where('role', 'user')->random(min(2, $users->where('role', 'user')->count()));
        foreach ($usersToMute as $user) {
            $user->update([
                'muted_until' => now()->addDays(rand(1, 7)),
                'punishment_reason' => 'Repeatedly posting spam content.'
            ]);
        }
    }
}
