<x-app-layout>
    <nav class="bg-white border-b border-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Dashboard -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    </div>
                </div>
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Dashboard -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('getBooksToRead')" :active="request()->routeIs('books')">
                                {{ __('Lista') }}
                            </x-nav-link>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Dashboard -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('getBooksRead')" :active="request()->routeIs('books')">
                                {{ __('ListaDeLidos') }}
                            </x-nav-link>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </nav>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="searchForm" method="GET" action="{{ route('searchBook') }}">
                        <input type="text" id="searchInput" name="q" placeholder="Digite o nome do livro">
                        <button type="submit">Pesquisar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="bookResults" class="mt-6">
        
    </div>
    <script>
        const deleteBookFromReadList = @json(route('removeBookReadList'));
        const deleteBookFromReadingList = @json(route('removeBookReadingList'));
        const addNewBookRoute = @json(route('addNewBook'));
        const addBookToReadingListRoute = @json(route('addBookToReadingList'));
        const addBookToReadListRoute = @json(route('addBookToReadList'));
    </script>
</x-app-layout>
