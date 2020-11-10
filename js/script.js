window.onload = function() {
	const spinner = document.getElementById('loading');
	console.log('OK');
	spinner.classList.add('loaded');
}

function changeColorW(idname)
{
	var link = document.createElement('link');
	link.href = './css/style_white.css';
	link.rel = 'stylesheet';
	link.type = 'text/css';
	var head = document.getElementsByTagName('head')[0];
	var last = head.lastElementChild;
	var str = last.href.slice(-9);
	if (str == 'style.css'){
		head.appendChild(link);
	} else {
		last.remove();
		head.appendChild(link);
	}
}

function changeColorB(idname)
{
	var head = document.getElementsByTagName('head')[0];
	var last = head.lastElementChild;
	var str = last.href.slice(-9);
	if (str != 'style.css'){
		last.remove();
	}
}
