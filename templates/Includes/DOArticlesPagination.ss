<% if PaginatedArticles %>
<% if PaginatedArticles.MoreThanOnePage %>
	<div class="pagination">
	  <ul>	  
			<% if PaginatedArticles.NotFirstPage %>
				<li>
					<a href="$PaginatedArticles.PrevLink"><% _t('DOArticlesPagination.PREV','Prev') %></a>
				</li>
			<% end_if %>
			<% loop PaginatedArticles.Pages %>
				<% if CurrentBool %>
					<li class="active">
						<a href="#">$PageNum</a>
					<% else %>
					<% if Link %>
						<li>
							<a href="$Link">$PageNum</a>
					<% else %>
						<li>
							...
					<% end_if %>
				<% end_if %>
			</li>
			<% end_loop %>

			<% if PaginatedArticles.NotLastPage %>
			<li>
				<a href="$PaginatedArticles.NextLink"><% _t('DOArticlesPagination.NEXT','Next') %></a>
			</li>
			<% end_if %>
	  </ul>
	</div>
<% end_if %>
<% end_if %>