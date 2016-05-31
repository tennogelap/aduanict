{{--if validation fails.. display this message--}}
<div class="container">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <h4>Validation Error!!!</h4>
            Maaf, sila betulkan borang sebelum hantar
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
{{--paparkan FLASH Message--}}

@include('flash::message')