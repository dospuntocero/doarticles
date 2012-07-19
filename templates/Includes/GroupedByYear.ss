<h2><% _t('GroupedByYear.ARTICLESBYMONTH','Articles by Month') %></h2>
<% loop GroupedArticlesByDate %>
	<ul>
	    <li><a href="{$Top.Link()}archive/$Year">$Year</a>
	        <% if Children %>
	        <ul>
	            <% loop Children %>
	            <li><a href="{$Top.Link()}$Year/$Month">$Month</a></li>
	            <% end_loop %>
	        </ul>

	        <% end_if %>
	    </li>
	</ul>
<% end_loop %>
