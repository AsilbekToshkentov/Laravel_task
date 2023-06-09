<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        if($request->hasFile(key:'file'))
        {
            $name =$request->file(key: 'file')->getClientOriginalName();
            $path = $request->file(key: 'file')->storeAs(
                'files',
                $name,
                'public',
            );
        }
        $validated = $request->validate([
            'subject'=>'required|max:255',
            'message'=>'required',
            'file'=>'file|mimes:jpg,png,pdf'
        ]);
        $application = Application::create([
            'user_id'=>auth()->user()->id,
            'subject'=> $request->subject,
            'message'=> $request->message,
            'file_url'=> $path ?? null,
        ]);
        return redirect()->back();
    }
}
