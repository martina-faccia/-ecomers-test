<?php

namespace App\Models;

use App\Models\User;
use Laravel\Scout\Searchable;
use App\Models\AnnouncementImage;
use App\Models\ImageAnnouncement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use Searchable;

    use HasFactory;
    protected $fillable=['title','body' , 'category_id' , 'price' , 'user_id', 'uniquescret'];

    public function toSearchableArray()
    {


        $announcements = $this->pluck('title')->join(', ');


        $array=[

            'id'=>$this->id,
            'title'=>$this->title,
            'body'=>$this->body,
            'altro'=>'annunci',
            'annunci'=>$announcements,
            // 'uniquesecret'=>$this->uniquesecret

        ];

        return $array;
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    static public function TopRevisionedCount()
    {
        return Announcement::where('is_accepted' , null)->count();
    }


    public function images(){
        return $this->hasMany(ImageAnnouncement::class);
    }


}
