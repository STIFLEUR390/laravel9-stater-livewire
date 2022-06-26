@component('mail::message')

    @lang("The application has gone into maintenance mode"). <br/>
    @lang("To access the application in amintenance mode, click on the button")

    @component('mail::button', ['url' => $url, 'color' => 'success'])
        @lang("Access the app")
    @endcomponent

    @lang("Thanks"),
    {{ config('app.name') }}

@endcomponent
