<section id="content-container" class="typography articles">
	$Content
	<% if PaginatedArticles %>
		<% loop PaginatedArticles %>
			<article>
				<div class="image left">
					$Image.SetWidth(200)
				</div>
				<div class="content">
					<h2><a href="article/read/$Link">$Title</a></h2>
					<p>$Date.Nice</p>
					<p><% _t('DOArticleHolderPage.TAGGEDAS','Tagged as') %>
						<% loop Tags %>
							<a href="article/bytag/$URLSegment">$Title</a><% if Last %><% else %>, <% end_if %>
						<% end_loop %>
					</p>
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
	<h2><% _t('DOArticleHolderPage.LATESTARTICLES','Latest Articles') %></h2>
	<ul>
		<% loop LatestArticles %>
		<li><a href="$Link">$Title</a></li>
		<% end_loop %>
	</ul>
	
</aside>
