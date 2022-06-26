<section class="app-user-view-account">
    <!-- User Card -->
    <div class="card">
        <div class="card-header">
            <a href="{{ route('users.index') }}" class="btn btn-primary">@lang('Return to user list')</a>
        </div>
        <div class="card-body">
            <div class="user-avatar-section">
                <div class="d-flex align-items-center flex-column">
                    <img class="img-fluid rounded mt-3 mb-2" src="{{ $user->profile_photo_url }}" height="110"
                        width="110" alt="{{ $user->name }}" />
                    <div class="user-info text-center">
                        <h4>{{ $user->name }}</h4>
                        <span
                            class="badge bg-light-secondary">{{ count($user->roles) > 0 ? $user->getRoleNames()[0] : '' }}</span>
                    </div>
                </div>
            </div>
            <h4 class="fw-bolder border-bottom pb-50 mb-1">@lang('Details')</h4>
            <div class="info-container">
                <ul class="list-unstyled">
                    <li class="mb-75">
                        <span class="fw-bolder me-25">@lang('Name')</span>
                        <span>{{ $user->name }}</span>
                    </li>
                    <li class="mb-75">
                        <span class="fw-bolder me-25">@lang('Email Address')</span>
                        <span>{{ $user->email }}</span>
                    </li>
                    <li class="mb-75">
                        <span class="fw-bolder me-25">@lang('Status')</span>
                        @if ($user->deleted_at)
                            <span class="badge bg-danger">@lang('Disable')</span>
                        @else
                            <span class="badge bg-primary">@lang('Active')</span>
                        @endif
                    </li>
                    @if (count($user->roles) > 0)
                        <li class="mb-75">
                            <span class="fw-bolder me-25">@lang('Role')</span>
                            <span>{{ count($user->roles) > 0 ? $user->getRoleNames()[0] : '' }}</span>
                        </li>
                    @endif
                </ul>
                <div class="d-flex justify-content-center pt-2">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary me-1">
                        @lang('Edit')
                    </a>
                    @if (!$user->deleted_at)
                        <a href="#" wire:click='diseableUser' class="btn btn-outline-danger suspend-user">
                            @lang('Suspended')
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /User Card -->
    @if (count($user->roles) > 0 &&
        auth()->user()->can('crud role'))
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('User roles')</h4>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i data-feather="chevron-down"></i></a></li>
                        {{-- <li><a data-action="reload"><i data-feather="rotate-cw"></i></a></li> --}}
                        <li><a data-action="close"><i data-feather="x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show" aria-expanded="true">
                <div class="card-body">
                    <ul>
                        @foreach ($user->roles as $key => $role)
                            <li class="row mt-1">
                                <div class="col-3">{{ $role->name }}</div>
                                <div class="col-3">
                                    <button wire:click="removeRole('{{ $role->name }}')" type="submit"
                                        class="btn btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-trash-2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                            </path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if ($roles &&
        auth()->user()->can('crud role'))
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('Assign a role to the user')</h4>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i data-feather="chevron-down"></i></a></li>
                        {{-- <li><a data-action="reload"><i data-feather="rotate-cw"></i></a></li> --}}
                        <li><a data-action="close"><i data-feather="x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show" aria-expanded="true">
                <div class="card-body">
                    <form wire:submit.prevent='assignRole'>
                        <div class="row">
                            <div class="col-md-10 mb-1">
                                <label class="form-label" for="assign_role">@lang('Role')</label>
                                <div wire:ignore>
                                    <select wire:model='role_name' class="select2 form-select" id="assign_role">
                                        <option value="">@lang('Select a role')</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('assign_role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2 mb-1">
                                <button type="submit" style="margin-top: 1.75em !important;"
                                    class="btn btn-primary">@lang('Assign')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if (count($user->permissions) > 0 &&
        auth()->user()->can('crud permission'))
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('User permissions')</h4>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i data-feather="chevron-down"></i></a></li>
                        {{-- <li><a data-action="reload"><i data-feather="rotate-cw"></i></a></li> --}}
                        <li><a data-action="close"><i data-feather="x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show" aria-expanded="true">
                <div class="card-body">
                    <ul>
                        @foreach ($user->permissions as $permission)
                            <li class="row mt-1">
                                <div class="col-3">{{ $permission->name }}</div>
                                <div class="col-3">
                                    <button wire:click="revokePermission('{{ $permission->name }}')" type="button" class="btn btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-trash-2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                            </path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if ($permissions &&
        auth()->user()->can('crud permission'))
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('Give a permission to the user')</h4>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i data-feather="chevron-down"></i></a></li>
                        {{-- <li><a data-action="reload"><i data-feather="rotate-cw"></i></a></li> --}}
                        <li><a data-action="close"><i data-feather="x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show" aria-expanded="true">
                <div class="card-body">
                    <form wire:submit.prevent='givePermission'>
                        <div class="row">
                            <div class="col-md-10 mb-1">
                                <label class="form-label" for="give_permission">@lang('Permission')</label>
                                <div wire:ignore>
                                    <select wire:model='permission_name' class="select2 form-select" id="give_permission">
                                        <option value="">@lang('Select a permission')</option>
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('role_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('assign_role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-1">
                                <button type="submit" style="margin-top: 1.75em !important;"
                                    class="btn btn-primary">@lang('Give')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</section>

@section('title')
    @lang('User details')
@endsection

@section('page-script')
    <script>
        $(function() {
            $("#assign_role").select2();
            $('#assign_role').on('change', function(e) {
                var data = $('#assign_role').select2("val");
                @this.set('role_name', data);
            });

            $("#give_permission").select2();
            $('#give_permission').on('change', function(e) {
                var data = $('#give_permission').select2("val");
                @this.set('permission_name', data);
            });
        })
    </script>
@endsection
