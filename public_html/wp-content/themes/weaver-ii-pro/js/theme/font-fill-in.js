function copy_google_3_4()
  {
    var cur = jQuery('#fonts_google_font_list').val();
    var g3 = jQuery('#font_google_link').val();
    var g4 = jQuery('#font_google_font_css').val();
    var add = cur + g3 + '<!-- ' + g4 + " -->\n";
    jQuery('#fonts_google_font_list').val(add);
  }

  function weaverii_generate_font_css() {
    var font_font_family = jQuery("#font_font_family").val();
    var font_font_weight = jQuery("#font_font_weight").val();
    var font_font_style = jQuery("#font_font_style").val();
    var font_font_variant = jQuery("#font_font_variant").val();
    var font_font_size = jQuery("#font_font_size").val();
    var font_font_size_value = jQuery("#font_font_size_value").val();
    var font_font_size_units = jQuery("#font_font_size_units").val();
    var g3 = jQuery('#font_google_link').val();
    var g4 = jQuery('#font_google_font_css').val();
    if ((g3 || g4) && font_font_family && font_font_family != 'Google Web Font' ) {
	alert('strong>Problem with Font Specifications: '
	+ '<em>Both</em> Standard Font Family and Google Web Font Family specified. Please clear one or the other.');
	return;
    }

    var css = '{';
    if (g4 && g3 && font_font_family == 'Google Web Font' ) {
	css += g4;
    } else if (font_font_family) {
	$css += 'font-family:' + $font_font_family + ';';
    }

    if (font_font_weight) css += 'font-weight:' + font_font_weight + ';';
    if (font_font_style) css += 'font-style:' + font_font_style + ';';
    if (font_font_variant) css += 'font-variant:' + font_font_variant + ';';

    if (font_font_size_value) css += 'font-size:' + font_font_size_value + font_font_size_units + ';';
    else if (font_font_size) css += 'font-size:' + font_font_size + ';';

    css += '}';
    jQuery('#font_generate_font_css').val(css);
    /* font_generate_font_css */
  }
  
  function move_content(sourceid, destinationid)
  {
    var cur = jQuery('#'+destinationid).val();
    var src = cur + jQuery('#'+sourceid).val() + "\n";
    jQuery("#"+destinationid).val(src);
  }
