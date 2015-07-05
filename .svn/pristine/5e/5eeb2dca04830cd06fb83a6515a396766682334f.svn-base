/**
 * Created by Andrey on 12.03.2015.
 */
(function () {
    var myMap;
    $('#live-map').css('height', $(window).height() - 60);
    ymaps.ready(init);
    map_options = {
        center: [55.76, 37.64], // Москва
        zoom: 10,
        controls: ['typeSelector','zoomControl', 'fullscreenControl']
    }

    function init() {
        myMap = new ymaps.Map('live-map', map_options);

        ymaps.geolocation.get({
            // Выставляем опцию для определения положения по ip
            provider: 'yandex',
            // Карта автоматически отцентрируется по положению пользователя.
            mapStateAutoApply: true
        }).then(function (result) {
            myMap.geoObjects.add(result.geoObjects);
            myMap.setZoom(12);
            getEventTomap();
        }, function(e){

        });

        myMap.events.add('mousedown', function (e) {
            //e.preventDefault();
            console.log(e.get('coords'));
            //getEventTomap();
        });

    }
    var baloonTemplate = _.template($('#tpl-event-line').text());
    function getEventTomap(){
        $.ajax({
            url: ""
        }).done(function (data) {
            var myGeoObjects = [];
            $.each(data, function (index, value) {
                myGeoObjects[index] = new ymaps.GeoObject({
                    geometry: {
                        type: "Point",
                        coordinates: [value.geo_longitude, value.geo_latitude]
                    },
                    properties: {
                        clusterCaption: value.name,
                        balloonContent: baloonTemplate({dt:value})
                    }
                });
            });

            var myClusterer = new ymaps.Clusterer(
                {clusterDisableClickZoom: true}
            );
            myClusterer.add(myGeoObjects);
            myMap.geoObjects.add(myClusterer);
        });
    }
})();