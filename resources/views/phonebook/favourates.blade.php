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
                        <button type="button" class="btn btn-outline-warning mr-2"><a class="text-decoration-none text-warning" href="">Favourates</a></button>
                    </div>
                </div>
                {{-- <div class="text-right">
                    <button type="button" class="btn btn-outline-warning mr-2"><a class="text-decoration-none text-warning" href="">Favourates</a></button>
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
                            <th scope="col">Favourate</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($phonebooks as $item)
                              <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->mobile }}</td>
                                <td>{{ $item->address }}</td>
                                <td>
                                    @if ($item->status == '0')
                                        <span class="badge bg-success">Public</span> 
                                        
                                    @else
                                    <span class="badge bg-danger">Private</span>
                                        
                                    @endif
                                </td>
                                <td>
                                    @if ($item->favourate == '1')
                                        <span class="badge bg-warning">Favourate</span> 
                                    @endif
                                </td>
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
    </div>
</div>

@endsection