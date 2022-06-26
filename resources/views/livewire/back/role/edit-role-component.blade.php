<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">@lang("Edit role")</h4>
            <div class="d-flex flex-row-reverse">
                <a href="{{ route('roles.index') }}" class="btn btn-primary text-right">@lang('Return to roles list')</a>
            </div>
        </div>
        <div class="card-content collapse show" aria-expanded="true">
            <div class="card-body">
                <form class="row" wire:submit.prevent='editRole'>
                    <div class="col-12">
                        <label class="form-label" for="roleName">@lang("Role Name")</label>
                        <input type="text" wire:model='name' value="{{ old('name') }}" id="roleName" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="@lang('Role Name')" autofocus/>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-2 me-1">@lang("Update")</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (count($role->permissions))
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('Permission')</h4>
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
                        @foreach ($role->permissions as $key => $row)
                            <li class="row mt-1">
                                <div class="col-3">{{ $row->name }}</div>
                                <div class="col-3">
                                    <button wire:click="revokePermission('{{ $row->id }}')" type="button" class="btn btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if (count($permissions))
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('Assign a permission to a role')</h4>
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
                                <label class="form-label" for="assign_rolebasic">@lang("Permissions")</label>
                                <div wire:ignore>
                                    <select wire:model='permission_name' name="permission" class="select2 form-select" id="assign_rolebasic">
                                        <option value="">@lang("Select a permission")</option>
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('permission_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @error('give_ermission') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            </div>
                            <div class="col-md-2 mb-1">
                                <button type="submit" style="margin-top: 1.75em !important;" class="btn btn-primary">@lang("Add")</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

@section('title')
    @lang('Edit role')
@endsection

@section('page-script')
    <script>
        $(function() {
            $("#assign_rolebasic").select2();
            $('#assign_rolebasic').on('change', function (e) {
                var data = $('#assign_rolebasic').select2("val");
                @this.set('permission_name', data);
            });
        })
    </script>
@endsection
