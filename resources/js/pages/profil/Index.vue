<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from '@lucide/vue';
import { Button } from '@/components/ui/button';

const props = defineProps<{
    profil: {
        data: Array<{
            id: number;
            nama_profil: string;
            email: string;
            no_hp: string;
            alamat: string;
            linkedin: string;
            github: string;
            foto_profil: string;
            foto_profil_url?: string | null;
        }>;
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
    };
}>();

const submitDelete = (id: number) => {
    if (window.confirm('Yakin ingin menghapus profil ini?')) {
        router.delete(`/profil/${id}`, {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Profil" />

    <div class="flex flex-col gap-4 p-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Profil</h1>
                <p class="text-sm text-muted-foreground">
                    Kelola profil yang tersedia.
                </p>
            </div>
            <Link
                :href="'/profil/create'"
                class="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground"
            >
                <Plus class="h-4 w-4" />
                Tambah Profil
            </Link>
        </div>

        <div class="overflow-hidden rounded-xl border">
            <table class="min-w-full divide-y divide-border text-sm">
                <thead class="bg-muted/50">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama Profil</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">No HP</th>
                        <th class="px-4 py-3 text-left">Alamat</th>
                        <th class="px-4 py-3 text-left">LinkedIn</th>
                        <th class="px-4 py-3 text-left">GitHub</th>
                        <th class="px-4 py-3 text-left">Foto Profil</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-background">
                    <tr v-if="props.profil.data.length === 0">
                        <td
                            colspan="8"
                            class="px-4 py-3 text-center text-muted-foreground"
                        >
                            Tidak ada profil yang tersedia.
                        </td>
                    </tr>
                    <tr v-for="profil in props.profil.data" :key="profil.id">
                        <td class="px-4 py-3">{{ profil.nama_profil }}</td>
                        <td class="px-4 py-3">{{ profil.email }}</td>
                        <td class="px-4 py-3">{{ profil.no_hp }}</td>
                        <td class="px-4 py-3">{{ profil.alamat }}</td>
                        <td class="px-4 py-3">{{ profil.linkedin }}</td>
                        <td class="px-4 py-3">{{ profil.github }}</td>
                        <td class="px-4 py-3">
                            <div
                                v-if="profil.foto_profil_url"
                                class="flex items-center"
                            >
                                <img
                                    :src="profil.foto_profil_url"
                                    :alt="profil.nama_profil"
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
                                    :href="`/profil/${profil.id}/edit`"
                                    class="py- 1 inline-flex items-center gap-2 rounded-md bg-primary px-3 text-sm font-medium text-primary-foreground"
                                >
                                    <Pencil class="h-4 w-4" />
                                    Edit
                                </Link>
                                <Button
                                    variant="destructive"
                                    class="inline-flex items-center gap-2 rounded-md px-3 py-1 text-sm font-medium"
                                    @click="submitDelete(profil.id)"
                                >
                                    <Trash2 class="h-4 w-4" />
                                    Hapus
                                </Button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4 flex justify-center gap-2">
                <Link
                    v-for="link in props.profil.links"
                    :key="link.label"
                    :href="link.url || '#'"
                    v-html="link.label"
                    class="rounded border px-3 py-1"
                    :class="{
                        'bg-primary text-white': link.active,
                        'pointer-events-none opacity-50': !link.url,
                    }"
                />
            </div>
        </div>
    </div>
</template>
