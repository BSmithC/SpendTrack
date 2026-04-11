<template>
    <AuthenticatedLayout>
        <template #header>
            <div v-if="flash?.success" class="bg-green-800 text-white p-5 rounded mb-2">
                {{ flash.success }}
            </div>
            <h2 class="text-xl font-semibold">
                Budgets
            </h2>
            <Button class="ml-auto text-gray-700 bg-gray-50 border-b-2 border-gray-200">
                <Link :href="route('Budget.create')">
                New Budget
                </Link>
            </Button>
        </template>

        <template #default>
            <div class="mx-auto max-w-7xl justify-center mt-4">
                <div class="flex justify-between w-full ">
                    <Input class="sm:max-w-sm" v-model="form.search" @input="sumbitFilters()" placeholder="Search ..." />
                    <Select v-model="form.status" @update:model-value="sumbitFilters()" >
                        <SelectTrigger class="w-full sm:w-48">
                            <SelectValue placeholder="Estado" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">Todos</SelectItem>
                            <SelectItem value="1">Activos</SelectItem>
                            <SelectItem value="0">Inactivos</SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <div class="overflow-auto rounded-xl shadow mt-4">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr class="p-3 text-sm font-semibold tracking-wider text-left">
                                <th scope="col" class="px-6 py-3 font-medium">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Product/Service
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Create At
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody v-for="budget in budgets.data" :key="budget.data">
                            <tr class="bg-white">
                                <th class="p-3 text-sm text-gray-700">
                                    {{ budget.id }}
                                </th>
                                <td class="p-3 text-sm text-gray-700">
                                    {{ truncateNames(budget.details, 3) }}
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    {{ budget.type }}
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    {{ budget.created_at.slice(0, 10) }}
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    {{ budget.total }}
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium"
                                        :class="budget.status
                                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'">
                                        {{ budget.status ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    <Button class="text-blue-500" variant="default">
                                        <Link :href="route('Budget.show', budget.id)">
                                        <EyeIcon />
                                        </Link>
                                    </Button>
                                    <Button @click="deleteinfo(budget.id)" class="text-red-500">
                                        <DeleteIcon />
                                    </Button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="budgets.total > budgets.per_page" class="flex items-center justify-between px-4 py-4">
                    <!-- Texto -->
                    <p class="text-sm text-muted-foreground">
                        Mostrando
                        <strong>{{ budgets.from }}</strong>
                        a
                        <strong>{{ budgets.to }}</strong>
                        de
                        <strong>{{ budgets.total }}</strong>
                        resultados
                    </p>
                    <!-- Controles -->
                    <div class="flex items-center gap-1">

                        <!-- First -->
                        <Button size="sm" variant="outline" as-child :disabled="budgets.current_page === 1">
                            <Link :href="budgets.first_page_url" preserve-scroll>
                            «
                            </Link>
                        </Button>

                        <!-- Prev -->
                        <Button size="sm" variant="outline" as-child :disabled="!budgets.prev_page_url">
                            <Link v-if="budgets.prev_page_url" :href="budgets.prev_page_url" preserve-scroll>
                            ‹
                            </Link>
                        </Button>

                        <!-- Pages -->
                        <Button v-for="link in budgets.links.slice(1, -1)" :key="link.label" size="sm"
                            :variant="link.active ? 'default' : 'outline'" as-child>
                            <Link v-if="link.url" :href="link.url" preserve-scroll v-html="link.label" />
                        </Button>

                        <!-- Next -->
                        <Button size="sm" variant="outline" as-child :disabled="!budgets.next_page_url">
                            <Link v-if="budgets.next_page_url" :href="budgets.next_page_url" preserve-scroll>
                            ›
                            </Link>
                        </Button>

                        <!-- Last -->
                        <Button size="sm" variant="outline" as-child
                            :disabled="budgets.current_page === budgets.last_page">
                            <Link :href="budgets.last_page_url" preserve-scroll>
                            »
                            </Link>
                        </Button>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script>
import AddIcon from '@/Components/Icons/AddIcon.vue';
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue';
import RestoreIcon from '@/Components/Icons/RestoreIcon.vue';
import EditIcon from '@/Components/Icons/EditIcon.vue';
import EyeIcon from '@/Components/Icons/EyeIcon.vue';
import Button from '@/Components/ui/button/Button.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { KeepAlive, ref } from 'vue';
import Input from '@/Components/ui/input/Input.vue';
import Select from '@/Components/ui/select/Select.vue';
import SelectTrigger from '@/Components/ui/select/SelectTrigger.vue';
import SelectValue from '@/Components/ui/select/SelectValue.vue';
import SelectContent from '@/Components/ui/select/SelectContent.vue';
import SelectItem from '@/Components/ui/select/SelectItem.vue';
export default {
    components: {
        AuthenticatedLayout,
        Head,
        Link,
        EditIcon,
        Button,
        EyeIcon,
        AddIcon,
        DeleteIcon,
        RestoreIcon,
        Input,
        Select,
        SelectTrigger,
        SelectValue,
        SelectContent,
        SelectItem,
    },
    props: {
        budgets: Object,
        filters: Object,
    },
    data() {
        return {
            searchTerm: ref(''),
            filteredExpenses: this.budgets,
            form: {
                search: this.filters?.search || '',
                status: this.filters?.status || ''
            },
            timeout: null
        }
    },
    computed: {
        flash() {
            return this.$page.props.flash
        }
    },
    methods: {
        truncateNames(items, limit = 3, separator = ', ') {
            if (!items || !Array.isArray(items) || items.length === 0) {
                return '';
            }
            const names = items
                .slice(0, limit)
                .map(item => item.name || item)
                .join(separator);

            return items.length > limit ? `${names}...` : names;
        },
        sumbitFilters() {
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                this.$inertia.get(route('Budget.index'), this.form, {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true
                });
            }, 300)

        },
        deleteinfo(id) {
            if (confirm('Are you sure?')) {
                this.$inertia.delete(route('Budget.destroy', id));
            }
        },
    },
}
</script>
