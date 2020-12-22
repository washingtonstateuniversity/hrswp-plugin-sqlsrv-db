/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/assertThisInitialized.js ***!
  \**********************************************************************/
/***/ (function(module) {

function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }

  return self;
}

module.exports = _assertThisInitialized;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/classCallCheck.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/classCallCheck.js ***!
  \***************************************************************/
/***/ (function(module) {

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

module.exports = _classCallCheck;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/createClass.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/createClass.js ***!
  \************************************************************/
/***/ (function(module) {

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  return Constructor;
}

module.exports = _createClass;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/defineProperty.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/defineProperty.js ***!
  \***************************************************************/
/***/ (function(module) {

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

module.exports = _defineProperty;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/getPrototypeOf.js ***!
  \***************************************************************/
/***/ (function(module) {

function _getPrototypeOf(o) {
  module.exports = _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  return _getPrototypeOf(o);
}

module.exports = _getPrototypeOf;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/inherits.js":
/*!*********************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/inherits.js ***!
  \*********************************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var setPrototypeOf = __webpack_require__(/*! ./setPrototypeOf */ "./node_modules/@babel/runtime/helpers/setPrototypeOf.js");

function _inherits(subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function");
  }

  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      writable: true,
      configurable: true
    }
  });
  if (superClass) setPrototypeOf(subClass, superClass);
}

module.exports = _inherits;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js ***!
  \**************************************************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var _typeof = __webpack_require__(/*! @babel/runtime/helpers/typeof */ "./node_modules/@babel/runtime/helpers/typeof.js");

var assertThisInitialized = __webpack_require__(/*! ./assertThisInitialized */ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js");

function _possibleConstructorReturn(self, call) {
  if (call && (_typeof(call) === "object" || typeof call === "function")) {
    return call;
  }

  return assertThisInitialized(self);
}

module.exports = _possibleConstructorReturn;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/setPrototypeOf.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/setPrototypeOf.js ***!
  \***************************************************************/
/***/ (function(module) {

function _setPrototypeOf(o, p) {
  module.exports = _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  };

  return _setPrototypeOf(o, p);
}

module.exports = _setPrototypeOf;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/typeof.js":
/*!*******************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/typeof.js ***!
  \*******************************************************/
/***/ (function(module) {

function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    module.exports = _typeof = function _typeof(obj) {
      return typeof obj;
    };
  } else {
    module.exports = _typeof = function _typeof(obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

module.exports = _typeof;

/***/ }),

/***/ "./src/blocks/index.js":
/*!*****************************!*\
  !*** ./src/blocks/index.js ***!
  \*****************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "registerBlocks": function() { return /* binding */ registerBlocks; }
/* harmony export */ });
/* harmony import */ var _salary_data__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./salary-data */ "./src/blocks/salary-data/index.js");
/* harmony import */ var _job_classifications__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./job-classifications */ "./src/blocks/job-classifications/index.js");
/* harmony import */ var _list_awards__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./list-awards */ "./src/blocks/list-awards/index.js");
/**
 * WordPress dependencies
 */
var registerBlockType = wp.blocks.registerBlockType;
/**
 * Internal dependencies
 */




/**
 * Function to register plugin blocks.
 *
 * @example
 * ```js
 * import { registerBlocks } from './blocks';
 *
 * registerBlocks();
 * ```
 */

var registerBlocks = function registerBlocks() {
  [_salary_data__WEBPACK_IMPORTED_MODULE_0__, _job_classifications__WEBPACK_IMPORTED_MODULE_1__, _list_awards__WEBPACK_IMPORTED_MODULE_2__].forEach(function (block) {
    if (!block) {
      return;
    }

    var settings = block.settings,
        name = block.name;
    registerBlockType(name, settings);
  });
};

/***/ }),

/***/ "./src/blocks/job-classifications/edit.js":
/*!************************************************!*\
  !*** ./src/blocks/job-classifications/edit.js ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);


/**
 * WordPress dependencies
 */
var __ = wp.i18n.__;
var withSelect = wp.data.withSelect;
var InspectorControls = wp.blockEditor.InspectorControls;
var ServerSideRender = wp.serverSideRender;
var _wp$components = wp.components,
    Disabled = _wp$components.Disabled,
    PanelBody = _wp$components.PanelBody,
    Placeholder = _wp$components.Placeholder,
    RangeControl = _wp$components.RangeControl,
    SelectControl = _wp$components.SelectControl,
    Spinner = _wp$components.Spinner,
    TextControl = _wp$components.TextControl,
    ToggleControl = _wp$components.ToggleControl;

function JobClassifications(_ref) {
  var attributes = _ref.attributes,
      setAttributes = _ref.setAttributes,
      tables = _ref.tables;
  var className = attributes.className,
      columns = attributes.columns,
      isStriped = attributes.isStriped,
      salaryDataUrl = attributes.salaryDataUrl,
      queryTable = attributes.queryTable;
  var inspectorControls = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InspectorControls, null, 'is-style-list' !== className && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: __('Table Settings')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: __('Striped table rows'),
    checked: isStriped,
    onChange: function onChange(value) {
      return setAttributes({
        isStriped: value
      });
    }
  })), 'is-style-list' === className && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: __('List Settings')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: __('List Columns'),
    value: columns || 3,
    onChange: function onChange(value) {
      return setAttributes({
        columns: value
      });
    },
    min: 1,
    max: 6
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: __('Salary Data Settings')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
    label: __('Linked Salary Data URL'),
    help: __('The full URL to a page with a corresponding Salary Data block to link to. Leave blank to link to the current page.'),
    value: salaryDataUrl,
    onChange: function onChange(value) {
      return setAttributes({
        salaryDataUrl: value
      });
    }
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: __('Select Job Data Source')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    className: 'salary-data-table-picker__select',
    label: __('Select desired group:'),
    value: queryTable,
    options: tables,
    onChange: function onChange(value) {
      return setAttributes({
        queryTable: value
      });
    }
  })));

  if (!queryTable) {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, inspectorControls, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Placeholder, {
      icon: "admin-post",
      label: __('Job Classification Data')
    }, !Array.isArray(tables) ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Spinner, null) : __('Select a job classification data group to display results.')));
  }

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, inspectorControls, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Disabled, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ServerSideRender, {
    block: "hrswpsqlsrv/job-classifications",
    attributes: attributes
  })));
}

/* harmony default export */ __webpack_exports__["default"] = (withSelect(function (select) {
  return {
    tables: select('hrswpsqlsrv/salary-data').getTableNames()
  };
})(JobClassifications));

/***/ }),

/***/ "./src/blocks/job-classifications/icon.js":
/*!************************************************!*\
  !*** ./src/blocks/job-classifications/icon.js ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */

/* harmony default export */ __webpack_exports__["default"] = ((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.SVG, {
  viewBox: "0 0 24 24",
  xmlns: "http://www.w3.org/2000/svg"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Rect, {
  x: "0",
  fill: "none",
  width: "24",
  height: "24"
}), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Path, {
  d: "M13.2 10L11 13l-1-1.4L9 13l-2.2-3C3 11 3 13 3 16.9c0 0 3 1.1 6.4 1.1h1.2c3.4-.1 6.4-1.1 6.4-1.1 0-3.9 0-5.9-3.8-6.9zm-3.2.7L8.4 10l1.6 1.6 1.6-1.6-1.6.7zM10 2.1c-1.9 0-3 1.8-2.7 3.8.3 2 1.3 3.4 2.7 3.4s2.4-1.4 2.7-3.4c.3-2.1-.8-3.8-2.7-3.8z"
})));

/***/ }),

/***/ "./src/blocks/job-classifications/index.js":
/*!*************************************************!*\
  !*** ./src/blocks/job-classifications/index.js ***!
  \*************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "name": function() { return /* binding */ name; },
/* harmony export */   "settings": function() { return /* binding */ settings; }
/* harmony export */ });
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./edit */ "./src/blocks/job-classifications/edit.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./block.json */ "./src/blocks/job-classifications/block.json");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./save */ "./src/blocks/job-classifications/save.js");
/* harmony import */ var _icon__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./icon */ "./src/blocks/job-classifications/icon.js");
/**
 * WordPress dependencies
 */
var _wp$i18n = wp.i18n,
    __ = _wp$i18n.__,
    _x = _wp$i18n._x;
/**
 * Internal dependencies
 */





var name = _block_json__WEBPACK_IMPORTED_MODULE_1__.name,
    category = _block_json__WEBPACK_IMPORTED_MODULE_1__.category,
    supports = _block_json__WEBPACK_IMPORTED_MODULE_1__.supports;

var settings = {
  title: __('HRS Job Classifications'),
  category: category,
  description: __('Display WSU job classification data.'),
  icon: _icon__WEBPACK_IMPORTED_MODULE_3__.default,
  keywords: [__('table data compensation jobs')],
  supports: supports,
  styles: [{
    name: 'default',
    label: _x('Table', 'block style'),
    isDefault: true
  }, {
    name: 'list',
    label: _x('List', 'block style')
  }],
  edit: _edit__WEBPACK_IMPORTED_MODULE_0__.default,
  save: _save__WEBPACK_IMPORTED_MODULE_2__.default
};

/***/ }),

/***/ "./src/blocks/job-classifications/save.js":
/*!************************************************!*\
  !*** ./src/blocks/job-classifications/save.js ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ save; }
/* harmony export */ });
/*
 * No data is saved to the block. Data is saved to post meta via attributes.
 *
 * Because this is similar to a dynamic block it doesn’t need to override the
 * default save implementation on the client. Instead, it needs a server
 * component. The contents in the front of your site depend on the function
 * called by the `render_callback` property of `register_block_type`.
 */
function save() {
  return null;
}

/***/ }),

/***/ "./src/blocks/list-awards/edit.js":
/*!****************************************!*\
  !*** ./src/blocks/list-awards/edit.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "./node_modules/@babel/runtime/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/createClass */ "./node_modules/@babel/runtime/helpers/createClass.js");
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/inherits */ "./node_modules/@babel/runtime/helpers/inherits.js");
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime/helpers/getPrototypeOf */ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__);







function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default()(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3___default()(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

/**
 * WordPress dependencies
 */
var __ = wp.i18n.__;
var withSelect = wp.data.withSelect;
var Component = wp.element.Component;
var InspectorControls = wp.blockEditor.InspectorControls;
var ServerSideRender = wp.serverSideRender;
var _wp$components = wp.components,
    Disabled = _wp$components.Disabled,
    PanelBody = _wp$components.PanelBody,
    Placeholder = _wp$components.Placeholder,
    RangeControl = _wp$components.RangeControl,
    SelectControl = _wp$components.SelectControl,
    Spinner = _wp$components.Spinner,
    ToggleControl = _wp$components.ToggleControl;

var ListAwards = /*#__PURE__*/function (_Component) {
  _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2___default()(ListAwards, _Component);

  var _super = _createSuper(ListAwards);

  function ListAwards() {
    _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, ListAwards);

    return _super.apply(this, arguments);
  }

  _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(ListAwards, [{
    key: "render",
    value: function render() {
      var _this$props = this.props,
          attributes = _this$props.attributes,
          setAttributes = _this$props.setAttributes,
          tables = _this$props.tables;
      var className = attributes.className,
          columns = attributes.columns,
          imageCrop = attributes.imageCrop,
          queryTable = attributes.queryTable;
      var inspectorControls = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createElement)(InspectorControls, null, 'is-style-list' !== className && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createElement)(PanelBody, {
        title: __('Grid Settings')
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createElement)(RangeControl, {
        label: __('List Columns'),
        value: columns || 3,
        onChange: function onChange(value) {
          return setAttributes({
            columns: value
          });
        },
        min: 1,
        max: 6
      })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createElement)(PanelBody, {
        title: __('Awards List Settings')
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createElement)(ToggleControl, {
        label: __('Crop Images'),
        checked: imageCrop,
        onChange: function onChange(value) {
          return setAttributes({
            imageCrop: value
          });
        }
      })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createElement)(PanelBody, {
        title: __('Select Awards Data Source')
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createElement)(SelectControl, {
        className: 'salary-data-table-picker__select',
        label: __('Select desired group:'),
        value: queryTable,
        options: tables,
        onChange: function onChange(value) {
          return setAttributes({
            queryTable: value
          });
        }
      })));

      if (!queryTable) {
        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.Fragment, null, inspectorControls, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createElement)(Placeholder, {
          icon: "admin-post",
          label: __('Awards Data')
        }, !Array.isArray(tables) ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createElement)(Spinner, null) : __('Select an awards data group to display results.')));
      }

      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.Fragment, null, inspectorControls, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createElement)(Disabled, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createElement)(ServerSideRender, {
        block: "hrswpsqlsrv/list-awards",
        attributes: attributes
      })));
    }
  }]);

  return ListAwards;
}(Component);

/* harmony default export */ __webpack_exports__["default"] = (withSelect(function (select) {
  return {
    tables: select('hrswpsqlsrv/salary-data').getTableNames()
  };
})(ListAwards));

/***/ }),

/***/ "./src/blocks/list-awards/icon.js":
/*!****************************************!*\
  !*** ./src/blocks/list-awards/icon.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */

/* harmony default export */ __webpack_exports__["default"] = ((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.SVG, {
  viewBox: "0 0 24 24",
  xmlns: "http://www.w3.org/2000/svg"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Rect, {
  x: "0",
  fill: "none",
  width: "24",
  height: "24"
}), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Path, {
  d: "M4.46 5.16L5 7.46l-.54 2.29 2.01 1.24L7.7 13l2.3-.54 2.3.54 1.23-2.01 2.01-1.24L15 7.46l.54-2.3-2-1.24-1.24-2.01-2.3.55-2.29-.54-1.25 2zm5.55 6.34C7.79 11.5 6 9.71 6 7.49c0-2.2 1.79-3.99 4.01-3.99 2.2 0 3.99 1.79 3.99 3.99 0 2.22-1.79 4.01-3.99 4.01zm-.02-1C8.33 10.5 7 9.16 7 7.5c0-1.65 1.33-3 2.99-3S13 5.85 13 7.5c0 1.66-1.35 3-3.01 3zm3.84 1.1l-1.28 2.24-2.08-.47L13 19.2l1.4-2.2h2.5zm-7.7.07l1.25 2.25 2.13-.51L7 19.2 5.6 17H3.1z"
})));

/***/ }),

/***/ "./src/blocks/list-awards/index.js":
/*!*****************************************!*\
  !*** ./src/blocks/list-awards/index.js ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "name": function() { return /* binding */ name; },
/* harmony export */   "settings": function() { return /* binding */ settings; }
/* harmony export */ });
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./edit */ "./src/blocks/list-awards/edit.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./block.json */ "./src/blocks/list-awards/block.json");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./save */ "./src/blocks/list-awards/save.js");
/* harmony import */ var _icon__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./icon */ "./src/blocks/list-awards/icon.js");
/**
 * WordPress dependencies
 */
var _wp$i18n = wp.i18n,
    __ = _wp$i18n.__,
    _x = _wp$i18n._x;
/**
 * Internal dependencies
 */





var name = _block_json__WEBPACK_IMPORTED_MODULE_1__.name,
    category = _block_json__WEBPACK_IMPORTED_MODULE_1__.category,
    supports = _block_json__WEBPACK_IMPORTED_MODULE_1__.supports;

var settings = {
  title: __('HRS Awards'),
  category: category,
  description: __('Display employee recognition awards.'),
  icon: _icon__WEBPACK_IMPORTED_MODULE_3__.default,
  keywords: [__('awards employees recognition')],
  supports: supports,
  styles: [{
    name: 'default',
    label: _x('Grid', 'block style'),
    isDefault: true
  }, {
    name: 'list',
    label: _x('List', 'block style')
  }],
  edit: _edit__WEBPACK_IMPORTED_MODULE_0__.default,
  save: _save__WEBPACK_IMPORTED_MODULE_2__.default
};

/***/ }),

/***/ "./src/blocks/list-awards/save.js":
/*!****************************************!*\
  !*** ./src/blocks/list-awards/save.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ save; }
/* harmony export */ });
/*
 * No data is saved to the block. Data is saved to post meta via attributes.
 *
 * Because this is similar to a dynamic block it doesn’t need to override the
 * default save implementation on the client. Instead, it needs a server
 * component. The contents in the front of your site depend on the function
 * called by the `render_callback` property of `register_block_type`.
 */
function save() {
  return null;
}

/***/ }),

/***/ "./src/blocks/salary-data/edit.js":
/*!****************************************!*\
  !*** ./src/blocks/salary-data/edit.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);


/**
 * WordPress dependencies
 */
var __ = wp.i18n.__;
var withSelect = wp.data.withSelect;
var InspectorControls = wp.blockEditor.InspectorControls;
var ServerSideRender = wp.serverSideRender;
var _wp$components = wp.components,
    Disabled = _wp$components.Disabled,
    PanelBody = _wp$components.PanelBody,
    Placeholder = _wp$components.Placeholder,
    RangeControl = _wp$components.RangeControl,
    SelectControl = _wp$components.SelectControl,
    Spinner = _wp$components.Spinner,
    ToggleControl = _wp$components.ToggleControl;

function SalaryData(_ref) {
  var attributes = _ref.attributes,
      setAttributes = _ref.setAttributes,
      tables = _ref.tables;
  var className = attributes.className,
      columns = attributes.columns,
      isStriped = attributes.isStriped,
      queryTable = attributes.queryTable;
  var inspectorControls = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: __('Select Data Source')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    className: 'salary-data-table-picker__select',
    label: __('Select desired group:'),
    value: queryTable,
    options: tables,
    onChange: function onChange(value) {
      return setAttributes({
        queryTable: value
      });
    }
  })), 'is-style-list' !== className && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: __('Table Settings')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: __('Striped table rows'),
    checked: isStriped,
    onChange: function onChange(value) {
      return setAttributes({
        isStriped: value
      });
    }
  })), 'is-style-list' === className && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    title: __('List Settings')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    label: __('List Columns'),
    value: columns || 3,
    onChange: function onChange(value) {
      return setAttributes({
        columns: value
      });
    },
    min: 1,
    max: 6
  })));

  if (!queryTable) {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, inspectorControls, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Placeholder, {
      icon: "admin-post",
      label: __('Salary Data')
    }, !Array.isArray(tables) ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Spinner, null) : __('Select a salary data group to display results.')));
  }

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, inspectorControls, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Disabled, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ServerSideRender, {
    block: "hrswpsqlsrv/salary-data",
    attributes: attributes
  })));
}

/* harmony default export */ __webpack_exports__["default"] = (withSelect(function (select) {
  return {
    tables: select('hrswpsqlsrv/salary-data').getTableNames()
  };
})(SalaryData));

/***/ }),

/***/ "./src/blocks/salary-data/index.js":
/*!*****************************************!*\
  !*** ./src/blocks/salary-data/index.js ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "name": function() { return /* binding */ name; },
/* harmony export */   "settings": function() { return /* binding */ settings; }
/* harmony export */ });
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./edit */ "./src/blocks/salary-data/edit.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./block.json */ "./src/blocks/salary-data/block.json");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./save */ "./src/blocks/salary-data/save.js");
/**
 * WordPress dependencies
 */
var _wp$i18n = wp.i18n,
    __ = _wp$i18n.__,
    _x = _wp$i18n._x;
/**
 * Internal dependencies
 */




var name = _block_json__WEBPACK_IMPORTED_MODULE_1__.name,
    category = _block_json__WEBPACK_IMPORTED_MODULE_1__.category,
    supports = _block_json__WEBPACK_IMPORTED_MODULE_1__.supports;

var settings = {
  title: __('HRS Salary Data'),
  category: category,
  description: __('Display WSU salary data.'),
  icon: 'portfolio',
  keywords: [__('table data compensation')],
  supports: supports,
  styles: [{
    name: 'default',
    label: _x('Table', 'block style'),
    isDefault: true
  }, {
    name: 'list',
    label: _x('List', 'block style')
  }],
  edit: _edit__WEBPACK_IMPORTED_MODULE_0__.default,
  save: _save__WEBPACK_IMPORTED_MODULE_2__.default
};

/***/ }),

/***/ "./src/blocks/salary-data/save.js":
/*!****************************************!*\
  !*** ./src/blocks/salary-data/save.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ save; }
/* harmony export */ });
/*
 * No data is saved to the block. Data is saved to post meta via attributes.
 *
 * Because this is similar to a dynamic block it doesn’t need to override the
 * default save implementation on the client. Instead, it needs a server
 * component. The contents in the front of your site depend on the function
 * called by the `render_callback` property of `register_block_type`.
 */
function save() {
  return null;
}

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./blocks */ "./src/blocks/index.js");
/* harmony import */ var _store__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./store */ "./src/store/index.js");
/**
 * Internal dependencies
 */


(0,_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlocks)();
(0,_store__WEBPACK_IMPORTED_MODULE_1__.default)();

/***/ }),

/***/ "./src/store/index.js":
/*!****************************!*\
  !*** ./src/store/index.js ***!
  \****************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ registerStores; }
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "@babel/runtime/regenerator");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/defineProperty.js");
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__);



function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1___default()(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

/**
 * WordPress dependencies
 */
var apiFetch = wp.apiFetch;
var registerStore = wp.data.registerStore;
var DEFAULT_STATE = {
  tableNames: {}
};
var actions = {
  getTableNames: function getTableNames(tableNames) {
    return {
      type: 'GET_TABLE_NAMES',
      tableNames: tableNames
    };
  },
  fetchFromAPI: function fetchFromAPI(path) {
    return {
      type: 'FETCH_FROM_API',
      path: path
    };
  }
};
function registerStores() {
  registerStore('hrswpsqlsrv/salary-data', {
    reducer: function reducer() {
      var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : DEFAULT_STATE;
      var action = arguments.length > 1 ? arguments[1] : undefined;

      switch (action.type) {
        case 'GET_TABLE_NAMES':
          return _objectSpread(_objectSpread({}, state), {}, {
            tableNames: action.tableNames
          });
      }

      return state;
    },
    actions: actions,
    selectors: {
      getTableNames: function getTableNames(state) {
        var tableNames = state.tableNames;
        return tableNames;
      }
    },
    controls: {
      FETCH_FROM_API: function FETCH_FROM_API(action) {
        return apiFetch({
          path: action.path
        });
      }
    },
    resolvers: {
      getTableNames: /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function getTableNames() {
        var path, tableNames;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function getTableNames$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                path = '/hrswp-sqlsrv-db/v1/tables/';
                _context.next = 3;
                return actions.fetchFromAPI(path);

              case 3:
                tableNames = _context.sent;
                return _context.abrupt("return", actions.getTableNames(tableNames));

              case 5:
              case "end":
                return _context.stop();
            }
          }
        }, getTableNames);
      })
    }
  });
}

/***/ }),

/***/ "./src/blocks/job-classifications/block.json":
/*!***************************************************!*\
  !*** ./src/blocks/job-classifications/block.json ***!
  \***************************************************/
/***/ (function(module) {

"use strict";
module.exports = JSON.parse("{\"name\":\"hrswpsqlsrv/job-classifications\",\"category\":\"hrswp_sqlsrv_db\",\"supports\":{\"align\":true,\"html\":false}}");

/***/ }),

/***/ "./src/blocks/list-awards/block.json":
/*!*******************************************!*\
  !*** ./src/blocks/list-awards/block.json ***!
  \*******************************************/
/***/ (function(module) {

"use strict";
module.exports = JSON.parse("{\"name\":\"hrswpsqlsrv/list-awards\",\"category\":\"hrswp_sqlsrv_db\",\"supports\":{\"align\":true,\"html\":false}}");

/***/ }),

/***/ "./src/blocks/salary-data/block.json":
/*!*******************************************!*\
  !*** ./src/blocks/salary-data/block.json ***!
  \*******************************************/
/***/ (function(module) {

"use strict";
module.exports = JSON.parse("{\"name\":\"hrswpsqlsrv/salary-data\",\"category\":\"hrswp_sqlsrv_db\",\"supports\":{\"align\":true,\"html\":false}}");

/***/ }),

/***/ "@babel/runtime/regenerator":
/*!*************************************!*\
  !*** external "regeneratorRuntime" ***!
  \*************************************/
/***/ (function(module) {

"use strict";
module.exports = window["regeneratorRuntime"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["element"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		if(__webpack_module_cache__[moduleId]) {
/******/ 			return __webpack_module_cache__[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	// startup
/******/ 	// Load entry module
/******/ 	__webpack_require__("./src/index.js");
/******/ 	// This entry module used 'exports' so it can't be inlined
/******/ })()
;
//# sourceMappingURL=index.js.map