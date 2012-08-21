<section class="typography articles">
<% with Article %>
	<article>
	<h1>$Title</h1>
	$ImageSet.SetWidth(290)
	<p class="date">$Date</p>
	$Content
	</article>
<% end_with %>
</section>