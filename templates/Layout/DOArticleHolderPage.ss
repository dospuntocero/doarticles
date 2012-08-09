<section id="content-container" class="typography articles">
	$Content
	<% if PaginatedArticles %>
		<% loop PaginatedArticles %>
			<article>
				<div class="image left">
					$ImageSet.SetWidth(200)
				</div>
				<div class="content">
					<h2><a href="">$Title</a></h2>
					<p>$Date.Nice</p>
					$Excerpt
				</div>
			</article>
		<% end_loop %>
		<% include DOArticlesPagination %>
	<% else %>
		<% _t('DOArticleHolderPage.NOARTICLES','there is no articles yet ') %>
	<% end_if %>
</section>

<aside id="sidebar">
	<h2>ultimos artículos</h2>
	<ul>
		<% loop LatestArticles %>
		<li><a href="">$Title</a></li>
		<% end_loop %>
	</ul>
	
	<% include Archive %>
</aside>
