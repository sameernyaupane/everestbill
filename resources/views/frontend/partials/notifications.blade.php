@if ($errors->any())
	<div class="alert alert-danger alert-dismissable">
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	    <h4>Error</h4>
	    Please check the form below for errors

	    <br>

	    {{--@foreach($errors->all() as $error)
			{{{ $error }}}
		@endforeach --}}
	</div>
@endif

@if ($message = Session::get('success'))
	<div class="alert alert-success alert-dismissable">
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	    <h4>Success</h4>
	    {{{ $message }}}
	</div>
@endif

@if ($message = Session::get('error'))
	<div class="alert alert-danger alert-dismissable">
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	    <h4>Error</h4>
	    {{{ $message }}}
	</div>
@endif

@if ($message = Session::get('warning'))
	<div class="alert alert-warning alert-dismissable">
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	    <h4>Warning</h4>
	    {{{ $message }}}
	</div>
@endif

@if ($message = Session::get('info'))
	<div class="alert alert-info alert-dismissable">
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	    <h4>Info</h4>
	    {{{ $message }}}
	</div>
@endif
