<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title',
        'description',
        'content',
        'category_id',
        'thumbnail',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable():array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function uploadImage(Request $request,string $img = null)
    {
        if ($request->hasFile('thumbnail')) {
            if($img) Storage::delete($img);
            $folder = date('Y-m-d');
            return $request->file('thumbnail')->store("img/{$folder}");
        }
        return null;
    }
    public function getImage(): string
    {
        if (!$this->thumbnail) return asset("uploads/img/no-image.png");
        return asset("uploads/{$this->thumbnail}");
    }
    public function getPostDate()
    {
        return Carbon::createFromFormat('Y-m-d H:m:s', $this->created_at)->format('d F Y');
    }

    public function scopeLike($query, $s)
    {
        return $query->where('title', 'LIKE', "%{$s}%");
    }

}
