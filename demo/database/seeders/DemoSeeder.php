<?php

namespace Database\Seeders;

use MohitHasan\ActivityLogger\Facades\ActivityLogger;
use MohitHasan\ActivityLogger\Models\ActivityLog;
use App\Models\Article;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $post = Post::create([
            'title' => 'Welcome Post',
            'content' => 'This is the first post created by the demo seeder.',
        ]);

        Post::create([
            'title' => 'Second Post',
            'content' => 'Another post to demonstrate polymorphic logging.',
        ]);

        ActivityLog::where('action', 'created')->each(function ($log) {
            $log->update(['user_id' => 1]);
        });

        ActivityLogger::action('custom_action')
            ->description('Demo seeder ran and generated sample log data.')
            ->with(['seeded' => true, 'source' => 'DemoSeeder'])
            ->log();
    }
}
