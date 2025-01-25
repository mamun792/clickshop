<?php

namespace App\Repositories\Admin\Comment;

use App\Models\Comment;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class CommentRepository implements CommentRepositoryInterface
{
    public function all()
    {
        return Comment::all();
    }

    public function create(array $data)
    {
        try {
            $comment = Comment::create($data);
            Log::info('Comment successfully created:', ['comment' => $comment]);
            return $comment;
        } catch (\Exception $e) {
            Log::error('Failed to create comment:', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function update(array $data, int $id)
    {
        return Comment::find($id)->update($data);
    }

    public function delete(int $id)
    {
        return Comment::destroy($id);
    }

    public function find(int $id)
    {
        return Comment::find($id);
    }

   


}
