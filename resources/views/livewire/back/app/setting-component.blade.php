<section>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">@lang("Maintenance mode")</h4>
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
                @if ($active)
                    <button type="button" wire:click='disableMaintenanceMode' class="btn btn-success">@lang("Turn off maintenance mode")</button>
                @else
                    <button type="button" wire:click='confirmActivationmaintenanceMode' class="btn btn-warning">@lang("Enable maintenance mode")</button>
                @endif
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">@lang("Create the symbolic links configured for the application")</h4>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i data-feather="chevron-down"></i></a></li>
                    <li><a data-action="close"><i data-feather="x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show" aria-expanded="true">
            <div class="card-body">
                <button type="button" wire:click='symbolicLinks' class="btn btn-info">@lang('Create')</button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">@lang('Translations')</h4>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i data-feather="chevron-down"></i></a></li>
                    <li><a data-action="close"><i data-feather="x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show" aria-expanded="true">
            <div class="card-body row">
                <div class="col-12">
                    <div wire:loading.delay wire:target="translations" class="mb-5">
                        <div class="spinner" style="padding-left: 3rem !important; padding-top: 3rem !important;"></div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="button" wire:click='translations("reset")' class="btn btn-primary">@lang("Delete all translations from the database")</button>
                </div>
                <div class="col-12">
                    <button type="button" wire:click='translations("import")' class="btn btn-primary my-2">@lang("Import translations from the PHP sources")</button>
                </div>
                <col-12>
                    <button type="button" wire:click='translations("find")' class="btn btn-primary">@lang("Find translations in php/twig files")</button><br>
                </col-12>
                <col-12>
                    <button type="button" wire:click='translations("clean")' class="btn btn-primary my-2">@lang('Clean empty translations')</button><br>
                </col-12>
                <div class="col-12">
                    <a href="{{ url('translations') }}" class="btn btn-info" target="_blank" rel="noopener noreferrer">mettre a jour et exporter les traductions</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">@lang("Others")</h4>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i data-feather="chevron-down"></i></a></li>
                    <li><a data-action="close"><i data-feather="x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show" aria-expanded="true">
            <div class="card-body row">
                <div class="col-12">
                    <div wire:loading.delay wire:target="other" class="mb-5">
                        <div class="spinner" style="padding-left: 3rem !important; padding-top: 3rem !important;"></div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="button" wire:click='other("clear-compiled")' class="btn btn-primary">@lang("Remove the compiled class file")</button>
                </div>
                <div class="col-12 my-2">
                    <button type="button" wire:click='other("cache:clear")' class="btn btn-primary">@lang("Flush the application cache")</button>
                </div>
                <div class="col-12">
                    <button type="button" wire:click='other("config:clear")' class="btn btn-primary">@lang("Remove the configuration cache file")</button>
                </div>
                <div class="col-12 my-2">
                    <button type="button" wire:click='other("debugbar:clear")' class="btn btn-primary">@lang("Clear the Debugbar Storage")</button>
                </div>
                <div class="col-12">
                    <button type="button" wire:click='other("optimize:clear")' class="btn btn-primary">@lang("Remove the cached bootstrap files")</button>
                </div>
                <div class="col-12 my-2">
                    <button type="button" wire:click='other("permission:cache-reset")' class="btn btn-primary">@lang("Reset the permission cache")</button>
                </div>
                <div class="col-12">
                    <button type="button" wire:click='other("queue:clear")' class="btn btn-primary">@lang("Delete all of the jobs from the specified queue")</button>
                </div>
                <div class="col-12 my-2">
                    <button type="button" wire:click='other("route:cache")' class="btn btn-primary">@lang("Create a route cache file for faster route registration")</button>
                </div>
                <div class="col-12">
                    <button type="button" wire:click='other("route:clear")' class="btn btn-primary">@lang("Remove the route cache file")</button>
                </div>
                <div class="col-12 my-2">
                    <button type="button" wire:click='other("view:cache")' class="btn btn-primary">@lang("Compile all of the application's Blade templates")</button>
                </div>
                <div class="col-12">
                    <button type="button" wire:click='other("view:clear")' class="btn btn-primary">@lang("Clear all compiled view files")</button>
                </div>
                <div class="col-12 my-2">
                    <div wire:loading wire:target="other('custom')" class="mb-5">
                        <div class="spinner" style="padding-left: 3rem !important; padding-top: 3rem !important;"></div>
                    </div>
                    <form wire:submit.prevent='other("custom")' class="row">
                        <div class="col-10 my-2">
                            <div class="mb-1">
                                <label class="form-label" for="custom_command">@lang('Enter the Artisan command')</label>
                                <input type="text" wire:model='customCommand' class="form-control @error('customCommand') is-invalid @enderror" id="custom_command" placeholder="@lang('Enter the Artisan command')" />
                                <p><small class="text-muted">@lang("The command must not contain") <strong>php artisan</strong></small></p>
                                @error('customCommand') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-2 my-2">
                            <button type="submit" style="margin-top: 1.75em !important;" class="btn btn-primary">@lang("Execute")</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


@section('title')
    @lang('Settings')
@endsection

@section('page-style')
    <style>
        @keyframes spinner {
            to {transform: rotate(360deg); }
        }

        .spinner:before {
            content: '';
            box-sizing: border-box;
            position: absolute;
            top: 50%;
            left: 50%;
            width: 64px;
            height: 64px;
            margin-top: -32px;
            margin-left: -32px;
            border-radius: 50%;
            border: 1px solid #ccc;
            border-top-color: #07d;
            animation: spinner .6s linear infinite;
        }
    </style>
@endsection
