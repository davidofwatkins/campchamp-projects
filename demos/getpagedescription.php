<?php error_reporting(E_ALL); ?>

<?php 
	function myErrorHandler($errno, $errstr, $errfile, $errline) {
		//echo "<p style='color: red'>Error: " . $errstr . "</p>";
	}
	set_error_handler("myErrorHandler");
?>

<style>

	body {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 13px;
	}
	
	a { color: blue; }

	#url {
		font-size: 20px;
		width: 600px;
		padding: 5px;
	}
	
	.description {
		width: 700px;
		padding: 10px;
		background: rgb(223, 252, 223);
		border: 1px solid green;
		margin: 10px;
	}
	
	p#welcometext {
		font-size: 15px;
		max-width: 900px;
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	}
	
	p#examples {
		background: rgb(236, 236, 238);
		padding: 5px;
	}
	p#examples a {
		margin: auto 10px;
	}
	
</style>

<!-- Related Question: http://stackoverflow.com/q/2941477/477632 -->

<h1>Get Page Description</h1>

<p id="welcometext">This page will get the description of any URL entered into the box below. If a &lt;meta&gt; description is not available, it will attempt to find a description for the Facebook and Google+ social plugins (Twitter could be added too). If no description is specified, it will provide the first paragraph of text with more than 15 words.</p>

<p id="examples">
	Examples:
	<a href="<?= $_SERVER["php_self"] ?>?url=http://www.nytimes.com/2013/07/29/business/media/two-ad-giants-in-merger-deal-chasing-google.html">Two Ad Giants... (NYT)</a>
	<a href="<?= $_SERVER["php_self"] ?>?url=http://www.reviewopedia.com/care-com-reviews">Care.com Review</a>
	<a href="<?= $_SERVER["php_self"] ?>?url=http://accessburlington.com">Access Burlington</a>
	<a href="<?= $_SERVER["php_self"] ?>?url=http://wordpress.org/plugins/wordpress-seo/">WordPress SEO by Yoast Plugin</a>
	<a href="<?= $_SERVER["php_self"] ?>?url=http://www.youtube.com/watch?v=k-6hftSsUvU">Vermont Character - a Maple story (YouTube)</a>
	<a href="<?= $_SERVER["php_self"] ?>?url=http://www.benjerry.com/company/history">History of Ben &amp; Jerry's</a>
	<a href="<?= $_SERVER["php_self"] ?>?url=http://davidofwatkins.com">David Watkins</a>
	
</p>

<form method="get" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
	<input type="text" name="url" id="url" value="<?= $_GET["url"] ?>" placeholder="Enter URL here..." />
	<input type="submit" value="Go" />
</form>

<?php
	
	if (isset($_GET["url"])) {
		
		try {
			$descriptions = getDescriptionFromURL($_GET["url"]);
			
			echo '<h3>Meta Description</h3><div class="description">' . $descriptions["meta"] . '</div>';
			echo '<h3>Google+ Meta Description</h3><div class="description">' . $descriptions["google"] . '</div>';
			echo '<h3>Open Graph (Facebook) Meta Description</h3><div class="description">' . $descriptions["og"] . '</div>';
			echo '<h3>Snippet From Page (first paragraph with 15+ words)</h3><div class="description">' . $descriptions["page_snippet"] . '</div>';
			
			echo '<p><a href="' . $_GET["url"] . '" target="_blank">Visit page...</a></p>';
		}
		catch(Exception $e) { echo '<p style="color: red">' . $e->getMessage() . '</p>'; }
	}
	
	function getDescriptionFromURL($url) {
		
		$url = urldecode($url);
		
		$string = file_get_contents($url);
		if (!$string) {
			throw new Exception('Error: cannot connect.');
		}
		
		if (substr($string, 0, 4) == "%PDF")
			throw new Exception("Error: page is a PDF");
		
		//Fix some common encoding problems (like fancy "")
		$string = str_replace("â€¦", "...", $string);
		$string = str_replace("â€“", "&ndash;", $string);
		$string = str_replace("â€™", "'", $string);
		$string = str_replace("â€œ", '"', $string);
		$string = str_replace("â€", '"', $string);
		$string = str_replace("Â", '&nbsp;', $string);
		
		$doc = new DOMDocument();
		$doc->loadHTML($string);
		
		$metas = $doc->getElementsByTagName("meta");
		
		$results = array();
		
		foreach ($metas as $element) {
			if ($element->getAttribute("name") == "description") {
				$results["meta"] = $element->getAttribute("content");
			}
			else if ($element->getAttribute("itemprop") == "description") {
				$results["google"] = $element->getAttribute("content");
			}
			else if ($element->getAttribute("property") == "og:description") {
				$results["og"] = $element->getAttribute("content");
			}
		}
		
		$body = $doc->getElementsByTagName("body")->item(0);
		if (!$body)
			throw new Exception("Error: webpage has no body element");
		$divs = $body->getElementsByTagName("p"); //Get all <p> within the <body>
		foreach ($divs as $element) {
			$text = $element->textContent;
			$numWords = str_word_count($text);
			
			if ($numWords >= 15) {
				$results["page_snippet"] = $text;
				break;
			}
		}
		
		return $results;
	}
?>