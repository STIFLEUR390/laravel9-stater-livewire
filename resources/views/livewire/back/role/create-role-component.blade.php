<div class="card">
    <div class="card-header">
        <h4 class="card-title">@lang("Add new role")</h4>
        <div class="d-flex flex-row-reverse">
            <a href="{{ route("roles.index") }}" class="btn btn-primary text-right">@lang('Return to roles list')</a>
        </div>
    </div>
    <div class="card-content collapse show" aria-expanded="true">
        <div class="card-body">
            <!-- Validation Errors -->
            <form class="row" wire:submit.prevent='createRole'>
                <div class="col-12">
                    <label class="form-label" for="roleName">@lang("Role Name")</label>
                    <input type="text" wire:model='name' value="{{ old('name') }}" id="roleName" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="@lang('Role Name')" autofocus/>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary mt-2 me-1">@lang("Create a role")</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('title')
    @lang('Create a role')
@endsection
