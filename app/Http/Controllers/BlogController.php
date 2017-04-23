<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;

class BlogController extends Controller
{
   public function index()
   {
   		$blog=Blog::all();
   		return view('blog.index',['blogs'=> $blog]);
   }

   public function editItem(Request $req)
   {
   		$blog=Blog::find($req->id);

   		$blog->title=$req->title;
   		$blog->description=$req->description;
   		$blog->save();
   		return response()->json($blog);
   }

   public function addItem(Request $req)
   {
      $rules=array(
         'title'=>'required',
         'description'=>'required'
         );

      //for validation
      $validator=Validator::make(Input::all(), $rules);
      if($validator->fails())
         return Response::json(array('errors'=>$validator->getMessageBag()->toArray()));
      else
      {
         $blog= new Blog();
         $blog->title=$req->title;
         $blog->description=$req->description;
         $blog->save();
         return response()->json($blog);
      }
   }

   public function deleteItem(Request $req)
   {
      Blog::find($req->id)->delete();
      return response()->json();
   }
}
