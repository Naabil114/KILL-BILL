<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

const props = defineProps<{
    profil: {
        id: number;
        nama_profil: string;
        email: string;
        no_hp: string;
        alamat: string;
        linkedin: string;
        github: string;
        foto_profil: string;
        foto_profil_url?: string | null;
    };
}>();

const form = useForm({
    nama_profil: props.profil.nama_profil,
    email: props.profil.email,
    no_hp: props.profil.no_hp,
    alamat: props.profil.alamat,
    linkedin: props.profil.linkedin,
    github: props.profil.github,
    foto_profil: null as File | null,
});

const handleFotoChange = (event: Event) => {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0] ?? null;

    form.clearErrors('foto_profil');

    if (file && file.size > 2 * 1024 * 1024) {
        form.foto_profil = null;
        input.value = '';
        form.setError('foto_profil', 'Ukuran foto maksimal 2 MB.');

        return;
    }

    form.foto_profil = file;
};

const submit = () => {
    form
        .transform((data) => ({
            ...data,
            _method: 'put',
        }))
        .post(`/profil/${props.profil.id}`, {
            forceFormData: true,
            onSuccess: () => {
                form.reset('foto_profil');
            },
        });
};
</script>

<template>
    <Head title="Edit Profil" />

    <div class="flex flex-col gap-4 p-4">
        <Link
            href="/profil"
            class="inline-flex items-center gap-2 text-sm text-muted-foreground"
        >
            <ArrowLeft class="h-4 w-4" /> Kembali
        </Link>

        <div class="rounded-xl border bg-background p-6">
            <h1 class="text-xl font-semibold">Edit Profil</h1>
            <form class="mt-4 space-y-4" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="nama_profil">Nama Profil</Label>
                    <Input
                        id="nama_profil"
                        v-model="form.nama_profil"
                        type="text"
                        placeholder="Masukkan nama profil"
                    />
                    <InputError :message="form.errors.nama_profil" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email</Label>
                    <Input
                        id="email"
                        v-model="form.email"
                        type="email"
                        placeholder="Masukkan email"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="no_hp">No HP</Label>
                    <Input
                        id="no_hp"
                        v-model="form.no_hp"
                        type="text"
                        placeholder="Masukkan nomor HP"
                    />
                    <InputError :message="form.errors.no_hp" />
                </div>

                <div class="grid gap-2">
                    <Label for="alamat">Alamat</Label>
                    <Input
                        id="alamat"
                        v-model="form.alamat"
                        type="text"
                        placeholder="Masukkan alamat"
                    />
                    <InputError :message="form.errors.alamat" />
                </div>

                <div class="grid gap-2">
                    <Label for="linkedin">LinkedIn</Label>
                    <Input
                        id="linkedin"
                        v-model="form.linkedin"
                        type="text"
                        placeholder="Masukkan URL LinkedIn"
                    />
                    <InputError :message="form.errors.linkedin" />
                </div>

                <div class="grid gap-2">
                    <Label for="github">GitHub</Label>
                    <Input
                        id="github"
                        v-model="form.github"
                        type="text"
                        placeholder="Masukkan URL GitHub"
                    />
                    <InputError :message="form.errors.github" />
                </div>

                <div class="grid gap-2">
                    <Label for="foto_profil">Foto Profil</Label>
                    <input
                        id="foto_profil"
                        type="file"
                        accept=".jpg,.jpeg,.png,.gif,.webp,.avif,.svg"
                        @change="handleFotoChange"
                    />
                    <InputError :message="form.errors.foto_profil" />
                    <p class="text-sm text-muted-foreground">
                        Maksimal ukuran file: 2 MB. Format yang diperbolehkan: JPG,
                        JPEG, PNG, GIF, WebP, AVIF, SVG.
                    </p>
                </div>
                <Button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
                </Button>
            </form>
        </div>
    </div>
</template>
