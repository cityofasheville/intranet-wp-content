tinymce.create('tinymce.plugins.firmasiteicons', {
    init : function(ed, url) {
      ed.addCommand('mceFirmasiteicons', function() {
        ed.windowManager.open({
          file : url + '/firmasite-icons-charmap.php',
          width : 550 + parseInt(ed.getLang('example.delta_width', 0)),
          height : 260 + parseInt(ed.getLang('example.delta_height', 0)),
          inline : 1
        }, {
          plugin_url : url, // Plugin absolute URL
          some_custom_arg : 'custom arg' // Custom argument
        });
      })

      // Register example button
      ed.addButton('firmasiteicons', {
        title : firmasiteicons.title,
        cmd : 'mceFirmasiteicons',
        image : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAB60lEQVQ4jaWSP0iWURTGf+/3fWr+CVKwloISsnCtsaXamoSgKYyGlsAhGp0LChqEBjehIQgaHVpqaYqMBqF6dQk0CpQ+TOu7773nT8P7+vqp1dIDh3PP4Z7nPg/nZgATs0uOREgBUsCrXJ+lqM4d8vmZjC60JmaX/NXUKQDUDFVDzUiqiJZ1FCGlBMCN4qfnT+/XJA2KX/wPGqTOgdfFDDPHzFEzrKrLi7KHoOUpEGIpr5Fl3M2H2UqwKdCOZQ5FQiVgMWAXp2lduOWHSGxPT2QtUkDUALiTj/BofAOg9F+pSiKkJHUWEUJrgMkHi94oCRRRpV0KQbSUrGqIKqqKu2FqXH+ec/XZp24LnVrB91jZrF9XRKTMVW+wJ2Owp3eXgNhBVAHYiFBE4c3qD+befmXxyya4M9SE2+dHuXxyiMdXypUXNUEKNVuIiWsL3/j4eQ3cwAxM2VZ4+HqVF3k/k2dHGOxt8mG7AJpkZ27e8x2CtUvThJX36FYb3MG0JPEqujB+/CjLzSM08vmZjFRA7GAx4JLKXZvuxr7hbuz5131zqz6WNtBOZesfgydGD/NyPdLqbmoKrFg/3tOHm+ImuBngBwiW18uVNbqbx3qNTAtMCkwibvrH4R2MDQ/stQBw7snK3yf24d3U6ew37ldlcL67V5kAAAAASUVORK5CYII=',
      });
    }
});


    tinymce.PluginManager.add('firmasiteicons', tinymce.plugins.firmasiteicons);
 
