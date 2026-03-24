<template>
    <footer
        class="bg-background  border-t bo text-foreground-700 ">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row justify-between items-center">

            <div class="text-sm">
                &copy; {{ new Date().getFullYear() }} BJGastroSoft. {{ $t('copyright') }}.
            </div>

            <div class="mt-2 sm:mt-0 flex gap-4">

                <a href="https://bjdevstudio.my.canva.site/" class="hover:text-primary dark:hover:text-primary transition-colors text-sm">{{$t('help')}}</a>
            </div>
        </div>
    </footer>
</template>

<script setup>
</script>

<style scoped>
footer {
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05);
}
</style>
