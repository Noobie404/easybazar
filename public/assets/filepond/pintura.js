/*!
 * Pintura Image Editor Sandbox 8.20.5
 * (c) 2018-2022 PQINA Inc. - All Rights Reserved
 * This version of Pintura Image Editor is for use on pqina.nl onlytfghrfghfgh
 * License: https://pqina.nl/pintura/license/
 */
/* eslint-disable */

const e = {
    65505: "exif",
    65504: "jfif",
    65498: "sos"
};
var t = t => {
    if (65496 !== t.getUint16(0)) return;
    const o = Object.keys(e).map((e => parseInt(e, 10))),
        i = t.byteLength;
    let n, r = 2,
        a = void 0;
    for (; r < i && 255 === t.getUint8(r);) {
        if (n = t.getUint16(r), o.includes(n)) {
            const o = e[n];
            a || (a = {}), a[o] || (a[o] = {
                offset: r,
                size: t.getUint16(r + 2)
            })
        }
        if (65498 === n) break;
        r += 2 + t.getUint16(r + 2)
    }
    return a
};
var o = (e, o, i) => {
    if (!e) return;
    const n = new DataView(e),
        r = t(n);
    if (!r || !r.exif) return;
    const a = ((e, t) => {
        if (65505 !== e.getUint16(t)) return;
        const o = e.getUint16(t + 2);
        if (t += 4, 1165519206 !== e.getUint32(t)) return;
        t += 6;
        const i = e.getUint16(t);
        if (18761 !== i && 19789 !== i) return;
        const n = 18761 === i;
        if (t += 2, 42 !== e.getUint16(t, n)) return;
        t += e.getUint32(t + 2, n);
        const r = i => {
            const r = [];
            let a = t;
            const s = t + o - 16;
            for (; a < s; a += 12) {
                const t = a;
                e.getUint16(t, n) === i && r.push(t)
            }
            return r
        };
        return {
            read: t => {
                const o = r(t);
                if (o.length) return e.getUint16(o[0] + 8, n)
            },
            write: (t, o) => {
                const i = r(t);
                return !!i.length && (i.forEach((t => e.setUint16(t + 8, o, n))), !0)
            }
        }
    })(n, r.exif.offset);
    return a ? void 0 === i ? a.read(o) : a.write(o, i) : void 0
};
var i = e => window.__pqina_webapi__ ? window.__pqina_webapi__[e] : window[e],
    n = (...e) => {};
const r = {
    ArrayBuffer: "readAsArrayBuffer"
};
var a = async (e, t = [0, e.size], o) => await ((e, t = n, o = {}) => new Promise(((n, a) => {
    const {
        dataFormat: s = r.ArrayBuffer
    } = o, l = new(i("FileReader"));
    l.onload = () => n(l.result), l.onerror = a, l.onprogress = t, l[s](e)
})))(e.slice(...t), o), s = async (e, t) => {
    const i = await a(e, [0, 131072], t);
    return o(i, 274) || 1
};
let l = null;
var c = () => (null === l && (l = "undefined" != typeof window && void 0 !== window.document), l);
let d = null;
var u = () => new Promise((e => {
        if (null === d) {
            const t = "data:image/jpg;base64,/9j/4AAQSkZJRgABAQEASABIAAD/4QA6RXhpZgAATU0AKgAAAAgAAwESAAMAAAABAAYAAAEoAAMAAAABAAIAAAITAAMAAAABAAEAAAAAAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////wAALCAABAAIBASIA/8QAJgABAAAAAAAAAAAAAAAAAAAAAxABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQAAPwBH/9k=";
            let o = c() ? new Image : {};
            return o.onload = () => {
                d = 1 === o.naturalWidth, o = void 0, e(d)
            }, void(o.src = t)
        }
        return e(d)
    })),
    h = e => e.getContext("2d").getImageData(0, 0, e.width, e.height),
    p = (e, t, o = []) => {
        const i = document.createElement(e),
            n = Object.getOwnPropertyDescriptors(i.__proto__);
        for (const e in t) "style" === e ? i.style.cssText = t[e] : n[e] && n[e].set || /textContent|innerHTML/.test(e) || "function" == typeof t[e] ? i[e] = t[e] : i.setAttribute(e, t[e]);
        return o.forEach((e => i.appendChild(e))), i
    };
const m = {
    1: () => [1, 0, 0, 1, 0, 0],
    2: e => [-1, 0, 0, 1, e, 0],
    3: (e, t) => [-1, 0, 0, -1, e, t],
    4: (e, t) => [1, 0, 0, -1, 0, t],
    5: () => [0, 1, 1, 0, 0, 0],
    6: (e, t) => [0, 1, -1, 0, t, 0],
    7: (e, t) => [0, -1, -1, 0, t, e],
    8: e => [0, -1, 1, 0, 0, e]
};
var g = e => {
        e.width = 1, e.height = 1;
        const t = e.getContext("2d");
        t && t.clearRect(0, 0, 1, 1)
    },
    f = e => "data" in e,
    $ = async (e, t = 1) => {
        const [o, i] = await u() || t < 5 ? [e.width, e.height] : [e.height, e.width], n = p("canvas", {
            width: o,
            height: i
        }), r = n.getContext("2d");
        if (f(e) && !await u() && t > 1) {
            const t = p("canvas", {
                width: e.width,
                height: e.height
            });
            t.getContext("2d").putImageData(e, 0, 0), e = t
        }
        return !await u() && t > 1 && r.transform.apply(r, ((e, t, o = -1) => (-1 === o && (o = 1), m[o](e, t)))(e.width, e.height, t)), f(e) ? r.putImageData(e, 0, 0) : r.drawImage(e, 0, 0), e instanceof HTMLCanvasElement && g(e), n
    }, y = async (e, t = 1) => 1 === t || await u() ? e : h(await $(e, t)), x = e => "object" == typeof e;
const b = e => x(e) ? v(e) : e,
    v = e => {
        let t;
        return Array.isArray(e) ? (t = [], e.forEach(((e, o) => {
            t[o] = b(e)
        }))) : (t = {}, Object.keys(e).forEach((o => {
            const i = e[o];
            t[o] = b(i)
        }))), t
    };
var w = e => "string" == typeof e,
    S = e => "function" == typeof e,
    C = (e, t) => new Promise(((o, i) => {
        const n = () => o(((e, {
            width: t,
            height: o,
            canvasMemoryLimit: i
        }) => {
            let n = t || e.naturalWidth,
                r = o || e.naturalHeight;
            n || r || (n = 300, r = 150);
            const a = n * r;
            if (i && a > i) {
                const e = Math.sqrt(i) / Math.sqrt(a);
                n = Math.floor(n * e), r = Math.floor(r * e)
            }
            const s = p("canvas");
            return s.width = n, s.height = r, s.getContext("2d").drawImage(e, 0, 0, n, r), s
        })(e, t));
        e.complete && e.width ? n() : (e.onload = n, e.onerror = i)
    })),
    k = () => "createImageBitmap" in window,
    M = e => /svg/.test(e.type),
    T = () => Math.random().toString(36).substr(2, 9);
const R = new Map;
var P = (e, t, o) => new Promise(((i, n) => {
        const r = e.toString();
        let a = R.get(r);
        if (!a) {
            const t = (e => `function () {self.onmessage = function (message) {(${e.toString()}).apply(null, message.data.content.concat([function (err, response) {\n    response = response || {};\n    const transfer = 'data' in response ? [response.data.buffer] : 'width' in response ? [response] : [];\n    return self.postMessage({ id: message.data.id, content: response, error: err }, transfer);\n}]))}}`)(e),
                o = URL.createObjectURL((e => new Blob(["(", "function" == typeof e ? e.toString() : e, ")()"], {
                    type: "application/javascript"
                }))(t)),
                i = new Map,
                n = new Worker(o);
            a = {
                url: o,
                worker: n,
                messages: i,
                terminationTimeout: void 0,
                terminate: () => {
                    clearTimeout(a.terminationTimeout), a.worker.terminate(), URL.revokeObjectURL(o), R.delete(r)
                }
            }, n.onmessage = function (e) {
                const {
                    id: t,
                    content: o,
                    error: n
                } = e.data;
                if (clearTimeout(a.terminationTimeout), a.terminationTimeout = setTimeout((() => {
                        i.size > 0 || a.terminate()
                    }), 500), !i.has(t)) return;
                const r = i.get(t);
                i.delete(t), null != n ? r.reject(n) : r.resolve(o)
            }, R.set(r, a)
        }
        const s = T();
        a.messages.set(s, {
            resolve: i,
            reject: n
        }), a.worker.postMessage({
            id: s,
            content: t
        }, o)
    })),
    A = async (e, t) => {
        let o;
        if (k() && !M(e) && "OffscreenCanvas" in window) try {
            o = await P(((e, t, o) => {
                createImageBitmap(e).then((e => {
                    let i = e.width,
                        n = e.height;
                    const r = i * n;
                    if (t && r > t) {
                        const e = Math.sqrt(t) / Math.sqrt(r);
                        i = Math.floor(i * e), n = Math.floor(n * e)
                    }
                    const a = new OffscreenCanvas(i, n),
                        s = a.getContext("2d");
                    s.drawImage(e, 0, 0, i, n);
                    const l = s.getImageData(0, 0, a.width, a.height);
                    o(null, l)
                })).catch((e => {
                    o(e)
                }))
            }), [e, t])
        } catch (e) {}
        if (!o || !o.width) {
            const i = await (async (e, t) => {
                const o = p("img", {
                        src: URL.createObjectURL(e)
                    }),
                    i = await C(o, {
                        canvasMemoryLimit: t
                    });
                return URL.revokeObjectURL(o.src), i
            })(e, t);
            o = h(i), g(i)
        }
        return o
    }, I = (e, t, o) => new Promise(((i, n) => {
        try {
            e.toBlob((e => {
                i(e)
            }), t, o)
        } catch (e) {
            n(e)
        }
    })), E = async (e, t, o) => {
        const i = await $(e),
            n = await I(i, t, o);
        return g(i), n
    }, L = e => (e.match(/\/([a-z]+)/) || [])[1], F = e => e.substr(0, e.lastIndexOf(".")) || e;
const z = /avif|bmp|gif|jpg|jpeg|jpe|jif|jfif|png|svg|tiff|webp/;
var B = e => {
        return e && (t = (o = e, o.split(".").pop()).toLowerCase(), z.test(t) ? "image/" + (/jfif|jif|jpe|jpg/.test(t) ? "jpeg" : "svg" === t ? "svg+xml" : t) : "");
        var t, o
    },
    D = (e, t, o) => {
        const n = (new Date).getTime(),
            r = e.type.length && !/null|text/.test(e.type),
            a = r ? e.type : o,
            s = ((e, t) => {
                const o = B(e);
                if (o === t) return e;
                const i = L(t) || o;
                return `${F(e)}.${i}`
            })(t, a);
        try {
            return new(i("File"))([e], s, {
                lastModified: n,
                type: r ? e.type : a
            })
        } catch (t) {
            const o = r ? e.slice() : e.slice(0, e.size, a);
            return o.lastModified = n, o.name = s, o
        }
    },
    O = (e, t) => e / t,
    _ = e => e;
const W = Math.PI,
    V = Math.PI / 2,
    H = V / 2;
var N = e => {
    const t = Math.abs(e) % Math.PI;
    return t > H && t < Math.PI - H
};
const U = (e, t, o) => o + (e - o) * t,
    j = e => ({
        x: e.x + .5 * e.width,
        y: e.y + .5 * e.height,
        rx: .5 * e.width,
        ry: .5 * e.height
    }),
    X = () => Y(0, 0),
    Y = (e, t) => ({
        x: e,
        y: t
    }),
    G = e => Y(e.x, e.y),
    q = e => Y(e.pageX, e.pageY),
    Z = e => Y(e.x, e.y),
    K = e => (e.x = -e.x, e.y = -e.y, e),
    J = (e, t, o = X()) => {
        const i = Math.cos(t),
            n = Math.sin(t),
            r = e.x - o.x,
            a = e.y - o.y;
        return e.x = o.x + i * r - n * a, e.y = o.y + n * r + i * a, e
    },
    Q = e => Math.sqrt(e.x * e.x + e.y * e.y),
    ee = e => {
        const t = Math.sqrt(e.x * e.x + e.y * e.y);
        return 0 === t ? X() : (e.x /= t, e.y /= t, e)
    },
    te = (e, t) => Math.atan2(t.y - e.y, t.x - e.x),
    oe = (e, t) => e.x === t.x && e.y === t.y,
    ie = (e, t) => (e.x = t(e.x), e.y = t(e.y), e),
    ne = (e, t) => (e.x += t.x, e.y += t.y, e),
    re = (e, t) => (e.x -= t.x, e.y -= t.y, e),
    ae = (e, t) => (e.x *= t, e.y *= t, e),
    se = (e, t) => e.x * t.x + e.y * t.y,
    le = (e, t = X()) => {
        const o = e.x - t.x,
            i = e.y - t.y;
        return o * o + i * i
    },
    ce = (e, t = X()) => Math.sqrt(le(e, t)),
    de = (e, t, o) => (e.x = U(e.x, t, o.x), e.y = U(e.y, t, o.y), e),
    ue = e => {
        let t = 0,
            o = 0;
        return e.forEach((e => {
            t += e.x, o += e.y
        })), Y(t / e.length, o / e.length)
    },
    he = (e, t, o, i, n) => (e.forEach((e => {
        e.x = t ? i - (e.x - i) : e.x, e.y = o ? n - (e.y - n) : e.y
    })), e),
    pe = (e, t, o, i) => {
        const n = Math.sin(t),
            r = Math.cos(t);
        return e.forEach((e => {
            e.x -= o, e.y -= i;
            const t = e.x * r - e.y * n,
                a = e.x * n + e.y * r;
            e.x = o + t, e.y = i + a
        })), e
    },
    me = (e, t) => ({
        width: e,
        height: t
    }),
    ge = e => me(e.width, e.height),
    fe = e => me(e.width, e.height),
    $e = e => me(e.width, e.height),
    ye = e => me(e[0], e[1]),
    xe = e => {
        return /img/i.test(e.nodeName) ? me((t = e).naturalWidth, t.naturalHeight) : fe(e);
        var t
    },
    be = (e, t) => me(e, t),
    ve = (e, t, o = _) => o(e.width) === o(t.width) && o(e.height) === o(t.height),
    we = (e, t) => (e.width *= t, e.height *= t, e),
    Se = e => Y(.5 * e.width, .5 * e.height),
    Ce = (e, t) => {
        const o = Math.abs(t),
            i = Math.cos(o),
            n = Math.sin(o),
            r = i * e.width + n * e.height,
            a = n * e.width + i * e.height;
        return e.width = r, e.height = a, e
    },
    ke = (e, t) => e.width >= t.width && e.height >= t.height,
    Me = (e, t) => (e.width = t(e.width), e.height = t(e.height), e),
    Te = (e, t) => ({
        start: e,
        end: t
    }),
    Re = e => Te(Z(e.start), Z(e.end)),
    Pe = (e, t) => {
        if (0 === t) return e;
        const o = Y(e.start.x - e.end.x, e.start.y - e.end.y),
            i = ee(o),
            n = ae(i, t);
        return e.start.x += n.x, e.start.y += n.y, e.end.x -= n.x, e.end.y -= n.y, e
    },
    Ae = [Y(-1, -1), Y(-1, 1), Y(1, 1), Y(1, -1)],
    Ie = (e, t, o, i) => ({
        x: e,
        y: t,
        width: o,
        height: i
    }),
    Ee = e => Ie(e.x, e.y, e.width, e.height),
    Le = () => Ie(0, 0, 0, 0),
    Fe = e => Ie(0, 0, e.width, e.height),
    ze = e => Ie(e.x || 0, e.y || 0, e.width || 0, e.height || 0),
    Be = e => {
        let t = e[0].x,
            o = e[0].x,
            i = e[0].y,
            n = e[0].y;
        return e.forEach((e => {
            t = Math.min(t, e.x), o = Math.max(o, e.x), i = Math.min(i, e.y), n = Math.max(n, e.y)
        })), Ie(t, i, o - t, n - i)
    },
    De = e => _e(e.x - e.rx, e.y - e.ry, 2 * e.rx, 2 * e.ry),
    Oe = (e, t) => Ie(e.x - .5 * t.width, e.y - .5 * t.height, t.width, t.height),
    _e = (e, t, o, i) => Ie(e, t, o, i),
    We = e => Y(e.x + .5 * e.width, e.y + .5 * e.height),
    Ve = (e, t) => (e.x += t.x, e.y += t.y, e),
    He = (e, t, o) => (o = o || We(e), e.x = t * (e.x - o.x) + o.x, e.y = t * (e.y - o.y) + o.y, e.width = t * e.width, e.height = t * e.height, e),
    Ne = (e, t) => (e.x *= t, e.y *= t, e.width *= t, e.height *= t, e),
    Ue = (e, t) => (e.x /= t, e.y /= t, e.width /= t, e.height /= t, e),
    je = (e, t, o = _) => o(e.x) === o(t.x) && o(e.y) === o(t.y) && o(e.width) === o(t.width) && o(e.height) === o(t.height),
    Xe = e => O(e.width, e.height),
    Ye = (e, t, o, i, n) => (e.x = t, e.y = o, e.width = i, e.height = n, e),
    Ge = (e, t) => (e.x = t.x, e.y = t.y, e.width = t.width, e.height = t.height, e),
    qe = (e, t, o) => (o || (o = We(e)), tt(e).map((e => J(e, t, o)))),
    Ze = (e, t) => Ie(.5 * e.width - .5 * t.width, .5 * e.height - .5 * t.height, t.width, t.height),
    Ke = (e, t) => !(t.x < e.x) && (!(t.y < e.y) && (!(t.x > e.x + e.width) && !(t.y > e.y + e.height))),
    Je = (e, t, o = X()) => {
        if (0 === e.width || 0 === e.height) return Le();
        const i = Xe(e);
        t || (t = i);
        let n = e.width,
            r = e.height;
        return t > i ? n = r * t : r = n / t, Ie(o.x + .5 * (e.width - n), o.y + .5 * (e.height - r), n, r)
    },
    Qe = (e, t = Xe(e), o = X()) => {
        if (0 === e.width || 0 === e.height) return Le();
        let i = e.width,
            n = i / t;
        return n > e.height && (n = e.height, i = n * t), Ie(o.x + .5 * (e.width - i), o.y + .5 * (e.height - n), i, n)
    },
    et = e => [Math.min(e.y, e.y + e.height), Math.max(e.x, e.x + e.width), Math.max(e.y, e.y + e.height), Math.min(e.x, e.x + e.width)],
    tt = e => [Y(e.x, e.y), Y(e.x + e.width, e.y), Y(e.x + e.width, e.y + e.height), Y(e.x, e.y + e.height)],
    ot = (e, t) => {
        if (e) return e.x = t(e.x), e.y = t(e.y), e.width = t(e.width), e.height = t(e.height), e
    },
    it = (e, t, o = We(e)) => tt(e).map(((e, i) => {
        const n = Ae[i];
        return Y(U(e.x, 1 + n.x * t.x, o.x), U(e.y, 1 + n.y * t.y, o.y))
    })),
    nt = e => (e.x = 0, e.y = 0, e),
    rt = e => {
        const t = e[0],
            o = e[e.length - 1];
        e = oe(t, o) ? e : [...e, t];
        const i = t.x,
            n = t.y;
        let r, a, s, l = 0,
            c = 0,
            d = 0,
            u = 0;
        const h = e.length;
        for (; c < h; c++) r = e[c], a = e[c + 1 > h - 1 ? 0 : c + 1], s = (r.y - n) * (a.x - i) - (a.y - n) * (r.x - i), l += s, d += (r.x + a.x - 2 * i) * s, u += (r.y + a.y - 2 * n) * s;
        return s = 3 * l, Y(i + d / s, n + u / s)
    },
    at = (e, t) => st(e.start, e.end, t.start, t.end),
    st = (e, t, o, i) => {
        const n = (i.y - o.y) * (t.x - e.x) - (i.x - o.x) * (t.y - e.y);
        if (0 === n) return;
        const r = ((i.x - o.x) * (e.y - o.y) - (i.y - o.y) * (e.x - o.x)) / n,
            a = ((t.x - e.x) * (e.y - o.y) - (t.y - e.y) * (e.x - o.x)) / n;
        return r < 0 || r > 1 || a < 0 || a > 1 ? void 0 : Y(e.x + r * (t.x - e.x), e.y + r * (t.y - e.y))
    },
    lt = (e, t) => {
        let o = 0,
            i = 0,
            n = !1;
        const r = t.length;
        for (o = 0, i = r - 1; o < r; i = o++) t[o].y > e.y != t[i].y > e.y && e.x < (t[i].x - t[o].x) * (e.y - t[o].y) / (t[i].y - t[o].y) + t[o].x && (n = !n);
        return n
    },
    ct = e => {
        const t = [];
        for (let o = 0; o < e.length; o++) {
            let i = o + 1;
            i === e.length && (i = 0), t.push(Te(Z(e[o]), Z(e[i])))
        }
        return t
    },
    dt = (e, t, o, i = 0, n = !1, r = !1, a = 12) => {
        const s = [];
        for (let i = 0; i < a; i++) s.push(Y(e.x + t * Math.cos(i * (2 * Math.PI) / a), e.y + o * Math.sin(i * (2 * Math.PI) / a)));
        return (n || r) && he(s, n, r, e.x, e.y), i && pe(s, i, e.x, e.y), s
    };
var ut = (e, t) => e instanceof HTMLElement && (!t || new RegExp(`^${t}$`, "i").test(e.nodeName)),
    ht = e => e instanceof File,
    pt = e => e.split("/").pop().split(/\?|\#/).shift();
const mt = c() && !!Node.prototype.replaceChildren ? (e, t) => e.replaceChildren(t) : (e, t) => {
        for (; e.lastChild;) e.removeChild(e.lastChild);
        void 0 !== t && e.append(t)
    },
    gt = c() && p("div", {
        class: "PinturaMeasure",
        style: "pointer-events:none;left:0;top:0;width:0;height:0;contain:strict;overflow:hidden;position:absolute;"
    });
let ft;
var $t = e => (mt(gt, e), gt.parentNode || document.body.append(gt), clearTimeout(ft), ft = setTimeout((() => {
    gt.remove()
}), 500), e);
let yt = null;
var xt = () => (null === yt && (yt = c() && /^((?!chrome|android).)*safari/i.test(navigator.userAgent)), yt),
    bt = e => new Promise(((t, o) => {
        let i = !1;
        !e.parentNode && xt() && (i = !0, e.style.cssText = "position:absolute;visibility:hidden;pointer-events:none;left:0;top:0;width:0;height:0;", $t(e));
        const n = () => {
            const o = e.naturalWidth,
                n = e.naturalHeight;
            o && n && (i && e.remove(), clearInterval(r), t({
                width: o,
                height: n
            }))
        };
        e.onerror = e => {
            clearInterval(r), o(e)
        };
        const r = setInterval(n, 1);
        n()
    })),
    vt = async e => {
        let t, o = e;
        o.src || (o = new Image, o.src = w(e) ? e : URL.createObjectURL(e));
        try {
            t = await bt(o)
        } finally {
            ht(e) && URL.revokeObjectURL(o.src)
        }
        return t
    };
var wt = async e => {
    try {
        const t = await vt(e),
            o = await (e => new Promise(((t, o) => {
                if (e.complete) return t(e);
                e.onload = () => t(e), e.onerror = o
            })))(e),
            i = document.createElement("canvas");
        i.width = t.width, i.height = t.height;
        i.getContext("2d").drawImage(o, 0, 0);
        const n = await I(i);
        return D(n, pt(o.src))
    } catch (e) {
        throw e
    }
}, St = (e = 0, t = !0) => new(i("ProgressEvent"))("progress", {
    loaded: 100 * e,
    total: 100,
    lengthComputable: t
}), Ct = e => /^image/.test(e.type), kt = (e, t, o = (e => e)) => e.getAllResponseHeaders().indexOf(t) >= 0 ? o(e.getResponseHeader(t)) : void 0, Mt = e => {
    if (!e) return null;
    const t = e.split(/filename=|filename\*=.+''/).splice(1).map((e => e.trim().replace(/^["']|[;"']{0,2}$/g, ""))).filter((e => e.length));
    return t.length ? decodeURI(t[t.length - 1]) : null
};
const Tt = "URL_REQUEST";
class Rt extends Error {
    constructor(e, t, o) {
        super(e), this.name = "EditorError", this.code = t, this.metadata = o
    }
}
var Pt = (e, t) => /^data:/.test(e) ? (async (e, t = "data-uri", o = n) => {
        o(St(0));
        const i = await fetch(e);
        o(St(.33));
        const r = await i.blob();
        let a;
        Ct(r) || (a = "image/" + (e.includes(",/9j/") ? "jpeg" : "png")), o(St(.66));
        const s = D(r, t, a);
        return o(St(1)), s
    })(e, void 0, t) : ((e, t) => new Promise(((o, i) => {
        const n = () => i(new Rt("Error fetching image", Tt, r)),
            r = new XMLHttpRequest;
        r.onprogress = t, r.onerror = n, r.onload = () => {
            if (!r.response || r.status >= 300 || r.status < 200) return n();
            const t = kt(r, "Content-Type"),
                i = kt(r, "Content-Disposition", Mt) || pt(e);
            o(D(r.response, i, t || B(i)))
        }, r.open("GET", e), r.responseType = "blob", r.send()
    })))(e, t),
    At = async (e, t) => {
        if (ht(e) || (o = e) instanceof Blob && !(o instanceof File)) return e;
        if (w(e)) return await Pt(e, t);
        if (ut(e, "canvas")) return await (async (e, t, o) => {
            const i = await I(e, t, o);
            return D(i, "canvas")
        })(e);
        if (ut(e, "img")) return await wt(e);
        throw new Rt("Invalid image source", "invalid-image-source");
        var o
    };
let It = null;
var Et = () => (null === It && (It = c() && /^mac/i.test(navigator.platform)), It),
    Lt = e => c() ? RegExp(e).test(window.navigator.userAgent) : void 0;
let Ft = null;
var zt = () => (null === Ft && (Ft = c() && (Lt(/iPhone|iPad|iPod/) || Et() && navigator.maxTouchPoints >= 1)), Ft),
    Bt = async (e, t = 1) => await u() || zt() || t < 5 ? e : be(e.height, e.width), Dt = e => /jpeg/.test(e.type), Ot = e => {
        return "object" != typeof (t = e) || t.constructor != Object ? e : JSON.stringify(e);
        var t
    }, _t = (e, t = 0, o) => (0 === t || (e.translate(o.x, o.y), e.rotate(t), e.translate(-o.x, -o.y)), e), Wt = async (e, t = {}) => {
        const {
            flipX: o,
            flipY: i,
            rotation: n,
            crop: r
        } = t, a = fe(e), s = o || i, l = !!n, c = r && (r.x || r.y || r.width || r.height), d = c && je(r, Fe(a)), u = c && !d;
        if (!s && !l && !u) return e;
        let h, m = p("canvas", {
            width: e.width,
            height: e.height
        });
        if (m.getContext("2d").putImageData(e, 0, 0), s) {
            const e = p("canvas", {
                width: m.width,
                height: m.height
            }).getContext("2d");
            ((e, t, o) => {
                e.scale(t, o)
            })(e, o ? -1 : 1, i ? -1 : 1), e.drawImage(m, o ? -m.width : 0, i ? -m.height : 0), e.restore(), g(m), m = e.canvas
        }
        if (l) {
            const e = Me($e(Be(qe(ze(m), n))), Math.floor),
                t = p("canvas", {
                    width: r.width,
                    height: r.height
                }).getContext("2d");
            ((e, t, o) => {
                e.translate(t, o)
            })(t, -r.x, -r.y), _t(t, n, Se(e)), t.drawImage(m, .5 * (e.width - m.width), .5 * (e.height - m.height)), t.restore(), g(m), m = t.canvas
        } else if (u) {
            return h = m.getContext("2d").getImageData(r.x, r.y, r.width, r.height), g(m), h
        }
        return h = m.getContext("2d").getImageData(0, 0, m.width, m.height), g(m), h
    }, Vt = (e, t) => {
        const {
            imageData: o,
            width: i,
            height: n
        } = e, r = o.width, a = o.height, s = Math.round(i), l = Math.round(n), c = o.data, d = new Uint8ClampedArray(s * l * 4), u = r / s, h = a / l, p = Math.ceil(.5 * u), m = Math.ceil(.5 * h);
        for (let e = 0; e < l; e++)
            for (let t = 0; t < s; t++) {
                const o = 4 * (t + e * s);
                let i = 0,
                    n = 0,
                    a = 0,
                    l = 0,
                    g = 0,
                    f = 0,
                    $ = 0;
                const y = (e + .5) * h;
                for (let o = Math.floor(e * h); o < (e + 1) * h; o++) {
                    const e = Math.abs(y - (o + .5)) / m,
                        s = (t + .5) * u,
                        d = e * e;
                    for (let e = Math.floor(t * u); e < (t + 1) * u; e++) {
                        let t = Math.abs(s - (e + .5)) / p;
                        const u = Math.sqrt(d + t * t);
                        if (u < -1 || u > 1) continue;
                        if (i = 2 * u * u * u - 3 * u * u + 1, i <= 0) continue;
                        t = 4 * (e + o * r);
                        const h = c[t + 3];
                        $ += i * h, a += i, h < 255 && (i = i * h / 250), l += i * c[t], g += i * c[t + 1], f += i * c[t + 2], n += i
                    }
                }
                d[o] = l / n, d[o + 1] = g / n, d[o + 2] = f / n, d[o + 3] = $ / a
            }
        t(null, {
            data: d,
            width: s,
            height: l
        })
    }, Ht = e => {
        if (e instanceof ImageData) return e;
        let t;
        try {
            t = new ImageData(e.width, e.height)
        } catch (o) {
            t = p("canvas").getContext("2d").createImageData(e.width, e.height)
        }
        return t.data.set(e.data), t
    }, Nt = async (e, t = {}, o) => {
        const {
            width: i,
            height: n,
            fit: r,
            upscale: a
        } = t;
        if (!i && !n) return e;
        let s = i,
            l = n;
        if (i ? n || (l = i) : s = n, "force" !== r) {
            const t = s / e.width,
                o = l / e.height;
            let i = 1;
            if ("cover" === r ? i = Math.max(t, o) : "contain" === r && (i = Math.min(t, o)), i > 1 && !1 === a) return e;
            s = Math.round(e.width * i), l = Math.round(e.height * i)
        }
        return s = Math.max(s, 1), l = Math.max(l, 1), e.width === s && e.height === l ? e : o ? o(e, s, l) : (e = await P(Vt, [{
            imageData: e,
            width: s,
            height: l
        }], [e.data.buffer]), Ht(e))
    }, Ut = (e, t) => {
        const {
            imageData: o,
            matrix: i
        } = e;
        if (!i) return t(null, o);
        const n = new Uint8ClampedArray(o.width * o.height * 4),
            r = o.data,
            a = r.length,
            s = i[0],
            l = i[1],
            c = i[2],
            d = i[3],
            u = i[4],
            h = i[5],
            p = i[6],
            m = i[7],
            g = i[8],
            f = i[9],
            $ = i[10],
            y = i[11],
            x = i[12],
            b = i[13],
            v = i[14],
            w = i[15],
            S = i[16],
            C = i[17],
            k = i[18],
            M = i[19];
        let T = 0,
            R = 0,
            P = 0,
            A = 0,
            I = 0,
            E = 0,
            L = 0,
            F = 0,
            z = 0,
            B = 0,
            D = 0,
            O = 0;
        for (; T < a; T += 4) R = r[T] / 255, P = r[T + 1] / 255, A = r[T + 2] / 255, I = r[T + 3] / 255, E = R * s + P * l + A * c + I * d + u, L = R * h + P * p + A * m + I * g + f, F = R * $ + P * y + A * x + I * b + v, z = R * w + P * S + A * C + I * k + M, B = Math.max(0, E * z) + (1 - z), D = Math.max(0, L * z) + (1 - z), O = Math.max(0, F * z) + (1 - z), n[T] = 255 * Math.max(0, Math.min(1, B)), n[T + 1] = 255 * Math.max(0, Math.min(1, D)), n[T + 2] = 255 * Math.max(0, Math.min(1, O)), n[T + 3] = 255 * I;
        t(null, {
            data: n,
            width: o.width,
            height: o.height
        })
    }, jt = (e, t) => {
        const {
            imageData: o,
            matrix: i
        } = e;
        if (!i) return t(null, o);
        let n = i.reduce(((e, t) => e + t));
        n = n <= 0 ? 1 : n;
        const r = o.width,
            a = o.height,
            s = o.data;
        let l = 0,
            c = 0,
            d = 0;
        const u = Math.round(Math.sqrt(i.length)),
            h = Math.floor(u / 2);
        let p = 0,
            m = 0,
            g = 0,
            f = 0,
            $ = 0,
            y = 0,
            x = 0,
            b = 0,
            v = 0,
            w = 0;
        const S = new Uint8ClampedArray(r * a * 4);
        for (d = 0; d < a; d++)
            for (c = 0; c < r; c++) {
                for (p = 0, m = 0, g = 0, f = 0, y = 0; y < u; y++)
                    for ($ = 0; $ < u; $++) x = d + y - h, b = c + $ - h, x < 0 && (x = a - 1), x >= a && (x = 0), b < 0 && (b = r - 1), b >= r && (b = 0), v = 4 * (x * r + b), w = i[y * u + $], p += s[v] * w, m += s[v + 1] * w, g += s[v + 2] * w, f += s[v + 3] * w;
                S[l] = p / n, S[l + 1] = m / n, S[l + 2] = g / n, S[l + 3] = f / n, l += 4
            }
        t(null, {
            data: S,
            width: r,
            height: a
        })
    }, Xt = (e, t) => {
        let {
            imageData: o,
            strength: i
        } = e;
        if (!i) return t(null, o);
        const n = new Uint8ClampedArray(o.width * o.height * 4),
            r = o.width,
            a = o.height,
            s = o.data,
            l = (e, t) => (c = e - w, d = t - S, Math.sqrt(c * c + d * d));
        let c, d, u, h, p, m, g, f, $, y, x, b = 0,
            v = 0,
            w = .5 * r,
            S = .5 * a,
            C = l(0, 0);
        for (i > 0 ? (u = 0, h = 0, p = 0) : (i = Math.abs(i), u = 1, h = 1, p = 1), v = 0; v < a; v++)
            for (b = 0; b < r; b++) k = 4 * (b + v * r), M = s, T = n, R = l(b, v) * i / C, m = M[k] / 255, g = M[k + 1] / 255, f = M[k + 2] / 255, $ = M[k + 3] / 255, y = 1 - R, x = y * $ + R, T[k] = (y * $ * m + R * u) / x * 255, T[k + 1] = (y * $ * g + R * h) / x * 255, T[k + 2] = (y * $ * f + R * p) / x * 255, T[k + 3] = 255 * x;
        var k, M, T, R;
        t(null, {
            data: n,
            width: o.width,
            height: o.height
        })
    }, Yt = (e, t) => {
        const {
            imageData: o,
            level: i,
            monochrome: n = !1
        } = e;
        if (!i) return t(null, o);
        const r = new Uint8ClampedArray(o.width * o.height * 4),
            a = o.data,
            s = a.length;
        let l, c, d, u = 0;
        const h = () => 255 * (2 * Math.random() - 1) * i,
            p = n ? () => {
                const e = h();
                return [e, e, e]
            } : () => [h(), h(), h()];
        for (; u < s; u += 4)[l, c, d] = p(), r[u] = a[u] + l, r[u + 1] = a[u + 1] + c, r[u + 2] = a[u + 2] + d, r[u + 3] = a[u + 3];
        t(null, {
            data: r,
            width: o.width,
            height: o.height
        })
    }, Gt = (e, t) => {
        const {
            imageData: o,
            level: i
        } = e;
        if (!i) return t(null, o);
        const n = new Uint8ClampedArray(o.width * o.height * 4),
            r = o.data,
            a = r.length;
        let s, l, c, d = 0;
        for (; d < a; d += 4) s = r[d] / 255, l = r[d + 1] / 255, c = r[d + 2] / 255, n[d] = 255 * Math.pow(s, i), n[d + 1] = 255 * Math.pow(l, i), n[d + 2] = 255 * Math.pow(c, i), n[d + 3] = r[d + 3];
        t(null, {
            data: n,
            width: o.width,
            height: o.height
        })
    }, qt = async (e, t = {}) => {
        const {
            colorMatrix: o,
            convolutionMatrix: i,
            gamma: n,
            noise: r,
            vignette: a
        } = t, s = [];
        if (i && s.push([jt, {
                matrix: i.clarity
            }]), n > 0 && s.push([Gt, {
                level: 1 / n
            }]), o && !(e => {
                const t = e.length;
                let o;
                const i = t >= 20 ? 6 : t >= 16 ? 5 : 3;
                for (let n = 0; n < t; n++) {
                    if (o = e[n], 1 === o && n % i != 0) return !1;
                    if (0 !== o && 1 !== o) return !1
                }
                return !0
            })(o) && s.push([Ut, {
                matrix: o
            }]), (r > 0 || r < 0) && s.push([Yt, {
                level: r
            }]), (a > 0 || a < 0) && s.push([Xt, {
                strength: a
            }]), !s.length) return e;
        const l = (e, t) => `(err, imageData) => {\n            (${e[t][0].toString()})(Object.assign({ imageData: imageData }, filterInstructions[${t}]), \n                ${e[t+1]?l(e,t+1):"done"})\n        }`,
            c = `function (options, done) {\n        const filterInstructions = options.filterInstructions;\n        const imageData = options.imageData;\n        (${l(s,0)})(null, imageData)\n    }`;
        return e = await P(c, [{
            imageData: e,
            filterInstructions: s.map((e => e[1]))
        }], [e.data.buffer]), Ht(e)
    }, Zt = e => "number" == typeof e, Kt = e => w(e) && null !== e.match(/(?:[\u2700-\u27bf]|(?:\ud83c[\udde6-\uddff]){2}|[\ud800-\udbff][\udc00-\udfff]|[\u0023-\u0039]\ufe0f?\u20e3|\u3299|\u3297|\u303d|\u3030|\u24c2|\ud83c[\udd70-\udd71]|\ud83c[\udd7e-\udd7f]|\ud83c\udd8e|\ud83c[\udd91-\udd9a]|\ud83c[\udde6-\uddff]|\ud83c[\ude01-\ude02]|\ud83c\ude1a|\ud83c\ude2f|\ud83c[\ude32-\ude3a]|\ud83c[\ude50-\ude51]|\u203c|\u2049|[\u25aa-\u25ab]|\u25b6|\u25c0|[\u25fb-\u25fe]|\u00a9|\u00ae|\u2122|\u2139|\ud83c\udc04|[\u2600-\u26FF]|\u2b05|\u2b06|\u2b07|\u2b1b|\u2b1c|\u2b50|\u2b55|\u231a|\u231b|\u2328|\u23cf|[\u23e9-\u23f3]|[\u23f8-\u23fa]|\ud83c\udccf|\u2934|\u2935|[\u2190-\u21ff])/g), Jt = (e, t) => e.hasOwnProperty(t), Qt = e => Array.isArray(e);
let eo = 64,
    to = 102,
    oo = 112,
    io = !1;
var no = (e, t) => (!io && c() && (/^win/i.test(navigator.platform) && (to = 103), (zt() || Et()) && (eo = 63.5, to = 110, oo = 123), io = !0), `<svg${t?` aria-label="${t}"`:""} width="128" height="128" viewBox="0 0 128 128" preserveAspectRatio="xMinYMin meet" xmlns="http://www.w3.org/2000/svg"><text x="${eo}" y="${to}" alignment-baseline="text-top" dominant-baseline="text-top" text-anchor="middle" font-size="${oo}px">${e}</text></svg>`),
    ro = e => e instanceof Blob,
    ao = (e, t) => e / t * 100 + "%",
    so = e => `rgba(${Math.round(255*e[0])}, ${Math.round(255*e[1])}, ${Math.round(255*e[2])}, ${Zt(e[3])?e[3]:1})`,
    lo = e => Object.values(e).join("_");
const co = async (e, t = 0) => {
    const o = p("canvas", {
        width: 80,
        height: 80
    }).getContext("2d");
    return await ((e = 0) => new Promise((t => {
        setTimeout(t, e)
    })))(t), o.drawImage(e, 0, 0, 80, 80), !((e => !new Uint32Array(e.getImageData(0, 0, e.canvas.width, e.canvas.height).data.buffer).some((e => 0 !== e)))(o) && t <= 256) || await co(e, t + 16)
}, uo = new Map;
var ho = e => new Promise(((t, o) => {
        const i = new FileReader;
        i.onerror = o, i.onload = () => t(i.result), i.readAsDataURL(e)
    })),
    po = () => {
        let e = [];
        return {
            sub: (t, o) => (e.push({
                event: t,
                callback: o
            }), () => e = e.filter((e => e.event !== t || e.callback !== o))),
            pub: (t, o) => {
                e.filter((e => e.event === t)).forEach((e => e.callback(o)))
            }
        }
    };
const mo = 32,
    go = ({
        color: e = [0, 0, 0],
        fontSize: t = 16,
        fontFamily: o = "sans-serif",
        fontVariant: i = "normal",
        fontWeight: n = "normal",
        fontStyle: r = "normal",
        textAlign: a = "left",
        lineHeight: s = 20
    }) => `font-size:${t}px;font-style:${r};font-weight:${n};font-family:${o};font-variant:${i};line-height:${s}px;text-align:${a};color:${so(e)};`,
    fo = e => {
        const {
            width: t,
            height: o
        } = e, i = !t, n = i ? "normal" : "break-word", r = i ? "nowrap" : "pre-line";
        return `max-width:none;min-width:auto;width:${i?"auto":t+"px"};height:${o?o+"px":"auto"};margin-top:0;margin-bottom:0;padding-top:${(({fontSize:e=16,lineHeight:t=20}={})=>.5*Math.max(0,e-t))(e)}px;word-break:${n};word-wrap:normal;white-space:${r};overflow:visible;`
    },
    $o = new Map,
    yo = new Map,
    xo = (e = "", t) => {
        const {
            width: o = 0,
            height: i = 0
        } = t;
        if (o && i) return be(o, i);
        const {
            fontSize: n,
            fontFamily: r,
            lineHeight: a,
            fontWeight: s,
            fontStyle: l,
            fontVariant: c
        } = t, d = lo({
            text: e,
            fontFamily: r,
            fontWeight: s,
            fontStyle: l,
            fontVariant: c,
            fontSize: n,
            lineHeight: a,
            width: o
        });
        let u = yo.get(d);
        if (u) return u;
        const h = $t(p("pre", {
            contenteditable: "true",
            spellcheck: "false",
            style: `pointer-events:none;visibility:hidden;position:absolute;${go(t)};${fo(t)}"`,
            innerHTML: e
        }, [p("span")])).getBoundingClientRect();
        return u = fe(h), u.height += Math.max(0, n - a), yo.set(d, u), u
    },
    bo = new Map,
    vo = e => new Promise(((t, o) => {
        let i = bo.get(e);
        i || (i = (e => {
            const {
                sub: t,
                pub: o
            } = po();
            let i, n;
            return fetch(e).then((e => e.text())).then((e => {
                i = e, o("load", i)
            })).catch((e => {
                n = e, o("error", n)
            })), {
                sub: (e, o) => "load" === e && i ? o(i) : "error" === e && n ? o(n) : void t(e, o)
            }
        })(e), bo.set(e, i)), i.sub("load", t), i.sub("error", o)
    })),
    wo = new Map,
    So = e => e.filter((e => e instanceof CSSFontFaceRule)),
    Co = async (e, t = (() => !0)) => {
        if (wo.has(e.href)) return wo.get(e.href);
        let o;
        try {
            o = So(Array.from(e.cssRules))
        } catch (i) {
            const n = e.href;
            if (!t(n)) return wo.set(n, []), [];
            o = So(await (async e => {
                let t;
                try {
                    t = await vo(e)
                } catch (e) {
                    return []
                }
                const o = p("style", {
                    innerHTML: t,
                    id: T()
                });
                document.head.append(o);
                const i = Array.from(document.styleSheets).find((e => e.ownerNode.id === o.id));
                return o.remove(), Array.from(i.cssRules)
            })(n)), wo.set(n, o)
        }
        return o
    }, ko = (e, t) => e.style.getPropertyValue(t), Mo = (e, t) => ko(e, "font-family").replace(/^"|"$/g, "") == t, To = async (e, t) => {
        const o = ((e, t) => {
            const o = [];
            for (const i of e) Mo(i, t) && o.push(i);
            return o
        })(await (async e => {
            const t = Array.from(document.styleSheets).map((t => Co(t, e))),
                o = await Promise.all(t),
                i = [];
            return o.forEach((e => i.push(...e))), i
        })(t), e);
        return o.length ? o.map((e => {
            const t = e.parentStyleSheet.href && new URL(e.parentStyleSheet.href),
                o = t ? t.origin + (e => e.pathname.split("/").slice(0, -1).join("/"))(t) + "/" : "",
                i = e.style.getPropertyValue("src").match(/url\("?(.*?)"?\)/)[1],
                n = Array.from(e.style).filter((e => "src" != e)).reduce(((t, o) => t += o + ":" + ko(e, o) + ";"), "");
            return [/^http/.test(i) ? i : o + i, n]
        })) : []
    }, Ro = new Map, Po = new Map;
var Ao = async (e = "", t) => {
    if (!e.length) return;
    const {
        imageWidth: o = 300,
        imageHeight: i = 150,
        paddingLeft: n = mo,
        paddingRight: r = mo,
        fontFamily: a,
        pixelRatio: s = 1,
        willRequestResource: l
    } = t, c = (o + n + r) * s, d = i * s, u = go(t), h = fo(t), p = await (async (e, t) => {
        if (Ro.get(e)) return;
        let o = Po.get(e);
        if (!o) {
            const n = await To(e, t);
            if (!n.length) return void Ro.set(e, !0);
            const r = [];
            for (const [e, t] of n) {
                const o = await fetch(e).then((e => e.blob())),
                    n = !(i = o.type) || /woff2/.test(i) ? "woff2" : /woff/.test(i) ? "woff" : /ttf|truetype/.test(i) ? "truetype" : /otf|opentype/.test(i) ? "opentype" : /svg/.test(i) ? "svg" : "woff2",
                    a = await ho(o);
                r.push(`@font-face { src:url(${a}) format('${n}');${t};font-display:block; }`)
            }
            o = r.join(""), Po.set(e, o)
        }
        var i;
        return o
    })(a, l);
    return ((e, {
        safariCacheKey: t = "*"
    } = {}) => new Promise(((o, i) => {
        const n = new Image;
        n.onerror = i, n.onload = () => {
            if (!xt() || !e.includes("@font-face") || uo.has(t)) return o(n);
            co(n).then((() => {
                uo.set(t, !0), o(n)
            }))
        }, n.src = "data:image/svg+xml," + e
    })))(`<svg xmlns="http://www.w3.org/2000/svg" width="${c}" height="${d}" viewBox="0 0 ${c} ${d}"><foreignObject x="0" y="0" width="${c}" height="${d}"><div xmlns="http://www.w3.org/1999/xhtml" style="transform-origin:0 0;transform:scale(${s})">${p?`<style>${p}</style>`:""}<pre contenteditable="true" spellcheck="false" style="position:absolute;padding-right:${r}px;padding-left:${n}px;${u};${h}">${e.replace(/&/g,"&amp;").replace(/#/g,"%23").replace(/<br>/g,"<br/>").replace(/\n/g,"<br/>")}</pre></div></foreignObject></svg>`, {
        safariCacheKey: a
    })
}, Io = (e, t = 12) => parseFloat(e.toFixed(t));
const Eo = e => {
        const t = {
            ...e
        };
        return v(t)
    },
    Lo = (e, t = {}) => {
        const o = Xe(e);
        let i, n;
        const r = t.width || t.rx,
            a = t.height || t.ry;
        if (r && a) return ge(t);
        if (r || a) {
            i = parseFloat(r || Number.MAX_SAFE_INTEGER), n = parseFloat(a || Number.MAX_SAFE_INTEGER);
            const e = Math.min(i, n);
            w(r) || w(a) ? (i = e + "%", n = e * o + "%") : (i = e, n = e)
        } else {
            const e = 10;
            i = e + "%", n = e * o + "%"
        }
        return {
            [(t.width ? "width" : t.rx ? "rx" : void 0) || "width"]: i,
            [(t.width ? "height" : t.rx ? "ry" : void 0) || "height"]: n
        }
    },
    Fo = (e, t = {}) => {
        return {
            width: void 0,
            height: void 0,
            ...t,
            aspectRatio: 1,
            backgroundImage: (o = no(e), "data:image/svg+xml," + o.replace("<", "%3C").replace(">", "%3E"))
        };
        var o
    },
    zo = (e, t = {}) => ({
        backgroundColor: [0, 0, 0, 0],
        ...No(t) ? {} : {
            width: void 0,
            height: void 0,
            aspectRatio: void 0
        },
        ...t,
        backgroundImage: w(e) ? e : ro(e) ? URL.createObjectURL(e) : e
    }),
    Bo = (e, t) => {
        let o;
        if (w(e) || ro(e)) {
            const i = {
                ...Lo(t),
                backgroundSize: "contain"
            };
            o = Kt(e) ? Fo(e, i) : zo(e, i)
        } else if (e.src) {
            const i = Lo(t, e.shape || e),
                n = {
                    ...e.shape,
                    ...i
                };
            if (e.width && e.height && !Jt(n, "aspectRatio")) {
                const e = Ci(i, "width", t),
                    o = Ci(i, "height", t);
                n.aspectRatio = O(e, o)
            }
            n.backgroundSize || e.shape || e.width && e.height || (n.backgroundSize = "contain"), o = Kt(e.src) ? Fo(e.src, n) : zo(e.src, n)
        } else e.shape && (o = Eo(e.shape));
        return Jt(o, "backgroundImage") && (Jt(o, "backgroundColor") || (o.backgroundColor = [0, 0, 0, 0]), Jt(o, "disableStyle") || (o.disableStyle = ["backgroundColor", "strokeColor", "strokeWidth"]), Jt(o, "disableFlip") || (o.disableFlip = !0)), t ? wi(o, t) : o
    },
    Do = e => Y(e.x1, e.y1),
    Oo = e => Y(e.x2, e.y2),
    _o = e => Jt(e, "text"),
    Wo = e => _o(e) && !(Qo(e) || Jt(e, "width")),
    Vo = e => _o(e) && (Qo(e) || Jt(e, "width")),
    Ho = e => !_o(e) && ei(e),
    No = e => Jt(e, "rx"),
    Uo = e => Jt(e, "x1") && !jo(e),
    jo = e => Jt(e, "x3"),
    Xo = e => Jt(e, "points"),
    Yo = e => _o(e) && e.isEditing,
    Go = e => !Jt(e, "opacity") || e.opacity > 0,
    qo = e => e.isSelected,
    Zo = e => e._isDraft,
    Ko = e => Jt(e, "width") && Jt(e, "height"),
    Jo = e => {
        const t = Jt(e, "right"),
            o = Jt(e, "bottom");
        return t || o
    },
    Qo = e => (Jt(e, "x") || Jt(e, "left")) && Jt(e, "right") || (Jt(e, "y") || Jt(e, "top")) && Jt(e, "bottom"),
    ei = e => Ko(e) || Qo(e),
    ti = e => (e._isDraft = !0, e),
    oi = (e, t) => !0 !== e.disableStyle && (!Qt(e.disableStyle) || !t || !e.disableStyle.includes(t)),
    ii = e => !0 !== e.disableSelect && !jo(e),
    ni = e => !0 !== e.disableRemove,
    ri = e => !e.disableFlip && (!Zo(e) && !Jo(e) && (e => Jt(e, "backgroundImage") || Jt(e, "text"))(e)),
    ai = (e, t) => !!_o(e) && (!0 !== e.disableInput && (S(e.disableInput) ? e.disableInput(null != t ? t : e.text) : t || !0)),
    si = (e, t) => !0 !== e.disableTextLayout && (!Qt(e.disableTextLayout) || !t || !e.disableTextLayout.includes(t)),
    li = e => !0 !== e.disableManipulate && !Zo(e) && !Jo(e),
    ci = e => li(e) && !0 !== e.disableMove,
    di = e => (delete e.left, delete e.right, delete e.top, delete e.bottom, e),
    ui = e => (delete e.rotation, e),
    hi = e => (e.strokeWidth = e.strokeWidth || 1, e.strokeColor = e.strokeColor || [0, 0, 0], e),
    pi = e => (e.backgroundColor = e.backgroundColor ? e.backgroundColor : e.strokeWidth || e.backgroundImage ? void 0 : [0, 0, 0], e),
    mi = e => (delete e.textAlign, di(e)),
    gi = e => (e.textAlign = e.textAlign || "left", e),
    fi = e => ((e => {
        w(e.id) || (e.id = T()), Jt(e, "rotation") || (e.rotation = 0), Jt(e, "opacity") || (e.opacity = 1), Jt(e, "disableErase") || (e.disableErase = !0)
    })(e), _o(e) ? (e => {
        e.fontSize = e.fontSize || "4%", e.fontFamily = e.fontFamily || "sans-serif", e.fontWeight = e.fontWeight || "normal", e.fontStyle = e.fontStyle || "normal", e.fontVariant = e.fontVariant || "normal", e.lineHeight = e.lineHeight || "120%", e.color = e.color || [0, 0, 0], Wo(e) ? mi(e) : gi(e)
    })(e) : Ho(e) ? (e => {
        e.cornerRadius = e.cornerRadius || 0, e.strokeWidth = e.strokeWidth || 0, e.strokeColor = e.strokeColor || [0, 0, 0], pi(e)
    })(e) : Xo(e) ? (e => {
        hi(e), ui(e), di(e)
    })(e) : Uo(e) ? (e => {
        hi(e), e.lineStart = e.lineStart || void 0, e.lineEnd = e.lineEnd || void 0, ui(e), di(e)
    })(e) : No(e) ? (e => {
        e.strokeWidth = e.strokeWidth || 0, e.strokeColor = e.strokeColor || [0, 0, 0], pi(e)
    })(e) : jo(e) && (e => {
        e.strokeWidth = e.strokeWidth || 0, e.strokeColor = e.strokeColor || [0, 0, 0], pi(e), di(e)
    })(e), e),
    $i = e => _o(e) ? "text" : Ho(e) ? "rectangle" : Xo(e) ? "path" : Uo(e) ? "line" : No(e) ? "ellipse" : jo(e) ? "triangle" : void 0,
    yi = (e, t) => parseFloat(e) / 100 * t,
    xi = new RegExp(/^x|left|right|^width|rx|fontSize|cornerRadius|strokeWidth/, "i"),
    bi = new RegExp(/^y|top|bottom|^height|ry/, "i"),
    vi = (e, t) => {
        Object.entries(e).map((([o, i]) => {
            e[o] = ((e, t, {
                width: o,
                height: i
            }) => {
                if (Array.isArray(t)) return t.map((e => (x(e) && vi(e, {
                    width: o,
                    height: i
                }), e)));
                if ("string" != typeof t) return t;
                if (!t.endsWith("%")) return t;
                const n = parseFloat(t) / 100;
                return xi.test(e) ? Io(o * n, 6) : bi.test(e) ? Io(i * n, 6) : t
            })(o, i, t)
        }));
        const o = e.lineHeight;
        w(o) && (e.lineHeight = Math.round(e.fontSize * (parseFloat(o) / 100)))
    },
    wi = (e, t) => (vi(e, t), Pi(e, t), e),
    Si = (e, t) => {
        let o;
        return /^x|width|rx|fontSize|strokeWidth|cornerRadius/.test(e) ? o = t.width : /^y|height|ry/.test(e) && (o = t.height), o
    },
    Ci = (e, t, o) => w(e[t]) ? yi(e[t], Si(t, o)) : e[t],
    ki = (e, t, o) => t.reduce(((t, i) => {
        const n = Ci(e, i, o);
        return t[i] = n, t
    }), {}),
    Mi = (e, t, o) => (Object.keys(t).forEach((i => ((e, t, o, i) => {
        if (!w(e[t])) return e[t] = o, e;
        const n = Si(t, i);
        return e[t] = void 0 === n ? o : ao(o, n), e
    })(e, i, t[i], o))), e),
    Ti = (e, t) => {
        const o = e.filter((e => e.x < 0 || e.y < 0 || e.x1 < 0 || e.y1 < 0)).reduce(((e, t) => {
            const [o, i, n, r] = (e => {
                const t = Le(),
                    o = e.strokeWidth || 0;
                if (Ho(e)) t.x = e.x - .5 * o, t.y = e.y - .5 * o, t.width = e.width + o, t.height = e.height + o;
                else if (Uo(e)) {
                    const {
                        x1: i,
                        y1: n,
                        x2: r,
                        y2: a
                    } = e, s = Math.abs(Math.min(i, r)), l = Math.abs(Math.max(i, r)), c = Math.abs(Math.min(n, a)), d = Math.abs(Math.min(n, a));
                    t.x = s + .5 * o, t.y = l + .5 * o, t.width = l - s + o, t.height = d - c + o
                } else No(e) && (t.x = e.x - e.rx + .5 * o, t.y = e.y - e.ry + .5 * o, t.width = 2 * e.rx + o, t.height = 2 * e.ry + o);
                return t && Jt(e, "rotation") && qe(t, e.rotation), et(t)
            })(t);
            return e.top = Math.min(o, e.top), e.left = Math.min(r, e.left), e.bottom = Math.max(n, e.bottom), e.right = Math.max(i, e.right), e
        }), {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        });
        return o.right > 0 && (o.right -= t.width), o.bottom > 0 && (o.bottom -= t.height), o
    },
    Ri = (e, t, o) => {
        const i = Eo(e);
        return wi(i, t), o(i)
    },
    Pi = (e, t) => {
        if (Jt(e, "left") && (e.x = e.left), Jt(e, "right") && !w(e.right)) {
            const o = t.width - e.right;
            Jt(e, "left") ? (e.x = e.left, e.width = Math.max(0, o - e.left)) : Jt(e, "width") && (e.x = o - e.width)
        }
        if (Jt(e, "top") && (e.y = e.top), Jt(e, "bottom") && !w(e.bottom)) {
            const o = t.height - e.bottom;
            Jt(e, "top") ? (e.y = e.top, e.height = Math.max(0, o - e.top)) : Jt(e, "height") && (e.y = o - e.height)
        }
        return e
    },
    Ai = (e, t) => (Xo(e) && e.points.filter((e => Zt(e.x))).forEach((e => {
        e.x *= t, e.y *= t
    })), jo(e) && Zt(e.x1) && (e.x1 *= t, e.y1 *= t, e.x2 *= t, e.y2 *= t, e.x3 *= t, e.y3 *= t), Uo(e) && Zt(e.x1) && (e.x1 *= t, e.y1 *= t, e.x2 *= t, e.y2 *= t), Zt(e.x) && Zt(e.y) && (e.x *= t, e.y *= t), Zt(e.width) && Zt(e.height) && (e.width *= t, e.height *= t), Zt(e.rx) && Zt(e.ry) && (e.rx *= t, e.ry *= t), (e => Zt(e.strokeWidth) && e.strokeWidth > 0)(e) && (e.strokeWidth *= t), _o(e) && (e._scale = t, Zt(e.fontSize) && (e.fontSize *= t), Zt(e.lineHeight) && (e.lineHeight *= t), Zt(e.width) && !Zt(e.height) && (e.width *= t)), Jt(e, "cornerRadius") && Zt(e.cornerRadius) && (e.cornerRadius *= t), e);
var Ii = e => /canvas/i.test(e.nodeName),
    Ei = (e, t) => new Promise(((o, i) => {
        let n = e,
            r = !1;
        const a = () => {
            r || (r = !0, S(t) && Promise.resolve().then((() => t(be(n.naturalWidth, n.naturalHeight)))))
        };
        if (n.src || (n = new Image, w(e) && new URL(e, location.href).origin !== location.origin && (n.crossOrigin = "anonymous"), n.src = w(e) ? e : URL.createObjectURL(e)), n.complete) return a(), o(n);
        S(t) && bt(n).then(a).catch(i), n.onload = () => {
            a(), o(n)
        }, n.onerror = i
    }));
const Li = new Map([]),
    Fi = (e, t = {}) => new Promise(((o, i) => {
        const {
            onMetadata: r = n,
            onLoad: a = o,
            onError: s = i,
            onComplete: l = n
        } = t;
        let c = Li.get(e);
        if (c || (c = {
                loading: !1,
                complete: !1,
                error: !1,
                image: void 0,
                size: void 0,
                bus: po()
            }, Li.set(e, c)), c.bus.sub("meta", r), c.bus.sub("load", a), c.bus.sub("error", s), c.bus.sub("complete", l), Ii(e)) {
            const t = e,
                o = t.cloneNode();
            c.complete = !0, c.image = o, c.size = xe(t)
        }
        if (c.complete) return c.bus.pub("meta", {
            size: c.size
        }), c.error ? c.bus.pub("error", c.error) : c.bus.pub("load", c.image), c.bus.pub("complete"), void(c.bus = po());
        c.loading || (c.loading = !0, Ei(e, (e => {
            c.size = e, c.bus.pub("meta", {
                size: e
            })
        })).then((e => {
            c.image = e, c.bus.pub("load", e)
        })).catch((e => {
            c.error = e, c.bus.pub("error", e)
        })).finally((() => {
            c.complete = !0, c.loading = !1, c.bus.pub("complete"), c.bus = po()
        })))
    })),
    zi = (e, t, o, i) => e.drawImage(t, o.x, o.x, o.width, o.height, i.x, i.y, i.width, i.height);
var Bi = async (e, t, o, i, n = zi) => {
    e.save(), e.clip(), await n(e, t, o, i), e.restore()
};
const Di = (e, t, o, i) => {
        let n = _e(0, 0, o.width, o.height);
        const r = Ee(e);
        if (i) n = ot(Be(i), Io), n.x *= o.width, n.width *= o.width, n.y *= o.height, n.height *= o.height;
        else if ("contain" === t) {
            const t = Qe(e, Xe(n));
            r.width = t.width, r.height = t.height, r.x += t.x, r.y += t.y
        } else "cover" === t && (n = Qe(_e(0, 0, n.width, n.height), Xe(r)));
        return {
            srcRect: n,
            destRect: r
        }
    },
    Oi = (e, t) => (t.cornerRadius > 0 ? ((e, t, o, i, n, r) => {
        i < 2 * r && (r = i / 2), n < 2 * r && (r = n / 2), e.beginPath(), e.moveTo(t + r, o), e.arcTo(t + i, o, t + i, o + n, r), e.arcTo(t + i, o + n, t, o + n, r), e.arcTo(t, o + n, t, o, r), e.arcTo(t, o, t + i, o, r), e.closePath()
    })(e, t.x, t.y, t.width, t.height, t.cornerRadius) : e.rect(t.x, t.y, t.width, t.height), e),
    _i = (e, t) => (t.backgroundColor && e.fill(), e),
    Wi = (e, t) => (t.strokeWidth && e.stroke(), e);
var Vi = async (e, t, o = {}) => new Promise((async (i, n) => {
    const {
        drawImage: r
    } = o;
    if (e.lineWidth = t.strokeWidth ? t.strokeWidth : 1, e.strokeStyle = t.strokeColor ? so(t.strokeColor) : "none", e.fillStyle = t.backgroundColor ? so(t.backgroundColor) : "none", e.globalAlpha = t.opacity, t.backgroundImage) {
        let o;
        try {
            o = Ii(t.backgroundImage) ? t.backgroundImage : await Fi(t.backgroundImage)
        } catch (e) {
            n(e)
        }
        Oi(e, t), _i(e, t);
        const {
            srcRect: a,
            destRect: s
        } = Di(t, t.backgroundSize, xe(o), t.backgroundCorners);
        await Bi(e, o, a, s, r), Wi(e, t), i([])
    } else Oi(e, t), _i(e, t), Wi(e, t), i([])
})), Hi = async (e, t, o = {}) => new Promise((async (i, n) => {
    const {
        drawImage: r
    } = o;
    if (e.lineWidth = t.strokeWidth || 1, e.strokeStyle = t.strokeColor ? so(t.strokeColor) : "none", e.fillStyle = t.backgroundColor ? so(t.backgroundColor) : "none", e.globalAlpha = t.opacity, e.ellipse(t.x, t.y, t.rx, t.ry, 0, 0, 2 * Math.PI), t.backgroundColor && e.fill(), t.backgroundImage) {
        let o;
        try {
            o = await Fi(t.backgroundImage)
        } catch (e) {
            n(e)
        }
        const a = _e(t.x - t.rx, t.y - t.ry, 2 * t.rx, 2 * t.ry),
            {
                srcRect: s,
                destRect: l
            } = Di(a, t.backgroundSize, xe(o));
        await Bi(e, o, s, l, r), t.strokeWidth && e.stroke(), i([])
    } else t.strokeWidth && e.stroke(), i([])
})), Ni = async (e, t, o) => {
    const i = t.width && t.height ? fe(t) : xo(t.text, t),
        n = {
            x: t.x,
            y: t.y,
            width: i.width,
            height: i.height
        };
    if (Vi(e, {
            ...t,
            ...n,
            options: o
        }), !t.text.length) return [];
    const {
        willRequestResource: r
    } = o, a = await Ao(t.text, {
        ...t,
        ...n,
        imageWidth: n.width,
        imageHeight: n.height,
        willRequestResource: r
    });
    return e.drawImage(a, t.x - mo, t.y, a.width, a.height), []
}, Ui = async (e, t) => new Promise((async o => {
    e.lineWidth = t.strokeWidth || 1, e.strokeStyle = t.strokeColor ? so(t.strokeColor) : "none", e.globalAlpha = t.opacity;
    let i = Do(t),
        n = Oo(t);
    e.moveTo(i.x, i.y), e.lineTo(n.x, n.y), t.strokeWidth && e.stroke(), o([])
})), ji = async (e, t) => new Promise(((o, i) => {
    e.lineWidth = t.strokeWidth || 1, e.strokeStyle = t.strokeColor ? so(t.strokeColor) : "none", e.fillStyle = t.backgroundColor ? so(t.backgroundColor) : "none", e.globalAlpha = t.opacity;
    const {
        points: n
    } = t;
    t.pathClose && e.beginPath(), e.moveTo(n[0].x, n[0].y);
    const r = n.length;
    for (let t = 1; t < r; t++) e.lineTo(n[t].x, n[t].y);
    t.pathClose && e.closePath(), t.strokeWidth && e.stroke(), t.backgroundColor && e.fill(), o([])
}));
const Xi = async (e, t, o) => {
    const i = (e => {
        if (Ho(e)) return Y(e.x + .5 * e.width, e.y + .5 * e.height);
        if (No(e)) return Y(e.x, e.y);
        if (Vo(e)) {
            const t = e.height || xo(e.text, e).height;
            return Y(e.x + .5 * e.width, e.y + .5 * t)
        }
        if (Wo(e)) {
            const t = xo(e.text, e);
            return Y(e.x + .5 * t.width, e.y + .5 * t.height)
        }
        return Xo(e) ? ue(e.points) : Uo(e) ? ue([Do(e), Oo(e)]) : void 0
    })(t);
    let n;
    return _t(e, t.rotation, i), ((e, t, o, i) => {
        (t || o) && (e.translate(i.x, i.y), e.scale(t ? -1 : 1, o ? -1 : 1), e.translate(-i.x, -i.y))
    })(e, t.flipX, t.flipY, i), Ho(t) ? n = Vi : No(t) ? n = Hi : Uo(t) ? n = Ui : Xo(t) ? n = ji : _o(t) && (n = Ni), n ? [t, ...await Yi(e, await n(e, t, o), o)] : []
};
var Yi = async (e, t, o) => {
    let i = [];
    for (const n of t) e.save(), e.beginPath(), i = [...i, ...await Xi(e, n, o)], e.restore();
    return i
}, Gi = async (e, t = {}) => {
    const {
        shapes: o = [],
        contextBounds: i = e,
        transform: r = n,
        drawImage: a,
        willRequestResource: s,
        canvasMemoryLimit: l,
        computeShape: c = _,
        preprocessShape: d = _
    } = t;
    if (!o.length) return e;
    const u = p("canvas");
    u.width = i.width, u.height = i.height;
    const h = u.getContext("2d");
    h.putImageData(e, i.x || 0, i.y || 0);
    const m = o.map(Eo).map(c).map(d).flat();
    r(h), await Yi(h, m, {
        drawImage: a,
        canvasMemoryLimit: l,
        willRequestResource: s
    });
    const f = h.getImageData(0, 0, u.width, u.height);
    return g(u), f
}, qi = async (e, t = {}) => {
    const {
        backgroundColor: o
    } = t;
    if (!o || o && 0 === o[3]) return e;
    const i = p("canvas");
    i.width = e.width, i.height = e.height;
    const n = i.getContext("2d");
    n.putImageData(e, 0, 0), n.globalCompositeOperation = "destination-over", n.fillStyle = so(o), n.fillRect(0, 0, i.width, i.height);
    const r = n.getImageData(0, 0, i.width, i.height);
    return g(i), r
}, Zi = e => e.length ? e.reduce(((e, t) => ((e, t) => {
    const o = new Array(20);
    return o[0] = e[0] * t[0] + e[1] * t[5] + e[2] * t[10] + e[3] * t[15], o[1] = e[0] * t[1] + e[1] * t[6] + e[2] * t[11] + e[3] * t[16], o[2] = e[0] * t[2] + e[1] * t[7] + e[2] * t[12] + e[3] * t[17], o[3] = e[0] * t[3] + e[1] * t[8] + e[2] * t[13] + e[3] * t[18], o[4] = e[0] * t[4] + e[1] * t[9] + e[2] * t[14] + e[3] * t[19] + e[4], o[5] = e[5] * t[0] + e[6] * t[5] + e[7] * t[10] + e[8] * t[15], o[6] = e[5] * t[1] + e[6] * t[6] + e[7] * t[11] + e[8] * t[16], o[7] = e[5] * t[2] + e[6] * t[7] + e[7] * t[12] + e[8] * t[17], o[8] = e[5] * t[3] + e[6] * t[8] + e[7] * t[13] + e[8] * t[18], o[9] = e[5] * t[4] + e[6] * t[9] + e[7] * t[14] + e[8] * t[19] + e[9], o[10] = e[10] * t[0] + e[11] * t[5] + e[12] * t[10] + e[13] * t[15], o[11] = e[10] * t[1] + e[11] * t[6] + e[12] * t[11] + e[13] * t[16], o[12] = e[10] * t[2] + e[11] * t[7] + e[12] * t[12] + e[13] * t[17], o[13] = e[10] * t[3] + e[11] * t[8] + e[12] * t[13] + e[13] * t[18], o[14] = e[10] * t[4] + e[11] * t[9] + e[12] * t[14] + e[13] * t[19] + e[14], o[15] = e[15] * t[0] + e[16] * t[5] + e[17] * t[10] + e[18] * t[15], o[16] = e[15] * t[1] + e[16] * t[6] + e[17] * t[11] + e[18] * t[16], o[17] = e[15] * t[2] + e[16] * t[7] + e[17] * t[12] + e[18] * t[17], o[18] = e[15] * t[3] + e[16] * t[8] + e[17] * t[13] + e[18] * t[18], o[19] = e[15] * t[4] + e[16] * t[9] + e[17] * t[14] + e[18] * t[19] + e[19], o
})([...e], t)), e.shift()) : [], Ki = (e, t) => {
    const o = e.width * e.height,
        i = t.reduce(((e, t) => (t.width > e.width && t.height > e.height && (e.width = t.width, e.height = t.height), e)), {
            width: 0,
            height: 0
        }),
        n = i.width * i.height;
    return ((e, t = 2) => Math.round(e * t) / t)(Math.max(.5, .5 + (1 - n / o) / 2), 5)
};

function Ji() {}
const Qi = e => e;

function en(e, t) {
    for (const o in t) e[o] = t[o];
    return e
}

function tn(e) {
    return e()
}

function on() {
    return Object.create(null)
}

function nn(e) {
    e.forEach(tn)
}

function rn(e) {
    return "function" == typeof e
}

function an(e, t) {
    return e != e ? t == t : e !== t || e && "object" == typeof e || "function" == typeof e
}

function sn(e, ...t) {
    if (null == e) return Ji;
    const o = e.subscribe(...t);
    return o.unsubscribe ? () => o.unsubscribe() : o
}

function ln(e) {
    let t;
    return sn(e, (e => t = e))(), t
}

function cn(e, t, o) {
    e.$$.on_destroy.push(sn(t, o))
}

function dn(e, t, o, i) {
    if (e) {
        const n = un(e, t, o, i);
        return e[0](n)
    }
}

function un(e, t, o, i) {
    return e[1] && i ? en(o.ctx.slice(), e[1](i(t))) : o.ctx
}

function hn(e, t, o, i, n, r, a) {
    const s = function (e, t, o, i) {
        if (e[2] && i) {
            const n = e[2](i(o));
            if (void 0 === t.dirty) return n;
            if ("object" == typeof n) {
                const e = [],
                    o = Math.max(t.dirty.length, n.length);
                for (let i = 0; i < o; i += 1) e[i] = t.dirty[i] | n[i];
                return e
            }
            return t.dirty | n
        }
        return t.dirty
    }(t, i, n, r);
    if (s) {
        const n = un(t, o, i, a);
        e.p(n, s)
    }
}

function pn(e) {
    const t = {};
    for (const o in e) "$" !== o[0] && (t[o] = e[o]);
    return t
}

function mn(e, t) {
    const o = {};
    t = new Set(t);
    for (const i in e) t.has(i) || "$" === i[0] || (o[i] = e[i]);
    return o
}

function gn(e, t, o = t) {
    return e.set(o), t
}

function fn(e) {
    return e && rn(e.destroy) ? e.destroy : Ji
}
const $n = "undefined" != typeof window;
let yn = $n ? () => window.performance.now() : () => Date.now(),
    xn = $n ? e => requestAnimationFrame(e) : Ji;
const bn = new Set;

function vn(e) {
    bn.forEach((t => {
        t.c(e) || (bn.delete(t), t.f())
    })), 0 !== bn.size && xn(vn)
}

function wn(e) {
    let t;
    return 0 === bn.size && xn(vn), {
        promise: new Promise((o => {
            bn.add(t = {
                c: e,
                f: o
            })
        })),
        abort() {
            bn.delete(t)
        }
    }
}

function Sn(e, t) {
    e.appendChild(t)
}

function Cn(e, t, o) {
    e.insertBefore(t, o || null)
}

function kn(e) {
    e.parentNode.removeChild(e)
}

function Mn(e) {
    return document.createElement(e)
}

function Tn(e) {
    return document.createElementNS("http://www.w3.org/2000/svg", e)
}

function Rn(e) {
    return document.createTextNode(e)
}

function Pn() {
    return Rn(" ")
}

function An() {
    return Rn("")
}

function In(e, t, o, i) {
    return e.addEventListener(t, o, i), () => e.removeEventListener(t, o, i)
}

function En(e) {
    return function (t) {
        return t.preventDefault(), e.call(this, t)
    }
}

function Ln(e) {
    return function (t) {
        return t.stopPropagation(), e.call(this, t)
    }
}

function Fn(e, t, o) {
    null == o ? e.removeAttribute(t) : e.getAttribute(t) !== o && e.setAttribute(t, o)
}

function zn(e, t) {
    const o = Object.getOwnPropertyDescriptors(e.__proto__);
    for (const i in t) null == t[i] ? e.removeAttribute(i) : "style" === i ? e.style.cssText = t[i] : "__value" === i ? e.value = e[i] = t[i] : o[i] && o[i].set ? e[i] = t[i] : Fn(e, i, t[i])
}

function Bn(e, t) {
    t = "" + t, e.wholeText !== t && (e.data = t)
}

function Dn(e, t) {
    e.value = null == t ? "" : t
}

function On(e, t) {
    const o = document.createEvent("CustomEvent");
    return o.initCustomEvent(e, !1, !1, t), o
}
class _n {
    constructor(e = null) {
        this.a = e, this.e = this.n = null
    }
    m(e, t, o = null) {
        this.e || (this.e = Mn(t.nodeName), this.t = t, this.h(e)), this.i(o)
    }
    h(e) {
        this.e.innerHTML = e, this.n = Array.from(this.e.childNodes)
    }
    i(e) {
        for (let t = 0; t < this.n.length; t += 1) Cn(this.t, this.n[t], e)
    }
    p(e) {
        this.d(), this.h(e), this.i(this.a)
    }
    d() {
        this.n.forEach(kn)
    }
}
const Wn = new Set;
let Vn, Hn = 0;

function Nn(e, t, o, i, n, r, a, s = 0) {
    const l = 16.666 / i;
    let c = "{\n";
    for (let e = 0; e <= 1; e += l) {
        const i = t + (o - t) * r(e);
        c += 100 * e + `%{${a(i,1-i)}}\n`
    }
    const d = c + `100% {${a(o,1-o)}}\n}`,
        u = `__svelte_${function(e){let t=5381,o=e.length;for(;o--;)t=(t<<5)-t^e.charCodeAt(o);return t>>>0}(d)}_${s}`,
        h = e.ownerDocument;
    Wn.add(h);
    const p = h.__svelte_stylesheet || (h.__svelte_stylesheet = h.head.appendChild(Mn("style")).sheet),
        m = h.__svelte_rules || (h.__svelte_rules = {});
    m[u] || (m[u] = !0, p.insertRule(`@keyframes ${u} ${d}`, p.cssRules.length));
    const g = e.style.animation || "";
    return e.style.animation = `${g?g+", ":""}${u} ${i}ms linear ${n}ms 1 both`, Hn += 1, u
}

function Un(e, t) {
    const o = (e.style.animation || "").split(", "),
        i = o.filter(t ? e => e.indexOf(t) < 0 : e => -1 === e.indexOf("__svelte")),
        n = o.length - i.length;
    n && (e.style.animation = i.join(", "), Hn -= n, Hn || xn((() => {
        Hn || (Wn.forEach((e => {
            const t = e.__svelte_stylesheet;
            let o = t.cssRules.length;
            for (; o--;) t.deleteRule(o);
            e.__svelte_rules = {}
        })), Wn.clear())
    })))
}

function jn(e) {
    Vn = e
}

function Xn() {
    if (!Vn) throw new Error("Function called outside component initialization");
    return Vn
}

function Yn(e) {
    Xn().$$.on_mount.push(e)
}

function Gn(e) {
    Xn().$$.after_update.push(e)
}

function qn(e) {
    Xn().$$.on_destroy.push(e)
}

function Zn() {
    const e = Xn();
    return (t, o) => {
        const i = e.$$.callbacks[t];
        if (i) {
            const n = On(t, o);
            i.slice().forEach((t => {
                t.call(e, n)
            }))
        }
    }
}

function Kn(e, t) {
    Xn().$$.context.set(e, t)
}

function Jn(e) {
    return Xn().$$.context.get(e)
}

function Qn(e, t) {
    const o = e.$$.callbacks[t.type];
    o && o.slice().forEach((e => e(t)))
}
const er = [],
    tr = [],
    or = [],
    ir = [],
    nr = Promise.resolve();
let rr = !1;

function ar(e) {
    or.push(e)
}

function sr(e) {
    ir.push(e)
}
let lr = !1;
const cr = new Set;

function dr() {
    if (!lr) {
        lr = !0;
        do {
            for (let e = 0; e < er.length; e += 1) {
                const t = er[e];
                jn(t), ur(t.$$)
            }
            for (jn(null), er.length = 0; tr.length;) tr.pop()();
            for (let e = 0; e < or.length; e += 1) {
                const t = or[e];
                cr.has(t) || (cr.add(t), t())
            }
            or.length = 0
        } while (er.length);
        for (; ir.length;) ir.pop()();
        rr = !1, lr = !1, cr.clear()
    }
}

function ur(e) {
    if (null !== e.fragment) {
        e.update(), nn(e.before_update);
        const t = e.dirty;
        e.dirty = [-1], e.fragment && e.fragment.p(e.ctx, t), e.after_update.forEach(ar)
    }
}
let hr;

function pr(e, t, o) {
    e.dispatchEvent(On(`${t?"intro":"outro"}${o}`))
}
const mr = new Set;
let gr;

function fr() {
    gr = {
        r: 0,
        c: [],
        p: gr
    }
}

function $r() {
    gr.r || nn(gr.c), gr = gr.p
}

function yr(e, t) {
    e && e.i && (mr.delete(e), e.i(t))
}

function xr(e, t, o, i) {
    if (e && e.o) {
        if (mr.has(e)) return;
        mr.add(e), gr.c.push((() => {
            mr.delete(e), i && (o && e.d(1), i())
        })), e.o(t)
    }
}
const br = {
    duration: 0
};

function vr(e, t, o, i) {
    let n = t(e, o),
        r = i ? 0 : 1,
        a = null,
        s = null,
        l = null;

    function c() {
        l && Un(e, l)
    }

    function d(e, t) {
        const o = e.b - r;
        return t *= Math.abs(o), {
            a: r,
            b: e.b,
            d: o,
            duration: t,
            start: e.start,
            end: e.start + t,
            group: e.group
        }
    }

    function u(t) {
        const {
            delay: o = 0,
            duration: i = 300,
            easing: u = Qi,
            tick: h = Ji,
            css: p
        } = n || br, m = {
            start: yn() + o,
            b: t
        };
        t || (m.group = gr, gr.r += 1), a || s ? s = m : (p && (c(), l = Nn(e, r, t, i, o, u, p)), t && h(0, 1), a = d(m, i), ar((() => pr(e, t, "start"))), wn((t => {
            if (s && t > s.start && (a = d(s, i), s = null, pr(e, a.b, "start"), p && (c(), l = Nn(e, r, a.b, a.duration, 0, u, n.css))), a)
                if (t >= a.end) h(r = a.b, 1 - r), pr(e, a.b, "end"), s || (a.b ? c() : --a.group.r || nn(a.group.c)), a = null;
                else if (t >= a.start) {
                const e = t - a.start;
                r = a.a + a.d * u(e / a.duration), h(r, 1 - r)
            }
            return !(!a && !s)
        })))
    }
    return {
        run(e) {
            rn(n) ? (hr || (hr = Promise.resolve(), hr.then((() => {
                hr = null
            }))), hr).then((() => {
                n = n(), u(e)
            })) : u(e)
        },
        end() {
            c(), a = s = null
        }
    }
}
const wr = "undefined" != typeof window ? window : "undefined" != typeof globalThis ? globalThis : global;

function Sr(e, t) {
    e.d(1), t.delete(e.key)
}

function Cr(e, t) {
    xr(e, 1, 1, (() => {
        t.delete(e.key)
    }))
}

function kr(e, t, o, i, n, r, a, s, l, c, d, u) {
    let h = e.length,
        p = r.length,
        m = h;
    const g = {};
    for (; m--;) g[e[m].key] = m;
    const f = [],
        $ = new Map,
        y = new Map;
    for (m = p; m--;) {
        const e = u(n, r, m),
            s = o(e);
        let l = a.get(s);
        l ? i && l.p(e, t) : (l = c(s, e), l.c()), $.set(s, f[m] = l), s in g && y.set(s, Math.abs(m - g[s]))
    }
    const x = new Set,
        b = new Set;

    function v(e) {
        yr(e, 1), e.m(s, d), a.set(e.key, e), d = e.first, p--
    }
    for (; h && p;) {
        const t = f[p - 1],
            o = e[h - 1],
            i = t.key,
            n = o.key;
        t === o ? (d = t.first, h--, p--) : $.has(n) ? !a.has(i) || x.has(i) ? v(t) : b.has(n) ? h-- : y.get(i) > y.get(n) ? (b.add(i), v(t)) : (x.add(n), h--) : (l(o, a), h--)
    }
    for (; h--;) {
        const t = e[h];
        $.has(t.key) || l(t, a)
    }
    for (; p;) v(f[p - 1]);
    return f
}

function Mr(e, t) {
    const o = {},
        i = {},
        n = {
            $$scope: 1
        };
    let r = e.length;
    for (; r--;) {
        const a = e[r],
            s = t[r];
        if (s) {
            for (const e in a) e in s || (i[e] = 1);
            for (const e in s) n[e] || (o[e] = s[e], n[e] = 1);
            e[r] = s
        } else
            for (const e in a) n[e] = 1
    }
    for (const e in i) e in o || (o[e] = void 0);
    return o
}

function Tr(e) {
    return "object" == typeof e && null !== e ? e : {}
}

function Rr(e, t, o) {
    const i = e.$$.props[t];
    void 0 !== i && (e.$$.bound[i] = o, o(e.$$.ctx[i]))
}

function Pr(e) {
    e && e.c()
}

function Ar(e, t, o, i) {
    const {
        fragment: n,
        on_mount: r,
        on_destroy: a,
        after_update: s
    } = e.$$;
    n && n.m(t, o), i || ar((() => {
        const t = r.map(tn).filter(rn);
        a ? a.push(...t) : nn(t), e.$$.on_mount = []
    })), s.forEach(ar)
}

function Ir(e, t) {
    const o = e.$$;
    null !== o.fragment && (nn(o.on_destroy), o.fragment && o.fragment.d(t), o.on_destroy = o.fragment = null, o.ctx = [])
}

function Er(e, t) {
    -1 === e.$$.dirty[0] && (er.push(e), rr || (rr = !0, nr.then(dr)), e.$$.dirty.fill(0)), e.$$.dirty[t / 31 | 0] |= 1 << t % 31
}

function Lr(e, t, o, i, n, r, a = [-1]) {
    const s = Vn;
    jn(e);
    const l = e.$$ = {
        fragment: null,
        ctx: null,
        props: r,
        update: Ji,
        not_equal: n,
        bound: on(),
        on_mount: [],
        on_destroy: [],
        on_disconnect: [],
        before_update: [],
        after_update: [],
        context: new Map(s ? s.$$.context : t.context || []),
        callbacks: on(),
        dirty: a,
        skip_bound: !1
    };
    let c = !1;
    if (l.ctx = o ? o(e, t.props || {}, ((t, o, ...i) => {
            const r = i.length ? i[0] : o;
            return l.ctx && n(l.ctx[t], l.ctx[t] = r) && (!l.skip_bound && l.bound[t] && l.bound[t](r), c && Er(e, t)), o
        })) : [], l.update(), c = !0, nn(l.before_update), l.fragment = !!i && i(l.ctx), t.target) {
        if (t.hydrate) {
            const e = function (e) {
                return Array.from(e.childNodes)
            }(t.target);
            l.fragment && l.fragment.l(e), e.forEach(kn)
        } else l.fragment && l.fragment.c();
        t.intro && yr(e.$$.fragment), Ar(e, t.target, t.anchor, t.customElement), dr()
    }
    jn(s)
}
class Fr {
    $destroy() {
        Ir(this, 1), this.$destroy = Ji
    }
    $on(e, t) {
        const o = this.$$.callbacks[e] || (this.$$.callbacks[e] = []);
        return o.push(t), () => {
            const e = o.indexOf(t); - 1 !== e && o.splice(e, 1)
        }
    }
    $set(e) {
        var t;
        this.$$set && (t = e, 0 !== Object.keys(t).length) && (this.$$.skip_bound = !0, this.$$set(e), this.$$.skip_bound = !1)
    }
}
const zr = [];

function Br(e, t) {
    return {
        subscribe: Dr(e, t).subscribe
    }
}

function Dr(e, t = Ji) {
    let o;
    const i = [];

    function n(t) {
        if (an(e, t) && (e = t, o)) {
            const t = !zr.length;
            for (let t = 0; t < i.length; t += 1) {
                const o = i[t];
                o[1](), zr.push(o, e)
            }
            if (t) {
                for (let e = 0; e < zr.length; e += 2) zr[e][0](zr[e + 1]);
                zr.length = 0
            }
        }
    }
    return {
        set: n,
        update: function (t) {
            n(t(e))
        },
        subscribe: function (r, a = Ji) {
            const s = [r, a];
            return i.push(s), 1 === i.length && (o = t(n) || Ji), r(e), () => {
                const e = i.indexOf(s); - 1 !== e && i.splice(e, 1), 0 === i.length && (o(), o = null)
            }
        }
    }
}

function Or(e, t, o) {
    const i = !Array.isArray(e),
        n = i ? [e] : e,
        r = t.length < 2;
    return Br(o, (e => {
        let o = !1;
        const a = [];
        let s = 0,
            l = Ji;
        const c = () => {
                if (s) return;
                l();
                const o = t(i ? a[0] : a, e);
                r ? e(o) : l = rn(o) ? o : Ji
            },
            d = n.map(((e, t) => sn(e, (e => {
                a[t] = e, s &= ~(1 << t), o && c()
            }), (() => {
                s |= 1 << t
            }))));
        return o = !0, c(),
            function () {
                nn(d), l()
            }
    }))
}
var _r = e => e.reduce(((e, t) => Object.assign(e, t)), {});
const Wr = e => ({
        updateValue: e
    }),
    Vr = e => ({
        defaultValue: e
    }),
    Hr = e => ({
        store: (t, o) => Or(...e(o))
    }),
    Nr = e => ({
        store: (t, o) => {
            const [i, n, r = (() => !1)] = e(o);
            let a, s = !0;
            return Or(i, ((e, t) => {
                n(e, (e => {
                    !s && r(a, e) || (a = e, s = !1, t(e))
                }))
            }))
        }
    }),
    Ur = e => ({
        store: (t, o) => {
            const [i, n = {}, r] = e(o);
            let a = [];
            const s = {},
                l = e => i(e, s),
                c = e => {
                    (a.length || e.length) && (a = e, d())
                },
                d = () => {
                    const e = a.map(l);
                    r && e.sort(r), a = [...e], h(e)
                };
            Object.entries(n).map((([e, t]) => t.subscribe((t => {
                s[e] = t, t && d()
            }))));
            const {
                subscribe: u,
                set: h
            } = Dr(t || []);
            return {
                set: c,
                update: e => c(e(a)),
                subscribe: u
            }
        }
    });
var jr = e => {
        const t = {},
            o = {};
        return e.forEach((([e, ...i]) => {
            const r = _r(i),
                a = t[e] = ((e, t, o) => {
                    const {
                        store: i = (e => Dr(e)),
                        defaultValue: r = n,
                        updateValue: a
                    } = o, s = i(r(), t, e), {
                        subscribe: l,
                        update: c = n
                    } = s;
                    let d;
                    const u = e => {
                            let t = !0;
                            d && d(), d = l((o => {
                                if (t) return t = !1;
                                e(o), d(), d = void 0
                            }))
                        },
                        h = a ? a(e) : _;
                    return s.set = e => c((t => h(e, t, u))), s.defaultValue = r, s
                })(o, t, r),
                s = {
                    get: () => ln(a),
                    set: a.set
                };
            Object.defineProperty(o, e, s)
        })), {
            stores: t,
            accessors: o
        }
    },
    Xr = [
        ["src"],
        ["imageReader"],
        ["imageWriter"],
        ["imageScrambler"],
        ["images", Vr((() => []))],
        ["shapePreprocessor"],
        ["willRequestResource"]
    ],
    Yr = e => e.charAt(0).toUpperCase() + e.slice(1),
    Gr = (e, t) => {
        Object.keys(t).forEach((o => {
            const i = S(t[o]) ? {
                value: t[o],
                writable: !1
            } : t[o];
            Object.defineProperty(e, o, i)
        }))
    };
const qr = (e, t) => {
    let o, i, n, r, a, s, l, c, d, u;
    const h = t.length;
    for (o = 0; o < h; o++)
        if (i = t[o], n = t[o + 1 > h - 1 ? 0 : o + 1], r = i.x - e.x, a = i.y - e.y, s = n.x - e.x, l = n.y - e.y, c = r - s, d = a - l, u = c * a - d * r, u < -1e-5) return !1;
    return !0
};
var Zr = (e, t) => {
        const o = ct(t),
            i = X();
        tt(e).forEach((e => {
            ne(e, i), qr(e, t) || o.forEach((t => {
                const o = Math.atan2(t.start.y - t.end.y, t.start.x - t.end.x),
                    n = 1e4 * Math.sin(Math.PI - o),
                    r = 1e4 * Math.cos(Math.PI - o),
                    a = Y(e.x + n, e.y + r),
                    s = Pe(Re(t), 1e4),
                    l = at(Te(e, a), s);
                l && ne(i, re(Z(l), e))
            }))
        }));
        const n = Ee(e);
        ne(n, i);
        return !!tt(n).every((e => qr(e, t))) && (Ge(e, n), !0)
    },
    Kr = (e, t) => {
        const o = tt(e),
            i = ct(t).map((e => Pe(e, 5))),
            n = We(e),
            r = [];
        o.forEach((e => {
            const t = ((e, t) => {
                if (0 === t) return e;
                const o = Y(e.start.x - e.end.x, e.start.y - e.end.y),
                    i = ee(o),
                    n = ae(i, t);
                return e.end.x += n.x, e.end.y += n.y, e
            })(Te(Z(n), Z(e)), 1e6);
            let o = !1;
            i.map(Re).forEach((e => {
                const i = at(t, e);
                i && !o && (r.push(i), o = !0)
            }))
        }));
        const a = ce(r[0], r[2]) < ce(r[1], r[3]) ? [r[0], r[2]] : [r[1], r[3]],
            s = Be(a);
        return s.width < e.width && (Ge(e, s), !0)
    },
    Jr = (e, t, o = {
        x: 0,
        y: 0
    }) => {
        const i = Fe(e),
            n = We(i),
            r = it(i, o, n).map((e => J(e, t, n))),
            a = Be(r);
        return r.map((e => re(e, a)))
    },
    Qr = (e, t = 0, o = Xe(e)) => {
        let i, n;
        if (0 !== t) {
            const r = Math.atan2(1, o),
                a = Math.sign(t) * t,
                s = a % Math.PI,
                l = a % V;
            let c, d;
            d = s > H && s < V + H ? l > H ? a : V - l : l > H ? V - l : a, c = Math.min(Math.abs(e.height / Math.sin(r + d)), Math.abs(e.width / Math.cos(r - d))), i = Math.cos(r) * c, n = i / o
        } else i = e.width, n = i / o, n > e.height && (n = e.height, i = n * o);
        return be(i, n)
    },
    ea = (e, t, o, i, n, r, a, s) => {
        const l = ge(a),
            c = ge(s),
            d = Io(Math.max(t.width / c.width, t.height / c.height)),
            u = Io(Math.min(t.width / l.width, t.height / l.height)),
            h = Ee(t);
        if (u < 1 || d > 1) {
            const o = We(e),
                i = We(t),
                n = u < 1 ? u : d,
                r = (i.x + o.x) / 2,
                a = (i.y + o.y) / 2,
                s = h.width / n,
                l = h.height / n;
            Ye(h, r - .5 * s, a - .5 * l, s, l)
        }
        return r ? (((e, t, o = 0, i = X(), n) => {
            if (Zt(o) && 0 !== o || i.x || i.y) {
                const n = Xe(e),
                    r = Jr(t, o, i),
                    a = Qr(t, o, n);
                if (!(e.width < a.width && e.height < a.height)) {
                    const t = .5 * e.width - .5 * a.width,
                        o = .5 * e.height - .5 * a.height;
                    e.width > a.width && (e.width = a.width, e.x += t), e.height > a.height && (e.height = a.height, e.y += o)
                }
                Zr(e, r), Kr(e, r) && Zr(e, r)
            } else {
                const o = Xe(e);
                e.width = Math.min(e.width, t.width), e.height = Math.min(e.height, t.height), e.x = Math.max(e.x, 0), e.x + e.width > t.width && (e.x -= e.x + e.width - t.width), e.y = Math.max(e.y, 0), e.y + e.height > t.height && (e.y -= e.y + e.height - t.height);
                const i = We(e),
                    r = Qe(e, o);
                r.width = Math.max(n.width, r.width), r.height = Math.max(n.height, r.height), r.x = i.x - .5 * r.width, r.y = i.y - .5 * r.height, Ge(e, r)
            }
        })(h, o, i, n, l), {
            crop: h
        }) : {
            crop: h
        }
    },
    ta = (e, t, o) => {
        const i = Fe(e),
            n = We(i),
            r = qe(i, o, n),
            a = We(nt(Be(r))),
            s = We(t),
            l = J(s, -o, a),
            c = re(l, a),
            d = ie(ne(n, c), Io);
        return _e(d.x - .5 * t.width, d.y - .5 * t.height, t.width, t.height)
    },
    oa = (e, t, o) => Math.max(t, Math.min(e, o));
const ia = ["cropLimitToImage", "cropMinSize", "cropMaxSize", "cropAspectRatio", "flipX", "flipY", "rotation", "crop", "colorMatrix", "convolutionMatrix", "gamma", "vignette", "redaction", "annotation", "decoration", "frame", "backgroundColor", "targetSize", "metadata"],
    na = e => Qt(e) ? e.map(na) : x(e) ? {
        ...e
    } : e,
    ra = e => e.map((e => Object.entries(e).reduce(((e, [t, o]) => (t.startsWith("_") || (e[t] = o), e)), {})));
var aa = (e, t) => {
    if (e.length !== t.length) return !1;
    for (let o = 0; o < e.length; o++)
        if (e[o] !== t[o]) return !1;
    return !0
};
const sa = -H,
    la = H,
    ca = (e, t, o) => {
        const i = ie(We(e), (e => Io(e, 8))),
            n = Fe(t),
            r = We(n),
            a = qe(n, o, r),
            s = ie(Se(Be(a)), (e => Io(e, 8))),
            l = Math.abs(s.x - i.x),
            c = Math.abs(s.y - i.y);
        return l < 1 && c < 1
    },
    da = (e, t, o, i, n) => {
        if (!n) return [sa, la];
        const r = Math.max(o.width / i.width, o.height / i.height),
            a = be(i.width * r, i.height * r),
            s = (l = a, Math.sqrt(l.width * l.width + l.height * l.height));
        var l;
        if (s < Math.min(e.width, e.height)) return [sa, la];
        const c = t ? e.height : e.width,
            d = t ? e.width : e.height,
            u = Math.acos(a.height / s),
            h = u - Math.acos(d / s),
            p = Math.asin(c / s) - u;
        if (Number.isNaN(h) && Number.isNaN(p)) return [sa, la];
        const m = Number.isNaN(h) ? p : Number.isNaN(p) ? h : Math.min(h, p);
        return [Math.max(-m, sa), Math.min(m, la)]
    },
    ua = (e, t) => {
        const {
            context: o,
            props: i
        } = t;
        return e._isFormatted || ((e = fi(e))._isFormatted = !0, Object.assign(e, i)), e._isDraft || !Qo(e) || e._context && je(o, e._context) || (Pi(e, o), e._context = {
            ...o
        }), e
    };
var ha = [
        ["file"],
        ["size"],
        ["loadState"],
        ["processState"],
        ["aspectRatio", Hr((({
            size: e
        }) => [e, e => e ? Xe(e) : void 0]))],
        ["perspectiveX", Vr((() => 0))],
        ["perspectiveY", Vr((() => 0))],
        ["perspective", Hr((({
            perspectiveX: e,
            perspectiveY: t
        }) => [
            [e, t], ([e, t]) => ({
                x: e,
                y: t
            })
        ]))],
        ["rotation", Vr((() => 0)), Wr((e => (t, o, i) => {
            if (t === o) return t;
            const {
                loadState: n,
                size: r,
                rotationRange: a,
                cropMinSize: s,
                cropMaxSize: l,
                crop: c,
                perspective: d,
                cropLimitToImage: u,
                cropOrigin: h
            } = e;
            if (!c || !n || !n.beforeComplete) return t;
            const p = ((e, t, o) => {
                    const i = Qr(t, o, Xe(e));
                    return ve(Me(i, Math.round), Me(ge(e), Math.round))
                })(c, r, o),
                m = ca(c, r, o),
                g = ((e, t, o, i, n, r, a, s, l, c) => {
                    const d = ge(l),
                        u = ge(c);
                    a && (u.width = Math.min(c.width, n.width), u.height = Math.min(c.height, n.height));
                    let h = !1;
                    const p = (t, o) => {
                            const l = ta(n, i, t),
                                c = Fe(n),
                                m = We(c),
                                g = it(c, r, m),
                                f = re(Z(m), rt(g)),
                                $ = J(We(l), o, m),
                                y = re(Z(m), $);
                            g.forEach((e => J(e, o, m)));
                            const x = Be(g),
                                b = rt(g),
                                v = ne(re(re(b, y), x), f),
                                w = _e(v.x - .5 * l.width, v.y - .5 * l.height, l.width, l.height);
                            if (s && He(w, s.width / w.width), a) {
                                const e = Jr(n, o, r);
                                Kr(w, e)
                            }
                            const S = Io(Math.min(w.width / d.width, w.height / d.height), 8),
                                C = Io(Math.max(w.width / u.width, w.height / u.height), 8);
                            return (S < 1 || C > 1) && Io(Math.abs(o - t)) === Io(Math.PI / 2) && !h ? (h = !0, p(e, e + Math.sign(o - t) * Math.PI)) : {
                                rotation: o,
                                crop: ot(w, (e => Io(e, 8)))
                            }
                        },
                        m = Math.sign(t) * Math.round(Math.abs(t) / V) * V,
                        g = oa(t, m + o[0], m + o[1]);
                    return p(e, g)
                })(o, t, a, c, r, d, u, h, s, l);
            if (p && m) {
                const e = Qr(r, t, Xe(g.crop));
                g.crop.x += .5 * g.crop.width, g.crop.y += .5 * g.crop.height, g.crop.x -= .5 * e.width, g.crop.y -= .5 * e.height, g.crop.width = e.width, g.crop.height = e.height
            }
            return i((() => {
                e.crop = ot(g.crop, (e => Io(e, 8)))
            })), g.rotation
        }))],
        ["flipX", Vr((() => !1))],
        ["flipY", Vr((() => !1))],
        ["flip", Hr((({
            flipX: e,
            flipY: t
        }) => [
            [e, t], ([e, t]) => ({
                x: e,
                y: t
            })
        ]))],
        ["isRotatedSideways", Nr((({
            rotation: e
        }) => [
            [e], ([e], t) => t(N(e)), (e, t) => e !== t
        ]))],
        ["crop", Wr((e => (t, o = t) => {
            const {
                loadState: i,
                size: n,
                cropMinSize: r,
                cropMaxSize: a,
                cropLimitToImage: s,
                cropAspectRatio: l,
                rotation: c,
                perspective: d
            } = e;
            if (!t && !o || !i || !i.beforeComplete) return t;
            t || (t = Fe(Qr(n, c, l || Xe(n))));
            const u = ea(o, t, n, c, d, s, r, a);
            return ot(u.crop, (e => Io(e, 8)))
        }))],
        ["cropAspectRatio", Wr((e => (t, o) => {
            const {
                loadState: i,
                crop: n,
                size: r,
                rotation: a,
                cropLimitToImage: s
            } = e, l = (e => {
                if (e) {
                    if (/:/.test(e)) {
                        const [t, o] = e.split(":");
                        return t / o
                    }
                    return parseFloat(e)
                }
            })(t);
            if (!l) return;
            if (!n || !i || !i.beforeComplete) return l;
            const c = o ? Math.abs(t - o) : 1;
            if (ca(n, r, a) && s && c >= .1) {
                const o = ((e, t) => {
                    const o = e.width,
                        i = e.height;
                    return N(t) && (e.width = i, e.height = o), e
                })(ge(r), a);
                e.crop = ot(Qe(Fe(o), t), Io)
            } else {
                const t = {
                        width: n.height * l,
                        height: n.height
                    },
                    o = .5 * (n.width - t.width),
                    i = .5 * (n.height - t.height);
                e.crop = ot(_e(n.x + o, n.y + i, t.width, t.height), Io)
            }
            return l
        }))],
        ["cropOrigin"],
        ["cropMinSize", Vr((() => ({
            width: 1,
            height: 1
        })))],
        ["cropMaxSize", Vr((() => ({
            width: 32768,
            height: 32768
        })))],
        ["cropLimitToImage", Vr((() => !0)), Wr((e => (t, o, i) => {
            const {
                crop: n
            } = e;
            return n ? (!o && t && i((() => e.crop = Ee(e.crop))), t) : t
        }))],
        ["cropSize", Nr((({
            crop: e
        }) => [
            [e], ([e], t) => {
                e && t(be(e.width, e.height))
            }, (e, t) => ve(e, t)
        ]))],
        ["cropRectAspectRatio", Hr((({
            cropSize: e
        }) => [
            [e], ([e], t) => {
                e && t(Io(Xe(e), 5))
            }
        ]))],
        ["cropRange", Nr((({
            size: e,
            rotation: t,
            cropRectAspectRatio: o,
            cropMinSize: i,
            cropMaxSize: n,
            cropLimitToImage: r
        }) => [
            [e, t, o, i, n, r], ([e, t, o, i, n, r], a) => {
                if (!e) return;
                a(((e, t, o, i, n, r) => {
                    const a = ge(i),
                        s = ge(n);
                    return r ? [a, Me(Qr(e, t, o), Math.round)] : [a, s]
                })(e, t, o, i, n, r))
            }, (e, t) => aa(e, t)
        ]))],
        ["rotationRange", Nr((({
            size: e,
            isRotatedSideways: t,
            cropMinSize: o,
            cropSize: i,
            cropLimitToImage: n
        }) => [
            [e, t, o, i, n], ([e, t, o, i, n], r) => {
                if (!e || !i) return;
                r(da(e, t, o, i, n))
            }, (e, t) => aa(e, t)
        ]))],
        ["backgroundColor", Wr((() => e => ((e = [0, 0, 0, 0], t = 1) => 4 === e.length ? e : [...e, t])(e)))],
        ["targetSize"],
        ["colorMatrix"],
        ["convolutionMatrix"],
        ["gamma"],
        ["noise"],
        ["vignette"],
        ["redaction", Ur((({
            size: e
        }) => [ua, {
            context: e
        }]))],
        ["annotation", Ur((({
            size: e
        }) => [ua, {
            context: e
        }]))],
        ["decoration", Ur((({
            crop: e
        }) => [ua, {
            context: e
        }]))],
        ["frame", Wr((() => e => {
            if (!e) return;
            const t = {
                frameStyle: void 0,
                x: 0,
                y: 0,
                width: "100%",
                height: "100%",
                disableStyle: ["backgroundColor", "strokeColor", "strokeWidth"]
            };
            return w(e) ? t.frameStyle = e : Object.assign(t, e), t
        }))],
        ["metadata"],
        ["state", (e => ({
            store: e
        }))(((e, t, o) => {
            const i = ia.map((e => t[e])),
                {
                    subscribe: n
                } = Or(i, ((e, t) => {
                    const o = ia.reduce(((t, o, i) => (t[o] = na(e[i]), t)), {});
                    o.crop && ot(o.crop, Math.round), o.redaction = o.redaction && ra(o.redaction), o.annotation = o.annotation && ra(o.annotation), o.decoration = o.decoration && ra(o.decoration), t(o)
                })),
                r = e => {
                    e && (o.cropOrigin = void 0, ia.filter((t => Jt(e, t))).forEach((t => {
                        o[t] = na(e[t])
                    })))
                };
            return {
                set: r,
                update: e => r(e(null)),
                subscribe: n
            }
        }))]
    ],
    pa = async (e, t, o = {}, i) => {
        const {
            ontaskstart: n,
            ontaskprogress: r,
            ontaskend: a,
            token: s
        } = i;
        let l = !1;
        s.cancel = () => {
            l = !0
        };
        for (const [i, s] of t.entries()) {
            if (l) return;
            const [t, c] = s;
            n(i, c);
            try {
                e = await t(e, {
                    ...o
                }, (e => r(i, c, e)))
            } catch (e) {
                throw l = !0, e
            }
            a(i, c)
        }
        return e
    };
const ma = ["loadstart", "loadabort", "loaderror", "loadprogress", "load", "processstart", "processabort", "processerror", "processprogress", "process"],
    ga = ["flip", "cropOrigin", "isRotatedSideways", "perspective", "perspectiveX", "perspectiveY", "cropRange"],
    fa = ["images"],
    $a = ha.map((([e]) => e)).filter((e => !ga.includes(e))),
    ya = e => "image" + Yr(e),
    xa = e => Jt(e, "crop");
var ba = () => {
    const {
        stores: e,
        accessors: t
    } = jr(Xr), {
        sub: o,
        pub: i
    } = po(), r = () => t.images ? t.images[0] : {};
    let a = {};
    $a.forEach((e => {
        Object.defineProperty(t, ya(e), {
            get: () => {
                const t = r();
                if (t) return t.accessors[e]
            },
            set: t => {
                a[ya(e)] = t;
                const o = r();
                o && (o.accessors[e] = t)
            }
        })
    }));
    const s = () => t.images && t.images[0],
        l = e.src.subscribe((e => {
            if (!e) return t.images = [];
            t.imageReader && (t.images.length && (a = {}), d(e))
        })),
        c = e.imageReader.subscribe((e => {
            e && (t.images.length || t.src && d(t.src))
        })),
        d = e => {
            Promise.resolve().then((() => h(e, a))).catch((() => {}))
        };
    let u;
    const h = (e, o = {}) => new Promise(((r, l) => {
        let c = s();
        const d = !(!1 === o.cropLimitToImage || !1 === o.imageCropLimitToImage),
            h = o.cropMinSize || o.imageCropMinSize,
            p = d ? h : c && c.accessors.cropMinSize;
        c && m(), c = (({
            minSize: e = {
                width: 1,
                height: 1
            }
        } = {}) => {
            const {
                stores: t,
                accessors: o
            } = jr(ha), {
                pub: i,
                sub: r
            } = po(), a = (e, t) => {
                const n = () => o[e] || {},
                    r = t => o[e] = {
                        ...n(),
                        ...t,
                        timeStamp: Date.now()
                    },
                    a = () => n().error,
                    s = e => {
                        a() || (r({
                            error: e
                        }), i(t + "error", {
                            ...n()
                        }))
                    };
                return {
                    start() {
                        i(t + "start")
                    },
                    onabort() {
                        r({
                            abort: !0
                        }), i(t + "abort", {
                            ...n()
                        })
                    },
                    ontaskstart(e, o) {
                        a() || (r({
                            index: e,
                            task: o,
                            taskProgress: void 0,
                            taskLengthComputable: void 0
                        }), i(t + "taskstart", {
                            ...n()
                        }))
                    },
                    ontaskprogress(e, o, s) {
                        a() || (r({
                            index: e,
                            task: o,
                            taskProgress: s.loaded / s.total,
                            taskLengthComputable: s.lengthComputable
                        }), i(t + "taskprogress", {
                            ...n()
                        }), i(t + "progress", {
                            ...n()
                        }))
                    },
                    ontaskend(e, o) {
                        a() || (r({
                            index: e,
                            task: o
                        }), i(t + "taskend", {
                            ...n()
                        }))
                    },
                    ontaskerror(e) {
                        s(e)
                    },
                    error(e) {
                        s(e)
                    },
                    beforeComplete(e) {
                        a() || (r({
                            beforeComplete: !0
                        }), i("before" + t, e))
                    },
                    complete(e) {
                        a() || (r({
                            complete: !0
                        }), i(t, e))
                    }
                }
            };
            return Gr(o, {
                read: (t, {
                    reader: i
                }) => {
                    if (!i) return;
                    Object.assign(o, {
                        file: void 0,
                        size: void 0,
                        loadState: void 0
                    });
                    let r = {
                            cancel: n
                        },
                        s = !1;
                    const l = a("loadState", "load"),
                        c = {
                            token: r,
                            ...l
                        },
                        d = {
                            src: t,
                            size: void 0,
                            dest: void 0
                        },
                        u = {};
                    return Promise.resolve().then((async () => {
                        try {
                            if (l.start(), s) return l.onabort();
                            const t = await pa(d, i, u, c);
                            if (s) return l.onabort();
                            const {
                                size: n,
                                dest: a
                            } = t || {};
                            if (!n || !n.width || !n.height) throw new Rt("Image size missing", "IMAGE_SIZE_MISSING", t);
                            if (n.width < e.width || n.height < e.height) throw new Rt("Image too small", "IMAGE_TOO_SMALL", {
                                ...t,
                                minWidth: e.width,
                                minHeight: e.height
                            });
                            Object.assign(o, {
                                size: n,
                                file: a
                            }), l.beforeComplete(t), l.complete(t)
                        } catch (e) {
                            l.error(e)
                        } finally {
                            r = void 0
                        }
                    })), () => {
                        s = !0, r && r.cancel(), l.onabort()
                    }
                },
                write: (e, t) => {
                    if (!o.loadState.complete) return;
                    o.processState = void 0;
                    const i = a("processState", "process"),
                        r = {
                            src: o.file,
                            imageState: o.state,
                            dest: void 0
                        };
                    if (!e) return i.start(), void i.complete(r);
                    let s = {
                            cancel: n
                        },
                        l = !1;
                    const c = t,
                        d = {
                            token: s,
                            ...i
                        };
                    return Promise.resolve().then((async () => {
                        try {
                            if (i.start(), l) return i.onabort();
                            const t = await pa(r, e, c, d);
                            i.complete(t)
                        } catch (e) {
                            i.error(e)
                        } finally {
                            s = void 0
                        }
                    })), () => {
                        l = !0, s && s.cancel()
                    }
                },
                on: r
            }), {
                accessors: o,
                stores: t
            }
        })({
            minSize: p
        }), ma.map((e => {
            return c.accessors.on(e, (t = e, e => i(t, e)));
            var t
        }));
        const g = () => {
                a = {}, f.forEach((e => e()))
            },
            f = [];
        f.push(c.accessors.on("loaderror", (e => {
            g(), l(e)
        }))), f.push(c.accessors.on("loadabort", (() => {
            g(), l({
                name: "AbortError"
            })
        }))), f.push(c.accessors.on("load", (e => {
            u = void 0, g(), r(e)
        }))), f.push(c.accessors.on("beforeload", (() => ((e, o) => {
            if (xa(o)) return void(t.imageState = o);
            if (!o.imageCrop) {
                const t = e.accessors.size,
                    i = o.imageRotation || 0,
                    n = Fe(Ce(ge(t), i)),
                    r = o.imageCropAspectRatio || (o.imageCropLimitToImage ? Xe(t) : Xe(n)),
                    a = Qe(n, r);
                o.imageCropLimitToImage || (a.x = (t.width - a.width) / 2, a.y = (t.height - a.height) / 2), o.imageCrop = a
            } ["imageCropLimitToImage", "imageCrop", "imageCropAspectRatio", "imageRotation"].filter((e => Jt(o, e))).forEach((e => {
                t[e] = o[e], delete o[e]
            }));
            const {
                imageCropLimitToImage: i,
                imageCrop: n,
                imageCropAspectRatio: r,
                imageRotation: a,
                ...s
            } = o;
            Object.assign(t, s)
        })(c, o)))), t.images = [c], o.imageReader && (t.imageReader = o.imageReader), o.imageWriter && (t.imageWriter = o.imageWriter), u = c.accessors.read(e, {
            reader: t.imageReader
        })
    }));
    let p;
    const m = () => {
        const e = s();
        e && (u && u(), e.accessors.loadState = void 0, t.images = [])
    };
    return Object.defineProperty(t, "stores", {
        get: () => e
    }), Gr(t, {
        on: o,
        loadImage: h,
        abortLoadImage: () => {
            u && u(), t.images = []
        },
        editImage: (e, o) => new Promise(((i, n) => {
            h(e, o).then((() => {
                const {
                    images: e
                } = t, o = e[0], r = () => {
                    a(), s()
                }, a = o.accessors.on("processerror", (e => {
                    r(), n(e)
                })), s = o.accessors.on("process", (e => {
                    r(), i(e)
                }))
            })).catch(n)
        })),
        removeImage: m,
        processImage: (e, o) => new Promise((async (i, n) => {
            (e => w(e) || ro(e) || ut(e))(e) ? await h(e, o): e && (xa(e) ? t.imageState = e : Object.assign(t, e));
            const r = s();
            if (!r) return n("no image");
            const a = () => {
                    p = void 0, l.forEach((e => e()))
                },
                l = [];
            l.push(r.accessors.on("processerror", (e => {
                a(), n(e)
            }))), l.push(r.accessors.on("processabort", (() => {
                a(), n({
                    name: "AbortError"
                })
            }))), l.push(r.accessors.on("process", (e => {
                a(), i(e)
            }))), p = r.accessors.write(t.imageWriter, {
                shapePreprocessor: t.shapePreprocessor || _,
                imageScrambler: t.imageScrambler,
                willRequestResource: t.willRequestResource
            })
        })),
        abortProcessImage: () => {
            const e = s();
            e && (p && p(), e.accessors.processState = void 0)
        },
        destroy: () => {
            l(), c()
        }
    }), t
};
const va = (e, t) => {
    const {
        processImage: o
    } = ba();
    return o(e, t)
};
var wa = () => {
        if (!xt()) return 1 / 0;
        const e = /15_/.test(navigator.userAgent);
        return zt() ? e ? 14745600 : 16777216 : e ? 16777216 : 1 / 0
    },
    Sa = (e, t) => Object.keys(e).filter((e => !t.includes(e))).reduce(((t, o) => (t[o] = e[o], t)), {});
const Ca = ({
    imageDataResizer: e,
    canvasMemoryLimit: t
} = {}) => async (o, i, n, r) => {
    n.width = Math.max(n.width, 1), n.height = Math.max(n.height, 1), r.width = Math.max(r.width, 1), r.height = Math.max(r.height, 1);
    const {
        dest: a
    } = await va(i, {
        imageReader: Za(),
        imageWriter: Ka({
            format: "canvas",
            targetSize: {
                ...r,
                upscale: !0
            },
            imageDataResizer: e,
            canvasMemoryLimit: t
        }),
        imageCrop: n
    });
    o.drawImage(a, r.x, r.y, r.width, r.height), g(a)
}, ka = (e, t = ((...e) => e), o) => async (i, n, r) => {
    r(St(0, !1));
    let a = !1;
    const s = await e(...t(i, n, (e => {
        a = !0, r(e)
    })));
    return o && o(i, s), a || r(St(1, !1)), i
}, Ma = ({
    srcProp: e = "src",
    destProp: t = "dest"
} = {}) => [ka(At, ((t, o, i) => [t[e], i]), ((e, o) => e[t] = o)), "any-to-file"], Ta = ({
    srcProp: e = "src",
    destProp: t = "size"
} = {}) => [ka(vt, ((t, o) => [t[e]]), ((e, o) => e[t] = o)), "read-image-size"], Ra = ({
    srcSize: e = "size",
    srcOrientation: t = "orientation",
    destSize: o = "size"
} = {}) => [ka(Bt, (o => [o[e], o[t]]), ((e, t) => e[o] = t)), "image-size-match-orientation"], Pa = ({
    srcProp: e = "src",
    destProp: t = "head"
} = {}) => [ka(((e, t) => Dt(e) ? a(e, t) : void 0), (t => [t[e],
    [0, 131072], onprogress
]), ((e, o) => e[t] = o)), "read-image-head"], Aa = ({
    srcProp: e = "head",
    destProp: t = "orientation"
} = {}) => [ka(o, (t => [t[e], 274]), ((e, o = 1) => e[t] = o)), "read-exif-orientation-tag"], Ia = ({
    srcProp: e = "head"
} = {}) => [ka(o, (t => [t[e], 274, 1])), "clear-exif-orientation-tag"], Ea = ({
    srcImageSize: e = "size",
    srcCanvasSize: t = "imageData",
    srcImageState: o = "imageState",
    destImageSize: i = "size",
    destScalar: n = "scalar"
} = {}) => [ka(((e, t) => [Math.min(t.width / e.width, t.height / e.height), fe(t)]), (i => [i[e], i[t], i[o]]), ((e, [t, o]) => {
    e[n] = t, e[i] = o
})), "calculate-canvas-scalar"], La = ({
    srcProp: e = "src",
    destProp: t = "imageData",
    canvasMemoryLimit: o
}) => [ka(A, (t => [t[e], o]), ((e, o) => e[t] = o)), "blob-to-image-data"], Fa = ({
    srcImageData: e = "imageData",
    srcOrientation: t = "orientation"
} = {}) => [ka(y, (o => [o[e], o[t]]), ((e, t) => e.imageData = t)), "image-data-match-orientation"], za = ({
    srcImageData: e = "imageData",
    srcImageState: t = "imageState"
} = {}) => [ka(qi, (o => [o[e], {
    backgroundColor: o[t].backgroundColor
}]), ((e, t) => e.imageData = t)), "image-data-fill"], Ba = ({
    srcImageData: e = "imageData",
    srcImageState: t = "imageState",
    destScalar: o = "scalar"
} = {}) => [ka(Wt, (i => {
    const n = i[o];
    let {
        crop: r
    } = i[t];
    return r && 1 !== n && (r = He(Ee(r), n, X())), [i[e], {
        crop: r,
        rotation: i[t].rotation,
        flipX: i[t].flipX,
        flipY: i[t].flipY
    }]
}), ((e, t) => e.imageData = t)), "image-data-crop"], Da = ({
    targetSize: e = {
        width: void 0,
        height: void 0,
        fit: void 0,
        upscale: void 0
    },
    imageDataResizer: t,
    srcProp: o = "imageData",
    srcImageState: i = "imageState",
    destImageScaledSize: n = "imageScaledSize"
}) => [ka(Nt, (n => {
    const r = Math.min(e.width || Number.MAX_SAFE_INTEGER, n[i].targetSize && n[i].targetSize.width || Number.MAX_SAFE_INTEGER),
        a = Math.min(e.height || Number.MAX_SAFE_INTEGER, n[i].targetSize && n[i].targetSize.height || Number.MAX_SAFE_INTEGER);
    return [n[o], {
        width: r,
        height: a,
        fit: e.fit || "contain",
        upscale: (s = n[i], !!(s.targetSize && s.targetSize.width || s.targetSize && s.targetSize.height) || (e.upscale || !1))
    }, t];
    var s
}), ((e, t) => {
    ve(e.imageData, t) || (e[n] = fe(t)), e.imageData = t
})), "image-data-resize"], Oa = ({
    srcImageData: e = "imageData",
    srcImageState: t = "imageState",
    destImageData: o = "imageData"
} = {}) => [ka(qt, (o => {
    const {
        colorMatrix: i
    } = o[t], n = i && Object.keys(i).map((e => i[e])).filter(Boolean);
    return [o[e], {
        colorMatrix: n && Zi(n),
        convolutionMatrix: o[t].convolutionMatrix,
        gamma: o[t].gamma,
        noise: o[t].noise,
        vignette: o[t].vignette
    }]
}), ((e, t) => e[o] = t)), "image-data-filter"], _a = ({
    srcImageData: e = "imageData",
    srcImageState: t = "imageState",
    destImageData: o = "imageData",
    destScalar: i = "scalar"
} = {}) => [ka((async (e, t, o, i, n) => {
    if (!t) return e;
    let r;
    try {
        const n = {
            dataSizeScalar: Ki(e, i)
        };
        o && o[3] > 0 && (n.backgroundColor = [...o]), r = await t(e, n)
    } catch (e) {}
    const a = p("canvas");
    a.width = e.width, a.height = e.height;
    const s = a.getContext("2d");
    s.putImageData(e, 0, 0);
    const l = new Path2D;
    i.forEach((e => {
        const t = _e(e.x, e.y, e.width, e.height);
        Ne(t, n);
        const o = qe(Ee(t), e.rotation),
            i = new Path2D;
        o.forEach(((e, t) => {
            if (0 === t) return i.moveTo(e.x, e.y);
            i.lineTo(e.x, e.y)
        })), l.addPath(i)
    })), s.clip(l, "nonzero"), s.imageSmoothingEnabled = !1, s.drawImage(r, 0, 0, a.width, a.height), g(r);
    const c = s.getImageData(0, 0, a.width, a.height);
    return g(a), c
}), ((o, {
    imageScrambler: n
}) => [o[e], n, o[t].backgroundColor, o[t].redaction, o[i]]), ((e, t) => e[o] = t)), "image-data-redact"], Wa = ({
    srcImageData: e = "imageData",
    srcSize: t = "size",
    srcImageState: o = "imageState",
    destImageData: i = "imageData",
    destImageScaledSize: n = "imageScaledSize",
    destScalar: r = "scalar",
    imageDataResizer: a,
    canvasMemoryLimit: s
} = {}) => [ka(Gi, ((i, {
    shapePreprocessor: l,
    willRequestResource: c
}) => {
    const {
        annotation: d
    } = i[o];
    if (!d.length) return [i[e]];
    const u = i[r],
        {
            crop: h
        } = i[o],
        p = i[t];
    let m = u;
    const g = i[n];
    g && (m = Math.min(g.width / h.width, g.height / h.height));
    const f = {
        width: p.width / u,
        height: p.height / u
    };
    return [i[e], {
        shapes: d,
        computeShape: e => (e = wi(e, f), e = Sa(e, ["left", "right", "top", "bottom"]), e = Ai(e, m)),
        transform: e => {
            const a = i[t],
                {
                    rotation: s = 0,
                    flipX: l,
                    flipY: c
                } = i[o],
                d = i[r],
                {
                    crop: u = Fe(a)
                } = i[o],
                h = i[n],
                p = h ? Math.min(h.width / u.width, h.height / u.height) : 1,
                m = {
                    width: a.width / d * p,
                    height: a.height / d * p
                },
                g = ((e, t) => {
                    const o = Fe(e),
                        i = We(o),
                        n = qe(o, t, i);
                    return nt(Be(n))
                })(m, s),
                f = g.width,
                $ = g.height,
                y = .5 * m.width - .5 * f,
                x = .5 * m.height - .5 * $,
                b = Se(m);
            e.translate(-y, -x), e.translate(-u.x * p, -u.y * p), e.translate(b.x, b.y), e.rotate(s), e.translate(-b.x, -b.y), e.scale(l ? -1 : 1, c ? -1 : 1), e.translate(l ? -m.width : 0, c ? -m.height : 0), e.rect(0, 0, m.width, m.height), e.clip()
        },
        drawImage: Ca({
            imageDataResizer: a,
            canvasMemoryLimit: s
        }),
        preprocessShape: e => l(e, {
            isPreview: !1
        }),
        canvasMemoryLimit: s,
        willRequestResource: c
    }]
}), ((e, t) => e[i] = t)), "image-data-annotate"], Va = ({
    srcImageData: e = "imageData",
    srcImageState: t = "imageState",
    destImageData: o = "imageData",
    destImageScaledSize: i = "imageScaledSize",
    imageDataResizer: n,
    canvasMemoryLimit: r,
    destScalar: a = "scalar"
} = {}) => [ka(Gi, ((o, {
    shapePreprocessor: s,
    willRequestResource: l
}) => {
    const {
        decoration: c
    } = o[t];
    if (!c.length) return [o[e]];
    let d = o[a];
    const {
        crop: u
    } = o[t], h = o[i];
    if (h) {
        const e = Math.min(h.width / u.width, h.height / u.height);
        d = e
    }
    return [o[e], {
        shapes: c,
        drawImage: Ca({
            imageDataResizer: n,
            canvasMemoryLimit: r
        }),
        computeShape: e => (e = wi(e, u), e = Sa(e, ["left", "right", "top", "bottom"]), e = Ai(e, d)),
        preprocessShape: e => s(e, {
            isPreview: !1
        }),
        canvasMemoryLimit: r,
        willRequestResource: l
    }]
}), ((e, t) => e[o] = t)), "image-data-decorate"], Ha = ({
    srcImageData: e = "imageData",
    srcImageState: t = "imageState",
    destImageData: o = "imageData",
    destImageScaledSize: i = "imageScaledSize",
    imageDataResizer: n,
    canvasMemoryLimit: r,
    destScalar: a = "scalar"
} = {}) => [ka(Gi, ((o, {
    shapePreprocessor: s,
    willRequestResource: l
}) => {
    const c = o[t].frame;
    if (!c) return [o[e]];
    const d = o[a];
    let {
        crop: u
    } = o[t];
    u && 1 !== d && (u = He(Ee(u), d, X()));
    const h = {
            ...u
        },
        p = Ti(Ri(c, h, s), h);
    h.x = Math.abs(p.left), h.y = Math.abs(p.top), h.width += Math.abs(p.left) + Math.abs(p.right), h.height += Math.abs(p.top) + Math.abs(p.bottom);
    const m = o[i],
        g = m ? Math.min(m.width / u.width, m.height / u.height) : 1;
    return Ne(h, g), h.x = Math.floor(h.x), h.y = Math.floor(h.y), h.width = Math.floor(h.width), h.height = Math.floor(h.height), [o[e], {
        shapes: [c],
        contextBounds: h,
        computeShape: t => wi(t, o[e]),
        transform: e => {
            e.translate(h.x, h.y)
        },
        drawImage: Ca({
            imageDataResizer: n,
            canvasMemoryLimit: r
        }),
        preprocessShape: e => s(e, {
            isPreview: !1
        }),
        canvasMemoryLimit: r,
        willRequestResource: l
    }]
}), ((e, t) => e[o] = t)), "image-data-frame"], Na = ({
    mimeType: e,
    quality: t,
    srcImageData: o = "imageData",
    srcFile: i = "src",
    destBlob: n = "blob"
} = {}) => [ka(E, (n => [n[o], e || B(n[i].name) || n[i].type, t]), ((e, t) => e[n] = t)), "image-data-to-blob"], Ua = ({
    srcImageData: e = "imageData",
    srcOrientation: t = "orientation",
    destCanvas: o = "dest"
} = {}) => [ka($, (o => [o[e], o[t]]), ((e, t) => e[o] = t)), "image-data-to-canvas"], ja = async (e, o) => {
    if (!Dt(e) || !o) return e;
    const i = new DataView(o),
        n = t(i);
    if (!n || !n.exif) return e;
    const {
        exif: r
    } = n;
    return ((e, t, o = [0, e.size]) => t ? new Blob([t, e.slice(...o)], {
        type: e.type
    }) : e)(e, o.slice(0, r.offset + r.size + 2), [20])
}, Xa = (e = "blob", t = "head", o = "blob") => [ka(ja, (o => [o[e], o[t]]), ((e, t) => e[o] = t)), "blob-write-image-head"], Ya = ({
    renameFile: e,
    srcBlob: t = "blob",
    srcFile: o = "src",
    destFile: i = "dest",
    defaultFilename: n
} = {}) => [ka(D, (i => [i[t], e ? e(i[o]) : i[o].name || `${n}.${L(i[t].type)}`]), ((e, t) => e[i] = t)), "blob-to-file"], Ga = ({
    url: e = "./",
    dataset: t = (e => [
        ["dest", e.dest, e.dest.name],
        ["imageState", e.imageState]
    ]),
    destStore: o = "store"
}) => [ka((async (t, o) => await ((e, t, o) => new Promise(((i, r) => {
    const {
        token: a = {},
        beforeSend: s = n,
        onprogress: l = n
    } = o;
    a.cancel = () => c.abort();
    const c = new XMLHttpRequest;
    c.upload.onprogress = l, c.onload = () => c.status >= 200 && c.status < 300 ? i(c) : r(c), c.onerror = () => r(c), c.ontimeout = () => r(c), c.open("POST", encodeURI(e)), s(c), c.send(t.reduce(((e, t) => (e.append(...t.map(Ot)), e)), new FormData))
})))(e, t, {
    onprogress: o
})), ((e, o, i) => [t(e), i]), ((e, t) => e[o] = t)), "store"], qa = e => [ka((t => e && e.length ? (Object.keys(t).forEach((o => {
    e.includes(o) || delete t[o]
})), t) : t)), "prop-filter"], Za = (e = {}) => {
    const {
        orientImage: t = !0,
        outputProps: o = ["src", "dest", "size"],
        preprocessImageFile: i
    } = e;
    return [Ma(), i && [ka(i, ((e, t, o) => [e.dest, t, o]), ((e, t) => e.dest = t)), "preprocess-image-file"], Ta({
        srcProp: "dest"
    }), t && Pa({
        srcProp: "dest"
    }), t && Aa(), t && Ra(), qa(o)].filter(Boolean)
}, Ka = (e = {}) => {
    const {
        canvasMemoryLimit: t = wa(),
        orientImage: o = !0,
        copyImageHead: i = !0,
        mimeType: n,
        quality: r,
        renameFile: a,
        targetSize: s,
        imageDataResizer: l,
        store: c,
        format: d = "file",
        outputProps: u = ["src", "dest", "imageState", "store"],
        preprocessImageSource: h,
        preprocessImageState: p,
        postprocessImageData: m,
        postprocessImageBlob: g
    } = e;
    return [h && [ka(h, ((e, t, o) => [e.src, t, o]), ((e, t) => e.src = t)), "preprocess-image-source"], (o || i) && Pa(), o && Aa(), Ta(), p && [ka(p, ((e, t, o) => [e.imageState, t, o]), ((e, t) => e.imageState = t)), "preprocess-image-state"], La({
        canvasMemoryLimit: t
    }), o && Ra(), o && Fa(), Ea(), _a(), Ba(), Da({
        imageDataResizer: l,
        targetSize: s
    }), Oa(), za(), Wa({
        imageDataResizer: l,
        canvasMemoryLimit: t
    }), Va({
        imageDataResizer: l,
        canvasMemoryLimit: t
    }), Ha({
        imageDataResizer: l,
        canvasMemoryLimit: t
    }), m && [ka(m, ((e, t, o) => [e.imageData, t, o]), ((e, t) => e.imageData = t)), "postprocess-image-data"], "file" === d ? Na({
        mimeType: n,
        quality: r
    }) : "canvas" === d ? Ua() : [e => (e.dest = e.imageData, e)], "file" === d && o && Ia(), "file" === d && i && Xa(), g && [ka(g, (({
        blob: e,
        imageData: t,
        src: o
    }, i, n) => [{
        blob: e,
        imageData: t,
        src: o
    }, i, n]), ((e, t) => e.blob = t)), "postprocess-image-file"], "file" === d && Ya({
        defaultFilename: "image",
        renameFile: a
    }), "file" === d ? c && (w(c) ? Ga({
        url: c
    }) : S(c) ? [c, "store"] : Ga(c)) : S(c) && [c, "store"], qa(u)].filter(Boolean)
};
var Ja = (e, t) => {
    const {
        imageData: o,
        amount: i = 1
    } = e, n = Math.round(2 * Math.max(1, i)), r = Math.round(.5 * n), a = o.width, s = o.height, l = new Uint8ClampedArray(a * s * 4), c = o.data;
    let d, u, h, p, m, g = 0,
        f = 0,
        $ = 0;
    const y = a * s * 4 - 4;
    for (h = 0; h < s; h++)
        for (d = crypto.getRandomValues(new Uint8ClampedArray(s)), u = 0; u < a; u++) p = d[h] / 255, f = 0, $ = 0, p < .5 && (f = 4 * (-r + Math.round(Math.random() * n))), p > .5 && ($ = (-r + Math.round(Math.random() * n)) * (4 * a)), m = Math.min(Math.max(0, g + f + $), y), l[g] = c[m], l[g + 1] = c[m + 1], l[g + 2] = c[m + 2], l[g + 3] = c[m + 3], g += 4;
    t(null, {
        data: l,
        width: o.width,
        height: o.height
    })
};
const Qa = [.0625, .125, .0625, .125, .25, .125, .0625, .125, .0625];

function es(e) {
    return Math.sqrt(1 - --e * e)
}

function ts(e) {
    return "[object Date]" === Object.prototype.toString.call(e)
}

function os(e, t) {
    if (e === t || e != e) return () => e;
    const o = typeof e;
    if (o !== typeof t || Array.isArray(e) !== Array.isArray(t)) throw new Error("Cannot interpolate values of different type");
    if (Array.isArray(e)) {
        const o = t.map(((t, o) => os(e[o], t)));
        return e => o.map((t => t(e)))
    }
    if ("object" === o) {
        if (!e || !t) throw new Error("Object cannot be null");
        if (ts(e) && ts(t)) {
            e = e.getTime();
            const o = (t = t.getTime()) - e;
            return t => new Date(e + t * o)
        }
        const o = Object.keys(t),
            i = {};
        return o.forEach((o => {
            i[o] = os(e[o], t[o])
        })), e => {
            const t = {};
            return o.forEach((o => {
                t[o] = i[o](e)
            })), t
        }
    }
    if ("number" === o) {
        const o = t - e;
        return t => e + t * o
    }
    throw new Error(`Cannot interpolate ${o} values`)
}

function is(e, t = {}) {
    const o = Dr(e);
    let i, n = e;

    function r(r, a) {
        if (null == e) return o.set(e = r), Promise.resolve();
        n = r;
        let s = i,
            l = !1,
            {
                delay: c = 0,
                duration: d = 400,
                easing: u = Qi,
                interpolate: h = os
            } = en(en({}, t), a);
        if (0 === d) return s && (s.abort(), s = null), o.set(e = n), Promise.resolve();
        const p = yn() + c;
        let m;
        return i = wn((t => {
            if (t < p) return !0;
            l || (m = h(e, r), "function" == typeof d && (d = d(e, r)), l = !0), s && (s.abort(), s = null);
            const i = t - p;
            return i > d ? (o.set(e = r), !1) : (o.set(e = m(u(i / d))), !0)
        })), i.promise
    }
    return {
        set: r,
        update: (t, o) => r(t(n, e), o),
        subscribe: o.subscribe
    }
}

function ns(e, t, o, i) {
    if ("number" == typeof o) {
        const n = i - o,
            r = (o - t) / (e.dt || 1 / 60),
            a = (r + (e.opts.stiffness * n - e.opts.damping * r) * e.inv_mass) * e.dt;
        return Math.abs(a) < e.opts.precision && Math.abs(n) < e.opts.precision ? i : (e.settled = !1, o + a)
    }
    if (Qt(o)) return o.map(((n, r) => ns(e, t[r], o[r], i[r])));
    if ("object" == typeof o) {
        const n = {};
        for (const r in o) n[r] = ns(e, t[r], o[r], i[r]);
        return n
    }
    throw new Error(`Cannot spring ${typeof o} values`)
}

function rs(e, t = {}) {
    const o = Dr(e),
        {
            stiffness: i = .15,
            damping: n = .8,
            precision: r = .01
        } = t;
    let a, s, l, c = e,
        d = e,
        u = 1,
        h = 0,
        p = !1;

    function m(t, i = {}) {
        d = t;
        const n = l = {};
        if (null == e || i.hard || g.stiffness >= 1 && g.damping >= 1) return p = !0, a = null, c = t, o.set(e = d), Promise.resolve();
        if (i.soft) {
            const e = !0 === i.soft ? .5 : +i.soft;
            h = 1 / (60 * e), u = 0
        }
        if (!s) {
            a = null, p = !1;
            const t = {
                inv_mass: void 0,
                opts: g,
                settled: !0,
                dt: void 0
            };
            s = wn((i => {
                if (null === a && (a = i), p) return p = !1, s = null, !1;
                u = Math.min(u + h, 1), t.inv_mass = u, t.opts = g, t.settled = !0, t.dt = 60 * (i - a) / 1e3;
                const n = ns(t, c, e, d);
                return a = i, c = e, o.set(e = n), t.settled && (s = null), !t.settled
            }))
        }
        return new Promise((e => {
            s.promise.then((() => {
                n === l && e()
            }))
        }))
    }
    const g = {
        set: m,
        update: (t, o) => m(t(d, e), o),
        subscribe: o.subscribe,
        stiffness: i,
        damping: n,
        precision: r
    };
    return g
}
var as = Br(!1, (e => {
    const t = window.matchMedia("(prefers-reduced-motion:reduce)");
    e(t.matches), t.onchange = () => e(t.matches)
}));
const ss = Le(),
    ls = (e, t, o, i, n) => {
        e.rect || (e.rect = Le());
        const r = e.rect;
        Ye(ss, t, o, i, n), je(r, ss) || (Ge(r, ss), e.dispatchEvent(new CustomEvent("measure", {
            detail: r
        })))
    },
    cs = Math.round,
    ds = e => {
        const t = e.getBoundingClientRect();
        ls(e, cs(t.x), cs(t.y), cs(t.width), cs(t.height))
    },
    us = e => ls(e, e.offsetLeft, e.offsetTop, e.offsetWidth, e.offsetHeight),
    hs = [];
let ps, ms = null;

function gs() {
    hs.length ? (hs.forEach((e => e.measure(e))), ms = requestAnimationFrame(gs)) : ms = null
}
let fs = 0;
var $s = (e, t = {}) => {
        const {
            observePosition: o = !1,
            observeViewRect: i = !1,
            once: n = !1,
            disabled: r = !1
        } = t;
        if (!r) return !("ResizeObserver" in window) || o || i ? (e.measure = i ? ds : us, hs.push(e), ms || (ms = requestAnimationFrame(gs)), e.measure(e), {
            destroy() {
                const t = hs.indexOf(e);
                hs.splice(t, 1), delete e.measure
            }
        }) : (ps || (ps = new ResizeObserver((e => {
            e.forEach((e => us(e.target)))
        }))), ps.observe(e), us(e), n ? ps.unobserve(e) : fs++, {
            destroy() {
                n || (ps.unobserve(e), fs--, 0 === fs && (ps.disconnect(), ps = void 0))
            }
        })
    },
    ys = e => {
        let t = !1;
        const o = {
            pointerdown: () => {
                t = !1
            },
            keydown: () => {
                t = !0
            },
            keyup: () => {
                t = !1
            },
            focus: e => {
                t && (e.target.dataset.focusVisible = "")
            },
            blur: e => {
                delete e.target.dataset.focusVisible
            }
        };
        return Object.keys(o).forEach((t => e.addEventListener(t, o[t], !0))), {
            destroy() {
                Object.keys(o).forEach((t => e.removeEventListener(t, o[t], !0)))
            }
        }
    };
const xs = async e => new Promise((t => {
    if ("file" === e.kind) return t(e.getAsFile());
    e.getAsString(t)
}));
var bs = (e, t = {}) => {
    const o = e => {
            e.preventDefault()
        },
        i = async o => {
            o.preventDefault(), o.stopPropagation();
            try {
                const i = await (e => new Promise(((t, o) => {
                    const {
                        items: i
                    } = e.dataTransfer;
                    if (!i) return t([]);
                    Promise.all(Array.from(i).map(xs)).then((e => {
                        t(e.filter((e => ro(e) && Ct(e) || /^http/.test(e))))
                    })).catch(o)
                })))(o);
                e.dispatchEvent(new CustomEvent("dropfiles", {
                    detail: {
                        event: o,
                        resources: i
                    },
                    ...t
                }))
            } catch (e) {}
        };
    return e.addEventListener("drop", i), e.addEventListener("dragover", o), {
        destroy() {
            e.removeEventListener("drop", i), e.removeEventListener("dragover", o)
        }
    }
};
let vs = null;
var ws = () => {
        if (null === vs)
            if ("WebGL2RenderingContext" in window) {
                let e;
                try {
                    e = p("canvas"), vs = !!e.getContext("webgl2")
                } catch (e) {
                    vs = !1
                }
                e && g(e), e = void 0
            } else vs = !1;
        return vs
    },
    Ss = (e, t) => ws() ? e.getContext("webgl2", t) : e.getContext("webgl", t) || e.getContext("experimental-webgl", t);
let Cs = null;
var ks = () => {
        if (null === Cs)
            if (c()) {
                const e = p("canvas");
                Cs = !Ss(e, {
                    failIfMajorPerformanceCaveat: !0
                }), g(e)
            } else Cs = !1;
        return Cs
    },
    Ms = e => 0 == (e & e - 1),
    Ts = (e, t = {}, o = "", i = "") => Object.keys(t).filter((e => !x(t[e]))).reduce(((e, n) => e.replace(new RegExp(o + n + i), t[n])), e);
const Rs = {
        head: "#version 300 es\n\nin vec4 aPosition;uniform mat4 uMatrix;",
        text: "\nin vec2 aTexCoord;out vec2 vTexCoord;",
        matrix: "\ngl_Position=uMatrix*vec4(aPosition.x,aPosition.y,0,1);"
    },
    Ps = {
        head: "#version 300 es\nprecision highp float;\n\nout vec4 fragColor;",
        mask: "\nuniform float uMaskFeather[8];uniform float uMaskBounds[4];uniform float uMaskOpacity;float mask(float x,float y,float bounds[4],float opacity){return 1.0-(1.0-(smoothstep(bounds[3],bounds[3]+1.0,x)*(1.0-smoothstep(bounds[1]-1.0,bounds[1],x))*(1.0-step(bounds[0],y))*step(bounds[2],y)))*(1.0-opacity);}",
        init: "\nfloat a=1.0;vec4 fillColor=uColor;vec4 textureColor=texture(uTexture,vTexCoord);textureColor*=(1.0-step(1.0,vTexCoord.y))*step(0.0,vTexCoord.y)*(1.0-step(1.0,vTexCoord.x))*step(0.0,vTexCoord.x);",
        colorize: "\nif(uTextureColor.a!=0.0&&textureColor.a>0.0){vec3 colorFlattened=textureColor.rgb/textureColor.a;if(colorFlattened.r>=.9999&&colorFlattened.g==0.0&&colorFlattened.b>=.9999){textureColor.rgb=uTextureColor.rgb*textureColor.a;}textureColor*=uTextureColor.a;}",
        maskapply: "\nfloat m=mask(gl_FragCoord.x,gl_FragCoord.y,uMaskBounds,uMaskOpacity);",
        maskfeatherapply: "\nfloat leftFeatherOpacity=step(uMaskFeather[1],gl_FragCoord.x)*uMaskFeather[0]+((1.0-uMaskFeather[0])*smoothstep(uMaskFeather[1],uMaskFeather[3],gl_FragCoord.x));float rightFeatherOpacity=(1.0-step(uMaskFeather[7],gl_FragCoord.x))*uMaskFeather[4]+((1.0-uMaskFeather[4])*smoothstep(uMaskFeather[7],uMaskFeather[5],gl_FragCoord.x));a*=leftFeatherOpacity*rightFeatherOpacity;",
        edgeaa: "\nvec2 scaledPoint=vec2(vRectCoord.x*uSize.x,vRectCoord.y*uSize.y);a*=smoothstep(0.0,1.0,uSize.x-scaledPoint.x);a*=smoothstep(0.0,1.0,uSize.y-scaledPoint.y);a*=smoothstep(0.0,1.0,scaledPoint.x);a*=smoothstep(0.0,1.0,scaledPoint.y);",
        cornerradius: "\nvec2 s=(uSize-2.0)*.5;vec2 r=(vRectCoord*uSize);vec2 p=r-(uSize*.5);float cornerRadius=uCornerRadius[0];bool left=r.x<s.x;bool top=r.y<s.x;if(!left&&top){cornerRadius=uCornerRadius[1];}if(!left&&!top){cornerRadius=uCornerRadius[3];}if(left&&!top){cornerRadius=uCornerRadius[2];}a*=1.0-clamp(length(max(abs(p)-(s-cornerRadius),0.0))-cornerRadius,0.0,1.0);",
        fragcolor: "\nif(m<=0.0)discard;fillColor.a*=a;fillColor.rgb*=fillColor.a;fillColor.rgb*=m;fillColor.rgb+=(1.0-m)*(uCanvasColor.rgb*fillColor.a);textureColor*=uTextureOpacity;textureColor.a*=a;textureColor.rgb*=m*a;textureColor.rgb+=(1.0-m)*(uCanvasColor.rgb*textureColor.a);fragColor=textureColor+(fillColor*(1.0-textureColor.a));"
    },
    As = (e, t, o) => {
        const i = e.createShader(o),
            n = ((e, t, o) => (t = Ts(t, o === e.VERTEX_SHADER ? Rs : Ps, "##").trim(), ws() ? t : (t = (t = t.replace(/#version.+/gm, "").trim()).replace(/^\/\/\#/gm, "#"), o === e.VERTEX_SHADER && (t = t.replace(/in /gm, "attribute ").replace(/out /g, "varying ")), o === e.FRAGMENT_SHADER && (t = t.replace(/in /gm, "varying ").replace(/out.*?;/gm, "").replace(/texture\(/g, "texture2D(").replace(/fragColor/g, "gl_FragColor")), "" + t)))(e, t, o);
        return e.shaderSource(i, n), e.compileShader(i), e.getShaderParameter(i, e.COMPILE_STATUS) || console.error(e.getShaderInfoLog(i)), i
    },
    Is = (e, t, o, i, n) => {
        const r = As(e, t, e.VERTEX_SHADER),
            a = As(e, o, e.FRAGMENT_SHADER),
            s = e.createProgram();
        e.attachShader(s, r), e.attachShader(s, a), e.linkProgram(s);
        const l = {};
        return i.forEach((t => {
            l[t] = e.getAttribLocation(s, t)
        })), n.forEach((t => {
            l[t] = e.getUniformLocation(s, t)
        })), {
            program: s,
            locations: l,
            destroy() {
                e.detachShader(s, r), e.detachShader(s, a), e.deleteShader(r), e.deleteShader(a), e.deleteProgram(s)
            }
        }
    },
    Es = e => !!ws() || Ms(e.width) && Ms(e.height),
    Ls = (e, t, o, i) => (e.bindTexture(e.TEXTURE_2D, t), e.texImage2D(e.TEXTURE_2D, 0, e.RGBA, e.RGBA, e.UNSIGNED_BYTE, o), ((e, t, o) => {
        e.texParameteri(e.TEXTURE_2D, e.TEXTURE_MIN_FILTER, Es(t) ? e.LINEAR_MIPMAP_LINEAR : e.LINEAR), e.texParameteri(e.TEXTURE_2D, e.TEXTURE_MAG_FILTER, o.filter), e.texParameteri(e.TEXTURE_2D, e.TEXTURE_WRAP_S, e.CLAMP_TO_EDGE), e.texParameteri(e.TEXTURE_2D, e.TEXTURE_WRAP_T, e.CLAMP_TO_EDGE), Es(t) && e.generateMipmap(e.TEXTURE_2D)
    })(e, o, i), e.bindTexture(e.TEXTURE_2D, null), t),
    Fs = (e, t = 1) => e ? [e[0], e[1], e[2], Zt(e[3]) ? t * e[3] : t] : [0, 0, 0, 0],
    zs = () => {
        const e = new Float32Array(16);
        return e[0] = 1, e[5] = 1, e[10] = 1, e[15] = 1, e
    },
    Bs = (e, t, o, i, n, r, a) => {
        const s = 1 / (t - o),
            l = 1 / (i - n),
            c = 1 / (r - a);
        e[0] = -2 * s, e[1] = 0, e[2] = 0, e[3] = 0, e[4] = 0, e[5] = -2 * l, e[6] = 0, e[7] = 0, e[8] = 0, e[9] = 0, e[10] = 2 * c, e[11] = 0, e[12] = (t + o) * s, e[13] = (n + i) * l, e[14] = (a + r) * c, e[15] = 1
    },
    Ds = (e, t, o, i) => {
        e[12] = e[0] * t + e[4] * o + e[8] * i + e[12], e[13] = e[1] * t + e[5] * o + e[9] * i + e[13], e[14] = e[2] * t + e[6] * o + e[10] * i + e[14], e[15] = e[3] * t + e[7] * o + e[11] * i + e[15]
    },
    Os = (e, t) => {
        e[0] *= t, e[1] *= t, e[2] *= t, e[3] *= t, e[4] *= t, e[5] *= t, e[6] *= t, e[7] *= t, e[8] *= t, e[9] *= t, e[10] *= t, e[11] *= t
    },
    _s = (e, t) => {
        const o = Math.sin(t),
            i = Math.cos(t),
            n = e[4],
            r = e[5],
            a = e[6],
            s = e[7],
            l = e[8],
            c = e[9],
            d = e[10],
            u = e[11];
        e[4] = n * i + l * o, e[5] = r * i + c * o, e[6] = a * i + d * o, e[7] = s * i + u * o, e[8] = l * i - n * o, e[9] = c * i - r * o, e[10] = d * i - a * o, e[11] = u * i - s * o
    },
    Ws = (e, t) => {
        const o = Math.sin(t),
            i = Math.cos(t),
            n = e[0],
            r = e[1],
            a = e[2],
            s = e[3],
            l = e[8],
            c = e[9],
            d = e[10],
            u = e[11];
        e[0] = n * i - l * o, e[1] = r * i - c * o, e[2] = a * i - d * o, e[3] = s * i - u * o, e[8] = n * o + l * i, e[9] = r * o + c * i, e[10] = a * o + d * i, e[11] = s * o + u * i
    },
    Vs = (e, t) => {
        const o = Math.sin(t),
            i = Math.cos(t),
            n = e[0],
            r = e[1],
            a = e[2],
            s = e[3],
            l = e[4],
            c = e[5],
            d = e[6],
            u = e[7];
        e[0] = n * i + l * o, e[1] = r * i + c * o, e[2] = a * i + d * o, e[3] = s * i + u * o, e[4] = l * i - n * o, e[5] = c * i - r * o, e[6] = d * i - a * o, e[7] = u * i - s * o
    };
var Hs = e => e * Math.PI / 180;
const Ns = (e, t, o, i, n) => {
        const r = ee(Y(i.x - o.x, i.y - o.y)),
            a = ee(Y(n.x - i.x, n.y - i.y)),
            s = ee(Y(r.x + a.x, r.y + a.y)),
            l = Y(-s.y, s.x),
            c = Y(-r.y, r.x),
            d = Math.min(1 / se(l, c), 5);
        e[t] = i.x, e[t + 1] = i.y, e[t + 2] = l.x * d, e[t + 3] = l.y * d, e[t + 4] = -1, e[t + 5] = i.x, e[t + 6] = i.y, e[t + 7] = l.x * d, e[t + 8] = l.y * d, e[t + 9] = 1
    },
    Us = e => {
        const t = new Float32Array(8);
        return t[0] = e[3].x, t[1] = e[3].y, t[2] = e[0].x, t[3] = e[0].y, t[4] = e[2].x, t[5] = e[2].y, t[6] = e[1].x, t[7] = e[1].y, t
    },
    js = (e, t = 0, o, i) => {
        const n = tt(e),
            r = e.x + .5 * e.width,
            a = e.y + .5 * e.height;
        return (o || i) && he(n, o, i, r, a), 0 !== t && pe(n, t, r, a), n
    },
    Xs = (e, t, o, i, n) => {
        const r = Math.min(20, Math.max(4, Math.round(i / 2)));
        let a = 0,
            s = 0,
            l = 0,
            c = 0,
            d = 0;
        for (; d < r; d++) a = d / r, s = n * V + a * V, l = i * Math.cos(s), c = i * Math.sin(s), e.push(Y(t + l, o + c))
    };
let Ys = null;
var Gs = () => {
    if (null !== Ys) return Ys;
    let e = p("canvas");
    const t = Ss(e);
    return Ys = t ? t.getParameter(t.MAX_TEXTURE_SIZE) : void 0, g(e), e = void 0, Ys
};
let qs = null;
const Zs = new Float32Array([0, 1, 0, 0, 1, 1, 1, 0]),
    Ks = [0, 0, 0, 0, 1, 0, 0, 0, 0],
    Js = [1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0],
    Qs = [0, 0, 0, 0],
    el = [0, 0, 0, 0],
    tl = (e, t, o, i, n) => {
        if (!o || !i) return Zs;
        const r = i.x / o.width,
            a = i.y / o.height;
        let s = e / o.width / n,
            l = t / o.height / n;
        s -= r, l -= a;
        return new Float32Array([-r, l, -r, -a, s, l, s, -a])
    };
var ol = e => {
    const t = {
            width: 0,
            height: 0
        },
        o = {
            width: 0,
            height: 0
        },
        i = Gs() || 1024;
    let n, r;
    const a = zs(),
        s = zs();
    let l, c, d, u, h, p, m, f, $, y = 0,
        x = 0,
        b = 0;
    const v = new Map([]),
        w = () => {
            k.stencilOp(k.KEEP, k.KEEP, k.KEEP), k.stencilFunc(k.ALWAYS, 1, 255), k.stencilMask(255)
        },
        S = Hs(30),
        C = Math.tan(S / 2),
        k = Ss(e, {
            antialias: !1,
            alpha: !1,
            premultipliedAlpha: !0,
            stencil: !0
        });
    if (!k) return;
    k.getExtension("OES_standard_derivatives"), k.disable(k.DEPTH_TEST), k.enable(k.STENCIL_TEST), k.enable(k.BLEND), k.blendFunc(k.ONE, k.ONE_MINUS_SRC_ALPHA), k.pixelStorei(k.UNPACK_PREMULTIPLY_ALPHA_WEBGL, (null === qs && (qs = Lt(/Firefox/)), !qs)), w();
    const M = k.createTexture();
    k.bindTexture(k.TEXTURE_2D, M), k.texImage2D(k.TEXTURE_2D, 0, k.RGBA, 1, 1, 0, k.RGBA, k.UNSIGNED_BYTE, new Uint8Array(Qs)), v.set(0, M);
    const T = k.createTexture();
    v.set(2, T);
    const R = k.createFramebuffer(),
        P = k.createTexture();
    v.set(1, P);
    const A = k.createFramebuffer(),
        I = Is(k, "\n##head\n##text\nvoid main(){vTexCoord=aTexCoord;gl_Position=uMatrix*aPosition;}", "\n##head\nin vec2 vTexCoord;uniform sampler2D uTexture;uniform sampler2D uTextureOverlay;uniform sampler2D uTextureBlend;uniform vec2 uTextureSize;uniform float uOpacity;uniform vec4 uFillColor;uniform vec4 uOverlayColor;uniform mat4 uColorMatrix;uniform vec4 uColorOffset;uniform float uClarityKernel[9];uniform float uClarityKernelWeight;uniform float uColorGamma;uniform float uColorVignette;uniform float uMaskClip;uniform float uMaskOpacity;uniform float uMaskBounds[4];uniform float uMaskCornerRadius[4];uniform float uMaskFeather[8];vec4 applyGamma(vec4 c,float g){c.r=pow(c.r,g);c.g=pow(c.g,g);c.b=pow(c.b,g);return c;}vec4 applyColorMatrix(vec4 c,mat4 m,vec4 o){vec4 cM=(c*m)+o;cM*=cM.a;return cM;}vec4 applyConvolutionMatrix(vec4 c,float k0,float k1,float k2,float k3,float k4,float k5,float k6,float k7,float k8,float w){vec2 pixel=vec2(1)/uTextureSize;vec4 colorSum=texture(uTexture,vTexCoord-pixel)*k0+texture(uTexture,vTexCoord+pixel*vec2(0.0,-1.0))*k1+texture(uTexture,vTexCoord+pixel*vec2(1.0,-1.0))*k2+texture(uTexture,vTexCoord+pixel*vec2(-1.0,0.0))*k3+texture(uTexture,vTexCoord)*k4+texture(uTexture,vTexCoord+pixel*vec2(1.0,0.0))*k5+texture(uTexture,vTexCoord+pixel*vec2(-1.0,1.0))*k6+texture(uTexture,vTexCoord+pixel*vec2(0.0,1.0))*k7+texture(uTexture,vTexCoord+pixel)*k8;vec4 color=vec4((colorSum/w).rgb,c.a);color.rgb=clamp(color.rgb,0.0,1.0);return color;}vec4 applyVignette(vec4 c,vec2 pos,vec2 center,float v){float d=distance(pos,center)/length(center);float f=1.0-(d*abs(v));if(v>0.0){c.rgb*=f;}else if(v<0.0){c.rgb+=(1.0-f)*(1.0-c.rgb);}return c;}vec4 blendPremultipliedAlpha(vec4 back,vec4 front){return front+(back*(1.0-front.a));}void main(){float x=gl_FragCoord.x;float y=gl_FragCoord.y;float a=1.0;float maskTop=uMaskBounds[0];float maskRight=uMaskBounds[1];float maskBottom=uMaskBounds[2];float maskLeft=uMaskBounds[3];float leftFeatherOpacity=step(uMaskFeather[1],x)*uMaskFeather[0]+((1.0-uMaskFeather[0])*smoothstep(uMaskFeather[1],uMaskFeather[3],x));float rightFeatherOpacity=(1.0-step(uMaskFeather[7],x))*uMaskFeather[4]+((1.0-uMaskFeather[4])*smoothstep(uMaskFeather[7],uMaskFeather[5],x));a*=leftFeatherOpacity*rightFeatherOpacity;float overlayColorAlpha=(smoothstep(maskLeft,maskLeft+1.0,x)*(1.0-smoothstep(maskRight-1.0,maskRight,x))*(1.0-step(maskTop,y))*step(maskBottom,y));if(uOverlayColor.a==0.0){a*=overlayColorAlpha;}vec2 offset=vec2(maskLeft,maskBottom);vec2 size=vec2(maskRight-maskLeft,maskTop-maskBottom)*.5;vec2 center=offset.xy+size.xy;int pixelX=int(step(center.x,x));int pixelY=int(step(y,center.y));float cornerRadius=0.0;if(pixelX==0&&pixelY==0)cornerRadius=uMaskCornerRadius[0];if(pixelX==1&&pixelY==0)cornerRadius=uMaskCornerRadius[1];if(pixelX==0&&pixelY==1)cornerRadius=uMaskCornerRadius[2];if(pixelX==1&&pixelY==1)cornerRadius=uMaskCornerRadius[3];float cornerOffset=sign(cornerRadius)*length(max(abs(gl_FragCoord.xy-size-offset)-size+cornerRadius,0.0))-cornerRadius;float cornerOpacity=1.0-smoothstep(0.0,1.0,cornerOffset);a*=cornerOpacity;vec2 scaledPoint=vec2(vTexCoord.x*uTextureSize.x,vTexCoord.y*uTextureSize.y);a*=smoothstep(0.0,1.0,uTextureSize.x-scaledPoint.x);a*=smoothstep(0.0,1.0,uTextureSize.y-scaledPoint.y);a*=smoothstep(0.0,1.0,scaledPoint.x);a*=smoothstep(0.0,1.0,scaledPoint.y);vec4 color=texture(uTexture,vTexCoord);color=blendPremultipliedAlpha(color,texture(uTextureBlend,vTexCoord));if(uClarityKernelWeight!=-1.0){color=applyConvolutionMatrix(color,uClarityKernel[0],uClarityKernel[1],uClarityKernel[2],uClarityKernel[3],uClarityKernel[4],uClarityKernel[5],uClarityKernel[6],uClarityKernel[7],uClarityKernel[8],uClarityKernelWeight);}color=applyGamma(color,uColorGamma);color=applyColorMatrix(color,uColorMatrix,uColorOffset);color=blendPremultipliedAlpha(uFillColor,color);color*=a;if(uColorVignette!=0.0){vec2 pos=gl_FragCoord.xy-offset;color=applyVignette(color,pos,center-offset,uColorVignette);}color=blendPremultipliedAlpha(color,texture(uTextureOverlay,vTexCoord));vec4 overlayColor=uOverlayColor*(1.0-overlayColorAlpha);overlayColor.rgb*=overlayColor.a;color=blendPremultipliedAlpha(color,overlayColor);if(uOverlayColor.a>0.0&&color.a<1.0&&uFillColor.a>0.0){color=blendPremultipliedAlpha(uFillColor,overlayColor);}color*=uOpacity;fragColor=color;}", ["aPosition", "aTexCoord"], ["uMatrix", "uTexture", "uTextureBlend", "uTextureOverlay", "uTextureSize", "uColorGamma", "uColorVignette", "uColorOffset", "uColorMatrix", "uClarityKernel", "uClarityKernelWeight", "uOpacity", "uMaskOpacity", "uMaskBounds", "uMaskCornerRadius", "uMaskFeather", "uFillColor", "uOverlayColor"]),
        E = k.createBuffer(),
        L = k.createBuffer();
    k.bindBuffer(k.ARRAY_BUFFER, L), k.bufferData(k.ARRAY_BUFFER, Zs, k.STATIC_DRAW);
    const F = Is(k, "#version 300 es\n\nin vec4 aPosition;in vec2 aNormal;in float aMiter;out vec2 vNormal;out float vMiter;out float vWidth;uniform float uWidth;uniform mat4 uMatrix;void main(){vMiter=aMiter;vNormal=aNormal;vWidth=(uWidth*.5)+1.0;gl_Position=uMatrix*vec4(aPosition.x+(aNormal.x*vWidth*aMiter),aPosition.y+(aNormal.y*vWidth*aMiter),0,1);}", "\n##head\n##mask\nin vec2 vNormal;in float vMiter;in float vWidth;uniform float uWidth;uniform vec4 uColor;uniform vec4 uCanvasColor;void main(){vec4 fillColor=uColor;float m=mask(gl_FragCoord.x,gl_FragCoord.y,uMaskBounds,uMaskOpacity);if(m<=0.0)discard;fillColor.a*=clamp(smoothstep(vWidth-.5,vWidth-1.0,abs(vMiter)*vWidth),0.0,1.0);fillColor.rgb*=fillColor.a;fillColor.rgb*=m;fillColor.rgb+=(1.0-m)*(uCanvasColor.rgb*fillColor.a);fragColor=fillColor;}", ["aPosition", "aNormal", "aMiter"], ["uColor", "uCanvasColor", "uMatrix", "uWidth", "uMaskBounds", "uMaskOpacity"]),
        z = k.createBuffer(),
        B = (e, t, o, i = !1) => {
            const {
                program: n,
                locations: r
            } = F;
            k.useProgram(n), k.enableVertexAttribArray(r.aPosition), k.enableVertexAttribArray(r.aNormal), k.enableVertexAttribArray(r.aMiter);
            const a = ((e, t) => {
                    let o, i, n, r = 0;
                    const a = e.length,
                        s = new Float32Array(10 * (t ? a + 1 : a)),
                        l = e[0],
                        c = e[a - 1];
                    for (r = 0; r < a; r++) o = e[r - 1], i = e[r], n = e[r + 1], o || (o = t ? c : Y(i.x + (i.x - n.x), i.y + (i.y - n.y))), n || (n = t ? l : Y(i.x + (i.x - o.x), i.y + (i.y - o.y))), Ns(s, 10 * r, o, i, n);
                    return t && Ns(s, 10 * a, c, l, e[1]), s
                })(e, i),
                s = 5 * Float32Array.BYTES_PER_ELEMENT,
                c = 2 * Float32Array.BYTES_PER_ELEMENT,
                d = 4 * Float32Array.BYTES_PER_ELEMENT;
            k.uniform1f(r.uWidth, t), k.uniform4fv(r.uColor, o), k.uniformMatrix4fv(r.uMatrix, !1, l), k.uniform4f(r.uCanvasColor, y, x, b, 1), k.uniform1fv(r.uMaskBounds, m), k.uniform1f(r.uMaskOpacity, p), k.bindBuffer(k.ARRAY_BUFFER, z), k.bufferData(k.ARRAY_BUFFER, a, k.STATIC_DRAW), k.vertexAttribPointer(r.aPosition, 2, k.FLOAT, !1, s, 0), k.vertexAttribPointer(r.aNormal, 2, k.FLOAT, !1, s, c), k.vertexAttribPointer(r.aMiter, 1, k.FLOAT, !1, s, d), k.drawArrays(k.TRIANGLE_STRIP, 0, a.length / 5), k.disableVertexAttribArray(r.aPosition), k.disableVertexAttribArray(r.aNormal), k.disableVertexAttribArray(r.aMiter)
        },
        D = Is(k, "\n##head\nvoid main(){\n##matrix\n}", "\n##head\n##mask\nuniform vec4 uColor;uniform vec4 uCanvasColor;void main(){vec4 fillColor=uColor;\n##maskapply\nfillColor.rgb*=fillColor.a;fillColor.rgb*=m;fillColor.rgb+=(1.0-m)*(uCanvasColor.rgb*fillColor.a);fragColor=fillColor;}", ["aPosition"], ["uColor", "uCanvasColor", "uMatrix", "uMaskBounds", "uMaskOpacity"]),
        _ = k.createBuffer(),
        W = Is(k, "\n##head\n##text\nin vec2 aRectCoord;out vec2 vRectCoord;void main(){vTexCoord=aTexCoord;vRectCoord=aRectCoord;\n##matrix\n}", "\n##head\n##mask\nin vec2 vTexCoord;in vec2 vRectCoord;uniform sampler2D uTexture;uniform vec4 uTextureColor;uniform float uTextureOpacity;uniform vec4 uColor;uniform float uCornerRadius[4];uniform vec2 uSize;uniform vec2 uPosition;uniform vec4 uCanvasColor;uniform int uInverted;void main(){\n##init\n##colorize\n##edgeaa\n##cornerradius\n##maskfeatherapply\nif(uInverted==1)a=1.0-a;\n##maskapply\n##fragcolor\n}", ["aPosition", "aTexCoord", "aRectCoord"], ["uTexture", "uColor", "uMatrix", "uCanvasColor", "uTextureColor", "uTextureOpacity", "uPosition", "uSize", "uMaskBounds", "uMaskOpacity", "uMaskFeather", "uCornerRadius", "uInverted"]),
        V = k.createBuffer(),
        H = k.createBuffer(),
        N = k.createBuffer(),
        U = Is(k, "\n##head\n##text\nout vec2 vTexCoordDouble;void main(){vTexCoordDouble=vec2(aTexCoord.x*2.0-1.0,aTexCoord.y*2.0-1.0);vTexCoord=aTexCoord;\n##matrix\n}", "\n##head\n##mask\nin vec2 vTexCoord;in vec2 vTexCoordDouble;uniform sampler2D uTexture;uniform float uTextureOpacity;uniform vec2 uRadius;uniform vec4 uColor;uniform int uInverted;uniform vec4 uCanvasColor;void main(){\n##init\nfloat ar=uRadius.x/uRadius.y;vec2 rAA=vec2(uRadius.x-1.0,uRadius.y-(1.0/ar));vec2 scaledPointSq=vec2((vTexCoordDouble.x*uRadius.x)*(vTexCoordDouble.x*uRadius.x),(vTexCoordDouble.y*uRadius.y)*(vTexCoordDouble.y*uRadius.y));float p=(scaledPointSq.x/(uRadius.x*uRadius.x))+(scaledPointSq.y/(uRadius.y*uRadius.y));float pAA=(scaledPointSq.x/(rAA.x*rAA.x))+(scaledPointSq.y/(rAA.y*rAA.y));a=smoothstep(1.0,p/pAA,p);if(uInverted==1)a=1.0-a;\n##maskapply\n##fragcolor\n}", ["aPosition", "aTexCoord"], ["uTexture", "uTextureOpacity", "uColor", "uCanvasColor", "uMatrix", "uRadius", "uInverted", "uMaskBounds", "uMaskOpacity"]),
        j = k.createBuffer(),
        X = k.createBuffer(),
        G = new Map,
        q = {
            2: {
                width: 0,
                height: 0
            },
            1: {
                width: 0,
                height: 0
            }
        },
        Z = (e, o, n, a = 1) => {
            const c = Math.min(Math.min(4096, i) / n.width, Math.min(4096, i) / n.height, a),
                d = Math.floor(c * n.width),
                u = Math.floor(c * n.height);
            ve(n, q[e]) ? k.bindFramebuffer(k.FRAMEBUFFER, o) : (k.bindTexture(k.TEXTURE_2D, v.get(e)), k.texImage2D(k.TEXTURE_2D, 0, k.RGBA, d, u, 0, k.RGBA, k.UNSIGNED_BYTE, null), k.texParameteri(k.TEXTURE_2D, k.TEXTURE_MIN_FILTER, k.LINEAR), k.texParameteri(k.TEXTURE_2D, k.TEXTURE_WRAP_S, k.CLAMP_TO_EDGE), k.texParameteri(k.TEXTURE_2D, k.TEXTURE_WRAP_T, k.CLAMP_TO_EDGE), k.bindFramebuffer(k.FRAMEBUFFER, o), k.framebufferTexture2D(k.FRAMEBUFFER, k.COLOR_ATTACHMENT0, k.TEXTURE_2D, v.get(e), 0), q[e] = n);
            const h = n.width * r,
                p = n.height * r;
            var m, g;
            Bs(s, 0, h, p, 0, -1, 1), Ds(s, 0, p, 0), g = 1, (m = s)[0] *= g, m[1] *= g, m[2] *= g, m[3] *= g, ((e, t) => {
                e[4] *= t, e[5] *= t, e[6] *= t, e[7] *= t
            })(s, -1), l = s, k.viewport(0, 0, d, u), k.colorMask(!0, !0, !0, !0), k.clearColor(0, 0, 0, 0), k.clear(k.COLOR_BUFFER_BIT), $ = [1, 0, 1, 0, 1, Math.max(t.width, n.width), 1, Math.max(t.width, n.width)]
        },
        K = (e, t = !1) => {
            const o = G.get(e);
            o instanceof HTMLCanvasElement && (t || o.dataset.retain || g(o)), G.delete(e), k.deleteTexture(e)
        };
    return {
        drawPath: (e, t, o, i, n) => {
            e.length < 2 || B(e.map((e => ({
                x: e.x * r,
                y: e.y * r
            }))), t * r, Fs(o, n), i)
        },
        drawTriangle: (e, t = 0, o = !1, i = !1, n, a) => {
            if (!n) return;
            const s = e.map((e => ({
                    x: e.x * r,
                    y: e.y * r
                }))),
                c = rt(s);
            (o || i) && he(s, o, i, c.x, c.y), pe(s, t, c.x, c.y);
            ((e, t) => {
                const {
                    program: o,
                    locations: i
                } = D;
                k.useProgram(o), k.enableVertexAttribArray(i.aPosition), k.uniform4fv(i.uColor, t), k.uniformMatrix4fv(i.uMatrix, !1, l), k.uniform1fv(i.uMaskBounds, m), k.uniform1f(i.uMaskOpacity, p), k.uniform4f(i.uCanvasColor, y, x, b, 1), k.bindBuffer(k.ARRAY_BUFFER, _), k.bufferData(k.ARRAY_BUFFER, e, k.STATIC_DRAW), k.vertexAttribPointer(i.aPosition, 2, k.FLOAT, !1, 0, 0), k.drawArrays(k.TRIANGLE_STRIP, 0, e.length / 2), k.disableVertexAttribArray(i.aPosition)
            })((e => {
                const t = new Float32Array(6);
                return t[0] = e[0].x, t[1] = e[0].y, t[2] = e[1].x, t[3] = e[1].y, t[4] = e[2].x, t[5] = e[2].y, t
            })(s), Fs(n, a))
        },
        drawRect: (e, t = 0, o = !1, i = !1, n, a, s, c, d, u, h, g, f, v, w, S) => {
            const C = Ne(Ee(e), r),
                T = n.map((t => ((e, t) => Math.floor(oa(e, 0, Math.min(.5 * (t.width - 1), .5 * (t.height - 1)))))(t || 0, e))).map((e => e * r));
            if (a || s) {
                const e = Ee(C);
                e.x -= .5, e.y -= .5, e.width += 1, e.height += 1;
                const n = js(e, t, o, i),
                    h = Us(n);
                let g;
                w && (g = Fs(w), 0 === g[3] && (g[3] = .001)), ((e, t, o, i, n, a = M, s = 1, c = Qs, d = Zs, u = $, h) => {
                    const {
                        program: g,
                        locations: f
                    } = W;
                    k.useProgram(g), k.enableVertexAttribArray(f.aPosition), k.enableVertexAttribArray(f.aTexCoord), k.enableVertexAttribArray(f.aRectCoord), k.uniform4fv(f.uColor, n), k.uniform2fv(f.uSize, [t, o]), k.uniform2fv(f.uPosition, [e[2], e[3]]), k.uniform1i(f.uInverted, h ? 1 : 0), k.uniform1fv(f.uCornerRadius, i), k.uniform4f(f.uCanvasColor, y, x, b, 1), k.uniform1fv(f.uMaskFeather, u.map(((e, t) => t % 2 == 0 ? e : e * r))), k.uniform1fv(f.uMaskBounds, m), k.uniform1f(f.uMaskOpacity, p), k.uniformMatrix4fv(f.uMatrix, !1, l), k.uniform1i(f.uTexture, 4), k.uniform4fv(f.uTextureColor, c), k.uniform1f(f.uTextureOpacity, s), k.activeTexture(k.TEXTURE0 + 4), k.bindTexture(k.TEXTURE_2D, a), k.bindBuffer(k.ARRAY_BUFFER, H), k.bufferData(k.ARRAY_BUFFER, d, k.STATIC_DRAW), k.vertexAttribPointer(f.aTexCoord, 2, k.FLOAT, !1, 0, 0), k.bindBuffer(k.ARRAY_BUFFER, N), k.bufferData(k.ARRAY_BUFFER, Zs, k.STATIC_DRAW), k.vertexAttribPointer(f.aRectCoord, 2, k.FLOAT, !1, 0, 0), k.bindBuffer(k.ARRAY_BUFFER, V), k.bufferData(k.ARRAY_BUFFER, e, k.STATIC_DRAW), k.vertexAttribPointer(f.aPosition, 2, k.FLOAT, !1, 0, 0), k.drawArrays(k.TRIANGLE_STRIP, 0, e.length / 2), k.disableVertexAttribArray(f.aPosition), k.disableVertexAttribArray(f.aTexCoord), k.disableVertexAttribArray(f.aRectCoord)
                })(h, e.width, e.height, T, Fs(a, f), s, f, g, u ? new Float32Array(u) : tl(e.width, e.height, c, d, r), v, S)
            }
            h && (h = Math.min(h, C.width, C.height), B(((e, t, o, i, n, r, a, s) => {
                const l = [];
                if (r.every((e => 0 === e))) l.push(Y(e, t), Y(e + o, t), Y(e + o, t + i), Y(e, t + i));
                else {
                    const [n, a, s, c] = r, d = e, u = e + o, h = t, p = t + i;
                    l.push(Y(d + n, h)), Xs(l, u - a, h + a, a, -1), l.push(Y(u, h + a)), Xs(l, u - c, p - c, c, 0), l.push(Y(u - c, p)), Xs(l, d + s, p - s, s, 1), l.push(Y(d, p - s)), Xs(l, d + n, h + n, n, 2)
                }
                return (a || s) && he(l, a, s, e + .5 * o, t + .5 * i), n && pe(l, n, e + .5 * o, t + .5 * i), l
            })(C.x, C.y, C.width, C.height, t, T, o, i), h * r, Fs(g, f), !0))
        },
        drawEllipse: (e, t, o, i, n, a, s, c, d, u, h, g, f, $, v) => {
            const w = Ne(_e(e.x - t, e.y - o, 2 * t, 2 * o), r);
            if (s || c) {
                const e = Ee(w);
                e.x -= .5, e.y -= .5, e.width += 1, e.height += 1;
                const t = js(e, i, n, a);
                ((e, t, o, i, n = M, r = Zs, a = 1, s = !1) => {
                    const {
                        program: c,
                        locations: d
                    } = U;
                    k.useProgram(c), k.enableVertexAttribArray(d.aPosition), k.enableVertexAttribArray(d.aTexCoord), k.uniformMatrix4fv(d.uMatrix, !1, l), k.uniform2fv(d.uRadius, [.5 * t, .5 * o]), k.uniform1i(d.uInverted, s ? 1 : 0), k.uniform4fv(d.uColor, i), k.uniform4f(d.uCanvasColor, y, x, b, 1), k.uniform1fv(d.uMaskBounds, m), k.uniform1f(d.uMaskOpacity, p), k.uniform1i(d.uTexture, 4), k.uniform1f(d.uTextureOpacity, a), k.activeTexture(k.TEXTURE0 + 4), k.bindTexture(k.TEXTURE_2D, n), k.bindBuffer(k.ARRAY_BUFFER, X), k.bufferData(k.ARRAY_BUFFER, r, k.STATIC_DRAW), k.vertexAttribPointer(d.aTexCoord, 2, k.FLOAT, !1, 0, 0), k.bindBuffer(k.ARRAY_BUFFER, j), k.bufferData(k.ARRAY_BUFFER, e, k.STATIC_DRAW), k.vertexAttribPointer(d.aPosition, 2, k.FLOAT, !1, 0, 0), k.drawArrays(k.TRIANGLE_STRIP, 0, e.length / 2), k.disableVertexAttribArray(d.aPosition), k.disableVertexAttribArray(d.aTexCoord)
                })(Us(t), e.width, e.height, Fs(s, $), c, h ? new Float32Array(h) : tl(e.width, e.height, d, u, r), $, v)
            }
            g && B(((e, t, o, i, n, r, a) => {
                const s = .5 * Math.abs(o),
                    l = .5 * Math.abs(i),
                    c = Math.abs(o) + Math.abs(i),
                    d = Math.max(20, Math.round(c / 6));
                return dt(Y(e + s, t + l), s, l, n, r, a, d)
            })(w.x, w.y, w.width, w.height, i, n, a), g * r, Fs(f, $), !0)
        },
        drawImage: (e, o, i, a, s, l, c, d, u, h, g = Js, $ = 1, y, x = 1, b = 0, w = f, M = el, T = Qs, R = Qs, P = !1, A = !1) => {
            const F = o.width * r,
                z = o.height * r,
                B = -.5 * F,
                D = .5 * z,
                O = .5 * F,
                _ = -.5 * z,
                W = new Float32Array([B, _, 0, B, D, 0, O, _, 0, O, D, 0]);
            k.bindBuffer(k.ARRAY_BUFFER, E), k.bufferData(k.ARRAY_BUFFER, W, k.STATIC_DRAW);
            const V = o.height / 2 / C * (t.height / o.height) * -1;
            s *= r, l *= r, i *= r, a *= r;
            const {
                program: H,
                locations: N
            } = I, U = zs();
            ((e, t, o, i, n) => {
                const r = 1 / Math.tan(t / 2),
                    a = 1 / (i - n);
                e[0] = r / o, e[1] = 0, e[2] = 0, e[3] = 0, e[4] = 0, e[5] = r, e[6] = 0, e[7] = 0, e[8] = 0, e[9] = 0, e[10] = (n + i) * a, e[11] = -1, e[12] = 0, e[13] = 0, e[14] = 2 * n * i * a, e[15] = 0
            })(U, S, n, 1, 2 * -V), Ds(U, s, -l, V), Ds(U, i, -a, 0), Vs(U, -u), Os(U, h), Ds(U, -i, a, 0), Ws(U, d), _s(U, c), k.useProgram(H), k.enableVertexAttribArray(N.aPosition), k.enableVertexAttribArray(N.aTexCoord), k.uniform1i(N.uTexture, 3), k.uniform2f(N.uTextureSize, o.width, o.height), k.activeTexture(k.TEXTURE0 + 3), k.bindTexture(k.TEXTURE_2D, e);
            const j = A ? 1 : 0,
                X = v.get(j);
            k.uniform1i(N.uTextureBlend, j), k.activeTexture(k.TEXTURE0 + j), k.bindTexture(k.TEXTURE_2D, X);
            const Y = P ? 2 : 0,
                G = v.get(Y);
            let q;
            k.uniform1i(N.uTextureOverlay, Y), k.activeTexture(k.TEXTURE0 + Y), k.bindTexture(k.TEXTURE_2D, G), k.bindBuffer(k.ARRAY_BUFFER, E), k.vertexAttribPointer(N.aPosition, 3, k.FLOAT, !1, 0, 0), k.bindBuffer(k.ARRAY_BUFFER, L), k.vertexAttribPointer(N.aTexCoord, 2, k.FLOAT, !1, 0, 0), k.uniformMatrix4fv(N.uMatrix, !1, U), k.uniform4fv(N.uOverlayColor, R), k.uniform4fv(N.uFillColor, T), !y || aa(y, Ks) ? (y = Ks, q = -1) : (q = y.reduce(((e, t) => e + t), 0), q = q <= 0 ? 1 : q), k.uniform1fv(N.uClarityKernel, y), k.uniform1f(N.uClarityKernelWeight, q), k.uniform1f(N.uColorGamma, 1 / x), k.uniform1f(N.uColorVignette, b), k.uniform4f(N.uColorOffset, g[4], g[9], g[14], g[19]), k.uniformMatrix4fv(N.uColorMatrix, !1, [g[0], g[1], g[2], g[3], g[5], g[6], g[7], g[8], g[10], g[11], g[12], g[13], g[15], g[16], g[17], g[18]]), k.uniform1f(N.uOpacity, $), k.uniform1f(N.uMaskOpacity, p), k.uniform1fv(N.uMaskBounds, m), k.uniform1fv(N.uMaskCornerRadius, M.map((e => e * r))), k.uniform1fv(N.uMaskFeather, w.map(((e, t) => t % 2 == 0 ? e : e * r))), k.drawArrays(k.TRIANGLE_STRIP, 0, 4), k.disableVertexAttribArray(N.aPosition), k.disableVertexAttribArray(N.aTexCoord)
        },
        textureFilterNearest: k.NEAREST,
        textureFilterLinear: k.LINEAR,
        textureCreate: () => k.createTexture(),
        textureUpdate: (e, t, o) => (G.set(e, t), Ls(k, e, t, o)),
        textureSize: e => {
            const t = G.get(e);
            return fe(t)
        },
        textureDelete: K,
        enablePreviewStencil: () => {
            k.stencilOp(k.KEEP, k.KEEP, k.REPLACE), k.stencilFunc(k.ALWAYS, 1, 255), k.stencilMask(255)
        },
        applyPreviewStencil: () => {
            k.stencilFunc(k.EQUAL, 1, 255), k.stencilMask(0)
        },
        disablePreviewStencil: w,
        setCanvasColor(e) {
            y = e[0], x = e[1], b = e[2], k.clear(k.COLOR_BUFFER_BIT)
        },
        resetCanvasMatrix: () => {
            Bs(a, 0, t.width, t.height, 0, -1, 1)
        },
        updateCanvasMatrix(e, o, i, n, s) {
            const l = e.width,
                c = e.height,
                d = t.width * (.5 / r),
                u = t.height * (.5 / r),
                h = {
                    x: d + (i.x + o.x),
                    y: u + (i.y + o.y)
                },
                p = {
                    x: h.x - o.x,
                    y: h.y - o.y
                },
                m = .5 * l,
                g = .5 * c;
            J(p, s.z, h), de(p, n, h);
            Ds(a, (p.x - m) * r, (p.y - g) * r, 0), Ds(a, m * r, g * r, 0), Vs(a, s.z);
            const f = s.x > Math.PI / 2;
            _s(a, f ? Math.PI : 0);
            const $ = s.y > Math.PI / 2;
            Ws(a, $ ? Math.PI : 0), Os(a, n), Ds(a, -m * r, -g * r, 0)
        },
        drawToCanvas() {
            k.bindFramebuffer(k.FRAMEBUFFER, null), l = a, k.viewport(0, 0, k.drawingBufferWidth, k.drawingBufferHeight), k.colorMask(!0, !0, !0, !1), k.clearColor(y, x, b, 1), k.clear(k.COLOR_BUFFER_BIT), $ = [1, 0, 1, 0, 1, t.width, 1, t.width]
        },
        drawToImageBlendBuffer(e, t) {
            Z(1, A, e, t)
        },
        drawToImageOverlayBuffer(e, t) {
            Z(2, R, e, t)
        },
        enableMask(e, o) {
            const i = e.x * r,
                n = e.y * r,
                a = e.width * r,
                s = e.height * r;
            h = i, d = h + a, c = t.height - n, u = t.height - (n + s), p = 1 - o, m = [c, d, u, h]
        },
        disableMask() {
            h = 0, d = t.width, c = t.height, u = 0, p = 1, m = [c, d, u, h]
        },
        resize: (i, s, l) => {
            r = l, o.width = i, o.height = s, t.width = i * r, t.height = s * r, n = O(t.width, t.height), e.width = t.width, e.height = t.height, Bs(a, 0, t.width, t.height, 0, -1, 1), f = [1, 0, 1, 0, 1, o.width, 1, o.width]
        },
        release() {
            Array.from(G.keys()).forEach((e => K(e, !0))), G.clear(), v.forEach((e => {
                k.deleteTexture(e)
            })), v.clear(), I.destroy(), F.destroy(), D.destroy(), W.destroy(), U.destroy(), e.width = 1, e.height = 1, e = void 0
        }
    }
};

function il(e) {
    let t, o, i, n;
    return {
        c() {
            t = Mn("div"), o = Mn("canvas"), Fn(t, "class", "PinturaCanvas")
        },
        m(r, a) {
            Cn(r, t, a), Sn(t, o), e[27](o), i || (n = [In(o, "measure", e[28]), fn($s.call(null, o))], i = !0)
        },
        p: Ji,
        i: Ji,
        o: Ji,
        d(o) {
            o && kn(t), e[27](null), i = !1, nn(n)
        }
    }
}

function nl(e, t, o) {
    let i, r, a, s, l, c, d;
    const u = (e, t) => {
            const [o, i, n] = e, [r, a, s, l] = t;
            return [r * l + o * (1 - l), a * l + i * (1 - l), s * l + n * (1 - l), 1]
        },
        h = Zn();
    let m, {
            animate: g
        } = t,
        {
            maskRect: $
        } = t,
        {
            maskOpacity: y = 1
        } = t,
        {
            maskFrameOpacity: x = .95
        } = t,
        {
            pixelRatio: b = 1
        } = t,
        {
            textPixelRatio: v = b
        } = t,
        {
            backgroundColor: S
        } = t,
        {
            willRender: C = _
        } = t,
        {
            didRender: k = _
        } = t,
        {
            willRequestResource: M = (() => !0)
        } = t,
        {
            loadImageData: T = _
        } = t,
        {
            images: R = []
        } = t,
        {
            interfaceImages: P = []
        } = t,
        A = null,
        I = null,
        E = null;
    const L = (e, t) => e.set(t, {
            hard: !g
        }),
        F = {
            precision: 1e-4 * .01
        },
        z = is(void 0, {
            duration: 250
        });
    cn(e, z, (e => o(23, a = e)));
    const B = rs(1, F);
    cn(e, B, (e => o(24, s = e)));
    const D = rs(1, F);
    cn(e, D, (e => o(38, d = e)));
    const W = Dr();
    cn(e, W, (e => o(36, l = e)));
    const V = Dr();
    cn(e, V, (e => o(37, c = e)));
    const H = () => requestAnimationFrame((() => {
            te = !0, r()
        })),
        N = new Map([]),
        U = new Map([]),
        j = (e, t) => {
            if (!N.has(e)) {
                N.set(e, e);
                const o = "pixelated" === t ? A.textureFilterNearest : A.textureFilterLinear;
                if (!w(e) && ("close" in e || f(e) || Ii(e))) {
                    const t = A.textureCreate();
                    A.textureUpdate(t, e, {
                        filter: o
                    }), N.set(e, t)
                } else T(e).then((t => {
                    const i = A.textureCreate();
                    A.textureUpdate(i, t, {
                        filter: o
                    }), N.set(e, i), H()
                })).catch((e => {
                    console.error(e)
                }))
            }
            return N.get(e)
        },
        q = e => {
            if (!e.text.length) return void U.delete(e.id);
            let {
                text: t,
                textAlign: o,
                fontFamily: i,
                fontSize: n,
                fontWeight: r,
                fontVariant: a,
                fontStyle: s,
                lineHeight: l,
                width: c,
                height: d
            } = e;
            const {
                lastCharPosition: u,
                size: h
            } = ((e = "", t) => {
                const {
                    width: o = 0,
                    height: i = "auto",
                    fontSize: n,
                    fontFamily: r,
                    lineHeight: a,
                    fontWeight: s,
                    fontStyle: l,
                    fontVariant: c
                } = t, d = lo({
                    text: e,
                    fontFamily: r,
                    fontWeight: s,
                    fontStyle: l,
                    fontVariant: c,
                    fontSize: n,
                    lineHeight: a,
                    width: o,
                    height: i
                });
                let u = $o.get(d);
                if (u) return u;
                const h = p("span"),
                    m = $t(p("pre", {
                        contenteditable: "true",
                        spellcheck: "false",
                        style: `pointer-events:none;visibility:hidden;position:absolute;left:0;top:0;${go({fontFamily:r,fontWeight:s,fontStyle:l,fontVariant:c,fontSize:n,lineHeight:a})};${fo(t)}"`,
                        innerHTML: e
                    }, [h])),
                    g = m.getBoundingClientRect(),
                    f = h.getBoundingClientRect();
                return u = {
                    size: fe(g),
                    lastCharPosition: ie(G(f), Math.round)
                }, $o.set(d, u), m.remove(), u
            })(t, e), m = lo({
                text: t,
                textAlign: o,
                fontFamily: i,
                fontSize: n,
                fontWeight: r,
                fontVariant: a,
                fontStyle: s,
                lineHeight: l,
                height: d ? Math.min(u.y, Math.ceil(d / l) * l) : "auto",
                xOffset: u.x,
                yOffset: u.y
            });
            if (!N.has(m)) {
                N.set(m, t);
                const u = c && Math.round(c),
                    p = d && Math.round(d),
                    g = Me(ge(h), (e => Math.min(Math.round(e), Gs())));
                Ao(t, {
                    fontSize: n,
                    fontFamily: i,
                    fontWeight: r,
                    fontVariant: a,
                    fontStyle: s,
                    textAlign: o,
                    lineHeight: l,
                    color: [1, 0, 1],
                    width: u,
                    height: p,
                    imageWidth: g.width,
                    imageHeight: p ? Math.ceil(p / l) * l : g.height,
                    pixelRatio: v,
                    willRequestResource: M
                }).then((t => {
                    const o = A.textureCreate();
                    A.textureUpdate(o, t, {
                        filter: A.textureFilterLinear
                    }), N.set(m, o), U.set(e.id, o), H()
                })).catch(console.error)
            }
            const g = N.get(m);
            return Z(g) ? g : U.get(e.id)
        },
        Z = e => e instanceof WebGLTexture,
        K = ({
            data: e,
            size: t,
            origin: o,
            translation: i,
            rotation: n,
            scale: r,
            colorMatrix: s,
            opacity: l,
            convolutionMatrix: c,
            gamma: d,
            vignette: h,
            maskFeather: p,
            maskCornerRadius: m,
            backgroundColor: g,
            overlayColor: f,
            enableOverlay: $,
            enableBlend: y
        }) => {
            g && g[3] < 1 && g[3] > 0 && (g = u(a, g));
            const x = j(e);
            return A.drawImage(x, t, o.x, o.y, i.x, i.y, n.x, n.y, n.z, r, s, oa(l, 0, 1), c, d, h, p, m, g, f, $, y), x
        },
        J = ([e, t, o, i]) => [i.x, i.y, e.x, e.y, o.x, o.y, t.x, t.y],
        Q = X(),
        ee = (e = [], t) => e.map((e => {
            let t = !e._isLoading && (e => {
                    let t;
                    if (e.backgroundImage) t = j(e.backgroundImage, e.backgroundImageRendering);
                    else if (w(e.text)) {
                        if (e.width && e.width < 1 || e.height && e.height < 1) return;
                        t = q(e)
                    }
                    return t
                })(e),
                o = Z(t) ? t : void 0;
            const i = e._scale || 1,
                n = e._translate || Q,
                r = e.strokeWidth && e.strokeWidth * i;
            if (Qt(e.points)) {
                const t = e.points.map((e => Y(e.x * i + n.x, e.y * i + n.y)));
                3 === t.length && e.backgroundColor ? A.drawTriangle(t, e.rotation, e.flipX, e.flipY, e.backgroundColor, r, e.strokeColor, e.opacity) : A.drawPath(t, r, e.strokeColor, e.pathClose, e.opacity)
            } else if (Zt(e.rx) && Zt(e.ry)) {
                let t = e.x,
                    a = e.y;
                t *= i, a *= i, t += n.x, a += n.y, A.drawEllipse(Y(t, a), e.rx * i, e.ry * i, e.rotation, e.flipX, e.flipY, e.backgroundColor, o, void 0, void 0, e.backgroundCorners && J(e.backgroundCorners), r, e.strokeColor, e.opacity, e.inverted)
            } else if (w(e.text) && o || e.width) {
                const t = o && A.textureSize(o);
                let a, s, l, c = void 0,
                    d = [e.cornerRadius, e.cornerRadius, e.cornerRadius, e.cornerRadius].map((e => e * i));
                if (a = e.width ? ze(e) : {
                        x: e.x,
                        y: e.y,
                        ...t
                    }, i && n && (a.x *= i, a.y *= i, a.x += n.x, a.y += n.y, a.width *= i, a.height *= i), t)
                    if (e.backgroundImage && e.backgroundSize) {
                        const o = O(t.width, t.height);
                        if ("contain" === e.backgroundSize) {
                            const e = Qe(a, o, a);
                            s = $e(e), l = Y(.5 * (a.width - s.width), .5 * (a.height - s.height))
                        } else if ("cover" === e.backgroundSize) {
                            const e = Je(a, o, a);
                            s = $e(e), l = Y(e.x, e.y), l = Y(.5 * (a.width - s.width), .5 * (a.height - s.height))
                        } else s = e.backgroundSize, l = e.backgroundPosition
                    } else if (e.text) {
                    const o = {
                        width: t.width / v,
                        height: t.height / v
                    };
                    l = Y(0, 0), s = {
                        width: o.width * i,
                        height: o.height * i
                    }, e.backgroundColor && A.drawRect({
                        ...a,
                        height: a.height || t.height * i
                    }, e.rotation, e.flipX, e.flipY, d, e.backgroundColor, void 0, void 0, void 0, void 0, r, e.strokeColor, e.opacity, void 0, void 0, e.inverted), e.backgroundColor = void 0, a.x -= mo * i, c = e.color, e.width ? (a.height = a.height || o.height * i, a.width += 2 * mo * i, "center" === e.textAlign ? l.x = .5 * (a.width - s.width) : "right" === e.textAlign && (l.x = a.width - s.width)) : (a.width = o.width * i, a.height = o.height * i), e._prerender && (c[3] = 0)
                }
                A.drawRect(a, e.rotation, e.flipX, e.flipY, d, e.backgroundColor, o, s, l, e.backgroundCorners && J(e.backgroundCorners), r, e.strokeColor, e.opacity, void 0, c, e.inverted)
            }
            return t
        })).filter(Boolean);
    let te = !1,
        oe = !0,
        ne = !1;
    const re = [],
        ae = [],
        se = [],
        le = () => {
            se.length = 0;
            const e = R[0],
                {
                    blendShapes: t,
                    blendShapesDirty: o,
                    annotationShapes: i,
                    annotationShapesDirty: n,
                    interfaceShapes: r,
                    decorationShapes: h,
                    frameShapes: p
                } = C({
                    opacity: e.opacity,
                    rotation: e.rotation,
                    scale: e.scale,
                    images: R,
                    size: be(I, E),
                    backgroundColor: [...a],
                    selectionRect: l
                }),
                m = [...a],
                g = l,
                f = oa(s, 0, 1),
                $ = c,
                y = Math.abs(e.rotation.x / Math.PI * 2 - 1),
                x = Math.abs(e.rotation.y / Math.PI * 2 - 1),
                b = y < .99 || x < .99,
                w = e.size,
                S = e.backgroundColor,
                M = t.length > 0,
                T = i.length > 0,
                L = S[3] > 0;
            if (f < 1 && L) {
                const e = m[0],
                    t = m[1],
                    o = m[2],
                    i = 1 - f,
                    n = S[0] * i,
                    r = S[1] * i,
                    a = S[2] * i,
                    s = 1 - i;
                m[0] = n + e * s, m[1] = r + t * s, m[2] = a + o * s, m[3] = 1
            }
            A.setCanvasColor(m), M && o ? (A.disableMask(), A.drawToImageBlendBuffer(w), re.length = 0, re.push(...ee(t))) : M || (re.length = 0), se.push(...re), oe && (A.drawToImageOverlayBuffer(w, v), oe = !1);
            if (b ? (T && (n || te) || !ne ? (A.disableMask(), A.drawToImageOverlayBuffer(w, v), ae.length = 0, ae.push(...ee(i))) : T || (ae.length = 0), ne = !0) : ne = !1, A.drawToCanvas(), A.enableMask(g, f), L && A.drawRect(g, 0, !1, !1, [0, 0, 0, 0], u(a, S)), A.enablePreviewStencil(), se.push(...[...R].reverse().map((e => K({
                    ...e,
                    enableOverlay: b && T,
                    enableBlend: M,
                    mask: g,
                    maskOpacity: f,
                    overlayColor: $
                })))), b || (A.applyPreviewStencil(), A.resetCanvasMatrix(), A.updateCanvasMatrix(w, e.origin, e.translation, e.scale, e.rotation), ae.length = 0, ae.push(...ee(i)), A.disablePreviewStencil()), se.push(...ae), A.resetCanvasMatrix(), A.enableMask(g, 1), se.push(...ee(h)), p.length) {
                const e = p.filter((e => !e.expandsCanvas)),
                    t = p.filter((e => e.expandsCanvas));
                e.length && se.push(...ee(e)), t.length && (A.enableMask({
                    x: g.x + .5,
                    y: g.y + .5,
                    width: g.width - 1,
                    height: g.height - 1
                }, d), se.push(...ee(t)))
            }
            A.disableMask(), se.push(...ee(r)), P.forEach((e => {
                A.enableMask(e.mask, e.maskOpacity), e.backgroundColor && A.drawRect(e.mask, 0, !1, !1, e.maskCornerRadius, e.backgroundColor, void 0, void 0, void 0, void 0, void 0, e.opacity, e.maskFeather), K({
                    ...e,
                    translation: {
                        x: e.translation.x + e.offset.x - .5 * I,
                        y: e.translation.y + e.offset.y - .5 * E
                    }
                })
            })), A.disableMask(), (e => {
                N.forEach(((t, o) => {
                    !e.find((e => e === t)) && Z(t) && (Array.from(U.values()).includes(t) || (N.delete(o), A.textureDelete(t)))
                }))
            })(se), k(), te = !1
        };
    let ce = Date.now();
    const de = () => {
        const e = Date.now();
        e - ce < 48 || (ce = e, le())
    };
    Gn((() => r())), Yn((() => o(22, A = ol(m)))), qn((() => {
        A && (A.release(), o(22, A = void 0), o(2, m = void 0))
    }));
    return e.$$set = e => {
        "animate" in e && o(9, g = e.animate), "maskRect" in e && o(10, $ = e.maskRect), "maskOpacity" in e && o(11, y = e.maskOpacity), "maskFrameOpacity" in e && o(12, x = e.maskFrameOpacity), "pixelRatio" in e && o(13, b = e.pixelRatio), "textPixelRatio" in e && o(14, v = e.textPixelRatio), "backgroundColor" in e && o(15, S = e.backgroundColor), "willRender" in e && o(16, C = e.willRender), "didRender" in e && o(17, k = e.didRender), "willRequestResource" in e && o(18, M = e.willRequestResource), "loadImageData" in e && o(19, T = e.loadImageData), "images" in e && o(20, R = e.images), "interfaceImages" in e && o(21, P = e.interfaceImages)
    }, e.$$.update = () => {
        32768 & e.$$.dirty[0] && S && L(z, S), 2048 & e.$$.dirty[0] && L(B, Zt(y) ? y : 1), 4096 & e.$$.dirty[0] && L(D, Zt(x) ? x : 1), 1024 & e.$$.dirty[0] && $ && W.set($), 25165824 & e.$$.dirty[0] && a && V.set([a[0], a[1], a[2], oa(s, 0, 1)]), 5242883 & e.$$.dirty[0] && o(26, i = !!(A && I && E && R.length)), 4202499 & e.$$.dirty[0] && I && E && A && A.resize(I, E, b), 67108864 & e.$$.dirty[0] && o(25, r = i ? ks() ? de : le : n), 100663296 & e.$$.dirty[0] && i && r && r()
    }, [I, E, m, h, z, B, D, W, V, g, $, y, x, b, v, S, C, k, M, T, R, P, A, a, s, r, i, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            m = e, o(2, m)
        }))
    }, e => {
        o(0, I = e.detail.width), o(1, E = e.detail.height), h("measure", {
            width: I,
            height: E
        })
    }]
}
class rl extends Fr {
    constructor(e) {
        super(), Lr(this, e, nl, il, an, {
            animate: 9,
            maskRect: 10,
            maskOpacity: 11,
            maskFrameOpacity: 12,
            pixelRatio: 13,
            textPixelRatio: 14,
            backgroundColor: 15,
            willRender: 16,
            didRender: 17,
            willRequestResource: 18,
            loadImageData: 19,
            images: 20,
            interfaceImages: 21
        }, [-1, -1])
    }
}
var al = (e, t = Boolean, o = " ") => e.filter(t).join(o);

function sl(e, t, o) {
    const i = e.slice();
    return i[17] = t[o], i
}
const ll = e => ({
        tab: 4 & e
    }),
    cl = e => ({
        tab: e[17]
    });

function dl(e) {
    let t, o, i, n = [],
        r = new Map,
        a = e[2];
    const s = e => e[17].id;
    for (let t = 0; t < a.length; t += 1) {
        let o = sl(e, a, t),
            i = s(o);
        r.set(i, n[t] = ul(i, o))
    }
    return {
        c() {
            t = Mn("ul");
            for (let e = 0; e < n.length; e += 1) n[e].c();
            Fn(t, "class", o = al(["PinturaTabList", e[0]])), Fn(t, "role", "tablist"), Fn(t, "data-layout", e[1])
        },
        m(o, r) {
            Cn(o, t, r);
            for (let e = 0; e < n.length; e += 1) n[e].m(t, null);
            e[14](t), i = !0
        },
        p(e, l) {
            1124 & l && (a = e[2], fr(), n = kr(n, l, s, 1, e, a, r, t, Cr, ul, null, sl), $r()), (!i || 1 & l && o !== (o = al(["PinturaTabList", e[0]]))) && Fn(t, "class", o), (!i || 2 & l) && Fn(t, "data-layout", e[1])
        },
        i(e) {
            if (!i) {
                for (let e = 0; e < a.length; e += 1) yr(n[e]);
                i = !0
            }
        },
        o(e) {
            for (let e = 0; e < n.length; e += 1) xr(n[e]);
            i = !1
        },
        d(o) {
            o && kn(t);
            for (let e = 0; e < n.length; e += 1) n[e].d();
            e[14](null)
        }
    }
}

function ul(e, t) {
    let o, i, n, r, a, s, l, c, d, u;
    const h = t[11].default,
        p = dn(h, t, t[10], cl);

    function m(...e) {
        return t[12](t[17], ...e)
    }

    function g(...e) {
        return t[13](t[17], ...e)
    }
    return {
        key: e,
        first: null,
        c() {
            o = Mn("li"), i = Mn("button"), p && p.c(), r = Pn(), i.disabled = n = t[17].disabled, Fn(o, "role", "tab"), Fn(o, "aria-controls", a = t[17].href.substr(1)), Fn(o, "id", s = t[17].tabId), Fn(o, "aria-selected", l = t[17].selected), this.first = o
        },
        m(e, t) {
            Cn(e, o, t), Sn(o, i), p && p.m(i, null), Sn(o, r), c = !0, d || (u = [In(i, "keydown", m), In(i, "click", g)], d = !0)
        },
        p(e, r) {
            t = e, p && p.p && 1028 & r && hn(p, h, t, t[10], r, ll, cl), (!c || 4 & r && n !== (n = t[17].disabled)) && (i.disabled = n), (!c || 4 & r && a !== (a = t[17].href.substr(1))) && Fn(o, "aria-controls", a), (!c || 4 & r && s !== (s = t[17].tabId)) && Fn(o, "id", s), (!c || 4 & r && l !== (l = t[17].selected)) && Fn(o, "aria-selected", l)
        },
        i(e) {
            c || (yr(p, e), c = !0)
        },
        o(e) {
            xr(p, e), c = !1
        },
        d(e) {
            e && kn(o), p && p.d(e), d = !1, nn(u)
        }
    }
}

function hl(e) {
    let t, o, i = e[4] && dl(e);
    return {
        c() {
            i && i.c(), t = An()
        },
        m(e, n) {
            i && i.m(e, n), Cn(e, t, n), o = !0
        },
        p(e, [o]) {
            e[4] ? i ? (i.p(e, o), 16 & o && yr(i, 1)) : (i = dl(e), i.c(), yr(i, 1), i.m(t.parentNode, t)) : i && (fr(), xr(i, 1, 1, (() => {
                i = null
            })), $r())
        },
        i(e) {
            o || (yr(i), o = !0)
        },
        o(e) {
            xr(i), o = !1
        },
        d(e) {
            i && i.d(e), e && kn(t)
        }
    }
}

function pl(e, t, o) {
    let i, n, r, {
            $$slots: a = {},
            $$scope: s
        } = t,
        {
            class: l
        } = t,
        {
            name: c
        } = t,
        {
            selected: d
        } = t,
        {
            tabs: u = []
        } = t,
        {
            layout: h
        } = t;
    const p = Zn(),
        m = e => {
            const t = r.querySelectorAll('[role="tab"] button')[e];
            t && t.focus()
        },
        g = (e, t) => {
            e.preventDefault(), e.stopPropagation(), p("select", t)
        },
        f = ({
            key: e
        }, t) => {
            if (!/arrow/i.test(e)) return;
            const o = u.findIndex((e => e.id === t));
            return /right|down/i.test(e) ? m(o < u.length - 1 ? o + 1 : 0) : /left|up/i.test(e) ? m(o > 0 ? o - 1 : u.length - 1) : void 0
        };
    return e.$$set = e => {
        "class" in e && o(0, l = e.class), "name" in e && o(7, c = e.name), "selected" in e && o(8, d = e.selected), "tabs" in e && o(9, u = e.tabs), "layout" in e && o(1, h = e.layout), "$$scope" in e && o(10, s = e.$$scope)
    }, e.$$.update = () => {
        896 & e.$$.dirty && o(2, i = u.map((e => {
            const t = e.id === d;
            return {
                ...e,
                tabId: `tab-${c}-${e.id}`,
                href: `#panel-${c}-${e.id}`,
                selected: t
            }
        }))), 4 & e.$$.dirty && o(4, n = i.length > 1)
    }, [l, h, i, r, n, g, f, c, d, u, s, a, (e, t) => f(t, e.id), (e, t) => g(t, e.id), function (e) {
        tr[e ? "unshift" : "push"]((() => {
            r = e, o(3, r)
        }))
    }]
}
class ml extends Fr {
    constructor(e) {
        super(), Lr(this, e, pl, hl, an, {
            class: 0,
            name: 7,
            selected: 8,
            tabs: 9,
            layout: 1
        })
    }
}
const gl = e => ({
        panel: 16 & e
    }),
    fl = e => ({
        panel: e[4][0].id,
        panelIsActive: !0
    });

function $l(e, t, o) {
    const i = e.slice();
    return i[14] = t[o].id, i[15] = t[o].draw, i[16] = t[o].panelId, i[17] = t[o].tabindex, i[18] = t[o].labelledBy, i[19] = t[o].hidden, i[3] = t[o].visible, i
}
const yl = e => ({
        panel: 16 & e,
        panelIsActive: 16 & e
    }),
    xl = e => ({
        panel: e[14],
        panelIsActive: !e[19]
    });

function bl(e) {
    let t, o, i, n, r, a;
    const s = e[11].default,
        l = dn(s, e, e[10], fl);
    return {
        c() {
            t = Mn("div"), o = Mn("div"), l && l.c(), Fn(o, "class", i = al([e[1]])), Fn(t, "class", e[0]), Fn(t, "style", e[2])
        },
        m(i, s) {
            Cn(i, t, s), Sn(t, o), l && l.m(o, null), n = !0, r || (a = [In(t, "measure", e[13]), fn($s.call(null, t))], r = !0)
        },
        p(e, r) {
            l && l.p && 1040 & r && hn(l, s, e, e[10], r, gl, fl), (!n || 2 & r && i !== (i = al([e[1]]))) && Fn(o, "class", i), (!n || 1 & r) && Fn(t, "class", e[0]), (!n || 4 & r) && Fn(t, "style", e[2])
        },
        i(e) {
            n || (yr(l, e), n = !0)
        },
        o(e) {
            xr(l, e), n = !1
        },
        d(e) {
            e && kn(t), l && l.d(e), r = !1, nn(a)
        }
    }
}

function vl(e) {
    let t, o, i, n, r, a = [],
        s = new Map,
        l = e[4];
    const c = e => e[14];
    for (let t = 0; t < l.length; t += 1) {
        let o = $l(e, l, t),
            i = c(o);
        s.set(i, a[t] = Sl(i, o))
    }
    return {
        c() {
            t = Mn("div");
            for (let e = 0; e < a.length; e += 1) a[e].c();
            Fn(t, "class", o = al(["PinturaTabPanels", e[0]])), Fn(t, "style", e[2])
        },
        m(o, s) {
            Cn(o, t, s);
            for (let e = 0; e < a.length; e += 1) a[e].m(t, null);
            i = !0, n || (r = [In(t, "measure", e[12]), fn($s.call(null, t, {
                observePosition: !0
            }))], n = !0)
        },
        p(e, n) {
            1042 & n && (l = e[4], fr(), a = kr(a, n, c, 1, e, l, s, t, Cr, Sl, null, $l), $r()), (!i || 1 & n && o !== (o = al(["PinturaTabPanels", e[0]]))) && Fn(t, "class", o), (!i || 4 & n) && Fn(t, "style", e[2])
        },
        i(e) {
            if (!i) {
                for (let e = 0; e < l.length; e += 1) yr(a[e]);
                i = !0
            }
        },
        o(e) {
            for (let e = 0; e < a.length; e += 1) xr(a[e]);
            i = !1
        },
        d(e) {
            e && kn(t);
            for (let e = 0; e < a.length; e += 1) a[e].d();
            n = !1, nn(r)
        }
    }
}

function wl(e) {
    let t;
    const o = e[11].default,
        i = dn(o, e, e[10], xl);
    return {
        c() {
            i && i.c()
        },
        m(e, o) {
            i && i.m(e, o), t = !0
        },
        p(e, t) {
            i && i.p && 1040 & t && hn(i, o, e, e[10], t, yl, xl)
        },
        i(e) {
            t || (yr(i, e), t = !0)
        },
        o(e) {
            xr(i, e), t = !1
        },
        d(e) {
            i && i.d(e)
        }
    }
}

function Sl(e, t) {
    let o, i, n, r, a, s, l, c, d, u = t[15] && wl(t);
    return {
        key: e,
        first: null,
        c() {
            o = Mn("div"), u && u.c(), i = Pn(), Fn(o, "class", n = al(["PinturaTabPanel", t[1]])), o.hidden = r = t[19], Fn(o, "id", a = t[16]), Fn(o, "tabindex", s = t[17]), Fn(o, "aria-labelledby", l = t[18]), Fn(o, "data-inert", c = !t[3]), this.first = o
        },
        m(e, t) {
            Cn(e, o, t), u && u.m(o, null), Sn(o, i), d = !0
        },
        p(e, h) {
            (t = e)[15] ? u ? (u.p(t, h), 16 & h && yr(u, 1)) : (u = wl(t), u.c(), yr(u, 1), u.m(o, i)): u && (fr(), xr(u, 1, 1, (() => {
                u = null
            })), $r()), (!d || 2 & h && n !== (n = al(["PinturaTabPanel", t[1]]))) && Fn(o, "class", n), (!d || 16 & h && r !== (r = t[19])) && (o.hidden = r), (!d || 16 & h && a !== (a = t[16])) && Fn(o, "id", a), (!d || 16 & h && s !== (s = t[17])) && Fn(o, "tabindex", s), (!d || 16 & h && l !== (l = t[18])) && Fn(o, "aria-labelledby", l), (!d || 16 & h && c !== (c = !t[3])) && Fn(o, "data-inert", c)
        },
        i(e) {
            d || (yr(u), d = !0)
        },
        o(e) {
            xr(u), d = !1
        },
        d(e) {
            e && kn(o), u && u.d()
        }
    }
}

function Cl(e) {
    let t, o, i, n;
    const r = [vl, bl],
        a = [];

    function s(e, t) {
        return e[5] ? 0 : 1
    }
    return t = s(e), o = a[t] = r[t](e), {
        c() {
            o.c(), i = An()
        },
        m(e, o) {
            a[t].m(e, o), Cn(e, i, o), n = !0
        },
        p(e, [n]) {
            let l = t;
            t = s(e), t === l ? a[t].p(e, n) : (fr(), xr(a[l], 1, 1, (() => {
                a[l] = null
            })), $r(), o = a[t], o ? o.p(e, n) : (o = a[t] = r[t](e), o.c()), yr(o, 1), o.m(i.parentNode, i))
        },
        i(e) {
            n || (yr(o), n = !0)
        },
        o(e) {
            xr(o), n = !1
        },
        d(e) {
            a[t].d(e), e && kn(i)
        }
    }
}

function kl(e, t, o) {
    let i, n, {
            $$slots: r = {},
            $$scope: a
        } = t,
        {
            class: s
        } = t,
        {
            name: l
        } = t,
        {
            selected: c
        } = t,
        {
            visible: d
        } = t,
        {
            panelClass: u
        } = t,
        {
            panels: h = []
        } = t,
        {
            style: p
        } = t;
    const m = {};
    return e.$$set = e => {
        "class" in e && o(0, s = e.class), "name" in e && o(6, l = e.name), "selected" in e && o(7, c = e.selected), "visible" in e && o(3, d = e.visible), "panelClass" in e && o(1, u = e.panelClass), "panels" in e && o(8, h = e.panels), "style" in e && o(2, p = e.style), "$$scope" in e && o(10, a = e.$$scope)
    }, e.$$.update = () => {
        968 & e.$$.dirty && o(4, i = h.map((e => {
            const t = e === c,
                i = !d || -1 !== d.indexOf(e);
            return t && o(9, m[e] = !0, m), {
                id: e,
                panelId: `panel-${l}-${e}`,
                labelledBy: `tab-${l}-${e}`,
                hidden: !t,
                visible: i,
                tabindex: t ? 0 : -1,
                draw: t || m[e]
            }
        }))), 16 & e.$$.dirty && o(5, n = i.length > 1)
    }, [s, u, p, d, i, n, l, c, h, m, a, r, function (t) {
        Qn(e, t)
    }, function (t) {
        Qn(e, t)
    }]
}
class Ml extends Fr {
    constructor(e) {
        super(), Lr(this, e, kl, Cl, an, {
            class: 0,
            name: 6,
            selected: 7,
            visible: 3,
            panelClass: 1,
            panels: 8,
            style: 2
        })
    }
}
var Tl = e => {
    const t = Object.getOwnPropertyDescriptors(e.prototype);
    return Object.keys(t).filter((e => !!t[e].get))
};

function Rl(e) {
    let t, o, i, n, r;
    const a = [e[7]];

    function s(t) {
        e[19](t)
    }
    var l = e[11];

    function c(e) {
        let t = {};
        for (let e = 0; e < a.length; e += 1) t = en(t, a[e]);
        return void 0 !== e[5] && (t.name = e[5]), {
            props: t
        }
    }
    return l && (o = new l(c(e)), tr.push((() => Rr(o, "name", s))), e[20](o), o.$on("measure", e[21])), {
        c() {
            t = Mn("div"), o && Pr(o.$$.fragment), Fn(t, "data-util", e[5]), Fn(t, "class", n = al(["PinturaPanel", e[2]])), Fn(t, "style", e[6])
        },
        m(e, i) {
            Cn(e, t, i), o && Ar(o, t, null), r = !0
        },
        p(e, [d]) {
            const u = 128 & d ? Mr(a, [Tr(e[7])]) : {};
            if (!i && 32 & d && (i = !0, u.name = e[5], sr((() => i = !1))), l !== (l = e[11])) {
                if (o) {
                    fr();
                    const e = o;
                    xr(e.$$.fragment, 1, 0, (() => {
                        Ir(e, 1)
                    })), $r()
                }
                l ? (o = new l(c(e)), tr.push((() => Rr(o, "name", s))), e[20](o), o.$on("measure", e[21]), Pr(o.$$.fragment), yr(o.$$.fragment, 1), Ar(o, t, null)) : o = null
            } else l && o.$set(u);
            (!r || 32 & d) && Fn(t, "data-util", e[5]), (!r || 4 & d && n !== (n = al(["PinturaPanel", e[2]]))) && Fn(t, "class", n), (!r || 64 & d) && Fn(t, "style", e[6])
        },
        i(e) {
            r || (o && yr(o.$$.fragment, e), r = !0)
        },
        o(e) {
            o && xr(o.$$.fragment, e), r = !1
        },
        d(i) {
            i && kn(t), e[20](null), o && Ir(o)
        }
    }
}

function Pl(e, t, o) {
    let i, n, r, a;
    const s = Zn();
    let l, {
            isActive: c = !0
        } = t,
        {
            isAnimated: d = !0
        } = t,
        {
            stores: u
        } = t,
        {
            content: h
        } = t,
        {
            component: p
        } = t,
        {
            locale: m
        } = t,
        {
            class: g
        } = t;
    const f = rs(0),
        $ = Or(f, (e => oa(e, 0, 1)));
    cn(e, $, (e => o(18, r = e)));
    let y = !c;
    const x = Dr(c);
    cn(e, x, (e => o(22, a = e)));
    const b = {
            isActive: Or(x, (e => e)),
            isActiveFraction: Or($, (e => e)),
            isVisible: Or($, (e => e > 0))
        },
        v = h.view,
        w = Tl(v),
        S = Object.keys(h.props || {}).reduce(((e, t) => w.includes(t) ? (e[t] = h.props[t], e) : e), {}),
        C = Object.keys(b).reduce(((e, t) => w.includes(t) ? (e[t] = b[t], e) : e), {});
    let k, M = !1;
    Yn((() => {
        o(4, M = !0)
    }));
    return e.$$set = e => {
        "isActive" in e && o(1, c = e.isActive), "isAnimated" in e && o(12, d = e.isAnimated), "stores" in e && o(13, u = e.stores), "content" in e && o(14, h = e.content), "component" in e && o(0, p = e.component), "locale" in e && o(15, m = e.locale), "class" in e && o(2, g = e.class)
    }, e.$$.update = () => {
        11 & e.$$.dirty && l && c && p && s("measure", l), 4098 & e.$$.dirty && f.set(c ? 1 : 0, {
            hard: !d
        }), 393216 & e.$$.dirty && (r <= 0 && !y ? o(17, y = !0) : r > 0 && y && o(17, y = !1)), 131088 & e.$$.dirty && M && s(y ? "hide" : "show"), 262144 & e.$$.dirty && s("fade", r), 262144 & e.$$.dirty && o(6, i = r < 1 ? "opacity: " + r : void 0), 2 & e.$$.dirty && gn(x, a = c, a), 40960 & e.$$.dirty && o(7, n = {
            ...S,
            ...C,
            stores: u,
            locale: m
        })
    }, [p, c, g, l, M, k, i, n, s, $, x, v, d, u, h, m, f, y, r, function (e) {
        k = e, o(5, k)
    }, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            p = e, o(0, p)
        }))
    }, e => {
        M && c && (o(3, l = e.detail), s("measure", {
            ...l
        }))
    }]
}
class Al extends Fr {
    constructor(e) {
        super(), Lr(this, e, Pl, Rl, an, {
            isActive: 1,
            isAnimated: 12,
            stores: 13,
            content: 14,
            component: 0,
            locale: 15,
            class: 2,
            opacity: 16
        })
    }
    get opacity() {
        return this.$$.ctx[16]
    }
}

function Il(e) {
    let t, o, i;
    const n = e[5].default,
        r = dn(n, e, e[4], null);
    return {
        c() {
            t = Tn("svg"), r && r.c(), Fn(t, "class", e[3]), Fn(t, "style", e[2]), Fn(t, "width", e[0]), Fn(t, "height", e[1]), Fn(t, "viewBox", o = "0 0 " + e[0] + "\n    " + e[1]), Fn(t, "xmlns", "http://www.w3.org/2000/svg"), Fn(t, "aria-hidden", "true"), Fn(t, "focusable", "false"), Fn(t, "stroke-linecap", "round"), Fn(t, "stroke-linejoin", "round")
        },
        m(e, o) {
            Cn(e, t, o), r && r.m(t, null), i = !0
        },
        p(e, [a]) {
            r && r.p && 16 & a && hn(r, n, e, e[4], a, null, null), (!i || 8 & a) && Fn(t, "class", e[3]), (!i || 4 & a) && Fn(t, "style", e[2]), (!i || 1 & a) && Fn(t, "width", e[0]), (!i || 2 & a) && Fn(t, "height", e[1]), (!i || 3 & a && o !== (o = "0 0 " + e[0] + "\n    " + e[1])) && Fn(t, "viewBox", o)
        },
        i(e) {
            i || (yr(r, e), i = !0)
        },
        o(e) {
            xr(r, e), i = !1
        },
        d(e) {
            e && kn(t), r && r.d(e)
        }
    }
}

function El(e, t, o) {
    let {
        $$slots: i = {},
        $$scope: n
    } = t, {
        width: r = 24
    } = t, {
        height: a = 24
    } = t, {
        style: s
    } = t, {
        class: l
    } = t;
    return e.$$set = e => {
        "width" in e && o(0, r = e.width), "height" in e && o(1, a = e.height), "style" in e && o(2, s = e.style), "class" in e && o(3, l = e.class), "$$scope" in e && o(4, n = e.$$scope)
    }, [r, a, s, l, n, i]
}
class Ll extends Fr {
    constructor(e) {
        super(), Lr(this, e, El, Il, an, {
            width: 0,
            height: 1,
            style: 2,
            class: 3
        })
    }
}
var Fl = (e, t) => t === e.target || t.contains(e.target);

function zl(e) {
    let t, o;
    return t = new Ll({
        props: {
            class: "PinturaButtonIcon",
            $$slots: {
                default: [Bl]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            1048578 & o && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Bl(e) {
    let t;
    return {
        c() {
            t = Tn("g")
        },
        m(o, i) {
            Cn(o, t, i), t.innerHTML = e[1]
        },
        p(e, o) {
            2 & o && (t.innerHTML = e[1])
        },
        d(e) {
            e && kn(t)
        }
    }
}

function Dl(e) {
    let t, o;
    return {
        c() {
            t = Mn("span"), o = Rn(e[0]), Fn(t, "class", e[11])
        },
        m(e, i) {
            Cn(e, t, i), Sn(t, o)
        },
        p(e, i) {
            1 & i && Bn(o, e[0]), 2048 & i && Fn(t, "class", e[11])
        },
        d(e) {
            e && kn(t)
        }
    }
}

function Ol(e) {
    let t, o, i, n;
    const r = e[18].default,
        a = dn(r, e, e[20], null),
        s = a || function (e) {
            let t, o, i, n = e[1] && zl(e),
                r = e[0] && Dl(e);
            return {
                c() {
                    t = Mn("span"), n && n.c(), o = Pn(), r && r.c(), Fn(t, "class", e[9])
                },
                m(e, a) {
                    Cn(e, t, a), n && n.m(t, null), Sn(t, o), r && r.m(t, null), i = !0
                },
                p(e, a) {
                    e[1] ? n ? (n.p(e, a), 2 & a && yr(n, 1)) : (n = zl(e), n.c(), yr(n, 1), n.m(t, o)) : n && (fr(), xr(n, 1, 1, (() => {
                        n = null
                    })), $r()), e[0] ? r ? r.p(e, a) : (r = Dl(e), r.c(), r.m(t, null)) : r && (r.d(1), r = null), (!i || 512 & a) && Fn(t, "class", e[9])
                },
                i(e) {
                    i || (yr(n), i = !0)
                },
                o(e) {
                    xr(n), i = !1
                },
                d(e) {
                    e && kn(t), n && n.d(), r && r.d()
                }
            }
        }(e);
    return {
        c() {
            t = Mn("button"), s && s.c(), Fn(t, "type", e[4]), Fn(t, "style", e[2]), t.disabled = e[3], Fn(t, "class", e[10]), Fn(t, "title", e[0])
        },
        m(r, a) {
            Cn(r, t, a), s && s.m(t, null), e[19](t), o = !0, i || (n = [In(t, "keydown", (function () {
                rn(e[6]) && e[6].apply(this, arguments)
            })), In(t, "click", (function () {
                rn(e[5]) && e[5].apply(this, arguments)
            })), fn(e[7].call(null, t))], i = !0)
        },
        p(i, [n]) {
            e = i, a ? a.p && 1048576 & n && hn(a, r, e, e[20], n, null, null) : s && s.p && 2563 & n && s.p(e, n), (!o || 16 & n) && Fn(t, "type", e[4]), (!o || 4 & n) && Fn(t, "style", e[2]), (!o || 8 & n) && (t.disabled = e[3]), (!o || 1024 & n) && Fn(t, "class", e[10]), (!o || 1 & n) && Fn(t, "title", e[0])
        },
        i(e) {
            o || (yr(s, e), o = !0)
        },
        o(e) {
            xr(s, e), o = !1
        },
        d(o) {
            o && kn(t), s && s.d(o), e[19](null), i = !1, nn(n)
        }
    }
}

function _l(e, t, o) {
    let i, n, r, a, {
            $$slots: s = {},
            $$scope: l
        } = t,
        {
            class: c
        } = t,
        {
            label: d
        } = t,
        {
            labelClass: u
        } = t,
        {
            innerClass: h
        } = t,
        {
            hideLabel: p = !1
        } = t,
        {
            icon: m
        } = t,
        {
            style: g
        } = t,
        {
            disabled: f
        } = t,
        {
            type: $ = "button"
        } = t,
        {
            onclick: y
        } = t,
        {
            onkeydown: x
        } = t,
        {
            action: b = (() => {})
        } = t;
    return e.$$set = e => {
        "class" in e && o(12, c = e.class), "label" in e && o(0, d = e.label), "labelClass" in e && o(13, u = e.labelClass), "innerClass" in e && o(14, h = e.innerClass), "hideLabel" in e && o(15, p = e.hideLabel), "icon" in e && o(1, m = e.icon), "style" in e && o(2, g = e.style), "disabled" in e && o(3, f = e.disabled), "type" in e && o(4, $ = e.type), "onclick" in e && o(5, y = e.onclick), "onkeydown" in e && o(6, x = e.onkeydown), "action" in e && o(7, b = e.action), "$$scope" in e && o(20, l = e.$$scope)
    }, e.$$.update = () => {
        16384 & e.$$.dirty && o(9, i = al(["PinturaButtonInner", h])), 36864 & e.$$.dirty && o(10, n = al(["PinturaButton", p && "PinturaButtonIconOnly", c])), 40960 & e.$$.dirty && o(11, r = al([p ? "implicit" : "PinturaButtonLabel", u]))
    }, [d, m, g, f, $, y, x, b, a, i, n, r, c, u, h, p, e => Fl(e, a), () => a, s, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            a = e, o(8, a)
        }))
    }, l]
}
class Wl extends Fr {
    constructor(e) {
        super(), Lr(this, e, _l, Ol, an, {
            class: 12,
            label: 0,
            labelClass: 13,
            innerClass: 14,
            hideLabel: 15,
            icon: 1,
            style: 2,
            disabled: 3,
            type: 4,
            onclick: 5,
            onkeydown: 6,
            action: 7,
            isEventTarget: 16,
            getElement: 17
        })
    }
    get isEventTarget() {
        return this.$$.ctx[16]
    }
    get getElement() {
        return this.$$.ctx[17]
    }
}
var Vl = (e, t) => {
    const o = e.findIndex(t);
    if (o >= 0) return e.splice(o, 1)
};
var Hl = (e, t = {}) => {
        const {
            inertia: o = !1,
            matchTarget: i = !1,
            pinch: n = !1,
            getEventPosition: r = (e => Y(e.clientX, e.clientY))
        } = t;

        function a(t, o) {
            e.dispatchEvent(new CustomEvent(t, {
                detail: o
            }))
        }

        function s() {
            f && f(), f = void 0
        }
        const l = [],
            c = e => 0 === e.timeStamp ? Date.now() : e.timeStamp,
            d = e => {
                e.origin.x = e.position.x, e.origin.y = e.position.y, e.translation.x = 0, e.translation.y = 0
            },
            u = e => {
                const t = (e => l.findIndex((t => t.event.pointerId === e.pointerId)))(e);
                if (!(t < 0)) return l[t]
            },
            h = () => 1 === l.length,
            p = () => 2 === l.length,
            m = e => {
                const t = ue(e.map((e => e.position)));
                return {
                    center: t,
                    distance: ((e, t) => e.reduce(((e, o) => e + ce(t, o.position)), 0) / e.length)(e, t),
                    velocity: ue(e.map((e => e.velocity))),
                    translation: ue(e.map((e => e.translation)))
                }
            };
        let g, f, $, y, x, b, v = 0,
            w = void 0;

        function S(t) {
            p() || (e => Zt(e.button) && 0 !== e.button)(t) || i && t.target !== e || (s(), (e => {
                const t = c(e),
                    o = {
                        timeStamp: t,
                        timeStampInitial: t,
                        position: r(e),
                        origin: r(e),
                        velocity: X(),
                        translation: X(),
                        interactionState: void 0,
                        event: e
                    };
                l.push(o), o.interactionState = m(l)
            })(t), h() ? (document.documentElement.addEventListener("pointermove", k), document.documentElement.addEventListener("pointerup", M), document.documentElement.addEventListener("pointercancel", M), b = !1, x = 1, y = X(), $ = void 0, a("interactionstart", {
                origin: Z(u(t).origin)
            })) : n && (b = !0, $ = ce(l[0].position, l[1].position), y.x += l[0].translation.x, y.y += l[0].translation.y, d(l[0])))
        }
        e.addEventListener("pointerdown", S);
        let C = Date.now();

        function k(e) {
            e.preventDefault(), (e => {
                const t = u(e);
                if (!t) return;
                const o = c(e),
                    i = r(e),
                    n = Math.max(1, o - t.timeStamp);
                t.velocity.x = (i.x - t.position.x) / n, t.velocity.y = (i.y - t.position.y) / n, t.translation.x = i.x - t.origin.x, t.translation.y = i.y - t.origin.y, t.timeStamp = o, t.position.x = i.x, t.position.y = i.y, t.event = e
            })(e);
            const t = Z(l[0].translation);
            let o = x;
            if (n && p()) {
                o *= ce(l[0].position, l[1].position) / $, ne(t, l[1].translation)
            }
            t.x += y.x, t.y += y.y;
            const i = Date.now();
            i - C < 16 || (C = i, a("interactionupdate", {
                translation: t,
                scalar: n ? o : void 0
            }))
        }

        function M(e) {
            if (!u(e)) return;
            const t = (e => {
                const t = Vl(l, (t => t.event.pointerId === e.pointerId));
                if (t) return t[0]
            })(e);
            if (n && h()) {
                const e = ce(l[0].position, t.position);
                x *= e / $, y.x += l[0].translation.x + t.translation.x, y.y += l[0].translation.y + t.translation.y, d(l[0])
            }
            let i = !1,
                r = !1;
            if (!b && t) {
                const e = performance.now(),
                    o = e - t.timeStampInitial,
                    n = le(t.translation);
                i = n < 64 && o < 300, r = !!(w && i && e - v < 700 && le(w, t.position) < 128), i && (w = Z(t.position), v = e)
            }
            if (l.length > 0) return;
            document.documentElement.removeEventListener("pointermove", k), document.documentElement.removeEventListener("pointerup", M), document.documentElement.removeEventListener("pointercancel", M);
            const s = Z(t.translation),
                c = Z(t.velocity);
            let p = !1;
            a("interactionrelease", {
                isTap: i,
                isDoubleTap: r,
                translation: s,
                scalar: x,
                preventInertia: () => p = !0
            });
            const m = ce(c);
            if (p || !o || m < .25) return R(s, {
                isTap: i,
                isDoubleTap: r
            });
            g = is(Z(s), {
                easing: es,
                duration: 80 * m
            }), g.set({
                x: s.x + 50 * c.x,
                y: s.y + 50 * c.y
            }).then((() => {
                f && R(ln(g), {
                    isTap: i,
                    isDoubleTap: r
                })
            })), f = g.subscribe(T)
        }

        function T(e) {
            e && a("interactionupdate", {
                translation: e,
                scalar: n ? x : void 0
            })
        }

        function R(e, t) {
            s(), a("interactionend", {
                ...t,
                translation: e,
                scalar: n ? x : void 0
            })
        }
        return {
            destroy() {
                s(), e.removeEventListener("pointerdown", S)
            }
        }
    },
    Nl = (e, t = {}) => {
        const {
            direction: o,
            shiftMultiplier: i = 10,
            bubbles: n = !1,
            stopKeydownPropagation: r = !0
        } = t, a = "horizontal" === o, s = "vertical" === o, l = t => {
            const {
                key: o
            } = t, l = t.shiftKey, c = /up|down/i.test(o), d = /left|right/i.test(o);
            if (!d && !c) return;
            if (a && c) return;
            if (s && d) return;
            const u = l ? i : 1;
            r && t.stopPropagation(), e.dispatchEvent(new CustomEvent("nudge", {
                bubbles: n,
                detail: Y((/left/i.test(o) ? -1 : /right/i.test(o) ? 1 : 0) * u, (/up/i.test(o) ? -1 : /down/i.test(o) ? 1 : 0) * u)
            }))
        };
        return e.addEventListener("keydown", l), {
            destroy() {
                e.removeEventListener("keydown", l)
            }
        }
    };

function Ul(e, t) {
    return t * Math.sign(e) * Math.log10(1 + Math.abs(e) / t)
}
const jl = (e, t, o) => {
    if (!t) return Ee(e);
    const i = e.x + Ul(t.x - e.x, o),
        n = e.x + e.width + Ul(t.x + t.width - (e.x + e.width), o),
        r = e.y + Ul(t.y - e.y, o);
    return {
        x: i,
        y: r,
        width: n - i,
        height: e.y + e.height + Ul(t.y + t.height - (e.y + e.height), o) - r
    }
};
var Xl = (e, t) => {
        if (e) return /em/.test(e) ? 16 * parseInt(e, 10) : /px/.test(e) ? parseInt(e, 10) : void 0
    },
    Yl = e => {
        let t = e.detail || 0;
        const {
            deltaX: o,
            deltaY: i,
            wheelDelta: n,
            wheelDeltaX: r,
            wheelDeltaY: a
        } = e;
        return Zt(r) && Math.abs(r) > Math.abs(a) ? t = r / -120 : Zt(o) && Math.abs(o) > Math.abs(i) ? t = o / 20 : (n || a) && (t = (n || a) / -120), t || (t = i / 20), t
    },
    Gl = {
        Up: 38,
        Down: 40,
        Left: 37,
        Right: 39
    };

function ql(e) {
    let t, o, i, n, r, a, s;
    const l = e[37].default,
        c = dn(l, e, e[36], null);
    return {
        c() {
            t = Mn("div"), o = Mn("div"), c && c.c(), Fn(o, "style", e[6]), Fn(t, "class", i = al(["PinturaScrollable", e[0]])), Fn(t, "style", e[4]), Fn(t, "data-direction", e[1]), Fn(t, "data-state", e[5])
        },
        m(i, l) {
            Cn(i, t, l), Sn(t, o), c && c.m(o, null), e[39](t), r = !0, a || (s = [In(o, "interactionstart", e[9]), In(o, "interactionupdate", e[11]), In(o, "interactionend", e[12]), In(o, "interactionrelease", e[10]), fn(Hl.call(null, o, {
                inertia: !0
            })), In(o, "measure", e[38]), fn($s.call(null, o)), In(t, "wheel", e[14], {
                passive: !1
            }), In(t, "scroll", e[16]), In(t, "focusin", e[15]), In(t, "nudge", e[17]), In(t, "measure", e[13]), fn($s.call(null, t, {
                observePosition: !0
            })), fn(n = Nl.call(null, t, {
                direction: "x" === e[1] ? "horizontal" : "vertical",
                stopKeydownPropagation: !1
            }))], a = !0)
        },
        p(e, a) {
            c && c.p && 32 & a[1] && hn(c, l, e, e[36], a, null, null), (!r || 64 & a[0]) && Fn(o, "style", e[6]), (!r || 1 & a[0] && i !== (i = al(["PinturaScrollable", e[0]]))) && Fn(t, "class", i), (!r || 16 & a[0]) && Fn(t, "style", e[4]), (!r || 2 & a[0]) && Fn(t, "data-direction", e[1]), (!r || 32 & a[0]) && Fn(t, "data-state", e[5]), n && rn(n.update) && 2 & a[0] && n.update.call(null, {
                direction: "x" === e[1] ? "horizontal" : "vertical",
                stopKeydownPropagation: !1
            })
        },
        i(e) {
            r || (yr(c, e), r = !0)
        },
        o(e) {
            xr(c, e), r = !1
        },
        d(o) {
            o && kn(t), c && c.d(o), e[39](null), a = !1, nn(s)
        }
    }
}

function Zl(e, t, o) {
    let i, r, a, s, l, c, d, u, h, {
        $$slots: p = {},
        $$scope: m
    } = t;
    const g = Zn(),
        f = Object.values(Gl),
        $ = Jn("keysPressed");
    cn(e, $, (e => o(46, h = e)));
    let y, x, b, v, w = "idle",
        S = rs(0);
    cn(e, S, (e => o(34, u = e)));
    let C, {
            class: k
        } = t,
        {
            scrollBlockInteractionDist: M = 5
        } = t,
        {
            scrollStep: T = 10
        } = t,
        {
            scrollFocusMargin: R = 64
        } = t,
        {
            scrollDirection: P = "x"
        } = t,
        {
            scrollAutoCancel: A = !1
        } = t,
        {
            elasticity: I = 0
        } = t,
        {
            onscroll: E = n
        } = t,
        {
            maskFeatherSize: L
        } = t,
        {
            maskFeatherStartOpacity: F
        } = t,
        {
            maskFeatherEndOpacity: z
        } = t,
        {
            scroll: B
        } = t,
        D = "",
        O = !0;
    const _ = S.subscribe((e => {
            const t = X();
            t[P] = e, E(t)
        })),
        W = e => Math.max(Math.min(0, e), b[i] - x[i]);
    let V, H, N;
    const U = (e, t = {}) => {
        const {
            elastic: i = !1,
            animate: n = !1
        } = t;
        Math.abs(e) > M && "idle" === w && !v && o(28, w = "scrolling");
        const r = W(e),
            a = i && I && !v ? r + Ul(e - r, I) : r;
        let s = !0;
        n ? s = !1 : O || (s = !v), O = !1, S.set(a, {
            hard: s
        }).then((e => {
            v && (O = !0)
        }))
    };
    qn((() => {
        _()
    }));
    return e.$$set = e => {
        "class" in e && o(0, k = e.class), "scrollBlockInteractionDist" in e && o(21, M = e.scrollBlockInteractionDist), "scrollStep" in e && o(22, T = e.scrollStep), "scrollFocusMargin" in e && o(23, R = e.scrollFocusMargin), "scrollDirection" in e && o(1, P = e.scrollDirection), "scrollAutoCancel" in e && o(24, A = e.scrollAutoCancel), "elasticity" in e && o(25, I = e.elasticity), "onscroll" in e && o(26, E = e.onscroll), "maskFeatherSize" in e && o(20, L = e.maskFeatherSize), "maskFeatherStartOpacity" in e && o(18, F = e.maskFeatherStartOpacity), "maskFeatherEndOpacity" in e && o(19, z = e.maskFeatherEndOpacity), "scroll" in e && o(27, B = e.scroll), "$$scope" in e && o(36, m = e.$$scope)
    }, e.$$.update = () => {
        if (2 & e.$$.dirty[0] && o(30, i = "x" === P ? "width" : "height"), 2 & e.$$.dirty[0] && o(31, r = P.toUpperCase()), 8 & e.$$.dirty[0] && o(32, a = C && getComputedStyle(C)), 8 & e.$$.dirty[0] | 2 & e.$$.dirty[1] && o(33, s = a && Xl(a.getPropertyValue("--scrollable-feather-size"))), 1611399172 & e.$$.dirty[0] | 12 & e.$$.dirty[1] && null != u && b && null != s && x) {
            const e = -1 * u / s,
                t = -(b[i] - x[i] - u) / s;
            o(18, F = oa(1 - e, 0, 1)), o(19, z = oa(1 - t, 0, 1)), o(20, L = s), o(4, D = `--scrollable-feather-start-opacity: ${F};--scrollable-feather-end-opacity: ${z}`)
        }
        134217736 & e.$$.dirty[0] && C && void 0 !== B && (Zt(B) ? U(B) : U(B.scrollOffset, B)), 1610612740 & e.$$.dirty[0] && o(35, l = b && x ? x[i] > b[i] : void 0), 268435456 & e.$$.dirty[0] | 16 & e.$$.dirty[1] && o(5, c = al([w, l ? "overflows" : void 0])), 25 & e.$$.dirty[1] && o(6, d = l ? `transform: translate${r}(${u}px)` : void 0)
    }, [k, P, x, C, D, c, d, $, S, () => {
        l && (H = !1, V = !0, N = Y(0, 0), v = !1, o(28, w = "idle"), y = ln(S))
    }, ({
        detail: e
    }) => {
        l && (v = !0, o(28, w = "idle"))
    }, ({
        detail: e
    }) => {
        l && (H || V && (V = !1, le(e.translation) < .1) || (!A || "x" !== P || (e => {
            const t = ie(Y(e.x - N.x, e.y - N.y), Math.abs);
            N = Z(e);
            const o = le(t),
                i = t.x - t.y;
            return !(o > 1 && i < -.5)
        })(e.translation) ? U(y + e.translation[P], {
            elastic: !0
        }) : H = !0))
    }, ({
        detail: e
    }) => {
        if (!l) return;
        if (H) return;
        const t = y + e.translation[P],
            o = W(t);
        O = !1, S.set(o).then((e => {
            v && (O = !0)
        }))
    }, ({
        detail: e
    }) => {
        o(29, b = e), g("measure", {
            x: e.x,
            y: e.y,
            width: e.width,
            height: e.height
        })
    }, e => {
        if (!l) return;
        e.preventDefault(), e.stopPropagation();
        const t = Yl(e),
            o = ln(S);
        U(o + t * T, {
            animate: !0
        })
    }, e => {
        if (!l) return;
        if (!v) return;
        if (h.some((e => f.includes(e)))) return;
        let t = e.target;
        e.target.classList.contains("implicit") && (t = t.parentNode);
        const o = t["x" === P ? "offsetLeft" : "offsetTop"],
            n = o + t["x" === P ? "offsetWidth" : "offsetHeight"],
            r = ln(S),
            a = R + L;
        r + o < a ? U(-o + a) : r + n > b[i] - a && U(b[i] - n - a, {
            animate: !0
        })
    }, () => {
        o(3, C["x" === P ? "scrollLeft" : "scrollTop"] = 0, C)
    }, ({
        detail: e
    }) => {
        const t = -2 * e[P],
            o = ln(S);
        U(o + t * T, {
            animate: !0
        })
    }, F, z, L, M, T, R, A, I, E, B, w, b, i, r, a, s, u, l, m, p, e => o(2, x = e.detail), function (e) {
        tr[e ? "unshift" : "push"]((() => {
            C = e, o(3, C)
        }))
    }]
}
class Kl extends Fr {
    constructor(e) {
        super(), Lr(this, e, Zl, ql, an, {
            class: 0,
            scrollBlockInteractionDist: 21,
            scrollStep: 22,
            scrollFocusMargin: 23,
            scrollDirection: 1,
            scrollAutoCancel: 24,
            elasticity: 25,
            onscroll: 26,
            maskFeatherSize: 20,
            maskFeatherStartOpacity: 18,
            maskFeatherEndOpacity: 19,
            scroll: 27
        }, [-1, -1])
    }
}

function Jl(e, {
    delay: t = 0,
    duration: o = 400,
    easing: i = Qi
} = {}) {
    const n = +getComputedStyle(e).opacity;
    return {
        delay: t,
        duration: o,
        easing: i,
        css: e => "opacity: " + e * n
    }
}

function Ql(e) {
    let t, o, i, n, r, a;
    return {
        c() {
            t = Mn("span"), o = Rn(e[0]), Fn(t, "class", "PinturaStatusMessage")
        },
        m(i, s) {
            Cn(i, t, s), Sn(t, o), n = !0, r || (a = [In(t, "measure", (function () {
                rn(e[1]) && e[1].apply(this, arguments)
            })), fn($s.call(null, t))], r = !0)
        },
        p(t, [i]) {
            e = t, (!n || 1 & i) && Bn(o, e[0])
        },
        i(e) {
            n || (ar((() => {
                i || (i = vr(t, Jl, {}, !0)), i.run(1)
            })), n = !0)
        },
        o(e) {
            i || (i = vr(t, Jl, {}, !1)), i.run(0), n = !1
        },
        d(e) {
            e && kn(t), e && i && i.end(), r = !1, nn(a)
        }
    }
}

function ec(e, t, o) {
    let {
        text: i
    } = t, {
        onmeasure: r = n
    } = t;
    return e.$$set = e => {
        "text" in e && o(0, i = e.text), "onmeasure" in e && o(1, r = e.onmeasure)
    }, [i, r]
}
class tc extends Fr {
    constructor(e) {
        super(), Lr(this, e, ec, Ql, an, {
            text: 0,
            onmeasure: 1
        })
    }
}

function oc(e) {
    let t, o, i, n, r, a, s, l;
    return {
        c() {
            t = Mn("span"), o = Tn("svg"), i = Tn("g"), n = Tn("circle"), r = Tn("circle"), a = Pn(), s = Mn("span"), l = Rn(e[0]), Fn(n, "class", "PinturaProgressIndicatorBar"), Fn(n, "r", "8.5"), Fn(n, "cx", "10"), Fn(n, "cy", "10"), Fn(n, "stroke-linecap", "round"), Fn(n, "opacity", ".25"), Fn(r, "class", "PinturaProgressIndicatorFill"), Fn(r, "r", "8.5"), Fn(r, "stroke-dasharray", e[1]), Fn(r, "cx", "10"), Fn(r, "cy", "10"), Fn(r, "transform", "rotate(-90) translate(-20)"), Fn(i, "fill", "none"), Fn(i, "stroke", "currentColor"), Fn(i, "stroke-width", "2.5"), Fn(i, "stroke-linecap", "round"), Fn(i, "opacity", e[2]), Fn(o, "width", "20"), Fn(o, "height", "20"), Fn(o, "viewBox", "0 0 20 20"), Fn(o, "xmlns", "http://www.w3.org/2000/svg"), Fn(o, "aria-hidden", "true"), Fn(o, "focusable", "false"), Fn(s, "class", "implicit"), Fn(t, "class", "PinturaProgressIndicator"), Fn(t, "data-status", e[3])
        },
        m(e, c) {
            Cn(e, t, c), Sn(t, o), Sn(o, i), Sn(i, n), Sn(i, r), Sn(t, a), Sn(t, s), Sn(s, l)
        },
        p(e, [o]) {
            2 & o && Fn(r, "stroke-dasharray", e[1]), 4 & o && Fn(i, "opacity", e[2]), 1 & o && Bn(l, e[0]), 8 & o && Fn(t, "data-status", e[3])
        },
        i: Ji,
        o: Ji,
        d(e) {
            e && kn(t)
        }
    }
}

function ic(e, t, o) {
    let i, n, r, a, s;
    const l = Zn();
    let {
        progress: c
    } = t, {
        min: d = 0
    } = t, {
        max: u = 100
    } = t, {
        labelBusy: h = "Busy"
    } = t;
    const p = rs(0, {
            precision: .01
        }),
        m = Or([p], (e => oa(e, d, u)));
    cn(e, m, (e => o(9, s = e)));
    const g = m.subscribe((e => {
        1 === c && Math.round(e) >= 100 && l("complete")
    }));
    return qn((() => {
        g()
    })), e.$$set = e => {
        "progress" in e && o(5, c = e.progress), "min" in e && o(6, d = e.min), "max" in e && o(7, u = e.max), "labelBusy" in e && o(8, h = e.labelBusy)
    }, e.$$.update = () => {
        32 & e.$$.dirty && c && c !== 1 / 0 && p.set(100 * c), 800 & e.$$.dirty && o(0, i = c === 1 / 0 ? h : Math.round(s) + "%"), 544 & e.$$.dirty && o(1, n = c === 1 / 0 ? "26.5 53" : s / 100 * 53 + " 53"), 544 & e.$$.dirty && o(2, r = Math.min(1, c === 1 / 0 ? 1 : s / 10)), 32 & e.$$.dirty && o(3, a = c === 1 / 0 ? "busy" : "loading")
    }, [i, n, r, a, m, c, d, u, h, s]
}
class nc extends Fr {
    constructor(e) {
        super(), Lr(this, e, ic, oc, an, {
            progress: 5,
            min: 6,
            max: 7,
            labelBusy: 8
        })
    }
}

function rc(e) {
    let t, o, i;
    const n = e[5].default,
        r = dn(n, e, e[4], null);
    return {
        c() {
            t = Mn("span"), r && r.c(), Fn(t, "class", o = "PinturaStatusAside " + e[0]), Fn(t, "style", e[1])
        },
        m(e, o) {
            Cn(e, t, o), r && r.m(t, null), i = !0
        },
        p(e, [a]) {
            r && r.p && 16 & a && hn(r, n, e, e[4], a, null, null), (!i || 1 & a && o !== (o = "PinturaStatusAside " + e[0])) && Fn(t, "class", o), (!i || 2 & a) && Fn(t, "style", e[1])
        },
        i(e) {
            i || (yr(r, e), i = !0)
        },
        o(e) {
            xr(r, e), i = !1
        },
        d(e) {
            e && kn(t), r && r.d(e)
        }
    }
}

function ac(e, t, o) {
    let i, {
            $$slots: n = {},
            $$scope: r
        } = t,
        {
            offset: a = 0
        } = t,
        {
            opacity: s = 0
        } = t,
        {
            class: l
        } = t;
    return e.$$set = e => {
        "offset" in e && o(2, a = e.offset), "opacity" in e && o(3, s = e.opacity), "class" in e && o(0, l = e.class), "$$scope" in e && o(4, r = e.$$scope)
    }, e.$$.update = () => {
        12 & e.$$.dirty && o(1, i = `transform:translateX(${a}px);opacity:${s}`)
    }, [l, i, a, s, r, n]
}
class sc extends Fr {
    constructor(e) {
        super(), Lr(this, e, ac, rc, an, {
            offset: 2,
            opacity: 3,
            class: 0
        })
    }
}

function lc(e) {
    let t, o, i;
    const n = e[3].default,
        r = dn(n, e, e[2], null);
    let a = [{
            for: o = "_"
        }, e[1]],
        s = {};
    for (let e = 0; e < a.length; e += 1) s = en(s, a[e]);
    return {
        c() {
            t = Mn("label"), r && r.c(), zn(t, s)
        },
        m(e, o) {
            Cn(e, t, o), r && r.m(t, null), i = !0
        },
        p(e, o) {
            r && r.p && 4 & o && hn(r, n, e, e[2], o, null, null), zn(t, s = Mr(a, [{
                for: "_"
            }, 2 & o && e[1]]))
        },
        i(e) {
            i || (yr(r, e), i = !0)
        },
        o(e) {
            xr(r, e), i = !1
        },
        d(e) {
            e && kn(t), r && r.d(e)
        }
    }
}

function cc(e) {
    let t, o;
    const i = e[3].default,
        n = dn(i, e, e[2], null);
    let r = [e[1]],
        a = {};
    for (let e = 0; e < r.length; e += 1) a = en(a, r[e]);
    return {
        c() {
            t = Mn("div"), n && n.c(), zn(t, a)
        },
        m(e, i) {
            Cn(e, t, i), n && n.m(t, null), o = !0
        },
        p(e, o) {
            n && n.p && 4 & o && hn(n, i, e, e[2], o, null, null), zn(t, a = Mr(r, [2 & o && e[1]]))
        },
        i(e) {
            o || (yr(n, e), o = !0)
        },
        o(e) {
            xr(n, e), o = !1
        },
        d(e) {
            e && kn(t), n && n.d(e)
        }
    }
}

function dc(e) {
    let t, o;
    const i = e[3].default,
        n = dn(i, e, e[2], null);
    let r = [e[1]],
        a = {};
    for (let e = 0; e < r.length; e += 1) a = en(a, r[e]);
    return {
        c() {
            t = Mn("div"), n && n.c(), zn(t, a)
        },
        m(e, i) {
            Cn(e, t, i), n && n.m(t, null), o = !0
        },
        p(e, o) {
            n && n.p && 4 & o && hn(n, i, e, e[2], o, null, null), zn(t, a = Mr(r, [2 & o && e[1]]))
        },
        i(e) {
            o || (yr(n, e), o = !0)
        },
        o(e) {
            xr(n, e), o = !1
        },
        d(e) {
            e && kn(t), n && n.d(e)
        }
    }
}

function uc(e) {
    let t, o, i, n;
    const r = [dc, cc, lc],
        a = [];

    function s(e, t) {
        return "div" === e[0] ? 0 : "span" === e[0] ? 1 : "label" === e[0] ? 2 : -1
    }
    return ~(t = s(e)) && (o = a[t] = r[t](e)), {
        c() {
            o && o.c(), i = An()
        },
        m(e, o) {
            ~t && a[t].m(e, o), Cn(e, i, o), n = !0
        },
        p(e, [n]) {
            let l = t;
            t = s(e), t === l ? ~t && a[t].p(e, n) : (o && (fr(), xr(a[l], 1, 1, (() => {
                a[l] = null
            })), $r()), ~t ? (o = a[t], o ? o.p(e, n) : (o = a[t] = r[t](e), o.c()), yr(o, 1), o.m(i.parentNode, i)) : o = null)
        },
        i(e) {
            n || (yr(o), n = !0)
        },
        o(e) {
            xr(o), n = !1
        },
        d(e) {
            ~t && a[t].d(e), e && kn(i)
        }
    }
}

function hc(e, t, o) {
    let {
        $$slots: i = {},
        $$scope: n
    } = t, {
        name: r = "div"
    } = t, {
        attributes: a = {}
    } = t;
    return e.$$set = e => {
        "name" in e && o(0, r = e.name), "attributes" in e && o(1, a = e.attributes), "$$scope" in e && o(2, n = e.$$scope)
    }, [r, a, n, i]
}
class pc extends Fr {
    constructor(e) {
        super(), Lr(this, e, hc, uc, an, {
            name: 0,
            attributes: 1
        })
    }
}
var mc = () => c() && window.devicePixelRatio || 1;
let gc = null;
var fc = e => (null === gc && (gc = 1 === mc() ? Math.round : e => e), gc(e));
const $c = e => ({}),
    yc = e => ({}),
    xc = e => ({}),
    bc = e => ({});

function vc(e) {
    let t;
    const o = e[35].label,
        i = dn(o, e, e[39], bc);
    return {
        c() {
            i && i.c()
        },
        m(e, o) {
            i && i.m(e, o), t = !0
        },
        p(e, t) {
            i && i.p && 256 & t[1] && hn(i, o, e, e[39], t, xc, bc)
        },
        i(e) {
            t || (yr(i, e), t = !0)
        },
        o(e) {
            xr(i, e), t = !1
        },
        d(e) {
            i && i.d(e)
        }
    }
}

function wc(e) {
    let t, o, i, n, r, a, s;
    const l = e[35].details,
        c = dn(l, e, e[39], yc);
    return {
        c() {
            t = Mn("div"), c && c.c(), o = Pn(), i = Mn("span"), Fn(i, "class", "PinturaDetailsPanelTip"), Fn(i, "style", e[7]), Fn(t, "class", n = al(["PinturaDetailsPanel", e[1]])), Fn(t, "tabindex", "-1"), Fn(t, "style", e[6])
        },
        m(n, l) {
            Cn(n, t, l), c && c.m(t, null), Sn(t, o), Sn(t, i), e[37](t), r = !0, a || (s = [In(t, "keydown", e[17]), In(t, "measure", e[38]), fn($s.call(null, t))], a = !0)
        },
        p(e, o) {
            c && c.p && 256 & o[1] && hn(c, l, e, e[39], o, $c, yc), (!r || 128 & o[0]) && Fn(i, "style", e[7]), (!r || 2 & o[0] && n !== (n = al(["PinturaDetailsPanel", e[1]]))) && Fn(t, "class", n), (!r || 64 & o[0]) && Fn(t, "style", e[6])
        },
        i(e) {
            r || (yr(c, e), r = !0)
        },
        o(e) {
            xr(c, e), r = !1
        },
        d(o) {
            o && kn(t), c && c.d(o), e[37](null), a = !1, nn(s)
        }
    }
}

function Sc(e) {
    let t, o, i, n, r, a, s, l, c = {
        class: al(["PinturaDetailsButton", e[0]]),
        onkeydown: e[16],
        onclick: e[15],
        $$slots: {
            default: [vc]
        },
        $$scope: {
            ctx: e
        }
    };
    o = new Wl({
        props: c
    }), e[36](o);
    let d = e[5] && wc(e);
    return {
        c() {
            t = Pn(), Pr(o.$$.fragment), i = Pn(), d && d.c(), n = Pn(), r = An()
        },
        m(c, u) {
            Cn(c, t, u), Ar(o, c, u), Cn(c, i, u), d && d.m(c, u), Cn(c, n, u), Cn(c, r, u), a = !0, s || (l = [In(document.body, "pointerdown", (function () {
                rn(e[8]) && e[8].apply(this, arguments)
            })), In(document.body, "pointerup", (function () {
                rn(e[9]) && e[9].apply(this, arguments)
            }))], s = !0)
        },
        p(t, i) {
            e = t;
            const r = {};
            1 & i[0] && (r.class = al(["PinturaDetailsButton", e[0]])), 256 & i[1] && (r.$$scope = {
                dirty: i,
                ctx: e
            }), o.$set(r), e[5] ? d ? (d.p(e, i), 32 & i[0] && yr(d, 1)) : (d = wc(e), d.c(), yr(d, 1), d.m(n.parentNode, n)) : d && (fr(), xr(d, 1, 1, (() => {
                d = null
            })), $r())
        },
        i(e) {
            a || (yr(o.$$.fragment, e), yr(d), yr(false), a = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), xr(d), xr(false), a = !1
        },
        d(a) {
            a && kn(t), e[36](null), Ir(o, a), a && kn(i), d && d.d(a), a && kn(n), a && kn(r), s = !1, nn(l)
        }
    }
}

function Cc(e, t, o) {
    let i, n, r, a, s, l, c, d, u, h, p, m, g, f, $, y, {
            $$slots: x = {},
            $$scope: b
        } = t,
        {
            buttonClass: v
        } = t,
        {
            panelClass: w
        } = t,
        {
            isActive: S = !1
        } = t,
        {
            onshow: C = (({
                panel: e
            }) => e.focus())
        } = t;
    const k = Jn("rootPortal");
    cn(e, k, (e => o(34, y = e)));
    const M = Jn("rootRect");
    let T, R, P;
    cn(e, M, (e => o(27, g = e)));
    let A = X(),
        I = rs(0);
    cn(e, I, (e => o(29, $ = e)));
    let E = X();
    const L = Dr({
        x: 0,
        y: 0
    });
    cn(e, L, (e => o(28, f = e)));
    const F = rs(-5, {
        stiffness: .1,
        damping: .35,
        precision: .001
    });
    cn(e, F, (e => o(26, m = e)));
    const z = e => Fl(e, y) || R.isEventTarget(e);
    let B, D, O = !1;
    qn((() => {
        y && B && !B.parentNode && y.removeChild(B)
    }));
    return e.$$set = e => {
        "buttonClass" in e && o(0, v = e.buttonClass), "panelClass" in e && o(1, w = e.panelClass), "isActive" in e && o(18, S = e.isActive), "onshow" in e && o(19, C = e.onshow), "$$scope" in e && o(39, b = e.$$scope)
    }, e.$$.update = () => {
        if (8 & e.$$.dirty[0] && (i = R && R.getElement()), 8650752 & e.$$.dirty[0] && o(9, p = S ? e => {
                O && (o(23, O = !1), z(e) || o(18, S = !1))
            } : void 0), 262144 & e.$$.dirty[0] && I.set(S ? 1 : 0), 262144 & e.$$.dirty[0] && F.set(S ? 0 : -5), 67108864 & e.$$.dirty[0] && o(25, n = 1 - m / -5), 135266308 & e.$$.dirty[0] && g && T && P) {
            let e = P.x - g.x + .5 * P.width - .5 * T.width,
                t = P.y - g.y + P.height;
            const i = 12,
                n = 12,
                r = g.width - 12,
                a = g.height - 12,
                s = e,
                l = t,
                c = s + T.width,
                d = l + T.height;
            if (s < i && (o(22, E.x = s - i, E), e = i), c > r && (o(22, E.x = c - r, E), e = r - T.width), d > a) {
                o(21, A.y = -1, A);
                n < t - T.height - P.height ? (o(22, E.y = 0, E), t -= T.height + P.height) : (o(22, E.y = t - (d - a), E), t -= d - a)
            } else o(21, A.y = 1, A);
            gn(L, f = ie(Y(e, t), fc), f)
        }
        536870912 & e.$$.dirty[0] && o(5, r = $ > 0), 536870912 & e.$$.dirty[0] && o(30, a = $ < 1), 337641472 & e.$$.dirty[0] && o(31, s = `translateX(${f.x+12*A.x}px) translateY(${f.y+12*A.y+A.y*m}px)`), 1610612736 & e.$$.dirty[0] | 1 & e.$$.dirty[1] && o(6, l = a ? `opacity: ${$}; pointer-events: ${$<1?"none":"all"}; transform: ${s};` : "transform: " + s), 33554432 & e.$$.dirty[0] && o(32, c = .5 + .5 * n), 33554432 & e.$$.dirty[0] && o(33, d = n), 274726916 & e.$$.dirty[0] | 6 & e.$$.dirty[1] && o(7, u = f && T && `opacity:${d};transform:scaleX(${c})rotate(45deg);top:${A.y<0?E.y+T.height:0}px;left:${E.x+.5*T.width}px`), 262144 & e.$$.dirty[0] && o(8, h = S ? e => {
            z(e) || o(23, O = !0)
        } : void 0), 48 & e.$$.dirty[0] | 8 & e.$$.dirty[1] && r && y && B && B.parentNode !== y && y.appendChild(B), 262144 & e.$$.dirty[0] && (S || o(24, D = void 0)), 17301552 & e.$$.dirty[0] && r && B && C({
            e: D,
            panel: B
        })
    }, [v, w, T, R, B, r, l, u, h, p, k, M, I, L, F, e => {
        S || o(20, P = i.getBoundingClientRect()), o(24, D = e), o(18, S = !S)
    }, e => {
        /down/i.test(e.key) && (o(18, S = !0), o(24, D = e))
    }, e => {
        /esc/i.test(e.key) && (o(18, S = !1), i.focus())
    }, S, C, P, A, E, O, D, n, m, g, f, $, a, s, c, d, y, x, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            R = e, o(3, R)
        }))
    }, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            B = e, o(4, B)
        }))
    }, e => o(2, T = fe(e.detail)), b]
}
class kc extends Fr {
    constructor(e) {
        super(), Lr(this, e, Cc, Sc, an, {
            buttonClass: 0,
            panelClass: 1,
            isActive: 18,
            onshow: 19
        }, [-1, -1])
    }
}

function Mc(e) {
    let t, o, i, n, r, a, s, l;
    const c = e[14].default,
        d = dn(c, e, e[13], null);
    return {
        c() {
            t = Mn("li"), o = Mn("input"), i = Pn(), n = Mn("label"), d && d.c(), Fn(o, "type", "radio"), Fn(o, "class", "implicit"), Fn(o, "id", e[6]), Fn(o, "name", e[0]), o.value = e[3], o.disabled = e[5], o.checked = e[4], Fn(n, "for", e[6]), Fn(n, "title", e[2]), Fn(t, "class", r = al(["PinturaRadioGroupOption", e[1]])), Fn(t, "data-disabled", e[5]), Fn(t, "data-selected", e[4])
        },
        m(r, c) {
            Cn(r, t, c), Sn(t, o), Sn(t, i), Sn(t, n), d && d.m(n, null), a = !0, s || (l = [In(o, "change", Ln(e[15])), In(o, "keydown", e[8]), In(o, "click", e[9])], s = !0)
        },
        p(e, [i]) {
            (!a || 64 & i) && Fn(o, "id", e[6]), (!a || 1 & i) && Fn(o, "name", e[0]), (!a || 8 & i) && (o.value = e[3]), (!a || 32 & i) && (o.disabled = e[5]), (!a || 16 & i) && (o.checked = e[4]), d && d.p && 8192 & i && hn(d, c, e, e[13], i, null, null), (!a || 64 & i) && Fn(n, "for", e[6]), (!a || 4 & i) && Fn(n, "title", e[2]), (!a || 2 & i && r !== (r = al(["PinturaRadioGroupOption", e[1]]))) && Fn(t, "class", r), (!a || 32 & i) && Fn(t, "data-disabled", e[5]), (!a || 16 & i) && Fn(t, "data-selected", e[4])
        },
        i(e) {
            a || (yr(d, e), a = !0)
        },
        o(e) {
            xr(d, e), a = !1
        },
        d(e) {
            e && kn(t), d && d.d(e), s = !1, nn(l)
        }
    }
}

function Tc(e, t, o) {
    let i, n, {
            $$slots: r = {},
            $$scope: a
        } = t,
        {
            name: s
        } = t,
        {
            class: l
        } = t,
        {
            label: c
        } = t,
        {
            id: d
        } = t,
        {
            value: u
        } = t,
        {
            checked: h
        } = t,
        {
            onkeydown: p
        } = t,
        {
            onclick: m
        } = t,
        {
            disabled: g = !1
        } = t;
    const f = Object.values(Gl),
        $ = Jn("keysPressed");
    cn(e, $, (e => o(16, n = e)));
    return e.$$set = e => {
        "name" in e && o(0, s = e.name), "class" in e && o(1, l = e.class), "label" in e && o(2, c = e.label), "id" in e && o(10, d = e.id), "value" in e && o(3, u = e.value), "checked" in e && o(4, h = e.checked), "onkeydown" in e && o(11, p = e.onkeydown), "onclick" in e && o(12, m = e.onclick), "disabled" in e && o(5, g = e.disabled), "$$scope" in e && o(13, a = e.$$scope)
    }, e.$$.update = () => {
        1025 & e.$$.dirty && o(6, i = `${s}-${d}`)
    }, [s, l, c, u, h, g, i, $, e => {
        p(e)
    }, e => {
        n.some((e => f.includes(e))) || m(e)
    }, d, p, m, a, r, function (t) {
        Qn(e, t)
    }]
}
class Rc extends Fr {
    constructor(e) {
        super(), Lr(this, e, Tc, Mc, an, {
            name: 0,
            class: 1,
            label: 2,
            id: 10,
            value: 3,
            checked: 4,
            onkeydown: 11,
            onclick: 12,
            disabled: 5
        })
    }
}
var Pc = (e = []) => e.reduce(((e, t) => (Qt(t) ? Qt(t[1]) : !!t.options) ? e.concat(Qt(t) ? t[1] : t.options) : (e.push(t), e)), []);
const Ac = (e, t, o) => {
    let i;
    return Qt(e) ? i = {
        id: t,
        value: e[0],
        label: e[1],
        ...e[2] || {}
    } : (i = e, i.id = null != i.id ? i.id : t), o ? o(i) : i
};
var Ic = (e, t, o) => S(e) ? e(t, o) : e;
const Ec = (e, t) => e.map((([e, o, i]) => {
    if (Qt(o)) return [Ic(e, t), Ec(o, t)]; {
        const n = [e, Ic(o, t)];
        if (i) {
            let e = {
                ...i
            };
            i.icon && (e.icon = Ic(i.icon, t)), n.push(e)
        }
        return n
    }
}));
var Lc = (e, t) => Ec(e, t),
    Fc = e => /enter| /i.test(e),
    zc = (e, t) => Array.isArray(e) && Array.isArray(t) ? aa(e, t) : e === t;

function Bc(e, t, o) {
    const i = e.slice();
    return i[27] = t[o], i
}
const Dc = e => ({
        option: 2048 & e[0]
    }),
    Oc = e => ({
        option: e[27]
    });

function _c(e, t, o) {
    const i = e.slice();
    return i[27] = t[o], i
}
const Wc = e => ({
        option: 2048 & e[0]
    }),
    Vc = e => ({
        option: e[27]
    }),
    Hc = e => ({
        option: 2048 & e[0]
    }),
    Nc = e => ({
        option: e[27]
    });

function Uc(e) {
    let t, o, i, n, r, a = [],
        s = new Map,
        l = e[1] && jc(e),
        c = e[11];
    const d = e => e[27].id;
    for (let t = 0; t < c.length; t += 1) {
        let o = Bc(e, c, t),
            i = d(o);
        s.set(i, a[t] = id(i, o))
    }
    return {
        c() {
            t = Mn("fieldset"), l && l.c(), o = Pn(), i = Mn("ul");
            for (let e = 0; e < a.length; e += 1) a[e].c();
            Fn(i, "class", "PinturaRadioGroupOptions"), Fn(t, "class", n = al(["PinturaRadioGroup", e[3]])), Fn(t, "data-layout", e[5]), Fn(t, "title", e[7])
        },
        m(e, n) {
            Cn(e, t, n), l && l.m(t, null), Sn(t, o), Sn(t, i);
            for (let e = 0; e < a.length; e += 1) a[e].m(i, null);
            r = !0
        },
        p(e, u) {
            e[1] ? l ? l.p(e, u) : (l = jc(e), l.c(), l.m(t, o)) : l && (l.d(1), l = null), 8420177 & u[0] && (c = e[11], fr(), a = kr(a, u, d, 1, e, c, s, i, Cr, id, null, Bc), $r()), (!r || 8 & u[0] && n !== (n = al(["PinturaRadioGroup", e[3]]))) && Fn(t, "class", n), (!r || 32 & u[0]) && Fn(t, "data-layout", e[5]), (!r || 128 & u[0]) && Fn(t, "title", e[7])
        },
        i(e) {
            if (!r) {
                for (let e = 0; e < c.length; e += 1) yr(a[e]);
                r = !0
            }
        },
        o(e) {
            for (let e = 0; e < a.length; e += 1) xr(a[e]);
            r = !1
        },
        d(e) {
            e && kn(t), l && l.d();
            for (let e = 0; e < a.length; e += 1) a[e].d()
        }
    }
}

function jc(e) {
    let t, o, i;
    return {
        c() {
            t = Mn("legend"), o = Rn(e[1]), Fn(t, "class", i = e[2] && "implicit")
        },
        m(e, i) {
            Cn(e, t, i), Sn(t, o)
        },
        p(e, n) {
            2 & n[0] && Bn(o, e[1]), 4 & n[0] && i !== (i = e[2] && "implicit") && Fn(t, "class", i)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function Xc(e) {
    let t, o;
    return t = new Rc({
        props: {
            name: e[4],
            label: e[27].label,
            id: e[27].id,
            value: e[27].value,
            disabled: e[27].disabled,
            class: e[8],
            checked: e[12](e[27]) === e[0],
            onkeydown: e[13](e[27]),
            onclick: e[14](e[27]),
            $$slots: {
                default: [Kc]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            16 & o[0] && (i.name = e[4]), 2048 & o[0] && (i.label = e[27].label), 2048 & o[0] && (i.id = e[27].id), 2048 & o[0] && (i.value = e[27].value), 2048 & o[0] && (i.disabled = e[27].disabled), 256 & o[0] && (i.class = e[8]), 2049 & o[0] && (i.checked = e[12](e[27]) === e[0]), 2048 & o[0] && (i.onkeydown = e[13](e[27])), 2048 & o[0] && (i.onclick = e[14](e[27])), 8390720 & o[0] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Yc(e) {
    let t, o, i, n, r, a, s = [],
        l = new Map;
    const c = e[22].group,
        d = dn(c, e, e[23], Nc),
        u = d || function (e) {
            let t, o, i = e[27].label + "";
            return {
                c() {
                    t = Mn("span"), o = Rn(i), Fn(t, "class", "PinturaRadioGroupOptionGroupLabel")
                },
                m(e, i) {
                    Cn(e, t, i), Sn(t, o)
                },
                p(e, t) {
                    2048 & t[0] && i !== (i = e[27].label + "") && Bn(o, i)
                },
                d(e) {
                    e && kn(t)
                }
            }
        }(e);
    let h = e[27].options;
    const p = e => e[27].id;
    for (let t = 0; t < h.length; t += 1) {
        let o = _c(e, h, t),
            i = p(o);
        l.set(i, s[t] = od(i, o))
    }
    return {
        c() {
            t = Mn("li"), u && u.c(), o = Pn(), i = Mn("ul");
            for (let e = 0; e < s.length; e += 1) s[e].c();
            n = Pn(), Fn(i, "class", "PinturaRadioGroupOptions"), Fn(t, "class", r = al(["PinturaRadioGroupOptionGroup", e[9]]))
        },
        m(e, r) {
            Cn(e, t, r), u && u.m(t, null), Sn(t, o), Sn(t, i);
            for (let e = 0; e < s.length; e += 1) s[e].m(i, null);
            Sn(t, n), a = !0
        },
        p(e, o) {
            d ? d.p && 8390656 & o[0] && hn(d, c, e, e[23], o, Hc, Nc) : u && u.p && 2048 & o[0] && u.p(e, o), 8419665 & o[0] && (h = e[27].options, fr(), s = kr(s, o, p, 1, e, h, l, i, Cr, od, null, _c), $r()), (!a || 512 & o[0] && r !== (r = al(["PinturaRadioGroupOptionGroup", e[9]]))) && Fn(t, "class", r)
        },
        i(e) {
            if (!a) {
                yr(u, e);
                for (let e = 0; e < h.length; e += 1) yr(s[e]);
                a = !0
            }
        },
        o(e) {
            xr(u, e);
            for (let e = 0; e < s.length; e += 1) xr(s[e]);
            a = !1
        },
        d(e) {
            e && kn(t), u && u.d(e);
            for (let e = 0; e < s.length; e += 1) s[e].d()
        }
    }
}

function Gc(e) {
    let t, o;
    return t = new Ll({
        props: {
            $$slots: {
                default: [qc]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            8390656 & o[0] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function qc(e) {
    let t, o = e[27].icon + "";
    return {
        c() {
            t = Tn("g")
        },
        m(e, i) {
            Cn(e, t, i), t.innerHTML = o
        },
        p(e, i) {
            2048 & i[0] && o !== (o = e[27].icon + "") && (t.innerHTML = o)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function Zc(e) {
    let t, o, i = e[27].label + "";
    return {
        c() {
            t = Mn("span"), o = Rn(i), Fn(t, "class", e[6])
        },
        m(e, i) {
            Cn(e, t, i), Sn(t, o)
        },
        p(e, n) {
            2048 & n[0] && i !== (i = e[27].label + "") && Bn(o, i), 64 & n[0] && Fn(t, "class", e[6])
        },
        d(e) {
            e && kn(t)
        }
    }
}

function Kc(e) {
    let t;
    const o = e[22].option,
        i = dn(o, e, e[23], Oc),
        n = i || function (e) {
            let t, o, i, n = e[27].icon && Gc(e),
                r = !e[27].hideLabel && Zc(e);
            return {
                c() {
                    n && n.c(), t = Pn(), r && r.c(), o = Pn()
                },
                m(e, a) {
                    n && n.m(e, a), Cn(e, t, a), r && r.m(e, a), Cn(e, o, a), i = !0
                },
                p(e, i) {
                    e[27].icon ? n ? (n.p(e, i), 2048 & i[0] && yr(n, 1)) : (n = Gc(e), n.c(), yr(n, 1), n.m(t.parentNode, t)) : n && (fr(), xr(n, 1, 1, (() => {
                        n = null
                    })), $r()), e[27].hideLabel ? r && (r.d(1), r = null) : r ? r.p(e, i) : (r = Zc(e), r.c(), r.m(o.parentNode, o))
                },
                i(e) {
                    i || (yr(n), i = !0)
                },
                o(e) {
                    xr(n), i = !1
                },
                d(e) {
                    n && n.d(e), e && kn(t), r && r.d(e), e && kn(o)
                }
            }
        }(e);
    return {
        c() {
            n && n.c()
        },
        m(e, o) {
            n && n.m(e, o), t = !0
        },
        p(e, t) {
            i ? i.p && 8390656 & t[0] && hn(i, o, e, e[23], t, Dc, Oc) : n && n.p && 2112 & t[0] && n.p(e, t)
        },
        i(e) {
            t || (yr(n, e), t = !0)
        },
        o(e) {
            xr(n, e), t = !1
        },
        d(e) {
            n && n.d(e)
        }
    }
}

function Jc(e) {
    let t, o;
    return t = new Ll({
        props: {
            $$slots: {
                default: [Qc]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            8390656 & o[0] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Qc(e) {
    let t, o = e[27].icon + "";
    return {
        c() {
            t = Tn("g")
        },
        m(e, i) {
            Cn(e, t, i), t.innerHTML = o
        },
        p(e, i) {
            2048 & i[0] && o !== (o = e[27].icon + "") && (t.innerHTML = o)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function ed(e) {
    let t, o, i = e[27].label + "";
    return {
        c() {
            t = Mn("span"), o = Rn(i), Fn(t, "class", e[6])
        },
        m(e, i) {
            Cn(e, t, i), Sn(t, o)
        },
        p(e, n) {
            2048 & n[0] && i !== (i = e[27].label + "") && Bn(o, i), 64 & n[0] && Fn(t, "class", e[6])
        },
        d(e) {
            e && kn(t)
        }
    }
}

function td(e) {
    let t;
    const o = e[22].option,
        i = dn(o, e, e[23], Vc),
        n = i || function (e) {
            let t, o, i, n = e[27].icon && Jc(e),
                r = !e[27].hideLabel && ed(e);
            return {
                c() {
                    n && n.c(), t = Pn(), r && r.c(), o = Pn()
                },
                m(e, a) {
                    n && n.m(e, a), Cn(e, t, a), r && r.m(e, a), Cn(e, o, a), i = !0
                },
                p(e, i) {
                    e[27].icon ? n ? (n.p(e, i), 2048 & i[0] && yr(n, 1)) : (n = Jc(e), n.c(), yr(n, 1), n.m(t.parentNode, t)) : n && (fr(), xr(n, 1, 1, (() => {
                        n = null
                    })), $r()), e[27].hideLabel ? r && (r.d(1), r = null) : r ? r.p(e, i) : (r = ed(e), r.c(), r.m(o.parentNode, o))
                },
                i(e) {
                    i || (yr(n), i = !0)
                },
                o(e) {
                    xr(n), i = !1
                },
                d(e) {
                    n && n.d(e), e && kn(t), r && r.d(e), e && kn(o)
                }
            }
        }(e);
    return {
        c() {
            n && n.c()
        },
        m(e, o) {
            n && n.m(e, o), t = !0
        },
        p(e, t) {
            i ? i.p && 8390656 & t[0] && hn(i, o, e, e[23], t, Wc, Vc) : n && n.p && 2112 & t[0] && n.p(e, t)
        },
        i(e) {
            t || (yr(n, e), t = !0)
        },
        o(e) {
            xr(n, e), t = !1
        },
        d(e) {
            n && n.d(e)
        }
    }
}

function od(e, t) {
    let o, i, n;
    return i = new Rc({
        props: {
            name: t[4],
            label: t[27].label,
            id: t[27].id,
            value: t[27].value,
            disabled: t[27].disabled,
            class: t[8],
            checked: t[12](t[27]) === t[0],
            onkeydown: t[13](t[27]),
            onclick: t[14](t[27]),
            $$slots: {
                default: [td]
            },
            $$scope: {
                ctx: t
            }
        }
    }), {
        key: e,
        first: null,
        c() {
            o = An(), Pr(i.$$.fragment), this.first = o
        },
        m(e, t) {
            Cn(e, o, t), Ar(i, e, t), n = !0
        },
        p(e, o) {
            t = e;
            const n = {};
            16 & o[0] && (n.name = t[4]), 2048 & o[0] && (n.label = t[27].label), 2048 & o[0] && (n.id = t[27].id), 2048 & o[0] && (n.value = t[27].value), 2048 & o[0] && (n.disabled = t[27].disabled), 256 & o[0] && (n.class = t[8]), 2049 & o[0] && (n.checked = t[12](t[27]) === t[0]), 2048 & o[0] && (n.onkeydown = t[13](t[27])), 2048 & o[0] && (n.onclick = t[14](t[27])), 8390720 & o[0] && (n.$$scope = {
                dirty: o,
                ctx: t
            }), i.$set(n)
        },
        i(e) {
            n || (yr(i.$$.fragment, e), n = !0)
        },
        o(e) {
            xr(i.$$.fragment, e), n = !1
        },
        d(e) {
            e && kn(o), Ir(i, e)
        }
    }
}

function id(e, t) {
    let o, i, n, r, a;
    const s = [Yc, Xc],
        l = [];

    function c(e, t) {
        return e[27].options ? 0 : 1
    }
    return i = c(t), n = l[i] = s[i](t), {
        key: e,
        first: null,
        c() {
            o = An(), n.c(), r = An(), this.first = o
        },
        m(e, t) {
            Cn(e, o, t), l[i].m(e, t), Cn(e, r, t), a = !0
        },
        p(e, o) {
            let a = i;
            i = c(t = e), i === a ? l[i].p(t, o) : (fr(), xr(l[a], 1, 1, (() => {
                l[a] = null
            })), $r(), n = l[i], n ? n.p(t, o) : (n = l[i] = s[i](t), n.c()), yr(n, 1), n.m(r.parentNode, r))
        },
        i(e) {
            a || (yr(n), a = !0)
        },
        o(e) {
            xr(n), a = !1
        },
        d(e) {
            e && kn(o), l[i].d(e), e && kn(r)
        }
    }
}

function nd(e) {
    let t, o, i, n = e[10].length && Uc(e);
    return {
        c() {
            n && n.c(), t = Pn(), o = An()
        },
        m(e, r) {
            n && n.m(e, r), Cn(e, t, r), Cn(e, o, r), i = !0
        },
        p(e, o) {
            e[10].length ? n ? (n.p(e, o), 1024 & o[0] && yr(n, 1)) : (n = Uc(e), n.c(), yr(n, 1), n.m(t.parentNode, t)) : n && (fr(), xr(n, 1, 1, (() => {
                n = null
            })), $r())
        },
        i(e) {
            i || (yr(n), yr(false), i = !0)
        },
        o(e) {
            xr(n), xr(false), i = !1
        },
        d(e) {
            n && n.d(e), e && kn(t), e && kn(o)
        }
    }
}

function rd(e, t, o) {
    let i, n, r, {
        $$slots: a = {},
        $$scope: s
    } = t;
    const l = Zn();
    let {
        label: c
    } = t, {
        hideLabel: d = !0
    } = t, {
        class: u
    } = t, {
        name: h = "radio-group-" + T()
    } = t, {
        selectedIndex: p = -1
    } = t, {
        options: m = []
    } = t, {
        onchange: g
    } = t, {
        layout: f
    } = t, {
        optionMapper: $
    } = t, {
        optionFilter: y
    } = t, {
        value: x
    } = t, {
        optionLabelClass: b
    } = t, {
        title: v
    } = t, {
        locale: w
    } = t, {
        optionClass: S
    } = t, {
        optionGroupClass: C
    } = t;
    const k = e => r.findIndex((t => t.id === e.id)),
        M = (e, t) => {
            o(0, p = k(e));
            const i = {
                index: p,
                ...e
            };
            ((e, ...t) => {
                e && e(...t)
            })(g, i, t), l("change", i)
        };
    return e.$$set = e => {
        "label" in e && o(1, c = e.label), "hideLabel" in e && o(2, d = e.hideLabel), "class" in e && o(3, u = e.class), "name" in e && o(4, h = e.name), "selectedIndex" in e && o(0, p = e.selectedIndex), "options" in e && o(15, m = e.options), "onchange" in e && o(16, g = e.onchange), "layout" in e && o(5, f = e.layout), "optionMapper" in e && o(17, $ = e.optionMapper), "optionFilter" in e && o(18, y = e.optionFilter), "value" in e && o(19, x = e.value), "optionLabelClass" in e && o(6, b = e.optionLabelClass), "title" in e && o(7, v = e.title), "locale" in e && o(20, w = e.locale), "optionClass" in e && o(8, S = e.optionClass), "optionGroupClass" in e && o(9, C = e.optionGroupClass), "$$scope" in e && o(23, s = e.$$scope)
    }, e.$$.update = () => {
        1343488 & e.$$.dirty[0] && o(10, i = Lc(y ? m.filter(y) : m, w)), 132096 & e.$$.dirty[0] && o(11, n = ((e = [], t) => {
            let o = 0;
            return e.map((e => (o++, Qt(e) ? Qt(e[1]) ? {
                id: o,
                label: e[0],
                options: e[1].map((e => Ac(e, ++o, t)))
            } : Ac(e, o, t) : e.options ? {
                id: e.id || o,
                label: e.label,
                options: e.options.map((e => Ac(e, ++o, t)))
            } : Ac(e, o, t))))
        })(i, $)), 2048 & e.$$.dirty[0] && o(21, r = Pc(n)), 2654209 & e.$$.dirty[0] && p < 0 && (o(0, p = r.findIndex((e => zc(e.value, x)))), p < 0 && o(0, p = (e => e.findIndex((e => void 0 === e[0])))(m)))
    }, [p, c, d, u, h, f, b, v, S, C, i, n, k, e => t => {
        Fc(t.key) && M(e, t)
    }, e => t => {
        M(e, t)
    }, m, g, $, y, x, w, r, a, s]
}
class ad extends Fr {
    constructor(e) {
        super(), Lr(this, e, rd, nd, an, {
            label: 1,
            hideLabel: 2,
            class: 3,
            name: 4,
            selectedIndex: 0,
            options: 15,
            onchange: 16,
            layout: 5,
            optionMapper: 17,
            optionFilter: 18,
            value: 19,
            optionLabelClass: 6,
            title: 7,
            locale: 20,
            optionClass: 8,
            optionGroupClass: 9
        }, [-1, -1])
    }
}

function sd(e) {
    let t, o;
    return t = new Ll({
        props: {
            class: "PinturaButtonIcon",
            $$slots: {
                default: [ld]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            536870976 & o && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function ld(e) {
    let t;
    return {
        c() {
            t = Tn("g")
        },
        m(o, i) {
            Cn(o, t, i), t.innerHTML = e[6]
        },
        p(e, o) {
            64 & o && (t.innerHTML = e[6])
        },
        d(e) {
            e && kn(t)
        }
    }
}

function cd(e) {
    let t, o, i, n, r, a, s, l, c = (e[2] || e[18]) + "",
        d = e[6] && sd(e);
    return {
        c() {
            t = Mn("span"), d && d.c(), o = Pn(), i = Mn("span"), n = Rn(c), Fn(i, "class", r = al(["PinturaButtonLabel", e[3], e[5] && "implicit"])), Fn(t, "slot", "label"), Fn(t, "title", a = Ic(e[1], e[15])), Fn(t, "class", s = al(["PinturaButtonInner", e[4]]))
        },
        m(e, r) {
            Cn(e, t, r), d && d.m(t, null), Sn(t, o), Sn(t, i), Sn(i, n), l = !0
        },
        p(e, u) {
            e[6] ? d ? (d.p(e, u), 64 & u && yr(d, 1)) : (d = sd(e), d.c(), yr(d, 1), d.m(t, o)) : d && (fr(), xr(d, 1, 1, (() => {
                d = null
            })), $r()), (!l || 262148 & u) && c !== (c = (e[2] || e[18]) + "") && Bn(n, c), (!l || 40 & u && r !== (r = al(["PinturaButtonLabel", e[3], e[5] && "implicit"]))) && Fn(i, "class", r), (!l || 32770 & u && a !== (a = Ic(e[1], e[15]))) && Fn(t, "title", a), (!l || 16 & u && s !== (s = al(["PinturaButtonInner", e[4]]))) && Fn(t, "class", s)
        },
        i(e) {
            l || (yr(d), l = !0)
        },
        o(e) {
            xr(d), l = !1
        },
        d(e) {
            e && kn(t), d && d.d()
        }
    }
}

function dd(e) {
    let t, o, i = e[28].label + "";
    return {
        c() {
            t = Mn("span"), o = Rn(i), Fn(t, "slot", "group")
        },
        m(e, i) {
            Cn(e, t, i), Sn(t, o)
        },
        p(e, t) {
            268435456 & t && i !== (i = e[28].label + "") && Bn(o, i)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function ud(e) {
    let t, o;
    return t = new Ll({
        props: {
            style: S(e[13]) ? e[13](e[28].value) : e[13],
            $$slots: {
                default: [hd]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            268443648 & o && (i.style = S(e[13]) ? e[13](e[28].value) : e[13]), 805306368 & o && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function hd(e) {
    let t, o = e[28].icon + "";
    return {
        c() {
            t = Tn("g")
        },
        m(e, i) {
            Cn(e, t, i), t.innerHTML = o
        },
        p(e, i) {
            268435456 & i && o !== (o = e[28].icon + "") && (t.innerHTML = o)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function pd(e) {
    let t, o, i, n, r, a, s, l = e[28].label + "",
        c = e[28].icon && ud(e);
    return {
        c() {
            t = Mn("span"), c && c.c(), o = Pn(), i = Mn("span"), n = Rn(l), Fn(i, "style", r = S(e[14]) ? e[14](e[28].value) : e[14]), Fn(i, "class", a = al(["PinturaDropdownOptionLabel", e[10]])), Fn(t, "slot", "option")
        },
        m(e, r) {
            Cn(e, t, r), c && c.m(t, null), Sn(t, o), Sn(t, i), Sn(i, n), s = !0
        },
        p(e, d) {
            e[28].icon ? c ? (c.p(e, d), 268435456 & d && yr(c, 1)) : (c = ud(e), c.c(), yr(c, 1), c.m(t, o)) : c && (fr(), xr(c, 1, 1, (() => {
                c = null
            })), $r()), (!s || 268435456 & d) && l !== (l = e[28].label + "") && Bn(n, l), (!s || 268451840 & d && r !== (r = S(e[14]) ? e[14](e[28].value) : e[14])) && Fn(i, "style", r), (!s || 1024 & d && a !== (a = al(["PinturaDropdownOptionLabel", e[10]]))) && Fn(i, "class", a)
        },
        i(e) {
            s || (yr(c), s = !0)
        },
        o(e) {
            xr(c), s = !1
        },
        d(e) {
            e && kn(t), c && c.d()
        }
    }
}

function md(e) {
    let t, o, i, n, r;
    return o = new ad({
        props: {
            name: e[7],
            value: e[9],
            selectedIndex: e[8],
            optionFilter: e[11],
            optionMapper: e[12],
            optionLabelClass: al(["PinturaDropdownOptionLabel", e[10]]),
            optionGroupClass: "PinturaDropdownOptionGroup",
            optionClass: "PinturaDropdownOption",
            options: e[16],
            onchange: e[19],
            $$slots: {
                option: [pd, ({
                    option: e
                }) => ({
                    28: e
                }), ({
                    option: e
                }) => e ? 268435456 : 0],
                group: [dd, ({
                    option: e
                }) => ({
                    28: e
                }), ({
                    option: e
                }) => e ? 268435456 : 0]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), Fn(t, "class", "PinturaDropdownPanel"), Fn(t, "slot", "details")
        },
        m(a, s) {
            Cn(a, t, s), Ar(o, t, null), i = !0, n || (r = In(t, "keydown", e[21]), n = !0)
        },
        p(e, t) {
            const i = {};
            128 & t && (i.name = e[7]), 512 & t && (i.value = e[9]), 256 & t && (i.selectedIndex = e[8]), 2048 & t && (i.optionFilter = e[11]), 4096 & t && (i.optionMapper = e[12]), 1024 & t && (i.optionLabelClass = al(["PinturaDropdownOptionLabel", e[10]])), 65536 & t && (i.options = e[16]), 805331968 & t && (i.$$scope = {
                dirty: t,
                ctx: e
            }), o.$set(i)
        },
        i(e) {
            i || (yr(o.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), i = !1
        },
        d(e) {
            e && kn(t), Ir(o), n = !1, r()
        }
    }
}

function gd(e) {
    let t, o, i;

    function n(t) {
        e[26](t)
    }
    let r = {
        onshow: e[20],
        buttonClass: al(["PinturaDropdownButton", e[0], e[5] && "PinturaDropdownIconOnly"]),
        $$slots: {
            details: [md],
            label: [cd]
        },
        $$scope: {
            ctx: e
        }
    };
    return void 0 !== e[17] && (r.isActive = e[17]), t = new kc({
        props: r
    }), tr.push((() => Rr(t, "isActive", n))), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, o) {
            Ar(t, e, o), i = !0
        },
        p(e, [i]) {
            const n = {};
            33 & i && (n.buttonClass = al(["PinturaDropdownButton", e[0], e[5] && "PinturaDropdownIconOnly"])), 537264126 & i && (n.$$scope = {
                dirty: i,
                ctx: e
            }), !o && 131072 & i && (o = !0, n.isActive = e[17], sr((() => o = !1))), t.$set(n)
        },
        i(e) {
            i || (yr(t.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), i = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function fd(e, t, o) {
    let i, r, {
            class: a
        } = t,
        {
            title: s
        } = t,
        {
            label: l
        } = t,
        {
            labelClass: c
        } = t,
        {
            innerClass: d
        } = t,
        {
            hideLabel: u = !1
        } = t,
        {
            icon: h
        } = t,
        {
            name: p
        } = t,
        {
            options: m = []
        } = t,
        {
            selectedIndex: g = -1
        } = t,
        {
            value: f
        } = t,
        {
            optionLabelClass: $
        } = t,
        {
            optionFilter: y
        } = t,
        {
            optionMapper: x
        } = t,
        {
            optionIconStyle: b
        } = t,
        {
            optionLabelStyle: v
        } = t,
        {
            locale: w
        } = t,
        {
            onchange: S = n
        } = t,
        {
            onload: C = n
        } = t,
        {
            ondestroy: k = n
        } = t;
    let M;
    return Yn((() => C({
        options: m
    }))), qn((() => k({
        options: m
    }))), e.$$set = e => {
        "class" in e && o(0, a = e.class), "title" in e && o(1, s = e.title), "label" in e && o(2, l = e.label), "labelClass" in e && o(3, c = e.labelClass), "innerClass" in e && o(4, d = e.innerClass), "hideLabel" in e && o(5, u = e.hideLabel), "icon" in e && o(6, h = e.icon), "name" in e && o(7, p = e.name), "options" in e && o(22, m = e.options), "selectedIndex" in e && o(8, g = e.selectedIndex), "value" in e && o(9, f = e.value), "optionLabelClass" in e && o(10, $ = e.optionLabelClass), "optionFilter" in e && o(11, y = e.optionFilter), "optionMapper" in e && o(12, x = e.optionMapper), "optionIconStyle" in e && o(13, b = e.optionIconStyle), "optionLabelStyle" in e && o(14, v = e.optionLabelStyle), "locale" in e && o(15, w = e.locale), "onchange" in e && o(23, S = e.onchange), "onload" in e && o(24, C = e.onload), "ondestroy" in e && o(25, k = e.ondestroy)
    }, e.$$.update = () => {
        4227072 & e.$$.dirty && o(16, i = w ? Lc(m, w) : m), 66048 & e.$$.dirty && o(18, r = i.reduce(((e, t) => {
            if (e) return e;
            const o = Array.isArray(t) ? t : [t, t],
                [i, n] = o;
            return zc(i, f) ? n : void 0
        }), void 0) || (e => {
            const t = e.find((e => void 0 === e[0]));
            if (t) return t[1]
        })(i) || f)
    }, [a, s, l, c, d, u, h, p, g, f, $, y, x, b, v, w, i, M, r, e => {
        o(18, r = e.value), S(e), o(17, M = !1)
    }, ({
        e: e,
        panel: t
    }) => {
        if (e && e.key && /up|down/i.test(e.key)) return t.querySelector("input:not([disabled])").focus();
        t.querySelector("fieldset").focus()
    }, e => {
        /tab/i.test(e.key) && e.preventDefault()
    }, m, S, C, k, function (e) {
        M = e, o(17, M)
    }]
}
class $d extends Fr {
    constructor(e) {
        super(), Lr(this, e, fd, gd, an, {
            class: 0,
            title: 1,
            label: 2,
            labelClass: 3,
            innerClass: 4,
            hideLabel: 5,
            icon: 6,
            name: 7,
            options: 22,
            selectedIndex: 8,
            value: 9,
            optionLabelClass: 10,
            optionFilter: 11,
            optionMapper: 12,
            optionIconStyle: 13,
            optionLabelStyle: 14,
            locale: 15,
            onchange: 23,
            onload: 24,
            ondestroy: 25
        })
    }
}
var yd = (e, t, o) => (e - t) / (o - t);

function xd(e) {
    let t;
    return {
        c() {
            t = Tn("path"), Fn(t, "d", "M8 12 h8 M12 8 v8")
        },
        m(e, o) {
            Cn(e, t, o)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function bd(e) {
    let t;
    return {
        c() {
            t = Tn("path"), Fn(t, "d", "M9 12 h6")
        },
        m(e, o) {
            Cn(e, t, o)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function vd(e) {
    let t, o, i, n, r, a, s, l, c, d, u, h, p, m, g, f, $, y;
    return u = new Ll({
        props: {
            $$slots: {
                default: [xd]
            },
            $$scope: {
                ctx: e
            }
        }
    }), m = new Ll({
        props: {
            $$slots: {
                default: [bd]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            t = Mn("div"), o = Mn("div"), i = Mn("input"), n = Pn(), r = Mn("div"), a = Pn(), s = Mn("div"), l = Mn("div"), c = Pn(), d = Mn("button"), Pr(u.$$.fragment), h = Pn(), p = Mn("button"), Pr(m.$$.fragment), Fn(i, "type", "range"), Fn(i, "id", e[3]), Fn(i, "min", e[0]), Fn(i, "max", e[1]), Fn(i, "step", e[2]), i.value = e[8], Fn(r, "class", "PinturaSliderTrack"), Fn(r, "style", e[4]), Fn(l, "class", "PinturaSliderKnob"), Fn(l, "style", e[5]), Fn(s, "class", "PinturaSliderKnobController"), Fn(s, "style", e[10]), Fn(o, "class", "PinturaSliderControl"), Fn(d, "type", "button"), Fn(d, "aria-label", "Increase"), Fn(p, "type", "button"), Fn(p, "aria-label", "Decrease"), Fn(t, "class", g = al(["PinturaSlider", e[7]])), Fn(t, "data-direction", e[6])
        },
        m(g, x) {
            Cn(g, t, x), Sn(t, o), Sn(o, i), e[22](i), Sn(o, n), Sn(o, r), Sn(o, a), Sn(o, s), Sn(s, l), Sn(t, c), Sn(t, d), Ar(u, d, null), Sn(t, h), Sn(t, p), Ar(m, p, null), f = !0, $ || (y = [In(i, "pointerdown", e[13]), In(i, "input", e[11]), In(i, "nudge", e[12]), fn(Nl.call(null, i)), In(d, "pointerdown", e[14](1)), In(p, "pointerdown", e[14](-1))], $ = !0)
        },
        p(e, o) {
            (!f || 8 & o[0]) && Fn(i, "id", e[3]), (!f || 1 & o[0]) && Fn(i, "min", e[0]), (!f || 2 & o[0]) && Fn(i, "max", e[1]), (!f || 4 & o[0]) && Fn(i, "step", e[2]), (!f || 256 & o[0]) && (i.value = e[8]), (!f || 16 & o[0]) && Fn(r, "style", e[4]), (!f || 32 & o[0]) && Fn(l, "style", e[5]), (!f || 1024 & o[0]) && Fn(s, "style", e[10]);
            const n = {};
            512 & o[1] && (n.$$scope = {
                dirty: o,
                ctx: e
            }), u.$set(n);
            const a = {};
            512 & o[1] && (a.$$scope = {
                dirty: o,
                ctx: e
            }), m.$set(a), (!f || 128 & o[0] && g !== (g = al(["PinturaSlider", e[7]]))) && Fn(t, "class", g), (!f || 64 & o[0]) && Fn(t, "data-direction", e[6])
        },
        i(e) {
            f || (yr(u.$$.fragment, e), yr(m.$$.fragment, e), f = !0)
        },
        o(e) {
            xr(u.$$.fragment, e), xr(m.$$.fragment, e), f = !1
        },
        d(o) {
            o && kn(t), e[22](null), Ir(u), Ir(m), $ = !1, nn(y)
        }
    }
}

function wd(e, t, o) {
    let i, n, r, a, s, l, c, d, u, h, p, m, g, f, {
            min: $ = 0
        } = t,
        {
            max: y = 100
        } = t,
        {
            step: x = 1
        } = t,
        {
            id: b
        } = t,
        {
            value: v = 0
        } = t,
        {
            trackStyle: w
        } = t,
        {
            knobStyle: S
        } = t,
        {
            onchange: C
        } = t,
        {
            direction: k = "x"
        } = t,
        {
            getValue: M = _
        } = t,
        {
            setValue: T = _
        } = t,
        {
            class: R
        } = t;
    const P = e => T(((e, t) => (t = 1 / t, Math.round(e * t) / t))(oa(e, $, y), x)),
        A = (e, t) => {
            o(15, v = P($ + e / t * n)), v !== f && (f = v, C(v))
        },
        I = e => {
            const t = e[d] - g;
            A(m + t, p)
        },
        E = e => {
            p = void 0, document.documentElement.removeEventListener("pointermove", I), document.documentElement.removeEventListener("pointerup", E), C(v)
        },
        L = () => {
            o(15, v = P(i + z * x)), C(v)
        };
    let F, z = 1,
        B = !1;
    const D = e => {
        clearTimeout(F), B || L(), document.removeEventListener("pointerup", D)
    };
    return e.$$set = e => {
        "min" in e && o(0, $ = e.min), "max" in e && o(1, y = e.max), "step" in e && o(2, x = e.step), "id" in e && o(3, b = e.id), "value" in e && o(15, v = e.value), "trackStyle" in e && o(4, w = e.trackStyle), "knobStyle" in e && o(5, S = e.knobStyle), "onchange" in e && o(16, C = e.onchange), "direction" in e && o(6, k = e.direction), "getValue" in e && o(17, M = e.getValue), "setValue" in e && o(18, T = e.setValue), "class" in e && o(7, R = e.class)
    }, e.$$.update = () => {
        163840 & e.$$.dirty[0] && o(8, i = void 0 !== v ? M(v) : 0), 3 & e.$$.dirty[0] && (n = y - $), 259 & e.$$.dirty[0] && o(19, r = 100 * yd(i, $, y)), 64 & e.$$.dirty[0] && o(20, a = k.toUpperCase()), 64 & e.$$.dirty[0] && o(21, s = "x" === k ? "Width" : "Height"), 2097152 & e.$$.dirty[0] && (l = "offset" + s), 1048576 & e.$$.dirty[0] && (c = "offset" + a), 1048576 & e.$$.dirty[0] && (d = "page" + a), 1572864 & e.$$.dirty[0] && o(10, u = `transform: translate${a}(${r}%)`)
    }, [$, y, x, b, w, S, k, R, i, h, u, e => {
        p || (o(15, v = T(parseFloat(e.target.value))), v !== f && (f = v, C(v)))
    }, e => {
        const t = h[l];
        A(i / n * t + e.detail[k], t)
    }, e => {
        e.stopPropagation(), p = h[l], m = e[c], g = e[d], A(m, p), document.documentElement.addEventListener("pointermove", I), document.documentElement.addEventListener("pointerup", E)
    }, e => t => {
        z = e, B = !1, F = setInterval((() => {
            B = !0, L()
        }), 100), document.addEventListener("pointercancel", D), document.addEventListener("pointerup", D)
    }, v, C, M, T, r, a, s, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            h = e, o(9, h)
        }))
    }]
}
class Sd extends Fr {
    constructor(e) {
        super(), Lr(this, e, wd, vd, an, {
            min: 0,
            max: 1,
            step: 2,
            id: 3,
            value: 15,
            trackStyle: 4,
            knobStyle: 5,
            onchange: 16,
            direction: 6,
            getValue: 17,
            setValue: 18,
            class: 7
        }, [-1, -1])
    }
}

function Cd(e) {
    let t, o;
    return t = new Ll({
        props: {
            class: "PinturaButtonIcon",
            $$slots: {
                default: [kd]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            524292 & o && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function kd(e) {
    let t;
    return {
        c() {
            t = Tn("g")
        },
        m(o, i) {
            Cn(o, t, i), t.innerHTML = e[2]
        },
        p(e, o) {
            4 & o && (t.innerHTML = e[2])
        },
        d(e) {
            e && kn(t)
        }
    }
}

function Md(e) {
    let t, o, i, n, r, a, s, l, c = e[2] && Cd(e);
    return {
        c() {
            t = Mn("span"), c && c.c(), o = Pn(), i = Mn("span"), n = Rn(e[8]), Fn(i, "class", r = al(["PinturaButtonLabel", e[3], e[5] && "implicit"])), Fn(t, "slot", "label"), Fn(t, "title", a = Ic(e[1], e[6])), Fn(t, "class", s = al(["PinturaButtonInner", e[4]]))
        },
        m(e, r) {
            Cn(e, t, r), c && c.m(t, null), Sn(t, o), Sn(t, i), Sn(i, n), l = !0
        },
        p(e, d) {
            e[2] ? c ? (c.p(e, d), 4 & d && yr(c, 1)) : (c = Cd(e), c.c(), yr(c, 1), c.m(t, o)) : c && (fr(), xr(c, 1, 1, (() => {
                c = null
            })), $r()), (!l || 256 & d) && Bn(n, e[8]), (!l || 40 & d && r !== (r = al(["PinturaButtonLabel", e[3], e[5] && "implicit"]))) && Fn(i, "class", r), (!l || 66 & d && a !== (a = Ic(e[1], e[6]))) && Fn(t, "title", a), (!l || 16 & d && s !== (s = al(["PinturaButtonInner", e[4]]))) && Fn(t, "class", s)
        },
        i(e) {
            l || (yr(c), l = !0)
        },
        o(e) {
            xr(c), l = !1
        },
        d(e) {
            e && kn(t), c && c.d()
        }
    }
}

function Td(e) {
    let t, o, i, n, r;
    const a = [e[11], {
        value: e[7]
    }, {
        onchange: e[10]
    }];
    let s = {};
    for (let e = 0; e < a.length; e += 1) s = en(s, a[e]);
    return o = new Sd({
        props: s
    }), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), Fn(t, "slot", "details")
        },
        m(a, s) {
            Cn(a, t, s), Ar(o, t, null), i = !0, n || (r = In(t, "keydown", e[9]), n = !0)
        },
        p(e, t) {
            const i = 3200 & t ? Mr(a, [2048 & t && Tr(e[11]), 128 & t && {
                value: e[7]
            }, 1024 & t && {
                onchange: e[10]
            }]) : {};
            o.$set(i)
        },
        i(e) {
            i || (yr(o.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), i = !1
        },
        d(e) {
            e && kn(t), Ir(o), n = !1, r()
        }
    }
}

function Rd(e) {
    let t, o;
    return t = new kc({
        props: {
            panelClass: "PinturaSliderPanel",
            buttonClass: al(["PinturaSliderButton", e[0], e[5] && "PinturaSliderIconOnly"]),
            $$slots: {
                details: [Td],
                label: [Md]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, [o]) {
            const i = {};
            33 & o && (i.buttonClass = al(["PinturaSliderButton", e[0], e[5] && "PinturaSliderIconOnly"])), 526846 & o && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Pd(e, t, o) {
    const i = ["class", "title", "label", "icon", "labelClass", "innerClass", "hideLabel", "locale", "value", "onchange"];
    let r = mn(t, i),
        {
            class: a
        } = t,
        {
            title: s
        } = t,
        {
            label: l = Math.round
        } = t,
        {
            icon: c
        } = t,
        {
            labelClass: d
        } = t,
        {
            innerClass: u
        } = t,
        {
            hideLabel: h = !1
        } = t,
        {
            locale: p
        } = t,
        {
            value: m
        } = t,
        {
            onchange: g = n
        } = t;
    const {
        min: f,
        max: $,
        getValue: y = _
    } = r;
    let x;
    const b = e => o(8, x = (e => S(l) ? l(y(e), f, $) : l)(e));
    return e.$$set = e => {
        t = en(en({}, t), pn(e)), o(11, r = mn(t, i)), "class" in e && o(0, a = e.class), "title" in e && o(1, s = e.title), "label" in e && o(12, l = e.label), "icon" in e && o(2, c = e.icon), "labelClass" in e && o(3, d = e.labelClass), "innerClass" in e && o(4, u = e.innerClass), "hideLabel" in e && o(5, h = e.hideLabel), "locale" in e && o(6, p = e.locale), "value" in e && o(7, m = e.value), "onchange" in e && o(13, g = e.onchange)
    }, e.$$.update = () => {
        128 & e.$$.dirty && b(m)
    }, [a, s, c, d, u, h, p, m, x, e => {
        /tab/i.test(e.key) && e.preventDefault()
    }, e => {
        b(e), g(e)
    }, r, l, g]
}
class Ad extends Fr {
    constructor(e) {
        super(), Lr(this, e, Pd, Rd, an, {
            class: 0,
            title: 1,
            label: 12,
            icon: 2,
            labelClass: 3,
            innerClass: 4,
            hideLabel: 5,
            locale: 6,
            value: 7,
            onchange: 13
        })
    }
}

function Id(e, t, o) {
    const i = e.slice();
    return i[7] = t[o][0], i[8] = t[o][1], i[9] = t[o][2], i[0] = t[o][3], i
}

function Ed(e) {
    let t, o, i;
    const n = [e[9]];
    var r = e[1][e[7]] || e[7];

    function a(e) {
        let t = {};
        for (let e = 0; e < n.length; e += 1) t = en(t, n[e]);
        return {
            props: t
        }
    }
    return r && (t = new r(a())), {
        c() {
            t && Pr(t.$$.fragment), o = An()
        },
        m(e, n) {
            t && Ar(t, e, n), Cn(e, o, n), i = !0
        },
        p(e, i) {
            const s = 1 & i ? Mr(n, [Tr(e[9])]) : {};
            if (r !== (r = e[1][e[7]] || e[7])) {
                if (t) {
                    fr();
                    const e = t;
                    xr(e.$$.fragment, 1, 0, (() => {
                        Ir(e, 1)
                    })), $r()
                }
                r ? (t = new r(a()), Pr(t.$$.fragment), yr(t.$$.fragment, 1), Ar(t, o.parentNode, o)) : t = null
            } else r && t.$set(s)
        },
        i(e) {
            i || (t && yr(t.$$.fragment, e), i = !0)
        },
        o(e) {
            t && xr(t.$$.fragment, e), i = !1
        },
        d(e) {
            e && kn(o), t && Ir(t, e)
        }
    }
}

function Ld(e) {
    let t, o;
    return t = new pc({
        props: {
            name: e[7],
            attributes: e[2](e[9]),
            $$slots: {
                default: [Dd]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            1 & o && (i.name = e[7]), 1 & o && (i.attributes = e[2](e[9])), 4097 & o && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Fd(e) {
    let t, o, i = e[9].innerHTML + "";
    return {
        c() {
            o = An(), t = new _n(o)
        },
        m(e, n) {
            t.m(i, e, n), Cn(e, o, n)
        },
        p(e, o) {
            1 & o && i !== (i = e[9].innerHTML + "") && t.p(i)
        },
        i: Ji,
        o: Ji,
        d(e) {
            e && kn(o), e && t.d()
        }
    }
}

function zd(e) {
    let t, o = e[9].textContent + "";
    return {
        c() {
            t = Rn(o)
        },
        m(e, o) {
            Cn(e, t, o)
        },
        p(e, i) {
            1 & i && o !== (o = e[9].textContent + "") && Bn(t, o)
        },
        i: Ji,
        o: Ji,
        d(e) {
            e && kn(t)
        }
    }
}

function Bd(e) {
    let t, o;
    return t = new Vd({
        props: {
            items: e[0],
            discardEmptyItems: !0
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            1 & o && (i.items = e[0]), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Dd(e) {
    let t, o, i, n;
    const r = [Bd, zd, Fd],
        a = [];

    function s(e, t) {
        return e[0] && e[0].length ? 0 : e[9].textContent ? 1 : e[9].innerHTML ? 2 : -1
    }
    return ~(t = s(e)) && (o = a[t] = r[t](e)), {
        c() {
            o && o.c(), i = Pn()
        },
        m(e, o) {
            ~t && a[t].m(e, o), Cn(e, i, o), n = !0
        },
        p(e, n) {
            let l = t;
            t = s(e), t === l ? ~t && a[t].p(e, n) : (o && (fr(), xr(a[l], 1, 1, (() => {
                a[l] = null
            })), $r()), ~t ? (o = a[t], o ? o.p(e, n) : (o = a[t] = r[t](e), o.c()), yr(o, 1), o.m(i.parentNode, i)) : o = null)
        },
        i(e) {
            n || (yr(o), n = !0)
        },
        o(e) {
            xr(o), n = !1
        },
        d(e) {
            ~t && a[t].d(e), e && kn(i)
        }
    }
}

function Od(e, t) {
    let o, i, n, r, a, s;
    const l = [Ld, Ed],
        c = [];

    function d(e, t) {
        return 1 & t && (i = !e[3](e[7])), i ? 0 : 1
    }
    return n = d(t, -1), r = c[n] = l[n](t), {
        key: e,
        first: null,
        c() {
            o = An(), r.c(), a = An(), this.first = o
        },
        m(e, t) {
            Cn(e, o, t), c[n].m(e, t), Cn(e, a, t), s = !0
        },
        p(e, o) {
            let i = n;
            n = d(t = e, o), n === i ? c[n].p(t, o) : (fr(), xr(c[i], 1, 1, (() => {
                c[i] = null
            })), $r(), r = c[n], r ? r.p(t, o) : (r = c[n] = l[n](t), r.c()), yr(r, 1), r.m(a.parentNode, a))
        },
        i(e) {
            s || (yr(r), s = !0)
        },
        o(e) {
            xr(r), s = !1
        },
        d(e) {
            e && kn(o), c[n].d(e), e && kn(a)
        }
    }
}

function _d(e) {
    let t, o, i = [],
        n = new Map,
        r = e[0];
    const a = e => e[8];
    for (let t = 0; t < r.length; t += 1) {
        let o = Id(e, r, t),
            s = a(o);
        n.set(s, i[t] = Od(s, o))
    }
    return {
        c() {
            for (let e = 0; e < i.length; e += 1) i[e].c();
            t = An()
        },
        m(e, n) {
            for (let t = 0; t < i.length; t += 1) i[t].m(e, n);
            Cn(e, t, n), o = !0
        },
        p(e, [o]) {
            15 & o && (r = e[0], fr(), i = kr(i, o, a, 1, e, r, n, t.parentNode, Cr, Od, t, Id), $r())
        },
        i(e) {
            if (!o) {
                for (let e = 0; e < r.length; e += 1) yr(i[e]);
                o = !0
            }
        },
        o(e) {
            for (let e = 0; e < i.length; e += 1) xr(i[e]);
            o = !1
        },
        d(e) {
            for (let t = 0; t < i.length; t += 1) i[t].d(e);
            e && kn(t)
        }
    }
}

function Wd(e, t, o) {
    let i, {
            items: n
        } = t,
        {
            discardEmptyItems: r = !0
        } = t;
    const a = {
            Button: Wl,
            Dropdown: $d,
            Slider: Ad
        },
        s = e => !w(e) || !!a[e],
        l = e => {
            if (!e) return !1;
            const [t, , o, i = []] = e;
            return !!s(t) || (i.some(l) || o.textContent || o.innerHTML)
        };
    return e.$$set = e => {
        "items" in e && o(4, n = e.items), "discardEmptyItems" in e && o(5, r = e.discardEmptyItems)
    }, e.$$.update = () => {
        48 & e.$$.dirty && o(0, i = (n && r ? n.filter(l) : n) || [])
    }, [i, a, (e = {}) => {
        const {
            textContent: t,
            innerHTML: o,
            ...i
        } = e;
        return i
    }, s, n, r]
}
class Vd extends Fr {
    constructor(e) {
        super(), Lr(this, e, Wd, _d, an, {
            items: 4,
            discardEmptyItems: 5
        })
    }
}
var Hd = (e, t, o, i = (e => e * e * (3 - 2 * e))) => i(Math.max(0, Math.min(1, (o - e) / (t - e))));
var Nd = (e, t) => new CustomEvent("ping", {
        detail: {
            type: e,
            data: t
        },
        cancelable: !0,
        bubbles: !0
    }),
    Ud = (e, t) => (t ? Ts(e, t) : e).replace(/([a-z])([A-Z])/g, "$1-$2").replace(/\s+/g, "-").toLowerCase(),
    jd = (e, t = _) => {
        const {
            subscribe: o,
            set: i
        } = Dr(void 0);
        return {
            subscribe: o,
            destroy: ((e, t) => {
                const o = matchMedia(e);
                return o.addListener(t), t(o), {
                    get matches() {
                        return o.matches
                    },
                    destroy: () => o.removeListener(t)
                }
            })(e, (({
                matches: e
            }) => i(t(e)))).destroy
        }
    },
    Xd = (e, t, o) => new Promise(((i, n) => {
        (async () => {
            const r = await t.read(e),
                a = e => A(e, o).then((e => t.apply(e, r))).then(i).catch(n);
            if (M(e) || !k() || xt() || zt()) return a(e);
            let s;
            try {
                s = await P(((e, t) => createImageBitmap(e).then((e => t(null, e))).catch(t)), [e])
            } catch (e) {}
            s && s.width ? await u() ? c() && window.chrome && r > 1 ? i(await (async e => h(await $(e)))(s)) : i(s) : i(t.apply(s, r)) : a(e)
        })()
    })),
    Yd = (e, t) => new Promise((async o => {
        if (e.width < t.width && e.height < t.height) return o(e);
        const i = Math.min(t.width / e.width, t.height / e.height),
            n = i * e.width,
            r = i * e.height,
            a = p("canvas", {
                width: n,
                height: r
            }),
            s = a.getContext("2d"),
            l = f(e) ? await $(e) : e;
        s.drawImage(l, 0, 0, n, r), o(h(a))
    })),
    Gd = e => (e = e.trim(), /^rgba/.test(e) ? e.substr(5).split(",").map(parseFloat).map(((e, t) => e / (3 === t ? 1 : 255))) : /^rgb/.test(e) ? e.substr(4).split(",").map(parseFloat).map((e => e / 255)) : /^#/.test(e) ? (e => {
        const [, t, o, i] = e.split("");
        e = 4 === e.length ? `#${t}${t}${o}${o}${i}${i}` : e;
        const [, n, r, a] = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);
        return [n, r, a].map((e => parseInt(e, 16) / 255))
    })(e) : /[0-9]{1,3}\s?,\s?[0-9]{1,3}\s?,\s?[0-9]{1,3}/.test(e) ? e.split(",").map((e => parseInt(e, 10))).map((e => e / 255)) : void 0);
let qd = null;
var Zd = () => {
    if (null === qd) {
        let e = p("canvas");
        qd = !!Ss(e), g(e), e = void 0
    }
    return qd
};
const Kd = [1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0],
    Jd = {
        precision: 1e-4
    },
    Qd = {
        precision: .01 * Jd.precision
    };
var eu = () => {
        const e = [],
            t = [],
            o = [],
            i = () => {
                t.forEach((e => e(o)))
            },
            n = t => {
                t.unsub = t.subscribe((n => ((t, n) => {
                    const r = e.indexOf(t);
                    r < 0 || (o[r] = n, i())
                })(t, n))), i()
            };
        return {
            get length() {
                return e.length
            },
            clear: () => {
                e.forEach((e => e.unsub())), e.length = 0, o.length = 0
            },
            unshift: t => {
                e.unshift(t), n(t)
            },
            get: t => e[t],
            push: t => {
                e.push(t), n(t)
            },
            remove: t => {
                t.unsub();
                const i = e.indexOf(t);
                e.splice(i, 1), o.splice(i, 1)
            },
            forEach: t => e.forEach(t),
            filter: t => e.filter(t),
            subscribe: e => (t.push(e), () => {
                t.splice(t.indexOf(e), 1)
            })
        }
    },
    tu = e => e[0] < .25 && e[1] < .25 && e[2] < .25,
    ou = () => new Promise((e => {
        const t = p("input", {
            type: "file",
            accept: "image/*",
            onchange: () => {
                const [o] = t.files;
                if (!o) return e(void 0);
                e(o)
            }
        });
        t.click()
    }));
const {
    window: iu
} = wr;

function nu(e) {
    let t, o, i, n = e[28] && ru(e),
        r = e[29] && mu(e);
    return {
        c() {
            n && n.c(), t = Pn(), r && r.c(), o = An()
        },
        m(e, a) {
            n && n.m(e, a), Cn(e, t, a), r && r.m(e, a), Cn(e, o, a), i = !0
        },
        p(e, i) {
            e[28] ? n ? (n.p(e, i), 268435456 & i[0] && yr(n, 1)) : (n = ru(e), n.c(), yr(n, 1), n.m(t.parentNode, t)) : n && (fr(), xr(n, 1, 1, (() => {
                n = null
            })), $r()), e[29] ? r ? (r.p(e, i), 536870912 & i[0] && yr(r, 1)) : (r = mu(e), r.c(), yr(r, 1), r.m(o.parentNode, o)) : r && (fr(), xr(r, 1, 1, (() => {
                r = null
            })), $r())
        },
        i(e) {
            i || (yr(n), yr(r), i = !0)
        },
        o(e) {
            xr(n), xr(r), i = !1
        },
        d(e) {
            n && n.d(e), e && kn(t), r && r.d(e), e && kn(o)
        }
    }
}

function ru(e) {
    let t, o, i, n, r, a;
    const s = [su, au],
        l = [];

    function c(e, t) {
        return e[25] ? 0 : e[14] ? 1 : -1
    }
    return ~(i = c(e)) && (n = l[i] = s[i](e)), {
        c() {
            t = Mn("div"), o = Mn("p"), n && n.c(), Fn(o, "style", e[46]), Fn(t, "class", "PinturaStatus"), Fn(t, "style", r = "opacity: " + e[27])
        },
        m(e, n) {
            Cn(e, t, n), Sn(t, o), ~i && l[i].m(o, null), a = !0
        },
        p(e, d) {
            let u = i;
            i = c(e), i === u ? ~i && l[i].p(e, d) : (n && (fr(), xr(l[u], 1, 1, (() => {
                l[u] = null
            })), $r()), ~i ? (n = l[i], n ? n.p(e, d) : (n = l[i] = s[i](e), n.c()), yr(n, 1), n.m(o, null)) : n = null), (!a || 32768 & d[1]) && Fn(o, "style", e[46]), (!a || 134217728 & d[0] && r !== (r = "opacity: " + e[27])) && Fn(t, "style", r)
        },
        i(e) {
            a || (yr(n), a = !0)
        },
        o(e) {
            xr(n), a = !1
        },
        d(e) {
            e && kn(t), ~i && l[i].d()
        }
    }
}

function au(e) {
    let t, o, i, n;
    t = new tc({
        props: {
            text: e[14].text || "",
            onmeasure: e[134]
        }
    });
    let r = e[14].aside && lu(e);
    return {
        c() {
            Pr(t.$$.fragment), o = Pn(), r && r.c(), i = An()
        },
        m(e, a) {
            Ar(t, e, a), Cn(e, o, a), r && r.m(e, a), Cn(e, i, a), n = !0
        },
        p(e, o) {
            const n = {};
            16384 & o[0] && (n.text = e[14].text || ""), t.$set(n), e[14].aside ? r ? (r.p(e, o), 16384 & o[0] && yr(r, 1)) : (r = lu(e), r.c(), yr(r, 1), r.m(i.parentNode, i)) : r && (fr(), xr(r, 1, 1, (() => {
                r = null
            })), $r())
        },
        i(e) {
            n || (yr(t.$$.fragment, e), yr(r), n = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), xr(r), n = !1
        },
        d(e) {
            Ir(t, e), e && kn(o), r && r.d(e), e && kn(i)
        }
    }
}

function su(e) {
    let t, o, i, n;
    return t = new tc({
        props: {
            text: e[25],
            onmeasure: e[134]
        }
    }), i = new sc({
        props: {
            class: "PinturaStatusIcon",
            offset: e[50],
            opacity: e[51],
            $$slots: {
                default: [pu]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment), o = Pn(), Pr(i.$$.fragment)
        },
        m(e, r) {
            Ar(t, e, r), Cn(e, o, r), Ar(i, e, r), n = !0
        },
        p(e, o) {
            const n = {};
            33554432 & o[0] && (n.text = e[25]), t.$set(n);
            const r = {};
            524288 & o[1] && (r.offset = e[50]), 1048576 & o[1] && (r.opacity = e[51]), 4 & o[0] | 134217728 & o[12] && (r.$$scope = {
                dirty: o,
                ctx: e
            }), i.$set(r)
        },
        i(e) {
            n || (yr(t.$$.fragment, e), yr(i.$$.fragment, e), n = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), xr(i.$$.fragment, e), n = !1
        },
        d(e) {
            Ir(t, e), e && kn(o), Ir(i, e)
        }
    }
}

function lu(e) {
    let t, o;
    return t = new sc({
        props: {
            class: "PinturaStatusButton",
            offset: e[50],
            opacity: e[51],
            $$slots: {
                default: [uu]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            524288 & o[1] && (i.offset = e[50]), 1048576 & o[1] && (i.opacity = e[51]), 16384 & o[0] | 134217728 & o[12] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function cu(e) {
    let t, o;
    return t = new nc({
        props: {
            progress: e[14].progressIndicator.progress
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            16384 & o[0] && (i.progress = e[14].progressIndicator.progress), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function du(e) {
    let t, o;
    const i = [e[14].closeButton, {
        hideLabel: !0
    }];
    let n = {};
    for (let e = 0; e < i.length; e += 1) n = en(n, i[e]);
    return t = new Wl({
        props: n
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const n = 16384 & o[0] ? Mr(i, [Tr(e[14].closeButton), i[1]]) : {};
            t.$set(n)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function uu(e) {
    let t, o, i, n = e[14].progressIndicator.visible && cu(e),
        r = e[14].closeButton && e[14].text && du(e);
    return {
        c() {
            n && n.c(), t = Pn(), r && r.c(), o = An()
        },
        m(e, a) {
            n && n.m(e, a), Cn(e, t, a), r && r.m(e, a), Cn(e, o, a), i = !0
        },
        p(e, i) {
            e[14].progressIndicator.visible ? n ? (n.p(e, i), 16384 & i[0] && yr(n, 1)) : (n = cu(e), n.c(), yr(n, 1), n.m(t.parentNode, t)) : n && (fr(), xr(n, 1, 1, (() => {
                n = null
            })), $r()), e[14].closeButton && e[14].text ? r ? (r.p(e, i), 16384 & i[0] && yr(r, 1)) : (r = du(e), r.c(), yr(r, 1), r.m(o.parentNode, o)) : r && (fr(), xr(r, 1, 1, (() => {
                r = null
            })), $r())
        },
        i(e) {
            i || (yr(n), yr(r), i = !0)
        },
        o(e) {
            xr(n), xr(r), i = !1
        },
        d(e) {
            n && n.d(e), e && kn(t), r && r.d(e), e && kn(o)
        }
    }
}

function hu(e) {
    let t, o = e[2].iconSupportError + "";
    return {
        c() {
            t = Tn("g")
        },
        m(e, i) {
            Cn(e, t, i), t.innerHTML = o
        },
        p(e, i) {
            4 & i[0] && o !== (o = e[2].iconSupportError + "") && (t.innerHTML = o)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function pu(e) {
    let t, o;
    return t = new Ll({
        props: {
            $$slots: {
                default: [hu]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            4 & o[0] | 134217728 & o[12] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function mu(e) {
    let t, o, i, n, r, a, s, l, c, d = e[6] && gu(e),
        u = e[19] && e[17] && fu(e);
    const h = [vu, bu],
        p = [];

    function m(e, t) {
        return e[19] ? 0 : 1
    }
    return i = m(e), n = p[i] = h[i](e), a = new rl({
        props: {
            animate: e[20],
            pixelRatio: e[54],
            textPixelRatio: e[7],
            backgroundColor: e[55],
            maskRect: e[56],
            maskOpacity: e[45] ? e[45].maskOpacity : 1,
            maskFrameOpacity: "frame" === e[57] && e[58] ? 0 : .95,
            images: e[24],
            interfaceImages: e[59],
            loadImageData: e[9],
            willRequestResource: e[60],
            willRender: e[291],
            didRender: e[292]
        }
    }), {
        c() {
            d && d.c(), t = Pn(), u && u.c(), o = Pn(), n.c(), r = Pn(), Pr(a.$$.fragment), s = Pn(), l = Mn("div"), Fn(l, "class", "PinturaRootPortal")
        },
        m(n, h) {
            d && d.m(n, h), Cn(n, t, h), u && u.m(n, h), Cn(n, o, h), p[i].m(n, h), Cn(n, r, h), Ar(a, n, h), Cn(n, s, h), Cn(n, l, h), e[293](l), c = !0
        },
        p(e, s) {
            e[6] ? d ? (d.p(e, s), 64 & s[0] && yr(d, 1)) : (d = gu(e), d.c(), yr(d, 1), d.m(t.parentNode, t)) : d && (fr(), xr(d, 1, 1, (() => {
                d = null
            })), $r()), e[19] && e[17] ? u ? (u.p(e, s), 655360 & s[0] && yr(u, 1)) : (u = fu(e), u.c(), yr(u, 1), u.m(o.parentNode, o)) : u && (fr(), xr(u, 1, 1, (() => {
                u = null
            })), $r());
            let l = i;
            i = m(e), i === l ? p[i].p(e, s) : (fr(), xr(p[l], 1, 1, (() => {
                p[l] = null
            })), $r(), n = p[i], n ? n.p(e, s) : (n = p[i] = h[i](e), n.c()), yr(n, 1), n.m(r.parentNode, r));
            const c = {};
            1048576 & s[0] && (c.animate = e[20]), 8388608 & s[1] && (c.pixelRatio = e[54]), 128 & s[0] && (c.textPixelRatio = e[7]), 16777216 & s[1] && (c.backgroundColor = e[55]), 33554432 & s[1] && (c.maskRect = e[56]), 16384 & s[1] && (c.maskOpacity = e[45] ? e[45].maskOpacity : 1), 201326592 & s[1] && (c.maskFrameOpacity = "frame" === e[57] && e[58] ? 0 : .95), 16777216 & s[0] && (c.images = e[24]), 268435456 & s[1] && (c.interfaceImages = e[59]), 512 & s[0] && (c.loadImageData = e[9]), 536870912 & s[1] && (c.willRequestResource = e[60]), 1073774624 & s[0] | 1073741827 & s[1] && (c.willRender = e[291]), 120 & s[1] && (c.didRender = e[292]), a.$set(c)
        },
        i(e) {
            c || (yr(d), yr(u), yr(n), yr(a.$$.fragment, e), c = !0)
        },
        o(e) {
            xr(d), xr(u), xr(n), xr(a.$$.fragment, e), c = !1
        },
        d(n) {
            d && d.d(n), n && kn(t), u && u.d(n), n && kn(o), p[i].d(n), n && kn(r), Ir(a, n), n && kn(s), n && kn(l), e[293](null)
        }
    }
}

function gu(e) {
    let t, o, i, n, r;
    return o = new Vd({
        props: {
            items: e[47]
        }
    }), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), Fn(t, "class", "PinturaNav PinturaNavTools")
        },
        m(a, s) {
            Cn(a, t, s), Ar(o, t, null), i = !0, n || (r = [In(t, "measure", e[276]), fn($s.call(null, t))], n = !0)
        },
        p(e, t) {
            const i = {};
            65536 & t[1] && (i.items = e[47]), o.$set(i)
        },
        i(e) {
            i || (yr(o.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), i = !1
        },
        d(e) {
            e && kn(t), Ir(o), n = !1, nn(r)
        }
    }
}

function fu(e) {
    let t, o, i;
    return o = new Kl({
        props: {
            elasticity: e[4] * ku,
            scrollDirection: e[43] ? "y" : "x",
            $$slots: {
                default: [xu]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), Fn(t, "class", "PinturaNav PinturaNavMain")
        },
        m(e, n) {
            Cn(e, t, n), Ar(o, t, null), i = !0
        },
        p(e, t) {
            const i = {};
            16 & t[0] && (i.elasticity = e[4] * ku), 4096 & t[1] && (i.scrollDirection = e[43] ? "y" : "x"), 2097152 & t[0] | 768 & t[1] | 134217728 & t[12] && (i.$$scope = {
                dirty: t,
                ctx: e
            }), o.$set(i)
        },
        i(e) {
            i || (yr(o.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), i = !1
        },
        d(e) {
            e && kn(t), Ir(o)
        }
    }
}

function $u(e) {
    let t, o = e[398].icon + "";
    return {
        c() {
            t = Tn("g")
        },
        m(e, i) {
            Cn(e, t, i), t.innerHTML = o
        },
        p(e, i) {
            67108864 & i[12] && o !== (o = e[398].icon + "") && (t.innerHTML = o)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function yu(e) {
    let t, o, i, n, r, a = e[398].label + "";
    return t = new Ll({
        props: {
            $$slots: {
                default: [$u]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment), o = Pn(), i = Mn("span"), n = Rn(a)
        },
        m(e, a) {
            Ar(t, e, a), Cn(e, o, a), Cn(e, i, a), Sn(i, n), r = !0
        },
        p(e, o) {
            const i = {};
            201326592 & o[12] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i), (!r || 67108864 & o[12]) && a !== (a = e[398].label + "") && Bn(n, a)
        },
        i(e) {
            r || (yr(t.$$.fragment, e), r = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), r = !1
        },
        d(e) {
            Ir(t, e), e && kn(o), e && kn(i)
        }
    }
}

function xu(e) {
    let t, o;
    const i = [e[39], {
        tabs: e[40]
    }];
    let n = {
        $$slots: {
            default: [yu, ({
                tab: e
            }) => ({
                398: e
            }), ({
                tab: e
            }) => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, e ? 67108864 : 0]]
        },
        $$scope: {
            ctx: e
        }
    };
    for (let e = 0; e < i.length; e += 1) n = en(n, i[e]);
    return t = new ml({
        props: n
    }), t.$on("select", e[277]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const n = 768 & o[1] ? Mr(i, [256 & o[1] && Tr(e[39]), 512 & o[1] && {
                tabs: e[40]
            }]) : {};
            201326592 & o[12] && (n.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(n)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function bu(e) {
    let t, o, i;

    function n(t) {
        e[286](t)
    }
    let r = {
        class: "PinturaMain",
        content: {
            ...e[22].find(e[285]),
            props: e[8][e[21]]
        },
        locale: e[2],
        isAnimated: e[20],
        stores: e[123]
    };
    return void 0 !== e[0][e[21]] && (r.component = e[0][e[21]]), t = new Al({
        props: r
    }), tr.push((() => Rr(t, "component", n))), t.$on("measure", e[287]), t.$on("show", e[288]), t.$on("hide", e[289]), t.$on("fade", e[290]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, o) {
            Ar(t, e, o), i = !0
        },
        p(e, i) {
            const n = {};
            6291712 & i[0] && (n.content = {
                ...e[22].find(e[285]),
                props: e[8][e[21]]
            }), 4 & i[0] && (n.locale = e[2]), 1048576 & i[0] && (n.isAnimated = e[20]), !o && 2097153 & i[0] && (o = !0, n.component = e[0][e[21]], sr((() => o = !1))), t.$set(n)
        },
        i(e) {
            i || (yr(t.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), i = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function vu(e) {
    let t, o;
    const i = [{
        class: "PinturaMain"
    }, {
        visible: e[33]
    }, e[39], {
        panels: e[41]
    }];
    let n = {
        $$slots: {
            default: [wu, ({
                panel: e
            }) => ({
                397: e
            }), ({
                panel: e
            }) => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, e ? 33554432 : 0]]
        },
        $$scope: {
            ctx: e
        }
    };
    for (let e = 0; e < i.length; e += 1) n = en(n, i[e]);
    return t = new Ml({
        props: n
    }), t.$on("measure", e[284]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const n = 1284 & o[1] ? Mr(i, [i[0], 4 & o[1] && {
                visible: e[33]
            }, 256 & o[1] && Tr(e[39]), 1024 & o[1] && {
                panels: e[41]
            }]) : {};
            15728901 & o[0] | 4194308 & o[1] | 167772160 & o[12] && (n.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(n)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function wu(e) {
    let t, o, i;

    function n(...t) {
        return e[278](e[397], ...t)
    }

    function r(t) {
        e[279](t, e[397])
    }
    let a = {
        content: {
            ...e[22].find(n),
            props: e[8][e[397]]
        },
        locale: e[2],
        isActive: e[397] === e[21],
        isAnimated: e[20],
        stores: e[123]
    };
    return void 0 !== e[0][e[397]] && (a.component = e[0][e[397]]), t = new Al({
        props: a
    }), tr.push((() => Rr(t, "component", r))), t.$on("measure", e[280]), t.$on("show", (function () {
        return e[281](e[397])
    })), t.$on("hide", (function () {
        return e[282](e[397])
    })), t.$on("fade", (function (...t) {
        return e[283](e[397], ...t)
    })), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, o) {
            Ar(t, e, o), i = !0
        },
        p(i, r) {
            e = i;
            const a = {};
            4194560 & r[0] | 33554432 & r[12] && (a.content = {
                ...e[22].find(n),
                props: e[8][e[397]]
            }), 4 & r[0] && (a.locale = e[2]), 2097152 & r[0] | 33554432 & r[12] && (a.isActive = e[397] === e[21]), 1048576 & r[0] && (a.isAnimated = e[20]), !o && 1 & r[0] | 33554432 & r[12] && (o = !0, a.component = e[0][e[397]], sr((() => o = !1))), t.$set(a)
        },
        i(e) {
            i || (yr(t.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), i = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Su(e) {
    let t, o;
    return {
        c() {
            t = Mn("span"), Fn(t, "class", "PinturaEditorOverlay"), Fn(t, "style", o = "opacity:" + e[62])
        },
        m(e, o) {
            Cn(e, t, o)
        },
        p(e, i) {
            1 & i[2] && o !== (o = "opacity:" + e[62]) && Fn(t, "style", o)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function Cu(e) {
    let t, o, i, r, a;
    ar(e[275]);
    let s = e[48] && nu(e),
        l = e[62] > 0 && Su(e);
    return {
        c() {
            t = Mn("div"), s && s.c(), o = Pn(), l && l.c(), Fn(t, "id", e[3]), Fn(t, "class", e[42]), Fn(t, "data-env", e[44])
        },
        m(c, d) {
            Cn(c, t, d), s && s.m(t, null), Sn(t, o), l && l.m(t, null), e[294](t), i = !0, r || (a = [In(iu, "keydown", e[139]), In(iu, "keyup", e[140]), In(iu, "blur", e[141]), In(iu, "paste", e[145]), In(iu, "resize", e[275]), In(t, "ping", (function () {
                rn(e[49]) && e[49].apply(this, arguments)
            })), In(t, "contextmenu", e[142]), In(t, "touchstart", e[135], {
                passive: !1
            }), In(t, "touchmove", e[136]), In(t, "pointermove", e[137]), In(t, "transitionend", e[124]), In(t, "dropfiles", e[143]), In(t, "measure", e[295]), In(t, "click", (function () {
                rn(e[26] ? e[144] : n) && (e[26] ? e[144] : n).apply(this, arguments)
            })), fn($s.call(null, t, {
                observeViewRect: !0
            })), fn(ys.call(null, t)), fn(bs.call(null, t))], r = !0)
        },
        p(n, r) {
            (e = n)[48] ? s ? (s.p(e, r), 131072 & r[1] && yr(s, 1)) : (s = nu(e), s.c(), yr(s, 1), s.m(t, o)): s && (fr(), xr(s, 1, 1, (() => {
                s = null
            })), $r()), e[62] > 0 ? l ? l.p(e, r) : (l = Su(e), l.c(), l.m(t, null)) : l && (l.d(1), l = null), (!i || 8 & r[0]) && Fn(t, "id", e[3]), (!i || 2048 & r[1]) && Fn(t, "class", e[42]), (!i || 8192 & r[1]) && Fn(t, "data-env", e[44])
        },
        i(e) {
            i || (yr(s), i = !0)
        },
        o(e) {
            xr(s), i = !1
        },
        d(o) {
            o && kn(t), s && s.d(), l && l.d(), e[294](null), r = !1, nn(a)
        }
    }
}
const ku = 10;

function Mu(e, t, o) {
    let i, r, a, s, l, c, d, u, m, f, $, y, x, b, v, S, C, k, M, R, P, A, I, E, L, F, z, B, D, O, W, V, H, N, U, j, X, q, J, Q, ee, te, oe, ie, ae, se, le, ce, de, ue, he, pe, me, ge, fe, $e, ye, xe, ve, we, Se, Ce, ke, Te, Re, Pe, Ae, Ie, ze, Be, De, Oe, Ye, Ge, Ke, Je, et, tt, it, rt, at, st, lt, ct, dt, ht, pt, mt, gt, ft, $t, yt, xt, bt, vt, wt, St, Ct, kt, Mt, Tt, Rt, Pt, At, It, Et, Lt, Ft, Bt, Dt, Ot, _t, Wt, Vt, Ht, Nt, Ut, jt, Xt, Yt, Gt, qt, Kt, Jt, Qt, eo, to, oo, io, no, ao, so, lo, co, uo, ho, mo, go, fo, $o, yo, xo, bo, vo, wo, So, Co = Ji,
        ko = Ji;
    cn(e, as, (e => o(216, It = e))), e.$$.on_destroy.push((() => Co())), e.$$.on_destroy.push((() => ko()));
    const Mo = po(),
        To = Zn();
    let {
        class: Ro
    } = t, {
        layout: Po
    } = t, {
        stores: Ao
    } = t, {
        locale: Lo
    } = t, {
        id: Fo
    } = t, {
        util: zo
    } = t, {
        utils: Bo
    } = t, {
        animations: Do = "auto"
    } = t, {
        disabled: Oo = !1
    } = t, {
        status: Vo
    } = t, {
        previewUpscale: Ho = !1
    } = t, {
        elasticityMultiplier: No = 10
    } = t, {
        willRevert: Xo = (() => Promise.resolve(!0))
    } = t, {
        willProcessImage: Yo = (() => Promise.resolve(!0))
    } = t, {
        willRenderCanvas: qo = _
    } = t, {
        willRenderToolbar: Zo = _
    } = t, {
        willSetHistoryInitialState: Ko = _
    } = t, {
        enableButtonExport: Jo = !0
    } = t, {
        enableButtonRevert: Qo = !0
    } = t, {
        enableNavigateHistory: ei = !0
    } = t, {
        enableToolbar: ti = !0
    } = t, {
        enableUtils: oi = !0
    } = t, {
        enableButtonClose: ii = !1
    } = t, {
        enableDropImage: ni = !1
    } = t, {
        enablePasteImage: ri = !1
    } = t, {
        enableBrowseImage: ai = !1
    } = t, {
        previewImageDataMaxSize: si
    } = t, {
        previewImageTextPixelRatio: li
    } = t, {
        layoutDirectionPreference: ci = "auto"
    } = t, {
        layoutHorizontalUtilsPreference: di = "left"
    } = t, {
        layoutVerticalUtilsPreference: ui = "bottom"
    } = t, {
        imagePreviewSrc: hi
    } = t, {
        imageOrienter: pi = {
            read: () => 1,
            apply: e => e
        }
    } = t, {
        pluginComponents: mi
    } = t, {
        pluginOptions: gi = {}
    } = t;
    const fi = Mo.sub,
        $i = {};
    let {
        root: yi
    } = t, xi = [];
    const bi = rs();
    cn(e, bi, (e => o(62, So = e)));
    const vi = Gs() || 1024,
        Si = be(vi, vi),
        Ci = wa();
    let {
        imageSourceToImageData: ki = (e => w(e) ? fetch(e).then((e => {
            if (200 !== e.status) throw `${e.status} (${e.statusText})`;
            return e.blob()
        })).then((e => Xd(e, pi, Ci))).then((e => Yd(e, a))) : ut(e) ? new Promise((t => t(h(e)))) : Xd(e, pi, Ci).then((e => Yd(e, a))))
    } = t;
    const Mi = (() => {
            let e, t;
            const o = ["file", "size", "loadState", "processState", "cropAspectRatio", "cropLimitToImage", "crop", "cropMinSize", "cropMaxSize", "cropRange", "cropOrigin", "cropRectAspectRatio", "rotation", "rotationRange", "targetSize", "flipX", "flipY", "perspectiveX", "perspectiveY", "perspective", "colorMatrix", "convolutionMatrix", "gamma", "vignette", "noise", "redaction", "decoration", "annotation", "frame", "backgroundColor", "state"],
                i = o.reduce(((e, o) => (e[o] = function (e, t, o) {
                    let i = [];
                    return {
                        set: t,
                        update: o,
                        publish: e => {
                            i.forEach((t => t(e)))
                        },
                        subscribe: t => (i.push(t), e(t), () => {
                            i = i.filter((e => e !== t))
                        })
                    }
                }((e => {
                    if (!t) return e();
                    t.stores[o].subscribe(e)()
                }), (e => {
                    t && t.stores[o].set(e)
                }), (e => {
                    t && t.stores[o].update(e)
                })), e)), {});
            return {
                update: n => {
                    if (t = n, e && (e.forEach((e => e())), e = void 0), !n) return i.file.publish(void 0), void i.loadState.publish(void 0);
                    e = o.map((e => n.stores[e].subscribe((t => {
                        i[e].publish(t)
                    }))))
                },
                stores: i,
                destroy: () => {
                    e && e.forEach((e => e()))
                }
            }
        })(),
        {
            file: Pi,
            size: Ai,
            loadState: Ei,
            processState: Li,
            cropAspectRatio: Fi,
            cropLimitToImage: zi,
            crop: Bi,
            cropMinSize: Di,
            cropMaxSize: Oi,
            cropRange: _i,
            cropOrigin: Wi,
            cropRectAspectRatio: Vi,
            rotation: Hi,
            rotationRange: Ni,
            targetSize: Ui,
            flipX: ji,
            flipY: Xi,
            backgroundColor: Yi,
            colorMatrix: Gi,
            convolutionMatrix: qi,
            gamma: Qi,
            vignette: en,
            noise: tn,
            decoration: on,
            annotation: nn,
            redaction: rn,
            frame: an,
            state: dn
        } = Mi.stores;
    cn(e, Pi, (e => o(211, Rt = e))), cn(e, Ai, (e => o(196, $t = e))), cn(e, Ei, (e => o(190, it = e))), cn(e, Li, (e => o(254, jt = e))), cn(e, Fi, (e => o(309, et = e))), cn(e, Bi, (e => o(191, rt = e))), cn(e, Ui, (e => o(195, gt = e))), cn(e, Yi, (e => o(274, to = e))), cn(e, on, (e => o(31, so = e))), cn(e, nn, (e => o(30, ao = e))), cn(e, rn, (e => o(271, Qt = e))), cn(e, an, (e => o(32, lo = e))), cn(e, dn, (e => o(318, Et = e)));
    const {
        images: un,
        shapePreprocessor: hn,
        imageScrambler: pn,
        willRequestResource: mn
    } = Ao;
    cn(e, un, (e => o(187, Ge = e))), cn(e, hn, (e => o(188, Ke = e))), cn(e, pn, (e => o(273, eo = e))), cn(e, mn, (e => o(60, vo = e)));
    const fn = dn.subscribe((e => Mo.pub("update", e))),
        $n = Dr();
    cn(e, $n, (e => o(57, yo = e)));
    const yn = Dr([0, 0, 0]);
    cn(e, yn, (e => o(55, fo = e)));
    const xn = Dr([1, 1, 1]);
    cn(e, xn, (e => o(320, oo = e)));
    const bn = rs();
    cn(e, bn, (e => o(321, io = e)));
    const vn = Dr(),
        wn = Dr();
    cn(e, wn, (e => o(18, Je = e)));
    const Sn = Dr();
    cn(e, Sn, (e => o(189, tt = e)));
    const Cn = Dr(Le());
    cn(e, Cn, (e => o(38, Lt = e)));
    const kn = Dr(Le());
    cn(e, kn, (e => o(52, ho = e)));
    const Mn = Dr();
    cn(e, Mn, (e => o(53, mo = e)));
    const Tn = jd("(pointer: fine)", (e => e ? "pointer-fine" : "pointer-coarse"));
    cn(e, Tn, (e => o(240, Ot = e)));
    const Rn = jd("(hover: hover)", (e => e ? "pointer-hover" : "pointer-no-hover"));
    cn(e, Rn, (e => o(241, _t = e)));
    const Pn = Dr(!1);
    cn(e, Pn, (e => o(192, st = e)));
    const An = Br(void 0, (e => {
        const t = rs(0),
            o = [Pn.subscribe((e => {
                t.set(e ? 1 : 0)
            })), t.subscribe(e)];
        return () => o.forEach((e => e()))
    }));
    cn(e, An, (e => o(322, no = e)));
    const In = Dr(Ho);
    cn(e, In, (e => o(312, ct = e)));
    const En = Dr();
    cn(e, En, (e => o(311, lt = e)));
    const Ln = Dr();
    cn(e, Ln, (e => o(310, at = e)));
    const Fn = Br(void 0, (e => {
            const t = rs(void 0, {
                    precision: 1e-4
                }),
                o = [Bi.subscribe((() => {
                    if (!rt) return;
                    const e = void 0 === at || st,
                        o = jl(rt, at, 5 * No);
                    t.set(o, {
                        hard: e
                    })
                })), t.subscribe(e)];
            return () => o.forEach((e => e()))
        })),
        zn = Dr();
    cn(e, zn, (e => o(313, dt = e)));
    const Bn = Dr();
    cn(e, Bn, (e => o(317, xt = e)));
    const Dn = Dr(void 0);
    cn(e, Dn, (e => o(314, pt = e)));
    let On = {
        left: 0,
        right: 0,
        top: 0,
        bottom: 0
    };
    const _n = Or([an, zn], (([e, t], o) => {
            t || o(On);
            let i = Xn(t, e);
            Io(On.top, 4) === Io(i.top, 4) && Io(On.bottom, 4) === Io(i.bottom, 4) && Io(On.right, 4) === Io(i.right, 4) && Io(On.left, 4) === Io(i.left, 4) || (On = i, o(i))
        })),
        Wn = Or([_n], (([e], t) => {
            t(Object.values(e).some((e => e > 0)))
        }));
    let Vn = {
        left: 0,
        right: 0,
        top: 0,
        bottom: 0
    };
    const Hn = Or([$n, an, zn], (([e, t, o], i) => {
            let n;
            o || i(Vn), n = "frame" === e ? Xn(o, t) : {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }, Io(Vn.top, 4) === Io(n.top, 4) && Io(Vn.bottom, 4) === Io(n.bottom, 4) && Io(Vn.right, 4) === Io(n.right, 4) && Io(Vn.left, 4) === Io(n.left, 4) || (Vn = n, i(n))
        })),
        Nn = Or([Hn], (([e], t) => {
            t(Object.values(e).some((e => e > 0)))
        }));
    cn(e, Nn, (e => o(58, xo = e)));
    const Un = Or([Mn, Cn, kn, Hn], (([e, t, o, n], r) => {
        if (!e) return r(void 0);
        let a = 0;
        1 !== v.length || i || (a = o.y + o.height), r(_e(e.x + t.x + n.top, e.y + t.y + a + n.top, e.width - (n.left + n.right), e.height - (n.top + n.bottom)))
    }));
    cn(e, Un, (e => o(194, mt = e)));
    const jn = Or([Un, Bi], (([e, t], o) => {
        if (!e || !t || !(!lt && !at)) return;
        const i = Math.min(e.width / t.width, e.height / t.height);
        o(ct ? i : Math.min(1, i))
    }));
    cn(e, jn, (e => o(315, ft = e)));
    const Xn = (e, t) => {
            if (!t || !e) return {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
            };
            const o = Ri(t, e, s),
                i = Ti(o, e);
            return {
                top: Math.abs(i.top),
                right: Math.abs(i.right),
                bottom: Math.abs(i.bottom),
                left: Math.abs(i.left)
            }
        },
        Yn = Br(void 0, (e => {
            const t = rs(void 0, {
                    precision: 1e-4
                }),
                o = () => {
                    if (!dt) return;
                    const e = st || !ht,
                        o = jl(dt, pt, 1 * No);
                    if (o.width < 0 && (o.width = 0, o.x = dt.x), o.height < 0 && (o.height = 0, o.y = dt.y), Ve(o, mt), rt && "resize" === M) {
                        const e = gt || rt;
                        He(o, e.width / dt.width || e.height / dt.height)
                    }
                    t.set(o, {
                        hard: e
                    })
                },
                i = [Un.subscribe(o), zn.subscribe(o), Ui.subscribe(o), an.subscribe(o), t.subscribe(e)];
            return () => i.forEach((e => e()))
        }));
    let Gn;
    cn(e, Yn, (e => o(56, $o = e)));
    const Jn = e => {
        if (i && Gn && je(Gn, e)) return;
        Gn = e;
        const t = rt.width <= e.width && rt.height <= e.height ? Ze(e, Ne(Ee(rt), ft || 1)) : Qe(e, Xe(rt || $t));
        zn.set(t)
    };
    let Qn = !1;
    const er = jn.subscribe((e => {
            !Qn && void 0 !== e && rt && (Jn(mt), Qn = !0)
        })),
        or = Un.subscribe((e => {
            e && void 0 !== ft && rt && Jn(e)
        }));
    let ir;
    const nr = Bn.subscribe((e => {
            if (!e) return ir = void 0, void gn(En, lt = void 0, lt);
            ir = yt;
            const t = Ee(rt);
            En.set(t)
        })),
        rr = zn.subscribe((e => {
            if (!e || !xt) return;
            const t = (o = Ee(e), i = xt, o.x -= i.x, o.y -= i.y, o.width -= i.width, o.height -= i.height, o);
            var o, i;
            Ue(t, ir);
            const n = ((e, t) => (e.x += t.x, e.y += t.y, e.width += t.width, e.height += t.height, e))(Ee(lt), t);
            Bi.set(n)
        })),
        ar = Bi.subscribe((e => {
            if (st || xt || at) return;
            if (!e || !dt) return;
            const t = Xe(dt),
                o = Xe(e);
            if (Io(t, 6) === Io(o, 6)) return;
            const i = Math.min(mt.width / rt.width, mt.height / rt.height),
                n = be(e.width * i, e.height * i),
                r = .5 * (dt.width - n.width),
                a = .5 * (dt.height - n.height),
                s = _e(dt.x + r, dt.y + a, n.width, n.height);
            zn.set(s)
        })),
        sr = Or([jn, Bi, zn], (([e, t, o], i) => {
            if (!e || !t || !o) return;
            const n = o.width / t.width,
                r = o.height / t.height;
            i(Math.max(n, r) / e)
        })),
        lr = Or([jn, sr], (([e, t], o) => {
            if (!t) return;
            o(e * t)
        }));
    cn(e, lr, (e => o(316, yt = e)));
    const cr = rs(.075, {
            stiffness: .03,
            damping: .4,
            precision: .001
        }),
        dr = Or([Yn, _n], (([e, t], o) => {
            if (!e) return;
            let {
                x: i,
                y: n,
                width: r,
                height: a
            } = e, {
                left: s,
                right: l,
                top: c,
                bottom: d
            } = t;
            if ("resize" === M) {
                const e = gt || rt,
                    t = e.width / dt.width || e.height / dt.height;
                s *= t, l *= t, c *= t, d *= t
            }
            o({
                x: i - s,
                y: n - l,
                width: r + s + l,
                height: a + c + d
            })
        }));
    cn(e, dr, (e => o(199, vt = e)));
    const ur = Or([bn, cr, Yn, an, Wn, _n], (([e, t, o, n, r, a], s) => {
            if (!o || i) return s([]);
            let {
                x: l,
                y: c,
                width: d,
                height: u
            } = o;
            l += .5, c += .5, d -= .5, u -= .5;
            const h = [];
            if (r) {
                t > .1 && h.push({
                    x: l,
                    y: c,
                    width: d - .5,
                    height: u - .5,
                    strokeWidth: 1,
                    strokeColor: e,
                    opacity: t
                });
                let {
                    left: o,
                    right: i,
                    top: n,
                    bottom: r
                } = a;
                if ("resize" === M) {
                    const e = gt || rt,
                        t = e.width / dt.width || e.height / dt.height;
                    o *= t, i *= t, n *= t, r *= t
                }
                return void s([...h, {
                    x: l - o,
                    y: c - i,
                    width: d + o + i,
                    height: u + n + r,
                    strokeWidth: 1,
                    strokeColor: e,
                    opacity: .05
                }])
            }
            const p = tu(e),
                m = n && n.frameColor && tu(n.frameColor);
            if (p && m || !p && !p) {
                const e = p ? [1, 1, 1, .3] : [0, 0, 0, .075];
                h.push({
                    x: l,
                    y: c,
                    width: d,
                    height: u,
                    strokeWidth: 3.5,
                    strokeColor: e,
                    opacity: t
                })
            }
            s([...h, {
                x: l,
                y: c,
                width: d,
                height: u,
                strokeWidth: 1,
                strokeColor: e,
                opacity: t
            }])
        })),
        hr = Dr([]);
    cn(e, hr, (e => o(210, Tt = e)));
    const pr = Or([ur, hr], (([e, t], o) => {
        o([...e, ...t])
    }));
    cn(e, pr, (e => o(61, wo = e)));
    const mr = (e, t, o) => {
            const i = p("canvas", {
                width: Math.max(1, e),
                height: Math.max(1, t)
            }).getContext("2d");
            let n = i.createLinearGradient(0, 0, e, t);
            return [
                [0, 0],
                [.013, .081],
                [.049, .155],
                [.104, .225],
                [.175, .29],
                [.259, .353],
                [.352, .412],
                [.45, .471],
                [.55, .529],
                [.648, .588],
                [.741, .647],
                [.825, .71],
                [.896, .775],
                [.951, .845],
                [.987, .919],
                [1, 1]
            ].forEach((([e, t]) => n.addColorStop(t, `rgba(${255*o[0]}, ${255*o[1]}, ${255*o[2]}, ${e})`))), i.fillStyle = n, i.fillRect(0, 0, i.canvas.width, i.canvas.height), n = void 0, i.canvas
        },
        gr = rs(40);
    cn(e, gr, (e => o(198, bt = e)));
    const fr = rs(70);
    cn(e, fr, (e => o(201, wt = e)));
    const $r = rs(0);
    cn(e, $r, (e => o(206, kt = e)));
    const yr = rs(0);
    cn(e, yr, (e => o(208, Mt = e)));
    const xr = rs(0);
    cn(e, xr, (e => o(202, St = e)));
    const br = rs(0);
    let vr, wr;
    cn(e, br, (e => o(204, Ct = e)));
    const Sr = yn.subscribe((e => {
            e && (vr && g(vr), wr && g(wr), o(179, vr = mr(16, 0, e)), o(179, vr.dataset.retain = 1, vr), o(180, wr = mr(0, 16, e)), o(180, wr.dataset.retain = 1, wr))
        })),
        Cr = Dr(!1);
    cn(e, Cr, (e => o(251, Ut = e)));
    const kr = Dr();
    cn(e, kr, (e => o(213, At = e)));
    let Mr;
    const Tr = Or([Cr, kr], (([e, t], i) => {
        if (e && t) {
            if (Mr && (Mr.cancel(), o(181, Mr = void 0)), Ii(t)) return i((e => {
                const t = p("canvas", {
                    width: e.width,
                    height: e.height
                });
                return t.getContext("2d").drawImage(e, 0, 0), t
            })(t));
            var r, a;
            o(181, Mr = {
                cancel: n
            }), (r = t, a = Mr, new Promise(((e, t) => {
                const o = ra.length ? 0 : 250;
                let i, n = !1;
                a.cancel = () => n = !0;
                const s = Date.now();
                ki(r).then((t => {
                    const r = Date.now() - s;
                    clearTimeout(i), i = setTimeout((() => {
                        n || e(t)
                    }), Math.max(0, o - r))
                })).catch(t)
            }))).then(i).catch((e => {
                gn(Ei, it.error = e, it)
            })).finally((() => {
                o(181, Mr = void 0)
            }))
        } else i(void 0)
    }));
    Co(), Co = sn(Tr, (e => o(212, Pt = e)));
    let {
        imagePreviewCurrent: Rr
    } = t;
    const Pr = Dr({});
    cn(e, Pr, (e => o(243, Vt = e)));
    const Ar = Dr([]);
    cn(e, Ar, (e => o(59, bo = e)));
    const Ir = Or([Un, Sn, Ai, Fn, zn, lr, Hi, ji, Xi, Ui], (([e, t, o, i, n, r, a, s, l, c], d) => {
        if (e && n) {
            if ("resize" === M) {
                const e = c || i;
                r = e.width / i.width || e.height / i.height
            }
            d(((e, t, o, i, n, r, a, s, l) => {
                if (!(e && t && o && i && r)) return;
                const c = nt(Ee(t)),
                    d = We(c),
                    u = We(e),
                    h = Fe(o),
                    p = We(h),
                    m = ta(o, i, a),
                    g = We(m),
                    f = re(Z(p), g),
                    $ = re(Z(u), d);
                f.x += $.x, f.y += $.y;
                const y = K(Z(f));
                y.x += $.x, y.y += $.y;
                const x = We(Ve(Ee(n), e)),
                    b = re(x, u);
                return ne(f, b), {
                    origin: y,
                    translation: f,
                    rotation: {
                        x: l ? Math.PI : 0,
                        y: s ? Math.PI : 0,
                        z: a
                    },
                    scale: r
                }
            })(e, t, o, i, n, r, a, s, l))
        }
    }));
    cn(e, Ir, (e => o(242, Wt = e)));
    const Er = Or([Gi, qi, Qi, en, tn], (([e, t, o, i, n], r) => {
        const a = e && Object.keys(e).map((t => e[t])).filter(Boolean);
        r({
            gamma: o || void 0,
            vignette: i || void 0,
            noise: n || void 0,
            convolutionMatrix: t || void 0,
            colorMatrix: a && a.length && Zi(a)
        })
    }));
    let Lr, Fr;
    const zr = (() => {
            if (!zt()) return !1;
            const e = navigator.userAgent.match(/OS (\d+)_(\d+)_?(\d+)?/i) || [],
                [, t, o] = e.map((e => parseInt(e, 10) || 0));
            return t > 13 || 13 === t && o >= 4
        })(),
        _r = Dr({});
    cn(e, _r, (e => o(239, Dt = e)));
    const Wr = mc(),
        Vr = Br(Wr, (e => {
            const t = () => e(mc()),
                o = matchMedia(`(resolution: ${Wr}dppx)`);
            return o.addListener(t), () => o.removeListener(t)
        }));
    cn(e, Vr, (e => o(54, go = e)));
    const Hr = Dr();
    cn(e, Hr, (e => o(20, ht = e)));
    const Nr = ((e, t) => {
        const {
            sub: o,
            pub: i
        } = po(), n = [], r = Dr(0), a = [], s = () => a.forEach((e => e({
            index: ln(r),
            length: n.length
        }))), l = {
            get index() {
                return ln(r)
            },
            set index(e) {
                e = Number.isInteger(e) ? e : 0, e = oa(e, 0, n.length - 1), r.set(e), t(n[l.index]), s()
            },
            get state() {
                return n[n.length - 1]
            },
            length: () => n.length,
            undo() {
                const e = l.index--;
                return i("undo", e), e
            },
            redo() {
                const e = l.index++;
                return i("redo", l.index), e
            },
            revert() {
                n.length = 1, l.index = 0, i("revert")
            },
            write(o) {
                o && t({
                    ...e(),
                    ...o
                });
                const i = e(),
                    a = n[n.length - 1];
                JSON.stringify(i) !== JSON.stringify(a) && (n.length = l.index + 1, n.push(i), r.set(n.length - 1), s())
            },
            set(e = {}) {
                n.length = 0, l.index = 0;
                const t = Array.isArray(e) ? e : [e];
                n.push(...t), l.index = n.length - 1
            },
            get: () => [...n],
            subscribe: e => (a.push(e), e({
                index: l.index,
                length: n.length
            }), () => a.splice(a.indexOf(e), 1)),
            on: o
        };
        return l
    })((() => Et), (e => {
        gn(dn, Et = e, Et), Cn.set(Lt)
    }));
    ko(), ko = sn(Nr, (e => o(218, Ft = e)));
    const Ur = () => {
            const e = {
                    x: 0,
                    y: 0,
                    ...$t
                },
                t = ot(Qe(e, Et.cropAspectRatio), Math.round),
                o = Ko({
                    ...Et,
                    rotation: 0,
                    crop: t
                }, Et),
                i = [o];
            JSON.stringify(o) !== JSON.stringify(Et) && i.push({
                ...Et
            }), Nr.set(i)
        },
        jr = Ei.subscribe((e => {
            e && e.complete && Ur()
        })),
        Xr = () => Xo().then((e => e && Nr.revert())),
        Yr = Dr(!1);
    cn(e, Yr, (e => o(220, Bt = e)));
    const Gr = () => {
            gn(Yr, Bt = !0, Bt), Yo().then((e => {
                if (!e) return void gn(Yr, Bt = !1, Bt);
                let t;
                t = ca.subscribe((e => {
                    1 === e && (t && t(), To("processImage"))
                }))
            }))
        },
        qr = Li.subscribe((e => {
            if (!e) return;
            gn(Yr, Bt = !0, Bt);
            const {
                complete: t,
                abort: o
            } = e;
            (t || o) && gn(Yr, Bt = !1, Bt)
        })),
        Zr = {
            ...Ao,
            imageFile: Pi,
            imageSize: Ai,
            imageBackgroundColor: Yi,
            imageCropAspectRatio: Fi,
            imageCropMinSize: Di,
            imageCropMaxSize: Oi,
            imageCropLimitToImage: zi,
            imageCropRect: Bi,
            imageCropRectOrigin: Wi,
            imageCropRectSnapshot: En,
            imageCropRectAspectRatio: Vi,
            imageCropRange: _i,
            imageRotation: Hi,
            imageRotationRange: Ni,
            imageFlipX: ji,
            imageFlipY: Xi,
            imageOutputSize: Ui,
            imageColorMatrix: Gi,
            imageConvolutionMatrix: qi,
            imageGamma: Qi,
            imageVignette: en,
            imageNoise: tn,
            imageDecoration: on,
            imageAnnotation: nn,
            imageRedaction: rn,
            imageFrame: an,
            imagePreview: Tr,
            imagePreviewSource: kr,
            imageTransforms: Ir,
            imagePreviewModifiers: Pr,
            history: Nr,
            animation: Hr,
            pixelRatio: Vr,
            elasticityMultiplier: No,
            scrollElasticity: ku,
            rangeInputElasticity: 5,
            pointerAccuracy: Tn,
            pointerHoverable: Rn,
            env: _r,
            rootRect: Sn,
            stageRect: Un,
            stageScalar: jn,
            framePadded: Wn,
            utilRect: Mn,
            presentationScalar: lr,
            rootBackgroundColor: yn,
            rootForegroundColor: xn,
            rootLineColor: bn,
            rootColorSecondary: vn,
            imageOutlineOpacity: cr,
            imageOverlayMarkup: hr,
            interfaceImages: Ar,
            isInteracting: Pn,
            isInteractingFraction: An,
            imageCropRectIntent: Ln,
            imageCropRectPresentation: Fn,
            imageSelectionRect: zn,
            imageSelectionRectIntent: Dn,
            imageSelectionRectPresentation: Yn,
            imageSelectionRectSnapshot: Bn,
            imageScalar: sr
        };
    delete Zr.image;
    const Kr = "util-" + T();
    let Jr = [],
        Qr = zt();
    const ea = (e, t) => {
            const o = (e => {
                const t = te.getPropertyValue(e);
                return Gd(t)
            })(e);
            o && 0 !== o[3] && (o.length = 3, t.set(o))
        },
        ia = () => {
            ea("color", xn), ea("background-color", yn), ea("outline-color", bn), ea("--color-secondary", vn)
        },
        na = Or([Ir, Er, Yi], (([e, t, o]) => e && {
            ...e,
            ...t,
            backgroundColor: o
        }));
    cn(e, na, (e => o(245, Ht = e)));
    const ra = eu();
    cn(e, ra, (e => o(24, Nt = e)));
    const aa = () => {
            const e = ra.length ? void 0 : {
                    resize: 1.05
                },
                t = ((e, t, o = {}) => {
                    const {
                        resize: i = 1,
                        opacity: n = 0
                    } = o, r = {
                        opacity: [rs(n, {
                            ...Jd,
                            stiffness: .1
                        }), _],
                        resize: [rs(i, {
                            ...Jd,
                            stiffness: .1
                        }), _],
                        translation: [rs(void 0, Jd), _],
                        rotation: [rs(void 0, Qd), _],
                        origin: [rs(void 0, Jd), _],
                        scale: [rs(void 0, Qd), _],
                        gamma: [rs(void 0, Qd), e => e || 1],
                        vignette: [rs(void 0, Qd), e => e || 0],
                        colorMatrix: [rs([...Kd], Jd), e => e || [...Kd]],
                        convolutionMatrix: [Dr(void 0), e => e && e.clarity || void 0],
                        backgroundColor: [rs(void 0, Jd), _]
                    }, a = Object.entries(r).map((([e, t]) => [e, t[0]])), s = a.map((([, e]) => e)), l = Object.entries(r).reduce(((e, [t, o]) => {
                        const [i, n] = o;
                        return e[t] = (e, t) => i.set(n(e), t), e
                    }), {});
                    let c;
                    const d = Or(s, (o => (c = o.reduce(((e, t, o) => (e[a[o][0]] = t, e)), {}), c.data = e, c.size = t, c.scale *= o[1], c)));
                    return d.get = () => c, d.set = (e, t) => {
                        const o = {
                            hard: !t
                        };
                        Object.entries(e).forEach((([e, t]) => {
                            l[e] && l[e](t, o)
                        }))
                    }, d
                })(Pt, $t, e);
            ra.unshift(t), sa(Ht)
        },
        sa = e => {
            ra.forEach(((t, o) => {
                const i = 0 === o ? 1 : 0;
                t.set({
                    ...e,
                    opacity: i,
                    resize: 1
                }, ht)
            }))
        };
    let la;
    const ca = is(void 0, {
        duration: 500
    });
    let da;
    cn(e, ca, (e => o(27, Yt = e)));
    const ua = Dr(!1);
    let ha;
    cn(e, ua, (e => o(263, Xt = e)));
    const pa = rs(void 0, {
        stiffness: .1,
        damping: .7,
        precision: .25
    });
    cn(e, pa, (e => o(50, co = e)));
    const ma = rs(0, {
        stiffness: .1,
        precision: .05
    });
    cn(e, ma, (e => o(51, uo = e)));
    const ga = rs(0, {
        stiffness: .02,
        damping: .5,
        precision: .25
    });
    cn(e, ga, (e => o(267, qt = e)));
    const fa = rs(void 0, {
        stiffness: .02,
        damping: .5,
        precision: .25
    });
    cn(e, fa, (e => o(265, Gt = e)));
    const $a = rs(void 0, {
        stiffness: .02,
        damping: .5,
        precision: .25
    });
    let ya;
    cn(e, $a, (e => o(268, Kt = e)));
    const xa = () => {
            To("abortLoadImage")
        },
        ba = () => {
            To("abortProcessImage"), gn(Yr, Bt = !1, Bt)
        },
        va = e => e.preventDefault(),
        Sa = zr ? e => {
            const t = e.touches ? e.touches[0] : e;
            t.pageX > 10 && t.pageX < Lr - 10 || va(e)
        } : n,
        Ca = zt() ? va : n,
        ka = zt() ? va : n,
        Ma = Dr([]);
    cn(e, Ma, (e => o(319, Jt = e))), Kn("keysPressed", Ma);
    const Ta = e => {
            !e || ro(e) && !(e => /^image/.test(e.type) && !/svg/.test(e.type))(e) || !ro(e) && !/^http/.test(e) || To("loadImage", e)
        },
        Ra = e => {
            e && Ta(e)
        };
    let Pa = void 0;
    let Aa, Ia = [];
    const Ea = Dr();
    Kn("rootPortal", Ea), Kn("rootRect", Sn);
    const La = () => ({
            foregroundColor: [...oo],
            lineColor: [...io],
            utilVisibility: {
                ...P
            },
            isInteracting: st,
            isInteractingFraction: no,
            rootRect: Ee(tt),
            stageRect: Ee(mt),
            annotationShapesDirty: ja,
            decorationShapesDirty: Xa,
            frameShapesDirty: Ya,
            blendShapesDirty: Ga
        }),
        Fa = (e, t, o) => wi(e, be(t.width / o, t.height / o)),
        za = (e, t, o) => (e._translate = G(t), e._scale = o, e),
        Ba = e => {
            const t = [];
            return e.forEach((e => t.push(Da(e)))), t.filter(Boolean)
        },
        Da = e => Uo(e) ? (e.points = [Y(e.x1, e.y1), Y(e.x2, e.y2)], e) : jo(e) ? (e.points = [Y(e.x1, e.y1), Y(e.x2, e.y2), Y(e.x3, e.y3)], e) : (e => _o(e) && !e.text.length)(e) ? (Wo(e) && (e.width = 5, e.height = e.lineHeight), e.strokeWidth = 1, e.strokeColor = [1, 1, 1, .5], e.backgroundColor = [0, 0, 0, .1], e) : e;
    let Oa, _a = [],
        Wa = [],
        Va = [],
        Ha = [],
        Na = {};
    const Ua = (e, t, o, i, n, r) => {
        const {
            annotationShapesDirty: a,
            decorationShapesDirty: l,
            frameShapesDirty: c,
            blendShapesDirty: d,
            selectionRect: u,
            scale: h
        } = e, p = Oa !== h || !je(Na, u);
        p && (Oa = h, Na = u), (a || o !== ao) && (_a = Ba(o.filter(Go).map(Eo).map((e => wi(e, $t))).map(s).flat())), d && (Wa = t.filter(Go).map((e => wi(e, $t)))), (l || i !== so || p) && (Va = Ba(i.filter(Go).map(Eo).map((e => Fa(e, u, h))).map(s).flat().map((e => za(e, u, h))))), (c || r !== lo || p) && (Ha = r ? Ba([r].map(Eo).map((e => Fa(e, u, h))).map(s).flat().map((e => za(e, u, h)))) : []);
        const m = Ba(n.filter(Go));
        return {
            blendShapesDirty: d,
            blendShapes: Wa,
            annotationShapesDirty: a,
            annotationShapes: _a,
            decorationShapesDirty: l,
            decorationShapes: Va,
            frameShapesDirty: c,
            frameShapes: Ha,
            interfaceShapes: m
        }
    };
    let ja = !0;
    let Xa = !0;
    let Ya = !0;
    let Ga = !0;
    qn((() => {
        fn(), or(), er(), nr(), rr(), ar(), Sr(), jr(), qr(), Tn.destroy(), Rn.destroy(), Mi.destroy(), ra.clear(), o(149, Rr = void 0), o(182, la = void 0), vr && (g(vr), o(179, vr = void 0)), wr && (g(wr), o(180, wr = void 0)), _a.length = 0, Wa.length = 0, Va.length = 0, Ha.length = 0
    }));
    return e.$$set = e => {
        "class" in e && o(150, Ro = e.class), "layout" in e && o(151, Po = e.layout), "stores" in e && o(152, Ao = e.stores), "locale" in e && o(2, Lo = e.locale), "id" in e && o(3, Fo = e.id), "util" in e && o(153, zo = e.util), "utils" in e && o(154, Bo = e.utils), "animations" in e && o(155, Do = e.animations), "disabled" in e && o(156, Oo = e.disabled), "status" in e && o(148, Vo = e.status), "previewUpscale" in e && o(157, Ho = e.previewUpscale), "elasticityMultiplier" in e && o(4, No = e.elasticityMultiplier), "willRevert" in e && o(158, Xo = e.willRevert), "willProcessImage" in e && o(159, Yo = e.willProcessImage), "willRenderCanvas" in e && o(5, qo = e.willRenderCanvas), "willRenderToolbar" in e && o(160, Zo = e.willRenderToolbar), "willSetHistoryInitialState" in e && o(161, Ko = e.willSetHistoryInitialState), "enableButtonExport" in e && o(162, Jo = e.enableButtonExport), "enableButtonRevert" in e && o(163, Qo = e.enableButtonRevert), "enableNavigateHistory" in e && o(164, ei = e.enableNavigateHistory), "enableToolbar" in e && o(6, ti = e.enableToolbar), "enableUtils" in e && o(165, oi = e.enableUtils), "enableButtonClose" in e && o(166, ii = e.enableButtonClose), "enableDropImage" in e && o(167, ni = e.enableDropImage), "enablePasteImage" in e && o(168, ri = e.enablePasteImage), "enableBrowseImage" in e && o(169, ai = e.enableBrowseImage), "previewImageDataMaxSize" in e && o(170, si = e.previewImageDataMaxSize), "previewImageTextPixelRatio" in e && o(7, li = e.previewImageTextPixelRatio), "layoutDirectionPreference" in e && o(171, ci = e.layoutDirectionPreference), "layoutHorizontalUtilsPreference" in e && o(172, di = e.layoutHorizontalUtilsPreference), "layoutVerticalUtilsPreference" in e && o(173, ui = e.layoutVerticalUtilsPreference), "imagePreviewSrc" in e && o(174, hi = e.imagePreviewSrc), "imageOrienter" in e && o(175, pi = e.imageOrienter), "pluginComponents" in e && o(176, mi = e.pluginComponents), "pluginOptions" in e && o(8, gi = e.pluginOptions), "root" in e && o(1, yi = e.root), "imageSourceToImageData" in e && o(9, ki = e.imageSourceToImageData), "imagePreviewCurrent" in e && o(149, Rr = e.imagePreviewCurrent)
    }, e.$$.update = () => {
        if (134217728 & e.$$.dirty[4] && o(186, i = "overlay" === Po), 1024 & e.$$.dirty[5] | 1 & e.$$.dirty[6] && o(17, r = oi && !i), 257 & e.$$.dirty[0] && gi && Object.entries(gi).forEach((([e, t]) => {
                Object.entries(t).forEach((([t, i]) => {
                    $i[e] && o(0, $i[e][t] = i, $i)
                }))
            })), 1 & e.$$.dirty[0] | 2097152 & e.$$.dirty[5]) {
            let e = !1;
            mi.forEach((([t]) => {
                $i[t] || (o(0, $i[t] = {}, $i), e = !0)
            })), e && o(178, xi = [...mi])
        }
        var t, n, h, p;
        if (2 & e.$$.dirty[5] && bi.set(Oo ? 1 : 0), 32768 & e.$$.dirty[5] && (a = si ? (t = si, n = Si, be(Math.min(t.width, n.width), Math.min(t.height, n.height))) : Si), 2 & e.$$.dirty[6] && Mi.update(Ge[0]), 4 & e.$$.dirty[6] && (s = Ke ? e => Ke(e, {
                isPreview: !0
            }) : _), 262144 & e.$$.dirty[0] && Je && Sn.set(_e(Je.x, Je.y, Je.width, Je.height)), 25 & e.$$.dirty[6] && tt && i && it && it.complete && (() => {
                const e = et,
                    t = Xe(tt);
                e && e === t || (Fi.set(Xe(tt)), Ur())
            })(), 4 & e.$$.dirty[0] | 1073741824 & e.$$.dirty[4] | 8388608 & e.$$.dirty[5] && o(193, v = Lo && xi.length ? Bo || xi.map((([e]) => e)) : []), 128 & e.$$.dirty[6] && o(19, L = v.length > 1), 524288 & e.$$.dirty[0] && (L || Cn.set(Le())), 64 & e.$$.dirty[0] && (ti || kn.set(Le())), 4 & e.$$.dirty[5] | 1 & e.$$.dirty[6] && In.set(Ho || i), 8388608 & e.$$.dirty[5] | 128 & e.$$.dirty[6] && o(221, S = xi.filter((([e]) => v.includes(e)))), 16 & e.$$.dirty[7] && o(222, C = S.length), 536870912 & e.$$.dirty[4] | 128 & e.$$.dirty[6] | 32 & e.$$.dirty[7] && o(21, M = zo && "string" == typeof zo && v.includes(zo) ? zo : C > 0 ? v[0] : void 0), 2097152 & e.$$.dirty[0] && M && cr.set(.075), 2097152 & e.$$.dirty[0] && gr.set("resize" === M ? 40 : 30), 2097152 & e.$$.dirty[0] && fr.set("resize" === M ? 140 : 70), 544 & e.$$.dirty[6] && o(197, l = rt && ((e, t) => {
                let {
                    width: o,
                    height: i
                } = e;
                const n = Xe(t);
                return o && i ? e : (o && !i && (i = o / n), i && !o && (o = i * n), o || i || (o = t.width, i = t.height), Me(be(o, i), Math.round))
            })(gt || {}, rt)), 14592 & e.$$.dirty[6] && l && mt && xr.set(Hd(mt.y, mt.y - bt, vt.y)), 14592 & e.$$.dirty[6] && l && mt && yr.set(Hd(mt.x + mt.width, mt.x + mt.width + bt, vt.x + vt.width)), 14592 & e.$$.dirty[6] && l && mt && br.set(Hd(mt.y + mt.height, mt.y + mt.height + bt, vt.y + vt.height)), 14592 & e.$$.dirty[6] && l && mt && $r.set(Hd(mt.x, mt.x - bt, vt.x)), 33554432 & e.$$.dirty[5] | 98312 & e.$$.dirty[6] && o(200, c = tt && {
                id: "stage-overlay",
                x: 0,
                y: 0,
                width: tt.width,
                height: wt,
                rotation: Math.PI,
                opacity: .85 * St,
                backgroundImage: wr
            }), 33554432 & e.$$.dirty[5] | 294920 & e.$$.dirty[6] && o(203, d = tt && {
                id: "stage-overlay",
                x: 0,
                y: tt.height - wt,
                width: tt.width,
                height: wt,
                opacity: .85 * Ct,
                backgroundImage: wr
            }), 16777216 & e.$$.dirty[5] | 1081352 & e.$$.dirty[6] && o(205, u = tt && {
                id: "stage-overlay",
                x: 0,
                y: 0,
                height: tt.height,
                width: wt,
                rotation: Math.PI,
                opacity: .85 * kt,
                backgroundImage: vr
            }), 16777216 & e.$$.dirty[5] | 4227080 & e.$$.dirty[6] && o(207, m = tt && {
                id: "stage-overlay",
                x: tt.width - wt,
                y: 0,
                height: tt.height,
                width: wt,
                opacity: .85 * Mt,
                backgroundImage: vr
            }), 2768896 & e.$$.dirty[6] && o(209, f = [c, m, d, u].filter(Boolean)), 25165824 & e.$$.dirty[6] && f && Tt) {
            const e = Tt.filter((e => "stage-overlay" !== e.id));
            gn(hr, Tt = [...e, ...f], Tt)
        }
        if (524288 & e.$$.dirty[5] | 33554432 & e.$$.dirty[6] && kr.set(hi || (Rt || void 0)), 2 & e.$$.dirty[0] | 33554432 & e.$$.dirty[4] | 67108864 & e.$$.dirty[6] && (o(149, Rr = Pt), Pt && yi.dispatchEvent(Nd("loadpreview", Rr))), 134217728 & e.$$.dirty[6] && At && Ar.set([]), 64 & e.$$.dirty[6] && o(214, $ = !st && !ks()), 1073741824 & e.$$.dirty[6] && o(215, y = !It), 1 & e.$$.dirty[5] | 805306368 & e.$$.dirty[6] && gn(Hr, ht = "always" === Do ? $ : "never" !== Do && ($ && y), ht), 2 & e.$$.dirty[7] && o(217, x = Ft.index > 0), 2 & e.$$.dirty[7] && o(219, b = Ft.index < Ft.length - 1), 4 & e.$$.dirty[0] | 128 & e.$$.dirty[6] | 16 & e.$$.dirty[7] && o(22, k = v.map((e => {
                const t = S.find((([t]) => e === t));
                if (t) return {
                    id: e,
                    view: t[1],
                    tabIcon: Lo[e + "Icon"],
                    tabLabel: Lo[e + "Label"]
                }
            })).filter(Boolean) || []), 2097152 & e.$$.dirty[0] && $n.set(M), 2097153 & e.$$.dirty[0] && o(223, R = M && $i[M].tools || []), 12582912 & e.$$.dirty[0] && o(23, P = k.reduce(((e, t) => (e[t.id] = P && P[t.id] || 0, e)), {})), 2097152 & e.$$.dirty[0] && o(39, A = {
                name: Kr,
                selected: M
            }), 4194304 & e.$$.dirty[0] && o(40, I = k.map((e => ({
                id: e.id,
                icon: e.tabIcon,
                label: e.tabLabel
            })))), 4194304 & e.$$.dirty[0] && o(41, E = k.map((e => e.id))), 67108864 & e.$$.dirty[4] && o(42, F = al(["PinturaRoot", "PinturaRootComponent", Ro])), 8 & e.$$.dirty[6] && o(224, z = tt && (tt.width > 1e3 ? "wide" : tt.width < 600 ? "narrow" : void 0)), 8 & e.$$.dirty[6] && o(225, B = tt && (tt.width <= 320 || tt.height <= 460)), 8 & e.$$.dirty[6] && o(226, D = tt && (tt.height > 1e3 ? "tall" : tt.height < 600 ? "short" : void 0)), 2 & e.$$.dirty[0] && o(227, O = yi && yi.parentNode && yi.parentNode.classList.contains("PinturaModal")), 4096 & e.$$.dirty[0] | 8 & e.$$.dirty[6] | 1024 & e.$$.dirty[7] && o(228, W = O && tt && Lr > tt.width), 8192 & e.$$.dirty[0] | 8 & e.$$.dirty[6] | 1024 & e.$$.dirty[7] && o(229, V = O && tt && Fr > tt.height), 6144 & e.$$.dirty[7] && o(230, H = W && V), 128 & e.$$.dirty[7] && o(231, N = "narrow" === z), 65536 & e.$$.dirty[5] | 8 & e.$$.dirty[6] && o(232, (h = tt, p = ci, U = tt ? "auto" === p ? h.width > h.height ? "landscape" : "portrait" : "horizontal" === p ? h.width < 500 ? "portrait" : "landscape" : "vertical" === p ? h.height < 400 ? "landscape" : "portrait" : void 0 : "landscape")), 32768 & e.$$.dirty[7] && o(43, j = "landscape" === U), 16896 & e.$$.dirty[7] && o(233, X = N || "short" === D), 4096 & e.$$.dirty[0] | 8 & e.$$.dirty[6] && o(234, q = Qr && tt && Lr === tt.width && !zr), 1 & e.$$.dirty[6] | 576 & e.$$.dirty[7] && o(235, J = R.length && ("short" === D || i)), 131072 & e.$$.dirty[5] && o(236, Q = "has-navigation-preference-" + di), 262144 & e.$$.dirty[5] && o(237, ee = "has-navigation-preference-" + ui), 2 & e.$$.dirty[0] && o(238, te = yi && getComputedStyle(yi)), 2097152 & e.$$.dirty[7] && te && ia(), 1704e3 & e.$$.dirty[0] | 134217728 & e.$$.dirty[4] | 2 & e.$$.dirty[5] | 31178624 & e.$$.dirty[7] && _r.set({
                ...Dt,
                layoutMode: Po,
                orientation: U,
                horizontalSpace: z,
                verticalSpace: D,
                navigationHorizontalPreference: Q,
                navigationVerticalPreference: ee,
                isModal: O,
                isDisabled: Oo,
                isCentered: H,
                isCenteredHorizontally: W,
                isCenteredVertically: V,
                isAnimated: ht,
                pointerAccuracy: Ot,
                pointerHoverable: _t,
                isCompact: X,
                hasSwipeNavigation: q,
                hasLimitedSpace: B,
                hasToolbar: ti,
                hasNavigation: L && r,
                isIOS: Qr
            }), 4194304 & e.$$.dirty[7] && o(44, oe = Object.entries(Dt).map((([e, t]) => /^is|has/.test(e) ? t ? Ud(e) : void 0 : t)).filter(Boolean).join(" ")), 100663296 & e.$$.dirty[7] && o(45, ie = Wt && Object.entries(Vt).filter((([, e]) => null != e)).reduce(((e, [, t]) => e = {
                ...e,
                ...t
            }), {})), 16 & e.$$.dirty[6] && o(244, ce = it && "any-to-file" === it.task), 134217728 & e.$$.dirty[7] && ce && ra && ra.clear(), 268435456 & e.$$.dirty[7] && o(246, ae = !!Ht && !!Ht.translation), 134217728 & e.$$.dirty[5] | 67108864 & e.$$.dirty[6] | 536870912 & e.$$.dirty[7] && ae && Pt && Pt !== la && (o(182, la = Pt), aa()), 805306368 & e.$$.dirty[7] && ae && sa(Ht), 16777216 & e.$$.dirty[0] && Nt && Nt.length > 1) {
            let e = [];
            ra.forEach(((t, o) => {
                0 !== o && t.get().opacity <= 0 && e.push(t)
            })), e.forEach((e => ra.remove(e)))
        }
        if (4 & e.$$.dirty[0] | 1073741824 & e.$$.dirty[7] && o(25, le = Lo && se.length && Lo.labelSupportError(se)), 16 & e.$$.dirty[6] && o(248, de = it && !!it.error), 16 & e.$$.dirty[6] && o(26, ue = !it || !it.complete && void 0 === it.task), 16 & e.$$.dirty[6] && o(249, he = it && (it.taskLengthComputable ? it.taskProgress : 1 / 0)), 134217728 & e.$$.dirty[7] && ce && gn(Cr, Ut = !1, Ut), 268435456 & e.$$.dirty[5] | 16 & e.$$.dirty[6] && it && it.complete) {
            const e = 500;
            clearTimeout(da), o(183, da = setTimeout((() => {
                gn(Cr, Ut = !0, Ut)
            }), e))
        }
        if (67108864 & e.$$.dirty[0] | 16 & e.$$.dirty[6] | 9 & e.$$.dirty[8] && o(250, pe = it && !de && !ue && !Ut), 67108864 & e.$$.dirty[5] | 201326592 & e.$$.dirty[6] && o(252, me = !(!At || Pt && !Mr)), 8 & e.$$.dirty[7] | 64 & e.$$.dirty[8] && o(253, ge = Bt || jt && void 0 !== jt.progress && !jt.complete), 67108864 & e.$$.dirty[0] | 16 & e.$$.dirty[6] && o(255, fe = it && !(it.error || ue)), 4 & e.$$.dirty[0] | 16 & e.$$.dirty[6] && o(256, $e = Lo && (it ? !it.complete || it.error ? Ts(Lo.statusLabelLoadImage(it), it.error && it.error.metadata, "{", "}") : Lo.statusLabelLoadImage({
                progress: 1 / 0,
                task: "blob-to-bitmap"
            }) : Lo.statusLabelLoadImage(it))), 4 & e.$$.dirty[0] | 64 & e.$$.dirty[8] && o(257, ye = jt && Lo && Lo.statusLabelProcessImage(jt)), 64 & e.$$.dirty[8] && o(258, xe = jt && (jt.taskLengthComputable ? jt.taskProgress : 1 / 0)), 64 & e.$$.dirty[8] && o(259, ve = jt && !jt.error), 64 & e.$$.dirty[8] && o(260, we = jt && jt.error), 67108868 & e.$$.dirty[0] | 16777216 & e.$$.dirty[4] | 8119 & e.$$.dirty[8])
            if (Vo) {
                let e, t, i, n, r;
                w(Vo) && (e = Vo), Zt(Vo) ? t = Vo : Array.isArray(Vo) && ([e, t, r] = Vo, !1 === t && (n = !0), Zt(t) && (i = !0)), o(14, ha = (e || t) && {
                    text: e,
                    aside: n || i,
                    progressIndicator: {
                        visible: i,
                        progress: t
                    },
                    closeButton: n && {
                        label: Lo.statusLabelButtonClose,
                        icon: Lo.statusIconButtonClose,
                        onclick: r || (() => o(148, Vo = void 0))
                    }
                })
            } else o(14, ha = Lo && ue || de || pe || me ? {
                text: $e,
                aside: de || fe,
                progressIndicator: {
                    visible: fe,
                    progress: he
                },
                closeButton: de && {
                    label: Lo.statusLabelButtonClose,
                    icon: Lo.statusIconButtonClose,
                    onclick: xa
                }
            } : Lo && ge && ye ? {
                text: ye,
                aside: we || ve,
                progressIndicator: {
                    visible: ve,
                    progress: xe
                },
                closeButton: we && {
                    label: Lo.statusLabelButtonClose,
                    icon: Lo.statusIconButtonClose,
                    onclick: ba
                }
            } : void 0);
        if (16777216 & e.$$.dirty[4] && o(261, Se = void 0 !== Vo), 1024 & e.$$.dirty[7] | 64 & e.$$.dirty[8] && O && jt && jt.complete && (ua.set(!0), setTimeout((() => ua.set(!1)), 100)), 100663296 & e.$$.dirty[0] | 41013 & e.$$.dirty[8] && o(262, Ce = Xt || le || ue || de || pe || me || ge || Se), 16384 & e.$$.dirty[8] && gn(ca, Yt = Ce ? 1 : 0, Yt), 134217728 & e.$$.dirty[0] && o(28, ke = Yt > 0), 16384 & e.$$.dirty[0] && o(264, Te = !(!ha || !ha.aside)), 268451840 & e.$$.dirty[0] | 536870912 & e.$$.dirty[5] | 196608 & e.$$.dirty[8] && ke && ha)
            if (clearTimeout(ya), Te) {
                const e = !!ha.error;
                ma.set(1), pa.set(Gt, {
                    hard: e
                }), o(184, ya = setTimeout((() => {
                    ga.set(16)
                }), 1))
            } else ma.set(0), o(184, ya = setTimeout((() => {
                ga.set(0)
            }), 1));
        if (268435456 & e.$$.dirty[0] && (ke || ($a.set(void 0, {
                hard: !0
            }), pa.set(void 0, {
                hard: !0
            }), ga.set(0, {
                hard: !0
            }))), 524288 & e.$$.dirty[8] && o(266, Re = .5 * qt), 1310720 & e.$$.dirty[8] && o(46, Pe = `transform: translateX(${Kt-Re}px)`), 4 & e.$$.dirty[0] | 2976 & e.$$.dirty[5] | 4472901 & e.$$.dirty[7] && o(47, Ae = Lo && Zo([
                ["div", "alpha", {
                        class: "PinturaNavGroup"
                    },
                    [
                        ["div", "alpha-set", {
                                class: "PinturaNavSet"
                            },
                            [ii && ["Button", "close", {
                                label: Lo.labelClose,
                                icon: Lo.iconButtonClose,
                                onclick: () => To("close"),
                                hideLabel: !0
                            }], Qo && ["Button", "revert", {
                                label: Lo.labelButtonRevert,
                                icon: Lo.iconButtonRevert,
                                disabled: !x,
                                onclick: Xr,
                                hideLabel: !0
                            }]]
                        ]
                    ]
                ],
                ["div", "beta", {
                        class: "PinturaNavGroup PinturaNavGroupFloat"
                    },
                    [ei && ["div", "history", {
                            class: "PinturaNavSet"
                        },
                        [
                            ["Button", "undo", {
                                label: Lo.labelButtonUndo,
                                icon: Lo.iconButtonUndo,
                                disabled: !x,
                                onclick: Nr.undo,
                                hideLabel: !0
                            }],
                            ["Button", "redo", {
                                label: Lo.labelButtonRedo,
                                icon: Lo.iconButtonRedo,
                                disabled: !b,
                                onclick: Nr.redo,
                                hideLabel: !0
                            }]
                        ]
                    ], J && ["div", "plugin-tools", {
                        class: "PinturaNavSet"
                    }, R.filter(Boolean).map((([e, t, o]) => [e, t, {
                        ...o,
                        hideLabel: !0
                    }]))]]
                ],
                ["div", "gamma", {
                        class: "PinturaNavGroup"
                    },
                    [Jo && ["Button", "export", {
                        label: Lo.labelButtonExport,
                        icon: N && Lo.iconButtonExport,
                        class: "PinturaButtonExport",
                        onclick: Gr,
                        hideLabel: N
                    }]]
                ]
            ], {
                ...Dt
            })), 262144 & e.$$.dirty[0] && o(269, Ie = Je && Je.width > 0 && Je.height > 0), 4 & e.$$.dirty[0] | 32 & e.$$.dirty[7] | 2097152 & e.$$.dirty[8] && o(48, ze = Ie && Lo && C), 8388608 & e.$$.dirty[8] && o(270, Be = Qt && !!Qt.length), 1024 & e.$$.dirty[6] | 12582912 & e.$$.dirty[8] && o(272, De = Be && Ki($t, Qt)), 67108864 & e.$$.dirty[6] | 121634816 & e.$$.dirty[8] && Be && ((e, t, i, n) => {
                if (!t) return;
                const r = {
                    dataSizeScalar: i
                };
                n && n[3] > 0 && (r.backgroundColor = [...n]), t(e, r).then((e => {
                    Pa && g(Pa), o(185, Pa = e)
                }))
            })(Pt, eo, De, to), 1073741824 & e.$$.dirty[5] | 1024 & e.$$.dirty[6] | 8388608 & e.$$.dirty[8] && Qt && Pa && $t) {
            const {
                width: e,
                height: t
            } = $t;
            o(15, Ia = Qt.map((o => {
                const i = _e(o.x, o.y, o.width, o.height),
                    n = qe(Ee(i), o.rotation).map((o => Y(o.x / e, o.y / t)));
                return {
                    ...o,
                    id: "redaction",
                    flipX: !1,
                    flipY: !1,
                    cornerRadius: 0,
                    strokeWidth: 0,
                    strokeColor: void 0,
                    backgroundColor: [0, 0, 0],
                    backgroundImage: Pa,
                    backgroundImageRendering: "pixelated",
                    backgroundCorners: n
                }
            })))
        }
        65536 & e.$$.dirty[0] && Aa && Ea.set(Aa), 33554432 & e.$$.dirty[0] | 67108864 & e.$$.dirty[6] && o(29, Ye = Pt && !le), 536870914 & e.$$.dirty[0] && Ye && yi.dispatchEvent(Nd("ready")), 1073741824 & e.$$.dirty[0] && o(34, ja = !0), 1 & e.$$.dirty[1] && o(35, Xa = !0), 2 & e.$$.dirty[1] && o(36, Ya = !0), 32768 & e.$$.dirty[0] && o(37, Ga = !0)
    }, o(247, se = [!Zd() && "WebGL"].filter(Boolean)), o(49, Oe = ((e, t = !0) => o => {
        "ping" === o.type && (t && o.stopPropagation(), e(o.detail.type, o.detail.data))
    })(Mo.pub)), [$i, yi, Lo, Fo, No, qo, ti, li, gi, ki, Tr, Nr, Lr, Fr, ha, Ia, Aa, r, Je, L, ht, M, k, P, Nt, le, ue, Yt, ke, Ye, ao, so, lo, Jr, ja, Xa, Ya, Ga, Lt, A, I, E, F, j, oe, ie, Pe, Ae, ze, Oe, co, uo, ho, mo, go, fo, $o, yo, xo, bo, vo, wo, So, bi, Pi, Ai, Ei, Li, Fi, Bi, Ui, Yi, on, nn, rn, an, dn, un, hn, pn, mn, $n, yn, xn, bn, wn, Sn, Cn, kn, Mn, Tn, Rn, Pn, An, In, En, Ln, zn, Bn, Dn, Nn, Un, jn, Yn, lr, dr, hr, pr, gr, fr, $r, yr, xr, br, Cr, kr, Pr, Ar, Ir, _r, Vr, Hr, Yr, Zr, ({
        target: e,
        propertyName: t
    }) => {
        e === yi && /background|outline/.test(t) && ia()
    }, na, ra, ca, ua, pa, ma, ga, fa, $a, e => {
        const t = !(!ha || !ha.closeButton);
        fa.set(e.detail.width, {
            hard: t
        }), $a.set(Math.round(.5 * -e.detail.width), {
            hard: t
        })
    }, Sa, Ca, ka, Ma, e => {
        const {
            keyCode: t,
            metaKey: o,
            ctrlKey: i,
            shiftKey: n
        } = e;
        if (9 === t && Oo) return void e.preventDefault();
        if (90 === t && (o || i)) return void(n && o ? Nr.redo() : Nr.undo());
        if (89 === t && i) return void Nr.redo();
        if (229 === t) return;
        if (o || i) return;
        const r = new Set([...Jt, t]);
        Ma.set(Array.from(r))
    }, ({
        keyCode: e
    }) => {
        Ma.set(Jt.filter((t => t !== e)))
    }, () => {
        Ma.set([])
    }, e => {
        var t;
        (e => /textarea/i.test(e.nodeName))(t = e.target) || (e => /date|email|number|search|text|url/.test(e.type))(t) || e.preventDefault()
    }, e => {
        ni && Ta(e.detail.resources[0])
    }, () => {
        ai && ou().then(Ra)
    }, e => {
        if (!ri) return;
        const t = oa((Lr - Math.abs(tt.x)) / tt.width, 0, 1),
            o = oa((Fr - Math.abs(tt.y)) / tt.height, 0, 1);
        t < .75 && o < .75 || Ta((e.clipboardData || window.clipboardData).files[0])
    }, La, Ua, Vo, Rr, Ro, Po, Ao, zo, Bo, Do, Oo, Ho, Xo, Yo, Zo, Ko, Jo, Qo, ei, oi, ii, ni, ri, ai, si, ci, di, ui, hi, pi, mi, fi, xi, vr, wr, Mr, la, da, ya, Pa, i, Ge, Ke, tt, it, rt, st, v, mt, gt, $t, l, bt, vt, c, wt, St, d, Ct, u, kt, m, Mt, f, Tt, Rt, Pt, At, $, y, It, x, Ft, b, Bt, S, C, R, z, B, D, O, W, V, H, N, U, X, q, J, Q, ee, te, Dt, Ot, _t, Wt, Vt, ce, Ht, ae, se, de, he, pe, Ut, me, ge, jt, fe, $e, ye, xe, ve, we, Se, Ce, Xt, Te, Gt, Re, qt, Kt, Ie, Be, Qt, De, eo, to, function () {
        o(12, Lr = iu.innerWidth), o(13, Fr = iu.innerHeight)
    }, e => gn(kn, ho = e.detail, ho), ({
        detail: e
    }) => o(21, M = e), (e, t) => t.id === e, function (t, i) {
        e.$$.not_equal($i[i], t) && ($i[i] = t, o(0, $i), o(8, gi), o(176, mi))
    }, e => gn(Mn, mo = e.detail, mo), e => o(33, Jr = Jr.concat(e)), e => o(33, Jr = Jr.filter((t => t !== e))), (e, {
        detail: t
    }) => o(23, P[e] = t, P), e => gn(Cn, Lt = e.detail, Lt), e => e.id === M, function (t) {
        e.$$.not_equal($i[M], t) && ($i[M] = t, o(0, $i), o(8, gi), o(176, mi))
    }, e => gn(Mn, mo = e.detail, mo), () => o(33, Jr = Jr.concat(M)), () => o(33, Jr = Jr.filter((e => e !== M))), ({
        detail: e
    }) => o(23, P[M] = e, P), e => {
        const t = {
                ...e,
                ...La()
            },
            {
                annotationShapes: o,
                decorationShapes: i,
                interfaceShapes: n,
                frameShapes: r
            } = qo({
                annotationShapes: ao,
                decorationShapes: so,
                interfaceShapes: wo,
                frameShapes: lo
            }, t);
        return Ua(t, Ia, o, i, n, r)
    }, () => {
        o(34, ja = !1), o(35, Xa = !1), o(36, Ya = !1), o(37, Ga = !1)
    }, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            Aa = e, o(16, Aa)
        }))
    }, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            yi = e, o(1, yi)
        }))
    }, e => gn(wn, Je = e.detail, Je)]
}
class Tu extends Fr {
    constructor(e) {
        super(), Lr(this, e, Mu, Cu, an, {
            class: 150,
            layout: 151,
            stores: 152,
            locale: 2,
            id: 3,
            util: 153,
            utils: 154,
            animations: 155,
            disabled: 156,
            status: 148,
            previewUpscale: 157,
            elasticityMultiplier: 4,
            willRevert: 158,
            willProcessImage: 159,
            willRenderCanvas: 5,
            willRenderToolbar: 160,
            willSetHistoryInitialState: 161,
            enableButtonExport: 162,
            enableButtonRevert: 163,
            enableNavigateHistory: 164,
            enableToolbar: 6,
            enableUtils: 165,
            enableButtonClose: 166,
            enableDropImage: 167,
            enablePasteImage: 168,
            enableBrowseImage: 169,
            previewImageDataMaxSize: 170,
            previewImageTextPixelRatio: 7,
            layoutDirectionPreference: 171,
            layoutHorizontalUtilsPreference: 172,
            layoutVerticalUtilsPreference: 173,
            imagePreviewSrc: 174,
            imageOrienter: 175,
            pluginComponents: 176,
            pluginOptions: 8,
            sub: 177,
            pluginInterface: 0,
            root: 1,
            imageSourceToImageData: 9,
            imagePreview: 10,
            imagePreviewCurrent: 149,
            history: 11
        }, [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1])
    }
    get class() {
        return this.$$.ctx[150]
    }
    set class(e) {
        this.$set({
            class: e
        }), dr()
    }
    get layout() {
        return this.$$.ctx[151]
    }
    set layout(e) {
        this.$set({
            layout: e
        }), dr()
    }
    get stores() {
        return this.$$.ctx[152]
    }
    set stores(e) {
        this.$set({
            stores: e
        }), dr()
    }
    get locale() {
        return this.$$.ctx[2]
    }
    set locale(e) {
        this.$set({
            locale: e
        }), dr()
    }
    get id() {
        return this.$$.ctx[3]
    }
    set id(e) {
        this.$set({
            id: e
        }), dr()
    }
    get util() {
        return this.$$.ctx[153]
    }
    set util(e) {
        this.$set({
            util: e
        }), dr()
    }
    get utils() {
        return this.$$.ctx[154]
    }
    set utils(e) {
        this.$set({
            utils: e
        }), dr()
    }
    get animations() {
        return this.$$.ctx[155]
    }
    set animations(e) {
        this.$set({
            animations: e
        }), dr()
    }
    get disabled() {
        return this.$$.ctx[156]
    }
    set disabled(e) {
        this.$set({
            disabled: e
        }), dr()
    }
    get status() {
        return this.$$.ctx[148]
    }
    set status(e) {
        this.$set({
            status: e
        }), dr()
    }
    get previewUpscale() {
        return this.$$.ctx[157]
    }
    set previewUpscale(e) {
        this.$set({
            previewUpscale: e
        }), dr()
    }
    get elasticityMultiplier() {
        return this.$$.ctx[4]
    }
    set elasticityMultiplier(e) {
        this.$set({
            elasticityMultiplier: e
        }), dr()
    }
    get willRevert() {
        return this.$$.ctx[158]
    }
    set willRevert(e) {
        this.$set({
            willRevert: e
        }), dr()
    }
    get willProcessImage() {
        return this.$$.ctx[159]
    }
    set willProcessImage(e) {
        this.$set({
            willProcessImage: e
        }), dr()
    }
    get willRenderCanvas() {
        return this.$$.ctx[5]
    }
    set willRenderCanvas(e) {
        this.$set({
            willRenderCanvas: e
        }), dr()
    }
    get willRenderToolbar() {
        return this.$$.ctx[160]
    }
    set willRenderToolbar(e) {
        this.$set({
            willRenderToolbar: e
        }), dr()
    }
    get willSetHistoryInitialState() {
        return this.$$.ctx[161]
    }
    set willSetHistoryInitialState(e) {
        this.$set({
            willSetHistoryInitialState: e
        }), dr()
    }
    get enableButtonExport() {
        return this.$$.ctx[162]
    }
    set enableButtonExport(e) {
        this.$set({
            enableButtonExport: e
        }), dr()
    }
    get enableButtonRevert() {
        return this.$$.ctx[163]
    }
    set enableButtonRevert(e) {
        this.$set({
            enableButtonRevert: e
        }), dr()
    }
    get enableNavigateHistory() {
        return this.$$.ctx[164]
    }
    set enableNavigateHistory(e) {
        this.$set({
            enableNavigateHistory: e
        }), dr()
    }
    get enableToolbar() {
        return this.$$.ctx[6]
    }
    set enableToolbar(e) {
        this.$set({
            enableToolbar: e
        }), dr()
    }
    get enableUtils() {
        return this.$$.ctx[165]
    }
    set enableUtils(e) {
        this.$set({
            enableUtils: e
        }), dr()
    }
    get enableButtonClose() {
        return this.$$.ctx[166]
    }
    set enableButtonClose(e) {
        this.$set({
            enableButtonClose: e
        }), dr()
    }
    get enableDropImage() {
        return this.$$.ctx[167]
    }
    set enableDropImage(e) {
        this.$set({
            enableDropImage: e
        }), dr()
    }
    get enablePasteImage() {
        return this.$$.ctx[168]
    }
    set enablePasteImage(e) {
        this.$set({
            enablePasteImage: e
        }), dr()
    }
    get enableBrowseImage() {
        return this.$$.ctx[169]
    }
    set enableBrowseImage(e) {
        this.$set({
            enableBrowseImage: e
        }), dr()
    }
    get previewImageDataMaxSize() {
        return this.$$.ctx[170]
    }
    set previewImageDataMaxSize(e) {
        this.$set({
            previewImageDataMaxSize: e
        }), dr()
    }
    get previewImageTextPixelRatio() {
        return this.$$.ctx[7]
    }
    set previewImageTextPixelRatio(e) {
        this.$set({
            previewImageTextPixelRatio: e
        }), dr()
    }
    get layoutDirectionPreference() {
        return this.$$.ctx[171]
    }
    set layoutDirectionPreference(e) {
        this.$set({
            layoutDirectionPreference: e
        }), dr()
    }
    get layoutHorizontalUtilsPreference() {
        return this.$$.ctx[172]
    }
    set layoutHorizontalUtilsPreference(e) {
        this.$set({
            layoutHorizontalUtilsPreference: e
        }), dr()
    }
    get layoutVerticalUtilsPreference() {
        return this.$$.ctx[173]
    }
    set layoutVerticalUtilsPreference(e) {
        this.$set({
            layoutVerticalUtilsPreference: e
        }), dr()
    }
    get imagePreviewSrc() {
        return this.$$.ctx[174]
    }
    set imagePreviewSrc(e) {
        this.$set({
            imagePreviewSrc: e
        }), dr()
    }
    get imageOrienter() {
        return this.$$.ctx[175]
    }
    set imageOrienter(e) {
        this.$set({
            imageOrienter: e
        }), dr()
    }
    get pluginComponents() {
        return this.$$.ctx[176]
    }
    set pluginComponents(e) {
        this.$set({
            pluginComponents: e
        }), dr()
    }
    get pluginOptions() {
        return this.$$.ctx[8]
    }
    set pluginOptions(e) {
        this.$set({
            pluginOptions: e
        }), dr()
    }
    get sub() {
        return this.$$.ctx[177]
    }
    get pluginInterface() {
        return this.$$.ctx[0]
    }
    get root() {
        return this.$$.ctx[1]
    }
    set root(e) {
        this.$set({
            root: e
        }), dr()
    }
    get imageSourceToImageData() {
        return this.$$.ctx[9]
    }
    set imageSourceToImageData(e) {
        this.$set({
            imageSourceToImageData: e
        }), dr()
    }
    get imagePreview() {
        return this.$$.ctx[10]
    }
    get imagePreviewCurrent() {
        return this.$$.ctx[149]
    }
    set imagePreviewCurrent(e) {
        this.$set({
            imagePreviewCurrent: e
        }), dr()
    }
    get history() {
        return this.$$.ctx[11]
    }
}(e => {
    const [t, o, i, n, r, a, s] = ["UmVnRXhw", "dGVzdA==", "cHFpbmFcLm5sfGxvY2FsaG9zdA==", "bG9jYXRpb24=", "Y29uc29sZQ==", "bG9n", "VGhpcyB2ZXJzaW9uIG9mIFBpbnR1cmEgaXMgZm9yIHRlc3RpbmcgcHVycG9zZXMgb25seS4gVmlzaXQgaHR0cHM6Ly9wcWluYS5ubC9waW50dXJhLyB0byBvYnRhaW4gYSBjb21tZXJjaWFsIGxpY2Vuc2Uu"].map(e[[(!1 + "")[1], (!0 + "")[0], (1 + {})[2], (1 + {})[3]].join("")]);
    // new e[t](i)[o](e[n]) || e[r][a](s)
})(window);
const Ru = ["klass", "stores", "isVisible", "isActive", "isActiveFraction", "locale"],
    Pu = ["history", "klass", "stores", "navButtons", "pluginComponents", "pluginInterface", "pluginOptions", "sub", "imagePreviewSrc", "imagePreview", "imagePreviewCurrent"];
let Au;
const Iu = new Set([]),
    Eu = {},
    Lu = new Map,
    Fu = (...e) => {
        e.filter((e => !!e.util)).forEach((e => {
            const [t, o] = e.util;
            Lu.has(t) || (Lu.set(t, o), Tl(o).filter((e => !Ru.includes(e))).forEach((e => {
                Iu.add(e), Eu[e] ? Eu[e].push(t) : Eu[e] = [t]
            })))
        }))
    };
var zu = [...ma, "undo", "redo", "update", "revert", "destroy", "show", "hide", "close", "ready", "loadpreview", "selectshape", "updateshape", "addshape", "removeshape"];
var Bu = (e, t, o = {}) => {
    const {
        prefix: i = "pintura:"
    } = o;
    return zu.map((o => e.on(o, (e => ut(t) ? ((e, t, o) => e.dispatchEvent(new CustomEvent(t, {
        detail: o,
        bubbles: !0,
        cancelable: !0
    })))(t, `${i}${o}`, e) : t(o, e)))))
};
const Du = e => w(e[0]),
    Ou = e => !Du(e),
    _u = e => e[1],
    Wu = e => e[3] || [];

function Vu(e, t, o, i) {
    return Array.isArray(o) && (i = o, o = {}), [e, t, o || {}, i || []]
}
const Hu = (e, t, o, i = (e => e)) => {
        const n = Gu(t, o),
            r = n.findIndex((e => _u(e) === t));
        var a, s, l;
        a = n, s = i(r), l = e, a.splice(s, 0, l)
    },
    Nu = (e, t, o) => Hu(e, t, o),
    Uu = (e, t, o) => Hu(e, t, o, (e => e + 1)),
    ju = (e, t) => {
        if (Ou(t)) return t.push(e);
        t[3] = [...Wu(t), e]
    },
    Xu = (e, t) => {
        const o = Gu(e, t);
        return Vl(o, (t => _u(t) === e)), o
    },
    Yu = (e, t) => Du(t) ? _u(t) === e ? t : Yu(e, Wu(t)) : t.find((t => Yu(e, t))),
    Gu = (e, t) => Ou(t) ? t.find((t => _u(t) === e)) ? t : t.find((t => Gu(e, Wu(t)))) : Gu(e, Wu(t));
var qu = () => {};
let Zu = null;
var Ku = () => (null === Zu && (Zu = c() && !("[object OperaMini]" === Object.prototype.toString.call(window.operamini)) && "visibilityState" in document && "Promise" in window && "File" in window && "URL" in window && "createObjectURL" in window.URL && "performance" in window), Zu),
    Ju = e => Math.round(100 * e);
const Qu = {
        base: 0,
        min: -.25,
        max: .25,
        getLabel: e => Ju(e / .25),
        getStore: ({
            imageColorMatrix: e
        }) => e,
        getValue: e => {
            if (e.brightness) return e.brightness[4]
        },
        setValue: (e, t) => e.update((e => ({
            ...e,
            brightness: [1, 0, 0, 0, t, 0, 1, 0, 0, t, 0, 0, 1, 0, t, 0, 0, 0, 1, 0]
        })))
    },
    eh = {
        base: 1,
        min: .5,
        max: 1.5,
        getLabel: e => Ju(2 * (e - .5) - 1),
        getStore: ({
            imageColorMatrix: e
        }) => e,
        getValue: e => {
            if (e.contrast) return e.contrast[0]
        },
        setValue: (e, t) => e.update((e => ({
            ...e,
            contrast: [t, 0, 0, 0, .5 * (1 - t), 0, t, 0, 0, .5 * (1 - t), 0, 0, t, 0, .5 * (1 - t), 0, 0, 0, 1, 0]
        })))
    },
    th = {
        base: 1,
        min: 0,
        max: 2,
        getLabel: e => Ju(e - 1),
        getStore: ({
            imageColorMatrix: e
        }) => e,
        getValue: e => {
            if (e.saturation) return (e.saturation[0] - .213) / .787
        },
        setValue: (e, t) => e.update((e => ({
            ...e,
            saturation: [.213 + .787 * t, .715 - .715 * t, .072 - .072 * t, 0, 0, .213 - .213 * t, .715 + .285 * t, .072 - .072 * t, 0, 0, .213 - .213 * t, .715 - .715 * t, .072 + .928 * t, 0, 0, 0, 0, 0, 1, 0]
        })))
    },
    oh = {
        base: 1,
        min: .5,
        max: 1.5,
        getLabel: e => Ju(2 * (e - .5) - 1),
        getStore: ({
            imageColorMatrix: e
        }) => e,
        getValue: e => {
            if (e.exposure) return e.exposure[0]
        },
        setValue: (e, t) => e.update((e => ({
            ...e,
            exposure: [t, 0, 0, 0, 0, 0, t, 0, 0, 0, 0, 0, t, 0, 0, 0, 0, 0, 1, 0]
        })))
    },
    ih = {
        base: 1,
        min: .15,
        max: 4,
        getLabel: e => Ju(e < 1 ? (e - .15) / .85 - 1 : (e - 1) / 3),
        getStore: ({
            imageGamma: e
        }) => e
    },
    nh = {
        base: 0,
        min: -1,
        max: 1,
        getStore: ({
            imageVignette: e
        }) => e
    },
    rh = {
        base: 0,
        min: -1,
        max: 1,
        getStore: ({
            imageConvolutionMatrix: e
        }) => e,
        getValue: e => {
            if (e.clarity) return 0 === e.clarity[0] ? e.clarity[1] / -1 : e.clarity[1] / -2
        },
        setValue: (e, t) => {
            e.update((e => ({
                ...e,
                clarity: t >= 0 ? [0, -1 * t, 0, -1 * t, 1 + 4 * t, -1 * t, 0, -1 * t, 0] : [-1 * t, -2 * t, -1 * t, -2 * t, 1 + -3 * t, -2 * t, -1 * t, -2 * t, -1 * t]
            })))
        }
    },
    ah = {
        base: 0,
        min: -1,
        max: 1,
        getStore: ({
            imageColorMatrix: e
        }) => e,
        getValue: e => {
            if (!e.temperature) return;
            const t = e.temperature[0];
            return t >= 1 ? (t - 1) / .1 : (1 - t) / -.15
        },
        setValue: (e, t) => e.update((e => ({
            ...e,
            temperature: t > 0 ? [1 + .1 * t, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1 + .1 * -t, 0, 0, 0, 0, 0, 1, 0] : [1 + .15 * t, 0, 0, 0, 0, 0, 1 + .05 * t, 0, 0, 0, 0, 0, 1 + .15 * -t, 0, 0, 0, 0, 0, 1, 0]
        })))
    };
var sh = {
    finetuneControlConfiguration: {
        gamma: ih,
        brightness: Qu,
        contrast: eh,
        saturation: th,
        exposure: oh,
        temperature: ah,
        clarity: rh,
        vignette: nh
    },
    finetuneOptions: [
        ["brightness", e => e.finetuneLabelBrightness],
        ["contrast", e => e.finetuneLabelContrast],
        ["saturation", e => e.finetuneLabelSaturation],
        ["exposure", e => e.finetuneLabelExposure],
        ["temperature", e => e.finetuneLabelTemperature],
        ["gamma", e => e.finetuneLabelGamma], !ks() && ["clarity", e => e.finetuneLabelClarity],
        ["vignette", e => e.finetuneLabelVignette]
    ].filter(Boolean)
};
const lh = () => [.75, .25, .25, 0, 0, .25, .75, .25, 0, 0, .25, .25, .75, 0, 0, 0, 0, 0, 1, 0],
    ch = () => [1.398, -.316, .065, -.273, .201, -.051, 1.278, -.08, -.273, .201, -.051, .119, 1.151, -.29, .215, 0, 0, 0, 1, 0],
    dh = () => [1.073, -.015, .092, -.115, -.017, .107, .859, .184, -.115, -.017, .015, .077, 1.104, -.115, -.017, 0, 0, 0, 1, 0],
    uh = () => [1.06, 0, 0, 0, 0, 0, 1.01, 0, 0, 0, 0, 0, .93, 0, 0, 0, 0, 0, 1, 0],
    hh = () => [1.1, 0, 0, 0, -.1, 0, 1.1, 0, 0, -.1, 0, 0, 1.2, 0, -.1, 0, 0, 0, 1, 0],
    ph = () => [-1, 0, 0, 1, 0, 0, -1, 0, 1, 0, 0, 0, -1, 1, 0, 0, 0, 0, 1, 0],
    mh = () => [.212, .715, .114, 0, 0, .212, .715, .114, 0, 0, .212, .715, .114, 0, 0, 0, 0, 0, 1, 0],
    gh = () => [.15, 1.3, -.25, .1, -.2, .15, 1.3, -.25, .1, -.2, .15, 1.3, -.25, .1, -.2, 0, 0, 0, 1, 0],
    fh = () => [.163, .518, .084, -.01, .208, .163, .529, .082, -.02, .21, .171, .529, .084, 0, .214, 0, 0, 0, 1, 0],
    $h = () => [.338, .991, .117, .093, -.196, .302, 1.049, .096, .078, -.196, .286, 1.016, .146, .101, -.196, 0, 0, 0, 1, 0],
    yh = () => [.393, .768, .188, 0, 0, .349, .685, .167, 0, 0, .272, .533, .13, 0, 0, 0, 0, 0, 1, 0],
    xh = () => [.289, .62, .185, 0, .077, .257, .566, .163, 0, .115, .2, .43, .128, 0, .188, 0, 0, 0, 1, 0],
    bh = () => [.269, .764, .172, .05, .1, .239, .527, .152, 0, .176, .186, .4, .119, 0, .159, 0, 0, 0, 1, 0],
    vh = () => [.547, .764, .134, 0, -.147, .281, .925, .12, 0, -.135, .225, .558, .33, 0, -.113, 0, 0, 0, 1, 0];
var wh = {
    filterFunctions: {
        chrome: ch,
        fade: dh,
        pastel: lh,
        cold: hh,
        warm: uh,
        monoDefault: mh,
        monoWash: fh,
        monoNoir: gh,
        monoStark: $h,
        sepiaDefault: yh,
        sepiaRust: bh,
        sepiaBlues: xh,
        sepiaColor: vh
    },
    filterOptions: [
        ["Default", [
            [void 0, e => e.labelDefault]
        ]],
        ["Classic", [
            ["chrome", e => e.filterLabelChrome],
            ["fade", e => e.filterLabelFade],
            ["cold", e => e.filterLabelCold],
            ["warm", e => e.filterLabelWarm],
            ["pastel", e => e.filterLabelPastel]
        ]],
        ["Monochrome", [
            ["monoDefault", e => e.filterLabelMonoDefault],
            ["monoNoir", e => e.filterLabelMonoNoir],
            ["monoStark", e => e.filterLabelMonoStark],
            ["monoWash", e => e.filterLabelMonoWash]
        ]],
        ["Sepia", [
            ["sepiaDefault", e => e.filterLabelSepiaDefault],
            ["sepiaRust", e => e.filterLabelSepiaRust],
            ["sepiaBlues", e => e.filterLabelSepiaBlues],
            ["sepiaColor", e => e.filterLabelSepiaColor]
        ]]
    ]
};
const Sh = {
        shape: {
            frameColor: [1, 1, 1],
            frameStyle: "solid",
            frameSize: "2.5%"
        },
        thumb: '<rect stroke-width="5" x="0" y="0" width="100%" height="100%"/>'
    },
    Ch = {
        shape: {
            frameColor: [1, 1, 1],
            frameStyle: "solid",
            frameSize: "2.5%",
            frameRound: !0
        },
        thumb: '<rect stroke-width="5" x="0" y="0" width="100%" height="100%" rx="12%"/>'
    },
    kh = {
        shape: {
            frameColor: [1, 1, 1],
            frameStyle: "line",
            frameInset: "2.5%",
            frameSize: ".3125%",
            frameRadius: 0
        },
        thumb: '<div style="top:.5em;left:.5em;right:.5em;bottom:.5em;box-shadow:inset 0 0 0 1px currentColor"></div>'
    },
    Mh = {
        shape: {
            frameColor: [1, 1, 1],
            frameStyle: "line",
            frameAmount: 2,
            frameInset: "2.5%",
            frameSize: ".3125%",
            frameOffset: "1.25%",
            frameRadius: 0
        },
        thumb: '<div style="top:.75em;left:.75em;right:.75em;bottom:.75em; outline: 3px double"></div>'
    },
    Th = {
        shape: {
            frameColor: [1, 1, 1],
            frameStyle: "edge",
            frameInset: "2.5%",
            frameOffset: "5%",
            frameSize: ".3125%"
        },
        thumb: '<div style="top:.75em;left:.5em;bottom:.75em;border-left:1px solid"></div><div style="top:.75em;right:.5em;bottom:.75em;border-right:1px solid"></div><div style="top:.5em;left:.75em;right:.75em;border-top:1px solid"></div><div style="bottom:.5em;left:.75em;right:.75em;border-bottom:1px solid"></div>'
    },
    Rh = {
        shape: {
            frameColor: [1, 1, 1],
            frameStyle: "edge",
            frameInset: "2.5%",
            frameSize: ".3125%"
        },
        thumb: '<div style="top:-.5em;left:.5em;right:.5em;bottom:-.5em; box-shadow: inset 0 0 0 1px currentColor"></div><div style="top:.5em;left:-.5em;right:-.5em;bottom:.5em;box-shadow:inset 0 0 0 1px currentColor"></div>'
    },
    Ph = {
        shape: {
            frameColor: [1, 1, 1],
            frameStyle: "edge",
            frameOffset: "1.5%",
            frameSize: ".3125%"
        },
        thumb: '<div style="top:.3125em;left:.5em;bottom:.3125em;border-left:1px solid"></div><div style="top:.3125em;right:.5em;bottom:.3125em;border-right:1px solid"></div><div style="top:.5em;left:.3125em;right:.3125em;border-top:1px solid"></div><div style="bottom:.5em;left:.3125em;right:.3125em;border-bottom:1px solid"></div>'
    },
    Ah = {
        shape: {
            frameColor: [1, 1, 1],
            frameStyle: "hook",
            frameInset: "2.5%",
            frameSize: ".3125%",
            frameLength: "5%"
        },
        thumb: '<div style="top:.5em;left:.5em;width:.75em;height:.75em; border-left: 1px solid;border-top: 1px solid;"></div><div style="top:.5em;right:.5em;width:.75em;height:.75em; border-right: 1px solid;border-top: 1px solid;"></div><div style="bottom:.5em;left:.5em;width:.75em;height:.75em; border-left: 1px solid;border-bottom: 1px solid;"></div><div style="bottom:.5em;right:.5em;width:.75em;height:.75em; border-right: 1px solid;border-bottom: 1px solid;"></div>'
    },
    Ih = {
        shape: {
            frameColor: [1, 1, 1],
            frameStyle: "polaroid"
        },
        thumb: '<rect stroke-width="20%" x="-5%" y="-5%" width="110%" height="96%"/>'
    };
var Eh = {
        frameStyles: {
            solidSharp: Sh,
            solidRound: Ch,
            lineSingle: kh,
            lineMultiple: Mh,
            edgeSeparate: Th,
            edgeCross: Rh,
            edgeOverlap: Ph,
            hook: Ah,
            polaroid: Ih
        },
        frameOptions: [
            [void 0, e => e.labelNone],
            ["solidSharp", e => e.frameLabelMatSharp],
            ["solidRound", e => e.frameLabelMatRound],
            ["lineSingle", e => e.frameLabelLineSingle],
            ["lineMultiple", e => e.frameLabelLineMultiple],
            ["edgeCross", e => e.frameLabelEdgeCross],
            ["edgeSeparate", e => e.frameLabelEdgeSeparate],
            ["edgeOverlap", e => e.frameLabelEdgeOverlap],
            ["hook", e => e.frameLabelCornerHooks],
            ["polaroid", e => e.frameLabelPolaroid]
        ]
    },
    Lh = (e, t, o) => {
        let i, n, r;
        const a = Math.floor(6 * e),
            s = 6 * e - a,
            l = o * (1 - t),
            c = o * (1 - s * t),
            d = o * (1 - (1 - s) * t);
        switch (a % 6) {
            case 0:
                i = o, n = d, r = l;
                break;
            case 1:
                i = c, n = o, r = l;
                break;
            case 2:
                i = l, n = o, r = d;
                break;
            case 3:
                i = l, n = c, r = o;
                break;
            case 4:
                i = d, n = l, r = o;
                break;
            case 5:
                i = o, n = l, r = c
        }
        return [i, n, r]
    };

function Fh(e) {
    let t, o, i;
    return {
        c() {
            t = Mn("div"), o = Mn("span"), Fn(t, "class", "PinturaColorPreview"), Fn(t, "title", e[0]), Fn(t, "style", i = "--color:" + e[1])
        },
        m(e, i) {
            Cn(e, t, i), Sn(t, o)
        },
        p(e, [o]) {
            1 & o && Fn(t, "title", e[0]), 2 & o && i !== (i = "--color:" + e[1]) && Fn(t, "style", i)
        },
        i: Ji,
        o: Ji,
        d(e) {
            e && kn(t)
        }
    }
}

function zh(e, t, o) {
    let i, {
            color: n
        } = t,
        {
            title: r
        } = t;
    return e.$$set = e => {
        "color" in e && o(2, n = e.color), "title" in e && o(0, r = e.title)
    }, e.$$.update = () => {
        4 & e.$$.dirty && o(1, i = n ? so(n) : "transparent")
    }, [r, i, n]
}
class Bh extends Fr {
    constructor(e) {
        super(), Lr(this, e, zh, Fh, an, {
            color: 2,
            title: 0
        })
    }
}

function Dh(e) {
    let t, o;
    return {
        c() {
            t = Mn("span"), o = Rn(e[0])
        },
        m(e, i) {
            Cn(e, t, i), Sn(t, o)
        },
        p(e, t) {
            1 & t[0] && Bn(o, e[0])
        },
        d(e) {
            e && kn(t)
        }
    }
}

function Oh(e) {
    let t, o, i, n;
    o = new Bh({
        props: {
            color: e[4],
            title: Ic(e[8], e[10])
        }
    });
    let r = !e[9] && Dh(e);
    return {
        c() {
            t = Mn("span"), Pr(o.$$.fragment), i = Pn(), r && r.c(), Fn(t, "slot", "label"), Fn(t, "class", "PinturaButtonLabel")
        },
        m(e, a) {
            Cn(e, t, a), Ar(o, t, null), Sn(t, i), r && r.m(t, null), n = !0
        },
        p(e, i) {
            const n = {};
            16 & i[0] && (n.color = e[4]), 1280 & i[0] && (n.title = Ic(e[8], e[10])), o.$set(n), e[9] ? r && (r.d(1), r = null) : r ? r.p(e, i) : (r = Dh(e), r.c(), r.m(t, null))
        },
        i(e) {
            n || (yr(o.$$.fragment, e), n = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), n = !1
        },
        d(e) {
            e && kn(t), Ir(o), r && r.d()
        }
    }
}

function _h(e) {
    let t, o, i, n, r, a, s, l, c, d, u, h, p;
    c = new Sd({
        props: {
            class: "PinturaHuePicker",
            knobStyle: "background-color:" + e[19],
            onchange: e[24],
            value: e[14],
            min: 0,
            max: 1,
            step: .01
        }
    });
    let m = e[11] && Wh(e);
    return {
        c() {
            t = Mn("div"), o = Mn("div"), i = Mn("div"), n = Mn("div"), l = Pn(), Pr(c.$$.fragment), d = Pn(), m && m.c(), Fn(n, "role", "button"), Fn(n, "aria-label", "Saturation slider"), Fn(n, "class", "PinturaPickerKnob"), Fn(n, "tabindex", "0"), Fn(n, "style", r = `background-color:${e[18]};`), Fn(i, "class", "PinturaPickerKnobController"), Fn(i, "style", a = `transform:translate(${e[21]}%,${e[22]}%)`), Fn(o, "class", "PinturaSaturationPicker"), Fn(o, "style", s = "background-color: " + e[19]), Fn(t, "class", "PinturaPicker")
        },
        m(r, a) {
            Cn(r, t, a), Sn(t, o), Sn(o, i), Sn(i, n), e[31](o), Sn(t, l), Ar(c, t, null), Sn(t, d), m && m.m(t, null), u = !0, h || (p = [In(n, "nudge", e[27]), fn(Nl.call(null, n)), In(o, "pointerdown", e[26])], h = !0)
        },
        p(e, l) {
            (!u || 262144 & l[0] && r !== (r = `background-color:${e[18]};`)) && Fn(n, "style", r), (!u || 6291456 & l[0] && a !== (a = `transform:translate(${e[21]}%,${e[22]}%)`)) && Fn(i, "style", a), (!u || 524288 & l[0] && s !== (s = "background-color: " + e[19])) && Fn(o, "style", s);
            const d = {};
            524288 & l[0] && (d.knobStyle = "background-color:" + e[19]), 16384 & l[0] && (d.value = e[14]), c.$set(d), e[11] ? m ? (m.p(e, l), 2048 & l[0] && yr(m, 1)) : (m = Wh(e), m.c(), yr(m, 1), m.m(t, null)) : m && (fr(), xr(m, 1, 1, (() => {
                m = null
            })), $r())
        },
        i(e) {
            u || (yr(c.$$.fragment, e), yr(m), u = !0)
        },
        o(e) {
            xr(c.$$.fragment, e), xr(m), u = !1
        },
        d(o) {
            o && kn(t), e[31](null), Ir(c), m && m.d(), h = !1, nn(p)
        }
    }
}

function Wh(e) {
    let t, o;
    return t = new Sd({
        props: {
            class: "PinturaOpacityPicker",
            knobStyle: "background-color: " + e[16],
            trackStyle: `background-image: linear-gradient(to right, ${e[17]}, ${e[18]})`,
            onchange: e[25],
            value: e[15],
            min: 0,
            max: 1,
            step: .01
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            65536 & o[0] && (i.knobStyle = "background-color: " + e[16]), 393216 & o[0] && (i.trackStyle = `background-image: linear-gradient(to right, ${e[17]}, ${e[18]})`), 32768 & o[0] && (i.value = e[15]), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Vh(e) {
    let t, o;
    return t = new ad({
        props: {
            label: "Presets",
            class: al(["PinturaColorPresets", e[9] ? "PinturaColorPresetsGrid" : "PinturaColorPresetsList"]),
            hideLabel: !1,
            name: e[1],
            value: e[4],
            optionGroupClass: "PinturaDropdownOptionGroup",
            optionClass: "PinturaDropdownOption",
            options: e[2].map(e[32]),
            selectedIndex: e[3],
            optionMapper: e[7],
            optionLabelClass: e[6],
            onchange: e[33],
            $$slots: {
                option: [Uh, ({
                    option: e
                }) => ({
                    44: e
                }), ({
                    option: e
                }) => [0, e ? 8192 : 0]],
                group: [Hh, ({
                    option: e
                }) => ({
                    44: e
                }), ({
                    option: e
                }) => [0, e ? 8192 : 0]]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            512 & o[0] && (i.class = al(["PinturaColorPresets", e[9] ? "PinturaColorPresetsGrid" : "PinturaColorPresetsList"])), 2 & o[0] && (i.name = e[1]), 16 & o[0] && (i.value = e[4]), 1028 & o[0] && (i.options = e[2].map(e[32])), 8 & o[0] && (i.selectedIndex = e[3]), 128 & o[0] && (i.optionMapper = e[7]), 64 & o[0] && (i.optionLabelClass = e[6]), 512 & o[0] | 24576 & o[1] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Hh(e) {
    let t, o, i = e[44].label + "";
    return {
        c() {
            t = Mn("span"), o = Rn(i), Fn(t, "slot", "group")
        },
        m(e, i) {
            Cn(e, t, i), Sn(t, o)
        },
        p(e, t) {
            8192 & t[1] && i !== (i = e[44].label + "") && Bn(o, i)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function Nh(e) {
    let t, o, i = e[44].label + "";
    return {
        c() {
            t = Mn("span"), o = Rn(i), Fn(t, "class", "PinturaButtonLabel")
        },
        m(e, i) {
            Cn(e, t, i), Sn(t, o)
        },
        p(e, t) {
            8192 & t[1] && i !== (i = e[44].label + "") && Bn(o, i)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function Uh(e) {
    let t, o, i, n;
    o = new Bh({
        props: {
            title: e[44].label,
            color: e[44].value
        }
    });
    let r = !e[9] && Nh(e);
    return {
        c() {
            t = Mn("span"), Pr(o.$$.fragment), i = Pn(), r && r.c(), Fn(t, "slot", "option")
        },
        m(e, a) {
            Cn(e, t, a), Ar(o, t, null), Sn(t, i), r && r.m(t, null), n = !0
        },
        p(e, i) {
            const n = {};
            8192 & i[1] && (n.title = e[44].label), 8192 & i[1] && (n.color = e[44].value), o.$set(n), e[9] ? r && (r.d(1), r = null) : r ? r.p(e, i) : (r = Nh(e), r.c(), r.m(t, null))
        },
        i(e) {
            n || (yr(o.$$.fragment, e), n = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), n = !1
        },
        d(e) {
            e && kn(t), Ir(o), r && r.d()
        }
    }
}

function jh(e) {
    let t, o, i, n = e[13] && _h(e),
        r = e[12] && Vh(e);
    return {
        c() {
            t = Mn("div"), n && n.c(), o = Pn(), r && r.c(), Fn(t, "slot", "details"), Fn(t, "class", "PinturaColorPickerPanel")
        },
        m(e, a) {
            Cn(e, t, a), n && n.m(t, null), Sn(t, o), r && r.m(t, null), i = !0
        },
        p(e, i) {
            e[13] ? n ? (n.p(e, i), 8192 & i[0] && yr(n, 1)) : (n = _h(e), n.c(), yr(n, 1), n.m(t, o)) : n && (fr(), xr(n, 1, 1, (() => {
                n = null
            })), $r()), e[12] ? r ? (r.p(e, i), 4096 & i[0] && yr(r, 1)) : (r = Vh(e), r.c(), yr(r, 1), r.m(t, null)) : r && (fr(), xr(r, 1, 1, (() => {
                r = null
            })), $r())
        },
        i(e) {
            i || (yr(n), yr(r), i = !0)
        },
        o(e) {
            xr(n), xr(r), i = !1
        },
        d(e) {
            e && kn(t), n && n.d(), r && r.d()
        }
    }
}

function Xh(e) {
    let t, o;
    return t = new kc({
        props: {
            buttonClass: al(["PinturaColorPickerButton", e[5]]),
            $$slots: {
                details: [jh],
                label: [Oh]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            32 & o[0] && (i.buttonClass = al(["PinturaColorPickerButton", e[5]])), 8388575 & o[0] | 16384 & o[1] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Yh(e, t, o) {
    let i, n, r, a, s, l, c, d, u, h, p, {
            label: m
        } = t,
        {
            name: g
        } = t,
        {
            options: f = []
        } = t,
        {
            selectedIndex: $ = -1
        } = t,
        {
            value: y
        } = t,
        {
            buttonClass: x
        } = t,
        {
            optionLabelClass: b
        } = t,
        {
            optionMapper: v
        } = t,
        {
            onchange: w
        } = t,
        {
            title: C
        } = t,
        {
            hidePresetLabel: k = !0
        } = t,
        {
            locale: M
        } = t,
        {
            enableOpacity: T = !0
        } = t,
        {
            enablePresets: R = !0
        } = t,
        {
            enablePicker: P = !0
        } = t;
    const A = (e, t) => {
        if (c = [e[0], e[1], e[2]], t) {
            let t = ((e, t, o) => {
                let i = Math.max(e, t, o),
                    n = i - Math.min(e, t, o),
                    r = n && (i == e ? (t - o) / n : i == t ? 2 + (o - e) / n : 4 + (e - t) / n);
                return [60 * (r < 0 ? r + 6 : r) / 360, i && n / i, i]
            })(...c);
            o(14, r = t[0]), o(29, a = t[1]), o(30, s = t[2]), o(15, l = Zt(e[3]) ? e[3] : 1)
        }
        o(16, d = so(e)), o(17, u = so([...c, 0])), o(18, h = so([...c, 1])), o(19, p = so(Lh(r, 1, 1)))
    };
    y && A(y, !0);
    const I = () => {
            const e = [...Lh(r, a, s), l];
            A(e), w(e)
        },
        E = e => {
            const t = 3 === e.length ? [...e, 1] : e;
            A(t, !0), w(t)
        },
        L = (e, t) => {
            const i = oa(e.x / t.width, 0, 1),
                n = oa(e.y / t.height, 0, 1);
            var r;
            r = 1 - n, o(29, a = i), o(30, s = r), 0 === l && o(15, l = 1), I()
        };
    let F, z, B, D;
    const O = e => {
            const t = re(q(e), D);
            L(ne(Z(B), t), z)
        },
        _ = e => {
            z = void 0, document.documentElement.removeEventListener("pointermove", O), document.documentElement.removeEventListener("pointerup", _)
        };
    return e.$$set = e => {
        "label" in e && o(0, m = e.label), "name" in e && o(1, g = e.name), "options" in e && o(2, f = e.options), "selectedIndex" in e && o(3, $ = e.selectedIndex), "value" in e && o(4, y = e.value), "buttonClass" in e && o(5, x = e.buttonClass), "optionLabelClass" in e && o(6, b = e.optionLabelClass), "optionMapper" in e && o(7, v = e.optionMapper), "onchange" in e && o(28, w = e.onchange), "title" in e && o(8, C = e.title), "hidePresetLabel" in e && o(9, k = e.hidePresetLabel), "locale" in e && o(10, M = e.locale), "enableOpacity" in e && o(11, T = e.enableOpacity), "enablePresets" in e && o(12, R = e.enablePresets), "enablePicker" in e && o(13, P = e.enablePicker)
    }, e.$$.update = () => {
        536870912 & e.$$.dirty[0] && o(21, i = 100 * a), 1073741824 & e.$$.dirty[0] && o(22, n = 100 - 100 * s)
    }, [m, g, f, $, y, x, b, v, C, k, M, T, R, P, r, l, d, u, h, p, F, i, n, E, e => {
        o(14, r = e), 0 === l && o(15, l = 1), I()
    }, e => {
        o(15, l = e), I()
    }, e => {
        e.stopPropagation(), z = be(F.offsetWidth, F.offsetHeight), B = (e => Y(e.offsetX, e.offsetY))(e), D = q(e), L(B, z), document.documentElement.addEventListener("pointermove", O), document.documentElement.addEventListener("pointerup", _)
    }, e => {
        z = be(F.offsetWidth, F.offsetHeight);
        const t = i / 100 * z.width,
            o = n / 100 * z.height;
        L({
            x: t + e.detail.x,
            y: o + e.detail.y
        }, z)
    }, w, a, s, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            F = e, o(20, F)
        }))
    }, ([e, t]) => [e, S(t) ? t(M) : t], e => E(e.value)]
}
class Gh extends Fr {
    constructor(e) {
        super(), Lr(this, e, Yh, Xh, an, {
            label: 0,
            name: 1,
            options: 2,
            selectedIndex: 3,
            value: 4,
            buttonClass: 5,
            optionLabelClass: 6,
            optionMapper: 7,
            onchange: 28,
            title: 8,
            hidePresetLabel: 9,
            locale: 10,
            enableOpacity: 11,
            enablePresets: 12,
            enablePicker: 13
        }, [-1, -1])
    }
}
var qh = e => e.charAt(0).toUpperCase() + e.slice(1);
let Zh = null;
var Kh = () => {
    if (null === Zh)
        if (c()) try {
            Zh = !1 === document.fonts.check("16px TestNonExistingFont")
        } catch (e) {
            Zh = !1
        } else Zh = !1;
    return Zh
};
const Jh = (e, t) => o => o[t ? `${t}${qh(e)}` : e],
    Qh = e => [e, "" + e],
    ep = (e, t) => o => [e[o], Jh(o, t)],
    tp = [1, .2549, .2118],
    op = [1, 1, 1, 0],
    ip = {
        path: () => ({
            points: [],
            disableErase: !1
        }),
        eraser: () => ({
            eraseRadius: 0
        }),
        line: () => ({
            x1: 0,
            y1: 0,
            x2: 0,
            y2: 0,
            disableErase: !1
        }),
        rectangle: () => ({
            x: 0,
            y: 0,
            width: 0,
            height: 0
        }),
        ellipse: () => ({
            x: 0,
            y: 0,
            rx: 0,
            ry: 0
        }),
        text: () => ({
            x: 0,
            y: 0,
            text: "Text"
        })
    },
    np = (e, t = {}, o = {
        position: "relative"
    }) => {
        if (!ip[e]) return;
        return [{
            ...ip[e](),
            ...t
        }, o]
    },
    rp = e => ({
        sharpie: np("path", {
            strokeWidth: "0.5%",
            strokeColor: [...tp],
            disableMove: !0
        }),
        eraser: np("eraser"),
        line: np("line", {
            strokeColor: [...tp],
            strokeWidth: "0.5%"
        }),
        arrow: np("line", {
            lineStart: "none",
            lineEnd: "arrow-solid",
            strokeColor: [...tp],
            strokeWidth: "0.5%"
        }),
        rectangle: np("rectangle", {
            strokeColor: [...op],
            backgroundColor: [...tp]
        }),
        ellipse: np("ellipse", {
            strokeColor: [...op],
            backgroundColor: [...tp]
        }),
        text: np("text", {
            color: [...tp],
            fontSize: "2%"
        }),
        ...e
    }),
    ap = (e, t, o) => [e, t || Jh(e, "shapeLabelTool"), {
        icon: Jh(e, "shapeIconTool"),
        ...o
    }],
    sp = (e = ["sharpie", "eraser", "line", "arrow", "rectangle", "ellipse", "text", "preset"]) => e.map((e => w(e) ? ap(e) : Array.isArray(e) ? x(e[1]) ? ap(e[0], void 0, e[1]) : ap(e[0], e[1], e[2]) : void 0)).filter(Boolean),
    lp = () => ({
        transparent: [1, 1, 1, 0],
        white: [1, 1, 1],
        silver: [.8667, .8667, .8667],
        gray: [.6667, .6667, .6667],
        black: [0, 0, 0],
        navy: [0, .1216, .2471],
        blue: [0, .4549, .851],
        aqua: [.498, .8588, 1],
        teal: [.2235, .8, .8],
        olive: [.2392, .6, .4392],
        green: [.1804, .8, .251],
        yellow: [1, .8627, 0],
        orange: [1, .5216, .1059],
        red: [1, .2549, .2118],
        maroon: [.5216, .0784, .2941],
        fuchsia: [.9412, .0706, .7451],
        purple: [.6941, .051, .7882]
    }),
    cp = () => [16, 18, 20, 24, 30, 36, 48, 64, 72, 96, 128, 144],
    dp = cp,
    up = () => ({
        extraSmall: "2%",
        small: "4%",
        mediumSmall: "8%",
        medium: "10%",
        mediumLarge: "15%",
        large: "20%",
        extraLarge: "25%"
    }),
    hp = () => ({
        extraSmall: "40%",
        small: "60%",
        mediumSmall: "100%",
        medium: "120%",
        mediumLarge: "140%",
        large: "180%",
        extraLarge: "220%"
    }),
    pp = () => [1, 2, 3, 4, 6, 8, 12, 16, 20, 24, 32, 48, 64],
    mp = () => ({
        extraSmall: "0.25%",
        small: "0.5%",
        mediumSmall: "1%",
        medium: "1.75%",
        mediumLarge: "2.5%",
        large: "3.5%",
        extraLarge: "5%"
    }),
    gp = () => ["bar", "arrow", "arrowSolid", "circle", "circleSolid", "square", "squareSolid"],
    fp = () => [
        ["Helvetica, Arial, Verdana, 'Droid Sans', sans-serif", "Sans Serif"],
        ["'Arial Black', 'Avenir-Black', 'Arial Bold'", "Black"],
        ["'Arial Narrow', 'Futura-CondensedMedium'", "Narrow"],
        ["'Trebuchet MS'", "Humanist"],
        ["Georgia, 'Avenir-Black', 'Times New Roman', 'Droid Serif', serif", "Serif"],
        ["Palatino", "Old-Style"],
        ["'Times New Roman', 'TimesNewRomanPSMT'", "Transitional"],
        ["Menlo, Monaco, 'Lucida Console', monospace", "Monospaced"],
        ["'Courier New', monospace", "Slab Serif"]
    ],
    $p = () => ["left", "center", "right"],
    yp = () => [
        ["normal", "bold"],
        ["italic", "normal"],
        ["italic", "bold"]
    ],
    xp = e => Object.keys(e).map(ep(e, "shapeTitleColor")),
    bp = e => e.map(Qh),
    vp = e => Object.keys(e).map(ep(e, "labelSize")),
    wp = e => e.map(Qh),
    Sp = e => Object.keys(e).map(ep(e, "labelSize")),
    Cp = e => e.map(Qh),
    kp = e => Object.keys(e).map(ep(e, "labelSize")),
    Mp = e => [...e],
    Tp = e => e.map((e => [e, t => t["shapeLabelFontStyle" + e.filter((e => "normal" !== e)).map(qh).join("")]])),
    Rp = e => e.map((e => [Ud(e), t => t["shapeTitleLineDecoration" + qh(e)], {
        icon: t => t["shapeIconLineDecoration" + qh(e)]
    }])),
    Pp = e => e.map((e => [e, t => t["shapeTitleTextAlign" + qh(e)], {
        hideLabel: !0,
        icon: t => t["shapeIconTextAlign" + qh(e)]
    }])),
    Ap = (e, t) => {
        const {
            defaultKey: o,
            defaultValue: i,
            defaultOptions: n
        } = t || {}, r = [];
        return o && (r[0] = [i, e => e[o], {
            ...n
        }]), [...r, ...e]
    },
    Ip = e => e.split(",").map((e => e.trim())).some((e => document.fonts.check("16px " + e))),
    Ep = e => [Gh, {
        title: e => e.labelColor,
        options: Ap(e)
    }],
    Lp = (e = {}) => [Ad, {
        ...e
    }],
    Fp = e => [$d, {
        title: e => e.shapeTitleFontFamily,
        onload: ({
            options: e = []
        }) => {
            Kh() && e.map((([e]) => e)).filter(Boolean).filter((e => !Ip(e))).forEach((e => {
                const t = "PinturaFontTest-" + e.replace(/[^a-zA-Z0-9]+/g, "").toLowerCase();
                document.getElementById(t) || document.body.append(p("span", {
                    textContent: " ",
                    id: t,
                    class: "PinturaFontTest",
                    style: `font-family:${e};font-size:0;color:transparent;`
                }))
            }))
        },
        ondestroy: () => {
            if (!Kh()) return;
            document.querySelectorAll(".PinturaFontTest").forEach((e => e.remove()))
        },
        optionLabelStyle: e => "font-family: " + e,
        options: Ap(e, {
            defaultKey: "labelDefault"
        }),
        optionFilter: e => {
            if (!Kh()) return !0;
            const [t] = e;
            if (!t) return !0;
            return Ip(t)
        }
    }],
    zp = e => [Gh, {
        title: e => e.shapeTitleBackgroundColor,
        options: Ap(e)
    }],
    Bp = (e, t = {}) => [Gh, {
        title: e => e.shapeTitleStrokeColor,
        options: Ap(e),
        buttonClass: "PinturaColorPickerButtonStroke",
        onchange: (e, o) => {
            const i = o.strokeWidth;
            (Zt(i) || w(i) ? parseFloat(i) : 0) > 0 || (o.strokeWidth = t && t.defaultStrokeWidth || "0.5%")
        }
    }],
    Dp = e => [$d, {
        title: e => e.shapeTitleStrokeWidth,
        options: t => Jt(t, "backgroundColor") ? Ap(e, {
            defaultKey: "shapeLabelStrokeNone"
        }) : Ap(e),
        onchange: (e, t) => {
            if (!e) return;
            const o = t.strokeColor || [];
            if (o[3]) return;
            const i = [...o];
            i[3] = 1, t.strokeColor[3] = i
        }
    }],
    Op = (e, t, o) => [$d, {
        title: e => e[t],
        options: Ap(e, {
            defaultKey: "labelNone",
            defaultOptions: {
                icon: '<g stroke="currentColor" stroke-linecap="round" stroke-width=".125em"><path d="M5,12 H14"/></g>'
            }
        }),
        optionIconStyle: o
    }],
    _p = e => Op(e, "shapeTitleLineStart", "transform: scaleX(-1)"),
    Wp = e => Op(e, "shapeTitleLineEnd"),
    Vp = e => [Gh, {
        title: e => e.shapeTitleTextColor,
        options: Ap(e)
    }],
    Hp = e => [$d, {
        title: e => e.shapeTitleFontStyle,
        optionLabelStyle: e => e && `font-style:${e[0]};font-weight:${e[1]}`,
        options: Ap(e, {
            defaultKey: "shapeLabelFontStyleNormal"
        })
    }],
    Np = e => {
        let t;
        return e.find((([e]) => "4%" === e)) || (t = {
            defaultKey: "labelAuto",
            defaultValue: "4%"
        }), [$d, {
            title: e => e.shapeTitleFontSize,
            options: Ap(e, t)
        }]
    },
    Up = e => [ad, {
        title: e => e.shapeTitleTextAlign,
        options: Ap(e)
    }],
    jp = e => {
        let t;
        return e.find((([e]) => "120%" === e)) || (t = {
            defaultKey: "labelAuto",
            defaultValue: "120%"
        }), [$d, {
            title: e => e.shapeTitleLineHeight,
            options: Ap(e, t)
        }]
    },
    Xp = (e = {}) => {
        const {
            colorOptions: t = xp(lp()),
            lineEndStyleOptions: o = Rp(gp()),
            fontFamilyOptions: i = Mp(fp()),
            fontStyleOptions: n = Tp(yp()),
            textAlignOptions: r = Pp($p())
        } = e;
        let {
            strokeWidthOptions: a = kp(mp()),
            fontSizeOptions: s = vp(up()),
            lineHeightOptions: l = Sp(hp())
        } = e;
        [s, l, a] = [s, l, a].map((e => Array.isArray(e) && e.every(Zt) ? e.map(Qh) : e));
        const c = {
            defaultColor: t && Ep(t),
            defaultNumber: Lp(),
            defaultPercentage: Lp({
                getValue: e => parseFloat(e),
                setValue: e => e + "%",
                step: .05,
                label: (e, t, o) => Math.round(e / o * 100) + "%",
                labelClass: "PinturaPercentageLabel"
            }),
            backgroundColor: t && zp(t),
            strokeColor: t && Bp(t),
            strokeWidth: a && Dp(a),
            lineStart: o && _p(o),
            lineEnd: o && Wp(o),
            color: t && Vp(t),
            fontFamily: i && Fp(i),
            fontStyle_fontWeight: n && Hp(n),
            fontSize: s && Np(s),
            lineHeight: l && jp(l),
            textAlign: r && Up(r),
            frameColor: ["defaultColor"],
            frameSize: ["defaultPercentage", {
                min: .2,
                max: 10,
                title: e => e.labelSize
            }],
            frameInset: ["defaultPercentage", {
                min: .5,
                max: 10,
                title: e => e.labelInset
            }],
            frameOffset: ["defaultPercentage", {
                min: .5,
                max: 10,
                title: e => e.labelOffset
            }],
            frameRadius: ["defaultPercentage", {
                min: .5,
                max: 10,
                title: e => e.labelRadius
            }],
            frameAmount: ["defaultNumber", {
                min: 1,
                max: 5,
                step: 1,
                title: e => e.labelAmount
            }]
        };
        return Object.entries(e).forEach((([e, t]) => {
            c[e] || (c[e] = t)
        })), c
    };

function Yp(e) {
    let t, o, i, n;
    const r = e[3].default,
        a = dn(r, e, e[2], null);
    return {
        c() {
            t = Mn("div"), a && a.c(), Fn(t, "class", e[0])
        },
        m(r, s) {
            Cn(r, t, s), a && a.m(t, null), o = !0, i || (n = [In(t, "measure", e[1]), fn($s.call(null, t))], i = !0)
        },
        p(e, [i]) {
            a && a.p && 4 & i && hn(a, r, e, e[2], i, null, null), (!o || 1 & i) && Fn(t, "class", e[0])
        },
        i(e) {
            o || (yr(a, e), o = !0)
        },
        o(e) {
            xr(a, e), o = !1
        },
        d(e) {
            e && kn(t), a && a.d(e), i = !1, nn(n)
        }
    }
}

function Gp(e, t, o) {
    let {
        $$slots: i = {},
        $$scope: n
    } = t;
    const r = Zn();
    let {
        class: a = null
    } = t;
    return e.$$set = e => {
        "class" in e && o(0, a = e.class), "$$scope" in e && o(2, n = e.$$scope)
    }, [a, ({
        detail: e
    }) => r("measure", e), n, i]
}
class qp extends Fr {
    constructor(e) {
        super(), Lr(this, e, Gp, Yp, an, {
            class: 0
        })
    }
}
const Zp = e => ({}),
    Kp = e => ({}),
    Jp = e => ({}),
    Qp = e => ({}),
    em = e => ({}),
    tm = e => ({});

function om(e) {
    let t, o;
    const i = e[4].header,
        n = dn(i, e, e[3], tm);
    return {
        c() {
            t = Mn("div"), n && n.c(), Fn(t, "class", "PinturaUtilHeader")
        },
        m(e, i) {
            Cn(e, t, i), n && n.m(t, null), o = !0
        },
        p(e, t) {
            n && n.p && 8 & t && hn(n, i, e, e[3], t, em, tm)
        },
        i(e) {
            o || (yr(n, e), o = !0)
        },
        o(e) {
            xr(n, e), o = !1
        },
        d(e) {
            e && kn(t), n && n.d(e)
        }
    }
}

function im(e) {
    let t, o;
    const i = e[4].footer,
        n = dn(i, e, e[3], Kp);
    return {
        c() {
            t = Mn("div"), n && n.c(), Fn(t, "class", "PinturaUtilFooter")
        },
        m(e, i) {
            Cn(e, t, i), n && n.m(t, null), o = !0
        },
        p(e, t) {
            n && n.p && 8 & t && hn(n, i, e, e[3], t, Zp, Kp)
        },
        i(e) {
            o || (yr(n, e), o = !0)
        },
        o(e) {
            xr(n, e), o = !1
        },
        d(e) {
            e && kn(t), n && n.d(e)
        }
    }
}

function nm(e) {
    let t, o, i, n, r, a, s = e[1] && om(e);
    const l = e[4].main,
        c = dn(l, e, e[3], Qp),
        d = c || function (e) {
            let t, o;
            return t = new qp({
                props: {
                    class: "PinturaStage"
                }
            }), t.$on("measure", e[5]), {
                c() {
                    Pr(t.$$.fragment)
                },
                m(e, i) {
                    Ar(t, e, i), o = !0
                },
                p: Ji,
                i(e) {
                    o || (yr(t.$$.fragment, e), o = !0)
                },
                o(e) {
                    xr(t.$$.fragment, e), o = !1
                },
                d(e) {
                    Ir(t, e)
                }
            }
        }(e);
    let u = e[2] && im(e);
    return {
        c() {
            s && s.c(), t = Pn(), o = Mn("div"), d && d.c(), i = Pn(), u && u.c(), n = Pn(), r = An(), Fn(o, "class", "PinturaUtilMain")
        },
        m(l, c) {
            s && s.m(l, c), Cn(l, t, c), Cn(l, o, c), d && d.m(o, null), e[6](o), Cn(l, i, c), u && u.m(l, c), Cn(l, n, c), Cn(l, r, c), a = !0
        },
        p(e, [o]) {
            e[1] ? s ? (s.p(e, o), 2 & o && yr(s, 1)) : (s = om(e), s.c(), yr(s, 1), s.m(t.parentNode, t)) : s && (fr(), xr(s, 1, 1, (() => {
                s = null
            })), $r()), c && c.p && 8 & o && hn(c, l, e, e[3], o, Jp, Qp), e[2] ? u ? (u.p(e, o), 4 & o && yr(u, 1)) : (u = im(e), u.c(), yr(u, 1), u.m(n.parentNode, n)) : u && (fr(), xr(u, 1, 1, (() => {
                u = null
            })), $r())
        },
        i(e) {
            a || (yr(s), yr(d, e), yr(u), yr(false), a = !0)
        },
        o(e) {
            xr(s), xr(d, e), xr(u), xr(false), a = !1
        },
        d(a) {
            s && s.d(a), a && kn(t), a && kn(o), d && d.d(a), e[6](null), a && kn(i), u && u.d(a), a && kn(n), a && kn(r)
        }
    }
}

function rm(e, t, o) {
    let {
        $$slots: i = {},
        $$scope: n
    } = t, {
        hasHeader: r = !!t.$$slots.header
    } = t, {
        hasFooter: a = !!t.$$slots.footer
    } = t, {
        root: s
    } = t;
    return e.$$set = e => {
        o(7, t = en(en({}, t), pn(e))), "hasHeader" in e && o(1, r = e.hasHeader), "hasFooter" in e && o(2, a = e.hasFooter), "root" in e && o(0, s = e.root), "$$scope" in e && o(3, n = e.$$scope)
    }, t = pn(t), [s, r, a, n, i, function (t) {
        Qn(e, t)
    }, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            s = e, o(0, s)
        }))
    }]
}
class am extends Fr {
    constructor(e) {
        super(), Lr(this, e, rm, nm, an, {
            hasHeader: 1,
            hasFooter: 2,
            root: 0
        })
    }
}

function sm(e) {
    let t, o;
    return {
        c() {
            t = Mn("div"), Fn(t, "class", "PinturaRangeInputMeter"), Fn(t, "style", o = `transform: translateX(${e[8].x-e[9].x}px) translateY(${e[8].y-e[9].y}px)`)
        },
        m(o, i) {
            Cn(o, t, i), t.innerHTML = e[6]
        },
        p(e, i) {
            64 & i[0] && (t.innerHTML = e[6]), 256 & i[0] && o !== (o = `transform: translateX(${e[8].x-e[9].x}px) translateY(${e[8].y-e[9].y}px)`) && Fn(t, "style", o)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function lm(e) {
    let t, o, i, n, r, a, s, l, c, d, u, h = e[8] && sm(e);
    return {
        c() {
            t = Mn("div"), o = Mn("span"), i = Rn(e[3]), n = Pn(), r = Mn("button"), a = Rn(e[1]), l = Pn(), c = Mn("div"), h && h.c(), Fn(o, "class", "PinturaRangeInputValue"), Fn(r, "class", "PinturaRangeInputReset"), Fn(r, "type", "button"), r.disabled = s = e[0] === e[2], Fn(c, "class", "PinturaRangeInputInner"), Fn(c, "style", e[7]), Fn(c, "data-value-limited", e[5]), Fn(t, "class", "PinturaRangeInput"), Fn(t, "tabindex", "0")
        },
        m(s, p) {
            Cn(s, t, p), Sn(t, o), Sn(o, i), Sn(t, n), Sn(t, r), Sn(r, a), Sn(t, l), Sn(t, c), h && h.m(c, null), d || (u = [In(r, "click", e[14]), In(c, "interactionstart", e[10]), In(c, "interactionupdate", e[12]), In(c, "interactionend", e[13]), In(c, "interactionrelease", e[11]), fn(Hl.call(null, c, {
                inertia: !0
            })), In(c, "measure", e[32]), fn($s.call(null, c)), In(t, "wheel", e[16], {
                passive: !1
            }), In(t, "nudge", e[17]), fn(Nl.call(null, t, {
                direction: "horizontal"
            }))], d = !0)
        },
        p(e, t) {
            8 & t[0] && Bn(i, e[3]), 2 & t[0] && Bn(a, e[1]), 5 & t[0] && s !== (s = e[0] === e[2]) && (r.disabled = s), e[8] ? h ? h.p(e, t) : (h = sm(e), h.c(), h.m(c, null)) : h && (h.d(1), h = null), 128 & t[0] && Fn(c, "style", e[7]), 32 & t[0] && Fn(c, "data-value-limited", e[5])
        },
        i: Ji,
        o: Ji,
        d(e) {
            e && kn(t), h && h.d(), d = !1, nn(u)
        }
    }
}

function cm(e, t, o) {
    let i, r, a, s, l, c, d, u, {
            labelReset: h = "Reset"
        } = t,
        {
            direction: p = "x"
        } = t,
        {
            min: m = 0
        } = t,
        {
            max: g = 1
        } = t,
        {
            base: f = m
        } = t,
        {
            value: $ = 0
        } = t,
        {
            valueLabel: y = 0
        } = t,
        {
            valueMin: x
        } = t,
        {
            valueMax: b
        } = t,
        {
            oninputstart: v = n
        } = t,
        {
            oninputmove: w = n
        } = t,
        {
            oninputend: S = n
        } = t,
        {
            elasticity: C = 0
        } = t;
    const k = (e, t, o) => Math.ceil((e - o) / t) * t + o;
    let M, T, R;
    const P = {
            x: 2,
            y: 0
        },
        A = (e, t, o) => `M ${e-o} ${t} a ${o} ${o} 0 1 0 0 -1`;
    let I, E = void 0,
        L = !1,
        F = {
            snap: !1,
            elastic: !1
        };
    const z = (e, t, o) => {
            const i = e[p] + t[p],
                n = oa(i, I[1][p], I[0][p]),
                r = C ? n + Ul(i - n, C) : n,
                a = o.elastic ? r : n,
                s = Y(0, 0);
            return s[p] = a, B.set(s, {
                hard: o.snap
            }), oa(O(s, p), m, g)
        },
        B = rs();
    cn(e, B, (e => o(8, u = e)));
    const D = (e, t) => {
            const o = .5 * (M[t] - s[t]) - (yd(e, m, g) * s[t] - .5 * s[t]);
            return {
                x: "x" === t ? o : 0,
                y: "y" === t ? o : 0
            }
        },
        O = (e, t) => {
            const o = -(e[t] - .5 * M[t]) / s[t];
            return m + o * i
        },
        _ = B.subscribe((e => {
            e && E && w(oa(O(e, p), m, g))
        })),
        W = e => {
            const t = [D(null != x ? x : m, p), D(null != b ? b : g, p)],
                o = {
                    x: "x" === p ? u.x + e : 0,
                    y: "y" === p ? u.y + e : 0
                },
                i = oa(o[p], t[1][p], t[0][p]),
                n = {
                    ...u,
                    [p]: i
                };
            gn(B, u = n, u);
            const r = oa(O(n, p), m, g);
            v(), w(r), S(r)
        };
    qn((() => {
        _()
    }));
    return e.$$set = e => {
        "labelReset" in e && o(1, h = e.labelReset), "direction" in e && o(18, p = e.direction), "min" in e && o(19, m = e.min), "max" in e && o(20, g = e.max), "base" in e && o(2, f = e.base), "value" in e && o(0, $ = e.value), "valueLabel" in e && o(3, y = e.valueLabel), "valueMin" in e && o(21, x = e.valueMin), "valueMax" in e && o(22, b = e.valueMax), "oninputstart" in e && o(23, v = e.oninputstart), "oninputmove" in e && o(24, w = e.oninputmove), "oninputend" in e && o(25, S = e.oninputend), "elasticity" in e && o(26, C = e.elasticity)
    }, e.$$.update = () => {
        if (1572864 & e.$$.dirty[0] && o(28, i = g - m), 2621440 & e.$$.dirty[0] && o(29, r = null != x ? Math.max(x, m) : m), 5242880 & e.$$.dirty[0] && o(30, a = null != b ? Math.min(b, g) : g), 1572868 & e.$$.dirty[0] && o(31, l = yd(f, m, g)), 16 & e.$$.dirty[0] | 1 & e.$$.dirty[1] && M) {
            const e = .5 * M.y;
            let t, i = 40 * l,
                n = "",
                r = M.y,
                a = "";
            for (let o = 0; o <= 40; o++) {
                const r = P.x + 10 * o,
                    s = e;
                n += A(r, s, o % 5 == 0 ? 2 : .75) + " ", t = r + P.x, o === i && (a = `<path d="M${r} ${s-4} l2 3 l-2 -1 l-2 1 z"/>`)
            }
            o(6, T = `<svg width="${t}" height="${r}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${t} ${r}" aria-hidden="true" focusable="false">\n        ${a}\n        <rect rx="4" ry="4" y="${e-4}"" height="8"/>\n        <path fill-rule="evenodd" d="${n.trim()}"/></svg>`), o(27, R = {
                x: t - 2 * P.x,
                y: r
            })
        }
        134217744 & e.$$.dirty[0] && (s = M && R), 1612185600 & e.$$.dirty[0] && o(5, c = r !== m || a !== g), 1610612768 & e.$$.dirty[0] && o(7, d = c ? function (e, t) {
            const o = 1 / 40,
                i = yd(e, m, g),
                n = yd(t, m, g);
            return `--range-mask-from:${100*Io(k(i,o,0)-.0125)}%;--range-mask-to:${100*Io(k(n,o,0)-.0125)}%`
        }(r, a) : ""), 268697617 & e.$$.dirty[0] && i && M && M.x && M.y && B.set(D($, p))
    }, [$, h, f, y, M, c, T, d, u, P, () => {
        L = !1, E = ln(B), I = [D(null != x ? x : m, p), D(null != b ? b : g, p)], v()
    }, () => {
        L = !0
    }, ({
        detail: e
    }) => {
        F.snap = !L, F.elastic = !L, z(E, e.translation, F)
    }, ({
        detail: e
    }) => {
        F.snap = !1, F.elastic = !1;
        const t = z(E, e.translation, F);
        if (E = void 0, I = void 0, Math.abs(t - f) < .01) return S(f);
        S(t)
    }, () => {
        o(0, $ = oa(f, r, a)), v(), S($)
    }, B, e => {
        e.preventDefault(), e.stopPropagation();
        const t = 8 * Yl(e);
        W(t)
    }, ({
        detail: e
    }) => {
        W(8 * e[p])
    }, p, m, g, x, b, v, w, S, C, R, i, r, a, l, e => o(4, M = (e => Y(e.width, e.height))(e.detail))]
}
class dm extends Fr {
    constructor(e) {
        super(), Lr(this, e, cm, lm, an, {
            labelReset: 1,
            direction: 18,
            min: 19,
            max: 20,
            base: 2,
            value: 0,
            valueLabel: 3,
            valueMin: 21,
            valueMax: 22,
            oninputstart: 23,
            oninputmove: 24,
            oninputend: 25,
            elasticity: 26
        }, [-1, -1])
    }
}

function um(e) {
    let t, o, i, n, r;
    const a = e[7].default,
        s = dn(a, e, e[6], null);
    return {
        c() {
            t = Mn("div"), o = Mn("div"), s && s.c(), Fn(o, "class", "PinturaToolbarInner"), Fn(t, "class", "PinturaToolbar"), Fn(t, "data-layout", e[1]), Fn(t, "data-overflow", e[0])
        },
        m(a, l) {
            Cn(a, t, l), Sn(t, o), s && s.m(o, null), i = !0, n || (r = [In(o, "measure", e[3]), fn($s.call(null, o)), In(t, "measure", e[2]), fn($s.call(null, t))], n = !0)
        },
        p(e, [o]) {
            s && s.p && 64 & o && hn(s, a, e, e[6], o, null, null), (!i || 2 & o) && Fn(t, "data-layout", e[1]), (!i || 1 & o) && Fn(t, "data-overflow", e[0])
        },
        i(e) {
            i || (yr(s, e), i = !0)
        },
        o(e) {
            xr(s, e), i = !1
        },
        d(e) {
            e && kn(t), s && s.d(e), n = !1, nn(r)
        }
    }
}

function hm(e, t, o) {
    let i, n, {
            $$slots: r = {},
            $$scope: a
        } = t,
        s = 0,
        l = 0,
        c = 0;
    const d = () => {
        o(0, n = "compact" === i && s > c ? "overflow" : void 0)
    };
    return e.$$set = e => {
        "$$scope" in e && o(6, a = e.$$scope)
    }, e.$$.update = () => {
        48 & e.$$.dirty && o(1, i = l > c ? "compact" : "default")
    }, [n, i, ({
        detail: e
    }) => {
        const {
            width: t
        } = e;
        o(5, c = t), d()
    }, ({
        detail: e
    }) => {
        const {
            width: t
        } = e;
        t > l && o(4, l = t), s = t, n || d()
    }, l, c, a, r]
}
class pm extends Fr {
    constructor(e) {
        super(), Lr(this, e, hm, um, an, {})
    }
}
const mm = {
        Top: "t",
        Right: "r",
        Bottom: "b",
        Left: "l",
        TopLeft: "tl",
        TopRight: "tr",
        BottomRight: "br",
        BottomLeft: "bl"
    },
    {
        Top: gm,
        Right: fm,
        Bottom: $m,
        Left: ym,
        TopLeft: xm,
        TopRight: bm,
        BottomRight: vm,
        BottomLeft: wm
    } = mm;
var Sm = {
    [gm]: e => ({
        x: e.x,
        y: e.y
    }),
    [bm]: e => ({
        x: e.x + e.width,
        y: e.y
    }),
    [fm]: e => ({
        x: e.x + e.width,
        y: e.y
    }),
    [vm]: e => ({
        x: e.x + e.width,
        y: e.y + e.height
    }),
    [$m]: e => ({
        x: e.x,
        y: e.y + e.height
    }),
    [wm]: e => ({
        x: e.x,
        y: e.y + e.height
    }),
    [ym]: e => ({
        x: e.x,
        y: e.y
    }),
    [xm]: e => ({
        x: e.x,
        y: e.y
    })
};

function Cm(e, t, o) {
    const i = e.slice();
    return i[12] = t[o].key, i[13] = t[o].translate, i[14] = t[o].scale, i[15] = t[o].type, i[16] = t[o].opacity, i
}

function km(e, t) {
    let o, i, n, r, a, s, l, c;
    return {
        key: e,
        first: null,
        c() {
            o = Mn("div"), Fn(o, "role", "button"), Fn(o, "aria-label", i = `Drag ${t[15]} ${t[12]}`), Fn(o, "tabindex", n = "edge" === t[15] ? -1 : 0), Fn(o, "class", "PinturaRectManipulator"), Fn(o, "data-direction", r = t[12]), Fn(o, "data-shape", a = "" + ("edge" === t[15] ? "edge" : "" + t[0])), Fn(o, "style", s = `transform: translate3d(${t[13].x}px, ${t[13].y}px, 0) scale(${t[14].x}, ${t[14].y}); opacity: ${t[16]}`), this.first = o
        },
        m(e, i) {
            Cn(e, o, i), l || (c = [In(o, "nudge", (function () {
                rn(t[5](t[12])) && t[5](t[12]).apply(this, arguments)
            })), fn(Nl.call(null, o)), In(o, "interactionstart", (function () {
                rn(t[4]("resizestart", t[12])) && t[4]("resizestart", t[12]).apply(this, arguments)
            })), In(o, "interactionupdate", (function () {
                rn(t[4]("resizemove", t[12])) && t[4]("resizemove", t[12]).apply(this, arguments)
            })), In(o, "interactionend", (function () {
                rn(t[4]("resizeend", t[12])) && t[4]("resizeend", t[12]).apply(this, arguments)
            })), fn(Hl.call(null, o))], l = !0)
        },
        p(e, l) {
            t = e, 2 & l && i !== (i = `Drag ${t[15]} ${t[12]}`) && Fn(o, "aria-label", i), 2 & l && n !== (n = "edge" === t[15] ? -1 : 0) && Fn(o, "tabindex", n), 2 & l && r !== (r = t[12]) && Fn(o, "data-direction", r), 3 & l && a !== (a = "" + ("edge" === t[15] ? "edge" : "" + t[0])) && Fn(o, "data-shape", a), 2 & l && s !== (s = `transform: translate3d(${t[13].x}px, ${t[13].y}px, 0) scale(${t[14].x}, ${t[14].y}); opacity: ${t[16]}`) && Fn(o, "style", s)
        },
        d(e) {
            e && kn(o), l = !1, nn(c)
        }
    }
}

function Mm(e) {
    let t, o = [],
        i = new Map,
        n = e[1];
    const r = e => e[12];
    for (let t = 0; t < n.length; t += 1) {
        let a = Cm(e, n, t),
            s = r(a);
        i.set(s, o[t] = km(s, a))
    }
    return {
        c() {
            for (let e = 0; e < o.length; e += 1) o[e].c();
            t = An()
        },
        m(e, i) {
            for (let t = 0; t < o.length; t += 1) o[t].m(e, i);
            Cn(e, t, i)
        },
        p(e, [a]) {
            51 & a && (n = e[1], o = kr(o, a, r, 1, e, n, i, t.parentNode, Sr, km, t, Cm))
        },
        i: Ji,
        o: Ji,
        d(e) {
            for (let t = 0; t < o.length; t += 1) o[t].d(e);
            e && kn(t)
        }
    }
}

function Tm(e, t, o) {
    let i, n, r, {
            rect: a = null
        } = t,
        {
            visible: s = !1
        } = t,
        {
            style: l
        } = t;
    const c = rs(void 0, {
        precision: 1e-4,
        stiffness: .2,
        damping: .4
    });
    cn(e, c, (e => o(8, n = e)));
    const d = rs(0, {
        precision: .001
    });
    let u;
    cn(e, d, (e => o(9, r = e)));
    const h = Zn();
    return e.$$set = e => {
        "rect" in e && o(6, a = e.rect), "visible" in e && o(7, s = e.visible), "style" in e && o(0, l = e.style)
    }, e.$$.update = () => {
        128 & e.$$.dirty && c.set(s ? 1 : .5), 128 & e.$$.dirty && d.set(s ? 1 : 0), 832 & e.$$.dirty && o(1, i = Object.keys(mm).map(((e, t) => {
            const o = mm[e],
                i = Sm[o](a),
                s = 1 === o.length ? "edge" : "corner",
                l = "corner" === s;
            return {
                key: o,
                type: s,
                scale: {
                    x: /^(t|b)$/.test(o) ? a.width : l ? oa(n, .5, 1.25) : 1,
                    y: /^(r|l)$/.test(o) ? a.height : l ? oa(n, .5, 1.25) : 1
                },
                translate: {
                    x: i.x,
                    y: i.y
                },
                opacity: r
            }
        })))
    }, [l, i, c, d, (e, t) => ({
        detail: o
    }) => {
        u && t !== u || "resizestart" !== e && void 0 === u || ("resizestart" === e && (u = t), "resizeend" === e && (u = void 0), h(e, {
            direction: t,
            translation: o && o.translation
        }))
    }, e => ({
        detail: t
    }) => {
        h("resizestart", {
            direction: e,
            translation: {
                x: 0,
                y: 0
            }
        }), h("resizemove", {
            direction: e,
            translation: t
        }), h("resizeend", {
            direction: e,
            translation: {
                x: 0,
                y: 0
            }
        })
    }, a, s, n, r]
}
class Rm extends Fr {
    constructor(e) {
        super(), Lr(this, e, Tm, Mm, an, {
            rect: 6,
            visible: 7,
            style: 0
        })
    }
}
var Pm = e => {
        function t(t, o) {
            e.dispatchEvent(new CustomEvent(t, {
                detail: o
            }))
        }
        const o = o => {
                o.preventDefault(), e.addEventListener("gesturechange", i), e.addEventListener("gestureend", n), t("gesturedown")
            },
            i = e => {
                e.preventDefault(), t("gestureupdate", e.scale)
            },
            n = e => {
                t("gestureup", e.scale), e.preventDefault(), r()
            },
            r = () => {
                e.removeEventListener("gesturechange", i), e.removeEventListener("gestureend", n)
            };
        return e.addEventListener("gesturestart", o), {
            destroy: () => {
                r(), e.removeEventListener("gesturestart", o)
            }
        }
    },
    Am = e => Y(e.clientX, e.clientY),
    Im = {
        [gm]: $m,
        [fm]: ym,
        [$m]: gm,
        [ym]: fm,
        [xm]: vm,
        [bm]: wm,
        [vm]: xm,
        [wm]: bm
    },
    Em = {
        [gm]: [.5, 0],
        [fm]: [1, .5],
        [$m]: [.5, 1],
        [ym]: [0, .5],
        [xm]: [0, 0],
        [bm]: [1, 0],
        [vm]: [1, 1],
        [wm]: [0, 1]
    },
    Lm = e => {
        const t = e === ym || e === fm,
            o = e === gm || e === $m;
        return [e === fm || e === bm || e === vm, e === ym || e === wm || e === xm, e === gm || e === bm || e === xm, e === $m || e === vm || e === wm, t, o, t || o]
    };
const Fm = (e, t, o, i) => {
    const {
        aspectRatio: n,
        minSize: r,
        maxSize: a
    } = i, s = t === fm || t === bm || t === vm, l = t === ym || t === wm || t === xm, c = t === gm || t === bm || t === xm, d = t === $m || t === vm || t === wm, u = t === ym || t === fm, h = t === gm || t === $m, p = Ee(o);
    s ? (p.x = e.x, p.width -= e.x) : l && (p.width = e.x), d ? (p.y = e.y, p.height -= e.y) : c && (p.height = e.y);
    const m = ((e, t) => Ie(0, 0, e, t))(Math.min(p.width, a.width), Math.min(p.height, a.height));
    if (n)
        if (u) {
            const t = Math.min(e.y, o.height - e.y);
            m.height = Math.min(2 * t, m.height)
        } else if (h) {
        const t = Math.min(e.x, o.width - e.x);
        m.width = Math.min(2 * t, m.width)
    }
    const g = n ? $e(Qe(m, n)) : m,
        f = n ? $e(Je(Fe(r), n)) : r;
    let $, y, x, b;
    s ? $ = e.x : l && (y = e.x), d ? x = e.y : c && (b = e.y), s ? y = $ + f.width : l && ($ = y - f.width), d ? b = x + f.height : c && (x = b - f.height), u ? (x = e.y - .5 * f.height, b = e.y + .5 * f.height) : h && ($ = e.x - .5 * f.width, y = e.x + .5 * f.width);
    const v = Be([Y($, x), Y(y, b)]);
    s ? y = $ + g.width : l && ($ = y - g.width), d ? b = x + g.height : c && (x = b - g.height), u ? (x = e.y - .5 * g.height, b = e.y + .5 * g.height) : h && ($ = e.x - .5 * g.width, y = e.x + .5 * g.width);
    return {
        inner: v,
        outer: Be([Y($, x), Y(y, b)])
    }
};
var zm = (e, t, o = {}) => {
        const {
            target: i,
            translate: n
        } = t, {
            aspectRatio: r
        } = o, a = Em[Im[i]], s = ne(Ee(e), Y(a[0] * e.width, a[1] * e.height)), l = Em[i], c = ne(Ee(e), Y(l[0] * e.width, l[1] * e.height)), [d, u, h, p, m, g, f] = Lm(i);
        let $ = n.x,
            y = n.y;
        m ? y = 0 : g && ($ = 0);
        let [x, b, v, w] = et(e);
        if (d ? w = s.x : u && (b = s.x), p ? x = s.y : h && (v = s.y), d ? b = c.x + $ : u && (w = c.x + $), p ? v = c.y + y : h && (x = c.y + y), r)
            if (f) {
                let e = b - w,
                    t = v - x;
                m ? (t = e / r, x = s.y - .5 * t, v = s.y + .5 * t) : g && (e = t * r, w = s.x - .5 * e, b = s.x + .5 * e)
            } else {
                const e = Y(c.x + $ - s.x, c.y + y - s.y);
                i === bm ? (e.x = Math.max(0, e.x), e.y = Math.min(0, e.y)) : i === vm ? (e.x = Math.max(0, e.x), e.y = Math.max(0, e.y)) : i === wm ? (e.x = Math.min(0, e.x), e.y = Math.max(0, e.y)) : i === xm && (e.x = Math.min(0, e.x), e.y = Math.min(0, e.y));
                const t = Q(e),
                    o = Y(r, 1),
                    n = ae(ee(o), t);
                i === bm ? (b = s.x + n.x, x = s.y - n.y) : i === vm ? (b = s.x + n.x, v = s.y + n.y) : i === wm ? (w = s.x - n.x, v = s.y + n.y) : i === xm && (w = s.x - n.x, x = s.y - n.y)
            } return _e(w, x, b - w, v - x)
    },
    Bm = e => 180 * e / Math.PI;

function Dm(e) {
    let t, o, i;
    return o = new dm({
        props: {
            elasticity: e[5],
            min: e[7],
            max: e[8],
            value: e[12],
            valueMin: e[0],
            valueMax: e[1],
            labelReset: e[6],
            base: e[11],
            valueLabel: Math.round(Bm(e[12])) + "°",
            oninputstart: e[2],
            oninputmove: e[14],
            oninputend: e[15]
        }
    }), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), Fn(t, "class", "PinturaImageRotator")
        },
        m(e, n) {
            Cn(e, t, n), Ar(o, t, null), i = !0
        },
        p(e, [t]) {
            const i = {};
            32 & t && (i.elasticity = e[5]), 128 & t && (i.min = e[7]), 256 & t && (i.max = e[8]), 4096 & t && (i.value = e[12]), 1 & t && (i.valueMin = e[0]), 2 & t && (i.valueMax = e[1]), 64 & t && (i.labelReset = e[6]), 2048 & t && (i.base = e[11]), 4096 & t && (i.valueLabel = Math.round(Bm(e[12])) + "°"), 4 & t && (i.oninputstart = e[2]), 1544 & t && (i.oninputmove = e[14]), 1552 & t && (i.oninputend = e[15]), o.$set(i)
        },
        i(e) {
            i || (yr(o.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), i = !1
        },
        d(e) {
            e && kn(t), Ir(o)
        }
    }
}

function Om(e, t, o) {
    let i, r, a, s, l, c;
    const d = Math.PI / 2,
        u = Math.PI / 4;
    let {
        rotation: h
    } = t, {
        valueMin: p
    } = t, {
        valueMax: m
    } = t, {
        oninputstart: g = n
    } = t, {
        oninputmove: f = n
    } = t, {
        oninputend: $ = n
    } = t, {
        elasticity: y = 0
    } = t, {
        labelReset: x
    } = t;
    return e.$$set = e => {
        "rotation" in e && o(13, h = e.rotation), "valueMin" in e && o(0, p = e.valueMin), "valueMax" in e && o(1, m = e.valueMax), "oninputstart" in e && o(2, g = e.oninputstart), "oninputmove" in e && o(3, f = e.oninputmove), "oninputend" in e && o(4, $ = e.oninputend), "elasticity" in e && o(5, y = e.elasticity), "labelReset" in e && o(6, x = e.labelReset)
    }, e.$$.update = () => {
        384 & e.$$.dirty && o(11, a = i + .5 * (r - i)), 8192 & e.$$.dirty && o(9, s = Math.sign(h)), 8192 & e.$$.dirty && o(10, l = Math.round(Math.abs(h) / d) * d), 9728 & e.$$.dirty && o(12, c = h - s * l)
    }, o(7, i = 1e-9 - u), o(8, r = u - 1e-9), [p, m, g, f, $, y, x, i, r, s, l, a, c, h, e => f(s * l + e), e => $(s * l + e)]
}
class _m extends Fr {
    constructor(e) {
        super(), Lr(this, e, Om, Dm, an, {
            rotation: 13,
            valueMin: 0,
            valueMax: 1,
            oninputstart: 2,
            oninputmove: 3,
            oninputend: 4,
            elasticity: 5,
            labelReset: 6
        })
    }
}

function Wm(e) {
    let t, o, i, n, r;
    return {
        c() {
            t = Mn("div"), o = Mn("p"), i = Rn(e[0]), n = Rn(" × "), r = Rn(e[1]), Fn(t, "class", "PinturaImageInfo")
        },
        m(e, a) {
            Cn(e, t, a), Sn(t, o), Sn(o, i), Sn(o, n), Sn(o, r)
        },
        p(e, [t]) {
            1 & t && Bn(i, e[0]), 2 & t && Bn(r, e[1])
        },
        i: Ji,
        o: Ji,
        d(e) {
            e && kn(t)
        }
    }
}

function Vm(e, t, o) {
    let {
        width: i
    } = t, {
        height: n
    } = t;
    return e.$$set = e => {
        "width" in e && o(0, i = e.width), "height" in e && o(1, n = e.height)
    }, [i, n]
}
class Hm extends Fr {
    constructor(e) {
        super(), Lr(this, e, Vm, Wm, an, {
            width: 0,
            height: 1
        })
    }
}

function Nm(e) {
    let t, o;
    return t = new Vd({
        props: {
            items: e[0]
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            1 & o[0] && (i.items = e[0]), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Um(e) {
    let t, o, i;
    return o = new pm({
        props: {
            $$slots: {
                default: [Nm]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), Fn(t, "slot", "header")
        },
        m(e, n) {
            Cn(e, t, n), Ar(o, t, null), i = !0
        },
        p(e, t) {
            const i = {};
            1 & t[0] | 128 & t[6] && (i.$$scope = {
                dirty: t,
                ctx: e
            }), o.$set(i)
        },
        i(e) {
            i || (yr(o.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), i = !1
        },
        d(e) {
            e && kn(t), Ir(o)
        }
    }
}

function jm(e) {
    let t, o;
    return t = new Wl({
        props: {
            onclick: e[80],
            label: e[4].cropLabelButtonRecenter,
            icon: e[4].cropIconButtonRecenter,
            class: "PinturaButtonCenter",
            disabled: !e[10],
            hideLabel: !0,
            style: `opacity: ${e[27]}; transform: translate3d(${e[28].x}px, ${e[28].y}px, 0)`
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            16 & o[0] && (i.label = e[4].cropLabelButtonRecenter), 16 & o[0] && (i.icon = e[4].cropIconButtonRecenter), 1024 & o[0] && (i.disabled = !e[10]), 402653184 & o[0] && (i.style = `opacity: ${e[27]}; transform: translate3d(${e[28].x}px, ${e[28].y}px, 0)`), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Xm(e) {
    let t, o;
    return t = new Rm({
        props: {
            rect: e[11],
            visible: e[9],
            style: e[2]
        }
    }), t.$on("resizestart", e[60]), t.$on("resizemove", e[61]), t.$on("resizeend", e[62]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            2048 & o[0] && (i.rect = e[11]), 512 & o[0] && (i.visible = e[9]), 4 & o[0] && (i.style = e[2]), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Ym(e) {
    let t, o;
    return t = new Hm({
        props: {
            width: Math.round(e[7].width),
            height: Math.round(e[7].height)
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            128 & o[0] && (i.width = Math.round(e[7].width)), 128 & o[0] && (i.height = Math.round(e[7].height)), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Gm(e) {
    let t, o, i, n, r, a, s, l, c = e[17] && e[18] && jm(e),
        d = e[17] && Xm(e),
        u = e[16] && Ym(e);
    return {
        c() {
            t = Mn("div"), o = Mn("div"), c && c.c(), i = Pn(), d && d.c(), r = Pn(), u && u.c(), Fn(o, "class", "PinturaStage"), Fn(t, "slot", "main")
        },
        m(h, p) {
            Cn(h, t, p), Sn(t, o), c && c.m(o, null), Sn(o, i), d && d.m(o, null), e[146](o), Sn(t, r), u && u.m(t, null), a = !0, s || (l = [In(o, "measure", e[144]), fn($s.call(null, o)), In(o, "wheel", (function () {
                rn(e[3] && e[79]) && (e[3] && e[79]).apply(this, arguments)
            }), {
                passive: !1
            }), In(o, "interactionstart", e[66]), In(o, "interactionupdate", e[67]), In(o, "interactionrelease", e[69]), In(o, "interactionend", e[68]), fn(n = Hl.call(null, o, {
                drag: !0,
                pinch: e[3],
                inertia: !0,
                matchTarget: !0,
                getEventPosition: e[147]
            })), In(o, "gesturedown", e[76]), In(o, "gestureupdate", e[77]), In(o, "gestureup", e[78]), fn(Pm.call(null, o))], s = !0)
        },
        p(r, a) {
            (e = r)[17] && e[18] ? c ? (c.p(e, a), 393216 & a[0] && yr(c, 1)) : (c = jm(e), c.c(), yr(c, 1), c.m(o, i)) : c && (fr(), xr(c, 1, 1, (() => {
                c = null
            })), $r()), e[17] ? d ? (d.p(e, a), 131072 & a[0] && yr(d, 1)) : (d = Xm(e), d.c(), yr(d, 1), d.m(o, null)) : d && (fr(), xr(d, 1, 1, (() => {
                d = null
            })), $r()), n && rn(n.update) && 32776 & a[0] && n.update.call(null, {
                drag: !0,
                pinch: e[3],
                inertia: !0,
                matchTarget: !0,
                getEventPosition: e[147]
            }), e[16] ? u ? (u.p(e, a), 65536 & a[0] && yr(u, 1)) : (u = Ym(e), u.c(), yr(u, 1), u.m(t, null)) : u && (fr(), xr(u, 1, 1, (() => {
                u = null
            })), $r())
        },
        i(e) {
            a || (yr(c), yr(d), yr(u), a = !0)
        },
        o(e) {
            xr(c), xr(d), xr(u), a = !1
        },
        d(o) {
            o && kn(t), c && c.d(), d && d.d(), e[146](null), u && u.d(), s = !1, nn(l)
        }
    }
}

function qm(e) {
    let t, o, i, n;
    const r = [{
        class: "PinturaControlList"
    }, {
        tabs: e[12]
    }, e[21]];
    let a = {
        $$slots: {
            default: [Zm, ({
                tab: e
            }) => ({
                192: e
            }), ({
                tab: e
            }) => [0, 0, 0, 0, 0, 0, e ? 64 : 0]]
        },
        $$scope: {
            ctx: e
        }
    };
    for (let e = 0; e < r.length; e += 1) a = en(a, r[e]);
    t = new ml({
        props: a
    }), t.$on("select", e[145]);
    const s = [{
        class: "PinturaControlPanels"
    }, {
        panelClass: "PinturaControlPanel"
    }, {
        panels: e[22]
    }, e[21]];
    let l = {
        $$slots: {
            default: [Qm, ({
                panel: e
            }) => ({
                191: e
            }), ({
                panel: e
            }) => [0, 0, 0, 0, 0, 0, e ? 32 : 0]]
        },
        $$scope: {
            ctx: e
        }
    };
    for (let e = 0; e < s.length; e += 1) l = en(l, s[e]);
    return i = new Ml({
        props: l
    }), {
        c() {
            Pr(t.$$.fragment), o = Pn(), Pr(i.$$.fragment)
        },
        m(e, r) {
            Ar(t, e, r), Cn(e, o, r), Ar(i, e, r), n = !0
        },
        p(e, o) {
            const n = 2101248 & o[0] ? Mr(r, [r[0], 4096 & o[0] && {
                tabs: e[12]
            }, 2097152 & o[0] && Tr(e[21])]) : {};
            192 & o[6] && (n.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(n);
            const a = 6291456 & o[0] ? Mr(s, [s[0], s[1], 4194304 & o[0] && {
                panels: e[22]
            }, 2097152 & o[0] && Tr(e[21])]) : {};
            117457168 & o[0] | 160 & o[6] && (a.$$scope = {
                dirty: o,
                ctx: e
            }), i.$set(a)
        },
        i(e) {
            n || (yr(t.$$.fragment, e), yr(i.$$.fragment, e), n = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), xr(i.$$.fragment, e), n = !1
        },
        d(e) {
            Ir(t, e), e && kn(o), Ir(i, e)
        }
    }
}

function Zm(e) {
    let t, o, i = e[192].label + "";
    return {
        c() {
            t = Mn("span"), o = Rn(i)
        },
        m(e, i) {
            Cn(e, t, i), Sn(t, o)
        },
        p(e, t) {
            64 & t[6] && i !== (i = e[192].label + "") && Bn(o, i)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function Km(e) {
    let t, o;
    return t = new dm({
        props: {
            elasticity: e[35] * e[36],
            base: ig,
            min: e[14],
            max: og,
            valueMin: e[25][0],
            valueMax: e[25][1],
            value: e[26],
            labelReset: e[4].labelReset,
            valueLabel: Math.round(100 * e[26]) + "%",
            oninputstart: e[73],
            oninputmove: e[74],
            oninputend: e[75]
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            16384 & o[0] && (i.min = e[14]), 33554432 & o[0] && (i.valueMin = e[25][0]), 33554432 & o[0] && (i.valueMax = e[25][1]), 67108864 & o[0] && (i.value = e[26]), 16 & o[0] && (i.labelReset = e[4].labelReset), 67108864 & o[0] && (i.valueLabel = Math.round(100 * e[26]) + "%"), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Jm(e) {
    let t, o;
    return t = new _m({
        props: {
            elasticity: e[35] * e[36],
            rotation: e[8],
            labelReset: e[4].labelReset,
            valueMin: e[24][0],
            valueMax: e[24][1],
            oninputstart: e[63],
            oninputmove: e[64],
            oninputend: e[65]
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            256 & o[0] && (i.rotation = e[8]), 16 & o[0] && (i.labelReset = e[4].labelReset), 16777216 & o[0] && (i.valueMin = e[24][0]), 16777216 & o[0] && (i.valueMax = e[24][1]), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Qm(e) {
    let t, o, i, n;
    const r = [Jm, Km],
        a = [];

    function s(e, t) {
        return e[191] === e[85] + "-rotation" ? 0 : e[191] === e[85] + "-zoom" ? 1 : -1
    }
    return ~(t = s(e)) && (o = a[t] = r[t](e)), {
        c() {
            o && o.c(), i = An()
        },
        m(e, o) {
            ~t && a[t].m(e, o), Cn(e, i, o), n = !0
        },
        p(e, n) {
            let l = t;
            t = s(e), t === l ? ~t && a[t].p(e, n) : (o && (fr(), xr(a[l], 1, 1, (() => {
                a[l] = null
            })), $r()), ~t ? (o = a[t], o ? o.p(e, n) : (o = a[t] = r[t](e), o.c()), yr(o, 1), o.m(i.parentNode, i)) : o = null)
        },
        i(e) {
            n || (yr(o), n = !0)
        },
        o(e) {
            xr(o), n = !1
        },
        d(e) {
            ~t && a[t].d(e), e && kn(i)
        }
    }
}

function eg(e) {
    let t, o, i = e[20] && qm(e);
    return {
        c() {
            t = Mn("div"), i && i.c(), Fn(t, "slot", "footer"), Fn(t, "style", e[23])
        },
        m(e, n) {
            Cn(e, t, n), i && i.m(t, null), o = !0
        },
        p(e, n) {
            e[20] ? i ? (i.p(e, n), 1048576 & n[0] && yr(i, 1)) : (i = qm(e), i.c(), yr(i, 1), i.m(t, null)) : i && (fr(), xr(i, 1, 1, (() => {
                i = null
            })), $r()), (!o || 8388608 & n[0]) && Fn(t, "style", e[23])
        },
        i(e) {
            o || (yr(i), o = !0)
        },
        o(e) {
            xr(i), o = !1
        },
        d(e) {
            e && kn(t), i && i.d()
        }
    }
}

function tg(e) {
    let t, o, i;

    function n(t) {
        e[148](t)
    }
    let r = {
        hasHeader: e[19],
        $$slots: {
            footer: [eg],
            main: [Gm],
            header: [Um]
        },
        $$scope: {
            ctx: e
        }
    };
    return void 0 !== e[13] && (r.root = e[13]), t = new am({
        props: r
    }), tr.push((() => Rr(t, "root", n))), t.$on("measure", e[149]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, o) {
            Ar(t, e, o), i = !0
        },
        p(e, i) {
            const n = {};
            524288 & i[0] && (n.hasHeader = e[19]), 536338429 & i[0] | 128 & i[6] && (n.$$scope = {
                dirty: i,
                ctx: e
            }), !o && 8192 & i[0] && (o = !0, n.root = e[13], sr((() => o = !1))), t.$set(n)
        },
        i(e) {
            i || (yr(t.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), i = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}
const og = 1,
    ig = 0;

function ng(e, t, o) {
    let i, n, r, a, s, l, c, d, u, h, p, m, g, f, $, y, x, b, v, w, S, C, k, M, R, P, A, I, E, L, F, z, B, D, W, H, U, j, X, G, q, J, te, ie, se, le, ce, de, ue, he, pe, me, fe, xe, ve, Te, Re, Pe, Ae, Ie, Le, ze, Be, De = Ji,
        Ne = () => (De(), De = sn(Ye, (e => o(9, U = e))), Ye);
    e.$$.on_destroy.push((() => De()));
    let {
        isActive: Ye
    } = t;
    Ne();
    let {
        stores: Ge
    } = t, {
        cropImageSelectionCornerStyle: qe = "circle"
    } = t, {
        cropWillRenderImageSelectionGuides: tt = ((e, t) => {
            const o = "rotate" == e;
            return {
                rows: o ? 5 : 3,
                cols: o ? 5 : 3,
                opacity: .25 * t
            }
        })
    } = t, {
        cropAutoCenterImageSelectionTimeout: it
    } = t, {
        cropEnableZoomMatchImageAspectRatio: nt = !0
    } = t, {
        cropEnableRotateMatchImageAspectRatio: rt = "never"
    } = t, {
        cropEnableRotationInput: at = !0
    } = t, {
        cropEnableZoom: st = !0
    } = t, {
        cropEnableZoomInput: lt = !0
    } = t, {
        cropEnableZoomAutoHide: ct = !0
    } = t, {
        cropEnableImageSelection: dt = !0
    } = t, {
        cropEnableInfoIndicator: ut = !1
    } = t, {
        cropEnableZoomTowardsWheelPosition: ht = !0
    } = t, {
        cropEnableLimitWheelInputToCropSelection: pt = !0
    } = t, {
        cropEnableCenterImageSelection: mt = !0
    } = t, {
        cropEnableButtonRotateLeft: gt = !0
    } = t, {
        cropEnableButtonRotateRight: ft = !1
    } = t, {
        cropEnableButtonFlipHorizontal: $t = !0
    } = t, {
        cropEnableButtonFlipVertical: yt = !1
    } = t, {
        cropSelectPresetOptions: xt
    } = t, {
        cropEnableSelectPreset: bt = !0
    } = t, {
        cropEnableButtonToggleCropLimit: vt = !1
    } = t, {
        cropWillRenderTools: wt = _
    } = t, {
        cropActiveTransformTool: St = "rotation"
    } = t, {
        locale: Ct = {}
    } = t, {
        tools: kt = []
    } = t, Mt = "idle";
    const Tt = () => void 0 === P,
        Rt = (e, t, o) => N(o) ? t.width === Math.round(e.height) || t.height === Math.round(e.width) : t.width === Math.round(e.width) || t.height === Math.round(e.height),
        Pt = () => (Tt() || "always" === rt && (() => {
            if (1 === P) return !1;
            const e = 1 / P;
            return !!xt && !!Pc(xt).find((([t]) => t === e))
        })()) && ((e, t, o) => {
            const i = Me(Ce(ge(t), o), (e => Math.abs(Math.round(e)))),
                n = Se(i),
                r = We(e);
            return oe(n, r)
        })(A, I, E) && Rt(A, I, E),
        At = e => {
            if ("never" !== rt && Pt()) {
                gn(Yt, E += e, E);
                const t = N(E),
                    o = t ? I.height : I.width,
                    i = t ? I.width : I.height;
                gn(io, A = _e(0, 0, o, i), A), Tt() || gn(so, P = O(o, i), P)
            } else gn(Yt, E += e, E)
        },
        {
            history: It,
            env: Et,
            isInteracting: Lt,
            isInteractingFraction: Ft,
            rootRect: zt,
            stageRect: Bt,
            utilRect: Dt,
            rootLineColor: Ot,
            animation: _t,
            elasticityMultiplier: Wt,
            rangeInputElasticity: Vt,
            presentationScalar: Ht,
            imagePreviewModifiers: Nt,
            imageOutlineOpacity: Ut,
            imageFlipX: jt,
            imageFlipY: Xt,
            imageRotation: Yt,
            imageRotationRange: Gt,
            imageOutputSize: qt,
            imageSelectionRect: Zt,
            imageSelectionRectSnapshot: Kt,
            imageSelectionRectIntent: Jt,
            imageSelectionRectPresentation: eo,
            imageCropRectIntent: to,
            imageCropRectOrigin: oo,
            imageCropRect: io,
            imageCropMinSize: no,
            imageCropMaxSize: ro,
            imageCropRange: ao,
            imageCropAspectRatio: so,
            imageCropRectAspectRatio: lo,
            imageCropLimitToImage: co,
            imageSize: uo,
            imageScalar: ho,
            imageOverlayMarkup: po,
            framePadded: mo
        } = Ge;
    let go, fo, $o;
    cn(e, Et, (e => o(119, H = e))), cn(e, Lt, (e => o(120, j = e))), cn(e, zt, (e => o(15, de = e))), cn(e, Bt, (e => o(125, ue = e))), cn(e, Dt, (e => o(124, ie = e))), cn(e, _t, (e => o(142, Re = e))), cn(e, Ht, (e => o(123, q = e))), cn(e, Nt, (e => o(137, xe = e))), cn(e, jt, (e => o(113, F = e))), cn(e, Xt, (e => o(112, L = e))), cn(e, Yt, (e => o(8, E = e))), cn(e, Gt, (e => o(24, Ae = e))), cn(e, qt, (e => o(160, B = e))), cn(e, Zt, (e => o(122, G = e))), cn(e, Kt, (e => o(121, X = e))), cn(e, Jt, (e => o(162, te = e))), cn(e, eo, (e => o(128, pe = e))), cn(e, to, (e => o(164, le = e))), cn(e, oo, (e => o(163, se = e))), cn(e, io, (e => o(7, A = e))), cn(e, no, (e => o(117, D = e))), cn(e, ro, (e => o(161, J = e))), cn(e, ao, (e => o(165, ce = e))), cn(e, so, (e => o(159, P = e))), cn(e, co, (e => o(118, W = e))), cn(e, uo, (e => o(111, I = e))), cn(e, ho, (e => o(135, me = e))), cn(e, po, (e => o(167, ve = e))), cn(e, mo, (e => o(136, fe = e)));
    const yo = (e, t) => {
        const o = {
            target: e,
            translate: t
        };
        let i, n = zm(X, o, {
            aspectRatio: P
        });
        const r = $e(Ue(Ee(n), q));
        if (Jr(I, E), r.width < D.width || r.height < D.height) {
            const o = t.y < 0,
                n = t.x > 0,
                a = t.x < 0,
                s = t.y > 0,
                l = "t" === e && o || "r" === e && n || "b" === e && s || "l" === e && a || "tr" === e && (n || o) || "tl" === e && (a || o) || "br" === e && (n || s) || "bl" === e && (a || s),
                c = Xe(r),
                d = Qr(I, E, c);
            if (l && (d.width < D.width || d.height < D.height)) {
                if (0 !== E) {
                    const e = Math.sign(E),
                        t = Math.round(Math.abs(E) / V) * V,
                        o = E - e * t,
                        i = t / V % 2 == 1,
                        n = i ? I.height : I.width,
                        a = i ? I.width : I.height,
                        s = Math.abs(o),
                        l = Math.sin(s),
                        c = Math.cos(s);
                    if (r.width < D.width) {
                        r.width = D.width;
                        const e = n - (c * r.width + l * r.height),
                            t = a - (l * r.width + c * r.height);
                        e < t ? r.height = (n - c * r.width) / l : t < e && (r.height = (a - l * r.width) / c)
                    }
                    if (r.height < D.height) {
                        r.height = D.height;
                        const e = n - (c * r.width + l * r.height),
                            t = a - (l * r.width + c * r.height);
                        e < t ? r.width = (n - l * r.height) / c : t < e && (r.width = (a - c * r.height) / l)
                    }
                } else r.width < D.width && (r.width = D.width, r.height = I.height), r.height < D.height && (r.height = D.height, r.width = I.width);
                i = Xe(r)
            }
        }
        return i && (n = zm(X, o, {
            aspectRatio: i || P
        })), {
            boundsLimited: ((e, t, o, i = {}) => {
                const {
                    target: n,
                    translate: r
                } = t, {
                    aspectRatio: a,
                    minSize: s,
                    maxSize: l
                } = i, c = Em[Im[n]], d = ne(Y(e.x, e.y), Y(c[0] * e.width, c[1] * e.height)), u = Em[n], h = ne(Ee(e), Y(u[0] * e.width, u[1] * e.height)), [p, m, g, f, $, y, x] = Lm(n);
                let b = r.x,
                    v = r.y;
                $ ? v = 0 : y && (b = 0);
                const w = Fm(d, n, o, {
                    aspectRatio: a,
                    minSize: s,
                    maxSize: l
                });
                let [S, C, k, M] = et(e);
                if (p ? M = d.x : m && (C = d.x), f ? S = d.y : g && (k = d.y), p) {
                    const e = w.inner.x + w.inner.width,
                        t = w.outer.x + w.outer.width;
                    C = oa(h.x + b, e, t)
                } else if (m) {
                    const e = w.outer.x,
                        t = w.inner.x;
                    M = oa(h.x + b, e, t)
                }
                if (f) {
                    const e = w.inner.y + w.inner.height,
                        t = w.outer.y + w.outer.height;
                    k = oa(h.y + v, e, t)
                } else if (g) {
                    const e = w.outer.y,
                        t = w.inner.y;
                    S = oa(h.y + v, e, t)
                }
                if (a)
                    if (x) {
                        let e = C - M,
                            t = k - S;
                        $ ? (t = e / a, S = d.y - .5 * t, k = d.y + .5 * t) : y && (e = t * a, M = d.x - .5 * e, C = d.x + .5 * e)
                    } else {
                        const e = Y(h.x + b - d.x, h.y + v - d.y);
                        n === bm ? (e.x = Math.max(0, e.x), e.y = Math.min(0, e.y)) : n === vm ? (e.x = Math.max(0, e.x), e.y = Math.max(0, e.y)) : n === wm ? (e.x = Math.min(0, e.x), e.y = Math.max(0, e.y)) : n === xm && (e.x = Math.min(0, e.x), e.y = Math.min(0, e.y));
                        const t = Q(e),
                            o = Q(Y(w.inner.width, w.inner.height)),
                            i = Q(Y(w.outer.width, w.outer.height)),
                            r = oa(t, o, i),
                            s = Y(a, 1),
                            l = ae(ee(s), r);
                        n === bm ? (C = d.x + l.x, S = d.y - l.y) : n === vm ? (C = d.x + l.x, k = d.y + l.y) : n === wm ? (M = d.x - l.x, k = d.y + l.y) : n === xm && (M = d.x - l.x, S = d.y - l.y)
                    } return _e(M, S, C - M, k - S)
            })(X, o, ie, {
                aspectRatio: P || i,
                minSize: fo,
                maxSize: $o
            }),
            boundsIntent: n
        }
    };
    let xo = void 0,
        bo = void 0;
    const vo = ({
            translation: e,
            scalar: t
        }) => {
            const o = Math.min(G.width / A.width, G.height / A.height),
                i = ae(Z(e), 1 / o);
            let n;
            if (bo) {
                const t = re(Z(bo), e);
                bo = e, n = Ve(Ee(A), t)
            } else n = Ve(Ee(xo), K(Z(i))), void 0 !== t && He(n, 1 / t);
            gn(to, le = n, le), gn(io, A = n, A)
        },
        wo = Or([ao, io], (([e, t], o) => {
            if (!t) return;
            const [i, n] = e, r = Xe(t);
            o([$e(ot(Je(i, r), Io)), $e(ot(Qe(n, r), Io))])
        }));
    cn(e, wo, (e => o(166, he = e)));
    const So = Or([uo, co, no, ro, ao, Yt], (([e, t, o, i, n, r], a) => {
        if (!e) return;
        const s = n[0],
            l = n[1];
        let c, d;
        t ? (c = ((e, t, o) => N(o) ? 1 - 1 / Math.min(e.height / t.width, e.width / t.height) : 1 - 1 / Math.min(e.width / t.width, e.height / t.height))(e, l, r), d = Math.min(s.width / o.width, s.height / o.height)) : (d = 1, c = -1);
        a([Io(c), Io(d)])
    }));
    cn(e, So, (e => o(25, Ie = e)));
    const Co = Or([uo, io, ao, Yt], (([e, t, o, i], n) => {
        if (!e || !t) return n(0);
        let r;
        const a = o[0],
            s = o[1],
            l = t.width,
            c = t.height,
            d = Xe(t),
            u = N(i) ? be(e.height, e.width) : e,
            h = Qe(u, d);
        if (l <= h.width || c <= h.height) {
            const e = h.width - a.width,
                t = h.height - a.height;
            r = 0 === e || 0 === t ? 1 : 1 - Math.min((l - a.width) / e, (c - a.height) / t)
        } else {
            const e = s.width - h.width,
                t = s.height - h.height,
                o = Qe({
                    width: e,
                    height: t
                }, d);
            r = -Math.min((l - h.width) / o.width, (c - h.height) / o.height)
        }
        n(r)
    }));
    cn(e, Co, (e => o(26, Le = e)));
    const ko = e => {
        const t = Xe(xo);
        let o, i, n;
        const r = N(E) ? be(I.height, I.width) : I,
            a = Qe(r, t);
        if (e >= 0) {
            const r = a.width - ce[0].width,
                s = a.height - ce[0].height;
            o = a.width - r * e, i = a.height - s * e, n = Je({
                width: o,
                height: i
            }, t)
        } else {
            const r = ce[1].width - a.width,
                s = ce[1].height - a.height;
            o = a.width + r * -e, i = a.height + s * -e, n = Qe({
                width: o,
                height: i
            }, t)
        }
        o = n.width, i = n.height;
        const s = xo.x + .5 * xo.width - .5 * o,
            l = xo.y + .5 * xo.height - .5 * i;
        gn(io, A = {
            x: s,
            y: l,
            width: o,
            height: i
        }, A)
    };
    let Mo;
    const To = e => {
        const t = He(Ee(Mo), 1 / e);
        gn(to, le = t, le), gn(io, A = t, A)
    };
    let Ro;
    const Po = Zn(),
        Ao = () => {
            Po("measure", Ee(ie))
        };
    let Eo;
    const Lo = rs(0, {
        precision: 1e-4
    });
    cn(e, Lo, (e => o(27, ze = e)));
    const Fo = rs();
    cn(e, Fo, (e => o(28, Be = e)));
    const zo = Or([so, qt], (([e, t], o) => {
        if (!xt) return;
        const i = Pc(xt),
            n = [...i].map((e => e[0])).sort(((e, t) => Qt(e[0]) && !Qt(t[0]) ? 1 : -1)).find((o => {
                if (Qt(o) && t) {
                    const [i, n] = o, r = t.width === i && t.height === n, a = e === O(i, n);
                    return r && a
                }
                return o === e
            }));
        o(i.map((e => e[0])).findIndex((e => Qt(e) ? aa(e, n) : e === n)))
    }));
    cn(e, zo, (e => o(115, z = e)));
    const Bo = e => {
            if (!xt || -1 === e) return;
            const t = Pc(xt)[e][0];
            return t ? Qt(t) ? O(t[0], t[1]) : t : void 0
        },
        Do = Or([Ot, eo, Ft], (([e, t, o], i) => {
            const {
                rows: n,
                cols: r,
                opacity: a
            } = tt(Mt, o);
            if (!t || a <= 0) return i([]);
            const {
                x: s,
                y: l,
                width: c,
                height: d
            } = t, u = c / r, h = d / n, p = [];
            for (let t = 1; t <= n - 1; t++) {
                const o = l + h * t;
                p.push({
                    id: "image-selection-guide-row-" + t,
                    points: [Y(s, o), Y(s + c, o)],
                    opacity: a,
                    strokeWidth: 1,
                    strokeColor: e
                })
            }
            for (let t = 1; t <= r - 1; t++) {
                const o = s + u * t;
                p.push({
                    id: "image-selection-guide-col-" + t,
                    points: [Y(o, l), Y(o, l + d)],
                    opacity: a,
                    strokeWidth: 1,
                    strokeColor: e
                })
            }
            i(p)
        }));
    cn(e, Do, (e => o(138, Te = e)));
    const Oo = "crop-" + T();
    let _o, Wo = Oo + "-" + (at ? St : "zoom"),
        Vo = Wo,
        Ho = void 0;
    const No = rs(Re ? 20 : 0);
    cn(e, No, (e => o(143, Pe = e)));
    return e.$$set = e => {
        "isActive" in e && Ne(o(1, Ye = e.isActive)), "stores" in e && o(88, Ge = e.stores), "cropImageSelectionCornerStyle" in e && o(2, qe = e.cropImageSelectionCornerStyle), "cropWillRenderImageSelectionGuides" in e && o(89, tt = e.cropWillRenderImageSelectionGuides), "cropAutoCenterImageSelectionTimeout" in e && o(90, it = e.cropAutoCenterImageSelectionTimeout), "cropEnableZoomMatchImageAspectRatio" in e && o(91, nt = e.cropEnableZoomMatchImageAspectRatio), "cropEnableRotateMatchImageAspectRatio" in e && o(92, rt = e.cropEnableRotateMatchImageAspectRatio), "cropEnableRotationInput" in e && o(93, at = e.cropEnableRotationInput), "cropEnableZoom" in e && o(3, st = e.cropEnableZoom), "cropEnableZoomInput" in e && o(94, lt = e.cropEnableZoomInput), "cropEnableZoomAutoHide" in e && o(95, ct = e.cropEnableZoomAutoHide), "cropEnableImageSelection" in e && o(96, dt = e.cropEnableImageSelection), "cropEnableInfoIndicator" in e && o(97, ut = e.cropEnableInfoIndicator), "cropEnableZoomTowardsWheelPosition" in e && o(98, ht = e.cropEnableZoomTowardsWheelPosition), "cropEnableLimitWheelInputToCropSelection" in e && o(99, pt = e.cropEnableLimitWheelInputToCropSelection), "cropEnableCenterImageSelection" in e && o(100, mt = e.cropEnableCenterImageSelection), "cropEnableButtonRotateLeft" in e && o(101, gt = e.cropEnableButtonRotateLeft), "cropEnableButtonRotateRight" in e && o(102, ft = e.cropEnableButtonRotateRight), "cropEnableButtonFlipHorizontal" in e && o(103, $t = e.cropEnableButtonFlipHorizontal), "cropEnableButtonFlipVertical" in e && o(104, yt = e.cropEnableButtonFlipVertical), "cropSelectPresetOptions" in e && o(105, xt = e.cropSelectPresetOptions), "cropEnableSelectPreset" in e && o(106, bt = e.cropEnableSelectPreset), "cropEnableButtonToggleCropLimit" in e && o(107, vt = e.cropEnableButtonToggleCropLimit), "cropWillRenderTools" in e && o(108, wt = e.cropWillRenderTools), "cropActiveTransformTool" in e && o(109, St = e.cropActiveTransformTool), "locale" in e && o(4, Ct = e.locale), "tools" in e && o(0, kt = e.tools)
    }, e.$$.update = () => {
        67108864 & e.$$.dirty[3] && o(133, u = "overlay" === H.layoutMode), 8192 & e.$$.dirty[3] | 512 & e.$$.dirty[4] && o(114, x = bt && !u), 536870912 & e.$$.dirty[3] | 1 & e.$$.dirty[4] && o(129, a = ie && G && Ze(ie, G)), 536870912 & e.$$.dirty[3] | 32 & e.$$.dirty[4] && o(130, s = !(!G || !a)), 536870912 & e.$$.dirty[3] | 96 & e.$$.dirty[4] && o(116, l = s && je(G, a, (e => Io(e, 5)))), 272 & e.$$.dirty[0] | 134012672 & e.$$.dirty[3] && o(0, kt = wt([gt && ["Button", "rotate-left", {
            label: Ct.cropLabelButtonRotateLeft,
            labelClass: "PinturaToolbarContentWide",
            icon: Ct.cropIconButtonRotateLeft,
            onclick: () => {
                At(-Math.PI / 2), It.write()
            }
        }], ft && ["Button", "rotate-right", {
            label: Ct.cropLabelButtonRotateRight,
            labelClass: "PinturaToolbarContentWide",
            icon: Ct.cropIconButtonRotateRight,
            onclick: () => {
                At(Math.PI / 2), It.write()
            }
        }], $t && ["Button", "flip-horizontal", {
            label: Ct.cropLabelButtonFlipHorizontal,
            labelClass: "PinturaToolbarContentWide",
            icon: Ct.cropIconButtonFlipHorizontal,
            onclick: () => {
                N(E) ? gn(Xt, L = !L, L) : gn(jt, F = !F, F), It.write()
            }
        }], yt && ["Button", "flip-vertical", {
            label: Ct.cropLabelButtonFlipVertical,
            labelClass: "PinturaToolbarContentWide",
            icon: Ct.cropIconButtonFlipVertical,
            onclick: () => {
                N(E) ? gn(jt, F = !F, F) : gn(Xt, L = !L, L), It.write()
            }
        }], x && xt && ["Dropdown", "select-preset", {
            icon: Ic(Ct.cropIconSelectPreset, Ct, Bo(z)),
            label: Ct.cropLabelSelectPreset,
            labelClass: "PinturaToolbarContentWide",
            options: xt,
            selectedIndex: z,
            onchange: ({
                value: e
            }) => {
                Qt(e) ? (gn(so, P = O(e[0], e[1]), P), gn(qt, B = ye(e), B)) : gn(so, P = e, P), l && Ao(), It.write()
            },
            optionMapper: e => {
                let t = !1;
                const o = Qt(e.value) ? e.value[0] / e.value[1] : e.value;
                if (o) {
                    const e = Qr(I, E, o);
                    t = e.width < D.width || e.height < D.height
                }
                return e.icon = ((e, t = {}) => {
                    const {
                        width: o = 24,
                        height: i = 24,
                        bounds: n = 16,
                        radius: r = 3
                    } = t;
                    let a, s, l, c, d = Qt(e) ? O(e[0], e[1]) : e,
                        u = !!d;
                    return d = u ? d : 1, l = d > 1 ? n : d * n, c = l / d, a = Math.round(.5 * (o - l)), s = Math.round(.5 * (i - c)), `<rect fill="${u?"currentColor":"none"}" stroke="${u?"none":"currentColor"}" stroke-width="${o/16}" stroke-dasharray="${[o/12,o/6].join(" ")}" x="${a}" y="${s}" width="${l}" height="${c}" rx="${r}"/>`
                })(e.value, {
                    bounds: 14
                }), {
                    ...e,
                    disabled: t
                }
            }
        }], vt && ["Dropdown", "select-crop-limit", {
            icon: Ic(Ct.cropIconCropBoundary, Ct, W),
            label: Ct.cropLabelCropBoundary,
            labelClass: "PinturaToolbarContentWide",
            onchange: ({
                value: e
            }) => {
                gn(co, W = e, W), It.write()
            },
            options: [
                [!0, Ct.cropLabelCropBoundaryEdge, {
                    icon: Ic(Ct.cropIconCropBoundary, Ct, !0)
                }],
                [!1, Ct.cropLabelCropBoundaryNone, {
                    icon: Ic(Ct.cropIconCropBoundary, Ct, !1)
                }]
            ]
        }]].filter(Boolean), H, (() => ({}))).filter(Boolean)), 512 & e.$$.dirty[0] && U && Ut.set(1), 33554432 & e.$$.dirty[3] && o(14, i = W ? 0 : -1), 3 & e.$$.dirty[4] && o(126, n = ie && Y(-(ue.x - ie.x), -(ue.y - ie.y))), 20 & e.$$.dirty[4] && o(127, r = pe && Y(fc(pe.x + .5 * pe.width + n.x), fc(pe.y + .5 * pe.height + n.y))), 268435456 & e.$$.dirty[3] && o(131, c = null != X), 33 & e.$$.dirty[4] && o(132, d = ie && a && (a.height === ie.height || a.width === ie.width)), 1073741824 & e.$$.dirty[3] | 2304 & e.$$.dirty[4] && o(134, h = !d && q < 1 && me < 1), 8388608 & e.$$.dirty[3] | 1216 & e.$$.dirty[4] && o(10, p = s && !c && (!l || h)), 128 & e.$$.dirty[0] | 16 & e.$$.dirty[3] | 512 & e.$$.dirty[4] && o(16, m = ut && !!A && !u), 20 & e.$$.dirty[4] && o(11, $ = pe && n && {
            x: pe.x + n.x,
            y: pe.y + n.y,
            width: pe.width,
            height: pe.height
        }), 2048 & e.$$.dirty[0] | 8 & e.$$.dirty[3] | 512 & e.$$.dirty[4] && o(17, g = dt && !!$ && !u), 268435456 & e.$$.dirty[2] | 128 & e.$$.dirty[3] | 8 & e.$$.dirty[4] && o(18, f = mt && !!r && !it), 1024 & e.$$.dirty[0] | 268435456 & e.$$.dirty[2] | 134348800 & e.$$.dirty[3] && p && it && !j && (clearTimeout(Eo), o(110, Eo = setTimeout(Ao, it))), 134348800 & e.$$.dirty[3] && j && clearTimeout(Eo), 1024 & e.$$.dirty[0] && Lo.set(p ? 1 : 0), 8 & e.$$.dirty[4] && Fo.set(r), 512 & e.$$.dirty[0] | 12288 & e.$$.dirty[4] && (U && !fe ? gn(Nt, xe.crop = {
            maskOpacity: .85,
            maskMarkupOpacity: .85
        }, xe) : delete xe.crop), 16384 & e.$$.dirty[4] && Te && (() => {
            const e = ve.filter((e => !/^image\-selection\-guide/.test(e.id)));
            gn(po, ve = U ? [...e, ...Te] : e, ve)
        })(), 67108864 & e.$$.dirty[3] && o(139, y = "short" !== H.verticalSpace), 33280 & e.$$.dirty[4] && o(19, b = y && !u), 8 & e.$$.dirty[0] | 2 & e.$$.dirty[3] && o(140, v = st && lt), 4 & e.$$.dirty[3] | 98304 & e.$$.dirty[4] && o(141, w = ct ? y && v : v), 1 & e.$$.dirty[3] | 131072 & e.$$.dirty[4] && o(20, S = at || w), 131072 & e.$$.dirty[4] && (w || o(5, Vo = Wo)), 32 & e.$$.dirty[0] && o(21, C = {
            name: Oo,
            selected: Vo
        }), 16 & e.$$.dirty[0] | 1 & e.$$.dirty[3] | 131072 & e.$$.dirty[4] && o(12, k = [at && {
            id: Oo + "-rotation",
            label: Ct.cropLabelTabRotation
        }, w && {
            id: Oo + "-zoom",
            label: Ct.cropLabelTabZoom
        }].filter(Boolean)), 4096 & e.$$.dirty[0] && o(22, M = k.map((e => e.id))), 64 & e.$$.dirty[0] | 512 & e.$$.dirty[4] && _o && !_o.children.length && u && _o.dispatchEvent(new CustomEvent("measure", {
            detail: _o.rect
        })), 512 & e.$$.dirty[0] | 262144 & e.$$.dirty[4] && Re && No.set(U ? 0 : 20), 524288 & e.$$.dirty[4] && o(23, R = Pe ? `transform: translateY(${Pe}px)` : void 0)
    }, [kt, Ye, qe, st, Ct, Vo, _o, A, E, U, p, $, k, Ho, i, de, m, g, f, b, S, C, M, R, Ae, Ie, Le, ze, Be, Et, Lt, zt, Bt, Dt, _t, Wt, Vt, Ht, Nt, jt, Xt, Yt, Gt, qt, Zt, Kt, Jt, eo, to, oo, io, no, ro, ao, so, co, uo, ho, po, mo, () => {
        Mt = "select", gn(Lt, j = !0, j), gn(Kt, X = Ee(G), X), go = q, fo = we(ge(D), go), $o = we(ge(J), go)
    }, ({
        detail: e
    }) => {
        const {
            boundsLimited: t,
            boundsIntent: o
        } = yo(e.direction, e.translation);
        gn(Jt, te = o, te), gn(Zt, G = t, G)
    }, ({
        detail: e
    }) => {
        const {
            boundsLimited: t
        } = yo(e.direction, e.translation);
        gn(Lt, j = !1, j), gn(Jt, te = void 0, te), Q(e.translation) && (gn(Zt, G = t, G), It.write()), gn(Kt, X = void 0, X), Mt = void 0
    }, () => {
        Mt = "rotate", gn(Lt, j = !0, j), gn(oo, se = Ee(A), se)
    }, e => {
        gn(Yt, E = e, E)
    }, e => {
        gn(Lt, j = !1, j), gn(Yt, E = e, E), It.write(), gn(oo, se = void 0, se)
    }, () => {
        Mt = "pan", bo = void 0, gn(Lt, j = !0, j), xo = Ee(A)
    }, ({
        detail: e
    }) => vo(e), ({
        detail: e
    }) => {
        gn(Lt, j = !1, j), (Q(e.translation) > 0 || 0 !== e.scalar) && (vo(e), It.write()), gn(to, le = void 0, le), xo = void 0
    }, ({
        detail: e
    }) => {
        bo = e.translation, gn(Lt, j = !1, j)
    }, wo, So, Co, () => {
        Mt = "zoom", gn(Lt, j = !0, j), xo = Ee(A)
    }, e => {
        ko(e)
    }, e => {
        ko(e), It.write(), gn(Lt, j = !1, j), xo = void 0
    }, () => {
        Mt = "zoom", xo || (Mo = Ee(A), gn(Lt, j = !0, j))
    }, ({
        detail: e
    }) => {
        Mo && To(e)
    }, ({
        detail: e
    }) => {
        Mo && (gn(Lt, j = !1, j), To(e), gn(to, le = void 0, le), Mo = void 0, It.write())
    }, e => {
        const t = ((e, t, o) => {
            const i = Am(e);
            return re(re(i, t), o)
        })(e, de, ue);
        if (pt && !Ke(G, t)) return;
        Mt = "zoom", gn(Lt, j = !0, j), e.preventDefault(), e.stopPropagation();
        const o = Yl(e),
            i = 1 + o / 100,
            n = Ee(A),
            r = 1 === Math.min(A.width / D.width, A.height / D.height);
        if (nt && W) {
            const e = Rt(A, I, E);
            if (Tt() && e && o > 0 && l) {
                gn(Lt, j = !1, j);
                const e = N(E) ? Fe({
                    height: I.width,
                    width: I.height
                }) : Fe(I);
                if (je(n, e)) return;
                if (clearTimeout(Ro), je(It.state.crop, e)) return;
                return gn(io, A = e, A), void It.write()
            }
        }
        let a = We(A);
        if (ht && o < 0 && !r) {
            const e = re(Z(t), G),
                o = Math.min(G.width / A.width, G.height / A.height),
                i = He(Ee(G), 1.1);
            a = Ke(i, t) ? ne(Ee(A), ae(e, 1 / o)) : a
        }
        let s = He(Ee(A), i, a);
        ke(he[1], s) || (s = Oe(We(s), he[1])), ke(s, he[0]) || (s = Oe(We(s), he[0])), je(n, s, Io) ? gn(Lt, j = !1, j) : (gn(io, A = ot(s, (e => Io(e, 5))), A), gn(Lt, j = !1, j), clearTimeout(Ro), Ro = setTimeout((() => {
            It.write()
        }), 500))
    }, Ao, Lo, Fo, zo, Do, Oo, No, "crop", Ge, tt, it, nt, rt, at, lt, ct, dt, ut, ht, pt, mt, gt, ft, $t, yt, xt, bt, vt, wt, St, Eo, I, L, F, x, z, l, D, W, H, j, X, G, q, ie, ue, n, r, pe, a, s, c, d, u, h, me, fe, xe, Te, y, v, w, Re, Pe, function (t) {
        Qn(e, t)
    }, ({
        detail: e
    }) => o(5, Vo = e), function (e) {
        tr[e ? "unshift" : "push"]((() => {
            _o = e, o(6, _o)
        }))
    }, e => Am(e), function (e) {
        Ho = e, o(13, Ho)
    }, function (t) {
        Qn(e, t)
    }]
}
var rg = {
    util: ["crop", class extends Fr {
        constructor(e) {
            super(), Lr(this, e, ng, tg, an, {
                name: 87,
                isActive: 1,
                stores: 88,
                cropImageSelectionCornerStyle: 2,
                cropWillRenderImageSelectionGuides: 89,
                cropAutoCenterImageSelectionTimeout: 90,
                cropEnableZoomMatchImageAspectRatio: 91,
                cropEnableRotateMatchImageAspectRatio: 92,
                cropEnableRotationInput: 93,
                cropEnableZoom: 3,
                cropEnableZoomInput: 94,
                cropEnableZoomAutoHide: 95,
                cropEnableImageSelection: 96,
                cropEnableInfoIndicator: 97,
                cropEnableZoomTowardsWheelPosition: 98,
                cropEnableLimitWheelInputToCropSelection: 99,
                cropEnableCenterImageSelection: 100,
                cropEnableButtonRotateLeft: 101,
                cropEnableButtonRotateRight: 102,
                cropEnableButtonFlipHorizontal: 103,
                cropEnableButtonFlipVertical: 104,
                cropSelectPresetOptions: 105,
                cropEnableSelectPreset: 106,
                cropEnableButtonToggleCropLimit: 107,
                cropWillRenderTools: 108,
                cropActiveTransformTool: 109,
                locale: 4,
                tools: 0
            }, [-1, -1, -1, -1, -1, -1, -1])
        }
        get name() {
            return this.$$.ctx[87]
        }
        get isActive() {
            return this.$$.ctx[1]
        }
        set isActive(e) {
            this.$set({
                isActive: e
            }), dr()
        }
        get stores() {
            return this.$$.ctx[88]
        }
        set stores(e) {
            this.$set({
                stores: e
            }), dr()
        }
        get cropImageSelectionCornerStyle() {
            return this.$$.ctx[2]
        }
        set cropImageSelectionCornerStyle(e) {
            this.$set({
                cropImageSelectionCornerStyle: e
            }), dr()
        }
        get cropWillRenderImageSelectionGuides() {
            return this.$$.ctx[89]
        }
        set cropWillRenderImageSelectionGuides(e) {
            this.$set({
                cropWillRenderImageSelectionGuides: e
            }), dr()
        }
        get cropAutoCenterImageSelectionTimeout() {
            return this.$$.ctx[90]
        }
        set cropAutoCenterImageSelectionTimeout(e) {
            this.$set({
                cropAutoCenterImageSelectionTimeout: e
            }), dr()
        }
        get cropEnableZoomMatchImageAspectRatio() {
            return this.$$.ctx[91]
        }
        set cropEnableZoomMatchImageAspectRatio(e) {
            this.$set({
                cropEnableZoomMatchImageAspectRatio: e
            }), dr()
        }
        get cropEnableRotateMatchImageAspectRatio() {
            return this.$$.ctx[92]
        }
        set cropEnableRotateMatchImageAspectRatio(e) {
            this.$set({
                cropEnableRotateMatchImageAspectRatio: e
            }), dr()
        }
        get cropEnableRotationInput() {
            return this.$$.ctx[93]
        }
        set cropEnableRotationInput(e) {
            this.$set({
                cropEnableRotationInput: e
            }), dr()
        }
        get cropEnableZoom() {
            return this.$$.ctx[3]
        }
        set cropEnableZoom(e) {
            this.$set({
                cropEnableZoom: e
            }), dr()
        }
        get cropEnableZoomInput() {
            return this.$$.ctx[94]
        }
        set cropEnableZoomInput(e) {
            this.$set({
                cropEnableZoomInput: e
            }), dr()
        }
        get cropEnableZoomAutoHide() {
            return this.$$.ctx[95]
        }
        set cropEnableZoomAutoHide(e) {
            this.$set({
                cropEnableZoomAutoHide: e
            }), dr()
        }
        get cropEnableImageSelection() {
            return this.$$.ctx[96]
        }
        set cropEnableImageSelection(e) {
            this.$set({
                cropEnableImageSelection: e
            }), dr()
        }
        get cropEnableInfoIndicator() {
            return this.$$.ctx[97]
        }
        set cropEnableInfoIndicator(e) {
            this.$set({
                cropEnableInfoIndicator: e
            }), dr()
        }
        get cropEnableZoomTowardsWheelPosition() {
            return this.$$.ctx[98]
        }
        set cropEnableZoomTowardsWheelPosition(e) {
            this.$set({
                cropEnableZoomTowardsWheelPosition: e
            }), dr()
        }
        get cropEnableLimitWheelInputToCropSelection() {
            return this.$$.ctx[99]
        }
        set cropEnableLimitWheelInputToCropSelection(e) {
            this.$set({
                cropEnableLimitWheelInputToCropSelection: e
            }), dr()
        }
        get cropEnableCenterImageSelection() {
            return this.$$.ctx[100]
        }
        set cropEnableCenterImageSelection(e) {
            this.$set({
                cropEnableCenterImageSelection: e
            }), dr()
        }
        get cropEnableButtonRotateLeft() {
            return this.$$.ctx[101]
        }
        set cropEnableButtonRotateLeft(e) {
            this.$set({
                cropEnableButtonRotateLeft: e
            }), dr()
        }
        get cropEnableButtonRotateRight() {
            return this.$$.ctx[102]
        }
        set cropEnableButtonRotateRight(e) {
            this.$set({
                cropEnableButtonRotateRight: e
            }), dr()
        }
        get cropEnableButtonFlipHorizontal() {
            return this.$$.ctx[103]
        }
        set cropEnableButtonFlipHorizontal(e) {
            this.$set({
                cropEnableButtonFlipHorizontal: e
            }), dr()
        }
        get cropEnableButtonFlipVertical() {
            return this.$$.ctx[104]
        }
        set cropEnableButtonFlipVertical(e) {
            this.$set({
                cropEnableButtonFlipVertical: e
            }), dr()
        }
        get cropSelectPresetOptions() {
            return this.$$.ctx[105]
        }
        set cropSelectPresetOptions(e) {
            this.$set({
                cropSelectPresetOptions: e
            }), dr()
        }
        get cropEnableSelectPreset() {
            return this.$$.ctx[106]
        }
        set cropEnableSelectPreset(e) {
            this.$set({
                cropEnableSelectPreset: e
            }), dr()
        }
        get cropEnableButtonToggleCropLimit() {
            return this.$$.ctx[107]
        }
        set cropEnableButtonToggleCropLimit(e) {
            this.$set({
                cropEnableButtonToggleCropLimit: e
            }), dr()
        }
        get cropWillRenderTools() {
            return this.$$.ctx[108]
        }
        set cropWillRenderTools(e) {
            this.$set({
                cropWillRenderTools: e
            }), dr()
        }
        get cropActiveTransformTool() {
            return this.$$.ctx[109]
        }
        set cropActiveTransformTool(e) {
            this.$set({
                cropActiveTransformTool: e
            }), dr()
        }
        get locale() {
            return this.$$.ctx[4]
        }
        set locale(e) {
            this.$set({
                locale: e
            }), dr()
        }
        get tools() {
            return this.$$.ctx[0]
        }
        set tools(e) {
            this.$set({
                tools: e
            }), dr()
        }
    }]
};

function ag(e) {
    let t, o, i, n, r, a, s, l = e[68],
        c = (S(e[68].label) ? e[68].label(e[2]) : e[68].label) + "";

    function d(...t) {
        return e[48](e[68], ...t)
    }
    const u = () => e[49](o, l),
        h = () => e[49](null, l);
    return {
        c() {
            t = Mn("div"), o = Mn("div"), i = Pn(), n = Mn("span"), r = Rn(c), Fn(o, "class", dg), Fn(t, "slot", "option"), Fn(t, "class", "PinturaFilterOption")
        },
        m(e, l) {
            Cn(e, t, l), Sn(t, o), u(), Sn(t, i), Sn(t, n), Sn(n, r), a || (s = [In(o, "measure", d), fn($s.call(null, o))], a = !0)
        },
        p(t, o) {
            l !== (e = t)[68] && (h(), l = e[68], u()), 4 & o[0] | 64 & o[2] && c !== (c = (S(e[68].label) ? e[68].label(e[2]) : e[68].label) + "") && Bn(r, c)
        },
        d(e) {
            e && kn(t), h(), a = !1, nn(s)
        }
    }
}

function sg(e) {
    let t, o;
    return t = new ad({
        props: {
            locale: e[2],
            layout: "row",
            options: e[3],
            selectedIndex: e[10],
            onchange: e[29],
            $$slots: {
                option: [ag, ({
                    option: e
                }) => ({
                    68: e
                }), ({
                    option: e
                }) => [0, 0, e ? 64 : 0]]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            4 & o[0] && (i.locale = e[2]), 8 & o[0] && (i.options = e[3]), 1024 & o[0] && (i.selectedIndex = e[10]), 516 & o[0] | 192 & o[2] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function lg(e) {
    let t, o, i, n, r, a, s, l;

    function c(t) {
        e[51](t)
    }

    function d(t) {
        e[52](t)
    }

    function u(t) {
        e[53](t)
    }
    let h = {
        elasticity: e[15] * e[16],
        onscroll: e[50],
        $$slots: {
            default: [sg]
        },
        $$scope: {
            ctx: e
        }
    };
    return void 0 !== e[4] && (h.maskFeatherStartOpacity = e[4]), void 0 !== e[5] && (h.maskFeatherEndOpacity = e[5]), void 0 !== e[6] && (h.maskFeatherSize = e[6]), o = new Kl({
        props: h
    }), tr.push((() => Rr(o, "maskFeatherStartOpacity", c))), tr.push((() => Rr(o, "maskFeatherEndOpacity", d))), tr.push((() => Rr(o, "maskFeatherSize", u))), o.$on("measure", e[54]), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), Fn(t, "slot", "footer"), Fn(t, "style", e[11])
        },
        m(i, n) {
            Cn(i, t, n), Ar(o, t, null), a = !0, s || (l = In(t, "transitionend", e[27]), s = !0)
        },
        p(e, s) {
            const l = {};
            128 & s[0] && (l.onscroll = e[50]), 1548 & s[0] | 128 & s[2] && (l.$$scope = {
                dirty: s,
                ctx: e
            }), !i && 16 & s[0] && (i = !0, l.maskFeatherStartOpacity = e[4], sr((() => i = !1))), !n && 32 & s[0] && (n = !0, l.maskFeatherEndOpacity = e[5], sr((() => n = !1))), !r && 64 & s[0] && (r = !0, l.maskFeatherSize = e[6], sr((() => r = !1))), o.$set(l), (!a || 2048 & s[0]) && Fn(t, "style", e[11])
        },
        i(e) {
            a || (yr(o.$$.fragment, e), a = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), a = !1
        },
        d(e) {
            e && kn(t), Ir(o), s = !1, l()
        }
    }
}

function cg(e) {
    let t, o;
    return t = new am({
        props: {
            $$slots: {
                footer: [lg]
            },
            $$scope: {
                ctx: e
            }
        }
    }), t.$on("measure", e[55]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            4092 & o[0] | 128 & o[2] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}
let dg = "PinturaFilterPreview";

function ug(e, t, o) {
    let i, n, r, a, s, l, c, d, u, h, p, m, g, f, $, y, x, b, v = Ji,
        w = () => (v(), v = sn(M, (e => o(40, u = e))), M),
        C = Ji,
        k = () => (C(), C = sn(T, (e => o(45, y = e))), T);
    e.$$.on_destroy.push((() => v())), e.$$.on_destroy.push((() => C()));
    let {
        isActive: M
    } = t;
    w();
    let {
        isActiveFraction: T
    } = t;
    k();
    let {
        stores: R
    } = t, {
        locale: P
    } = t, {
        filterFunctions: A
    } = t, {
        filterOptions: I
    } = t;
    const {
        history: E,
        interfaceImages: L,
        stageRect: F,
        utilRect: z,
        animation: B,
        elasticityMultiplier: D,
        scrollElasticity: O,
        imageSize: _,
        imagePreview: W,
        imageCropRect: V,
        imageRotation: H,
        imageFlipX: N,
        imageFlipY: U,
        imageBackgroundColor: j,
        imageGamma: X,
        imageColorMatrix: G
    } = R;
    cn(e, F, (e => o(42, p = e))), cn(e, z, (e => o(41, h = e))), cn(e, B, (e => o(39, d = e))), cn(e, _, (e => o(57, f = e))), cn(e, W, (e => o(44, g = e))), cn(e, j, (e => o(58, $ = e))), cn(e, X, (e => o(43, m = e))), cn(e, G, (e => o(36, a = e)));
    const q = Dr({});
    cn(e, q, (e => o(37, s = e)));
    const J = (e, t) => gn(q, s[e.value] = t, s),
        Q = Or(q, (e => {
            if (!e[void 0]) return;
            const t = e[void 0];
            return l && ve(l, t) ? l : ge(t)
        }));
    cn(e, Q, (e => o(56, l = e)));
    const ee = Or([M, Q, V, _, H, N, U], (([e, t, o, i, n, r, a], s) => {
        if (!e || !t || !i) return c;
        const l = Fe(i),
            d = We(l),
            u = ta(i, o, n),
            h = We(u),
            p = re(Z(d), h),
            m = K(Z(p)),
            g = Math.max(t.width / o.width, t.height / o.height);
        s({
            origin: m,
            translation: p,
            rotation: {
                x: a ? Math.PI : 0,
                y: r ? Math.PI : 0,
                z: n
            },
            scale: g
        })
    }));
    cn(e, ee, (e => o(38, c = e)));
    const te = rs(d ? 20 : 0);
    let oe;
    cn(e, te, (e => o(46, x = e)));
    const ie = {};
    let ne, ae, se, le, ce, de = {
        x: 0,
        y: 0
    };
    const ue = Dr([]);
    cn(e, ue, (e => o(47, b = e)));
    const he = e => {
        const t = {
            ...e,
            data: g,
            size: f,
            offset: {
                ...e.offset
            },
            mask: {
                ...e.mask
            },
            backgroundColor: $
        };
        return t.opacity = y, t.offset.y += x, t.mask.y += x, t
    };
    qn((() => {
        L.set([])
    }));
    return e.$$set = e => {
        "isActive" in e && w(o(0, M = e.isActive)), "isActiveFraction" in e && k(o(1, T = e.isActiveFraction)), "stores" in e && o(31, R = e.stores), "locale" in e && o(2, P = e.locale), "filterFunctions" in e && o(32, A = e.filterFunctions), "filterOptions" in e && o(3, I = e.filterOptions)
    }, e.$$.update = () => {
        if (8 & e.$$.dirty[0] && o(35, i = Pc(I)), 48 & e.$$.dirty[1] && o(10, n = ((e, t) => {
                if (!e || !e.filter || !t) return 0;
                const o = e.filter;
                return t.findIndex((([e]) => {
                    if (!A[e]) return !1;
                    const t = A[e]();
                    return aa(t, o)
                }))
            })(a, i)), 768 & e.$$.dirty[1] && d && te.set(u ? 0 : 20), 3584 & e.$$.dirty[1] && u && h && p) {
            const e = p.y + p.height + h.y;
            o(34, ce = {
                x: p.x - h.x,
                y: e
            })
        }
        if (496 & e.$$.dirty[0] | 4350 & e.$$.dirty[1] && c && ce && de && le && oe) {
            const e = ce.x + le.x + de.x,
                t = ce.y,
                o = le.x + ce.x,
                n = o + le.width;
            ue.set(i.map((([i], r) => {
                const l = s[i],
                    d = de.x + l.x,
                    u = d + l.width;
                if (u < 0 || d > le.width) return !1;
                const h = e + l.x,
                    p = t + l.y,
                    g = (e => ({
                        origin: Z(e.origin),
                        translation: Z(e.translation),
                        rotation: {
                            ...e.rotation
                        },
                        scale: e.scale
                    }))(c);
                g.offset = Y(.5 * l.width + h, .5 * l.height + p);
                g.maskOpacity = 1, g.mask = _e(h + 0, p, l.width + 0, l.height), g.maskFeather = [1, 0, 1, 0, 1, n, 1, n], d < se && ne < 1 && (g.maskFeather[0] = ne, g.maskFeather[1] = o, g.maskFeather[2] = 1, g.maskFeather[3] = o + se), u > le.width - se && ae < 1 && (g.maskFeather[4] = ae, g.maskFeather[5] = n - se, g.maskFeather[6] = 1, g.maskFeather[7] = n), g.maskCornerRadius = oe[i];
                let f = a && Object.keys(a).filter((e => "filter" != e)).map((e => a[e])) || [];
                return S(A[i]) && f.push(A[i]()), g.colorMatrix = f.length ? Zi(f) : void 0, g.gamma = m, g
            })).filter(Boolean))
        }
        122880 & e.$$.dirty[1] && (y > 0 && b ? L.set(b.map(he)) : L.set([])), 32768 & e.$$.dirty[1] && o(11, r = x ? `transform: translateY(${x}px)` : void 0)
    }, [M, T, P, I, ne, ae, se, de, le, ie, n, r, F, z, B, D, O, _, W, j, X, G, q, J, Q, ee, te, e => {
        e.target.className === dg && o(33, oe = Object.keys(ie).reduce(((e, t) => {
            const o = ie[t],
                i = getComputedStyle(o),
                n = ["top-left", "top-right", "bottom-left", "bottom-right"].map((e => i.getPropertyValue(`border-${e}-radius`))).map(Xl).map((e => 1.25 * e));
            return e[t] = n, e
        }), {}))
    }, ue, ({
        value: e
    }) => {
        gn(G, a = {
            ...a,
            filter: S(A[e]) ? A[e]() : void 0
        }, a), E.write()
    }, "filter", R, A, oe, ce, i, a, s, c, d, u, h, p, m, g, y, x, b, (e, t) => J(e, t.detail), function (e, t) {
        tr[e ? "unshift" : "push"]((() => {
            ie[t.value] = e, o(9, ie)
        }))
    }, e => o(7, de = e), function (e) {
        ne = e, o(4, ne)
    }, function (e) {
        ae = e, o(5, ae)
    }, function (e) {
        se = e, o(6, se)
    }, e => o(8, le = e.detail), function (t) {
        Qn(e, t)
    }]
}
var hg = {
    util: ["filter", class extends Fr {
        constructor(e) {
            super(), Lr(this, e, ug, cg, an, {
                name: 30,
                isActive: 0,
                isActiveFraction: 1,
                stores: 31,
                locale: 2,
                filterFunctions: 32,
                filterOptions: 3
            }, [-1, -1, -1])
        }
        get name() {
            return this.$$.ctx[30]
        }
        get isActive() {
            return this.$$.ctx[0]
        }
        set isActive(e) {
            this.$set({
                isActive: e
            }), dr()
        }
        get isActiveFraction() {
            return this.$$.ctx[1]
        }
        set isActiveFraction(e) {
            this.$set({
                isActiveFraction: e
            }), dr()
        }
        get stores() {
            return this.$$.ctx[31]
        }
        set stores(e) {
            this.$set({
                stores: e
            }), dr()
        }
        get locale() {
            return this.$$.ctx[2]
        }
        set locale(e) {
            this.$set({
                locale: e
            }), dr()
        }
        get filterFunctions() {
            return this.$$.ctx[32]
        }
        set filterFunctions(e) {
            this.$set({
                filterFunctions: e
            }), dr()
        }
        get filterOptions() {
            return this.$$.ctx[3]
        }
        set filterOptions(e) {
            this.$set({
                filterOptions: e
            }), dr()
        }
    }]
};

function pg(e) {
    let t, o, i = e[37].label + "";
    return {
        c() {
            t = Mn("span"), o = Rn(i)
        },
        m(e, i) {
            Cn(e, t, i), Sn(t, o)
        },
        p(e, t) {
            64 & t[1] && i !== (i = e[37].label + "") && Bn(o, i)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function mg(e) {
    let t, o;
    const i = [{
        class: "PinturaControlList"
    }, {
        tabs: e[1]
    }, e[3]];
    let n = {
        $$slots: {
            default: [pg, ({
                tab: e
            }) => ({
                37: e
            }), ({
                tab: e
            }) => [0, e ? 64 : 0]]
        },
        $$scope: {
            ctx: e
        }
    };
    for (let e = 0; e < i.length; e += 1) n = en(n, i[e]);
    return t = new ml({
        props: n
    }), t.$on("select", e[22]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const n = 10 & o[0] ? Mr(i, [i[0], 2 & o[0] && {
                tabs: e[1]
            }, 8 & o[0] && Tr(e[3])]) : {};
            192 & o[1] && (n.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(n)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function gg(e) {
    let t, o;
    const i = [e[5][e[36]]];
    let n = {};
    for (let e = 0; e < i.length; e += 1) n = en(n, i[e]);
    return t = new dm({
        props: n
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const n = 32 & o[0] | 32 & o[1] ? Mr(i, [Tr(e[5][e[36]])]) : {};
            t.$set(n)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function fg(e) {
    let t, o, i, n, r;
    o = new Kl({
        props: {
            elasticity: e[9] * e[8],
            class: "PinturaControlListScroller",
            $$slots: {
                default: [mg]
            },
            $$scope: {
                ctx: e
            }
        }
    });
    const a = [{
        class: "PinturaControlPanels"
    }, {
        panelClass: "PinturaControlPanel"
    }, {
        panels: e[4]
    }, e[3]];
    let s = {
        $$slots: {
            default: [gg, ({
                panel: e
            }) => ({
                36: e
            }), ({
                panel: e
            }) => [0, e ? 32 : 0]]
        },
        $$scope: {
            ctx: e
        }
    };
    for (let e = 0; e < a.length; e += 1) s = en(s, a[e]);
    return n = new Ml({
        props: s
    }), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), i = Pn(), Pr(n.$$.fragment), Fn(t, "slot", "footer"), Fn(t, "style", e[6])
        },
        m(e, a) {
            Cn(e, t, a), Ar(o, t, null), Sn(t, i), Ar(n, t, null), r = !0
        },
        p(e, i) {
            const s = {};
            14 & i[0] | 128 & i[1] && (s.$$scope = {
                dirty: i,
                ctx: e
            }), o.$set(s);
            const l = 24 & i[0] ? Mr(a, [a[0], a[1], 16 & i[0] && {
                panels: e[4]
            }, 8 & i[0] && Tr(e[3])]) : {};
            32 & i[0] | 160 & i[1] && (l.$$scope = {
                dirty: i,
                ctx: e
            }), n.$set(l), (!r || 64 & i[0]) && Fn(t, "style", e[6])
        },
        i(e) {
            r || (yr(o.$$.fragment, e), yr(n.$$.fragment, e), r = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), xr(n.$$.fragment, e), r = !1
        },
        d(e) {
            e && kn(t), Ir(o), Ir(n)
        }
    }
}

function $g(e) {
    let t, o;
    return t = new am({
        props: {
            $$slots: {
                footer: [fg]
            },
            $$scope: {
                ctx: e
            }
        }
    }), t.$on("measure", e[23]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            126 & o[0] | 128 & o[1] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function yg(e, t, o) {
    let i, n, r, a, s, l, c, d, u, h, p = Ji,
        m = () => (p(), p = sn(f, (e => o(20, u = e))), f);
    e.$$.on_destroy.push((() => p()));
    let {
        stores: g
    } = t, {
        isActive: f
    } = t;
    m();
    let {
        locale: $ = {}
    } = t, {
        finetuneControlConfiguration: y
    } = t, {
        finetuneOptions: x
    } = t;
    const {
        history: b,
        animation: v,
        scrollElasticity: w,
        elasticityMultiplier: C,
        rangeInputElasticity: k,
        imageColorMatrix: M,
        imageConvolutionMatrix: R,
        imageGamma: P,
        imageVignette: A,
        imageNoise: I
    } = g;
    cn(e, v, (e => o(19, d = e)));
    const E = {
            imageColorMatrix: M,
            imageConvolutionMatrix: R,
            imageGamma: P,
            imageVignette: A,
            imageNoise: I
        },
        L = "finetune-" + T(),
        F = Dr({});
    cn(e, F, (e => o(18, c = e)));
    const z = Dr({});
    cn(e, z, (e => o(5, l = e)));
    let B = [];
    const D = rs(d ? 20 : 0);
    cn(e, D, (e => o(21, h = e)));
    return e.$$set = e => {
        "stores" in e && o(14, g = e.stores), "isActive" in e && m(o(0, f = e.isActive)), "locale" in e && o(15, $ = e.locale), "finetuneControlConfiguration" in e && o(16, y = e.finetuneControlConfiguration), "finetuneOptions" in e && o(17, x = e.finetuneOptions)
    }, e.$$.update = () => {
        var t;
        163840 & e.$$.dirty[0] && o(1, i = x ? x.map((([e, t]) => ({
            id: e,
            label: S(t) ? t($) : t
        }))) : []), 2 & e.$$.dirty[0] && o(2, n = i.length && i[0].id), 4 & e.$$.dirty[0] && o(3, r = {
            name: L,
            selected: n
        }), 2 & e.$$.dirty[0] && o(4, a = i.map((e => e.id))), 65536 & e.$$.dirty[0] && y && (t = y, B && B.forEach((e => e())), B = a.map((e => {
            const {
                getStore: o,
                getValue: i = _
            } = t[e];
            return o(E).subscribe((t => {
                const o = null != t ? i(t) : t;
                gn(F, c = {
                    ...c,
                    [e]: o
                }, c)
            }))
        }))), 327680 & e.$$.dirty[0] && y && c && gn(z, l = Object.keys(c).reduce(((e, t) => {
            const {
                base: o,
                min: i,
                max: n,
                getLabel: r,
                getStore: a,
                setValue: s = ((e, t) => e.set(t))
            } = y[t], l = a(E), d = null != c[t] ? c[t] : o;
            return e[t] = {
                base: o,
                min: i,
                max: n,
                value: d,
                valueLabel: r ? r(d, i, n, n - i) : Math.round(100 * d),
                oninputmove: e => {
                    s(l, e)
                },
                oninputend: e => {
                    s(l, e), b.write()
                },
                elasticity: C * k,
                labelReset: $.labelReset
            }, e
        }), {}), l), 1572864 & e.$$.dirty[0] && d && D.set(u ? 0 : 20), 2097152 & e.$$.dirty[0] && o(6, s = h ? `transform: translateY(${h}px)` : void 0)
    }, [f, i, n, r, a, l, s, v, w, C, F, z, D, "finetune", g, $, y, x, c, d, u, h, ({
        detail: e
    }) => o(2, n = e), function (t) {
        Qn(e, t)
    }]
}
var xg = {
    util: ["finetune", class extends Fr {
        constructor(e) {
            super(), Lr(this, e, yg, $g, an, {
                name: 13,
                stores: 14,
                isActive: 0,
                locale: 15,
                finetuneControlConfiguration: 16,
                finetuneOptions: 17
            }, [-1, -1])
        }
        get name() {
            return this.$$.ctx[13]
        }
        get stores() {
            return this.$$.ctx[14]
        }
        set stores(e) {
            this.$set({
                stores: e
            }), dr()
        }
        get isActive() {
            return this.$$.ctx[0]
        }
        set isActive(e) {
            this.$set({
                isActive: e
            }), dr()
        }
        get locale() {
            return this.$$.ctx[15]
        }
        set locale(e) {
            this.$set({
                locale: e
            }), dr()
        }
        get finetuneControlConfiguration() {
            return this.$$.ctx[16]
        }
        set finetuneControlConfiguration(e) {
            this.$set({
                finetuneControlConfiguration: e
            }), dr()
        }
        get finetuneOptions() {
            return this.$$.ctx[17]
        }
        set finetuneOptions(e) {
            this.$set({
                finetuneOptions: e
            }), dr()
        }
    }]
};

function bg(e, t, o) {
    const i = e.slice();
    return i[47] = t[o].key, i[48] = t[o].index, i[49] = t[o].translate, i[50] = t[o].scale, i[14] = t[o].rotate, i[51] = t[o].dir, i[52] = t[o].center, i[53] = t[o].type, i
}

function vg(e) {
    let t, o;
    return {
        c() {
            t = Mn("div"), Fn(t, "class", "PinturaShapeManipulator"), Fn(t, "data-control", "point"), Fn(t, "style", o = `pointer-events:none;transform: translate3d(${e[52].x}px, ${e[52].y}px, 0) scale(${e[5]}, ${e[5]}); opacity: ${e[6]}`)
        },
        m(e, o) {
            Cn(e, t, o)
        },
        p(e, i) {
            104 & i[0] && o !== (o = `pointer-events:none;transform: translate3d(${e[52].x}px, ${e[52].y}px, 0) scale(${e[5]}, ${e[5]}); opacity: ${e[6]}`) && Fn(t, "style", o)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function wg(e, t) {
    let o, i, n, r, a, s, l, c, d;

    function u(...e) {
        return t[18](t[48], ...e)
    }
    let h = "edge" === t[53] && "both" !== t[2] && vg(t);
    return {
        key: e,
        first: null,
        c() {
            o = Mn("div"), s = Pn(), h && h.c(), l = An(), Fn(o, "role", "button"), Fn(o, "aria-label", i = `Drag ${t[53]} ${t[47]}`), Fn(o, "tabindex", n = "edge" === t[53] ? -1 : 0), Fn(o, "class", "PinturaShapeManipulator"), Fn(o, "data-control", r = t[53]), Fn(o, "style", a = `cursor: ${t[51]?t[51]+"-resize":"move"}; transform: translate3d(${t[49].x}px, ${t[49].y}px, 0)${"edge"===t[53]?` rotate(${t[14]}rad)`:""} scale(${"point"===t[53]?t[5]:t[50].x}, ${"point"===t[53]?t[5]:t[50].y}); opacity: ${t[6]}`), this.first = o
        },
        m(e, i) {
            Cn(e, o, i), Cn(e, s, i), h && h.m(e, i), Cn(e, l, i), c || (d = [In(o, "keydown", t[7]), In(o, "keyup", t[8]), In(o, "nudge", u), fn(Nl.call(null, o)), In(o, "interactionstart", (function () {
                rn(t[11]("start", t[48])) && t[11]("start", t[48]).apply(this, arguments)
            })), In(o, "interactionupdate", (function () {
                rn(t[11]("move", t[48])) && t[11]("move", t[48]).apply(this, arguments)
            })), In(o, "interactionend", (function () {
                rn(t[11]("end", t[48])) && t[11]("end", t[48]).apply(this, arguments)
            })), fn(Hl.call(null, o))], c = !0)
        },
        p(e, s) {
            t = e, 8 & s[0] && i !== (i = `Drag ${t[53]} ${t[47]}`) && Fn(o, "aria-label", i), 8 & s[0] && n !== (n = "edge" === t[53] ? -1 : 0) && Fn(o, "tabindex", n), 8 & s[0] && r !== (r = t[53]) && Fn(o, "data-control", r), 104 & s[0] && a !== (a = `cursor: ${t[51]?t[51]+"-resize":"move"}; transform: translate3d(${t[49].x}px, ${t[49].y}px, 0)${"edge"===t[53]?` rotate(${t[14]}rad)`:""} scale(${"point"===t[53]?t[5]:t[50].x}, ${"point"===t[53]?t[5]:t[50].y}); opacity: ${t[6]}`) && Fn(o, "style", a), "edge" === t[53] && "both" !== t[2] ? h ? h.p(t, s) : (h = vg(t), h.c(), h.m(l.parentNode, l)) : h && (h.d(1), h = null)
        },
        d(e) {
            e && kn(o), e && kn(s), h && h.d(e), e && kn(l), c = !1, nn(d)
        }
    }
}

function Sg(e) {
    let t, o, i, n;
    return {
        c() {
            t = Mn("div"), Fn(t, "role", "button"), Fn(t, "aria-label", "Drag rotator"), Fn(t, "tabindex", "0"), Fn(t, "class", "PinturaShapeManipulator"), Fn(t, "data-control", "rotate"), Fn(t, "style", o = `transform: translate3d(${e[0].x}px, ${e[0].y}px, 0) scale(${e[5]}, ${e[5]}); opacity: ${e[6]}`)
        },
        m(o, r) {
            Cn(o, t, r), i || (n = [In(t, "keydown", e[7]), In(t, "keyup", e[8]), In(t, "nudge", e[13]), fn(Nl.call(null, t)), In(t, "interactionstart", e[14]("start")), In(t, "interactionupdate", e[14]("move")), In(t, "interactionend", e[14]("end")), fn(Hl.call(null, t))], i = !0)
        },
        p(e, i) {
            97 & i[0] && o !== (o = `transform: translate3d(${e[0].x}px, ${e[0].y}px, 0) scale(${e[5]}, ${e[5]}); opacity: ${e[6]}`) && Fn(t, "style", o)
        },
        d(e) {
            e && kn(t), i = !1, nn(n)
        }
    }
}

function Cg(e) {
    let t, o, i = [],
        n = new Map,
        r = e[3];
    const a = e => e[47];
    for (let t = 0; t < r.length; t += 1) {
        let o = bg(e, r, t),
            s = a(o);
        n.set(s, i[t] = wg(s, o))
    }
    let s = e[1] && e[4] && Sg(e);
    return {
        c() {
            for (let e = 0; e < i.length; e += 1) i[e].c();
            t = Pn(), s && s.c(), o = An()
        },
        m(e, n) {
            for (let t = 0; t < i.length; t += 1) i[t].m(e, n);
            Cn(e, t, n), s && s.m(e, n), Cn(e, o, n)
        },
        p(e, l) {
            6636 & l[0] && (r = e[3], i = kr(i, l, a, 1, e, r, n, t.parentNode, Sr, wg, t, bg)), e[1] && e[4] ? s ? s.p(e, l) : (s = Sg(e), s.c(), s.m(o.parentNode, o)) : s && (s.d(1), s = null)
        },
        i: Ji,
        o: Ji,
        d(e) {
            for (let t = 0; t < i.length; t += 1) i[t].d(e);
            e && kn(t), s && s.d(e), e && kn(o)
        }
    }
}

function kg(e, t, o) {
    let i, n, r, a, s;
    const l = Zn(),
        c = .5 * H,
        d = V - c,
        u = V + c,
        h = -V,
        p = h - c,
        m = h + c,
        g = W - c,
        f = -W + c,
        $ = c,
        y = -c,
        x = V - H,
        b = x - c,
        v = x + c,
        S = W - H,
        C = S - c,
        k = S + c,
        M = h - H,
        T = M + c,
        R = M - c,
        P = h + H,
        A = P + c,
        I = P - c;
    let {
        points: E = []
    } = t, {
        rotatorPoint: L
    } = t, {
        visible: F = !1
    } = t, {
        enableResizing: z = !0
    } = t, {
        enableRotating: B = !0
    } = t, D = !1;
    const O = rs(.5, {
        precision: 1e-4,
        stiffness: .3,
        damping: .7
    });
    cn(e, O, (e => o(5, a = e)));
    const _ = rs(0, {
        precision: .001,
        stiffness: .3,
        damping: .7
    });
    cn(e, _, (e => o(6, s = e)));
    const N = e => {
            let t = "";
            return (e <= u && e >= d || e >= p && e <= m) && (t = "ns"), (e <= f || e >= g || e >= y && e <= $) && (t = "ew"), (e >= C && e <= k || e <= A && e >= I) && (t = "nesw"), (e >= b && e <= v || e <= T && e >= R) && (t = "nwse"), t
        },
        U = (e, t) => {
            l("resizestart", {
                indexes: e,
                translation: X()
            }), l("resizemove", {
                indexes: e,
                translation: t
            }), l("resizeend", {
                indexes: e,
                translation: X()
            })
        };
    return e.$$set = e => {
        "points" in e && o(15, E = e.points), "rotatorPoint" in e && o(0, L = e.rotatorPoint), "visible" in e && o(16, F = e.visible), "enableResizing" in e && o(17, z = e.enableResizing), "enableRotating" in e && o(1, B = e.enableRotating)
    }, e.$$.update = () => {
        65536 & e.$$.dirty[0] && O.set(F ? 1 : .5), 65536 & e.$$.dirty[0] && _.set(F ? 1 : 0), 131072 & e.$$.dirty[0] && o(2, i = !!z && (w(z) ? z : "both")), 32772 & e.$$.dirty[0] && o(3, n = i && ((e, t) => {
            let o = 0;
            const i = ue(e),
                n = [],
                r = e.length,
                a = 2 === r,
                s = "both" !== t;
            for (; o < r; o++) {
                const l = e[o - 1] || e[e.length - 1],
                    c = e[o],
                    d = e[o + 1] || e[0],
                    u = Math.atan2(d.y - c.y, d.x - c.x);
                if (!s) {
                    const e = ee(Y(l.x - c.x, l.y - c.y)),
                        t = ee(Y(d.x - c.x, d.y - c.y)),
                        i = Y(e.x + t.x, e.y + t.y);
                    n.push({
                        index: [o],
                        key: "point-" + o,
                        type: "point",
                        scale: {
                            x: 1,
                            y: 1
                        },
                        translate: {
                            x: c.x,
                            y: c.y
                        },
                        angle: void 0,
                        rotate: a ? 0 : u,
                        center: c,
                        dir: a ? void 0 : N(Math.atan2(i.y, i.x))
                    })
                }
                if (a) continue;
                const h = Y(c.x + .5 * (d.x - c.x), c.y + .5 * (d.y - c.y));
                "horizontal" === t && o % 2 == 0 || "vertical" === t && o % 2 != 0 || n.push({
                    index: [o, o + 1 === r ? 0 : o + 1],
                    key: "edge-" + o,
                    type: "edge",
                    scale: {
                        x: ce(c, d),
                        y: 1
                    },
                    translate: {
                        x: c.x,
                        y: c.y
                    },
                    angle: u,
                    rotate: u,
                    center: h,
                    dir: N(Math.atan2(i.y - h.y, i.x - h.x))
                })
            }
            return n
        })(E, i) || []), 32768 & e.$$.dirty[0] && o(4, r = E.length > 2)
    }, [L, B, i, n, r, a, s, e => D = e.shiftKey, e => D = !1, O, _, (e, t) => ({
        detail: o
    }) => {
        const i = o && o.translation ? o.translation : Y(0, 0);
        l("resize" + e, {
            ...o,
            indexes: t,
            translation: i,
            shiftKey: D
        })
    }, U, ({
        detail: e
    }) => {
        l("rotatestart", {
            translation: X()
        }), l("rotatemove", {
            translation: e
        }), l("rotateend", {
            translation: X()
        })
    }, e => ({
        detail: t
    }) => {
        const o = t && t.translation ? t.translation : Y(0, 0);
        l("rotate" + e, {
            translation: o,
            shiftKey: D
        })
    }, E, F, z, (e, {
        detail: t
    }) => U(e, t)]
}
class Mg extends Fr {
    constructor(e) {
        super(), Lr(this, e, kg, Cg, an, {
            points: 15,
            rotatorPoint: 0,
            visible: 16,
            enableResizing: 17,
            enableRotating: 1
        }, [-1, -1])
    }
}
var Tg = (e, t) => {
    const o = Am(e);
    return re(o, t)
};
let Rg = null;
let Pg = null;
var Ag = e => {
    if (null === Pg && (Pg = c() && "visualViewport" in window), !Pg) return !1;
    const t = visualViewport.height,
        o = () => {
            e(visualViewport.height < t ? "visible" : "hidden")
        };
    return visualViewport.addEventListener("resize", o), () => visualViewport.removeEventListener("resize", o)
};

function Ig(e) {
    let t, o, i, n, r, a, s, l, c, d;
    i = new Wl({
        props: {
            onclick: e[1],
            label: e[5],
            icon: e[7],
            hideLabel: !e[6]
        }
    });
    const u = e[20].default,
        h = dn(u, e, e[19], null);
    return s = new Wl({
        props: {
            onclick: e[0],
            label: e[2],
            icon: e[4],
            hideLabel: !e[3],
            class: "PinturaInputFormButtonConfirm"
        }
    }), {
        c() {
            t = Mn("div"), o = Mn("div"), Pr(i.$$.fragment), n = Pn(), r = Mn("div"), h && h.c(), a = Pn(), Pr(s.$$.fragment), Fn(r, "class", "PinturaInputFormFields"), Fn(o, "class", "PinturaInputFormInner"), Fn(t, "class", "PinturaInputForm"), Fn(t, "style", e[9])
        },
        m(u, p) {
            Cn(u, t, p), Sn(t, o), Ar(i, o, null), Sn(o, n), Sn(o, r), h && h.m(r, null), Sn(o, a), Ar(s, o, null), e[21](t), l = !0, c || (d = [In(t, "focusin", e[10]), In(t, "focusout", e[11]), In(t, "measure", e[12]), fn($s.call(null, t))], c = !0)
        },
        p(e, o) {
            const n = {};
            2 & o[0] && (n.onclick = e[1]), 32 & o[0] && (n.label = e[5]), 128 & o[0] && (n.icon = e[7]), 64 & o[0] && (n.hideLabel = !e[6]), i.$set(n), h && h.p && 524288 & o[0] && hn(h, u, e, e[19], o, null, null);
            const r = {};
            1 & o[0] && (r.onclick = e[0]), 4 & o[0] && (r.label = e[2]), 16 & o[0] && (r.icon = e[4]), 8 & o[0] && (r.hideLabel = !e[3]), s.$set(r), (!l || 512 & o[0]) && Fn(t, "style", e[9])
        },
        i(e) {
            l || (yr(i.$$.fragment, e), yr(h, e), yr(s.$$.fragment, e), l = !0)
        },
        o(e) {
            xr(i.$$.fragment, e), xr(h, e), xr(s.$$.fragment, e), l = !1
        },
        d(o) {
            o && kn(t), Ir(i), h && h.d(o), Ir(s), e[21](null), c = !1, nn(d)
        }
    }
}

function Eg(e, t, o) {
    let i, n, r, a, {
            $$slots: s = {},
            $$scope: l
        } = t,
        {
            onconfirm: c
        } = t,
        {
            oncancel: d
        } = t,
        {
            autoFocus: u = !0
        } = t,
        {
            autoPositionCursor: h = !0
        } = t,
        {
            labelConfirm: p
        } = t,
        {
            labelConfirmShow: m = !0
        } = t,
        {
            iconConfirm: g
        } = t,
        {
            labelCancel: f
        } = t,
        {
            labelCancelShow: $ = !1
        } = t,
        {
            iconCancel: y
        } = t,
        {
            panelOffset: x = X()
        } = t,
        b = !1,
        v = void 0,
        w = void 0,
        S = "",
        C = 0;
    const k = () => {
            const e = a.querySelector("input, textarea");
            e.focus(), C >= 1 || e.select()
        },
        M = () => {
            b = !0, R || !zt() && (null === Rg && (Rg = Lt(/Android/)), !Rg) || o(16, S = "top:1em;bottom:auto;"), zt() && (e => {
                let t;
                const o = e => t = e.touches[0].screenY,
                    i = e => {
                        const o = e.touches[0].screenY,
                            i = e.target;
                        /textarea/i.test(i.nodeName) ? (o > t ? 0 == i.scrollTop && e.preventDefault() : o < t ? i.scrollTop + i.offsetHeight == i.scrollHeight && e.preventDefault() : e.preventDefault(), t = o) : e.preventDefault()
                    };
                e.addEventListener("touchstart", o), e.addEventListener("touchmove", i)
            })(a), o(17, C = 1)
        };
    let T;
    const R = Ag((e => {
        n ? "hidden" !== e || b ? (clearTimeout(w), w = void 0, o(16, S = `top:${visualViewport.height-v-x.y}px`), "visible" === e ? (o(8, a.dataset.layout = "stick", a), k(), M()) : (b = !1, o(17, C = 0))) : k() : o(16, S = "top: 4.5em; bottom: auto")
    }));
    return Yn((() => {
        u && k()
    })), qn((() => {
        R && R()
    })), e.$$set = e => {
        "onconfirm" in e && o(0, c = e.onconfirm), "oncancel" in e && o(1, d = e.oncancel), "autoFocus" in e && o(13, u = e.autoFocus), "autoPositionCursor" in e && o(14, h = e.autoPositionCursor), "labelConfirm" in e && o(2, p = e.labelConfirm), "labelConfirmShow" in e && o(3, m = e.labelConfirmShow), "iconConfirm" in e && o(4, g = e.iconConfirm), "labelCancel" in e && o(5, f = e.labelCancel), "labelCancelShow" in e && o(6, $ = e.labelCancelShow), "iconCancel" in e && o(7, y = e.iconCancel), "panelOffset" in e && o(15, x = e.panelOffset), "$$scope" in e && o(19, l = e.$$scope)
    }, e.$$.update = () => {
        256 & e.$$.dirty[0] && o(18, i = a && getComputedStyle(a)), 262144 & e.$$.dirty[0] && (n = i && "1" === i.getPropertyValue("--editor-modal")), 196608 & e.$$.dirty[0] && o(9, r = `opacity:${C};${S}`)
    }, [c, d, p, m, g, f, $, y, a, r, e => {
        var t;
        (e => /textarea/i.test(e))(e.target) && (T = Date.now(), h && ((t = e.target).selectionStart = t.selectionEnd = t.value.length), clearTimeout(w), w = setTimeout(M, 200))
    }, e => {
        Date.now() - T > 50 || (e.stopPropagation(), k())
    }, ({
        detail: e
    }) => {
        v = e.height
    }, u, h, x, S, C, i, l, s, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            a = e, o(8, a)
        }))
    }]
}
class Lg extends Fr {
    constructor(e) {
        super(), Lr(this, e, Eg, Ig, an, {
            onconfirm: 0,
            oncancel: 1,
            autoFocus: 13,
            autoPositionCursor: 14,
            labelConfirm: 2,
            labelConfirmShow: 3,
            iconConfirm: 4,
            labelCancel: 5,
            labelCancelShow: 6,
            iconCancel: 7,
            panelOffset: 15
        }, [-1, -1])
    }
}
var Fg = e => document.createTextNode(e);

function zg(e) {
    let t, o, i, n;
    return {
        c() {
            t = Mn("pre"), Fn(t, "class", "PinturaContentEditable"), Fn(t, "data-wrap-content", o = e[3] ? "wrap" : "nowrap"), Fn(t, "contenteditable", ""), Fn(t, "spellcheck", e[0]), Fn(t, "autocorrect", e[1]), Fn(t, "autocapitalize", e[2]), Fn(t, "style", e[4])
        },
        m(o, r) {
            Cn(o, t, r), e[20](t), i || (n = [In(t, "input", e[9]), In(t, "paste", e[10]), In(t, "keydown", e[7]), In(t, "keyup", e[8]), In(t, "blur", e[6])], i = !0)
        },
        p(e, i) {
            8 & i[0] && o !== (o = e[3] ? "wrap" : "nowrap") && Fn(t, "data-wrap-content", o), 1 & i[0] && Fn(t, "spellcheck", e[0]), 2 & i[0] && Fn(t, "autocorrect", e[1]), 4 & i[0] && Fn(t, "autocapitalize", e[2]), 16 & i[0] && Fn(t, "style", e[4])
        },
        i: Ji,
        o: Ji,
        d(o) {
            o && kn(t), e[20](null), i = !1, nn(n)
        }
    }
}

function Bg(e, t, o) {
    let i, {
            spellcheck: r = "false"
        } = t,
        {
            autocorrect: a = "off"
        } = t,
        {
            autocapitalize: s = "off"
        } = t,
        {
            wrapLines: l = !0
        } = t,
        {
            textStyles: d = !1
        } = t,
        {
            formatInput: u = _
        } = t,
        {
            formatPaste: h = _
        } = t,
        {
            style: m
        } = t,
        {
            innerHTML: g
        } = t,
        {
            oninput: f = n
        } = t;
    const $ = () => {
            if (!x) return;
            const e = document.createRange();
            e.selectNodeContents(x);
            const t = window.getSelection();
            t.removeAllRanges(), t.addRange(e)
        },
        y = Zn();
    let x;
    c() && document.execCommand("defaultParagraphSeparator", !1, "br");
    const b = e => e.replace(/<\/?(?:i|b|em|strong)>/, ""),
        v = () => {
            o(11, g = x.innerHTML), y("input", g), f(g), requestAnimationFrame((() => x && x.scrollTo(0, 0)))
        },
        w = () => {
            k(x);
            const e = d ? x.innerHTML : b(x.innerHTML);
            o(5, x.innerHTML = u(e), x), M(x), v()
        },
        S = e => {
            const t = p("span");
            return t.dataset.bookmark = e, t
        },
        C = (e, t, o) => {
            const i = S(o);
            if (e.nodeType === Node.TEXT_NODE) {
                const n = e.textContent;
                if ("start" === o) {
                    const o = Fg(n.substr(0, t)),
                        r = Fg(n.substr(t));
                    e.replaceWith(o, i, r)
                } else {
                    const o = Fg(n.substr(0, t)),
                        r = Fg(n.substr(t));
                    e.replaceWith(o, i, r)
                }
            } else e.nodeType === Node.ELEMENT_NODE && e.insertBefore(i, e.childNodes[t])
        },
        k = e => {
            const t = window.getSelection();
            if (!t.getRangeAt || !t.rangeCount) return;
            const o = t.getRangeAt(0),
                {
                    startOffset: i,
                    endOffset: n,
                    startContainer: r,
                    endContainer: a
                } = o;
            if (e.contains(o.startContainer) && e.contains(o.endContainer))
                if (r.nodeType === Node.TEXT_NODE && r === a) {
                    const e = r.textContent,
                        t = e.substr(0, i),
                        o = S("start"),
                        a = n - i > 0 ? e.substr(i, n) : "",
                        s = S("end"),
                        l = e.substr(n);
                    r.replaceWith(t, o, a, s, l)
                } else C(r, i, "start"), C(a, n + (r === a ? 1 : 0), "end")
        },
        M = e => {
            const t = T(e, "start"),
                o = T(e, "end");
            if (!t || !o) return;
            const i = document.createRange();
            i.setStart(t, 0), i.setEnd(o, 0);
            const n = window.getSelection();
            n.removeAllRanges(), n.addRange(i), t.remove(), o.remove()
        },
        T = (e, t) => {
            const o = e.children;
            for (let e = 0; e < o.length; e++) {
                const i = o[e];
                if (i.dataset.bookmark === t) return i;
                if (i.children.length) {
                    const e = T(i, t);
                    if (e) return e
                }
            }
        },
        R = e => {
            const t = window.getSelection().getRangeAt(0),
                o = t.cloneRange();
            return o.selectNodeContents(e), o.setEnd(t.endContainer, t.endOffset), o.toString().length
        };
    return e.$$set = e => {
        "spellcheck" in e && o(0, r = e.spellcheck), "autocorrect" in e && o(1, a = e.autocorrect), "autocapitalize" in e && o(2, s = e.autocapitalize), "wrapLines" in e && o(3, l = e.wrapLines), "textStyles" in e && o(12, d = e.textStyles), "formatInput" in e && o(13, u = e.formatInput), "formatPaste" in e && o(14, h = e.formatPaste), "style" in e && o(4, m = e.style), "innerHTML" in e && o(11, g = e.innerHTML), "oninput" in e && o(15, f = e.oninput)
    }, e.$$.update = () => {
        var t;
        32 & e.$$.dirty[0] && o(19, i = !!x), 526336 & e.$$.dirty[0] && i && g && (t = g) !== x.innerHTML && (o(5, x.innerHTML = t, x), x === document.activeElement && $())
    }, [r, a, s, l, m, x, () => y("blur"), e => {
        if (13 !== e.keyCode) return;
        const t = R(x) === x.textContent.length ? "<br><br>" : "<br>";
        l && document.execCommand("insertHTML", !1, t), e.preventDefault()
    }, () => {}, e => {
        const {
            inputType: t
        } = e;
        "insertCompositionText" !== t && "deleteCompositionText" !== t && w()
    }, e => {
        e.preventDefault();
        const t = e.clipboardData.getData("text/plain"),
            o = d ? t : b(t),
            i = h(o);
        if (!i.length) return;
        const n = window.getSelection().getRangeAt(0);
        n.deleteContents(), n.insertNode(document.createTextNode(i)), v()
    }, g, d, u, h, f, () => w(), () => {
        x && x.focus()
    }, $, i, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            x = e, o(5, x)
        }))
    }]
}
class Dg extends Fr {
    constructor(e) {
        super(), Lr(this, e, Bg, zg, an, {
            spellcheck: 0,
            autocorrect: 1,
            autocapitalize: 2,
            wrapLines: 3,
            textStyles: 12,
            formatInput: 13,
            formatPaste: 14,
            style: 4,
            innerHTML: 11,
            oninput: 15,
            confirm: 16,
            focus: 17,
            select: 18
        }, [-1, -1])
    }
    get spellcheck() {
        return this.$$.ctx[0]
    }
    set spellcheck(e) {
        this.$set({
            spellcheck: e
        }), dr()
    }
    get autocorrect() {
        return this.$$.ctx[1]
    }
    set autocorrect(e) {
        this.$set({
            autocorrect: e
        }), dr()
    }
    get autocapitalize() {
        return this.$$.ctx[2]
    }
    set autocapitalize(e) {
        this.$set({
            autocapitalize: e
        }), dr()
    }
    get wrapLines() {
        return this.$$.ctx[3]
    }
    set wrapLines(e) {
        this.$set({
            wrapLines: e
        }), dr()
    }
    get textStyles() {
        return this.$$.ctx[12]
    }
    set textStyles(e) {
        this.$set({
            textStyles: e
        }), dr()
    }
    get formatInput() {
        return this.$$.ctx[13]
    }
    set formatInput(e) {
        this.$set({
            formatInput: e
        }), dr()
    }
    get formatPaste() {
        return this.$$.ctx[14]
    }
    set formatPaste(e) {
        this.$set({
            formatPaste: e
        }), dr()
    }
    get style() {
        return this.$$.ctx[4]
    }
    set style(e) {
        this.$set({
            style: e
        }), dr()
    }
    get innerHTML() {
        return this.$$.ctx[11]
    }
    set innerHTML(e) {
        this.$set({
            innerHTML: e
        }), dr()
    }
    get oninput() {
        return this.$$.ctx[15]
    }
    set oninput(e) {
        this.$set({
            oninput: e
        }), dr()
    }
    get confirm() {
        return this.$$.ctx[16]
    }
    get focus() {
        return this.$$.ctx[17]
    }
    get select() {
        return this.$$.ctx[18]
    }
}

function Og(e, t, o) {
    const i = e.slice();
    return i[198] = t[o], i[200] = o, i
}

function _g(e, t) {
    let o, i, n, r, a, s, l, c, d, u, h, p = t[198].name + "";

    function m(...e) {
        return t[132](t[200], ...e)
    }
    return n = new Bh({
        props: {
            color: t[198].color
        }
    }), {
        key: e,
        first: null,
        c() {
            o = Mn("li"), i = Mn("button"), Pr(n.$$.fragment), r = Pn(), a = Mn("span"), s = Rn(p), c = Pn(), Fn(i, "class", "PinturaShapeListItem"), Fn(i, "type", "button"), Fn(i, "aria-label", l = "Select shape " + t[198].name), this.first = o
        },
        m(e, t) {
            Cn(e, o, t), Sn(o, i), Ar(n, i, null), Sn(i, r), Sn(i, a), Sn(a, s), Sn(o, c), d = !0, u || (h = In(i, "click", m), u = !0)
        },
        p(e, o) {
            t = e;
            const r = {};
            4194304 & o[0] && (r.color = t[198].color), n.$set(r), (!d || 4194304 & o[0]) && p !== (p = t[198].name + "") && Bn(s, p), (!d || 4194304 & o[0] && l !== (l = "Select shape " + t[198].name)) && Fn(i, "aria-label", l)
        },
        i(e) {
            d || (yr(n.$$.fragment, e), d = !0)
        },
        o(e) {
            xr(n.$$.fragment, e), d = !1
        },
        d(e) {
            e && kn(o), Ir(n), u = !1, h()
        }
    }
}

function Wg(e) {
    let t, o;
    return t = new Mg({
        props: {
            visible: !0,
            points: e[11],
            rotatorPoint: e[16],
            enableResizing: e[15],
            enableRotating: e[9]
        }
    }), t.$on("resizestart", e[28]), t.$on("resizemove", e[29]), t.$on("resizeend", e[30]), t.$on("rotatestart", e[31]), t.$on("rotatemove", e[32]), t.$on("rotateend", e[33]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            2048 & o[0] && (i.points = e[11]), 65536 & o[0] && (i.rotatorPoint = e[16]), 32768 & o[0] && (i.enableResizing = e[15]), 512 & o[0] && (i.enableRotating = e[9]), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Vg(e) {
    let t, o, i, n;
    const r = [Ng, Hg],
        a = [];

    function s(e, t) {
        return "modal" === e[3] ? 0 : "inline" === e[3] ? 1 : -1
    }
    return ~(t = s(e)) && (o = a[t] = r[t](e)), {
        c() {
            o && o.c(), i = An()
        },
        m(e, o) {
            ~t && a[t].m(e, o), Cn(e, i, o), n = !0
        },
        p(e, n) {
            let l = t;
            t = s(e), t === l ? ~t && a[t].p(e, n) : (o && (fr(), xr(a[l], 1, 1, (() => {
                a[l] = null
            })), $r()), ~t ? (o = a[t], o ? o.p(e, n) : (o = a[t] = r[t](e), o.c()), yr(o, 1), o.m(i.parentNode, i)) : o = null)
        },
        i(e) {
            n || (yr(o), n = !0)
        },
        o(e) {
            xr(o), n = !1
        },
        d(e) {
            ~t && a[t].d(e), e && kn(i)
        }
    }
}

function Hg(e) {
    let t, o, i, n = {
        formatInput: e[35],
        wrapLines: !!e[8].width,
        style: e[18]
    };
    return o = new Dg({
        props: n
    }), e[135](o), o.$on("input", e[36]), o.$on("keyup", e[39]), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), Fn(t, "class", "PinturaInlineInput"), Fn(t, "style", e[19])
        },
        m(e, n) {
            Cn(e, t, n), Ar(o, t, null), i = !0
        },
        p(e, n) {
            const r = {};
            256 & n[0] && (r.wrapLines = !!e[8].width), 262144 & n[0] && (r.style = e[18]), o.$set(r), (!i || 524288 & n[0]) && Fn(t, "style", e[19])
        },
        i(e) {
            i || (yr(o.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), i = !1
        },
        d(i) {
            i && kn(t), e[135](null), Ir(o)
        }
    }
}

function Ng(e) {
    let t, o;
    return t = new Lg({
        props: {
            panelOffset: e[1],
            onconfirm: e[40],
            oncancel: e[41],
            labelCancel: e[4].shapeLabelInputCancel,
            iconCancel: e[4].shapeIconInputCancel,
            labelConfirm: e[4].shapeLabelInputConfirm,
            iconConfirm: e[4].shapeIconInputConfirm,
            $$slots: {
                default: [Ug]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            2 & o[0] && (i.panelOffset = e[1]), 16 & o[0] && (i.labelCancel = e[4].shapeLabelInputCancel), 16 & o[0] && (i.iconCancel = e[4].shapeIconInputCancel), 16 & o[0] && (i.labelConfirm = e[4].shapeLabelInputConfirm), 16 & o[0] && (i.iconConfirm = e[4].shapeIconInputConfirm), 393280 & o[0] | 32768 & o[6] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Ug(e) {
    let t, o, i;
    return {
        c() {
            t = Mn("textarea"), Fn(t, "spellcheck", "false"), Fn(t, "autocorrect", "off"), Fn(t, "autocapitalize", "off"), Fn(t, "style", e[18])
        },
        m(n, r) {
            Cn(n, t, r), e[133](t), Dn(t, e[17]), o || (i = [In(t, "keydown", e[38]), In(t, "keypress", e[37]), In(t, "keyup", e[39]), In(t, "input", e[36]), In(t, "input", e[134])], o = !0)
        },
        p(e, o) {
            262144 & o[0] && Fn(t, "style", e[18]), 131072 & o[0] && Dn(t, e[17])
        },
        d(n) {
            n && kn(t), e[133](null), o = !1, nn(i)
        }
    }
}

function jg(e) {
    let t, o, i, n, r;
    return o = new Vd({
        props: {
            items: e[21]
        }
    }), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), Fn(t, "class", "PinturaShapeControls"), Fn(t, "style", e[20])
        },
        m(a, s) {
            Cn(a, t, s), Ar(o, t, null), i = !0, n || (r = [In(t, "measure", e[136]), fn($s.call(null, t))], n = !0)
        },
        p(e, n) {
            const r = {};
            2097152 & n[0] && (r.items = e[21]), o.$set(r), (!i || 1048576 & n[0]) && Fn(t, "style", e[20])
        },
        i(e) {
            i || (yr(o.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), i = !1
        },
        d(e) {
            e && kn(t), Ir(o), n = !1, nn(r)
        }
    }
}

function Xg(e) {
    let t, o, i, n, r, a, s, l, c, d, u = [],
        h = new Map,
        p = e[22];
    const m = e => e[198].id;
    for (let t = 0; t < p.length; t += 1) {
        let o = Og(e, p, t),
            i = m(o);
        h.set(i, u[t] = _g(i, o))
    }
    let g = e[10] && Wg(e),
        f = e[12] && Vg(e),
        $ = e[13] > 0 && jg(e);
    return {
        c() {
            t = Mn("div"), o = Mn("nav"), i = Mn("ul");
            for (let e = 0; e < u.length; e += 1) u[e].c();
            n = Pn(), g && g.c(), r = Pn(), f && f.c(), a = Pn(), $ && $.c(), Fn(o, "class", "PinturaShapeList"), Fn(o, "data-visible", e[14]), Fn(t, "class", "PinturaShapeEditor"), Fn(t, "tabindex", "0")
        },
        m(h, p) {
            Cn(h, t, p), Sn(t, o), Sn(o, i);
            for (let e = 0; e < u.length; e += 1) u[e].m(i, null);
            Sn(t, n), g && g.m(t, null), Sn(t, r), f && f.m(t, null), Sn(t, a), $ && $.m(t, null), l = !0, c || (d = [In(o, "focusin", e[44]), In(o, "focusout", e[45]), In(t, "keydown", e[34]), In(t, "nudge", e[43]), In(t, "measure", e[131]), fn($s.call(null, t)), fn(Nl.call(null, t)), In(t, "pointermove", e[46]), In(t, "interactionstart", e[24]), In(t, "interactionupdate", e[25]), In(t, "interactionrelease", e[26]), In(t, "interactionend", e[27]), fn(s = Hl.call(null, t, {
                drag: !0,
                pinch: !0,
                inertia: !0,
                matchTarget: !0,
                getEventPosition: e[137]
            }))], c = !0)
        },
        p(e, n) {
            4194337 & n[0] && (p = e[22], fr(), u = kr(u, n, m, 1, e, p, h, i, Cr, _g, null, Og), $r()), (!l || 16384 & n[0]) && Fn(o, "data-visible", e[14]), e[10] ? g ? (g.p(e, n), 1024 & n[0] && yr(g, 1)) : (g = Wg(e), g.c(), yr(g, 1), g.m(t, r)) : g && (fr(), xr(g, 1, 1, (() => {
                g = null
            })), $r()), e[12] ? f ? (f.p(e, n), 4096 & n[0] && yr(f, 1)) : (f = Vg(e), f.c(), yr(f, 1), f.m(t, a)) : f && (fr(), xr(f, 1, 1, (() => {
                f = null
            })), $r()), e[13] > 0 ? $ ? ($.p(e, n), 8192 & n[0] && yr($, 1)) : ($ = jg(e), $.c(), yr($, 1), $.m(t, null)) : $ && (fr(), xr($, 1, 1, (() => {
                $ = null
            })), $r()), s && rn(s.update) && 4 & n[0] && s.update.call(null, {
                drag: !0,
                pinch: !0,
                inertia: !0,
                matchTarget: !0,
                getEventPosition: e[137]
            })
        },
        i(e) {
            if (!l) {
                for (let e = 0; e < p.length; e += 1) yr(u[e]);
                yr(g), yr(f), yr($), l = !0
            }
        },
        o(e) {
            for (let e = 0; e < u.length; e += 1) xr(u[e]);
            xr(g), xr(f), xr($), l = !1
        },
        d(e) {
            e && kn(t);
            for (let e = 0; e < u.length; e += 1) u[e].d();
            g && g.d(), f && f.d(), $ && $.d(), c = !1, nn(d)
        }
    }
}

function Yg(e, t, o) {
    let i, r, a, s, l, c, d, u, h, p, m, g, f, $, y, x, b, v, S, C, k, M, R, P, A, I, E, L, F, z, B, D, O, W, V, H, N, {
            uid: U = T()
        } = t,
        {
            ui: G
        } = t,
        {
            markup: q
        } = t,
        {
            offset: K
        } = t,
        {
            contextRotation: Q = 0
        } = t,
        {
            contextFlipX: de = !1
        } = t,
        {
            contextFlipY: me = !1
        } = t,
        {
            contextScale: ge
        } = t,
        {
            active: $e = !1
        } = t,
        {
            opacity: ye = 1
        } = t,
        {
            parentRect: xe
        } = t,
        {
            rootRect: ve
        } = t,
        {
            utilRect: we
        } = t,
        {
            hoverColor: Se
        } = t,
        {
            textInputMode: Ce = "inline"
        } = t,
        {
            oninteractionstart: ke = n
        } = t,
        {
            oninteractionupdate: Me = n
        } = t,
        {
            oninteractionrelease: Re = n
        } = t,
        {
            oninteractionend: Ae = n
        } = t,
        {
            onaddshape: Ie = n
        } = t,
        {
            onupdateshape: Ee = n
        } = t,
        {
            onselectshape: Le = n
        } = t,
        {
            onremoveshape: Fe = n
        } = t,
        {
            ontapshape: Oe = n
        } = t,
        {
            onhovershape: Ve = n
        } = t,
        {
            onhovercanvas: He = n
        } = t,
        {
            beforeSelectShape: Ne = (() => !0)
        } = t,
        {
            beforeDeselectShape: Ue = (() => !0)
        } = t,
        {
            beforeRemoveShape: je = (() => !0)
        } = t,
        {
            beforeUpdateShape: Xe = ((e, t) => t)
        } = t,
        {
            willRenderShapeControls: Ye = _
        } = t,
        {
            mapEditorPointToImagePoint: Ge
        } = t,
        {
            mapImagePointToEditorPoint: Ze
        } = t,
        {
            eraseRadius: Ke
        } = t,
        {
            selectRadius: Je
        } = t,
        {
            enableButtonFlipVertical: ot = !1
        } = t,
        {
            enableTapToAddText: it = !0
        } = t,
        {
            locale: nt
        } = t;
    const rt = (e, t, o) => {
            let i = Xe({
                ...e
            }, t, {
                ...o
            });
            Mi(e, i, o)
        },
        at = (e, t, o, i) => {
            const n = Y(e.x - o.x, e.y - o.y),
                r = Y(i.x - o.x, i.y - o.y),
                a = se(r, r);
            let s = se(n, r) / a;
            s = s < 0 ? 0 : s, s = s > 1 ? 1 : s;
            const l = Y(r.x * s + o.x - e.x, r.y * s + o.y - e.y);
            return se(l, l) <= t * t
        },
        ct = (e, t, o) => {
            const i = o.length;
            for (let n = 0; n < i - 1; n++)
                if (at(e, t, o[n], o[n + 1])) return !0;
            return !1
        },
        ut = (e, t, o) => !!lt(e, o) || (!!ct(e, t, o) || at(e, t, o[0], o[o.length - 1])),
        ht = (e, t, o, i, n) => ut(e, t, qe(o, i, n || We(o))),
        pt = Jn("keysPressed");
    cn(e, pt, (e => o(147, H = e)));
    const mt = (e, t, o) => 0 === e || t && o ? e : t || o ? -e : e,
        gt = (e, t) => {
            const o = Ze(e);
            return Ge(ne(o, t))
        },
        ft = (e, t, o) => {
            if (Uo(e)) {
                const i = gt(Do(t), o),
                    n = gt(Oo(t), o);
                rt(e, {
                    x1: i.x,
                    y1: i.y,
                    x2: n.x,
                    y2: n.y
                }, xe)
            } else if (Ho(e) || _o(e) || No(e)) {
                const i = gt(t, o);
                rt(e, i, xe)
            }
            kt()
        },
        $t = {
            0: 1,
            1: 0,
            2: 3,
            3: 2
        },
        yt = {
            0: 3,
            1: 2,
            2: 1,
            3: 0
        };
    let xt;
    const bt = () => {
            if (q.length) return q.find(Zo)
        },
        vt = () => {
            if (q.length) return q.findIndex(Zo)
        },
        wt = (e, t = !0) => {
            if (!bt()) return ti(e), Mt(e, t)
        },
        St = () => {
            const e = bt();
            if (e) return e._isDraft = !1, kt(), e
        },
        Ct = () => {
            bt() && (q.splice(vt(), 1), kt())
        },
        kt = () => o(0, q),
        Mt = (e, t = !0) => (q.push(e), t && kt(), e),
        Tt = (e, t = [], o = !0) => {
            t.forEach((t => delete e[t])), o && kt()
        },
        Rt = (e, t, o = !0) => {
            e = Object.assign(e, t), o && kt()
        },
        Pt = (e, t, o, i = !0) => {
            e[t] = o, i && kt()
        },
        At = (e, t = !0) => {
            q.forEach((t => Rt(t, e, !1))), t && kt()
        },
        It = () => [...q].reverse().find(qo),
        Et = () => !!It(),
        Lt = e => {
            if (!je(e)) return !1;
            o(0, q = q.filter((t => t !== e))), Fe(e)
        },
        Ft = () => {
            const e = It();
            if (!e) return;
            const t = q.filter((e => ni(e) && ii(e))),
                o = t.findIndex((t => t === e));
            if (!1 === Lt(e)) return;
            if (zt = e, t.length - 1 <= 0) return Bt();
            const i = o - 1 < 0 ? t.length - 1 : o - 1;
            Ot(t[i])
        };
    let zt = void 0;
    const Bt = () => {
            Object.keys(bo).forEach((e => bo[e] = {})), zt = Dt(), At({
                isSelected: !1,
                isEditing: !1,
                _prerender: !1
            })
        },
        Dt = () => q.find(qo),
        Ot = (e, t = !0) => {
            if (Zo(e)) return;
            const o = Dt() || zt,
                i = qo(e);
            zt = void 0, Ne(o, e) && (Bt(), (e => {
                e.isSelected = !0
            })(e), !i && Le(e), t && kt())
        },
        _t = e => {
            uo && e.isEditing && uo.confirm && uo.confirm(), Rt(e, {
                isSelected: !1,
                isEditing: !1,
                _prerender: !1
            })
        },
        Wt = e => {
            Rt(e, {
                isSelected: !0,
                isEditing: !0,
                _prerender: "inline" === Ce
            })
        },
        Vt = e => {
            Rt(e, {
                isSelected: !0,
                isEditing: !1,
                _prerender: !1
            })
        },
        Ht = e => {
            if (!e.length) return [];
            const t = e.filter(je);
            return o(0, q = q.filter((e => !t.includes(e)))), t
        },
        Nt = e => {
            const t = xo(e.text, e);
            return _e(e.x, e.y, e.width ? Math.min(e.width, t.width) : t.width, e.height ? Math.min(e.height, t.height) : t.height)
        },
        Ut = e => {
            if (Ko(e)) return ze(e);
            if (No(e)) return De(e);
            const t = Nt(e);
            return t.width = Math.max(10, e.width || t.width), t
        },
        jt = (e, t = 0, o = (e => !0)) => [...q].reverse().map((e => ({
            shape: e,
            priority: 1
        }))).filter(o).filter((o => {
            const {
                shape: i
            } = o, n = wi(Eo(i), xe), r = t + (n.strokeWidth || 0);
            if (Ho(n)) return ht(e, r, n, i.rotation);
            if (_o(n)) {
                const t = Ut(n),
                    a = ht(e, r, t, i.rotation);
                let s = !1;
                if (a && !qo(i)) {
                    const a = Nt(n);
                    "right" !== i.textAlign || i.flipX || (a.x = t.x + t.width - a.width), "center" === i.textAlign && (a.x = t.x + .5 * t.width - .5 * a.width), s = ht(e, r, a, i.rotation, We(t)), s || (o.priority = -1)
                }
                return a
            }
            return No(n) ? ((e, t, o, i, n, r) => {
                const a = dt(Y(o.x, o.y), o.rx, o.ry, i, n, r, 12);
                return ut(e, t, a)
            })(e, r, n, i.rotation, i.flipX, i.flipY) : Uo(n) ? at(e, Math.max(16, r), Do(n), Oo(n)) : !!Xo(n) && ct(e, Math.max(16, r), n.points)
        })).sort(((e, t) => e.priority < t.priority ? 1 : e.priority > t.priority ? -1 : 0)).map((e => e.shape)),
        Xt = (e, t, o, i = 0) => {
            const n = Math.abs(i),
                r = Te(t, o),
                a = Pe(r, n),
                s = (({
                    start: e,
                    end: t
                }, o) => {
                    if (0 === o) return [Y(e.x, e.y), Y(e.x, e.y), Y(t.x, t.y), Y(t.x, t.y)];
                    const i = Math.atan2(t.y - e.y, t.x - e.x),
                        n = Math.sin(i) * o,
                        r = Math.cos(i) * o;
                    return [Y(n + e.x, -r + e.y), Y(-n + e.x, r + e.y), Y(-n + t.x, r + t.y), Y(n + t.x, -r + t.y)]
                })(a, n);
            return e.filter((e => {
                const t = wi(Eo(e), xe);
                if (Uo(t) || Xo(t)) {
                    const e = t.points ? [...t.points] : [Do(t), Oo(t)];
                    return !!((e, t) => {
                        const o = t.length,
                            i = [];
                        for (let n = 0; n < o - 1; n++) {
                            const o = st(e.start, e.end, t[n], t[n + 1]);
                            o && i.push(o)
                        }
                        return i.length ? i : void 0
                    })(a, e)
                }
                return ((e, t) => !!e.find((e => lt(e, t))) || !!t.find((t => lt(t, e))))(s, ((e, t = 12) => {
                    if (Ho(e)) return qe(e, e.rotation, We(e));
                    if (_o(e)) {
                        const t = Ut(e);
                        return qe(t, e.rotation, We(t))
                    }
                    return No(e) ? dt(Y(e.x, e.y), e.rx, e.ry, e.rotation, e.flipX, e.flipY, t) : []
                })(t))
            }))
        };
    let Yt = void 0,
        Gt = void 0,
        qt = void 0,
        Zt = void 0,
        Kt = void 0,
        Qt = !1;
    const eo = e => {
            let t;
            if (Ho(e)) {
                const o = We(e);
                t = tt(e), (e.flipX || e.flipY) && he(t, e.flipX, e.flipY, o.x, o.y), t = pe(t, e.rotation, o.x, o.y)
            } else if (No(e)) {
                const o = e;
                t = tt(De(e)), (e.flipX || e.flipY) && he(t, e.flipX, e.flipY, o.x, o.y), t = pe(t, e.rotation, o.x, o.y)
            } else if (Uo(e)) t = [Do(e), Oo(e)];
            else if (Xo(e)) t = [...e.points];
            else if (_o(e)) {
                const o = Ut(e);
                o.width = Math.max(10, o.width);
                const i = We(o);
                t = tt(o), (e.flipX || e.flipY) && he(t, e.flipX, e.flipY, i.x, i.y), t = pe(t, e.rotation, i.x, i.y)
            }
            return t
        },
        to = e => {
            const t = eo(e);
            let o, i;
            return e.flipY ? (o = ue([t[0], t[1]]), i = ee(Y(t[1].x - t[2].x, t[1].y - t[2].y))) : (o = ue([t[2], t[3]]), i = ee(Y(t[2].x - t[1].x, t[2].y - t[1].y))), ae(i, 20 / ge), {
                origin: o,
                dir: i
            }
        },
        oo = () => {
            const e = G.filter((e => "markup-hover" !== e.id));
            e.length !== G.length && o(47, G = e)
        };
    let io, no = "markup-manipulator-segment";
    const ro = (e, t) => {
            const i = G.find((e => e.id === no)),
                n = i ? Math.max(i.opacity, e) : e,
                r = [],
                a = .1 * n,
                s = n,
                l = [0, 0, 0],
                c = [1, 1, 1],
                d = !Xo(t) && !Uo(t);
            r.push({
                id: no,
                points: p.map((e => Y(e.x + 1, e.y + 1))),
                pathClose: d,
                strokeColor: l,
                strokeWidth: 2,
                opacity: a,
                _group: U
            }), g && r.push({
                id: no,
                points: [Y(g.origin.x + 1, g.origin.y + 1), Y(g.position.x + 1, g.position.y + 1)],
                strokeColor: l,
                strokeWidth: 2,
                opacity: a,
                _group: U
            }), r.push({
                id: no,
                points: p,
                pathClose: d,
                strokeColor: c,
                strokeWidth: 1.5,
                opacity: s,
                _group: U
            }), g && r.push({
                id: no,
                points: [{
                    x: g.origin.x,
                    y: g.origin.y
                }, {
                    x: g.position.x,
                    y: g.position.y
                }],
                strokeColor: c,
                strokeWidth: 1.5,
                opacity: s,
                _group: U
            }), o(47, G = [...G.filter((e => e.id !== no)), ...r])
        },
        lo = () => {
            o(47, G = G.filter((e => 0 === e.opacity && e.id !== no)))
        },
        co = e => e.isContentEditable || /input|textarea/i.test(e.nodeName);
    let uo;
    const ho = e => o(6, uo.innerHTML = (e => e.replace(/ {2,}/g, " ").replace(/&/g, "&amp;").replace(/\u00a0/g, "&nbsp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").split("\n").join("<br>"))(e), uo),
        po = e => {
            let t;
            t = void 0 === e.value ? e.innerHTML.split("<br>").join("\n").replace(/&nbsp;/g, String.fromCharCode(160)).replace(/&amp;/g, "&").replace(/&lt;/g, "<").replace(/&gt;/g, ">") : e.value;
            return Wo(i) ? (e => {
                const t = e.split(/[\n\r]/g);
                return t.length > 1 ? t.map((e => e.trim())).filter((e => e.length)).join(" ") : t[0]
            })(t) : t
        },
        mo = () => {
            const e = po(uo),
                t = ai(i, e),
                o = !0 === t ? e : t;
            let n = b.x,
                r = b.y;
            if (!i.height) {
                const e = qe({
                        ...S
                    }, i.rotation),
                    t = xo(o, a),
                    s = qe({
                        x: n,
                        y: r,
                        ...t
                    }, i.rotation),
                    [l, , c] = e,
                    [d, , u] = s;
                let h = l,
                    p = d;
                i.flipX && (h = c, p = u);
                const m = re(Z(h), p);
                n += m.x, r += m.y
            }
            Rt(i, {
                x: w(x.x) ? ao(n, xe.width) : n,
                y: w(x.y) ? ao(r, xe.height) : r,
                text: o
            })
        },
        go = () => {
            let e = Zo(i);
            Zo(i) && St(), mo(), Vt(i), e ? Ie(i) : Ee(i)
        },
        fo = () => {
            Zo(i) ? Ct() : (Rt(i, {
                text: x.text,
                x: x.x,
                y: x.y
            }), Vt(i))
        },
        $o = (e, t, {
            flipX: o,
            flipY: i,
            rotation: n
        }, r = "top left") => {
            let a, s;
            const [l, c, d, u] = qe(e, n), [h, p, m, g] = qe(t, n);
            if ("top center" === r) {
                a = ue(i ? [u, d] : [l, c]), s = ue(i ? [g, m] : [h, p])
            } else "top right" === r && !o || "top left" === r && o ? (a = i ? d : c, s = i ? m : p) : (a = i ? u : l, s = i ? g : h);
            return re(Z(a), s)
        },
        yo = (e, t, o) => Y(w(e.x) ? ao(t.x + o.x, xe.width) : t.x + o.x, w(e.y) ? ao(t.y + o.y, xe.height) : t.y + o.y),
        bo = {},
        vo = () => Wt(i),
        wo = () => {
            const e = xo(i.text, a),
                t = Jt(i, "height"),
                o = !t && Jt(i, "width"),
                n = i.id;
            let r = bo[n];
            r || (bo[n] = {}, r = bo[n]);
            const s = e => {
                    const {
                        width: t,
                        ...o
                    } = a, n = xo(i.text, o), r = $o(_e(a.x, a.y, e.width, e.height), _e(a.x, a.y, n.width, n.height), a, "top " + i.textAlign);
                    Tt(i, ["width", "height", "textAlign"]), Rt(i, {
                        ...yo(i, a, r)
                    })
                },
                l = t => {
                    const o = be(r.width || a.width || e.width, e.height),
                        n = r.textAlign || "left",
                        s = $o(_e(a.x, a.y, t.width, t.height), _e(a.x, a.y, o.width, o.height), a, "top " + n);
                    Tt(i, ["height"]), Rt(i, {
                        ...yo(i, a, s),
                        width: w(i.width) ? ao(o.width, xe.width) : o.width,
                        textAlign: n
                    })
                },
                c = t => {
                    const o = be(r.width || e.width, r.height || e.height),
                        n = r.textAlign || "left",
                        s = $o(_e(a.x, a.y, t.width, t.height), _e(a.x, a.y, o.width, o.height), a, "top " + n);
                    Rt(i, {
                        ...yo(i, a, s),
                        width: w(i.width) ? ao(o.width, xe.width) : o.width,
                        height: w(i.width) ? ao(o.height, xe.height) : o.height,
                        textAlign: n
                    })
                };
            if (t) {
                r.textAlign = i.textAlign, r.width = a.width, r.height = a.height;
                const e = be(a.width, a.height);
                si(i, "auto-height") ? l(e) : si(i, "auto-width") && s(e)
            } else if (o) {
                r.textAlign = i.textAlign, r.width = a.width;
                const t = be(a.width, e.height);
                si(i, "auto-width") ? s(t) : si(i, "fixed-size") && c(t)
            } else {
                const t = be(e.width, e.height);
                si(i, "fixed-size") ? c(t) : si(i, "auto-height") && l(t)
            }
        },
        So = e => {
            e.stopPropagation();
            const t = i.flipX || !1;
            Pt(i, "flipX", !t), Ee(i)
        },
        Co = e => {
            e.stopPropagation();
            const t = i.flipY || !1;
            Pt(i, "flipY", !t), Ee(i)
        },
        ko = e => {
            Pt(i, "opacity", e), Ee(i)
        },
        Mo = e => {
            e.stopPropagation(), e.target.blur(), Ft()
        },
        To = e => {
            e.stopPropagation();
            q.findIndex((e => e === i)) !== q.length - 1 && (o(0, q = q.filter((e => e !== i)).concat([i])), Ee(i))
        },
        Ro = e => {
            e.stopPropagation();
            const t = Eo(i);
            t.id = T();
            const o = Y(50, -50);
            if (Uo(t)) {
                const e = ki(t, ["x1", "y1", "x2", "y2"], xe);
                e.x1 += o.x, e.y1 += o.y, e.x2 += o.x, e.y2 += o.y, Mi(t, e, xe)
            } else {
                const e = ki(t, ["x", "y"], xe);
                e.x += 50, e.y -= 50, Mi(t, e, xe)
            }
            q.push(t), Ie(t), Ot(t)
        },
        Po = rs(0, {
            stiffness: .2,
            damping: .7
        });
    let Ao;
    cn(e, Po, (e => o(13, N = e)));
    const Lo = (e, t) => {
            const {
                disableTextLayout: o = []
            } = t;
            return "height" in t ? o.includes("auto-height") ? e.shapeIconButtonTextLayoutAutoWidth : e.shapeIconButtonTextLayoutAutoHeight : "width" in t ? o.includes("auto-width") ? e.shapeIconButtonTextLayoutFixedSize : e.shapeIconButtonTextLayoutAutoWidth : o.includes("fixed-size") ? e.shapeIconButtonTextLayoutAutoHeight : e.shapeIconButtonTextLayoutFixedSize
        },
        Fo = (e, t) => {
            const {
                disableTextLayout: o = []
            } = t;
            return "height" in t ? o.includes("auto-height") ? e.shapeTitleButtonTextLayoutAutoWidth : e.shapeTitleButtonTextLayoutAutoHeight : "width" in t ? o.includes("auto-width") ? e.shapeTitleButtonTextLayoutFixedSize : e.shapeTitleButtonTextLayoutAutoWidth : o.includes("fixed-size") ? e.shapeTitleButtonTextLayoutAutoHeight : e.shapeTitleButtonTextLayoutFixedSize
        };
    let zo = !1;
    let Bo = X();
    const jo = e => {
        Ve(e), o(109, io = e)
    };
    qn((() => {
        lo()
    }));
    return e.$$set = e => {
        "uid" in e && o(48, U = e.uid), "ui" in e && o(47, G = e.ui), "markup" in e && o(0, q = e.markup), "offset" in e && o(1, K = e.offset), "contextRotation" in e && o(49, Q = e.contextRotation), "contextFlipX" in e && o(50, de = e.contextFlipX), "contextFlipY" in e && o(51, me = e.contextFlipY), "contextScale" in e && o(52, ge = e.contextScale), "active" in e && o(53, $e = e.active), "opacity" in e && o(54, ye = e.opacity), "parentRect" in e && o(55, xe = e.parentRect), "rootRect" in e && o(2, ve = e.rootRect), "utilRect" in e && o(56, we = e.utilRect), "hoverColor" in e && o(57, Se = e.hoverColor), "textInputMode" in e && o(3, Ce = e.textInputMode), "oninteractionstart" in e && o(58, ke = e.oninteractionstart), "oninteractionupdate" in e && o(59, Me = e.oninteractionupdate), "oninteractionrelease" in e && o(60, Re = e.oninteractionrelease), "oninteractionend" in e && o(61, Ae = e.oninteractionend), "onaddshape" in e && o(62, Ie = e.onaddshape), "onupdateshape" in e && o(63, Ee = e.onupdateshape), "onselectshape" in e && o(64, Le = e.onselectshape), "onremoveshape" in e && o(65, Fe = e.onremoveshape), "ontapshape" in e && o(66, Oe = e.ontapshape), "onhovershape" in e && o(67, Ve = e.onhovershape), "onhovercanvas" in e && o(68, He = e.onhovercanvas), "beforeSelectShape" in e && o(69, Ne = e.beforeSelectShape), "beforeDeselectShape" in e && o(70, Ue = e.beforeDeselectShape), "beforeRemoveShape" in e && o(71, je = e.beforeRemoveShape), "beforeUpdateShape" in e && o(72, Xe = e.beforeUpdateShape), "willRenderShapeControls" in e && o(73, Ye = e.willRenderShapeControls), "mapEditorPointToImagePoint" in e && o(74, Ge = e.mapEditorPointToImagePoint), "mapImagePointToEditorPoint" in e && o(75, Ze = e.mapImagePointToEditorPoint), "eraseRadius" in e && o(76, Ke = e.eraseRadius), "selectRadius" in e && o(77, Je = e.selectRadius), "enableButtonFlipVertical" in e && o(78, ot = e.enableButtonFlipVertical), "enableTapToAddText" in e && o(79, it = e.enableTapToAddText), "locale" in e && o(4, nt = e.locale)
    }, e.$$.update = () => {
        var t, n;
        if (1 & e.$$.dirty[0] && o(110, i = q && (bt() || It())), 131072 & e.$$.dirty[3] && o(111, r = i && !Zo(i) ? i.id : void 0), 4 & e.$$.dirty[0] | 16777216 & e.$$.dirty[1] | 131072 & e.$$.dirty[3] && o(8, a = ve && i && wi(Eo(i), xe)), 131072 & e.$$.dirty[3] && o(112, s = !(!i || !Zo(i))), 256 & e.$$.dirty[0] | 8388608 & e.$$.dirty[1] | 131072 & e.$$.dirty[3] && o(113, l = i && ye && eo(a) || []), 131072 & e.$$.dirty[3] && o(114, c = i && (li(t = i) && ci(t) && !0 !== t.disableResize && (Ko(t) || Vo(t) || No(t) || Uo(t))) && !Yo(i)), 131072 & e.$$.dirty[3] && o(9, d = i && (e => li(e) && !0 !== e.disableRotate && (Ko(e) || Jt(e, "text") || No(e)))(i) && !Yo(i)), 2228224 & e.$$.dirty[3] && o(15, u = c && Jt(i, "text") && !i.height ? "horizontal" : c), 1179648 & e.$$.dirty[3] && o(10, h = i && l.length > 1), 8192 & e.$$.dirty[2] | 1048576 & e.$$.dirty[3] && o(115, p = l.map(Ze)), 2 & e.$$.dirty[0] | 4194304 & e.$$.dirty[3] && o(11, m = p.map((e => Y(e.x - K.x, e.y - K.y)))), 65536 & e.$$.dirty[3] && (io && !qo(io) && ii(io) ? (e => {
                const t = eo(wi(Eo(e), xe)).map(Ze),
                    i = !Xo(e) && !Uo(e),
                    n = {
                        id: "markup-hover",
                        points: t.map((e => Y(e.x + 1, e.y + 1))),
                        strokeColor: [0, 0, 0, .1],
                        strokeWidth: 2,
                        pathClose: i
                    },
                    r = {
                        id: "markup-hover",
                        points: t,
                        strokeColor: Se,
                        strokeWidth: 2,
                        pathClose: i
                    };
                oo(), o(47, G = [...G, n, r])
            })(io) : oo()), 3840 & e.$$.dirty[0] | 8388608 & e.$$.dirty[1] && o(116, g = h && d && ye && m && (e => {
                const t = to(e),
                    o = Ze({
                        x: t.origin.x + t.dir.x,
                        y: t.origin.y + t.dir.y
                    });
                return {
                    origin: Ze(t.origin),
                    position: o
                }
            })(a)), 2 & e.$$.dirty[0] | 8388608 & e.$$.dirty[3] && o(16, f = g && Y(g.position.x - K.x, g.position.y - K.y)), 2048 & e.$$.dirty[0] | 12582912 & e.$$.dirty[1] | 131072 & e.$$.dirty[3])
            if ($e) {
                if (ye > 0) {
                    o(47, G = G.map((e => (e.id !== no || (e._group = U), e))));
                    const e = i && Zo(i) && Xo(i);
                    i && m.length > 2 && !e ? ro(ye, i) : lo()
                }
            } else G.find((e => e._group === U)) && i && ro(ye, i);
        4194304 & e.$$.dirty[1] && (e => {
            if (!e) return At({
                _prerender: !1
            });
            const t = q.find((e => e.isEditing));
            t && Rt(t, {
                _prerender: "inline" === Ce
            })
        })($e), 72 & e.$$.dirty[0] && uo && "inline" === Ce && uo.focus(), 131072 & e.$$.dirty[3] && o(117, $ = i && _o(i)), 16908288 & e.$$.dirty[3] && o(12, y = $ && !1 !== ai(i) && Yo(i)), 4096 & e.$$.dirty[0] && o(118, x = y ? {
            ...i
        } : void 0), 16777216 & e.$$.dirty[1] | 33554432 & e.$$.dirty[3] && o(119, b = x && wi({
            ...x
        }, xe)), 67108864 & e.$$.dirty[3] && o(120, v = b && xo(b.text, b)), 201326592 & e.$$.dirty[3] && (S = b && _e(b.x, b.y, v.width, v.height)), 4096 & e.$$.dirty[0] | 131072 & e.$$.dirty[3] && o(17, C = y ? i.text : ""), 4360 & e.$$.dirty[0] && o(18, k = y && ((e, t) => {
            const {
                textAlign: o = "left",
                fontFamily: i = "sans-serif",
                fontWeight: n = "normal",
                fontStyle: r = "normal"
            } = e, a = e.fontSize, s = "!important", l = `text-align:${o}${s};font-family:${i}${s};font-weight:${n}${s};font-style:${r}${s};`;
            if ("modal" === t) return l;
            const c = so(e.color),
                d = e.lineHeight,
                u = .5 * Math.max(0, a - d);
            return `--bottom-inset:${u}px;padding:${u}px 0 0${s};color:${c}${s};font-size:${a}px${s};line-height:${d}px${s};${l}`
        })(a, Ce)), 4354 & e.$$.dirty[0] | 2359296 & e.$$.dirty[1] && o(19, M = y && ((e, t, o, n) => {
            let r, s;
            e.width && e.height ? (r = We(e), s = fe(e)) : (s = xo(i.text, a), s.width = a.width || s.width, r = Y(e.x + .5 * s.width, e.y + .5 * s.height));
            const l = Math.max(0, e.fontSize - e.lineHeight) + e.lineHeight,
                c = Ze(r);
            let d = c.x - t.x - .5 * s.width,
                u = c.y - t.y - .5 * s.height,
                h = e.flipX,
                p = e.flipY,
                m = e.rotation;
            de && me ? (h = !h, p = !p) : de ? (h = !h, m = -m) : me && (p = !p, m = -m), m += n;
            const g = o * (h ? -1 : 1),
                f = o * (p ? -1 : 1);
            return `--line-height:${l}px;width:${s.width}px;height:${s.height}px;transform:translate(${d}px,${u}px) rotate(${m}rad) scale(${g}, ${f})`
        })(a, K, ge, Q)), 4168 & e.$$.dirty[0] && y && uo && "inline" === Ce && ho(C), 269090816 & e.$$.dirty[3] && o(121, R = i && !s ? i : R), 268435456 & e.$$.dirty[3] && o(122, P = R && ri(R)), 268435456 & e.$$.dirty[3] && o(123, A = R && si(R)), 268435456 & e.$$.dirty[3] && o(124, I = R && (e => !0 !== e.disableDuplicate && ci(e))(R)), 268435456 & e.$$.dirty[3] && o(125, E = R && ni(R)), 268435456 & e.$$.dirty[3] && o(126, L = R && (e => !0 !== e.disableReorder)(R)), 268435456 & e.$$.dirty[3] && o(127, F = R && !1 !== ai(R)), 268435456 & e.$$.dirty[3] && o(128, z = R && Jt(R, "backgroundImage") && oi(R, "opacity")), 4096 & e.$$.dirty[0] | 688128 & e.$$.dirty[3] && Po.set(!i || s || Qt || y ? 0 : 1), 2048 & e.$$.dirty[0] | 655360 & e.$$.dirty[3] | 32 & e.$$.dirty[4] && o(129, B = i && !s ? (n = Be(m), ie(Y(n.x + .5 * n.width, n.y), fc)) : B), 128 & e.$$.dirty[0] | 33554432 & e.$$.dirty[1] | 32 & e.$$.dirty[4] && o(130, D = B && Ao && we && (e => {
            const t = we.x,
                o = we.y,
                i = t + we.width;
            let n = Math.max(e.x - .5 * Ao.width, t),
                r = Math.max(e.y - Ao.height - 16, o);
            return n + Ao.width > i && (n = i - Ao.width), Y(n, r)
        })(B)), 8192 & e.$$.dirty[0] | 64 & e.$$.dirty[4] && o(20, O = D && `transform: translate(${D.x}px, ${D.y}px);opacity:${N}`), 16 & e.$$.dirty[0] | 67584 & e.$$.dirty[2] | 1611005952 & e.$$.dirty[3] | 31 & e.$$.dirty[4] && o(21, W = r && Ye([z && ["div", "alpha", {
                    class: "PinturaShapeControlsGroup"
                },
                [
                    ["Slider", "adjust-opacity", {
                        onchange: ko,
                        step: .01,
                        value: Jt(i, "opacity") ? i.opacity : 1,
                        label: (e, t, o) => Math.round(e / o * 100) + "%",
                        min: 0,
                        max: 1,
                        direction: "x"
                    }]
                ]
            ],
            ["div", "beta", {
                    class: "PinturaShapeControlsGroup"
                },
                [P && ["Button", "flip-horizontal", {
                    onclick: So,
                    label: nt.shapeTitleButtonFlipHorizontal,
                    icon: nt.shapeIconButtonFlipHorizontal,
                    hideLabel: !0
                }], P && ot && ["Button", "flip-vertical", {
                    onclick: Co,
                    label: nt.shapeTitleButtonFlipVertical,
                    icon: nt.shapeIconButtonFlipVertical,
                    hideLabel: !0
                }], L && ["Button", "to-front", {
                    onclick: To,
                    label: nt.shapeTitleButtonMoveToFront,
                    icon: nt.shapeIconButtonMoveToFront,
                    hideLabel: !0
                }], I && ["Button", "duplicate", {
                    onclick: Ro,
                    label: nt.shapeTitleButtonDuplicate,
                    icon: nt.shapeIconButtonDuplicate,
                    hideLabel: !0
                }], E && ["Button", "remove", {
                    onclick: Mo,
                    label: nt.shapeTitleButtonRemove,
                    icon: nt.shapeIconButtonRemove,
                    hideLabel: !0
                }]].filter(Boolean)
            ], F && A && ["div", "gamma", {
                    class: "PinturaShapeControlsGroup"
                },
                [
                    ["Button", "text-layout", {
                        onclick: wo,
                        label: Ic(Fo, nt, i),
                        icon: Ic(Lo, nt, i),
                        hideLabel: !0
                    }]
                ]
            ], F && ["div", "delta", {
                    class: "PinturaShapeControlsGroup"
                },
                [
                    ["Button", "edit-text", {
                        label: nt.shapeLabelInputText,
                        onclick: vo
                    }]
                ]
            ]
        ].filter(Boolean), r)), 17 & e.$$.dirty[0] && o(22, V = q.filter(ii).filter((e => !Zo(e))).map((e => ({
            id: e.id,
            color: _o(e) ? e.color : Uo(e) ? e.strokeColor : e.backgroundColor,
            name: e.name || nt["shapeLabelTool" + Yr($i(e))]
        }))))
    }, [q, K, ve, Ce, nt, Ot, uo, Ao, a, d, h, m, y, N, zo, u, f, C, k, M, O, W, V, pt, e => {
        const {
            origin: t
        } = e.detail;
        qt = void 0, Zt = void 0, Kt = void 0, Gt = void 0, clearTimeout(Yt), Yt = setTimeout((() => o(108, Qt = !0)), 250);
        bt() && St();
        const n = Ge(Z(t)),
            r = jt(n, Je, (e => ii(e))),
            a = r.length && r.shift();
        if (!a && i && Yo(i) && _t(i), a && qo(a)) return qt = a, Zt = Eo(qt), void(Kt = wi(Eo(qt), xe));
        Gt = a;
        !ke(e) && a && (Ot(a), qt = a, Zt = Eo(qt), Kt = wi(Eo(qt), xe))
    }, e => {
        if (qt) {
            if (!ci(qt)) return;
            if (Yo(qt)) return;
            return ft(qt, Kt, e.detail.translation)
        }
        Me(e)
    }, e => {
        clearTimeout(Yt), Yt = void 0, o(108, Qt = !1), qt ? Yo(qt) ? fo() : e.detail.isTap && _o(qt) && !1 !== ai(qt) && Wt(qt) : Re(e)
    }, e => {
        const t = Gt && e.detail.isTap;
        if (qt) return Oe(qt), o = qt, i = Zt, JSON.stringify(o) !== JSON.stringify(i) && Ee(qt), void(qt = void 0);
        var o, i;
        const n = Dt(),
            r = !n || Ue(n, Gt);
        r && Bt(), Ae(e), r && t && Ot(Gt)
    }, e => {
        o(108, Qt = !0), qt = i, Kt = a
    }, e => {
        const {
            translation: t,
            indexes: o,
            shiftKey: i
        } = e.detail;
        ((e, t, o, i, n) => {
            if (Uo(e)) {
                const [n] = o, r = H.includes(16) ? (e, t) => {
                    const o = ce(e, t),
                        i = te(e, t),
                        n = Math.PI / 4,
                        r = n * Math.round(i / n) - Q % n;
                    t.x = e.x + o * Math.cos(r), t.y = e.y + o * Math.sin(r)
                } : (e, t) => t;
                if (0 === n) {
                    const o = gt(Do(t), i);
                    r(Y(t.x2, t.y2), o), rt(e, {
                        x1: o.x,
                        y1: o.y
                    }, xe)
                } else if (1 === n) {
                    const o = gt(Oo(t), i);
                    r(Y(t.x1, t.y1), o), rt(e, {
                        x2: o.x,
                        y2: o.y
                    }, xe)
                }
            } else if (Ko(e) || No(e) || Vo(e)) {
                let r, a, s = !1;
                if (No(e)) r = De(t);
                else if (Ko(e)) r = ze(t);
                else {
                    s = !0, r = ze(t);
                    const e = xo(t.text, t);
                    r.height = e.height
                }
                e.aspectRatio ? a = e.aspectRatio : n.shiftKey && !s && (a = r.width / r.height);
                const l = ze(r),
                    c = We(l),
                    d = e.rotation,
                    u = tt(l),
                    h = qe(l, d);
                if (1 === o.length) {
                    let t = o[0];
                    e.flipX && (t = $t[t]), e.flipY && (t = yt[t]);
                    const [n, r, s, l] = u, p = Ze(h[t]);
                    ne(p, i);
                    const m = Ge(p),
                        g = Y(m.x - h[t].x, m.y - h[t].y),
                        f = J(Z(g), -d),
                        $ = Y(u[t].x + f.x, u[t].y + f.y);
                    let y;
                    0 === t && (y = s), 1 === t && (y = l), 2 === t && (y = n), 3 === t && (y = r);
                    const x = Be([y, $]);
                    if (a) {
                        const {
                            width: e,
                            height: t
                        } = Qe(x, a), [o, i, n, r] = et(x);
                        x.width = e, x.height = t, $.y < y.y && (x.y = n - t), $.x < y.x && (x.x = i - e)
                    }
                    const b = qe(x, d, c),
                        v = ue(b),
                        w = J(b[0], -d, v),
                        S = J(b[2], -d, v),
                        C = Be([w, S]);
                    rt(e, No(e) ? j(C) : C, xe)
                } else {
                    o = o.map((t => (e.flipX && (t = $t[t]), e.flipY && (t = yt[t]), t)));
                    const [t, n] = o.map((e => h[e])), r = {
                        x: t.x + .5 * (n.x - t.x),
                        y: t.y + .5 * (n.y - t.y)
                    }, [l, p] = o.map((e => u[e])), [m, g] = o.map((e => {
                        const t = e + 2;
                        return t < 4 ? u[t] : u[t - 4]
                    })), f = {
                        x: m.x + .5 * (g.x - m.x),
                        y: m.y + .5 * (g.y - m.y)
                    }, $ = Ze(r);
                    ne($, i);
                    const y = Ge($),
                        x = Y(y.x - r.x, y.y - r.y),
                        b = J(Z(x), -d),
                        v = re(Z(l), p),
                        w = ie(v, (e => 1 - Math.abs(Math.sign(e)))),
                        S = Y(b.x * w.x, b.y * w.y);
                    ne(l, S), ne(p, S);
                    const C = Be(u);
                    if (a) {
                        let e = C.width,
                            t = C.height;
                        0 === w.y ? t = e / a : e = t * a, C.width = e, C.height = t, 0 === w.y ? C.y = f.y - .5 * t : C.x = f.x - .5 * e
                    }
                    const k = qe(C, d, c),
                        M = ue(k),
                        T = J(k[0], -d, M),
                        R = J(k[2], -d, M),
                        P = Be([T, R]);
                    let A;
                    No(e) ? A = j(P) : Ko(e) ? A = P : s && (A = {
                        x: P.x,
                        y: P.y,
                        width: P.width
                    }), rt(e, A, xe)
                }
            }
            kt()
        })(qt, Kt, o, t, {
            shiftKey: i
        })
    }, e => {
        Ot(qt);
        const {
            isTap: t
        } = e.detail;
        t && Oe(qt), qt = void 0, o(108, Qt = !1), Ee(i)
    }, e => {
        xt = to(a).origin, o(108, Qt = !0), qt = i, Kt = a
    }, e => {
        const {
            translation: t,
            shiftKey: o
        } = e.detail;
        ((e, t, o, i) => {
            const n = Ut(wi(Eo(e), xe)),
                r = We(n),
                a = gt(xt, o);
            let s = te(a, r) + Math.PI / 2;
            if (i.shiftKey) {
                const e = Math.PI / 16;
                s = e * Math.round(s / e) - Q % e
            }
            rt(e, {
                rotation: s
            }, xe), kt()
        })(qt, 0, t, {
            shiftKey: o
        })
    }, () => {
        Ot(qt), qt = void 0, o(108, Qt = !1), Ee(i)
    }, e => {
        if (!Et()) return;
        const {
            key: t
        } = e;
        if (/escape/i.test(t)) return e.preventDefault(), e.stopPropagation(), _t(i);
        /backspace/i.test(t) && !co(e.target) && (e.preventDefault(), Ft())
    }, e => {
        const t = ai(i, e);
        return !0 === t ? e : t
    }, mo, e => {
        const {
            target: t,
            key: o
        } = e, n = t.value || t.innerText, r = t.selectionStart || 0, a = t.selectionEnd || n.length, s = n.substring(0, r) + o + n.substring(a);
        if (ai(i, s) !== s) return e.preventDefault()
    }, e => Wo(i) && /enter/i.test(e.code) ? e.preventDefault() : /arrow/i.test(e.code) ? e.stopPropagation() : /escape/i.test(e.key) ? fo() : void 0, e => {
        const {
            key: t,
            ctrlKey: o,
            altKey: i
        } = e;
        if (/enter/i.test(t) && (o || i)) return go()
    }, go, fo, Po, e => {
        const t = It();
        t && (Yo(t) || ci(t) && (qt = t, Kt = wi(Eo(qt), xe), ft(qt, Kt, e.detail)))
    }, e => {
        o(14, zo = !0)
    }, ({
        relatedTarget: e
    }) => {
        e && e.classList.contains("shape-selector__button") || o(14, zo = !1)
    }, e => {
        if (Qt || Yt) return jo(void 0);
        const t = Tg(e, ve),
            o = ie(Ge(t), (e => Math.round(e)));
        if (oe(o, Bo)) return;
        Bo = Z(o), He(t, o);
        const [i] = jt(o, 0, (e => ii(e)));
        i && Zo(i) || jo(i)
    }, G, U, Q, de, me, ge, $e, ye, xe, we, Se, ke, Me, Re, Ae, Ie, Ee, Le, Fe, Oe, Ve, He, Ne, Ue, je, Xe, Ye, Ge, Ze, Ke, Je, ot, it, (e, t = {}) => {
        let o, i, n, r = No(e),
            a = _o(e),
            s = "relative" === t.position;
        return Xo(e) ? {
            start: t => {
                const {
                    origin: r
                } = t.detail;
                i = 4, o = Z(r), n = Z(r);
                const a = Ge(r);
                s && (a.x = s ? ao(a.x, xe.width) : a.x, a.y = s ? ao(a.y, xe.height) : a.y), wt({
                    ...e,
                    points: [a]
                })
            },
            update: e => {
                const t = bt(),
                    {
                        translation: r
                    } = e.detail,
                    a = Y(o.x + r.x, o.y + r.y),
                    l = ce(n, a);
                if (Io(l, 5) <= i) return;
                const c = te(a, n),
                    d = i - l;
                n.x += d * Math.cos(c), n.y += d * Math.sin(c);
                const u = Ge(n);
                u && (u.x = s ? ao(u.x, xe.width) : u.x, u.y = s ? ao(u.y, xe.height) : u.y), t.points = t.points.concat(u), kt()
            },
            release: e => e.detail.preventInertia(),
            end: e => {
                if (e.detail.isTap) return Ct();
                const t = St();
                Ie(t)
            }
        } : r || a || Ho(e) ? {
            start: t => {
                const {
                    origin: i
                } = t.detail;
                o = Z(i);
                const n = Ge(o),
                    a = {
                        ...e,
                        rotation: -1 * mt(Q, de, me),
                        x: s ? ao(n.x, xe.width) : n.x,
                        y: s ? ao(n.y, xe.height) : n.y
                    };
                a.flipX = de, a.flipY = me, delete a.position, a.opacity = 0, r ? (a.rx = s ? "0%" : 0, a.ry = s ? "0%" : 0) : (a.width = s ? "0%" : 0, a.height = s ? "0%" : 0), wt(a)
            },
            update: e => {
                const t = bt();
                t.opacity = 1;
                const {
                    aspectRatio: i
                } = t;
                let {
                    translation: n
                } = e.detail;
                if (i) {
                    const e = Math.abs(n.x) * i;
                    n.x = n.x, n.y = e * Math.sign(n.y)
                }
                const a = Y(o.x + n.x, o.y + n.y),
                    s = Ge(o),
                    l = Ge(a),
                    c = {
                        x: s.x + .5 * (l.x - s.x),
                        y: s.y + .5 * (l.y - s.y)
                    },
                    d = mt(Q, de, me);
                J(s, d, c), J(l, d, c);
                const u = Math.min(s.x, l.x),
                    h = Math.min(s.y, l.y);
                let p = Math.max(s.x, l.x) - u,
                    m = Math.max(s.y, l.y) - h,
                    g = {};
                r ? (g.x = u + .5 * p, g.y = h + .5 * m, g.rx = .5 * p, g.ry = .5 * m) : (g.x = u, g.y = h, g.width = p, g.height = m), rt(t, g, xe), kt()
            },
            release: e => {
                e.detail.preventInertia()
            },
            end: e => {
                const t = bt();
                if (e.detail.isTap) {
                    if (!_o(t) || !it || Gt) return Ct();
                    delete t.width, delete t.height, delete t.textAlign;
                    const e = wi({
                            ...t
                        }, xe),
                        i = xo(t.text, e);
                    i.width *= ge, i.height *= ge;
                    const n = Ge({
                            x: o.x,
                            y: o.y - .5 * i.height
                        }),
                        r = Ge({
                            x: o.x + i.width,
                            y: o.y + .5 * i.height
                        }),
                        a = {
                            x: n.x + .5 * (r.x - n.x),
                            y: n.y + .5 * (r.y - n.y)
                        },
                        s = mt(Q, de, me);
                    J(n, s, a), J(r, s, a);
                    const l = Math.min(n.x, r.x),
                        c = Math.min(n.y, r.y);
                    t.x = w(t.x) ? ao(l, xe.width) : l, t.y = w(t.y) ? ao(c, xe.height) : c
                }
                if (t.opacity = 1, !_o(t)) {
                    const e = St();
                    Ie(e)
                }
                Ot(t), _o(t) && Wt(t)
            }
        } : Uo(e) ? {
            start: t => {
                const {
                    origin: i
                } = t.detail, n = Ge(i), r = ie(n, fc);
                o = Z(i), wt({
                    ...e,
                    x1: s ? ao(r.x, xe.width) : r.x,
                    y1: s ? ao(r.y, xe.height) : r.y,
                    x2: s ? ao(r.x, xe.width) : r.x,
                    y2: s ? ao(r.y, xe.height) : r.y,
                    opacity: 0
                })
            },
            update: e => {
                const t = bt(),
                    {
                        translation: i
                    } = e.detail,
                    n = ne(Z(o), i);
                if (H.includes(16)) {
                    const e = ce(o, n),
                        t = te(o, n),
                        i = Math.PI / 4,
                        r = i * Math.round(t / i);
                    n.x = o.x + e * Math.cos(r), n.y = o.y + e * Math.sin(r)
                }
                const r = Ge(n);
                Rt(t, {
                    x2: s ? ao(r.x, xe.width) : r.x,
                    y2: s ? ao(r.y, xe.height) : r.y,
                    opacity: 1
                }), kt()
            },
            release: e => e.detail.preventInertia(),
            end: e => {
                const t = bt();
                if (e.detail.isTap) return Ct();
                t.opacity = 1;
                const o = St();
                Ie(o), Ot(o)
            }
        } : void 0
    }, () => {
        let e, t;
        const o = Ke * Ke,
            i = (e, t, i = !1) => {
                const n = le(e, t);
                if (!i && n < 2) return !1;
                const r = q.filter((e => !e.disableErase));
                let a;
                a = n < o ? jt(Ge(t), Ke) : Xt(r, Ge(e), Ge(t), Ke);
                return Ht(a).forEach(Fe), !0
            };
        return {
            start: o => {
                e = Y(Math.round(o.detail.origin.x), Math.round(o.detail.origin.y)), i(e, e, !0), t = e
            },
            update: o => {
                const {
                    translation: n
                } = o.detail, r = Y(Math.round(e.x + n.x), Math.round(e.y + n.y));
                i(t, r) && (t = Z(r))
            },
            release: e => e.detail.preventInertia(),
            end: () => {}
        }
    }, bt, vt, wt, St, Ct, (e = {}) => ({
        id: T(),
        ...e
    }), kt, Mt, Tt, Rt, Pt, (e, t, o = !0) => {
        q.forEach((o => Pt(o, e, t, !1))), o && kt()
    }, At, It, Et, Lt, Ft, Bt, _t, Wt, Vt, Ht, Nt, Ut, jt, Xt, Qt, io, i, r, s, l, c, p, g, $, x, b, v, R, P, A, I, E, L, F, z, B, D, function (t) {
        Qn(e, t)
    }, (e, t) => Ot(q[e]), function (e) {
        tr[e ? "unshift" : "push"]((() => {
            uo = e, o(6, uo)
        }))
    }, function () {
        C = this.value, o(17, C), o(12, y), o(110, i), o(117, $), o(0, q)
    }, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            uo = e, o(6, uo)
        }))
    }, e => o(7, Ao = e.detail), e => Tg(e, ve)]
}
class Gg extends Fr {
    constructor(e) {
        super(), Lr(this, e, Yg, Xg, an, {
            uid: 48,
            ui: 47,
            markup: 0,
            offset: 1,
            contextRotation: 49,
            contextFlipX: 50,
            contextFlipY: 51,
            contextScale: 52,
            active: 53,
            opacity: 54,
            parentRect: 55,
            rootRect: 2,
            utilRect: 56,
            hoverColor: 57,
            textInputMode: 3,
            oninteractionstart: 58,
            oninteractionupdate: 59,
            oninteractionrelease: 60,
            oninteractionend: 61,
            onaddshape: 62,
            onupdateshape: 63,
            onselectshape: 64,
            onremoveshape: 65,
            ontapshape: 66,
            onhovershape: 67,
            onhovercanvas: 68,
            beforeSelectShape: 69,
            beforeDeselectShape: 70,
            beforeRemoveShape: 71,
            beforeUpdateShape: 72,
            willRenderShapeControls: 73,
            mapEditorPointToImagePoint: 74,
            mapImagePointToEditorPoint: 75,
            eraseRadius: 76,
            selectRadius: 77,
            enableButtonFlipVertical: 78,
            enableTapToAddText: 79,
            locale: 4,
            createShape: 80,
            eraseShape: 81,
            getMarkupItemDraft: 82,
            getMarkupItemDraftIndex: 83,
            addMarkupItemDraft: 84,
            confirmMarkupItemDraft: 85,
            discardMarkupItemDraft: 86,
            createMarkupItem: 87,
            syncShapes: 88,
            addShape: 89,
            removeMarkupShapeProps: 90,
            updateMarkupShape: 91,
            updateMarkupShapeProperty: 92,
            updateMarkupItemsShapeProperty: 93,
            updateMarkupShapeItems: 94,
            getActiveMarkupItem: 95,
            hasActiveMarkupItem: 96,
            removeShape: 97,
            removeActiveMarkupItem: 98,
            blurShapes: 99,
            selectShape: 5,
            deselectMarkupItem: 100,
            editMarkupItem: 101,
            finishEditMarkupItem: 102,
            removeMarkupItems: 103,
            getTextShapeRect: 104,
            getMarkupShapeRect: 105,
            getShapesNearPosition: 106,
            getShapesBetweenPoints: 107
        }, [-1, -1, -1, -1, -1, -1, -1])
    }
    get createShape() {
        return this.$$.ctx[80]
    }
    get eraseShape() {
        return this.$$.ctx[81]
    }
    get getMarkupItemDraft() {
        return this.$$.ctx[82]
    }
    get getMarkupItemDraftIndex() {
        return this.$$.ctx[83]
    }
    get addMarkupItemDraft() {
        return this.$$.ctx[84]
    }
    get confirmMarkupItemDraft() {
        return this.$$.ctx[85]
    }
    get discardMarkupItemDraft() {
        return this.$$.ctx[86]
    }
    get createMarkupItem() {
        return this.$$.ctx[87]
    }
    get syncShapes() {
        return this.$$.ctx[88]
    }
    get addShape() {
        return this.$$.ctx[89]
    }
    get removeMarkupShapeProps() {
        return this.$$.ctx[90]
    }
    get updateMarkupShape() {
        return this.$$.ctx[91]
    }
    get updateMarkupShapeProperty() {
        return this.$$.ctx[92]
    }
    get updateMarkupItemsShapeProperty() {
        return this.$$.ctx[93]
    }
    get updateMarkupShapeItems() {
        return this.$$.ctx[94]
    }
    get getActiveMarkupItem() {
        return this.$$.ctx[95]
    }
    get hasActiveMarkupItem() {
        return this.$$.ctx[96]
    }
    get removeShape() {
        return this.$$.ctx[97]
    }
    get removeActiveMarkupItem() {
        return this.$$.ctx[98]
    }
    get blurShapes() {
        return this.$$.ctx[99]
    }
    get selectShape() {
        return this.$$.ctx[5]
    }
    get deselectMarkupItem() {
        return this.$$.ctx[100]
    }
    get editMarkupItem() {
        return this.$$.ctx[101]
    }
    get finishEditMarkupItem() {
        return this.$$.ctx[102]
    }
    get removeMarkupItems() {
        return this.$$.ctx[103]
    }
    get getTextShapeRect() {
        return this.$$.ctx[104]
    }
    get getMarkupShapeRect() {
        return this.$$.ctx[105]
    }
    get getShapesNearPosition() {
        return this.$$.ctx[106]
    }
    get getShapesBetweenPoints() {
        return this.$$.ctx[107]
    }
}

function qg(e, t, o) {
    const i = e.slice();
    return i[7] = t[o], i
}

function Zg(e, t) {
    let o, i, n, r, a, s, l, c = Ic(t[7].componentProps.title, t[1]) + "";
    const d = [t[7].componentProps];
    var u = t[7].component;

    function h(e) {
        let t = {};
        for (let e = 0; e < d.length; e += 1) t = en(t, d[e]);
        return {
            props: t
        }
    }
    return u && (a = new u(h())), {
        key: e,
        first: null,
        c() {
            o = Mn("li"), i = Mn("span"), n = Rn(c), r = Pn(), a && Pr(a.$$.fragment), s = Pn(), Fn(i, "class", "PinturaShapeStyleLabel"), Fn(o, "class", "PinturaShapeStyle"), this.first = o
        },
        m(e, t) {
            Cn(e, o, t), Sn(o, i), Sn(i, n), Sn(o, r), a && Ar(a, o, null), Sn(o, s), l = !0
        },
        p(e, i) {
            t = e, (!l || 3 & i) && c !== (c = Ic(t[7].componentProps.title, t[1]) + "") && Bn(n, c);
            const r = 1 & i ? Mr(d, [Tr(t[7].componentProps)]) : {};
            if (u !== (u = t[7].component)) {
                if (a) {
                    fr();
                    const e = a;
                    xr(e.$$.fragment, 1, 0, (() => {
                        Ir(e, 1)
                    })), $r()
                }
                u ? (a = new u(h()), Pr(a.$$.fragment), yr(a.$$.fragment, 1), Ar(a, o, s)) : a = null
            } else u && a.$set(r)
        },
        i(e) {
            l || (a && yr(a.$$.fragment, e), l = !0)
        },
        o(e) {
            a && xr(a.$$.fragment, e), l = !1
        },
        d(e) {
            e && kn(o), a && Ir(a)
        }
    }
}

function Kg(e) {
    let t, o, i = [],
        n = new Map,
        r = e[0];
    const a = e => e[7].id;
    for (let t = 0; t < r.length; t += 1) {
        let o = qg(e, r, t),
            s = a(o);
        n.set(s, i[t] = Zg(s, o))
    }
    return {
        c() {
            t = Mn("ul");
            for (let e = 0; e < i.length; e += 1) i[e].c();
            Fn(t, "class", "PinturaShapeStyleList")
        },
        m(e, n) {
            Cn(e, t, n);
            for (let e = 0; e < i.length; e += 1) i[e].m(t, null);
            o = !0
        },
        p(e, o) {
            3 & o && (r = e[0], fr(), i = kr(i, o, a, 1, e, r, n, t, Cr, Zg, null, qg), $r())
        },
        i(e) {
            if (!o) {
                for (let e = 0; e < r.length; e += 1) yr(i[e]);
                o = !0
            }
        },
        o(e) {
            for (let e = 0; e < i.length; e += 1) xr(i[e]);
            o = !1
        },
        d(e) {
            e && kn(t);
            for (let e = 0; e < i.length; e += 1) i[e].d()
        }
    }
}

function Jg(e) {
    let t, o, i;
    return o = new Kl({
        props: {
            class: "PinturaShapeStyles",
            elasticity: e[2],
            $$slots: {
                default: [Kg]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), Fn(t, "style", e[3])
        },
        m(e, n) {
            Cn(e, t, n), Ar(o, t, null), i = !0
        },
        p(e, [n]) {
            const r = {};
            4 & n && (r.elasticity = e[2]), 1027 & n && (r.$$scope = {
                dirty: n,
                ctx: e
            }), o.$set(r), (!i || 8 & n) && Fn(t, "style", e[3])
        },
        i(e) {
            i || (yr(o.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), i = !1
        },
        d(e) {
            e && kn(t), Ir(o)
        }
    }
}

function Qg(e, t, o) {
    let i, n, {
            isActive: r = !1
        } = t,
        {
            controls: a = []
        } = t,
        {
            locale: s
        } = t,
        {
            scrollElasticity: l
        } = t;
    const c = rs(0);
    return cn(e, c, (e => o(6, n = e))), e.$$set = e => {
        "isActive" in e && o(5, r = e.isActive), "controls" in e && o(0, a = e.controls), "locale" in e && o(1, s = e.locale), "scrollElasticity" in e && o(2, l = e.scrollElasticity)
    }, e.$$.update = () => {
        32 & e.$$.dirty && c.set(r ? 1 : 0), 96 & e.$$.dirty && o(3, i = `opacity:${n};${r?"":"pointer-events:none;"}${n<=0?"visibility:hidden":""}`)
    }, [a, s, l, i, c, r, n]
}
class ef extends Fr {
    constructor(e) {
        super(), Lr(this, e, Qg, Jg, an, {
            isActive: 5,
            controls: 0,
            locale: 1,
            scrollElasticity: 2
        })
    }
}

function tf(e, t, o) {
    const i = e.slice();
    return i[11] = t[o].key, i[2] = t[o].controls, i[12] = t[o].isActive, i
}

function of (e, t) {
    let o, i, n;
    return i = new ef({
        props: {
            isActive: t[12],
            controls: t[2],
            locale: t[0],
            scrollElasticity: t[1]
        }
    }), {
        key: e,
        first: null,
        c() {
            o = An(), Pr(i.$$.fragment), this.first = o
        },
        m(e, t) {
            Cn(e, o, t), Ar(i, e, t), n = !0
        },
        p(e, o) {
            t = e;
            const n = {};
            8 & o && (n.isActive = t[12]), 8 & o && (n.controls = t[2]), 1 & o && (n.locale = t[0]), 2 & o && (n.scrollElasticity = t[1]), i.$set(n)
        },
        i(e) {
            n || (yr(i.$$.fragment, e), n = !0)
        },
        o(e) {
            xr(i.$$.fragment, e), n = !1
        },
        d(e) {
            e && kn(o), Ir(i, e)
        }
    }
}

function nf(e) {
    let t, o, i = [],
        n = new Map,
        r = e[3];
    const a = e => e[11];
    for (let t = 0; t < r.length; t += 1) {
        let o = tf(e, r, t),
            s = a(o);
        n.set(s, i[t] = of (s, o))
    }
    return {
        c() {
            t = Mn("div");
            for (let e = 0; e < i.length; e += 1) i[e].c();
            Fn(t, "class", "PinturaShapeStyleEditor")
        },
        m(e, n) {
            Cn(e, t, n);
            for (let e = 0; e < i.length; e += 1) i[e].m(t, null);
            o = !0
        },
        p(e, [o]) {
            11 & o && (r = e[3], fr(), i = kr(i, o, a, 1, e, r, n, t, Cr, of , null, tf), $r())
        },
        i(e) {
            if (!o) {
                for (let e = 0; e < r.length; e += 1) yr(i[e]);
                o = !0
            }
        },
        o(e) {
            for (let e = 0; e < i.length; e += 1) xr(i[e]);
            o = !1
        },
        d(e) {
            e && kn(t);
            for (let e = 0; e < i.length; e += 1) i[e].d()
        }
    }
}

function rf(e, t, o) {
    let i, n, r, {
            controls: a = {}
        } = t,
        {
            shape: s
        } = t,
        {
            onchange: l
        } = t,
        {
            locale: c
        } = t,
        {
            scrollElasticity: d
        } = t;
    const u = [];
    return e.$$set = e => {
        "controls" in e && o(2, a = e.controls), "shape" in e && o(4, s = e.shape), "onchange" in e && o(5, l = e.onchange), "locale" in e && o(0, c = e.locale), "scrollElasticity" in e && o(1, d = e.scrollElasticity)
    }, e.$$.update = () => {
        4 & e.$$.dirty && o(6, i = Object.keys(a).filter((e => a[e]))), 80 & e.$$.dirty && o(7, n = s && i && oi(s) ? (e => i.filter((t => t.split("_").every((t => Jt(e, t) && oi(e, t))))).map((t => {
            const o = t.split("_"),
                i = o.length > 1 ? o.map((t => e[t])) : e[t];
            let [n, r] = a[t];
            if (w(n))
                if (a[n]) {
                    const e = {
                        ...r
                    };
                    [n, r] = a[n], r = {
                        ...r,
                        ...e
                    }
                } else {
                    if ("Dropdown" !== n) return;
                    n = $d
                } const s = S(r.options) ? r.options(e) : r.options;
            return {
                id: t,
                component: n,
                componentProps: {
                    ...r,
                    options: s,
                    locale: c,
                    value: i,
                    optionLabelClass: "PinturaButtonLabel",
                    onchange: i => {
                        const n = x(i) && !Qt(i) ? i.value : i;
                        r.onchange && r.onchange(n, e);
                        const a = o.length > 1 ? o.reduce(((e, t, o) => ({
                            ...e,
                            [t]: Array.isArray(n) ? n[o] : n
                        })), {}) : {
                            [t]: n
                        };
                        l(a)
                    }
                }
            }
        })).filter(Boolean))(s) : []), 144 & e.$$.dirty && o(3, r = ((e, t) => {
            let o = u.find((t => t.key === e));
            return o || (o = {
                key: e,
                controls: t
            }, u.push(o)), u.forEach((e => e.isActive = !1)), o.controls = t, o.isActive = !0, u
        })(s ? Object.keys(s).join("_") : "none", n || []))
    }, [c, d, a, r, s, l, i, n]
}
class af extends Fr {
    constructor(e) {
        super(), Lr(this, e, rf, nf, an, {
            controls: 2,
            shape: 4,
            onchange: 5,
            locale: 0,
            scrollElasticity: 1
        })
    }
}

function sf(e) {
    let t, o, i;
    return {
        c() {
            t = Mn("button"), Fn(t, "class", "PinturaDragButton"), Fn(t, "title", e[1]), t.disabled = e[2]
        },
        m(n, r) {
            Cn(n, t, r), t.innerHTML = e[0], e[9](t), o || (i = In(t, "pointerdown", e[4]), o = !0)
        },
        p(e, [o]) {
            1 & o && (t.innerHTML = e[0]), 2 & o && Fn(t, "title", e[1]), 4 & o && (t.disabled = e[2])
        },
        i: Ji,
        o: Ji,
        d(n) {
            n && kn(t), e[9](null), o = !1, i()
        }
    }
}

function lf(e, t, o) {
    let i, {
            html: r
        } = t,
        {
            title: a
        } = t,
        {
            onclick: s
        } = t,
        {
            disabled: l = !1
        } = t,
        {
            ongrab: c = n
        } = t,
        {
            ondrag: d = n
        } = t,
        {
            ondrop: u = n
        } = t;
    const h = e => le(p, Y(e.pageX, e.pageY)) < 256;
    let p;
    const m = e => {
            document.documentElement.removeEventListener("pointermove", g), document.documentElement.removeEventListener("pointerup", m);
            const t = Y(e.pageX, e.pageY);
            if (le(p, t) < 32) return s(e);
            h(e) || u(e)
        },
        g = e => {
            h(e) || d(e)
        };
    return e.$$set = e => {
        "html" in e && o(0, r = e.html), "title" in e && o(1, a = e.title), "onclick" in e && o(5, s = e.onclick), "disabled" in e && o(2, l = e.disabled), "ongrab" in e && o(6, c = e.ongrab), "ondrag" in e && o(7, d = e.ondrag), "ondrop" in e && o(8, u = e.ondrop)
    }, [r, a, l, i, e => {
        p = Y(e.pageX, e.pageY), c(e), document.documentElement.addEventListener("pointermove", g), document.documentElement.addEventListener("pointerup", m)
    }, s, c, d, u, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            i = e, o(3, i)
        }))
    }]
}
class cf extends Fr {
    constructor(e) {
        super(), Lr(this, e, lf, sf, an, {
            html: 0,
            title: 1,
            onclick: 5,
            disabled: 2,
            ongrab: 6,
            ondrag: 7,
            ondrop: 8
        })
    }
}

function df(e, t, o) {
    const i = e.slice();
    return i[14] = t[o], i
}

function uf(e, t) {
    let o, i, n, r, a, s, l;

    function c() {
        return t[10](t[14])
    }

    function d(...e) {
        return t[11](t[14], ...e)
    }

    function u(...e) {
        return t[12](t[14], ...e)
    }

    function h(...e) {
        return t[13](t[14], ...e)
    }
    return i = new cf({
        props: {
            onclick: c,
            ongrab: d,
            ondrag: u,
            ondrop: h,
            disabled: t[1] || t[14].disabled,
            title: t[14].title,
            html: t[14].thumb
        }
    }), {
        key: e,
        first: null,
        c() {
            o = Mn("li"), Pr(i.$$.fragment), n = Pn(), Fn(o, "class", "PinturaShapePreset"), Fn(o, "style", t[6]), this.first = o
        },
        m(e, c) {
            Cn(e, o, c), Ar(i, o, null), Sn(o, n), a = !0, s || (l = fn(r = t[8].call(null, o, t[14])), s = !0)
        },
        p(e, n) {
            t = e;
            const s = {};
            5 & n && (s.onclick = c), 9 & n && (s.ongrab = d), 17 & n && (s.ondrag = u), 33 & n && (s.ondrop = h), 3 & n && (s.disabled = t[1] || t[14].disabled), 1 & n && (s.title = t[14].title), 1 & n && (s.html = t[14].thumb), i.$set(s), (!a || 64 & n) && Fn(o, "style", t[6]), r && rn(r.update) && 1 & n && r.update.call(null, t[14])
        },
        i(e) {
            a || (yr(i.$$.fragment, e), a = !0)
        },
        o(e) {
            xr(i.$$.fragment, e), a = !1
        },
        d(e) {
            e && kn(o), Ir(i), s = !1, l()
        }
    }
}

function hf(e) {
    let t, o, i = [],
        n = new Map,
        r = e[0];
    const a = e => e[14].id;
    for (let t = 0; t < r.length; t += 1) {
        let o = df(e, r, t),
            s = a(o);
        n.set(s, i[t] = uf(s, o))
    }
    return {
        c() {
            t = Mn("ul");
            for (let e = 0; e < i.length; e += 1) i[e].c();
            Fn(t, "class", "PinturaShapePresetsList")
        },
        m(e, n) {
            Cn(e, t, n);
            for (let e = 0; e < i.length; e += 1) i[e].m(t, null);
            o = !0
        },
        p(e, [o]) {
            127 & o && (r = e[0], fr(), i = kr(i, o, a, 1, e, r, n, t, Cr, uf, null, df), $r())
        },
        i(e) {
            if (!o) {
                for (let e = 0; e < r.length; e += 1) yr(i[e]);
                o = !0
            }
        },
        o(e) {
            for (let e = 0; e < i.length; e += 1) xr(i[e]);
            o = !1
        },
        d(e) {
            e && kn(t);
            for (let e = 0; e < i.length; e += 1) i[e].d()
        }
    }
}

function pf(e, t, o) {
    let i, n, {
            presets: r
        } = t,
        {
            disabled: a
        } = t,
        {
            onclickpreset: s
        } = t,
        {
            ongrabpreset: l
        } = t,
        {
            ondragpreset: c
        } = t,
        {
            ondroppreset: d
        } = t;
    const u = is(0, {
        duration: 300
    });
    cn(e, u, (e => o(9, n = e)));
    Yn((() => u.set(1)));
    return e.$$set = e => {
        "presets" in e && o(0, r = e.presets), "disabled" in e && o(1, a = e.disabled), "onclickpreset" in e && o(2, s = e.onclickpreset), "ongrabpreset" in e && o(3, l = e.ongrabpreset), "ondragpreset" in e && o(4, c = e.ondragpreset), "ondroppreset" in e && o(5, d = e.ondroppreset)
    }, e.$$.update = () => {
        512 & e.$$.dirty && o(6, i = "opacity:" + n)
    }, [r, a, s, l, c, d, i, u, (e, t) => t.mount && t.mount(e.firstChild, t), n, e => s(e.id), (e, t) => l && l(e.id, t), (e, t) => c && c(e.id, t), (e, t) => d && d(e.id, t)]
}
class mf extends Fr {
    constructor(e) {
        super(), Lr(this, e, pf, hf, an, {
            presets: 0,
            disabled: 1,
            onclickpreset: 2,
            ongrabpreset: 3,
            ondragpreset: 4,
            ondroppreset: 5
        })
    }
}
var gf = e => /<svg /.test(e);

function ff(e) {
    let t, o;
    return t = new Vd({
        props: {
            items: e[13]
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            8192 & o && (i.items = e[13]), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function $f(e) {
    let t, o, i, n;
    const r = [xf, yf],
        a = [];

    function s(e, t) {
        return e[7] ? 0 : 1
    }
    return t = s(e), o = a[t] = r[t](e), {
        c() {
            o.c(), i = An()
        },
        m(e, o) {
            a[t].m(e, o), Cn(e, i, o), n = !0
        },
        p(e, n) {
            let l = t;
            t = s(e), t === l ? a[t].p(e, n) : (fr(), xr(a[l], 1, 1, (() => {
                a[l] = null
            })), $r(), o = a[t], o ? o.p(e, n) : (o = a[t] = r[t](e), o.c()), yr(o, 1), o.m(i.parentNode, i))
        },
        i(e) {
            n || (yr(o), n = !0)
        },
        o(e) {
            xr(o), n = !1
        },
        d(e) {
            a[t].d(e), e && kn(i)
        }
    }
}

function yf(e) {
    let t, o, i, n, r = e[13] && bf(e);
    return i = new Kl({
        props: {
            scrollAutoCancel: e[6],
            elasticity: e[0],
            $$slots: {
                default: [vf]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            t = Mn("div"), r && r.c(), o = Pn(), Pr(i.$$.fragment), Fn(t, "class", "PinturaShapePresetsFlat")
        },
        m(e, a) {
            Cn(e, t, a), r && r.m(t, null), Sn(t, o), Ar(i, t, null), n = !0
        },
        p(e, n) {
            e[13] ? r ? (r.p(e, n), 8192 & n && yr(r, 1)) : (r = bf(e), r.c(), yr(r, 1), r.m(t, o)) : r && (fr(), xr(r, 1, 1, (() => {
                r = null
            })), $r());
            const a = {};
            64 & n && (a.scrollAutoCancel = e[6]), 1 & n && (a.elasticity = e[0]), 536870974 & n && (a.$$scope = {
                dirty: n,
                ctx: e
            }), i.$set(a)
        },
        i(e) {
            n || (yr(r), yr(i.$$.fragment, e), n = !0)
        },
        o(e) {
            xr(r), xr(i.$$.fragment, e), n = !1
        },
        d(e) {
            e && kn(t), r && r.d(), Ir(i)
        }
    }
}

function xf(e) {
    let t, o, i, n, r, a, s, l = e[13] && wf(e);
    const c = [{
        class: "PinturaControlList"
    }, {
        tabs: e[8]
    }, e[11], {
        layout: "compact"
    }];
    let d = {
        $$slots: {
            default: [Mf, ({
                tab: e
            }) => ({
                28: e
            }), ({
                tab: e
            }) => e ? 268435456 : 0]
        },
        $$scope: {
            ctx: e
        }
    };
    for (let e = 0; e < c.length; e += 1) d = en(d, c[e]);
    n = new ml({
        props: d
    }), n.$on("select", e[18]);
    const u = [{
        class: "PinturaControlPanels"
    }, {
        panelClass: "PinturaControlPanel"
    }, {
        panels: e[12]
    }, e[11]];
    let h = {
        $$slots: {
            default: [Rf, ({
                panel: e,
                panelIsActive: t
            }) => ({
                26: e,
                27: t
            }), ({
                panel: e,
                panelIsActive: t
            }) => (e ? 67108864 : 0) | (t ? 134217728 : 0)]
        },
        $$scope: {
            ctx: e
        }
    };
    for (let e = 0; e < u.length; e += 1) h = en(h, u[e]);
    return a = new Ml({
        props: h
    }), {
        c() {
            t = Mn("div"), o = Mn("div"), l && l.c(), i = Pn(), Pr(n.$$.fragment), r = Pn(), Pr(a.$$.fragment), Fn(o, "class", "PinturaShapePresetsGroups"), Fn(t, "class", "PinturaShapePresetsGrouped")
        },
        m(e, c) {
            Cn(e, t, c), Sn(t, o), l && l.m(o, null), Sn(o, i), Ar(n, o, null), Sn(t, r), Ar(a, t, null), s = !0
        },
        p(e, t) {
            e[13] ? l ? (l.p(e, t), 8192 & t && yr(l, 1)) : (l = wf(e), l.c(), yr(l, 1), l.m(o, i)) : l && (fr(), xr(l, 1, 1, (() => {
                l = null
            })), $r());
            const r = 2304 & t ? Mr(c, [c[0], 256 & t && {
                tabs: e[8]
            }, 2048 & t && Tr(e[11]), c[3]]) : {};
            805306368 & t && (r.$$scope = {
                dirty: t,
                ctx: e
            }), n.$set(r);
            const s = 6144 & t ? Mr(u, [u[0], u[1], 4096 & t && {
                panels: e[12]
            }, 2048 & t && Tr(e[11])]) : {};
            738198623 & t && (s.$$scope = {
                dirty: t,
                ctx: e
            }), a.$set(s)
        },
        i(e) {
            s || (yr(l), yr(n.$$.fragment, e), yr(a.$$.fragment, e), s = !0)
        },
        o(e) {
            xr(l), xr(n.$$.fragment, e), xr(a.$$.fragment, e), s = !1
        },
        d(e) {
            e && kn(t), l && l.d(), Ir(n), Ir(a)
        }
    }
}

function bf(e) {
    let t, o;
    return t = new Vd({
        props: {
            items: e[13]
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            8192 & o && (i.items = e[13]), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function vf(e) {
    let t, o;
    return t = new mf({
        props: {
            presets: e[5],
            onclickpreset: e[1],
            ongrabpreset: e[2],
            ondragpreset: e[3],
            ondroppreset: e[4]
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            32 & o && (i.presets = e[5]), 2 & o && (i.onclickpreset = e[1]), 4 & o && (i.ongrabpreset = e[2]), 8 & o && (i.ondragpreset = e[3]), 16 & o && (i.ondroppreset = e[4]), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function wf(e) {
    let t, o;
    return t = new Vd({
        props: {
            items: e[13]
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            8192 & o && (i.items = e[13]), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Sf(e) {
    let t, o;
    return t = new Ll({
        props: {
            $$slots: {
                default: [Cf]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            805306368 & o && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Cf(e) {
    let t, o = e[28].icon + "";
    return {
        c() {
            t = Tn("g")
        },
        m(e, i) {
            Cn(e, t, i), t.innerHTML = o
        },
        p(e, i) {
            268435456 & i && o !== (o = e[28].icon + "") && (t.innerHTML = o)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function kf(e) {
    let t, o, i = e[28].label + "";
    return {
        c() {
            t = Mn("span"), o = Rn(i)
        },
        m(e, i) {
            Cn(e, t, i), Sn(t, o)
        },
        p(e, t) {
            268435456 & t && i !== (i = e[28].label + "") && Bn(o, i)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function Mf(e) {
    let t, o, i, n = e[28].icon && Sf(e),
        r = !e[28].hideLabel && kf(e);
    return {
        c() {
            n && n.c(), t = Pn(), r && r.c(), o = An()
        },
        m(e, a) {
            n && n.m(e, a), Cn(e, t, a), r && r.m(e, a), Cn(e, o, a), i = !0
        },
        p(e, i) {
            e[28].icon ? n ? (n.p(e, i), 268435456 & i && yr(n, 1)) : (n = Sf(e), n.c(), yr(n, 1), n.m(t.parentNode, t)) : n && (fr(), xr(n, 1, 1, (() => {
                n = null
            })), $r()), e[28].hideLabel ? r && (r.d(1), r = null) : r ? r.p(e, i) : (r = kf(e), r.c(), r.m(o.parentNode, o))
        },
        i(e) {
            i || (yr(n), i = !0)
        },
        o(e) {
            xr(n), i = !1
        },
        d(e) {
            n && n.d(e), e && kn(t), r && r.d(e), e && kn(o)
        }
    }
}

function Tf(e) {
    let t, o;
    return t = new mf({
        props: {
            presets: e[10][e[26]].items,
            disabled: e[10][e[26]].disabled,
            onclickpreset: e[1],
            ongrabpreset: e[2],
            ondragpreset: e[3],
            ondroppreset: e[4]
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            67109888 & o && (i.presets = e[10][e[26]].items), 67109888 & o && (i.disabled = e[10][e[26]].disabled), 2 & o && (i.onclickpreset = e[1]), 4 & o && (i.ongrabpreset = e[2]), 8 & o && (i.ondragpreset = e[3]), 16 & o && (i.ondroppreset = e[4]), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Rf(e) {
    let t, o;
    return t = new Kl({
        props: {
            scroll: e[27] ? {
                scrollOffset: 0,
                animate: !1
            } : void 0,
            scrollAutoCancel: e[6],
            elasticity: e[0],
            $$slots: {
                default: [Tf]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            134217728 & o && (i.scroll = e[27] ? {
                scrollOffset: 0,
                animate: !1
            } : void 0), 64 & o && (i.scrollAutoCancel = e[6]), 1 & o && (i.elasticity = e[0]), 603980830 & o && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Pf(e) {
    let t, o, i, n;
    const r = [$f, ff],
        a = [];

    function s(e, t) {
        return e[6] ? 0 : e[13] ? 1 : -1
    }
    return ~(o = s(e)) && (i = a[o] = r[o](e)), {
        c() {
            t = Mn("div"), i && i.c(), Fn(t, "class", "PinturaShapePresetsPalette")
        },
        m(e, i) {
            Cn(e, t, i), ~o && a[o].m(t, null), n = !0
        },
        p(e, [n]) {
            let l = o;
            o = s(e), o === l ? ~o && a[o].p(e, n) : (i && (fr(), xr(a[l], 1, 1, (() => {
                a[l] = null
            })), $r()), ~o ? (i = a[o], i ? i.p(e, n) : (i = a[o] = r[o](e), i.c()), yr(i, 1), i.m(t, null)) : i = null)
        },
        i(e) {
            n || (yr(i), n = !0)
        },
        o(e) {
            xr(i), n = !1
        },
        d(e) {
            e && kn(t), ~o && a[o].d()
        }
    }
}

function Af(e, t, o) {
    let i, r, a, s, l, c, d, u, h, {
            locale: p
        } = t,
        {
            presets: m
        } = t,
        {
            scrollElasticity: g
        } = t,
        {
            enableSelectImage: f = !0
        } = t,
        {
            willRenderPresetToolbar: $ = _
        } = t,
        {
            onaddpreset: y = n
        } = t,
        {
            ongrabpreset: x
        } = t,
        {
            ondragpreset: b
        } = t,
        {
            ondroppreset: v
        } = t;
    const S = "presets-" + T(),
        C = (e, t = "") => gf(e) ? e : Kt(e) ? no(e, t) : `<img src="${e}" alt="${t}"/>`,
        k = e => F(pt(e)),
        M = ["src", "alt", "thumb", "shape", "id", "mount", "disabled"],
        R = e => e.map((e => (e => Qt(e) && w(e[0]) && Qt(e[1]))(e) ? {
            ...e[2],
            id: `${S}-${e[0].toLowerCase()}`,
            label: e[0],
            items: R(e[1])
        } : (e => {
            let t, o, i, n, r, a, s, l = e;
            return w(e) ? Kt(e) ? (t = e, r = e, n = C(t, r)) : (t = e, r = k(t), n = C(t, r)) : (t = e.src, r = e.alt || (w(t) ? k(t) : w(e.thumb) ? k(e.thumb) : void 0), n = C(e.thumb || t, r), o = e.shape, a = e.mount, s = e.disabled, i = Object.keys(e).reduce(((t, o) => (M.includes(o) || (t[o] = e[o]), t)), {})), {
                id: l,
                src: t,
                thumb: n,
                shape: o,
                shapeProps: i,
                alt: r,
                title: r,
                mount: a,
                disabled: s
            }
        })(e)));
    return e.$$set = e => {
        "locale" in e && o(14, p = e.locale), "presets" in e && o(15, m = e.presets), "scrollElasticity" in e && o(0, g = e.scrollElasticity), "enableSelectImage" in e && o(16, f = e.enableSelectImage), "willRenderPresetToolbar" in e && o(17, $ = e.willRenderPresetToolbar), "onaddpreset" in e && o(1, y = e.onaddpreset), "ongrabpreset" in e && o(2, x = e.ongrabpreset), "ondragpreset" in e && o(3, b = e.ondragpreset), "ondroppreset" in e && o(4, v = e.ondroppreset)
    }, e.$$.update = () => {
        32768 & e.$$.dirty && o(5, i = R(m)), 32 & e.$$.dirty && o(6, r = i.length), 96 & e.$$.dirty && o(7, a = r && i.some((e => !!e.items))), 160 & e.$$.dirty && o(8, s = a && i), 160 & e.$$.dirty && o(10, l = a && i.reduce(((e, t) => (e[t.id] = t, e)), {})), 768 & e.$$.dirty && o(9, c = c || s && (s.find((e => !e.disabled)) || {}).id), 512 & e.$$.dirty && o(11, d = {
            name: S,
            selected: c
        }), 256 & e.$$.dirty && o(12, u = s && s.map((e => e.id))), 212994 & e.$$.dirty && o(13, h = p && $([f && ["Button", "browse", {
            label: p.shapeLabelButtonSelectSticker,
            icon: p.shapeIconButtonSelectSticker,
            onclick: () => {
                ou().then((e => {
                    e && y(e)
                }))
            }
        }]]))
    }, [g, y, x, b, v, i, r, a, s, c, l, d, u, h, p, m, f, $, ({
        detail: e
    }) => o(9, c = e)]
}
class If extends Fr {
    constructor(e) {
        super(), Lr(this, e, Af, Pf, an, {
            locale: 14,
            presets: 15,
            scrollElasticity: 0,
            enableSelectImage: 16,
            willRenderPresetToolbar: 17,
            onaddpreset: 1,
            ongrabpreset: 2,
            ondragpreset: 3,
            ondroppreset: 4
        })
    }
}

function Ef(e) {
    let t, o, i, n;
    const r = [{
        locale: e[4]
    }, {
        uid: e[14]
    }, {
        parentRect: e[24]
    }, {
        rootRect: e[32]
    }, {
        utilRect: e[26]
    }, {
        offset: e[34]
    }, {
        contextScale: e[44]
    }, {
        contextRotation: e[17]
    }, {
        contextFlipX: e[18]
    }, {
        contextFlipY: e[19]
    }, {
        active: e[25]
    }, {
        opacity: e[29]
    }, {
        hoverColor: e[45]
    }, {
        eraseRadius: e[35]
    }, {
        selectRadius: e[6]
    }, {
        enableButtonFlipVertical: e[9]
    }, {
        mapEditorPointToImagePoint: e[15]
    }, {
        mapImagePointToEditorPoint: e[16]
    }, {
        enableTapToAddText: e[12]
    }, {
        textInputMode: e[7]
    }, {
        oninteractionstart: e[58]
    }, {
        oninteractionupdate: e[59]
    }, {
        oninteractionrelease: e[60]
    }, {
        oninteractionend: e[61]
    }, {
        onhovershape: e[63]
    }, {
        onaddshape: e[95]
    }, {
        onselectshape: e[96]
    }, {
        ontapshape: e[97]
    }, {
        onupdateshape: e[98]
    }, {
        onremoveshape: e[99]
    }, e[41]];

    function a(t) {
        e[101](t)
    }

    function s(t) {
        e[102](t)
    }
    let l = {};
    for (let e = 0; e < r.length; e += 1) l = en(l, r[e]);
    return void 0 !== e[27] && (l.markup = e[27]), void 0 !== e[43] && (l.ui = e[43]), t = new Gg({
        props: l
    }), e[100](t), tr.push((() => Rr(t, "markup", a))), tr.push((() => Rr(t, "ui", s))), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, o) {
            Ar(t, e, o), n = !0
        },
        p(e, n) {
            const a = 655348432 & n[0] | 2013291674 & n[1] | 130 & n[2] ? Mr(r, [16 & n[0] && {
                locale: e[4]
            }, 16384 & n[0] && {
                uid: e[14]
            }, 16777216 & n[0] && {
                parentRect: e[24]
            }, 2 & n[1] && {
                rootRect: e[32]
            }, 67108864 & n[0] && {
                utilRect: e[26]
            }, 8 & n[1] && {
                offset: e[34]
            }, 8192 & n[1] && {
                contextScale: e[44]
            }, 131072 & n[0] && {
                contextRotation: e[17]
            }, 262144 & n[0] && {
                contextFlipX: e[18]
            }, 524288 & n[0] && {
                contextFlipY: e[19]
            }, 33554432 & n[0] && {
                active: e[25]
            }, 536870912 & n[0] && {
                opacity: e[29]
            }, 16384 & n[1] && {
                hoverColor: e[45]
            }, 16 & n[1] && {
                eraseRadius: e[35]
            }, 64 & n[0] && {
                selectRadius: e[6]
            }, 512 & n[0] && {
                enableButtonFlipVertical: e[9]
            }, 32768 & n[0] && {
                mapEditorPointToImagePoint: e[15]
            }, 65536 & n[0] && {
                mapImagePointToEditorPoint: e[16]
            }, 4096 & n[0] && {
                enableTapToAddText: e[12]
            }, 128 & n[0] && {
                textInputMode: e[7]
            }, 134217728 & n[1] && {
                oninteractionstart: e[58]
            }, 268435456 & n[1] && {
                oninteractionupdate: e[59]
            }, 536870912 & n[1] && {
                oninteractionrelease: e[60]
            }, 1073741824 & n[1] && {
                oninteractionend: e[61]
            }, 2 & n[2] && {
                onhovershape: e[63]
            }, 128 & n[1] | 128 & n[2] && {
                onaddshape: e[95]
            }, 128 & n[1] && {
                onselectshape: e[96]
            }, 128 & n[1] && {
                ontapshape: e[97]
            }, 128 & n[1] | 128 & n[2] && {
                onupdateshape: e[98]
            }, 128 & n[1] | 128 & n[2] && {
                onremoveshape: e[99]
            }, 1024 & n[1] && Tr(e[41])]) : {};
            !o && 134217728 & n[0] && (o = !0, a.markup = e[27], sr((() => o = !1))), !i && 4096 & n[1] && (i = !0, a.ui = e[43], sr((() => i = !1))), t.$set(a)
        },
        i(e) {
            n || (yr(t.$$.fragment, e), n = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), n = !1
        },
        d(o) {
            e[100](null), Ir(t, o)
        }
    }
}

function Lf(e) {
    let t, o, i, r, a, s = e[33] && Ef(e);
    return {
        c() {
            t = Mn("div"), s && s.c(), Fn(t, "slot", "main"), Fn(t, "style", o = "cursor: " + e[36])
        },
        m(o, l) {
            Cn(o, t, l), s && s.m(t, null), e[103](t), i = !0, r || (a = [fn(bs.call(null, t)), In(t, "dropfiles", (function () {
                rn(e[11] ? e[68] : n) && (e[11] ? e[68] : n).apply(this, arguments)
            })), fn($s.call(null, t)), In(t, "measure", e[93])], r = !0)
        },
        p(n, r) {
            (e = n)[33] ? s ? (s.p(e, r), 4 & r[1] && yr(s, 1)) : (s = Ef(e), s.c(), yr(s, 1), s.m(t, null)): s && (fr(), xr(s, 1, 1, (() => {
                s = null
            })), $r()), (!i || 32 & r[1] && o !== (o = "cursor: " + e[36])) && Fn(t, "style", o)
        },
        i(e) {
            i || (yr(s), i = !0)
        },
        o(e) {
            xr(s), i = !1
        },
        d(o) {
            o && kn(t), s && s.d(), e[103](null), r = !1, nn(a)
        }
    }
}

function Ff(e) {
    let t, o;
    return t = new If({
        props: {
            locale: e[4],
            presets: e[13],
            enableSelectImage: e[10],
            willRenderPresetToolbar: e[40],
            onaddpreset: e[67],
            ongrabpreset: e[64],
            ondragpreset: e[65],
            ondroppreset: e[66],
            scrollElasticity: e[39]
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            16 & o[0] && (i.locale = e[4]), 8192 & o[0] && (i.presets = e[13]), 1024 & o[0] && (i.enableSelectImage = e[10]), 512 & o[1] && (i.willRenderPresetToolbar = e[40]), 256 & o[1] && (i.scrollElasticity = e[39]), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function zf(e) {
    let t, o, i, n, r, a;
    const s = [Df, Bf],
        l = [];

    function c(e, t) {
        return e[37] ? 0 : 1
    }
    o = c(e), i = l[o] = s[o](e);
    let d = e[23] && Of(e);
    return {
        c() {
            t = Mn("div"), i.c(), n = Pn(), d && d.c(), r = An(), Fn(t, "class", "PinturaControlPanels")
        },
        m(e, i) {
            Cn(e, t, i), l[o].m(t, null), Cn(e, n, i), d && d.m(e, i), Cn(e, r, i), a = !0
        },
        p(e, n) {
            let a = o;
            o = c(e), o === a ? l[o].p(e, n) : (fr(), xr(l[a], 1, 1, (() => {
                l[a] = null
            })), $r(), i = l[o], i ? i.p(e, n) : (i = l[o] = s[o](e), i.c()), yr(i, 1), i.m(t, null)), e[23] ? d ? (d.p(e, n), 8388608 & n[0] && yr(d, 1)) : (d = Of(e), d.c(), yr(d, 1), d.m(r.parentNode, r)) : d && (fr(), xr(d, 1, 1, (() => {
                d = null
            })), $r())
        },
        i(e) {
            a || (yr(i), yr(d), a = !0)
        },
        o(e) {
            xr(i), xr(d), a = !1
        },
        d(e) {
            e && kn(t), l[o].d(), e && kn(n), d && d.d(e), e && kn(r)
        }
    }
}

function Bf(e) {
    let t, o, i;
    return o = new af({
        props: {
            locale: e[4],
            shape: e[28],
            onchange: e[62],
            controls: e[8],
            scrollElasticity: e[39]
        }
    }), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), Fn(t, "class", "PinturaControlPanel")
        },
        m(e, n) {
            Cn(e, t, n), Ar(o, t, null), i = !0
        },
        p(e, t) {
            const i = {};
            16 & t[0] && (i.locale = e[4]), 268435456 & t[0] && (i.shape = e[28]), 256 & t[0] && (i.controls = e[8]), 256 & t[1] && (i.scrollElasticity = e[39]), o.$set(i)
        },
        i(e) {
            i || (yr(o.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), i = !1
        },
        d(e) {
            e && kn(t), Ir(o)
        }
    }
}

function Df(e) {
    let t, o, i;
    return o = new If({
        props: {
            locale: e[4],
            presets: e[13],
            enableSelectImage: e[10],
            willRenderPresetToolbar: e[40],
            onaddpreset: e[67],
            ongrabpreset: e[64],
            ondragpreset: e[65],
            ondroppreset: e[66],
            scrollElasticity: e[39]
        }
    }), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), Fn(t, "class", "PinturaControlPanel")
        },
        m(e, n) {
            Cn(e, t, n), Ar(o, t, null), i = !0
        },
        p(e, t) {
            const i = {};
            16 & t[0] && (i.locale = e[4]), 8192 & t[0] && (i.presets = e[13]), 1024 & t[0] && (i.enableSelectImage = e[10]), 512 & t[1] && (i.willRenderPresetToolbar = e[40]), 256 & t[1] && (i.scrollElasticity = e[39]), o.$set(i)
        },
        i(e) {
            i || (yr(o.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), i = !1
        },
        d(e) {
            e && kn(t), Ir(o)
        }
    }
}

function Of(e) {
    let t, o;
    return t = new Kl({
        props: {
            class: "PinturaControlListScroller",
            elasticity: e[39],
            $$slots: {
                default: [Hf]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            256 & o[1] && (i.elasticity = e[39]), 4194321 & o[0] | 1073741824 & o[3] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function _f(e) {
    let t, o;
    return t = new Ll({
        props: {
            $$slots: {
                default: [Wf]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            16 & o[0] | 1610612736 & o[3] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Wf(e) {
    let t, o = (S(e[122].icon) ? e[122].icon(e[4]) : e[122].icon) + "";
    return {
        c() {
            t = Tn("g")
        },
        m(e, i) {
            Cn(e, t, i), t.innerHTML = o
        },
        p(e, i) {
            16 & i[0] | 536870912 & i[3] && o !== (o = (S(e[122].icon) ? e[122].icon(e[4]) : e[122].icon) + "") && (t.innerHTML = o)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function Vf(e) {
    let t, o, i, n, r, a = (S(e[122].label) ? e[122].label(e[4]) : e[122].label) + "",
        s = e[122].icon && _f(e);
    return {
        c() {
            t = Mn("div"), s && s.c(), o = Pn(), i = Mn("span"), n = Rn(a), Fn(t, "slot", "option")
        },
        m(e, a) {
            Cn(e, t, a), s && s.m(t, null), Sn(t, o), Sn(t, i), Sn(i, n), r = !0
        },
        p(e, i) {
            e[122].icon ? s ? (s.p(e, i), 536870912 & i[3] && yr(s, 1)) : (s = _f(e), s.c(), yr(s, 1), s.m(t, o)) : s && (fr(), xr(s, 1, 1, (() => {
                s = null
            })), $r()), (!r || 16 & i[0] | 536870912 & i[3]) && a !== (a = (S(e[122].label) ? e[122].label(e[4]) : e[122].label) + "") && Bn(n, a)
        },
        i(e) {
            r || (yr(s), r = !0)
        },
        o(e) {
            xr(s), r = !1
        },
        d(e) {
            e && kn(t), s && s.d()
        }
    }
}

function Hf(e) {
    let t, o;
    return t = new ad({
        props: {
            locale: e[4],
            class: "PinturaControlList",
            optionClass: "PinturaControlListOption",
            layout: "row",
            options: e[22],
            selectedIndex: e[22].findIndex(e[94]),
            onchange: e[57],
            $$slots: {
                option: [Vf, ({
                    option: e
                }) => ({
                    122: e
                }), ({
                    option: e
                }) => [0, 0, 0, e ? 536870912 : 0]]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            16 & o[0] && (i.locale = e[4]), 4194304 & o[0] && (i.options = e[22]), 4194305 & o[0] && (i.selectedIndex = e[22].findIndex(e[94])), 16 & o[0] | 1610612736 & o[3] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Nf(e) {
    let t, o, i, n;
    const r = [zf, Ff],
        a = [];

    function s(e, t) {
        return e[31] ? 0 : e[37] ? 1 : -1
    }
    return ~(o = s(e)) && (i = a[o] = r[o](e)), {
        c() {
            t = Mn("div"), i && i.c(), Fn(t, "slot", "footer"), Fn(t, "style", e[42])
        },
        m(e, i) {
            Cn(e, t, i), ~o && a[o].m(t, null), n = !0
        },
        p(e, l) {
            let c = o;
            o = s(e), o === c ? ~o && a[o].p(e, l) : (i && (fr(), xr(a[c], 1, 1, (() => {
                a[c] = null
            })), $r()), ~o ? (i = a[o], i ? i.p(e, l) : (i = a[o] = r[o](e), i.c()), yr(i, 1), i.m(t, null)) : i = null), (!n || 2048 & l[1]) && Fn(t, "style", e[42])
        },
        i(e) {
            n || (yr(i), n = !0)
        },
        o(e) {
            xr(i), n = !1
        },
        d(e) {
            e && kn(t), ~o && a[o].d()
        }
    }
}

function Uf(e) {
    let t, o;
    return t = new am({
        props: {
            $$slots: {
                footer: [Nf],
                main: [Lf]
            },
            $$scope: {
                ctx: e
            }
        }
    }), t.$on("measure", e[104]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            2146435025 & o[0] | 32767 & o[1] | 1073741824 & o[3] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function jf(e, t, o) {
    let i, n, r, a, s, l, c, d, u, h, p, m, g, f, $, y, x, b, v, S, C, k, M, T, R, P, A, I, E, L, F, z, B, D, O, W, V, H, N, U = Ji,
        j = () => (U(), U = sn(Te, (e => o(24, M = e))), Te),
        X = Ji,
        G = () => (X(), X = sn(te, (e => o(25, R = e))), te),
        q = Ji,
        Z = () => (q(), q = sn(ie, (e => o(84, A = e))), ie),
        K = Ji,
        J = () => (K(), K = sn(ae, (e => o(27, L = e))), ae),
        Q = Ji,
        ee = () => (Q(), Q = sn(oe, (e => o(29, z = e))), oe);
    e.$$.on_destroy.push((() => U())), e.$$.on_destroy.push((() => X())), e.$$.on_destroy.push((() => q())), e.$$.on_destroy.push((() => K())), e.$$.on_destroy.push((() => Q()));
    let {
        isActive: te
    } = t;
    G();
    let {
        isActiveFraction: oe
    } = t;
    ee();
    let {
        isVisible: ie
    } = t;
    Z();
    let {
        stores: ne
    } = t, {
        locale: re = {}
    } = t, {
        shapes: ae
    } = t;
    J();
    let {
        tools: se = []
    } = t, {
        toolShapes: le = []
    } = t, {
        toolActive: de
    } = t, {
        toolSelectRadius: ue
    } = t, {
        textInputMode: he
    } = t, {
        shapeControls: pe = {}
    } = t, {
        enableButtonFlipVertical: me = !1
    } = t, {
        enablePresetSelectImage: ge = !0
    } = t, {
        enablePresetDropImage: fe = !0
    } = t, {
        enableSelectToolToAddShape: $e = !1
    } = t, {
        enableTapToAddText: ye = !1
    } = t, {
        willRenderPresetToolbar: xe
    } = t, {
        shapePresets: be = []
    } = t, {
        utilKey: ve
    } = t, {
        mapScreenPointToImagePoint: we
    } = t, {
        mapImagePointToScreenPoint: Se
    } = t, {
        imageRotation: Ce = 0
    } = t, {
        imageFlipX: ke = !1
    } = t, {
        imageFlipY: Me = !1
    } = t, {
        parentRect: Te
    } = t;
    j();
    let {
        hooks: Re = {}
    } = t;
    const {
        env: Pe,
        animation: Ae,
        history: Ie,
        rootRect: Ee,
        rootColorSecondary: Le,
        stageRect: Fe,
        utilRect: ze,
        elasticityMultiplier: Be,
        scrollElasticity: De,
        imageOverlayMarkup: Oe,
        imagePreviewModifiers: _e,
        imageCropRect: Ve,
        imageSize: He,
        presentationScalar: Ne,
        shapePreprocessor: Ue
    } = ne;
    cn(e, Pe, (e => o(90, D = e))), cn(e, Ae, (e => o(91, O = e))), cn(e, Ee, (e => o(32, T = e))), cn(e, Le, (e => o(45, N = e))), cn(e, Fe, (e => o(85, E = e))), cn(e, ze, (e => o(26, I = e))), cn(e, Oe, (e => o(43, V = e))), cn(e, _e, (e => o(82, P = e))), cn(e, Ve, (e => o(109, B = e))), cn(e, Ne, (e => o(44, H = e))), cn(e, Ue, (e => o(89, F = e)));
    const je = e => {
            const [t, o] = le[e];
            let i, n, r = "relative" === o.position;
            const a = r ? "0%" : 0,
                s = r ? "0%" : 0;
            Ho(t) || _o(t) ? (n = r ? "20%" : .2 * M.width, i = Eo(t), i.x = a, i.y = s, Mi(i, {
                width: n,
                height: n
            }, M)) : No(t) ? (n = r ? "10%" : .1 * M.width, i = Eo(t), i.x = a, i.y = s, Mi(i, {
                rx: n,
                ry: n
            }, M)) : Uo(t) && (n = r ? "10%" : .1 * M.width, i = Eo(t), i.x1 = a, i.y1 = s, i.x2 = a, i.y2 = s), i && Promise.resolve().then((() => {
                tt(Qe(i, void 0, n))
            }))
        },
        Xe = e => we(Tg(e, T));
    let Ye, Ge, qe = {};
    let Ze, Je;
    const Qe = (e, t, o) => {
            let i = !1;
            t || (i = !0, t = x ? we(We(E)) : We(B)), t.x -= M.x || 0, t.y -= M.y || 0, (ke || Me) && (e.flipX = ke, e.flipY = Me);
            const n = Ye.getShapesNearPosition(t);
            if (i && n.length) {
                const e = .1 * Math.min(B.width, B.height);
                t.x += Math.round(-e + Math.random() * e * 2), t.y += Math.round(-e + Math.random() * e * 2)
            }
            if (0 !== Ce && (e.rotation = ke && Me ? -Ce : ke || Me ? Ce : -Ce), Jt(e, "width") && Jt(e, "height")) {
                const {
                    width: o,
                    height: i
                } = ki(e, ["width", "height"], M);
                Mi(e, {
                    x: t.x - .5 * o,
                    y: t.y - .5 * i
                }, M)
            } else if (No(e)) Mi(e, {
                x: t.x,
                y: t.y
            }, M);
            else if (Uo(e)) {
                const {
                    x1: i,
                    y1: n,
                    x2: r,
                    y2: a
                } = ki(e, ["x1", "y1", "x2", "y2"], M), s = ce(Y(i, n), Y(r, a)) || w(o) ? yi(o, M.width) : o;
                Mi(e, {
                    x1: t.x - s,
                    y1: t.y + s,
                    x2: t.x + s,
                    y2: t.y - s
                }, M)
            }
            return e
        },
        et = (e, t) => {
            const o = Qe(Bo(e, B), t);
            return tt(o)
        },
        tt = e => {
            const {
                beforeAddShape: t = (() => !0)
            } = Re;
            if (t(e)) return Ye.addShape(e), Ye.selectShape(e), Ie.write(), e
        };
    let ot = !1;
    const it = () => Ie.write();
    let nt;
    const rt = rs(O ? 20 : 0);
    cn(e, rt, (e => o(92, W = e)));
    return e.$$set = e => {
        "isActive" in e && G(o(1, te = e.isActive)), "isActiveFraction" in e && ee(o(2, oe = e.isActiveFraction)), "isVisible" in e && Z(o(3, ie = e.isVisible)), "stores" in e && o(71, ne = e.stores), "locale" in e && o(4, re = e.locale), "shapes" in e && J(o(5, ae = e.shapes)), "tools" in e && o(72, se = e.tools), "toolShapes" in e && o(73, le = e.toolShapes), "toolActive" in e && o(0, de = e.toolActive), "toolSelectRadius" in e && o(6, ue = e.toolSelectRadius), "textInputMode" in e && o(7, he = e.textInputMode), "shapeControls" in e && o(8, pe = e.shapeControls), "enableButtonFlipVertical" in e && o(9, me = e.enableButtonFlipVertical), "enablePresetSelectImage" in e && o(10, ge = e.enablePresetSelectImage), "enablePresetDropImage" in e && o(11, fe = e.enablePresetDropImage), "enableSelectToolToAddShape" in e && o(74, $e = e.enableSelectToolToAddShape), "enableTapToAddText" in e && o(12, ye = e.enableTapToAddText), "willRenderPresetToolbar" in e && o(75, xe = e.willRenderPresetToolbar), "shapePresets" in e && o(13, be = e.shapePresets), "utilKey" in e && o(14, ve = e.utilKey), "mapScreenPointToImagePoint" in e && o(15, we = e.mapScreenPointToImagePoint), "mapImagePointToScreenPoint" in e && o(16, Se = e.mapImagePointToScreenPoint), "imageRotation" in e && o(17, Ce = e.imageRotation), "imageFlipX" in e && o(18, ke = e.imageFlipX), "imageFlipY" in e && o(19, Me = e.imageFlipY), "parentRect" in e && j(o(20, Te = e.parentRect)), "hooks" in e && o(76, Re = e.hooks)
    }, e.$$.update = () => {
        var t;
        8192 & e.$$.dirty[0] | 1024 & e.$$.dirty[2] && o(22, i = 0 === be.length ? se.filter((e => "preset" !== e[0])) : se), 256 & e.$$.dirty[0] && o(79, n = Object.keys(pe).length), 4194304 & e.$$.dirty[0] && o(23, r = i.length > 1), 4194304 & e.$$.dirty[0] && o(80, a = !!i.length), 12582913 & e.$$.dirty[0] && r && void 0 === de && o(0, de = i[0][0]), 1 & e.$$.dirty[0] && o(81, s = void 0 !== de), 917504 & e.$$.dirty[2] && o(31, l = (!s || a) && n), 33570816 & e.$$.dirty[0] | 1048576 & e.$$.dirty[2] && (R ? gn(_e, P[ve] = {
            maskMarkupOpacity: .85
        }, P) : delete P[ve]), 1 & e.$$.dirty[0] && de && Ye && Ye.blurShapes(), 4194304 & e.$$.dirty[2] && o(33, c = A), 67108864 & e.$$.dirty[0] | 8388608 & e.$$.dirty[2] && o(34, d = I && Y(E.x - I.x, E.y - I.y)), 256 & e.$$.dirty[0] && o(86, u = Object.keys(pe)), 134217728 & e.$$.dirty[0] && o(87, h = L.filter(qo)[0]), 33554433 & e.$$.dirty[0] | 2048 & e.$$.dirty[2] && o(88, p = R && (le[de] ? fi(Eo(le[de][0])) : {})), 83918848 & e.$$.dirty[2] && o(83, m = p && Object.keys(p).reduce(((e, t) => {
            const o = "disableStyle" === t,
                i = u.find((e => e.split("_").includes(t)));
            return o || i ? (void 0 === p[t] || (e[t] = Jt(qe, t) ? qe[t] : p[t]), e) : e
        }), {})), 35651584 & e.$$.dirty[2] && o(28, g = h || m), 268435456 & e.$$.dirty[0] | 134217728 & e.$$.dirty[2] && g && g.lineEnd && !F && console.warn("Set shapePreprocessor property to draw lineStart and lineEnd styles.\nhttps://pqina/pintura/docs/v8/api/exports/#createshapepreprocessor"), 69206016 & e.$$.dirty[2] && o(35, f = p && Zt(p.eraseRadius) ? (m || p).eraseRadius : void 0), 33619968 & e.$$.dirty[2] && o(36, $ = ((e, t) => {
            if (!e) return "crosshair";
            let o = e || t;
            return qo(o) ? (e => e.isEditing)(o) ? "modal" === he ? "default" : "text" : ci(o) ? "move" : "default" : "crosshair"
        })(Je, h)), 536880129 & e.$$.dirty[0] && o(37, y = z > 0 && "preset" === de && (be.length > 0 || ge)), 16777216 & e.$$.dirty[0] && (x = !Jt(M, "x") && !Jt(M, "y")), 2097152 & e.$$.dirty[0] && o(38, b = nt && (t = nt, (e, o) => {
            t.dispatchEvent(Nd(e, o))
        })), 268443648 & e.$$.dirty[2] && o(40, S = xe ? e => xe(e, et, {
            ...D
        }) : _), 16384 & e.$$.dirty[2] && o(41, C = Object.keys(Re).reduce(((e, t) => ("beforeAddShape" === t || (e[t] = Re[t]), e)), {})), 33554432 & e.$$.dirty[0] | 536870912 & e.$$.dirty[2] && O && rt.set(R ? 0 : 20), 1073741824 & e.$$.dirty[2] && o(42, k = W ? `transform: translateY(${W}px)` : void 0)
    }, o(39, v = Be * De), [de, te, oe, ie, re, ae, ue, he, pe, me, ge, fe, ye, be, ve, we, Se, Ce, ke, Me, Te, nt, i, r, M, R, I, L, g, z, Ye, l, T, c, d, f, $, y, b, v, S, C, k, V, H, N, Pe, Ae, Ee, Le, Fe, ze, Oe, _e, Ve, Ne, Ue, ({
        value: e
    }, t) => {
        o(0, de = e), ($e || Fc(t.key)) && je(e)
    }, e => {
        if ("eraser" === de) Ge = Ye.eraseShape();
        else if (de && le[de]) {
            const [e, t] = le[de];
            Ge = Ye.createShape({
                ...e,
                ...m
            }, t)
        } else Ge = void 0;
        return !!Ge && (Ge.start(e), !0)
    }, e => !!Ge && (Ge.update(e), !0), e => !!Ge && (Ge.release(e), !0), e => !!Ge && (Ge.end(e), Ge = void 0, !0), function (e) {
        Object.keys(e).forEach((t => o(77, qe[t] = e[t], qe))), h && (Ye.updateMarkupShape(h, e), clearTimeout(Ze), Ze = setTimeout((() => {
            it()
        }), 200))
    }, e => o(78, Je = e), () => {
        ot = !1
    }, (e, t) => {
        if (ot) return;
        const {
            beforeAddShape: o = (() => !0)
        } = Re, i = Xe(t), n = Ye.getMarkupItemDraft(), r = Ke(B, {
            x: i.x + (M.x || 0),
            y: i.y + (M.y || 0)
        });
        if (n && !r && Ye.discardMarkupItemDraft(), r) {
            if (!n) {
                const n = Qe(Bo(e, B), i);
                return o(n) ? (ti(n), void Ye.addShape(n)) : (ot = !0, void t.preventDefault())
            }
            Ho(n) && (i.x -= .5 * n.width, i.y -= .5 * n.height), Ye.updateMarkupShape(n, i)
        }
    }, (e, t) => {
        if (ot) return;
        const o = Xe(t);
        if (!Ke(B, {
                x: o.x + (M.x || 0),
                y: o.y + (M.y || 0)
            })) return void Ye.discardMarkupItemDraft();
        const i = Ye.confirmMarkupItemDraft();
        Ye.selectShape(i), Ie.write()
    }, e => et(e), e => {
        return t = e.detail.resources, o = Xe(e.detail.event), t.forEach((e => et(e, o)));
        var t, o
    }, it, rt, ne, se, le, $e, xe, Re, qe, Je, n, a, s, P, m, A, E, u, h, p, F, D, O, W, function (t) {
        Qn(e, t)
    }, e => e[0] === de, e => {
        b("addshape", e), it()
    }, e => {
        b("selectshape", e)
    }, e => {
        b("tapshape", e)
    }, e => {
        b("updateshape", e), it()
    }, e => {
        b("removeshape", e), it()
    }, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            Ye = e, o(30, Ye)
        }))
    }, function (e) {
        L = e, ae.set(L)
    }, function (e) {
        V = e, Oe.set(V)
    }, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            nt = e, o(21, nt)
        }))
    }, function (t) {
        Qn(e, t)
    }]
}
class Xf extends Fr {
    constructor(e) {
        super(), Lr(this, e, jf, Uf, an, {
            isActive: 1,
            isActiveFraction: 2,
            isVisible: 3,
            stores: 71,
            locale: 4,
            shapes: 5,
            tools: 72,
            toolShapes: 73,
            toolActive: 0,
            toolSelectRadius: 6,
            textInputMode: 7,
            shapeControls: 8,
            enableButtonFlipVertical: 9,
            enablePresetSelectImage: 10,
            enablePresetDropImage: 11,
            enableSelectToolToAddShape: 74,
            enableTapToAddText: 12,
            willRenderPresetToolbar: 75,
            shapePresets: 13,
            utilKey: 14,
            mapScreenPointToImagePoint: 15,
            mapImagePointToScreenPoint: 16,
            imageRotation: 17,
            imageFlipX: 18,
            imageFlipY: 19,
            parentRect: 20,
            hooks: 76
        }, [-1, -1, -1, -1])
    }
    get isActive() {
        return this.$$.ctx[1]
    }
    set isActive(e) {
        this.$set({
            isActive: e
        }), dr()
    }
    get isActiveFraction() {
        return this.$$.ctx[2]
    }
    set isActiveFraction(e) {
        this.$set({
            isActiveFraction: e
        }), dr()
    }
    get isVisible() {
        return this.$$.ctx[3]
    }
    set isVisible(e) {
        this.$set({
            isVisible: e
        }), dr()
    }
    get stores() {
        return this.$$.ctx[71]
    }
    set stores(e) {
        this.$set({
            stores: e
        }), dr()
    }
    get locale() {
        return this.$$.ctx[4]
    }
    set locale(e) {
        this.$set({
            locale: e
        }), dr()
    }
    get shapes() {
        return this.$$.ctx[5]
    }
    set shapes(e) {
        this.$set({
            shapes: e
        }), dr()
    }
    get tools() {
        return this.$$.ctx[72]
    }
    set tools(e) {
        this.$set({
            tools: e
        }), dr()
    }
    get toolShapes() {
        return this.$$.ctx[73]
    }
    set toolShapes(e) {
        this.$set({
            toolShapes: e
        }), dr()
    }
    get toolActive() {
        return this.$$.ctx[0]
    }
    set toolActive(e) {
        this.$set({
            toolActive: e
        }), dr()
    }
    get toolSelectRadius() {
        return this.$$.ctx[6]
    }
    set toolSelectRadius(e) {
        this.$set({
            toolSelectRadius: e
        }), dr()
    }
    get textInputMode() {
        return this.$$.ctx[7]
    }
    set textInputMode(e) {
        this.$set({
            textInputMode: e
        }), dr()
    }
    get shapeControls() {
        return this.$$.ctx[8]
    }
    set shapeControls(e) {
        this.$set({
            shapeControls: e
        }), dr()
    }
    get enableButtonFlipVertical() {
        return this.$$.ctx[9]
    }
    set enableButtonFlipVertical(e) {
        this.$set({
            enableButtonFlipVertical: e
        }), dr()
    }
    get enablePresetSelectImage() {
        return this.$$.ctx[10]
    }
    set enablePresetSelectImage(e) {
        this.$set({
            enablePresetSelectImage: e
        }), dr()
    }
    get enablePresetDropImage() {
        return this.$$.ctx[11]
    }
    set enablePresetDropImage(e) {
        this.$set({
            enablePresetDropImage: e
        }), dr()
    }
    get enableSelectToolToAddShape() {
        return this.$$.ctx[74]
    }
    set enableSelectToolToAddShape(e) {
        this.$set({
            enableSelectToolToAddShape: e
        }), dr()
    }
    get enableTapToAddText() {
        return this.$$.ctx[12]
    }
    set enableTapToAddText(e) {
        this.$set({
            enableTapToAddText: e
        }), dr()
    }
    get willRenderPresetToolbar() {
        return this.$$.ctx[75]
    }
    set willRenderPresetToolbar(e) {
        this.$set({
            willRenderPresetToolbar: e
        }), dr()
    }
    get shapePresets() {
        return this.$$.ctx[13]
    }
    set shapePresets(e) {
        this.$set({
            shapePresets: e
        }), dr()
    }
    get utilKey() {
        return this.$$.ctx[14]
    }
    set utilKey(e) {
        this.$set({
            utilKey: e
        }), dr()
    }
    get mapScreenPointToImagePoint() {
        return this.$$.ctx[15]
    }
    set mapScreenPointToImagePoint(e) {
        this.$set({
            mapScreenPointToImagePoint: e
        }), dr()
    }
    get mapImagePointToScreenPoint() {
        return this.$$.ctx[16]
    }
    set mapImagePointToScreenPoint(e) {
        this.$set({
            mapImagePointToScreenPoint: e
        }), dr()
    }
    get imageRotation() {
        return this.$$.ctx[17]
    }
    set imageRotation(e) {
        this.$set({
            imageRotation: e
        }), dr()
    }
    get imageFlipX() {
        return this.$$.ctx[18]
    }
    set imageFlipX(e) {
        this.$set({
            imageFlipX: e
        }), dr()
    }
    get imageFlipY() {
        return this.$$.ctx[19]
    }
    set imageFlipY(e) {
        this.$set({
            imageFlipY: e
        }), dr()
    }
    get parentRect() {
        return this.$$.ctx[20]
    }
    set parentRect(e) {
        this.$set({
            parentRect: e
        }), dr()
    }
    get hooks() {
        return this.$$.ctx[76]
    }
    set hooks(e) {
        this.$set({
            hooks: e
        }), dr()
    }
}
var Yf = (e, t, o, i, n, r, a, s, l) => {
        const c = Z(e),
            d = .5 * o.width,
            u = .5 * o.height,
            h = .5 * t.width,
            p = .5 * t.height,
            m = n.x + i.x,
            g = n.y + i.y;
        s && (c.x = o.width - c.x), l && (c.y = o.height - c.y);
        const f = Math.cos(r),
            $ = Math.sin(r);
        c.x -= d, c.y -= u;
        const y = c.x * f - c.y * $,
            x = c.x * $ + c.y * f;
        c.x = d + y, c.y = u + x, c.x *= a, c.y *= a, c.x += h, c.y += p, c.x += m, c.y += g, c.x -= d * a, c.y -= u * a;
        const b = (n.x - m) * a,
            v = (n.y - g) * a,
            w = b * f - v * $,
            S = b * $ + v * f;
        return c.x += w, c.y += S, c
    },
    Gf = (e, t, o, i, n, r, a, s, l) => {
        const c = Z(e),
            d = Se(o),
            u = Se(t),
            h = Y(n.x + i.x, n.y + i.y),
            p = Math.cos(r),
            m = Math.sin(r);
        c.x -= u.x, c.y -= u.y;
        const g = (n.x - h.x) * a,
            f = (n.y - h.y) * a,
            $ = g * p - f * m,
            y = g * m + f * p;
        c.x -= $, c.y -= y, c.x -= h.x, c.y -= h.y, c.x /= a, c.y /= a;
        const x = c.x * p + c.y * m,
            b = c.x * m - c.y * p;
        return c.x = x, c.y = -b, c.x += d.x, c.y += d.y, s && (c.x = o.width - c.x), l && (c.y = o.height - c.y), c
    };

function qf(e) {
    let t, o, i;

    function n(t) {
        e[43](t)
    }
    let r = {
        stores: e[4],
        locale: e[5],
        isActive: e[1],
        isActiveFraction: e[2],
        isVisible: e[3],
        mapScreenPointToImagePoint: e[29],
        mapImagePointToScreenPoint: e[30],
        utilKey: "annotate",
        imageRotation: e[31],
        imageFlipX: e[27],
        imageFlipY: e[28],
        shapes: e[33],
        tools: e[12] || e[6],
        toolShapes: e[13] || e[7],
        enableSelectToolToAddShape: e[19],
        enableTapToAddText: e[20],
        shapeControls: e[14] || e[8],
        shapePresets: e[17],
        enableButtonFlipVertical: e[15],
        parentRect: e[34],
        enablePresetSelectImage: e[16],
        toolSelectRadius: e[9],
        textInputMode: e[10],
        willRenderPresetToolbar: e[18] || e[11],
        hooks: {
            willRenderShapeControls: e[21],
            beforeAddShape: e[22],
            beforeRemoveShape: e[23],
            beforeDeselectShape: e[24],
            beforeSelectShape: e[25],
            beforeUpdateShape: e[26]
        }
    };
    return void 0 !== e[0] && (r.toolActive = e[0]), t = new Xf({
        props: r
    }), tr.push((() => Rr(t, "toolActive", n))), t.$on("measure", e[44]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, o) {
            Ar(t, e, o), i = !0
        },
        p(e, i) {
            const n = {};
            16 & i[0] && (n.stores = e[4]), 32 & i[0] && (n.locale = e[5]), 2 & i[0] && (n.isActive = e[1]), 4 & i[0] && (n.isActiveFraction = e[2]), 8 & i[0] && (n.isVisible = e[3]), 536870912 & i[0] && (n.mapScreenPointToImagePoint = e[29]), 1073741824 & i[0] && (n.mapImagePointToScreenPoint = e[30]), 1 & i[1] && (n.imageRotation = e[31]), 134217728 & i[0] && (n.imageFlipX = e[27]), 268435456 & i[0] && (n.imageFlipY = e[28]), 4160 & i[0] && (n.tools = e[12] || e[6]), 8320 & i[0] && (n.toolShapes = e[13] || e[7]), 524288 & i[0] && (n.enableSelectToolToAddShape = e[19]), 1048576 & i[0] && (n.enableTapToAddText = e[20]), 16640 & i[0] && (n.shapeControls = e[14] || e[8]), 131072 & i[0] && (n.shapePresets = e[17]), 32768 & i[0] && (n.enableButtonFlipVertical = e[15]), 65536 & i[0] && (n.enablePresetSelectImage = e[16]), 512 & i[0] && (n.toolSelectRadius = e[9]), 1024 & i[0] && (n.textInputMode = e[10]), 264192 & i[0] && (n.willRenderPresetToolbar = e[18] || e[11]), 132120576 & i[0] && (n.hooks = {
                willRenderShapeControls: e[21],
                beforeAddShape: e[22],
                beforeRemoveShape: e[23],
                beforeDeselectShape: e[24],
                beforeSelectShape: e[25],
                beforeUpdateShape: e[26]
            }), !o && 1 & i[0] && (o = !0, n.toolActive = e[0], sr((() => o = !1))), t.$set(n)
        },
        i(e) {
            i || (yr(t.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), i = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Zf(e, t, o) {
    let i, n, r, a, s, l, c, d;
    let {
        isActive: u
    } = t, {
        isActiveFraction: h
    } = t, {
        isVisible: p
    } = t, {
        stores: m
    } = t, {
        locale: g = {}
    } = t, {
        markupEditorToolbar: f
    } = t, {
        markupEditorToolStyles: $
    } = t, {
        markupEditorShapeStyleControls: y
    } = t, {
        markupEditorToolSelectRadius: x
    } = t, {
        markupEditorTextInputMode: b
    } = t, {
        willRenderShapePresetToolbar: v
    } = t, {
        annotateTools: w
    } = t, {
        annotateToolShapes: S
    } = t, {
        annotateShapeControls: C
    } = t, {
        annotateActiveTool: k
    } = t, {
        annotateEnableButtonFlipVertical: M = !1
    } = t, {
        annotateEnableSelectImagePreset: T = !1
    } = t, {
        annotatePresets: R = []
    } = t, {
        annotateWillRenderShapePresetToolbar: P
    } = t, {
        enableSelectToolToAddShape: A
    } = t, {
        enableTapToAddText: I
    } = t, {
        willRenderShapeControls: E
    } = t, {
        beforeAddShape: L
    } = t, {
        beforeRemoveShape: F
    } = t, {
        beforeDeselectShape: z
    } = t, {
        beforeSelectShape: B
    } = t, {
        beforeUpdateShape: D
    } = t;
    const {
        rootRect: O,
        imageAnnotation: _,
        imageSize: W,
        imageTransforms: V,
        imageRotation: H,
        imageFlipX: N,
        imageFlipY: U
    } = m;
    return cn(e, O, (e => o(40, r = e))), cn(e, W, (e => o(41, a = e))), cn(e, V, (e => o(42, s = e))), cn(e, H, (e => o(31, d = e))), cn(e, N, (e => o(27, l = e))), cn(e, U, (e => o(28, c = e))), e.$$set = e => {
        "isActive" in e && o(1, u = e.isActive), "isActiveFraction" in e && o(2, h = e.isActiveFraction), "isVisible" in e && o(3, p = e.isVisible), "stores" in e && o(4, m = e.stores), "locale" in e && o(5, g = e.locale), "markupEditorToolbar" in e && o(6, f = e.markupEditorToolbar), "markupEditorToolStyles" in e && o(7, $ = e.markupEditorToolStyles), "markupEditorShapeStyleControls" in e && o(8, y = e.markupEditorShapeStyleControls), "markupEditorToolSelectRadius" in e && o(9, x = e.markupEditorToolSelectRadius), "markupEditorTextInputMode" in e && o(10, b = e.markupEditorTextInputMode), "willRenderShapePresetToolbar" in e && o(11, v = e.willRenderShapePresetToolbar), "annotateTools" in e && o(12, w = e.annotateTools), "annotateToolShapes" in e && o(13, S = e.annotateToolShapes), "annotateShapeControls" in e && o(14, C = e.annotateShapeControls), "annotateActiveTool" in e && o(0, k = e.annotateActiveTool), "annotateEnableButtonFlipVertical" in e && o(15, M = e.annotateEnableButtonFlipVertical), "annotateEnableSelectImagePreset" in e && o(16, T = e.annotateEnableSelectImagePreset), "annotatePresets" in e && o(17, R = e.annotatePresets), "annotateWillRenderShapePresetToolbar" in e && o(18, P = e.annotateWillRenderShapePresetToolbar), "enableSelectToolToAddShape" in e && o(19, A = e.enableSelectToolToAddShape), "enableTapToAddText" in e && o(20, I = e.enableTapToAddText), "willRenderShapeControls" in e && o(21, E = e.willRenderShapeControls), "beforeAddShape" in e && o(22, L = e.beforeAddShape), "beforeRemoveShape" in e && o(23, F = e.beforeRemoveShape), "beforeDeselectShape" in e && o(24, z = e.beforeDeselectShape), "beforeSelectShape" in e && o(25, B = e.beforeSelectShape), "beforeUpdateShape" in e && o(26, D = e.beforeUpdateShape)
    }, e.$$.update = () => {
        402653184 & e.$$.dirty[0] | 3584 & e.$$.dirty[1] && o(29, i = e => Gf(e, r, a, s.origin, s.translation, s.rotation.z, s.scale, l, c)), 402653184 & e.$$.dirty[0] | 3584 & e.$$.dirty[1] && o(30, n = e => Yf(e, r, a, s.origin, s.translation, s.rotation.z, s.scale, l, c))
    }, [k, u, h, p, m, g, f, $, y, x, b, v, w, S, C, M, T, R, P, A, I, E, L, F, z, B, D, l, c, i, n, d, O, _, W, V, H, N, U, "annotate", r, a, s, function (e) {
        k = e, o(0, k)
    }, function (t) {
        Qn(e, t)
    }]
}
var Kf = {
    util: ["annotate", class extends Fr {
        constructor(e) {
            super(), Lr(this, e, Zf, qf, an, {
                name: 39,
                isActive: 1,
                isActiveFraction: 2,
                isVisible: 3,
                stores: 4,
                locale: 5,
                markupEditorToolbar: 6,
                markupEditorToolStyles: 7,
                markupEditorShapeStyleControls: 8,
                markupEditorToolSelectRadius: 9,
                markupEditorTextInputMode: 10,
                willRenderShapePresetToolbar: 11,
                annotateTools: 12,
                annotateToolShapes: 13,
                annotateShapeControls: 14,
                annotateActiveTool: 0,
                annotateEnableButtonFlipVertical: 15,
                annotateEnableSelectImagePreset: 16,
                annotatePresets: 17,
                annotateWillRenderShapePresetToolbar: 18,
                enableSelectToolToAddShape: 19,
                enableTapToAddText: 20,
                willRenderShapeControls: 21,
                beforeAddShape: 22,
                beforeRemoveShape: 23,
                beforeDeselectShape: 24,
                beforeSelectShape: 25,
                beforeUpdateShape: 26
            }, [-1, -1])
        }
        get name() {
            return this.$$.ctx[39]
        }
        get isActive() {
            return this.$$.ctx[1]
        }
        set isActive(e) {
            this.$set({
                isActive: e
            }), dr()
        }
        get isActiveFraction() {
            return this.$$.ctx[2]
        }
        set isActiveFraction(e) {
            this.$set({
                isActiveFraction: e
            }), dr()
        }
        get isVisible() {
            return this.$$.ctx[3]
        }
        set isVisible(e) {
            this.$set({
                isVisible: e
            }), dr()
        }
        get stores() {
            return this.$$.ctx[4]
        }
        set stores(e) {
            this.$set({
                stores: e
            }), dr()
        }
        get locale() {
            return this.$$.ctx[5]
        }
        set locale(e) {
            this.$set({
                locale: e
            }), dr()
        }
        get markupEditorToolbar() {
            return this.$$.ctx[6]
        }
        set markupEditorToolbar(e) {
            this.$set({
                markupEditorToolbar: e
            }), dr()
        }
        get markupEditorToolStyles() {
            return this.$$.ctx[7]
        }
        set markupEditorToolStyles(e) {
            this.$set({
                markupEditorToolStyles: e
            }), dr()
        }
        get markupEditorShapeStyleControls() {
            return this.$$.ctx[8]
        }
        set markupEditorShapeStyleControls(e) {
            this.$set({
                markupEditorShapeStyleControls: e
            }), dr()
        }
        get markupEditorToolSelectRadius() {
            return this.$$.ctx[9]
        }
        set markupEditorToolSelectRadius(e) {
            this.$set({
                markupEditorToolSelectRadius: e
            }), dr()
        }
        get markupEditorTextInputMode() {
            return this.$$.ctx[10]
        }
        set markupEditorTextInputMode(e) {
            this.$set({
                markupEditorTextInputMode: e
            }), dr()
        }
        get willRenderShapePresetToolbar() {
            return this.$$.ctx[11]
        }
        set willRenderShapePresetToolbar(e) {
            this.$set({
                willRenderShapePresetToolbar: e
            }), dr()
        }
        get annotateTools() {
            return this.$$.ctx[12]
        }
        set annotateTools(e) {
            this.$set({
                annotateTools: e
            }), dr()
        }
        get annotateToolShapes() {
            return this.$$.ctx[13]
        }
        set annotateToolShapes(e) {
            this.$set({
                annotateToolShapes: e
            }), dr()
        }
        get annotateShapeControls() {
            return this.$$.ctx[14]
        }
        set annotateShapeControls(e) {
            this.$set({
                annotateShapeControls: e
            }), dr()
        }
        get annotateActiveTool() {
            return this.$$.ctx[0]
        }
        set annotateActiveTool(e) {
            this.$set({
                annotateActiveTool: e
            }), dr()
        }
        get annotateEnableButtonFlipVertical() {
            return this.$$.ctx[15]
        }
        set annotateEnableButtonFlipVertical(e) {
            this.$set({
                annotateEnableButtonFlipVertical: e
            }), dr()
        }
        get annotateEnableSelectImagePreset() {
            return this.$$.ctx[16]
        }
        set annotateEnableSelectImagePreset(e) {
            this.$set({
                annotateEnableSelectImagePreset: e
            }), dr()
        }
        get annotatePresets() {
            return this.$$.ctx[17]
        }
        set annotatePresets(e) {
            this.$set({
                annotatePresets: e
            }), dr()
        }
        get annotateWillRenderShapePresetToolbar() {
            return this.$$.ctx[18]
        }
        set annotateWillRenderShapePresetToolbar(e) {
            this.$set({
                annotateWillRenderShapePresetToolbar: e
            }), dr()
        }
        get enableSelectToolToAddShape() {
            return this.$$.ctx[19]
        }
        set enableSelectToolToAddShape(e) {
            this.$set({
                enableSelectToolToAddShape: e
            }), dr()
        }
        get enableTapToAddText() {
            return this.$$.ctx[20]
        }
        set enableTapToAddText(e) {
            this.$set({
                enableTapToAddText: e
            }), dr()
        }
        get willRenderShapeControls() {
            return this.$$.ctx[21]
        }
        set willRenderShapeControls(e) {
            this.$set({
                willRenderShapeControls: e
            }), dr()
        }
        get beforeAddShape() {
            return this.$$.ctx[22]
        }
        set beforeAddShape(e) {
            this.$set({
                beforeAddShape: e
            }), dr()
        }
        get beforeRemoveShape() {
            return this.$$.ctx[23]
        }
        set beforeRemoveShape(e) {
            this.$set({
                beforeRemoveShape: e
            }), dr()
        }
        get beforeDeselectShape() {
            return this.$$.ctx[24]
        }
        set beforeDeselectShape(e) {
            this.$set({
                beforeDeselectShape: e
            }), dr()
        }
        get beforeSelectShape() {
            return this.$$.ctx[25]
        }
        set beforeSelectShape(e) {
            this.$set({
                beforeSelectShape: e
            }), dr()
        }
        get beforeUpdateShape() {
            return this.$$.ctx[26]
        }
        set beforeUpdateShape(e) {
            this.$set({
                beforeUpdateShape: e
            }), dr()
        }
    }]
};

function Jf(e) {
    let t, o, i;

    function n(t) {
        e[36](t)
    }
    let r = {
        stores: e[4],
        locale: e[5],
        isActive: e[1],
        isActiveFraction: e[2],
        isVisible: e[3],
        mapScreenPointToImagePoint: e[27],
        mapImagePointToScreenPoint: e[28],
        utilKey: "decorate",
        shapes: e[30],
        tools: e[12] || e[6],
        toolShapes: e[13] || e[7],
        shapeControls: e[14] || e[8],
        shapePresets: e[17],
        enableSelectToolToAddShape: e[19],
        enableTapToAddText: e[20],
        enablePresetSelectImage: e[16],
        enableButtonFlipVertical: e[15],
        parentRect: e[29],
        toolSelectRadius: e[9],
        textInputMode: e[10],
        willRenderPresetToolbar: e[18] || e[11],
        hooks: {
            willRenderShapeControls: e[21],
            beforeAddShape: e[22],
            beforeRemoveShape: e[23],
            beforeDeselectShape: e[24],
            beforeSelectShape: e[25],
            beforeUpdateShape: e[26]
        }
    };
    return void 0 !== e[0] && (r.toolActive = e[0]), t = new Xf({
        props: r
    }), tr.push((() => Rr(t, "toolActive", n))), t.$on("measure", e[37]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, o) {
            Ar(t, e, o), i = !0
        },
        p(e, i) {
            const n = {};
            16 & i[0] && (n.stores = e[4]), 32 & i[0] && (n.locale = e[5]), 2 & i[0] && (n.isActive = e[1]), 4 & i[0] && (n.isActiveFraction = e[2]), 8 & i[0] && (n.isVisible = e[3]), 134217728 & i[0] && (n.mapScreenPointToImagePoint = e[27]), 268435456 & i[0] && (n.mapImagePointToScreenPoint = e[28]), 4160 & i[0] && (n.tools = e[12] || e[6]), 8320 & i[0] && (n.toolShapes = e[13] || e[7]), 16640 & i[0] && (n.shapeControls = e[14] || e[8]), 131072 & i[0] && (n.shapePresets = e[17]), 524288 & i[0] && (n.enableSelectToolToAddShape = e[19]), 1048576 & i[0] && (n.enableTapToAddText = e[20]), 65536 & i[0] && (n.enablePresetSelectImage = e[16]), 32768 & i[0] && (n.enableButtonFlipVertical = e[15]), 512 & i[0] && (n.toolSelectRadius = e[9]), 1024 & i[0] && (n.textInputMode = e[10]), 264192 & i[0] && (n.willRenderPresetToolbar = e[18] || e[11]), 132120576 & i[0] && (n.hooks = {
                willRenderShapeControls: e[21],
                beforeAddShape: e[22],
                beforeRemoveShape: e[23],
                beforeDeselectShape: e[24],
                beforeSelectShape: e[25],
                beforeUpdateShape: e[26]
            }), !o && 1 & i[0] && (o = !0, n.toolActive = e[0], sr((() => o = !1))), t.$set(n)
        },
        i(e) {
            i || (yr(t.$$.fragment, e), i = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), i = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function Qf(e, t, o) {
    let i, n, r, a;
    let {
        isActive: s
    } = t, {
        isActiveFraction: l
    } = t, {
        isVisible: c
    } = t, {
        stores: d
    } = t, {
        locale: u = {}
    } = t, {
        markupEditorToolbar: h
    } = t, {
        markupEditorToolStyles: p
    } = t, {
        markupEditorShapeStyleControls: m
    } = t, {
        markupEditorToolSelectRadius: g
    } = t, {
        markupEditorTextInputMode: f
    } = t, {
        willRenderShapePresetToolbar: $
    } = t, {
        decorateTools: y
    } = t, {
        decorateToolShapes: x
    } = t, {
        decorateShapeControls: b
    } = t, {
        decorateActiveTool: v
    } = t, {
        decorateEnableButtonFlipVertical: w = !1
    } = t, {
        decorateEnableSelectImagePreset: S = !1
    } = t, {
        decoratePresets: C = []
    } = t, {
        decorateWillRenderShapePresetToolbar: k
    } = t, {
        enableSelectToolToAddShape: M
    } = t, {
        enableTapToAddText: T
    } = t, {
        willRenderShapeControls: R
    } = t, {
        beforeAddShape: P
    } = t, {
        beforeRemoveShape: A
    } = t, {
        beforeDeselectShape: I
    } = t, {
        beforeSelectShape: E
    } = t, {
        beforeUpdateShape: L
    } = t;
    const {
        imageCropRect: F,
        imageDecoration: z,
        imageSelectionRectPresentation: B,
        presentationScalar: D
    } = d;
    return cn(e, B, (e => o(34, r = e))), cn(e, D, (e => o(35, a = e))), e.$$set = e => {
        "isActive" in e && o(1, s = e.isActive), "isActiveFraction" in e && o(2, l = e.isActiveFraction), "isVisible" in e && o(3, c = e.isVisible), "stores" in e && o(4, d = e.stores), "locale" in e && o(5, u = e.locale), "markupEditorToolbar" in e && o(6, h = e.markupEditorToolbar), "markupEditorToolStyles" in e && o(7, p = e.markupEditorToolStyles), "markupEditorShapeStyleControls" in e && o(8, m = e.markupEditorShapeStyleControls), "markupEditorToolSelectRadius" in e && o(9, g = e.markupEditorToolSelectRadius), "markupEditorTextInputMode" in e && o(10, f = e.markupEditorTextInputMode), "willRenderShapePresetToolbar" in e && o(11, $ = e.willRenderShapePresetToolbar), "decorateTools" in e && o(12, y = e.decorateTools), "decorateToolShapes" in e && o(13, x = e.decorateToolShapes), "decorateShapeControls" in e && o(14, b = e.decorateShapeControls), "decorateActiveTool" in e && o(0, v = e.decorateActiveTool), "decorateEnableButtonFlipVertical" in e && o(15, w = e.decorateEnableButtonFlipVertical), "decorateEnableSelectImagePreset" in e && o(16, S = e.decorateEnableSelectImagePreset), "decoratePresets" in e && o(17, C = e.decoratePresets), "decorateWillRenderShapePresetToolbar" in e && o(18, k = e.decorateWillRenderShapePresetToolbar), "enableSelectToolToAddShape" in e && o(19, M = e.enableSelectToolToAddShape), "enableTapToAddText" in e && o(20, T = e.enableTapToAddText), "willRenderShapeControls" in e && o(21, R = e.willRenderShapeControls), "beforeAddShape" in e && o(22, P = e.beforeAddShape), "beforeRemoveShape" in e && o(23, A = e.beforeRemoveShape), "beforeDeselectShape" in e && o(24, I = e.beforeDeselectShape), "beforeSelectShape" in e && o(25, E = e.beforeSelectShape), "beforeUpdateShape" in e && o(26, L = e.beforeUpdateShape)
    }, e.$$.update = () => {
        24 & e.$$.dirty[1] && o(27, i = e => {
            const t = Z(e);
            return t.x -= r.x, t.y -= r.y, t.x /= a, t.y /= a, t
        }), 24 & e.$$.dirty[1] && o(28, n = e => {
            const t = Z(e);
            return t.x *= a, t.y *= a, t.x += r.x, t.y += r.y, t
        })
    }, [v, s, l, c, d, u, h, p, m, g, f, $, y, x, b, w, S, C, k, M, T, R, P, A, I, E, L, i, n, F, z, B, D, "decorate", r, a, function (e) {
        v = e, o(0, v)
    }, function (t) {
        Qn(e, t)
    }]
}
var e$ = {
    util: ["decorate", class extends Fr {
        constructor(e) {
            super(), Lr(this, e, Qf, Jf, an, {
                name: 33,
                isActive: 1,
                isActiveFraction: 2,
                isVisible: 3,
                stores: 4,
                locale: 5,
                markupEditorToolbar: 6,
                markupEditorToolStyles: 7,
                markupEditorShapeStyleControls: 8,
                markupEditorToolSelectRadius: 9,
                markupEditorTextInputMode: 10,
                willRenderShapePresetToolbar: 11,
                decorateTools: 12,
                decorateToolShapes: 13,
                decorateShapeControls: 14,
                decorateActiveTool: 0,
                decorateEnableButtonFlipVertical: 15,
                decorateEnableSelectImagePreset: 16,
                decoratePresets: 17,
                decorateWillRenderShapePresetToolbar: 18,
                enableSelectToolToAddShape: 19,
                enableTapToAddText: 20,
                willRenderShapeControls: 21,
                beforeAddShape: 22,
                beforeRemoveShape: 23,
                beforeDeselectShape: 24,
                beforeSelectShape: 25,
                beforeUpdateShape: 26
            }, [-1, -1])
        }
        get name() {
            return this.$$.ctx[33]
        }
        get isActive() {
            return this.$$.ctx[1]
        }
        set isActive(e) {
            this.$set({
                isActive: e
            }), dr()
        }
        get isActiveFraction() {
            return this.$$.ctx[2]
        }
        set isActiveFraction(e) {
            this.$set({
                isActiveFraction: e
            }), dr()
        }
        get isVisible() {
            return this.$$.ctx[3]
        }
        set isVisible(e) {
            this.$set({
                isVisible: e
            }), dr()
        }
        get stores() {
            return this.$$.ctx[4]
        }
        set stores(e) {
            this.$set({
                stores: e
            }), dr()
        }
        get locale() {
            return this.$$.ctx[5]
        }
        set locale(e) {
            this.$set({
                locale: e
            }), dr()
        }
        get markupEditorToolbar() {
            return this.$$.ctx[6]
        }
        set markupEditorToolbar(e) {
            this.$set({
                markupEditorToolbar: e
            }), dr()
        }
        get markupEditorToolStyles() {
            return this.$$.ctx[7]
        }
        set markupEditorToolStyles(e) {
            this.$set({
                markupEditorToolStyles: e
            }), dr()
        }
        get markupEditorShapeStyleControls() {
            return this.$$.ctx[8]
        }
        set markupEditorShapeStyleControls(e) {
            this.$set({
                markupEditorShapeStyleControls: e
            }), dr()
        }
        get markupEditorToolSelectRadius() {
            return this.$$.ctx[9]
        }
        set markupEditorToolSelectRadius(e) {
            this.$set({
                markupEditorToolSelectRadius: e
            }), dr()
        }
        get markupEditorTextInputMode() {
            return this.$$.ctx[10]
        }
        set markupEditorTextInputMode(e) {
            this.$set({
                markupEditorTextInputMode: e
            }), dr()
        }
        get willRenderShapePresetToolbar() {
            return this.$$.ctx[11]
        }
        set willRenderShapePresetToolbar(e) {
            this.$set({
                willRenderShapePresetToolbar: e
            }), dr()
        }
        get decorateTools() {
            return this.$$.ctx[12]
        }
        set decorateTools(e) {
            this.$set({
                decorateTools: e
            }), dr()
        }
        get decorateToolShapes() {
            return this.$$.ctx[13]
        }
        set decorateToolShapes(e) {
            this.$set({
                decorateToolShapes: e
            }), dr()
        }
        get decorateShapeControls() {
            return this.$$.ctx[14]
        }
        set decorateShapeControls(e) {
            this.$set({
                decorateShapeControls: e
            }), dr()
        }
        get decorateActiveTool() {
            return this.$$.ctx[0]
        }
        set decorateActiveTool(e) {
            this.$set({
                decorateActiveTool: e
            }), dr()
        }
        get decorateEnableButtonFlipVertical() {
            return this.$$.ctx[15]
        }
        set decorateEnableButtonFlipVertical(e) {
            this.$set({
                decorateEnableButtonFlipVertical: e
            }), dr()
        }
        get decorateEnableSelectImagePreset() {
            return this.$$.ctx[16]
        }
        set decorateEnableSelectImagePreset(e) {
            this.$set({
                decorateEnableSelectImagePreset: e
            }), dr()
        }
        get decoratePresets() {
            return this.$$.ctx[17]
        }
        set decoratePresets(e) {
            this.$set({
                decoratePresets: e
            }), dr()
        }
        get decorateWillRenderShapePresetToolbar() {
            return this.$$.ctx[18]
        }
        set decorateWillRenderShapePresetToolbar(e) {
            this.$set({
                decorateWillRenderShapePresetToolbar: e
            }), dr()
        }
        get enableSelectToolToAddShape() {
            return this.$$.ctx[19]
        }
        set enableSelectToolToAddShape(e) {
            this.$set({
                enableSelectToolToAddShape: e
            }), dr()
        }
        get enableTapToAddText() {
            return this.$$.ctx[20]
        }
        set enableTapToAddText(e) {
            this.$set({
                enableTapToAddText: e
            }), dr()
        }
        get willRenderShapeControls() {
            return this.$$.ctx[21]
        }
        set willRenderShapeControls(e) {
            this.$set({
                willRenderShapeControls: e
            }), dr()
        }
        get beforeAddShape() {
            return this.$$.ctx[22]
        }
        set beforeAddShape(e) {
            this.$set({
                beforeAddShape: e
            }), dr()
        }
        get beforeRemoveShape() {
            return this.$$.ctx[23]
        }
        set beforeRemoveShape(e) {
            this.$set({
                beforeRemoveShape: e
            }), dr()
        }
        get beforeDeselectShape() {
            return this.$$.ctx[24]
        }
        set beforeDeselectShape(e) {
            this.$set({
                beforeDeselectShape: e
            }), dr()
        }
        get beforeSelectShape() {
            return this.$$.ctx[25]
        }
        set beforeSelectShape(e) {
            this.$set({
                beforeSelectShape: e
            }), dr()
        }
        get beforeUpdateShape() {
            return this.$$.ctx[26]
        }
        set beforeUpdateShape(e) {
            this.$set({
                beforeUpdateShape: e
            }), dr()
        }
    }]
};

function t$(e) {
    let t, o;
    return t = new Xf({
        props: {
            stores: e[3],
            locale: e[4],
            isActive: e[0],
            isActiveFraction: e[1],
            isVisible: e[2],
            mapScreenPointToImagePoint: e[32],
            mapImagePointToScreenPoint: e[33],
            utilKey: "sticker",
            shapePresets: e[5],
            shapes: e[6] ? e[25] : e[26],
            toolActive: "preset",
            imageFlipX: !!e[6] && e[18],
            imageFlipY: !!e[6] && e[19],
            imageRotation: e[6] ? e[20] : 0,
            parentRect: e[6] ? e[27] : e[23],
            enablePresetSelectImage: e[7],
            enableButtonFlipVertical: e[8],
            toolSelectRadius: e[11],
            willRenderPresetToolbar: e[9] || e[12],
            hooks: {
                willRenderShapeControls: e[10],
                beforeAddShape: e[13],
                beforeRemoveShape: e[14],
                beforeDeselectShape: e[15],
                beforeSelectShape: e[16],
                beforeUpdateShape: e[17]
            }
        }
    }), t.$on("measure", e[35]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            8 & o[0] && (i.stores = e[3]), 16 & o[0] && (i.locale = e[4]), 1 & o[0] && (i.isActive = e[0]), 2 & o[0] && (i.isActiveFraction = e[1]), 4 & o[0] && (i.isVisible = e[2]), 32 & o[0] && (i.shapePresets = e[5]), 64 & o[0] && (i.shapes = e[6] ? e[25] : e[26]), 262208 & o[0] && (i.imageFlipX = !!e[6] && e[18]), 524352 & o[0] && (i.imageFlipY = !!e[6] && e[19]), 1048640 & o[0] && (i.imageRotation = e[6] ? e[20] : 0), 64 & o[0] && (i.parentRect = e[6] ? e[27] : e[23]), 128 & o[0] && (i.enablePresetSelectImage = e[7]), 256 & o[0] && (i.enableButtonFlipVertical = e[8]), 2048 & o[0] && (i.toolSelectRadius = e[11]), 4608 & o[0] && (i.willRenderPresetToolbar = e[9] || e[12]), 254976 & o[0] && (i.hooks = {
                willRenderShapeControls: e[10],
                beforeAddShape: e[13],
                beforeRemoveShape: e[14],
                beforeDeselectShape: e[15],
                beforeSelectShape: e[16],
                beforeUpdateShape: e[17]
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function o$(e, t, o) {
    let i, n, r, a, s, l, c, d;
    let {
        isActive: u
    } = t, {
        isActiveFraction: h
    } = t, {
        isVisible: p
    } = t, {
        stores: m
    } = t, {
        locale: g = {}
    } = t, {
        stickers: f = []
    } = t, {
        stickerStickToImage: $ = !1
    } = t, {
        stickerEnableSelectImage: y = !0
    } = t, {
        stickersEnableButtonFlipVertical: x = !1
    } = t, {
        stickersWillRenderShapePresetToolbar: b
    } = t, {
        willRenderShapeControls: v
    } = t, {
        markupEditorToolSelectRadius: w
    } = t, {
        willRenderShapePresetToolbar: S
    } = t, {
        beforeAddShape: C
    } = t, {
        beforeRemoveShape: k
    } = t, {
        beforeDeselectShape: M
    } = t, {
        beforeSelectShape: T
    } = t, {
        beforeUpdateShape: R
    } = t;
    const {
        presentationScalar: P,
        rootRect: A,
        imageCropRect: I,
        imageSelectionRectPresentation: E,
        imageAnnotation: L,
        imageDecoration: F,
        imageSize: z,
        imageTransforms: B,
        imageRotation: D,
        imageFlipX: O,
        imageFlipY: _
    } = m;
    cn(e, P, (e => o(40, c = e))), cn(e, A, (e => o(36, i = e))), cn(e, E, (e => o(39, l = e))), cn(e, z, (e => o(37, n = e))), cn(e, B, (e => o(38, r = e))), cn(e, D, (e => o(20, d = e))), cn(e, O, (e => o(18, a = e))), cn(e, _, (e => o(19, s = e)));
    const W = $ ? e => Gf(e, i, n, r.origin, r.translation, r.rotation.z, r.scale, a, s) : e => {
            const t = Z(e);
            return t.x -= l.x, t.y -= l.y, t.x /= c, t.y /= c, t
        },
        V = $ ? e => Yf(e, i, n, r.origin, r.translation, r.rotation.z, r.scale, a, s) : e => {
            const t = Z(e);
            return t.x *= c, t.y *= c, t.x += l.x, t.y += l.y, t
        };
    return e.$$set = e => {
        "isActive" in e && o(0, u = e.isActive), "isActiveFraction" in e && o(1, h = e.isActiveFraction), "isVisible" in e && o(2, p = e.isVisible), "stores" in e && o(3, m = e.stores), "locale" in e && o(4, g = e.locale), "stickers" in e && o(5, f = e.stickers), "stickerStickToImage" in e && o(6, $ = e.stickerStickToImage), "stickerEnableSelectImage" in e && o(7, y = e.stickerEnableSelectImage), "stickersEnableButtonFlipVertical" in e && o(8, x = e.stickersEnableButtonFlipVertical), "stickersWillRenderShapePresetToolbar" in e && o(9, b = e.stickersWillRenderShapePresetToolbar), "willRenderShapeControls" in e && o(10, v = e.willRenderShapeControls), "markupEditorToolSelectRadius" in e && o(11, w = e.markupEditorToolSelectRadius), "willRenderShapePresetToolbar" in e && o(12, S = e.willRenderShapePresetToolbar), "beforeAddShape" in e && o(13, C = e.beforeAddShape), "beforeRemoveShape" in e && o(14, k = e.beforeRemoveShape), "beforeDeselectShape" in e && o(15, M = e.beforeDeselectShape), "beforeSelectShape" in e && o(16, T = e.beforeSelectShape), "beforeUpdateShape" in e && o(17, R = e.beforeUpdateShape)
    }, [u, h, p, m, g, f, $, y, x, b, v, w, S, C, k, M, T, R, a, s, d, P, A, I, E, L, F, z, B, D, O, _, W, V, "sticker", function (t) {
        Qn(e, t)
    }]
}
var i$ = {
    util: ["sticker", class extends Fr {
        constructor(e) {
            super(), Lr(this, e, o$, t$, an, {
                name: 34,
                isActive: 0,
                isActiveFraction: 1,
                isVisible: 2,
                stores: 3,
                locale: 4,
                stickers: 5,
                stickerStickToImage: 6,
                stickerEnableSelectImage: 7,
                stickersEnableButtonFlipVertical: 8,
                stickersWillRenderShapePresetToolbar: 9,
                willRenderShapeControls: 10,
                markupEditorToolSelectRadius: 11,
                willRenderShapePresetToolbar: 12,
                beforeAddShape: 13,
                beforeRemoveShape: 14,
                beforeDeselectShape: 15,
                beforeSelectShape: 16,
                beforeUpdateShape: 17
            }, [-1, -1])
        }
        get name() {
            return this.$$.ctx[34]
        }
        get isActive() {
            return this.$$.ctx[0]
        }
        set isActive(e) {
            this.$set({
                isActive: e
            }), dr()
        }
        get isActiveFraction() {
            return this.$$.ctx[1]
        }
        set isActiveFraction(e) {
            this.$set({
                isActiveFraction: e
            }), dr()
        }
        get isVisible() {
            return this.$$.ctx[2]
        }
        set isVisible(e) {
            this.$set({
                isVisible: e
            }), dr()
        }
        get stores() {
            return this.$$.ctx[3]
        }
        set stores(e) {
            this.$set({
                stores: e
            }), dr()
        }
        get locale() {
            return this.$$.ctx[4]
        }
        set locale(e) {
            this.$set({
                locale: e
            }), dr()
        }
        get stickers() {
            return this.$$.ctx[5]
        }
        set stickers(e) {
            this.$set({
                stickers: e
            }), dr()
        }
        get stickerStickToImage() {
            return this.$$.ctx[6]
        }
        set stickerStickToImage(e) {
            this.$set({
                stickerStickToImage: e
            }), dr()
        }
        get stickerEnableSelectImage() {
            return this.$$.ctx[7]
        }
        set stickerEnableSelectImage(e) {
            this.$set({
                stickerEnableSelectImage: e
            }), dr()
        }
        get stickersEnableButtonFlipVertical() {
            return this.$$.ctx[8]
        }
        set stickersEnableButtonFlipVertical(e) {
            this.$set({
                stickersEnableButtonFlipVertical: e
            }), dr()
        }
        get stickersWillRenderShapePresetToolbar() {
            return this.$$.ctx[9]
        }
        set stickersWillRenderShapePresetToolbar(e) {
            this.$set({
                stickersWillRenderShapePresetToolbar: e
            }), dr()
        }
        get willRenderShapeControls() {
            return this.$$.ctx[10]
        }
        set willRenderShapeControls(e) {
            this.$set({
                willRenderShapeControls: e
            }), dr()
        }
        get markupEditorToolSelectRadius() {
            return this.$$.ctx[11]
        }
        set markupEditorToolSelectRadius(e) {
            this.$set({
                markupEditorToolSelectRadius: e
            }), dr()
        }
        get willRenderShapePresetToolbar() {
            return this.$$.ctx[12]
        }
        set willRenderShapePresetToolbar(e) {
            this.$set({
                willRenderShapePresetToolbar: e
            }), dr()
        }
        get beforeAddShape() {
            return this.$$.ctx[13]
        }
        set beforeAddShape(e) {
            this.$set({
                beforeAddShape: e
            }), dr()
        }
        get beforeRemoveShape() {
            return this.$$.ctx[14]
        }
        set beforeRemoveShape(e) {
            this.$set({
                beforeRemoveShape: e
            }), dr()
        }
        get beforeDeselectShape() {
            return this.$$.ctx[15]
        }
        set beforeDeselectShape(e) {
            this.$set({
                beforeDeselectShape: e
            }), dr()
        }
        get beforeSelectShape() {
            return this.$$.ctx[16]
        }
        set beforeSelectShape(e) {
            this.$set({
                beforeSelectShape: e
            }), dr()
        }
        get beforeUpdateShape() {
            return this.$$.ctx[17]
        }
        set beforeUpdateShape(e) {
            this.$set({
                beforeUpdateShape: e
            }), dr()
        }
    }]
};

function n$(e) {
    let t, o, i, n, r, a = (e[13](e[29].value) || "") + "",
        s = (S(e[29].label) ? e[29].label(e[1]) : e[29].label) + "";
    return {
        c() {
            t = Mn("div"), i = Pn(), n = Mn("span"), r = Rn(s), o = new _n(i), Fn(t, "slot", "option")
        },
        m(e, s) {
            Cn(e, t, s), o.m(a, t), Sn(t, i), Sn(t, n), Sn(n, r)
        },
        p(e, t) {
            536870912 & t && a !== (a = (e[13](e[29].value) || "") + "") && o.p(a), 536870914 & t && s !== (s = (S(e[29].label) ? e[29].label(e[1]) : e[29].label) + "") && Bn(r, s)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function r$(e) {
    let t, o;
    return t = new ad({
        props: {
            locale: e[1],
            layout: "row",
            options: e[2],
            selectedIndex: e[10],
            onchange: e[11],
            $$slots: {
                option: [n$, ({
                    option: e
                }) => ({
                    29: e
                }), ({
                    option: e
                }) => e ? 536870912 : 0]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            2 & o && (i.locale = e[1]), 4 & o && (i.options = e[2]), 1610612738 & o && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function a$(e) {
    let t, o, i, n, r;
    return o = new af({
        props: {
            locale: e[1],
            shape: e[5],
            onchange: e[12],
            controls: e[3],
            scrollElasticity: e[4]
        }
    }), n = new Kl({
        props: {
            elasticity: e[8],
            $$slots: {
                default: [r$]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            t = Mn("div"), Pr(o.$$.fragment), i = Pn(), Pr(n.$$.fragment), Fn(t, "slot", "footer"), Fn(t, "style", e[6])
        },
        m(e, a) {
            Cn(e, t, a), Ar(o, t, null), Sn(t, i), Ar(n, t, null), r = !0
        },
        p(e, i) {
            const a = {};
            2 & i && (a.locale = e[1]), 32 & i && (a.shape = e[5]), 8 & i && (a.controls = e[3]), 16 & i && (a.scrollElasticity = e[4]), o.$set(a);
            const s = {};
            1073741830 & i && (s.$$scope = {
                dirty: i,
                ctx: e
            }), n.$set(s), (!r || 64 & i) && Fn(t, "style", e[6])
        },
        i(e) {
            r || (yr(o.$$.fragment, e), yr(n.$$.fragment, e), r = !0)
        },
        o(e) {
            xr(o.$$.fragment, e), xr(n.$$.fragment, e), r = !1
        },
        d(e) {
            e && kn(t), Ir(o), Ir(n)
        }
    }
}

function s$(e) {
    let t, o;
    return t = new am({
        props: {
            $$slots: {
                footer: [a$]
            },
            $$scope: {
                ctx: e
            }
        }
    }), t.$on("measure", e[21]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, [o]) {
            const i = {};
            1073741950 & o && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function l$(e, t, o) {
    let i, n, r, a, s, l, c = Ji,
        d = () => (c(), c = sn(u, (e => o(19, s = e))), u);
    e.$$.on_destroy.push((() => c()));
    let {
        isActive: u
    } = t;
    d();
    let {
        stores: h
    } = t, {
        locale: p = {}
    } = t, {
        frameStyles: m = {}
    } = t, {
        frameOptions: g = []
    } = t, {
        markupEditorShapeStyleControls: f
    } = t;
    const {
        history: $,
        animation: y,
        elasticityMultiplier: x,
        scrollElasticity: b,
        imageFrame: v
    } = h;
    cn(e, y, (e => o(18, a = e))), cn(e, v, (e => o(5, r = e)));
    let w = r ? g.findIndex((([e]) => e === r.id)) : 0,
        S = {};
    let C;
    const k = rs(a ? 20 : 0);
    return cn(e, k, (e => o(20, l = e))), e.$$set = e => {
        "isActive" in e && d(o(0, u = e.isActive)), "stores" in e && o(16, h = e.stores), "locale" in e && o(1, p = e.locale), "frameStyles" in e && o(17, m = e.frameStyles), "frameOptions" in e && o(2, g = e.frameOptions), "markupEditorShapeStyleControls" in e && o(3, f = e.markupEditorShapeStyleControls)
    }, e.$$.update = () => {
        786432 & e.$$.dirty && a && k.set(s ? 0 : 20), 1048576 & e.$$.dirty && o(6, n = l ? `transform: translateY(${l}px)` : void 0)
    }, o(4, i = x * b), [u, p, g, f, i, r, n, y, b, v, w, ({
        value: e
    }) => {
        const t = m[e];
        if (!t || !t.shape) return v.set(void 0), void $.write();
        const {
            shape: o
        } = t, i = {
            id: e,
            ...Eo(o),
            ...Object.keys(S).reduce(((e, t) => o[t] ? (e[t] = S[t], e) : e), {})
        };
        v.set(i), $.write()
    }, function (e) {
        Jt(e, "frameColor") && (S.frameColor = e.frameColor), r && (Mi(r, e), v.set(r), clearTimeout(C), C = setTimeout((() => {
            $.write()
        }), 200))
    }, e => {
        const t = m[e];
        var o;
        if (t && t.thumb) return o = t.thumb, /div/i.test(o) || gf(o) ? o : /rect|path|circle|line|<g>/i.test(o) ? `<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" stroke-width="1" stroke="currentColor" fill="none" aria-hidden="true" focusable="false" stroke-linecap="round" stroke-linejoin="round">${o}</svg>` : `<img src="${o}" alt=""/>`
    }, k, "frame", h, m, a, s, l, function (t) {
        Qn(e, t)
    }]
}
var c$ = {
    util: ["frame", class extends Fr {
        constructor(e) {
            super(), Lr(this, e, l$, s$, an, {
                name: 15,
                isActive: 0,
                stores: 16,
                locale: 1,
                frameStyles: 17,
                frameOptions: 2,
                markupEditorShapeStyleControls: 3
            })
        }
        get name() {
            return this.$$.ctx[15]
        }
        get isActive() {
            return this.$$.ctx[0]
        }
        set isActive(e) {
            this.$set({
                isActive: e
            }), dr()
        }
        get stores() {
            return this.$$.ctx[16]
        }
        set stores(e) {
            this.$set({
                stores: e
            }), dr()
        }
        get locale() {
            return this.$$.ctx[1]
        }
        set locale(e) {
            this.$set({
                locale: e
            }), dr()
        }
        get frameStyles() {
            return this.$$.ctx[17]
        }
        set frameStyles(e) {
            this.$set({
                frameStyles: e
            }), dr()
        }
        get frameOptions() {
            return this.$$.ctx[2]
        }
        set frameOptions(e) {
            this.$set({
                frameOptions: e
            }), dr()
        }
        get markupEditorShapeStyleControls() {
            return this.$$.ctx[3]
        }
        set markupEditorShapeStyleControls(e) {
            this.$set({
                markupEditorShapeStyleControls: e
            }), dr()
        }
    }]
};

function d$(e) {
    let t, o, i, n, r, a, s, l;
    return {
        c() {
            t = Mn("div"), o = Mn("label"), i = Rn(e[1]), n = Pn(), r = Mn("input"), Fn(o, "for", e[0]), Fn(o, "title", e[2]), Fn(o, "aria-label", e[2]), Fn(r, "id", e[0]), Fn(r, "type", "text"), Fn(r, "inputmode", "numeric"), Fn(r, "pattern", "[0-9]*"), Fn(r, "data-state", e[3]), Fn(r, "autocomplete", "off"), Fn(r, "placeholder", e[4]), r.value = a = void 0 === e[5] ? "" : e[7](e[5] + ""), Fn(t, "class", "PinturaInputDimension")
        },
        m(a, c) {
            Cn(a, t, c), Sn(t, o), Sn(o, i), Sn(t, n), Sn(t, r), s || (l = In(r, "input", e[8]), s = !0)
        },
        p(e, [t]) {
            2 & t && Bn(i, e[1]), 1 & t && Fn(o, "for", e[0]), 4 & t && Fn(o, "title", e[2]), 4 & t && Fn(o, "aria-label", e[2]), 1 & t && Fn(r, "id", e[0]), 8 & t && Fn(r, "data-state", e[3]), 16 & t && Fn(r, "placeholder", e[4]), 160 & t && a !== (a = void 0 === e[5] ? "" : e[7](e[5] + "")) && r.value !== a && (r.value = a)
        },
        i: Ji,
        o: Ji,
        d(e) {
            e && kn(t), s = !1, l()
        }
    }
}

function u$(e, t, o) {
    let {
        id: i
    } = t, {
        label: n
    } = t, {
        title: r
    } = t, {
        state: a
    } = t, {
        placeholder: s
    } = t, {
        value: l
    } = t, {
        onchange: c
    } = t, {
        format: d = (e => e.replace(/\D/g, ""))
    } = t;
    return e.$$set = e => {
        "id" in e && o(0, i = e.id), "label" in e && o(1, n = e.label), "title" in e && o(2, r = e.title), "state" in e && o(3, a = e.state), "placeholder" in e && o(4, s = e.placeholder), "value" in e && o(5, l = e.value), "onchange" in e && o(6, c = e.onchange), "format" in e && o(7, d = e.format)
    }, [i, n, r, a, s, l, c, d, e => c(d(e.currentTarget.value))]
}
class h$ extends Fr {
    constructor(e) {
        super(), Lr(this, e, u$, d$, an, {
            id: 0,
            label: 1,
            title: 2,
            state: 3,
            placeholder: 4,
            value: 5,
            onchange: 6,
            format: 7
        })
    }
}

function p$(e) {
    let t;
    return {
        c() {
            t = Tn("g")
        },
        m(o, i) {
            Cn(o, t, i), t.innerHTML = e[2]
        },
        p(e, o) {
            4 & o && (t.innerHTML = e[2])
        },
        d(e) {
            e && kn(t)
        }
    }
}

function m$(e) {
    let t, o, i, n, r, a, s, l;
    return r = new Ll({
        props: {
            $$slots: {
                default: [p$]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            t = Mn("div"), o = Mn("input"), i = Pn(), n = Mn("label"), Pr(r.$$.fragment), Fn(o, "id", e[0]), Fn(o, "class", "implicit"), Fn(o, "type", "checkbox"), o.checked = e[1], Fn(n, "for", e[0]), Fn(n, "title", e[3])
        },
        m(c, d) {
            Cn(c, t, d), Sn(t, o), Sn(t, i), Sn(t, n), Ar(r, n, null), a = !0, s || (l = In(o, "change", e[5]), s = !0)
        },
        p(e, [t]) {
            (!a || 1 & t) && Fn(o, "id", e[0]), (!a || 2 & t) && (o.checked = e[1]);
            const i = {};
            68 & t && (i.$$scope = {
                dirty: t,
                ctx: e
            }), r.$set(i), (!a || 1 & t) && Fn(n, "for", e[0]), (!a || 8 & t) && Fn(n, "title", e[3])
        },
        i(e) {
            a || (yr(r.$$.fragment, e), a = !0)
        },
        o(e) {
            xr(r.$$.fragment, e), a = !1
        },
        d(e) {
            e && kn(t), Ir(r), s = !1, l()
        }
    }
}

function g$(e, t, o) {
    let {
        id: i
    } = t, {
        locked: n
    } = t, {
        icon: r
    } = t, {
        title: a
    } = t, {
        onchange: s
    } = t;
    return e.$$set = e => {
        "id" in e && o(0, i = e.id), "locked" in e && o(1, n = e.locked), "icon" in e && o(2, r = e.icon), "title" in e && o(3, a = e.title), "onchange" in e && o(4, s = e.onchange)
    }, [i, n, r, a, s, e => s(e.currentTarget.checked)]
}
class f$ extends Fr {
    constructor(e) {
        super(), Lr(this, e, g$, m$, an, {
            id: 0,
            locked: 1,
            icon: 2,
            title: 3,
            onchange: 4
        })
    }
}

function $$(e) {
    let t;
    return {
        c() {
            t = Rn("Save")
        },
        m(e, o) {
            Cn(e, t, o)
        },
        d(e) {
            e && kn(t)
        }
    }
}

function y$(e) {
    let t, o, i, n, r, a, s, l, c, d, u, h, p, m = e[1].resizeLabelFormCaption + "";
    return l = new Vd({
        props: {
            items: e[3]
        }
    }), d = new Wl({
        props: {
            type: "submit",
            class: "implicit",
            $$slots: {
                default: [$$]
            },
            $$scope: {
                ctx: e
            }
        }
    }), {
        c() {
            t = Mn("form"), o = Mn("div"), i = Mn("fieldset"), n = Mn("legend"), r = Rn(m), a = Pn(), s = Mn("div"), Pr(l.$$.fragment), c = Pn(), Pr(d.$$.fragment), Fn(n, "class", "implicit"), Fn(s, "class", "PinturaFieldsetInner"), Fn(o, "class", "PinturaFormInner"), Fn(t, "slot", "footer"), Fn(t, "style", e[4])
        },
        m(m, g) {
            Cn(m, t, g), Sn(t, o), Sn(o, i), Sn(i, n), Sn(n, r), Sn(i, a), Sn(i, s), Ar(l, s, null), e[62](s), Sn(o, c), Ar(d, o, null), u = !0, h || (p = [In(s, "focusin", e[13]), In(s, "focusout", e[14]), In(t, "submit", En(e[15]))], h = !0)
        },
        p(e, o) {
            (!u || 2 & o[0]) && m !== (m = e[1].resizeLabelFormCaption + "") && Bn(r, m);
            const i = {};
            8 & o[0] && (i.items = e[3]), l.$set(i);
            const n = {};
            2097152 & o[2] && (n.$$scope = {
                dirty: o,
                ctx: e
            }), d.$set(n), (!u || 16 & o[0]) && Fn(t, "style", e[4])
        },
        i(e) {
            u || (yr(l.$$.fragment, e), yr(d.$$.fragment, e), u = !0)
        },
        o(e) {
            xr(l.$$.fragment, e), xr(d.$$.fragment, e), u = !1
        },
        d(o) {
            o && kn(t), Ir(l), e[62](null), Ir(d), h = !1, nn(p)
        }
    }
}

function x$(e) {
    let t, o;
    return t = new am({
        props: {
            $$slots: {
                footer: [y$]
            },
            $$scope: {
                ctx: e
            }
        }
    }), t.$on("measure", e[63]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, o) {
            const i = {};
            30 & o[0] | 2097152 & o[2] && (i.$$scope = {
                dirty: o,
                ctx: e
            }), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function b$(e, t, o) {
    let i, n, r, a, s, l, c, d, u, h, p, m, g, f, $, y, x, b, v, S, C, k, M, R, P, A, I, E, L = Ji,
        F = () => (L(), L = sn(B, (e => o(60, I = e))), B);
    e.$$.on_destroy.push((() => L()));
    const z = (e, t = 0, o = 9999) => {
        if (w(e) && !(e = e.replace(/\D/g, "")).length) return;
        const i = Math.round(e);
        return Number.isNaN(i) ? void 0 : oa(i, t, o)
    };
    let {
        isActive: B
    } = t;
    F();
    let {
        stores: D
    } = t, {
        locale: W = {}
    } = t, {
        resizeMinSize: V = be(1, 1)
    } = t, {
        resizeMaxSize: H = be(9999, 9999)
    } = t, {
        resizeSizePresetOptions: N
    } = t, {
        resizeWidthPresetOptions: U
    } = t, {
        resizeHeightPresetOptions: j
    } = t, {
        resizeWillRenderFooter: X = _
    } = t;
    const Y = rs(0, {
        stiffness: .15,
        damping: .3
    });
    cn(e, Y, (e => o(57, R = e)));
    const {
        animation: G,
        imageSize: q,
        imageCropRect: Z,
        imageCropRectAspectRatio: K,
        imageCropAspectRatio: J,
        imageOutputSize: Q,
        history: ee,
        env: te
    } = D;
    cn(e, G, (e => o(59, A = e))), cn(e, q, (e => o(69, g = e))), cn(e, Z, (e => o(52, M = e))), cn(e, K, (e => o(39, h = e))), cn(e, J, (e => o(68, m = e))), cn(e, Q, (e => o(67, p = e))), cn(e, te, (e => o(58, P = e)));
    const oe = T();
    let ie, ne, re, ae, se, le = !1;
    const ce = (e, t, o, i, n) => null != e && o !== t ? e >= i[t] && e <= n[t] ? "valid" : "invalid" : "undetermined",
        de = (e, t, o) => Math.round(null != e ? e / t : o.height),
        ue = () => {
            le && ne && re && ("width" === ae ? o(36, re = Math.round(ne / h)) : "height" === ae ? o(35, ne = Math.round(re * h)) : ("width" === se ? o(36, re = Math.round(ne / h)) : "height" === se && o(35, ne = Math.round(re * h)), he()))
        },
        he = e => {
            let t = z(ne),
                i = z(re),
                n = t,
                r = i,
                a = n && r,
                s = e || h;
            if (!n && !r) return;
            n && !r ? r = Math.round(n / s) : r && !n && (n = Math.round(r * s)), s = e || a ? O(n, r) : h;
            let l = be(n, r);
            ke(H, l) || (l = Qe(H, s)), ke(l, V) || (l = Je(V, s)), o(35, ne = null != t ? Math.round(l.width) : void 0), o(36, re = null != i ? Math.round(l.height) : void 0)
        },
        pe = () => {
            he();
            const {
                width: e,
                height: t
            } = p || {};
            e === ne && t === re || (ne || re ? (ne && re && gn(J, m = ne / re, m), gn(Q, p = be(ne, re), p)) : (gn(J, m = g.width / g.height, m), gn(J, m = void 0, m), gn(Q, p = void 0, p)), ee.write())
        },
        me = Q.subscribe((e => {
            if (!e) return o(35, ne = void 0), void o(36, re = void 0);
            o(35, ne = e.width), o(36, re = e.height), he()
        })),
        ge = J.subscribe((e => {
            (ne || re) && e && (ne && re && O(ne, re) !== e ? (o(36, re = ne / e), he(e)) : he())
        })),
        fe = e => w(e[0]) ? (e[1] = e[1].map(fe), e) : Zt(e) ? [e, "" + e] : e,
        $e = e => {
            if (w(e[0])) return e[1] = e[1].map($e), e;
            let [t, o] = e;
            if (Zt(t) && Zt(o)) {
                const [e, i] = [t, o];
                o = `${e} × ${i}`, t = [e, i]
            }
            return [t, o]
        },
        xe = Dr();
    cn(e, xe, (e => o(40, f = e)));
    const ve = Dr();
    cn(e, ve, (e => o(41, $ = e)));
    const we = Dr();
    cn(e, we, (e => o(42, y = e)));
    const Se = Dr();
    cn(e, Se, (e => o(43, x = e)));
    const Ce = Dr();
    cn(e, Ce, (e => o(44, b = e)));
    const Me = Dr();
    cn(e, Me, (e => o(45, v = e)));
    const Te = Or([Q, ve], (([e, t], o) => {
        if (!t) return o(-1);
        const i = t.findIndex((([t]) => {
            if (!t && !e) return !0;
            if (!t) return !1;
            const [o, i] = t;
            return e.width === o && e.height === i
        }));
        o(i < 0 ? 0 : i)
    }));
    cn(e, Te, (e => o(47, S = e)));
    const Re = Or([Q, Se], (([e, t], o) => {
        if (!t) return o(-1);
        const i = t.findIndex((([t]) => !t && !e || !!t && e.width === t));
        o(i < 0 ? 0 : i)
    }));
    cn(e, Re, (e => o(49, C = e)));
    const Pe = Or([Q, Me], (([e, t], o) => {
        if (!t) return o(-1);
        const i = t.findIndex((([t]) => !t && !e || !!t && e.height === t));
        o(i < 0 ? 0 : i)
    }));
    cn(e, Pe, (e => o(51, k = e)));
    let Ae = void 0,
        Ie = void 0;
    let Ee = {};
    const Le = rs(A ? 20 : 0);
    return cn(e, Le, (e => o(61, E = e))), qn((() => {
        me(), ge()
    })), e.$$set = e => {
        "isActive" in e && F(o(0, B = e.isActive)), "stores" in e && o(27, D = e.stores), "locale" in e && o(1, W = e.locale), "resizeMinSize" in e && o(28, V = e.resizeMinSize), "resizeMaxSize" in e && o(29, H = e.resizeMaxSize), "resizeSizePresetOptions" in e && o(30, N = e.resizeSizePresetOptions), "resizeWidthPresetOptions" in e && o(31, U = e.resizeWidthPresetOptions), "resizeHeightPresetOptions" in e && o(32, j = e.resizeHeightPresetOptions), "resizeWillRenderFooter" in e && o(33, X = e.resizeWillRenderFooter)
    }, e.$$.update = () => {
        var t, g, T;
        1073741824 & e.$$.dirty[0] | 512 & e.$$.dirty[1] && N && (gn(xe, f = N.map($e), f), gn(ve, $ = Pc(f), $)), 512 & e.$$.dirty[1] && o(53, a = !!f), 66560 & e.$$.dirty[1] && o(46, i = S > -1 && $[S][1]), 2049 & e.$$.dirty[1] && U && (gn(we, y = U.map(fe), y), gn(Se, x = Pc(y), x)), 4196352 & e.$$.dirty[1] && o(54, s = !a && y), 266240 & e.$$.dirty[1] && o(48, n = C > -1 && x[C][1]), 8194 & e.$$.dirty[1] && j && (gn(Ce, b = j.map(fe), b), gn(Me, v = Pc(b), v)), 4202496 & e.$$.dirty[1] && o(55, l = !a && b), 1064960 & e.$$.dirty[1] && o(50, r = k > -1 && v[k][1]), 29360128 & e.$$.dirty[1] && o(56, c = !a && !s && !l), 805306370 & e.$$.dirty[0] | 268413948 & e.$$.dirty[1] && o(3, d = Ee && X([a && ["Dropdown", "size-presets", {
            label: i,
            options: f,
            onchange: e => {
                return (t = e.value) && !Ae && (Ae = {
                    ...M
                }, Ie = m), t ? (gn(J, m = O(t[0], t[1]), m), gn(Q, p = ye(t), p)) : (gn(Z, M = Ae, M), gn(J, m = Ie, m), gn(Q, p = void 0, p), Ae = void 0, Ie = void 0), void ee.write();
                var t
            },
            selectedIndex: S
        }], s && ["Dropdown", "width-presets", {
            label: n,
            options: y,
            onchange: e => {
                o(35, ne = e.value), pe()
            },
            selectedIndex: C
        }], s && l && ["span", "times", {
            class: "PinturaResizeLabel",
            innerHTML: "&times;"
        }], l && ["Dropdown", "height-presets", {
            label: r,
            options: b,
            onchange: e => {
                o(36, re = e.value), pe()
            },
            selectedIndex: k
        }], c && [h$, "width-input", {
            id: "width-" + oe,
            title: W.resizeTitleInputWidth,
            label: W.resizeLabelInputWidth,
            placeholder: (t = z(re), g = h, T = M, Math.round(null != t ? t * g : T.width)),
            value: ne,
            state: ce(z(ne), "width", ae, V, H),
            onchange: e => {
                o(35, ne = e), ue()
            }
        }], c && [f$, "aspect-ratio-lock", {
            id: "aspect-ratio-lock-" + oe,
            title: W.resizeTitleButtonMaintainAspectRatio,
            icon: w(W.resizeIconButtonMaintainAspectRatio) ? W.resizeIconButtonMaintainAspectRatio : W.resizeIconButtonMaintainAspectRatio(le, R),
            locked: le,
            onchange: e => {
                o(34, le = e), ue()
            }
        }], c && [h$, "height-input", {
            id: "height-" + oe,
            title: W.resizeTitleInputHeight,
            label: W.resizeLabelInputHeight,
            placeholder: de(z(ne), h, M),
            value: re,
            state: ce(z(re), "height", ae, V, H),
            onchange: e => {
                o(36, re = e), ue()
            }
        }]].filter(Boolean), {
            ...P
        }, (() => o(38, Ee = {}))).filter(Boolean)), 8 & e.$$.dirty[1] && Y.set(le ? 1 : 0), 64 & e.$$.dirty[1] && ae && (se = ae), 805306368 & e.$$.dirty[1] && A && Le.set(I ? 0 : 20), 1073741824 & e.$$.dirty[1] && o(4, u = E ? `transform: translateY(${E}px)` : void 0)
    }, [B, W, ie, d, u, Y, G, q, Z, K, J, Q, te, e => {
        const t = e.target.id;
        /width/.test(t) ? o(37, ae = "width") : /height/.test(t) ? o(37, ae = "height") : /aspectRatio/i.test(t) ? o(37, ae = "lock") : o(37, ae = void 0)
    }, e => {
        ie.contains(e.relatedTarget) || pe(), o(37, ae = void 0)
    }, pe, xe, ve, we, Se, Ce, Me, Te, Re, Pe, Le, "resize", D, V, H, N, U, j, X, le, ne, re, ae, Ee, h, f, $, y, x, b, v, i, S, n, C, r, k, M, a, s, l, c, R, P, A, I, E, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            ie = e, o(2, ie)
        }))
    }, function (t) {
        Qn(e, t)
    }]
}
var v$ = {
    util: ["resize", class extends Fr {
        constructor(e) {
            super(), Lr(this, e, b$, x$, an, {
                name: 26,
                isActive: 0,
                stores: 27,
                locale: 1,
                resizeMinSize: 28,
                resizeMaxSize: 29,
                resizeSizePresetOptions: 30,
                resizeWidthPresetOptions: 31,
                resizeHeightPresetOptions: 32,
                resizeWillRenderFooter: 33
            }, [-1, -1, -1])
        }
        get name() {
            return this.$$.ctx[26]
        }
        get isActive() {
            return this.$$.ctx[0]
        }
        set isActive(e) {
            this.$set({
                isActive: e
            }), dr()
        }
        get stores() {
            return this.$$.ctx[27]
        }
        set stores(e) {
            this.$set({
                stores: e
            }), dr()
        }
        get locale() {
            return this.$$.ctx[1]
        }
        set locale(e) {
            this.$set({
                locale: e
            }), dr()
        }
        get resizeMinSize() {
            return this.$$.ctx[28]
        }
        set resizeMinSize(e) {
            this.$set({
                resizeMinSize: e
            }), dr()
        }
        get resizeMaxSize() {
            return this.$$.ctx[29]
        }
        set resizeMaxSize(e) {
            this.$set({
                resizeMaxSize: e
            }), dr()
        }
        get resizeSizePresetOptions() {
            return this.$$.ctx[30]
        }
        set resizeSizePresetOptions(e) {
            this.$set({
                resizeSizePresetOptions: e
            }), dr()
        }
        get resizeWidthPresetOptions() {
            return this.$$.ctx[31]
        }
        set resizeWidthPresetOptions(e) {
            this.$set({
                resizeWidthPresetOptions: e
            }), dr()
        }
        get resizeHeightPresetOptions() {
            return this.$$.ctx[32]
        }
        set resizeHeightPresetOptions(e) {
            this.$set({
                resizeHeightPresetOptions: e
            }), dr()
        }
        get resizeWillRenderFooter() {
            return this.$$.ctx[33]
        }
        set resizeWillRenderFooter(e) {
            this.$set({
                resizeWillRenderFooter: e
            }), dr()
        }
    }]
};

function w$(e) {
    let t, o;
    return t = new Xf({
        props: {
            stores: e[3],
            locale: e[4],
            isActive: e[0],
            isActiveFraction: e[1],
            isVisible: e[2],
            mapScreenPointToImagePoint: e[7],
            mapImagePointToScreenPoint: e[8],
            utilKey: "redact",
            imageRotation: e[9],
            imageFlipX: e[5],
            imageFlipY: e[6],
            shapes: e[10],
            tools: ["rect"],
            toolShapes: {
                rectangle: [{
                    x: 0,
                    y: 0,
                    width: 0,
                    height: 0
                }]
            },
            toolActive: "rectangle",
            parentRect: e[12],
            enablePresetDropImage: !1,
            enablePresetSelectImage: !1,
            hooks: {
                willRenderShapeControls: e[21]
            }
        }
    }), t.$on("measure", e[22]), {
        c() {
            Pr(t.$$.fragment)
        },
        m(e, i) {
            Ar(t, e, i), o = !0
        },
        p(e, [o]) {
            const i = {};
            8 & o && (i.stores = e[3]), 16 & o && (i.locale = e[4]), 1 & o && (i.isActive = e[0]), 2 & o && (i.isActiveFraction = e[1]), 4 & o && (i.isVisible = e[2]), 128 & o && (i.mapScreenPointToImagePoint = e[7]), 256 & o && (i.mapImagePointToScreenPoint = e[8]), 512 & o && (i.imageRotation = e[9]), 32 & o && (i.imageFlipX = e[5]), 64 & o && (i.imageFlipY = e[6]), t.$set(i)
        },
        i(e) {
            o || (yr(t.$$.fragment, e), o = !0)
        },
        o(e) {
            xr(t.$$.fragment, e), o = !1
        },
        d(e) {
            Ir(t, e)
        }
    }
}

function S$(e, t, o) {
    let i, n, r, a, s, l, c, d;
    let {
        isActive: u
    } = t, {
        isActiveFraction: h
    } = t, {
        isVisible: p
    } = t, {
        stores: m
    } = t, {
        locale: g = {}
    } = t;
    const {
        imageRedaction: f,
        rootRect: $,
        imageSize: y,
        imageTransforms: x,
        imageRotation: b,
        imageFlipX: v,
        imageFlipY: w
    } = m;
    cn(e, $, (e => o(18, r = e))), cn(e, y, (e => o(19, a = e))), cn(e, x, (e => o(20, s = e))), cn(e, b, (e => o(9, d = e))), cn(e, v, (e => o(5, l = e))), cn(e, w, (e => o(6, c = e)));
    return e.$$set = e => {
        "isActive" in e && o(0, u = e.isActive), "isActiveFraction" in e && o(1, h = e.isActiveFraction), "isVisible" in e && o(2, p = e.isVisible), "stores" in e && o(3, m = e.stores), "locale" in e && o(4, g = e.locale)
    }, e.$$.update = () => {
        1835104 & e.$$.dirty && o(7, i = e => Gf(e, r, a, s.origin, s.translation, s.rotation.z, s.scale, l, c)), 1835104 & e.$$.dirty && o(8, n = e => Yf(e, r, a, s.origin, s.translation, s.rotation.z, s.scale, l, c))
    }, [u, h, p, m, g, l, c, i, n, d, f, $, y, x, b, v, w, "redact", r, a, s, e => {
        const t = Wu(e[0]);
        return Xu("to-front", t), e
    }, function (t) {
        Qn(e, t)
    }]
}
var C$ = {
    util: ["redact", class extends Fr {
        constructor(e) {
            super(), Lr(this, e, S$, w$, an, {
                name: 17,
                isActive: 0,
                isActiveFraction: 1,
                isVisible: 2,
                stores: 3,
                locale: 4
            })
        }
        get name() {
            return this.$$.ctx[17]
        }
        get isActive() {
            return this.$$.ctx[0]
        }
        set isActive(e) {
            this.$set({
                isActive: e
            }), dr()
        }
        get isActiveFraction() {
            return this.$$.ctx[1]
        }
        set isActiveFraction(e) {
            this.$set({
                isActiveFraction: e
            }), dr()
        }
        get isVisible() {
            return this.$$.ctx[2]
        }
        set isVisible(e) {
            this.$set({
                isVisible: e
            }), dr()
        }
        get stores() {
            return this.$$.ctx[3]
        }
        set stores(e) {
            this.$set({
                stores: e
            }), dr()
        }
        get locale() {
            return this.$$.ctx[4]
        }
        set locale(e) {
            this.$set({
                locale: e
            }), dr()
        }
    }]
};
const k$ = '<g fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width=".125em"><path d="M18 6L6 18M6 6l12 12"></path></path></g>',
    M$ = '<path fill="none" d="M9 15 L12 9 L15 15 M10 13.5 h3" stroke="currentColor" stroke-width=".125em"/>';
var T$ = {
    labelReset: "Reset",
    labelDefault: "Default",
    labelAuto: "Auto",
    labelNone: "None",
    labelEdit: "Edit",
    labelClose: "Close",
    labelSupportError: e => e.join(", ") + " not supported on this browser",
    labelColor: "Color",
    labelWidth: "Width",
    labelSize: "Size",
    labelOffset: "Offset",
    labelAmount: "Amount",
    labelInset: "Inset",
    labelRadius: "Radius",
    labelSizeExtraSmall: "Extra small",
    labelSizeSmall: "Small",
    labelSizeMediumSmall: "Medium small",
    labelSizeMedium: "Medium",
    labelSizeMediumLarge: "Medium large",
    labelSizeLarge: "Large",
    labelSizeExtraLarge: "Extra large",
    labelButtonRevert: "Revert",
    labelButtonCancel: "Cancel",
    labelButtonUndo: "Undo",
    labelButtonRedo: "Redo",
    labelButtonExport: "Done",
    iconSupportError: '<g fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><g><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></g>',
    iconButtonClose: k$,
    iconButtonRevert: '<g fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width=".125em"><path d="M7.388 18.538a8 8 0 10-2.992-9.03"/><path fill="currentColor" d="M2.794 11.696L2.37 6.714l5.088 3.18z"/><path d="M12 8v4M12 12l4 2"/></g>',
    iconButtonUndo: '<g fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width=".125em"><path d="M10 8h4c2.485 0 5 2 5 5s-2.515 5-5 5h-4"/><path fill="currentColor" d="M5 8l4-3v6z"/></g>',
    iconButtonRedo: '<g fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width=".125em"><path d="M14 8h-4c-2.485 0-5 2-5 5s2.515 5 5 5h4"/><path fill="currentColor" d="M19 8l-4-3v6z"/></g>',
    iconButtonExport: '<polyline points="20 6 9 17 4 12" fill="none" stroke="currentColor" stroke-width=".125em"></polyline>',
    statusLabelButtonClose: "Close",
    statusIconButtonClose: k$,
    statusLabelLoadImage: e => e && e.task ? e.error ? "IMAGE_TOO_SMALL" === e.error.code ? "Minimum image size is {minWidth} × {minHeight}" : "Error loading image" : "blob-to-bitmap" === e.task ? "Creating preview…" : "Loading image…" : "Waiting for image",
    statusLabelProcessImage: e => {
        if (e && e.task) return "store" === e.task ? e.error ? "Error uploading image" : "Uploading image…" : e.error ? "Error processing image" : "Processing image…"
    }
};
const R$ = {
    shapeLabelButtonSelectSticker: "Select image",
    shapeIconButtonSelectSticker: '<g fill="none" stroke="currentColor" stroke-width="0.0625em"><path d="M8 21 L15 11 L19 15"/><path d="M15 2 v5 h5"/><path d="M8 2 h8 l4 4 v12 q0 4 -4 4 h-8 q-4 0 -4 -4 v-12 q0 -4 4 -4z"/></g><circle fill="currentColor" cx="10" cy="8" r="1.5"/>',
    shapeIconButtonFlipHorizontal: '<g stroke="currentColor" stroke-width=".125em"><path fill="none" d="M6 6.5h5v11H6z"/><path fill="currentColor" d="M15 6.5h3v11h-3z"/><path d="M11 4v16" fill="currentColor"/></g>',
    shapeIconButtonFlipVertical: '<g stroke="currentColor" stroke-width=".125em"><rect x="7" y="8" width="11" height="5" fill="none"/><rect x="7" y="17" width="11" height="2" fill="currentColor"/><line x1="5" y1="13" x2="20" y2="13"/></g>',
    shapeIconButtonRemove: '<g fill="none" fill-rule="evenodd"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M7.5 7h9z"/><path d="M7.916 9h8.168a1 1 0 01.99 1.14l-.972 6.862a2 2 0 01-1.473 1.653c-.877.23-1.753.345-2.629.345-.876 0-1.752-.115-2.628-.345a2 2 0 01-1.473-1.653l-.973-6.862A1 1 0 017.916 9z" fill="currentColor"/><rect fill="currentColor" x="10" y="5" width="4" height="3" rx="1"/></g>',
    shapeIconButtonDuplicate: '<g fill="none" fill-rule="evenodd"><path d="M15 13.994V16a2 2 0 01-2 2H8a2 2 0 01-2-2v-5a2 2 0 012-2h2.142" stroke="currentColor" stroke-width=".125em"/><path d="M15 9V8a1 1 0 00-2 0v1h-1a1 1 0 000 2h1v1a1 1 0 002 0v-1h1a1 1 0 000-2h-1zm-4-4h6a2 2 0 012 2v6a2 2 0 01-2 2h-6a2 2 0 01-2-2V7a2 2 0 012-2z" fill="currentColor"/></g>',
    shapeIconButtonMoveToFront: '<g fill="none" fill-rule="evenodd"><rect fill="currentColor" x="11" y="13" width="8" height="2" rx="1"/><rect fill="currentColor" x="9" y="17" width="10" height="2" rx="1"/><path d="M11.364 8H10a5 5 0 000 10M12 6.5L14.5 8 12 9.5z" stroke="currentColor" stroke-width=".125em" stroke-linecap="round"/></g>',
    shapeIconButtonTextLayoutAutoWidth: "" + M$,
    shapeIconButtonTextLayoutAutoHeight: '<g fill="currentColor"><circle cx="4" cy="12" r="1.5"/><circle cx="20" cy="12" r="1.5"/></g>' + M$,
    shapeIconButtonTextLayoutFixedSize: '<g fill="currentColor"><circle cx="5" cy="6" r="1.5"/><circle cx="19" cy="6" r="1.5"/><circle cx="19" cy="19" r="1.5"/><circle cx="5" cy="19" r="1.5"/></g>' + M$,
    shapeTitleButtonTextLayoutAutoWidth: "Auto width",
    shapeTitleButtonTextLayoutAutoHeight: "Auto height",
    shapeTitleButtonTextLayoutFixedSize: "Fixed size",
    shapeTitleButtonFlipHorizontal: "Flip Horizontal",
    shapeTitleButtonFlipVertical: "Flip Vertical",
    shapeTitleButtonRemove: "Remove",
    shapeTitleButtonDuplicate: "Duplicate",
    shapeTitleButtonMoveToFront: "Move to front",
    shapeLabelInputText: "Edit text",
    shapeIconInputCancel: '<g fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width=".125em"><path d="M18 6L6 18M6 6l12 12"/></g>',
    shapeIconInputConfirm: '<g fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width=".125em"><polyline points="20 6 9 17 4 12"/></g>',
    shapeLabelInputCancel: "Cancel",
    shapeLabelInputConfirm: "Confirm",
    shapeLabelStrokeNone: "No outline",
    shapeLabelFontStyleNormal: "Normal",
    shapeLabelFontStyleBold: "Bold",
    shapeLabelFontStyleItalic: "Italic",
    shapeLabelFontStyleItalicBold: "Bold Italic",
    shapeTitleBackgroundColor: "Fill color",
    shapeTitleFontFamily: "Font",
    shapeTitleFontSize: "Font size",
    shapeTitleFontStyle: "Font style",
    shapeTitleLineHeight: "Line height",
    shapeTitleLineStart: "Start",
    shapeTitleLineEnd: "End",
    shapeTitleStrokeWidth: "Line width",
    shapeTitleStrokeColor: "Line color",
    shapeTitleLineDecorationBar: "Bar",
    shapeTitleLineDecorationCircle: "Circle",
    shapeTitleLineDecorationSquare: "Square",
    shapeTitleLineDecorationArrow: "Arrow",
    shapeTitleLineDecorationCircleSolid: "Circle solid",
    shapeTitleLineDecorationSquareSolid: "Square solid",
    shapeTitleLineDecorationArrowSolid: "Arrow solid",
    shapeIconLineDecorationBar: '<g stroke="currentColor" stroke-linecap="round" stroke-width=".125em"><path d="M5,12 H16"/><path d="M16,8 V16"/></g>',
    shapeIconLineDecorationCircle: '<g stroke="currentColor" stroke-linecap="round"><path stroke-width=".125em" d="M5,12 H12"/><circle fill="none" stroke-width=".125em" cx="16" cy="12" r="4"/></g>',
    shapeIconLineDecorationSquare: '<g stroke="currentColor" stroke-linecap="round"><path stroke-width=".125em" d="M5,12 H12"/><rect fill="none" stroke-width=".125em" x="12" y="8" width="8" height="8"/></g>',
    shapeIconLineDecorationArrow: '<g stroke="currentColor" stroke-linecap="round" stroke-width=".125em"><path d="M5,12 H16 M13,7 l6,5 l-6,5" fill="none"/></g>',
    shapeIconLineDecorationCircleSolid: '<g stroke="currentColor" stroke-linecap="round"><path stroke-width=".125em" d="M5,12 H12"/><circle fill="currentColor" cx="16" cy="12" r="4"/></g>',
    shapeIconLineDecorationSquareSolid: '<g stroke="currentColor" stroke-linecap="round"><path stroke-width=".125em" d="M5,12 H12"/><rect fill="currentColor" x="12" y="8" width="8" height="8"/></g>',
    shapeIconLineDecorationArrowSolid: '<g stroke="currentColor" stroke-linecap="round" stroke-width=".125em"><path d="M5,12 H16"/><path d="M13,7 l6,5 l-6,5z" fill="currentColor"/></g>',
    shapeTitleColorTransparent: "Transparent",
    shapeTitleColorWhite: "White",
    shapeTitleColorSilver: "Silver",
    shapeTitleColorGray: "Gray",
    shapeTitleColorBlack: "Black",
    shapeTitleColorNavy: "Navy",
    shapeTitleColorBlue: "Blue",
    shapeTitleColorAqua: "Aqua",
    shapeTitleColorTeal: "Teal",
    shapeTitleColorOlive: "Olive",
    shapeTitleColorGreen: "Green",
    shapeTitleColorYellow: "Yellow",
    shapeTitleColorOrange: "Orange",
    shapeTitleColorRed: "Red",
    shapeTitleColorMaroon: "Maroon",
    shapeTitleColorFuchsia: "Fuchsia",
    shapeTitleColorPurple: "Purple",
    shapeTitleTextColor: "Font color",
    shapeTitleTextAlign: "Text align",
    shapeTitleTextAlignLeft: "Left align text",
    shapeTitleTextAlignCenter: "Center align text",
    shapeTitleTextAlignRight: "Right align text",
    shapeIconTextAlignLeft: '<g stroke-width=".125em" stroke="currentColor"><line x1="5" y1="8" x2="15" y2="8"/><line x1="5" y1="12" x2="19" y2="12"/><line x1="5" y1="16" x2="14" y2="16"/></g>',
    shapeIconTextAlignCenter: '<g stroke-width=".125em" stroke="currentColor"><line x1="7" y1="8" x2="17" y2="8"/><line x1="5" y1="12" x2="19" y2="12"/><line x1="8" y1="16" x2="16" y2="16"/></g>',
    shapeIconTextAlignRight: '<g stroke-width=".125em" stroke="currentColor"><line x1="9" y1="8" x2="19" y2="8"/><line x1="5" y1="12" x2="19" y2="12"/><line x1="11" y1="16" x2="19" y2="16"/></g>',
    shapeLabelToolSharpie: "Sharpie",
    shapeLabelToolEraser: "Eraser",
    shapeLabelToolRectangle: "Rectangle",
    shapeLabelToolEllipse: "Ellipse",
    shapeLabelToolArrow: "Arrow",
    shapeLabelToolLine: "Line",
    shapeLabelToolText: "Text",
    shapeLabelToolPreset: "Stickers",
    shapeIconToolSharpie: '<g stroke-width=".125em" stroke="currentColor" fill="none"><path d="M2.025 5c5.616-2.732 8.833-3.857 9.65-3.374C12.903 2.351.518 12.666 2.026 14 3.534 15.334 16.536.566 17.73 2.566 18.924 4.566 3.98 17.187 4.831 18c.851.813 9.848-6 11.643-6 1.087 0-2.53 5.11-2.92 7-.086.41 3.323-1.498 4.773-1 .494.17.64 2.317 1.319 3 .439.443 1.332.776 2.679 1" stroke="currentColor" stroke-width=".125em" fill="none" fill-rule="evenodd" stroke-linejoin="round"/></g>',
    shapeIconToolEraser: '<g stroke-width=".125em" stroke="currentColor" stroke-linecap="round" fill="none"><g transform="translate(3, 15) rotate(-45)"><rect x="0" y="0" width="18" height="10" rx="3"/></g><line x1="11" y1="21" x2="18" y2="21"/><line x1="20" y1="21" x2="22" y2="21"/></g>',
    shapeIconToolRectangle: '<g stroke-width=".125em" stroke="currentColor" fill="none"><rect x="2" y="2" width="20" height="20" rx="3"/></g>',
    shapeIconToolEllipse: '<g stroke-width=".125em" stroke="currentColor" fill="none"><circle cx="12" cy="12" r="11"/></g>',
    shapeIconToolArrow: '<g stroke-width=".125em" stroke="currentColor" fill="none"><line x1="20" y1="3" x2="6" y2="21"/><path d="m10 5 L22 1 L21 13" fill="currentColor" stroke="none"/></g>',
    shapeIconToolLine: '<g stroke-width=".125em" stroke="currentColor" fill="none"><line x1="20" y1="3" x2="6" y2="21"/></g>',
    shapeIconToolText: '<g stroke="none" fill="currentColor" transform="translate(6,0)"><path d="M8.14 20.085c.459 0 .901-.034 1.329-.102a8.597 8.597 0 001.015-.21v1.984c-.281.135-.695.247-1.242.336a9.328 9.328 0 01-1.477.133c-3.312 0-4.968-1.745-4.968-5.235V6.804H.344v-1.25l2.453-1.078L3.89.819h1.5v3.97h4.97v2.015H5.39v10.078c0 1.031.245 1.823.735 2.375s1.161.828 2.015.828z"/>',
    shapeIconToolPreset: '<g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width=".125em"><path d="M12 22c2.773 0 1.189-5.177 3-7 1.796-1.808 7-.25 7-3 0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10z"></path><path d="M20 17c-3 3-5 5-8 5"></path></g>'
};
var P$ = {
        cropLabel: "Crop",
        cropIcon: '<g stroke-width=".125em" stroke="currentColor" fill="none"><path d="M23 17H9a2 2 0 0 1-2-2v-5m0-3V1 M1 7h14a2 2 0 0 1 2 2v7m0 4v3"/></g>',
        cropIconButtonRecenter: '<path stroke="currentColor" fill="none" stroke-width="2" stroke-linejoin="bevel" d="M1.5 7.5v-6h6M1.5 16.5v6h6M22.5 16.5v6h-6M22.5 7.5v-6h-6"/><circle cx="12" cy="12" r="3.5" fill="currentColor" stroke="none"/>',
        cropIconButtonRotateLeft: '<g stroke="none" fill="currentColor"><path fill="none" d="M-1-1h582v402H-1z"/><rect x="3" rx="1" height="12" width="12" y="9"/><path d="M15 5h-1a5 5 0 015 5 1 1 0 002 0 7 7 0 00-7-7h-1.374l.747-.747A1 1 0 0011.958.84L9.603 3.194a1 1 0 000 1.415l2.355 2.355a1 1 0 001.415-1.414l-.55-.55H15z"/></g>',
        cropIconButtonRotateRight: '<g stroke="none" fill="currentColor"><path fill="none" d="M-1-1h582v402H-1z"/><path d="M11.177 5H10a5 5 0 00-5 5 1 1 0 01-2 0 7 7 0 017-7h1.374l-.747-.747A1 1 0 0112.042.84l2.355 2.355a1 1 0 010 1.415l-2.355 2.354a1 1 0 01-1.415-1.414l.55-.55z"/><rect rx="1" height="12" width="12" y="9" x="9"/></g>',
        cropIconButtonFlipVertical: '<g stroke="none" fill="currentColor"><path d="M19.993 12.143H7a1 1 0 0 1-1-1V5.994a1 1 0 0 1 1.368-.93l12.993 5.15a1 1 0 0 1-.368 1.93z"/><path d="M19.993 14a1 1 0 0 1 .368 1.93L7.368 21.078A1 1 0 0 1 6 20.148V15a1 1 0 0 1 1-1h12.993z" opacity=".6"/></g>',
        cropIconButtonFlipHorizontal: '<g stroke="none" fill="currentColor"><path d="M11.93 7.007V20a1 1 0 0 1-1 1H5.78a1 1 0 0 1-.93-1.368l5.15-12.993a1 1 0 0 1 1.929.368z"/><path d="M14 7.007V20a1 1 0 0 0 1 1h5.149a1 1 0 0 0 .93-1.368l-5.15-12.993A1 1 0 0 0 14 7.007z" opacity=".6"/></g>',
        cropIconSelectPreset: (e, t) => {
            const [o, i, n] = t ? [t < 1 ? 1 : .3, 1 === t ? .85 : .5, t > 1 ? 1 : .3] : [.2, .3, .4];
            return `<g fill="currentColor">\n            <rect opacity="${o}" x="2" y="4" width="10" height="18" rx="1"/>\n            <rect opacity="${i}" x="4" y="8" width="14" height="14" rx="1"/>\n            <rect opacity="${n}" x="6" y="12" width="17" height="10" rx="1"/>\n        </g>`
        },
        cropIconCropBoundary: (e, t) => {
            const [o, i, n, r] = t ? [.3, 1, 0, 0] : [0, 0, .3, 1];
            return `<g fill="currentColor">\n            <rect opacity="${o}" x="2" y="3" width="20" height="20" rx="1"/>\n            <rect opacity="${i}" x="7" y="8" width="10" height="10" rx="1"/>\n            <rect opacity="${n}" x="4" y="8" width="14" height="14" rx="1"/>\n            <rect opacity="${r}" x="12" y="4" width="10" height="10" rx="1"/>\n        </g>`
        },
        cropLabelButtonRecenter: "Recenter",
        cropLabelButtonRotateLeft: "Rotate left",
        cropLabelButtonRotateRight: "Rotate right",
        cropLabelButtonFlipHorizontal: "Flip horizontal",
        cropLabelButtonFlipVertical: "Flip vertical",
        cropLabelSelectPreset: "Crop shape",
        cropLabelCropBoundary: "Crop boundary",
        cropLabelCropBoundaryEdge: "Edge of image",
        cropLabelCropBoundaryNone: "None",
        cropLabelTabRotation: "Rotation",
        cropLabelTabZoom: "Zoom"
    },
    A$ = {
        frameLabel: "Frame",
        frameIcon: '<g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width=".125em">\n            <rect x="2" y="2" width="20" height="20" rx="4"/>\n            <rect x="6" y="6" width="12" height="12" rx="1"/>\n        </g>',
        frameLabelMatSharp: "Mat",
        frameLabelMatRound: "Bevel",
        frameLabelLineSingle: "Line",
        frameLabelLineMultiple: "Zebra",
        frameLabelEdgeSeparate: "Inset",
        frameLabelEdgeOverlap: "Plus",
        frameLabelEdgeCross: "Lumber",
        frameLabelCornerHooks: "Hook",
        frameLabelPolaroid: "Polaroid"
    },
    I$ = {
        redactLabel: "Redact",
        redactIcon: '<g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width=".125em">\n        <path d="M 4 5 l 1 -1"/>\n        <path d="M 4 10 l 6 -6"/>\n        <path d="M 4 15 l 11 -11"/>\n        <path d="M 4 20 l 16 -16"/>\n        <path d="M 9 20 l 11 -11"/>\n        <path d="M 14 20 l 6 -6"/>\n        <path d="M 19 20 l 1 -1"/>\n    </g>'
    },
    E$ = (e, t) => {
        const o = Object.getOwnPropertyDescriptors(e);
        Object.keys(o).forEach((i => {
            o[i].get ? Object.defineProperty(t, i, {
                get: () => e[i],
                set: t => e[i] = t
            }) : t[i] = e[i]
        }))
    },
    L$ = e => {
        const t = {},
            {
                sub: o,
                pub: i
            } = po();
        c() && null !== document.doctype || console.warn("Browser is in quirks mode, add <!DOCTYPE html> to page to fix render issues");
        const r = ba();
        E$(r, t);
        const a = ((e, t) => {
            const o = {},
                i = new Tu({
                    target: e,
                    props: {
                        stores: t,
                        pluginComponents: Array.from(Lu)
                    }
                });
            let n = !1;
            const r = () => {
                n || (c() && window.removeEventListener("pagehide", r), i && (n = !0, i.$destroy()))
            };
            Au || (Au = new Set(Tl(Tu).filter((e => !Pu.includes(e))))), Au.forEach((e => {
                Object.defineProperty(o, e, {
                    get: () => i[e],
                    set: t => i[e] = t
                })
            })), Object.defineProperty(o, "previewImageData", {
                get: () => i.imagePreviewCurrent
            }), Iu.forEach((e => {
                const t = Eu[e],
                    n = t[0];
                Object.defineProperty(o, e, {
                    get: () => i.pluginInterface[n][e],
                    set: o => {
                        const n = t.reduce(((t, n) => (t[n] = {
                            ...i.pluginOptions[n],
                            [e]: o
                        }, t)), {});
                        i.pluginOptions = {
                            ...i.pluginOptions,
                            ...n
                        }
                    }
                })
            })), Object.defineProperty(o, "element", {
                get: () => i.root,
                set: () => {}
            });
            const a = i.history;
            return Gr(o, {
                on: (e, t) => {
                    if (n) return () => {};
                    if (/undo|redo|revert/.test(e)) return a.on(e, t);
                    const o = [i.sub(e, t), i.$on(e, (e => t(e instanceof CustomEvent && !e.detail ? void 0 : e)))].filter(Boolean);
                    return () => o.forEach((e => e()))
                },
                updateImagePreview: e => {
                    i.imagePreviewSrc = e
                },
                close: () => !n && i.pub("close"),
                destroy: r
            }), Object.defineProperty(o, "history", {
                get: () => ({
                    undo: () => a.undo(),
                    redo: () => a.redo(),
                    revert: () => a.revert(),
                    get: () => a.get(),
                    getCollapsed: () => a.get().splice(0, a.index + 1),
                    set: e => a.set(e),
                    write: e => a.write(e),
                    get length() {
                        return a.length()
                    },
                    get index() {
                        return a.index
                    }
                })
            }), c() && window.addEventListener("pagehide", r), o
        })(e, r.stores);
        E$(a, t);
        const s = ["loadImage", "processImage", "abortProcessImage", "abortLoadImage"].map((e => a.on(e, (t => {
                const o = r[e](t && t.detail);
                o instanceof Promise && o.catch((() => {}))
            })))),
            l = (e, t) => {
                const i = o(e, t),
                    n = r.on(e, t),
                    s = a.on(e, t);
                return () => {
                    i(), n(), s()
                }
            };
        t.handleEvent = n;
        const d = zu.map((e => l(e, (o => t.handleEvent(e, o)))));
        return Gr(t, {
            on: l,
            updateImage: e => new Promise(((o, i) => {
                const n = t.history.get(),
                    a = t.imageState;
                r.loadImage(e).then((e => {
                    t.history.set(n), t.imageState = a, o(e)
                })).catch(i)
            })),
            close: () => {
                i("close")
            },
            destroy: () => {
                [...s, ...d].forEach((e => e())), a.destroy(), r.destroy(), i("destroy")
            }
        }), t
    };
var F$ = (e, t = {}) => {
    const o = w(e) ? document.querySelector(e) : e;
    if (!ut(o)) return;
    t.class = t.class ? "pintura-editor " + t.class : "pintura-editor";
    const i = L$(o);
    return Object.assign(i, t)
};
const {
    document: z$,
    window: B$
} = wr;

function D$(e) {
    let t, o, i, n;
    return ar(e[27]), {
        c() {
            t = Pn(), o = Mn("div"), Fn(o, "class", e[5]), Fn(o, "style", e[4])
        },
        m(r, a) {
            Cn(r, t, a), Cn(r, o, a), e[28](o), i || (n = [In(B$, "keydown", e[10]), In(B$, "orientationchange", e[11]), In(B$, "resize", e[27]), In(z$.body, "focusin", (function () {
                rn(!e[1] && e[7]) && (!e[1] && e[7]).apply(this, arguments)
            })), In(z$.body, "focusout", (function () {
                rn(e[2] && e[8]) && (e[2] && e[8]).apply(this, arguments)
            })), In(o, "wheel", e[9], {
                passive: !1
            })], i = !0)
        },
        p(t, i) {
            e = t, 32 & i[0] && Fn(o, "class", e[5]), 16 & i[0] && Fn(o, "style", e[4])
        },
        i: Ji,
        o: Ji,
        d(r) {
            r && kn(t), r && kn(o), e[28](null), i = !1, nn(n)
        }
    }
}

function O$(e, t, o) {
    let i, n, r, a, s, l, d, u;
    const h = Zn();
    let {
        root: m
    } = t, {
        preventZoomViewport: g = !0
    } = t, {
        preventScrollBodyIfNeeded: f = !0
    } = t, {
        preventFooterOverlapIfNeeded: $ = !0
    } = t, {
        class: y
    } = t, x = !0, b = !1, v = !1, w = c() && document.documentElement, S = c() && document.body, C = c() && document.head;
    const k = rs(0, {
        precision: .001,
        damping: .5
    });
    cn(e, k, (e => o(23, u = e)));
    const M = k.subscribe((e => {
        v && e >= 1 ? (o(19, v = !1), o(1, x = !1), h("show")) : b && e <= 0 && (o(18, b = !1), o(1, x = !0), h("hide"))
    }));
    let T = !1,
        R = void 0,
        P = void 0,
        A = void 0;
    const I = () => document.querySelector("meta[name=viewport]"),
        E = () => Array.from(document.querySelectorAll("meta[name=theme-color]"));
    let L;
    const F = (e, t) => {
        const o = () => {
            e() ? t() : requestAnimationFrame(o)
        };
        requestAnimationFrame(o)
    };
    let z, B, D = 0,
        O = void 0;
    const _ = () => {
        B || (B = p("div", {
            style: "position:fixed;height:100vh;top:0"
        }), S.append(B))
    };
    Yn((() => {
        $ && zt() && _()
    })), Gn((() => {
        B && (o(21, O = B.offsetHeight), B.remove(), B = void 0)
    }));
    let W = void 0;
    const V = () => w.style.setProperty("--pintura-document-height", window.innerHeight + "px");
    return qn((() => {
        w.classList.remove("PinturaModalBodyLock"), M()
    })), e.$$set = e => {
        "root" in e && o(0, m = e.root), "preventZoomViewport" in e && o(12, g = e.preventZoomViewport), "preventScrollBodyIfNeeded" in e && o(13, f = e.preventScrollBodyIfNeeded), "preventFooterOverlapIfNeeded" in e && o(14, $ = e.preventFooterOverlapIfNeeded), "class" in e && o(15, y = e.class)
    }, e.$$.update = () => {
        9175042 & e.$$.dirty[0] && o(22, i = v || b ? u : x ? 0 : 1), 4096 & e.$$.dirty[0] && (n = "width=device-width,height=device-height,initial-scale=1" + (g ? ",maximum-scale=1,user-scalable=0" : "")), 786434 & e.$$.dirty[0] && o(24, r = !v && !x && !b), 12 & e.$$.dirty[0] && (T || o(20, z = D)), 2097160 & e.$$.dirty[0] && o(25, a = Zt(O) ? "--viewport-pad-footer:" + (O > D ? 0 : 1) : ""), 38797312 & e.$$.dirty[0] && o(4, s = `opacity:${i};height:${z}px;--editor-modal:1;${a}`), 32768 & e.$$.dirty[0] && o(5, l = al(["pintura-editor", "PinturaModal", y])), 8192 & e.$$.dirty[0] && o(26, d = f && zt() && /15_/.test(navigator.userAgent)), 83886080 & e.$$.dirty[0] && d && (e => {
            e ? (W = window.scrollY, w.classList.add("PinturaDocumentLock"), V(), window.addEventListener("resize", V)) : (window.removeEventListener("resize", V), w.classList.remove("PinturaDocumentLock"), Zt(W) && window.scrollTo(0, W), W = void 0)
        })(r)
    }, [m, x, T, D, s, l, k, e => {
        /textarea/i.test(e.target) && (o(2, T = !0), L = D)
    }, e => {
        if (/textarea/i.test(e.target))
            if (clearTimeout(undefined), L === D) o(2, T = !1);
            else {
                const e = D;
                F((() => D !== e), (() => o(2, T = !1)))
            }
    }, e => {
        e.target && /PinturaStage/.test(e.target.className) && e.preventDefault()
    }, e => {
        const {
            key: t
        } = e;
        if (!/escape/i.test(t)) return;
        const o = e.target;
        if (o && /input|textarea/i.test(o.nodeName)) return;
        const i = document.querySelectorAll(".PinturaModal");
        i[i.length - 1] === m && h("close")
    }, _, g, f, $, y, () => {
        if (v || !x) return;
        o(19, v = !0);
        const e = I() || p("meta", {
            name: "viewport"
        });
        R = !R && e.getAttribute("content"), e.setAttribute("content", n + (/cover/.test(R) ? ",viewport-fit=cover" : "")), e.parentNode || C.append(e);
        const t = getComputedStyle(m).getPropertyValue("--color-background"),
            i = E();
        if (i.length) P = i.map((e => e.getAttribute("content")));
        else {
            const e = p("meta", {
                name: "theme-color"
            });
            C.append(e), i.push(e)
        }
        i.forEach((e => e.setAttribute("content", `rgb(${t})`))), clearTimeout(A), A = setTimeout((() => k.set(1)), 250)
    }, () => {
        if (b || x) return;
        clearTimeout(A), o(18, b = !0);
        const e = I();
        R ? e.setAttribute("content", R) : e.remove();
        const t = E();
        P ? t.forEach(((e, t) => {
            e.setAttribute("content", P[t])
        })) : t.forEach((e => e.remove())), k.set(0)
    }, b, v, z, O, i, u, r, a, d, function () {
        o(3, D = B$.innerHeight)
    }, function (e) {
        tr[e ? "unshift" : "push"]((() => {
            m = e, o(0, m)
        }))
    }]
}
class _$ extends Fr {
    constructor(e) {
        super(), Lr(this, e, O$, D$, an, {
            root: 0,
            preventZoomViewport: 12,
            preventScrollBodyIfNeeded: 13,
            preventFooterOverlapIfNeeded: 14,
            class: 15,
            show: 16,
            hide: 17
        }, [-1, -1])
    }
    get root() {
        return this.$$.ctx[0]
    }
    set root(e) {
        this.$set({
            root: e
        }), dr()
    }
    get preventZoomViewport() {
        return this.$$.ctx[12]
    }
    set preventZoomViewport(e) {
        this.$set({
            preventZoomViewport: e
        }), dr()
    }
    get preventScrollBodyIfNeeded() {
        return this.$$.ctx[13]
    }
    set preventScrollBodyIfNeeded(e) {
        this.$set({
            preventScrollBodyIfNeeded: e
        }), dr()
    }
    get preventFooterOverlapIfNeeded() {
        return this.$$.ctx[14]
    }
    set preventFooterOverlapIfNeeded(e) {
        this.$set({
            preventFooterOverlapIfNeeded: e
        }), dr()
    }
    get class() {
        return this.$$.ctx[15]
    }
    set class(e) {
        this.$set({
            class: e
        }), dr()
    }
    get show() {
        return this.$$.ctx[16]
    }
    get hide() {
        return this.$$.ctx[17]
    }
}
const W$ = (e, t, o, i) => {
        const n = Y(t.x - e.x, t.y - e.y),
            r = ee(n),
            a = 5 * o;
        let s;
        s = i ? .5 * a : Math.ceil(.5 * (a - 1));
        const l = ae(Z(r), s);
        return {
            anchor: Z(e),
            offset: l,
            normal: r,
            solid: i,
            size: a,
            sizeHalf: s
        }
    },
    V$ = ({
        anchor: e,
        solid: t,
        normal: o,
        offset: i,
        size: n,
        sizeHalf: r,
        strokeWidth: a,
        strokeColor: s
    }, l) => {
        const c = e.x,
            d = e.y,
            u = ae(Z(o), n),
            h = Y(c + u.x, d + u.y);
        if (ae(u, .55), t) {
            ne(l, i);
            const e = ae(Z(o), .5 * r);
            return [{
                points: [Y(c - e.x, d - e.y), Y(h.x - u.y, h.y + u.x), Y(h.x + u.y, h.y - u.x)],
                backgroundColor: s
            }]
        } {
            const e = ae((e => {
                    const t = e.x;
                    return e.x = -e.y, e.y = t, e
                })(Z(o)), .5),
                t = Y(c - e.x, d - e.y),
                i = Y(c + e.x, d + e.y);
            return [{
                points: [Y(h.x + u.y, h.y - u.x), t, Y(c, d), i, Y(h.x - u.y, h.y + u.x)],
                strokeWidth: a,
                strokeColor: s
            }]
        }
    },
    H$ = ({
        anchor: e,
        solid: t,
        offset: o,
        normal: i,
        sizeHalf: n,
        strokeWidth: r,
        strokeColor: a
    }, s) => (ne(s, o), t && ne(s, K(Z(i))), [{
        x: e.x,
        y: e.y,
        rx: n,
        ry: n,
        backgroundColor: t ? a : void 0,
        strokeWidth: t ? void 0 : r,
        strokeColor: t ? void 0 : a
    }]),
    N$ = ({
        anchor: e,
        offset: t,
        strokeWidth: o,
        strokeColor: i
    }) => [{
        points: [Y(e.x - t.y, e.y + t.x), Y(e.x + t.y, e.y - t.x)],
        strokeWidth: o,
        strokeColor: i
    }],
    U$ = ({
        anchor: e,
        solid: t,
        offset: o,
        normal: i,
        sizeHalf: n,
        strokeWidth: r,
        strokeColor: a
    }, s) => {
        return ne(s, o), [{
            x: e.x - n,
            y: e.y - n,
            width: 2 * n,
            height: 2 * n,
            rotation: (l = i, Math.atan2(l.y, l.x)),
            backgroundColor: t ? a : void 0,
            strokeWidth: t ? void 0 : r,
            strokeColor: t ? void 0 : a
        }];
        var l
    },
    j$ = (e = {}) => t => {
        if (!Jt(t, "lineStart") && !Jt(t, "lineEnd")) return;
        const o = [],
            {
                lineStart: i,
                lineEnd: n,
                strokeWidth: r,
                strokeColor: a
            } = t,
            s = Y(t.x1, t.y1),
            l = Y(t.x2, t.y2),
            c = [s, l];
        if (i) {
            const [t, n] = i.split("-"), c = e[t];
            if (c) {
                const e = W$(s, l, r, !!n);
                o.push(...c({
                    ...e,
                    strokeColor: a,
                    strokeWidth: r
                }, s))
            }
        }
        if (n) {
            const [t, i] = n.split("-"), c = e[t];
            if (c) {
                const e = W$(l, s, r, !!i);
                o.push(...c({
                    ...e,
                    strokeColor: a,
                    strokeWidth: r
                }, l))
            }
        }
        return [{
            points: c,
            strokeWidth: r,
            strokeColor: a
        }, ...o]
    },
    X$ = () => ({
        arrow: V$,
        circle: H$,
        square: U$,
        bar: N$
    }),
    Y$ = (e, t) => {
        const o = parseFloat(e) * t;
        return w(e) ? o + "%" : o
    },
    G$ = (e, t) => w(e) ? yi(e, t) : e,
    q$ = e => [{
        ...e,
        frameStyle: "line",
        frameInset: 0,
        frameOffset: 0,
        frameSize: e.frameSize ? Y$(e.frameSize, 2) : "2.5%",
        frameRadius: e.frameRound ? Y$(e.frameSize, 2) : 0
    }],
    Z$ = ({
        width: e,
        height: t,
        frameImage: o,
        frameSize: i = "15%",
        frameSlices: n = {
            x1: .15,
            y1: .15,
            x2: .85,
            y2: .85
        }
    }, {
        isPreview: r
    }) => {
        if (!o) return [];
        const a = Math.sqrt(e * t),
            s = G$(i, a),
            l = r ? s : Math.round(s),
            c = l,
            {
                x1: d,
                x2: u,
                y1: h,
                y2: p
            } = n,
            m = {
                x0: 0,
                y0: 0,
                x1: l,
                y1: c,
                x2: e - l,
                y2: t - c,
                x3: e,
                y3: t,
                cw: l,
                ch: c,
                ew: e - l - l,
                eh: t - c - c
            },
            g = r ? 1 : 0,
            f = 2 * g,
            $ = {
                width: m.cw,
                height: m.ch,
                backgroundImage: o
            };
        return [{
            x: m.x1 - g,
            y: m.y0,
            width: m.ew + f,
            height: m.ch,
            backgroundCorners: [{
                x: d,
                y: 0
            }, {
                x: u,
                y: 0
            }, {
                x: u,
                y: h
            }, {
                x: d,
                y: h
            }],
            backgroundImage: o
        }, {
            x: m.x1 - g,
            y: m.y2,
            width: m.ew + f,
            height: m.ch,
            backgroundCorners: [{
                x: d,
                y: p
            }, {
                x: u,
                y: p
            }, {
                x: u,
                y: 1
            }, {
                x: d,
                y: 1
            }],
            backgroundImage: o
        }, {
            x: m.x0,
            y: m.y1 - g,
            width: m.cw,
            height: m.eh + f,
            backgroundCorners: [{
                x: 0,
                y: h
            }, {
                x: d,
                y: h
            }, {
                x: d,
                y: p
            }, {
                x: 0,
                y: p
            }],
            backgroundImage: o
        }, {
            x: m.x2,
            y: m.y1 - g,
            width: m.cw,
            height: m.eh + f,
            backgroundCorners: [{
                x: u,
                y: h
            }, {
                x: 1,
                y: h
            }, {
                x: 1,
                y: p
            }, {
                x: u,
                y: p
            }],
            backgroundImage: o
        }, {
            ...$,
            x: m.x0,
            y: m.y0,
            backgroundCorners: [{
                x: 0,
                y: 0
            }, {
                x: d,
                y: 0
            }, {
                x: d,
                y: h
            }, {
                x: 0,
                y: h
            }]
        }, {
            ...$,
            x: m.x2,
            y: m.y0,
            backgroundCorners: [{
                x: u,
                y: 0
            }, {
                x: 1,
                y: 0
            }, {
                x: 1,
                y: h
            }, {
                x: u,
                y: h
            }]
        }, {
            ...$,
            x: m.x2,
            y: m.y2,
            backgroundCorners: [{
                x: u,
                y: p
            }, {
                x: 1,
                y: p
            }, {
                x: 1,
                y: 1
            }, {
                x: u,
                y: 1
            }]
        }, {
            ...$,
            x: m.x0,
            y: m.y2,
            backgroundCorners: [{
                x: 0,
                y: p
            }, {
                x: d,
                y: p
            }, {
                x: d,
                y: 1
            }, {
                x: 0,
                y: 1
            }]
        }]
    },
    K$ = ({
        x: e,
        y: t,
        width: o,
        height: i,
        frameInset: n = "3.5%",
        frameSize: r = ".25%",
        frameColor: a = [1, 1, 1],
        frameOffset: s = "5%",
        frameAmount: l = 1,
        frameRadius: c = 0,
        expandsCanvas: d = !1
    }, {
        isPreview: u
    }) => {
        const h = Math.sqrt(o * i);
        let p = G$(r, h);
        const m = G$(n, h),
            g = G$(s, h);
        let f = 0;
        u || (p = Math.max(1, Math.round(p)), f = p % 2 == 0 ? 0 : .5);
        const $ = G$(Y$(c, l), h);
        return new Array(l).fill(void 0).map(((n, r) => {
            const s = g * r;
            let l = e + m + s,
                c = t + m + s,
                h = e + o - m - s,
                y = t + i - m - s;
            u || (l = Math.round(l), c = Math.round(c), h = Math.round(h), y = Math.round(y));
            return {
                x: l + f,
                y: c + f,
                width: h - l,
                height: y - c,
                cornerRadius: $ > 0 ? $ - s : 0,
                strokeWidth: p,
                strokeColor: a,
                expandsCanvas: d
            }
        }))
    },
    J$ = ({
        x: e,
        y: t,
        width: o,
        height: i,
        frameSize: n = ".25%",
        frameOffset: r = 0,
        frameInset: a = "2.5%",
        frameColor: s = [1, 1, 1]
    }, {
        isPreview: l
    }) => {
        const c = Math.sqrt(o * i);
        let d = G$(n, c),
            u = G$(a, c),
            h = G$(r, c),
            p = 0;
        l || (d = Math.max(1, Math.round(d)), u = Math.round(u), h = Math.round(h), p = d % 2 == 0 ? 0 : .5);
        const m = h - u,
            g = e + u + p,
            f = t + u + p,
            $ = e + o - u - p,
            y = t + i - u - p;
        return [{
            points: [Y(g + m, f), Y($ - m, f)]
        }, {
            points: [Y($, f + m), Y($, y - m)]
        }, {
            points: [Y($ - m, y), Y(g + m, y)]
        }, {
            points: [Y(g, y - m), Y(g, f + m)]
        }].map((e => (e.strokeWidth = d, e.strokeColor = s, e)))
    },
    Q$ = ({
        x: e,
        y: t,
        width: o,
        height: i,
        frameSize: n = ".25%",
        frameInset: r = "2.5%",
        frameLength: a = "2.5%",
        frameColor: s = [1, 1, 1]
    }, {
        isPreview: l
    }) => {
        const c = Math.sqrt(o * i);
        let d = G$(n, c),
            u = G$(r, c),
            h = G$(a, c),
            p = 0;
        l || (d = Math.max(1, Math.round(d)), u = Math.round(u), h = Math.round(h), p = d % 2 == 0 ? 0 : .5);
        const m = e + u + p,
            g = t + u + p,
            f = e + o - u - p,
            $ = t + i - u - p;
        return [{
            points: [Y(m, g + h), Y(m, g), Y(m + h, g)]
        }, {
            points: [Y(f - h, g), Y(f, g), Y(f, g + h)]
        }, {
            points: [Y(f, $ - h), Y(f, $), Y(f - h, $)]
        }, {
            points: [Y(m + h, $), Y(m, $), Y(m, $ - h)]
        }].map((e => (e.strokeWidth = d, e.strokeColor = s, e)))
    },
    ey = ({
        x: e,
        y: t,
        width: o,
        height: i,
        frameColor: n = [1, 1, 1]
    }, {
        isPreview: r
    }) => {
        const a = Math.sqrt(o * i),
            s = .1 * a;
        let l = .2 * a;
        const c = .5 * s;
        let d = .0025 * a;
        return r || (l = Math.ceil(l), d = Math.max(2, d)), n.length = 3, [{
            id: "border",
            x: e - c,
            y: t - c,
            width: o + s,
            height: i + l,
            frameStyle: "line",
            frameInset: 0,
            frameOffset: 0,
            frameSize: s,
            frameColor: n,
            expandsCanvas: !0
        }, {
            id: "chin",
            x: e - c,
            y: i,
            width: o + s,
            height: l,
            backgroundColor: n,
            expandsCanvas: !0
        }, r && {
            x: e,
            y: t,
            width: o,
            height: i,
            strokeWidth: d,
            strokeColor: n
        }].filter(Boolean)
    },
    ty = (e = {}) => (t, o) => {
        if (!Jt(t, "frameStyle")) return;
        const i = t.frameStyle,
            n = e[i];
        if (!n) return;
        const {
            frameStyle: r,
            ...a
        } = t;
        return n(a, o)
    },
    oy = () => ({
        solid: q$,
        hook: Q$,
        line: K$,
        edge: J$,
        polaroid: ey,
        nine: Z$
    }),
    iy = e => {
        const t = (o, i = {
            isPreview: !0
        }) => {
            const n = e.map((e => {
                const n = e(o, i);
                if (n) return n.map((e => t(e, i)))
            })).filter(Boolean).flat();
            return n.length ? n.flat() : o
        };
        return t
    },
    ny = Za,
    ry = Ka,
    ay = () => ({
        read: s,
        apply: y
    }),
    sy = (e = {}) => {
        const {
            blurAmount: t,
            scrambleAmount: o,
            enableSmoothing: i,
            backgroundColor: n
        } = e;
        return (e, r) => (async (e, t = {}) => {
            if (!e) return;
            const {
                width: o,
                height: i
            } = e, {
                dataSize: n = 96,
                dataSizeScalar: r = 1,
                scrambleAmount: a = 4,
                blurAmount: s = 6,
                outputFormat: l = "canvas",
                backgroundColor: c = [0, 0, 0]
            } = t, d = Math.round(n * r), u = Math.min(d / o, d / i), h = Math.floor(o * u), m = Math.floor(i * u), $ = p("canvas", {
                width: h,
                height: m
            }), y = $.getContext("2d");
            if (c.length = 3, y.fillStyle = so(c), y.fillRect(0, 0, h, m), f(e)) {
                const t = p("canvas", {
                    width: o,
                    height: i
                });
                t.getContext("2d").putImageData(e, 0, 0), y.drawImage(t, 0, 0, h, m), g(t)
            } else y.drawImage(e, 0, 0, h, m);
            const x = y.getImageData(0, 0, h, m),
                b = [];
            if (a > 0 && b.push([Ja, {
                    amount: a
                }]), s > 0)
                for (let e = 0; e < s; e++) b.push([jt, {
                    matrix: Qa
                }]);
            let v;
            if (b.length) {
                const e = (t, o) => `(err, imageData) => {\n                (${t[o][0].toString()})(Object.assign({ imageData: imageData }, filterInstructions[${o}]), \n                    ${t[o+1]?e(t,o+1):"done"})\n            }`,
                    t = `function (options, done) {\n            const filterInstructions = options.filterInstructions;\n            const imageData = options.imageData;\n            (${e(b,0)})(null, imageData)\n        }`,
                    o = await P(t, [{
                        imageData: x,
                        filterInstructions: b.map((e => e[1]))
                    }], [x.data.buffer]);
                v = Ht(o)
            } else v = x;
            return "canvas" === l ? (y.putImageData(v, 0, 0), $) : v
        })(e, {
            blurAmount: t,
            scrambleAmount: o,
            enableSmoothing: i,
            backgroundColor: n,
            ...r
        })
    },
    ly = ba,
    cy = () => (() => {
        const e = $a.map(ya),
            t = Xr.map((([e]) => e)).filter((e => !fa.includes(e)));
        return e.concat(t)
    })().concat((Au = new Set(Tl(Tu).filter((e => !Pu.includes(e)))), [...Au, ...Iu])),
    dy = sp,
    uy = rp,
    hy = Xp,
    py = {
        markupEditorToolbar: sp(),
        markupEditorToolStyles: rp(),
        markupEditorShapeStyleControls: Xp()
    },
    my = Fu,
    gy = rg,
    fy = hg,
    $y = xg,
    yy = Kf,
    xy = e$,
    by = i$,
    vy = c$,
    wy = C$,
    Sy = v$,
    Cy = sh,
    ky = wh,
    My = Eh,
    Ty = T$,
    Ry = R$,
    Py = P$,
    Ay = {
        filterLabel: "Filter",
        filterIcon: '<g stroke-width=".125em" stroke="currentColor" fill="none"><path d="M18.347 9.907a6.5 6.5 0 1 0-1.872 3.306M3.26 11.574a6.5 6.5 0 1 0 2.815-1.417 M10.15 17.897A6.503 6.503 0 0 0 16.5 23a6.5 6.5 0 1 0-6.183-8.51"/></g>',
        filterLabelChrome: "Chrome",
        filterLabelFade: "Fade",
        filterLabelCold: "Cold",
        filterLabelWarm: "Warm",
        filterLabelPastel: "Pastel",
        filterLabelMonoDefault: "Mono",
        filterLabelMonoNoir: "Noir",
        filterLabelMonoWash: "Wash",
        filterLabelMonoStark: "Stark",
        filterLabelSepiaDefault: "Sepia",
        filterLabelSepiaBlues: "Blues",
        filterLabelSepiaRust: "Rust",
        filterLabelSepiaColor: "Color"
    },
    Iy = {
        finetuneLabel: "Finetune",
        finetuneIcon: '<g stroke-width=".125em" stroke="currentColor" fill="none"><path d="M4 1v5.5m0 3.503V23M12 1v10.5m0 3.5v8M20 1v15.5m0 3.5v3M2 7h4M10 12h4M18 17h4"/></g>',
        finetuneLabelBrightness: "Brightness",
        finetuneLabelContrast: "Contrast",
        finetuneLabelSaturation: "Saturation",
        finetuneLabelExposure: "Exposure",
        finetuneLabelTemperature: "Temperature",
        finetuneLabelGamma: "Gamma",
        finetuneLabelClarity: "Clarity",
        finetuneLabelVignette: "Vignette"
    },
    Ey = {
        resizeLabel: "Resize",
        resizeIcon: '<g stroke-width=".125em" stroke="currentColor" fill="none"><rect x="2" y="12" width="10" height="10" rx="2"/><path d="M4 11.5V4a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5"/><path d="M14 10l3.365-3.365M14 6h4v4"/></g>',
        resizeLabelFormCaption: "Image output size",
        resizeLabelInputWidth: "w",
        resizeTitleInputWidth: "Width",
        resizeLabelInputHeight: "h",
        resizeTitleInputHeight: "Height",
        resizeTitleButtonMaintainAspectRatio: "Maintain aspectratio",
        resizeIconButtonMaintainAspectRatio: (e, t) => `\n        <defs>\n            <mask id="mask1" x="0" y="0" width="24" height="24" >\n                <rect x="0" y="0" width="24" height="10" fill="#fff" stroke="none"/>\n            </mask>\n        </defs>\n        <g fill="none" fill-rule="evenodd">\n            <g  mask="url(#mask1)">\n                <path transform="translate(0 ${3*(t-1)})" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" d="M9.401 10.205v-.804a2.599 2.599 0 0 1 5.198 0V17"/>\n            </g>\n            <rect fill="currentColor" x="7" y="10" width="10" height="7" rx="1.5"/>\n        </g>\n    `
    },
    Ly = {
        decorateLabel: "Decorate",
        decorateIcon: '<g fill="none" fill-rule="evenodd"><path stroke="currentColor" stroke-width=".125em" stroke-linecap="round" stroke-linejoin="round" d="M12 18.5l-6.466 3.4 1.235-7.2-5.23-5.1 7.228-1.05L12 2l3.233 6.55 7.229 1.05-5.231 5.1 1.235 7.2z"/></g>'
    },
    Fy = {
        annotateLabel: "Annotate",
        annotateIcon: '<g stroke-width=".125em" stroke="currentColor" fill="none"><path d="M17.086 2.914a2.828 2.828 0 1 1 4 4l-14.5 14.5-5.5 1.5 1.5-5.5 14.5-14.5z"/></g>'
    },
    zy = {
        stickerLabel: "Sticker",
        stickerIcon: '<g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width=".125em"><path d="M12 22c2.773 0 1.189-5.177 3-7 1.796-1.808 7-.25 7-3 0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10z"/><path d="M20 17c-3 3-5 5-8 5"/></g>'
    },
    By = A$,
    Dy = I$,
    Oy = (e, t, o = {}) => (w(t) ? Array.from(document.querySelectorAll(t)) : t).filter(Boolean).map((t => e(t, v(o)))),
    _y = F$,
    Wy = (e = {}, t) => {
        const {
            sub: o,
            pub: i
        } = po(), r = {}, a = ((e = {}, t) => new _$({
            target: t || document.body,
            props: {
                class: e.class,
                preventZoomViewport: e.preventZoomViewport,
                preventScrollBodyIfNeeded: e.preventScrollBodyIfNeeded,
                preventFooterOverlapIfNeeded: e.preventFooterOverlapIfNeeded
            }
        }))(e, t), s = () => {
            a.hide && a.hide()
        }, l = () => {
            a.show && a.show()
        }, c = L$(a.root);
        E$(c, r), r.handleEvent = n, c.handleEvent = (e, t) => r.handleEvent(e, t), c.on("close", (async () => {
            const {
                willClose: t
            } = e;
            if (!t) return s();
            await t() && s()
        }));
        const d = (e, t) => /show|hide/.test(e) ? o(e, t) : c.on(e, t),
            u = ["show", "hide"].map((e => d(e, (t => r.handleEvent(e, t))))),
            h = () => {
                u.forEach((e => e())), s(), a.$destroy(), c.destroy()
            };
        return Gr(r, {
            on: d,
            destroy: h,
            hide: s,
            show: l
        }), Object.defineProperty(r, "modal", {
            get: () => a.root,
            set: () => {}
        }), a.$on("close", c.close), a.$on("show", (() => i("show"))), a.$on("hide", (() => {
            i("hide"), !1 !== e.enableAutoDestroy && h()
        })), !1 !== e.enableAutoHide && c.on("process", s), c.on("loadstart", l), !1 !== e.enableButtonClose && (e.enableButtonClose = !0), delete e.class, Object.assign(r, e), r
    },
    Vy = (e, t) => F$(e, {
        ...t,
        layout: "overlay"
    }),
    Hy = (e, t) => Oy(_y, e, t),
    Ny = iy,
    Uy = () => iy([ty(oy()), j$(X$())]),
    jy = (e = {}) => {
        let t = void 0;
        Array.isArray(e.imageWriter) || (t = e.imageWriter, delete e.imageReader);
        let o = void 0;
        Array.isArray(e.imageWriter) || (o = e.imageWriter, delete e.imageWriter);
        let i = void 0;
        return S(e.imageScrambler) || (i = e.imageScrambler, delete e.imageScrambler), {
            imageReader: ny(t),
            imageWriter: ry(o),
            imageOrienter: ay(),
            imageScrambler: sy(i)
        }
    },
    Xy = (e, t = {}) => va(e, {
        ...jy(t),
        ...t
    }),
    Yy = (e = {}) => {
        Fu(...[gy, fy, $y, yy, xy, by, vy, wy, Sy].filter(Boolean));
        const t = ["crop", "filter", "finetune", "annotate", "decorate", e.stickers && "sticker", "frame", "redact", "resize"].filter(Boolean),
            o = jy(e),
            i = {
                ...Ty,
                ...Ry,
                ...Py,
                ...Ay,
                ...Iy,
                ...By,
                ...Dy,
                ...Ey,
                ...Ly,
                ...Fy,
                ...zy,
                ...e.locale
            };
        return delete e.locale, _r([{
            ...o,
            shapePreprocessor: Uy(),
            utils: t,
            ...Cy,
            ...ky,
            ...My,
            ...py,
            stickerStickToImage: !0,
            locale: i
        }, e])
    },
    Gy = async (e = {}) => {
        const t = await void 0;
        return t.forEach((t => Object.assign(t, v(e)))), t
    }, qy = e => Gy(Yy(e)), Zy = e => Wy(Yy(e)), Ky = (e, t) => _y(e, Yy(t)), Jy = (e, t) => Vy(e, Yy(t)), Qy = (e, t) => Oy(Ky, e, t);
(e => {
    const [t, o, i, n, r, a, s, l, c, d, u, h] = ["bG9jYXRpb24=", "ZG9jdW1lbnQ=", "UmVnRXhw", "RWxlbWVudA==", "dGVzdA==", "PGEgaHJlZj0iaHR0cHM6Ly9wcWluYS5ubC8/dW5saWNlbnNlZCI+Zm9yIHVzZSBvbiBwcWluYS5ubCBvbmx5PC9hPg==", "aW5zZXJ0QWRqYWNlbnRIVE1M", "Y2xhc3NOYW1l", "IHBpbnR1cmEtZWRpdG9yLXZhbGlkYXRlZA==", "KD86WzAtOV17MSwzfVwuKXszfXxjc2JcLmFwcHxwcWluYVwubmx8bG9jYWxob3N0", "YmVmb3JlZW5k", "Ym9keQ=="].map(e[[(!1 + "")[1], (!0 + "")[0], (1 + {})[2], (1 + {})[3]].join("")]);
    new e[i](d)[r](e[t]) || e[o][h][s](u, a), e[o][o + n][l] += c
})(window);
export {
    Ky as appendDefaultEditor, Qy as appendDefaultEditors, _y as appendEditor, Hy as appendEditors, ju as appendNode, D as blobToFile, Gd as colorStringToColorArray, lp as createDefaultColorOptions, fp as createDefaultFontFamilyOptions, up as createDefaultFontScaleOptions, cp as createDefaultFontSizeOptions, yp as createDefaultFontStyleOptions, oy as createDefaultFrameStyles, ay as createDefaultImageOrienter, ny as createDefaultImageReader, sy as createDefaultImageScrambler, ry as createDefaultImageWriter, gp as createDefaultLineEndStyleOptions, X$ as createDefaultLineEndStyles, dp as createDefaultLineHeightOptions, hp as createDefaultLineHeightScaleOptions, Uy as createDefaultShapePreprocessor, mp as createDefaultStrokeScaleOptions, pp as createDefaultStrokeWidthOptions, $p as createDefaultTextAlignOptions, ly as createEditor, ty as createFrameStyleProcessor, j$ as createLineEndProcessor, zp as createMarkupEditorBackgroundColorControl, Ep as createMarkupEditorColorControl, xp as createMarkupEditorColorOptions, Vp as createMarkupEditorFontColorControl, Fp as createMarkupEditorFontFamilyControl, Mp as createMarkupEditorFontFamilyOptions, vp as createMarkupEditorFontScaleOptions, Np as createMarkupEditorFontSizeControl, bp as createMarkupEditorFontSizeOptions, Hp as createMarkupEditorFontStyleControl, Tp as createMarkupEditorFontStyleOptions, Wp as createMarkupEditorLineEndStyleControl, Rp as createMarkupEditorLineEndStyleOptions, jp as createMarkupEditorLineHeightControl, wp as createMarkupEditorLineHeightOptions, Sp as createMarkupEditorLineHeightScaleOptions, _p as createMarkupEditorLineStartStyleControl, hy as createMarkupEditorShapeStyleControls, Bp as createMarkupEditorStrokeColorControl, kp as createMarkupEditorStrokeScaleOptions, Dp as createMarkupEditorStrokeWidthControl, Cp as createMarkupEditorStrokeWidthOptions, Up as createMarkupEditorTextAlignControl, np as createMarkupEditorToolStyle, uy as createMarkupEditorToolStyles, dy as createMarkupEditorToolbar, Vu as createNode, Ny as createShapePreprocessor, Gy as defineCustomElements, qy as defineDefaultCustomElements, Hs as degToRad, Bu as dispatchEditorEvents, Qu as effectBrightness, rh as effectClarity, eh as effectContrast, oh as effectExposure, ih as effectGamma, th as effectSaturation, ah as effectTemperature, nh as effectVignette, ch as filterChrome, hh as filterCold, dh as filterFade, ph as filterInvert, mh as filterMonoDefault, gh as filterMonoNoir, $h as filterMonoStark, fh as filterMonoWash, lh as filterPastel, xh as filterSepiaBlues, vh as filterSepiaColor, yh as filterSepiaDefault, bh as filterSepiaRust, uh as filterWarm, Yu as findNode, Rh as frameEdgeCross, Ph as frameEdgeOverlap, Th as frameEdgeSeparate, Ah as frameHook, Mh as frameLineMultiple, kh as frameLineSingle, Ih as framePolaroid, Ch as frameSolidRound, Sh as frameSolidSharp, Yy as getEditorDefaults, cy as getEditorProps, Uu as insertNodeAfter, Nu as insertNodeBefore, Ku as isSupported, qu as legacyDataToImageState, Ty as locale_en_gb, py as markup_editor_defaults, Ry as markup_editor_locale_en_gb, Zy as openDefaultEditor, Wy as openEditor, Jy as overlayDefaultEditor, Vy as overlayEditor, yy as plugin_annotate, Fy as plugin_annotate_locale_en_gb, gy as plugin_crop, Py as plugin_crop_locale_en_gb, xy as plugin_decorate, Ly as plugin_decorate_locale_en_gb, fy as plugin_filter, ky as plugin_filter_defaults, Ay as plugin_filter_locale_en_gb, $y as plugin_finetune, Cy as plugin_finetune_defaults, Iy as plugin_finetune_locale_en_gb, vy as plugin_frame, My as plugin_frame_defaults, By as plugin_frame_locale_en_gb, wy as plugin_redact, Dy as plugin_redact_locale_en_gb, Sy as plugin_resize, Ey as plugin_resize_locale_en_gb, by as plugin_sticker, zy as plugin_sticker_locale_en_gb, Xy as processDefaultImage, va as processImage, Xu as removeNode, my as setPlugins, Zd as supportsWebGL
};
