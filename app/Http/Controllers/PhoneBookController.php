<?php

namespace App\Http\Controllers;

use App\Models\PhoneBook;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PhoneBookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin.name.redirect']);
        // $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
       // filtering logics included
        $phonebooks = PhoneBook::where('ownerId', Auth::user()->id);

        if($request->filled('favourite')) {
            $phonebooks = $phonebooks->where('favourite', '1');
        } else {
            $phonebooks = $phonebooks->orWhere('status', '0');
        }

        $phonebooks = $phonebooks->orderBy('id', 'desc')->paginate(5);

        return view('phonebook.index',compact('phonebooks'));


        
        // $favourite = $request->query('favourite');

        // $phonebooks = PhoneBook::where(function ($query) use ($favourite){
        //     if($favourite){
        //         $query->where('favourite', $favourite);
        //     }
        // })->paginate();
        // return view('phonebook.index',compact('phonebooks', 'favourite'));
        

        // dd('check');
        
    }

    public function store(Request $request){

        // dd($request->all());
        $favourite = 0;
        if ($request->status == "0" && $request->favourite == "1") {
            $favourite = 0;
            // dd('dada');
            return Redirect()->back()->with('danger', 'Public and Favourite cannot be selecetd at the same time. TRY AGAIN!!!');
        } 
        if ($request->has('status') == true && $request->favourite == "0") {
            $favourite = 0;
            // dd('if 2');
        }
        if ($request->has('status') == false && $request->favourite == "1") {
            $favourite = 1;
            // dd('if 3');
        }
        
       
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|max:11',
            'address' => 'required',
            'status' => 'nullable|in:0,1',
            // 'favourite' => 'required|in:0,1',
        ]);

        PhoneBook::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'status' => $request->status ?? 1,
            'ownerId' => $request->ownerId,
            // 'favourite' => $request->favourite ?? 0
            'favourite' => $favourite

        ]);

        return Redirect()->back()->with('msg', 'Contact created successfuly');
    }

    public function edit($id){

        $phonebooks = PhoneBook::latest()
                    ->where('status', '=', 0)
                    ->orWhere('ownerId', '=', Auth::user()->id)
                    ->paginate(5);

        $editPhoneBooks = PhoneBook::where('id', $id)->first();

        return view('phonebook.edit', compact('editPhoneBooks','phonebooks'));
    }

    public function update(Request $request){

        $request->validate([
            'name' => 'required',
            'mobile' => 'required|max:11',
            'address' => 'required',
            'status' => 'required|in:0,1',
            'favourite' => 'required|in:0,1',
        ]);

        $phonebook = PhoneBook::where('id', $request->id)->first();
        
        $phonebook->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'status' => $request->status ?? 0,
            'favourite' => $request->favourite,
            // 'ownerId' => $request->ownerId
        ]);

        return redirect()->route('phonebook.index')->with('msg', 'Contact updated successfuly');
    }

    public function delete(Request $request){

        $phonebook = PhoneBook::where('id', $request->id)->first();
        
        $phonebook->delete();

        return redirect()->route('phonebook.index')->with('msg', 'Contact deleted successfuly');
    }

    // favourite contacts

    public function favourite()
    {

        $phonebooks = PhoneBook::latest()
                    ->where('favourite', '=', 1)
                    ->Where('ownerId', '=', Auth::user()->id)
                    ->paginate(5);

        return view('phonebook.favourites',compact('phonebooks'));
    }
}
