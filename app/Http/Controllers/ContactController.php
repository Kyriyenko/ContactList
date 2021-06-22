<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Contact;


class ContactController extends Controller
{
    public function showData()
    {
        $result = Contact::all();
        response()->json($result, 200)->send();
    }

    public function deleteContact($id)
    {
        Contact::find($id)->delete();
//todo result!
        $results = [
            'success' => 'true',
            'message' => 'data was deleted',
        ];

        response()->json($results, 200)->send();
    }

    public  function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required|string|max:50',
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            return [
              'status'=>false,
              'errors'=>  $validator->messages()
            ];
         }

            $post = new  Contact([
                'name'=>$request->name,
                'email'=>$request->email,
                'address'=>$request->address
            ]);

            $post->save();

           return [
                'status' => true,
                'message' => 'contact was created',
                'record'=> $post->toArray()
            ];


    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required|string|max:50',
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'status'=>false,
                'errors'=>  $validator->messages()
            ];
        }
            $post = Contact::find($request->id);
            $post->name=$request->name;
            $post->email=$request->email;
            $post->address=$request->address;

            $post->save();

            return [
                'status' => true,
                'message' => 'contact was updated',
                'record'=> $post->toArray()
            ];


    }

}
