(function () {
  "use strict";

  /* page loader */

  function hideLoader() {
    const loader = document.getElementById("loader");
    loader.classList.add("d-none")
  }

  window.addEventListener("load", hideLoader);
  /* page loader */

  /* tooltip */
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );

  /* popover  */
  const popoverTriggerList = document.querySelectorAll(
    '[data-bs-toggle="popover"]'
  );
  const popoverList = [...popoverTriggerList].map(
    (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
  );

  //switcher color pickers
  const pickrContainerPrimary = document.querySelector(
    ".pickr-container-primary"
  );
  const themeContainerPrimary = document.querySelector(
    ".theme-container-primary"
  );
  const pickrContainerBackground = document.querySelector(
    ".pickr-container-background"
  );
  const themeContainerBackground = document.querySelector(
    ".theme-container-background"
  );

  /* for theme primary */
  const nanoThemes = [
    [
      "nano",
      {
        defaultRepresentation: "RGB",
        components: {
          preview: true,
          opacity: false,
          hue: true,

          interaction: {
            hex: false,
            rgba: true,
            hsva: false,
            input: true,
            clear: false,
            save: false,
          },
        },
      },
    ],
  ];
  const nanoButtons = [];
  let nanoPickr = null;
  for (const [theme, config] of nanoThemes) {
    const button = document.createElement("button");
    button.innerHTML = theme;
    nanoButtons.push(button);

    button.addEventListener("click", () => {
      const el = document.createElement("p");
      //pickrContainerPrimary.appendChild(el);

      /* Delete previous instance */
      if (nanoPickr) {
        nanoPickr.destroyAndRemove();
      }

      /* Apply active class */
      for (const btn of nanoButtons) {
        btn.classList[btn === button ? "add" : "remove"]("active");
      }

      /* Create fresh instance */
      nanoPickr = new Pickr(
        Object.assign(
          {
            el,
            theme,
            default: "#38cab3",
          },
          config
        )
      );

      /* Set events */
      nanoPickr.on("changestop", (source, instance) => {
        let color = instance.getColor().toRGBA();
        let html = document.querySelector("html");
        html.style.setProperty(
          "--primary-rgb",
          `${Math.floor(color[0])}, ${Math.floor(color[1])}, ${Math.floor(
            color[2]
          )}`
        );
        /* theme color picker */
        localStorage.setItem(
          "primaryRGB",
          `${Math.floor(color[0])}, ${Math.floor(color[1])}, ${Math.floor(
            color[2]
          )}`
        );
        updateColors();
      });
    });

   // themeContainerPrimary.appendChild(button);
  }
  //nanoButtons[0].click();
  /* for theme primary */

  /* for theme background */
  const nanoThemes1 = [
    [
      "nano",
      {
        defaultRepresentation: "RGB",
        components: {
          preview: true,
          opacity: false,
          hue: true,

          interaction: {
            hex: false,
            rgba: true,
            hsva: false,
            input: true,
            clear: false,
            save: false,
          },
        },
      },
    ],
  ];
  const nanoButtons1 = [];
  let nanoPickr1 = null;
  for (const [theme, config] of nanoThemes) {
    const button = document.createElement("button");
    button.innerHTML = theme;
    nanoButtons1.push(button);

    button.addEventListener("click", () => {
      const el = document.createElement("p");
      pickrContainerBackground.appendChild(el);

      /* Delete previous instance */
      if (nanoPickr1) {
        nanoPickr1.destroyAndRemove();
      }

      /* Apply active class */
      for (const btn of nanoButtons) {
        btn.classList[btn === button ? "add" : "remove"]("active");
      }

      /* Create fresh instance */
      nanoPickr1 = new Pickr(
        Object.assign(
          {
            el,
            theme,
            default: "#38cab3",
          },
          config
        )
      );

      /* Set events */
      nanoPickr1.on("changestop", (source, instance) => {
        let color = instance.getColor().toRGBA();
        let html = document.querySelector("html");
        html.style.setProperty(
          "--body-bg-rgb",
          `${color[0]}, ${color[1]}, ${color[2]}`
        );
        document
          .querySelector("html")
          .style.setProperty(
            "--body-bg-rgb2",
            `${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14}`
          );
        document
          .querySelector("html")
          .style.setProperty(
            "--light-rgb",
            `${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14}`
          );
        document
          .querySelector("html")
          .style.setProperty(
            "--form-control-bg",
            `rgb(${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14})`
          );
        localStorage.removeItem("bgtheme");
        updateColors();
        html.setAttribute("data-theme-mode", "dark");
        html.setAttribute("data-menu-styles", "dark");
        html.setAttribute("data-header-styles", "dark");
        document.querySelector("#switcher-dark-theme").checked = true;
        localStorage.setItem(
          "bodyBgRGB",
          `${color[0]}, ${color[1]}, ${color[2]}`
        );
        localStorage.setItem(
          "bodylightRGB",
          `${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14}`
        );
      });
    });
   // themeContainerBackground.appendChild(button);
  }
  //nanoButtons1[0].click();
  /* for theme background */

  /* header theme toggle */
  function toggleTheme() {
    let html = document.querySelector("html");
    if (html.getAttribute("data-theme-mode") === "dark") {
      console.log("light");
      html.setAttribute("data-theme-mode", "light");
      html.setAttribute("data-header-styles", "light");
      html.setAttribute("data-menu-styles", "light");
      if (!localStorage.getItem("primaryRGB")) {
        html.setAttribute("style", "");
      }
      html.removeAttribute("data-bg-theme");
      document.querySelector("#switcher-light-theme").checked = true;
      document.querySelector("#switcher-menu-light").checked = true;
      document
        .querySelector("html")
        .style.removeProperty("--body-bg-rgb", localStorage.bodyBgRGB);
      checkOptions();

      html.style.removeProperty("--body-bg-rgb2");
      html.style.removeProperty('--body-bg-rgb');
      html.style.removeProperty("--light-rgb");
      html.style.removeProperty("--form-control-bg");
      html.style.removeProperty("--input-border");

      document.querySelector("#switcher-header-light").checked = true;
      document.querySelector("#switcher-menu-light").checked = true;
      document.querySelector("#switcher-light-theme").checked = true;
      document.querySelector("#switcher-background4").checked = false;
      document.querySelector("#switcher-background3").checked = false;
      document.querySelector("#switcher-background2").checked = false;
      document.querySelector("#switcher-background1").checked = false;
      document.querySelector("#switcher-background").checked = false;
      localStorage.removeItem("nowadarktheme");
      localStorage.removeItem("nowaMenu");
      localStorage.removeItem("nowaHeader");
      localStorage.removeItem("bodylightRGB");
      localStorage.removeItem("bodyBgRGB");
      if (localStorage.getItem("nowalayout") != "horizontal") {
        // html.setAttribute("data-menu-styles", "dark");
      }
      html.setAttribute("data-header-styles", "light");
    } else {
      html.setAttribute("data-theme-mode", "dark");
      html.setAttribute("data-header-styles", "dark");
      if (!localStorage.getItem("primaryRGB")) {
        html.setAttribute("style", "");
      }
      html.setAttribute("data-menu-styles", "dark");
      document.querySelector("#switcher-dark-theme").checked = true;
      document.querySelector("#switcher-menu-dark").checked = true;
      document.querySelector("#switcher-header-dark").checked = true;
      checkOptions();
      document.querySelector("#switcher-menu-dark").checked = true;
      document.querySelector("#switcher-header-dark").checked = true;
      document.querySelector("#switcher-dark-theme").checked = true;
      document.querySelector("#switcher-background4").checked = false;
      document.querySelector("#switcher-background3").checked = false;
      document.querySelector("#switcher-background2").checked = false;
      document.querySelector("#switcher-background1").checked = false;
      document.querySelector("#switcher-background").checked = false;
      localStorage.setItem("nowadarktheme", "true");
      localStorage.setItem("nowaMenu", "dark");
      localStorage.setItem("nowaHeader", "dark");
      localStorage.removeItem("bodylightRGB");
      localStorage.removeItem("bodyBgRGB");
    }
  }
 /*let layoutSetting = document.querySelector(".layout-setting");
  layoutSetting.addEventListener("click", toggleTheme);*/
  /* header theme toggle */

  /* Choices JS */
  document.addEventListener("DOMContentLoaded", function () {
    var genericExamples = document.querySelectorAll("[data-trigger]");
    for (let i = 0; i < genericExamples.length; ++i) {
      var element = genericExamples[i];
      new Choices(element, {
        allowHTML: true,
        searchEnabled: false,
        placeholderValue: "This is a placeholder set in the config",
        searchPlaceholderValue: "Search",
      });
    }
  });
  /* Choices JS */

  /* footer year */
  //document.getElementById("year").innerHTML = new Date().getFullYear();
  /* footer year */

  /* node waves */
 // Waves.attach(".btn-wave", ["waves-light"]);
 // Waves.init();
  /* node waves */

  /* card with close button */
  let DIV_CARD = ".card";
  let cardRemoveBtn = document.querySelectorAll(
    '[data-bs-toggle="card-remove"]'
  );
  cardRemoveBtn.forEach((ele) => {
    ele.addEventListener("click", function (e) {
      e.preventDefault();
      let $this = this;
      let card = $this.closest(DIV_CARD);
      card.remove();
      return false;
    });
  });
  /* card with close button */

  /* card with fullscreen */
  let cardFullscreenBtn = document.querySelectorAll(
    '[data-bs-toggle="card-fullscreen"]'
  );
  cardFullscreenBtn.forEach((ele) => {
    ele.addEventListener("click", function (e) {
      let $this = this;
      let card = $this.closest(DIV_CARD);
      card.classList.toggle("card-fullscreen");
      card.classList.remove("card-collapsed");
      e.preventDefault();
      return false;
    });
  });
  /* card with fullscreen */

  /* count-up */
  var i = 1;
  setInterval(() => {
    document.querySelectorAll(".count-up").forEach((ele) => {
      if (ele.getAttribute("data-count") >= i) {
        i = i + 1;
        ele.innerText = i;
      }
    });
  }, 10);
  /* count-up */

  /* back to top */
  const scrollToTop = document.querySelector(".scrollToTop");
  const $rootElement = document.documentElement;
  const $body = document.body;
  window.onscroll = () => {
    const scrollTop = window.scrollY || window.pageYOffset;
    const clientHt = $rootElement.scrollHeight - $rootElement.clientHeight;
    if (window.scrollY > 100) {
      scrollToTop.style.display = "flex";
    } else {
      scrollToTop.style.display = "none";
    }
  };
  scrollToTop.onclick = () => {
    window.scrollTo(0, 0);
  };
  /* back to top */

  /* header dropdowns scroll */
  var myHeaderShortcut = document.getElementById("header-shortcut-scroll");
  //new SimpleBar(myHeaderShortcut, { autoHide: true });

  var myHeadernotification = document.getElementById(
    "header-notification-scroll"
  );
 // new SimpleBar(myHeadernotification, { autoHide: true });

  var myHeaderCart = document.getElementById("header-cart-items-scroll");
 // new SimpleBar(myHeaderCart, { autoHide: true });
  /* header dropdowns scroll */
})();

/* full screen */
var elem = document.documentElement;
function openFullscreen() {
  let open = document.querySelector(".full-screen-open");
  let close = document.querySelector(".full-screen-close");

  if (
    !document.fullscreenElement &&
    !document.webkitFullscreenElement &&
    !document.msFullscreenElement
  ) {
    if (elem.requestFullscreen) {
      elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) {
      /* Safari */
      elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) {
      /* IE11 */
      elem.msRequestFullscreen();
    }
    close.classList.add("d-block");
    close.classList.remove("d-none");
    open.classList.add("d-none");
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.webkitExitFullscreen) {
      /* Safari */
      document.webkitExitFullscreen();
      console.log("working");
    } else if (document.msExitFullscreen) {
      /* IE11 */
      document.msExitFullscreen();
    }
    close.classList.remove("d-block");
    open.classList.remove("d-none");
    close.classList.add("d-none");
    open.classList.add("d-block");
  }
}
/* full screen */

/* toggle switches */
let customSwitch = document.querySelectorAll(".toggle");
customSwitch.forEach((e) =>
  e.addEventListener("click", () => {
    e.classList.toggle("on");
  })
);
/* toggle switches */

/* header dropdown close button */

/* for cart dropdown */
const headerbtn = document.querySelectorAll(".dropdown-item-close");
headerbtn.forEach((button) => {
  button.addEventListener("click", (e) => {
    e.preventDefault();
    e.stopPropagation();
    button.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
    document.getElementById("cart-data").innerText = `${
      document.querySelectorAll(".dropdown-item-close").length
    } Items`;
    document.getElementById("cart-icon-badge").innerText = `${
      document.querySelectorAll(".dropdown-item-close").length
    }`;
    console.log(
      document.getElementById("header-cart-items-scroll").children.length
    );
    if (document.querySelectorAll(".dropdown-item-close").length == 0) {
      let elementHide = document.querySelector(".empty-header-item");
      let elementShow = document.querySelector(".empty-item");
      elementHide.classList.add("d-none");
      elementShow.classList.remove("d-none");
    }
  });
});
/* for cart dropdown */

/* for notifications dropdown */
const headerbtn1 = document.querySelectorAll(".dropdown-item-close1");
headerbtn1.forEach((button) => {
  button.addEventListener("click", (e) => {
    e.preventDefault();
    e.stopPropagation();
    button.parentNode.parentNode.parentNode.parentNode.remove();
    document.getElementById("notifiation-data").innerText = `${
      document.querySelectorAll(".dropdown-item-close1").length
    } Unread`;
    document.getElementById("notification-icon-badge").innerText = `${
      document.querySelectorAll(".dropdown-item-close1").length
    }`;
    if (document.querySelectorAll(".dropdown-item-close1").length == 0) {
      let elementHide1 = document.querySelector(".empty-header-item1");
      let elementShow1 = document.querySelector(".empty-item1");
      elementHide1.classList.add("d-none");
      elementShow1.classList.remove("d-none");
    }
  });
});
/* for notifications dropdown */
var dataTableCount = $('.dataTables');
if(dataTableCount.length > 0){
    var dataTable = $('.dataTables').DataTable({
        "language": {
            "url": "/panel/assets/vendor/datatables/language/tr-TR.json",
        },
        "order":[]
    });
}
$('.get_slug').change(function () {
    slug_get($(this).val(), $(this).attr('focus_input'));
});
function deleteButton() {
    $('.deleteButton').click(function () {
        var button = $(this);
        Swal.fire({
            title: 'Veri Silinecek Emin Misiniz?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'Hayır',

        }).then((result) => {
            if (result.isConfirmed) {
                $('.preloader').show();

                var table = $(this).attr('data-table');
                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });


                $.ajax({

                    type: 'DELETE',

                    url: $(this).attr('data-action'),

                    data: {value: $(this).attr('data-id')},
                    success: function (data) {
                        if (data.type == "success") {
                            if (data.tableRefresh == 1) {
                                dataTable
                                    .row(button.parents('tr'))
                                    .remove()
                                    .draw();
                                table_write_data(data.listData, table);
                                if (typeof button_main_language == "function") {
                                    button_main_language();
                                }
                                if (typeof socialmediaaddmodal == "function") {
                                    socialmediaaddmodal();
                                }
                                if (typeof addressaddmodal == "function") {
                                    addressaddmodal()
                                }
                                if (typeof openhourseaddbutton == "function") {
                                    openhourseaddbutton()
                                }
                            }
                            $.each(data.success_message_array, function (i, data) {
                                Toastify({
                                    title: "success",
                                    text: data,
                                    style: {
                                        background: "green",
                                    },
                                    offset: {
                                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                        y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                    },
                                }).showToast();
                            })
                        } else {
                            $.each(data.error_message_array, function (i, data) {
                                Toastify({
                                    title: "Error",
                                    text: data,
                                    style: {
                                        background: "red",
                                    },
                                    offset: {
                                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                        y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                    },
                                }).showToast();
                            })
                        }
                        $('.preloader').hide();
                    },
                    error: function (data) {
                        Toastify({
                            title: "Error",
                            text: "An Error Occurred, please try again later.",
                            style: {
                                background: "red",
                            },
                            offset: {
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();

                        $('.preloader').hide();
                    }

                });
            }
        });

    });
}
function deleteButton2() {
    $('.deleteButton2').click(function () {
        var button = $(this);
        Swal.fire({
            title: 'Veri Silinecek Emin Misiniz?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'Hayır',
        }).then((result) => {
            if (result.isConfirmed) {
                $('.preloader').show();
                var id = $(this).attr('data-id');
                var table = $(this).attr('data-table');
                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });


                $.ajax({

                    type: 'DELETE',

                    url: $(this).attr('data-action'),

                    data: {value: $(this).attr('data-id')},
                    success: function (data) {
                        if (data.type == "success") {
                            $('.tabletr'+id).remove();
                            $.each(data.success_message_array, function (i, data) {
                                Toastify({
                                    title: "success",
                                    text: data,
                                    style: {
                                        background: "green",
                                    },
                                    offset: {
                                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                        y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                    },
                                }).showToast();
                            })
                        } else{
                            $.each(data.error_message_array, function (i, data) {
                                Toastify({
                                    title: "Error",
                                    text: data,
                                    style: {
                                        background: "red",
                                    },
                                    offset: {
                                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                        y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                    },
                                }).showToast();
                            })
                        }
                        $('.preloader').hide();
                    },
                    error: function (data) {
                        Toastify({
                            title: "Error",
                            text: "An Error Occurred, please try again later.",
                            style: {
                                background: "red",
                            },
                            offset: {
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();

                        $('.preloader').hide();
                    }

                });
            }
        });

    });
}

deleteButton();
deleteButton2();
var slug_get = function (value, focus_input) {

    $('.preloader').show();
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $.ajax({

        type: 'POST',

        url: '/Kpanel/name_convert_slug',

        data: {value: value},
        success: function (data) {
            if (data.type == "success") {
                $(focus_input).attr('placeholder', data.slug)
            } else {
                Toastify({
                    title: "Error",
                    text: "An Error Occurred, please try again later.",
                    style: {
                        background: "red",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
            }
            $('.preloader').hide();
        },
        error: function (data) {
            Toastify({
                title: "Error",
                text: "An Error Occurred, please try again later.",
                style: {
                    background: "red",
                },
                offset: {
                    x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                    y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                },
            }).showToast();

            $('.preloader').hide();
        }

    });
}
var table_write_data = function (listData, table) {
    var html = "";

    $.each(listData, function (i, data) {
        html += "<tr>";
        $.each(data, function (itwo, appendData) {
            if (itwo == "actions") {
                html += "<td class='text-right table-actions'>" + appendData + "</td>";
            } else {
                html += "<td>" + appendData + "</td>";
            }
        });
        html += "</tr>";
    });
    console.log(html);
    $(table + " tbody").html(html);
    deleteButton();
}
var table_write_data_append = function (listData, table) {
    var html = "";

    $.each(listData, function (i, data) {
        html += "<tr>";
        $.each(data, function (itwo, appendData) {
            console.log(itwo);
            if (itwo == "actions") {
                html += "<td class='text-right table-actions'>" + appendData + "</td>";
            } else {
                html += "<td>" + appendData + "</td>";
            }
        });
        html += "</tr>";
    });
    $(table + " tbody").append(html);
}

function Loader_toggle(t) {
    if (t == "show") {
        $('.preloader').show();
    } else {

        $('.preloader').hide();
    }
}

$('.view_data').click(function()    {
    Loader_toggle('show');
    var request_id = $(this).attr('data-requestid');
    var data_id = $(this).attr('data-id');
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $.ajax({

        type: 'POST',

        url: $(this).attr('data-action'),

        data : {data_id:data_id,id:request_id},
        success: function (data) {
            if(data.type == "success"){
                $('#view_data_modal .modal-body').html(data.viewData);
                $('#view_data_modal').modal('show');
                $.each(data.success_message_array, function (i, data){
                    Toastify({
                        title:"success",
                        text: data,
                        style: {
                            background: "green",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();
                })
                Loader_toggle('hide');
            }else{
                $.each(data.error, function (i, data){
                    Toastify({
                        title:"error",
                        text: data,
                        style: {
                            background: "red",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();
                    Loader_toggle('hide');
                })
            }

            Loader_toggle('hide');
        },
        error: function(data)
        {
            Toastify({
                title:"Error",
                text: "An Error Occurred, please try again later.",
                style: {
                    background: "red",
                },
                offset: {
                    x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                    y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                },
            }).showToast();

            Loader_toggle('hide');
        }

    });
})
