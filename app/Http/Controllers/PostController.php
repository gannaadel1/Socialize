<?php

namespace App\Http\Controllers;

use App\Http\Controllers\traits\responseTrait;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use responseTrait;
    public function index(){

        // $posts=Post::get();
        $posts=PostResource::collection(Post::get());
        return $this->apiResponse($posts,200,'ok');
    
    }

    public function show($id){
         $post=Post::find($id);

        
        if($post){
            return $this->apiResponse(new PostResource($post) ,200,'done');
        }
        else{
            return $this->apiResponse(null,401,'the post not found');
        }

    }

    public function store(Request $request){

        $validator=Validator::make($request->all(),[
            'title'=>'required',
            'body'=>'required',

        ]);
        if ($validator->fails()){
            return $this->apiResponse(null,400,$validator->errors());
        }


        $post=Post::create($request->all());
        if($post){
            return $this->apiResponse(new PostResource($post),201,'the post saved succcessfully');
        }
        else{
            return $this->apiResponse(null,402,'the post cant be saved');
        }

    }


    public function update(Request $request,$id){
        $validator=Validator::make($request->all(),[
            'title'=>'required',
            'body'=>'required',

        ]);
        if ($validator->fails()){
            return $this->apiResponse(null,400,$validator->errors());
        }

        $post=Post::find($id);

        if($post){
            $post->update($request->all());
            return $this->apiResponse(new PostResource($post),201,'the post updated succcessfully');

        }
        else {
            return $this->apiResponse(null,402,'the post cant be updated');
        }
        

    }

    public function delete($id){
        $post=Post::find($id);
        if($post){
            $post->delete($id);
            return $this->apiResponse(null,200,'the post deleted successfully');
        }
        else{
            return $this->apiResponse(null,402,'the post cant be deleted');
        }
    }

}
