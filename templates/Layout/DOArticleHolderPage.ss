<section id="content-container" class="typography articles">
	$Content
	<% loop DOArticles %>
		<a href="articles/view/$URLSegment" title="$Title">$Title</a>
	<% end_loop %>
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
      // something for no articles here
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
