function update_cover () {

  'use strict';

  var CropperC = window.Cropper;
  var URLC = window.URL || window.webkitURL;
  var containerC = document.querySelector('.img-container-c');
  var imageC = containerC.getElementsByTagName('img').item(0);
  var dataXC = document.getElementById('dataXC');
  var dataYC = document.getElementById('dataYC');
  var dataHeightC = document.getElementById('dataHeightC');
  var dataWidthC = document.getElementById('dataWidthC');
  var dataRotateC = document.getElementById('dataRotateC');
  var dataScaleXC = document.getElementById('dataScaleXC');
  var dataScaleYC = document.getElementById('dataScaleYC');
  var optionsC = {
    aspectRatio: 3 / 1,
    preview: '.img-preview-c',
    ready: function (c) {
      console.log(c.type);
    },
    cropstart: function (c) {
      console.log(c.type, c.detail.action);
    },
    cropmove: function (c) {
      console.log(c.type, c.detail.action);
    },
    cropend: function (e) {
      console.log(c.type, c.detail.action);
    },
    crop: function (c) {
      var dataC = c.detail;

      console.log(c.type);
      dataXC.value = Math.round(dataC.x);
      dataYC.value = Math.round(dataC.y);
      dataHeightC.value = Math.round(dataC.height);
      dataWidthC.value = Math.round(dataC.width);
      dataRotateC.value = typeof dataC.rotate !== 'undefined' ? dataC.rotate : '';
      dataScaleXC.value = typeof dataC.scaleX !== 'undefined' ? dataC.scaleX : '';
      dataScaleYC.value = typeof dataC.scaleY !== 'undefined' ? dataC.scaleY : '';
    },
    zoom: function (c) {
      console.log(c.type, c.detail.ratio);
    }
  };
  var cropperC = new CropperC(imageC, optionsC);
  var uploadedImageTypeC = 'image/jpeg';
  var uploadedImageURLC;

  // Import image
  var inputImageC = document.getElementById('inputCover');

  if (URLC) {
    inputImageC.onchange = function () {
      var filesC = this.files;
      var fileC;

      if (cropperC && filesC && filesC.length) {
        fileC = filesC[0];

        if (/^image\/\w+/.test(fileC.type)) {
          uploadedImageTypeC = fileC.type;

          if (uploadedImageURLC) {
            URLC.revokeObjectURL(uploadedImageURLC);
          }

          imageC.src = uploadedImageURLC = URLC.createObjectURL(fileC);
          cropperC.destroy();
          cropperC = new CropperC(imageC, optionsC);
        } else {
          window.alert('Please choose an image file.');
        }
      }
    };
  } else {
    inputImageC.disabled = true;
    inputImageC.parentNode.className += ' disabled';
  }
};