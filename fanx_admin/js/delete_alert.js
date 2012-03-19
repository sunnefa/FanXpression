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
    Current file: fanx_admin/js/delete_alert.js
    First created: 26.8.2011

 *********************/

/**
 * Initiates a JavaScript confirm box when a delete link is clicked
 */
function post_delete() {
        $('a.delete').click(function (event) {
           var new_page = $(this).attr('href');
           event.preventDefault();
           var conf = confirm('Are you sure? You cannot undo this action!');
           if(conf == true) {
               window.location.replace(new_page);
           } else {
               window.location.reload();
           }
        }); 
    }
    
    $(document).ready(function() {
  	post_delete();
        console.log($('a.delete'));
});

