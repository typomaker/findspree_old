/**
 * Created by albert on 11.03.15.
 */

Helper.string.truncate = function (string, length, ending) {
    if (!ending)ending = '...';
    if (!length)length = 40;
    var regexp = new RegExp("^.{0," + length + "}[^\\s]{0,10}");
    var newStr = regexp.exec(string)[0];
    if (newStr.length < string.length)newStr += ending;
    return newStr;
};
Helper.string.prune = function (str, length, pruneStr) {
    length = ~~length;
    pruneStr = pruneStr != null ? String(pruneStr) : '...';

    if (str.length <= length) return str;

    var tmpl = function (c) {
            return c.toUpperCase() !== c.toLowerCase() ? 'A' : ' ';
        },
        template = str.slice(0, length + 1).replace(/.(?=\W*\w*$)/g, tmpl); // 'Hello, world' -> 'HellAA AAAAA'

    if (template.slice(template.length - 2).match(/\w\w/))
        template = template.replace(/\s*\S+$/, '');
    else
        template = Helper.string.rtrim(template.slice(0, template.length - 1));

    return (template + pruneStr).length > str.length ? str : str.slice(0, template.length) + pruneStr;
};
Helper.string.rtrim = function (str, charlist) {
    charlist = !charlist ? ' \s\xA0' : charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\$1');
    var re = new RegExp('[' + charlist + ']+$', 'g');
    return str.replace(re, '');
};
Helper.html.avatar = function (user, size, options) {
    size = size || 60;
    options = options || {};
    var keyName, keySizes, $el, keySizesInverted, cssStyleName;
    keySizes = {
        60: 'sm',
        120: 'md',
        240: 'lg'
    };
    keySizesInverted = _.invert(keySizes);
    keyName = size;
    if (!keySizesInverted.hasOwnProperty(keyName)) {
        for (var sizeAvailable in keySizes) {
            cssStyleName = sizeAvailable + 'x';
            keyName = keySizes[sizeAvailable];
            if (sizeAvailable >= size) {
                break;
            }
        }
    } else {
        size = keySizesInverted[keyName];
        cssStyleName = size + 'x';
    }
    if (user.avatar && user.avatar[keyName] && user.avatar[keyName].length != 0) {
        $el = $('<img/>', options);
        $el.addClass('ava');
        $el.attr('src', user.avatar[keyName]);
        return $el[0].outerHTML;
    } else {
        var c = size / 2;
        var char1 = user.username.substr(0, 1).toLowerCase();
        var char2 = user.username.substr(1, 1).toLowerCase();
        var posCount = Helper.string.chars.length;
        var pos = Helper.string.chars.indexOf(char1);
        var pos2 = Helper.string.chars.indexOf(char2);
        pos = pos == -1 ? 0 : pos;
        pos2 = pos2 == -1 ? 0 : pos2;
        var count = Helper.html.colorsAvatar.length;
        var colorKey = Math.floor((pos + pos2) / (posCount * 2) * count);
        var backgroundCol = Helper.html.colorsAvatar[colorKey][0];
        var textCol = Helper.html.colorsAvatar[colorKey][1];
        $el = $('<div/>', options);
        $el.addClass('ava');
        $el.addClass('fake-avatar');
        $el.addClass('fake-avatar-' + cssStyleName);
        $el.css('color', "#" + textCol);
        $el.css('background', "#" + backgroundCol);
        $el.text(char1 + char2);
        return $el[0].outerHTML;
    }
};
Helper.text.toHtml = function (text) {
    _.each(Helper.bbRulesQueue,function(e){
        var regexp = e[0];
        var replace = e[1];
        text = text.replace(new RegExp(regexp,'gm'),replace);
    });
    //text = text
    //    .replace(/(\r\n|\n\r|\r|\n)/gm, " <br/> ")
    //    .replace(/\[b\](.*?)\[\/b\]/gm, "<strong>$1</strong>")
    //    .replace(/\[i\](.*?)\[\/i\]/gm, "<i>$1</i>")
    //    .replace(/\[u\](.*?)\[\/u\]/gm, "<span style=\"text-decoration: underline\">$1</span>")
    //    .replace(/\[s\](.*?)\[\/s\]/gm, "<span style=\"text-decoration:line-through\">$1</span>")
    //    .replace(/\[center\](.*?)\[\/center\]/gm, "<div style=\"text-align: center\">$1</div>")
    //    .replace(/\[url\s+(.*?)\](.*?)\[\/url\]/gm, "<a href='$1'>$2</a>")
    //    .replace(/\[img\](.*?)\[\/img\]/gm, "<img src='$1'/>")
    //    .replace(/\[em\](.*?)\[\/em\]/gm, "<em>$1</em>")
    //    .replace(/\[small\](.*?)\[\/small\]/gm, "<small>$1</small>")
    //    .replace(/\[h\s*([3-6])\](.*?)\[\/h\]/gm, "<h$1>$2</h$1>")
    //    .replace(/\[ol\](.*?)\[\/ol\]/gm, "<ol>$1</ol>")
    //    .replace(/\[li\](.*?)\[\/li\]/gm, "<li>$1</li>")
    //    .replace(/\[ul\](.*?)\[\/ul\]/gm, "<ul>$1</ul>")
    //    //youtube https://youtu.be/oPzjEoGNYbM
    //    .replace(/https?:\/\/youtu\.be\/([^\s])/gm, '<iframe width="420" height="315" class="center-block" src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>')
    //    //чистка
    //    //.replace(/<\/li>.*?<li>/gm, "</li><li>")
    //    .replace(/<ul>.*?<li>/gm, "<ul><li>")
    //    .replace(/<ol>.*?<li>/gm, "<ol><li>")
    //    .replace(/<\/li>.*?<\/ul>/gm, "</li></ul>")
    //    .replace(/<\/li>.*?<\/ol>/gm, "</li></ol>")
    //    .replace(/\[\/br\]/gm, "</br>")
    return text;
};

//$inputTag.tagsinput({
//    tagClass: 'label label-primary',
//    maxTags: 10,
//    maxChars: 15,
//    confirmKeys: [13, 44, 32, 46, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 45, 47, 58, 59, 60, 61, 62, 63, 64, 91, 92, 93, 94, 96, 126, 186, 187, 188, 189, 190, 191, 192, 219, 220, 221, 222],
//    trimValue: true
//});
//$inputTag.on('beforeItemAdd', function (event) {
//    var re = /[^A-ZА-Яё_0-9]+/gi;
//    var str = event.item;
//    var m;
//    if (re.exec(str) !== null) {
//        event.cancel = true;
//        var value = event.item.replace(re, "");
//        $inputTag.tagsinput('add', value);
//    }
//});

$(document).on('click', '.event-control-subscribe', function () {
    var $e = $(this);
    var url = $(this).data('remote');
    var oldClass = $e.attr('class');
    if ($e.hasClass('md-add-circle-outline')) {
        $e.removeClass('md-add-circle-outline').addClass('md-add-circle');
    } else {
        $e.removeClass('md-add-circle').addClass('md-add-circle-outline');
    }
    $.getJSON(url, function (data) {
        //$e.trigger('fs.event.subscribed');
        if (data.error) {
            $e.attr('class', oldClass);
        }
        //$.growl({ title: "Growl", message: data.message , location: "tc"});
    });
});

var cookieHelloMessage = $.cookie('hello-message');
if (!cookieHelloMessage && App.user.isGuest) {
    $('#hello').modal('show');
    $.cookie('hello-message', 1);
}