<?php

namespace App\Services\Admin\Comment;

use App\Repositories\Admin\Comment\CommentRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function all()
    {
        return $this->commentRepository->all();
    }

    public function create(array $data)
    {
        Log::info('CommentService@create', $data);
        return $this->commentRepository->create($data);
    }

    public function update(array $data, int $id)
    {
        return $this->commentRepository->update($data, $id);
    }

    public function delete(int $id)
    {
        return $this->commentRepository->delete($id);
    }

    public function find(int $id)
    {
        return $this->commentRepository->find($id);
    }

    public function toggleStatus(Request $request, int $id)
    {
        // Find the comment by its ID
        try {
            $comment = $this->commentRepository->find($id);
            if ($comment) {
                // Update the status of the comment
                $comment->status = $request->status;
                $comment->save();
                return $comment;
            }
        } catch (\Exception $e) {
            Log::error('CommentService@toggleStatus', ['message' => $e->getMessage()]);
        }
    }
}
