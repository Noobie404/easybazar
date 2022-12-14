var infobox_count = 0;
! function(o) {
    o.fn.infoBox = function(i) {
        var t = {
            bg_color: "black",
            text_color: "white",
            width: 200,
            position: "below"
        };
        i = o.extend(t, i), o(this).css({
            cursor: "default"
        }), org_width = o(this).width(), 0 == i.width && (box_width = 200), infobox_count++, box_width = i.width, org_width < 200 && (box_width = o(this).width());
        var e = o(this).position();
        o(this).css({
            width: box_width,
            padding: "10px",
            display: "block"
        }), box_width += 20;
        var n = o(this).height() + 30;
        o(this).css("padding", "0px"), o(this).css("display", "inline");
        var h = o(this).html();
        o(this).html("&#9432;"), one_line_height = o(this).height(), temp_point_1 = box_width - 20, temp_point_2 = box_width - 15, temp_point_3 = box_width - 10, box_height_new = n - 10, "above" == i.position ? o(this).append("<div id='infobox-" + infobox_count + "'><a>" + h + "</a><svg id='infobox-svg-default-" + infobox_count + "' width='" + box_width + "' height='" + n + "'><path d='M0 0 L" + box_width + " 0 L" + box_width + " " + box_height_new + " L20 " + box_height_new + " L15 " + n + " L10 " + box_height_new + " L0 " + box_height_new + " Z' /></svg><svg id='infobox-svg-reverted-" + infobox_count + "' width='" + box_width + "' height='" + n + "'><path d='M0 0 L" + box_width + " 0 L" + box_width + " " + box_height_new + " L" + temp_point_1 + " " + box_height_new + " L" + temp_point_2 + " " + n + " L" + temp_point_3 + " " + box_height_new + " L0 " + box_height_new + " Z' /></svg></div>") : o(this).append("<div id='infobox-" + infobox_count + "'><a>" + h + "</a><svg id='infobox-svg-default-" + infobox_count + "' width='" + box_width + "' height='" + n + "'><path d='M0 10 L10 10 L15 0 L20 10 L" + box_width + " 10 L" + box_width + " " + n + " L0 " + n + " Z' /></svg><svg id='infobox-svg-reverted-" + infobox_count + "' width='" + box_width + "' height='" + n + "'><path d='M0 10 L" + temp_point_1 + " 10 L" + temp_point_2 + " 0 L" + temp_point_3 + " 10 L" + box_width + " 10 L" + box_width + " " + n + " L0 " + n + " Z' /></svg></div>"), "above" == i.position ? (above_height = 0 - n - one_line_height, above_height_a = -10) : (above_height = 0, above_height_a = 0), o("#infobox-" + infobox_count).css({
            position: "absolute",
            "margin-left": e.left,
            display: "none",
            "margin-top": above_height
        }), o("#infobox-svg-default-" + infobox_count).css({
            fill: i.bg_color
        }), o("#infobox-svg-reverted-" + infobox_count).css({
            fill: i.bg_color
        }), o("#infobox-" + infobox_count + " a").css({
            position: "absolute",
            padding: "10px",
            "padding-top": "20px",
            color: i.text_color,
            "margin-top": above_height_a
        }), e = o(this).position(), e.left = e.left - 15, reverted_margin_left = box_width - 30, o("body").append("<script>$(" + o(this).attr("id") + ").mouseover(function(e){$('#infobox-" + infobox_count + "').css({'display':'block','position':'absolute','margin-left':" + e.left + "});check_width=" + box_width + "+e.pageX;screen_width=screen.width;if(screen_width>check_width){$('#infobox-svg-default-" + infobox_count + "').css({'display':'inline-block'});$('#infobox-svg-reverted-" + infobox_count + "').css({'display':'none'});}else{$('#infobox-svg-default-" + infobox_count + "').css({'display':'none'});$('#infobox-svg-reverted-" + infobox_count + "').css({'display':'inline-block','margin-left':-" + reverted_margin_left + "});$('#infobox-" + infobox_count + " a').css({'margin-left':-" + reverted_margin_left + "});}});</script>"), o("body").append("<script>$(" + o(this).attr("id") + ").mouseout(function(){$('#infobox-" + infobox_count + "').css({'display':'none'});});</script>")
    }
}(jQuery);
