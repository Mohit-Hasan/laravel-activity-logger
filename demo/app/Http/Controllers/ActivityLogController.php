<?php

namespace App\Http\Controllers;

use MohitHasan\ActivityLogger\Facades\ActivityLogger;
use MohitHasan\ActivityLogger\Models\ActivityLog;
use App\Models\Post;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLogger::getAll();
        return view('logs', ['logs' => $logs]);
    }

    public function manualLog()
    {
        ActivityLogger::action('custom_action')
            ->description('User performed a custom manual action in the demo.')
            ->with(['demo' => true, 'source' => 'manual_log_route'])
            ->log();

        return redirect()->route('logs.index')->with('success', 'Manual log entry created!');
    }

    public function createPost()
    {
        $post = Post::create([
            'title' => 'Demo Post ' . now()->format('H:i:s'),
            'content' => 'This post was created to demonstrate automatic logging.',
        ]);

        return redirect()->route('logs.index')->with(
            'success',
            "Post #{$post->id} created — automatic \"created\" log generated!"
        );
    }

    public function updatePost()
    {
        $post = Post::latest()->first();

        if (!$post) {
            $post = Post::create([
                'title' => 'Demo Post ' . now()->format('H:i:s'),
                'content' => 'Created first so we have something to update.',
            ]);

            return redirect()->route('logs.index')->with(
                'info',
                'No existing post found. A new one was created instead. Click "Update Post" again.'
            );
        }

        $post->update(['title' => $post->title . ' (updated)']);

        return redirect()->route('logs.index')->with(
            'success',
            "Post #{$post->id} updated — automatic \"updated\" log generated!"
        );
    }

    public function deletePost()
    {
        $post = Post::latest()->first();

        if (!$post) {
            return redirect()->route('logs.index')->with(
                'info',
                'No posts to delete. Create one first.'
            );
        }

        $post->delete();

        return redirect()->route('logs.index')->with(
            'success',
            "Post #{$post->id} deleted — automatic \"deleted\" log generated!"
        );
    }

    public function clearLogs()
    {
        ActivityLog::truncate();

        return redirect()->route('logs.index')->with('success', 'All logs cleared!');
    }
}
