<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use App\Models\Mahasiswa;
use App\Models\Pengaduan;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete($userMahasiswa, Comment $comment)
    {
        if ($userMahasiswa instanceof Mahasiswa) {
            return $userMahasiswa::class == $comment->commentable_type && $userMahasiswa->id == $comment->commentable_id;
        }
        if ($userMahasiswa instanceof User) {
            return $userMahasiswa::class == $comment->commentable_type && $userMahasiswa->id == $comment->commentable_id;
        }
    }
}
