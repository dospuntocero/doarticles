<aside id="sidebar">
	<% if Menu(3) %>
	<nav class="secondary">
		<h3>Categorías</h3>
		<ul>
			<% loop Menu(3) %>
				<li>
					<a href="$Link">$Title ($DOArticles.Count)</a>
				</li>
			<% end_loop %>
		</ul>
	</nav>
	
	<% end_if %>
	<% if Tags %>
	<nav class="secondary">
		<h3>Tagcloud</h3>
		<ul>
			<% loop Tags %>
				<li><a href="$Link">$Title <% with Articles %>($Count)<% end_with %></a></li>
			<% end_loop %>
		</ul>
	</nav>
	
	<% end_if %>
	<% if LatestArticles %>
	<nav class="secondary">
		<h2><% _t('DOArticleHolderPage.LATESTARTICLES','Latest Articles') %></h2>
		<ul>
			<% loop LatestArticles %>
				<li><a href="$Link">$Title</a></li>
			<% end_loop %>
		</ul>
	</nav>
	
	<% end_if %>
	
</aside>
