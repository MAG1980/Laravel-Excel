<template>
    <transition name="fade" mode="out-in" appear>
        <slot></slot>
    </transition>
</template>

<style scoped>
/* Добавляем директиву @reference */
/* Она импортирует ваши переменные темы, кастомные утилиты и классы только для справки, не дублируя CSS в финальной сборке */
@reference "tailwindcss";

.fade-enter-active,
.fade-leave-active {
    @apply transition-all duration-300 ease-in-out;
}

.fade-enter-from,
.fade-leave-to {
    @apply -translate-y-4 opacity-0;
}

.fade-enter-to,
.fade-leave-from {
    @apply translate-y-0 opacity-100;
}
</style>
