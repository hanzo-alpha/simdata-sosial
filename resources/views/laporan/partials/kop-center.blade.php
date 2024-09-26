@if(config('app.env') === 'local')
    <img style="align-items: center; align-content: center;"
         src="images/logos/logo-soppeng2.png"
         alt="logo"
         height="60" />
@else
    <img style="align-items: center; align-content: center;"
         src="{{ asset('images/logos/logo-soppeng2.png') }}"
         alt="logo"
         height="60" />
@endif
<h2 style="margin-bottom: 5px">
    <strong>{{ setting('ba.kop_title') }}</strong>
</h2>
<h1 style="margin-top: 3px; margin-bottom: 5px">
    <strong>{{ setting('ba.kop_instansi') }}</strong>
</h1>
<p class="pt-0">
    <span style="font-style: italic">
        {{ setting('ba.kop_jalan') }}
    </span>
    <br />
    <span style="font-style: italic" class="mt-1">
         {{ setting('ba.kop_website') }}
    </span>
</p>
