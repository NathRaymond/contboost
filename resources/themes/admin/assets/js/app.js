/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import './bootstrap';
import 'simplebar';
import * as coreui from '@coreui/coreui/dist/js/coreui'
import Tagify from '@yaireo/tagify'
import Sortable from 'sortablejs';
import Swal from 'sweetalert2';

window.Tagify = Tagify
window.coreui = coreui

const DotArtisan = function () {
    const convertToSlug = function (string) {
        const a = 'àáäâãåăæąçćčđďèéěėëêęğǵḧìíïîįıłḿǹńňñòóöôœøṕŕřßşśšșťțùúüûǘůűūųẃẍÿýźžż·/_,:;'
        const b = 'aaaaaaaaacccddeeeeeeegghiiiiiilmnnnnooooooprrsssssttuuuuuuuuuwxyyzzz------'
        const p = new RegExp(a.split('').join('|'), 'g')

        return string.toString().toLowerCase()
            .replace(/\s+/g, '-') // Replace spaces with -
            .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
            .replace(/&/g, '-and-') // Replace & with 'and'
            .replace(/[^\w\-]+/g, '') // Remove all non-word characters
            .replace(/\-\-+/g, '-') // Replace multiple - with single -
            .replace(/^-+/, '') // Trim - from start of text
            .replace(/-+$/, '') // Trim - from end of text
    },
        checkAll = function () {
            var boxes = document.getElementsByTagName("input");
            for (var x = 0; x < boxes.length; x++) {
                var obj = boxes[x];
                if (obj.type == "checkbox") {
                    if (obj.name != "check")
                        obj.checked = o.checked;
                }
            }
        },
        initTags = function () {
            if (document.querySelector('.tagging')) {
                const whitelisted = document.querySelector('.tagging').getAttribute("data-whitelisted") ? JSON
                    .parse(document.querySelector('.tagging').getAttribute("data-whitelisted")) : []
                new Tagify(document.querySelector('.tagging'), {
                    whitelist: whitelisted,
                    tagTextProp: 'name'
                });
            }
        },
        loading = function ($event) {
            $event.classList.add('d-none')
            $event.nextElementSibling.classList.remove('d-none');
        },
        stopLoading = function ($event) {
            $event.classList.remove('d-none')
            $event.nextElementSibling.classList.add('d-none');
        },
        serialize = function (form) {
            return Array.from(
                new FormData(form),
                function (e) { return e.map(encodeURIComponent).join('='); }
            ).join('&')
        },
        selectWidget = function () {
            document.querySelectorAll('.widgetSelection').forEach(e => {
                e.addEventListener('click', elem => {
                    elem.preventDefault();
                    const $parent = elem.target.parentElement;
                    $parent.querySelectorAll('.nav-link').forEach(element => {
                        element.classList.remove('active');
                    });
                    elem.target.classList.add('active');
                    $parent.parentElement.parentElement.querySelector('.card-footer').classList.remove('d-none');
                })
            });
        },
        addWidget = function ($addWidget) {
            if (!$addWidget) {
                return;
            }
            document.querySelectorAll('.addWidget').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const $this = e.target
                    const $parent = $this.parentElement;
                    const $nav = $parent.previousElementSibling.querySelector('.nav-link.active');
                    if ($nav) {
                        const $data = $nav.dataset;
                        loading($this);
                        axios.post($addWidget, $data)
                            .then((response) => {
                                stopLoading($this);
                                if (!response.data.success) {
                                    DotArtisan.sweetError(response.data.response.message); return;
                                }

                                document.querySelector(response.data.widget).insertAdjacentHTML("beforeend", response.data.response.html)
                                new coreui.Collapse(document.querySelector(response.data.toggle)).show();
                                saveWidget()
                                deleteWidget()
                            }, (error) => {
                                stopLoading($this);
                                console.log(error)
                            });
                    }
                });
            });
        },
        saveWidget = function () {
            document.querySelectorAll('.saveWidget').forEach(element => {
                element.addEventListener('click', e => {
                    e.preventDefault();
                    postWidgetData(e.target)
                })
            });
            document.querySelectorAll('.widget-form').forEach(element => {
                element.addEventListener('submit', e => {
                    e.preventDefault();
                    const saveBtn = e.target.parentElement.parentElement.querySelector('.saveWidget')
                    postWidgetData(saveBtn)
                })
            });
        },
        postWidgetData = function (e) {
            const $this = e;
            const $frmID = $this.getAttribute('data-id');
            const $frm = document.querySelector($frmID);
            const $saveWidget = $frm.getAttribute('action');
            if ($saveWidget) {
                loading($this)
                const $data = serialize($frm);
                axios.put($saveWidget, $data)
                    .then((response) => {
                        stopLoading($this)
                        if (!response.data.success) {
                            DotArtisan.sweetError(response.data.response.message); return;
                        }
                    }, (error) => {
                        stopLoading($this)
                        console.log(error)
                    });
            }
        },
        deleteWidget = function () {
            document.querySelectorAll('.deleteWidget').forEach(e => {
                e.addEventListener('click', elem => {
                    elem.preventDefault();
                    deleteWidgetAction(elem.target)
                })
            });
        },
        deleteWidgetAction = function (e) {
            const $this = e;
            const $parent = $this.parentElement;
            const $deleteWidget = $parent.getAttribute('action');
            if ($deleteWidget) {
                const $data = $this.dataset;
                loading($this);
                axios.delete($deleteWidget, $data)
                    .then((response) => {
                        stopLoading($this);
                        if (!response.data.success) {
                            DotArtisan.sweetError(response.data.response.message); return;
                        }
                        document.querySelector('#widget-' + $this.getAttribute('data-id')).remove()
                    }, (error) => {
                        stopLoading($this);
                        console.log(error)
                    });
            }
        },
        sortWidgets = function ($sortUrl) {
            if (!$sortUrl) {
                return;
            }
            document.querySelectorAll('.sortable-widgets-wrapper').forEach(el => {
                new Sortable(el, {
                    animation: 150,
                    handle: '.card .card-header',
                    ghostClass: 'ghost-class',
                    onSort: function (e) {
                        let items = e.to.children;
                        let orders = [];
                        for (var i = 0; i < items.length; i++) {
                            orders.push(items[i].getAttribute('data-id'));
                        }
                        axios.post($sortUrl, {
                            ids: orders
                        })
                            .then((response) => {
                                if (!response.data.success) {
                                    DotArtisan.sweetError(response.data.response.message); return;
                                }
                            }, (error) => {
                                console.log(error)
                            });
                    }
                });
            });
        },
        rangeSlider = function () {
            var slider = document.querySelectorAll('.range-slider');
            if (slider.length > 0) {
                slider.forEach(element => {
                    var range = element.querySelector('.range-slider__range'),
                        value = element.querySelector('.range-slider__value');
                    value.innerHTML = value.previousElementSibling.value
                    range.addEventListener('input', e => {
                        value.innerHTML = e.target.value
                    })

                });
            }
        };

    return {
        init: function () {
            initTags();
            this.initSlug();
            this.initTooltip();
        },
        initTooltip: function () {
            const tooltipTriggerList = document.querySelectorAll('[data-coreui-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new coreui.Tooltip(tooltipTriggerEl))
        },
        initSlug: function () {
            document.querySelectorAll('.slug_title').forEach(field => {
                field.addEventListener("keyup", e => {
                    const slug = convertToSlug(e.target.value)
                    e.target.parentElement.parentElement.parentElement.querySelector('.slug').value = slug
                });
            });
        },
        initWidgets: function ($addUrl, $sortUrl) {
            selectWidget();
            deleteWidget();
            saveWidget();
            addWidget($addUrl);
            sortWidgets($sortUrl);
        },
        sweetError: function (text, callback, options) {
            let defaults = {
                icon: 'error',
                title: 'Error',
                html: text,
                confirmButtonText: "Ok",
                allowOutsideClick: false,
                allowEscapeKey: false
            };
            defaults = Object.assign({}, defaults, options)
            Swal.fire(defaults).then(function (result) {
                if (typeof callback === 'function') {
                    callback();
                }
            });
        },
        sweetSuccess: function (text, callback, options) {
            let defaults = {
                icon: 'success',
                title: "Success",
                text: text,
                timer: 2000,
                confirmButtonText: "Ok",
                allowOutsideClick: false,
                allowEscapeKey: false,
            };
            defaults = Object.assign({}, defaults, options)
            Swal.fire(defaults).then(function (result) {
                if (typeof callback === 'function') {
                    callback();
                }
            });
        },
    }
}();

window.DotArtisan = DotArtisan;
DotArtisan.init();
