@extends('layout.app')
@section('content')
<div class="container" role="alert">
    <div class="row my-3">
        <div class="col-md-12">
            <h4>Profile</h4>
        </div>
    </div>
    @include('error_message')
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4>
                        Profile Information
                    </h4>
                    <p>Update your account's profile information and email address.</p>

                    <form action="{{ route('profile.update') }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" required="" value="{{ old('name') ?? $user->name  }}">
                                @error('name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" required="" value="{{ old('email') ?? $user->email }}">
                                @error('email')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-dark">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!--pasword update--->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4>
                        Update Password
                    </h4>
                    <p>Ensure your account is using a long, random password to stay secure.</p>

                    <form action="{{ route('profile.password') }}" method="post">
                        @csrf
                        @method('Patch')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Current Password</label>
                                <input type="password" name="current_password" class="form-control"  required="" value="">
                                @error('current_password')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">New Password</label>
                                <input type="password" name="password" required="" class="form-control">
                                @error('password')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control"  required="">
                                @error('password_confirmation')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-dark">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--delete account--->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4>
                        Delete Account
                    </h4>
                    <p>Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>

                    <form action="{{ route('profile.destroy') }}" method="post" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                        @csrf
                        @method("delete")
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-danger">Delete Account</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
