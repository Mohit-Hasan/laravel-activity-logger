<?php

namespace App\Models;

use MohitHasan\ActivityLogger\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use LogsActivity;

    protected $fillable = ['title', 'content'];
}
