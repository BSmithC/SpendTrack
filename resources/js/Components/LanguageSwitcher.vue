<script setup>
import { getCurrentInstance } from 'vue'

const { proxy } = getCurrentInstance()

const languages = [
  { code: 'es', label: 'ES', flag: '🇪🇸' },
  { code: 'en', label: 'EN', flag: '🇺🇸' }
]

const changeLang = (lang) => {
  proxy.$i18n.locale = lang
  localStorage.setItem('lang', lang)
  document.cookie = `lang=${lang}; path=/`
}

const isActive = (lang) => proxy.$i18n.locale === lang
</script>


<template>
    <nav class="inline-flex p-1 bg-muted/50 border border-border rounded-lg shadow-inner"
        aria-label="Language selector">
        <button v-for="lang in languages" :key="lang.code" @click="changeLang(lang.code)"
            :aria-pressed="isActive(lang.code)" :class="[
                'flex items-center gap-2 px-4 py-2 text-sm font-medium transition-all duration-200 rounded-md cursor-pointer',
                isActive(lang.code)
                    ? 'bg-background text-primary shadow-sm ring-1 ring-border transform scale-[1.02]'
                    : 'text-muted-foreground hover:text-foreground hover:bg-accent/50'
            ]">
            <span class="text-base leading-none grayscale-[0.5]" :class="{ 'grayscale-0': isActive(lang.code) }">
                {{ lang.flag }}
            </span>
            <span class="tracking-tight">{{ lang.label }}</span>
        </button>
    </nav>
</template>
