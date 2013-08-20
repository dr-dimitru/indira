<article id="page_{{ $page_data->id }}">
	<section id="section1">
		<header class="section-header">
			<!-- EDITABLE -->
			<div class="editable">
				<h1><sup><a href="#section1">#</a></sup> Demo Header</h1>
				<small>Demo Subheader</small>

				<div class="alert alert-info">To login go to <a href="/admin">Admin Side</a>. For first login use for password and login <strong>admin</strong>, more info at <a href="http://indira-cms.com/en/post/How_to_install" target="_blank">How to install</a></div>
			</div>
			<!-- END EDITABLE -->

		</header>
	</section>

	<hr class="no-vertical-margin">

	<section>
		<div class="row">
			<div class="span12">
				
				<!-- EDITABLE -->
				<div class="editable">
					<p>To edit demo page pattern please go to <code>/application/views/page_patterns</code> folder.</p>
					<p>
						You may edit or add new patterns.<br />
						To add new pattern just create new file in folder: <code>/application/views/page_patterns</code><br />
						After you save and upload new page's pattern it automatically will appear in admin side at Pages module.
					</p>
					<strong>Important: you must add ID to parent element of page's pattern as: <code>id="page_&#123;&#123; $page_data->id &#125;&#125;</code></strong>
				</div>
				<!-- END EDITABLE -->

			</div>
		</div>
	</section>

	<hr class="no-vertical-margin">
	
	<section id="section2" class="black-background">
		<header class="section-header">
			<!-- EDITABLE -->
			<div class="editable">
				<h1><sup><a href="#section2">#</a></sup> Demo Header 2</h1>
				<small>Demo Subheader 2</small>
			</div>
			<!-- END EDITABLE -->
		</header>


		<div class="row">
			<!-- EDITABLE -->
			<div class="editable">
				<div class="span6">
					<h2>Editable areas</h2>
					<p style="text-align:justify">To create editable area in page's pattern add class <code>editable</code> to any element</p>
				</div>

				<div class="span6">
					<h2>How to edit page?</h2>
					<p style="text-align:justify">You need to login into Indira's admin side, go to Pages section, create new page, then just click on the lemon</p>
				</div>
			</div>
			<!-- END EDITABLE -->
		</div>

		<hr>

		<div class="row">

			<!-- EDITABLE -->
			<div class="editable">
				<div class="span6">
					<h2>Default pages</h2>
					<p style="text-align:justify">
						By default you have two pages: main and main_mobile and two page's patterns with same names.<br />
						Both of them set as main page of your website - you may delete, or unpublish those pages to hide them<br />
					</p>
				</div>

				<div class="span6">
					<h2>Difference between mobile and desktop pages</h2>
					<p style="text-align:justify">Difference is in possibility to create pages with different content for different screens.</p>
				</div>
			</div>
			<!-- END EDITABLE -->

		</div>
	</section>
</article>