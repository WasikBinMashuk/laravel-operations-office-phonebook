@extends('layouts.companies')

@section('companiesContent')

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class=" card-header justify-content-center text-center">
                    
                    <div>
                        <a  style="text-decoration: none; color:black" href="{{ route('phonebook.index') }}"><h4>Phone Book</h4></a>
                        <span style="float-right">Total <span class="badge text-bg-danger">{{ count($phonebooks) }}</span></span>
                    </div>
                    
                    {{-- <div class="mt-2">
                        <button type="button" class="btn btn-outline-warning mr-2"><a class="text-decoration-none text-warning" href="{{ route('phonebook.fav') }}">favourites</a></button>
                    </div> --}}
                </div>

                <div class="card-body">

                    @if (session('msg'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('msg') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('danger'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('danger') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <table class="table ">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Address</th>
                            {{-- <th scope="col">Status</th> --}}
                            {{-- <th scope="col">favourite</th> --}}
                            <th scope="col"></th>
                            <th scope="col"></th>
                            
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($phonebooks as $item)
                              <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}
                                     
                                    @if ($item->favourite == '1')
                                        <i class="fa-solid fa-star" style="color: #eba000;"></i> 
                                    @endif

                                    {{-- Status icon --}}
                                    @if ($item->status == '0')
                                        {{-- public --}}
                                        <i class="fa-solid fa-earth-asia" style="color: #808080;"></i> 
                                        
                                    @else
                                        {{-- private --}}
                                        
                                    @endif
                                </td>
                                <td>{{ $item->mobile }}</td>
                                <td>{{ $item->address }}</td>
                                {{-- <td>
                                    @if ($item->status == '0')
                                        <span class="badge bg-success">Public</span> 
                                        
                                    @else
                                    <span class="badge bg-danger">Private</span>
                                        
                                    @endif
                                </td> --}}
                                {{-- <td>
                                    @if ($item->favourite == '1')
                                        <span class="badge bg-warning">Favourite</span> 
                                    @endif
                                </td> --}}

                                {{-- EDIT and Delete setup --}}
                                @if ($item->status == 0)
                                    @if ($item->ownerId == Auth::user()->id)
                                        <td><a class="btn btn-outline-success btn-sm" href="{{ route('phonebook.edit', $item->id) }}"><i class="fa-regular fa-pen-to-square" style="color: #00ff00;"></i></a></td>
                                        <td><a class="btn btn-outline-danger btn-sm" href="{{ route('phonebook.delete', $item->id) }}"><i class="fa-regular fa-trash-can" style="color: #ff0000;"></i></a></td>
                                    @else
                                        <td><a class="btn btn-outline-success btn-sm" role="link" aria-disabled="true"><i class="fa-regular fa-pen-to-square" style="color: #00ff00;"></i></a></td>
                                        <td><a class="btn btn-outline-danger btn-sm" role="link" aria-disabled="true"><i class="fa-regular fa-trash-can" style="color: #ff0000;"></i></a></td>
                                    @endif
                                    
                                
                              @else
                                <td><a class="btn btn-outline-success btn-sm" href="{{ route('phonebook.edit', $item->id) }}"><i class="fa-regular fa-pen-to-square" style="color: #00ff00;"></i></a></td>
                                <td><a class="btn btn-outline-danger btn-sm" href="{{ route('phonebook.delete', $item->id) }}"><i class="fa-regular fa-trash-can" style="color: #ff0000;"></i></a></td>
                              @endif

                                {{-- <td><a class="btn btn-outline-success btn-sm" href="{{ route('phonebook.edit', $item->id) }}"><i class="fa-regular fa-pen-to-square" style="color: #00ff00;"></i></a></td>
                                <td><a class="btn btn-outline-danger btn-sm" href="{{ route('phonebook.delete', $item->id) }}"><i class="fa-regular fa-trash-can" style="color: #ff0000;"></i></a></td> --}}
                              </tr>
                          @endforeach
                        </tbody>
                      </table>
    
                      {{ $phonebooks->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center bg-success pt-4">
                    <h4>Edit Contacts</h4>
                    
                </div>

                <div class="card-body">
                    
                    <form action="{{ route('phonebook.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" value="{{ $editPhoneBooks->id }}" name="id"> 
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" value="{{ old('name', $editPhoneBooks->name) }}" name="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                          </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control" id="mobile" value="{{ old('mobile', $editPhoneBooks->mobile) }}" name="mobile">
                            @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                          </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" value="{{ old('address', $editPhoneBooks->address) }}" name="address">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                          </div>

                          {{-- checkbox section --}}

                          <div class="">
                            {{-- <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option selected disabled>Select status</option>
                                <option value="0" {{ old('status', $editPhoneBooks->status) == '0' ? 'selected' : '' }}>Public</option>
                                <option value="1" {{ old('status', $editPhoneBooks->status) == '1' ? 'selected' : '' }} >Private</option>
                              </select> --}}
                              <div class=" align-items-center input-group">
                                <input  type="checkbox" id="status" name="status" value="0" {{ old('status', $editPhoneBooks->status) == '0' ? 'checked' : '' }}> 
                                <label class="px-1 pt-1" for="status">Public</label><br>
                              </div>
                                @error('status')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                          </div>

                          @if ($editPhoneBooks->status == 1)
                            <div class="">
                                {{-- <label for="favourite" class="form-label">favourite</label>
                                <select class="form-select" name="favourite" id="favourite">
                                    <option selected disabled>Make favourite</option>
                                    <option value="0" {{ old('favourite', $editPhoneBooks->favourite) == '0' ? 'selected' : '' }}>Unfavourite</option>
                                    <option value="1" {{ old('favourite', $editPhoneBooks->favourite) == '1' ? 'selected' : '' }} >Favourite</option>
                                </select> --}}
                                <div class="d-flex align-items-center input-group">
                                    <input type="checkbox" id="favourite" name="favourite" value="1" {{ old('favourite', $editPhoneBooks->favourite) == '1' ? 'checked' : '' }}>
                                    <label class="px-1 pt-1" for="favourite">Favourite</label><br>
                                </div>
                                @error('favourite')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="">
                                
                                <div class="d-flex align-items-center input-group">
                                    <input type="checkbox" id="friend" name="friend" value="1" {{ old('friend', $editPhoneBookGroup->friend) == '1' ? 'checked' : '' }}>
                                    <label class="px-1 pt-1" for="friend">Mark as friend</label><br>
                                </div>
                                @error('friend')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                          @endif
                          

                          {{-- Passing the owner id hidden --}}
                          {{-- <input type="show" value="{{ Auth::user()->id }}" name="ownerId"> --}}

                          

                          <div class="d-grid mb-2">
                            <input type="submit" class="btn btn-primary" value="ADD">
                          </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection