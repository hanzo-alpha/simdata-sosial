var _ = class {
    constructor(t, e, i, n) {
        if (isNaN(t) || isNaN(e)) throw new Error(`Point is invalid: (${t}, ${e})`);
        this.x = +t, this.y = +e, this.pressure = i || 0, this.time = n || Date.now();
    }

    distanceTo(t) {
        return Math.sqrt(Math.pow(this.x - t.x, 2) + Math.pow(this.y - t.y, 2));
    }

    equals(t) {
        return this.x === t.x && this.y === t.y && this.pressure === t.pressure && this.time === t.time;
    }

    velocityFrom(t) {
        return this.time !== t.time ? this.distanceTo(t) / (this.time - t.time) : 0;
    }
}, w = class {
    constructor(t, e, i, n, s, o) {
        this.startPoint = t, this.control2 = e, this.control1 = i, this.endPoint = n, this.startWidth = s, this.endWidth = o;
    }

    static fromPoints(t, e) {
        let i = this.calculateControlPoints(t[0], t[1], t[2]).c2, n = this.calculateControlPoints(t[1], t[2], t[3]).c1;
        return new w(t[1], i, n, t[2], e.start, e.end);
    }

    static calculateControlPoints(t, e, i) {
        let n = t.x - e.x, s = t.y - e.y, o = e.x - i.x, r = e.y - i.y, h = { x: (t.x + e.x) / 2, y: (t.y + e.y) / 2 },
            a = { x: (e.x + i.x) / 2, y: (e.y + i.y) / 2 }, d = Math.sqrt(n * n + s * s), c = Math.sqrt(o * o + r * r),
            u = h.x - a.x, m = h.y - a.y, l = c / (d + c), v = { x: a.x + u * l, y: a.y + m * l }, x = e.x - v.x,
            y = e.y - v.y;
        return { c1: new _(h.x + x, h.y + y), c2: new _(a.x + x, a.y + y) };
    }

    length() {
        let e = 0, i, n;
        for (let s = 0; s <= 10; s += 1) {
            let o = s / 10, r = this.point(o, this.startPoint.x, this.control1.x, this.control2.x, this.endPoint.x),
                h = this.point(o, this.startPoint.y, this.control1.y, this.control2.y, this.endPoint.y);
            if (s > 0) {
                let a = r - i, d = h - n;
                e += Math.sqrt(a * a + d * d);
            }
            i = r, n = h;
        }
        return e;
    }

    point(t, e, i, n, s) {
        return e * (1 - t) * (1 - t) * (1 - t) + 3 * i * (1 - t) * (1 - t) * t + 3 * n * (1 - t) * t * t + s * t * t * t;
    }
}, p = class {
    constructor() {
        try {
            this._et = new EventTarget;
        } catch {
            this._et = document;
        }
    }

    addEventListener(t, e, i) {
        this._et.addEventListener(t, e, i);
    }

    dispatchEvent(t) {
        return this._et.dispatchEvent(t);
    }

    removeEventListener(t, e, i) {
        this._et.removeEventListener(t, e, i);
    }
};

function P(g, t = 250) {
    let e = 0, i = null, n, s, o, r = () => {
        e = Date.now(), i = null, n = g.apply(s, o), i || (s = null, o = []);
    };
    return function(...a) {
        let d = Date.now(), c = t - (d - e);
        return s = this, o = a, c <= 0 || c > t ? (i && (clearTimeout(i), i = null), e = d, n = g.apply(s, o), i || (s = null, o = [])) : i || (i = window.setTimeout(r, c)), n;
    };
}

var f = class extends p {
    constructor(t, e = {}) {
        super(), this.canvas = t, this._drawningStroke = !1, this._isEmpty = !0, this._lastPoints = [], this._data = [], this._lastVelocity = 0, this._lastWidth = 0, this._handleMouseDown = i => {
            i.buttons === 1 && (this._drawningStroke = !0, this._strokeBegin(i));
        }, this._handleMouseMove = i => {
            this._drawningStroke && this._strokeMoveUpdate(i);
        }, this._handleMouseUp = i => {
            i.buttons === 1 && this._drawningStroke && (this._drawningStroke = !1, this._strokeEnd(i));
        }, this._handleTouchStart = i => {
            if (i.cancelable && i.preventDefault(), i.targetTouches.length === 1) {
                let n = i.changedTouches[0];
                this._strokeBegin(n);
            }
        }, this._handleTouchMove = i => {
            i.cancelable && i.preventDefault();
            let n = i.targetTouches[0];
            this._strokeMoveUpdate(n);
        }, this._handleTouchEnd = i => {
            if (i.target === this.canvas) {
                i.cancelable && i.preventDefault();
                let s = i.changedTouches[0];
                this._strokeEnd(s);
            }
        }, this._handlePointerStart = i => {
            this._drawningStroke = !0, i.preventDefault(), this._strokeBegin(i);
        }, this._handlePointerMove = i => {
            this._drawningStroke && (i.preventDefault(), this._strokeMoveUpdate(i));
        }, this._handlePointerEnd = i => {
            this._drawningStroke && (i.preventDefault(), this._drawningStroke = !1, this._strokeEnd(i));
        }, this.velocityFilterWeight = e.velocityFilterWeight || .7, this.minWidth = e.minWidth || .5, this.maxWidth = e.maxWidth || 2.5, this.throttle = 'throttle' in e ? e.throttle : 16, this.minDistance = 'minDistance' in e ? e.minDistance : 5, this.dotSize = e.dotSize || 0, this.penColor = e.penColor || 'black', this.backgroundColor = e.backgroundColor || 'rgba(0,0,0,0)', this.compositeOperation = e.compositeOperation || 'source-over', this._strokeMoveUpdate = this.throttle ? P(f.prototype._strokeUpdate, this.throttle) : f.prototype._strokeUpdate, this._ctx = t.getContext('2d'), this.clear(), this.on();
    }

    clear() {
        let { _ctx: t, canvas: e } = this;
        t.fillStyle = this.backgroundColor, t.clearRect(0, 0, e.width, e.height), t.fillRect(0, 0, e.width, e.height), this._data = [], this._reset(this._getPointGroupOptions()), this._isEmpty = !0;
    }

    fromDataURL(t, e = {}) {
        return new Promise((i, n) => {
            let s = new Image, o = e.ratio || window.devicePixelRatio || 1, r = e.width || this.canvas.width / o,
                h = e.height || this.canvas.height / o, a = e.xOffset || 0, d = e.yOffset || 0;
            this._reset(this._getPointGroupOptions()), s.onload = () => {
                this._ctx.drawImage(s, a, d, r, h), i();
            }, s.onerror = c => {
                n(c);
            }, s.crossOrigin = 'anonymous', s.src = t, this._isEmpty = !1;
        });
    }

    toDataURL(t = 'image/png', e) {
        switch (t) {
            case'image/svg+xml':
                return typeof e != 'object' && (e = void 0), `data:image/svg+xml;base64,${btoa(this.toSVG(e))}`;
            default:
                return typeof e != 'number' && (e = void 0), this.canvas.toDataURL(t, e);
        }
    }

    on() {
        this.canvas.style.touchAction = 'none', this.canvas.style.msTouchAction = 'none', this.canvas.style.userSelect = 'none';
        let t = /Macintosh/.test(navigator.userAgent) && 'ontouchstart' in document;
        window.PointerEvent && !t ? this._handlePointerEvents() : (this._handleMouseEvents(), 'ontouchstart' in window && this._handleTouchEvents());
    }

    off() {
        this.canvas.style.touchAction = 'auto', this.canvas.style.msTouchAction = 'auto', this.canvas.style.userSelect = 'auto', this.canvas.removeEventListener('pointerdown', this._handlePointerStart), this.canvas.removeEventListener('pointermove', this._handlePointerMove), this.canvas.ownerDocument.removeEventListener('pointerup', this._handlePointerEnd), this.canvas.removeEventListener('mousedown', this._handleMouseDown), this.canvas.removeEventListener('mousemove', this._handleMouseMove), this.canvas.ownerDocument.removeEventListener('mouseup', this._handleMouseUp), this.canvas.removeEventListener('touchstart', this._handleTouchStart), this.canvas.removeEventListener('touchmove', this._handleTouchMove), this.canvas.removeEventListener('touchend', this._handleTouchEnd);
    }

    isEmpty() {
        return this._isEmpty;
    }

    fromData(t, { clear: e = !0 } = {}) {
        e && this.clear(), this._fromData(t, this._drawCurve.bind(this), this._drawDot.bind(this)), this._data = this._data.concat(t);
    }

    toData() {
        return this._data;
    }

    _getPointGroupOptions(t) {
        return {
            penColor: t && 'penColor' in t ? t.penColor : this.penColor,
            dotSize: t && 'dotSize' in t ? t.dotSize : this.dotSize,
            minWidth: t && 'minWidth' in t ? t.minWidth : this.minWidth,
            maxWidth: t && 'maxWidth' in t ? t.maxWidth : this.maxWidth,
            velocityFilterWeight: t && 'velocityFilterWeight' in t ? t.velocityFilterWeight : this.velocityFilterWeight,
            compositeOperation: t && 'compositeOperation' in t ? t.compositeOperation : this.compositeOperation,
        };
    }

    _strokeBegin(t) {
        this.dispatchEvent(new CustomEvent('beginStroke', { detail: t }));
        let e = this._getPointGroupOptions(), i = Object.assign(Object.assign({}, e), { points: [] });
        this._data.push(i), this._reset(e), this._strokeUpdate(t);
    }

    _strokeUpdate(t) {
        if (this._data.length === 0) {
            this._strokeBegin(t);
            return;
        }
        this.dispatchEvent(new CustomEvent('beforeUpdateStroke', { detail: t }));
        let e = t.clientX, i = t.clientY, n = t.pressure !== void 0 ? t.pressure : t.force !== void 0 ? t.force : 0,
            s = this._createPoint(e, i, n), o = this._data[this._data.length - 1], r = o.points,
            h = r.length > 0 && r[r.length - 1], a = h ? s.distanceTo(h) <= this.minDistance : !1,
            d = this._getPointGroupOptions(o);
        if (!h || !(h && a)) {
            let c = this._addPoint(s, d);
            h ? c && this._drawCurve(c, d) : this._drawDot(s, d), r.push({
                time: s.time,
                x: s.x,
                y: s.y,
                pressure: s.pressure,
            });
        }
        this.dispatchEvent(new CustomEvent('afterUpdateStroke', { detail: t }));
    }

    _strokeEnd(t) {
        this._strokeUpdate(t), this.dispatchEvent(new CustomEvent('endStroke', { detail: t }));
    }

    _handlePointerEvents() {
        this._drawningStroke = !1, this.canvas.addEventListener('pointerdown', this._handlePointerStart), this.canvas.addEventListener('pointermove', this._handlePointerMove), this.canvas.ownerDocument.addEventListener('pointerup', this._handlePointerEnd);
    }

    _handleMouseEvents() {
        this._drawningStroke = !1, this.canvas.addEventListener('mousedown', this._handleMouseDown), this.canvas.addEventListener('mousemove', this._handleMouseMove), this.canvas.ownerDocument.addEventListener('mouseup', this._handleMouseUp);
    }

    _handleTouchEvents() {
        this.canvas.addEventListener('touchstart', this._handleTouchStart), this.canvas.addEventListener('touchmove', this._handleTouchMove), this.canvas.addEventListener('touchend', this._handleTouchEnd);
    }

    _reset(t) {
        this._lastPoints = [], this._lastVelocity = 0, this._lastWidth = (t.minWidth + t.maxWidth) / 2, this._ctx.fillStyle = t.penColor, this._ctx.globalCompositeOperation = t.compositeOperation;
    }

    _createPoint(t, e, i) {
        let n = this.canvas.getBoundingClientRect();
        return new _(t - n.left, e - n.top, i, new Date().getTime());
    }

    _addPoint(t, e) {
        let { _lastPoints: i } = this;
        if (i.push(t), i.length > 2) {
            i.length === 3 && i.unshift(i[0]);
            let n = this._calculateCurveWidths(i[1], i[2], e), s = w.fromPoints(i, n);
            return i.shift(), s;
        }
        return null;
    }

    _calculateCurveWidths(t, e, i) {
        let n = i.velocityFilterWeight * e.velocityFrom(t) + (1 - i.velocityFilterWeight) * this._lastVelocity,
            s = this._strokeWidth(n, i), o = { end: s, start: this._lastWidth };
        return this._lastVelocity = n, this._lastWidth = s, o;
    }

    _strokeWidth(t, e) {
        return Math.max(e.maxWidth / (t + 1), e.minWidth);
    }

    _drawCurveSegment(t, e, i) {
        let n = this._ctx;
        n.moveTo(t, e), n.arc(t, e, i, 0, 2 * Math.PI, !1), this._isEmpty = !1;
    }

    _drawCurve(t, e) {
        let i = this._ctx, n = t.endWidth - t.startWidth, s = Math.ceil(t.length()) * 2;
        i.beginPath(), i.fillStyle = e.penColor;
        for (let o = 0; o < s; o += 1) {
            let r = o / s, h = r * r, a = h * r, d = 1 - r, c = d * d, u = c * d, m = u * t.startPoint.x;
            m += 3 * c * r * t.control1.x, m += 3 * d * h * t.control2.x, m += a * t.endPoint.x;
            let l = u * t.startPoint.y;
            l += 3 * c * r * t.control1.y, l += 3 * d * h * t.control2.y, l += a * t.endPoint.y;
            let v = Math.min(t.startWidth + a * n, e.maxWidth);
            this._drawCurveSegment(m, l, v);
        }
        i.closePath(), i.fill();
    }

    _drawDot(t, e) {
        let i = this._ctx, n = e.dotSize > 0 ? e.dotSize : (e.minWidth + e.maxWidth) / 2;
        i.beginPath(), this._drawCurveSegment(t.x, t.y, n), i.closePath(), i.fillStyle = e.penColor, i.fill();
    }

    _fromData(t, e, i) {
        for (let n of t) {
            let { points: s } = n, o = this._getPointGroupOptions(n);
            if (s.length > 1) for (let r = 0; r < s.length; r += 1) {
                let h = s[r], a = new _(h.x, h.y, h.pressure, h.time);
                r === 0 && this._reset(o);
                let d = this._addPoint(a, o);
                d && e(d, o);
            } else this._reset(o), i(s[0], o);
        }
    }

    toSVG({ includeBackgroundColor: t = !1 } = {}) {
        let e = this._data, i = Math.max(window.devicePixelRatio || 1, 1), n = 0, s = 0, o = this.canvas.width / i,
            r = this.canvas.height / i, h = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        if (h.setAttribute('xmlns', 'http://www.w3.org/2000/svg'), h.setAttribute('xmlns:xlink', 'http://www.w3.org/1999/xlink'), h.setAttribute('viewBox', `${n} ${s} ${o} ${r}`), h.setAttribute('width', o.toString()), h.setAttribute('height', r.toString()), t && this.backgroundColor) {
            let a = document.createElement('rect');
            a.setAttribute('width', '100%'), a.setAttribute('height', '100%'), a.setAttribute('fill', this.backgroundColor), h.appendChild(a);
        }
        return this._fromData(e, (a, { penColor: d }) => {
            let c = document.createElement('path');
            if (!isNaN(a.control1.x) && !isNaN(a.control1.y) && !isNaN(a.control2.x) && !isNaN(a.control2.y)) {
                let u = `M ${a.startPoint.x.toFixed(3)},${a.startPoint.y.toFixed(3)} C ${a.control1.x.toFixed(3)},${a.control1.y.toFixed(3)} ${a.control2.x.toFixed(3)},${a.control2.y.toFixed(3)} ${a.endPoint.x.toFixed(3)},${a.endPoint.y.toFixed(3)}`;
                c.setAttribute('d', u), c.setAttribute('stroke-width', (a.endWidth * 2.25).toFixed(3)), c.setAttribute('stroke', d), c.setAttribute('fill', 'none'), c.setAttribute('stroke-linecap', 'round'), h.appendChild(c);
            }
        }, (a, { penColor: d, dotSize: c, minWidth: u, maxWidth: m }) => {
            let l = document.createElement('circle'), v = c > 0 ? c : (u + m) / 2;
            l.setAttribute('r', v.toString()), l.setAttribute('cx', a.x.toString()), l.setAttribute('cy', a.y.toString()), l.setAttribute('fill', d), h.appendChild(l);
        }), h.outerHTML;
    }
};

function E(g, t) {
    return {
        state: g,
        ratio: 1,
        disabled: t.disabled,
        dotSize: t.dotSize,
        minWidth: t.minWidth,
        maxWidth: t.maxWidth,
        minDistance: t.minDistance,
        penColor: t.penColor,
        signaturePad: null,
        backgroundColor: t.backgroundColor,
        canvas: null,
        init() {
            if (this.canvas = document.getElementById(t.id), !this.canvas) {
                console.error('Canvas is not present');
                return;
            }
            this.signaturePad = new f(this.canvas, {
                dotSize: this.dotSize || 2,
                minWidth: this.minWidth || 1,
                maxWidth: this.maxWidth || 2.5,
                minDistance: this.minDistance || 2,
                penColor: this.penColor || 'rgb(0,0,0)',
                backgroundColor: this.backgroundColor || 'rgba(255,255,255,0)',
            }), window.addEventListener('resize', e => this.resizeCanvas()), this.resizeCanvas(), this.signaturePad.addEventListener('beginStroke', () => {
            }, { once: !1 }), this.signaturePad.addEventListener('endStroke', e => {
                this.save(), this.resizeCanvas();
            }, { once: !1 }), this.signaturePad.addEventListener('afterUpdateStroke', () => {
            }, { once: !1 });
        },
        save() {
            this.state = this.signaturePad.toDataURL('image/svg+xml'), this.resizeCanvas();
        },
        clear() {
            this.signaturePad.clear(), this.state = null, this.resizeCanvas();
        },
        resizeCanvas() {
            let e = this.canvas;
            this.ratio = Math.max(window.devicePixelRatio || 1, 1);
            let i = this.getCanvasOffsetDimensions();
            e.width = i.width * this.ratio, e.height = i.height * this.ratio, e.getContext('2d').scale(this.ratio, this.ratio), this.signaturePad.clear(), this.state ? this.signaturePad.fromDataURL(this.state) : this.signaturePad?.fromData(this.signaturePad.toData());
        },
        getCanvasOffsetDimensions() {
            let e = this.canvas, i = e.cloneNode(!0);
            if (e.offsetHeight > 0 && e.offsetWidth > 0) return { height: e.offsetHeight, width: e.offsetWidth };
            i.style.visibility = 'hidden', document.body.appendChild(i);
            let n = i.offsetHeight, s = i.offsetWidth;
            return document.body.removeChild(i), { height: n, width: s };
        },
        downloadSVG() {
            if (this.signaturePad.isEmpty()) alert('Please provide a signature first.'); else {
                let e = this.signaturePad.toDataURL('image/svg+xml');
                this.download(e, 'signature.svg');
            }
        },
        downloadPNG() {
            if (this.signaturePad.isEmpty()) alert('Please provide a signature first.'); else {
                let e = this.signaturePad.toDataURL('image/png');
                this.download(e, 'signature.png');
            }
        },
        downloadJPG() {
            if (this.signaturePad.isEmpty()) alert('Please provide a signature first.'); else {
                this.signaturePad.backgroundColor = 'rgb(255,255,255)';
                let e = this.signaturePad.toDataURL('image/jpeg');
                this.download(e, 'signature.jpg');
            }
        },
        download(e, i = 'signature') {
            let n = this.dataURLToBlob(e), s = window.URL.createObjectURL(n), o = document.createElement('a');
            o.href = s, o.style = 'display: none', o.download = i, document.body.appendChild(o), o.click(), window.URL.revokeObjectURL(s);
        },
        dataURLToBlob(e) {
            let i = e.split(';base64,'), n = i[0].split(':')[1], s = window.atob(i[1]), o = s.length,
                r = new Uint8Array(o);
            for (let h = 0; h < o; ++h) r[h] = s.charCodeAt(h);
            return new Blob([r], { type: n });
        },
    };
}

export { E as default };
/*! Bundled license information:

signature_pad/dist/signature_pad.js:
  (*!
   * Signature Pad v4.1.6 | https://github.com/szimek/signature_pad
   * (c) 2023 Szymon Nowak | Released under the MIT license
   *)
*/