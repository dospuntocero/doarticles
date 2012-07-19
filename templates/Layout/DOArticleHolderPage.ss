<section id="content-container" class="typography articles">
	$Content
	<% loop PaginatedArticles %>
		<article>
			<div class="image left">
				$ImageSet.SetWidth(200)
			</div>
			<div class="content">
				<h2><a href="$Link">$Title</a></h2>
				<p>$Date.Nice</p>
				$Excerpt
			</div>
		</article>
	<% end_loop %>
	<% include DOArticlesPagination %>
</section>
<aside id="sidebar">

	<h2>ultimos artículos</h2>
	<ul>
		<% loop LatestArticles %>
		<li><a href="$Link">$Title</a></li>
		<% end_loop %>
	</ul>
	
	<% include GroupedByYear %>
</aside>
