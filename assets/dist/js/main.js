/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/src/js/_custom-page.js":
/*!***************************************!*\
  !*** ./assets/src/js/_custom-page.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\njQuery(document).ready(function ($) {\n  var $tmpRow = $('<tr class=\"custom-page__grid__row custom-page__grid__row--after\"></tr>');\n  var $currentClickedElement = void 0;\n  var remoteContent = [];\n  $('[data-ajax-html-enabled=\"true\"]').click(function (e) {\n    e.preventDefault(); // https://css-tricks.com/snippets/jquery/compare-jquery-objects/\n\n    if ($currentClickedElement && $currentClickedElement[0] === $(this)[0]) {\n      $tmpRow.slideToggle(300);\n    } else {\n      if ($currentClickedElement) {\n        $currentClickedElement.removeClass('active');\n      }\n\n      var $currentRow = $(this).parents('.custom-page__grid__row');\n      $tmpRow.html('<td colspan=\"' + $currentRow.find('> td').length + '\"></td>');\n      $currentRow.after($tmpRow);\n      $tmpRow.addClass('processing').removeClass('error');\n      $tmpRow.slideDown(300);\n      var ajaxUrl = $(this).data('ajax-html-url');\n      $currentClickedElement = $(this);\n      $currentClickedElement.addClass('active');\n\n      if (remoteContent[ajaxUrl]) {\n        $('.custom-page__grid__row--after').removeClass('processing');\n        $('.custom-page__grid__row--after > td').html(remoteContent[ajaxUrl]);\n      } else {\n        $.ajax({\n          url: ajaxUrl,\n          dataType: 'html',\n          context: $(this)\n        }).success(function (htmlData) {\n          var ajaxUrl = $(this).data('ajax-html-url');\n          remoteContent[ajaxUrl] = htmlData;\n          $('.custom-page__grid__row--after').removeClass('processing');\n          $('.custom-page__grid__row--after > td').html(htmlData);\n        }).error(function () {\n          $('.custom-page__grid__row--after').removeClass('processing').addClass('error');\n          $('.custom-page__grid__row--after > td').html($(this).data('ajax-html-error-message'));\n        });\n      }\n    }\n  });\n}(jQuery));\n\n//# sourceURL=webpack:///./assets/src/js/_custom-page.js?");

/***/ }),

/***/ "./assets/src/js/main.js":
/*!*******************************!*\
  !*** ./assets/src/js/main.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\n__webpack_require__(/*! ./_custom-page */ \"./assets/src/js/_custom-page.js\");\n\n//# sourceURL=webpack:///./assets/src/js/main.js?");

/***/ }),

/***/ "./assets/src/scss/main.scss":
/*!***********************************!*\
  !*** ./assets/src/scss/main.scss ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("// extracted by mini-css-extract-plugin\n\n//# sourceURL=webpack:///./assets/src/scss/main.scss?");

/***/ }),

/***/ 0:
/*!*****************************************************************!*\
  !*** multi ./assets/src/js/main.js ./assets/src/scss/main.scss ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("__webpack_require__(/*! ./assets/src/js/main.js */\"./assets/src/js/main.js\");\nmodule.exports = __webpack_require__(/*! ./assets/src/scss/main.scss */\"./assets/src/scss/main.scss\");\n\n\n//# sourceURL=webpack:///multi_./assets/src/js/main.js_./assets/src/scss/main.scss?");

/***/ })

/******/ });