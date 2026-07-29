<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowDown,
    ArrowUpRight,
    Award,
    BriefcaseBusiness,
    Check,
    Code2,
    Mail,
    MapPin,
    Menu,
    Phone,
    Sparkles,
    X,
} from '@lucide/vue';
import { computed, ref } from 'vue';
import { dashboard, login } from '@/routes';

type Profil = {
    nama_profil: string;
    email: string;
    no_hp: string;
    alamat: string;
    linkedin: string;
    github: string;
    foto_profil_url: string | null;
};

type Sertifikat = {
    id: number;
    nama: string;
    deskripsi: string;
    jenis: string;
    foto_url: string | null;
};

const props = defineProps<{
    profil: Profil | null;
    sertifikats: Sertifikat[];
}>();

const menuOpen = ref(false);
const selectedCertificate = ref<Sertifikat | null>(null);

const displayName = computed(
    () => props.profil?.nama_profil || 'Creative Developer',
);
const firstName = computed(() => displayName.value.split(' ')[0]);
const currentYear = new Date().getFullYear();

const closeMenu = () => {
    menuOpen.value = false;
};

const normalizeUrl = (url?: string) => {
    if (!url) return '#';

    return /^https?:\/\//i.test(url) ? url : `https://${url}`;
};
</script>

<template>
    <Head :title="`${displayName} — Portfolio`">
        <meta
            name="description"
            :content="`Portfolio ${displayName}, menampilkan profil profesional dan sertifikat pilihan.`"
        />
    </Head>

    <div class="portfolio-page min-h-screen overflow-x-hidden">
        <header class="fixed inset-x-0 top-0 z-40 px-4 pt-4 sm:px-6">
            <nav
                class="mx-auto flex max-w-7xl items-center justify-between rounded-2xl border border-white/10 bg-[#0b0d0c]/80 px-4 py-3 shadow-2xl shadow-black/20 backdrop-blur-xl sm:px-6"
            >
                <a
                    href="#home"
                    class="group flex items-center gap-3"
                    @click="closeMenu"
                >
                    <span
                        class="grid size-9 place-items-center rounded-xl bg-[#dfff5f] text-sm font-black text-[#10120e] transition-transform group-hover:-rotate-6"
                    >
                        {{ firstName.charAt(0).toUpperCase() }}
                    </span>
                    <span class="font-semibold tracking-tight text-white">
                        {{ firstName }}<span class="text-[#dfff5f]">.</span>
                    </span>
                </a>

                <div
                    class="hidden items-center gap-8 text-sm text-white/65 md:flex"
                >
                    <a class="nav-link" href="#home">Beranda</a>
                    <a class="nav-link" href="#about">Tentang</a>
                    <a class="nav-link" href="#certificates">Sertifikat</a>
                    <a class="nav-link" href="#contact">Kontak</a>
                </div>

                <div class="hidden md:block">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="dashboard()"
                        class="nav-button"
                    >
                        Dashboard <ArrowUpRight class="size-4" />
                    </Link>
                    <a v-else href="#about" class="nav-button">
                        {{ profil?.nama_profil ?? 'Profil' }}
                        <ArrowUpRight class="size-4" />
                    </a>
                </div>

                <button
                    class="grid size-10 place-items-center rounded-xl border border-white/10 text-white md:hidden"
                    type="button"
                    aria-label="Buka navigasi"
                    @click="menuOpen = !menuOpen"
                >
                    <X v-if="menuOpen" class="size-5" />
                    <Menu v-else class="size-5" />
                </button>
            </nav>

            <div
                v-if="menuOpen"
                class="mx-auto mt-2 flex max-w-7xl flex-col gap-1 rounded-2xl border border-white/10 bg-[#111411] p-3 text-white shadow-2xl md:hidden"
            >
                <a class="mobile-link" href="#home" @click="closeMenu"
                    >Beranda</a
                >
                <a class="mobile-link" href="#about" @click="closeMenu"
                    >Tentang</a
                >
                <a class="mobile-link" href="#certificates" @click="closeMenu"
                    >Sertifikat</a
                >
                <a class="mobile-link" href="#contact" @click="closeMenu"
                    >Kontak</a
                >
            </div>
        </header>

        <main>
            <section
                id="home"
                class="relative flex min-h-screen items-center overflow-hidden px-4 pt-32 pb-16 sm:px-6 lg:pt-36"
            >
                <div class="hero-glow hero-glow-one" />
                <div class="hero-glow hero-glow-two" />
                <div class="hero-grid" />

                <div
                    class="relative z-10 mx-auto grid w-full max-w-7xl items-center gap-12 lg:grid-cols-[1.1fr_0.9fr] lg:gap-20"
                >
                    <div>
                        <div class="eyebrow">
                            <span class="relative flex size-2">
                                <span
                                    class="absolute inline-flex size-full animate-ping rounded-full bg-[#dfff5f] opacity-75"
                                />
                                <span
                                    class="relative inline-flex size-2 rounded-full bg-[#dfff5f]"
                                />
                            </span>
                            Tersedia untuk kolaborasi
                        </div>

                        <h1
                            class="mt-7 max-w-4xl text-5xl leading-[0.96] font-black tracking-[-0.055em] text-white sm:text-6xl lg:text-8xl"
                        >
                            Halo, saya
                            <span class="block text-[#dfff5f]">{{
                                displayName
                            }}</span>
                        </h1>

                        <p
                            class="mt-7 max-w-2xl text-base leading-7 text-white/55 sm:text-lg sm:leading-8"
                        >
                            Saya membangun pengalaman digital yang bersih,
                            cepat, dan menyenangkan—memadukan detail visual
                            dengan solusi teknis yang dapat diandalkan.
                        </p>

                        <div class="mt-9 flex flex-wrap items-center gap-4">
                            <a href="#certificates" class="primary-button">
                                Lihat pencapaian
                                <ArrowDown class="size-4" />
                            </a>
                            <a
                                v-if="profil?.no_hp"
                                :href="`tel:${profil.no_hp}`"
                                class="secondary-button"
                            >
                                Hubungi saya
                            </a>
                        </div>

                        <div
                            class="mt-12 flex flex-wrap items-center gap-x-8 gap-y-4 border-t border-white/10 pt-6 text-sm text-white/45"
                        >
                            <span class="flex items-center gap-2">
                                <MapPin class="size-4 text-[#dfff5f]" />
                                {{ profil?.alamat || 'Indonesia' }}
                            </span>
                            <span class="flex items-center gap-2">
                                <Award class="size-4 text-[#dfff5f]" />
                                {{ sertifikats.length }} sertifikat
                            </span>
                        </div>
                    </div>

                    <div class="relative mx-auto w-full max-w-md lg:max-w-none">
                        <div class="portrait-frame">
                            <div class="portrait-label">
                                <Sparkles class="size-4" /> Portfolio
                            </div>
                            <img
                                v-if="profil?.foto_profil_url"
                                :src="profil.foto_profil_url"
                                :alt="displayName"
                                class="portrait-photo h-full w-full object-cover"
                            />
                            <div
                                v-else
                                class="grid h-full w-full place-items-center bg-[#1b2119] text-8xl font-black text-[#dfff5f]"
                            >
                                {{ firstName.charAt(0).toUpperCase() }}
                            </div>
                            <div class="portrait-overlay" />
                            <div class="absolute right-5 bottom-5 left-5">
                                <p
                                    class="text-xs tracking-[0.22em] text-white/50 uppercase"
                                >
                                    Currently creating
                                </p>
                                <p
                                    class="mt-1 text-xl font-semibold text-white"
                                >
                                    Better digital experiences.
                                </p>
                            </div>
                        </div>
                        <div class="float-card -left-5 sm:-left-10">
                            <span
                                class="grid size-10 place-items-center rounded-full bg-[#dfff5f]"
                            >
                                <Check class="size-5 text-[#10120e]" />
                            </span>
                            <span>
                                <small class="block text-white/45">Focus</small>
                                <strong class="text-sm text-white"
                                    >Quality first</strong
                                >
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="about" class="section-shell">
                <div class="mx-auto max-w-7xl">
                    <div class="section-kicker">01 — Tentang saya</div>
                    <div
                        class="mt-8 grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:gap-24"
                    >
                        <h2 class="section-title">
                            Ide yang baik layak diwujudkan dengan
                            <span>cara yang tepat.</span>
                        </h2>
                        <div class="space-y-7">
                            <p
                                class="text-lg leading-8 text-white/60 sm:text-xl"
                            >
                                Saya percaya produk digital terbaik lahir dari
                                perpaduan rasa ingin tahu, desain yang punya
                                tujuan, dan eksekusi teknis yang teliti.
                            </p>
                            <p class="leading-7 text-white/40">
                                Setiap proyek adalah kesempatan untuk
                                menyederhanakan sesuatu yang rumit dan
                                menciptakan pengalaman yang terasa natural bagi
                                penggunanya.
                            </p>
                            <div class="grid gap-3 pt-3 sm:grid-cols-2">
                                <a
                                    v-if="profil?.github"
                                    :href="normalizeUrl(profil.github)"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="social-card"
                                >
                                    <Code2 class="size-5" />
                                    <span>GitHub</span>
                                    <ArrowUpRight class="ml-auto size-4" />
                                </a>
                                <a
                                    v-if="profil?.linkedin"
                                    :href="normalizeUrl(profil.linkedin)"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="social-card"
                                >
                                    <BriefcaseBusiness class="size-5" />
                                    <span>LinkedIn</span>
                                    <ArrowUpRight class="ml-auto size-4" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="certificates" class="section-shell bg-[#111410]">
                <div class="mx-auto max-w-7xl">
                    <div
                        class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between"
                    >
                        <div>
                            <div class="section-kicker">02 — Pencapaian</div>
                            <h2 class="section-title mt-7">
                                Sertifikat <span>pilihan.</span>
                            </h2>
                        </div>
                        <p class="max-w-md text-sm leading-6 text-white/40">
                            Bukti perjalanan belajar dan komitmen untuk terus
                            meningkatkan kualitas.
                        </p>
                    </div>

                    <div
                        v-if="sertifikats.length"
                        class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-3"
                    >
                        <button
                            v-for="(sertifikat, index) in sertifikats"
                            :key="sertifikat.id"
                            type="button"
                            class="certificate-card group text-left"
                            @click="selectedCertificate = sertifikat"
                        >
                            <div class="certificate-image">
                                <img
                                    v-if="sertifikat.foto_url"
                                    :src="sertifikat.foto_url"
                                    :alt="sertifikat.nama"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                />
                                <div
                                    v-else
                                    class="grid h-full place-items-center bg-[#20251d]"
                                >
                                    <Award class="size-16 text-[#dfff5f]/60" />
                                </div>
                                <span class="certificate-number">
                                    {{ String(index + 1).padStart(2, '0') }}
                                </span>
                            </div>
                            <div class="p-5 sm:p-6">
                                <div
                                    class="flex items-start justify-between gap-4"
                                >
                                    <div>
                                        <p
                                            class="text-xs tracking-[0.18em] text-[#dfff5f] uppercase"
                                        >
                                            {{ sertifikat.jenis }}
                                        </p>
                                        <h3
                                            class="mt-3 text-xl font-semibold text-white"
                                        >
                                            {{ sertifikat.nama }}
                                        </h3>
                                    </div>
                                    <span class="card-arrow">
                                        <ArrowUpRight class="size-4" />
                                    </span>
                                </div>
                                <p
                                    class="mt-4 line-clamp-2 text-sm leading-6 text-white/40"
                                >
                                    {{ sertifikat.deskripsi }}
                                </p>
                            </div>
                        </button>
                    </div>

                    <div v-else class="empty-state">
                        <Award class="size-10 text-[#dfff5f]" />
                        <h3 class="mt-5 text-xl font-semibold text-white">
                            Sertifikat segera hadir
                        </h3>
                        <p class="mt-2 text-sm text-white/40">
                            Tambahkan sertifikat melalui dashboard agar tampil
                            di sini.
                        </p>
                    </div>
                </div>
            </section>

            <section
                id="contact"
                class="section-shell relative overflow-hidden"
            >
                <div class="contact-orb" />
                <div class="relative z-10 mx-auto max-w-7xl">
                    <div class="contact-panel">
                        <p class="section-kicker">03 — Mari terhubung</p>
                        <h2
                            class="mt-7 max-w-4xl text-4xl leading-tight font-black tracking-[-0.045em] text-white sm:text-6xl lg:text-7xl"
                        >
                            Punya ide menarik?
                            <span class="text-[#dfff5f]"
                                >Mari kita wujudkan.</span
                            >
                        </h2>
                        <div
                            class="mt-10 flex flex-col gap-4 sm:flex-row sm:items-center"
                        >
                            <a
                                v-if="profil?.email"
                                :href="`mailto:${profil.email}`"
                                class="primary-button justify-center"
                            >
                                <Mail class="size-4" /> {{ profil.email }}
                            </a>
                            <a
                                v-if="profil?.no_hp"
                                :href="`tel:${profil.no_hp}`"
                                class="secondary-button justify-center"
                            >
                                <Phone class="size-4" /> {{ profil.no_hp }}
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-white/10 px-4 py-8 sm:px-6">
            <div
                class="mx-auto flex max-w-7xl flex-col gap-4 text-sm text-white/35 sm:flex-row sm:items-center sm:justify-between"
            >
                <p>
                    © {{ currentYear }} {{ displayName }}. Dibuat dengan
                    ketelitian.
                </p>
                <a
                    href="#home"
                    class="flex items-center gap-2 hover:text-white"
                >
                    Kembali ke atas <ArrowUpRight class="size-4 -rotate-45" />
                </a>
            </div>
        </footer>

        <div
            v-if="selectedCertificate"
            class="fixed inset-0 z-50 grid place-items-center bg-black/85 p-4 backdrop-blur-sm"
            role="dialog"
            aria-modal="true"
            @click.self="selectedCertificate = null"
        >
            <div
                class="relative max-h-[90vh] w-full max-w-4xl overflow-auto rounded-3xl border border-white/10 bg-[#121512] shadow-2xl"
            >
                <button
                    type="button"
                    class="absolute top-4 right-4 z-10 grid size-10 place-items-center rounded-full bg-black/60 text-white backdrop-blur"
                    aria-label="Tutup"
                    @click="selectedCertificate = null"
                >
                    <X class="size-5" />
                </button>
                <img
                    v-if="selectedCertificate.foto_url"
                    :src="selectedCertificate.foto_url"
                    :alt="selectedCertificate.nama"
                    class="max-h-[65vh] w-full bg-black object-contain"
                />
                <div class="p-6 sm:p-8">
                    <p
                        class="text-xs tracking-[0.18em] text-[#dfff5f] uppercase"
                    >
                        {{ selectedCertificate.jenis }}
                    </p>
                    <h3 class="mt-3 text-2xl font-bold text-white">
                        {{ selectedCertificate.nama }}
                    </h3>
                    <p class="mt-3 leading-7 text-white/50">
                        {{ selectedCertificate.deskripsi }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.portfolio-page {
    background: #0b0d0b;
    color: #fff;
    scroll-behavior: smooth;
}

.nav-link {
    transition: color 180ms ease;
}

.nav-link:hover {
    color: #dfff5f;
}

.nav-button,
.primary-button,
.secondary-button {
    display: inline-flex;
    align-items: center;
    gap: 0.55rem;
    border-radius: 999px;
    padding: 0.75rem 1.15rem;
    font-size: 0.875rem;
    font-weight: 650;
    transition:
        transform 180ms ease,
        background 180ms ease,
        border-color 180ms ease;
}

.nav-button,
.primary-button {
    background: #dfff5f;
    color: #10120e;
}

.nav-button:hover,
.primary-button:hover {
    transform: translateY(-2px);
    background: #ebff9a;
}

.secondary-button {
    border: 1px solid rgb(255 255 255 / 0.14);
    color: rgb(255 255 255 / 0.8);
}

.secondary-button:hover {
    border-color: rgb(223 255 95 / 0.55);
    color: #fff;
}

.mobile-link {
    border-radius: 0.75rem;
    padding: 0.85rem 1rem;
    color: rgb(255 255 255 / 0.65);
}

.mobile-link:hover {
    background: rgb(255 255 255 / 0.06);
    color: #dfff5f;
}

.hero-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgb(255 255 255 / 0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgb(255 255 255 / 0.025) 1px, transparent 1px);
    background-size: 72px 72px;
    mask-image: linear-gradient(to bottom, black, transparent 88%);
}

.hero-glow {
    position: absolute;
    border-radius: 999px;
    filter: blur(110px);
    pointer-events: none;
}

.hero-glow-one {
    top: 4rem;
    right: -12rem;
    width: 34rem;
    height: 34rem;
    background: rgb(168 211 72 / 0.12);
}

.hero-glow-two {
    bottom: 0;
    left: -12rem;
    width: 26rem;
    height: 26rem;
    background: rgb(71 114 82 / 0.12);
}

.eyebrow,
.section-kicker {
    display: inline-flex;
    align-items: center;
    gap: 0.65rem;
    font-size: 0.72rem;
    font-weight: 650;
    letter-spacing: 0.18em;
    text-transform: uppercase;
}

.eyebrow {
    border: 1px solid rgb(255 255 255 / 0.1);
    border-radius: 999px;
    padding: 0.65rem 0.9rem;
    color: rgb(255 255 255 / 0.62);
}

.section-kicker {
    color: #dfff5f;
}

.portrait-frame {
    position: relative;
    aspect-ratio: 4 / 5;
    overflow: hidden;
    border: 1px solid rgb(255 255 255 / 0.12);
    border-radius: 2rem;
    background: #181b17;
    box-shadow: 0 30px 100px rgb(0 0 0 / 0.35);
}

.portrait-photo {
    object-position: center top;
}

.portrait-frame::before {
    content: '';
    position: absolute;
    inset: 0.75rem;
    z-index: 2;
    border: 1px solid rgb(255 255 255 / 0.12);
    border-radius: 1.45rem;
    pointer-events: none;
}

.portrait-label {
    position: absolute;
    top: 1.6rem;
    left: 1.6rem;
    z-index: 3;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    border-radius: 999px;
    background: rgb(11 13 11 / 0.72);
    padding: 0.55rem 0.8rem;
    font-size: 0.72rem;
    color: #dfff5f;
    backdrop-filter: blur(12px);
}

.portrait-overlay {
    position: absolute;
    inset: 35% 0 0;
    background: linear-gradient(to bottom, transparent, rgb(7 9 7 / 0.9));
}

.float-card {
    position: absolute;
    bottom: 3rem;
    z-index: 4;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    border: 1px solid rgb(255 255 255 / 0.12);
    border-radius: 1rem;
    background: rgb(17 20 17 / 0.88);
    padding: 0.75rem 1rem;
    box-shadow: 0 20px 50px rgb(0 0 0 / 0.3);
    backdrop-filter: blur(14px);
}

.section-shell {
    padding: 6rem 1rem;
    border-top: 1px solid rgb(255 255 255 / 0.07);
}

.section-title {
    max-width: 46rem;
    font-size: clamp(2.3rem, 5vw, 4.5rem);
    line-height: 1.02;
    font-weight: 850;
    letter-spacing: -0.05em;
    color: #fff;
}

.section-title span {
    color: rgb(255 255 255 / 0.25);
}

.social-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    border: 1px solid rgb(255 255 255 / 0.1);
    border-radius: 1rem;
    padding: 1rem;
    color: rgb(255 255 255 / 0.68);
    transition:
        color 180ms ease,
        border-color 180ms ease,
        transform 180ms ease;
}

.social-card:hover {
    transform: translateY(-2px);
    border-color: rgb(223 255 95 / 0.35);
    color: #dfff5f;
}

.certificate-card {
    overflow: hidden;
    border: 1px solid rgb(255 255 255 / 0.09);
    border-radius: 1.4rem;
    background: #171a16;
    transition:
        transform 250ms ease,
        border-color 250ms ease;
}

.certificate-card:hover {
    transform: translateY(-6px);
    border-color: rgb(223 255 95 / 0.3);
}

.certificate-image {
    position: relative;
    aspect-ratio: 16 / 10;
    overflow: hidden;
    background: #0b0d0b;
}

.certificate-number {
    position: absolute;
    top: 1rem;
    left: 1rem;
    border-radius: 999px;
    background: rgb(11 13 11 / 0.72);
    padding: 0.45rem 0.65rem;
    font-size: 0.7rem;
    color: #fff;
    backdrop-filter: blur(10px);
}

.card-arrow {
    display: grid;
    flex: none;
    width: 2.25rem;
    height: 2.25rem;
    place-items: center;
    border: 1px solid rgb(255 255 255 / 0.1);
    border-radius: 999px;
    color: rgb(255 255 255 / 0.55);
    transition:
        background 180ms ease,
        color 180ms ease,
        transform 180ms ease;
}

.certificate-card:hover .card-arrow {
    transform: rotate(8deg);
    background: #dfff5f;
    color: #10120e;
}

.empty-state {
    margin-top: 3rem;
    border: 1px dashed rgb(255 255 255 / 0.13);
    border-radius: 1.5rem;
    padding: 4rem 1.5rem;
    text-align: center;
}

.contact-panel {
    border: 1px solid rgb(255 255 255 / 0.1);
    border-radius: 2rem;
    background: linear-gradient(
        135deg,
        rgb(255 255 255 / 0.055),
        rgb(255 255 255 / 0.018)
    );
    padding: clamp(2rem, 6vw, 5rem);
}

.contact-orb {
    position: absolute;
    right: -10rem;
    bottom: -14rem;
    width: 35rem;
    height: 35rem;
    border-radius: 999px;
    background: rgb(223 255 95 / 0.09);
    filter: blur(80px);
}

@media (min-width: 640px) {
    .section-shell {
        padding: 8rem 1.5rem;
    }
}

@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        scroll-behavior: auto !important;
        transition-duration: 0.01ms !important;
        animation-duration: 0.01ms !important;
    }
}
</style>
