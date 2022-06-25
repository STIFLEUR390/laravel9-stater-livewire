<section class="app-user-list">
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="fw-bolder mb-75">{{ $user_count }}</h3>
                        <span>@lang('Total Users')</span>
                    </div>
                    <div class="avatar bg-light-primary p-50">
                        <span class="avatar-content">
                            <i data-feather="user" class="font-medium-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="fw-bolder mb-75">4,567</h3>
                        <span>Paid Users</span>
                    </div>
                    <div class="avatar bg-light-danger p-50">
                        <span class="avatar-content">
                            <i data-feather="user-plus" class="font-medium-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="fw-bolder mb-75">{{ $active_users }}</h3>
                        <span>@lang('Active Users')</span>
                    </div>
                    <div class="avatar bg-light-success p-50">
                        <span class="avatar-content">
                            <i data-feather="user-check" class="font-medium-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="fw-bolder mb-75">{{ $pending_users }}</h3>
                        <span>@lang('Disabled Users')</span>
                    </div>
                    <div class="avatar bg-light-warning p-50">
                        <span class="avatar-content">
                            <i data-feather="user-x" class="font-medium-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- list and filter start -->
    <div class="card">
        @if (auth()->user()->can('create users'))
            <div class="card-body border-bottom d-flex flex-row-reverse">
                <a href="{{ route('users.create') }}" class="btn btn-primary">@lang('Add new user')</a>
            </div>
        @endif
        <div style="width: 96%;" class="row my-1 mx-2">
            <div class="col-6 input-group input-group-merge" style="width: 48%;">
                <input type="text" class="form-control search-product" id="shop-search" wire:model='search' placeholder="@lang('Search a user')" aria-label="Search..." aria-describedby="shop-search" />
                <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
            </div>
            <div class="col-6" wire:ignore>
                <select wire:model='role' class="select2 form-select" id="assign_rolebasic">
                    <option value="">@lang('Select a role')</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div @if (count($users) > 4) class="table-responsive" @endif>
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>@lang('Name')</th>
                        <th>@lang('Email')</th>
                        <th>@lang('Role')</th>
                        {{-- <th>Plan</th>
                        <th>Billing</th> --}}
                        <th>@lang('Status')</th>
                        <th style="width: 10%">@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr @if ($user->deleted_at) style="background-color: #798939 !important" @endif>
                            <td>
                                <img src="{{ asset($user->profile_photo_url) }}" alt="{{ $user->name }}" height="50" />
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ count($user->roles) > 0 ? $user->getRoleNames()[0] : '' }}</td>
                            <td>
                                @if ($user->deleted_at)
                                    <span class="badge bg-danger">@lang('Disable')</span>
                                @else
                                    <span class="badge bg-primary">@lang('Active')</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->deleted_at)
                                    @if (auth()->user()->can('delete users'))
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a wire:click="restoreUser('{{ $user->id }}')" class="dropdown-item" href="#">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-ccw"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                                                    <span>@lang('Restore')</span>
                                                </a>
                                                <a wire:click="confirmDeletion('{{ $user->id }}')" class="dropdown-item" href="#">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                    <span>@lang('Delete')</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            @if (auth()->user()->can('crud permission') || auth()->user()->can('crud role') || auth()->user()->can('show users'))
                                                <a class="dropdown-item" href="{{ route('users.show', $user->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye me-50"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                    <span>@lang('User details')</span>
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('edit users'))
                                                <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                    <span>@lang('Edit')</span>
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('delete users'))
                                                <a class="dropdown-item" wire:click="disableUser('{{ $user->id }}')" href="#">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                    <span>@lang('Disable')</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex flex-row-reverse">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    <!-- list and filter end -->
</section>

@section('title')
    {{ __('locale.All users') }}
@endsection

@section('page-script')
    <script>
        $(function() {
            $("#assign_rolebasic").select2();
            $('#assign_rolebasic').on('change', function (e) {
                var data = $('#assign_rolebasic').select2("val");
                @this.set('role', data);
            });
        })
    </script>
@endsection
