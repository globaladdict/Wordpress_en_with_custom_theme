/**
 * Weaver II JavaScript support Library
 *
 * @version 1.1
 * @license GNU Lesser General Public License, http://www.gnu.org/copyleft/lesser.html
 * @author  Bruce Wampler
 */
/* weaveriip_hide_css, JavaScript specialized hide table row */
function weaveriip_ToggleDIV(his, me, show, hide, text) {
    if (his.style.display != 'none') {
        his.style.display = 'none';
        if (text == 'img') {
            me.innerHTML = '<img src="' + show + '" />';
        } else {
            me.innerHTML = '<span class="weaveriip_showhide_show">' + show + '</span>';
        }
    } else {
        his.style.display = '';
        if (text == 'img') {
            me.innerHTML = '<img src="' + hide + '" />';
        } else {
            me.innerHTML = '<span class="weaveriip_showhide_hide">' + hide + '</span>';
        }
    }
}

function weaverii_ToggleMenu(his, me, show, hide,slide) {
    if (his.style.display != 'none') {
        me.innerHTML = show;
        if (slide)
            jQuery(his).slideUp('normal');
        else
            his.style.display = 'none';
    } else {
        me.innerHTML = hide;
        if (slide)
            jQuery(his).slideDown('normal');
        else
            his.style.display = 'block';

    }
}

/* Weaver iFrame fixer */
function weaverii_fixVideo(myframe,vert)
{
var iframeW =  myframe.clientWidth;
myframe.height= iframeW * vert ;
}
