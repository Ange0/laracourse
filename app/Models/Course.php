<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    use HasFactory;
    use Authorizable;
    
    public $fillable = ['title','description'];
    protected $appends = ['update']; // qui sera un champ declarer à la volé dans notre table courses

    public function getUpdateAttribute()
    { 
       if(Auth::check()){
            // ici l'attribut update sera à true si utiliseur connecter est celui qui à creer la formation  donc peut modifier sinon false voir+ dans resources/Pages/Courses/Index.vue
            return  $this->can('update-course',$this); // appel du gate declarer dans AuthServiceProvider (arg1=nom du Gate,arg2=model) NB:ici le model est course donc $this
       }
       return false;
    } 
     public static function booted()
    {
        static::creating(function($course){
            $course->user_id = auth()->user()->id;
        }); 
    } 

    public function episodes(){
        return $this->hasMany(Episode::class);
    }

    public function user(){
        return $this->belongsTo(User::class);   
    }
}
