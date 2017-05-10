<form method="post" action="{{ route('login.index') }}">
  {{ csrf_field() }}
  <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
    @if($errors->has('email'))
      @foreach ($errors->get('email') as $message)
        <div class="alert alert-danger error-message" role="alert">{{ $message }}</div>
      @endforeach
    @endif
  </div>
  <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password">
    @if($errors->has('password'))
      @foreach ($errors->get('password') as $message)
        <div class="alert alert-danger error-message" role="alert">{{ $message }}</div>
      @endforeach
    @endif
  </div>
  <button type="submit" class="btn btn-default">Login</button>
</form>