

<div class="flash-message" >
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))

    <p class="alert alert-{{ $msg }}">{{ Session::pull('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
    @endforeach


    @if(count($errors) > 0)
    <div class="alert alert-error">
        <button class="close" data-dismiss="alert">×</button>
        @foreach($errors->all() as $error)
        <p>
            <strong>Error!</strong>  {{ $error }}
        </p>
        @endforeach
    </div>
    @endif
</div>