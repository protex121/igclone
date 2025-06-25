@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('users.update', $user) }}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">{{ __('Edit Profile') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Name') }}</label>

                                        <input id="name"
                                               type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               name="name"
                                               value="{{ old('name') ?? $user->name }}"
                                               autocomplete="name">

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="username">{{ __('Username') }}</label>

                                        <input id="username"
                                               type="text"
                                               class="form-control @error('username') is-invalid @enderror"
                                               name="username"
                                               value="{{ old('username') ?? $user->username }}"
                                               autocomplete="username">

                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <div class="text-muted">
                                            <small>
                                                {{ __('You can change your username twice in the interval of 14 days.') }}
                                            </small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-file">

                                            <label for="avatar" class="custom-file-label">{{ __('Avatar') }}</label>

                                            <input type="file"
                                                   class="custom-file-input"
                                                   id="avatar"
                                                   name="avatar"
                                                   accept="image/*"
                                                   oninput="document.getElementById('avatar-img').src=window.URL.createObjectURL(this.files[0])">
                                        </div>

                                        <img src="{{ $user->avatar }}" id="avatar-img" class="img-thumbnail my-3"
                                             alt="{{ $user->name }}"/>

                                        @error('avatar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary">{{ __('Save Profile') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
