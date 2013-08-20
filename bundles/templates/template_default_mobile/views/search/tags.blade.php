<section>
	<header class="section-header">
		<h1>{{ __('templates::content.search.by_tag') }}</h1>
		<span class="tag label label-danger">{{ $search_value }}</span>
	</header>
</section>

<hr class="no-vertical-margin">

<section class="black-background" itemscope itemtype="http://schema.org/SearchResultsPage">
	@include('templates::search.listing')
</section>