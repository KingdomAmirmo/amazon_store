<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PostRequest;
use App\Models\Content\Post;
use App\Http\Services\Image\ImageService;
use App\Models\Content\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
//    public function __construct()
//    {
//        $this->authorizeResource(Post::class, 'post');
//    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $posts = Post::orderBy('created_at', 'desc')->simplePaginate(15);
//        return view('admin.content.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $postCategories = PostCategory::all();
//        return view('admin.content.post.create', compact('postCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, ImageService  $imageService)
    {
//        $inputs = $request->all();
//
//        //date fixed
//        $realTimestampStart = substr($request->published_at, 0,10);
//        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimestampStart);
//        if ($request->hasFile('image'))
//        {
//            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post');
//            $result = $imageService->createIndexAndSave($request->file('image'));
//
//            if ($request === false)
//            {
//                return redirect()->route('admin.content.post.index')->with('swal-error', "آپلود تصویر با خطا مواجه شد");
//            }
//            $inputs['image'] = $result;
//        }
//        $inputs['author_id'] = auth()->user()->id;
//        $post = Post::create($inputs);
//        return redirect()->route('admin.content.post.index')->with('swal-success', "پست جدید شما با موفقیت ثبت شد");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
//        $postCategories = PostCategory::all();
//        return view('admin.content.post.edit', compact('post', 'postCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post, ImageService $imageService)
    {
//        if (!Gate::allows('update-post', $post))
//        {
//            abort(403);
//        }
//        if ($request->user()->can('update', $post))
//        {
//
//        }
//           $this->authorize('update', $post);

//
//        $inputs = $request->all();
//        //date fixed
//        $realTimestampStart = substr($request->published_at, 0,10);
//        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimestampStart);
//
//        if ($request->hasFile('image'))
//        {
//            if (!empty($post->image))
//            {
//                $imageService->deleteDirectoryAndFiles($post->image['directory']);
//            }
//            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post');
//            $result = $imageService->createIndexAndSave($request->file('image'));
//            if ($request === false)
//            {
//                return redirect()->route('admin.content.post.index')->with('swal-error', "آپلود تصویر با خطا مواجه شد");
//            }
//            $inputs['image'] = $result;
//        }
//        else
//        {
//            if (isset($inputs['currentImage']) && !empty($post->image))
//            {
//                $image = $post->image;
//                $image['currentImage'] = $inputs['currentImage'];
//                $inputs['image'] = $image;
//            }
//        }
//        $post->update($inputs);
//        return redirect()->route('admin.content.post.index')->with('swal-success', 'پست شما با موفقیت ویرایش شد');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
//        $result = $post->delete();
//        return redirect()->route('admin.content.post.index')->with('swal-success', 'پست با موفقیت حذف شد');
    }

    public function status(Post $post)
    {
//        $post->status = $post->status == 0 ? 1 : 0;
//        $result = $post->save();
//        $post->status == 1 ? ($status = "فعال") : ($status = "غیرفعال");
//        return redirect()->route('admin.content.post.index')->with('swal-success', 'وضعیت به'. ' ' . $status .' تغییر یافت');
    }
    public function commentable(Post $post)
        {
//        $post->commentable = $post->commentable == 0 ? 1 : 0;
//        $result = $post->save();
//        $post->commentable == 1 ? ($commentable = "فعال") : ($commentable = "غیرفعال");
//        return redirect()->route('admin.content.post.index')->with('swal-success', 'امکان درج کامنت با موفقیت'. ' ' . $commentable .' شد');
    }


}
