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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/process/browser.js":
/*!*****************************************!*\
  !*** ./node_modules/process/browser.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),

/***/ "./node_modules/setimmediate/setImmediate.js":
/*!***************************************************!*\
  !*** ./node_modules/setimmediate/setImmediate.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global, process) {(function (global, undefined) {
    "use strict";

    if (global.setImmediate) {
        return;
    }

    var nextHandle = 1; // Spec says greater than zero
    var tasksByHandle = {};
    var currentlyRunningATask = false;
    var doc = global.document;
    var registerImmediate;

    function setImmediate(callback) {
      // Callback can either be a function or a string
      if (typeof callback !== "function") {
        callback = new Function("" + callback);
      }
      // Copy function arguments
      var args = new Array(arguments.length - 1);
      for (var i = 0; i < args.length; i++) {
          args[i] = arguments[i + 1];
      }
      // Store and register the task
      var task = { callback: callback, args: args };
      tasksByHandle[nextHandle] = task;
      registerImmediate(nextHandle);
      return nextHandle++;
    }

    function clearImmediate(handle) {
        delete tasksByHandle[handle];
    }

    function run(task) {
        var callback = task.callback;
        var args = task.args;
        switch (args.length) {
        case 0:
            callback();
            break;
        case 1:
            callback(args[0]);
            break;
        case 2:
            callback(args[0], args[1]);
            break;
        case 3:
            callback(args[0], args[1], args[2]);
            break;
        default:
            callback.apply(undefined, args);
            break;
        }
    }

    function runIfPresent(handle) {
        // From the spec: "Wait until any invocations of this algorithm started before this one have completed."
        // So if we're currently running a task, we'll need to delay this invocation.
        if (currentlyRunningATask) {
            // Delay by doing a setTimeout. setImmediate was tried instead, but in Firefox 7 it generated a
            // "too much recursion" error.
            setTimeout(runIfPresent, 0, handle);
        } else {
            var task = tasksByHandle[handle];
            if (task) {
                currentlyRunningATask = true;
                try {
                    run(task);
                } finally {
                    clearImmediate(handle);
                    currentlyRunningATask = false;
                }
            }
        }
    }

    function installNextTickImplementation() {
        registerImmediate = function(handle) {
            process.nextTick(function () { runIfPresent(handle); });
        };
    }

    function canUsePostMessage() {
        // The test against `importScripts` prevents this implementation from being installed inside a web worker,
        // where `global.postMessage` means something completely different and can't be used for this purpose.
        if (global.postMessage && !global.importScripts) {
            var postMessageIsAsynchronous = true;
            var oldOnMessage = global.onmessage;
            global.onmessage = function() {
                postMessageIsAsynchronous = false;
            };
            global.postMessage("", "*");
            global.onmessage = oldOnMessage;
            return postMessageIsAsynchronous;
        }
    }

    function installPostMessageImplementation() {
        // Installs an event handler on `global` for the `message` event: see
        // * https://developer.mozilla.org/en/DOM/window.postMessage
        // * http://www.whatwg.org/specs/web-apps/current-work/multipage/comms.html#crossDocumentMessages

        var messagePrefix = "setImmediate$" + Math.random() + "$";
        var onGlobalMessage = function(event) {
            if (event.source === global &&
                typeof event.data === "string" &&
                event.data.indexOf(messagePrefix) === 0) {
                runIfPresent(+event.data.slice(messagePrefix.length));
            }
        };

        if (global.addEventListener) {
            global.addEventListener("message", onGlobalMessage, false);
        } else {
            global.attachEvent("onmessage", onGlobalMessage);
        }

        registerImmediate = function(handle) {
            global.postMessage(messagePrefix + handle, "*");
        };
    }

    function installMessageChannelImplementation() {
        var channel = new MessageChannel();
        channel.port1.onmessage = function(event) {
            var handle = event.data;
            runIfPresent(handle);
        };

        registerImmediate = function(handle) {
            channel.port2.postMessage(handle);
        };
    }

    function installReadyStateChangeImplementation() {
        var html = doc.documentElement;
        registerImmediate = function(handle) {
            // Create a <script> element; its readystatechange event will be fired asynchronously once it is inserted
            // into the document. Do so, thus queuing up the task. Remember to clean up once it's been called.
            var script = doc.createElement("script");
            script.onreadystatechange = function () {
                runIfPresent(handle);
                script.onreadystatechange = null;
                html.removeChild(script);
                script = null;
            };
            html.appendChild(script);
        };
    }

    function installSetTimeoutImplementation() {
        registerImmediate = function(handle) {
            setTimeout(runIfPresent, 0, handle);
        };
    }

    // If supported, we should attach to the prototype of global, since that is where setTimeout et al. live.
    var attachTo = Object.getPrototypeOf && Object.getPrototypeOf(global);
    attachTo = attachTo && attachTo.setTimeout ? attachTo : global;

    // Don't get fooled by e.g. browserify environments.
    if ({}.toString.call(global.process) === "[object process]") {
        // For Node.js before 0.9
        installNextTickImplementation();

    } else if (canUsePostMessage()) {
        // For non-IE10 modern browsers
        installPostMessageImplementation();

    } else if (global.MessageChannel) {
        // For web workers, where supported
        installMessageChannelImplementation();

    } else if (doc && "onreadystatechange" in doc.createElement("script")) {
        // For IE 6–8
        installReadyStateChangeImplementation();

    } else {
        // For older browsers
        installSetTimeoutImplementation();
    }

    attachTo.setImmediate = setImmediate;
    attachTo.clearImmediate = clearImmediate;
}(typeof self === "undefined" ? typeof global === "undefined" ? this : global : self));

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js"), __webpack_require__(/*! ./../process/browser.js */ "./node_modules/process/browser.js")))

/***/ }),

/***/ "./node_modules/timers-browserify/main.js":
/*!************************************************!*\
  !*** ./node_modules/timers-browserify/main.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {var scope = (typeof global !== "undefined" && global) ||
            (typeof self !== "undefined" && self) ||
            window;
var apply = Function.prototype.apply;

// DOM APIs, for completeness

exports.setTimeout = function() {
  return new Timeout(apply.call(setTimeout, scope, arguments), clearTimeout);
};
exports.setInterval = function() {
  return new Timeout(apply.call(setInterval, scope, arguments), clearInterval);
};
exports.clearTimeout =
exports.clearInterval = function(timeout) {
  if (timeout) {
    timeout.close();
  }
};

function Timeout(id, clearFn) {
  this._id = id;
  this._clearFn = clearFn;
}
Timeout.prototype.unref = Timeout.prototype.ref = function() {};
Timeout.prototype.close = function() {
  this._clearFn.call(scope, this._id);
};

// Does not start the time, just sets up the members needed.
exports.enroll = function(item, msecs) {
  clearTimeout(item._idleTimeoutId);
  item._idleTimeout = msecs;
};

exports.unenroll = function(item) {
  clearTimeout(item._idleTimeoutId);
  item._idleTimeout = -1;
};

exports._unrefActive = exports.active = function(item) {
  clearTimeout(item._idleTimeoutId);

  var msecs = item._idleTimeout;
  if (msecs >= 0) {
    item._idleTimeoutId = setTimeout(function onTimeout() {
      if (item._onTimeout)
        item._onTimeout();
    }, msecs);
  }
};

// setimmediate attaches itself to the global object
__webpack_require__(/*! setimmediate */ "./node_modules/setimmediate/setImmediate.js");
// On some exotic environments, it's not clear which object `setimmediate` was
// able to install onto.  Search each possibility in the same order as the
// `setimmediate` library.
exports.setImmediate = (typeof self !== "undefined" && self.setImmediate) ||
                       (typeof global !== "undefined" && global.setImmediate) ||
                       (this && this.setImmediate);
exports.clearImmediate = (typeof self !== "undefined" && self.clearImmediate) ||
                         (typeof global !== "undefined" && global.clearImmediate) ||
                         (this && this.clearImmediate);

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ "./node_modules/webpack/buildin/global.js":
/*!***********************************!*\
  !*** (webpack)/buildin/global.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || new Function("return this")();
} catch (e) {
	// This works if the window reference is available
	if (typeof window === "object") g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),

/***/ "./resources/js/cloud_payment.js":
/*!***************************************!*\
  !*** ./resources/js/cloud_payment.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(setImmediate, global) {var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

var JSON, cp;
JSON || (JSON = {}), function () {
  "use strict";

  function i(n) {
    return n < 10 ? "0" + n : n;
  }

  function o(n) {
    return e.lastIndex = 0, e.test(n) ? '"' + n.replace(e, function (n) {
      var t = s[n];
      return typeof t == "string" ? t : "\\u" + ("0000" + n.charCodeAt(0).toString(16)).slice(-4);
    }) + '"' : '"' + n + '"';
  }

  function u(i, f) {
    var s,
        l,
        h,
        a,
        v = n,
        c,
        e = f[i];
    e && _typeof(e) == "object" && typeof e.toJSON == "function" && (e = e.toJSON(i));
    typeof t == "function" && (e = t.call(f, i, e));

    switch (_typeof(e)) {
      case "string":
        return o(e);

      case "number":
        return isFinite(e) ? String(e) : "null";

      case "boolean":
      case "null":
        return String(e);

      case "object":
        if (!e) return "null";

        if (n += r, c = [], Object.prototype.toString.apply(e) === "[object Array]") {
          for (a = e.length, s = 0; s < a; s += 1) {
            c[s] = u(s, e) || "null";
          }

          return h = c.length === 0 ? "[]" : n ? "[\n" + n + c.join(",\n" + n) + "\n" + v + "]" : "[" + c.join(",") + "]", n = v, h;
        }

        if (t && _typeof(t) == "object") for (a = t.length, s = 0; s < a; s += 1) {
          typeof t[s] == "string" && (l = t[s], h = u(l, e), h && c.push(o(l) + (n ? ": " : ":") + h));
        } else for (l in e) {
          Object.prototype.hasOwnProperty.call(e, l) && (h = u(l, e), h && c.push(o(l) + (n ? ": " : ":") + h));
        }
        return h = c.length === 0 ? "{}" : n ? "{\n" + n + c.join(",\n" + n) + "\n" + v + "}" : "{" + c.join(",") + "}", n = v, h;
    }
  }

  typeof Date.prototype.toJSON != "function" && (Date.prototype.toJSON = function () {
    return isFinite(this.valueOf()) ? this.getUTCFullYear() + "-" + i(this.getUTCMonth() + 1) + "-" + i(this.getUTCDate()) + "T" + i(this.getUTCHours()) + ":" + i(this.getUTCMinutes()) + ":" + i(this.getUTCSeconds()) + "Z" : null;
  }, String.prototype.toJSON = Number.prototype.toJSON = Boolean.prototype.toJSON = function () {
    return this.valueOf();
  });
  var f = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
      e = /[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
      n,
      r,
      s = {
    "\b": "\\b",
    "\t": "\\t",
    "\n": "\\n",
    "\f": "\\f",
    "\r": "\\r",
    '"': '\\"',
    "\\": "\\\\"
  },
      t;
  typeof JSON.stringify != "function" && (JSON.stringify = function (i, f, e) {
    var o;
    if (n = "", r = "", typeof e == "number") for (o = 0; o < e; o += 1) {
      r += " ";
    } else typeof e == "string" && (r = e);
    if (t = f, f && typeof f != "function" && (_typeof(f) != "object" || typeof f.length != "number")) throw new Error("JSON.stringify");
    return u("", {
      "": i
    });
  });
  typeof JSON.parse != "function" && (JSON.parse = function (text, reviver) {
    function walk(n, t) {
      var r,
          u,
          i = n[t];
      if (i && _typeof(i) == "object") for (r in i) {
        Object.prototype.hasOwnProperty.call(i, r) && (u = walk(i, r), u !== undefined ? i[r] = u : delete i[r]);
      }
      return reviver.call(n, t, i);
    }

    var j;
    if (text = String(text), f.lastIndex = 0, f.test(text) && (text = text.replace(f, function (n) {
      return "\\u" + ("0000" + n.charCodeAt(0).toString(16)).slice(-4);
    })), /^[\],:{}\s]*$/.test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, "@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]").replace(/(?:^|:|,)(?:\s*\[)+/g, ""))) return j = eval("(" + text + ")"), typeof reviver == "function" ? walk({
      "": j
    }, "") : j;
    throw new SyntaxError("JSON.parse");
  });
}(), function (n, t, i, r, u, f) {
  function b(n, t) {
    var i = _typeof(n[t]);

    return i == "function" || !!(i == "object" && n[t]) || i == "unknown";
  }

  function kt(n, t) {
    return !!(_typeof(n[t]) == "object" && n[t]);
  }

  function dt(n) {
    return Object.prototype.toString.call(n) === "[object Array]";
  }

  function lt() {
    var i = "Shockwave Flash",
        r = "application/x-shockwave-flash",
        n,
        t,
        u,
        f;
    if (a(navigator.plugins) || _typeof(navigator.plugins[i]) != "object" || (n = navigator.plugins[i].description, n && !a(navigator.mimeTypes) && navigator.mimeTypes[r] && navigator.mimeTypes[r].enabledPlugin && (w = n.match(/\d+/g))), !w) try {
      t = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
      w = Array.prototype.slice.call(t.GetVariable("$version").match(/(\d+),(\d+),(\d+),(\d+)/), 1);
      t = null;
    } catch (e) {}
    return w ? (u = parseInt(w[0], 10), f = parseInt(w[1], 10), ht = u > 9 && f > 0, !0) : !1;
  }

  function it() {
    if (!y) {
      y = !0;

      for (var n = 0; n < tt.length; n++) {
        tt[n]();
      }

      tt.length = 0;
    }
  }

  function p(n, t) {
    if (y) {
      n.call(t);
      return;
    }

    tt.push(function () {
      n.call(t);
    });
  }

  function gt() {
    var t = parent,
        n,
        i;
    if (d !== "") for (n = 0, i = d.split("."); n < i.length; n++) {
      t = t[i[n]];
    }
    return t.easyXDM;
  }

  function ni(t) {
    return n.easyXDM = ei, d = t, d && (c = "easyXDM_" + d.replace(".", "_") + "_"), e;
  }

  function at(n) {
    return n.match(st)[3];
  }

  function ti(n) {
    return n.match(st)[4] || "";
  }

  function o(n) {
    var i = n.toLowerCase().match(st),
        r = i[2],
        u = i[3],
        t = i[4] || "";
    return (r == "http:" && t == ":80" || r == "https:" && t == ":443") && (t = ""), r + "//" + u + t;
  }

  function nt(n) {
    if (n = n.replace(fi, "$1/"), !n.match(/^(http||https):\/\//)) {
      var t = n.substring(0, 1) === "/" ? "" : i.pathname;
      t.substring(t.length - 1) !== "/" && (t = t.substring(0, t.lastIndexOf("/") + 1));
      n = i.protocol + "//" + i.host + t + n;
    }

    while (wt.test(n)) {
      n = n.replace(wt, "");
    }

    return n;
  }

  function k(n, t) {
    var e = "",
        r = n.indexOf("#"),
        u,
        i;
    r !== -1 && (e = n.substring(r), n = n.substring(0, r));
    u = [];

    for (i in t) {
      t.hasOwnProperty(i) && u.push(i + "=" + f(t[i]));
    }

    return n + (bt ? "#" : n.indexOf("?") == -1 ? "?" : "&") + u.join("&") + e;
  }

  function a(n) {
    return typeof n == "undefined";
  }

  function s(n, t, i) {
    var u;

    for (var r in t) {
      t.hasOwnProperty(r) && (r in n ? (u = t[r], _typeof(u) == "object" ? s(n[r], u, i) : i || (n[r] = t[r])) : n[r] = t[r]);
    }

    return n;
  }

  function ii() {
    var n = t.body.appendChild(t.createElement("form")),
        i = n.appendChild(t.createElement("input"));
    i.name = c + "TEST" + pt;
    ut = i !== n.elements[i.name];
    t.body.removeChild(n);
  }

  function v(n) {
    var i, e, r, u, f;

    if (a(ut) && ii(), ut ? i = t.createElement('<iframe name="' + n.props.name + '"/>') : (i = t.createElement("IFRAME"), i.name = n.props.name), i.id = i.name = n.props.name, delete n.props.name, typeof n.container == "string" && (n.container = t.getElementById(n.container)), n.container || (s(i.style, {
      position: "absolute",
      top: "-2000px",
      left: "0px"
    }), n.container = t.body), e = n.props.src, n.props.src = "javascript:false", s(i, n.props), i.border = i.frameBorder = 0, i.allowTransparency = !0, n.container.appendChild(i), n.onLoad && l(i, "load", n.onLoad), n.usePost) {
      if (r = n.container.appendChild(t.createElement("form")), r.target = i.name, r.action = e, r.method = "POST", _typeof(n.usePost) == "object") for (f in n.usePost) {
        n.usePost.hasOwnProperty(f) && (ut ? u = t.createElement('<input name="' + f + '"/>') : (u = t.createElement("INPUT"), u.name = f), u.value = n.usePost[f], r.appendChild(u));
      }
      r.submit();
      r.parentNode.removeChild(r);
    } else i.src = e;

    return n.props.src = e, i;
  }

  function ri(n, t) {
    typeof n == "string" && (n = [n]);

    for (var i, r = n.length; r--;) {
      if (i = n[r], i = new RegExp(i.substr(0, 1) == "^" ? i : "^" + i.replace(/(\*)/g, ".$1").replace(/\?/g, ".") + "$"), i.test(t)) return !0;
    }

    return !1;
  }

  function vt(r) {
    var c = r.protocol,
        u,
        f;
    if (r.isHost = r.isHost || a(h.xdm_p), bt = r.hash || !1, r.props || (r.props = {}), r.isHost) r.remote = nt(r.remote), r.channel = r.channel || "default" + pt++, r.secret = Math.random().toString(16).substring(2), a(c) && (c = o(i.href) == o(r.remote) ? "4" : b(n, "postMessage") || b(t, "postMessage") ? "1" : r.swf && b(n, "ActiveXObject") && lt() ? "6" : navigator.product === "Gecko" && "frameElement" in n && navigator.userAgent.indexOf("WebKit") == -1 ? "5" : r.remoteHelper ? "2" : "0");else if (r.channel = h.xdm_c.replace(/["'<>\\]/g, ""), r.secret = h.xdm_s, r.remote = h.xdm_e.replace(/["'<>\\]/g, ""), c = h.xdm_p, r.acl && !ri(r.acl, r.remote)) throw new Error("Access denied for " + r.remote);
    r.protocol = c;

    switch (c) {
      case "0":
        if (s(r, {
          interval: 100,
          delay: 2e3,
          useResize: !0,
          useParent: !1,
          usePolling: !1
        }, !0), r.isHost) {
          if (!r.local) {
            for (var v = i.protocol + "//" + i.host, y = t.body.getElementsByTagName("img"), l, p = y.length; p--;) {
              if (l = y[p], l.src.substring(0, v.length) === v) {
                r.local = l.src;
                break;
              }
            }

            r.local || (r.local = n);
          }

          f = {
            xdm_c: r.channel,
            xdm_p: 0
          };
          r.local === n ? (r.usePolling = !0, r.useParent = !0, r.local = i.protocol + "//" + i.host + i.pathname + i.search, f.xdm_e = r.local, f.xdm_pa = 1) : f.xdm_e = nt(r.local);
          r.container && (r.useResize = !1, f.xdm_po = 1);
          r.remote = k(r.remote, f);
        } else s(r, {
          channel: h.xdm_c,
          remote: h.xdm_e,
          useParent: !a(h.xdm_pa),
          usePolling: !a(h.xdm_po),
          useResize: r.useParent ? !1 : r.useResize
        });

        u = [new e.stack.HashTransport(r), new e.stack.ReliableBehavior({}), new e.stack.QueueBehavior({
          encode: !0,
          maxLength: 4e3 - r.remote.length
        }), new e.stack.VerifyBehavior({
          initiate: r.isHost
        })];
        break;

      case "1":
        u = [new e.stack.PostMessageTransport(r)];
        break;

      case "2":
        r.isHost && (r.remoteHelper = nt(r.remoteHelper));
        u = [new e.stack.NameTransport(r), new e.stack.QueueBehavior(), new e.stack.VerifyBehavior({
          initiate: r.isHost
        })];
        break;

      case "3":
        u = [new e.stack.NixTransport(r)];
        break;

      case "4":
        u = [new e.stack.SameOriginTransport(r)];
        break;

      case "5":
        u = [new e.stack.FrameElementTransport(r)];
        break;

      case "6":
        w || lt();
        u = [new e.stack.FlashTransport(r)];
    }

    return u.push(new e.stack.QueueBehavior({
      lazy: r.lazy,
      remove: !0
    })), u;
  }

  function yt(n) {
    for (var i, u = {
      incoming: function incoming(n, t) {
        this.up.incoming(n, t);
      },
      outgoing: function outgoing(n, t) {
        this.down.outgoing(n, t);
      },
      callback: function callback(n) {
        this.up.callback(n);
      },
      init: function init() {
        this.down.init();
      },
      destroy: function destroy() {
        this.down.destroy();
      }
    }, t = 0, r = n.length; t < r; t++) {
      i = n[t], s(i, u, !0), t !== 0 && (i.down = n[t - 1]), t !== r - 1 && (i.up = n[t + 1]);
    }

    return i;
  }

  function ui(n) {
    n.up.down = n.down;
    n.down.up = n.up;
    n.up = n.down = null;
  }

  var rt = this,
      pt = Math.floor(Math.random() * 1e4),
      ot = Function.prototype,
      st = /^((http.?:)\/\/([^:\/\s]+)(:\d+)*)/,
      wt = /[\-\w]+\/\.\.\//,
      fi = /([^:])\/\//g,
      d = "",
      e = {},
      ei = n.easyXDM,
      c = "easyXDM_",
      ut,
      bt = !1,
      w,
      ht,
      l,
      g,
      y,
      tt,
      ft,
      _ct,
      h,
      _et;

  if (b(n, "addEventListener")) l = function l(n, t, i) {
    n.addEventListener(t, i, !1);
  }, g = function g(n, t, i) {
    n.removeEventListener(t, i, !1);
  };else if (b(n, "attachEvent")) l = function l(n, t, i) {
    n.attachEvent("on" + t, i);
  }, g = function g(n, t, i) {
    n.detachEvent("on" + t, i);
  };else throw new Error("Browser not supported");
  y = !1;
  tt = [];
  "readyState" in t ? (ft = t.readyState, y = ft == "complete" || ~navigator.userAgent.indexOf("AppleWebKit/") && (ft == "loaded" || ft == "interactive")) : y = !!t.body;
  y || (b(n, "addEventListener") ? l(t, "DOMContentLoaded", it) : (l(t, "readystatechange", function () {
    t.readyState == "complete" && it();
  }), t.documentElement.doScroll && n === top && (_ct = function ct() {
    if (!y) {
      try {
        t.documentElement.doScroll("left");
      } catch (n) {
        r(_ct, 1);
        return;
      }

      it();
    }
  }, _ct())), l(n, "load", it));

  h = function (n) {
    n = n.substring(1).split("&");

    for (var i = {}, t, r = n.length; r--;) {
      t = n[r].split("="), i[t[0]] = u(t[1]);
    }

    return i;
  }(/xdm_e=/.test(i.search) ? i.search : i.hash);

  _et = function et() {
    var n = {},
        t = {
      a: [1, 2, 3]
    },
        i = '{"a":[1,2,3]}';
    return typeof JSON != "undefined" && typeof JSON.stringify == "function" && JSON.stringify(t).replace(/\s/g, "") === i ? JSON : (Object.toJSON && Object.toJSON(t).replace(/\s/g, "") === i && (n.stringify = Object.toJSON), typeof String.prototype.evalJSON == "function" && (t = i.evalJSON(), t.a && t.a.length === 3 && t.a[2] === 3 && (n.parse = function (n) {
      return n.evalJSON();
    })), n.stringify && n.parse) ? (_et = function et() {
      return n;
    }, n) : null;
  };

  s(e, {
    version: "2.4.19.3",
    query: h,
    stack: {},
    apply: s,
    getJSONObject: _et,
    whenReady: p,
    noConflict: ni
  });
  e.DomHelper = {
    on: l,
    un: g,
    requiresJSON: function requiresJSON(i) {
      kt(n, "JSON") || t.write('<script type="text/javascript" src="' + i + '"></script>');
    }
  }, function () {
    var n = {};
    e.Fn = {
      set: function set(t, i) {
        n[t] = i;
      },
      get: function get(t, i) {
        if (n.hasOwnProperty(t)) {
          var r = n[t];
          return i && delete n[t], r;
        }
      }
    };
  }();

  e.Socket = function (n) {
    var t = yt(vt(n).concat([{
      incoming: function incoming(t, i) {
        n.onMessage(t, i);
      },
      callback: function callback(t) {
        if (n.onReady) n.onReady(t);
      }
    }])),
        i = o(n.remote);
    this.origin = o(n.remote);

    this.destroy = function () {
      t.destroy();
    };

    this.postMessage = function (n) {
      t.outgoing(n, i);
    };

    t.init();
  };

  e.Rpc = function (n, t) {
    var i, r, u;
    if (t.local) for (i in t.local) {
      t.local.hasOwnProperty(i) && (r = t.local[i], typeof r == "function" && (t.local[i] = {
        method: r
      }));
    }
    u = yt(vt(n).concat([new e.stack.RpcBehavior(this, t), {
      callback: function callback(t) {
        if (n.onReady) n.onReady(t);
      }
    }]));
    this.origin = o(n.remote);

    this.destroy = function () {
      u.destroy();
    };

    u.init();
  };

  e.stack.SameOriginTransport = function (n) {
    var t, u, f, h;
    return t = {
      outgoing: function outgoing(n, t, i) {
        f(n);
        i && i();
      },
      destroy: function destroy() {
        u && (u.parentNode.removeChild(u), u = null);
      },
      onDOMReady: function onDOMReady() {
        h = o(n.remote);
        n.isHost ? (s(n.props, {
          src: k(n.remote, {
            xdm_e: i.protocol + "//" + i.host + i.pathname,
            xdm_c: n.channel,
            xdm_p: 4
          }),
          name: c + n.channel + "_provider"
        }), u = v(n), e.Fn.set(n.channel, function (n) {
          return f = n, r(function () {
            t.up.callback(!0);
          }, 0), function (n) {
            t.up.incoming(n, h);
          };
        })) : (f = gt().Fn.get(n.channel, !0)(function (n) {
          t.up.incoming(n, h);
        }), r(function () {
          t.up.callback(!0);
        }, 0));
      },
      init: function init() {
        p(t.onDOMReady, t);
      }
    };
  };

  e.stack.FlashTransport = function (n) {
    function w(n) {
      r(function () {
        l.up.incoming(n, y);
      }, 0);
    }

    function b(i) {
      var r = n.swf + "?host=" + n.isHost,
          c = "easyXDM_swf_" + Math.floor(Math.random() * 1e4),
          o;
      e.Fn.set("flash_loaded" + i.replace(/[\-.]/g, "_"), function () {
        var n, t;

        for (e.stack.FlashTransport[i].swf = u = h.firstChild, n = e.stack.FlashTransport[i].queue, t = 0; t < n.length; t++) {
          n[t]();
        }

        n.length = 0;
      });
      n.swfContainer ? h = typeof n.swfContainer == "string" ? t.getElementById(n.swfContainer) : n.swfContainer : (h = t.createElement("div"), s(h.style, ht && n.swfNoThrottle ? {
        height: "20px",
        width: "20px",
        position: "fixed",
        right: 0,
        top: 0
      } : {
        height: "1px",
        width: "1px",
        position: "absolute",
        overflow: "hidden",
        right: 0,
        top: 0
      }), t.body.appendChild(h));
      o = "callback=flash_loaded" + f(i.replace(/[\-.]/g, "_")) + "&proto=" + rt.location.protocol + "&domain=" + f(at(rt.location.href)) + "&port=" + f(ti(rt.location.href)) + "&ns=" + f(d);
      h.innerHTML = "<object height='20' width='20' type='application/x-shockwave-flash' id='" + c + "' data='" + r + "'><param name='allowScriptAccess' value='always'></param><param name='wmode' value='transparent'><param name='movie' value='" + r + "'></param><param name='flashvars' value='" + o + "'></param><embed type='application/x-shockwave-flash' FlashVars='" + o + "' allowScriptAccess='always' wmode='transparent' src='" + r + "' height='1' width='1'></embed></object>";
    }

    var l, a, y, u, h;
    return l = {
      outgoing: function outgoing(t, i, r) {
        u.postMessage(n.channel, t.toString());
        r && r();
      },
      destroy: function destroy() {
        try {
          u.destroyChannel(n.channel);
        } catch (t) {}

        u = null;
        a && (a.parentNode.removeChild(a), a = null);
      },
      onDOMReady: function onDOMReady() {
        y = n.remote;
        e.Fn.set("flash_" + n.channel + "_init", function () {
          r(function () {
            l.up.callback(!0);
          });
        });
        e.Fn.set("flash_" + n.channel + "_onMessage", w);
        n.swf = nt(n.swf);

        var t = at(n.swf),
            f = function f() {
          e.stack.FlashTransport[t].init = !0;
          u = e.stack.FlashTransport[t].swf;
          u.createChannel(n.channel, n.secret, o(n.remote), n.isHost);
          n.isHost && (ht && n.swfNoThrottle && s(n.props, {
            position: "fixed",
            right: 0,
            top: 0,
            height: "20px",
            width: "20px"
          }), s(n.props, {
            src: k(n.remote, {
              xdm_e: o(i.href),
              xdm_c: n.channel,
              xdm_p: 6,
              xdm_s: n.secret
            }),
            name: c + n.channel + "_provider"
          }), a = v(n));
        };

        e.stack.FlashTransport[t] && e.stack.FlashTransport[t].init ? f() : e.stack.FlashTransport[t] ? e.stack.FlashTransport[t].queue.push(f) : (e.stack.FlashTransport[t] = {
          queue: [f]
        }, b(t));
      },
      init: function init() {
        p(l.onDOMReady, l);
      }
    };
  };

  e.stack.PostMessageTransport = function (t) {
    function y(n) {
      if (n.origin) return o(n.origin);
      if (n.uri) return o(n.uri);
      if (n.domain) return i.protocol + "//" + n.domain;
      throw "Unable to retrieve the origin of the event";
    }

    function a(n) {
      var i = y(n);
      i == h && n.data.substring(0, t.channel.length + 1) == t.channel + " " && f.up.incoming(n.data.substring(t.channel.length + 1), i);
    }

    var f, u, e, h;
    return f = {
      outgoing: function outgoing(n, i, r) {
        e.postMessage(t.channel + " " + n, i || h);
        r && r();
      },
      destroy: function destroy() {
        g(n, "message", a);
        u && (e = null, u.parentNode.removeChild(u), u = null);
      },
      onDOMReady: function onDOMReady() {
        if (h = o(t.remote), t.isHost) {
          var y = function y(i) {
            i.data == t.channel + "-ready" && (e = "postMessage" in u.contentWindow ? u.contentWindow : u.contentWindow.document, g(n, "message", y), l(n, "message", a), r(function () {
              f.up.callback(!0);
            }, 0));
          };

          l(n, "message", y);
          s(t.props, {
            src: k(t.remote, {
              xdm_e: o(i.href),
              xdm_c: t.channel,
              xdm_p: 1
            }),
            name: c + t.channel + "_provider"
          });
          u = v(t);
        } else l(n, "message", a), e = "postMessage" in n.parent ? n.parent : n.parent.document, e.postMessage(t.channel + "-ready", h), r(function () {
          f.up.callback(!0);
        }, 0);
      },
      init: function init() {
        p(f.onDOMReady, f);
      }
    };
  };

  e.stack.FrameElementTransport = function (u) {
    var f, e, l, a;
    return f = {
      outgoing: function outgoing(n, t, i) {
        l.call(this, n);
        i && i();
      },
      destroy: function destroy() {
        e && (e.parentNode.removeChild(e), e = null);
      },
      onDOMReady: function onDOMReady() {
        a = o(u.remote);
        u.isHost ? (s(u.props, {
          src: k(u.remote, {
            xdm_e: o(i.href),
            xdm_c: u.channel,
            xdm_p: 5
          }),
          name: c + u.channel + "_provider"
        }), e = v(u), e.fn = function (n) {
          return delete e.fn, l = n, r(function () {
            f.up.callback(!0);
          }, 0), function (n) {
            f.up.incoming(n, a);
          };
        }) : (t.referrer && o(t.referrer) != h.xdm_e && (n.top.location = h.xdm_e), l = n.frameElement.fn(function (n) {
          f.up.incoming(n, a);
        }), f.up.callback(!0));
      },
      init: function init() {
        p(f.onDOMReady, f);
      }
    };
  };

  e.stack.NameTransport = function (n) {
    function l(i) {
      var r = n.remoteHelper + (t ? "#_3" : "#_2") + n.channel;
      u.contentWindow.sendMessage(i, r);
    }

    function a() {
      t ? ++w != 2 && t || i.up.callback(!0) : (l("ready"), i.up.callback(!0));
    }

    function y(n) {
      i.up.incoming(n, b);
    }

    function tt() {
      h && r(function () {
        h(!0);
      }, 0);
    }

    var i, t, u, f, w, h, b, d;
    return i = {
      outgoing: function outgoing(n, t, i) {
        h = i;
        l(n);
      },
      destroy: function destroy() {
        u.parentNode.removeChild(u);
        u = null;
        t && (f.parentNode.removeChild(f), f = null);
      },
      onDOMReady: function onDOMReady() {
        t = n.isHost;
        w = 0;
        b = o(n.remote);
        n.local = nt(n.local);
        t ? (e.Fn.set(n.channel, function (i) {
          t && i === "ready" && (e.Fn.set(n.channel, y), a());
        }), d = k(n.remote, {
          xdm_e: n.local,
          xdm_c: n.channel,
          xdm_p: 2
        }), s(n.props, {
          src: d + "#" + n.channel,
          name: c + n.channel + "_provider"
        }), f = v(n)) : (n.remoteHelper = n.remote, e.Fn.set(n.channel, y));

        var i = function i() {
          var t = u || this;
          g(t, "load", i);
          e.Fn.set(n.channel + "_load", tt), function f() {
            typeof t.contentWindow.sendMessage == "function" ? a() : r(f, 50);
          }();
        };

        u = v({
          props: {
            src: n.local + "#_4" + n.channel
          },
          onLoad: i
        });
      },
      init: function init() {
        p(i.onDOMReady, i);
      }
    };
  };

  e.stack.HashTransport = function (t) {
    function d(n) {
      if (i) {
        var r = t.remote + "#" + b++ + "_" + n;
        (l || !h ? i.contentWindow : i).location = r;
      }
    }

    function g(n) {
      e = n;
      u.up.incoming(e.substring(e.indexOf("_") + 1), k);
    }

    function nt() {
      if (f) {
        var t = f.location.href,
            n = "",
            i = t.indexOf("#");
        i != -1 && (n = t.substring(i));
        n && n != e && g(n);
      }
    }

    function a() {
      y = setInterval(nt, w);
    }

    var u,
        tt = this,
        l,
        y,
        w,
        e,
        b,
        f,
        i,
        h,
        k;
    return u = {
      outgoing: function outgoing(n) {
        d(n);
      },
      destroy: function destroy() {
        n.clearInterval(y);
        (l || !h) && i.parentNode.removeChild(i);
        i = null;
      },
      onDOMReady: function onDOMReady() {
        if (l = t.isHost, w = t.interval, e = "#" + t.channel, b = 0, h = t.useParent, k = o(t.remote), l) {
          if (s(t.props, {
            src: t.remote,
            name: c + t.channel + "_provider"
          }), h) t.onLoad = function () {
            f = n;
            a();
            u.up.callback(!0);
          };else {
            var y = 0,
                p = t.delay / 50;

            (function d() {
              if (++y > p) throw new Error("Unable to reference listenerwindow");

              try {
                f = i.contentWindow.frames[c + t.channel + "_consumer"];
              } catch (n) {}

              f ? (a(), u.up.callback(!0)) : r(d, 50);
            })();
          }
          i = v(t);
        } else f = n, a(), h ? (i = parent, u.up.callback(!0)) : (s(t, {
          props: {
            src: t.remote + "#" + t.channel + new Date(),
            name: c + t.channel + "_consumer"
          },
          onLoad: function onLoad() {
            u.up.callback(!0);
          }
        }), i = v(t));
      },
      init: function init() {
        p(u.onDOMReady, u);
      }
    };
  };

  e.stack.ReliableBehavior = function () {
    var n,
        t,
        i = 0,
        r = 0,
        u = "";
    return n = {
      incoming: function incoming(f, e) {
        var s = f.indexOf("_"),
            o = f.substring(0, s).split(",");
        f = f.substring(s + 1);
        o[0] == i && (u = "", t && t(!0));
        f.length > 0 && (n.down.outgoing(o[1] + "," + i + "_" + u, e), r != o[1] && (r = o[1], n.up.incoming(f, e)));
      },
      outgoing: function outgoing(f, e, o) {
        u = f;
        t = o;
        n.down.outgoing(r + "," + ++i + "_" + f, e);
      }
    };
  };

  e.stack.QueueBehavior = function (n) {
    function s() {
      if (n.remove && i.length === 0) {
        ui(t);
        return;
      }

      if (!o && i.length !== 0 && !c) {
        o = !0;
        var u = i.shift();
        t.down.outgoing(u.data, u.origin, function (n) {
          o = !1;
          u.callback && r(function () {
            u.callback(n);
          }, 0);
          s();
        });
      }
    }

    var t,
        i = [],
        o = !0,
        e = "",
        c,
        l = 0,
        v = !1,
        h = !1;
    return t = {
      init: function init() {
        a(n) && (n = {});
        n.maxLength && (l = n.maxLength, h = !0);
        n.lazy ? v = !0 : t.down.init();
      },
      callback: function callback(n) {
        o = !1;
        var i = t.up;
        s();
        i.callback(n);
      },
      incoming: function incoming(i, r) {
        if (h) {
          var f = i.indexOf("_"),
              o = parseInt(i.substring(0, f), 10);
          e += i.substring(f + 1);
          o === 0 && (n.encode && (e = u(e)), t.up.incoming(e, r), e = "");
        } else t.up.incoming(i, r);
      },
      outgoing: function outgoing(r, u, e) {
        n.encode && (r = f(r));
        var c = [],
            o;

        if (h) {
          while (r.length !== 0) {
            o = r.substring(0, l), r = r.substring(o.length), c.push(o);
          }

          while (o = c.shift()) {
            i.push({
              data: c.length + "_" + o,
              origin: u,
              callback: c.length === 0 ? e : null
            });
          }
        } else i.push({
          data: r,
          origin: u,
          callback: e
        });

        v ? t.down.init() : s();
      },
      destroy: function destroy() {
        c = !0;
        t.down.destroy();
      }
    };
  };

  e.stack.VerifyBehavior = function (n) {
    function u() {
      i = Math.random().toString(16).substring(2);
      t.down.outgoing(i);
    }

    var t, i, r;
    return t = {
      incoming: function incoming(f, e) {
        var o = f.indexOf("_");
        o === -1 ? f === i ? t.up.callback(!0) : r || (r = f, n.initiate || u(), t.down.outgoing(f)) : f.substring(0, o) === r && t.up.incoming(f.substring(o + 1), e);
      },
      outgoing: function outgoing(n, r, u) {
        t.down.outgoing(i + "_" + n, r, u);
      },
      callback: function callback() {
        n.initiate && u();
      }
    };
  };

  e.stack.RpcBehavior = function (n, t) {
    function i(n) {
      n.jsonrpc = "2.0";
      r.down.outgoing(f.stringify(n));
    }

    function o(n, t) {
      var r = Array.prototype.slice;
      return function () {
        var f = arguments.length,
            s,
            o = {
          method: t
        };
        f > 0 && typeof arguments[f - 1] == "function" ? (f > 1 && typeof arguments[f - 2] == "function" ? (s = {
          success: arguments[f - 2],
          error: arguments[f - 1]
        }, o.params = r.call(arguments, 0, f - 2)) : (s = {
          success: arguments[f - 1]
        }, o.params = r.call(arguments, 0, f - 1)), u["" + ++e] = s, o.id = e) : o.params = r.call(arguments, 0);
        n.namedParams && o.params.length === 1 && (o.params = o.params[0]);
        i(o);
      };
    }

    function s(n, t, r, u) {
      var _f, _e, o;

      if (!r) {
        t && i({
          id: t,
          error: {
            code: -32601,
            message: "Procedure not found."
          }
        });
        return;
      }

      t ? (_f = function f(n) {
        _f = ot;
        i({
          id: t,
          result: n
        });
      }, _e = function e(n, r) {
        _e = ot;
        var u = {
          id: t,
          error: {
            code: -32099,
            message: n
          }
        };
        r && (u.error.data = r);
        i(u);
      }) : _f = _e = ot;
      dt(u) || (u = [u]);

      try {
        o = r.method.apply(r.scope, u.concat([_f, _e]));
        a(o) || _f(o);
      } catch (s) {
        _e(s.message);
      }
    }

    var r,
        f = t.serializer || _et(),
        e = 0,
        u = {};

    return r = {
      incoming: function incoming(n) {
        var r = f.parse(n),
            e;
        r.method ? t.handle ? t.handle(r, i) : s(r.method, r.id, t.local[r.method], r.params) : (e = u[r.id], r.error ? e.error && e.error(r.error) : e.success && e.success(r.result), delete u[r.id]);
      },
      init: function init() {
        if (t.remote) for (var i in t.remote) {
          t.remote.hasOwnProperty(i) && (n[i] = o(t.remote[i], i));
        }
        r.down.init();
      },
      destroy: function destroy() {
        for (var i in t.remote) {
          t.remote.hasOwnProperty(i) && n.hasOwnProperty(i) && delete n[i];
        }

        r.down.destroy();
      }
    };
  };

  rt.easyXDM = e;
}(window, document, location, window.setTimeout, decodeURIComponent, encodeURIComponent), function (n) {
  n.serverSettings = {
    widget: {
      googlePayEnvironment: "PRODUCTION",
      rootUrl: "https://widget.cloudpayments.ru",
      errorHandlerUrl: "",
      easyXDMSwfPath: "/scripts/easyxdm.swf",
      payformPathFormat: "/payforms/{0}/index.html",
      threeDSPopupCallbackPath: "/Home/ThreeDSPopupCallback",
      merchantBundlePath: "/bundles/cloudpayments",
      threeDSCallbackPath: "/Home/ThreeDSCallback",
      loadingImagePath: "/images/overlay-loading.svg",
      dummyPath: "/dummy.html",
      binInfoServicePath: "/Home/BinInfo",
      merchantTerminalServicePath: "/Home/MerchantInfo",
      startApplePaySessionServicePath: "/ApplePay/StartSession",
      api: {
        checkedThreeDSDataProcessingPath: "/Payments/CheckTransactionStatusAfter3DSecure",
        threeDSDataProcessingPath: "/Payments/Post3DS",
        authPath: "/Payments/Auth",
        chargePath: "/Payments/Charge"
      },
      defaultCulture: "ru",
      detectedCulture: ""
    }
  };
}(cp || (cp = {}));
!function (n, t) {
  "object" == ( false ? undefined : _typeof(exports)) && "undefined" != typeof module ? t() :  true ? !(__WEBPACK_AMD_DEFINE_FACTORY__ = (t),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : undefined;
}(0, function () {
  "use strict";

  function f(n) {
    var t = this.constructor;
    return this.then(function (i) {
      return t.resolve(n()).then(function () {
        return i;
      });
    }, function (i) {
      return t.resolve(n()).then(function () {
        return t.reject(i);
      });
    });
  }

  function e(n) {
    return !(!n || "undefined" == typeof n.length);
  }

  function h() {}

  function n(t) {
    if (!(this instanceof n)) throw new TypeError("Promises must be constructed via new");
    if ("function" != typeof t) throw new TypeError("not a function");
    this._state = 0;
    this._handled = !1;
    this._value = undefined;
    this._deferreds = [];
    s(t, this);
  }

  function o(i, u) {
    for (; 3 === i._state;) {
      i = i._value;
    }

    0 !== i._state ? (i._handled = !0, n._immediateFn(function () {
      var n = 1 === i._state ? u.onFulfilled : u.onRejected,
          f;

      if (null !== n) {
        try {
          f = n(i._value);
        } catch (e) {
          return void t(u.promise, e);
        }

        r(u.promise, f);
      } else (1 === i._state ? r : t)(u.promise, i._value);
    })) : i._deferreds.push(u);
  }

  function r(i, r) {
    try {
      if (r === i) throw new TypeError("A promise cannot be resolved with itself.");

      if (r && ("object" == _typeof(r) || "function" == typeof r)) {
        var f = r.then;
        if (r instanceof n) return i._state = 3, i._value = r, void u(i);
        if ("function" == typeof f) return void s(function (n, t) {
          return function () {
            n.apply(t, arguments);
          };
        }(f, r), i);
      }

      i._state = 1;
      i._value = r;
      u(i);
    } catch (e) {
      t(i, e);
    }
  }

  function t(n, t) {
    n._state = 2;
    n._value = t;
    u(n);
  }

  function u(t) {
    2 === t._state && 0 === t._deferreds.length && n._immediateFn(function () {
      t._handled || n._unhandledRejectionFn(t._value);
    });

    for (var i = 0, r = t._deferreds.length; r > i; i++) {
      o(t, t._deferreds[i]);
    }

    t._deferreds = null;
  }

  function s(n, i) {
    var u = !1;

    try {
      n(function (n) {
        u || (u = !0, r(i, n));
      }, function (n) {
        u || (u = !0, t(i, n));
      });
    } catch (f) {
      if (u) return;
      u = !0;
      t(i, f);
    }
  }

  var c = setTimeout,
      i;

  n.prototype["catch"] = function (n) {
    return this.then(null, n);
  };

  n.prototype.then = function (n, t) {
    var i = new this.constructor(h);
    return o(this, new function (n, t, i) {
      this.onFulfilled = "function" == typeof n ? n : null;
      this.onRejected = "function" == typeof t ? t : null;
      this.promise = i;
    }(n, t, i)), i;
  };

  n.prototype["finally"] = f;

  n.all = function (t) {
    return new n(function (n, i) {
      function f(t, u) {
        try {
          if (u && ("object" == _typeof(u) || "function" == typeof u)) {
            var e = u.then;
            if ("function" == typeof e) return void e.call(u, function (n) {
              f(t, n);
            }, i);
          }

          r[t] = u;
          0 == --o && n(r);
        } catch (s) {
          i(s);
        }
      }

      var r, o, u;
      if (!e(t)) return i(new TypeError("Promise.all accepts an array"));
      if (r = Array.prototype.slice.call(t), 0 === r.length) return n([]);

      for (o = r.length, u = 0; r.length > u; u++) {
        f(u, r[u]);
      }
    });
  };

  n.resolve = function (t) {
    return t && "object" == _typeof(t) && t.constructor === n ? t : new n(function (n) {
      n(t);
    });
  };

  n.reject = function (t) {
    return new n(function (n, i) {
      i(t);
    });
  };

  n.race = function (t) {
    return new n(function (i, r) {
      if (!e(t)) return r(new TypeError("Promise.race accepts an array"));

      for (var u = 0, f = t.length; f > u; u++) {
        n.resolve(t[u]).then(i, r);
      }
    });
  };

  n._immediateFn = "function" == typeof setImmediate && function (n) {
    setImmediate(n);
  } || function (n) {
    c(n, 0);
  };

  n._unhandledRejectionFn = function (n) {
    void 0 !== console && console && console.warn("Possible Unhandled Promise Rejection:", n);
  };

  i = function () {
    if ("undefined" != typeof self) return self;
    if ("undefined" != typeof window) return window;
    if ("undefined" != typeof global) return global;
    throw Error("unable to locate global object");
  }();

  "Promise" in i ? i.Promise.prototype["finally"] || (i.Promise.prototype["finally"] = f) : i.Promise = n;
}), function (n) {
  var t = function () {
    function t() {}

    return t.collect = function (t, i, r, u) {
      try {
        n.MatomoTracker.pushEvent(t, i, r, u);
      } catch (f) {}
    }, t.goal = function (t, i) {
      try {
        n.MatomoTracker.pushGoal(t, i);
      } catch (r) {}
    }, t;
  }();

  n.Analytics = t;

  try {
    window.location.host !== "widget.cloudpayments.kz" && window.location.host !== "widget.cloudpayments.eu" && n.MatomoTracker.load("3", "Widget Frame");
  } catch (i) {}
}(cp || (cp = {})), function (n) {
  var i = function () {
    function n() {}

    return n.currentModel = function () {
      return this.getModel();
    }, n.getModel = function () {
      var u, i, r, n;
      if (this.iosVer == null && (this.iosVer = parseFloat(("" + (/CPU.*OS ([0-9_]{1,5})|(CPU like).*AppleWebKit.*Mobile/i.exec(navigator.userAgent) || [0, ""])[1]).replace("undefined", "3_2").replace("_", ".").replace("_", "")) || !1), this.iosVer >= 12.2) return t.IPhone_NotDetected;
      if (u = window.devicePixelRatio, this.canvasEl === undefined && (this.canvasEl = document.createElement("canvas")), this.canvasEl && (i = this.canvasEl.getContext("webgl") || this.canvasEl.getContext("experimental-webgl"), i && (r = i.getExtension("WEBGL_debug_renderer_info"), r && (n = i.getParameter(r.UNMASKED_RENDERER_WEBGL)))), window.screen.height === 896 && window.screen.width === 414 && (window.devicePixelRatio === 3 || window.devicePixelRatio === 2)) switch (u) {
        default:
          return t.IPhone_XR;

        case 2:
          return t.IPhone_XR;

        case 3:
          return t.IPhone_XS_Max;
      } else if (window.screen.height === 812 && window.screen.width === 375) switch (n) {
        default:
          return t.IPhone_X;

        case "Apple A11 GPU":
          return t.IPhone_X;

        case "Apple A12 GPU":
          return t.IPhone_XS;
      } else if (window.screen.height === 736 && window.screen.width === 414 && window.devicePixelRatio === 3) switch (n) {
        default:
          return t.IPhone_6_PLUS;

        case "Apple A8 GPU":
          return t.IPhone_6_PLUS;

        case "Apple A9 GPU":
          return t.IPhone_6S_PLUS;

        case "Apple A10 GPU":
          return t.IPhone_7_PLUS;

        case "Apple A11 GPU":
          return t.IPhone_8_PLUS;
      } else if (window.screen.height === 667 && window.screen.width === 375 && window.devicePixelRatio === 3) switch (n) {
        default:
          return t.IPhone_6_PLUS;

        case "Apple A8 GPU":
          return t.IPhone_6_PLUS;

        case "Apple A9 GPU":
          return t.IPhone_6S_PLUS;

        case "Apple A10 GPU":
          return t.IPhone_7_PLUS;

        case "Apple A11 GPU":
          return t.IPhone_8_PLUS;
      } else if (window.screen.height === 667 && window.screen.width === 375 && window.devicePixelRatio === 2) switch (n) {
        default:
          return t.IPhone_6;

        case "Apple A8 GPU":
          return t.IPhone_6;

        case "Apple A9 GPU":
          return t.IPhone_6S;

        case "Apple A10 GPU":
          return t.IPhone_7;

        case "Apple A11 GPU":
          return t.IPhone_8;
      } else if (window.screen.height / window.screen.width == 1.775 && window.devicePixelRatio == 2) switch (n) {
        default:
          return t.IPhone_5;

        case "PowerVR SGX 543":
          return t.IPhone_5;

        case "Apple A7 GPU":
          return t.IPhone_5S;

        case "Apple A8 GPU":
          return t.IPhone_6;

        case "Apple A9 GPU":
          return t.IPhone_SE;

        case "Apple A10 GPU":
          return t.IPhone_7;

        case "Apple A11 GPU":
          return t.IPhone_8;
      } else if (window.screen.height / window.screen.width == 1.5 && window.devicePixelRatio == 2) switch (n) {
        default:
          return t.IPhone_4;

        case "PowerVR SGX 535":
          return t.IPhone_4;

        case "PowerVR SGX 543":
          return t.IPhone_4S;
      } else if (window.screen.height / window.screen.width == 1.5 && window.devicePixelRatio == 1) switch (n) {
        default:
          return t.IPhone;

        case "ALP0298C05":
          return t.IPhone_3GS;

        case "S5L8900":
          return t.IPhone;
      } else return n && !!n.match("Apple") && this.iosVer ? t.IPhone : t.Not_IPhone;
    }, n.iosVer = null, n;
  }(),
      t;

  n.PhoneModelDetector = i, function (n) {
    n[n.Not_IPhone = 0] = "Not_IPhone";
    n[n.IPhone = 1] = "IPhone";
    n[n.IPhone_3G = 3] = "IPhone_3G";
    n[n.IPhone_3GS = 3.1] = "IPhone_3GS";
    n[n.IPhone_4 = 4] = "IPhone_4";
    n[n.IPhone_4S = 4.1] = "IPhone_4S";
    n[n.IPhone_5 = 5] = "IPhone_5";
    n[n.IPhone_5C = 5.1] = "IPhone_5C";
    n[n.IPhone_5S = 5.2] = "IPhone_5S";
    n[n.IPhone_SE = 6] = "IPhone_SE";
    n[n.IPhone_6 = 6.1] = "IPhone_6";
    n[n.IPhone_6_PLUS = 6.2] = "IPhone_6_PLUS";
    n[n.IPhone_6S = 6.3] = "IPhone_6S";
    n[n.IPhone_6S_PLUS = 6.4] = "IPhone_6S_PLUS";
    n[n.IPhone_7 = 7] = "IPhone_7";
    n[n.IPhone_7_PLUS = 7.1] = "IPhone_7_PLUS";
    n[n.IPhone_8 = 8] = "IPhone_8";
    n[n.IPhone_8_PLUS = 8.1] = "IPhone_8_PLUS";
    n[n.IPhone_X = 10] = "IPhone_X";
    n[n.IPhone_XR = 10.1] = "IPhone_XR";
    n[n.IPhone_XS = 10.2] = "IPhone_XS";
    n[n.IPhone_XS_Max = 10.3] = "IPhone_XS_Max";
    n[n.IPhone_NotDetected = 1e6] = "IPhone_NotDetected";
  }(t = n.PhoneModelEnum || (n.PhoneModelEnum = {}));
}(cp || (cp = {})), function (n) {
  var t, i;

  (function (n) {
    n[n.none = 0] = "none";
    n[n.iFrame = 1] = "iFrame";
  })(t = n.PostMessageSupport || (n.PostMessageSupport = {}));

  i = function () {
    function i() {
      var i, t, r;
      this.device = {};
      i = n.PhoneModelDetector.currentModel();
      t = navigator.userAgent.match(/(iPad|iPhone|iPod)/g);
      t && (this.device[t[0]] = {}, this.device.iOS = {});
      i && (this.device.iPhone = {}, this.device.iOS = {});
      r = navigator.userAgent.match(/Android/g);
      r && (this.device.Android = {});
      this.browser = {
        ie: this.detectIE(),
        chromeForIOS: this.detectChromeForIOS(),
        safariForIOS: this.detectSafariForIOS(),
        androidBrowser: this.detectAndroidBrowser(),
        yandexBrowser: this.detectYandexBrowser(),
        facebookForIOS: this.detectFacebookForIOS(),
        microsoftEdge: this.detectEdge(),
        instagram: this.detectInstagram()
      };
      this.features = {
        hasSmallScreen: this.detectSmallScreen() || this.device.iPad,
        supportsCors: "withCredentials" in new XMLHttpRequest(),
        postMessageSupport: this.detectPostMessageSupport(),
        supportsViewPortUnits: this.detectViewPortUnitsSupport(),
        hasVirtualKeyboard: !!(this.detectSmallScreen() || this.device.iPad),
        supportsApplePay: this.detectApplePaySupport(),
        supportsGooglePay: this.detectGooglePaySupport(),
        isDonateWithApplePayEnabled: this.detectDonateWithApplePayButtonEnabled()
      };
    }

    return i.prototype.detectViewPortUnitsSupport = function () {
      var n, t;

      try {
        if (n = this.browser.androidBrowser, n) return n.version ? (t = n.version.split("."), t.length > 1 && parseInt(t[0]) == 4 && parseInt(t[1]) > 4) : !1;
      } catch (i) {}

      return !(this.browser.ie && this.browser.ie.version < 9);
    }, i.prototype.detectPostMessageSupport = function () {
      return "postMessage" in window ? this.browser.ie && this.browser.ie.version < 9 ? t.none : t.iFrame : t.none;
    }, i.prototype.detectSmallScreen = function () {
      var n, t;
      return this.device.iPhone ? !0 : window.screen ? (n = window.screen.width, window.devicePixelRatio && window.screen.width / window.devicePixelRatio === window.innerWidth && (n = window.innerWidth), t = window.screen && n <= 760 && n > 0, t) ? !0 : !1 : !1;
    }, i.prototype.detectApplePaySupport = function () {
      try {
        return !(n.PhoneModelDetector.currentModel() === n.PhoneModelEnum.IPhone_5S) && this.browser.chromeForIOS == null && "ApplePaySession" in window && ApplePaySession.canMakePayments();
      } catch (t) {
        return !1;
      }
    }, i.prototype.detectGooglePaySupport = function () {
      return !0;
    }, i.prototype.detectFacebookForIOS = function () {
      var n = !!(this.device.iPhone || this.device.iPad || this.device.iPod),
          t = navigator.userAgent.toUpperCase().indexOf("FBAN/") > -1;
      return n && t ? {} : null;
    }, i.prototype.detectChromeForIOS = function () {
      return /(CriOS)/g.test(navigator.userAgent) ? {} : null;
    }, i.prototype.detectYandexBrowser = function () {
      return navigator.userAgent.indexOf("YaBrowser") > -1 ? {} : null;
    }, i.prototype.detectSafariForIOS = function () {
      var n = /(iPad|iPhone|iPod)/g.test(navigator.userAgent);
      return n && !this.detectChromeForIOS() && !this.detectYandexBrowser() && !this.detectFacebookForIOS() ? {
        version: (navigator.userAgent.match(/\b[0-9]+_[0-9]+(?:_[0-9]+)?\b/) || [""])[0].replace(/_/g, ".")
      } : null;
    }, i.prototype.detectIE = function () {
      var n = navigator.userAgent.match(/MSIE\s+([0-9\.]+);/i);
      return n && n.length > 1 ? {
        version: parseInt(n[1], 10)
      } : !!window.MSInputMethodContext && !!document.documentMode ? {
        version: 11
      } : null;
    }, i.prototype.detectEdge = function () {
      var n = navigator.userAgent.match(/Edge\/([^ ]+)$/i);
      return n ? {
        version: parseFloat(n[1])
      } : !!window.MSInputMethodContext && !!document.documentMode ? {
        version: 11
      } : null;
    }, i.prototype.detectInstagram = function () {
      var n = navigator.userAgent.match(/instagram/gi);
      return n ? !0 : null;
    }, i.prototype.detectAndroidBrowser = function () {
      var i = navigator.userAgent.indexOf("Android") > -1 && navigator.userAgent.indexOf("Mozilla/5.0") > -1 && navigator.userAgent.indexOf("AppleWebKit") > -1,
          n = /AppleWebKit\/([\d.]+)/.exec(navigator.userAgent),
          t = n === null ? null : parseFloat(n[1]),
          r = i && t !== null && t < 537;
      return r ? {
        version: this.getAndroidVersion(navigator.userAgent)
      } : null;
    }, i.prototype.getAndroidVersion = function (n) {
      var t = n.match(/android\s([0-9\.]+)/i) || n.match(/android[; ]+release\/([0-9\.]+)/i);
      return t ? t[1] : null;
    }, i.prototype.detectDonateWithApplePayButtonEnabled = function () {
      var n, t, i;
      return !this.browser.safariForIOS || !this.browser.safariForIOS.version ? !1 : (n = this.browser.safariForIOS.version.split("."), t = parseInt(n[0]), !t) ? !1 : (n.length > 1 && (i = parseInt(n[1])), i || (i = 0), t < 10 ? !1 : t > 10 ? !0 : i >= 2);
    }, i;
  }();

  n.ClientSettings = i;
  n.clientSettings = new i();
}(cp || (cp = {})), function (n) {
  var t = function () {
    function t() {}

    return t.createApplePaymentRequest = function (n, t, i, r) {
      var u = {
        countryCode: "RU",
        currencyCode: i,
        supportedNetworks: ["visa", "masterCard"],
        merchantCapabilities: ["supports3DS"],
        total: {
          label: n,
          amount: t.toString()
        }
      };
      return r && (u.requiredBillingContactFields = ["email"]), u;
    }, t.pay = function (n, i, r, u) {
      var e = t.createApplePaymentRequest(i, n.amount, n.currency, n.requireEmail && !n.email),
          f = new ApplePaySession(1, e);

      f.onvalidatemerchant = function (t) {
        r.startApplePaySession({
          validationUrl: t.validationURL,
          terminalPublicId: n.publicId
        });
      };

      u.onCompleteApplePayMerchantValidation(function (n) {
        f.completeMerchantValidation(n);
      });

      f.oncancel = function () {
        r.resetPayment();
      };

      f.onpaymentauthorized = function (n) {
        r.applePayOperation(n.payment);
      };

      u.onCompleteApplePayOperation(function (n) {
        f.completePayment(n ? ApplePaySession.STATUS_SUCCESS : ApplePaySession.STATUS_FAILURE);
      });
      f.begin();
    }, t.isApplePayAvailable = function () {
      if (n.clientSettings.features.supportsApplePay) try {
        return ApplePaySession.canMakePayments() ? Promise.resolve(!0) : Promise.resolve(!1);
      } catch (t) {
        return Promise.resolve(!1);
      }
      return Promise.resolve(!1);
    }, t;
  }();

  n.ApplePayApi = t;
}(cp || (cp = {})), function (n) {
  var i = function () {
    function t() {}

    return t.addEventListener = function (n, t, i) {
      if (n.addEventListener) n.addEventListener(t, i, !1);else {
        var r = function r(n) {
          return n || (n = window.event), typeof n.keyCode != "undefined" && (n.which = n.keyCode), typeof n.srcElement != "undefined" && (n.target = n.srcElement), n.preventDefault || (n.preventDefault = function () {
            this.returnValue = !1;
          }), i(n);
        };

        i._normalizingHandler = r;
        n.attachEvent("on" + t, r);
      }
    }, t.generateRandomString = function (n) {
      for (var t = "", i = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", r = 0; r < n; r++) {
        t += i.charAt(Math.floor(Math.random() * i.length));
      }

      return t;
    }, t.removeEventListener = function (n, t, i) {
      if (n.removeEventListener) n.removeEventListener(t, i, !1);else {
        var r = i._normalizingHandler;
        n.detachEvent("on" + t, r || i);
      }
    }, t.show = function (n) {
      n.style.display = "";
      n.style.opacity = "0";
      setTimeout(function () {
        n.style.opacity = "1";
      }, 15);
    }, t.createAndSubmitForm = function (n, t, i) {
      var r = n.createElement("form"),
          f,
          u;
      r.action = t;
      r.method = "POST";

      for (f in i) {
        i.hasOwnProperty(f) && (u = n.createElement("input"), u.type = "hidden", u.name = f, u.value = i[f], r.appendChild(u));
      }

      n.body.appendChild(r);
      r.submit();
    }, t.hide = function (n) {
      n.style.opacity = "0";
      n.style.display = "none";
    }, t.sendPost = function (n, i, r, u, f) {
      return t.sendRequest(n, "POST", i, r, u, f);
    }, t.sendGet = function (n, i, r, u, f) {
      return t.sendRequest(n, "GET", i, r, u, f);
    }, t.sendPostAndReturnJson = function (n, i, r, u, f) {
      return t.sendPost(n, i, function (n) {
        r && r(JSON.parse(n));
      }, u, f);
    }, t.sendGetAndReturnJson = function (n, i, r, u, f) {
      return t.sendGet(n, i, function (n) {
        r && r(JSON.parse(n));
      }, u, f);
    }, t.removeSpaces = function (n) {
      return n.replace(/ /g, "");
    }, t.isHtmlElement = function (n) {
      return "HTMLElement" in window && n instanceof HTMLElement || n && _typeof(n) == "object" && n !== null && n.nodeType === 1 && typeof n.nodeName == "string";
    }, t.createElement = function (n, i) {
      for (var r, f = [], u = 2; u < arguments.length; u++) {
        f[u - 2] = arguments[u];
      }

      return r = document.createElement(n), i != null && (r.className = i), f != null && t.forEach(f, function (n) {
        n instanceof HTMLElement || n instanceof HTMLInputElement ? r.appendChild(n) : r.setAttribute(n.key, n.value);
      }), r;
    }, t.createKVP = function (n, t) {
      return {
        key: n,
        value: t
      };
    }, t.createQuery = function (n) {
      var t = [];

      for (var i in n) {
        t.push(encodeURIComponent(i) + "=" + encodeURIComponent(n[i]));
      }

      return t.length === 0 ? "" : t.join("&");
    }, t.parseQuery = function (n) {
      var u = {},
          f,
          i,
          t,
          r;
      if (n && n.length > 0) for (f = n.charAt(0) === "?" ? n.substring(1) : n, i = f.split("&"), t = 0; t < i.length; t++) {
        r = i[t].split("=");

        try {
          u[decodeURIComponent(r[0])] = decodeURIComponent(r[1]);
        } catch (e) {}
      }
      return u;
    }, t.sendRequest = function (n, i, r, u, f, e) {
      var o, s;
      if (r && _typeof(r) != "object") throw new Error("Argument 'data' must me a parameter name-value map");
      if (o = t.createXMLHttpRequest(), !o) throw Error("XMLHttpRequest is not supported");
      if (o.readyState == 4) throw Error("XMLHttpRequest is in invalid state 'completed' before sending");
      if (s = null, i === "POST") o.open(i, n, !0), o.setRequestHeader("Content-type", "application/x-www-form-urlencoded"), s = t.createQuery(r);else if (i === "GET") o.open(i, t.appendQueryToUrl(n, r), !0);else throw new Error("Invalid HTTP method '" + i + "'");
      return o.setRequestHeader("X-Request-ID", t.XRequestId), o.onreadystatechange = function () {
        var n = this;
        n.readyState == 4 && (o.onreadystatechange = null, n.status != 200 && n.status != 304 ? f && f(n.responseText) : u && u(n.responseText), e && e(n.responseText));
      }, o.send(s), o;
    }, t.appendQueryToUrl = function (n, i) {
      var u, r;
      if (_typeof(i) != "object") throw new TypeError("Argument 'data' must be an object");
      return (u = t.createQuery(i), !u) ? n : (r = document.createElement("a"), r.href = n, r.search += (r.search ? "&" : "?") + u, r.href);
    }, t.createXMLHttpRequest = function () {
      try {
        return new XMLHttpRequest();
      } catch (n) {}

      try {
        return new ActiveXObject("Msxml3.XMLHTTP");
      } catch (n) {}

      try {
        return new ActiveXObject("Msxml2.XMLHTTP.6.0");
      } catch (n) {}

      try {
        return new ActiveXObject("Msxml2.XMLHTTP.3.0");
      } catch (n) {}

      try {
        return new ActiveXObject("Msxml2.XMLHTTP");
      } catch (n) {}

      try {
        return new ActiveXObject("Microsoft.XMLHTTP");
      } catch (n) {}

      return null;
    }, t.addClass = function (n, t) {
      n.className += " " + t;
    }, t.isClosedWindow = function (n) {
      return !n || !("closed" in n) || n.closed;
    }, t.trackWindowClose = function (n, i) {
      return t.setIntervalUntil(i, function () {
        return t.isClosedWindow(n);
      }, 500);
    }, t.removeClass = function (n, t) {
      for (var i = n.className; i.indexOf(t) != -1;) {
        i = i.replace(t, ""), i = i.trim();
      }

      n.className = i;
    }, t.format = function (n) {
      for (var i = [], t = 1; t < arguments.length; t++) {
        i[t - 1] = arguments[t];
      }

      if (!n) throw new Error("Argument 'formatString' must be specified");
      return n.replace(/{(\d+)}/g, function (n, t) {
        var r = parseInt(t),
            u;
        if (isNaN(r)) throw new Error("Invalid format string argument '" + t + "'");
        if (u = i[r], typeof u == "undefined") throw new Error("Format string argument " + r + " must be provided");
        return u;
      });
    }, t.forEach = function (n, t) {
      for (var i = 0; i < n.length; i++) {
        t(n[i], i);
      }
    }, t.indexOf = function (n, t, i) {
      if (typeof n == "undefined" || n === null) throw new TypeError('"this" is null or not defined');
      var r = n.length >>> 0;

      for (i = +i || 0, Math.abs(i) === Infinity && (i = 0), i < 0 && (i += r, i < 0 && (i = 0)); i < r; i++) {
        if (n[i] === t) return i;
      }

      return -1;
    }, t.isNullOrUndefined = function (n) {
      return n === null || typeof n == "undefined";
    }, t.setIntervalUntil = function (n, t, i) {
      var r = setInterval(function () {
        t() && (clearInterval(r), n());
      }, i, t);
      return {
        cancel: function cancel() {
          r && (clearInterval(r), r = null);
        }
      };
    }, t.getHostnameFromUrl = function (n) {
      var t = n.match(/^https?\:\/\/([^\/?#]+)(?:[\/?#]|$)/i);
      return t && t[1];
    }, t.createLoadingOverlay = function (t) {
      var i = t.createElement("div"),
          r,
          u,
          f;
      i.id = "cloudpayments-loading-overlay-63456123";
      i.style.cssText = "position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; text-align: center; background-color: transparent; z-index: 9999;";
      r = t.createElement("img");
      r.style.cssText = "position: relative; top:50%;width: 64px;height:64px";
      r.src = n.serverSettings.widget.rootUrl + n.serverSettings.widget.loadingImagePath;
      u = t.createElement("style");
      u.type = "text/css";
      f = "@-webkit-keyframes rotating /* Safari and Chrome */ {\n                        from {\n                          -webkit-transform: rotate(0deg);\n                          -o-transform: rotate(0deg);\n                          transform: rotate(0deg);\n                        }\n                        to {\n                          -webkit-transform: rotate(360deg);\n                          -o-transform: rotate(360deg);\n                          transform: rotate(360deg);\n                        }\n                      }\n                      @keyframes rotating {\n                        from {\n                          -ms-transform: rotate(0deg);\n                          -moz-transform: rotate(0deg);\n                          -webkit-transform: rotate(0deg);\n                          -o-transform: rotate(0deg);\n                          transform: rotate(0deg);\n                        }\n                        to {\n                          -ms-transform: rotate(360deg);\n                          -moz-transform: rotate(360deg);\n                          -webkit-transform: rotate(360deg);\n                          -o-transform: rotate(360deg);\n                          transform: rotate(360deg);\n                        }\n                      }\n                      #cloudpayments-loading-overlay-63456123 > img{\n                        -webkit-animation: rotating 2s linear infinite;\n                        -moz-animation: rotating 2s linear infinite;\n                        -ms-animation: rotating 2s linear infinite;\n                        -o-animation: rotating 2s linear infinite;\n                        animation: rotating 2s linear infinite;\n                      }";
      u.appendChild(t.createTextNode(f));
      i.appendChild(u);
      i.appendChild(r);
      t.body.appendChild(i);
    }, t.removeLoadingOverlay = function (n) {
      var t = n.getElementById("cloudpayments-loading-overlay-63456123");
      t && t.parentNode && t.parentNode.removeChild(t);
    }, t.XRequestId = t.generateRandomString(32), t.jsLoader = {
      url: function url(n) {
        return new Promise(function (t, i) {
          var r = document.createElement("script");
          r.type = "text/javascript";
          r.src = n;
          r.addEventListener("load", function () {
            return t(!0);
          }, !1);
          r.addEventListener("error", function () {
            return i(!1);
          }, !1);
          document.body.appendChild(r);
        });
      },
      urls: function urls(n) {
        return Promise.all(n.map(t.jsLoader.url));
      }
    }, t;
  }(),
      t,
      r;

  n.Utils = i;

  t = function () {
    function n(n) {
      n === void 0 && (n = window.location.search);
      this.map = i.parseQuery(n);
      this.queryLowerCase = {};

      for (var t in this.map) {
        this.queryLowerCase[t.toLowerCase()] = this.map[t];
      }
    }

    return n.prototype.getValue = function (n) {
      return this.queryLowerCase[n.toLowerCase()];
    }, n;
  }();

  n.QueryParams = t;
  n.queryParams = new t();
  "Prototype" in window && (r = JSON.stringify, JSON.stringify = function (n) {
    var i = Array.prototype.toJSON,
        t;
    return delete Array.prototype.toJSON, t = r(n), Array.prototype.toJSON = i, t;
  });
}(cp || (cp = {})), function (n) {
  var i, t;

  (function (n) {
    n[n.ApplePay = 0] = "ApplePay";
    n[n.GooglePay = 1] = "GooglePay";
  })(i = n.ExternalPaymentMethods || (n.ExternalPaymentMethods = {}));

  t = function () {
    function n(n, t) {
      this.key = n;
      this.value = t;
    }

    return n.prototype.setValue = function (n) {
      this.value = n;
    }, n;
  }();

  n.KeyValuePair = t;
}(cp || (cp = {})), function (n) {
  var t, i;

  (function (n) {
    n[n.childOk = 0] = "childOk";
    n[n.parentOk = 1] = "parentOk";
    n[n.command = 2] = "command";
  })(t || (t = {}));

  i = function () {
    function i(t, r) {
      var f, e, u;
      if (this.options = t, this.methods = r, f = this.getChannelId(), f ? (this.channelId = f, this.isChild = !0) : (this.channelId = Math.random().toString(), this.isChild = !1), this.localOrigin = i.getOrigin(window.location.href), this.remoteOrigin = i.getOrigin(t.remote), !window.postMessage) throw new Error("Browser does not support window.postMessage");
      e = this;
      n.Utils.addEventListener(window, "message", function (n) {
        return e.receiveMessage(n);
      });
      this.bindRemoteMethods(this.methods.remote);
      this.isChild ? (this.targetWindow = window.parent, this.sendChildOk()) : (u = document.createElement("iframe"), u.allowPaymentRequest = !0, u.name = this.getWindowNameFromChannelId(this.channelId), u.src = t.remote, t.container != null ? t.container.appendChild(u) : !1, this.targetWindow = u.contentWindow);
    }

    return i.prototype.getChannelId = function () {
      return this.getChannelIdFromWindowName() || n.queryParams.getValue("channelid");
    }, i.prototype.getChannelIdFromWindowName = function () {
      if (window.name) {
        var n = window.name.indexOf("cp.rpc.");
        if (n === 0) return window.name.substring(7);
      }

      return null;
    }, i.prototype.getWindowNameFromChannelId = function (n) {
      return "cp.rpc." + n;
    }, i.prototype.bindRemoteMethods = function (n) {
      for (var t in n) {
        n.hasOwnProperty(t) && this.addRemoteMethod(t);
      }
    }, i.prototype.addRemoteMethod = function (n) {
      var t = this;

      this[n] = function () {
        t.sendCommand({
          name: n,
          arguments: Array.prototype.slice.call(arguments)
        });
      };
    }, i.prototype.receiveMessage = function (n) {
      if (this.remoteOrigin === n.origin) {
        var i = JSON.parse(n.data);
        if (this.channelId === i.channelId) switch (i.type) {
          case t.childOk:
            if (this.isChild) throw new Error("Invalid message: 'childOk' must not be received by a child");else {
              this.targetWindow && this.sendParentOk();
              this.ready();
              return;
            }

          case t.parentOk:
            if (this.isChild) {
              this.ready();
              return;
            }

            throw new Error("Invalid message: 'parentOk' must not be received by a parent");

          case t.command:
            this.executeCommand(i.command);
            return;

          default:
            throw new Error("Invalid MessageType value " + i.type);
        }
      }
    }, i.prototype.executeCommand = function (n) {
      if (!n.name || !n.arguments) throw new Error("Invalid command");
      if (!this.methods.local.hasOwnProperty(n.name)) throw new Error("Local RPC method '" + n.name + "' is not defined");
      var t = this.methods.local[n.name];
      t.apply(this, n.arguments);
    }, i.prototype.sendChildOk = function () {
      if (!this.isChild) throw new Error("RPC is not a child");
      this.postMessage({
        type: t.childOk,
        channelId: this.channelId
      });
    }, i.prototype.sendParentOk = function () {
      if (this.isChild) throw new Error("RPC is not a parent");
      this.postMessage({
        type: t.parentOk,
        channelId: this.channelId
      });
    }, i.prototype.sendCommand = function (n) {
      if (!this.isReady) throw new Error("RPC is not ready");
      this.postMessage({
        type: t.command,
        channelId: this.channelId,
        command: n
      });
    }, i.prototype.postMessage = function (n) {
      this.targetWindow.postMessage(JSON.stringify(n), this.remoteOrigin);
    }, i.prototype.ready = function () {
      this.isReady || (this.isReady = !0, this.options.onReady && this.options.onReady());
    }, i.getOrigin = function (n) {
      var t = document.createElement("a"),
          i,
          r;
      return (t.href = n, t.origin) ? t.origin : (i = t.protocol + "//" + t.hostname, t.port && (r = i + ":" + t.port, n.indexOf(r) === 0)) ? r : i;
    }, i;
  }();

  n.PostMessageRpc = i;
}(cp || (cp = {})), function (n) {
  var t = function () {
    function t() {}

    return t.createRpc = function (t, i) {
      return n.clientSettings.features.postMessageSupport === n.PostMessageSupport.none ? new easyXDM.Rpc(t, i) : new n.PostMessageRpc(t, i);
    }, t;
  }();

  n.RpcFatory = t;
}(cp || (cp = {})), function (n) {
  var t = function () {
    function n() {}

    return n.supportsHashTransportOnly = function () {
      var t = n.getMajorFlashVersion();
      return !n.supportsPostMessageApi();
    }, n.supportsPostMessageApi = function () {
      return typeof postMessage == "function";
    }, n.getMajorFlashVersion = function () {
      function i(n) {
        return (n = n.match(/[\d]+/g), !n) ? "" : (n.length = 3, n.join("."));
      }

      var t = !1,
          n = "",
          r,
          u,
          e;
      if (navigator.plugins && navigator.plugins.length) r = navigator.plugins["Shockwave Flash"], r && (t = !0, r.description && (n = i(r.description))), navigator.plugins["Shockwave Flash 2.0"] && (t = !0, n = "2.0.0.11");else if (navigator.mimeTypes && navigator.mimeTypes.length) u = navigator.mimeTypes["application/x-shockwave-flash"], (t = u && u.enabledPlugin) && (n = i(u.enabledPlugin.description));else try {
        var f = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7"),
            t = !0,
            n = i(f.GetVariable("$version"));
      } catch (o) {
        try {
          f = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");
          t = !0;
          n = "6.0.21";
        } catch (s) {
          try {
            f = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
            t = !0;
            n = i(f.GetVariable("$version"));
          } catch (h) {}
        }
      }
      return e = n, t ? parseInt(n.split(".")[0], 10) : null;
    }, n;
  }();

  n.TransportSupportHelper = t;
}(cp || (cp = {})), function (n) {
  var t = function () {
    function n() {}

    return n.createApplePaymentRequest = function (n, t, i) {
      return {
        countryCode: "RU",
        currencyCode: i,
        supportedNetworks: ["visa", "masterCard"],
        merchantCapabilities: ["supports3DS"],
        total: {
          label: "Pay to " + n,
          amount: t.toString()
        }
      };
    }, n;
  }();

  n.PaymentRequestFactory = t;
}(cp || (cp = {})), function (n) {
  var t = function () {
    function n() {}

    return n.initialize = function () {
      if (typeof window != "undefined") {
        var n = {
          get passive() {
            return this.hasPassiveEvents = !0, undefined;
          }

        };
        window.addEventListener("testPassive", null, n);
        window.removeEventListener("testPassive", null, n);
      }

      this.initialized = !0;
    }, n.allowTouchMove = function (n) {
      return this.locks.some(function (t) {
        return t.options.allowTouchMove && t.options.allowTouchMove(n) ? !0 : !1;
      });
    }, n.preventDefault = function (n) {
      var t = n || window.event;
      return this.allowTouchMove(t.target) ? !0 : t.touches.length > 1 ? !0 : (t.preventDefault && t.preventDefault(), !1);
    }, n.setOverflowHidden = function (n) {
      var t = this;
      setTimeout(function () {
        if (t.previousBodyPaddingRight === undefined) {
          var r = !!n && n.reserveScrollBarGap === !0,
              i = window.innerWidth - document.documentElement.clientWidth;
          r && i > 0 && (t.previousBodyPaddingRight = document.body.style.paddingRight, document.body.style.paddingRight = i + "px");
        }

        t.previousBodyOverflowSetting === undefined && (t.previousBodyOverflowSetting = document.body.style.overflow, document.body.style.overflow = "hidden");
      });
    }, n.restoreOverflowSetting = function () {
      var n = this;
      setTimeout(function () {
        n.previousBodyPaddingRight !== undefined && (document.body.style.paddingRight = n.previousBodyPaddingRight, n.previousBodyPaddingRight = undefined);
        n.previousBodyOverflowSetting !== undefined && (document.body.style.overflow = n.previousBodyOverflowSetting, n.previousBodyOverflowSetting = undefined);
      });
    }, n.isTargetElementTotallyScrolled = function (n) {
      return n ? n.scrollHeight - n.scrollTop <= n.clientHeight : !1;
    }, n.handleScroll = function (n, t) {
      var i = n.targetTouches[0].clientY - this.initialClientY;
      return this.allowTouchMove(n.target) ? !1 : t && t.scrollTop === 0 && i > 0 ? this.preventDefault(n) : this.isTargetElementTotallyScrolled(t) && i < 0 ? this.preventDefault(n) : (n.stopPropagation(), !0);
    }, n.disableBodyScroll = function (n, t) {
      var r = this,
          i;

      if (this.isIosDevice) {
        if (!n) {
          console.error("disableBodyScroll unsuccessful - targetElement must be provided when calling disableBodyScroll on IOS devices.");
          return;
        }

        n && !this.locks.some(function (t) {
          return t.targetElement === n;
        }) && (i = {
          targetElement: n,
          options: t || {}
        }, this.locks = this.locks.concat([i]), n.ontouchstart = function (n) {
          n.targetTouches.length === 1 && (r.initialClientY = n.targetTouches[0].clientY);
        }, n.ontouchmove = function (t) {
          t.targetTouches.length === 1 && r.handleScroll(t, n);
        }, this.documentListenerAdded || (document.addEventListener("touchmove", this.preventDefault.bind(this), this.hasPassiveEvents ? {
          passive: !1
        } : undefined), this.documentListenerAdded = !0));
      } else this.setOverflowHidden(t), i = {
        targetElement: n,
        options: t || {}
      }, this.locks = this.locks.concat([i]);
    }, n.clearAllBodyScrollLocks = function () {
      this.isIosDevice ? (this.locks.forEach(function (n) {
        n.targetElement.ontouchstart = null;
        n.targetElement.ontouchmove = null;
      }), this.documentListenerAdded && (document.removeEventListener("touchmove", this.preventDefault.bind(this), this.hasPassiveEvents ? {
        passive: !1
      } : undefined), this.documentListenerAdded = !1), this.locks = [], this.initialClientY = -1) : (this.restoreOverflowSetting(), this.locks = []);
    }, n.enableBodyScroll = function (n) {
      if (this.isIosDevice) {
        if (!n) {
          console.error("enableBodyScroll unsuccessful - targetElement must be provided when calling enableBodyScroll on IOS devices.");
          return;
        }

        n.ontouchstart = null;
        n.ontouchmove = null;
        this.locks = this.locks.filter(function (t) {
          return t.targetElement !== n;
        });
        this.documentListenerAdded && this.locks.length === 0 && (document.removeEventListener("touchmove", this.preventDefault.bind(this), this.hasPassiveEvents ? {
          passive: !1
        } : undefined), this.documentListenerAdded = !1);
      } else this.locks = this.locks.filter(function (t) {
        return t.targetElement !== n;
      }), this.locks.length || this.restoreOverflowSetting();
    }, n.initialized = !1, n.hasPassiveEvents = !1, n.isIosDevice = typeof window != "undefined" && window.navigator && window.navigator.platform && /iP(ad|hone|od)/.test(window.navigator.platform), n.locks = [], n.documentListenerAdded = !1, n.initialClientY = -1, n;
  }();

  n.BodyScrollLock = t;
  n.BodyScrollLock.initialize();
}(cp || (cp = {})), function (n) {
  var t = function () {
    function n() {
      this.isReady = !1;
    }

    return n.prototype.ready = function () {
      this.isReady = !0;
      this.callable && this.callable();
    }, n.prototype.setCallable = function (n) {
      this.callable = n;
      this.isReady && this.callable();
    }, n;
  }(),
      i = function () {
    function n() {}

    return n.prototype.onCompleteApplePayMerchantValidation = function (n) {
      this.completeApplePayMerchantValidationHandler = n;
    }, n.prototype.triggerCompleteApplePayMerchantValidation = function (n) {
      this.completeApplePayMerchantValidationHandler(n);
    }, n.prototype.onCompleteApplePayOperation = function (n) {
      this.completeApplePayOperationHandler = n;
    }, n.prototype.triggerCompleteApplePayOperation = function (n) {
      this.completeApplePayOperationHandler(n);
    }, n;
  }(),
      r;

  n.RpcEventDispatcher = i;

  r = function () {
    function r(t) {
      var e = this,
          s,
          h;
      t === void 0 && (t = {});
      this.appledStyle = null;
      this.savedScrollPosition = null;
      this.alternateEmbed = !1;
      this.setCloudPaymentsOptionsDefaults(t);
      this.widgetOptions = t;
      this.alternateEmbed = n.clientSettings.device.iOS || n.clientSettings.device.Android ? !0 : !1;
      this.container = r.createContainer(this.alternateEmbed);
      this.hideWindow();
      s = r.ensureContainer(t.container);
      s.appendChild(this.container);
      var u = this,
          o = {
        swf: n.serverSettings.widget.rootUrl + n.serverSettings.widget.easyXDMSwfPath,
        container: this.container,
        onReady: function onReady() {
          u.iframe = u.container.getElementsByTagName("iframe")[0];
          u.iframe.style.cssText = "height: 100% !important;width: 100% !important;position: fixed !important;z-index: 9999 !important;border: 0 !important; top: 0 !important;bottom: 0 !important;left: 0 !important;right: 0px !important;max-height: 100% !important;";
        }
      },
          f = {};
      t.language && (f.language = t.language);
      f.mainWindowHref = window.location.href;
      t.logoUrl && (f.logoUrl = t.logoUrl);
      h = this.getSkinPath(this.widgetOptions.skin);
      o.remote = n.Utils.format("{0}{1}?{2}", n.serverSettings.widget.rootUrl, h, n.Utils.createQuery(f));
      n.TransportSupportHelper.supportsHashTransportOnly() && delete o.swf;

      this.initRpc = function () {
        e.rpc = n.RpcFatory.createRpc(o, {
          local: {
            showWindow: function showWindow() {
              u.widgetOptions.showLoadingImage && n.Utils.removeLoadingOverlay(document);
              u.showWindow();
              e.rpc.windowResized(window.matchMedia("(max-width: 592px)").matches);
            },
            hideWindow: function hideWindow() {
              u.hideWindow();
            },
            completePaymentApiCall: function completePaymentApiCall(n) {
              u.onCompletePayment(n);
            },
            completeOperation: function completeOperation(n) {
              u.hideWindow();
              u.onCompleteOperation(n);
            },
            needOptions: function needOptions() {
              u.notifyWidgetIsReadyToReceiveOptions();
            },
            isPaymentMethodAvaliable: function isPaymentMethodAvaliable(i) {
              switch (i) {
                case n.ExternalPaymentMethods.ApplePay:
                  u.rpc.setPaymentMethodStatus(n.ExternalPaymentMethods.ApplePay, t.applePaySupport && n.clientSettings.features.supportsApplePay);
                  break;

                case n.ExternalPaymentMethods.GooglePay:
                  u.rpc.setPaymentMethodStatus(n.ExternalPaymentMethods.GooglePay, n.clientSettings.features.supportsGooglePay && t.googlePaySupport);
              }
            },
            initApplePayOperation: function initApplePayOperation(t, i) {
              n.ApplePayApi.pay(t, i, u.rpc, u.rpcEventDispatcher);
            },
            completeApplePayMerchantValidation: function completeApplePayMerchantValidation(n) {
              n.success ? u.rpcEventDispatcher.triggerCompleteApplePayMerchantValidation(n.merchantSession) : u.rpc.setPaymentStatus({
                success: !1,
                message: n.message
              });
            },
            completeApplePayOperation: function completeApplePayOperation(n) {
              u.rpcEventDispatcher.triggerCompleteApplePayOperation(n.success);
            },
            completeGooglePayOperation: function completeGooglePayOperation() {},
            removeLoader: function removeLoader() {
              n.Utils.removeLoadingOverlay(document);
            },
            fixPosition: function fixPosition() {
              window.scrollTo(0, 0);
            }
          },
          remote: {
            setOptions: {},
            closeWindow: {},
            setPaymentStatus: {},
            setPaymentMethodStatus: {},
            startApplePaySession: {},
            applePayOperation: {},
            resetPayment: {},
            windowResized: {}
          }
        });
        e.rpcEventDispatcher = new i();
      };

      this.initRpc();
    }

    return r.prototype.getSkinPath = function (t) {
      return n.Utils.format(n.serverSettings.widget.payformPathFormat, t || "cards2");
    }, r.prototype.setCloudPaymentsOptionsDefaults = function (t) {
      n.Utils.isNullOrUndefined(t.showLoadingImage) && (t.showLoadingImage = !0);
      n.Utils.isNullOrUndefined(t.applePaySupport) && (t.applePaySupport = !0);
      n.Utils.isNullOrUndefined(t.googlePaySupport) && (t.googlePaySupport = !0);
    }, r.prototype.charge = function (n, t, i, r) {
      this.auth(n, t, i, r, !1);
    }, r.prototype.pay = function (n, t, i) {
      i === void 0 && (i = {});
      this.auth(t, i.onSuccess, i.onFail, i.onComplete, n == "auth", !0);
    }, r.prototype.createCryptogram = function (n, t, i, r) {
      n.cryptogramMode = !0;
      this.auth(n, t, i, r, !1);
    }, r.prototype.auth = function (t, i, r, u, f, e) {
      if (f === void 0 && (f = !0), e === void 0 && (e = !1), !t.publicId) throw new Error("Option 'publicId' must be specified");
      if (!t.amount) throw new Error("Option 'amount' must be specified");
      if (typeof t.amount != "number") throw new Error("Option 'amount' must be a number");
      if (!t.currency) throw new Error("Option 'currency' must be specified");
      if (t.email && typeof t.email != "string") throw new Error("Option 'email' must be a string");
      if (u && typeof u != "function") throw new Error("Argument 'onCompleted' must be a function");
      if (f && typeof f != "boolean") throw new Error("Argument 'auth' must be a boolean");
      if (t.requireEmail && typeof t.requireEmail != "boolean") throw new Error("Argument 'requireEmail' must be a boolean");
      this.widgetOptions.showLoadingImage && n.Utils.createLoadingOverlay(document);
      !t.email && this.widgetOptions.email && (t.email = this.widgetOptions.email);
      t.description || (t.description = "");
      t.isLongDesc = t.description.length > 85;
      t.auth = f;
      var o = {
        options: t,
        onCompleted: u,
        shouldCompleteAfterTransactionCreated: e
      };
      if (i) switch (_typeof(i)) {
        case "function":
          o.onSuccess = i;
          break;

        case "string":
          o.onSuccessUrl = i;
          break;

        default:
          throw new Error("Argument 'onSuccess' must be a function or URL string");
      }
      if (r) switch (_typeof(r)) {
        case "function":
          o.onFail = r;
          break;

        case "string":
          o.onFailUrl = r;
          break;

        default:
          throw new Error("Argument 'onFail' must be a function or URL string");
      }
      this.operation = o;
      this.notifyPaymentOptionsCreated(t);
    }, r.prototype.notifyPaymentOptionsCreated = function (n) {
      var i = this;
      this.optionsNotifier || (this.optionsNotifier = new t());
      this.optionsNotifier.setCallable(function () {
        i.rpc.setOptions(n);
        i.rpc.windowResized(window.matchMedia("(max-width: 592px)").matches);

        window.onresize = function () {
          i.rpc.windowResized(window.matchMedia("(max-width: 592px)").matches);
        };
      });
    }, r.prototype.notifyWidgetIsReadyToReceiveOptions = function () {
      this.rpc.windowResized(window.matchMedia("(max-width: 592px)").matches);
      this.optionsNotifier || (this.optionsNotifier = new t());
      this.optionsNotifier.ready();
    }, r.prototype.showWindow = function () {
      this.container && (this.addViewPortMeta(), n.clientSettings.browser.ie && n.clientSettings.browser.ie.version < 7 && this.fixIE6IFrameSize(), n.Utils.addClass(this.iframe, "with-appled"), n.Utils.show(this.container), n.BodyScrollLock.disableBodyScroll(this.container), this.alternateEmbed && !this.appledStyle && (this.savedScrollPosition = document.body.scrollTop, this.appledStyle = document.createElement("style"), this.appledStyle.type = "text/css", this.appledStyle.innerHTML = "\n                        html {height: 100% !important; position: static !important}\n                        body {margin: 0 !important; padding: 0 !important; position: static !important}\n                        body * {display: none !important}\n                        #" + this.container.id + " {position: static !important}\n                        #" + this.container.id + ", #cloudpayments-backdrop-8978968765, iframe.with-appled {display: block !important}\n                        .payment-tools-container.with-appled {display: table !important}\n                        .payment-tools-container.with-appled div {display: table-cell !important}\n                        .payment-tools-container.with-appled div *:not(style) {display: block !important}\n                    ", document.body.appendChild(this.appledStyle), setTimeout(function () {
        window.scrollTo(0, 0);
      }, 200)));
    }, r.prototype.hideWindow = function () {
      if (n.BodyScrollLock.enableBodyScroll(this.container), this.savedScrollPosition && (window.scrollTo(0, this.savedScrollPosition), this.savedScrollPosition = null), this.appledStyle) {
        try {
          this.appledStyle.remove();
        } catch (t) {}

        this.appledStyle = null;
      }

      this.removeViewPortMeta();
      this.iframe && n.Utils.removeClass(this.iframe, "with-appled");
      n.Utils.hide(this.container);

      try {
        this.container.remove();
      } catch (t) {}
    }, r.prototype.onCompletePayment = function (n) {
      var t = this.operation;
      if (t && t.shouldCompleteAfterTransactionCreated && t.onCompleted) t.onCompleted(n, t.options);
    }, r.prototype.onCompleteOperation = function (n) {
      var t = this.operation;

      if (t && !t.completed) {
        if (t.completed = !0, n.success) {
          if (t.onSuccess) t.onSuccess(t.options, n.data);else t.onSuccessUrl && (window.location.href = t.onSuccessUrl);
        } else if (t.onFail) t.onFail(n.message, t.options, n.code);else t.onFailUrl && (window.location.href = t.onFailUrl);
        if (t.onCompleted && !t.shouldCompleteAfterTransactionCreated) t.onCompleted(n, t.options);
        t.popupWindowTracker && t.popupWindowTracker.cancel();
        this.operation = null;
      }
    }, r.createContainer = function (n) {
      n === void 0 && (n = !1);
      var t = document.createElement("div");
      return t.id = "cp-scrollable-" + Math.floor(Math.random() * 1e8).toString(), n || (t.style.cssText = "z-index:9997;text-align:left;height:100%;width:100%;position:fixed;left:0;top:0;transition:opacity 0.15s;overflow:auto;-webkit-overflow-scrolling:touch;pointer-events:all;"), t.style.pointerEvents = "all", t;
    }, r.prototype.addViewPortMeta = function () {
      var t = this,
          i = document.getElementsByTagName("head")[0],
          n = document.createElement("meta");
      n.id = "cloudpayments-widget-viewport";
      n.name = "viewport";
      n.content = "width=device-width, height=device-height, initial-scale=1";
      i.appendChild(n);
      setTimeout(function () {
        t.rpc.windowResized(window.matchMedia("(max-width: 592px)").matches);
      }, 500);
    }, r.prototype.removeViewPortMeta = function () {
      var n = document.getElementById("cloudpayments-widget-viewport"),
          t;
      n && (t = document.getElementsByTagName("head")[0], t.removeChild(n));
    }, r.ensureContainer = function (n) {
      if (!n) return document.body;
      if (typeof n == "string") return document.getElementById(n);
      if (_typeof(n) == "object" && n.nodeType === 1) return n;
      throw new Error("Argument 'container' must be an ID of element or the element itself");
    }, r.prototype.fixIE6IFrameSize = function () {
      typeof document.body.style.maxHeight == "undefined" && (this.iframe.style.height = document.documentElement.clientHeight.toString() + "px", this.iframe.style.width = document.documentElement.clientWidth.toString() + "px");
    }, r;
  }();

  n.CloudPayments = r;
}(cp || (cp = {}));
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../node_modules/timers-browserify/main.js */ "./node_modules/timers-browserify/main.js").setImmediate, __webpack_require__(/*! ./../../node_modules/webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ 1:
/*!*********************************************!*\
  !*** multi ./resources/js/cloud_payment.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/discover3/resources/js/cloud_payment.js */"./resources/js/cloud_payment.js");


/***/ })

/******/ });