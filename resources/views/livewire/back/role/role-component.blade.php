<div>
    <!-- Role cards -->
    <div class="row">
        @foreach ($roles as $role)
            @php
                $users = App\Models\User::role($role->name, 'web')->inRandomOrder()->take(5)->get();
                $user_count = App\Models\User::role($role->name, 'web')->count();
            @endphp
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Total of :num users', ['num'=> $user_count]) }}</span>
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                @foreach ($users as $user)
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        title="{{ $user->name }}" class="avatar avatar-sm pull-up">
                                        <img class="rounded-circle" src="{{ asset($user->profile_photo_url) }}" alt="{{ $user->name }}" />
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                            <div class="role-heading">
                                <h4 class="fw-bolder">@lang($role->name)</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!--/ Role cards -->

    <!-- table -->
    <div class="card">
        <div class="card-body border-bottom d-flex flex-row-reverse">
            <a href="{{ route('roles.create') }}" class="btn btn-primary">@lang('Add new role')</a>
        </div>

        <div class="input-group input-group-merge my-1 mx-2" style="width: 96%;">
            <input type="text" class="form-control search-product" id="shop-search" wire:model='search' placeholder="@lang('Search a role')" aria-label="Search..." aria-describedby="shop-search" />
            <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
        </div>

        <div @if (count($roles) > 4) class="table-responsive" @endif >
            <table class="table">
                <thead>
                    <tr>
                        <th>@lang("Role Name")</th>
                        <th>@lang("Create at")</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ Carbon\Carbon::parse($role->created_at)->format('Y-m-d') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit me-50"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            <span>@lang('Edit')</span>
                                        </a>
                                        <a wire:click="confirmDeletion('{{ $role->id }}')" class="dropdown-item" href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            <span>@lang('Delete')</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex flex-row-reverse">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
    <!-- table -->
</div>

@section('title')
    @lang('Roles list')
@endsection
