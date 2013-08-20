<section class="black-background">
	<header class="section-header">
		<h1>{{ __('templates::content.search.by_tag') }}</h1>
		<span class="tag label">{{ $search_value }}</span>
	</header>
</section>

<hr class="no-vertical-margin">

<section itemscope itemtype="http://schema.org/SearchResultsPage">
	@include('templates::search.listing')
</section>

<section class="black-background">
	<footer>

	</footer>
</section>