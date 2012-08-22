<section class="typography articles">
<% with Article %>
	<article>
	<h1>$Title</h1>
	<div class="image">
		$Image.SetWidth(290)
	</div>
	<p class="date">$Date</p>
	$Content
	</article>
<% end_with %>
</section>