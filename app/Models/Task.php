<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'done',
        'due',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    protected function casts(): array
    {
        return [
          "done" => "datetime",
          "due" => "datetime",
        ];
    }
    
    public function scopeSearchView($query, $keyword)
    {
      $query->where('title', 'like', '%'.$keyword.'%')
        ->orWhere('description', 'like', '%'.$keyword.'%');
    }
    
    public function scopeFilterStatus($query, $status = "all")
    {
      $query->when(
        $status == "all",
        fn ($query) => $query
      )->when(
        $status == "done",
        fn ($query) => $query->whereColumn('done', '<=', 'due')
      )->when(
        $status == "late",
        fn ($query) => $query->whereColumn('done', '>=', 'due')
      )->when(
        $status == "overdue",
        fn ($query) => $query->where('due', '<=', now())->where('done', null)
      )->when(
        $status == "ongoing",
        fn ($query) => $query->where('due', '>=', now())->where('done', null)
      );
    }
    
    public function scopeSortView($query, $type = "latest")
    {
      $query->when(
        $type == "latest",
        fn ($query) => $query->latest()
      )->when(
        $type == "oldest",
        fn ($query) => $query->oldest()
      )->when(
        $type == "nearest",
        fn ($query) => $query->oldest("due")
      )->when(
        $type == "farthest",
        fn ($query) => $query->latest("due")
      );
    }
}
