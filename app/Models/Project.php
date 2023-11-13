<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Project extends Model
{
  use HasFactory;
  protected $fillable = ['title', 'description', 'type_id'];

    public function type() {
        return $this->belongsTo(Type::class);
      }

    public function technologies() {
      return $this->belongsToMany(Technology::class);
    }

    public function setUniqueSlug() 
    {
      $slug = Str::slug($this->title);
      $end_slug = "";

      $existing_project = Project::where("slug", $slug)
      ->where('id','<>',$this->id)
      ->first();

      $i=1;
      while (!empty($existing_project)) {
        $i++;
        $end_slug = "-" . $i;

        $existing_project = Project::where("slug", $slug . $end_slug)
        ->where('id','<>',$this->id)
        ->first();
      }

      $this->slug = $slug . $end_slug;
    }

    public function getAbstract($chars = 50) 
    {
      return strlen($this->description) . $chars ? substr($this->description, 0 , $chars) . "..." : $this->description;
    }

    public function getAbsUriImage() {
      return $this->cover_image ? Storage::url($this->cover_image) : null;
    }
}
