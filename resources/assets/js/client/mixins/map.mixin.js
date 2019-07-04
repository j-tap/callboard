var mixin = {
    data () {
        return {
            map: null,
        }
    },
    methods: {
        initMap (lat, lon, zoom, blockId, callback)
		{
			ymaps.ready(() => {
                this.map = new ymaps.Map(`${blockId}`, {
                    center: [lat, lon],
                    zoom: zoom,
                    controls: [],

                })
                if (callback) {
                    callback(this.map)
                }
            })
        },
        mapCenter (lat, lon) 
		{
            this.map.setCenter([
                lat,
                lon
            ])
        },
        addMapMarker (lat, lon, icon)
		{
            let marker = new ymaps.Placemark([lat, lon], {}, {
                // Опции.
                // Необходимо указать данный тип макета.
                iconLayout: 'default#image',
                // Своё изображение иконки метки.
                iconImageHref: '/images/tamtem/map/' + icon,
                // Размеры метки.
                iconImageSize: [48, 48],
                // Смещение левого верхнего угла иконки относительно
                // её "ножки" (точки привязки).
                iconImageOffset: [-24, -48],
                openEmptyBalloon: false,

            })
            this.map.geoObjects.add(marker)
        },

        addOfficeMarker (lat, lon, icon)
		{
            let marker = new ymaps.Placemark([lat, lon], {
                type: 'office'
            }, {
                // Опции.
                // Необходимо указать данный тип макета.
                iconLayout: 'default#image',
                // Своё изображение иконки метки.
                iconImageHref: '/images/tamtem/map/' + icon,
                // Размеры метки.
                iconImageSize: [48, 48],
                // Смещение левого верхнего угла иконки относительно
                // её "ножки" (точки привязки).
                iconImageOffset: [-24, -48],
                openEmptyBalloon: false,

            });
            marker.events.add('click', () => {
                console.log(marker.properties._data.type)
            });
            this.map.geoObjects.add(marker)
        },
        addStockMarker (lat, lon, icon, stockId = undefined)
		{
            let marker = new ymaps.Placemark([lat, lon], {
                id: stockId
            }, {
                // Опции.
                // Необходимо указать данный тип макета.
                iconLayout: 'default#image',
                // Своё изображение иконки метки.
                iconImageHref: '/images/tamtem/map/' + icon,
                // Размеры метки.
                iconImageSize: [48, 48],
                // Смещение левого верхнего угла иконки относительно
                // её "ножки" (точки привязки).
                iconImageOffset: [-24, -48],
                openEmptyBalloon: false,

            });
            marker.events.add('click', () => {
                this.stockMarkerEvent(marker)
            });
            this.map.geoObjects.add(marker)
        },

        async stockMarkerEvent (point)
		{
            // Будем хранить инфу по организациям в массиве, а то на каждый клик много запросов =)
            var id = point.properties._data.id;
            //this.mapShowOrganizationMarkers(id)
            this.$router.push({
                params: {
                    id: id
                },
            })
        },
    }
};

export default mixin