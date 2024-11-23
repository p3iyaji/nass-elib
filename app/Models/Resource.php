<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Resource extends Model
{
    use SoftDeletes;

    protected $table = 'resources';


    public static function boot(): void
    {
        parent::boot();

        self::creating(function ($model) {
            $model->user_id = auth()->id();
            $model->slug = Str::slug($model->title);
        });

        self::updating(function ($model) {
            if (!$model->isDirty('title')) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'user_id',
        'authors',
        'authors_affiliation',
        'publisher',
        'date_of_publication',
        'year_of_publication',
        'issn_isbn_doi',
        'edition',
        'volume',
        'issue',
        'abstract',
        'references',
        'tags',
        'pages',
        'cover_image',
        'file'
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'resource_member')->withTimestamps();
    }
}
