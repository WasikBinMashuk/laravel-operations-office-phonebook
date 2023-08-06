<?php

namespace App\Http\Controllers;

use App\Models\PhoneBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PhoneBookController extends Controller
{
    public function index()
    {

        $phonebooks = PhoneBook::latest()
                    ->where('status', '=', 0)
                    ->orWhere('ownerId', '=', Auth::user()->id)
                    ->paginate();

        return view('phonebook.index',compact('phonebooks'));
    }

    public function store(Request $request){
       
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|max:11',
            'address' => 'required',
            'status' => 'required|in:0,1'
        ]);

        PhoneBook::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'status' => $request->status,
            'ownerId' => $request->ownerId,
            'favourite' => $request->favourite
        ]);

        return Redirect()->back()->with('msg', 'Contact created successfuly');
    }

    public function edit($id){

        $phonebooks = PhoneBook::latest()
                    ->where('status', '=', 0)
                    ->orWhere('ownerId', '=', Auth::user()->id)
                    ->paginate();

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
            'status' => $request->status,
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
                    ->paginate();

        return view('phonebook.favourites',compact('phonebooks'));
    }
}
