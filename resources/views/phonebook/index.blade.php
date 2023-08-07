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
                    
                    <div class="mt-2">
                        <button type="" class="btn btn-outline-warning mr-2"><a class="text-decoration-none text-warning" href="{{ route('phonebook.fav') }}">Favourites</a></button>
                    </div>
                </div>
                {{-- <div class="text-right">
                    <button type="button" class="btn btn-outline-warning mr-2"><a class="text-decoration-none text-warning" href="">favourites</a></button>
                </div> --}}

                <div class="card-body">

                    @if (session('msg'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('msg') }}</strong>
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
                            <th scope="col">Status</th>
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
                                </td>
                                <td>{{ $item->mobile }}</td>
                                <td>{{ $item->address }}</td>
                                <td>
                                    @if ($item->status == '0')
                                        <span class="badge bg-success">Public</span> 
                                        
                                    @else
                                    <span class="badge bg-danger">Private</span>
                                        
                                    @endif
                                </td>
                                {{-- <td>
                                    @if ($item->favourite == '1')
                                        <span class="badge bg-warning">Favourite</span> 
                                    @endif
                                </td> --}}
                                <td><a class="btn btn-outline-success btn-sm" href="{{ route('phonebook.edit', $item->id) }}">Edit</a></td>
                                <td><a class="btn btn-outline-danger btn-sm" href="{{ route('phonebook.delete', $item->id) }}">Delete</a></td>
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
                <div class="card-header text-center pt-4">
                    <h4>Add Contacts</h4>
                    
                </div>

                <div class="card-body">
                    
                    <form action="{{ route('phonebook.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                          </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Mobile</label>
                            <input type="text" class="form-control" id="mobile" value="{{ old('mobile') }}" name="mobile">
                            @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                          </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" value="{{ old('address') }}" name="address">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                          </div>
                          <div class="mb-3">
                            {{-- <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option disabled>Select status</option>
                                <option value="0" >Public</option>
                                <option selected value="1" >Private</option>
                              </select>
                              @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror --}}

                            <div class="input-group-prepend">
                                
                                <div class="input-group-text">
                                    
                                    <input type="checkbox" name="status" id="status" value="0" aria-label="Checkbox for following text input">
                                    {{-- <label for="status" class="form-label">Public</label> --}}
                                    <p class="pt-3 pl-1">Public</p>
                                </div>
                            </div>
                          </div>

                          {{-- Passing the owner id hidden --}}
                          <input type="hidden" value="{{ Auth::user()->id }}" name="ownerId">

                          {{-- Favourite default input --}}
                          <input type="hidden" value="0" name="favourite">

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