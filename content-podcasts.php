<div class="breadcrambs"><?php echo $yellow->page->getExtra("breadcrumbs") ?></div>
<div class="content">
<?php $yellow->snippet("sidebar") ?>
<div class="main" role="main">
<?php $yellow->page->set("entryClass", "entry") ?>
<?php if($yellow->page->isExisting("tag")): ?>
<?php foreach(preg_split("/\s*,\s*/", $yellow->page->get("tag")) as $tag) { $yellow->page->set("entryClass", $yellow->page->get("entryClass")." tag-".$yellow->toolbox->normaliseArgs($tag, false)); } ?>
<?php endif ?>
<section>
<article itemscope itemtype="http://schema.org/RadioSeries">
<div class="<?php echo $yellow->page->getHtml("entryClass") ?>">
	<a class="none" itemprop="url" href="<?php echo $yellow->page->getUrl() ?>">
	<span itemprop="name"><?php echo $yellow->page->getHtml("titleContent") ?></span></a>
<header itemprop="episode" itemscope itemtype="http://schema.org/RadioEpisode">
<hgroup itemprop="name" class="entry-title"><h2 class="podcasts" itemprop="headline"><?php echo $yellow->page->getHtml("titleContent") ?></h2></hgroup>
  <div class="none" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
    <?php if($this->yellow->config->isExisting("PodcastImageUrl")): ?>
	<figure>
	<img itemprop="url" src="<?php echo $this->yellow->config->get("PodcastImageUrl") ?>" alt="<?php echo $yellow->page->getHtml("titleContent") ?>" />
    <meta itemprop="width" content="3000"/>
    <meta itemprop="height" content="3000"/>
	</figure>
	<?php endif ?>
  </div> 
  <div class="none" itemprop="publication" itemscope itemtype="http://schema.org/BroadcastEvent">
		<div itemprop="publishedOn" itemscope itemtype="http://schema.org/BroadcastService">
		<time> 
  	    <?php if($yellow->page->isExisting("published")): ?><meta itemprop="startDate" content="<?php echo $this->yellow->page->getDateFormattedHtml("published", DATE_ATOM) ?>" /><?php endif ?></time> 
		</div>
		<div itemprop="publication" itemscope itemtype="http://schema.org/OnDemandEvent">
		<time>
		 <?php if($yellow->page->isExisting("published")): ?><meta itemprop="startDate" content="<?php echo $this->yellow->page->getDateFormattedHtml("published", DATE_ATOM) ?>"/><?php endif ?>  
		</time>
		</div>
	</div>
	
	<div class="none" itemscope itemtype="http://schema.org/AudioObject">
      <span itemprop="name"><?php echo $yellow->page->getHtml("titleContent") ?></span>
    <meta itemprop="encodingFormat" content="audio/mpeg" />
     <meta itemprop="contentUrl" content="<?php echo $yellow->page->getHtml("mediafile") ?>" />
    <span class="description">
          <meta itemprop="duration" content="<?php echo $yellow->page->getHtml("duration") ?>" />
          <span itemprop="description"><?php echo $yellow->page->getHtml("description") ?></span>
    </span>
    </div>

<div itemprop="name" class="entry-meta"><span class="meta-head"><span itemprop="datePublished" content="<?php echo $yellow->page->getDateHtml("published") ?>"><?php echo $yellow->page->getDateHtml("published") ?></span> 
<span itemprop="name"><?php $authorCounter = 0; foreach(preg_split("/\s*,\s*/", $yellow->page->get("author")) as $author) { if(++$authorCounter>1) echo ", "; echo "<a href=\"".$yellow->page->getPage("podcasts")->getLocation(true).$yellow->toolbox->normaliseArgs("author:$author")."\">".htmlspecialchars($author)."</a>"; } ?></span></span>
</div>
</header>
</div>
<div  itemprop="articleBody" class="entry-content"><?php echo $yellow->page->getContent() ?></div>

<footer>
<div class="author">

 <div itemprop="author" itemscope itemtype="https://schema.org/Person"> 
 <span itemprop="name"><?php echo $yellow->page->getHtml("author") ?></span>
 
 <span class="avatar">
 <?php if($yellow->text->isExisting("photo")): ?>
 <figure>
 	<img itemprop="image" src="<?php echo $this->yellow->text->getHtml("photo") ?>" alt="Photo of <?php echo $yellow->page->getHtml("author") ?>"/>
 </figure><?php endif ?>
 </span>
  <?php if($yellow->text->isExisting("authorDescription")): ?><span class="authordescription" itemprop="description"><?php echo $this->yellow->text->getHtml("authorDescription") ?></span><?php endif ?>
  
   <span itemprop="creator" itemscope itemtype="http://schema.org/Person">
		<a itemprop="sameAs" href="https://plus.google.com/<?php echo $this->yellow->text->getHtml("googlePlus") ?>">Gplus</a>
		<a itemprop="sameAs" href="https://facebook.com/<?php echo $this->yellow->text->getHtml("facebook") ?>">Facebook</a>
		<a itemprop="sameAs" href="https://youtube.com/<?php echo $this->yellow->text->getHtml("youtube") ?>">Youtube</a>
		<a itemprop="sameAs" href="https://twitter.com/<?php echo $this->yellow->text->getHtml("twitter") ?>">Twitter</a>
		<a itemprop="sameAs" href="https://github.com/<?php echo $this->yellow->text->getHtml("github") ?>">Github</a>
    </span>
 </div>
</div>

<?php echo $yellow->page->getExtra("links") ?>
<?php if($yellow->page->isExisting("tag")): ?>
<div class="entry-tags" itemscope itemtype="http://schema.org/CollectionPage">
<span class="meta-tags"> <?php $tagCounter = 0; foreach(preg_split("/\s*,\s*/", $yellow->page->get("tag")) as $tag) { if(++$tagCounter>1) echo ", "; echo "<span itemprop=\"headline\"><a href=\"".$yellow->page->getPage("podcasts")->getLocation(true).$yellow->toolbox->normaliseArgs("tag:$tag")."\">".htmlspecialchars($tag)."</a></span>"; } ?></span>
<span class="ping"><a href="http://pingomatic.com/ping/?title=<?php echo $yellow->page->getHtml("titleHeader") ?>&blogurl=<?php echo $yellow->page->getUrl() ?>&chk_weblogscom=on&chk_blogs=on&chk_feedburner=on&chk_newsgator=on&chk_myyahoo=on&chk_pubsubcom=on&chk_blogdigger=on&chk_weblogalot=on&chk_newsisfree=on&chk_topicexchange=on&chk_google=on&chk_tailrank=on&chk_skygrid=on&chk_collecta=on&chk_superfeedr=on&chk_audioweblogs=on&chk_rubhub=on&chk_a2b=on&chk_blogshares=on" target="_blank">[&#961;]</a></span>
</div>

<?php if($yellow->text->isExisting("nameOrganization")): ?>
<div class="none" itemscope itemtype="http://schema.org/LocalBusiness">
<address>
	<div itemprop="name"><?php echo $this->yellow->text->getHtml("nameOrganization") ?></div>
	<span itemprop="description"><?php echo $this->yellow->text->getHtml("organizationDescription") ?></span>
	<span itemprop="email"><?php echo $this->yellow->text->getHtml("email") ?></span>
	<span itemprop="telephone"><?php echo $this->yellow->text->getHtml("telephone") ?></span>
	<span itemprop="url"><?php echo $this->yellow->text->getHtml("url") ?></span>

	<div itemtype="http://schema.org/GeoCoordinates" itemscope="" itemprop="geo">
		<meta itemprop="latitude" content="<?php echo $this->yellow->text->getHtml("latitude") ?>" />
		<meta itemprop="longitude" content="<?php echo $this->yellow->text->getHtml("longitude") ?>" />
	</div>
	
	<div itemtype="http://schema.org/PostalAddress" itemscope="" itemprop="address">
		<div itemprop="postOfficeBoxNumber"><?php echo $this->yellow->text->getHtml("postOfficeBoxNumber") ?></div>
		<div><span itemprop="addressLocality"><?php echo $this->yellow->text->getHtml("addressLocality") ?></span>, <span itemprop="addressRegion"><?php echo $this->yellow->text->getHtml("addressRegion") ?></span> <span itemprop="postalCode"><?php echo $this->yellow->text->getHtml("postalCode") ?></span></div>
	</div>
</address>
</div>
<?php endif ?>	
</footer>
</article>
<?php endif ?>
<?php echo $yellow->page->getExtra("comments") ?>
</section>
</div>
</div>
</div>
