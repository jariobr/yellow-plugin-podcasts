<div class="content">
<?php $yellow->snippet("sidebar") ?>
<div class="main">
<?php if($yellow->page->isExisting("titlePodcasts")): ?>
<h1><?php echo $yellow->page->getHtml("titlePodcasts") ?></h1>
<?php endif ?>
<?php foreach($yellow->page->getPages() as $page): ?>
<?php $page->set("entryClass", "entry") ?>
<?php if($page->isExisting("tag")): ?>
<?php foreach(preg_split("/\s*,\s*/", $page->get("tag")) as $tag) { $page->set("entryClass", $page->get("entryClass")." tag-".$yellow->toolbox->normaliseArgs($tag, false)); } ?>
<?php endif ?>
<div class="<?php echo $page->getHtml("entryClass") ?>">
<div class="entry-title"><h2><a href="<?php echo $page->getLocation(true) ?>"><?php echo $page->getHtml("title") ?></a></h2></div>
<div class="entry-meta"> <i class="fa fa-calendar"></i> <?php echo $page->getDateHtml("published") ?> <?php echo $yellow->text->getHtml("By") ?> <i class="fa fa-user-md"></i> <?php $authorCounter = 0; foreach(preg_split("/\s*,\s*/", $page->get("author")) as $author) { if(++$authorCounter>1) echo ", "; echo "<a href=\"".$yellow->page->getLocation(true).$yellow->toolbox->normaliseArgs("author:$author")."\">".htmlspecialchars($author)."</a>"; } ?> </div>
<div class="entry-content"><?php echo $yellow->toolbox->createTextDescription($page->getContent(), 0, false, "<!--more-->", " <a href=\"".$page->getLocation(true)."\">".$yellow->text->getHtml("Continue reading →")."</a><p> <hr></p>") ?></div>
</div>
<?php endforeach ?>
<?php $yellow->snippet("pagination", $yellow->page->getPages()) ?>
</div>
</div>
<?php /*
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="ca-pub-3110269164927978"
     data-ad-slot="6754919111"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
*/?>