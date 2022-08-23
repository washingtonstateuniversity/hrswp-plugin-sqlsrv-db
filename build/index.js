!function(){"use strict";var e={d:function(t,l){for(var n in l)e.o(l,n)&&!e.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:l[n]})},o:function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r:function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})}};!function(e,t,l){var n={};l.r(n),l.d(n,{metadata:function(){return S},name:function(){return j},settings:function(){return k}});var a={};function r(e,t,l){return t in e?Object.defineProperty(e,t,{value:l,enumerable:!0,configurable:!0,writable:!0}):e[t]=l,e}function c(e,t){(null==t||t>e.length)&&(t=e.length);for(var l=0,n=new Array(t);l<t;l++)n[l]=e[l];return n}l.r(a),l.d(a,{metadata:function(){return z},name:function(){return $},settings:function(){return K}});var u=window.wp.element,o=window.lodash,i=wp.components,s=i.PanelBody,m=i.Placeholder,p=i.SelectControl,b=i.Spinner,E=wp.data,y=E.dispatch,f=E.useSelect,d=wp.blockEditor,h=d.InspectorControls,g=d.useBlockProps,v=wp.i18n.__,S=JSON.parse('{"apiVersion":2,"name":"hrswpsqlsrv/salary-data","title":"HRS Salary Data","category":"hrswp_sqlsrv_db","description":"Display WSU salary data.","textdomain":"default","attributes":{"queryTable":{"type":"string"}},"supports":{"align":true,"html":false},"styles":[{"name":"default","label":"Table","isDefault":true},{"name":"stripes","label":"Stripes"}]}'),w=wp.primitives,D=w.Path,C=w.SVG,O=(0,u.createElement)(C,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,u.createElement)(D,{d:"M3.25 12a8.75 8.75 0 1117.5 0 8.75 8.75 0 01-17.5 0zM12 4.75a7.25 7.25 0 100 14.5 7.25 7.25 0 000-14.5zm-1.338 4.877c-.314.22-.412.452-.412.623 0 .171.098.403.412.623.312.218.783.377 1.338.377.825 0 1.605.233 2.198.648.59.414 1.052 1.057 1.052 1.852 0 .795-.461 1.438-1.052 1.852-.41.286-.907.486-1.448.582v.316a.75.75 0 01-1.5 0v-.316a3.64 3.64 0 01-1.448-.582c-.59-.414-1.052-1.057-1.052-1.852a.75.75 0 011.5 0c0 .171.098.403.412.623.312.218.783.377 1.338.377s1.026-.159 1.338-.377c.314-.22.412-.452.412-.623 0-.171-.098-.403-.412-.623-.312-.218-.783-.377-1.338-.377-.825 0-1.605-.233-2.198-.648-.59-.414-1.052-1.057-1.052-1.852 0-.795.461-1.438 1.052-1.852a3.64 3.64 0 011.448-.582V7.5a.75.75 0 011.5 0v.316c.54.096 1.039.296 1.448.582.59.414 1.052 1.057 1.052 1.852a.75.75 0 01-1.5 0c0-.171-.098-.403-.412-.623-.312-.218-.783-.377-1.338-.377s-1.026.159-1.338.377z"})),j=S.name,k={icon:O,example:{},edit:function(e){var t,l=e.attributes.queryTable,n=e.setAttributes,a=f((function(e){var t=e("hrswpsqlsrv/salary-data"),n=t.getSalaryData,a=t.getTableNames,r=t.isResolving;return{salaryData:null!=l&&l.length?n(l):{},isRequesting:r("getSalaryData",[l]),tables:a()}}),[l]),i=a.salaryData,E=a.isRequesting,d=a.tables,S=new Intl.NumberFormat("en-US",{style:"currency",currency:"USD",maximumFractionDigits:0}),w=function(e){return e?(0,o.unescape)(e).trim():v("(Untitled)")},D=function(e,t){return(0,u.createElement)("tr",{key:t},Object.entries(e).map((function(e,t){var l,n=function(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){var l=null==e?null:"undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(null!=l){var n,a,r=[],c=!0,u=!1;try{for(l=l.call(e);!(c=(n=l.next()).done)&&(r.push(n.value),!t||r.length!==t);c=!0);}catch(e){u=!0,a=e}finally{try{c||null==l.return||l.return()}finally{if(u)throw a}}return r}}(e,t)||function(e,t){if(e){if("string"==typeof e)return c(e,t);var l=Object.prototype.toString.call(e).slice(8,-1);return"Object"===l&&e.constructor&&(l=e.constructor.name),"Map"===l||"Set"===l?Array.from(e):"Arguments"===l||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(l)?c(e,t):void 0}}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}(e,2),a=n[0],r=n[1],o="RANGE"!==a?(l=r,Number.isNaN(Number(l))?w(l):S.format(l)):w(r);return(0,u.createElement)("td",{key:t},o)})))};return(0,u.createElement)("div",g(),(0,u.createElement)(h,null,(0,u.createElement)(s,{title:v("Salary Data settings")},(0,u.createElement)(p,{className:"salary-data-table-picker__select",label:v("Select Job Data source"),value:l,options:null!=d&&d.length?null==d?void 0:d.reduce((function(e,t){return(t.value.includes("salary")||""===t.value)&&e.push(t),e}),[]):[],onChange:(t="queryTable",function(e){y("hrswpsqlsrv/salary-data").invalidateResolutionForStoreSelector("getSalaryData"),n(r({},t,e))})}))),!l&&(0,u.createElement)(m,{icon:"admin-post",label:v("Salary Data")},Array.isArray(d)?v("Select a salary data group to display results."):(0,u.createElement)(b,null)),l&&E&&(0,u.createElement)(m,{icon:"admin-post",label:v("Salary Data")},(0,u.createElement)(b,null)),!E&&(null==i?void 0:i.length)>0&&(0,u.createElement)("figure",{className:"wp-block-table"},(0,u.createElement)("table",null,(0,u.createElement)("thead",null,(0,u.createElement)("tr",null,Object.keys(i[0]).map((function(e,t){return function(e,t){var l="RANGE"!==e?"Step ".concat(w(e)):"Range";return(0,u.createElement)("th",{key:t},l)}(e,t)}))),l.includes("nurses")&&function(e){var t;return e.includes("nurses-a-am")&&(t=(0,u.createElement)(u.Fragment,null,(0,u.createElement)("th",null),(0,u.createElement)("th",null),(0,u.createElement)("th",null),(0,u.createElement)("th",null),(0,u.createElement)("th",null,"0"),(0,u.createElement)("th",null),(0,u.createElement)("th",null,"1"),(0,u.createElement)("th",null),(0,u.createElement)("th",null,"2"),(0,u.createElement)("th",null),(0,u.createElement)("th",null,"3"),(0,u.createElement)("th",null,"4"),(0,u.createElement)("th",null,"5"))),e.includes("nurses-a-nu")&&(t=(0,u.createElement)(u.Fragment,null,(0,u.createElement)("th",null,"6"),(0,u.createElement)("th",null,"7"),(0,u.createElement)("th",null,"8"),(0,u.createElement)("th",null,"12"),(0,u.createElement)("th",null,"15"),(0,u.createElement)("th",null,"18"),(0,u.createElement)("th",null,"20"),(0,u.createElement)("th",null,"26"))),e.includes("nurses-b-am")&&(t=(0,u.createElement)(u.Fragment,null,(0,u.createElement)("th",null,"0"),(0,u.createElement)("th",null),(0,u.createElement)("th",null,"1"),(0,u.createElement)("th",null),(0,u.createElement)("th",null,"2"),(0,u.createElement)("th",null),(0,u.createElement)("th",null,"3"),(0,u.createElement)("th",null),(0,u.createElement)("th",null,"4"),(0,u.createElement)("th",null),(0,u.createElement)("th",null,"5"),(0,u.createElement)("th",null,"6"),(0,u.createElement)("th",null,"7"))),e.includes("nurses-b-nu")&&(t=(0,u.createElement)(u.Fragment,null,(0,u.createElement)("th",null,"8"),(0,u.createElement)("th",null,"9"),(0,u.createElement)("th",null,"10"),(0,u.createElement)("th",null,"12"),(0,u.createElement)("th",null,"15"),(0,u.createElement)("th",null,"18"),(0,u.createElement)("th",null,"20"),(0,u.createElement)("th",null,"26"))),(0,u.createElement)("tr",null,(0,u.createElement)("th",null,(0,u.createElement)("abbr",{title:"Years of experience"},"YRSx")),t)}(l)),(0,u.createElement)("tbody",null,i.map((function(e,t){return D(e,t)}))))))}},N=wp.components,R=N.PanelBody,T=N.Placeholder,x=N.RangeControl,P=N.SelectControl,q=N.Spinner,_=N.TextControl,A=N.ToggleControl,J=wp.data,M=J.dispatch,U=J.useSelect,L=wp.blockEditor,F=L.InspectorControls,B=L.useBlockProps,I=wp.i18n.__,z=JSON.parse('{"apiVersion":2,"name":"hrswpsqlsrv/job-classifications","title":"HRS Job Classifications","category":"hrswp_sqlsrv_db","description":"Display WSU job classification data.","textdomain":"default","attributes":{"displayAsList":{"type":"boolean","default":false},"columns":{"type":"number","default":3},"salaryDataUrl":{"type":"string","default":""},"queryTable":{"type":"string"}},"supports":{"align":true,"html":false},"styles":[{"name":"default","label":"Default Table","isDefault":true},{"name":"stripes","label":"Striped Table"}]}'),V=wp.components,G=V.Path,W=V.Rect,H=V.SVG,Y=(0,u.createElement)(H,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,u.createElement)(W,{x:"0",fill:"none",width:"24",height:"24"}),(0,u.createElement)(G,{d:"M13.2 10L11 13l-1-1.4L9 13l-2.2-3C3 11 3 13 3 16.9c0 0 3 1.1 6.4 1.1h1.2c3.4-.1 6.4-1.1 6.4-1.1 0-3.9 0-5.9-3.8-6.9zm-3.2.7L8.4 10l1.6 1.6 1.6-1.6-1.6.7zM10 2.1c-1.9 0-3 1.8-2.7 3.8.3 2 1.3 3.4 2.7 3.4s2.4-1.4 2.7-3.4c.3-2.1-.8-3.8-2.7-3.8z"})),$=z.name,K={icon:Y,example:{},edit:function(e){var t=e.attributes,l=t.displayAsList,n=t.columns,a=t.salaryDataUrl,c=t.queryTable,i=e.setAttributes,s=U((function(e){var t=e("hrswpsqlsrv/salary-data"),l=t.getJobClassificationData,n=t.getTableNames,a=t.isResolving;return{jobClassificationData:null!=c&&c.length?l(c):{},isRequesting:a("getJobClassificationData",[c]),tables:n()}}),[c]),m=s.jobClassificationData,p=s.isRequesting,b=s.tables,E=function(e){return function(t){"queryTable"===e&&M("hrswpsqlsrv/salary-data").invalidateResolutionForStoreSelector("getJobClassificationData"),i(r({},e,t))}},y=new Intl.NumberFormat("en-US",{style:"currency",currency:"USD"}),f=function(e){return e?(0,o.unescape)(e).trim():I("(Untitled)")},d=function(e){return Number.isNaN(Number(e))?f(e):y.format(e)},h=function(e,t){var l=(0,o.escape)(a+"?filter="+e);return(0,u.createElement)("a",{href:l,target:"_blank",rel:"noreferrer noopener"},f(t))};return(0,u.createElement)("div",B(),(0,u.createElement)(F,null,(0,u.createElement)(R,{title:I("Job Classifications settings")},(0,u.createElement)(A,{label:I("Display as list"),checked:l,onChange:E("displayAsList")}),l&&(0,u.createElement)(x,{label:I("List Columns"),value:n||3,onChange:E("columns"),min:1,max:6}),(0,u.createElement)(P,{className:"salary-data-table-picker__select",label:I("Select Job Data source"),value:c,options:null!=b&&b.length?null==b?void 0:b.reduce((function(e,t){return(t.value.includes("job-class")||""===t.value)&&e.push(t),e}),[]):[],onChange:E("queryTable")}),(0,u.createElement)(_,{label:I("Linked Salary Data URL"),help:I("The full URL to a page with a corresponding Salary Data block to link to. Leave blank to link to the current page."),value:a,onChange:E("salaryDataUrl")}))),!c&&(0,u.createElement)(T,{icon:"admin-post",label:I("Job Classification Data")},Array.isArray(b)?I("Select a job classification data group to display results."):(0,u.createElement)(q,null)),c&&p&&(0,u.createElement)(T,{icon:"admin-post",label:I("Job Classification Data")},(0,u.createElement)(q,null)),!p&&(null==m?void 0:m.length)>0&&(l?(0,u.createElement)("ul",{className:"has-columns has-columns-".concat(n)},m.map((function(e,t){return function(e,t){var l=e.ClassCode,n=e.JobTitle,a=e.SalRangeNum,r=e.Salary_Max,c=e.Salary_Min,o=e.SalrangeWExceptions;return(0,u.createElement)("li",{key:t},(0,u.createElement)("strong",null,f(n)),(0,u.createElement)("span",null," (".concat(f(l),")")),(0,u.createElement)("ul",null,(0,u.createElement)("li",null," ".concat(I("Range"),": "),h(a,o)),(0,u.createElement)("li",null," ".concat(I("Salary Min"),": "),d(c)),(0,u.createElement)("li",null," ".concat(I("Salary Max"),": "),d(r))))}(e,t)}))):(0,u.createElement)("figure",{className:"wp-block-table"},(0,u.createElement)("table",null,(0,u.createElement)("thead",null,(0,u.createElement)("tr",null,(0,u.createElement)("th",null,I("Job Class")),(0,u.createElement)("th",null,I("Job Title")),(0,u.createElement)("th",null,I("Range")),(0,u.createElement)("th",null,I("Salary Min")),(0,u.createElement)("th",null,I("Salary Max")))),(0,u.createElement)("tbody",null,m.map((function(e,t){return function(e,t){var l=e.ClassCode,n=e.JobTitle,a=e.SalRangeNum,r=e.Salary_Max,c=e.Salary_Min,o=e.SalrangeWExceptions;return(0,u.createElement)("tr",{key:t},(0,u.createElement)("td",null,f(l)),(0,u.createElement)("td",null,f(n)),(0,u.createElement)("td",null,h(a,o)),(0,u.createElement)("td",null,d(c)),(0,u.createElement)("td",null,d(r)))}(e,t)})))))))}};function Q(e,t){var l=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),l.push.apply(l,n)}return l}var X=wp.blocks.registerBlockType;[n,a].forEach((function(e){if(e){var t=e.metadata,l=e.settings,n=e.name;X(function(e){for(var t=1;t<arguments.length;t++){var l=null!=arguments[t]?arguments[t]:{};t%2?Q(Object(l),!0).forEach((function(t){r(e,t,l[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(l)):Q(Object(l)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(l,t))}))}return e}({name:n},t),l)}}))}(0,0,e)}();