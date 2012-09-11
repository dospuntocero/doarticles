<% if FeaturedArticles %>
<section id="FeaturedArticles" class="container">
	<% loop FeaturedArticles %>
		<article class="grid_1-4">
			<img src="<% control MainImage %><% control CroppedImage(200,200) %>$URL<% end_control %><% end_control %>" alt="$Title"/>
			$Title
		</article>
	<% end_loop %>
</div>
<% end_if %>
