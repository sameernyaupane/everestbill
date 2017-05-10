<form method="post" action="{{ route('register.index') }}">
  {{ csrf_field() }}
  <div class="form-group {{ $errors->has('full_name') ? 'has-error' : '' }}">
    <label for="full_name">Full Name</label>
    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name" value="{{ old('full_name') }}">
    @if($errors->has('full_name'))
      @foreach ($errors->get('full_name') as $message)
        <div class="alert alert-danger error-message" role="alert">{{ $message }}</div>
      @endforeach
    @endif
  </div>
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
    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    @if($errors->has('password'))
      @foreach ($errors->get('password') as $message)
        <div class="alert alert-danger error-message" role="alert">{{ $message }}</div>
      @endforeach
    @endif
  </div>
  <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
    <label for="password_confirmation">Password Confirmation</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password Confirmation">
    @if($errors->has('password_confirmation'))
      @foreach ($errors->get('password_confirmation') as $message)
        <div class="alert alert-danger error-message" role="alert">{{ $message }}</div>
      @endforeach
    @endif
  </div>
  <button type="submit" class="btn btn-default">Register</button>
</form>