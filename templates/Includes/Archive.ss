<h2><% _t('GroupedByYear.ARTICLESBYMONTH','Articles by Month') %></h2>
<% loop GroupedArticlesByDate %>
	<ul>
	    <li><a href="{$Top.Link()}archive/$Year">$Year</a>
	        <% if Children %><br />
            <% loop Children %>
							<a href="{$Top.Link()}archive/$Year/$Month">$Month</a>
            <% end_loop %>
	        <% end_if %>
	    </li>
	</ul>
<% end_loop %>
