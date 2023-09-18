@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('User panel') }}: {{ auth()->user()->name }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('update-user') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ auth()->user()->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ auth()->user()->email }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="birthDate"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Birth date') }}</label>
                                <div class="col-md-6">
                                    <input id="birthDate" type="date"
                                        class="form-control @error('birthDate') is-invalid @enderror" name="birthDate"
                                        value="{{ auth()->user()->birth_date }}">
                                    @error('birthDate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="gender"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>
                                <div class="col-md-6">
                                    <select name="gender" class="form-select @error('gender') is-invalid @enderror"
                                        value="{{ auth()->user()->gender }}" id="floatingSelect"
                                        aria-label="Floating label select example">
                                        <option value="">{{ __('Select gender') }}</option>
                                        <option value="male">{{ __('Male') }}</option>
                                        <option value="female">{{ __('Female') }}</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save new data') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Change password') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('change-pass') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="currentPassword"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Current password') }}</label>
                                <div class="col-md-6">
                                    <input id="currentPassword" type="password"
                                        class="form-control @error('currentPassword') is-invalid @enderror"
                                        name="currentPassword" required autocomplete="new-password">

                                    @error('currentPassword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="newPassword"
                                    class="col-md-4 col-form-label text-md-end">{{ __('New password') }}</label>
                                <div class="col-md-6">
                                    <input id="newPassword" type="password"
                                        class="form-control @error('newPassword') is-invalid @enderror"
                                        name="newPassword" required autocomplete="new-password">

                                    @error('newPassword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="newPasswordConfirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm new password') }}</label>

                                <div class="col-md-6">
                                    <input id="newPasswordConfirm" type="password" class="form-control"
                                        name="newPassword_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save new password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
