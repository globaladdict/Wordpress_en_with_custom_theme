jQuery(document).ready(function() {
jQuery('a[title]').mouseover(function(e) {
var tip = jQuery(this).attr('title');
jQuery(this).attr('title','');
}).mouseout(function() {
jQuery(this).attr('title',jQuery('.tipBody').html());
});
});
