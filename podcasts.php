<?php
// Podcasts plugin, https://github.com/datenstrom/yellow-plugins/tree/master/blog
// Copyright (c) 2013-2017 Datenstrom, https://datenstrom.se
// This file may be used and distributed under the terms of the public license.

class YellowPodcasts
{
	const VERSION = "0.7.3";
	var $yellow;			//access to API
	
	// Handle initialisation
	function onLoad($yellow)
	{
		$this->yellow = $yellow;
		$this->yellow->config->setDefault("podcastsLocation", "");
		$this->yellow->config->setDefault("podcastsNewLocation", "@title");
		$this->yellow->config->setDefault("podcastsPagesMax", "1000");
		$this->yellow->config->setDefault("podcastsPaginationLimit", "15");
	}
	
	// Handle page content parsing of custom block
	function onParseContentBlock($page, $name, $text, $shortcut)
	{
		$output = null;
		if($name=="podcastsarchive" && $shortcut)
		{
			list($location, $pagesMax) = $this->yellow->toolbox->getTextArgs($text);
			if(empty($location)) $location = $this->yellow->config->get("podcastsLocation");
			if(strempty($pagesMax)) $pagesMax = $this->yellow->config->get("podcastsPagesMax");			
			$podcasts = $this->yellow->pages->find($location);
			$pages = $this->getPodcastsPages($location);
			$page->setLastModified($pages->getModified());
			$months = array();
			foreach($pages as $page) if(preg_match("/^(\d+\-\d+)\-/", $page->get("published"), $matches)) ++$months[$matches[1]];
			if(count($months))
			{
				if($pagesMax!=0) $months = array_slice($months, -$pagesMax);
				uksort($months, "strnatcasecmp");
				$months = array_reverse($months);
				$output = "<div class=\"".htmlspecialchars($name)."\">\n";
				$output .= "<ul>\n";
				foreach($months as $key=>$value)
				{
					$output .= "<li><a href=\"".$podcasts->getLocation(true).$this->yellow->toolbox->normaliseArgs("published:$key")."\">";
					$output .= htmlspecialchars($this->yellow->text->normaliseDate($key))."</a></li>\n";
				}
				$output .= "</ul>\n";
				$output .= "</div>\n";
			} else {
				$page->error(500, "Podcastsarchive '$location' does not exist!");
			}
		}
		if($name=="Blogauthors" && $shortcut)
		{
			list($location, $pagesMax) = $this->yellow->toolbox->getTextArgs($text);
			if(empty($location)) $location = $this->yellow->config->get("podcastsLocation");
			if(strempty($pagesMax)) $pagesMax = $this->yellow->config->get("podcastsPagesMax");
			$podcasts = $this->yellow->pages->find($location);
			$pages = $this->getPodcastsPages($location);
			$page->setLastModified($pages->getModified());
			$authors = array();
			foreach($pages as $page) if($page->isExisting("author")) foreach(preg_split("/\s*,\s*/", $page->get("author")) as $author) ++$authors[$author];
			if(count($authors))
			{
				$authors = $this->yellow->lookup->normaliseUpperLower($authors);
				if($pagesMax!=0 && count($authors)>$pagesMax)
				{
					uasort($authors, "strnatcasecmp");
					$authors = array_slice($authors, -$pagesMax);
				}
				uksort($authors, "strnatcasecmp");
				$output = "<div class=\"".htmlspecialchars($name)."\">\n";
				$output .= "<ul>\n";
				foreach($authors as $key=>$value)
				{
					$output .= "<li><a href=\"".$podcasts->getLocation(true).$this->yellow->toolbox->normaliseArgs("author:$key")."\">";
					$output .= htmlspecialchars($key)."</a></li>\n";
				}
				$output .= "</ul>\n";
				$output .= "</div>\n";
			} else {
				$page->error(500, "Blogauthors '$location' does not exist!");
			}
		}
		if($name=="podcastsrecent" && $shortcut)
		{
			list($location, $pagesMax) = $this->yellow->toolbox->getTextArgs($text);
			if(empty($location)) $location = $this->yellow->config->get("podcastsLocation");
			if(strempty($pagesMax)) $pagesMax = $this->yellow->config->get("podcastsPagesMax");
			$podcasts = $this->yellow->pages->find($location);
			$pages = $this->getPodcastsPages($location);
			$pages->sort("published", false);
			$page->setLastModified($pages->getModified());
			if(count($pages))
			{
				if($pagesMax!=0) $pages->limit($pagesMax);
				$output = "<div class=\"".htmlspecialchars($name)."\">\n";
				$output .= "<ul>\n";
				foreach($pages as $page)
				{
					$output .= "<li><a href=\"".$page->getLocation(true)."\">".$page->getHtml("titleNavigation")."</a></li>\n";
				}
				$output .= "</ul>\n";
				$output .= "</div>\n";
			} else {
				$page->error(500, "Podcastsrecent '$location' does not exist!");
			}
		}
		if($name=="podcastsrelated" && $shortcut)
		{
			list($location, $pagesMax) = $this->yellow->toolbox->getTextArgs($text);
			if(empty($location)) $location = $this->yellow->config->get("podcastsLocation");
			if(strempty($pagesMax)) $pagesMax = $this->yellow->config->get("podcastsPagesMax");
			$podcasts = $this->yellow->pages->find($location);
			$pages = $this->getPodcastsPages($location);
			$pages->similar($page->getPage("main"));
			$page->setLastModified($pages->getModified());
			if(count($pages))
			{
				if($pagesMax!=0) $pages->limit($pagesMax);
				$output = "<div class=\"".htmlspecialchars($name)."\">\n";
				$output .= "<ul>\n";
				foreach($pages as $page)
				{
					$output .= "<li><a href=\"".$page->getLocation(true)."\">".$page->getHtml("titleNavigation")."</a></li>\n";
				}
				$output .= "</ul>\n";
				$output .= "</div>\n";
			} else {
				$page->error(500, "Podcastsrelated '$location' does not exist!");
			}
		}
		if($name=="podcaststags" && $shortcut)
		{
			list($location, $pagesMax) = $this->yellow->toolbox->getTextArgs($text);
			if(empty($location)) $location = $this->yellow->config->get("podcastsLocation");
			if(strempty($pagesMax)) $pagesMax = $this->yellow->config->get("podcastsPagesMax");
			$podcasts = $this->yellow->pages->find($location);
			$pages = $this->getPodcastsPages($location);
			$page->setLastModified($pages->getModified());
			$tags = array();
			foreach($pages as $page) if($page->isExisting("tag")) foreach(preg_split("/\s*,\s*/", $page->get("tag")) as $tag) ++$tags[$tag];
			if(count($tags))
			{
				$tags = $this->yellow->lookup->normaliseUpperLower($tags);
				if($pagesMax!=0 && count($tags)>$pagesMax)
				{
					uasort($tags, "strnatcasecmp");
					$tags = array_slice($tags, -$pagesMax);
				}
				uksort($tags, "strnatcasecmp");
				$output = "<div class=\"".htmlspecialchars($name)."\">\n";
				$output .= "<ul>\n";
				foreach($tags as $key=>$value)
				{
					$output .= "<li><a href=\"".$podcasts->getLocation(true).$this->yellow->toolbox->normaliseArgs("tag:$key")."\">";
					$output .= htmlspecialchars($key)."</a></li>\n";
				}
				$output .= "</ul>\n";
				$output .= "</div>\n";
			} else {
				$page->error(500, "Podcaststags '$location' does not exist!");
			}
		}
		return $output;
	}
	
	// Handle page parsing
	function onParsePage()
	{
		if($this->yellow->page->get("template")=="podcastspages")
		{
			$pages = $this->getPodcastsPages($this->yellow->page->location);
			$pagesFilter = array();
			if($_REQUEST["tag"])
			{
				$pages->filter("tag", $_REQUEST["tag"]);
				array_push($pagesFilter, $pages->getFilter());
			}
			if($_REQUEST["author"])
			{
				$pages->filter("author", $_REQUEST["author"]);
				array_push($pagesFilter, $pages->getFilter());
			}
			if($_REQUEST["published"])
			{
				$pages->filter("published", $_REQUEST["published"], false);
				array_push($pagesFilter, $this->yellow->text->normaliseDate($pages->getFilter()));
			}
			$pages->sort("published");
			$pages->pagination($this->yellow->config->get("podcastsPaginationLimit"));
			if(!$pages->getPaginationNumber()) $this->yellow->page->error(404);
			if(!empty($pagesFilter))
			{
				$title = implode(' ', $pagesFilter);
				$this->yellow->page->set("titleHeader", $title." - ".$this->yellow->page->get("sitename"));
				$this->yellow->page->set("titlePodcasts", $this->yellow->text->get("podcastsFilter")." ".$title);
			}
			$this->yellow->page->setPages($pages);
			$this->yellow->page->setLastModified($pages->getModified());
			$this->yellow->page->setHeader("Cache-Control", "max-age=0");
		}
		if($this->yellow->page->get("template")=="podcasts")
		{
			$location = $this->yellow->config->get("podcastsLocation");
			if(empty($location)) $location = $this->yellow->lookup->getDirectoryLocation($this->yellow->page->location);
			$podcasts = $this->yellow->pages->find($location);
			$this->yellow->page->setPage("podcasts", $podcasts);
		}
	}
	
	// Handle content file editing
	function onEditContentFile($page, $action)
	{
		if($page->get("template")=="podcasts") $page->set("pageNewLocation", $this->yellow->config->get("podcastsNewLocation"));
	}

	// Return blog pages
	function getPodcastsPages($location)
	{
		$pages = $this->yellow->pages->clean();
		$podcasts = $this->yellow->pages->find($location);
		if($podcasts)
		{
			if($location==$this->yellow->config->get("podcastsLocation"))
			{
				$pages = $this->yellow->pages->index(!$podcasts->isVisible());
			} else {
				$pages = $podcasts->getChildren(!$podcasts->isVisible());
			}
			$pages->filter("template", "podcasts");
		}
		return $pages;
	}
}

$yellow->plugins->register("podcasts", "YellowPodcasts", YellowPodcasts::VERSION);
?>
