<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\RevisorRecived;
use Illuminate\Http\Request;
use App\Models\RevisorCreate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class RevisorCreateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('revisor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        RevisorCreate::create($request->all());
        $revisor = $request->all();

        Mail::to($revisor['email'])->send(new RevisorRecived($revisor));
        return redirect(route('revisor.control'));
    }

    public function control()
    {
        return view('revisor.control');
    }

 public function final(){


     return view('revisor.final');


 }
    public function index(){
        $user=Auth::user();
        if ($user && $user->email =='clarissa.lavinolondra@gmail.com'){
            //passowrd 12345678

            $revisor = RevisorCreate::where('visible',true)->get();
            return view('revisor.index',compact('revisor'));

        }else{
            return view('revisor.final');
        }

    }


    public function approved($id)
    {
        $revisor = RevisorCreate::find($id);
        $revisor->visible = false;
        $revisor->save();
        return redirect(route('revisor.index'));
    }

    public function revisorTrue($id)
    {

        $revisorCreate = User::find($id);
        $revisorCreate->is_revisor = true;
        $revisorCreate->save();
        return redirect(route('revisorCreate.index'));
        
    }

    public function indexRevisor()
    {
        $userRevisors = User::where('is_revisor' , true)->get();
        return view('revisorCreate.index',compact('userRevisors'));
    }

    // public function revisorTrue($revisorApproved , $revisorCreate , $email , $id)
    // {
    //     $revisorApproved = RevisorCreate::find($email)->get('email');
    //     $revisorCreate = User::find($email)->get('email');
    //     $revisorModelUser = User::find($id);

    //     if ($revisorApproved == $revisorCreate) 
    //     {
    //         $revisorModelUser->is_revisor = false;
    //         $revisorModelUser->save();
    //         return redirect(route('revisorCreate.index'));
    //     }
    // }
}
