window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.Popper = require('@popperjs/core').default;
window.$ = window.jQuery = require('jquery');
window.bootstrap = require('bootstrap/dist/js/bootstrap.min.js');
window.counterUp = require('counterup2');
window.noUiSlider = require('nouislider/distribute/nouislider.min.js');
require('datatables.net-bs4');
require('datatables.net');
require('smooth-scrollbar');
window.Swal = require('sweetalert2');
require('flatpickr');
window.Scrollbar = require('smooth-scrollbar/dist/smooth-scrollbar')
window.ApexCharts = require('apexcharts');
window.waypoint = require('waypoints/lib/noframework.waypoints');
window.Swiper = require('swiper/swiper-bundle.min.js');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import 'filepond/dist/filepond.min.css'; // Import FilePond styles
import * as FilePond from 'filepond'; // Import FilePond
import FilePondPluginImageCrop from 'filepond-plugin-image-crop';

import * as Pintura from '@pqina/pintura';
import * as PinturaInput from '@pqina/pintura-input';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageResize from 'filepond-plugin-image-resize';
import FilePondPluginImageTransform from 'filepond-plugin-image-transform';
import FilePondPluginImageValidateSize from 'filepond-plugin-image-validate-size';
import FilePondPluginImageEdit from 'filepond-plugin-image-edit';
import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
import FilePondPluginImageEditor from '@pqina/filepond-plugin-image-editor';

import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginPdfPreview from 'filepond-plugin-pdf-preview';
import {
    openEditor,
    processImage,
    createDefaultImageReader,
    createDefaultImageWriter,
    createDefaultImageOrienter,
    legacyDataToImageState,
    getEditorDefaults,
} from '@pqina/pintura';

window.FilePond = FilePond;
window.Pintura = Pintura;
window.PinturaInput = PinturaInput;
window.FilePondPluginFileValidateType = FilePondPluginFileValidateType
window.FilePondPluginImageExifOrientation = FilePondPluginImageExifOrientation;
window.FilePondPluginImagePreview = FilePondPluginImagePreview;
window.FilePondPluginImageResize = FilePondPluginImageResize;
window.FilePondPluginImageTransform = FilePondPluginImageTransform;
window.FilePondPluginImageValidateSize = FilePondPluginImageValidateSize;
window.FilePondPluginImageEdit = FilePondPluginImageEdit;
window.FilePondPluginImageCrop = FilePondPluginImageCrop;
window.FilePondPluginFilePoster = FilePondPluginFilePoster;
window.FilePondPluginImageEditor = FilePondPluginImageEditor;
window.openEditor = openEditor;
window.processImage = processImage;
window.createDefaultImageReader = createDefaultImageReader;
window.createDefaultImageWriter = createDefaultImageWriter;
window.createDefaultImageOrienter = createDefaultImageOrienter;
window.legacyDataToImageState = legacyDataToImageState;
window.getEditorDefaults = getEditorDefaults;

window.FilePondPluginPdfPreview = FilePondPluginPdfPreview;
window.FilePondPluginFileValidateSize = FilePondPluginFileValidateSize;
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
