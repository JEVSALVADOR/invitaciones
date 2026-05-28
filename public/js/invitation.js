/**
 * invitation.js — Digital Invitation Interactive Script
 */

'use strict';

/* ─── ENVELOPE OPEN ─────────────────────────── */
let envelopeOpened = sessionStorage.getItem('envelopeOpened') === 'true';

function openEnvelope() {
    const envelope  = document.getElementById('envelope');
    const cover     = document.getElementById('cover');
    const content   = document.getElementById('invitation-content');
    if (!envelope || envelopeOpened) return;

    envelope.classList.add('open');

    setTimeout(() => {
        cover.style.transition  = 'opacity 0.7s ease, transform 0.7s ease';
        cover.style.opacity     = '0';
        cover.style.transform   = 'scale(0.94)';

        setTimeout(() => {
            cover.style.display = 'none';
            content.classList.remove('hidden-initially');
            content.classList.add('revealed');
            envelopeOpened = true;
            sessionStorage.setItem('envelopeOpened', 'true');
            initScrollReveal();
            initCountdown();
            renderCalendar(
                document.getElementById('eventCalendar')?.dataset.eventDate
            );
        }, 650);
    }, 820);
}

const trigger = document.getElementById('envelopeTrigger');
if (trigger) {
    trigger.addEventListener('click', openEnvelope);
    trigger.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openEnvelope(); }
    });
}

if (envelopeOpened) {
    const cover   = document.getElementById('cover');
    const content = document.getElementById('invitation-content');
    if (cover) cover.style.display = 'none';
    if (content) {
        content.classList.remove('hidden-initially');
        content.style.opacity = '1';
    }
    document.addEventListener('DOMContentLoaded', () => {
        initScrollReveal();
        initCountdown();
        renderCalendar(document.getElementById('eventCalendar')?.dataset.eventDate);
    });
}


/* ─── MUSIC PLAYER ──────────────────────────── */
let isPlaying = false;
let isRepeat  = true;
const audio = document.getElementById('audioPlayer');

function togglePlay() {
    if (!audio) return;
    if (!audio.src || audio.src === window.location.href || audio.src === '') {
        return;
    }
    if (isPlaying) {
        audio.pause();
        document.getElementById('playIcon').textContent = '▶';
    } else {
        audio.play().catch(() => {});
        document.getElementById('playIcon').textContent = '⏸';
    }
    isPlaying = !isPlaying;
}

function toggleRepeat() {
    if (!audio) return;
    isRepeat   = !isRepeat;
    audio.loop = isRepeat;
    const btn  = document.getElementById('repeatBtn');
    if (btn) btn.style.opacity = isRepeat ? '1' : '0.35';
}

if (audio) {
    audio.loop = true;
    audio.addEventListener('ended', () => {
        if (!isRepeat) {
            isPlaying = false;
            const icon = document.getElementById('playIcon');
            if (icon) icon.textContent = '▶';
        }
    });
}


/* ─── COUNTDOWN ─────────────────────────────── */
function initCountdown() {
    const timerEl = document.getElementById('countdownTimer');
    if (!timerEl) return;

    const rawTarget = timerEl.dataset.target;
    if (!rawTarget) return;

    const target = new Date(rawTarget).getTime();

    function pad(n) { return String(n).padStart(2, '0'); }

    function updateTimer() {
        const diff = target - Date.now();
        if (diff <= 0) {
            ['days','hours','minutes','seconds'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = '00';
            });
            return;
        }
        const d = Math.floor(diff / 86400000);
        const h = Math.floor((diff % 86400000) / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);

        const days = document.getElementById('days');
        const hours = document.getElementById('hours');
        const mins = document.getElementById('minutes');
        const secs = document.getElementById('seconds');

        if (days)  days.textContent  = pad(d);
        if (hours) hours.textContent = pad(h);
        if (mins)  mins.textContent  = pad(m);
        if (secs)  secs.textContent  = pad(s);
    }

    updateTimer();
    setInterval(updateTimer, 1000);
}


/* ─── CALENDAR ──────────────────────────────── */
function renderCalendar(eventDateStr) {
    const cal = document.getElementById('eventCalendar');
    if (!cal || !eventDateStr) return;

    const parts     = eventDateStr.split('-');
    const eventDate = new Date(+parts[0], +parts[1] - 1, +parts[2]);
    const year      = eventDate.getFullYear();
    const month     = eventDate.getMonth();
    const eventDay  = eventDate.getDate();

    const monthNames = [
        'ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO',
        'JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'
    ];
    const dayNames = ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'];

    const firstDow    = new Date(year, month, 1).getDay();
    const adjustedFst = firstDow === 0 ? 6 : firstDow - 1;
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    let html = `<div class="cal-header">${monthNames[month]} ${year}</div><div class="cal-grid">`;
    dayNames.forEach(d => { html += `<div class="cal-day-name">${d}</div>`; });
    for (let i = 0; i < adjustedFst; i++) html += '<div class="cal-day"></div>';
    for (let d = 1; d <= daysInMonth; d++) {
        if (d === eventDay) {
            html += `<div class="cal-day event-day"><span>${d}</span></div>`;
        } else {
            html += `<div class="cal-day">${d}</div>`;
        }
    }
    html += '</div>';
    cal.innerHTML = html;
}


/* ─── SCROLL REVEAL ─────────────────────────── */
let revealObserver;

function initScrollReveal() {
    const els = document.querySelectorAll('#invitation-content .scroll-reveal');
    if (!els.length) return;

    revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    els.forEach(el => revealObserver.observe(el));
}


/* ─── RSVP FORM ─────────────────────────────── */
const rsvpForm = document.getElementById('rsvpForm');
if (rsvpForm) {
    rsvpForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        const form = e.target;
        const btn  = form.querySelector('[type="submit"]');
        const orig = btn.textContent;

        if (!form.querySelector('[name="attendance_option"]:checked')) {
            showRsvpError('Por favor selecciona una opción de asistencia.');
            return;
        }

        btn.textContent = 'Enviando...';
        btn.disabled    = true;

        try {
            const fd  = new FormData(form);
            const res = await fetch(form.action, {
                method:  'POST',
                body:    fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });

            if (!res.ok) throw new Error('Server error');
            const data = await res.json();

            if (data.success) {
                form.innerHTML = `
                    <div style="padding:24px 0; text-align:center">
                        <div style="font-size:3rem; margin-bottom:14px">🎉</div>
                        <p style="font-size:1.1rem; font-weight:700; color:var(--primary); line-height:1.5">
                            ¡Gracias, ${escapeHtml(data.name)}!
                        </p>
                        <p style="margin-top:8px; opacity:0.7; font-size:0.9rem">
                            Tu asistencia ha sido confirmada.
                        </p>
                    </div>`;
            } else {
                btn.textContent = orig;
                btn.disabled    = false;
                showRsvpError('Hubo un error. Por favor intenta de nuevo.');
            }
        } catch {
            btn.textContent = orig;
            btn.disabled    = false;
            showRsvpError('Sin conexión. Por favor intenta de nuevo.');
        }
    });
}

function showRsvpError(msg) {
    let err = document.getElementById('rsvpError');
    if (!err) {
        err = document.createElement('p');
        err.id = 'rsvpError';
        err.style.cssText = 'color:#c0392b;font-size:0.85rem;margin:8px 0;text-align:center';
        rsvpForm?.prepend(err);
    }
    err.textContent = msg;
}

function escapeHtml(str) {
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}


/* ─── INIT ON DOM READY ─────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    if (envelopeOpened) {
        initScrollReveal();
        initCountdown();
        renderCalendar(document.getElementById('eventCalendar')?.dataset.eventDate);
    }
});
