@if(session()->has('success'))
  <div class="alert alert-success text-center" role="alert">
    {{ session('success') }}
  </div>
@endif


@if(session()->has('error'))

  <div class="alert alert-danger text-center" role="alert">
    {{ session('error') }}
  </div>

@endif


@if(count($errors->all()) > 0)
<div class="alert alert-danger text-center alert-message" role="alert">
        <ul >
            @foreach($errors->all() as $error)
                <li class="list-group-item">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
