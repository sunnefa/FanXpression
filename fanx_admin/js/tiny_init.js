/***********************
    FanXpression
    ********************
    Copyright 2011 Sunnefa Lind
    
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    ********************
    FanXpression version: Version 1.0.3 Beta
    Current file: fanx_admin/js/tiny_init.js
    First created: 26.8.2011

 *********************/

/**
 * Initiates the TinyMCE WYSIWYG editor
 */

tinyMCE.init({
        mode : "textareas",
		plugins : "searchreplace,contextmenu,wordcount,fullscreen,inlinepopups,media,emotions,preview,spellchecker",
        theme : "advanced",
        theme_advanced_buttons1 : "bold,italic,underline,|,hr,|,justifyleft,justifycenter,justifyright,|,link,unlink,anchor,|,image,media,|,bullist,numlist,|,outdent,indent,|,sub,sup,|,emotions",
        theme_advanced_buttons2 : "fontselect, fontsizeselect,formatselect,|,search,replace,|,removeformat,|,code,fullscreen,preview,|,spellchecker,|,cut,copy,paste,|,undo,redo",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
		relative_urls : false,
		
		// Skin options
        skin : "default",
		height: "300px",
		width: "700px",
file_browser_callback:tinyupload//Hookup tinyupload the the filebrowser call back.
});


