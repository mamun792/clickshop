<?php

namespace App\Http\Controllers\Admin\Comment;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Comment\StoreCommentRequest;
use App\Services\Admin\Comment\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index()
    {
       $comments = $this->commentService->all();
        return view('admin.comment.index', compact('comments'));
    }

    public function create()
    {
        return view('admin.comment.create');
    }

    public function store(StoreCommentRequest $request)
    {
    
       try {
            $this->commentService->create($request->validated());
            return redirect()->route('admin.comments.index')->with('success', 'Comment created successfully');
        } catch (\Exception $e) {
            Log::error('CommentController@store', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Something went wrong');
        }
       
    }

    public function edit($id)
    {
        $comment = $this->commentService->find($id);
        return view('admin.comment.edit', compact('comment'));
    }


    public function update(StoreCommentRequest $request, $id)
    {
        try {
            $this->commentService->update($request->validated(), $id);
            return redirect()->route('admin.comments.index')->with('success', 'Comment updated successfully');
        } catch (\Exception $e) {
            Log::error('CommentController@update', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function destroy($id)
    {
        try {
            $this->commentService->delete($id);
            return ApiResponse::success('Comment deleted successfully');
        } catch (\Exception $e) {
            Log::error('CommentController@destroy', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function toggleStatus(Request $request, $id)
    {
       
        try {
           $data= $this->commentService->toggleStatus($request, $id);
            return ApiResponse::success('Comment status updated successfully', $data);
        } catch (\Exception $e) {
            Log::error('CommentController@toggleStatus', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

}
