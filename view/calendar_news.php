<script>
    (function ($) {
        $(window).on('load', function () {
            <?php
            if (!function_exists('mg_teoola_load_calendar_news')) {
                function mg_teoola_load_calendar_news()
                {
                    $username = get_option("teoola_username") ? get_option("teoola_username") : '';
                    $password = get_option("teoola_key") ? get_option("teoola_key") : '';

                    $url = "https://api.teoola.com/json_entity_actualite.php?entity=$username&key=$password";
                    $response_api = wp_remote_get($url);
                    $response = json_decode(wp_remote_retrieve_body($response_api), true);
                    $arr_events = '[';
                    $i = 0;
                    if (count($response)) {
                        foreach ($response as $row) {
                            $d = date_parse_from_format("Y, m, d, G, i", $row['date']);
                            $goodM = intval($d["month"]) - 1;
                            $arr_events .= "{
                        title: '" . addslashes($row['name']) . "',
                        description: '" . str_replace(array("\r", "\n"), '', teoolaTruncate(addslashes($row['description']), 80)) . "',
                        datetime: new Date(" . $d["year"] . ", " . $goodM . ", " . $d["day"] . ", " . $d["minute"] . "),
                        link: '" . str_replace('\\', '', $row['link']) . "'
                    },";
                            $i++;
                        }
                    }
                    $arr_events .= ']';
                    echo $arr_events;
                }
            }
            ?>
            $('#teoolaCalendarNews').teoolaCalendar({
                eventTitle: 'Actualités',
                events: <?php mg_teoola_load_calendar_news(); ?>
            });
        });

        $(window).on('load resize scroll', function () {
            if ($('#teoolaCalendarNews').parent('div').width() < 980) {
                $('.c-grid, .c-event-grid').addClass('vertical');
            }else {
                $('.c-grid, .c-event-grid').removeClass('vertical');
            }
        });
    }(jQuery));
</script>

<div id="teoolaCalendarNews"></div>