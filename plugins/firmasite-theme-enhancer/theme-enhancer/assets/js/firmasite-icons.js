/*global tinymce:true */

tinymce.PluginManager.add('firmasiteicons', function(editor) {

	function showDialog() {
		var gridHtml, x, y, win;

		function getParentTd(elm) {
			while (elm) {
				if (elm.nodeName == 'TD') {
					return elm;
				}

				elm = elm.parentNode;
			}
		}

		gridHtml = '<table role="presentation" cellspacing="0" class="mce-charmap"><tbody>';

		var width = 25;
		for (y = 0; y < 20; y++) {
			gridHtml += '<tr>';

			for (x = 0; x < width; x++) {
				var chr = iconscharmap[y * width + x];
				if(chr)
				gridHtml += '<td title="' + chr[0] + '"><div tabindex="-1" title="' + chr[0] + '" role="button">' +
					'<i class="' + chr[0] + '"></i>' + '</div></td>';
			}

			gridHtml += '</tr>';
		}


		gridHtml += '</tbody></table>';

		var iconscharmapPanel = {
			type: 'container',
			html: gridHtml,
			onclick: function(e) {
				var target = e.target;

				if (target.tagName == 'TD') {
					target = target.firstChild.firstChild;
				}

				if (target.tagName == 'DIV') {
					target = target.firstChild;
				}

				if (target.tagName == 'I') {
					console.log(target.className);
					editor.execCommand('mceInsertContent', false, '&nbsp;<i class="' + target.className + '"></i>&nbsp;');

					if (!e.ctrlKey) {
						win.close();
					}
				}
			}
		};

		win = editor.windowManager.open({
			title: firmasiteicons.title,
			spacing: 10,
			padding: 10,
			items: [
				iconscharmapPanel
			],
			buttons: [
				{text: "Close", onclick: function() {
					win.close();
				}}
			]
		});
	}

	editor.addButton('firmasiteicons', {
        image : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAB60lEQVQ4jaWSP0iWURTGf+/3fWr+CVKwloISsnCtsaXamoSgKYyGlsAhGp0LChqEBjehIQgaHVpqaYqMBqF6dQk0CpQ+TOu7773nT8P7+vqp1dIDh3PP4Z7nPg/nZgATs0uOREgBUsCrXJ+lqM4d8vmZjC60JmaX/NXUKQDUDFVDzUiqiJZ1FCGlBMCN4qfnT+/XJA2KX/wPGqTOgdfFDDPHzFEzrKrLi7KHoOUpEGIpr5Fl3M2H2UqwKdCOZQ5FQiVgMWAXp2lduOWHSGxPT2QtUkDUALiTj/BofAOg9F+pSiKkJHUWEUJrgMkHi94oCRRRpV0KQbSUrGqIKqqKu2FqXH+ec/XZp24LnVrB91jZrF9XRKTMVW+wJ2Owp3eXgNhBVAHYiFBE4c3qD+befmXxyya4M9SE2+dHuXxyiMdXypUXNUEKNVuIiWsL3/j4eQ3cwAxM2VZ4+HqVF3k/k2dHGOxt8mG7AJpkZ27e8x2CtUvThJX36FYb3MG0JPEqujB+/CjLzSM08vmZjFRA7GAx4JLKXZvuxr7hbuz5131zqz6WNtBOZesfgydGD/NyPdLqbmoKrFg/3tOHm+ImuBngBwiW18uVNbqbx3qNTAtMCkwibvrH4R2MDQ/stQBw7snK3yf24d3U6ew37ldlcL67V5kAAAAASUVORK5CYII=',
		tooltip: firmasiteicons.title,
		onclick: showDialog
	});

	editor.addMenuItem('firmasiteicons', {
        image : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAB60lEQVQ4jaWSP0iWURTGf+/3fWr+CVKwloISsnCtsaXamoSgKYyGlsAhGp0LChqEBjehIQgaHVpqaYqMBqF6dQk0CpQ+TOu7773nT8P7+vqp1dIDh3PP4Z7nPg/nZgATs0uOREgBUsCrXJ+lqM4d8vmZjC60JmaX/NXUKQDUDFVDzUiqiJZ1FCGlBMCN4qfnT+/XJA2KX/wPGqTOgdfFDDPHzFEzrKrLi7KHoOUpEGIpr5Fl3M2H2UqwKdCOZQ5FQiVgMWAXp2lduOWHSGxPT2QtUkDUALiTj/BofAOg9F+pSiKkJHUWEUJrgMkHi94oCRRRpV0KQbSUrGqIKqqKu2FqXH+ec/XZp24LnVrB91jZrF9XRKTMVW+wJ2Owp3eXgNhBVAHYiFBE4c3qD+befmXxyya4M9SE2+dHuXxyiMdXypUXNUEKNVuIiWsL3/j4eQ3cwAxM2VZ4+HqVF3k/k2dHGOxt8mG7AJpkZ27e8x2CtUvThJX36FYb3MG0JPEqujB+/CjLzSM08vmZjFRA7GAx4JLKXZvuxr7hbuz5131zqz6WNtBOZesfgydGD/NyPdLqbmoKrFg/3tOHm+ImuBngBwiW18uVNbqbx3qNTAtMCkwibvrH4R2MDQ/stQBw7snK3yf24d3U6ew37ldlcL67V5kAAAAASUVORK5CYII=',
		text: firmasiteicons.title,
		onclick: showDialog,
		context: 'insert'
	});
});