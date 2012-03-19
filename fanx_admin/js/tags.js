/* 
 * This is tags.js
 * Created on 19.9.2011
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 */

$(document).ready(function () {
    var old_tags = $('#old_tags').val();
    
    if(old_tags != "") {
        old_tags = old_tags.split(',');
    }

    $('#new_tags').tagEditor({
        items: old_tags,
        completeOnSeparator: true
    });
});


