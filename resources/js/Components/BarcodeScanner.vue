<script setup>
import { ref, onMounted } from 'vue'
import { Input } from '@/Components/ui/input'
import { toast } from 'vue-sonner'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const props = defineProps({
    products: Object,
    current_view: String

})
const emit = defineEmits(['select'])
const search = ref('')
const inputRef = ref(null)
const error = ref('');

const isBarcode = (value) => /^\d{8,}$/.test(value)

const onEnter = () => {
    const value = search.value.trim()
    if (!value) return
    const product = props.products.find(p => p.barcode === value || p.code === value)
    if (product) {
        if (product.stock == 0 && props.current_view == 'bill') {
            error.value = t('errors.stock');
            return
        }
        emit('select', product)

    } else {
        toast.error(t('errors.product'));
    }

    search.value = ''
    focusInput()

}

const focusInput = () => setTimeout(() => inputRef.value?.focus?.(), 50)
onMounted(() => focusInput())
</script>

<template>
    <Input ref="inputRef" v-model="search" placeholder="Escanear código de barras..."
        class="text-lg flex-1 py-5 rounded-l-none" @keydown.enter.prevent="onEnter" v-bind="$attrs" />


</template>
