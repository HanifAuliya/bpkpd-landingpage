import 'trix';

// Reveal elements as they enter the viewport.
function initReveal() {
    const items = document.querySelectorAll('[data-reveal]:not(.is-visible)');
    if (!('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('is-visible'));
        return;
    }
    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                io.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    items.forEach((el) => io.observe(el));
}

document.addEventListener('DOMContentLoaded', initReveal);
document.addEventListener('livewire:navigated', initReveal);
document.addEventListener('livewire:init', () => {
    window.Livewire.hook('morphed', () => requestAnimationFrame(initReveal));
});

document.addEventListener('alpine:init', () => {
    const Alpine = window.Alpine;

    // Light/dark switch. The initial class is set by an inline script in <head> to avoid a flash.
    Alpine.store('theme', {
        dark: document.documentElement.classList.contains('dark'),
        toggle() {
            this.dark = !this.dark;
            document.documentElement.classList.toggle('dark', this.dark);
            try { localStorage.setItem('theme', this.dark ? 'dark' : 'light'); } catch (e) { /* storage unavailable */ }
        },
    });

    // Animated number that counts up once it becomes visible.
    Alpine.data('counter', (target = 0, duration = 1600) => ({
        value: 0,
        init() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                this.value = target;
                return;
            }
            const io = new IntersectionObserver(([entry]) => {
                if (!entry.isIntersecting) return;
                io.disconnect();
                const start = performance.now();
                const tick = (now) => {
                    // The first frame's timestamp can precede `start`; clamp so the value never goes negative.
                    const p = Math.max(0, Math.min((now - start) / duration, 1));
                    this.value = Math.round(target * (1 - Math.pow(1 - p, 3)));
                    if (p < 1) requestAnimationFrame(tick);
                };
                requestAnimationFrame(tick);
            });
            io.observe(this.$el);
        },
    }));

    // Simple autoplaying slider.
    Alpine.data('slider', (count = 1, interval = 6500) => ({
        active: 0,
        count,
        timer: null,
        init() { this.play(); },
        play() {
            clearInterval(this.timer);
            if (this.count > 1) this.timer = setInterval(() => this.next(), interval);
        },
        next() { this.active = (this.active + 1) % this.count; },
        prev() { this.active = (this.active - 1 + this.count) % this.count; },
        go(i) { this.active = i; this.play(); },
        destroy() { clearInterval(this.timer); },
    }));

    // Trix editor bound to a Livewire property.
    Alpine.data('richtext', (model) => ({
        init() {
            const editor = this.$refs.trix;
            const sync = () => {
                const value = this.$wire.get(model) ?? '';
                if (editor.value !== value) editor.editor.loadHTML(value);
            };
            editor.addEventListener('trix-initialize', sync, { once: true });
            editor.addEventListener('trix-change', () => this.$wire.set(model, editor.value, false));
            this.$wire.$watch(model, (v) => { if (editor.editor && editor.value !== v) editor.editor.loadHTML(v ?? ''); });
        },
    }));
});
