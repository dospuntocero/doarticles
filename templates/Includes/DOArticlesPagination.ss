<% if PaginatedArticles.MoreThanOnePage %>
	<% if PaginatedArticles.NotFirstPage %>
		<a class="prev" href="$PaginatedArticles.PrevLink"><% _t('DOArticlesPagination.PREV','Prev') %></a>
	<% end_if %>
	<% loop PaginatedArticles.Pages %>
		<% if CurrentBool %>
			$PageNum
			<% else %>
			<% if Link %>
				<a href="$Link">$PageNum</a>
			<% else %>
			...
			<% end_if %>
		<% end_if %>
	<% end_loop %>
	<% if PaginatedArticles.NotLastPage %>
		<a class="next" href="$PaginatedArticles.NextLink"><% _t('DOArticlesPagination.NEXT','Next') %></a>
	<% end_if %>
<% end_if %>
