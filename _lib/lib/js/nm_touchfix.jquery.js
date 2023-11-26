(function ($) {
    $.support.touch = 'ontouchend' in document;
    if (!$.support.touch) {
        return;
    }
    var _NM_TouchFix = $.ui.mouse.prototype;
    var _mouseInit = _NM_TouchFix._mouseInit;
    var _mouseDestroy = _NM_TouchFix._mouseDestroy;
    var _touchHandled;

    function _nm_swapTouchClick (event, s_type) {
        if (event.originalEvent.touches.length > 1) {
            return;
        }
        event.preventDefault();
        var touch = event.originalEvent.changedTouches[0];
        var simulatedEvent = document.createEvent('MouseEvents');

        simulatedEvent.initMouseEvent( s_type, true, true, window, 1, touch.screenX, touch.screenY, touch.clientX, touch.clientY, false, false, false, false, 0, null);
        event.target.dispatchEvent(simulatedEvent);
    }
    _NM_TouchFix._touchStart = function (event) {
        var self = this;
        if (_touchHandled || !self._mouseCapture(event.originalEvent.changedTouches[0])) {
            return;
        }
        _touchHandled = true;
        self._touchMoved = false;
        _nm_swapTouchClick(event, 'mouseover');
        _nm_swapTouchClick(event, 'mousemove');
        _nm_swapTouchClick(event, 'mousedown');
    };
    _NM_TouchFix._touchMove = function (event) {
        if (!_touchHandled) {
            return;
        }
        this._touchMoved = true;
        _nm_swapTouchClick(event, 'mousemove');
    };
    _NM_TouchFix._touchEnd = function (event) {
        if (!_touchHandled) {
            return;
        }
        _nm_swapTouchClick(event, 'mouseup');
        _nm_swapTouchClick(event, 'mouseout');
        if (!this._touchMoved) {
            _nm_swapTouchClick(event, 'click');
        }
        _touchHandled = false;
    };

    _NM_TouchFix._mouseInit = function () {
        var self = this;
        self.element.bind({
            touchstart: $.proxy(self, '_touchStart'),
            touchmove: $.proxy(self, '_touchMove'),
            touchend: $.proxy(self, '_touchEnd')
        });
        _mouseInit.call(self);
    };
    _NM_TouchFix._mouseDestroy = function () {
        var self = this;
        self.element.unbind({
            touchstart: $.proxy(self, '_touchStart'),
            touchmove: $.proxy(self, '_touchMove'),
            touchend: $.proxy(self, '_touchEnd')
        });
        _mouseDestroy.call(self);
    };
})(jQuery);