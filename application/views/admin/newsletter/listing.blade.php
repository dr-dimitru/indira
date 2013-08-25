@layout('admin.newsletter.template')

<h3>
	<i class="icon-envelope-alt"></i> {{ __('content.newsletter') }} 
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_new_newsletter"
			class="btn"
			href="{{ action('admin.newsletter.home@new') }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.newsletter', 'content.add_new_word')) }}"
			title="{{ __('content.add_new_word') }}"
		>
			<i class="icon-plus green"></i>
		</a>
	</div>
	<div class="btn-group pull-right">
		<a 
			id="go_to_module_settings"
			class="btn"
			href="{{ action('admin.tools.action@module_settings', array('Newsletter')) }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.newsletter', 'content.settings_word')) }}"
			title="{{ __('content.settings_word') }}"
		>
			<i class="icon-cog"></i>
		</a>
	</div>
</div>

@section('newsletter')

	@if($newsletter)
		@if($pagination)
			<div class="row-fluid">
				<div class="span7">
					{{ $pagination }}
				</div>
				<div class="span5" align="right">
					@include('admin.assets.show_by_bar')
				</div>
			</div>
		@endif

		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					@if(in_array('id', $listing_columns))
					<th style="width:5%">
						ID
					</th>
					@endif

					@if(in_array('is_sent', $listing_columns))
					<th style="width:10%;">
						{{ __('newsletter.is_sent') }}
					</th>
					@endif

					<th>
						{{ __('newsletter.title') }}
					</th>

					@if(in_array('subject', $listing_columns))
					<th>
						{{ __('newsletter.subject') }}
					</th>
					@endif

					@if(in_array('to', $listing_columns))
					<th>
						{{ __('newsletter.to') }}
					</th>
					@endif

					@if(in_array('sent_on', $listing_columns))
					<th>
						{{ __('newsletter.sent_on') }}
					</th>
					@endif

					@if(in_array('text', $listing_columns))
					<th>
						{{ __('newsletter.text') }}
					</th>
					@endif

					@if(in_array('created_at', $listing_columns))
					<th>
						{{ __('forms.created_at_word') }}
					</th>
					@endif

					@if(in_array('updated_at', $listing_columns))
					<th>
						{{ __('forms.updated_at_word') }}
					</th>
					@endif

					<th style="width:10%">
						{{ __('forms.action_word') }}
					</th>
				</tr>
			</thead>
			<tbody>
				@include('admin.newsletter.row')
			</tbody>
		</table>

		@if($pagination)
			<div class="row-fluid">
				<div class="span7">
					{{ $pagination }}
				</div>
				<div class="span5" align="right">
					@include('admin.assets.show_by_bar')
				</div>
			</div>
		@endif
		
	@else
		<div class="well well-large" style="text-align: center">
			<h6>No Emails created yet :(</h6>
		</div>
	@endif

@endsection