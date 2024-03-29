/**
 * Created by albert on 09.03.15.
 */
(function () {
    var el;
    el = {
        $map: $('#map'),
        $subscribe: $('#subscribe'),
        $mainContent: $('#event-info')
    };
    var refreshContent = function () {
        $.get('', function (data) {
            el.$mainContent.html(data)
        })
    };
    ymaps.ready(function () {
        var center = el.$map.data('coordinates');
        var description = el.$map.data('description');
        var title = el.$map.data('title');
        var params = {
            center: center,
            zoom: 12,
            controls: []
        };
        var map = new ymaps.Map('map', params);
        map.geoObjects.add(new ymaps.Placemark(center, {
            openBalloonOnClick: false
        }, {
            preset: 'islands#dotIcon',
            iconColor: '#3b5998'
        }))
    });
    el.$subscribe.on('click', function () {
        var oldCLass = $(this).attr('class');
        var btn = $(this).find('.md');
        if (!btn.hasClass('md-favorite')) {
            btn.removeClass('md-favorite-outline').addClass('md-favorite')
        } else {
            btn.removeClass('md-favorite').addClass('md-favorite-outline')
        }
        $.get(el.$subscribe.data('remote'), function (data) {
            if (data.error) {
                btn.attr('class', oldCLass);
            }
            refreshContent();
        })
    });

    load_subscribers();
    load_comments();

    if ($("i").is("#event-descr-edit-icon")) {
        $("#event-descr-edit-icon").hover(function () {
            $(this).animate({
                'opacity': 1
            })
        }, function () {
            $(this).animate({
                'opacity': 0.2
            });
        });
        edit_area = $('#event-description');
        $("#event-descr-edit-icon").on('click', function () {
            if ($(this).hasClass('md-save')) {
                edit_area.attr('class', 'text-muted');
                edit_area.prop('contenteditable', 'false');
                $(this).prop('class', 'md-border-color pull-right event-descr-edit');
                $.ajax({
                    type: "POST",
                    url: $(this).data('href'),
                    dataType: "JSON",
                    data: {
                        description: edit_area.html()
                    },
                    beforeSend: function () {
                        var loading = $('<i class="md-loop md-rotate-right md-spin md-3x" style="position: absolute; left: 45%; top: 10%;"></i>');
                        edit_area.append(loading);
                    },
                    success: function (msg) {
                        edit_area.empty();
                        edit_area.append(msg);
                    }
                });
            } else {
                edit_area.addClass('text-muted-edit');
                edit_area.prop('contenteditable', 'true');
                $(this).prop('class', 'md-save pull-right event-descr-edit');
            }
        });
    }

})();

function load_subscribers() {
    var page = 1;
    var $tpl = $('#subscriber-event-item');
    var $list = $('#subscriber-container');
    var template = _.template($tpl.text());
    var $buttonNextPage = $('#subscriber-next-page');
    var loadSubscribersPage = function (page) {
        var url = $tpl.data('remote') + '&page=' + page;
        $.get(url, function (data) {
            //console.log(data);
            if (data.pageCount == page) {
                $buttonNextPage.hide()
            }
            $.each(data.items, function (k, v) {
                $list.append(template(v))
            })
        });
    }
    loadSubscribersPage(page);
    $buttonNextPage.click(function () {
        loadSubscribersPage(++page);
        return false;
    });
}

function load_comments() {
    var page = 1;
    var container = document.querySelector('#events-container');
    var $tpl = $('#comment-event-item');
    var $list = $('#comments-container');
    var template = _.template($tpl.text());
    var $buttonNextPage = $('#comments-next-page');
    var loadCommentsPage = function (page) {
        var url = $tpl.data('remote') + '&page=' + page;
        $.get(url, function (data) {
            if (data.pageCount == 0 || data.pageCount == page) {
                $buttonNextPage.hide();
            }
            $.each(data.items, function (k, v) {
                $list.append(template(v))
            })
        });
    }
    loadCommentsPage(page);
    $buttonNextPage.click(function () {
        loadCommentsPage(++page);
        return false;
    });
}

function sent(obj) {
    var obj = $(obj);
    var siblings = obj.siblings("#msg_cnt");
    var notify_all = $("#notify_all");
    //console.log(notify_all.prop("checked"));
    //return;
    if (siblings.text() == '') {
        return false;
    }
    $.ajax({
        type: "POST",
        url: "/comment/add-comment",
        dataType: "JSON",
        data: {
            message: siblings.text(),
            event_id: siblings.data('eid'),
            notify_all: notify_all.prop("checked")
        },
        success: function (msg) {
            var d = new Date();
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (month < 10) {
                month = '0' + month;
            }
            var hours = d.getHours();
            var minutes = d.getMinutes();
            var seconds = d.getSeconds();

            var date = 'Сегодня: ' + hours + ':' + minutes + ':' + seconds;

            var comments_container = $('#comments-container');
            var ava = Helper.html.avatar(msg.user, 50, {
                "class": "media-object img-circle",
                style: "width:'50px'; height:'50px';",
                "title": msg.user.username,
                "alt": msg.user.username
            });
            $('<div class="media"><div class="media-left media-middle">' +
            '<a href="' + msg.user.link.home + '">' + ava +
            '</a></div>' +
            '<div class="media-body">' +
            '<h4 class="media-heading">' + msg.user.username + ' | <small>' + date + '</small></h4>' +
            msg.item.message +
            '</div></div>').prependTo(comments_container);
            siblings.text('');
        }
    });
}