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
</x-app-layout>

<div x-data="{ show: false, message: '', type: '' }" 
     x-show="show"
     x-transition
     x-init="
        window.addEventListener('toast', event => {
            message = event.detail.message;
            type = event.detail.type;
            show = true;
            setTimeout(() => show = false, 3000);
        });
     "
     class="fixed bottom-4 right-4 px-4 py-2 rounded shadow-lg"
     :class="{
         'bg-green-500': type === 'success',
         'bg-red-500': type === 'error',
         'bg-blue-500': type === 'info'
     }">
    <span x-text="message"></span>
</div