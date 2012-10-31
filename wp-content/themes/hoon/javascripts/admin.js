jQuery(document).ready(function() {
  var templates = [];
  
  templates.chat =
  ['<ul class="dialogue">',
    '  <li class="odd"><span class="label">Person A:</span> Said something</li>',
    '  <li class="even"><span class="label gray-2">Person B:</span> Said something</li>',
    '  <li class="odd"><span class="label">Person A:</span> Said something</li>',
    '  <li class="even"><span class="label gray-2">Person B:</span> Said something</li>',
  '</ul>'];

  templates.quote =
    ['<blockquote><p>Put your quote here…</p>',
    '<p><cite>Put your source here.</cite></p>',
    '</blockquote>'];

  jQuery('#post-formats-select input').click(function(){
    if ( ! templates[jQuery(this).val()] ) { return; }

    var value = templates[jQuery(this).val()].join('\n');

    if( ( ! tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden() ) && ! jQuery('textarea#content').val()) {
      jQuery('textarea#content').val(value);
    } else if ( tinyMCE.activeEditor && ! tinyMCE.activeEditor.isHidden() && ! tinyMCE.activeEditor.getContent() ) {
      tinyMCE.execCommand('mceInsertRawHTML', false, value);
    }
  });
});
