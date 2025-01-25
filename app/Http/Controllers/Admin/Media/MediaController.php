<?php

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Media\MediaStoreRequest;
use App\Services\Admin\Media\MediaService;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index()
    {
        $media = $this->mediaService->getMedia();
        return view('admin.media.index', compact('media'));
    }

    public function store(MediaStoreRequest $request)
    {
       try {
            $this->mediaService->storeMedia($request->validated());
            return redirect()->route('admin.media.index')->with('success', 'Media updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
       
    }


}
