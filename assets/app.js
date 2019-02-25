$(document).ready(function () {
    $("body").on("click", "[data-ma-action]", function (e) {
        function launchIntoFullscreen(element) {
            element.requestFullscreen ? element.requestFullscreen() : element.mozRequestFullScreen ? element.mozRequestFullScreen() : element.webkitRequestFullscreen ? element.webkitRequestFullscreen() : element.msRequestFullscreen && element.msRequestFullscreen()
        }
        e.preventDefault();
        var $this = $(this)
            , action = $(this).data("ma-action");
        switch (action) {
            case "sidebar-open":
                var target = $this.data("ma-target")
                    , backdrop = '<div data-ma-action="sidebar-close" class="ma-backdrop" />';
                $("body").addClass("sidebar-toggled"),
                    $("#header, #header-alt, #main").append(backdrop),
                    $this.addClass("toggled"),
                    $(target).addClass("toggled");
                break;
            case "sidebar-close":
                $("body").removeClass("sidebar-toggled"),
                    $(".ma-backdrop").remove(),
                    $(".sidebar, .ma-trigger").removeClass("toggled");
                break;
            case "submenu-toggle":
                $this.next().slideToggle(200),
                    $this.parent().toggleClass("toggled");
                break;
            case "search-open":
                $("#header").addClass("search-toggled"),
                    $("#top-search-wrap input").focus();
                break;
            case "search-close":
                $("#header").removeClass("search-toggled");
                break;
            case "clear-notification":
                var x = $this.closest(".list-group")
                    , y = x.find(".list-group-item")
                    , z = y.size();
                $this.parent().fadeOut(),
                    x.find(".list-group").prepend('<i class="grid-loading hide-it"></i>'),
                    x.find(".grid-loading").fadeIn(1500);
                var w = 0;
                y.each(function () {
                    var z = $(this);
                    setTimeout(function () {
                        z.addClass("animated fadeOutRightBig").delay(1e3).queue(function () {
                            z.remove()
                        })
                    }, w += 150)
                }),
                    setTimeout(function () {
                        $("#notifications").addClass("empty")
                    }, 150 * z + 200);
                break;
            case "fullscreen":
                launchIntoFullscreen(document.documentElement);
                break;
            case "clear-localstorage":
                swal({
                    title: "Are you sure?",
                    text: "All your saved localStorage values will be removed",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: !1
                }, function () {
                    localStorage.clear(),
                        swal("Done!", "localStorage is cleared", "success")
                });
                break;
            case "print":
                window.print();
                break;
            case "login-switch":
                var loginblock = $this.data("ma-block")
                    , loginParent = $this.closest(".lc-block");
                loginParent.removeClass("toggled"),
                    setTimeout(function () {
                        $(loginblock).addClass("toggled")
                    });
                break;
            case "profile-edit":
                $this.closest(".pmb-block").toggleClass("toggled");
                break;
            case "profile-edit-cancel":
                $(this).closest(".pmb-block").removeClass("toggled");
                break;
            case "action-header-open":
                ahParent = $this.closest(".action-header").find(".ah-search"),
                    ahParent.fadeIn(300),
                    ahParent.find(".ahs-input").focus();
                break;
            case "action-header-close":
                ahParent.fadeOut(300),
                    setTimeout(function () {
                        ahParent.find(".ahs-input").val("")
                    }, 350);
                break;
            case "wall-comment-open":
                $this.closest(".wic-form").hasClass("toggled") || $this.closest(".wic-form").addClass("toggled");
                break;
            case "wall-comment-close":
                $this.closest(".wic-form").find("textarea").val(""),
                    $this.closest(".wic-form").removeClass("toggled");
                break;
            case "todo-form-open":
                $this.closest(".t-add").addClass("toggled");
                break;
            case "todo-form-close":
                $this.closest(".t-add").removeClass("toggled"),
                    $this.closest(".t-add").find("textarea").val("")
        }
    })
});