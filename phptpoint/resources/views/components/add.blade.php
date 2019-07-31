@php
	$adds   =   App\Add::where('add_type','right')->get();
	if(count($adds)){
		foreach($adds as $add){
			@endphp
				<div class="p-8 mb-5 bg-white"> 
					{!! html_entity_decode($add->content) !!}
				</div>
			@php
		}
	}
@endphp