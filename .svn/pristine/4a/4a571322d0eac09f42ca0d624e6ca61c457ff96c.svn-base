/**
 * Created by dev on 20.02.15.
 */
/*
 *  var state = function () {
 var url = URI(window.location.href);
 var params = url.search(true) || {};

 var begin = $('.calendar-item.active').data('date');
 if (begin) {
 params.begin = begin;
 }
 var tags = $inputTag.val().length ? $inputTag.val().split(',') : [];
 if (tags.length > 0) {
 params.tags = tags;
 }
 console.log(params);
 if ((params.tags && params.tags.length > 0) || params.begin) {
 history.pushState({}, '', '?' + $.param(params));
 } else {
 alert(1);
 history.pushState({}, '', window.location.pathname);
 }
 };
 * */

(function () {
    function AFilter() {
        var _tag = '';
        var _page = 1;
        var _begin = '';
        var _act = '';
        var _type = '';
        var _search = '';
        var params = this.getUrl().query(true);
        if (params.tag) _tag = params.tag;
        if (params.begin) _begin = params.begin;
        if (params.type) _type = params.type;
        if (params.act) _act = params.act;
        if (params.search) _search = params.search;
        this.setSearch = function (value) {
            _search = value;
            this.apply();
            return this;
        };
        this.getSearch = function () {
            return _search;
        }
        this.getTag = function () {
            return _tag;
        };
        this.setTag = function (tag) {
            _tag = tag;
            this.apply();
            return this;
        };
        this.cleanTag = function () {
            _tag = [];
            this.apply();
            return this;
        };
        this.nextPage = function () {
            _page++;
            this.apply();
            return this;
        };
        this.firstPage = function () {
            _page = 1;
            this.apply();
            return this;
        };
        this.setPage = function (page) {
            _page = page;
            this.apply();
            return this;
        };
        this.getPage = function () {
            return _page;
        };
        this.setBegin = function (begin) {
            _begin = begin;
            this.apply();
            return this;
        };
        this.getBegin = function () {
            return _begin;
        };
        this.getAttributes = function () {
            return {
                page: _page,
                begin: _begin,
                tag: _tag,
                act: _act,
                search: _search,
                type: _type
            }
        };
        this.getChangedAttributes = function () {
            var attr = this.getAttributes();
            var prepare = {};
            if (attr.page > 1)prepare.page = attr.page;
            if (attr.tag.length > 0)prepare.tag = attr.tag;
            if (attr.begin)prepare.begin = attr.begin;
            if (attr.type)prepare.type = attr.type;
            if (attr.act)prepare.act = attr.act;
            if (attr.search)prepare.search = attr.search;
            return prepare;
        };
        this.setAct = function (act) {
            _act = act;
            this.apply();
        };
        this.getAct = function () {
            return _act;
        };
        this.apply = function () {
            var url2 = this.getUrl().search(this.getChangedAttributes());
            history.pushState(null, '', url2);
        };
        this.setType = function (type) {
            _type = type;
            this.apply();
            return this;
        };
        this.getType = function () {
            return _type;
        }

    };
    AFilter.prototype.getUrl = function () {
        return URI(window.location.href);
    };
    var container = document.querySelector('#events-container');
    var masonry;
    window.filter = new AFilter();
    var $tpl = $('#tpl-event-item');
    var url = $tpl.data('remote');
    var $list = $('#events-container');
    var masonryConfig = {
        transitionDuration: "0.2s",
        itemSelector: '.item',
        columnWidth: '.col-md-4'
    };
    $list.masonry(masonryConfig);
    var template = _.template($tpl.text());
    var $buttonNextPage = $('#next-page');

    var more = true;
    var loading = false;

    var buttonNextShow = function () {
        $buttonNextPage.prev().show();
        $buttonNextPage.show();
    };
    var buttonNextHide = function () {
        $buttonNextPage.prev().hide();
        $buttonNextPage.hide();
    };
    buttonNextHide();
    var nextPage = function () {
        if (loading)return;
        filter.nextPage();
        currentPage();
    };

    window.currentPage = function () {
        loading = true;
        $.get(url, filter.getChangedAttributes(), function (data) {
            loading = false;
            var meta = data._meta;
            var links = data._links;

            if (meta.pageCount == meta.currentPage) {
                buttonNextHide();
                more = false;
            } else if (meta.pageCount > 1) {
                buttonNextShow();
                more = true;
            }
            var html = '';
            if (filter.getPage() == 1) {
                $list.html('')
            }
            if(meta.totalCount==0){
                $('#events-list-empty').show()
            }else{
                $('#events-list-empty').hide()
                $.each(data.items, function (k, v) {
                    html = $(template({dt: v}))[0];
                    if (filter.getTag()) {
                        $(html).find('.tag-link[data-tag="' + filter.getTag() + '"]').removeClass('label-primary').addClass('label-info').attr('title','Нажми, что бы отменить поиск по тегу')
                    }
                    $list.masonry().append(html).masonry('appended', html);
                });
            }

            imagesLoaded( $list, function() {
                $list.masonry();
            });
            //setTimeout(function () {
            //    $list.masonry();
            //}, 300);
        });
    };

    setInterval(function () {
        if (masonry)
            masonry.layout();
    }, 3000);
    currentPage();
    $(document).ready(function () {
        $(window).scroll(function () {
            if (more && $(window).scrollTop() + $(window).height() > $(document).height() * 0.9) {
                nextPage()
            }
        });
    });
    var timeout;
    var search = function (event) {
        var val = $(this).val();
        if (val.length == 0) {
            filter.cleanTag();
        } else {
            filter.setTag(val);
        }
        filter.firstPage();
        clearTimeout(timeout);
        timeout = setTimeout(currentPage, 500);
    };
    $(document).on('click', '.tag-link', function (e) {
        filter.firstPage();
        e.preventDefault();
        if ($(this).hasClass('label-info')) {
            filter.setTag('');
        } else {
            filter.setTag($(this).data('tag'));
        }
        currentPage();
    });
    $('.event-calendar li:not(.disabled)').on('click', function () {
        var $e = $(this);
        $list.html('');
        filter.firstPage();
        filter.setBegin($e.data('date'));
        $e.parent().find('.active').removeClass('active');
        $e.addClass('active');
        currentPage();
        return false;
    });
    $('#search-event-type').on('change', function () {
        $list.html('');
        filter.firstPage();
        filter.setType($(this).val());
        currentPage();
        return false;
    });
    $('#search-event-act').on('change', function () {
        $list.html('');
        filter.firstPage();
        filter.setAct($(this).val());
        currentPage();
    });
    var openIsClick = true;
    var $filterDate = $("#filter-date");
    $filterDate.datetimepicker({
        format: 'dd MM yyyy',
        minView: 2,
        language: 'ru',
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left",
        todayHighlight: true
    }).on('changeDate', function (ev) {
        $list.html('');
        filter.firstPage();
        var yyyy = ev.date.getFullYear().toString();
        var mm = (ev.date.getMonth() + 1).toString(); // getMonth() is zero-based
        var dd = ev.date.getDate().toString();
        var date = (dd[1] ? dd : "0" + dd[0]) + '.' + (mm[1] ? mm : "0" + mm[0]) + '.' + yyyy; // padding
        filter.setBegin(date);
        currentPage();
    }).on('hide', function () {
        openIsClick = true;
    }).on('show', function () {
        openIsClick = false;
    }).click(function () {
        if (openIsClick){
            $filterDate.datetimepicker('show')
        }
    }).datetimepicker('update', $filterDate.data('initial'));

    $("#filter-date-clear").click(function () {
        if (filter.getBegin() != '') {
            $list.html('');
            filter.firstPage();
            filter.setBegin('');
            currentPage();
        }
        $('#filter-date').val('').datetimepicker('update', null);
    });
    $("#filter-search-clear").click(function () {
        if (filter.getSearch() != '') {
            $list.html('');

            filter.firstPage();
            filter.setSearch('');
            currentPage();
        }
        $('#filter-search').val('');
        $(this).parent().hide();
    });
    var filterSearchTimer, before = '';
    $('#filter-search').keyup(function () {
        if ($(this).val().length == 0) {
            $("#filter-search-clear").parent().hide();
        } else {
            $("#filter-search-clear").parent().show();
        }
        if (before != $(this).val()) {
            before = $(this).val();
            clearTimeout(filterSearchTimer);
            filterSearchTimer = setTimeout(function () {
                $list.html('');
                filter.firstPage();
                filter.setSearch($(this).val());
                currentPage();
            }.bind(this), 1000);
        }
    }).on('focus', function () {
        $('.user-main-avatar .ava').css({
            top: "-10px",
            opacity: "0.3"
        })
    }).on('blur', function () {
        $('.user-main-avatar .ava').css({
            top: "5px",
            opacity: "1"
        })
    })
})();