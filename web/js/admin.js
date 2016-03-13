/* Gallery selectable */
$(".gallery-item.selectable").on("click", function() {
	$(this).toggleClass("selected");
});

/* Image grid focal point */
var $src = $('#grid-source');
var $wrap = $('<div id="grid-overlay"></div>');
var $gsize = 12;

var $width = Math.ceil($src.find('img').prop("width") / $gsize);
var $height = Math.ceil($src.find('img').prop("height") / $gsize);

var fpCoordinates = $("#multimedia-column").val() + "x" + $("#multimedia-row").val();

// create overlay
var $tbl = $('<table></table>');
for (var y = 1; y <= $gsize; y++) {
    var $tr = $('<tr></tr>');
    for (var x = 1; x <= $gsize; x++) {
        var $td = $('<td></td>');
        $td.css('width', $width+'px').css('height', $height+'px').attr('id', y.toString() + "x" + x.toString());
        $tr.append($td);
    }
    $tbl.append($tr);
}

$tbl.find("#" + fpCoordinates).addClass("selected");

// attach overlay
$wrap.append($tbl);
$src.after($wrap);

$('#grid-overlay td').hover(function() {
    $(this).toggleClass('hover');
});

$('#grid-overlay td').click(function() {
	$('#grid-overlay td.selected').toggleClass('selected');
    $(this).toggleClass('selected');

    $("#multimedia-column").val($(this).attr("id").split("x")[0]);
    $("#multimedia-row").val($(this).attr("id").split("x")[1]);
});