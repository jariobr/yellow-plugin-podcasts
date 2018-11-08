# Podcasts Yellow plugin

Podcasts Yellow plugin. The podcasts is available on your website as http://website/podcasts/ or other directory. To show the podcasts on the home page, go to your content folder and paste the podcasts page.txt in the 1-home folder. To create a new podcasts page, add a new file to the podcasts folder. [--more--] 

* See demo here http://jario.com.br/podcasts/   
* See sitemap this here http://jario.com.br/podcast/page:podcast.xml   
* See human sitemap here http://jario.com.br/podcast/  


### How to install plugin

1. Download and install Datenstrom Yellow.  
2. Download plugin. If you are using Safari, right click and select 'Download file as'.   
3. Download audio plugin. (Is requerid).
4. Download podcastfeed plugin. 
5. Copy podcasts.zip, podcastfeed.zip and audio.zip into your system/plugins folder.  

To uninstall delete the plugin files.


### How to use a podcasts

Set Published and other settings at the top of a page. Use Tag to group similar pages together. You can use to add a page break at the desired spot. Learn more.
How to show podcasts information


### Directory page.txt


```
---
Title: @Podcasts
Description: 
Template: podcastspages
TemplateNew: podcasts
---
```


### Podcasts pages 

For iTunes and Google Podcast are obrigatory these entry in all news pages podcasts:  

	Mediafile: http://domain/media/audio/*.mp3
	Duration: 00:00:00
  
Duration is same as the time audio (ogg/mp3/mpeg). The file mp3 is friendly for streamers.  	

	
```
---
Title: Podcasts page
Published: @datetime
Author: @username
Template: podcasts
Tag: Example
Mediafile: http://domain/media/audio/*.mp3
Duration: 00:00:00
---
```

### Podcasts Shortcuts

You can use shortcuts to show information about the podcasts:

[podcastsauthors] for a list of authors  
[podcaststags] for a list of tags  
[podcastsarchive] for a list of months  
[podcastsrelated] for a list of pages, related to the current page  
[podcastspages] for a list of pages, alphabetic order   
[podcastschanges] for a list of pages, published order   

### Arguments
The following arguments are available, all but the first argument are optional:   

Location = podcasts location  
PagesMax = number of pages, 0 for unlimited  
Author = show pages by a specific author, [podcastspages] or [podcastschanges] only  
Tag = show pages with a specific tag, [podcastspages] or [podcastschanges] only   
How to configure a podcasts   

The following settings can be configured in file system/config/config.ini:   

BlogLocation = podcasts location  
BlogNewLocation = podcasts location for new page   
BlogPagesMax = number of pages   
BlogPaginationLimit = number of entries to show per page


For example, open config.ini, copy and past the lines bellow:

PodcastLocation: 
PodcastNewLocation: @title
PodcastPagesMax: 20
PodcastPaginationLimit: 15

PodcastLocation: /podcastfeed/
PodcastFileXml: podcastfeed.xml
PodcastFilter: podcasts
PodcastPaginationLimit: 30
PodcastMimeType: audio/mpeg
PodcastImageUrl: /media/images/icon-podcast.jpg
PodcastImageWidth: 144
PodcastImageHeight: 144
PodcastKeywords: tags appear in itunes and google
PodcastExplicit: no
PodcastItunesBlock: no
PodcastCategory: Music
PodcastSubcategory: Podcast


### Files config
The following files can be configured:
   
system/config/page-new-podcasts.txt = content file for new podcasts page  
system/themes/snippets/content-podcasts.php = source code for podcasts page   
system/themes/snippets/content-podcastspages.php = source code for main page   


### Shortcuts Examples

Showing latest podcasts pages:   

  
[podcastschanges /podcasts/]   
[podcastschanges /podcasts/ 5]   
[podcastschanges /podcasts/ 20]  
  
Showing list of tags:   

[podcaststags /podcasts/]  
[podcaststags /podcasts/ 5]   
[podcaststags /podcasts/ 20]   

Showing list of pages:   
  
[podcastspages /podcasts/]  
[podcastspages /podcasts/ 5 ]   
[podcastspages /podcasts/ 20 - exampleTag]  
     
	
