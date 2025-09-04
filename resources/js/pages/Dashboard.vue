<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { ref } from 'vue';
import Button from '@/components/ui/button/Button.vue';
import Table from '@/components/ui/table/Table.vue';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const tahvelCookie = ref<string>();

const saveTahvelCookie = () => {
    router.put('save-tahvel-cookie'), {
        tahvel_cookie: tahvelCookie.value,
    }
};


</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-[500px] flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            
            <div class="">
                <Label> Tahvel auth cookie </Label>
                <Textarea v-model="tahvelCookie"></Textarea>
                <p class="text-xs " v-show="">
                    
                </p>
            </div>
            <Button @click="saveTahvelCookie" class="max-w-[200px]">save</Button>
            <pre>
                {{ $page.props.auth.user }}
            </pre>
            
            {{ tahvelCookie }}

        </div>
    </AppLayout>
</template>
