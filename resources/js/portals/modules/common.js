window.$ = window.jQuery = require('jquery');
window.Popper = require('popper.js');
require('bootstrap');

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
