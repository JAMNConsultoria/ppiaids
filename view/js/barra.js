/***********************
Accessible Selectbox by Christian Heilmann
http://onlinetools.org/articles/unobtrusivejavascript/chapter1.html
***********************/

function send(f)
{
	var chosen;
	chosen = f.selectbox_goto.options[f.selectbox_goto.selectedIndex].value;
	
	if (chosen != "null") {
		window.open(chosen);
		return false;
	}
	else {
		return false;
	}	
}  