<?php

namespace App\Http\Controllers;

use App\Models\PhoneBook;
use App\Models\PhoneBookGroup;
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
       // filtering logics included favourites and friends
        $phonebooks = PhoneBook::where('ownerId', Auth::user()->id);


        if($request->filled('favourite')) {
            $phonebooks = $phonebooks->where('favourite', '1');
        } else if($request->filled('friend')) {
            $phonebooks = $phonebooks->join('phone_book_groups', 'phone_books.id', 'phone_book_groups.phone_book_id')->select(['phone_books.*', 'phone_book_groups.friend'])->where('friend','1');
        }
        else {
            $phonebooks = $phonebooks->orWhere('status', '0');
        }

        $phonebooks = $phonebooks->orderBy('id', 'desc')->paginate(5);
        // return $phonebooks;

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

        // Public and Friend selection logic
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

        // creation
        $phoneBook = PhoneBook::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'status' => $request->status ?? 1,
            'ownerId' => $request->ownerId,
            // 'favourite' => $request->favourite ?? 0
            'favourite' => $favourite

        ]);
        
        // Mark as Friend section
        if($request->has('friend') == true){
            // dd('friend');
            PhoneBookGroup::create([
                'user_id' => Auth::user()->id,
                'phone_book_id' => $phoneBook -> id,
                'friend' => $request->friend
            ]);
        }
        

        return Redirect()->back()->with('msg', 'Contact created successfuly');
    }

    public function edit($id){
        
        $phonebooks = PhoneBook::latest()
                    ->where('status', '=', 0)
                    ->orWhere('ownerId', '=', Auth::user()->id)
                    ->paginate(5);

        $editPhoneBooks = PhoneBook::where('id', $id)->first();
        $editPhoneBookGroup = PhoneBookGroup::where('phone_book_id', $id)->first(); // seeking group table for friend info
        // dd($editPhoneBookGroup);
        return view('phonebook.edit', compact('editPhoneBooks','phonebooks', 'editPhoneBookGroup'));
    }

    public function update(Request $request){
        // dd($request->all());

        // Favourite-Public logic
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
            'favourite' => 'nullable|in:0,1',
        ]);

        $phonebook = PhoneBook::where('id', $request->id)->first();
        // dd('hmmm');
        $phonebook->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'status' => $request->status ?? 1,
            // 'ownerId' => Auth::user()->id,
            // 'favourite' => $request->favourite ?? 0
            'favourite' => $favourite
        ]);
        if ($request->has('friend') == true) {
            # code...
            $editPhoneBookGroup = PhoneBookGroup::where('phone_book_id', $request->id)->first();
            $editPhoneBookGroup->update([
                'friend' => $request->friend
            ]);
        } else {
            # code...
            $editPhoneBookGroup = PhoneBookGroup::where('phone_book_id', $request->id)->first();
            $editPhoneBookGroup->update([
                'friend' => '0'
            ]);
        }
        

        return redirect()->route('phonebook.index')->with('msg', 'Contact updated successfuly');
    }

    public function delete(Request $request){

        $phonebook = PhoneBook::where('id', $request->id)->first();
        
        $phonebook->delete();

        return redirect()->route('phonebook.index')->with('msg', 'Contact deleted successfuly');
    }

    // favourite contacts
    public function favourite() {

        $phonebooks = PhoneBook::latest()
                    ->where('favourite', '=', 1)
                    ->Where('ownerId', '=', Auth::user()->id)
                    ->paginate(5);

        return view('phonebook.favourites',compact('phonebooks'));
    }
}
