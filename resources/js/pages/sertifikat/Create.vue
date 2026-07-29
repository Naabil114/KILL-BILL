<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

const form = useForm({
    nama: '',
    deskripsi: '',
    jenis: '',
    foto: null as File | null,
});

const handleFotoChange = (event: Event) => {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0] ?? null;

    form.clearErrors('foto');

    if (file && file.size > 2 * 1024 * 1024) {
        form.foto = null;
        input.value = '';
        form.setError('foto', 'Ukuran foto maksimal 2 MB.');

        return;
    }

    form.foto = file;
};

const submit = () => {
    if (!form.foto) {
        form.setError('foto', 'Foto wajib dipilih.');

        return;
    }

    form.post('/sertifikat', {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Tambah Sertifikat" />

    <div class="flex flex-col gap-4 p-4">
        <Link
            href="/sertifikat"
            class="inline-flex items-center gap-2 text-sm text-muted-foreground"
        >
            <ArrowLeft class="h-4 w-4" /> Kembali
        </Link>

        <div class="rounded-xl border bg-background p-6">
            <h1 class="text-xl font-semibold">Tambah Sertifikat</h1>
            <form class="mt-4 space-y-4" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="nama">Nama</Label>
                    <Input id="nama" v-model="form.nama" required />
                    <InputError :message="form.errors.nama" />
                </div>
                <div class="grid gap-2">
                    <Label for="deskripsi">Deskripsi</Label>
                    <Input id="deskripsi" v-model="form.deskripsi" required />
                    <InputError :message="form.errors.deskripsi" />
                </div>
                <div class="grid gap-2">
                    <Label for="jenis">Jenis</Label>
                    <Input id="jenis" v-model="form.jenis" required />
                    <InputError :message="form.errors.jenis" />
                </div>
                <div class="grid gap-2">
                    <Label for="foto">Foto</Label>
                    <Input
                        id="foto"
                        type="file"
                        accept="image/jpeg,image/png,image/webp"
                        required
                        @change="handleFotoChange"
                    />
                    <InputError :message="form.errors.foto" />
                    <p class="text-sm text-muted-foreground">
                        Format JPG, PNG, atau WebP. Maksimal 2 MB.
                    </p>
                </div>
                <Button type="submit" :disabled="form.processing"
                    >{{ form.processing ? 'Menyimpan...' : 'Simpan' }}</Button
                >
            </form>
        </div>
    </div>
</template>
