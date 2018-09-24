var fs = require('fs');

module.exports.name = "main";

module.exports.compress = false;

module.exports.hash = false;

module.exports.static = {
    dst: {
        js: 'dist/js',
        scss: 'css',
        css: 'dist/css',
        images: 'dist/images',
        fonts: 'dist/fonts'
    },
    src: {
        js: [
            'js/sticky.js',
            'js/ajax_validation.js',
            'js/modal.js',
            'js/main.js',
        ],
        scss: [
            'node_modules/bootstrap/scss/bootstrap.scss',
            'node_modules/bootstrap/scss/bootstrap-grid.scss',
            'scss/**/*.scss'
        ],
        css: [
            'css/*',
            'fonts/GothamPro/css/GothamPro.css',
        ],
        images: [
            'images/**/*.*'
        ],
        fonts: [
            'fonts/GothamPro/fonts/**/*',
        ]
    },
    vendors: {
        jquery: {
            js: [
                'node_modules/jquery/dist/jquery.min.js'
            ]
        },
        flow: {
            js: [
                'node_modules/@flowjs/flow.js/dist/flow.js'
            ]
        },
        fancybox: {
            js: [
                'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.js'
            ],
            css: [
                'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.css'
            ]
        },
        jquery_form: {
            js: [
                'node_modules/jquery-form/dist/jquery.form.min.js'
            ]
        }
    }
};