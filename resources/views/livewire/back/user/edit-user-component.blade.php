<section id="basic-horizontal-layouts">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('users.index') }}" class="btn btn-primary">@lang('Return to user list')</a>
        </div>
        <div class="card-body">
            <form class="form form-horizontal" wire:submit.prevent="updateUser">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="fname-icon">@lang('Name')</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="input-group input-group-merge @error('name') is-invalid @enderror">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    </span>
                                    <input type="text" wire:model='name' id="fname-icon" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="@lang('Name')" />
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="email-icon">@lang("Email")</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="input-group input-group-merge @error('email') is-invalid @enderror">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    </span>
                                    <input type="email" wire:model='email' id="email-icon" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="@lang('Email Address')" />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="pass-icon">@lang('Password')</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    </span>
                                    <input type="password" id="pass-icon" class="form-control @error('password') is-invalid @enderror" disabled name="password" placeholder="password" />
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="photo-icon">@lang('Photo')</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="input-group input-group-merge @error('profile_photo_path') is-invalid @enderror">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                    </span>
                                    <input wire:model='profile_photo_path' type="file" accept="image/*" id="photo-icon" class="form-control @error('profile_photo_path') is-invalid @enderror" name="profile_photo_path" />
                                    @error('profile_photo_path')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="preview">
                                    @if ($profile_photo_path)
                                        <img height="90" src="{{ $profile_photo_path->temporaryUrl() }}">
                                    @else
                                        <img height="90" src="{{ asset($photo_path) }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary me-1">@lang('Update')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@section('title')
    @lang('Edit user')
@endsection
