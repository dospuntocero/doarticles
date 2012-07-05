<section id="content-container" class="typography articles">
	$Content
	testes
	<% loop Articles %>
		<article>
			<div class="image left">
				$ImageSet.SetWidth(200)
			</div>
			<div class="content">
				<h2><a href="$Top.URLSegment/$Link">$Title</a></h2>
				<p>$Date.Nice</p>
				$Excerpt
			</div>
		</article>
	<% end_loop %>
	<% include DOArticlesPagination %>
</section>
