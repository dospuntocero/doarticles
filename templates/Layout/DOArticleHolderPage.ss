<section class="typography articles" id="$Top.URLSegment">
$Content

<% loop PaginatedArticles %>
	<h2><a href="$Top.URLSegment/$Link">$Title</a></h2>
	<p>$Date</p>
	$Excerpt
	$ImageSet.SetWidth(200)
<% end_loop %>

<% include DOArticlesPagination %>
</section>