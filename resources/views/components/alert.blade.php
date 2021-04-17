@if($errors->any())
    @foreach($errors->getMessages() as $this_error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            {!! $this_error[0] !!}
        </div>
    @endforeach
@endif