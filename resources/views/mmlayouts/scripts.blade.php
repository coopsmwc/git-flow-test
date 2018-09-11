<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}" defer></script>
<script src="{{ mix('js/vc.js') }}" defer></script>
<script src="{{ mix('js/scripts.js') }}" defer></script>
@if (isset($scripts))
    @foreach ($scripts as $script)
        <script src="{{ $script }}"></script>
    @endforeach
@endif