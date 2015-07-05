/**
 * Created by albert on 22.02.15.
 */
(function () {
    var el, map, geolocation;
    el = {
        $geoTitle: $('#eventform-geotitle'),
        $geoCoordinates: $('#eventform-geocoordinates'),
        $geoDescription: $('#eventform-geodescription')
    };
    ymaps.ready(function () {
        geolocation = ymaps.geolocation;
        var params = {
            center: [59.22, 39.89],
            zoom: 12,
            controls: []
        };
        if (el.$geoCoordinates.length > 0) {
            params.center = el.$geoCoordinates.val().split(',')
            getAddress(params.center)
        }
        map = new ymaps.Map('map', params);
        var searchResult = new ymaps.GeoObjectCollection(null, {
            hintContentLayout: ymaps.templateLayoutFactory.createClass('$[properties.name]')
        });
        el.$geoTitle.on('change', function () {
            var value = $(this).val();
            if (value.length <= 5)return false;
            // Поиск координат центра Нижнего Новгорода.
            ymaps.geocode(value, {
                results: 1 // Если нужен только один результат, экономим трафик пользователей
            }).then(function (res) {
                // Выбираем первый результат геокодирования.
                var node = res.geoObjects.get(0),
                    bounds = node.properties.get('boundedBy');
                searchResult.removeAll()
                searchResult.add(node);
                map.setBounds(bounds, {
                    checkZoomRange: true // проверяем наличие тайлов на данном масштабе.
                });
                el.$geoCoordinates.val(node.geometry.getCoordinates().join());
                el.$geoTitle.val(node.properties.get('name'));
                el.$geoDescription.val(node.properties.get('text'))
            });
        });


        geolocation.get({
            provider: 'yandex',
            mapStateAutoApply: true
        }).then(function (result) {
            map.setCenter(result.geoObjects.get(0).geometry.getCoordinates());
        });

        map.events.add('click', function (e) {
            var coords = e.get('coords');
            getAddress(coords);
        });
        map.geoObjects.add(searchResult);
        function getAddress(coords) {
            //myPlacemark.properties.set('iconContent', 'поиск...');
            ymaps.geocode(coords).then(function (res) {
                searchResult.removeAll();
                var node = res.geoObjects.get(0);
                node.options.set('draggable', true);
                node.events.add('dragend', function (e) {
                    getAddress(e.get('target').geometry.getCoordinates());
                });
                searchResult.add(node);
                el.$geoCoordinates.val(node.geometry.getCoordinates().join());
                el.$geoTitle.val(node.properties.get('name'));
                el.$geoDescription.val(node.properties.get('text'))
            });
        }
    });
    function fillCoordInput(node) {

    }

    var datetimePickerOption = {
        format: 'dd.mm.yyyy hh:ii',
        minView: 0,
        language: 'ru',
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left",
        startDate: new Date(),
        minuteStep: 10
    };
    $('#description-preview-btn').click(function(){
        $('#description-preview').modal('show').find('.modal-body').html(Helper.text.toHtml($('#eventform-description').val())).end()
    });
    $('#description-preview').on('hidden.bs.modal',function(){
       $(this).find('.modal-body').html('');
    });
    var $begin = $('#eventform-begin');
    var $end = $('#eventform-end');
    $begin.datetimepicker(datetimePickerOption).on('changeDate', function (ev) {
        $('#eventform-end').datetimepicker('setStartDate', ev.date);
    }).on('keydown', function () {
        return false;
    }).on('show',function(){
        if($end.val()){
            $begin.datetimepicker('setEndDate', $end.val());
        }
    });
    $end.datetimepicker(_.extend(datetimePickerOption, {})).on('changeDate', function (ev) {
        $('#eventform-begin').datetimepicker('setEndDate', ev.date);
    }).on('keydown', function () {
        return false;
    }).on('show',function(){
        if($begin.val()){
            $end.datetimepicker('setStartDate', $begin.val());
        }
    });

    $('#eventform-img').change(function () {
        var input = $(this)[0];
        if (input.files && input.files[0]) {
            if (input.files[0].type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var $avatarPreview = $('#avatar-preview');
                    //$avatarPreview.parent().show().end().attr('src', e.target.result)
                    $('#avatar-preview-label').hide();
                    $avatarPreview.show().attr('src',e.target.result);
                    //masonry.layout()
                };
                reader.readAsDataURL(input.files[0]);
            } else console.log('is not image mime type');
        } else console.log('not isset files data or files API not supordet');
    });
    $(document).on('click', '#price-add-row', function () {
        var $priceList = $('.price-list');
        var count = $priceList.find('.price-row').length;
        var $container = $('#price-row-template').children().clone();
        if (count >= 9) {
            $(this).removeClass('md-add')
        }
        $container.find('input').val('').removeAttr('disabled');
        $container.find('.price-container').each(function () {
            var $input = $(this).find('input');
            var newId = $input.attr('id').replace(/(.*-)X$/, "$1" + count);
            var newName = $input.attr('name').replace(/(.*)\[X\](.*)$/, "$1[" + count + "]$2");
            $input.attr('id', newId);
            $input.attr('name', newName);
            $(this).find('.help-block').html("")
            $(this).removeClass('has-success').removeClass('has-error')
            var cNewId = $(this).attr('id').replace(/(.*-)X$/, "$1" + count);
            $(this).attr('id', cNewId);
        });
        $container.find('i.md-add').removeClass('md-add').addClass('md-clear');
        $priceList.append($container);

        var $form = $('#w0');
        $form.yiiActiveForm('add', {
            "id": "eventprice-cost",
            "name": "cost",
            "container": "#eventprice-container-cost-" + count,
            "input": "#eventprice-cost-" + count,
            "validate": function (attribute, value, messages, deferred, $form) {
                yii.validation.number(value, messages, {
                    "pattern": /^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/,
                    "message": "Значение «Цена» должно быть числом.",
                    "skipOnEmpty": 1
                });
            }
        });
        $form.yiiActiveForm('add', {
            "id": "eventprice-description",
            "name": "description",
            "container": "#eventprice-container-description-" + count,
            "input": "#eventprice-description-" + count,
            "validate": function (attribute, value, messages, deferred, $form) {
                yii.validation.string(value, messages, {
                    "message": "Значение «Пояснение» должно быть строкой.",
                    "skipOnEmpty": 1
                });
            }
        });
    });
    $(document).on('click', '.md-clear', function () {
        var $priceList = $(this).parents('.price-list');
        $(this).parents('.price-row').remove();
        var count = $priceList.find('.price-row').length;
        if (count < 10) {
            $priceList.find('.price-row').first().find('.price-add-row').addClass('md-add');
        }
    });
    var timer;
    var idTimeout;
    $('#event-save').click(function(e){
        e.preventDefault();
        if(!timer){
            timer = true;
            clearTimeout(idTimeout);
            idTimeout = setTimeout(function(){
                timer = false;
            }.bind(this),3000);
            $('#w0').submit();
        }
    });
    //$('#eventform-tag').tagsinput({
    //    maxTags: 5,
    //    maxChars: 30,
    //    confirmKeys: [13, 44, 32,46,33,34,35,36,37,38,39,40,41,42,43,45,47,58,59,60,61,62,63,64,91,92,93,94,96,126,186,187,188,189,190,191,192,219,220,221,222],
    //    trimValue: true
    //});


})();