<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Arr;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, array $injected)
    {
        $commentableType = Arr::get($injected, 'commentable.connect.type');
        $commentableId = Arr::get($injected, 'commentable.connect.id');

        $classId = $commentableType::findOrFail($commentableId)->class_id;

        return $this->determine($user, $classId);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id == $comment->author_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        $classId = $comment->commentable->class_id;

        return $user->isATeacherOf($classId)
            or $user->id == $comment->author_id;
    }

    public function determine(User $user, $classId)
    {
        return $user->isATeacherOf($classId) or $user->isAStudentIn($classId);
    }
}
