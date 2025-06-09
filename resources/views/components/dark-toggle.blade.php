<!-- resources/views/components/dark-toggle.blade.php -->
<div class="flex justify-end p-4">
    <button
        @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
        class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200"
    >
        <span x-text="darkMode ? '🌞 Kun rejimi' : '🌙 Tun rejimi'"></span>
    </button>
</div>
