@if (count($errors) > 0)
    <div class="alert alert-danger">
        {{--<p>There were some problems with your input.</p>--}}
        <ul>
            @foreach ($errors->all() as $error)
                <li> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif