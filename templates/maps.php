<?php
/*
Template Name: Адреса наших магазинов
*/
get_header();
?>

<section class="maps">
    <div class="container">
        <div class="h1-block">
            <h1 class="h1"><?php the_title(); ?></h1>
            <?php woocommerce_breadcrumb(); ?>
        </div>

        <div class="maps-contacts">
            <div class="maps-contacts__info">
                <?php 
                // Лимит на 3 точки (можно увеличить)
                for ($i = 1; $i <= 3; $i++) : 
                    $title = get_field("c_title_$i");
                    $text  = get_field("c_text_$i");
                    $days  = get_field("c_days_$i");
                    $time  = get_field("c_time_$i");
                    $phone = get_field("c_phone_$i");

                    // Выводим блок только если заполнен заголовок
                    if ($title) : 
                        // Первый элемент делаем активным по умолчанию
                        $active_class = ($i === 1) ? 'is-active' : '';
                        
                        // Очищаем телефон от пробелов для ссылки tel:
                        $phone_clean = preg_replace('/[^0-9+]/', '', $phone);
                    ?>
                        <div class="maps-contact-item <?php echo $active_class; ?>" 
                            onclick="moveToPoint(<?php echo $i - 1; ?>, this)">
                            
                            <h3 class="maps-contact-item__title"><?php echo esc_html($title); ?></h3>
                            
                            <p class="maps-contact-item__text"><?php echo esc_html($text); ?></p>
                            
                            <div class="maps-contact-item__schedule">
                                <span>График работы:</span>
                                <span>
                                    <p><?php echo esc_html($days); ?></p>
                                    <p><?php echo esc_html($time); ?></p>
                                </span>
                            </div>
                            
                            <?php if ($phone) : ?>
                                <p class="maps-contact-item__phone">
                                    Телефон: <a href="tel:<?php echo $phone_clean; ?>"><?php echo esc_html($phone); ?></a>
                                </p>
                            <?php endif; ?>
                            
                        </div>
                    <?php endif; 
                endfor; ?>
            </div>
            <div id="yandex-map"></div>
        </div>

        <!-- ВСТАВИТЬ СВОЙ КЛЮЧ КАРТ -->
        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=ВАШ_API_КЛЮЧ" type="text/javascript"></script>

        <script>
            let myMap;
            let placemarks = [];
            const locations = [
                { coords: [59.936305, 30.333701], title: "Unico Moda: Итальянская 15" },
                { coords: [60.004239, 30.263426], title: "Unico Moda: Комендантский 9" }
            ];
            ymaps.ready(init);

            function init() {
                myMap = new ymaps.Map("yandex-map", {
                    center: locations[0].coords,
                    zoom: 15,
                    controls: ['zoomControl', 'fullscreenControl']
                });
                // Создаем и добавляем метки
                locations.forEach((loc, index) => {
                    let pm = new ymaps.Placemark(loc.coords, {
                        balloonContent: loc.title
                    }, {
                        preset: 'islands#yellowDotIcon' // Желтый цвет в стиле Яндекса
                    });
                    placemarks.push(pm);
                    myMap.geoObjects.add(pm);
                });
            }
            function moveToPoint(index, element) {
                const target = locations[index];
                // 1. Плавный перелет
                myMap.panTo(target.coords, {
                    flying: true,
                    duration: 1000
                }).then(() => {
                    // 2. Открываем балун (облачко) после прилета
                    placemarks[index].balloon.open();
                });
                // 3. Красим активный таб
                document.querySelectorAll('.maps-contact-item').forEach(item => item.classList.remove('is-active'));
                element.classList.add('is-active');
            }
        </script>
    </div>
</section>

<?php get_footer(); ?>