<div class="content">
<?php $yellow->snippet("sidebar") ?>
<div class="main">
<?php $yellow->page->set("entryClass", "entry") ?>
<?php if($yellow->page->isExisting("tag")): ?>
<?php foreach(preg_split("/\s*,\s*/", $yellow->page->get("tag")) as $tag) { $yellow->page->set("entryClass", $yellow->page->get("entryClass")." tag-".$yellow->toolbox->normaliseArgs($tag, false)); } ?>
<?php endif ?>
<div class="<?php echo $yellow->page->getHtml("entryClass") ?>">
<div class="entry-title"><h2><?php echo $yellow->page->getHtml("titleContent") ?></h2></div>
<div class="entry-meta"><i class="fa fa-calendar"></i>  <?php echo $yellow->page->getDateHtml("published") ?> <?php echo $yellow->text->getHtml("blogBy") ?>  <i class="fa fa-user-md"></i>  <?php $authorCounter = 0; foreach(preg_split("/\s*,\s*/", $yellow->page->get("author")) as $author) { if(++$authorCounter>1) echo ", "; echo "<a href=\"".$yellow->page->getPage("blog")->getLocation(true).$yellow->toolbox->normaliseArgs("author:$author")."\">".htmlspecialchars($author)."</a>"; } ?></div>
<div class="entry-content"><?php echo $yellow->page->getContent() ?></div>
<span class="links-class"><?php echo $yellow->page->getExtra("links") ?></span>
<?php if($yellow->page->isExisting("tag")): ?>
<div class="entry-tags">
<i class="fa fa-tags"></i> <?php// echo $yellow->text->getHtml("blogTag") ?> <?php $tagCounter = 0; foreach(preg_split("/\s*,\s*/", $yellow->page->get("tag")) as $tag) { if(++$tagCounter>1) echo ", "; echo "<a href=\"".$yellow->page->getPage("blog")->getLocation(true).$yellow->toolbox->normaliseArgs("tag:$tag")."\"><h3>".htmlspecialchars($tag)."</h3></a>"; } ?>
</div>
<?php endif ?>
<?php echo $yellow->page->getExtra("comments") ?>
</div>
</div>
</div>
