/**
 * td-padding.js
 *
 * Helps td to judge whether padding needs to be added or not depending on a tag inside of td.
 */
var td = document.getElementsByTagName("td");
for (var i = 0, max = td.length; i < max; i++) {
	var a = document.getElementsByTagName('a');
	if (td[i].contains(a[0])) {
		td[i].className = 'has-a';
	}
}
