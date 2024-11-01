/* Teeola Stepped form */
var $x = jQuery.noConflict();

(function ($) {
    $.fn.inputFilter = function (inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            }
        });
    };

    var teoolaCalendar = function (options, object) {
        // Initializing global variables
        var adDay = new Date().getDate();
        var adMonth = new Date().getMonth();
        var adYear = new Date().getFullYear();
        var dDay = adDay;
        var dMonth = adMonth;
        var dYear = adYear;
        var instance = object;

        var settings = $.extend({}, $.fn.teoolaCalendar.defaults, options);

        function lpad(value, length, pad) {
            if (typeof pad == 'undefined') {
                pad = '0';
            }
            var p;
            for (var i = 0; i < length; i++) {
                p += pad;
            }
            return (p + value).slice(-length);
        }

        var mouseOverEvent = function () {
            $(this).addClass('c-event-over');
            var d = $(this).attr('data-event-day');
            $('div.c-event-item[data-event-day="' + d + '"]').addClass('c-event-over');
        };
        var mouseLeaveEvent = function () {
            $(this).removeClass('c-event-over')
            var d = $(this).attr('data-event-day');
            $('div.c-event-item[data-event-day="' + d + '"]').removeClass('c-event-over');
        };
        var nextMonth = function () {
            if (dMonth < 11) {
                dMonth++;
            } else {
                dMonth = 0;
                dYear++;
            }
            print();

            if ($('#teoolaCalendarNews').parent('div').width() < 980) {
                $('.c-grid, .c-event-grid').addClass('vertical');
            }else {
                $('.c-grid, .c-event-grid').removeClass('vertical');
            }

            if ($('#teoolaCalendar').parent('div').width() < 980) {
                $('.c-grid, .c-event-grid').addClass('vertical');
            }else {
                $('.c-grid, .c-event-grid').removeClass('vertical');
            }
        };
        var previousMonth = function () {
            if (dMonth > 0) {
                dMonth--;
            } else {
                dMonth = 11;
                dYear--;
            }
            print();

            if ($('#teoolaCalendarNews').parent('div').width() < 980) {
                $('.c-grid, .c-event-grid').addClass('vertical');
            }else {
                $('.c-grid, .c-event-grid').removeClass('vertical');
            }

            if ($('#teoolaCalendar').parent('div').width() < 980) {
                $('.c-grid, .c-event-grid').addClass('vertical');
            }else {
                $('.c-grid, .c-event-grid').removeClass('vertical');
            }
        };

        function loadEvents() {
            if (typeof settings.url != 'undefined' && settings.url != '') {
                $.ajax({
                    url: settings.url,
                    async: false,
                    success: function (result) {
                        settings.events = result;
                    }
                });
            }
        }

        function print() {
            loadEvents();
            var dWeekDayOfMonthStart = new Date(dYear, dMonth, 1).getDay() - settings.firstDayOfWeek;
            if (dWeekDayOfMonthStart < 0) {
                dWeekDayOfMonthStart = 6 - ((dWeekDayOfMonthStart + 1) * -1);
            }
            var dLastDayOfMonth = new Date(dYear, dMonth + 1, 0).getDate();
            var dLastDayOfPreviousMonth = new Date(dYear, dMonth + 1, 0).getDate() - dWeekDayOfMonthStart + 1;

            var cBody = $('<div/>').addClass('c-grid');
            var cEvents = $('<div/>').addClass('c-event-grid');

            var cEventsBody = $('<div/>').addClass('c-event-body');
            cEvents.append($('<div/>').addClass('c-event-title').html(settings.eventTitle));
            cEvents.append(cEventsBody);
            var cNext = $('<div/>').addClass('c-next c-grid-title');
            var cMonth = $('<div/>').addClass('c-month c-grid-title');
            var cPrevious = $('<div/>').addClass('c-previous c-grid-title');
            cPrevious.html(settings.textArrows.previous);
            cMonth.html(settings.months[dMonth] + ' ' + dYear);
            cNext.html(settings.textArrows.next);

            cPrevious.on('click', previousMonth);
            cNext.on('click', nextMonth);

            cBody.append(cPrevious);
            cBody.append(cMonth);
            cBody.append(cNext);
            var dayOfWeek = settings.firstDayOfWeek;
            for (var i = 0; i < 7; i++) {
                if (dayOfWeek > 6) {
                    dayOfWeek = 0;
                }
                var cWeekDay = $('<div/>').addClass('c-week-day');
                cWeekDay.html(settings.weekDays[dayOfWeek]);
                cBody.append(cWeekDay);
                dayOfWeek++;
            }
            var day = 1;
            var dayOfNextMonth = 1;
            for (var i = 0; i < 42; i++) {
                var cDay = $('<div/>');
                if (i < dWeekDayOfMonthStart) {
                    cDay.addClass('c-day-previous-month');
                    cDay.html("<span>" + dLastDayOfPreviousMonth++ + "</span>");
                } else if (day <= dLastDayOfMonth) {
                    cDay.addClass('c-day');
                    if (day == dDay && adMonth == dMonth && adYear == dYear) {
                        cDay.addClass('c-today');
                    }
                    for (var j = 0; j < settings.events.length; j++) {
                        var d = settings.events[j].datetime;
                        if (d.getDate() == day && d.getMonth() == dMonth && d.getFullYear() == dYear) {
                            cDay.addClass('c-event').attr('data-event-day', d.getDate());
                            cDay.on('mouseover', mouseOverEvent).on('mouseleave', mouseLeaveEvent);
                        }
                    }
                    cDay.html("<span>" + day++ + "</span>");
                } else {
                    cDay.addClass('c-day-next-month');
                    cDay.html("<span>" + dayOfNextMonth++ + "</span>");
                }
                cBody.append(cDay);
            }
            var eventList = $('<div/>').addClass('c-event-list');
            for (var i = 0; i < settings.events.length; i++) {
                var d = settings.events[i].datetime;
                if (d.getMonth() == dMonth && d.getFullYear() == dYear) {
                    var date = lpad(d.getDate(), 2) + '/' + lpad(d.getMonth() + 1, 2) + ' ' + lpad(d.getHours(), 2) + ':' + lpad(d.getMinutes(), 2);
                    var item = $('<div/>').addClass('c-event-item');
                    var title = $('<div/>').addClass('title').html(date + '  ' + settings.events[i].title + '<br/>');
                    var description = $('<div/>').addClass('description').html(settings.events[i].description);
                    if (settings.events[i].link !== undefined) {
                        if (settings.events[i].link.length) {
                            description.html(description.html() + ' <a href="' + settings.events[i].link + '" target="_blank">Voir plus</a>');
                        }
                    }
                    description.html(description.html() + '<br />');

                    item.attr('data-event-day', d.getDate());
                    item.append(title).append(description);
                    eventList.append(item);
                }
            }
            $(instance).addClass('teoola-calendar');
            cEventsBody.append(eventList);
            $(instance).html(cBody).append(cEvents);
        }

        return print();
    }

    $.fn.teoolaCalendar = function (oInit) {
        return this.each(function () {
            return teoolaCalendar(oInit, $(this));
        });
    };

    // plugin defaults
    $.fn.teoolaCalendar.defaults = {
        weekDays: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
        months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        textArrows: {
            previous: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="512" height="512" x="0" y="0" viewBox="0 0 407.436 407.436" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><polygon xmlns="http://www.w3.org/2000/svg" points="315.869,21.178 294.621,0 91.566,203.718 294.621,407.436 315.869,386.258 133.924,203.718 " fill="#ffffff" data-original="#000000" style="" class=""/><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g></g></svg>',
            next: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="512" height="512" x="0" y="0" viewBox="0 0 407.436 407.436" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><polygon xmlns="http://www.w3.org/2000/svg" points="112.814,0 91.566,21.178 273.512,203.718 91.566,386.258 112.814,407.436 315.869,203.718 " fill="#ffffff" data-original="#000000" style="" class=""/><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g><g xmlns="http://www.w3.org/2000/svg"></g></g></svg>'
        },
        eventTitle: 'Evènements',
        url: '',
        events: [],
        firstDayOfWeek: 0
    };
}($x));

/* POPUP */
$x(document).ready(function ($) {
    // Play animation to hide on startup
    ResetForms();
    HidePopup();
});

function HidePopup(){
    let hideHeight = "";
    if ($x('#teoola').hasClass('minified')) {
        $x('#teoola-show').fadeIn();
        hideHeight = '-' +  $x('#teoola .teoola-container').css('height');
    } else {
        hideHeight = '-' +  ( parseInt($x('#teoola .teoola-container').css('height')) - 46 ) + 'px';
    }
    $x('#teoola').css('bottom', hideHeight );
    $x('#teoola .teoola-close').fadeOut();
}

function ShowPopup(){
    $x('#teoola').css('bottom', '15px' );
    $x('#teoola .teoola-close').fadeIn();
    $x('#teoola-show').fadeOut();

}

$x(document).on('click', '#teoola-show', function () {
    ShowPopup();
});

$x(document).on('click', '#teoola .teoola-header span', function () {
    ShowPopup();
});

$x(document).on('click', '#teoola .teoola-close', function () {
    HidePopup();
});

$x(document).on('click', '#teoola .teoola-btn-close', function () {
    ResetForms();
    HidePopup();
});

/* MODALS */

function HideModals(){
    $x('.teoola-popup:not(.teoola-hidden)').fadeOut('500', function () {
        $x(this).addClass('teoola-hidden');
    });
    $x('#teoola-overlay').fadeOut('500', function () {
        $x(this).remove();
    });
}

function ShowModal(id){
    ResetForms();
    var overlay = $x('<div id="teoola-overlay"></div>');
    overlay.appendTo(document.body).hide().fadeIn(500);
    $x('#teoola-popup' + id).removeClass('teoola-hidden').hide().fadeIn('500');
}

$x(document).on('click', '.teoola-popup .teoola-btn-close,.teoola-popup .teoola-close', function () {
    ResetForms();
    HideModals();
});

/* COMMON POPUP & MODALS */

function  ResetForms(){
    ResetFormsFields();
    $x('.teoola-success').hide();
    $x('.teoola-body').removeClass('body-success');
    $x('.teoola-error').hide();
    $x('.teoola-body').removeClass('body-error');
    $x('.teoola-body .teoola-steps').hide();
    $x('.teoola-body .teoola-steps:first-child').show();
}

function ResetFormsFields(){
    $x('.contact_givenName, .contact_familyName, .contact_mobile, .contact_email, .contact_message, .teoolatag').val('');
}

$x(document).on('click', '.teoola-correct', function (e) {
    e.preventDefault();
    $x('.teoola-steps').hide();
    $x('.teoola-step2').fadeIn();
});

$x(document).on('click','.previous', function(e){
    $x(this).closest('.teoola').find('.teoola-steps:visible').hide().prev('.teoola-steps').fadeIn();
});

$x(document).on('click','.previous2', function(e){
    $x(this).closest('.teoola').find('.teoola-steps:visible').hide().prev('.teoola-steps').prev('.teoola-steps').fadeIn();
});

$x(document).on('click', '.next', function (e) {
    e.preventDefault();
    let missingFields = false;
    let currentStepBtn = $x(this);
    let currentStep = currentStepBtn.closest('.teoola-steps');

    // if needed, verify all field on current step before continue
    if(!$x(currentStepBtn).hasClass('no-verify')){
        currentStep.find('input, select, textarea').each((id, fieldElement) => {
            $x(fieldElement).removeClass('error');
            $x('.contact_' +  $x(fieldElement).attr('name') + '_val').html($x(fieldElement).val());
            if($x(fieldElement).hasClass('required')){
                if (!$x(fieldElement).val()) {
                    $x(fieldElement).addClass('error');
                    missingFields = true;
                }
                if($x(fieldElement).attr('type') == 'email' && !isEmail($x(fieldElement).val())){
                    $x(fieldElement).addClass('error');
                    missingFields = true;
                }
            }
        });
        if (missingFields) {
            return false;
        }
    }
    if (currentStepBtn.hasClass('next2')) {
        $x(this).closest('.teoola').find('.teoola-steps:visible').hide().next('.teoola-steps').next('.teoola-steps').fadeIn();
    } else {
        $x(this).closest('.teoola').find('.teoola-steps:visible').hide().next('.teoola-steps').fadeIn();
    }
    return true;
});

$x(document).on('click', '.teoola-step5 .submit', function (e) {
    teoolaSave($x(this));
});

$x(document).on('click', '.teoola-btn-retry', function () {
    teoolaSave($x(this));
});

$x(document).on('click', '.teoola-step3 .submit', function (e) {
    var gTag = $x(this).closest('.teoola').find('.teoolatag');
    gTag.removeClass('error');
    if (!gTag.val().length) {
        gTag.addClass('error');
        return false;
    }
    var posturl = "https://api.teoola.com/json_user_data.php?entity=" + userEntity + "&teoolatag=" + gTag.val() + "&key=" + userKey;
    $x.ajax({
        type: "POST",
        url: posturl,
        dataType: "json",
        success: (data) => {
            if (data.error != null) {
                gTag.addClass('error');
                gTag.val('Code invalide');
            } else {
                let step2 = $x(this).closest('.teoola-steps').prev();
                step2.find('.contact_givenName').val(data.givenName);
                step2.find('.contact_familyName').val(data.familyName);
                step2.find('.contact_mobile').val(data.mobile);
                step2.find('.contact_email').val(data.email);
                step2.find('.contact_notify').val(1);
                teoolaSave($x(this));
            }
        },
        error: function (data) {
            gTag.addClass('error');
            gTag.val('Code invalide');
        }
    });
});
/* EVENT */
$x(document).on('click', '.c-event-item', function (e) {
    if ($x(this).find('.description').is(':visible')) {
        $x('.c-event-item .description').slideUp();
    } else {
        $x('.c-event-item .description').slideUp();
        $x(this).find('.description').slideToggle();
    }
});

/* Core functions */
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

function isEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function teoolaSave(elt) {
    $x('.teoola-success').hide();
    $x('.teoola-body').removeClass('body-success');
    $x('.teoola-error').hide();
    $x('.teoola-body').removeClass('body-error');
    var posturl = "https://api.teoola.com/json_message.php?entity=" + userEntity + "&key=" + userKey;
    $x.ajax({
        type: "POST",
        url: posturl,
        dataType: "json",
        data: {
            message: elt.closest('.teoola').find('.contact_message').val(),
            teoolatag: elt.closest('.teoola').find('.teoolatag').val(),
            givenName: elt.closest('.teoola').find('.contact_givenName').val(),
            familyName: elt.closest('.teoola').find('.contact_familyName').val(),
            email: elt.closest('.teoola').find('.contact_email').val(),
            mobile: elt.closest('.teoola').find('.contact_mobile').val(),
            notify: elt.closest('.teoola').find('.contact_notify').val()
        },
        success: function (data) {
            $x('.contact_givenName, .contact_familyName, .contact_mobile, .contact_email, .contact_message, .teoolatag').val('');
            $x('.teoola-steps').hide();
            elt.closest('.teoola').find('.teoola-body').addClass('body-success');
            elt.closest('.teoola').find('.teoola-success').fadeIn();
        },
        error: function (data) {
            $x('.teoola-steps').hide();
            elt.closest('.teoola').find('.teoola-body').addClass('body-error');
            elt.closest('.teoola').find('.teoola-error').fadeIn();
        }
    });
}