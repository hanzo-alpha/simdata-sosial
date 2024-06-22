<footer
    class="fixed bottom-0 left-0 z-20 w-full p-3 bg-white border-t border-gray-200 shadow md:flex md:items-center
    md:justify-between md:p-6 dark:bg-gray-800 dark:border-gray-600">
    <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">
        © {{ now()->subYears()->year . ' - ' . now()->year }}
        <a href="https://dianra.cloud" class="hover:underline">RENO DINSOS KABUPATEN SOPPENG</a>.
        {{ setting('app.version') }}
    </span>
</footer>
