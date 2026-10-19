<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $guarded = [];
    protected $casts = ['tanggal' => 'date'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}