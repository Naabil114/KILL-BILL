<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from '@lucide/vue';
import { Button } from '@/components/ui/button';

const props = defineProps<{
    sertifikats: Array<{
        id: number;
        nama: string;
        deskripsi: string;
        jenis: string;
        foto: string;
        foto_url?: string | null;
    }>;
}>();

const submitDelete = (id: number) => {
    if (window.confirm('Yakin ingin menghapus sertifikat ini?')) {
        router.delete(`/sertifikat/${id}`, {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Sertifikat" />

    <div class="flex flex-col gap-4 p-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Sertifikat</h1>
                <p class="text-sm text-muted-foreground">
                    Kelola sertifikat yang tersedia.
                </p>
            </div>
            <Link
                :href="'/sertifikat/create'"
                class="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground"
            >
                <Plus class="h-4 w-4" />
                Tambah Sertifikat
            </Link>
        </div>

        <div class="overflow-hidden rounded-xl border">
            <table class="min-w-full divide-y divide-border text-sm">
                <thead class="bg-muted/50">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Deskripsi</th>
                        <th class="px-4 py-3 text-left">Jenis</th>
                        <th class="px-4 py-3 text-left">Foto</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-background">
                    <tr v-if="props.sertifikats.length === 0">
                        <td
                            colspan="5"
                            class="px-4 py-10 text-center text-muted-foreground"
                        >
                            Belum ada data sertifikat.
                        </td>
                    </tr>
                    <tr
                        v-for="sertifikat in props.sertifikats"
                        :key="sertifikat.id"
                    >
                        <td class="px-4 py-3">{{ sertifikat.nama }}</td>
                        <td class="px-4 py-3">{{ sertifikat.deskripsi }}</td>
                        <td class="px-4 py-3">{{ sertifikat.jenis }}</td>
                        <td class="px-4 py-3">
                            <div
                                v-if="sertifikat.foto_url"
                                class="flex items-center"
                            >
                                <img
                                    :src="sertifikat.foto_url"
                                    :alt="sertifikat.nama"
                                    class="h-16 w-16 rounded-md object-cover"
                                />
                            </div>
                            <span v-else class="text-muted-foreground"
                                >Tidak ada foto</span
                            >
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <Link
                                    :href="`/sertifikat/${sertifikat.id}/edit`"
                                    class="inline-flex items-center rounded-md border px-3 py-2 text-sm"
                                >
                                    <Pencil class="mr-2 h-4 w-4" /> Edit
                                </Link>
                                <Button
                                    variant="destructive"
                                    size="sm"
                                    @click="submitDelete(sertifikat.id)"
                                >
                                    <Trash2 class="mr-2 h-4 w-4" /> Hapus
                                </Button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
