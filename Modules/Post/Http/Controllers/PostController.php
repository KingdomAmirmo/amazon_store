<?php

namespace Modules\Post\Http\Controllers;

use App\Http\Services\Image\ImageService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ContentCategory\Entities\PostCategory;
use Modules\Post\Entities\Post;
use Modules\Post\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('post::index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $postCategories = PostCategory::all();
        return view('post::create', compact('postCategories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(PostRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();

        //date fixed
        $realTimestampStart = substr($request->published_at, 0,10);
        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimestampStart);
        if ($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post');
            $result = $imageService->createIndexAndSave($request->file('image'));

            if ($request === false)
            {
                return redirect()->route('admin.content.post.index')->with('swal-error', "آپلود تصویر با خطا مواجه شد");
            }
            $inputs['image'] = $result;
        }
        $inputs['author_id'] = auth()->user()->id;
        $post = Post::create($inputs);
        return redirect()->route('admin.content.post.index')->with('swal-success', "پست جدید شما با موفقیت ثبت شد");

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('post::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Post $post)
    {
        $postCategories = PostCategory::all();
        return view('post::edit', compact('postCategories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(PostRequest $request, Post  $post, ImageService $imageService)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->published_at, 0,10);
        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimestampStart);

        if ($request->hasFile('image'))
        {
            if (!empty($post->image))
            {
                $imageService->deleteDirectoryAndFiles($post->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($request === false)
            {
                return redirect()->route('admin.content.post.index')->with('swal-error', "آپلود تصویر با خطا مواجه شد");
            }
            $inputs['image'] = $result;
        }
        else
        {
            if (isset($inputs['currentImage']) && !empty($post->image))
            {
                $image = $post->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        $post->update($inputs);
        return redirect()->route('admin.content.post.index')->with('swal-success', 'پست شما با موفقیت ویرایش شد');

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Post $post)
    {
        $result = $post->delete();
        return redirect()->route('admin.content.post.index')->with('swal-success', 'پست با موفقیت حذف شد');
    }

    public function status(Post $post)
    {
        $post->status = $post->status == 0 ? 1 : 0;
        $result = $post->save();
        $post->status == 1 ? ($status = "فعال") : ($status = "غیرفعال");
        return redirect()->route('admin.content.post.index')->with('swal-success', 'وضعیت به'. ' ' . $status .' تغییر یافت');
    }
    public function commentable(Post $post)
    {
        $post->commentable = $post->commentable == 0 ? 1 : 0;
        $result = $post->save();
        $post->commentable == 1 ? ($commentable = "فعال") : ($commentable = "غیرفعال");
        return redirect()->route('admin.content.post.index')->with('swal-success', 'امکان درج کامنت با موفقیت'. ' ' . $commentable .' شد');
    }

}
