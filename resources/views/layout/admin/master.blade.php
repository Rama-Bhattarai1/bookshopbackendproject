 <x-app-layout>
     <x-slot name="header">
         <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight  flex justify-between">
             <p>{{ __('Book shop') }}</p>
             <p class=" capitalize">{{ Route::currentRouteName() }}</p>
         </h2>
     </x-slot>

     <div class="flex flex-col md:flex-row w-full">

         <!-- Sidebar -->
         <div class="bg-blue-900 shadow-lg h-screen w-64 sticky top-0 sm:block">
             <div class="p-6 text-white text-2xl font-semibold">
                 Book shop
             </div>
             {{-- include leftside navbar --}}
             @includeIf('layout.admin.sidenavbar')
         </div>
         <!-- Main Content -->
         <div class="flex-1 p-6">

             @yield('contents')
         </div>
     </div>
 </x-app-layout>
