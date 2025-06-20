$(function () {
    "use strict";

    // Kondisikan panggilan MorrisArea()
    if ($("#m_area_chart").length) {
        MorrisArea();
    }

    // ===========================================
    // LOGIKA SIDEBAR RESPONSIVE UNTUK MOBILE (Alpino Compatible)
    // ===========================================

    // 1. Tangani klik pada tombol navbar toggler (ikon hamburger)
    $(".navbar-toggler").on("click", function (e) {
        e.stopPropagation();
        const $body = $("body");
        const currentWindowWidth = $(window).width();

        $body.toggleClass("overlay-open");

        if ($body.hasClass("overlay-open")) {
            $body.removeClass("ls-closed");
        } else {
            if (currentWindowWidth < 1170) {
                $body.addClass("ls-closed");
            }
        }
    });

    // 2. Tangani klik pada overlay gelap atau di luar sidebar untuk menutup sidebar
    $(document).on("click", function (e) {
        const $target = $(e.target);
        const $body = $("body");
        const currentWindowWidth = $(window).width();

        if (
            $body.hasClass("overlay-open") &&
            !$target.closest("#leftsidebar").length &&
            !$target.is(".navbar-toggler") &&
            !$target.closest(".navbar-toggler").length
        ) {
            $body.removeClass("overlay-open");

            if (currentWindowWidth < 1170) {
                $body.addClass("ls-closed");
            }
        }
    });

    // Opsional: Tutup sidebar jika ada item menu sidebar yang diklik (untuk mobile)
    $("#leftsidebar .menu ul.list a").on("click", function () {
        const $body = $("body");
        if ($(window).width() < 1170) {
            $body.removeClass("overlay-open");
            $body.addClass("ls-closed");
        }
    });

    // Perbaikan untuk memastikan sidebar tertutup atau disesuaikan saat resize jendela
    $(window).on("resize", function () {
        const $body = $("body");
        const currentWindowWidth = $(window).width();

        if (currentWindowWidth >= 1170) {
            $body.removeClass("overlay-open");
            $body.removeClass("ls-closed");
        } else {
            if (!$body.hasClass("overlay-open")) {
                $body.addClass("ls-closed");
            }
        }
    });
});

$(function () {
    // Kondisikan panggilan Sparkline Pie
    if ($(".sparkline-pie").length) {
        $(".sparkline-pie").sparkline("html", {
            type: "pie",
            offset: 90,
            width: "138px",
            height: "138px",
            sliceColors: ["#454c56", "#61ccb7", "#5589cd"],
        });
    }

    // Kondisikan panggilan Sparkline 14
    if ($("#sparkline14").length) {
        $("#sparkline14").sparkline([8, 2, 3, 7, 6, 5, 2, 1, 4, 8], {
            type: "line",
            width: "100%",
            height: "28",
            lineColor: "#3f7dc5",
            fillColor: "transparent",
            spotColor: "#000",
            lineWidth: 1,
            spotRadius: 2,
        });
    }

    // Kondisikan panggilan Sparkline 15
    if ($("#sparkline15").length) {
        $("#sparkline15").sparkline([2, 3, 9, 1, 2, 5, 4, 7, 8, 2], {
            type: "line",
            width: "100%",
            height: "28",
            lineColor: "#e66990",
            fillColor: "transparent",
            spotColor: "#000",
            lineWidth: 1,
            spotRadius: 2,
        });
    }

    // Kondisikan panggilan Sparkbar
    if ($(".sparkbar").length) {
        $(".sparkbar").sparkline("html", {
            type: "bar",
            height: "100",
            width: "100%",
            barSpacing: "20",
            barColor: "#e56590",
            negBarColor: "#4ac2ae",
            responsive: true,
        });
    }
});

// Morris-chart
function MorrisArea() {
    Morris.Area({
        element: "m_area_chart",
        data: [
            {
                period: "2011",
                Visit: 45,
                Sales: 75,
            },
            {
                period: "2012",
                Visit: 130,
                Sales: 110,
            },
            {
                period: "2013",
                Visit: 80,
                Sales: 60,
            },
            {
                period: "2014",
                Visit: 78,
                Sales: 205,
            },
            {
                period: "2015",
                Visit: 180,
                Sales: 124,
            },
            {
                period: "2016",
                Visit: 105,
                Sales: 100,
            },
            {
                period: "2017",
                Visit: 210,
                Sales: 180,
            },
        ],
        xkey: "period",
        ykeys: ["Visit", "Sales"],
        labels: ["Visit", "Sales"],
        pointSize: 3,
        fillOpacity: 0,
        pointStrokeColors: ["#191f28", "#6c7787"],
        behaveLikeLine: true,
        gridLineColor: "#e0e0e0",
        lineWidth: 2,
        hideHover: "auto",
        lineColors: ["#191f28", "#6c7787"],
        resize: true,
    });
}

//======
$(window).on("scroll", function () {
    $(".card .sparkline").each(function () {
        var imagePos = $(this).offset().top;

        var topOfWindow = $(window).scrollTop();
        if (imagePos < topOfWindow + 400) {
            $(this).addClass("pullUp");
        }
    });
});

/*VectorMap Init*/

$(function () {
    "use strict";
    var mapData = {
        US: 298,
        SA: 200,
        AU: 760,
        IN: 2000000,
        GB: 120,
    };

    // Kondisikan panggilan VectorMap
    if ($("#world-map-markers2").length > 0) {
        $("#world-map-markers2").vectorMap({
            map: "world_mill_en",
            backgroundColor: "transparent",
            borderColor: "#fff",
            borderOpacity: 0.25,
            borderWidth: 0,
            color: "#e6e6e6",
            regionStyle: {
                initial: {
                    fill: "#e9eef0",
                },
            },

            markerStyle: {
                initial: {
                    r: 8,
                    fill: "#3c434d",
                    "fill-opacity": 0.9,
                    stroke: "#fff",
                    "stroke-width": 5,
                    "stroke-opacity": 0.8,
                },
                hover: {
                    stroke: "#fff",
                    "fill-opacity": 1,
                    "stroke-width": 5,
                },
            },

            markers: [
                {
                    latLng: [21.0, 78.0],
                    name: "INDIA : 350",
                },
                {
                    latLng: [-33.0, 151.0],
                    name: "Australia : 250",
                },
                {
                    latLng: [36.77, -119.41],
                    name: "USA : 250",
                },
                {
                    latLng: [55.37, -3.41],
                    name: "UK   : 250",
                },
                {
                    latLng: [25.2, 55.27],
                    name: "UAE : 250",
                },
                {
                    latLng: [491, 540.93],
                    name: "CANADA : 250",
                },
                {
                    latLng: [452, 256.55],
                    name: "FRANCE : 50",
                },
                {
                    latLng: [445, 610.79],
                    name: "CHINA : 50",
                },
            ],

            series: {
                regions: [
                    {
                        values: {
                            US: "#a4e2da",
                            SA: "#cba1de",
                            AU: "#95d3ff",
                            IN: "#ffd89a",
                            GB: "#ff9a9a",
                            CA: "#999999",
                            FR: "#999999",
                            CN: "#999999",
                        },
                        attribute: "fill",
                    },
                ],
            },
            hoverOpacity: null,
            normalizeFunction: "linear",
            zoomOnScroll: false,
            scaleColors: ["#000000", "#000000"],
            selectedColor: "#000000",
            selectedRegions: [],
            enableZoom: false,
            hoverColor: "#fff",
        });
    }
});

function initSparkline() {
    $(".sparkline").each(function () {
        var a = $(this);
        a.sparkline("html", a.data());
    });
}
function initCounters() {
    $(".count-to").countTo();
}
function skinChanger() {
    $(".right-sidebar .choose-skin li").on("click", function () {
        var a = $("body"),
            b = $(this),
            c = $(".right-sidebar .choose-skin li.active").data("theme");
        $(".right-sidebar .choose-skin li").removeClass("active"),
            a.removeClass("theme-" + c),
            b.addClass("active"),
            a.addClass("theme-" + b.data("theme"));
    });
}
function CustomScrollbar() {
    $(".right_menu .slim_scroll").slimscroll({
        height: "calc(100vh - 30px)",
        color: "rgba(0,0,0,0.1)",
        position: "right",
        size: "2px",
        alwaysVisible: !1,
        borderRadius: "3px",
        railBorderRadius: "0",
    }),
        $(".cwidget-scroll").slimscroll({
            height: "306px",
            color: "rgba(0,0,0,0.4)",
            size: "2px",
            alwaysVisible: !1,
            borderRadius: "3px",
            railBorderRadius: "2px",
        }),
        $(".right-sidebar .slim_scroll").slimscroll({
            height: "calc(100vh - 100px)",
            color: "rgba(0,0,0,0.4)",
            size: "2px",
            alwaysVisible: !1,
            borderRadius: "3px",
            railBorderRadius: "0",
        });
}
function CustomPageJS() {
    $(".boxs-close").on("click", function () {
        $(this).parents(".card").addClass("closed").fadeOut();
    }),
        $(".theme-light-dark .t-dark").on("click", function () {
            $("body").toggleClass("menu_dark");
        }),
        $(".menu-sm").on("click", function () {
            $("body").toggleClass("menu_sm");
        }),
        $(".minileftbar .notifications").on("click", function () {
            $(".right_menu .notif-menu")
                .toggleClass("open stretchRight")
                .siblings()
                .removeClass("open stretchRight"),
                $(".right_menu .notif-menu").hasClass("open")
                    ? $(".overlay").fadeIn()
                    : $(".overlay").fadeOut();
        }),
        $(".minileftbar .task").on("click", function () {
            $(".right_menu .task-menu")
                .toggleClass("open stretchRight")
                .siblings()
                .removeClass("open stretchRight"),
                $(".right_menu .task-menu").hasClass("open")
                    ? $(".overlay").fadeIn()
                    : $(".overlay").fadeOut();
        }),
        $(".minileftbar .menuapp-btn").on("click", function () {
            $(".right_menu .menu-app")
                .toggleClass("open stretchRight")
                .siblings()
                .removeClass("open stretchRight"),
                $(".right_menu .menu-app").hasClass("open")
                    ? $(".overlay").fadeIn()
                    : $(".overlay").fadeOut();
        }),
        $(".minileftbar .js-right-sidebar").on("click", function () {
            $(".right_menu #rightsidebar")
                .toggleClass("open stretchRight")
                .siblings()
                .removeClass("open stretchRight"),
                $(".right_menu #rightsidebar").hasClass("open")
                    ? $(".overlay").fadeIn()
                    : $(".overlay").fadeOut();
        }),
        $(".minileftbar .bars").on("click", function () {
            $(".right_menu .sidebar")
                .toggleClass("open stretchRight")
                .siblings()
                .removeClass("open stretchRight"),
                $(".right_menu .sidebar").hasClass("open stretchRight")
                    ? $(".overlay").fadeIn()
                    : $(".overlay").fadeOut();
        }),
        $(".overlay").on("click", function () {
            $(".open.stretchRight").removeClass("open stretchRight"),
                $(this).fadeOut();
        }),
        $(".btn_overlay").on("click", function () {
            $(".overlay_menu").fadeToggle(200),
                $(this).toggleClass("btn-open").toggleClass("btn-close");
        }),
        $(".overlay_menu .btn").on("click", function () {
            $(".overlay_menu").fadeToggle(200),
                $(".overlay_menu button.btn")
                    .toggleClass("btn-open")
                    .toggleClass("btn-close"),
                (open = !1);
        }),
        $(".form-control")
            .on("focus", function () {
                $(this).parent(".input-group").addClass("input-group-focus");
            })
            .on("blur", function () {
                $(this).parent(".input-group").removeClass("input-group-focus");
            });
}
if ("undefined" == typeof jQuery)
    throw new Error("jQuery plugins need to be before this file");
$(function () {
    "use strict";
    $.AdminAlpino.browser.activate(),
        $.AdminAlpino.leftSideBar.activate(),
        $.AdminAlpino.select.activate(),
        setTimeout(function () {
            $(".page-loader-wrapper").fadeOut();
        }, 50);
}),
    ($.AdminAlpino = {}),
    ($.AdminAlpino.options = {
        colors: {
            red: "#ec3b57",
            pink: "#E91E63",
            purple: "#ba3bd0",
            deepPurple: "#673AB7",
            indigo: "#3F51B5",
            blue: "#2196f3",
            lightBlue: "#03A9F4",
            cyan: "#00bcd4",
            green: "#4CAF50",
            lightGreen: "#8BC34A",
            yellow: "#ffe821",
            orange: "#FF9800",
            deepOrange: "#f83600",
            grey: "#9E9E9E",
            blueGrey: "#607D8B",
            black: "#000000",
            blush: "#dd5e89",
            white: "#ffffff",
        },
        leftSideBar: {
            scrollColor: "rgba(0,0,0,0.5)",
            scrollWidth: "4px",
            scrollAlwaysVisible: !1,
            scrollBorderRadius: "0",
            scrollRailBorderRadius: "0",
        },
    }),
    ($.AdminAlpino.leftSideBar = {
        activate: function () {
            var a = this,
                b = $("body"),
                c = $(".overlay"); // This overlay is likely managed by Alpino's core JS
            $(window).on("click", function (d) {
                var e = $(d.target);
                "i" === d.target.nodeName.toLowerCase() &&
                    (e = $(d.target).parent()),
                    !e.hasClass("bars") && // This is likely Alpino's specific sidebar toggle icon
                        a.isOpen() && // Checks if body has 'overlay-open'
                        0 === e.parents("#leftsidebar").length &&
                        (e.hasClass("js-right-sidebar") || c.fadeOut(), // Fades out THEIR overlay
                        b.removeClass("overlay-open")); // Removes THEIR class 'overlay-open'
            }),
                $.each($(".menu-toggle.toggled"), function (a, b) {
                    $(b).next().slideToggle(0);
                }),
                $.each($(".menu .list li.active"), function (a, b) {
                    var c = $(b).find("a:eq(0)");
                    c.addClass("toggled"), c.next().show();
                }),
                $(".menu-toggle").on("click", function (a) {
                    var b = $(this),
                        c = b.next();
                    if ($(b.parents("ul")[0]).hasClass("list")) {
                        var d = $(a.target).hasClass("menu-toggle")
                            ? a.target
                            : $(a.target).parents(".menu-toggle");
                        $.each(
                            $(".menu-toggle.toggled").not(d).next(),
                            function (a, b) {
                                $(b).is(":visible") &&
                                    ($(b).prev().toggleClass("toggled"),
                                    $(b).slideUp());
                            }
                        );
                    }
                    b.toggleClass("toggled"), c.slideToggle(320);
                }),
                a.checkStatuForResize(!0),
                $(window).resize(function () {
                    a.checkStatuForResize(!1);
                }),
                Waves.attach(".menu .list a", ["waves-block"]),
                Waves.init();
        },
        checkStatuForResize: function (a) {
            var b = $("body"),
                c = $(".minileftbar .menu_list .bars"),
                d = b.width();
            a &&
                b
                    .find(".content, .sidebar")
                    .addClass("no-animate")
                    .delay(1e3)
                    .queue(function () {
                        $(this).removeClass("no-animate").dequeue();
                    }),
                d < 1170
                    ? (b.addClass("ls-closed"), c.fadeIn())
                    : (b.removeClass("ls-closed"), c.fadeOut());
        },
        isOpen: function () {
            return $("body").hasClass("overlay-open");
        },
    }),
    ($.AdminAlpino.select = {
        activate: function () {
            $.fn.selectpicker && $("select:not(.ms)").selectpicker();
        },
    });
var edge = "Microsoft Edge",
    ie10 = "Internet Explorer 10",
    ie11 = "Internet Explorer 11",
    opera = "Opera",
    firefox = "Mozilla Firefox",
    chrome = "Google Chrome",
    safari = "Safari";
($.AdminAlpino.browser = {
    activate: function () {
        var a = this;
        "" !== a.getClassName() && $("html").addClass(a.getClassName());
    },
    getBrowser: function () {
        var a = navigator.userAgent.toLowerCase();
        return /edge/i.test(a)
            ? edge
            : /rv:11/i.test(a)
            ? ie11
            : /msie 10/i.test(a)
            ? ie10
            : /opr/i.test(a)
            ? opera
            : /chrome/i.test(a)
            ? chrome
            : /firefox/i.test(a)
            ? firefox
            : navigator.userAgent.match(/Version\/[\d\.]+.*Safari/)
            ? safari
            : void 0;
    },
    getClassName: function () {
        var a = this.getBrowser();
        return a === edge
            ? "edge"
            : a === ie11
            ? "ie11"
            : a === ie10
            ? "ie10"
            : a === opera
            ? "opera"
            : a === chrome
            ? "chrome"
            : a === firefox
            ? "firefox"
            : a === safari
            ? "safari"
            : "";
    },
}),
    $(function () {
        "use strict";
        skinChanger(),
            CustomScrollbar(),
            initSparkline(),
            initCounters(),
            CustomPageJS();
    });
var Tawk_API = Tawk_API || {},
    Tawk_LoadStart = new Date();
!(function () {
    var a = document.createElement("script"),
        b = document.getElementsByTagName("script")[0];
    (a.async = !0),
        (a.src = "https://embed.tawk.to/5c6d4867f324050cfe342c69/default"),
        (a.charset = "UTF-8"),
        a.setAttribute("crossorigin", "*"),
        b.parentNode.insertBefore(a, b);
})(),
    $(function () {
        "use strict";
        function a() {
            var a = screenfull.element;
            $("#status").text("Is fullscreen: " + screenfull.isFullscreen),
                a &&
                    $("#element").text(
                        "Element: " + a.localName + (a.id ? "#" + a.id : "")
                    ),
                screenfull.isFullscreen ||
                    ($("#external-iframe").remove(),
                    (document.body.style.overflow = "auto"));
        }
        if (
            ($("#supported").text("Supported/allowed: " + !!screenfull.enabled),
            !screenfull.enabled)
        )
            return !1;
        $("#request").on("click", function () {
            screenfull.request($("#container")[0]);
        }),
            $("#exit").on("click", function () {
                screenfull.exit();
            }),
            $('[data-provide~="boxfull"]').on("click", function () {
                screenfull.toggle($(".box")[0]);
            }),
            $('[data-provide~="fullscreen"]').on("click", function () {
                screenfull.toggle($("#container")[0]);
            });
        var b = '[data-provide~="boxfull"]',
            b = '[data-provide~="fullscreen"]';
        $(b).each(function () {
            $(this).data("fullscreen-default-html", $(this).html());
        }),
            document.addEventListener(
                screenfull.raw.fullscreenchange,
                function () {
                    screenfull.isFullscreen
                        ? $(b).each(function () {
                              $(this).addClass("is-fullscreen");
                          })
                        : $(b).each(function () {
                              $(this).removeClass("is-fullscreen");
                          });
                }
            ),
            screenfull.on("change", a),
            a();
    });
