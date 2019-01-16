@php
	$next_class = '';
	$prev_class = '';

	if(!isset($next_url))
	{
		$next_class = 'd-none';
		$next_url  = '#';
	}
	if(!isset($prev_url))
	{
		$prev_class = 'd-none';
		$prev_url = '#';
	}
@endphp
<div class="row">
	<div class="col-md-12">
		<a href="/{{ $prev_url }}" class="btn btn-primary no-border-radius {{ $prev_class }}">&laquo; Previous</a>
		<a href="/{{ $next_url }}" class="btn btn-primary no-border-radius float-right {{ $next_class }}">Next &raquo</a>
	</div>
</div>
<br>