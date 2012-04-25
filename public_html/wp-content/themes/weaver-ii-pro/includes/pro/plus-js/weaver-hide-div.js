/**
 * weaveriip_hidediv, JavaScript specialized hide table row
 *
 * @version 1.1
 * @license GNU Lesser General Public License, http://www.gnu.org/copyleft/lesser.html
 * @author  Bruce Wampler
 */

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
