@foreach($newsletter as $letter)
	<tr id="letter_row_{{ $letter->id }}">

		@if(in_array('id', $listing_columns))
		<td style="vertical-align: middle;">
			<span class="label label-inverse">{{ $letter->id }}</span>
		</td>
		@endif


		@if(in_array('is_sent', $listing_columns))
		<td style="vertical-align: middle; text-align:right">

			<button 
				id="ajax_send_{{ $letter->id }}" 
				class="btn btn-small" 
				type="button"
				data-post="{{ e('{ "id": "'.$letter->id.'" }') }}" 
				data-link="{{ action('admin.newsletter.action@send') }}"
				data-prevent-follow="true" 
				data-out="send_count_{{ $letter->id }}"
				data-out-popup="{{ e(Utilites::alert(__('newsletter.sent_notification', array('letter' => $letter->title)), 'success')) }}"
				title="{{ __('newsletter.send_letter') }}"
			>
				<i class="icon-envelope-alt icon-large"></i>
				&nbsp;
				<span id="send_count_{{ $letter->id }}" class="label" title="{{ __('newsletter.send_count') }}">{{ $letter->send_count }}</span>
				&nbsp;
				@if($letter->is_sent == 'true')
					<i class="icon-ok-sign icon-large green"></i>
				@else
					<i class="icon-pause"></i>
				@endif
			</button>
		</td>
		@endif

		<td style="vertical-align: middle;">
			<a 	id="go_to_letter_{{ $letter->id }}" 
				href="{{ action('admin.newsletter.home@edit', array($letter->id)) }}" 
				data-title="{{ Utilites::build_title(array('content.application_name', 'content.newsletter')) }} · {{ $letter->title }}"
			>
				{{ $letter->title }}
			</a>
		</td>

		@if(in_array('subject', $listing_columns))
		<td style="vertical-align: middle;">
			{{ $letter->subject }}
		</td>
		@endif

		@if(in_array('to', $listing_columns))
		<td style="vertical-align: middle;">
			@if(stripos($letter->to, ','))
				
				@foreach(explode(',', $letter->to) as $to)
					
					<span class="label label-info">{{ $to }}</span>

				@endforeach

			@else
				<span class="label label-info">$letter->to</span>
			@endif
		</td>
		@endif

		@if(in_array('sent_on', $listing_columns))
		<td style="vertical-align: middle;">
			<small>{{ (is_numeric($letter->sent_on)) ? date('h:i d M Y', $letter->sent_on) : $letter->sent_on }}</small>
		</td>
		@endif

		@if(in_array('text', $listing_columns))
		<td class="ellipsis">
			<small>{{ substr(strip_tags($letter->text), 0, 150) }}</small>
		</td>
		@endif

		@if(in_array('created_at', $listing_columns))
		<td style="vertical-align: middle;">
			<small>{{ (is_numeric($letter->created_at)) ? date('Y-m-d h:i', $letter->created_at) : $letter->created_at }}</small>
		</td>
		@endif

		@if(in_array('updated_at', $listing_columns))
		<td style="vertical-align: middle;">
			<small>{{ (is_numeric($letter->updated_at)) ? date('Y-m-d h:i', $letter->updated_at) : $letter->updated_at }}</small>
		</td>
		@endif

		<td style="vertical-align: middle;">
			<div class="btn-group">
				<a 	id="go_to_btn_letter_{{ $letter->id }}" 
					href="{{ action('admin.newsletter.home@edit', array($letter->id)) }}" 
					class="btn btn-small" 
					data-title="{{ Utilites::build_title(array('content.application_name', 'content.newsletter')) }} · {{ $letter->title }}" 
				>
						<i class="icon-edit icon-large"></i>
				</a> 

				<a 	href="{{ action('admin.newsletter.home@preview', array($letter->id)) }}" 
					class="btn btn-small"
					target="_blank"
					title="{{ __('content.preview_word') }}"
				>
					<i class="icon-eye-open"></i>
				</a>

				<button 
					id="ajax_duplicate_{{ $letter->id }}"
					class="btn btn-small"
					type="button"
					data-link="{{ action('admin.tools.action@duplicate_row') }}" 
					data-post="{{ e('{ "id": "'.$letter->id.'", "table_name": "Newsletter"}') }}" 
					data-message="{{ e(__('forms.duplicate_warning', array('item' => $letter->title))) }}" 
					data-prevent-follow="true" 
					data-out="null"
					data-out-popup="true"
				>
					<i class="icon-copy icon-large blue"></i>
				</button>

				<button 
					id="ajax_delete_{{ $letter->id }}"
					class="btn btn-small"
					type="button"
					data-link="{{ action('admin.newsletter.action@delete') }}" 
					data-post="{{ e('{ "id": "'.$letter->id.'", "delete": "delete"}') }}" 
					data-message="{{ e(__('forms.delete_warning', array('item' => $letter->title))) }}" 
					data-prevent-follow="true" 
					data-out="letter_row_{{ $letter->id }}"
					data-remove="letter_row_{{ $letter->id }}"
					data-out-popup="true"
				>
					<i class="icon-trash icon-large red"></i>
				</button> 
			</div>
		</td>
	</tr>
@endforeach