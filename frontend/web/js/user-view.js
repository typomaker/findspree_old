/**
 * Created by dev on 12.03.15.
 */

(function () {
    function List(params) {

        params = _.extend({
            $el: null,
            tpl: null,
            itemClass: ''
        }, params);

        this.startUrl = params.$el.data('remote');
        this.url = this.startUrl;
        this.tpl = params.tpl;
        this.$el = params.$el;
        this.$footer = this.$el.find('.footer').hide();
        this.$empty = this.$el.find('.panel-empty').show();
        this.$body = this.$el.find('.body').hide();
        this.itemClass = params.itemClass;
        this.$footer.click(function () {
            this.load();
        }.bind(this));
        this.loading = false;
        $(window).scroll(function () {
            if (!this.loading && this.$el.is(':visible') && $(window).scrollTop() + $(window).height() > $(document).height() - 400) {
                this.load()
            }
        }.bind(this));
    }

    List.prototype.showLoading = function () {
        this.$empty.show();
        this.$empty.find('.md-sync').show();
        this.$empty.find('.md-event-note').hide();
        this.$footer.hide();
    };
    List.prototype.showEmpty = function () {
        this.$empty.show();
        this.$empty.find('.md-sync').hide();
        this.$empty.find('.md-event-note').show();
        this.$footer.hide();
    };

    List.prototype.load = function (reset) {

        if (reset) {
            this.url = this.startUrl;
            this.$body.html('');
        }
        if (!this.url)return;

        this.loading = true;
        this.showLoading();
        $.get(this.url, function (data) {
            this.$empty.hide();
            this.url = '';
            if (data._links.next) {
                this.url = data._links.next.href;
            }
            var meta = data._meta;
            if (meta.currentPage < meta.pageCount) {
                this.$footer.slideDown(500);
            }else{
                this.$footer.hide();
            }
            this.loading = false;
            this.$empty.hide();
            this.$body.show();
            if (data && data.items)
                this.render(data)
        }.bind(this));
    };
    List.prototype.render = function (data) {
        var html = '';
        this.$body.masonry({
            itemSelector: '.user-page-item',
            columnWidth: '.user-page-item',
            transitionDuration: "0.2s"
        });
        if (!data)return false;
        if (data._meta.pageCount == 0) {
            this.showEmpty();
            return;
        }
        _.each(data.items, function (e) {
            var dt = _.extend({
                itemStyle: this.itemClass
            }, e);
            html = $(this.tpl({dt:e}))[0];

            this.$body.masonry().append(html).masonry( 'appended', html).masonry()

        }.bind(this));
        imagesLoaded( this.$body, function() {
            this.$body.masonry();
        }.bind(this));
    };

    var listEventSubscribe, action, listEventCreate;
    var html2 = $('#tpl-event-wide').html(), listWall, listSigned;
    listEventSubscribe = new List({
        $el: $('#act-event-subscribe'),
        tpl: _.template(html2)
    });
    listEventCreate = new List({
        $el: $('#act-event-create'),
        tpl: _.template(html2)
    });
    var userTpl = $('#tpl-user').html(), listSubscribers;
    listSigned = new List({
        $el: $('#act-signed'),
        tpl: _.template(userTpl)
    });
    listSubscribers = new List({
        $el: $('#act-subscribers'),
        tpl: _.template(userTpl)
    });
    listWall = new List({
        $el: $('#act-wall'),
        tpl: function (e) {
            if (wallViews[e.dt.type])
                return wallViews[e.dt.type]({dt: e.dt});
            return '';
        }
    });
    var wallViews = {
        1: _.template($("#tpl-wall-subscribe-event").html()),
        2: _.template($("#tpl-wall-subscribe-user").html()),
        3: _.template($("#tpl-wall-event-create").html()),
        4: _.template($("#tpl-wall-event-edit").html())
    };
    var lastAction = '';
    var loading = false;
    action = {
        wall: function () {
            $('.act').hide();
            $('.menu-item').removeClass('active');
            $('#menu-wall').addClass('active');
            var $act = $('#act-wall');
            $act.show();
            listWall.load(true);
        },
        eventSubscribe: function () {
            $('.act').hide();
            $('.menu-item').removeClass('active');
            $('#menu-event-subscribe').addClass('active');
            var $act = $('#act-event-subscribe');
            $act.show();
            listEventSubscribe.load(true);

        },
        eventCreated: function () {
            $('.act').hide();
            $('.menu-item').removeClass('active');
            $('#menu-event-create').addClass('active');
            var $act = $('#act-event-create');
            $act.show();
            listEventCreate.load(true);
        },
        signed: function () {
            $('.act').hide();
            $('.menu-item').removeClass('active');
            $('#menu-signed').addClass('active');
            var $act = $('#act-signed');
            $act.show();
            listSigned.load(true);
        },
        subscribers: function () {
            $('.act').hide();
            $('.menu-item').removeClass('active');
            $('#menu-subscribers').addClass('active');
            var $act = $('#act-subscribers');
            $act.show();
            listSubscribers.load(true);
        }
    };
    action.wall();
    $('.menu-item').click(function () {
        var actionName = $(this).data('action');
        if (action[actionName]) {
            action[actionName]();
            lastAction = actionName;
        }
        return false;
    });
}());

$('#user-subscribe').on('click', function () {
    var e = $(this);
    var url = $(this).data('remote');
    var oldClass = e.attr('class');
    $.getJSON(url, function (data) {
        if (e.hasClass('btn-success')) {
            e.removeClass('btn-success');
            e.addClass('btn-info');
            e.find('span').text('ПОДПИСАТЬСЯ')
        } else {
            e.removeClass('btn-info');
            e.addClass('btn-success');
            e.find('span').text('ВЫ ПОДПИСАНЫ')
        }
        if (data.error) {
            e.attr('class', oldClass);
        }
    });
});