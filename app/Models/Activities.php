<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Activities extends Model
{
    use HasFactory;
    protected $table = 'activities';
    protected $fillable = ['id',    'date',    'heading',    'icon',    'pointsEarned',  'type', 'user_id', 'conversation_id', 'created_at',    'updated_at'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
        // return DB::connection('mysql2')->table('users',$this->user_id);
    }
    public function activitiesable()
    {
        return $this->morphTo();
    }
    public function subject()
    {
        return $this->hasOne(Subject::class, 'activities_id');
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {

            $model->user_id = auth()->user()->id;
        });
    }
}
