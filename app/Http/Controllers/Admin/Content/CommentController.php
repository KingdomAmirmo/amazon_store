<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\CommentRequest;
use App\Models\Content\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unseenComments = Comment::where('commentable_type', 'App\Models\Content\Post')->where('seen', 0)->get();
        foreach ($unseenComments as $unseenComment) {
            $unseenComment->seen = 1;
            $result = $unseenComment->save();
        }
        $comments = Comment::orderBy('created_at')->where('commentable_type', 'App\Models\Content\Post')->simplePaginate(10);
        return view('admin.content.comment.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return view('admin.content.comment.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function status(Comment $comment)
    {
        $comment->status = $comment->status == 0 ? 1 : 0;
        $result = $comment->save();
        $comment->status == 1 ? ($status = "فعال") : ($status = "غیرفعال");
        return redirect()->route('admin.content.comment.index')->with('swal-success', 'کامنت مورد نظر' . ' ' . $status . ' ' . 'شد ');

    }
    public function approved(Comment $comment)
    {
        $comment->approved = $comment->approved == 0 ? 1 : 0;
        $result = $comment->save();
        if ($result)
        {
            return redirect()->route('admin.content.comment.index')->with('swal-success', "وضعیت نظر با موفقیت تغییر کرد");
        }
        else
        {
            return redirect()->route('admin.content.comment.index')->with('swal-error', 'وضعیت نظر با خطا مواجه شد');
        }
    }

    public function answer(CommentRequest $request, Comment $comment)
    {
        if ($comment->parent_id == null)
        {
            $inputs = $request->all();
            $inputs['author_id'] = 1;
            $inputs['parent_id'] = $comment->id;
            $inputs['commentable_id'] = $comment->commentable_id;
            $inputs['commentable_type'] = $comment->commentable_type;
            $inputs['approved'] = 1;
            $inputs['status'] = 1;
            $comment = Comment::create($inputs);
            return redirect()->route('admin.content.comment.index')->with('swal-success', 'پاسخ شما باموفقیت ثبت شد');
        }else{
            return redirect()->route('admin.content.comment.index')->with('swal-error', 'خطا');

        }




    }




}
