<?php

namespace App\Models;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use GraphQL\Type\Definition\ResolveInfo;
use App\Traits\HasAuthIdFields;
use App\Models\User;
use App\Models\Forum;
use App\Traits\TimestampsShouldInHumanReadable;

class Comment extends Model
{
    use HasAuthIdFields, TimestampsShouldInHumanReadable;

    protected $fillable = ['comment'];

    protected $authIdFields = ['author_id'];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'full_name' => '[Deleted Author]'
        ]);
    }
}
