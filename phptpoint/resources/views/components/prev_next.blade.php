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
	if(isset($add)){
		$adds   =   App\Add::where('add_type',$add)->get();
		
	}
		
@endphp
<div class="row">
	@if(!empty($adds) && $add =="top")
		@foreach($adds as $add)
			<div class="col-md-12 text-center"> 
				{!! html_entity_decode($add->content) !!}
			</div>
		@endforeach
	@endif
	<div class="col-md-12">
		<a href="/{{ $prev_url }}" class="btn btn-primary no-border-radius {{ $prev_class }}">&laquo; Previous</a>
		<a href="/{{ $next_url }}" class="btn btn-primary no-border-radius float-right {{ $next_class }}">Next &raquo</a>
	</div>
	@if(!empty($adds) && $add =="bottom")
		@foreach($adds as $add)
			<div class="col-md-12 text-center"> 
				{!! html_entity_decode($add->content) !!}
			</div>
		@endforeach
	@endif
</div>
<br>