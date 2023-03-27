/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import './bootstrap';
import 'simplebar';
import Cookies from 'js-cookie'
import ClipboardJS from 'clipboard';
import { Tooltip, Toast, Popover, Alert } from 'bootstrap';

import.meta.glob([
    '../images/**',
]);


const FrontApp = function () {
    const clipboardCopy = function () {
        if (document.querySelectorAll('.copy-clipboard').length > 0) {
            new ClipboardJS('.copy-clipboard');
        }
    },
        appBootstrap = function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new Tooltip(tooltipTriggerEl)
            })

        },
        initDarkMode = function () {
            if (!document.querySelector('.btn-mode')) {
                return;
            }
            var button = document.querySelector('.btn-mode');
            var themeMode = document.querySelector('.theme-mode');
            var AIEditor = document.querySelector('.toastui-editor-defaultUI');
            button.addEventListener('click', function () {
                if (themeMode.classList.contains('theme-mode-dark')) {
                    themeMode.classList.remove('theme-mode-dark')
                    themeMode.classList.add('theme-mode-light');
                    if (AIEditor) {
                        AIEditor.classList.remove('toastui-editor-light')
                        AIEditor.classList.add('toastui-editor-dark')
                    }
                } else {
                    themeMode.classList.add('theme-mode-dark')
                    themeMode.classList.remove('theme-mode-light');
                    if (AIEditor) {
                        AIEditor.classList.remove('toastui-editor-dark')
                        AIEditor.classList.add('toastui-editor-light')
                    }
                }
            });

            // change darkmode
            const STORAGE_KEY = 'siteMode';
            const modeToggleButton = document.querySelector('.js-mode-toggle');

            const applySetting = passedSetting => {
                let currentSetting = passedSetting || Cookies.get(STORAGE_KEY);
                if (currentSetting) {
                    document.documentElement.setAttribute('theme-mode', currentSetting);
                }
            };

            const toggleSetting = () => {
                let currentSetting = Cookies.get(STORAGE_KEY) === 'dark' ? 'light' : 'dark';
                Cookies.set('siteMode', currentSetting)
                return currentSetting;
            };
            modeToggleButton.addEventListener('click', evt => {
                evt.preventDefault();
                applySetting(toggleSetting());
            });
            applySetting();
        };

    return {
        init: function () {
            clipboardCopy();
            appBootstrap();
            initDarkMode();
            this.hideLoader();
        },
        showLoader: function () {
            if (document.querySelector('#app-loader')) {
                document.querySelector('#app-loader').classList.remove('d-none')
            }
        },
        hideLoader: function () {
            if (document.querySelector('#app-loader')) {
                document.querySelector('#app-loader').classList.add('d-none')
            }
        },
        serializeForm: function (form) {
            let requestArray = [];
            form.querySelectorAll('[name]').forEach((elem) => {
                requestArray.push(elem.name + '=' + elem.value);
            });
            if (requestArray.length > 0)
                return requestArray.join('&');
            else
                return false;
        },
        toastError: function (message) {
            const html = `<div class="toast toast-danger show" role="alert" aria-live="assertive" data-bs-delay="3000" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">${message}</div>
                                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>`;
            this.initToast(html)
        },
        toastSuccess: function (message) {
            const html = `<div class="toast toast-success show" role="alert" aria-live="assertive" data-bs-delay="3000" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">${message}</div>
                                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>`;
            this.initToast(html)
        },
        initToast: function (html) {
            if (!document.querySelector('.toast-container')) return;
            var child = document.createElement('div');
            child.innerHTML = html;
            child = child.firstChild;

            document.querySelector('.toast-container').prepend(child)
        },

    }
}();

window.FrontApp = FrontApp
document.addEventListener("DOMContentLoaded", function (event) {
    FrontApp.init();
});
