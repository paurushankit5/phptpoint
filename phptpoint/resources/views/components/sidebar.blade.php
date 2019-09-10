<?php
	if(isset($sidebar_type) && isset($source_page_id))
	{
		$linked_sidebars   =   App\Http\Controllers\HomeController::getsidebars($sidebar_type,$source_page_id);
		if(count($linked_sidebars))
		{
			foreach($linked_sidebars as $linked_sidebar){
				$added_url  ='';
				if($linked_sidebar->sidebar_type=="project")
				{
					$added_url = "projects/";
				}
				?>
					<br>
					<br>
					<div class="list-group">
					  	<a href="#" class="list-group-item list-group-item-action active">{{ $linked_sidebar->sidebar->sidebar_name }} </a>
						@if(count($linked_sidebar->sidebar->sidebar_content))
							@foreach($linked_sidebar->sidebar->sidebar_content as $sidebar_content)
								<?php
									$sidebar_content_data = App\Http\Controllers\HomeController::getsidebarcontent($sidebar_content->destination_id,$linked_sidebar->sidebar->sidebar_type);
								?> 	
								<a href="@if($sidebar_content_data->external_link !='') {{$sidebar_content_data->external_link}} @else /{{ $sidebar_content_data->slug }} @endif" class="list-group-item list-group-item-action">{{ $sidebar_content_data->name }}</a>
							@endforeach
						@endif	
					</div>
				<?php
			}

		}

	}
	

?>

