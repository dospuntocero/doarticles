<section id="content-container" class="typography articles">
	<% if Action = bytag %>
		<h1><% _t('DOArticlesCategoryPage.TAGGEDAS','Tagged as: ') %>'$tagName'</h1>
	<% else %>		
		<h1>$Title</h1>
	<% end_if %>

	$Content
	<% if PaginatedArticles %>
		<% loop PaginatedArticles %>
			<article>
				<div class="image left">
					$Image.SetWidth(200)
				</div>
				<div class="content">
					<h2><a href="$Link">$Title</a></h2>
					<p>$Date.Nice</p>
					<% if Tags %>
					<p><% _t('DOArticleHolderPage.TAGGEDAS','Tagged as') %>
						<% loop Tags %>
							<a href="$URLSegment">$Title</a><% if Last %><% else %>, <% end_if %>
						<% end_loop %>
					</p>					
					<% end_if %>
					<% if Excerpt %>
						$Excerpt
					<% else %>
						$Content.LimitCharacters(100)
					<% end_if %>
					
				</div>
			</article>
		<% end_loop %>
		<% include DOArticlesPagination %>
	<% else %>
		<% _t('DOArticleHolderPage.NOARTICLES','there is no articles yet ') %>
	<% end_if %>
</section>
<% include DOArticleSidebar %>