/**
 * iconscharmap.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

tinyMCEPopup.requireLangPack();

tinyMCEPopup.onInit.add(function() {
	tinyMCEPopup.dom.setHTML('iconscharmapView', rendericonscharmapHTML());
	addKeyboardNavigation();
});

function addKeyboardNavigation(){
	var tableElm, cells, settings;

	cells = tinyMCEPopup.dom.select("a.iconscharmaplink", "iconscharmapgroup");

	settings ={
		root: "iconscharmapgroup",
		items: cells
	};
	cells[0].tabindex=0;
	tinyMCEPopup.dom.addClass(cells[0], "mceFocus");
	if (tinymce.isGecko) {
		cells[0].focus();		
	} else {
		setTimeout(function(){
			cells[0].focus();
		}, 100);
	}
	tinyMCEPopup.editor.windowManager.createInstance('tinymce.ui.KeyboardNavigation', settings, tinyMCEPopup.dom);
}

function rendericonscharmapHTML() {
	var charsPerRow = 10, tdWidth=40, tdHeight=40, i;
	var html = '<div id="iconscharmapgroup" aria-labelledby="iconscharmap_label" tabindex="0" role="listbox">'+
	'<table role="presentation" border="0" cellspacing="1" cellpadding="0" width="' + (tdWidth*charsPerRow) + 
	'"><tr height="' + tdHeight + '">';
	var cols=-1;

	for (i=0; i<iconscharmap.length; i++) {
		var previewCharFn;

			cols++;
			icon = '<i class="' + iconscharmap[i][0] + '"></i>';
			previewCharFn = 'previewChar(\'' + iconscharmap[i][0] + '\');';
			html += ''
				+ '<td class="iconscharmap">'
				+ '<a class="iconscharmaplink" role="button" onmouseover="'+previewCharFn+'" href="javascript:void(0)" onclick="insertChar(\'' + iconscharmap[i][0] + '\');" onclick="return false;" onmousedown="return false;" title="">'
				+ icon
				+ '</a></td>';
			if ((cols+1) % charsPerRow == 0)
				html += '</tr><tr height="' + tdHeight + '">';
	 }

	if (cols % charsPerRow > 0) {
		var padd = charsPerRow - (cols % charsPerRow);
		for (var i=0; i<padd-1; i++)
			html += '<td width="' + tdWidth + '" height="' + tdHeight + '" class="iconscharmap">&nbsp;</td>';
	}

	html += '</tr></table></div>';
	html = html.replace(/<tr height="20"><\/tr>/g, '');

	return html;
}

function insertChar(chr) {
	tinyMCEPopup.execCommand('mceInsertContent', false, '&nbsp;<i class="' + chr + '"></i>&nbsp;');

	// Refocus in window
	if (tinyMCEPopup.isWindow)
		window.focus();

	tinyMCEPopup.editor.focus();
	tinyMCEPopup.close();
}

function previewChar(codeN) {
	var elmV = document.getElementById('iconBig');
	var elmN = document.getElementById('iconCode');

	elmV.innerHTML = '<i class="' + codeN + '"></i>';
	elmN.innerHTML = codeN;
}
